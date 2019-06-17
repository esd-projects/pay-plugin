<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 11:40
 */

namespace ESD\Plugins\Pay\WeChat;

use ESD\Plugins\Pay\Config\WeChatPayConfig;
use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;


use ESD\Plugins\Pay\Utility\SplArray;
use ESD\Plugins\Pay\WeChat\RequestBean\MiniProgram as MiniProgramRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\OfficialAccount as OfficialAccountRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Scan as ScanRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Transfer as TransferRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Wap as WapRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\App as AppRequest;

use ESD\Plugins\Pay\WeChat\RequestBean\OrderFind as OrderFindRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\RefundFind as RefundFindRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Close as CloseRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Refund as RefundRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Download as DownloadRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\DownloadFundFlow as DownloadFundFlowRequest;
use ESD\Plugins\Pay\WeChat\RequestBean\Comment as CommentRequest;


use ESD\Plugins\Pay\WeChat\ResponseBean\OfficialAccount as OfficialAccountResponse;
use ESD\Plugins\Pay\WeChat\ResponseBean\Wap as WapResponse;
use ESD\Plugins\Pay\WeChat\ResponseBean\Scan as ScanResponse;
use ESD\Plugins\Pay\WeChat\ResponseBean\MiniProgram  as MiniProgramResponse;
use ESD\Plugins\Pay\WeChat\ResponseBean\App  as AppResponse;
use ESD\Plugins\Pay\WeChat\ResponseBean\Transfer as TransferResponse;
use ESD\Plugins\Pay\WeChat\WeChatPay\MiniProgram;
use ESD\Plugins\Pay\WeChat\WeChatPay\OfficialAccount;
use ESD\Plugins\Pay\WeChat\WeChatPay\Scan;
use ESD\Plugins\Pay\WeChat\WeChatPay\Transfer;
use ESD\Plugins\Pay\WeChat\WeChatPay\Wap;
use ESD\Plugins\Pay\WeChat\WeChatPay\App;

/**
 * Class WeChat
 * @package ESD\Plugins\Pay\WeChat
 *
 */
class WeChat
{
	private $config;

	function __construct(WeChatPayConfig $config)
	{
		$this->config = $config;
	}

    /**
     * 公众号支付
     * @param OfficialAccountRequest $bean
     * @return OfficialAccountResponse
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     */
	public function officialAccount(OfficialAccountRequest $bean): OfficialAccountResponse
	{
		return (new OfficialAccount($this->config))->pay($bean);
	}

	/**
	 * H5支付
	 * @param WapRequest $bean
	 * @return WapResponse
	 * @throws GatewayException
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function wap(WapRequest $bean): WapResponse
	{
		return (new Wap($this->config))->pay($bean);
	}

    /**
     * 小程序支付
     * @param MiniProgramRequest $bean
     * @return MiniProgramResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
	public function miniProgram(MiniProgramRequest $bean): MiniProgramResponse
	{
		return (new MiniProgram($this->config))->pay($bean);
	}


    /**
     * app支付
     * @param AppRequest $bean
     * @return AppResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
	public function app(AppRequest $bean): AppResponse
	{
		return (new App($this->config))->pay($bean);
	}

    /**
     * 扫码支付
     * @param ScanRequest $bean
     * @return ResponseBean\Scan
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
	public function scan(ScanRequest $bean): ScanResponse
	{
		return (new Scan($this->config))->pay($bean);
	}

	/**
	 * 订单查询
	 * @param OrderFindRequest $bean
	 * @return SplArray
	 * @throws GatewayException
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function orderFind(OrderFindRequest $bean): SplArray
	{
		return (new Utility($this->config))->requestApi('/pay/orderquery', $bean);
	}

	/**
	 * 退款查询
	 * @param RefundFindRequest $bean
	 * @return SplArray
	 * @throws GatewayException
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function refundFind(RefundFindRequest $bean): SplArray
	{
		return (new Utility($this->config))->requestApi('/pay/refundquery', $bean);
	}

	/**
	 * 关闭订单
	 * @param CloseRequest $bean
	 * @return SplArray
	 * @throws GatewayException
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function close(CloseRequest $bean): SplArray
	{
		return (new Utility($this->config))->requestApi('/pay/closeorder', $bean);
	}

	/**
	 * 申请退款
	 * @param RefundRequest $bean
	 * @return SplArray
	 * @throws GatewayException
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function refund(RefundRequest $bean): SplArray
	{
		return (new Utility($this->config))->requestApi('/secapi/pay/refund', $bean, true);
	}

	/**
	 * 下载对账单
	 * @param DownloadRequest $bean
	 * @return string
	 * @throws GatewayException
	 */
	public function download(DownloadRequest $bean): string
	{
		return (new Utility($this->config))->request('/pay/downloadbill', $bean);
	}

	/**
	 * 下载资金对账单
	 * @param DownloadFundFlowRequest $bean
	 * @return string
	 * @throws GatewayException
	 */
	public function downloadFundFlow(DownloadFundFlowRequest $bean): string
	{
		return (new Utility($this->config))->request('/pay/downloadfundflow', $bean, true);
	}

	/**
	 * 拉取订单评价数据(ps:测试未成功)
	 * @param CommentRequest $bean
	 * @return string
	 * @throws GatewayException
	 */
	public function comment(CommentRequest $bean): string
	{
		return (new Utility($this->config))->request('/billcommentsp/batchquerycomment', $bean, true);
	}


    /**
     * 微信付款到零钱
     * @param TransferRequest $bean
     * @return TransferResponse
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function Transfer(TransferRequest $bean):TransferResponse
    {
        return (new Transfer($this->config))->payOut($bean);
    }

	/**
	 * 结果返回给微信服务器
	 * @return string
	 */
	public static function success(): string
	{
		return (new SplArray(['return_code' => 'SUCCESS', 'return_msg' => 'OK']))->toXML();
	}

	/**
	 * 结果返回给微信服务器
	 * @return string
	 */
	public static function fail(): string
	{
		return (new SplArray(['return_code' => 'FAIL', 'return_msg' => 'FAIL']))->toXML();
	}

	/**
	 * 支付或退款异步通知签名校验
	 * @param null $content
	 * @param bool $refund
	 * @return SplArray
	 * @throws InvalidSignException
	 * @throws InvalidArgumentException
	 */
	public function verify($content = null, $refund = false): SplArray
	{
		$utility = new Utility($this->config);
		$data = $utility->fromXML($content);
		if ($refund) {
			$decrypt_data = $utility->fromXML($utility->decryptRefundContents($data['req_info']));
			$data = array_merge($decrypt_data, $data);
		}
		if ($refund || (isset($data['sign']) && $utility->generateSign($data) === $data['sign'])) {
			return new SplArray($data);
		}
		throw new InvalidSignException('Wechat Sign Verify FAILED', json_encode($data));
	}

}