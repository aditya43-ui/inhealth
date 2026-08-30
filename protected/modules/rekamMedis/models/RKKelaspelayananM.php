<?php

class RKKelaspelayananM extends KelaspelayananM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelaspelayananM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('kelaspelayanan_aktif = TRUE');
		$criteria->order = 'kelaspelayanan_nama ASC';
		$model = $this->model()->findAll($criteria);
		if(count((array)$model) > 0){
			return $model;
		}else{
			return array();
		}
	}
}