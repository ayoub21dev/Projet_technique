<?php

namespace Tests\Unit;

use App\Models\City;
use App\Models\Contact;
use App\Services\CityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CityService $cityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cityService = new CityService();
    }

    /**
     * Test getting all cities with contacts count.
     */
    public function test_get_all_cities()
    {
        City::factory()->count(3)->create();

        $cities = $this->cityService->getAll();

        $this->assertCount(3, $cities);
        $this->assertNotNull($cities->first()->contacts_count);
    }

    /**
     * Test updating a city.
     */
    public function test_update_city()
    {
        $city = City::factory()->create(['nom' => 'Old Name']);
        $data = ['nom' => 'New Name'];

        $updatedCity = $this->cityService->update($city, $data);

        $this->assertEquals('New Name', $updatedCity->nom);
        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'nom' => 'New Name'
        ]);
    }

    /**
     * Test deleting a city without contacts.
     */
    public function test_delete_city_without_contacts()
    {
        $city = City::factory()->create();

        $result = $this->cityService->delete($city);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }

    /**
     * Test that a city cannot be deleted if it has linked contacts.
     */
    public function test_cannot_delete_city_with_contacts()
    {
        $city = City::factory()->create();
        $contact = Contact::factory()->create();
        $city->contacts()->attach($contact);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot delete city as it is linked to contacts.');

        $this->cityService->delete($city);
    }
}
