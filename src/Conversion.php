<?php

namespace ExchangeRates;

class Conversion
{
    protected $cache;
    protected $rateQuery;
    protected $__rate;
    protected $rate = 0;
    protected $value = 0;

    public function __construct($fromCurrency, $toCurrency, $value, $ttl = 12000)
    {

        $this->cache = new Cache();
        $cacheFilename = $fromCurrency . $toCurrency . '-ratedata';
        $cachedRateData = $this->cache->getCacheData($cacheFilename, $ttl);
        if (!$cachedRateData) {
            echo 'new q';
            $this->rateQuery = new RateQuery($fromCurrency, $toCurrency);
            $this->cache->saveToCache($cacheFilename, $this->rateQuery->getData());
            $cachedRateData = $this->rateQuery->getData();
        }
        $this->__rate = new Rate($cachedRateData);
        $this->rate = $this->__rate->get();
        $this->value = $value;
    }

    public function get()
    {
        return ($this->value * $this->rate);
    }
}