<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanySymbolRequest;
use App\Mail\CompanySymbolEmail;
use App\Services\CompanySymbolService;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanySymbolController extends Controller
{
    public function index()
    {
        return view('symbol');
    }

    public function symbol(CompanySymbolRequest $request, CompanySymbolService $companySymbolService): JsonResponse
    {
        $data = $request->validated();
        $amount = $companySymbolService->getSymbol($data['symbol'], $data['from'], $data['to']);

        return response()->json(['amount' => $amount]);
    }

    public function show(CompanySymbolRequest $request, CompanySymbolService $companySymbolService)
    {
        $data = $request->validated();

        $companySymbolService->sendEmail($data);

        $response = $companySymbolService->getCompanySymbol($data['symbol']);

        $filtered_data = $companySymbolService->getDataByDateRange($data, $response);

        return response()->json([
            'filtered_data' => $filtered_data
            ]);
    }
}
