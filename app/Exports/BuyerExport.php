<?php

namespace App\Exports;

use App\Models\Buyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

class BuyerExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $buyers;

    public function __construct()
    {
        $this->buyers = Buyer::with('ticket')->orderBy('created_at', 'asc')->get();
    }

    public function collection()
    {
        return $this->buyers;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Pesanan',
            'Nama',
            'No HP',
            'Komunitas',
            'Kategori Tiket',
            'Jumlah',
            'Waktu Pemesanan',
            'Status Pembayaran',
            'Harga Tiket',
            'Biaya Layanan',
            'Total Harga',
        ];
    }

    public function map($buyer): array
    {
        static $no = 1;

        return [
            $no++,
            $buyer->external_id,
            $buyer->nama_lengkap,
            $buyer->no_handphone,
            $buyer->alamat_lengkap,
            $buyer->ticket->name,
            $buyer->quantity,
            $buyer->created_at->translatedFormat('l, d F Y'),
            $buyer->payment_status,
            $buyer->ticket_price,
            $buyer->admin_fee,
            $buyer->total_amount,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // ID Pesanan
            'C' => 25,  // Nama
            'D' => 15,  // No HP
            'E' => 35,  // Alamat Lengkap
            'F' => 20,  // Kategori Tiket
            'G' => 8,   // Jumlah
            'H' => 20,  // Waktu Pemesanan
            'I' => 15,  // Status Pembayaran
            'J' => 12,  // Harga Tiket
            'K' => 12,  // Biaya Layanan
            'L' => 12,  // Total Harga
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set row height untuk header
        $sheet->getRowDimension('1')->setRowHeight(30);

        // Set row height untuk semua baris data (normal height tanpa QR code)
        $totalRows = $this->buyers->count() + 1; // +1 untuk header
        for ($row = 2; $row <= $totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // Style untuk header (opsional)
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('CCCCCC');

        // Center align untuk semua cells
        $sheet->getStyle('A1:L' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        return [];
    }
}
