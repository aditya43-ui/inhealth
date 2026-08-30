<?php

/**
 * This is the model class for table "informasisep_v".
 *
 * The followings are the available columns in table 'informasisep_v':
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $nokartuasuransi
 * @property string $tglrujukan
 * @property string $norujukan
 * @property string $ppkrujukan
 * @property string $ppkpelayanan
 * @property integer $jnspelayanan
 * @property string $catatansep
 * @property string $diagnosaawal
 * @property string $politujuan
 * @property integer $klsrawat
 * @property integer $lakalantas
 * @property integer $penjamin_lakalantas
 * @property string $lokasi_lakalantas
 * @property string $no_telpon_peserta
 * @property integer $poli_eksekutif
 * @property integer $cob
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 */
class ARInformasisepV extends InformasisepV
{
    public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisepV the static model class
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
                $criteria->addBetweenCondition('DATE(tglsep)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(tglrujukan)',strtolower($this->tglrujukan),true);
		$criteria->compare('LOWER(norujukan)',strtolower($this->norujukan),true);
		$criteria->compare('LOWER(ppkrujukan)',strtolower($this->ppkrujukan),true);
		$criteria->compare('LOWER(ppkpelayanan)',strtolower($this->ppkpelayanan),true);
		if(!empty($this->jnspelayanan)){
			$criteria->addCondition('jnspelayanan = '.$this->jnspelayanan);
		}
		$criteria->compare('LOWER(catatansep)',strtolower($this->catatansep),true);
		$criteria->compare('LOWER(diagnosaawal)',strtolower($this->diagnosaawal),true);
		$criteria->compare('LOWER(politujuan)',strtolower($this->politujuan),true);
		if(!empty($this->klsrawat)){
			$criteria->addCondition('klsrawat = '.$this->klsrawat);
		}
		if(!empty($this->lakalantas)){
			$criteria->addCondition('lakalantas = '.$this->lakalantas);
		}
		if(!empty($this->penjamin_lakalantas)){
			$criteria->addCondition('penjamin_lakalantas = '.$this->penjamin_lakalantas);
		}
		$criteria->compare('LOWER(lokasi_lakalantas)',strtolower($this->lokasi_lakalantas),true);
		$criteria->compare('LOWER(no_telpon_peserta)',strtolower($this->no_telpon_peserta),true);
		if(!empty($this->poli_eksekutif)){
			$criteria->addCondition('poli_eksekutif = '.$this->poli_eksekutif);
		}
		if(!empty($this->cob)){
			$criteria->addCondition('cob = '.$this->cob);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);

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
            // $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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
}