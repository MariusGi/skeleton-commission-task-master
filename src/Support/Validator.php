<?php

declare(strict_types=1);

namespace MyApp\Support;

use MyApp\Config\OperationConstants;

class Validator
{
    public static function validateTransactionInput(array $dataArr): array
    {
        foreach ($dataArr as $dataArrRow) {
            if (!in_array($dataArrRow['person'], OperationConstants::PERSON_TYPES, true)) {
                return [
                    'id' => $dataArrRow['id'],
                    'column' => 'person',
                    'value' => $dataArrRow['person'],
                ];
            }
            if (!in_array($dataArrRow['operation'], OperationConstants::OPERATION_TYPES, true)) {
                return [
                    'id' => $dataArrRow['id'],
                    'column' => 'operation',
                    'value' => $dataArrRow['operation'],
                ];
            }
            if ($dataArrRow['amount'] <= 0) {
                return [
                    'id' => $dataArrRow['id'],
                    'column' => 'amount',
                    'value' => $dataArrRow['amount'],
                ];
            }
            if (!in_array($dataArrRow['currency'], OperationConstants::SUPPORTED_CURRENCIES, true)) {
                return [
                    'id' => $dataArrRow['id'],
                    'column' => 'currency',
                    'value' => $dataArrRow['currency'],
                ];
            }
        }

        return [];
    }
}
