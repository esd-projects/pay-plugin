<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 12:00
 */

namespace ESD\Plugins\Pay\Utility;


use Swlib\Saber;

class HttpClient
{
    public static $TIMEOUT = 15;
    /**
     * @var Saber[]
     */
    protected static $sabers;

    public static function post($gateway,$endpoint, $data)
    {
        return  self::getSaberFromBaseUrl($gateway)->post($endpoint,$data);
    }

    public static function postXML($gateway,$endpoint, $data, $options = [])
    {
        return  self::getSaberFromBaseUrl($gateway)->post($endpoint,$data,$options);
    }

    public static function getSaberFromBaseUrl(string $baseUri): ?Saber
    {
        $saber = self::$sabers[$baseUri] ?? null;
        if ($saber == null) {
            $normalOptions = [
                'use_pool' => true,
                'base_uri' => $baseUri,
                'retry_time' => self::$TIMEOUT,
                'retry' => function (Saber\Request $request) use ($baseUri) {
                    $request->getUri()->withHost($baseUri);
                }
            ];
            $saber = Saber::create($normalOptions);
            self::$sabers[$baseUri] = $saber;
        }
        return $saber;
    }
}