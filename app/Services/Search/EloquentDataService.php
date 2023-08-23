<?php

namespace App\Services\Search;

use App\Models\Data;
use Illuminate\Support\Arr;

class EloquentDataService implements DataService
{
    public function search(array $search = [])
    {
        return Data::query()
            ->when($name = Arr::get($search, 'name'), fn($query) => $query->where('name', 'like', "%{$name}%"))
            ->when($price = Arr::get($search, 'price'), fn($query) => $query->where('price', $price))
            ->when($bedrooms = Arr::get($search, 'bedrooms'), fn($query) => $query->where('bedrooms', $bedrooms))
            ->when($bathrooms = Arr::get($search, 'bathrooms'), fn($query) => $query->where('bathrooms', $bathrooms))
            ->when($storeys = Arr::get($search, 'storeys'), fn($query) => $query->where('storeys', $storeys))
            ->when($garages = Arr::get($search, 'garages'), fn($query) => $query->where('garages', $garages))
            ->when($from = Arr::get($search, 'from'), fn($query) => $query->where('price', '>=', $from))
            ->when($to = Arr::get($search, 'to'), fn($query) => $query->where('price', '<=', $to))
            ->get();
    }
}
