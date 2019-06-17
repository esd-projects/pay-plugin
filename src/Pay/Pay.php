<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 11:38
 */

namespace ESD\Plugins\Pay;


use ESD\Plugins\Pay\AliPay\AliPay;
use ESD\Plugins\Pay\Config\AliPayConfig;
use ESD\Plugins\Pay\Config\PayConfig;
use ESD\Plugins\Pay\Config\WeChatPayConfig;
use ESD\Plugins\Pay\WeChat\WeChat;

class Pay
{
    /**
     * @var PayConfig
     */
    private $payConfig;

    /**
     * @var WeChat
     */
    private $wePay;

    /**
     * @var AliPay
     */
    private $aliPay;


    public function __construct(PayConfig $payConfig)
    {
        $this->payConfig = $payConfig;
    }

    public function getWePay(WeChatPayConfig $config = null)
    {
        if (isset($this->wePay)) {
            return $this->wePay;
        }
        if (empty($config)) $config = $this->payConfig->getWechatConfig();
        $this->wePay = new WeChat($config);
        return $this->wePay;
    }


    public function getAliPay(AliPayConfig $config = null): ?AliPay
    {
        if (isset($this->aliPay)) {
            return $this->aliPay;
        }
        if (empty($config)) $config = $this->payConfig->getAlipayConfig();
        $this->wePay = new AliPay($config);
        return $this->wePay;
    }

    /**
     * @return PayConfig
     */
    public function getPayConfig(): PayConfig
    {
        return $this->payConfig;
    }

}