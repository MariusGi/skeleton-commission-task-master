<?php

declare(strict_types=1);

namespace MyApp\Service;

use MyApp\Config\OperationConstants;
use MyApp\Support\Helper;

class Operation
{
    public function getFeeForNaturalPerson(string $userId, string $amount, string $origCurrency, array $userData): string
    {
        $math = new Math(OperationConstants::ROUND_NUMBER_DECIMALS);
        $cashOutFeePerc = Helper::toString(OperationConstants::CASH_OUT_FEE_PERC);

        if ($userData[$userId]['operationCount'] > OperationConstants::CASH_OUT_MAX_DISCOUNTABLE_OPERATIONS) {
            $fee = $math->multiply($amount, $cashOutFeePerc);
        } else {
            $commissionableAmount = $this->getCommissionableAmount($userId, $amount, $origCurrency, $userData);

            if ($commissionableAmount <= 0) {
                return '0.00';
            }

            $fee = $math->multiply($commissionableAmount, $cashOutFeePerc);
        }

        return $fee;
    }

    public function getFeeForLegalPerson(string $amount, string $origCurrency): string
    {
        $currency = new Currency();
        $amountInEur = $currency->convertAmount($amount, $origCurrency);
        $math = new Math(OperationConstants::ROUND_NUMBER_DECIMALS);
        $cashOutFeePerc = Helper::toString(OperationConstants::CASH_OUT_FEE_PERC);
        $feeInEur = $math->multiply($amountInEur, $cashOutFeePerc);

        if ($feeInEur < OperationConstants::CASH_OUT_FEE_EUR_MIN_LEGAL_PERS) {
            $minCashOutFee = Helper::toString(OperationConstants::CASH_OUT_FEE_EUR_MIN_LEGAL_PERS);
            $fee = $currency->convertAmount($minCashOutFee, $origCurrency, false, true);
        } else {
            $fee = $math->multiply($amount, $cashOutFeePerc);
        }

        return $fee;
    }

    private function getCommissionableAmount(string $userId, string $origAmount, string $origCurrency, array $userData): string
    {
        $currency = new Currency();
        $math = new Math(OperationConstants::ROUND_NUMBER_DECIMALS);
        $amount = Helper::toString($userData[$userId]['amount']);
        $maxFreeWeeklyAmount = Helper::toString(OperationConstants::CASH_OUT_FREE_EUR_MAX_NATURAL_PERS_WEEKLY);
        $origAmountInEur = $currency->convertAmount($origAmount, $origCurrency);

        if ($math->subtract($amount, $maxFreeWeeklyAmount) >= $origAmountInEur) {
            $commissionableAmount = $origAmount;
        } else {
            $commissionableAmountInEur = $math->subtract($amount, $maxFreeWeeklyAmount);
            $currency = new Currency();
            $commissionableAmount = $currency->convertAmount($commissionableAmountInEur, $origCurrency, false);
        }

        return $commissionableAmount;
    }
}
