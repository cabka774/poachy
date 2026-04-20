<?php

declare(strict_types=1);

$email = $argv[1] ?? 'admin@poachy.com';

$pdo = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare('select password from users where email = :email limit 1');
$stmt->execute(['email' => $email]);
$hash = $stmt->fetchColumn();

if (!$hash) {
    fwrite(STDERR, "No user found for email: {$email}\n");
    exit(1);
}

echo "hash_prefix=" . substr((string) $hash, 0, 10) . PHP_EOL;

if (preg_match('/^\$2[aby]\$(\d\d)\$/', substr((string) $hash, 0, 7), $m)) {
    echo "bcrypt_cost={$m[1]}" . PHP_EOL;
} else {
    echo "hash_type=non-bcrypt-or-unrecognized" . PHP_EOL;
}

