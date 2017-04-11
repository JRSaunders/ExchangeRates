<?php

namespace ExchangeRates;


class RateQuery extends Rate
{
    protected $query;
    protected $data = false;

    public function __construct($fromCurrency, $toCurrency)
    {
        $this->query = new Query();
        $this->data = $this->query->execute($fromCurrency, $toCurrency)->getData();
        if (!$this->data) {
            throw new \Exception('No Exchange Rate Data Received!');
        }
    }
}