<?php
/**
 *
 * Copyright  EasySwoole
 * User: hanwenbo
 * Date: 2019-02-17
 * Time: 13:24
 *
 */

namespace ESD\Plugins\Pay\WeChat\ResponseBean;


use ESD\Plugins\Pay\Utility\SplBean;

class Transfer extends SplBean
{
    protected $mch_appid;
    protected $mch_id;
    protected $device_info;
    protected $nonce_str;
    protected $result_code;
    protected $err_code;
    protected $err_code_des;
    protected $partner_trade_no;
    protected $payment_no;
    protected $payment_time;


}