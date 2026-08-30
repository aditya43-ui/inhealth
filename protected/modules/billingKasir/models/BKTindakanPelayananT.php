<?php

class BKTindakanPelayananT extends TindakanpelayananT
{
    public $tgl_awal;
    public $tgl_akhir;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
    public $statusperiksa;
    public $is_pilihtindakan;
    public $subtotal;
    public $jenistarif_id;
    public $kategoritindakan_nama;
    public $daftartindakan_nama;
    public $dokterpemeriksa1_nama;
    public $dokterpemeriksa2_nama;
    public $dokterpendamping_nama;
    public $dokteranastesi_nama;
    public $dokterdelegasi_nama;
    public $bidan_nama;
    public $suster_nama;
    public $perawat_nama;
    public $pemeriksaanrad_id;
    public $pemeriksaanlab_id;
    public $jenistindakanrm_id;
    public $tindakanrm_id;
    public $persencyto_tindakan;
    
    public $tglmasukpenunjang;
    public $no_masukpenunjang;
    
    public $operasi_id;
    public $kegiatanoperasi_id;
    public $total;
	
	public $kelompoktindakan_id;
	public $instalasi_id, $daftartindakan_kode;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getJumlahTarif()
    {
        return $this->tarif_tindakan * $this->qty_tindakan + $this->tarifcyto_tindakan;
    }
                

    public function getTipePakets()
    {
        return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif'=>true));
    }
    
    public function getRuangans($instalasi_id=null)
    {
        $criteria = new CdbCriteria();
        if (!empty($instalasi_id)){
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);					
			}
        }
        $criteria->addCondition('ruangan_aktif = true');
        return RuanganM::model()->findAll($criteria);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPasienKarcis()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with = array('pendaftaran','pasien','daftartindakan');
            $criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
            $criteria->addBetweenCondition('DATE(pendaftaran.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addCondition('t.karcis_id IS NOT NULL');
            $criteria->order = 'pendaftaran.tgl_pendaftaran DESC';
//            $criteria->addCondition('t.tindakansudahbayar_id IS NULL');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchRiwayatTindakan($pendaftaran_id,$instalasi_id = null)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
//        echo $pendaftaran_id."-".$instalasi_id;exit;

            $criteria=new CDbCriteria;

            $criteria->group = 'pasienmasukpenunjang_t.tglmasukpenunjang,tgl_tindakan,pasienmasukpenunjang_t.no_masukpenunjang, daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_id, t.dokterpemeriksa1_id, t.tindakanpelayanan_id, t.pendaftaran_id';
            $criteria->select = $criteria->group.' ,sum(t.qty_tindakan*t.tarif_satuan) as tarif_tindakan';
            $criteria->addCondition('ruangan_m.instalasi_id ='.$instalasi_id);
            $criteria->addCondition('t.pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('t.tindakansudahbayar_id IS NULL');
            $criteria->addCondition('t.verifrenctindakan_id IS NULL');
            $criteria->addCondition('t.pasienmasukpenunjang_id IS NOT NULL');
            $criteria->order = 't.tgl_tindakan';
            $criteria->join='JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id'
                    . ' JOIN pasienmasukpenunjang_t ON t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id'
                    . ' JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function getNamaLengkap()
    {
        if(!empty($this->dokter1->nama_pegawai)){
            return (isset($this->dokter1->gelardepan) ? $this->dokter1->gelardepan : "").' '.$this->dokter1->nama_pegawai.(isset($this->dokter1->gelarbelakang_id) ? ', '.$this->dokter1->gelarbelakang->gelarbelakang_nama : "");
        }else{
            return "-";
        }
        
    }
    
    /**
    * menampilkan pemeriksaan lab berdasarkan daftartindakan_id
    * @return type
    */
    public function getPemeriksaanBedah(){
        return BKOperasiM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
    }

    public function getPenjaminTagihan()
	{
		$modPenjamin = PenjaminpasienM::model()->findAllByAttributes(array('penjamin_id'=>$this->penjamin_id));
		return $modPenjamin;
	}
}
?>
