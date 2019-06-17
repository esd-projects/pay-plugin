<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 11:42
 */

namespace ESD\Plugins\Pay\AliPay;

use ESD\Plugins\Pay\AliPay\RequestBean\App;
use ESD\Plugins\Pay\AliPay\RequestBean\MiniProgram;
use ESD\Plugins\Pay\AliPay\RequestBean\NotifyRequest;
use ESD\Plugins\Pay\AliPay\RequestBean\Pos;
use ESD\Plugins\Pay\AliPay\RequestBean\Scan;
use ESD\Plugins\Pay\AliPay\RequestBean\Transfer;
use ESD\Plugins\Pay\AliPay\RequestBean\Wap;
use ESD\Plugins\Pay\AliPay\RequestBean\Web;
use ESD\Plugins\Pay\AliPay\RequestBean\OrderFind;
use ESD\Plugins\Pay\AliPay\RequestBean\RefundFind;
use ESD\Plugins\Pay\AliPay\RequestBean\TransferFind;
use ESD\Plugins\Pay\AliPay\RequestBean\Refund;
use ESD\Plugins\Pay\AliPay\RequestBean\Close;
use ESD\Plugins\Pay\AliPay\RequestBean\Cancel;
use ESD\Plugins\Pay\AliPay\RequestBean\Download;

use ESD\Plugins\Pay\AliPay\ResponseBean\Base;
use ESD\Plugins\Pay\AliPay\ResponseBean\Web as WebResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Wap as WapResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\App as AppResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Pos as PosResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Scan as ScanResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Transfer as TransferResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\MiniProgram as MiniProgramResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\OrderFind as OrderFindResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\RefundFind as RefundFindResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\TransferFind as TransferFindResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Close as CloseResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Cancel as CancelResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Download as DownloadResponse;
use ESD\Plugins\Pay\AliPay\ResponseBean\Refund as RefundResponse;

use ESD\Plugins\Pay\Config\AliPayConfig;
use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidConfigException;

use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\Utility\HttpClient;
use ESD\Plugins\Pay\Utility\SplArray;
use ESD\Plugins\Pay\Utility\SplString;


class AliPay
{
	private $config;

	function __construct(AliPayConfig $config )
	{
		$this->config = $config;
	}

	/**
	 * @param Web $web
	 * @return WebResponse
	 * @throws InvalidConfigException
	 */
	public function web( Web $web ) : WebResponse
	{
		return new WebResponse( $this->getRequestParams( $web ) );
	}

	/**
	 * @param Wap $wap
	 * @return WapResponse
	 * @throws InvalidConfigException
	 */
	public function wap( Wap $wap ) : WapResponse
	{
		return new WapResponse( $this->getRequestParams( $wap ) );
	}

	/**
	 * @param App $app
	 * @return AppResponse
	 * @throws InvalidConfigException
	 */
	public function app( App $app ) : AppResponse
	{
		return new AppResponse( $this->getRequestParams( $app ) );
	}

	/**
	 * @param Pos $pos
	 * @return PosResponse
	 * @throws InvalidConfigException
	 */
	public function pos( Pos $pos ) : PosResponse
	{
		return new PosResponse( $this->getRequestParams( $pos ) );
	}

	/**
	 * @param Scan $scan
	 * @return ScanResponse
	 * @throws InvalidConfigException
	 */
	public function scan( Scan $scan ) : ScanResponse
	{
		return new ScanResponse( $this->getRequestParams( $scan ) );
	}

	/**
	 * @param Transfer $transfer
	 * @return TransferResponse
	 * @throws InvalidConfigException
	 */
	public function transfer( Transfer $transfer ) : TransferResponse
	{
		return new TransferResponse( $this->getRequestParams( $transfer ) );
	}

	/**
	 * @param MiniProgram $miniProgram
	 * @return MiniProgramResponse
	 * @throws InvalidConfigException
	 */
	public function miniProgram( MiniProgram $miniProgram ) : MiniProgramResponse
	{
		return new MiniProgramResponse( $this->getRequestParams( $miniProgram ) );
	}

