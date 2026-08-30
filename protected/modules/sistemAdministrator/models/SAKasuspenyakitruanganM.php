<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SAKasuspenyakitruanganM extends KasuspenyakitruanganM {

	public $jeniskasuspenyakit_nama,$jeniskasuspenyakit_namalainnya;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTabelPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$sessionruangan = Yii::app()->user->ruangan_id;
		$criteria=new CDbCriteria;
		$criteria->with=array('ruangan','jeniskasuspenyakit');
		$criteria->order = 't.ruangan_id';
		if (Yii::app()->controller->module->id =='sistemAdministrator') {
			$ruanganLab = array(Params::RUANGAN_ID_LAB_KLINIK,Params::RUANGAN_ID_LAB_ANATOMI,Params::RUANGAN_ID_LAB);
			$criteria->addInCondition('t.ruangan_id',$ruanganLab);
		}else{
			$criteria->compare('t.ruangan_id',$sessionruangan);
		}   
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_namalainnya)',strtolower($this->jeniskasuspenyakit_namalainnya),true);
		$criteria->order = 't.ruangan_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}

?>
