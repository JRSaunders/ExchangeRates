<?php
namespace ExchangeRates;

/**
 * Class Query
 * @package ExchangeRates
 */
class Query
{

    private $format = 'json';
    private $fromCurrency = false;
    private $toCurrency = false;
    protected $url = '';
    protected $params = '';
    protected $rawData = '';
    /**
     * @var CurrencyCodes
     */
    protected $codes;

    /**
     * @param bool|string $fromCurrency
     * @param bool|string $toCurrency
     * @param string $format
     */
    public function __construct($fromCurrency = false, $toCurrency = false, $format = 'json')
    {

        $this->codes = new CurrencyCodes();
        $this->setFromCurrency($fromCurrency);
        $this->setToCurrency($toCurrency);
        $this->setFormat($format);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    /**
     * @param $currency
     */
    public function setToCurrency($currency)
    {
        if ($this->codes->isValid($currency)) {
            $this->toCurrency = $currency;
        }
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param $format
     */
    public function setFormat($format)
    {
        $allowed = array('json', 'xml');
        if (in_array($format, $allowed)) {
            $this->format = $format;
        }
    }

    /**
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    /**
     * @param string $currency
     */
    public function setFromCurrency($currency)
    {
        if ($this->codes->isValid($currency)) {
            $this->fromCurrency = $currency;
        }
    }

    protected function buildQuery($fromCurrency = false, $toCurrency = false)
    {

        $fromCurrencyDefault = $this->getFromCurrency();
        if (isset($fromCurrency)) {
            $fromCurrency = $this->codes->isValid($fromCurrency);
            if ($fromCurrency) {
                $finalFromCurrency = $fromCurrency;
            } else {
                $finalFromCurrency = $fromCurrencyDefault;
            }
        }
        $toCurrencyDefault = $this->getToCurrency();
        if (isset($toCurrency)) {
            $toCurrency = $this->codes->isValid($toCurrency);
            if ($toCurrency) {
                $finalToCurrency = $toCurrency;
            } else {
                $finalToCurrency = $toCurrencyDefault;
            }
        }
        $format = $this->getFormat();
        $url = 'http://query.yahooapis.com/v1/public/yql';
        $params = 'q=select * from yahoo.finance.xchange where pair in (';

        if ($finalFromCurrency && $finalToCurrency) {
            $params .= '"' . $finalFromCurrency . $finalToCurrency . '"';
        } elseif ($fromCurrency) {
            $paramsArray = array();
            foreach ($this->codes->getCodes() as $code) {
                $paramsArray[] .= '"' . $finalFromCurrency . $code . '"';
            }
            $params .= join(',', $paramsArray);
        }

        $params .= ')';
        $params .= '&env=store://datatables.org/alltableswithkeys&format=' . $format;
        $this->url = $url;
        $this->params = $params;

        return $this;
    }

    /**
     * @param bool $fromCurrency
     * @param bool $toCurrency
     */
    public function execute($fromCurrency = false, $toCurrency = false)
    {
        $this->buildQuery($fromCurrency, $toCurrency);
        $url = $this->getUrl();
        $params = $this->getParams();
        $rawData = $this->curl($url, $params);
        $this->rawData = $rawData;
        return $this;
    }

    public function getData()
    {

        $format = $this->getFormat();

        switch ($format) {
            case 'json':
                return json_decode($this->getRawData());
                break;
            case 'xml':
                return simplexml_load_string($this->getRawData());
                break;
        }


    }

    protected function curl(
        $url = NULL,
        $params = NULL,
        $header = NULL,
        $connecttimeout = 180,
        $timeout = 180,
        $followloc = 1,
        $redir = 3,
        $user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)',
        $convert_params_array = TRUE
    )
    {


        if (!function_exists('curl_init')) die("\n no curl");

        if (!isset($url)) return FALSE;

        $postfields = '';
        $i = 0;
        if (isset($params) && is_array($params) && $convert_params_array == TRUE) {
            foreach ($params as $key => $value) {
                $and = ($i > 0) ? '&' : '';
                $postfields .= $and . $key . '=' . $value;
                $i++;
            }
        } else {
            $postfields = $params;
        }
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if (isset($header) && is_array($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connecttimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if (!ini_get('open_basedir') && !ini_get('safe_mode')) {

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followloc);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $redir);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);

        if (isset($params)) {

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }


}