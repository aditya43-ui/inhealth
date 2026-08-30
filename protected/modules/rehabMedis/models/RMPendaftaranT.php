<?php
class RMPendaftaranT extends PendaftaranT {
    public $jeniskasuspenyakit_nama='';
    public $is_adapjpasien = 0;
    public $is_pasienrujukan = 0;
	public $diagnosa;
    public $is_bpjs = 0;
    
    public $buatjanjipoli_id;
    public $is_vaksinasi = 0;
    
    public $isRujukan,$isPasienLama,$pakeAsuransi,$adaPenanggungJawab,$adaKarcis,$noRekamMedik;
    public $instalasi_nama,$ruangan_nama,$gelardepan,$nama_pegawai,$gelarbelakang_nama,$carabayar_nama,$penjamin_nama,$is_bpjs_manual;
     public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran RJ
         * - pendaftaran RD
         * - pendaftaran RI
         * @return \CActiveDataProvider
         */
        public function searchRiwayatPasien($pasien_id){
			if(!empty($pasien_id)){
				$condition = " AND pasien_m.pasien_id = ".$pasien_id;
			}else{
				$condition = " ";
			}
			
			$startDate = date('Y-m-d', strtotime('today - 6 months'));
			$endDate = date('Y-m-d');
			
			$model = CActiveRecord::findAllBySql("SELECT * FROM (SELECT pasien_m.pasien_id, pasien_m.jenisidentitas, pasien_m.no_identitas_pasien, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.nama_bin AS alias, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.rt, pasien_m.rw, pasien_m.agama, pasien_m.golongandarah, pasien_m.photopasien, pasien_m.alamatemail, pasien_m.statusrekammedis, pasien_m.statusperkawinan, pasien_m.no_rekam_medik, pasien_m.tgl_rekam_medik, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.transportasi, pendaftaran_t.keadaanmasuk, pendaftaran_t.statusperiksa, pendaftaran_t.statuspasien, pendaftaran_t.kunjungan, pendaftaran_t.alihstatus, pendaftaran_t.byphone, pendaftaran_t.kunjunganrumah, pendaftaran_t.statusmasuk, pendaftaran_t.umur, asuransipasien_m.nokartuasuransi AS no_asuransi, asuransipasien_m.namapemilikasuransi AS namapemilik_asuransi, asuransipasien_m.nomorpokokperusahaan AS nopokokperusahaan, pendaftaran_t.create_time, pendaftaran_t.create_loginpemakai_id, pendaftaran_t.create_ruangan, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, caramasuk_m.caramasuk_id, caramasuk_m.caramasuk_nama, pendaftaran_t.shift_id, golonganumur_m.golonganumur_id, golonganumur_m.golonganumur_nama, rujukan_t.no_rujukan, rujukan_t.nama_perujuk, rujukan_t.tanggal_rujukan, rujukan_t.diagnosa_rujukan, asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, instalasi_m.instalasi_id, instalasi_m.instalasi_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, NULL::integer AS pasienadmisi_id, NULL::integer AS masukkamar_id, NULL::character varying AS kamarruangan_nokamar, asuransipasien_m.tglcetakkartuasuransi, asuransipasien_m.kodefeskestk1, asuransipasien_m.nama_feskestk1, asuransipasien_m.masaberlakukartu, asuransipasien_m.nokartukeluarga, asuransipasien_m.nopassport, asuransipasien_m.status_konfirmasi, asuransipasien_m.tgl_konfirmasi, asuransipasien_m.asuransipasien_aktif, pendaftaran_t.keterangan_pendaftaran
           FROM pasien_m
      JOIN pendaftaran_t ON pasien_m.pasien_id = pendaftaran_t.pasien_id
   JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
   JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
   JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
   LEFT JOIN caramasuk_m ON pendaftaran_t.caramasuk_id = caramasuk_m.caramasuk_id
   JOIN golonganumur_m ON pendaftaran_t.golonganumur_id = golonganumur_m.golonganumur_id
   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
   LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
   JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
   JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
   JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
   LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
   LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
   LEFT JOIN asuransipasien_m ON pendaftaran_t.asuransipasien_id = asuransipasien_m.asuransipasien_id
  WHERE pendaftaran_t.pasienbatalperiksa_id IS NULL AND pendaftaran_t.alihstatus = false".$condition."
UNION ALL 
         SELECT pasien_m.pasien_id, pasien_m.jenisidentitas, pasien_m.no_identitas_pasien, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.nama_bin AS alias, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.rt, pasien_m.rw, pasien_m.agama, pasien_m.golongandarah, pasien_m.photopasien, pasien_m.alamatemail, pasien_m.statusrekammedis, pasien_m.statusperkawinan, pasien_m.no_rekam_medik, pasien_m.tgl_rekam_medik, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.transportasi, pendaftaran_t.keadaanmasuk, 'SEDANG DIRAWAT'::character varying(50) AS statusperiksa, pendaftaran_t.statuspasien, pendaftaran_t.kunjungan, pendaftaran_t.alihstatus, pendaftaran_t.byphone, pendaftaran_t.kunjunganrumah, pendaftaran_t.statusmasuk, pendaftaran_t.umur, asuransipasien_m.nokartuasuransi AS no_asuransi, asuransipasien_m.namapemilikasuransi AS namapemilik_asuransi, asuransipasien_m.nomorpokokperusahaan AS nopokokperusahaan, pendaftaran_t.create_time, pendaftaran_t.create_loginpemakai_id, pendaftaran_t.create_ruangan, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, caramasuk_m.caramasuk_id, caramasuk_m.caramasuk_nama, pendaftaran_t.shift_id, golonganumur_m.golonganumur_id, golonganumur_m.golonganumur_nama, rujukan_t.no_rujukan, rujukan_t.nama_perujuk, rujukan_t.tanggal_rujukan, rujukan_t.diagnosa_rujukan, asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, instalasi_m.instalasi_id, instalasi_m.instalasi_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pasienadmisi_t.pasienadmisi_id, masukkamar_t.masukkamar_id, kamarruangan_m.kamarruangan_nokamar, asuransipasien_m.tglcetakkartuasuransi, asuransipasien_m.kodefeskestk1, asuransipasien_m.nama_feskestk1, asuransipasien_m.masaberlakukartu, asuransipasien_m.nokartukeluarga, asuransipasien_m.nopassport, asuransipasien_m.status_konfirmasi, asuransipasien_m.tgl_konfirmasi, asuransipasien_m.asuransipasien_aktif, pendaftaran_t.keterangan_pendaftaran
           FROM pasien_m
      JOIN pendaftaran_t ON pasien_m.pasien_id = pendaftaran_t.pasien_id
   JOIN golonganumur_m ON pendaftaran_t.golonganumur_id = golonganumur_m.golonganumur_id
   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
   LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
   JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
   JOIN pasienadmisi_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id AND pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
   JOIN carabayar_m ON pasienadmisi_t.carabayar_id = carabayar_m.carabayar_id
   JOIN penjaminpasien_m ON pasienadmisi_t.penjamin_id = penjaminpasien_m.penjamin_id
   JOIN caramasuk_m ON pasienadmisi_t.caramasuk_id = caramasuk_m.caramasuk_id
   JOIN ruangan_m ON ruangan_m.ruangan_id = pasienadmisi_t.ruangan_id
   JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
   LEFT JOIN masukkamar_t ON masukkamar_t.ruangan_id = ruangan_m.ruangan_id AND pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
   LEFT JOIN kamarruangan_m ON masukkamar_t.kamarruangan_id = kamarruangan_m.kamarruangan_id
   JOIN kelaspelayanan_m ON masukkamar_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
   LEFT JOIN pegawai_m ON masukkamar_t.pegawai_id = pegawai_m.pegawai_id
   LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
   LEFT JOIN asuransipasien_m ON pendaftaran_t.asuransipasien_id = asuransipasien_m.asuransipasien_id
  WHERE masukkamar_t.pindahkamar_id IS NULL ".$condition.") t WHERE DATE(t.tgl_pendaftaran) BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY t.tgl_pendaftaran DESC LIMIT 5");
			 return $model;
        }

