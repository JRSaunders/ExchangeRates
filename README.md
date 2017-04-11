# ExchangeRates
Apply and Use up to date exchange rates

```<?php 
$conversion = new \ExchangeRates\Conversion('GBP', 'EUR', 10.34);
   
echo $conversion->get();
// will echo out 11.70 - converting GBP 10.34 to EUR 11.70
```
