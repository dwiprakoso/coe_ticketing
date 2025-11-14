<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WAHA Base URL
    |--------------------------------------------------------------------------
    |
    | Base URL untuk WAHA API server
    | Contoh: http://localhost:3000 atau https://waha.yourdomain.com
    |
    */
    'base_url' => env('WAHA_BASE_URL', 'http://localhost:3000'),

    /*
    |--------------------------------------------------------------------------
    | WAHA API Key
    |--------------------------------------------------------------------------
    |
    | API Key untuk autentikasi ke WAHA server
    |
    */
    'api_key' => env('WAHA_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | WAHA Default Session
    |--------------------------------------------------------------------------
    |
    | Default session name yang digunakan untuk mengirim pesan
    | Session ini harus sudah di-setup dan connected di WAHA server
    |
    */
    'session' => env('WAHA_SESSION', 'default'),
];
