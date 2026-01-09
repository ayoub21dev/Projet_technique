<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/user.csv');

        if (!File::exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $csvData = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'] ?? 'user',
                ]
            );
        }

        $this->command->info('Users imported successfully from CSV!');
    }
}
