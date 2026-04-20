<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$email = $argv[1] ?? 'admin@poachy.com';
$user = App\Models\User::query()->where('email', $email)->first();

if (!$user) {
    fwrite(STDERR, "No user found for email: {$email}\n");
    exit(1);
}

$rounds = config('hashing.bcrypt.rounds');
echo "config_rounds={$rounds}\n";
echo "stored_prefix=" . substr((string) $user->password, 0, 10) . "\n";
echo "needsRehash=" . (Hash::needsRehash((string) $user->password) ? 'true' : 'false') . "\n";

