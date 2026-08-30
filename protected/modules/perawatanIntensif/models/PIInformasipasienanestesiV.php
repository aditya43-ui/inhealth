<?php

/**
 * This is the model class for table "informasipasienanestesi_v".
 *
 * The followings are the available columns in table 'informasipasienanestesi_v':
 * @property integer $pasienanastesi_id
 * @property string $tglanastesi
 * @property string $noanestesi
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $umur
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $pasienmasukpenunjang_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $statusanestesi
 */
class PIInformasipasienanestesiV extends InformasipasienanestesiV
{
	public $tgl_awal,$tgl_akhir, $tgl_masuk_cari;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipasienanestesiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{	
		$format = new MyFormatter();
		$criteria=$this->criteriaSearch();
//                $tgl_masuk_cari = $this->getKonverviDateRange($this->tgl_masuk_cari);
//                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $tgl_masuk_cari[0]." 00:00:00", $tgl_masuk_cari[1]." 23:59:59");
//                $criteria->addBetweenCondition("DATE(tglmasukpenunjang)", $format->formatDateTimeForDb($this->tgl_masuk_cari)." 00:00:00", $format->formatDateTimeForDb($this->tgl_masuk_cari)." 23:59:59");
		$criteria->limit=5;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
                                    'pageSize'=>5
                                ),
		));
	}
	
	public function criteriaSearchInformasi()
	{
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglanastesi)', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		$criteria->compare('LOWER(noanestesi)',strtolower($this->noanestesi),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);		
		$criteria->compare('LOWER(statusanestesi)',strtolower($this->statusanestesi),true);
		
		return $criteria;
	}
	
	public function searchInformasiPasien()
	{
		$criteria=$this->criteriaSearchInformasi();
		$criteria->limit=5;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
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