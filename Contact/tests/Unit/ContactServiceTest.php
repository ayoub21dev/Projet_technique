<?php

namespace Tests\Unit;

use App\Models\City;
use App\Models\Contact;
use App\Models\User;
use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ContactService $contactService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactService = new ContactService();
        Storage::fake('public');
    }

    /**
     * Test that an admin can retrieve all contacts.
     */
    public function test_get_all_contacts_for_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Auth::login($admin);

        Contact::factory()->count(5)->create();

        $contacts = $this->contactService->getAll();

        $this->assertCount(5, $contacts);
    }

    /**
     * Test that a regular user only retrieves their own contacts.
     */
    public function test_get_all_contacts_for_regular_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        Auth::login($user);

        Contact::factory()->count(3)->create(['user_id' => $user->id]);
        Contact::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $contacts = $this->contactService->getAll();

        $this->assertCount(3, $contacts);
    }

    /**
     * Test updating a contact, photo handling, and city synchronization.
     */
    public function test_update_contact_with_photo_and_cities()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $city = City::factory()->create();
        $photo = UploadedFile::fake()->image('contact.jpg');

        $data = [
            'nom' => 'Updated Nom',
            'cities' => [$city->id],
            'photo' => $photo
        ];

        $updatedContact = $this->contactService->update($contact, $data);

        $this->assertEquals('Updated Nom', $updatedContact->nom);
        $this->assertCount(1, $updatedContact->cities);
        $this->assertNotNull($updatedContact->photo);
        Storage::disk('public')->assertExists($updatedContact->photo);
    }

    /**
     * Test deleting a contact and its associated photo.
     */
    public function test_delete_contact_removes_photo()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $photoPath = 'contacts/test.jpg';
        Storage::disk('public')->put($photoPath, 'content');

        $contact = Contact::factory()->create([
            'user_id' => $user->id,
            'photo' => $photoPath
        ]);

        $this->contactService->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    /**
     * Test searching and filtering contacts by city and search term.
     */
    public function test_filter_by_city_and_search_term()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Auth::login($user);

        $city1 = City::factory()->create(['nom' => 'Paris']);
        $city2 = City::factory()->create(['nom' => 'Marseille']);

        $c1 = Contact::factory()->create(['nom' => 'Doe', 'prenom' => 'John']);
        $c1->cities()->attach($city1);

        $c2 = Contact::factory()->create(['nom' => 'Smith', 'prenom' => 'Jane']);
        $c2->cities()->attach($city2);

        $c3 = Contact::factory()->create(['nom' => 'Doe', 'prenom' => 'Jane']);
        $c3->cities()->attach($city2);

        // Filter by City 1
        $results = $this->contactService->filterByCity([$city1->id]);
        $this->assertCount(1, $results);
        $this->assertEquals('Doe', $results->first()->nom);

        // Filter by search term
        $results = $this->contactService->filterByCity([], 'Jane');
        $this->assertCount(2, $results);

        // Filter by both
        $results = $this->contactService->filterByCity([$city2->id], 'Doe');
        $this->assertCount(1, $results);
        $this->assertEquals('Jane', $results->first()->prenom);
    }
}
