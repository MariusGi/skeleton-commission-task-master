<?php

declare(strict_types=1);

namespace MyApp\Service;

use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    /**
     * @var Operation
     */
    private $operation;

    public function setUp(): void
    {
        $this->operation = new Operation();
    }
    /**
     * @param string $amount
     * @param string $currency
     * @param string $expectation
     *
     * @dataProvider dataProviderForLegalPersonFeeTesting
    */
    public function testGetFeeForLegalPerson(string $amount, string $currency, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->operation->getFeeForLegalPerson($amount, $currency)
        );
    }

    public function dataProviderForLegalPersonFeeTesting(): array
    {
        return [
            'get minimal fee for legal person in eur' => ['100', 'EUR', '0.50'],
            'get over minimal fee for legal person in eur' => ['300', 'EUR', '0.90'],
            'get minimal fee for legal person not in eur' => ['100', 'USD', '0.57'],
            'get over minimal fee for legal person not in eur' => ['100000', 'JPY', '300.00'],
        ];
    }
}