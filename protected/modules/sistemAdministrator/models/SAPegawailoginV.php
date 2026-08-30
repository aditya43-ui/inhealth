<?php

class SAPegawailoginV extends PegawailoginV
{
    public $tgl_awal, $tgl_akhir;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
    public function searchInformasi()
    {
		 // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(lastlogin)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('instalasi_nama',$this->instalasi_nama,true);
        $criteria->compare('ruangan_nama',$this->ruangan_nama,true);
        $criteria->compare('modul_nama',$this->modul_nama,true);
        $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
        $criteria->compare('lower(nama_pemakai)', strtolower($this->nama_pemakai),true);
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchPrintInformasi()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(lastlogin)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('instalasi_nama',$this->instalasi_nama,true);
        $criteria->compare('ruangan_nama',$this->ruangan_nama,true);
        $criteria->compare('modul_nama',$this->modul_nama,true);
        $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
        $criteria->compare('lower(nama_pemakai)', strtolower($this->nama_pemakai),true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
}