<?php

declare(strict_types=1);

namespace MyApp\Service;

use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    /**
    * @var Transaction
    */
    private $transaction;

    public function setUp(): void
    {
        $this->transaction = new Transaction();
    }
    /**
     * @param array $transaction
     * @param array $expectation
     *
     * @dataProvider dataProviderForGetTransactionFeeTesting
     */
    public function testGetTransactionFee(array $transaction, array $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->transaction->getFees($transaction)
        );
    }

    public function dataProviderForGetTransactionFeeTesting(): array
    {
        return [
            'get fee for multiple transactions' => [
                [
                    [
                        'id' => '1',
                        'date' => '01/01/2015',
                        'user_id' => '1',
                        'person' => 'natural',
                        'operation' => 'cash_out',
                        'amount' => '1000.00',
                        'currency' => 'EUR',
                    ],
                    [
                        'id' => '1',
                        'date' => '01/01/2016',
                        'user_id' => '1',
                        'person' => 'natural',
                        'operation' => 'cash_out',
                        'amount' => '1000.00',
                        'currency' => 'EUR',
                    ],
                ],
                ['0.00','0.00']
            ],
        ];
    }
}