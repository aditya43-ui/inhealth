<?php

/** 
 * @author Muhammad Iqbal Laksana  <iqbal.laksana@piindonesia.co.id>
 * @package generate token reset password
 * @verion 1
 */
class GenerateTokenPass{
	
	public static function generateRandomBase62String($length)
	{
		$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
		shuffle($chars);
		$result = implode(array_slice($chars, 0, $length));
		return substr($result, 0, $length);
	}
}

