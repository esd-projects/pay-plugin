<?php

namespace ESD\Plugins\Pay\Config;

use ESD\Core\Plugins\Config\BaseConfig;

class PayConfig extends BaseConfig
{

    const key = "pay";

    public function __construct()
    {
        parent::__construct(self::key);
    }
    /**
     * @var WeChatPayConfig
     */
    protected $wechatConfig;
    /**
     * @var AliPayConfig
     */
    protected $alipayConfig;

    /**
     * @return WeChatPayConfig
     */
    public function getWechatConfig()
    {
        return $this->wechatConfig;
    }

    /**
     * @param WeChatPayConfig $wechatConfig
     * @throws \ReflectionException
     */
    public function setWechatConfig($wechatConfig): void
    {
        if ($wechatConfig instanceof WeChatPayConfig) {
            $this->wechatConfig = $wechatConfig;
        } else {
            $Config = new WeChatPayConfig();
            $Config->buildFromConfig($wechatConfig);
            $this->wechatConfig = $Config;
        }
    }

    /**
     * @return AliPayConfig
     */
    public function getAlipayConfig()
    {
        return $this->alipayConfig;
    }

    /**
     * @param AliPayConfig $alipayConfig
     * @throws \ReflectionException
     */
    public function setAlipayConfig($alipayConfig): void
    {

        if ($alipayConfig instanceof AliPayConfig) {
            $this->alipayConfig = $alipayConfig;

        } else {
            $Config = new AliPayConfig();
            $Config->buildFromConfig($alipayConfig);
            $this->alipayConfig = $Config;
        }
    }

}