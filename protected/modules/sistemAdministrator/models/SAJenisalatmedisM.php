<?php

class SAJenisalatmedisM extends JenisalatmedisM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganpegawaiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisalatmedis_id',$this->jenisalatmedis_id);
		$criteria->compare('LOWER(jenisalatmedis_nama)',strtolower($this->jenisalatmedis_nama),true);
		$criteria->compare('LOWER(jenisalatmedis_namalain)',strtolower($this->jenisalatmedis_namalain),true);
		$criteria->compare('jenisalatmedis_aktif',isset($this->jenisalatmedis_aktif)?$this->jenisalatmedis_aktif:true);
		$criteria->addCondition('jenisalatmedis_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}