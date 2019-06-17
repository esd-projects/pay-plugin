<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 19:39
 */

namespace ESD\Plugins\Pay\AliPay\ResponseBean;


class Transfer extends Base
{
	/**
	 * @var string
	 */
	protected $out_biz_no;

	/**
	 * @var string
	 */
	protected $order_id;
	/**
	 * @var string
	 */
	protected $pay_date;

}