<?php
header('Content-Type: application/json');

// Cek parameter URL produk
if (!isset($_GET['url'])) {
    echo json_encode(['error' => 'Parameter url tidak ditemukan']);
    exit;
}

// Ambil link
$url = $_GET['url'];

// Ambil konten halaman menggunakan cURL
function curl_get($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => '',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Ambil HTML dari halaman Shopee
$html = curl_get($url);

// Cek jika gagal ambil
if (!$html || strpos($html, 'error-page') !== false) {
    echo json_encode(['error' => 'Gagal mengambil data dari Shopee']);
    exit;
}

// Ekstrak JSON dari <script type="application/ld+json">
if (preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches)) {
    $json = json_decode($matches[1], true);
    if (isset($json['offers']['price'])) {
        echo json_encode([
            'name' => $json['name'] ?? null,
            'price' => $json['offers']['price'],
            'currency' => $json['offers']['priceCurrency'] ?? 'IDR'
        ]);
        exit;
    }
}

echo json_encode(['error' => 'Harga tidak ditemukan']);
