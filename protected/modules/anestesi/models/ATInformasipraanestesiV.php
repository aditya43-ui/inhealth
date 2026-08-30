<?php

/**
 * This is the model class for table "informasipraanestesi_v".
 *
 * The followings are the available columns in table 'informasipraanestesi_v':
 * @property integer $praanestesi_id
 * @property string $tglpraanestesi
 * @property string $nopraanestesi
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $perawat2_id
 * @property string $nama_perawat2
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 */
class ATInformasipraanestesiV extends InformasipraanestesiV
{
	public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipraanestesiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearchInformasi()
	{
		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tglpraanestesi)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}		
		$criteria->compare('LOWER(nopraanestesi)',strtolower($this->nopraanestesi),true);
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('dokter_id = '.$this->dokter_id);
		}
		$criteria->compare('LOWER(nama_dokter)',strtolower($this->nama_dokter),true);
		if(!empty($this->perawat1_id)){
			$criteria->addCondition('perawat1_id = '.$this->perawat1_id);
		}
		$criteria->compare('LOWER(nama_perawat1)',strtolower($this->nama_perawat1),true);
		if(!empty($this->perawat2_id)){
			$criteria->addCondition('perawat2_id = '.$this->perawat2_id);
		}
		$criteria->compare('LOWER(nama_perawat2)',strtolower($this->nama_perawat2),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);

		return $criteria;
	}
        
	public function searchInformasiPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearchInformasi();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

}