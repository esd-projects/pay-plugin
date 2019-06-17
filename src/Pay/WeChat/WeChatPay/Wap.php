<?php
/**
 * Created by PhpStorm.
 * User: xcg
 * Date: 2019/3/13
 * Time: 16:04
 */

namespace ESD\Plugins\Pay\WeChat\WeChatPay;

use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\WeChat\RequestBean\Base;
use ESD\Plugins\Pay\WeChat\RequestBean\PayBase;
use ESD\Plugins\Pay\WeChat\ResponseBean\Wap as WapResponse;
use ESD\Plugins\Pay\WeChat\Utility;

class Wap extends AbstractPayBase
{
    /**
     * 发起一次支付
     * @param PayBase $bean
     * @return WapResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay(Base $bean): WapResponse
    {
        // 如果没有定义回调 使用全局回调
        if (empty($bean->getNotifyUrl())) {
            $bean->setNotifyUrl($this->config->getNotifyUrl());
        }
        $utility = new Utility($this->config);
        $result = $utility->requestApi($this->requestPath(), $bean);
        return new WapResponse((array)$result);
    }

    /**
     * 请求地址
     * @return string
     */
    protected function requestPath(): string
    {
        return '/pay/unifiedorder';
    }
}