	/**
	 * @param OrderFind $orderFind
	 * @return OrderFindResponse
	 * @throws InvalidConfigException
	 */
	public function orderFind( OrderFind $orderFind ) : OrderFindResponse
	{
		return new OrderFindResponse( $this->getRequestParams( $orderFind ) );
	}

	/**
	 * @param RefundFind $refundFind
	 * @return RefundFindResponse
	 * @throws InvalidConfigException
	 */
	public function refundFind( RefundFind $refundFind ) : RefundFindResponse
	{
		return new RefundFindResponse( $this->getRequestParams( $refundFind ) );
	}

	/**
	 * @param TransferFind $transferFind
	 * @return TransferFindResponse
	 * @throws InvalidConfigException
	 */
	public function transferFind( TransferFind $transferFind ) : TransferFindResponse
	{
		return new TransferFindResponse( $this->getRequestParams( $transferFind ) );
	}

	/**
	 * @param Refund $refund
	 * @return RefundResponse
	 * @throws InvalidConfigException
	 */
	public function refund( Refund $refund ) : RefundResponse
	{
		return new RefundResponse( $this->getRequestParams( $refund ) );
	}

	/**
	 * @param Cancel $cancel
	 * @return CancelResponse
	 * @throws InvalidConfigException
	 */
	public function cancel( Cancel $cancel ) : CancelResponse
	{
		return new CancelResponse( $this->getRequestParams( $cancel ) );
	}

	/**
	 * @param Close $close
	 * @return CloseResponse
	 * @throws InvalidConfigException
	 */
	public function close( Close $close ) : CloseResponse
	{
		return new CloseResponse( $this->getRequestParams( $close ) );
	}

	/**
	 * @param Download $download
	 * @return DownloadResponse
	 * @throws InvalidConfigException
	 */
	public function download( Download $download ) : DownloadResponse
	{
		return new DownloadResponse( $this->getRequestParams( $download ) );
	}

	/**
	 * Verify sign.
	 * @param array       $data
	 * @param bool        $sync
	 * @param string|null $sign
	 * @throws InvalidConfigException
	 *
	 * @return bool
	 */
	public function verifySign( array $data, $sync = false, $sign = null ) : bool
	{
		$publicKey = $this->config->getPublicKey();
		if( is_null( $publicKey ) ){
			throw new InvalidConfigException( 'Missing Alipay Config -- [ali_public_key]' );
		}

		$string = new SplString( $publicKey );
		if( $string->endsWith( '.pem' ) ){
			$publicKey = openssl_pkey_get_public( $publicKey );
		} else{
			$publicKey = "-----BEGIN PUBLIC KEY-----\n".wordwrap( $publicKey, 64, "\n", true )."\n-----END PUBLIC KEY-----";
		}

		$sign = $sign ?? $data['sign'];

		$toVerify = $sync ? mb_convert_encoding( json_encode( $data, JSON_UNESCAPED_UNICODE ), 'gb2312', 'utf-8' ) : $this->getSignContent( $data );

		return openssl_verify( $toVerify, base64_decode( $sign ), $publicKey, OPENSSL_ALGO_SHA256 ) === 1;
	}

	/**
	 * @param NotifyRequest $request
	 * @return bool
	 * @throws InvalidConfigException
	 */
	public function verify( NotifyRequest $request ) : bool
	{
		$data = $request->toArray();
		if( isset( $data['fund_bill_list'] ) ){
			$data['fund_bill_list'] = htmlspecialchars_decode( $data['fund_bill_list'] );
		}

		return $this->verifySign( $data );
	}

	/**
	 * success string to alipay.
	 *
	 * @return string
	 */
	public static function success() : string
	{
		return 'success';
	}

	/**
	 * fail string to alipay.
	 *
	 * @return string
	 */
	public static function fail() : string
	{
		return 'failure';
	}

