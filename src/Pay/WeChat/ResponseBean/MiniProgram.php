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

class MiniProgram extends SplBean
{
    protected $appId;
    protected $timeStamp;
    protected $nonceStr;
    protected $package;
    protected $signType;
    protected $paySign;

    public function setPaySign(string $paySign): void
    {
        $this->paySign = $paySign;
    }

    public function initialize(): void
    {
        if (empty($this->nonceStr)) {
            $this->nonceStr = Random::character(32);
        }
        if (empty($this->timeStamp)) {
            $this->timeStamp = strval(time());
        }
    }
}