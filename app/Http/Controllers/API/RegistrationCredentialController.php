<?php

namespace App\Http\Controllers\API;

use App\Exceptions\EmptyDataException;
use App\Exceptions\EmtpyDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationCredentialStoreRequest;
use App\Http\Requests\RegistrationCredentialUpdateRequest;
use App\Http\Resources\RegistrationCredentialResource;
use App\Http\Resources\RegistrationCredentialResourceCollection;
use App\Models\RegistrationCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class RegistrationCredentialController extends Controller
{
    public function index()
    {
        $totalPerPage =   request()->get('total_per_page') ?? 5;
        $data = RegistrationCredential::paginate($totalPerPage);
        return (new RegistrationCredentialResourceCollection($data))->additional([
            'status' => 200,
            'message' => 'Get all registration credential successfuly'
        ])
            ->response()
            ->setStatusCode(200);
    }


    public function store(RegistrationCredentialStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = 1;
        $validated['token'] = Str::random(8);

        $registrationController =  RegistrationCredential::create($validated);


        return (new RegistrationCredentialResource($registrationController))
            ->additional([
                'status' => 201,
                'message' => 'Store registration credential successfuly'
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): JsonResponse
    {
        $data = RegistrationCredential::find($id);

        if (empty($data)) throw new EmptyDataException();

        return (new RegistrationCredentialResource($data))
            ->additional([
                'status' => 200,
                'message' => 'Get registration credential successfuly'
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(RegistrationCredentialUpdateRequest $request, $id): JsonResponse
    {
        $updated = RegistrationCredential::where(['id' => $id])
            ->update($request->validated());

        if (!$updated) throw new EmptyDataException();

        $data = RegistrationCredential::find($id);

        return (new RegistrationCredentialResource($data))
            ->additional([
                'status' => 200,
                'message' => 'Update registration credential successfuly'
            ])
            ->response()
            ->setStatusCode(200);
    }
}
