<?php

namespace App\Http\Controllers\Api\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\StoreRequest;
use App\Http\Requests\Ad\UpdateRequest;
use App\Http\Resources\Api\Ad\AdResource;
use App\Models\Ad;
use App\Services\Ad\AdTargetTypeService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::active()->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => __('api.ad.index.success'),
            'data' => AdResource::collection($ads)
        ]);
    }

    public function store(StoreRequest $request, AdTargetTypeService $adTargetTypeService)
    {
        $data = $request->validated();
        $adTargetTypeService->validateTargetPayload($data);
        $data = $adTargetTypeService->normalizeTargetPayload($data);

        $data['image_path'] = $request->file('image')->store('ads', 'public');

        $data['member_id'] = \Auth::id();

        $ad = Ad::create([
            'title' => $data['title'],
            'member_id' => $data['member_id'],
            'description' => $data['description'] ?? null,
            'image_path' => $data['image_path'],
            'target_type' => $data['target_type'],
//            'status' => $data['status'],
            'listing_id' => $data['listing_id'] ?? null,
            'target_member_id' => $data['target_member_id'] ?? null,
            'external_url' => $data['external_url'] ?? null,

            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'coins' => $data['coins'],



        ]);

        return response()->json([
            'success' => true,
            'message' => __('api.ad.created'),
            'data' => new AdResource($ad)
        ]);
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
            \Storage::disk('public')->delete($ad->image_path);
            $data['image_path'] = $request->file('image')->store('ads', 'public');
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
