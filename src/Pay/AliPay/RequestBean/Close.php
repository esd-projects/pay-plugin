<?php
/**
 * Created by PhpStorm.
 * User: hanwenbo
 * Date: 2019-02-17
 * Time: 17:46
 */
namespace ESD\Plugins\Pay\AliPay\RequestBean;


class Close extends Base
{
	protected $method = 'alipay.trade.close';
}