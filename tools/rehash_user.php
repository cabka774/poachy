<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$email = $argv[1] ?? 'admin@poachy.com';
$plain = $argv[2] ?? 'password123';

$user = App\Models\User::query()->where('email', $email)->firstOrFail();

echo "before=" . substr((string) $user->password, 0, 7) . "\n";
echo "needsRehash=" . (Hash::needsRehash((string) $user->password) ? 'true' : 'false') . "\n";

if (Hash::needsRehash((string) $user->password)) {
    $user->forceFill(['password' => $plain])->save();
}

$user->refresh();
echo "after=" . substr((string) $user->password, 0, 7) . "\n";

