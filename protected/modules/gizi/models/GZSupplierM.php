<?php

class GZSupplierM extends SupplierM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* Mengambil daftar semua carabayar
	* @return CActiveDataProvider 
	*/
	public function getPropinsiItems()
	{
	   return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
	}
	/**
	* Mengambil daftar semua penjamin
	* @return CActiveDataProvider 
	*/
	public function getkabupatenItems($propinsi_id=null)
	{
		if(!empty($propinsi_id)){
			return KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true),array('order'=>'kabupaten_nama'));
		}else{
			return array();
		}
	}

}