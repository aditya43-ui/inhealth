<?php


class RKInfoGabungBerkasRMV extends MergerekammedikR
{	
        public $tgl_awal, $tgl_akhir, $no_rekam_medik_lama, $no_rekam_medik_baru, $nama_pasien_lama, $nama_pasien_baru;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi(){          	
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(tglmerge)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->with = array('pasienlama','pasienbaru');

            if (!empty($this->pasienlama_id)){
                $criteria->addCondition(" pasienlama_id = '".$this->pasienlama_id."' ");
            } 
            $criteria->compare('LOWER(pasienlama.no_rekam_medik)',strtolower($this->no_rekam_medik_lama),true);
            $criteria->compare('LOWER(pasienbaru.no_rekam_medik)',strtolower($this->no_rekam_medik_baru),true);
            $criteria->compare('LOWER(pasienlama.nama_pasien)',strtolower($this->nama_pasien_lama),true);
            $criteria->compare('LOWER(pasienbaru.nama_pasien)',strtolower($this->nama_pasien_baru),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
        
        public function getLoginpemakaiItems($id)
        {
            $hasil ='';
            $a = LoginpemakaiK::model()->findByAttributes(array( 'loginpemakai_id'=>$id)); 
            
            if(isset ($a)){
                $pegawai_nama = PegawaiM::model()->findByAttributes(array(
                'pegawai_id'=>$a->pegawai_id,
            )); 
                $hasil = $pegawai_nama->nama_pegawai;
            }
            return $hasil;
        }
}