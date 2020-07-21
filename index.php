<?php

include_once 'vendor/autoload.php';

use MyApp\Config\OperationConstants;
use MyApp\Input\Import;
use MyApp\Support\Validator;
use MyApp\Service\Transaction;
use MyApp\Support\Error;
use MyApp\Output\Output;

if (defined('STDIN')) {
    $filePath = $argv[1];
} else {
    $filePath = OperationConstants::CSV_DATA_FILE_PATH;
}

$transaction = new Transaction();
$import = new Import($filePath);

if ($import->errorMessage) {
    Error::displayErrorMessage($import->errorMessage);
} else {
    $dataArr = $import->convertCsvToArr();
    $validation = Validator::validateTransactionInput($dataArr);

    if ($validation) {
        Error::displayDataValidationError($validation);
    } else {
        $fees = $transaction->getFees($dataArr);
        Output::displayResults($fees);
    }
}