	/**
	 * Get signContent that is to be signed.
	 *
	 *
	 * @param array $params
	 * @return string
	 */
	private function getSignContent( array $params ) : string
	{
		ksort( $params );
		$stringToBeSigned = "";
		$i                = 0;
		foreach( $params as $k => $v ){
			if( $k == 'sign' ){
				continue;
			}
			if( false === $this->checkEmpty( $v ) && "@" != substr( $v, 0, 1 ) ){
				if( $i == 0 ){
					$stringToBeSigned .= "$k"."="."$v";
				} else{
					$stringToBeSigned .= "&"."$k"."="."$v";
				}
				$i ++;
			}
		}
		return $stringToBeSigned;
	}

	/**
	 * Generate sign.
	 *
	 *
	 * @param array $params
	 *
	 * @throws InvalidConfigException
	 *
	 * @return string
	 */
	private function generateSign( array $params ) : string
	{
		$privateKey = $this->config->getPrivateKey();
		if( is_null( $privateKey ) ){
			throw new InvalidConfigException( 'Missing Alipay Config -- [private_key]' );
		}
		$string = new SplString( $privateKey );
		if( $string->endsWith( '.pem' ) ){
			$privateKey = openssl_pkey_get_private( $privateKey );
		} else{
			$privateKey = "-----BEGIN RSA PRIVATE KEY-----\n".wordwrap( $privateKey, 64, "\n", true )."\n-----END RSA PRIVATE KEY-----";
		}
		openssl_sign( $this->getSignContent( $params ), $sign, $privateKey, OPENSSL_ALGO_SHA256 );
		$sign = base64_encode( $sign );
		return $sign;
	}

	private function getSysParams() : array
	{
		$sysParams                   = [];
		$sysParams["app_id"]         = $this->config->getAppId();
		$sysParams["version"]        = $this->config->getApiVersion();
		$sysParams["format"]         = $this->config->getFormat();
		$sysParams["sign_type"]      = $this->config->getSignType();
		$sysParams["timestamp"]      = date( "Y-m-d H:i:s" );
		$sysParams["return_url"]     = $this->config->getReturnUrl();
		$sysParams["notify_url"]     = $this->config->getNotifyUrl();
		$sysParams["charset"]        = $this->config->getCharset();
		$sysParams["app_auth_token"] = $this->config->getAppAuthToken();
		return (new Base( $sysParams ))->toArray();
	}

	private function checkEmpty( $value )
	{
		if( !isset( $value ) )
			return true;
		if( $value === null )
			return true;
		if( trim( $value ) === "" )
			return true;
		return false;
	}

	/**
	 * @param mixed $request
	 * @return array
	 * @throws InvalidConfigException
	 */
	private function getRequestParams( $request ) : array
	{
		$array                = $request->toArray() + $this->getSysParams();
		$array['biz_content'] = json_encode( $array, JSON_UNESCAPED_UNICODE );
		$array['sign']        = $this->generateSign( $array );
		return $array;
	}

	/**
	 * @param array $data
	 * @return SplArray
	 * @throws InvalidConfigException
	 * @throws GatewayException
	 * @throws InvalidSignException
	 */
	public function preQuest( array $data ) : SplArray
	{
		$response = HttpClient::post( $this->config->getGateWay(),'/gateway.do', $data );
		$result   = json_decode($response->getBody(), true );
		$method   = str_replace( '.', '_', $data['method'] ).'_response';
		if( !isset( $result['sign'] ) || $result[$method]['code'] != '10000' ){
			throw new GatewayException( 'Get Alipay API Error:'.$result[$method]['msg'].($result[$method]['sub_msg'] ?? '').($result[$method]['sub_code'] ?? ''), $result, $result[$method]['code'] );
		}
		if( $this->verifySign( $result[$method], true, $result['sign'] ) ){
			return new SplArray( $result[$method] );
		}
		throw new InvalidSignException( 'Alipay Sign Verify FAILED', $result );
	}
}
