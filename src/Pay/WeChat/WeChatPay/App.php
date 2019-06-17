<?php
/**
 * Created by PhpStorm.
 * User: xcg
 * Date: 2019/3/28
 * Time: 18:15
 */

namespace ESD\Plugins\Pay\WeChat\WeChatPay;

use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\Utility\Random;
use ESD\Plugins\Pay\WeChat\RequestBean\Base;
use ESD\Plugins\Pay\WeChat\ResponseBean\App as AppResponse;
use ESD\Plugins\Pay\WeChat\Utility;

class App extends AbstractPayBase
{
	public function requestPath() : string
	{
		return '/pay/unifiedorder';
	}


    /**
     * @param Base $bean
     * @return AppResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
	public function pay( Base $bean )
	{
		$bean->setNotifyUrl( $this->config->getNotifyUrl() );
		$utility      = new Utility( $this->config );
		$result       = $utility->requestApi( $this->requestPath(), $bean );
		$data         = [
			'appid'     => $result['appid'],
			'partnerid' => $result['mch_id'],
			'prepayid'  => $result['prepay_id'],
			'noncestr'  => Random::character( 32 ),
			'timestamp' => strval( time() ),
			'package'   => 'Sign=WXPay',
		];
		$data['sign'] = $utility->generateSign( $data );
		return new AppResponse( $data );
	}
}