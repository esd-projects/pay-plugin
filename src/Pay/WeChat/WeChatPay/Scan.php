<?php
/**
 * Created by PhpStorm.
 * User: xcg
 * Date: 2019/3/18
 * Time: 11:34
 */

namespace ESD\Plugins\Pay\WeChat\WeChatPay;

use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\WeChat\RequestBean\Base;
use ESD\Plugins\Pay\WeChat\RequestBean\PayBase;
use ESD\Plugins\Pay\WeChat\ResponseBean\Scan as ScanResponse;
use ESD\Plugins\Pay\WeChat\Utility;

/**
 * 扫码支付
 * Class Scan
 * @package ESD\Plugins\Pay\WeChat\WeChatPay
 */
class Scan extends AbstractPayBase
{
    /**
     * 发起一次支付
     * @param PayBase $bean
     * @return ScanResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay(Base $bean): ScanResponse
    {
        // 如果没有定义回调 使用全局回调
        if (empty($bean->getNotifyUrl())) {
            $bean->setNotifyUrl($this->config->getNotifyUrl());
        }
        $utility = new Utility($this->config);
        $result = $utility->requestApi($this->requestPath(), $bean);
        return new ScanResponse((array)$result);
    }

    /**
     * 设置支付路径
     * @return string
     */
    protected function requestPath(): string
    {
        return '/pay/unifiedorder';
    }
}