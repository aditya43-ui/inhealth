<?php

/**
 * This is the model class for table "formasishift_m".
 *
 * The followings are the available columns in table 'formasishift_m':
 * @property integer $formasishift_id
 * @property integer $ruangan_id
 * @property integer $shift_id
 * @property integer $jmlformasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $formasishift_aktif
 */
class SAFormasishiftM extends FormasishiftM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormasishiftM the static model class
	 */
	public $instalasi_id, $ruangan_nama, $shift_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search2(){
		$criteria=new CDbCriteria;
		$criteria->with = array('ruangan','shift');
		if(!empty($this->formasishift_id)){
			$criteria->addCondition('formasishift_id = '.$this->formasishift_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->jmlformasi)){
			$criteria->addCondition('jmlformasi = '.$this->jmlformasi);
		}
		$criteria->compare('LOWER(shift.shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('formasishift_aktif',isset($this->formasishift_aktif)?$this->formasishift_aktif:true);
		
		return $criteria;
	}
	
	public function searchTabel(){
		$criteria=$this->search2();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint2(){
		$criteria=$this->search2();
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	} 
}