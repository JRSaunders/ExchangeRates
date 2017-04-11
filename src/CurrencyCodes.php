<?php
namespace ExchangeRates;

/**
 * Class CurrencyCodes
 * @package ExchangeRates
 */
class CurrencyCodes
{
    /**
     * @var array
     */
    private $codes = array(
        'EUR',
        'GBP',
        'JPY',
        'BGN',
        'CZK',
        'DKK',
        'HUF',
        'LTL',
        'LVL',
        'PLN',
        'RON',
        'SEK',
        'CHF',
        'NOK',
        'HRK',
        'RUB',
        'TRY',
        'AUD',
        'BRL',
        'CAD',
        'CNY',
        'HKD',
        'IDR',
        'ILS',
        'INR',
        'KRW',
        'MXN',
        'MYR',
        'NZD',
        'PHP',
        'SGD',
        'THB',
        'ZAR',
        'USD',
        'ISK'
    );

    /**
     * @param $code
     * @return bool|string
     */
    public function isValid($code)
    {
        $cleanCode = strtoupper($code);
        if (in_array($cleanCode, $this->codes)) {
            return $cleanCode;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getCodes()
    {
        return $this->codes;
    }
}