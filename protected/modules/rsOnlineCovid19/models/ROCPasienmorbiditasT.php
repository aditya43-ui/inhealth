<?php

class ROCPasienmorbiditasT extends PasienmorbiditasT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrawatinapV the static model class
     */
    public $ceklis = false;
    public $carakeluar;
	public $is_dokter = 0;
	public $pegawai_id;
	public $pilih,$daftartindakan_id,$ceklist;
	public $tgl_awal, $tgl_akhir, $tgl_pendaftaran, $namadepan, $tanggal_lahir, $carabaya_nama, $kelaspelayanan_nama;
        public $no_pendaftaran, $no_rekam_medik, $nama_pasien, $carabayar_id, $penjamin_id, $kelaspelayanan_id, $jeniskasuspenyakit_nama, $diagnosa_nama, $penjamin_nama;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchinformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
                $criteria->join = "JOIN pendaftaran_t pd ON pd.pendaftaran_id = t.pendaftaran_id"
                        . " JOIN diagnosa_m diag ON diag.diagnosa_id = t.diagnosa_id "
                        . " JOIN pasien_m pasien ON pasien.pasien_id = pd.pasien_id"
                        . " JOIN penjaminpasien_m penjamin ON penjamin.penjamin_id = pd.penjamin_id"
                        . " JOIN carabayar_m carabayar ON carabayar.carabayar_id = penjamin.carabayar_id"
                        . " JOIN kelaspelayanan_m kelaspel ON kelaspel.kelaspelayanan_id = pd.kelaspelayanan_id"
                        . " JOIN jeniskasuspenyakit_m jnspenyakit ON jnspenyakit.jeniskasuspenyakit_id = pd.jeniskasuspenyakit_id";
                
                $criteria->select = "pd.pendaftaran_id, pd.no_pendaftaran, pd.tgl_pendaftaran, pasien.pasien_id, pasien.no_rekam_medik, pasien.namadepan, pasien.nama_pasien, pasien.tanggal_lahir, carabayar.carabayar_nama, pd.pegawai_id, kelaspel.kelaspelayanan_nama, jnspenyakit.jeniskasuspenyakit_nama, diag.diagnosa_nama, penjamin.penjamin_nama, t.tglpengiriminkemenkes, t.tglubahpengirimankemenkes, t.pegawaipengirimkemenkes, t.pegawaiubahpengirimankemenkes, t.pegawaipenghapusankemenkes, t.tglpenghapusankemenkes";
		$criteria->addBetweenCondition('DATE(pd.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
                
//		$criteria->addCondition('t.instalasi_id = '. Params::INSTALASI_ID_RI);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin.penjamin_id = ".$this->penjamin_id); 	
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar.carabayar_id = ".$this->carabayar_id); 	
		}
//		if(!empty($this->caramasuk_id)){
//			$criteria->addCondition("t.caramasuk_id = ".$this->caramasuk_id); 	
//		}
                if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspel.kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
                if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jnspenyakit.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pd.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->addCondition('pd.pasienadmisi_id IS NOT NULL');
//                echo '<pre>';
//                print_r($criteria);
//                exit();
//		if($this->ceklis == 1)
//		{
//			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
//		}
//        $criteria->compare('t.dokterpenerima_id', $this->dokterpenerima_id);
//        
//        if (!empty($this->pegawai_id)) {
//            $criteria->addCondition(
//                "(t.dpjp1_id = ".$this->pegawai_id." or t.dpjp2_id = ".$this->pegawai_id." or t.dpjp3_id = ".$this->pegawai_id.")"
//            );
//        }
//		//$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
//                $criteria->compare('t.kamarruangan_id', $this->kamarruangan_id);                
//                if (!empty($this->tgl_pendaftaran)){
//                    $criteria->addCondition(" DATE(t.tgl_pendaftaran) = '".MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran)."' ");
//                }
//		//if($this->ceklis == 1)
//		//{
//        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {     
//                
//			$criteria->addBetweenCondition('DATE(t.tglmasukkamar)',$this->tgl_awal,$this->tgl_akhir);
//        }
//		//}
//                $criteria->order = "t.tgl_pendaftaran DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
    public function getKelasPelayananRuangan()
        {
            $cri = new CDbCriteria();
            $cri->join = " JOIN kelasruangan_m kr ON kr.kelaspelayanan_id = t.kelaspelayanan_id ";
            $cri->addCondition(" kr.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $cri->addCondition(" t.kelaspelayanan_aktif = TRUE ");
            $cri->order = " t.kelaspelayanan_nama ASC ";

            return KelaspelayananM::model()->findAll($cri);
        }
        
        public function getKasusPenyakit()
        {            

            return JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC");
        }
   
   
	        
}
?>
