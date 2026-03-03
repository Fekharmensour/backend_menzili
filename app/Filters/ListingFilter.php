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
        $this->request = $request;
        $this->query = $query;
    }

    public function apply(): Builder
    {
        $this->search();
        $this->type();
        $this->rentDuration();
        $this->city();
        $this->categories();
        $this->features();
        $this->nearPlaces();

        return $this->query;
    }

    /*
    |--------------------------------------------------
    | Search Title + Description
    |--------------------------------------------------
    */
    protected function search(): void
    {
        if (!$this->request->filled('search')) return;

        $search = $this->request->search;

        $this->query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    /*
    |--------------------------------------------------
    | Type Filter (Single)
    |--------------------------------------------------
    */
    protected function type(): void
    {
        if (!$this->request->filled('type_id')) return;

        $this->query->where('type_id', $this->request->type_id);
    }

    /*
    |--------------------------------------------------
    | Rent Duration (Only if type = rent)
    | Example: type_id = 1 = rent
    |--------------------------------------------------
    */
    protected function rentDuration(): void
    {
        if (
            !$this->request->filled('rent_duration_id') ||
            $this->request->type_id != 1
        ) return;

        $this->query->where('rent_duration_id', $this->request->rent_duration_id);
    }

    /*
    |--------------------------------------------------
    | City Filter
    |--------------------------------------------------
    */
    protected function city(): void
    {
        if (!$this->request->filled('city_id')) return;

        $cityId = $this->request->city_id;

        $this->query->whereHas('location', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        });
    }

    /*
    |--------------------------------------------------
    | Categories Filter (Multi Select)
    |--------------------------------------------------
    */
    protected function categories(): void
    {
        if (!$this->request->filled('category_ids')) return;

        $categoryIds = $this->request->category_ids;

        if (!is_array($categoryIds)) return;

        $this->query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }

    /*
    |--------------------------------------------------
    | Features Filter (Multi Select)
    |--------------------------------------------------
    */
    protected function features(): void
    {
        if (!$this->request->filled('feature_ids')) return;

        $featureIds = $this->request->feature_ids;

        if (!is_array($featureIds)) return;

        $this->query->whereHas('features', function ($q) use ($featureIds) {
            $q->whereIn('features.id', $featureIds);
        });
    }

    /*
    |--------------------------------------------------
    | Near Places Filter (Multi Select)
    |--------------------------------------------------
    */
    protected function nearPlaces(): void
    {
        if (!$this->request->filled('near_place_ids')) return;

        $nearPlaceIds = $this->request->near_place_ids;

        if (!is_array($nearPlaceIds)) return;

        $this->query->whereHas('nearPlaces', function ($q) use ($nearPlaceIds) {
            $q->whereIn('near_places.id', $nearPlaceIds);
        });
    }
}
