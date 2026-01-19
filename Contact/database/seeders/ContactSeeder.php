<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/Contact.csv');
        
        if (!File::exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $csvData = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);
            
            // 1. Manage City (Handle Multiple Cities)
            $cityNames = explode('|', $data['ville']);
            $cityIds = [];
            foreach ($cityNames as $cityName) {
                $city = City::firstOrCreate(['nom' => trim($cityName)]);
                $cityIds[] = $city->id;
            }

            // 2. Find Owner User
            $ownerEmail = $data['user_email'] ?? 'admin@connecthub.com';
            $user = User::where('email', $ownerEmail)->first() ?: User::first();

            // 3. Manage Contact
            $contact = Contact::updateOrCreate(
                ['email' => $data['email']], // Unique criteria
                [
                    'prenom' => $data['prenom'],
                    'nom' => $data['nom'],
                    'telephone' => $data['telephone'],
                    'photo' => $data['photo'] ?? null,
                    'user_id' => $user->id,
                ]
            );

            // 4. Sync Cities
            $contact->cities()->sync($cityIds);
        }

        $this->command->info('Contacts imported successfully from CSV!');
    }
}