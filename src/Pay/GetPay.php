<?php

/**
 * File: GetPay.php
 * User: 4213509@qq.com
 * Date: 2019-06-17
 * Time: ${Time}
 **/


namespace ESD\Plugins\Pay;

use DI\Annotation\Inject;
use ESD\Plugins\Pay\AliPay\AliPay;
use ESD\Plugins\Pay\Config\PayConfig;
use ESD\Plugins\Pay\WeChat\WeChat;


trait GetPay
{

    /**
     * @Inject()
     * @var Pay
     */
    protected $pay;

    /**
     * @return AliPay
     */
    public function getAliPay(): AliPay
    {
        return $this->pay->getAliPay();
    }

    /**
     * @return WeChat
     */
    public function getWePay(): WeChat
    {
        return  $this->pay->getWePay();
    }

    /**
     * @return PayConfig
     */
    public function getConfig(): PayConfig
    {
        return  $this->pay->getPayConfig();
    }


}