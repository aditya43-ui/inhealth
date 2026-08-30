<?php

/**
 * This is the model class for table "informasiintraanestesi_v".
 *
 * The followings are the available columns in table 'informasiintraanestesi_v':
 * @property integer $intraanestesi_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $praanestesi_id
 */
class ATInformasiintraanestesiV extends InformasiintraanestesiV
{
	public $umur,$jeniskasuspenyakit_id,$jeniskasuspenyakit_nama,$pegawai_id,$nama_pegawai,$jeniskelamin,$pekerjaan_id,$pekerjaan_nama,$kelaspelayanan_id,$kelaspelayanan_nama,$alamat_pasien;
	public $tgl_awal,$tgl_akhir, $tgl_intra_cari;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiintraanestesiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglintraanestesi)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		$criteria->compare('LOWER(nointraanestesi)',strtolower($this->nointraanestesi),true);
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
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}

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
		
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter();
		$criteria=$this->criteriaSearch();
//        $criteria->addBetweenCondition('DATE(tglintraanestesi)',$format->formatDateTimeForDb($this->tgl_intra_cari)." 00:00:00",$format->formatDateTimeForDb($this->tgl_intra_cari)." 23:59:59");
//                $tgl_intra_cari = $this->getKonverviDateRange($this->tgl_intra_cari);
//                $criteria->addBetweenCondition('DATE(tglintraanestesi)', $tgl_intra_cari[0]." 00:00:00", $tgl_intra_cari[1]." 23:59:59");
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
        
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
}