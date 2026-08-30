<?php

class FAFormulariumobatM extends FormulariumobatM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $carabayar_nama, $penjamin_nama, $obatalkes_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	/**
	 * Mengambil daftar semua penjamin
	 * @return CActiveDataProvider 
	 */
	public static function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
				return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
				return array();
	}
}