<?php

/**
 * This is the model class for table "jenisalatmedis_m".
 *
 * The followings are the available columns in table 'jenisalatmedis_m':
 * @property integer $jenisalatmedis_id
 * @property string $jenisalatmedis_nama
 * @property string $jenisalatmedis_namalain
 * @property boolean $jenisalatmedis_aktif
 */
class SAJenisalatsterilisasiM extends JenisalatmedisM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisalatmedisM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function attributeLabels()
	{
		return array(
			'jenisalatmedis_id' => 'ID',
			'jenisalatmedis_nama' => 'Nama jenis Alat Sterilisasi',
			'jenisalatmedis_namalain' => 'Nama Lainnya',
			'jenisalatmedis_aktif' => 'Aktif',
		);
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