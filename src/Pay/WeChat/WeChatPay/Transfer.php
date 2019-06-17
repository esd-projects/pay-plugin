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
use ESD\Plugins\Pay\WeChat\RequestBean\Transfer as TransferRequest;
use ESD\Plugins\Pay\WeChat\ResponseBean\Transfer as TransferResponse;
use ESD\Plugins\Pay\WeChat\Utility;

class Transfer extends AbstractPayBase
{
    /**
     * 付款到个人零钱
     * @param TransferRequest $bean
     * @return TransferResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function payOut(TransferRequest $bean): TransferResponse
    {
        $utility = new Utility($this->config);
        $result = $utility->requestApi($this->requestPath(), $bean,true);
        return new TransferResponse((array)$result);
    }

    /**
     * 请求地址
     * @return string
     */
    protected function requestPath(): string
    {
        return '/mmpaymkttransfers/promotion/transfers';
    }

    function pay(Base $bean)
    {
        // TODO: Implement pay() method.
    }
}