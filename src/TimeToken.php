<?php

namespace Peak;

/**
 * Token高级功能
 * 用于服务器间的身份验证
 * @ 开发 kane
 */

class TimeToken extends Token {

	// 设置时间戳的key
	private static $key = 'timestamp';
	private static $time;
	
	function __construct($key=null, $glue='')
	{
		$key && self::$key = $key;
		self::setGlue($glue);
		self::$time = time();
	}


	public function time()
	{
		return self::$time;
	}

	/**
	 * 生成token签名
	 * */
	public function sign($param)
	{
		@$param[self::$key] || $param[self::$key] = self::$time;
		return parent::encode($param);
	}


	/**
	 * 输出拼接字符串
	 * */
	public function signToArray($param, $key='token', array $hiddenKey=[])
	{
		@$param[self::$key] || $param[self::$key] = self::$time;
		foreach ($param as $key=>&$val) {
			if (in_array($key, $hiddenKey)) {
				unset($param[$key]);
			}
		}
		return $param;
	}


	public function signToQueryString ($param, $key='token', $hiddenKey=[])
	{
		return self::glue_param($this->signToArray($param, $key, $hiddenKey));
	}

	/**
	 * 检测是否超时
	 * @param $param
	 * @param $exp 超时秒数
	 * */
	public function validate(array $param, $str, $exp=6):bool
	{
		if ( self::$time>$param[self::$key]+$exp) {
			return false;
		}
		return self::verify($param, $str);
	}

}


?>