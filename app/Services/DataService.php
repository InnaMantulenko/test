<?php

namespace App\Services;

use App\Models\Data;
use Illuminate\Support\Arr;

class DataService
{
    public function search(array $data = [])
    {
        return Data::query()
            ->when($name = Arr::get($data, 'name'), fn($query) => $query->where('name', 'like', "%{$name}%"))
            ->when($price = Arr::get($data, 'price'), fn($query) => $query->where('price', $price))
            ->when($bedrooms = Arr::get($data, 'bedrooms'), fn($query) => $query->where('bedrooms', $bedrooms))
            ->when($bathrooms = Arr::get($data, 'bathrooms'), fn($query) => $query->where('bathrooms', $bathrooms))
            ->when($storeys = Arr::get($data, 'storeys'), fn($query) => $query->where('storeys', $storeys))
            ->when($garages = Arr::get($data, 'garages'), fn($query) => $query->where('garages', $garages))
            ->when($from = Arr::get($data, 'from'), fn($query) => $query->where('price', '>=', $from))
            ->when($to = Arr::get($data, 'to'), fn($query) => $query->where('price', '<=', $to))
            ->get();
    }
}
