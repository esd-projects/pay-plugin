<?php
/**
 * Created by PhpStorm.
 * User: xcg
 * Date: 2019/3/11
 * Time: 17:54
 */

namespace ESD\Plugins\Pay\WeChat\WeChatPay;

use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\WeChat\RequestBean\Base;
use ESD\Plugins\Pay\WeChat\RequestBean\OfficialAccount as OfficialAccountRequest;
use ESD\Plugins\Pay\WeChat\ResponseBean\OfficialAccount as OfficiaAccountResponse;
use ESD\Plugins\Pay\WeChat\Utility;

/**
 * 公众号支付入口
 * Class OfficialAccount
 * @package ESD\Plugins\Pay\WeChat\WeChatPay
 */
class OfficialAccount extends AbstractPayBase
{

    /**
     * 发起一次支付
     * @param Base $bean 这里实际上会给入对应支付方法的Bean
     * @return OfficiaAccountResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay(Base $bean): OfficiaAccountResponse
    {
        $utility = new Utility($this->config);
        // 如果没有定义回调 使用全局回调
        if (empty($bean->getNotifyUrl())) {
            $bean->setNotifyUrl($this->config->getNotifyUrl());
        }
        $result = $utility->requestApi($this->requestPath(), $bean);
        $result = [
            'appId' => $this->config->getAppId(),
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => empty($bean->getSignType()) ? 'MD5' : $bean->getSignType()
        ];
        $response = new OfficiaAccountResponse($result);
        $response->setPaySign($utility->generateSign($response->toArray()));
        return $response;
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