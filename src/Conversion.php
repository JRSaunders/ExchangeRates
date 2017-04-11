<?php

namespace ExchangeRates;
/**
 * Class Conversion
 * @package ExchangeRates
 */
class Conversion
{
    protected $cache;
    protected $rateQuery;
    protected $__rate;
    protected $rate = 0;
    protected $value = 0;

    /**
     * Conversion constructor.
     * @param $fromCurrency
     * @param $toCurrency
     * @param $value
     * @param int $ttl
     */
    public function __construct($fromCurrency, $toCurrency, $value, $ttl = 86400)
    {

        $this->cache = new Cache();
        $cacheFilename = $fromCurrency . $toCurrency . '-ratedata';
        $cachedRateData = $this->cache->getCacheData($cacheFilename, $ttl);
        if (!$cachedRateData) {
            $this->rateQuery = new RateQuery($fromCurrency, $toCurrency);
            $this->cache->saveToCache($cacheFilename, $this->rateQuery->getData());
            $cachedRateData = $this->rateQuery->getData();
        }
        $this->__rate = new Rate($cachedRateData);
        $this->rate = $this->__rate->get();
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function get()
    {
        return ($this->value * $this->rate);
    }
}