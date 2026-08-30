<?php
class INInfokunjunganrjV  extends InfokunjunganrjV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrjV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRJ()
        {
            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            if(!empty($this->ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }
            if(!empty($this->pegawai_id)){
                $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
            }
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
            $criteria->addCondition('no_urutantri IS NOT NULL');
            $criteria->order = 'no_urutantri';
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function getRuangan(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_id ='.Params::INSTALASI_ID_RJ);
            $criteria->addCondition('ruangan_aktif = TRUE');
            $criteria->order = 'ruangan_nama';
            return RuanganM::model()->findAll($criteria);
        }
        
        /**
         * Menampilkan data status kamar dari lookup_m
         */
        public function getStatusPeriksa()
        {
            return LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperiksa', 'lookup_aktif'=>true),array('order'=>'lookup_urutan'));
        }
}

