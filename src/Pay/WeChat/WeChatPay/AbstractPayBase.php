<?php
/**
 * Created by PhpStorm.
 * User: xcg
 * Date: 2019/3/12
 * Time: 16:49
 */

namespace ESD\Plugins\Pay\WeChat\WeChatPay;


use ESD\Plugins\Pay\Config\WeChatPayConfig;
use ESD\Plugins\Pay\WeChat\RequestBean\Base;

abstract class AbstractPayBase
{
    protected $config;

    public function __construct(WeChatPayConfig $config)
    {
        $this->config = $config;
    }

    abstract protected function requestPath():string ;
    abstract function pay(Base $bean);
}