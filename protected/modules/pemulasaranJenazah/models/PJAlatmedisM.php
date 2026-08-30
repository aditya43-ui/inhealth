<?php
class PJAlatmedisM extends AlatmedisM
{
	public $jenisalatmedis_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('jenisalatmedis');
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('t.alatmedis_id = '.$this->alatmedis_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->jenisalatmedis_id)){
			$criteria->addCondition('t.jenisalatmedis_id = '.$this->jenisalatmedis_id);
		}
		if(!empty($this->alatmedis_noaset)){
			$criteria->addCondition('t.alatmedis_noaset = '.$this->alatmedis_noaset);
		}
		$criteria->compare('LOWER(t.alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(t.alatmedis_namalain)',strtolower($this->alatmedis_namalain),true);
		$criteria->compare('t.alatmedis_aktif',$this->alatmedis_aktif);
		$criteria->compare('LOWER(t.alatmedis_kode)',strtolower($this->alatmedis_kode),true);
		$criteria->compare('LOWER(t.alatmedis_format)',strtolower($this->alatmedis_format),true);
		$criteria->compare('LOWER(jenisalatmedis.jenisalatmedis_nama)',strtolower($this->jenisalatmedis_nama),true);

		$criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}