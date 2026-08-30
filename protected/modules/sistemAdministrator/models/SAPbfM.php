<?php

/**
 * This is the model class for table "pbf_m".
 *
 * The followings are the available columns in table 'pbf_m':
 * @property integer $pbf_id
 * @property string $pbf_kode
 * @property string $pbf_nama
 * @property string $pbf_singkatan
 * @property string $pbf_alamat
 * @property string $pbf_propinsi
 * @property string $pbf_kabupaten
 * @property boolean $pbf_aktif
 */
class SAPbfM extends PbfM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PbfM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPrint()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pbf_id)){
			$criteria->addCondition('pbf_id = '.$this->pbf_id);
		}
		$criteria->compare('LOWER(pbf_kode)',strtolower($this->pbf_kode),true);
		$criteria->compare('LOWER(pbf_nama)',strtolower($this->pbf_nama),true);
		$criteria->compare('LOWER(pbf_singkatan)',strtolower($this->pbf_singkatan),true);
		$criteria->compare('LOWER(pbf_alamat)',strtolower($this->pbf_alamat),true);
		$criteria->compare('LOWER(pbf_propinsi)',strtolower($this->pbf_propinsi),true);
		$criteria->compare('LOWER(pbf_kabupaten)',strtolower($this->pbf_kabupaten),true);
		$criteria->compare('pbf_aktif',isset($this->pbf_aktif)?$this->pbf_aktif:true);
//		$criteria->compare('pbf_aktif',$this->pbf_aktif);
		$criteria->order='pbf_nama asc';
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
        
       
}