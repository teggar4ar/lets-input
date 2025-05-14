<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class OperatorAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a file to store the credentials
        $credentialsPath = storage_path('app/operator-credentials.txt');
        File::put($credentialsPath, "Operator Credentials (Generated at: " . now() . ")\n\n");

        // Create 10 operator accounts with random passwords
        for ($i = 1; $i <= 10; $i++) {
            // Generate a random password with 10 characters
            $randomPassword = Str::random(10);

            $user = User::create([
                'name' => "operator{$i}",
                'email' => "operator{$i}@" . Str::random(5) . ".com", // Random domain part
                'email_verified_at' => now(),
                'password' => Hash::make($randomPassword), // Random password for each operator
                'remember_token' => Str::random(10),
            ]);

            // Save the credentials to file
            File::append($credentialsPath, "Username: operator{$i}\n");
            File::append($credentialsPath, "Email: {$user->email}\n");
            File::append($credentialsPath, "Password: {$randomPassword}\n\n");

            // Output the user credentials to the console for admin reference
            $this->command->info("Created user: operator{$i} with password: {$randomPassword}");
        }

        $this->command->info("Operator credentials saved to: {$credentialsPath}");
    }
}
