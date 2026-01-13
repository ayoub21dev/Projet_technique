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

    public function test_it_can_get_all_contacts_based_on_role()
    {
        // 1. Regular user should only see their own contacts (user1@test.com has 2 contacts in CSV)
        $user1 = User::where('email', 'user1@test.com')->first();
        $this->actingAs($user1);
        $this->assertCount(2, $this->service->getAll());

        // 2. Admin should see all contacts (10 contacts in CSV)
        $admin = User::where('email', 'admin@connecthub.com')->first();
        $this->actingAs($admin);
        $this->assertCount(10, $this->service->getAll());
    }

    public function test_it_can_update_a_contact_and_replace_photo()
    {
        Storage::fake('public');
        $user = User::where('email', 'user1@test.com')->first();
        $this->actingAs($user);

        // Get existing contact and setup a mock photo
        $contact = Contact::where('email', 'karim@test.com')->first();
        $oldPhoto = UploadedFile::fake()->image('old.jpg')->store('contacts', 'public');
        $contact->update(['photo' => $oldPhoto]);

        $newPhoto = UploadedFile::fake()->image('new.jpg');
        $this->service->update($contact, [
            'nom' => 'Updated',
            'prenom' => 'Name',
            'email' => 'karim@test.com',
            'telephone' => '0700000000',
            'photo' => $newPhoto
        ]);

        Storage::disk('public')->assertMissing($oldPhoto);
        Storage::disk('public')->assertExists($contact->fresh()->photo);
        $this->assertEquals('Updated', $contact->fresh()->nom);
    }

    public function test_it_can_delete_a_contact_and_its_photo()
    {
        Storage::fake('public');
        $user = User::where('email', 'user2@test.com')->first();
        $this->actingAs($user);

        // Get existing contact and setup a mock photo
        $contact = Contact::where('email', 'fatima@test.com')->first();
        $photoPath = UploadedFile::fake()->image('delete.jpg')->store('contacts', 'public');
        $contact->update(['photo' => $photoPath]);

        $this->service->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_it_can_search_and_filter_contacts()
    {
        $admin = User::where('email', 'admin@connecthub.com')->first();
        $this->actingAs($admin);

        // Filter by city (Casablanca)
        $casablanca = City::where('nom', 'Casablanca')->first();
        $results = $this->service->filterByCity([$casablanca->id]);
        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertTrue($results->contains(fn($contact) => $contact->nom === 'Alami'));

        // Search by name (Ahmed)
        $results = $this->service->filterByCity([], 'Ahmed');
        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertTrue($results->contains(fn($contact) => $contact->prenom === 'Ahmed'));
        
        // Combined filter and search
        $results = $this->service->filterByCity([$casablanca->id], 'Ahmed');
        $this->assertCount(1, $results);
        $this->assertEquals('Ahmed', $results->first()->prenom);
    }
}
