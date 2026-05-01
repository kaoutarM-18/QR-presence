<?php

namespace App\Helpers;

class QrCodeHelper
{
    public static function generate($url, $size = 300)
    {
        // Utiliser l'API Google Charts (gratuit, pas besoin d'extension)
        $qrUrl = "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl=" . urlencode($url);
        
        return '<img src="' . $qrUrl . '" alt="QR Code" style="width: ' . $size . 'px; height: ' . $size . 'px;">';
    }
    
    public static function downloadUrl($url, $size = 300)
    {
        return "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl=" . urlencode($url);
    }
}