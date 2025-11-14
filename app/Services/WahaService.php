<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaService
{
    protected $baseUrl;
    protected $apiKey;
    protected $session;

    public function __construct()
    {
        $this->baseUrl = config('waha.base_url');
        $this->apiKey = config('waha.api_key');
        $this->session = config('waha.session');
    }

    /**
     * Set session (override default session)
     * 
     * @param string|null $session
     * @return self
     */
    public function setSession($session)
    {
        $this->session = $session ?: config('waha.session');
        return $this;
    }

    /**
     * Get current session
     * 
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Send text message
     * 
     * @param string $phone - Phone number (e.g., "62895422988754")
     * @param string $message - Text message to send
     * @return array
     */
    public function sendText($phone, $message)
    {
        try {
            $chatId = $this->formatChatId($phone);

            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
            ])->post($this->baseUrl . '/api/sendText', [
                'chatId' => $chatId,
                'text' => $message,
                'session' => $this->session,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('WAHA Send Text Failed', [
                'phone' => $phone,
                'session' => $this->session,
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('WAHA Send Text Error', [
                'phone' => $phone,
                'session' => $this->session,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Send image with optional caption
     * 
     * @param string $phone - Phone number
     * @param string $imageUrl - Public URL of the image
     * @param string|null $caption - Optional caption for the image
     * @param string|null $filename - Optional filename (default: auto-detect from URL)
     * @return array
     */
    public function sendImage($phone, $imageUrl, $caption = null, $filename = null)
    {
        try {
            $chatId = $this->formatChatId($phone);

            // Auto-detect filename from URL if not provided
            if (!$filename) {
                $filename = basename(parse_url($imageUrl, PHP_URL_PATH)) ?: 'image.jpg';
            }

            // Auto-detect mimetype from filename extension
            $mimetype = $this->getMimeType($filename);

            $payload = [
                'chatId' => $chatId,
                'file' => [
                    'mimetype' => $mimetype,
                    'filename' => $filename,
                    'url' => $imageUrl
                ],
                'reply_to' => null,
                'session' => $this->session,
            ];

            // Add caption if provided
            if ($caption) {
                $payload['caption'] = $caption;
            }

            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
            ])->post($this->baseUrl . '/api/sendImage', $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('WAHA Send Image Failed', [
                'phone' => $phone,
                'imageUrl' => $imageUrl,
                'session' => $this->session,
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('WAHA Send Image Error', [
                'phone' => $phone,
                'imageUrl' => $imageUrl,
                'session' => $this->session,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get mimetype from filename extension
     * 
     * @param string $filename
     * @return string
     */
    protected function getMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp',
        ];

        return $mimeTypes[$extension] ?? 'image/jpeg'; // default to jpeg
    }

    /**
     * Format phone number to chatId format
     * 
     * @param string $phone
     * @return string
     */
    protected function formatChatId($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Add @c.us if not already present
        if (!str_contains($phone, '@')) {
            $phone = $phone . '@c.us';
        }

        return $phone;
    }
}
