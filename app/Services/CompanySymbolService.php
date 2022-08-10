<?php

namespace App\Services;

use App\Mail\CompanySymbolEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CompanySymbolService
{
    private string $host = 'yh-finance.p.rapidapi.com';
    private string $url  = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';

    public function __construct(protected RapidApiService $rapidApiService)
    {
    }

    public function getCompanySymbol(string $symbol, $region = 'US')
    {
        $response = $this->rapidApiService->get($this->host, $this->url, compact('symbol', 'region'));

        if ($response->failed()) {
            throw new \RuntimeException('Failed to find company', $response->status());
        }

        return $response->json();
    }

    public function sendEmail($data)
    {
        $objData = new \stdClass();
        $objData->sender = 'admin@application.com';
        $objData->receiver = $data['email'];
        $objData->symbol = $data['symbol'];
        $objData->start_date = $data['start_date'];
        $objData->end_date = $data['end_date'];

        Mail::to($data['email'])->send(new CompanySymbolEmail($objData));
    }

    public function getDataByDateRange($data, $response): array
    {
        $filtered_data = [];

        foreach ($response['prices'] as $price) {
            if ($price['date'] >= strtotime($data['start_date']) && $price['date'] <= strtotime($data['end_date']))
            {
                $price['date'] = Carbon::parse($price['date'])->format('Y-m-d');
                $filtered_data[] = $price;
            }
        }
        return $filtered_data;
    }

}
