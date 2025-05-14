<?php
// This is a simple script to create 10 operator accounts

// Bootstrap the Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

echo "Creating operator accounts...\n";

// Create a file to store the credentials
$credentialsPath = storage_path('app/operator-credentials.txt');
File::put($credentialsPath, "Operator Credentials (Generated at: " . now() . ")\n\n");

// Create 10 operator accounts with random passwords
for ($i = 1; $i <= 10; $i++) {
    // Generate a random password with 10 characters
    $randomPassword = Str::random(10);

    try {
        $user = User::create([
            'name' => "operator{$i}",
            'email' => "operator{$i}@example.com", // Fixed domain for simplicity
            'email_verified_at' => now(),
            'password' => Hash::make($randomPassword),
            'remember_token' => Str::random(10),
        ]);

        // Save the credentials to file
        File::append($credentialsPath, "Username: operator{$i}\n");
        File::append($credentialsPath, "Email: {$user->email}\n");
        File::append($credentialsPath, "Password: {$randomPassword}\n\n");

        echo "Created user: operator{$i} with password: {$randomPassword}\n";
    } catch (Exception $e) {
        echo "Error creating operator{$i}: " . $e->getMessage() . "\n";
    }
}

echo "Operator credentials saved to: {$credentialsPath}\n";
echo "Done!\n";
