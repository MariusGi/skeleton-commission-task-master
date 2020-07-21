<?php

declare(strict_types=1);

namespace MyApp\Service;

use MyApp\Config\OperationConstants;
use MyApp\Support\Helper;

class Currency
{
    // Converts by default to EUR, enter optional parameter $convertToEur = false to convert to $currency variable.
    public function convertAmount(string $amount, string $currency = 'EUR', bool $convertToEur = true,
                                  bool $rounded = false): string
    {
        if ($currency === 'EUR') {
            return $amount;
        }

        $amount = Helper::toString($amount);
        $ratio = Helper::toString(OperationConstants::CURRENCY_RATIOS_TO_EUR[$currency]);

        $math = new Math(OperationConstants::ROUND_NUMBER_DECIMALS);

        if ($convertToEur === true) {
            if ($rounded === true) {
                $convertedAmount = $math->divide($amount, $ratio);
            } else {
                $convertedAmount = $math->divideRaw($amount, $ratio);
            }
        } else {
            if ($rounded === true) {
                $convertedAmount = $math->multiply($amount, $ratio);
            } else {
                $convertedAmount = $math->multiplyRaw($amount, $ratio);
            }
        }

        return $convertedAmount;
    }
}