    public function getRuanganItems($instalasiId ='') 
    {
        return RuanganM::model()->findAll('(instalasi_id = '.Params::INSTALASI_ID_LAB.' OR instalasi_id = '.Params::INSTALASI_ID_RAD.' OR instalasi_id = '.Params::INSTALASI_ID_REHAB. ' OR instalasi_id = '.Params::INSTALASI_ID_IBS. ') AND ruangan_aktif=true ORDER BY ruangan_nama');
    }
    public function getJenisKasusPenyakit()
    {
        return JeniskasuspenyakitM::model()->findAllByAttributes(array('jeniskasuspenyakit_aktif'=>true),array('order'=>'jeniskasuspenyakit_nama'));
    }
     public function getKelasPelayanan()
    {
        return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
    }
	/**
	* Mengambil daftar semua kelaspelayanan
	* @return CActiveDataProvider 
	*/
   public static function getKelasPelayananItems($ruangan_id = null)
   {
	   if($ruangan_id==null){
		   return array();
	   }else{
		  $criteria = new CdbCriteria();
		   $criteria->join = "JOIN kelasruangan_m on t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
		   $criteria->addCondition('t.kelaspelayanan_aktif = true');
		   $criteria->addCondition('kelasruangan_m.ruangan_id ='.$ruangan_id);
		   $criteria->order = "t.urutankelas";
		   return KelaspelayananM::model()->findAll($criteria);
	   } 
   }
   /**
	* mengambil data jenis kasus penyakit berdasarkan ruangan
	* @param type $ruangan_id
	*/
	public static function getJenisKasusPenyakitItems($ruangan_id = null)
	{            
		if(empty($ruangan_id)){
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
		}
		$criteria = new CdbCriteria();
		$criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
		$criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
		$criteria->order = "t.jeniskasuspenyakit_nama";
		$criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
		return JeniskasuspenyakitM::model()->findAll($criteria);
	}
	/**
	* menampilkan dokter 
	* @param type $ruangan_id
	* @return type
	*/
   public static function getDokterItems($ruangan_id='')
   {
	   $criteria = new CdbCriteria();
	   if(!empty($ruangan_id)){
		   $criteria->addCondition("ruangan_id = ".$ruangan_id);					
	   }
	   $criteria->addCondition('pegawai_aktif = true');
	   $criteria->order = "nama_pegawai, gelardepan";
	   $modDokter = DokterV::model()->findAll($criteria);
	   return $modDokter;
   }


   public static function getPPDS()
   {
	   $criteria = new CdbCriteria();
	   $criteria->addCondition('ppds_aktif = true');
	   $criteria->order = "ppds_nama";
	   $modPPDS = PpdsM::model()->findAll($criteria);
	   return $modPPDS;
   }
    
    public function getDokter()
    {
        return DokterV::model()->findAll('ruangan_id='.Yii::app()->user->getState('ruangan_id').' ORDER BY nama_pegawai');
    }
    public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
    public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
				return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
				return array();
	}
	public function getParamedisItems($ruangan_id='')
	{
		if(!empty($ruangan_id))
			return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
		else
			return array();
	}
        
        /**
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public function getKelasTanggunganItems()
        {
			$cri = new CDbCriteria();
			$cri->addCondition(" kelaspelayanan_aktif = TRUE ");
			$cri->addCondition(" kelasbpjs_id IS NOT NULL ");
			$cri->order = " urutankelas ASC ";
            //return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
			return KelaspelayananM::model()->findAll($cri);
        }
        
}
?>
