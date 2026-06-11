<?php

namespace App\Http\Controllers\Api\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\StoreRequest;
use App\Http\Requests\Ad\UpdateRequest;
use App\Http\Resources\Api\Ad\AdResource;
use App\Http\Resources\Api\Ad\AdsPlanResource;
use App\Models\Ad;
use App\Models\AdsPlan;
use App\Services\Ad\AdPublishingService;
use App\Services\Ad\AdTargetTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    public function memberAds()
    {
        $memberID = Auth::user()->member->id;
        $ads = Ad::where('member_id', $memberID)->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => __('api.ad.index.success'),
            'data' => AdResource::collection($ads)
        ]);
    }

    public function plans()
    {
        $plans = AdsPlan::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'message' => 'Available Ad Plans retrieved successfully',
            'data' => AdsPlanResource::collection($plans)
        ]);
    }

    public function index()
    {
        $ads = Ad::active()->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => __('api.ad.index.success'),
            'data' => AdResource::collection($ads)
        ]);
    }

    public function store(StoreRequest $request, AdTargetTypeService $adTargetTypeService, AdPublishingService $adPublishingService)
    {
        $data = $request->validated();
        $adTargetTypeService->validateTargetPayload($data);
        $data = $adTargetTypeService->normalizeTargetPayload($data);

        $member = Auth::user()->member;
        $plan = AdsPlan::findOrFail($data['ads_plan_id']);

        // Preparation for service
        $adData = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'image_path' => app(\App\Services\Image\ImageService::class)->storeAsWebp($request->file('image'), 'ads'),
            'target_type' => $data['target_type'],
            'listing_id' => $data['listing_id'] ?? null,
            'external_url' => $data['external_url'] ?? null,
        ];

        try {
            $ad = $adPublishingService->publish($member, $plan, $adData);

            return response()->json([
                'success' => true,
                'message' => __('api.ad.created'),
                'data' => new AdResource($ad)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show(Ad $ad)
    {
        return response()->json([
            'success' => true,
            'message' => __('api.ad.show'),
            'data' => new AdResource($ad)
        ]);
    }

    public function update(UpdateRequest $request, Ad $ad, AdTargetTypeService $adTargetTypeService)
    {
        $data = $request->validated();
        $adTargetTypeService->validateTargetPayload($data, $ad);
        $data = $adTargetTypeService->normalizeTargetPayload($data, $ad);

        if ($request->hasFile('image')) {
            $ad->updateImage($request->file('image'));
            unset($data['image_path']);
        }

        $ad->update($data);

        return response()->json([
            'success' => true,
            'data' => new AdResource($ad),
            'message' => __('api.ad.updated'),
        ]);
    }

    public function destroy(Ad $ad)
    {
        \Storage::disk('public')->delete($ad->image_path);
        $ad->delete();

        return response()->json([
            'success' => true,
            'message' => __('api.ad.deleted'),
        ]);
    }

}
