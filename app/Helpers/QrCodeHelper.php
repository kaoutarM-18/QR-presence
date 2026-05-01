<?php

namespace App\Helpers;

class QrCodeHelper
{
    public static function generate($url, $size = 300)
    {
        // Utilise l'API Google Charts pour générer le QR Code
        $encodedUrl = urlencode($url);
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedUrl}";
        
        return '<img src="' . $qrUrl . '" alt="QR Code" class="img-fluid">';
    }

    public static function downloadUrl($url, $size = 300)
    {
        $encodedUrl = urlencode($url);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedUrl}&download=1";
    }
}