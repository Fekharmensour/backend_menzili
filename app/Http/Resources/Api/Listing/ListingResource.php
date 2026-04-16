<?php

namespace App\Http\Resources\Api\Listing;

use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\FeatureResource;
use App\Http\Resources\Api\LocationResource;
use App\Http\Resources\Api\NearPlaceResource;
use App\Http\Resources\Api\RentDurationResource;
use App\Http\Resources\Api\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'description' => $this->description,
            'rating'=>$this->rating_avg ?? 4.2 ,
            'views'=>$this->views ?? 0 ,

            'price' => $this->price,
            'floor' => $this->floor,
            'surface' => $this->surface,
            'min_duration' => $this->min_duration,
            'number_rooms' => $this->number_rooms,
            'number_persons' => $this->number_persons,

            'is_ready' => $this->is_ready,
            'is_negotiable' => $this->is_negotiable,
//            'boost_level' => $this->boost_level,
            'moderation_status' => $this->moderation_status,

            'image' => $this->main_image_url,

            // BelongsTo
            'rent_duration' => new RentDurationResource(
                $this->whenLoaded('rentDuration')
            ),

            'type' => new TypeResource(
                $this->whenLoaded('type')
            ),

            'location' => new \App\Http\Resources\Api\Listing\LocationResource(
                $this->whenLoaded('location')
            ),

            // Many To Many
            'categories' => CategoryResource::collection(
                $this->whenLoaded('categories')
            ),

            'features' => FeatureResource::collection(
                $this->whenLoaded('features')
            ),

            'near_places' => NearPlaceResource::collection(
                $this->whenLoaded('nearPlaces')
            ),

            'member' => new MemberResource($this->whenLoaded('member')),
            'images' => ImagesResource::collection(
                $this->whenLoaded('images')
            ),


            'time_post'=>$this->updated_at,
        ];
    }
}
