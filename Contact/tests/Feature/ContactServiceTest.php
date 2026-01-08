<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Contact;
use App\Models\User;
use App\Services\ContactService;
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
    }

    public function test_get_all_returns_only_user_contacts_for_regular_user()
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);
        
        Contact::factory()->count(3)->create(['user_id' => $user1->id]);
        Contact::factory()->count(2)->create(['user_id' => $user2->id]);

        $this->actingAs($user1);

        $results = $this->service->getAll();

        $this->assertCount(3, $results);
    }

    public function test_get_all_returns_everything_for_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        
        Contact::factory()->count(2)->create(['user_id' => $admin->id]);
        Contact::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($admin);

        $results = $this->service->getAll();

        $this->assertCount(5, $results);
    }

    public function test_create_contact_with_photo_and_cities()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $city = City::create(['nom' => 'Tanger']);
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john@example.com',
            'telephone' => '0600000000',
            'photo' => $photo,
            'cities' => [$city->id]
        ];

        $contact = $this->service->create($data);

        $this->assertDatabaseHas('contacts', ['email' => 'john@example.com', 'user_id' => $user->id]);
        $this->assertCount(1, $contact->cities);
        $this->assertNotNull($contact->photo);
        Storage::disk('public')->assertExists($contact->photo);
    }

    public function test_update_contact_replaces_old_photo()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $oldPhotoPath = UploadedFile::fake()->image('old.jpg')->store('contacts', 'public');
        $contact = Contact::factory()->create([
            'user_id' => $user->id,
            'photo' => $oldPhotoPath
        ]);

        $newPhoto = UploadedFile::fake()->image('new.jpg');
        $updatedData = [
            'nom' => 'Updated',
            'prenom' => 'Name',
            'email' => 'updated@example.com',
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
        $user = User::factory()->create();
        $this->actingAs($user);

        $photoPath = UploadedFile::fake()->image('delete.jpg')->store('contacts', 'public');
        $contact = Contact::factory()->create([
            'user_id' => $user->id,
            'photo' => $photoPath
        ]);

        $this->service->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_filter_by_city_and_search_term()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $city1 = City::create(['nom' => 'Casablanca']);
        $city2 = City::create(['nom' => 'Rabat']);

        $c1 = Contact::factory()->create(['nom' => 'Ali', 'user_id' => $user->id]);
        $c1->cities()->sync([$city1->id]);

        $c2 = Contact::factory()->create(['nom' => 'Ahmed', 'user_id' => $user->id]);
        $c2->cities()->sync([$city2->id]);

        // Filter by city
        $results = $this->service->filterByCity([$city1->id]);
        $this->assertCount(1, $results);
        $this->assertEquals('Ali', $results->first()->nom);

        // Filter by search term
        $results = $this->service->filterByCity([], 'Ahmed');
        $this->assertCount(1, $results);
        $this->assertEquals('Ahmed', $results->first()->nom);
    }
}
