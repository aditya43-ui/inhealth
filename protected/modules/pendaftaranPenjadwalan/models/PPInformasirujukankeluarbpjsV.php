<?php

/**
 * This is the model class for table "informasirujukankeluarbpjs_v".
 *
 * The followings are the available columns in table 'informasirujukankeluarbpjs_v':
 * @property integer $pasiendirujukkeluar_id
 * @property string $tgldirujuk
 * @property string $nosuratrujukan
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $dirujukke
 * @property string $dirujukkebagian
 * @property string $diagnosasementara_ruj
 * @property string $catatandokterperujuk
 * @property string $dokterpemeriksa
 * @property boolean $isdikembalikan
 * @property string $jenispelayanan_bpjs
 * @property string $tiperujukan_bpjs
 * @property string $userinput_bpjs
 */
class PPInformasirujukankeluarbpjsV extends InformasirujukankeluarbpjsV
{
        public $tgl_awal,$tgl_akhir,$nosep,$nokartuasuransi,$sep_id;
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasiendirujukkeluar_id)){
			$criteria->addCondition('pasiendirujukkeluar_id = '.$this->pasiendirujukkeluar_id);
		}
//		$criteria->compare('LOWER(tgldirujuk)',strtolower($this->tgldirujuk),true);
                $criteria->addBetweenCondition('DATE(tgldirujuk)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nosuratrujukan)',strtolower($this->nosuratrujukan),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(dirujukke)',strtolower($this->dirujukke),true);
		$criteria->compare('LOWER(dirujukkebagian)',strtolower($this->dirujukkebagian),true);
		$criteria->compare('LOWER(diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
		$criteria->compare('LOWER(catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);
		$criteria->compare('LOWER(dokterpemeriksa)',strtolower($this->dokterpemeriksa),true);
		$criteria->compare('isdikembalikan',$this->isdikembalikan);
		$criteria->compare('LOWER(jenispelayanan_bpjs)',strtolower($this->jenispelayanan_bpjs),true);
		$criteria->compare('LOWER(tiperujukan_bpjs)',strtolower($this->tiperujukan_bpjs),true);
		$criteria->compare('LOWER(userinput_bpjs)',strtolower($this->userinput_bpjs),true);

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