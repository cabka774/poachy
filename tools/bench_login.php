<?php

declare(strict_types=1);

$url = $argv[1] ?? 'http://127.0.0.1:8000/api/login';
$email = $argv[2] ?? 'admin@poachy.com';
$password = $argv[3] ?? 'password123';

$payload = json_encode([
    'email' => $email,
    'password' => $password,
], JSON_UNESCAPED_SLASHES);

if ($payload === false) {
    fwrite(STDERR, "Failed to encode JSON payload.\n");
    exit(2);
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$t0 = microtime(true);
$body = curl_exec($ch);
$elapsedMs = (microtime(true) - $t0) * 1000;

if ($body === false) {
    fwrite(STDERR, 'cURL error: '.curl_error($ch)."\n");
    exit(2);
}

$code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

echo 'code='.$code.' ms='.round($elapsedMs, 1).PHP_EOL;
if ($code >= 400) {
    echo $body.PHP_EOL;
}

