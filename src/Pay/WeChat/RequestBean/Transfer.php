<?php
/**
 *
 * Copyright  EasySwoole
 * User: hanwenbo
 * Date: 2019-02-17
 * Time: 13:24
 *
 */

namespace ESD\Plugins\Pay\WeChat\RequestBean;


class Transfer extends Base
{

    const NOCHECK = 'NO_CHECK';
    const FORCE_CHECK = 'FORCE_CHECK';

	/**
	 * @var string
	 */
	protected $partner_trade_no;   //商户订单号
	/**
	 * @var string
	 */
	protected $openid;  //收款人的openid


    protected $re_user_name;

    protected $spbill_create_ip;

	/**
	 * @var string
	 */
	protected $check_name;  //NO_CHECK：不校验真实姓名\FORCE_CHECK：强校验真实姓名
	// 're_user_name'=>'张三',       //check_name为 FORCE_CHECK 校验实名的时候必须提交
	/**
	 * @var string
	 */
	protected $amount;  //企业付款金额，单位为分
	/**
	 * @var string
	 */
	protected $desc;

    /**
     * @return string
     */
    public function getPartnerTradeNo(): string
    {
        return $this->partner_trade_no;
    }

    /**
     * @param string $partner_trade_no
     */
    public function setPartnerTradeNo(string $partner_trade_no): void
    {
        $this->partner_trade_no = $partner_trade_no;
    }

    /**
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getCheckName(): string
    {
        return $this->check_name;
    }

    /**
     * @param string $check_name
     */
    public function setCheckName(string $check_name): void
    {
        $this->check_name = $check_name;
    }

    /**
     * @return string
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getReUserName()
    {
        return $this->re_user_name;
    }

    /**
     * @param mixed $re_user_name
     */
    public function setReUserName($re_user_name): void
    {
        $this->re_user_name = $re_user_name;
    }


    /**
     * @param mixed $spbill_create_ip
     */
    public function setSpbillCreateIp($spbill_create_ip): void
    {
        $this->spbill_create_ip = $spbill_create_ip;
    } //企业付款金额，单位为分

}