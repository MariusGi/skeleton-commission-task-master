<?php

declare(strict_types=1);

namespace MyApp\Config;

class OperationConstants
{
    const CASH_IN_FEE_PERC = 0.0003;
    const CASH_IN_FEE_EUR_MAX = '5.00';
    const CASH_OUT_FEE_PERC = 0.003;
    const CASH_OUT_FREE_EUR_MAX_NATURAL_PERS_WEEKLY = 1000;
    const CASH_OUT_MAX_DISCOUNTABLE_OPERATIONS = 3;
    const CASH_OUT_FEE_EUR_MIN_LEGAL_PERS = '0.50';

    const ROUND_NUMBER_DECIMALS = 2;

    const PERSON_TYPES = ['natural', 'legal'];

    const OPERATION_TYPES = ['cash_in', 'cash_out'];

    const SUPPORTED_CURRENCIES = ['EUR', 'JPY', 'USD'];

    const CURRENCY_RATIOS_TO_EUR = [
        'USD' => 1.1497,
        'JPY' => 129.53,
    ];

    const CSV_DATA_FILE_PATH = 'storage/csv/input.csv';
}
