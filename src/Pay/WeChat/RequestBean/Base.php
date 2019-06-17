<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-15
 * Time: 19:19
 */

namespace ESD\Plugins\Pay\WeChat\RequestBean;

use ESD\Plugins\Pay\Utility\Random;
use ESD\Plugins\Pay\Utility\SplBean;

/**
 * 支付公共参数
 * Class Base
 * @package ESD\Plugins\Pay\WeChat\RequestBean
 */
abstract class Base extends SplBean
{
    const FILTER_NOT_NULL = 1;
    const FILTER_NOT_EMPTY = 2;//0 不算empty
	// 基础支付参数
	protected $appid;
	protected $mch_id;
	protected $nonce_str;
	protected $sign;
	protected $sign_type;

	// 服务商支付参数
	protected $sub_appid;
	protected $sub_mch_id;
	protected $sub_openid;
	protected $notify_url;
    protected $mchid;
    protected $mch_appid;

    /**
	 * 初始化一个随机字符串供签名用
	 * @return void
	 */
	public function initialize(): void
	{
		if (empty($this->nonce_str)) {
			$this->nonce_str = Random::character(32);
		}
	}
    /**
     * 生成随机字符串 可用于生成随机密码等
     * @param int    $length   生成长度
     * @param string $alphabet 自定义生成字符集
     * @author : evalor <master@evalor.cn>
     * @return bool|string
     */
    static function character($length = 6, $alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789')
    {
        mt_srand();
        // 重复字母表以防止生成长度溢出字母表长度
        if ($length >= strlen($alphabet)) {
            $rate = intval($length / strlen($alphabet)) + 1;
            $alphabet = str_repeat($alphabet, $rate);
        }
        // 打乱顺序返回
        return substr(str_shuffle($alphabet), 0, $length);
    }
	/**
	 * 转为数组时过滤空值
	 * @param array|null $columns
	 * @param null $filter
	 * @return array
	 */
	public function toArray(array $columns = null, $filter = null): array
	{
		return parent::toArray(null, self::FILTER_NOT_NULL);
	}

	/**
	 * @return mixed
	 */
	public function getAppid()
	{
		return $this->appid;
	}

	/**
	 * @param mixed $appid
	 */
	public function setAppid($appid): void
	{
		$this->appid = $appid;
	}

	/**
	 * @return mixed
	 */
	public function getMchId()
	{
		return $this->mch_id;
	}

	/**
	 * @param mixed $mch_id
	 */
	public function setMchId($mch_id): void
	{
		$this->mch_id = $mch_id;
	}

    /**
 * @param mixed $mch_id
 */
    public function setOutMchId($mch_id): void
    {
        $this->mchid = $mch_id;
    }

	/**
	 * @return mixed
	 */
	public function getNonceStr()
	{
		return $this->nonce_str;
	}

	/**
	 * @param mixed $nonce_str
	 */
	public function setNonceStr($nonce_str): void
	{
		$this->nonce_str = $nonce_str;
	}

	/**
	 * @return mixed
	 */
	public function getSign()
	{
		return $this->sign;
	}

	/**
	 * @param mixed $sign
	 */
	public function setSign($sign): void
	{
		$this->sign = $sign;
	}

	/**
	 * @return mixed
	 */
	public function getSignType()
	{
		return $this->sign_type;
	}

	/**
	 * @param mixed $sign_type
	 */
	public function setSignType($sign_type): void
	{
		$this->sign_type = $sign_type;
	}

	/**
	 * @return mixed
	 */
	public function getSubAppid()
	{
		return $this->sub_appid;
	}

	/**
	 * @param mixed $sub_appid
	 */
	public function setSubAppid($sub_appid): void
	{
		$this->sub_appid = $sub_appid;
	}

	/**
	 * @return mixed
	 */
	public function getSubMchId()
	{
		return $this->sub_mch_id;
	}

	/**
	 * @param mixed $sub_mch_id
	 */
	public function setSubMchId($sub_mch_id): void
	{
		$this->sub_mch_id = $sub_mch_id;
	}

	/**
	 * @return mixed
	 */
	public function getSubOpenid()
	{
		return $this->sub_openid;
	}

	/**
	 * @param mixed $sub_openid
	 */
	public function setSubOpenid($sub_openid): void
	{
		$this->sub_openid = $sub_openid;
	}

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param mixed $notify_url
     */
    public function setNotifyUrl($notify_url): void
    {
        $this->notify_url = $notify_url;
    }

    /**
     * @param mixed $mch_appid
     */
    public function setMchAppid($mch_appid): void
    {
        $this->mch_appid = $mch_appid;
    }
}