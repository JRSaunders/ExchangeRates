<?php

namespace ExchangeRates;


class Rate
{
    protected $query;
    protected $data = false;

    public function __construct($data = false)
    {
        $this->data = $data;
    }

    public function get()
    {
        if (isset($this->data->query->results->rate->Rate)) {
            return $this->data->query->results->rate->Rate;
        }
        throw new \Exception('No Exchange Rate Data Found!');
    }

    /**
     * @return bool|data
     */
    public function getData()
    {
        return $this->data;
    }

}