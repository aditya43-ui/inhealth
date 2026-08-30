<?php
/**
 * model ini digunakan untuk transaksi pesanan pasca anastesi
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.modules.anestesi
 * @subpackage models 
 */
class ATTerapipascaanastesiT extends TerapipascaanastesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerapipascaanastesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}