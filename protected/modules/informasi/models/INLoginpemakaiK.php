<?php

class INLoginpemakaiK extends LoginpemakaiK
{
    public $tgl_awal, $tgl_akhir, $no_rekam_medik, $tgl_rekam_medik, $nama_pasien, $jeniskelamin, $tempat_lahir, $tanggal_lahir, $alamat_pasien;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
                $criteria=new CDbCriteria;
                $criteria->select = "pasien.pasien_id, pasien.no_rekam_medik, pasien.tgl_rekam_medik, pasien.nama_pasien, pasien.jeniskelamin, pasien.tempat_lahir, pasien.tanggal_lahir, pasien.alamat_pasien";
                $criteria->join = " JOIN pasien_m as pasien ON pasien.pasien_id = t.pasien_id";
                
                $criteria->addBetweenCondition('DATE(pasien.tgl_rekam_medik)',$this->tgl_awal,$this->tgl_akhir,true);
                
                $criteria->addCondition("pasien.pasien_id is not null"); 
                $criteria->addCondition("t.is_email =  true OR t.is_phonenumber = true"); 
                $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
                
                $criteria->limit = 10;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}