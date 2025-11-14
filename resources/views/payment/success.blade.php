<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">Pemesanan Berhasil!</h1>
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Mohon ditunggu untuk konfirmasi pemesanan melalui Whatsapp
            </h1>

            {{-- <p class="text-gray-600 mb-6">
                {{ $message ?? 'Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses.' }}
            </p> --}}

            @if (isset($external_id))
                <p class="text-sm text-gray-500 mb-4">
                    ID Transaksi: {{ $external_id }}
                </p>
            @endif

            <div class="space-y-3">
                <a href="{{ url('/') }}"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>

</html>
