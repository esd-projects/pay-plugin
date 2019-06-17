<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/5/15
 * Time: 13:48
 */

namespace ESD\Plugins\Pay\exampleClass;

use ESD\Core\Server\Beans\Request;
use ESD\Core\Server\Beans\Response;
use ESD\Core\Server\Beans\WebSocketFrame;
use ESD\Core\Server\Port\ServerPort;
use ESD\Plugins\Pay\AliPay\RequestBean\Pos;
use ESD\Plugins\Pay\AliPay\RequestBean\Wap;
use ESD\Plugins\Pay\Exceptions\GatewayException;
use ESD\Plugins\Pay\Exceptions\InvalidArgumentException;
use ESD\Plugins\Pay\Exceptions\InvalidConfigException;
use ESD\Plugins\Pay\Exceptions\InvalidSignException;
use ESD\Plugins\Pay\GetPay;
use ESD\Plugins\Pay\WeChat\RequestBean\Transfer;


class TestPort extends ServerPort
{


    use GetPay;


    public function onTcpConnect(int $fd, int $reactorId)
    {
        // TODO: Implement onTcpConnect() method.
    }

    public function onTcpClose(int $fd, int $reactorId)
    {
        // TODO: Implement onTcpClose() method.
    }

    public function onWsClose(int $fd, int $reactorId)
    {
        // TODO: Implement onWsClose() method.
    }

    public function onTcpReceive(int $fd, int $reactorId, string $data)
    {
        // TODO: Implement onTcpReceive() method.
    }

    public function onUdpPacket(string $data, array $clientInfo)
    {
        // TODO: Implement onUdpPacket() method.
    }

    public function onHttpRequest(Request $request, Response $response)
    {


        // 支付宝刷卡测试
//        $aliPay = $this->getAliPay();
//        $order = new Pos();
//        $order->setSubject('测试');
//        $order->setTotalAmount('0.01');
//        $order->setOutTradeNo(time());
//        $order->setAuthCode('289756915257123456');
//        $data = $aliPay->pos($order)->toArray();
//        try {
//            $res = $aliPay->preQuest($data);
//        } catch (GatewayException $e) {
//            p($e->getMessage());
//        } catch (InvalidConfigException $e) {
//            p($e->getMessage());
//        } catch (InvalidSignException $e) {
//            p($e->getMessage());
//
//        }


//        // WAP支付
//        $order =new  Wap();
//        $order->setSubject('测试');
//        $order->setOutTradeNo(time().'123456');
//        $order->setTotalAmount('0.01');
//        $pay = $this->getAliPay();
//        $res = $pay->wap($order);
//        P($res->toArray());

        // 付款到微信零钱
        $order = new Transfer();
        $order->setOpenid('o4LXm5bHNOn2Kli36ofEKnu4fAAg');
        $order->setCheckName(Transfer::NOCHECK);
        $order->setAmount(100);
        $order->setDesc('说明文档');
        $order->setSpbillCreateIp("10.0.0.1");
        $order->setPartnerTradeNo('12312312312321');
        $order->setReUserName('张三');
        try {
            $data = $this->getWePay()->Transfer($order);
        } catch (GatewayException $e) {
            p($e->getMessage());
        } catch (InvalidArgumentException $e) {
            p($e->getMessage());
        } catch (InvalidSignException $e) {
            p($e->getMessage());
        }

//        $pay = $this->getWePay();
//              // 公众号支付
//        $officialAccount = new OfficialAccount();
//        $officialAccount->setOpenid('xxxxxxx');
//        $officialAccount->setOutTradeNo('CN' . date('YmdHis') . rand(1000, 9999));
//        $officialAccount->setBody('xxxxx-测试');
//        $officialAccount->setTotalFee(1);
//        $officialAccount->setMchId("123123123");
//        $officialAccount->setSpbillCreateIp('xxxxx');
//        $pay = $this->getWePay();
//        $params = $pay->officialAccount($officialAccount);

        /*
                扫码支付测试
                     $param = new ScanRequest();
                $param->setName('哈哈测试');
                $param->setId('222');
                $param->setAddress('10.0.0.1');
                $param->setAttach('attach');
                $param->setOpenid('213231231232');
                $param->setTotalFee(100);
                $param->setId('222');
                try {
                    $payconfig = $pay->scan($param);
                } catch (GatewayException $e) {
                    p($e->getMessage());
                } catch (InvalidArgumentException $e) {
                } catch (InvalidSignException $e) {
                }
        */


        /*
     支付回调验证
        try {
           $data = $pay->verify('<xml>  </xml>');
       } catch (InvalidArgumentException $e) {
           p("非法参数".$e->getMessage());
       } catch (InvalidSignException $e) {
           p("签名错误".$e->getMessage());
       }*/


    }

    public function onWsMessage(WebSocketFrame $frame)
    {
        // TODO: Implement onWsMessage() method.
    }

    public function onWsPassCustomHandshake(Request $request): bool
    {
        // TODO: Implement onWsPassCustomHandshake() method.
    }

    public function onWsOpen(Request $request)
    {
        // TODO: Implement onWsOpen() method.
    }
}