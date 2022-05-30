<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|CompanyResource
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $company = Company::create([
                'title' => $request->title,
                'description' => $request->description,
                'phone' => $request->phone,
                'user_id' => auth('sanctum')->user()->getAuthIdentifier()
            ]);
            return new CompanyResource($company);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return AnonymousResourceCollection
     */
    public function show($id): AnonymousResourceCollection
    {
        return CompanyResource::collection(Company::where(['user_id' => $id])->get());
    }
}
