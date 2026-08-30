<?php

class PPKecamatanM extends KecamatanM {

	public $propinsi_id;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('LOWER(kecamatan_namalainnya)',strtolower($this->kecamatan_namalainnya),true);
		$criteria->compare('kecamatan_aktif',isset($this->kecamatan_aktif)?$this->kecamatan_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('LOWER(kecamatan_namalainnya)',strtolower($this->kecamatan_namalainnya),true);
		$criteria->compare('kecamatan_aktif',isset($this->kecamatan_aktif)?$this->kecamatan_aktif:true);
		$criteria->order = 'kecamatan_id';
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				 'pagination'=>false,
		));
	}

}