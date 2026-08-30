<?php

/**
 * This is the model class for table "lokasipenyimpanan_m".
 *
 * The followings are the available columns in table 'lokasipenyimpanan_m':
 * @property integer $lokasipenyimpanan_id
 * @property integer $instalasi_id
 * @property string $lokasipenyimpanan_kode
 * @property string $lokasipenyimpanan_nama
 * @property string $lokasipenyimpanan_namalain
 * @property boolean $lokasipenyimpanan_aktif
 */
class SALokasipenyimpananM extends LokasipenyimpananM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasipenyimpananM the static model class
	 */
	public $instalasi_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getInstalasiItems()
		{
			 return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama ASC');
		}
	public function searchLokasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(lokasipenyimpanan_kode)',strtolower($this->lokasipenyimpanan_kode),true);
		$criteria->compare('LOWER(lokasipenyimpanan_nama)',strtolower($this->lokasipenyimpanan_nama),true);
		$criteria->compare('LOWER(lokasipenyimpanan_namalain)',strtolower($this->lokasipenyimpanan_namalain),true);
		$criteria->compare('lokasipenyimpanan_aktif',isset($this->lokasipenyimpanan_aktif)?$this->lokasipenyimpanan_aktif:true);
		
		//if(!isset($this->lokasipenyimpanan_aktif)){
			//$criteria->addCondition('lokasipenyimpanan_aktif is true');
		//}
		$criteria->limit= 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}