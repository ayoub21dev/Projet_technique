<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Contact;
use App\Models\User;
use App\Services\ContactService;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    private ContactService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ContactService::class);
        
        // Seed database with CSV data
        $this->seed(UserSeeder::class);
        $this->seed(ContactSeeder::class);
    }

    public function test_get_all_returns_only_user_contacts_for_regular_user()
    {
        // Use real user from CSV data (user1@test.com has 2 contacts)
        $user1 = User::where('email', 'user1@test.com')->first();
        
        $this->actingAs($user1);

        $results = $this->service->getAll();

        // user1@test.com has 2 contacts: Karim and Omar
        $this->assertCount(2, $results);
    }

    public function test_get_all_returns_everything_for_admin()
    {
        // Use real admin from CSV data
        $admin = User::where('email', 'admin@connecthub.com')->first();
        
        $this->actingAs($admin);

        $results = $this->service->getAll();

        // Admin should see all 10 contacts from CSV
        $this->assertCount(10, $results);
    }

    public function test_create_contact_with_photo_and_cities()
    {
        Storage::fake('public');
        
        // Use real user from CSV
        $user = User::where('email', 'user1@test.com')->first();
        $this->actingAs($user);
        
        // Use real city from CSV
        $city = City::where('nom', 'Tanger')->first();
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nom' => 'Test',
            'prenom' => 'New',
            'email' => 'newcontact@test.com',
            'telephone' => '0611223344',
            'photo' => $photo,
            'cities' => [$city->id]
        ];

        $contact = $this->service->create($data);

        $this->assertDatabaseHas('contacts', ['email' => 'newcontact@test.com', 'user_id' => $user->id]);
        $this->assertCount(1, $contact->cities);
        $this->assertEquals('Tanger', $contact->cities->first()->nom);
        $this->assertNotNull($contact->photo);
        Storage::disk('public')->assertExists($contact->photo);
    }

    public function test_update_contact_replaces_old_photo()
    {
        Storage::fake('public');
        
        // Use real user from CSV
        $user = User::where('email', 'user1@test.com')->first();
        $this->actingAs($user);

        // Get existing contact from CSV data (Karim belongs to user1)
        $contact = Contact::where('email', 'karim@test.com')->first();
        
        // Store old photo to test replacement
        $oldPhotoPath = UploadedFile::fake()->image('old.jpg')->store('contacts', 'public');
        $contact->update(['photo' => $oldPhotoPath]);

        $newPhoto = UploadedFile::fake()->image('new.jpg');
        $updatedData = [
            'nom' => 'Updated',
            'prenom' => 'Name',
            'email' => 'karim@test.com',
            'telephone' => '0700000000',
            'photo' => $newPhoto
        ];

        $this->service->update($contact, $updatedData);

        Storage::disk('public')->assertMissing($oldPhotoPath);
        Storage::disk('public')->assertExists($contact->fresh()->photo);
    }

    public function test_delete_contact_removes_photo_from_storage()
    {
        Storage::fake('public');
        
        // Use real user from CSV
        $user = User::where('email', 'user2@test.com')->first();
        $this->actingAs($user);

        // Get existing contact from CSV data (Fatima belongs to user2)
        $contact = Contact::where('email', 'fatima@test.com')->first();
        
        // Add a photo to test deletion
        $photoPath = UploadedFile::fake()->image('delete.jpg')->store('contacts', 'public');
        $contact->update(['photo' => $photoPath]);

        $this->service->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_filter_by_city_and_search_term()
    {
        // Use admin to see all contacts
        $admin = User::where('email', 'admin@connecthub.com')->first();
        $this->actingAs($admin);

        // Use real cities from CSV
        $casablanca = City::where('nom', 'Casablanca')->first();
        $rabat = City::where('nom', 'Rabat')->first();

        // Filter by city (Ahmed is in Casablanca)
        $results = $this->service->filterByCity([$casablanca->id]);
        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertTrue($results->contains(fn($contact) => $contact->nom === 'Alami'));

        // Filter by city (Sara is in Rabat)
        $results = $this->service->filterByCity([$rabat->id]);
        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertTrue($results->contains(fn($contact) => $contact->nom === 'Benani'));

        // Filter by search term (search for 'Ahmed')
        $results = $this->service->filterByCity([], 'Ahmed');
        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertTrue($results->contains(fn($contact) => $contact->prenom === 'Ahmed'));
    }
}
