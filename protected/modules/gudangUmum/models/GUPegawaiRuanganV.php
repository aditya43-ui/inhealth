<?php

class GUPegawaiRuanganV extends PegawairuanganV
{       
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
                }
    
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;            
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin),TRUE);
                $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai),TRUE);
                $criteria->compare('LOWER(alamat_pegawai)', strtolower($this->alamat_pegawai),TRUE);
                $criteria->compare('LOWER(agama)', strtolower($this->agama),TRUE);
                $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),TRUE);
                $criteria->compare('ruangan_id',Yii::app()->user->ruangan_id);
                if (!empty($this->jabatan_id)){
                    $criteria->addCondition("jabatan_id = '".$this->jabatan_id."' ");
                }
                $criteria->order = "nama_pegawai, nomorindukpegawai ASC";
		//$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}

}