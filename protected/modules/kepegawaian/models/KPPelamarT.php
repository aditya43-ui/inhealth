<?php
class KPPelamarT extends PelamarT
{
	public $semuapelamar,$kemampuan_tingkat, $tgl_awal, $tgl_akhir;
        public $menyetujui_nama, $mengetahui_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PelamarT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchInfoPelamar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		//$tanggal_hariini = date('Y-m-d');
//		var_dump($this->semuapelamar);exit;
               // var_dump($this->semuapelamar);
		if($this->semuapelamar == '1'){
			$criteria->addCondition('berlaku_s_d <= now()');
        }else{
            $criteria->addBetweenCondition('DATE(tglmelamar)', $this->tgl_awal, $this->tgl_akhir);
        }
                
                
		
		if(!empty($this->pelamar_id)){
			$criteria->addCondition('pelamar_id = '.$this->pelamar_id);
		}
		if(!empty($this->pendkualifikasi_id)){
			$criteria->addCondition('pendkualifikasi_id = '.$this->pendkualifikasi_id);
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->suku_id)){
			$criteria->addCondition('suku_id = '.$this->suku_id);
		}
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition('pendidikan_id = '.$this->pendidikan_id);
		}
	//	$criteria->compare('LOWER(tgllowongan)',strtolower($this->tgllowongan),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nama_pelamar)',strtolower($this->nama_pelamar),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pelamar)',strtolower($this->tempatlahir_pelamar),true);
		$criteria->compare('LOWER(tgl_lahirpelamar)',strtolower($this->tgl_lahirpelamar),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan));
		if(!empty($this->jmlanak)){
			$criteria->addCondition('jmlanak = '.$this->jmlanak);
		}
		$criteria->compare('LOWER(alamat_pelamar)',strtolower($this->alamat_pelamar),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pelamar)',strtolower($this->notelp_pelamar),true);
		$criteria->compare('LOWER(nomobile_pelamar)',strtolower($this->nomobile_pelamar),true);
		$criteria->compare('LOWER(warganegara_pelamar)',strtolower($this->warganegara_pelamar),true);
		$criteria->compare('LOWER(photopelamar)',strtolower($this->photopelamar),true);
		$criteria->compare('gajiygdiharapkan',$this->gajiygdiharapkan);
		$criteria->compare('LOWER(tglditerima)',strtolower($this->tglditerima),true);
		$criteria->compare('LOWER(tglmulaibekerja)',strtolower($this->tglmulaibekerja),true);
		$criteria->compare('LOWER(ingintunjangan)',strtolower($this->ingintunjangan),true);
		$criteria->compare('LOWER(keterangan_pelamar)',strtolower($this->keterangan_pelamar),true);
		$criteria->compare('LOWER(minatpekerjaan)',strtolower($this->minatpekerjaan),true);
		$criteria->compare('LOWER(filelamaran)',strtolower($this->filelamaran),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		//$criteria->compare('LOWER(berlaku_s_d)',strtolower($this->berlaku_s_d),true);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                
		));
	}

    public function getJenisIdentitas()
    {
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'jenisidentitas'));
    }
    public function getJenisKelamin()
    {
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'jeniskelamin'));
    }
    public function getAgama()
    {
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'agama'), array('order'=>'lookup_urutan'));
    }
    public function getStatusPerkawinan()
    {
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperkawinan'));
    }
    public function getPendidikanItems(){
        return PendidikanM::model()->findAll();
    }
    public function getpendidikannama(){
        $pendidikan = PendidikanM::model()->findByPk($this->pendidikan_id);
        if (!empty($pendidikan->pendidikan_nama)){
            $nama_pendidikan = $pendidikan->pendidikan_nama;
            return $nama_pendidikan;
        }
    }
    public function getPendkualifikasiItems(){
        return PendidikankualifikasiM::model()->findAllByAttributes(array('pendkualifikasi_aktif'=>true));
    }
    public function getPendkualifikasiNama(){
        $pendidikan = PendidikankualifikasiM::model()->findByPk($this->pendkualifikasi_id);
        if (!empty($pendidikan->pendkualifikasi_nama)){
            return $pendidikan->pendkualifikasi_nama;
        }
    }
    public function getMinatPekerjaan(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'minatpekerjaan'));
    }
    public function getSuku(){
        return SukuM::model()->findAll();
    }
    public function getProfilRS(){
        return ProfilrumahsakitM::model()->findAll(array('order'=>'profilrs_id'));
    }

    public function getnokontakpelamar(){
        $nokontak = $this->notelp_pelamar." / ".$this->nomobile_pelamar;
        return $nokontak;
    }

    public function getstatuskawin(){
        return $this->statusperkawinan.' / '.$this->jmlanak;
    }

    public function getnamasuku(){
        $suku = SukuM::model()->findByPk($this->suku_id);
        if(!empty($suku->suku_nama))
            return $suku->suku_nama;
    }

    public function getprofilnama(){
        $profile = ProfilrumahsakitM::model()->findByPk($this->profilrs_id);
        return $profile->nama_rumahsakit;
    }

    public function  getWargaNegara(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'warganegara'));
    }
    
    public function getStatusPenilaian()
    {
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'statuspenilaian'));
    }
    
}
?>
