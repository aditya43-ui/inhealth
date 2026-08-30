<?php

class BKRinciantagihapasiensudahlunasV extends RinciantagihapasiensudahlunasV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchByRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addCondition('ruanganpendaftaran_id = 18');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}