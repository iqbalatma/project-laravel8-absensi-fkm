<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CongressDayStoreRequest;
use App\Http\Requests\CongressDayUpdateRequest;
use App\Http\Resources\CongressDayResource;
use App\Http\Resources\CongressDayResourceCollection;
use App\Models\CongressDay;
use Illuminate\Http\JsonResponse;

class CongressDayController extends Controller
{

    /**
     * Description : to store data congress day
     * 
     * @param CongressDayStoreRequest $request for validate the request
     * @return JsonResponse for response 
     */
    public function store(CongressDayStoreRequest $request):JsonResponse
    {
        $validated = $request->validated();
        $data = CongressDay::create($validated);

        return (new CongressDayResource($data))->additional([
            'status'=> 201,
            'message'=> 'Store congress day successfully'
        ])->response()->setStatusCode(201);
    }


    /**
     * Description : to get single congress day
     * 
     * @param integer $id of the congress
     * @return JsonResponse resource for response
     */
    public function show(int $id):JsonResponse
    {
        $data = CongressDay::find($id);
        
        return (new CongressDayResource($data))->additional([
            'status'=> 200,
            'message'=> 'Get congress day successfully'
        ])->response()->setStatusCode(200);
    }

    public function index():JsonResponse
    {
        $totalPerPage =   request()->get('total_per_page') ?? 5;
        $data = CongressDay::paginate($totalPerPage);
        return (new CongressDayResourceCollection($data))->additional([
            'status' => 200,
            'message' => 'Get all congress day successfully'
        ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Description : for update the congress day 
     * 
     * @param CongressDayUpdateRequest $request for validate the request
     * @param integer $id the id that want to update
     * @return JsonResponse for response
     */
    public function update(CongressDayUpdateRequest $request, $id):JsonResponse
    {
        $validated = $request->validated();
        CongressDay::where('id',$id)->update($validated);
        $updated = CongressDay::find($id);

        return response()->json(['data'=> $updated]);
    }
}
