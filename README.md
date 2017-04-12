# ExchangeRates
Apply and use up to date exchange rates

[![Latest Stable Version](https://poser.pugx.org/jrsaunders/exchangerates/v/stable)](https://packagist.org/packages/jrsaunders/giraffe)
[![Total Downloads](https://poser.pugx.org/jrsaunders/exchangerates/downloads)](https://packagist.org/packages/jrsaunders/exchangerates)
[![Latest Unstable Version](https://poser.pugx.org/jrsaunders/exchangerates/v/unstable)](https://packagist.org/packages/jrsaunders/exchangerates)
[![License](https://poser.pugx.org/jrsaunders/exchangerates/license)](https://packagist.org/packages/jrsaunders/exchangerates)

```<?php 

$cache = new \ExchangeRates\Cache();

$cache->setCachePath('/var/www/vhost/my-site/cachedata/');

$conversion = new \ExchangeRates\Conversion('GBP', 'EUR', 10.34);
   
echo $conversion->get();

// will echo out 11.70 - converting GBP 10.34 to EUR 11.70
```
