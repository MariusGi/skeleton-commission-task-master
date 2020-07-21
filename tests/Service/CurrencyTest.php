<?php

declare(strict_types=1);

namespace MyApp\Service;

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * @var Operation
     */
    private $currency;

    public function setUp(): void
    {
        $this->currency = new Currency();
    }
    /**
     * @param string $amount
     * @param string $expectation
     * @param string $currency
     * @param bool $convertToEur
     * @param bool $rounded
     *
     * @dataProvider dataProviderForConvertAmountTesting
     */
    public function testConvertAmount(string $amount, string $expectation, string $currency = 'EUR', bool $convertToEur = true,
                                      bool $rounded = false)
    {
        $this->assertEquals(
            $expectation,
            $this->currency->convertAmount($amount, $currency, $convertToEur, $rounded)
        );
    }

    public function dataProviderForConvertAmountTesting(): array
    {
        return [
            'convert unspecified currency' => ['2', '2'],
            'convert eur to eur without decimals' => ['5', '5', 'EUR'],
            'convert eur to eur with decimals' => ['5.00', '5.00', 'EUR'],
            'convert usd to eur' => ['2', '1.73', 'USD', true, true],
            'convert jpy to eur' => ['100000', '772.02', 'JPY', true, true],
            'convert eur to usd' => ['2', '2.29', 'USD', false, true],
            'convert eur to jpy' => ['100', '12953.00', 'JPY', false, true],
        ];
    }
}
