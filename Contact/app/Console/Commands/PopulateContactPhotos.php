<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PopulateContactPhotos extends Command
{
    protected $signature = 'contacts:populate-photos';
    protected $description = 'Populate contacts with professional professional photos from Unsplash for demonstration';

    public function handle()
    {
        $this->info('Starting to populate contact photos...');
        
        $contacts = Contact::all();
        
        if ($contacts->isEmpty()) {
            $this->error('No contacts found in the database.');
            return;
        }

        // Create directory in storage/public/contacts
        if (!Storage::disk('public')->exists('contacts')) {
            Storage::disk('public')->makeDirectory('contacts');
        }

        // Professional headshot queries for Unsplash
        $queries = [
            'professional+man+business+headshot',
            'professional+woman+business+headshot',
            'professional+person+office+portrait',
            'business+executive+portrait',
            'smiling+professional+face'
        ];

        foreach ($contacts as $index => $contact) {
            $this->info("Processing: {$contact->prenom} {$contact->nom}");
            
            $imageUrl = "https://i.pravatar.cc/400?u=" . urlencode($contact->email);

            try {
                // Use Http::withoutVerifying() to avoid SSL issues on local dev environment
                // Also using a direct Unsplash source URL
                $response = Http::withoutVerifying()->get($imageUrl);
                
                if ($response->successful()) {
                    $filename = 'contacts/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());
                    
                    // Delete old photo if exists
                    if ($contact->photo) {
                        Storage::disk('public')->delete($contact->photo);
                    }

                    $contact->update(['photo' => $filename]);
                    $this->info("Successfully updated photo for {$contact->prenom}");
                } else {
                    $this->warn("Could not download image for {$contact->prenom}");
                }
            } catch (\Exception $e) {
                $this->error("Error for {$contact->prenom}: " . $e->getMessage());
            }
        }

        $this->info('Finished populating photos!');
    }
}
