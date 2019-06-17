<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 19:20
 */

namespace ESD\Plugins\Pay\AliPay\RequestBean;


class Wap extends Web
{
	protected $product_code = 'QUICK_WAP_WAY';
	protected $method = 'alipay.trade.wap.pay';

}