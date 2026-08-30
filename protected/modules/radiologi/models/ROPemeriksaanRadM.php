<?php

class ROPemeriksaanRadM extends PemeriksaanradM
{
    public $refhasilrad_id,$jenispemeriksaanrad_nama,$pemeriksaanrad_jenis, $daftartindakan_nama;
    public $isChecked = false; //status jika di pilih
	public $is_adareferensihasil = 0; //refrensi hasil jika dipilih => RND-8166
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

//    public function getDaftarTindakanNama($daftartindakanId = null) {
////        return DaftartindakanM::model()->findByPk($daftartindakanId);
//    }
	public function getDaftarTindakanItems()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE ORDER BY daftartindakan_nama');
        }

    public function getDaftarTindakanNama()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE ORDER BY daftartindakan_nama');
        }
    public function searchTabel()
    {


        $criteria=new CDbCriteria;
        $criteria->with = array('daftartindakan','jenispemeriksaanrad');
        $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition("t.pemeriksaanrad_id = ".$this->pemeriksaanrad_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id);
		}
		if(!empty($this->jenispemeriksaanrad_id)){
			$criteria->addCondition("t.jenispemeriksaanrad_id = ".$this->jenispemeriksaanrad_id);
		}
        $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria->compare('LOWER(t.kode_dicom_modality)', strtolower($this->kode_dicom_modality), true);
        $criteria->compare('LOWER(t.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
        $criteria->compare('LOWER(t.pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
        $criteria->compare('LOWER(jenispemeriksaanrad.jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
        $criteria->compare('t.pemeriksaanrad_aktif',isset($this->pemeriksaanrad_aktif)?$this->pemeriksaanrad_aktif:true);
        $criteria->compare('t.subjenis_pemeriksaanrad_id',$this->subjenis_pemeriksaanrad_id);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'attributes' => array(
                    'daftartindakan_nama' => array(
                        'asc' => 'daftartindakan.daftartindakan_nama ASC',
                        'desc' => 'daftartindakan.daftartindakan_nama DESC',
                    ),
                    '*',
                )
            )
        ));
    }

	public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
//		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
//		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
//		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
//		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
//		$criteria->compare('LOWER(pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
		//$criteria->compare('pemeriksaanrad_aktif',$this->pemeriksaanrad_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit

		$criteria->with = array('daftartindakan','jenispemeriksaanrad');
	    $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
	    $criteria->compare('LOWER(jenispemeriksaanrad.jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('t.pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(t.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('LOWER(t.pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
        $criteria->compare('t.subjenis_pemeriksaanrad_id',$this->subjenis_pemeriksaanrad_id);
		$criteria->compare('t.pemeriksaanrad_aktif',isset($this->pemeriksaanrad_aktif)?$this->pemeriksaanrad_aktif:true);
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

}
?>
