<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\FeatureResource;
use App\Http\Resources\Api\NearPlaceResource;
use App\Http\Resources\Api\RentDurationResource;
use App\Http\Resources\Api\TypeResource;
use App\Models\Category;
use App\Models\Feature;
use App\Models\NearPlace;
use App\Models\RentDuration;
use App\Models\Type;
use App\Models\Wilaya;
use Illuminate\Http\Request;

class DetailsController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => trans('api.listings.index.success'),
            'data' => [
                'features' => FeatureResource::collection(Feature::all()),
                'categories' =>  CategoryResource::collection(Category::all()),
                'near_places' =>  NearPlaceResource::collection(NearPlace::all()),
                'types' =>  TypeResource::collection(Type::all()),
                'rent_durations' =>  RentDurationResource::collection(RentDuration::all()),
            ]
        ]);
    }
    public function wilayas(){
        return response()->json([
            'success' => true,
            'message' => trans('api.listings.index.success'),
            'data' => [
                'wilayas' =>  \App\Http\Resources\Api\WilayaResource::collection(\App\Models\Wilaya::all()),
            ]
        ]);
    }
    public function cities(Request $request){
        $validation = $request->validate([
            'wilaya_id' => 'required|exists:wilayas,id'
        ]);
        $wilaya = Wilaya::find($validation['wilaya_id']);
        return response()->json([
            'success' => true,
            'message' => trans('api.listings.index.success'),
            'data' => [
                'cities' => CityResource::collection($wilaya->cities),
            ]
        ]);

    }
}
