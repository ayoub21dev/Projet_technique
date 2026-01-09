<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/ville.csv');

        if (!File::exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $csvData = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            City::firstOrCreate([
                'nom' => trim($data['nom']),
            ]);
        }

        $this->command->info('Cities imported successfully from CSV!');
    }
}
