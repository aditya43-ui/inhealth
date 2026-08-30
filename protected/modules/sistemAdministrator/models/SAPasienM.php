<?php

class SAPasienM extends PasienM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CdbCriteria that can return criterias.
    */
    public function searchDialog()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $format = new MyFormatter();
            $criteria=new CDbCriteria;
			
			if (!empty($this->pasien_id)){
				$criteria->addCondition('t.pasien_id ='.$this->pasien_id);
			}
			if (!empty($this->kelompokumur_id)){
				$criteria->addCondition('t.kelompokumur_id ='.$this->kelompokumur_id);
			}
			if (!empty($this->kecamatan_id)){
				$criteria->addCondition('t.kecamatan_id ='.$this->kecamatan_id);
			}
			if (!empty($this->pendidikan_id)){
				$criteria->addCondition('t.pendidikan_id ='.$this->pendidikan_id);
			}
			if (!empty($this->profilrs_id)){
				$criteria->addCondition('t.profilrs_id ='.$this->profilrs_id);
			}
			if (!empty($this->kelurahan_id)){
				$criteria->addCondition('t.kelurahan_id ='.$this->kelurahan_id);
			}
			if (!empty($this->loginpemakai_id)){
				$criteria->addCondition('t.loginpemakai_id ='.$this->loginpemakai_id);
			}
			if (!empty($this->suku_id)){
				$criteria->addCondition('t.suku_id ='.$this->suku_id);
			}
			if (!empty($this->pekerjaan_id)){
				$criteria->addCondition('t.pekerjaan_id ='.$this->pekerjaan_id);
			}
			if (!empty($this->kabupaten_id)){
				$criteria->addCondition('t.kabupaten_id ='.$this->kabupaten_id);
			}
			if (!empty($this->propinsi_id)){
				$criteria->addCondition('t.propinsi_id ='.$this->propinsi_id);
			}
			if (!empty($this->dokrekammedis_id)){
				$criteria->addCondition('t.dokrekammedis_id ='.$this->dokrekammedis_id);
			}
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
            $criteria->compare('LOWER(t.jenisidentitas)',strtolower($this->jenisidentitas),true);
            $criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('t.rt',$this->rt);
            $criteria->compare('t.rw',$this->rw);
            $criteria->compare('LOWER(t.statusperkawinan)',strtolower($this->statusperkawinan),true);
            $criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
            $criteria->compare('LOWER(t.rhesus)',strtolower($this->rhesus),true);
            $criteria->compare('t.anakke',$this->anakke);
            $criteria->compare('t.jumlah_bersaudara',$this->jumlah_bersaudara);
            $criteria->compare('LOWER(t.no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
            $criteria->compare('LOWER(t.no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
            $criteria->compare('LOWER(t.warga_negara)',strtolower($this->warga_negara),true);
            $criteria->compare('LOWER(t.photopasien)',strtolower($this->photopasien),true);
            $criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
            $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(t.tgl_meninggal)',strtolower($this->tgl_meninggal),true);
            $criteria->compare('t.ispasienluar',$this->ispasienluar);
            $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('LOWER(t.nama_ibu)',strtolower($this->nama_ibu),true);
            $criteria->compare('LOWER(t.nama_ayah)',strtolower($this->nama_ayah),true);
            $criteria->compare('LOWER(t.norm_lama)',strtolower($this->norm_lama),true);
            $criteria->addCondition("t.statusrekammedis LIKE '%AKTIF%'");

            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPasienNoUser()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;                
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik);				
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
                $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);                
                $criteria->addCondition("loginpemakai_id is null ");          
		//$criteria->compare('pasien_aktif',true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       
				));
	}
	
        public function searchDialogRM() {
            $provider = $this->searchDialog();
            $provider->criteria->join = "left join  dokrekammedis_m d on d.pasien_id = t.pasien_id";
            $provider->criteria->addCondition('d.dokrekammedis_id is null');
            return $provider;
        }
    
	public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }
        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
			}
            $criteria->compare('kabupaten_aktif', true);
            $criteria->order='kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kecamatan berdasarkan kabupaten
         * @return CActiveDataProvider 
         */
        public function getKecamatanItems($kabupaten_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
			}
            $criteria->compare('kecamatan_aktif', true);
            $criteria->order='kecamatan_nama';
            $models = KecamatanM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kelurahan berdasarkan kecamatan
         * @return CActiveDataProvider 
         */
        public function getKelurahanItems($kecamatan_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
			}
            $criteria->compare('kelurahan_aktif', true);
            $criteria->order='kelurahan_nama';
            $models = KelurahanM::model()->findAll($criteria);
            return $models;
        }
	    
}
?>
