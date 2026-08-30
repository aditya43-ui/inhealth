<?php

/**
 * This is the model class for table "klasifikasidiagnosa_m".
 *
 * The followings are the available columns in table 'klasifikasidiagnosa_m':
 * @property integer $klasifikasidiagnosa_id
 * @property string $klasifikasidiagnosa_kode
 * @property string $klasifikasidiagnosa_nama
 * @property string $klasifikasidiagnosa_namalain
 * @property boolean $klasifikasidiagnosa_aktif
 * @property string $klasifikasidiagnosa_desc
 *
 * The followings are the available model relations:
 * @property DiagnosaM[] $diagnosaMs
 */
class SAKlasifikasidiagnosaM extends KlasifikasidiagnosaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasidiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * untuk dropdown
	 */
	public function getDropdownItems(){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->addCondition("klasifikasidiagnosa_aktif = TRUE");
		$criteria->order = "klasifikasidiagnosa_kode, klasifikasidiagnosa_nama";
		$models = self::model()->findAll($criteria);
		if(count((array)$models) > 0){
			$data = CHtml::listData($models, 'klasifikasidiagnosa_id', 'KlasifikasiKodeNama');
		}
		return $data;
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition('klasifikasidiagnosa_id = '.$this->klasifikasidiagnosa_id);
		}
		$criteria->compare('LOWER(klasifikasidiagnosa_kode)',strtolower($this->klasifikasidiagnosa_kode),true);
		$criteria->compare('LOWER(klasifikasidiagnosa_nama)',strtolower($this->klasifikasidiagnosa_nama),true);
		$criteria->compare('LOWER(klasifikasidiagnosa_namalain)',strtolower($this->klasifikasidiagnosa_namalain),true);
		$criteria->compare('klasifikasidiagnosa_aktif',isset($this->klasifikasidiagnosa_aktif)?$this->klasifikasidiagnosa_aktif:true);
		$criteria->compare('LOWER(klasifikasidiagnosa_desc)',strtolower($this->klasifikasidiagnosa_desc),true);
                $criteria->order = "klasifikasidiagnosa_kode ASC";

		return $criteria;
	}
        
        

}