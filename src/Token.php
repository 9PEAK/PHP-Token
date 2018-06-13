<?php

namespace Peak;

/**
 * Token基础功能
 * 制作、验证token
 * @ 开发 kane
 */

class Token {

	/**
	 * 字符串连接符
	 * */
	protected static $param_glue = '&';

	static function setGlue ($glue)
	{
		if ( $glue ) {
			self::$param_glue = $glue;
		}
	}


	protected static $encode_func = 'md5';

	/**
	 * 检测是否是允许的加密方式
	 * */
	static function setEncodeType ($type)
	{
		self::$encode_func = $type;
//		return in_array($type, self::$encode_func);
	}



	/**
	 * [底层] 加密预处理参数
	 * */
	protected static function init_param (array $param)
	{
		ksort($param);
		foreach ( $param as $k=>&$v ) {
			$v = $k.'='.$v ;
		}
		return $param;
	}

	/**
	 * [底层] 将参数组合成字符串编码
	 * */
	protected static function glue_param (array $param)
	{
		return join(self::$param_glue, self::init_param($param));
	}


	/**
	 * 生成密码
	 * */
	static function encode (array $param)
	{
		$func = self::$encode_func ;
		return $func(self::glue_param($param));
	}


	/**
	 * 验证编码是否正确
	 * */
	static function verify (array $param, $str)
	{
		return $str==self::encode($param);
	}


}
