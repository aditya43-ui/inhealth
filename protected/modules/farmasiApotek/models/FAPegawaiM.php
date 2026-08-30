<?php

class FAPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
    public $tempPhoto;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchByFilterDokter()
    {
            $criteria=new CDbCriteria;
            $criteria->addCondition('kelompokpegawai_id IN (1)');
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function searchByFilterKaryawan()
    {
            $criteria=new CDbCriteria;
            $criteria->addCondition('kelompokpegawai_id NOT IN (1)');
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
}