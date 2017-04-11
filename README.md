# ExchangeRates
Apply and use up to date exchange rates

```<?php 

$cache = new \ExchangeRates\Cache();

$cache->setCachePath('/var/www/vhost/my-site/cachedata/');

$conversion = new \ExchangeRates\Conversion('GBP', 'EUR', 10.34);
   
echo $conversion->get();

// will echo out 11.70 - converting GBP 10.34 to EUR 11.70
```
