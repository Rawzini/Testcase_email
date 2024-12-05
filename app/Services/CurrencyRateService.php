<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyRateService
{
    public function getDollarRubleRate(): float
    {
        $response = Http::get('https://www.cbr-xml-daily.ru/daily_json.js');

        if ($response->successful()) {
            $currencyRates = $response->json();

            $dollarRubleRate = data_get($currencyRates, 'Valute.USD.Value', null);

            if ($dollarRubleRate === null) {
                throw new \Exception("The 'USDRUB' rate is missing in the API response.");
            }

            return $response->json()['Valute']['USD']['Value'];
        }

        throw new \Exception('Unable to fetch dollar rate');
    }
}