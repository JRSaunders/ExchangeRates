<?php
namespace ExchangeRates;
/**
 * Class Cache
 * @package ExchangeRates
 */
class Cache
{
    protected static $cachePath = false;

    /**
     * @return bool|string
     */
    public function getCachePath()
    {
        if (static::$cachePath) {
            return rtrim(static::$cachePath, '/') . '/';
        }
        return false;
    }

    /**
     * @param string $cachePath
     */
    public function setCachePath($cachePath)
    {
        static::$cachePath = $cachePath;
    }

    public function saveToCache($filename = null)
    {
        if ($this->getCachePath() && !empty($filename)) {
            $filename = $this->prepareFilename($filename);
            /**
             * TODO save to cache
             */
        }
    }

    protected function prepareFilename($filename)
    {

        $filename = $this->normalizeString($filename);
        $filename = str_replace('.XchgeCache', '', $filename);

        return $filename;
    }

    public function normalizeString($str = '')
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);
        return $str;
    }
}