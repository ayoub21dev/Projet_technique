<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getAll()
    {
        return City::withCount('contacts')->get();
    }


    public function update(City $city, array $data)
    {
        $city->update($data);
        return $city;
    }

    public function delete(City $city)
    {
        if ($city->contacts()->count() > 0) {
            throw new \Exception('Cannot delete city as it is linked to contacts.');
        }
        return $city->delete();
    }
}
