<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListingFilter
{
    protected Builder $query;
    protected Request $request;

    public function __construct(Request $request, Builder $query)
    {
        // Merge JSON body into request parameters to unify input
        $request->merge($request->json()->all());

        $this->request = $request;
        $this->query = $query;
    }

    public function apply(): Builder
    {
        $this->search();
        $this->type();
        $this->member();
        $this->rentDuration();
        $this->city();
        $this->wilaya();
        $this->categories();
        $this->features();
        $this->nearPlaces();

        $this->price();
        $this->surface();
        $this->rooms();
        $this->persons();
        $this->floor();
        $this->minDuration();
        $this->ready();
        $this->negotiable();


        return $this->query;
    }

    protected function search(): void
    {
        $search = $this->request->input('search');
        if (!$search) return;

        $this->query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    protected function type(): void
    {
        $typeId = $this->request->input('type_id');
        if (!$typeId) return;

        $this->query->where('type_id', $typeId);
    }
    protected function member(): void
    {
        $memberId = $this->request->input('member_id');
        if (!$memberId) return;

        $this->query->where('member_id', $memberId);
    }

    /*--------------------------------------------------
     | Rent Duration (Only if type = rent) i have proble
     --------------------------------------------------*/
    protected function rentDuration(): void
    {
        $rentDurationId = $this->request->input('rent_duration_id');
        if (!$rentDurationId) return;

        $this->query->where('rent_duration_id', $rentDurationId);
    }

    protected function city(): void
    {
        $cityId = $this->request->input('city_id');
        if (!$cityId) return;

        $this->query->whereHas('location', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        });
    }

    protected function wilaya(): void
    {
        $wilayaId = $this->request->input('wilaya_id');

        if (!$wilayaId) return;

        $this->query->whereHas('location.city', fn ($q) =>
        $q->where('wilaya_id', $wilayaId)
        );
    }


    protected function categories(): void
    {
        $categoryIds = $this->request->input('category_ids');
        if (!is_array($categoryIds) || empty($categoryIds)) return;

        $this->query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }

    /*--------------------------------------------------
     | Features Filter (Multi Select)
     --------------------------------------------------*/
    protected function features(): void
    {
        $featureIds = $this->request->input('feature_ids');
        if (!is_array($featureIds) || empty($featureIds)) return;

        $this->query->whereHas('features', function ($q) use ($featureIds) {
            $q->whereIn('features.id', $featureIds);
        });
    }

    /*--------------------------------------------------
     | Near Places Filter (Multi Select)
     --------------------------------------------------*/
    protected function nearPlaces(): void
    {
        $nearPlaceIds = $this->request->input('near_place_ids');
        if (!is_array($nearPlaceIds) || empty($nearPlaceIds)) return;

        $this->query->whereHas('nearPlaces', function ($q) use ($nearPlaceIds) {
            $q->whereIn('near_places.id', $nearPlaceIds);
        });
    }

    protected function price(): void
    {
        $min = $this->request->input('min_price');
        $max = $this->request->input('max_price');

        if ($min !== null) {
            $this->query->where('price', '>=', $min);
        }

        if ($max !== null) {
            $this->query->where('price', '<=', $max);
        }
    }

    protected function surface(): void
    {
        $min = $this->request->input('min_surface');
        $max = $this->request->input('max_surface');

        if ($min !== null) {
            $this->query->where('surface', '>=', $min);
        }

        if ($max !== null) {
            $this->query->where('surface', '<=', $max);
        }
    }
    protected function rooms(): void
    {
        $rooms = $this->request->input('number_rooms');
        if (!$rooms) return;

        $this->query->where('number_rooms', '>=', $rooms);
    }

    protected function persons(): void
    {
        $persons = $this->request->input('number_persons');
        if (!$persons) return;

        $this->query->where('number_persons', '>=', $persons);
    }

    protected function floor(): void
    {
        $min = $this->request->input('min_floor');
        $max = $this->request->input('max_floor');

        if ($min !== null) {
            $this->query->where('floor', '>=', $min);
        }

        if ($max !== null) {
            $this->query->where('floor', '<=', $max);
        }
    }

    protected function minDuration(): void
    {
        $duration = $this->request->input('min_duration');
        if (!$duration) return;

        $this->query->where('min_duration', '<=', $duration);
    }

    protected function ready(): void
    {
        $ready = $this->request->input('is_ready');
        if ($ready === null) return;

        $this->query->where('is_ready', $ready);
    }
    protected function negotiable(): void
    {
        $negotiable = $this->request->input('is_negotiable');
        if ($negotiable === null) return;

        $this->query->where('is_negotiable', $negotiable);
    }

//GET /listings?
//
//min_price=20000
//&max_price=60000
//&min_surface=80
//&number_rooms=3
//&number_persons=4
//&min_floor=1
//&max_floor=5
//&min_duration=6
//&is_ready=1
//&is_negotiable=1
}
