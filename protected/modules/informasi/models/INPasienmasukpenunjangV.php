<?php

class INPasienmasukpenunjangV  extends PasienmasukpenunjangV
{
        public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchMP(){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(statusperiksa)',  strtolower($this->statusperiksa),true);
            $criteria->compare("DATE(tglmasukpenunjang)", date("Y-m-d"));
            if (!empty($this->instalasi_id)){
                $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
            }
            if (!empty($this->ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }
            if (!empty($this->pegawai_id)){
                $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
            }
            $criteria->addCondition('no_urutperiksa IS NOT NULL');
            $criteria->order = 'no_urutperiksa';
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria, 
            ));
            
        }
        
        
        public function getInstalasi(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasirujukaninternal = TRUE');
            $criteria->order = 'instalasi_nama';
            return InstalasiM::model()->findAll($criteria);
        }
        
        /**
         * Menampilkan data status kamar dari lookup_m
         */
        public function getStatusPeriksaLookUp()
        {
            return LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperiksa', 'lookup_aktif'=>true),array('order'=>'lookup_urutan'));
        }
        
        
}