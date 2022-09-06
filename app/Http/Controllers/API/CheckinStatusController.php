<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckinStatusStoreRequest;
use App\Models\Checkin;
use App\Models\CheckinStatus;
use Illuminate\Http\JsonResponse;

class CheckinStatusController extends Controller
{
    public function checkin(CheckinStatusStoreRequest $request, string $personalToken): JsonResponse
    {
        $data = Checkin::where('personal_token', $personalToken)->first();
        if(empty($data)){
            return response()->json([
                'status'=> 404,
                'error' => 1,
                'message' => 'Your personal token is invalid !'
            ])->setStatusCode(404);
        }

        $validated = $request->validated();
        $validated['user_id'] = $data->id;
        $validated['checkin_status'] = true;

        $checkinStatus = CheckinStatus::where(['user_id' => $data->id, 'congress_day_id' => $validated['congress_day_id']])->first();

        if (empty($checkinStatus)) {
            CheckinStatus::create($validated);
            return response()->json([
                'status'=> 200,
                'error' => 0,
                'message' => 'Checkin successfully!'
            ])->setStatusCode(200);
        } else {
            if($checkinStatus->checkin_status){
                $checkinStatus->checkin_status = 0;
                $checkinStatus->save();

                return response()->json([
                    'status'=> 200,
                    'error' => 0,
                    'message' => 'Checkout successfully!'
                ])->setStatusCode(200);
            }else{
                $checkinStatus->checkin_status = 1;
                $checkinStatus->save();

                return response()->json([
                    'status'=> 200,
                    'error' => 0,
                    'message' => 'Checkin successfully!'
                ])->setStatusCode(200);
            }
           
        }
    }
}
