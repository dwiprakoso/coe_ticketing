<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
use App\Services\WahaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    protected $wahaService;

    public function __construct(WahaService $wahaService)
    {
        $this->wahaService = $wahaService;
    }

    public function index()
    {
        // Ambil 1 produk terbaru (event)
        $product = Product::latest()->first();

        // Ambil semua tiket yang statusnya published
        $tickets = Ticket::where('status', 'published')->get();

        return view('order.index', compact('product', 'tickets'));
    }

    public function create($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $product = Product::first(); // Ambil product pertama karena hanya ada 1

        return view('order.create', compact('product', 'ticket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'nama_lengkap' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:500',
            'no_handphone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1|max:5',
        ]);

        // Get ticket data
        $ticket = Ticket::find($request->ticket_id);

        // Cek stok tiket
        if ($ticket->qty < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Stok tiket tidak mencukupi. Stok tersedia: ' . $ticket->qty)
                ->withInput();
        }

        // Set semua biaya ke 0 karena gratis
        $ticket_price = 0;
        $admin_fee = 0;
        $total_amount = 0;

        // Generate external ID yang unik
        do {
            $randomNumber = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $externalId = 'ORDER-' . $randomNumber;

            // Cek apakah external_id sudah ada di database
            $exists = Buyer::where('external_id', $externalId)->exists();
        } while ($exists);

        // Gunakan Database Transaction untuk memastikan atomicity
        DB::beginTransaction();

        try {
            // Kurangi stok tiket
            $ticket->decrement('qty', $request->quantity);

            // Simpan ke database buyers
            $buyer = new Buyer();
            $buyer->nama_lengkap = $request->nama_lengkap;
            $buyer->email = '-'; // Default value karena tidak ada field email
            $buyer->no_handphone = $request->no_handphone;
            $buyer->nama_instagram = '-'; // Default value
            $buyer->alamat_lengkap = $request->alamat_lengkap;
            $buyer->kode_pos = '-'; // Default value
            $buyer->ukuran_jersey = '-'; // Default value
            $buyer->quantity = $request->quantity;
            $buyer->ticket_id = $request->ticket_id;
            $buyer->ticket_price = $ticket_price;
            $buyer->admin_fee = $admin_fee;
            $buyer->total_amount = $total_amount;
            $buyer->external_id = $externalId;
            $buyer->payment_status = 'paid'; // Langsung paid karena gratis
            $buyer->save();

            Log::info('Free Ticket Registration', [
                'buyer_id' => $buyer->id,
                'external_id' => $externalId,
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'customer_name' => $request->nama_lengkap,
                'customer_address' => $request->alamat_lengkap
            ]);

            // Generate QR Code
            try {
                $verifyUrl = route('ticket.verify', ['external_id' => $externalId]);
                $qrCodePath = 'qr_codes/qr_' . $externalId;

                // Pastikan direktori ada
                if (!Storage::disk('public')->exists('qr_codes')) {
                    Storage::disk('public')->makeDirectory('qr_codes');
                }

                // Coba berbagai backend secara berurutan
                $qrCode = null;
                $backends = ['svg', 'png'];
                $usedBackend = null;
                $finalPath = null;

                foreach ($backends as $format) {
                    try {
                        if ($format === 'svg') {
                            $qrCode = QrCode::format('svg')
                                ->size(300)
                                ->margin(2)
                                ->generate($verifyUrl);
                            $finalPath = $qrCodePath . '.svg';
                            $usedBackend = 'svg';
                        } else {
                            $qrCode = QrCode::format('png')
                                ->size(300)
                                ->margin(2)
                                ->generate($verifyUrl);
                            $finalPath = $qrCodePath . '.png';
                            $usedBackend = 'png';
                        }

                        // Jika berhasil, keluar dari loop
                        break;
                    } catch (Exception $backendException) {
                        Log::warning('QR Code backend failed', [
                            'backend' => $format,
                            'error' => $backendException->getMessage()
                        ]);
                        continue;
                    }
                }

                // Jika tidak ada backend yang berhasil
                if (!$qrCode) {
                    throw new Exception('All QR code backends failed');
                }

                // Store QR code image
                Storage::disk('public')->put($finalPath, $qrCode);

                // Generate full URL untuk QR code
                $qrCodeFullUrl = Storage::disk('public')->url($finalPath);

                // Log QR code generation
                Log::info('QR Code Generated Successfully', [
                    'buyer_id' => $buyer->id,
                    'external_id' => $externalId,
                    'qr_code_path' => $qrCodeFullUrl,
                    'qr_code_file_path' => $finalPath,
                    'verify_url' => $verifyUrl,
                    'backend_used' => $usedBackend,
                    'file_size' => Storage::disk('public')->size($finalPath)
                ]);

                $qrCodePathToStore = $qrCodeFullUrl;
            } catch (Exception $qrException) {
                // Jika gagal generate QR code, log error tapi tetap lanjutkan proses
                Log::error('QR Code Generation Failed', [
                    'buyer_id' => $buyer->id,
                    'external_id' => $externalId,
                    'error' => $qrException->getMessage(),
                    'trace' => $qrException->getTraceAsString(),
                    'php_extensions' => [
                        'gd' => extension_loaded('gd'),
                        'imagick' => extension_loaded('imagick'),
                        'svg' => extension_loaded('svg')
                    ]
                ]);

                $qrCodePathToStore = null;
            }

            // Update buyer dengan QR code path
            $buyer->update([
                'qr_code_path' => $qrCodePathToStore
            ]);

            // KIRIM WHATSAPP MESSAGE
            $this->sendWhatsAppMessage($request->no_handphone, $buyer, $ticket);

            // Commit transaction
            DB::commit();

            // Redirect ke halaman sukses dengan pesan tiket gratis berhasil
            return redirect()->route('payment.success')
                ->with('success', 'Pendaftaran tiket gratis berhasil!');
        } catch (Exception $e) {
            // Rollback transaction jika ada error
            DB::rollback();

            // Enhanced error logging
            Log::error('Free Ticket Registration Failed', [
                'error_message' => $e->getMessage(),
                'buyer_id' => $buyer->id ?? 'not_created',
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'customer_address' => $request->alamat_lengkap ?? 'not_provided',
                'stack_trace' => $e->getTraceAsString()
            ]);

            // Return dengan error message
            return redirect()->route('order.create', ['ticket_id' => $ticket->id])
                ->with('error', 'Gagal melakukan pendaftaran tiket: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Kirim WhatsApp message menggunakan WahaService
     */
    private function sendWhatsAppMessage(string $phone, Buyer $buyer, Ticket $ticket)
    {
        try {
            // Format nomor telepon
            $phone = $this->formatPhoneNumber($phone);

            // Buat message
            $message = $this->buildTicketMessage($buyer, $ticket);

            // Kirim message
            $result = $this->wahaService->sendText($phone, $message);

            // Log hasil pengiriman
            if ($result['success']) {
                Log::info('WhatsApp ticket confirmation sent', [
                    'buyer_id' => $buyer->id,
                    'external_id' => $buyer->external_id,
                    'phone' => $phone,
                    'ticket_name' => $ticket->name
                ]);
            } else {
                Log::warning('WhatsApp send failed', [
                    'buyer_id' => $buyer->id,
                    'external_id' => $buyer->external_id,
                    'phone' => $phone,
                    'error' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            // Log error tapi jangan stop proses pendaftaran
            Log::error('WhatsApp send error', [
                'buyer_id' => $buyer->id,
                'external_id' => $buyer->external_id,
                'phone' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Build pesan tiket untuk WhatsApp
     */
    private function buildTicketMessage(Buyer $buyer, Ticket $ticket): string
    {
        $verifyUrl = route('ticket.verify', ['external_id' => $buyer->external_id]);

        $message = "✅ *Konfirmasi Pemesanan Tiket!*\n\n";
        $message .= "Nama: {$buyer->nama_lengkap}\n";
        $message .= "Tiket: {$ticket->name}\n";
        $message .= "Jumlah: {$buyer->quantity}\n";
        $message .= "Kode: *{$buyer->external_id}*\n\n";
        // $message .= "Verifikasi: {$verifyUrl}\n\n";
        $message .= "Terima kasih! 🎊";

        return $message;
    }

    /**
     * Format nomor telepon ke format internasional
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Hapus karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum ada 62 di awal, tambahkan
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
