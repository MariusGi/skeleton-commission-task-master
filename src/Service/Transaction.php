<?php

declare(strict_types=1);

namespace MyApp\Service;

use MyApp\Config\OperationConstants;
use MyApp\Support\Helper;

class Transaction
{
    private $user;
    private $currency;
    private $math;
    private $operation;
    private $cashInFeePerc;

    public function __construct()
    {
        $this->currency = new Currency();
        $this->math = new Math(OperationConstants::ROUND_NUMBER_DECIMALS);
        $this->operation = new Operation();
        $this->user = new User();
        $this->cashInFeePerc = Helper::toString(OperationConstants::CASH_IN_FEE_PERC);
    }

    public function getFees(array $transactionsArr): array
    {
        $fees = [];

        foreach ($transactionsArr as $transaction) {
            $fee = '';

            if ($transaction['operation'] === 'cash_in') {
                $amountInEur = $this->currency->convertAmount($transaction['amount'], $transaction['currency']);
                $feeInEur = $this->math->multiply($amountInEur, $this->cashInFeePerc);

                if ($feeInEur > OperationConstants::CASH_IN_FEE_EUR_MAX) {
                    $fee = $this->currency->convertAmount(OperationConstants::CASH_IN_FEE_EUR_MAX, $transaction['currency'],
                        false, true);
                } else {
                    $fee = $this->math->multiply($transaction['amount'], $this->cashInFeePerc);
                }
            } elseif ($transaction['operation'] === 'cash_out') {
                if ($transaction['person'] === 'natural') {
                    $amountInEur = $this->currency->convertAmount($transaction['amount'], $transaction['currency']);
                    $this->user->saveUserOperation($transaction['date'], $transaction['user_id'], $amountInEur);
                    $userData = $this->user->getUserData();
                    $fee = $this->operation->getFeeForNaturalPerson($transaction['user_id'], $transaction['amount'],
                        $transaction['currency'], $userData);
                } elseif ($transaction['person'] === 'legal') {
                    $fee = $this->operation->getFeeForLegalPerson($transaction['amount'], $transaction['currency']);
                }
            }
            array_push($fees, $fee);
        }

        return $fees;
    }
}
