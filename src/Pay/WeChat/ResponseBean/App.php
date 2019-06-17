<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 19:20
 */

namespace ESD\Plugins\Pay\WeChat\ResponseBean;


use ESD\Plugins\Pay\Utility\SplBean;

class App extends SplBean
{
	protected $appid;
	protected $partnerid;
	protected $prepayid;
	protected $package;
	protected $noncestr;
	protected $timestamp;
	protected $sign;

}