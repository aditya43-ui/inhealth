<?php

/**
 * This is the model class for table "pencarianseprujukankeluar_v".
 *
 * The followings are the available columns in table 'pencarianseprujukankeluar_v':
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $klsrawat
 * @property integer $pegawai_id
 */
class PPPencarianseprujukankeluarV extends PencarianseprujukankeluarV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencarianseprujukankeluarV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
//		$criteria->compare('LOWER(tglsep)',strtolower($this->tglsep),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->klsrawat)){
			$criteria->addCondition('klsrawat = '.$this->klsrawat);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchDialog(){
            $criteria=$this->criteriaSearch();
//            $this->tglsep = MyFormatter::formatDateTimeForDb($this->tglsep);
//            $criteria->addBetweenCondition('DATE(tglsep)', $this->tglsep, $this->tglsep);
            // $tglsep = $this->getKonverviDateRange($this->tglsep);
            // $criteria->addBetweenCondition('DATE(tglsep)', $tglsep[0]." 00:00:00", $tglsep[1]." 23:59:59");
            // $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>10
                ),
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('d/m/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('d/m/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
        
        public function searchPasienSep(){
            $cri = new CDbCriteria;
            
            $cri->compare("LOWER(nosep)", strtolower($this->nosep), true);
            $cri->compare("LOWER(nama_pasien)", strtolower($this->nama_pasien), true);
            $cri->compare("LOWER(no_rekam_medik)", strtolower($this->no_rekam_medik), true);
            $cri->compare("LOWER(no_pendaftaran)", strtolower($this->no_pendaftaran), true);
            $cri->compare("jnspelayanan::text", $this->jnspelayanan, true);
            $cri->compare("klsrawat::text", $this->klsrawat, true);            
            $cri->limit = 10;
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$cri,                    
            ));
        }
}