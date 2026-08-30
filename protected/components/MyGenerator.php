<?php

/**
 * Class Generator untuk menyimpan function generator kode / nomor unik
 * modify by: @author Research Development | 03 Jun 2014 | RND-95 RND-94
 */
class MyGenerator
{

    public static function noOrderLAB($ruangan_id = null) {
        $default = "0000";

        switch ($ruangan_id) {
            case Params::RUANGAN_ID_LAB_KLINIK:
                $default = "2000";
                break;
            case Params::RUANGAN_ID_LAB_PATOLOGI:
                $default = "1000";
                break;
            default:
                $default = "0000";
            
        }

        $prefix = date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noorderlis," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from pasienmasukpenunjang_t "
                . "where noorderlis ilike ('" . $prefix . "%') ";
        if (!empty($ruangan_id)) {
            $sql .= " and ruangan_id = ".$ruangan_id;
        }
        $order = Yii::app()->db->createCommand($sql)->queryRow();

        $nomor = (isset($order['nomaksimal']) ? ($order['nomaksimal'] + 1) : $default);
        $nomor = ((int)$nomor < (int)$default) ? (int)$default : (int)$nomor;


        $nomor_baru = $prefix.str_pad($nomor, strlen($default), 0, STR_PAD_LEFT);


        // var_dump($default, $nomor_baru); die;

        return $nomor_baru;
    }
    
    public static function noRekamMedikPenunjangBM($prefix)
    {
		return self::noRekamMedikBM($prefix,'TRUE');
    }

    public static function noRekamMedikBM($prefix='',$is_pasienluar='FALSE',$sesuairange='')
    {
        $default = null;
		$digit_rm = self::DigitRM();
		for($i=1;$i<=$digit_rm;$i++){
            if($i == $digit_rm)
                $default .= "1";
            else
                $default .= "0";
        }

        $cek_no_range = '';
        if (!empty($sesuairange) && empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
					FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                        AND no_rekam_medik ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$'
                                        and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                        AND no_rekam_medik::integer <= '".$sesuairange."'
					ORDER BY no_rekam_medik DESC
					LIMIT 1";
            $cek_no_range = Yii::app()->db->createCommand($sql)->queryRow();
        }
        // echo '<pre>';var_dump($cek_no_range);die;
        $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'*/
                                    and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        if(empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'
                                    AND no_rekam_medik not ilike '%RM%'*/
                                    and length(no_rekam_medik) = ".($digit_rm)."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        }
        // var_dump($prefix, $sql);
        $pasien = Yii::app()->db->createCommand($sql)->queryRow();
        // echo '<pre>';var_dump($pasien);die;
        if(isset($pasien['nomaksimal'])){
			$nomaksimal = $pasien['nomaksimal']+1;
			$sql = "SELECT normlama_min, normlama_maks FROM konfigsystem_k LIMIT 1";
			$normlama = Yii::app()->db->createCommand($sql)->queryRow();

            // var_dump($nomaksimal);
            if (isset($cek_no_range['nomaksimal'])){
                if ($cek_no_range['nomaksimal'] == $sesuairange){
                    if($nomaksimal == $normlama['normlama_min']){
                        $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                    } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                        $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                    }
                }else{
                    $nomaksimal = ((int)$cek_no_range['nomaksimal'])+1;
                }
            }else{
                if($nomaksimal == $normlama['normlama_min']){
                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                }
                // echo '<pre>';var_dump($nomaksimal);die;
            }
			$no_rm_baru = $prefix.str_pad($nomaksimal, $digit_rm, 0,STR_PAD_LEFT);
            // echo '<pre>';var_dump($no_rm_baru);die;
		}else{
			$no_rm_baru = $prefix.$default;
		}
        $no_rm_baru = 'LB'.$no_rm_baru +1;
                // var_dump($no_rm_baru); die;
        return (string)$no_rm_baru;
    }
    
    public static function noPenutupanPeriodeAkun()
    {
        $default="0001";
        $prefix = 'PPA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenutupan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penutupanperiodeakun_t
				WHERE nopenutupan LIKE ('".$prefix."%')";
        $penutupan = Yii::app()->db->createCommand($sql)->queryRow();
        $nopenutupan =$prefix.(isset($penutupan['nomaksimal']) ? (str_pad($penutupan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenutupan;
    }

    /* no surat keperluan MCU*/
      public static function noKeperluanMCU()
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(no_sarandankesimpulan) AS nop FROM kesimpulanmcu_t";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();

        $temp = explode('/',$genSurat['nop']);

        $noSurat = str_pad((int)$genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."/CU/RSDS/".$bulanRomawi."/".$tahun;

        //$noSurat = str_pad($genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."/CU/RSDS/".$bulanRomawi."/".$tahun;
        return trim($noSurat);
    }


    public static function noClosingKasir()
    {
        $default="0001";
        $prefix = 'CK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(closingkasir_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM closingkasir_t
				WHERE closingkasir_no LIKE ('".$prefix."%')";
        $closingKasir = Yii::app()->db->createCommand($sql)->queryRow();
        $no_closing =$prefix.(isset($closingKasir['nomaksimal']) ? (str_pad($closingKasir['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_closing;
    }

    public static function noTriagePasien()
    {
        $default="0001";
        $prefix = date('ymd');
        $tgl = date('Y-m-d');
        
		$md = NotriagePasienT::model()->count("no_triage_pasien LIKE '%$prefix%'");

        $no = str_pad(($md + 1),4,"0",STR_PAD_LEFT);
        $no_triage = $prefix . "" . $no;

        return $no_triage;
    }


    public static function pengambilanObatPasien()
    {
        $default="0001";
        $prefix = date('ymd');
        $tgl = date('Y-m-d');
        
		$md = PengambilanobatTriageT::model()->count("noresep_triage LIKE '%$prefix%'");

        $no = str_pad(($md + 1),4,"0",STR_PAD_LEFT);
        $noresep_triage = $prefix . "" . $no;

        return $noresep_triage;
    }


    public static function noTriagePasienOld()
    {
        $default="0001";
        $prefix = date('ymd');
        $tgl = date('Y-m-d');
        
		 $sql = "SELECT CAST(MAX(SUBSTR(no_triage_pasien,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM notriage_pasien_t
				WHERE no_bed_triage LIKE ('".$prefix."%') AND DATE(create_time) = '".$tgl."'";
        $closingTriage = Yii::app()->db->createCommand($sql)->queryRow();
        $no_triage =$prefix.(isset($closingTriage['nomaksimal']) ? (str_pad($closingTriage['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_triage;
    }


    /**
     * Generate nomasukkamar untuk masukkamar_t
     * @return string
     */
    public static function noMasukKamar($ruangan_id)
    {
		$default = '001';
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        $nama_ruangan = null;
        if ($ruangan)
            $nama_ruangan=strtoupper(trim($ruangan->ruangan_singkatan));
        $prefix = $nama_ruangan.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomasukkamar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM masukkamar_t
				WHERE nomasukkamar LIKE ('".$prefix."%')";
        // var_dump($sql);
        $masukKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masuk_kamar_baru = $prefix.(isset($masukKamar['nomaksimal']) ? (str_pad($masukKamar['nomaksimal']+1, (strlen($default)), 0,STR_PAD_LEFT)) : $default);
        // var_dump($no_masuk_kamar_baru);
        return $no_masuk_kamar_baru;
    }

    /**
     * Generate nomasukkamar untuk masukkamar_t
     * @return string
     */
    public static function noPindahKamar($ruangan_id)
    {
		$default = '001';
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        $nama_ruangan = null;
        if ($ruangan)
            $nama_ruangan=strtoupper(trim($ruangan->ruangan_singkatan));
        $prefix = $nama_ruangan.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopindahkamar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pindahkamar_t
				WHERE nopindahkamar LIKE ('".$prefix."%')";
        // var_dump($sql);
        $masukKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masuk_kamar_baru = $prefix.(isset($masukKamar['nomaksimal']) ? (str_pad($masukKamar['nomaksimal']+1, (strlen($default)), 0,STR_PAD_LEFT)) : $default);
        // var_dump($no_masuk_kamar_baru);
        return $no_masuk_kamar_baru;
    }

    /**
     * Generate noretur untuk returpembelian_t
     * @return string
     */
    public static function noRetur()
    {
		$default="0001";
        $prefix = 'RETUR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noretur,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returpembelian_t
				WHERE noretur LIKE ('".$prefix."%')";
        $returPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($returPembelian['nomaksimal']) ? (str_pad($returPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

    /**
     * Generate noRencanaLembur untuk rencanalembur_t
     * @return string
     */
    public static function noRencanaLembur()
    {
		$default="0001";
        $prefix = 'RCLB'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(norencana,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanalembur_t
				WHERE norencana LIKE ('".$prefix."%')";
        $rencanaLembur = Yii::app()->db->createCommand($sql)->queryRow();
        $no_rencana =$prefix.(isset($rencanaLembur['nomaksimal']) ? (str_pad($rencanaLembur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_rencana;
    }

    /**
     * Generate noreturresep untuk returresep_t
     * @return string
     */
    public static function noReturResep()
    {
		$default = "0001";
        //$prefix = 'RETRESEP'.date('ymd');
		$prefix = 'RTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returresep_t
				WHERE noreturresep LIKE ('".$prefix."%')";
        $returResep = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($returResep['nomaksimal']) ? (str_pad($returResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

	/**
     * Generate noreturresep untuk returresep_t
     * @return string
     */
    public static function noReturResepStok()
    {
		$default = "0001";
        //$prefix = 'RETRESEP'.date('ymd');
		$prefix = 'RTS'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returresep_t
				WHERE noreturresep LIKE ('".$prefix."%')";
        $returResep = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($returResep['nomaksimal']) ? (str_pad($returResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

     /**
     * Generate nofaktur untuk fakturpembelian_t
     * @return string
     */
    public static function noFaktur()
    {
		$default = "0001";
        $prefix = 'FAKTUR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nofaktur,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM fakturpembelian_t
				WHERE nofaktur LIKE ('".$prefix."%')";
        $fakturPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_faktur_baru = $prefix.(isset($fakturPembelian['nomaksimal']) ? (str_pad($fakturPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_faktur_baru;
    }

     /**
     * Generate noperencnaan untuk rencanakebfarmasi_t
     * @return string
     */
    public static function noPerencanaan()
    {
		$default = "0001";
        $prefix = 'RENCANA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noperencnaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanakebfarmasi_t
				WHERE noperencnaan LIKE ('".$prefix."%')";
        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

     /**
     * Generate noterima untuk penerimaanbarang_t
     * @return string
     */
    public static function noTerimaBarang()
    {
		$default = "0001";
        $prefix = 'TERIMA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noterima,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penerimaanbarang_t
				WHERE noterima LIKE ('".$prefix."%')";
        $penerimaanBarang = Yii::app()->db->createCommand($sql)->queryRow();
        $no_terimabarang_baru = $prefix.(isset($penerimaanBarang['nomaksimal']) ? (str_pad($penerimaanBarang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_terimabarang_baru;
    }


     /**
     * Generate nosuratpenawaran untuk permintaanpenawaran_t
     * @return string
     */
    public static function noPenawaran()
    {
		$default = "0001";
        $prefix = 'PENAWARAN'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nosuratpenawaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM permintaanpenawaran_t
				WHERE nosuratpenawaran LIKE ('".$prefix."%')";
        $permintaanPenawaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_penawaran_baru =$prefix.(isset($permintaanPenawaran['nomaksimal']) ? (str_pad($permintaanPenawaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_penawaran_baru;
    }

     /**
     * Generate nopermintaan untuk permintaanpembelian_t
     * @return string
     */
    public static function noPembelian()
    {
		$default = "0001";
        $prefix = 'PEMBELIAN'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopermintaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM permintaanpembelian_t
				WHERE nopermintaan LIKE ('".$prefix."%')";
        $permintaanPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($permintaanPembelian['nomaksimal']) ? (str_pad($permintaanPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

     /**
     * Generate nopermintaan untuk permintaanpembelian_t
     * @return string
     */
    public static function noPembelianGolongan($golongan)
    {

        $lookup = LookupM::model()->findByAttributes(array(
            'lookup_type'=>'obatalkes_golongan',
            'lookup_value'=>$golongan
        ));


        if (empty($lookup)) {
            return self::noPembelian();
        }

		$default = "001";

        $suffix = "/SP/IFPMC/".$lookup->lookup_kode."/".CustomFunction::getBulan3Digit()[date('m')]."/".date('Y');

		$sql = "SELECT CAST(MAX(SUBSTR(nopermintaan, 1,".(strlen($default)).")) AS integer) nomaksimal
				FROM permintaanpembelian_t
				WHERE nopermintaan ILIKE ('%".$suffix."')";
        $permintaanPembelian = Yii::app()->db->createCommand($sql)->queryRow();

        $no_perencanaan_baru = (isset($permintaanPembelian['nomaksimal']) ? (str_pad($permintaanPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default).$suffix;


        return $no_perencanaan_baru;
    }

     public static function noPembelianTerbaru($typeSumber = null)
    {
        $sumber =  KonfigsystemK::model()->find()->prefix_kode_surat;
        if(!empty($typeSumber)){
            $sumber = $typeSumber;
        }
        $default = "001";

        $suffix = "/IFRS-".$sumber."/".CustomFunction::romawi(date('m'))."/".date('Y');

		$sql = "SELECT CAST(MAX(SUBSTR(nopermintaan, 1,".(strlen($default)).")) AS integer) nomaksimal
				FROM permintaanpembelian_t
				WHERE nopermintaan ILIKE ('%".$suffix."')";
        $permintaanPembelian = Yii::app()->db->createCommand($sql)->queryRow();

        $no_perencanaan_baru = (isset($permintaanPembelian['nomaksimal']) ? (str_pad($permintaanPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default).$suffix;


        return $no_perencanaan_baru;
    }

     /**
     * Generate renkebbarang_no untuk renkebbarang_t
     * @return string
     */
    public static function noPerencanaanKebutuhanBarang()
    {
		$default = "0001";
        $prefix = 'RENCANA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(renkebbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM renkebbarang_t
				WHERE renkebbarang_no LIKE ('".$prefix."%')";
        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

     /**
     * Generate renkebbarang_no untuk renkebbarang_t
     * @return string
     */
    public static function noPerencanaanKebutuhanBahanMakanan()
    {
		$default = "0001";
        $prefix = 'RENBHN'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(renkebbahanmakanan_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM renkebbahanmakanan_t
				WHERE renkebbahanmakanan_no LIKE ('".$prefix."%')";
        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

     /**
     * Generate no kirim sample
     * @return string
     */
    public static function noKirimsample()
    {
	$default="0001";
        $prefix = date('ym');
		$sql = "SELECT CAST(MAX(SUBSTR(nokirimsample,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM kirimsamplelab_t
				WHERE nokirimsample LIKE ('".$prefix."%')";
        $nokirimsample = Yii::app()->db->createCommand($sql)->queryRow();
        $nokirimsample_baru =$prefix.(isset($nokirimsample['nomaksimal']) ? (str_pad($nokirimsample['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokirimsample_baru;
    }

    /**
     * Generate nosediaanpa untuk hasilpemeriksaanpa_t
     * @return string
     */
    public static function noAsesmentPasien()
    {
		$default = "001";
        $prefix = "SPIGD".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(asesmenpasienigd_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM asesmenpasienigd_t
				WHERE asesmenpasienigd_no LIKE ('".$prefix."%')";
        $hasilPemeriksaanPA = Yii::app()->db->createCommand($sql)->queryRow();
        $no_sediaan_pa_baru = $prefix.(isset($hasilPemeriksaanPA['nomaksimal']) ? (str_pad($hasilPemeriksaanPA['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_sediaan_pa_baru;
    }


    /**
     * Generate nosediaanpa untuk hasilpemeriksaanpa_t
     * @return string
     */
    public static function noSediaanPA()
    {
		$default = "001";
        $prefix = date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nosediaanpa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanpa_t
				WHERE nosediaanpa LIKE ('".$prefix."%')";
        $hasilPemeriksaanPA = Yii::app()->db->createCommand($sql)->queryRow();
        $no_sediaan_pa_baru = $prefix.(isset($hasilPemeriksaanPA['nomaksimal']) ? (str_pad($hasilPemeriksaanPA['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_sediaan_pa_baru;
    }

    /**
     * Generate nohasilperiksalab untuk hasilpemeriksaanlab_t
     * @return string
     */
    public static function noHasilPemeriksaanLK()
    {
		$default = "001";
        $prefix = date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nohasilperiksalab,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanlab_t
				WHERE nohasilperiksalab LIKE ('".$prefix."%')";
        $hasilPemeriksaanLab = Yii::app()->db->createCommand($sql)->queryRow();
        $no_hasilperiksalab_baru = $prefix.(isset($hasilPemeriksaanLab['nomaksimal']) ? (str_pad($hasilPemeriksaanLab['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_hasilperiksalab_baru;
    }

    /**
     * Generate noantrian untuk antrian_t berdasarkan loket_id
     * @return string
     */
    public static function noAntrianLoket($loket_id = null, $format = "000")
    {
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".strlen($format).")) AS integer) nomaksimal FROM antrian_t
                WHERE DATE(tglantrian)='".date('Y-m-d')."'
                    ".(!empty($loket_id) ? " AND loket_id = ".$loket_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
		$noantrian_baru = (isset($antrian['nomaksimal']) ? (str_pad($antrian['nomaksimal']+1, strlen($format), 0,STR_PAD_LEFT)) : (str_pad($format+1, strlen($format), 0,STR_PAD_LEFT)));
        return $noantrian_baru;
    }

    /**
     * Generate noantrian untuk antrian_t berdasarkan loket_id
     * @return string
     */
    public static function noAntrianModelAntrian($modelantrian_id = null, $format = "000")
    {
        // $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".strlen($format).")::integer) AS integer) nomaksimal FROM antrian_t
        //         WHERE DATE(tglantrian)='".date('Y-m-d')."'
        //             ".(!empty($modelantrian_id) ? " AND modelantrian_id = ".$modelantrian_id : "");
        $sql = "SELECT CAST(MAX(noantrian::integer) AS integer) nomaksimal FROM antrian_t
                WHERE DATE(tglantrian)='".date('Y-m-d')."'
                ".(!empty($loket_id) ? " AND loket_id = ".$loket_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
		$noantrian_baru = (isset($antrian['nomaksimal']) ? (str_pad($antrian['nomaksimal']+1, strlen($format), 0,STR_PAD_LEFT)) : (str_pad($format+1, strlen($format), 0,STR_PAD_LEFT)));
        return $noantrian_baru;
    }
    
    /**
     * Generate noantrian untuk antrian_t berdasarkan loket_id
     * @return string
     */
    public static function noAntrianModelAntrianInteger($modelantrian_id = null, $loket_id  = null, $tglreservasi = null)
    {
        $date = date('Y-m-d');
        $cond = '';
        if (!empty($modelantrian_id))
            $cond .= " AND modelantrian_id = ".$modelantrian_id;
        
        if (!empty($loket_id))
            $cond .= " AND loket_id = ".$loket_id;
        
        if (!empty($tglreservasi))
            $date = $tglreservasi;
        
        $sql = "SELECT MAX(cast (noantrian as integer)) as nomaksimal FROM antrian_t 
                WHERE DATE(tglantrian)='".$date."' ".$cond;
        
//        var_dump($sql); die;
        
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
		$noantrian_baru = (isset($antrian['nomaksimal']) ? ($antrian['nomaksimal']+1) : 1);
        return $noantrian_baru;
    }

    /**
     * Generate noantrian untuk antrian_t berdasarkan loket_id
     * @return string
     */

     public static function noAntrianBerdasarkanDokter($ruangan_id, $pegawai_id, $jenis = '') {
        $default = '001';
        $tgl = date('Y-m-d');

        $cond = " AND ruangan_id = '" . $ruangan_id . "' ";
        if ($jenis == 'mcu') {
            $jenisperiksa = strtolower($ruangan_id);
            if ($jenisperiksa == Params::JENISPEMERIKSAANMCU_PRIVAT || $jenisperiksa == Params::JENISPEMERIKSAANMCU_VAKSIN) {
                $cond = " AND (jenispemeriksaanmcu ilike '" . Params::JENISPEMERIKSAANMCU_PRIVAT . "' OR jenispemeriksaanmcu ilike '" . Params::JENISPEMERIKSAANMCU_VAKSIN . "' ) ";
            } else {
                $cond = " AND jenispemeriksaanmcu ilike '" . $jenisperiksa . "' ";
            }
        }

        $sql = "select max(no_urutantri) nomaksimal
        from pendaftaran_t
        where date(tgl_pendaftaran) = '" . $tgl . "' " . $cond . " AND pegawai_id = " . $pegawai_id . " ";


        $pendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_urut_baru = (isset($pendaftaran['nomaksimal']) ? (str_pad($pendaftaran['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_urut_baru;
    }

    
    public static function noModelAntrianLoket($modelantrian_id = null, $format = "000")
    {
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".strlen($format).")) AS integer) nomaksimal FROM antrian_t
                WHERE DATE(tglantrian)='".date('Y-m-d')."'
                    ".(!empty($modelantrian_id) ? " AND modelantrian_id = ".$modelantrian_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
		$noantrian_baru = (isset($antrian['nomaksimal']) ? (str_pad($antrian['nomaksimal']+1, strlen($format), 0,STR_PAD_LEFT)) : (str_pad($format+1, strlen($format), 0,STR_PAD_LEFT)));
        return $noantrian_baru;
    }

    /**
     * Generate noantrian untuk antrianfarmasi_t (farmasi)
     * @return string
     */
    public static function noAntrianFarmasi($racikan_id = null)
    {
		$default = '0001';
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".(strlen($default)).")) AS integer) nomaksimal FROM antrianfarmasi_t
                      WHERE date(tglambilantrian)='".$tgl."' AND racikan_id = $racikan_id ";
        $farmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_farmasi_baru = (isset($farmasi['nomaksimal']) ? (str_pad($farmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_farmasi_baru;
    }

    /**
     * Generate noantrian untuk antrianfarmasi_t (farmasi)
     * @return string
     */
    public static function noAntrianFarmasiLoket($racikan_id = null, $modelantrian_id = null)
    {
		$default = '0001';
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".(strlen($default)).")) AS integer) nomaksimal FROM antrianfarmasi_t
                      WHERE date(tglambilantrian)='".$tgl."' AND racikan_id = $racikan_id and modelantrian_id = $modelantrian_id";
        $farmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_farmasi_baru = (isset($farmasi['nomaksimal']) ? (str_pad($farmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_farmasi_baru;
    }


    /**
     * Generate no_rekam_medik untuk pasien_m
     * @param type $prefix
     * @param type $is_pasienluar
     * @param type $sesuairange
     * @return type
     */
    public static function noRekamMedik($prefix='',$is_pasienluar='FALSE',$sesuairange='')
    {
        $default = null;
		$digit_rm = self::DigitRM();
		for($i=1;$i<=$digit_rm;$i++){
            if($i == $digit_rm)
                $default .= "1";
            else
                $default .= "0";
        }

        $cek_no_range = '';
        if (!empty($sesuairange) && empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
					FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                        AND no_rekam_medik ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$'
                                        and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                        AND no_rekam_medik::integer <= '".$sesuairange."'
					ORDER BY no_rekam_medik DESC
					LIMIT 1";
            $cek_no_range = Yii::app()->db->createCommand($sql)->queryRow();
        }

        $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'*/
                                    and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        if(empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'
                                    AND no_rekam_medik not ilike '%RM%'*/
                                    and length(no_rekam_medik) = ".($digit_rm)."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        }
        // var_dump($prefix, $sql);
        $pasien = Yii::app()->db->createCommand($sql)->queryRow();

        if(isset($pasien['nomaksimal'])){
			$nomaksimal = $pasien['nomaksimal']+1;
			$sql = "SELECT normlama_min, normlama_maks FROM konfigsystem_k LIMIT 1";
			$normlama = Yii::app()->db->createCommand($sql)->queryRow();

                        // var_dump($nomaksimal);
                        if (isset($cek_no_range['nomaksimal'])){
                            if ($cek_no_range['nomaksimal'] == $sesuairange){
                                if($nomaksimal == $normlama['normlama_min']){
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                }
                            }else{
                                $nomaksimal = ((int)$cek_no_range['nomaksimal'])+1;
                            }
                        }else{
                            if($nomaksimal == $normlama['normlama_min']){
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            }
                        }
			$no_rm_baru = $prefix.str_pad($nomaksimal, $digit_rm, 0,STR_PAD_LEFT);
		}else{
			$no_rm_baru = $prefix.$default;
		}
                // var_dump($no_rm_baru); die;
        return (string)$no_rm_baru;
    }

    /**
     * Generate no_rekam_medik untuk pasien_m untuk transaksipenjualanresep_umum
     * @param type $prefix
     * @param type $is_pasienluar
     * @param type $sesuairange
     * @return type
     */
    public static function noRekamMedikAP($prefix='',$is_pasienluar='FALSE',$sesuairange='')
    {
        $default = null;
		$digit_rm = self::DigitRM();
		for($i=1;$i<=$digit_rm;$i++){
            if($i == $digit_rm)
                $default .= "1";
            else
                $default .= "0";
        }

        $cek_no_range = '';
        if (!empty($sesuairange) && empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
					FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                        AND no_rekam_medik ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$'
                                        and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                        AND no_rekam_medik::integer <= '".$sesuairange."'
					ORDER BY no_rekam_medik DESC
					LIMIT 1";
            $cek_no_range = Yii::app()->db->createCommand($sql)->queryRow();
        }

        $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'*/
                                    and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                    and no_rekam_medik ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$'
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        if(empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'
                                    AND no_rekam_medik not ilike '%RM%'*/
                                    and length(no_rekam_medik) = ".($digit_rm)."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        }
        // var_dump($prefix, $sql);
        $pasien = Yii::app()->db->createCommand($sql)->queryRow();

        if(isset($pasien['nomaksimal'])){
			$nomaksimal = $pasien['nomaksimal']+1;
			$sql = "SELECT normlama_min, normlama_maks FROM konfigsystem_k LIMIT 1";
			$normlama = Yii::app()->db->createCommand($sql)->queryRow();

                        // var_dump($nomaksimal);
                        if (isset($cek_no_range['nomaksimal'])){
                            if ($cek_no_range['nomaksimal'] == $sesuairange){
                                if($nomaksimal == $normlama['normlama_min']){
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                }
                            }else{
                                $nomaksimal = ((int)$cek_no_range['nomaksimal'])+1;
                            }
                        }else{
                            if($nomaksimal == $normlama['normlama_min']){
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            }
                        }
			$no_rm_baru = $prefix.str_pad($nomaksimal, $digit_rm, 0,STR_PAD_LEFT);
		}else{
			$no_rm_baru = $prefix.$default;
		}
                // var_dump($no_rm_baru); die;
        return (string)$no_rm_baru;
    }

    public static function DigitRM()
    {
        $sql="SELECT jmldigitrm FROM konfigsystem_k LIMIT 1";
        $Konfigjmldigitrm = Yii::app()->db->createCommand($sql)->queryRow();
        $digitrm = $Konfigjmldigitrm['jmldigitrm'];
        return $digitrm;
        
    }
    /**
     * Penambahan jumlah digit baru untuk generate pendaftaran APS dengan jumlah digit dikuragi 1
     * 
     */
    public static function DigitRMNew()
    {
        $sql="SELECT jmldigitrm - 1 as jumlah FROM konfigsystem_k LIMIT 1";
        $Konfigjmldigitrm = Yii::app()->db->createCommand($sql)->queryRow();
        $digitrm = $Konfigjmldigitrm['jumlah'];
        // var_dump($digitrm);die;
        return $digitrm;
        
    }

    /**
     * Generate no_rekam_medik untuk pasien_m untuk APS
     * @param type $prefix
     * @param type $is_pasienluar
     * @param type $sesuairange
     * @return type
     */
    public static function noRekamMedikNew($prefix='',$is_pasienluar='FALSE',$sesuairange='')
    {
        $default = null;
		$digit_rm = self::DigitRMNew();
		for($i=1;$i<=$digit_rm;$i++){
            if($i == $digit_rm)
                $default .= "1";
            else
                $default .= "0";
        }

        $cek_no_range = '';
        if (!empty($sesuairange) && empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
					FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                        AND no_rekam_medik ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$'
                                        and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                        AND no_rekam_medik::integer <= '".$sesuairange."'
					ORDER BY no_rekam_medik DESC
					LIMIT 1";
            $cek_no_range = Yii::app()->db->createCommand($sql)->queryRow();
        }

        $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'*/
                                    and length(no_rekam_medik) = ".($digit_rm + strlen($prefix))."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        // var_dump($sql);die;
        if(empty($prefix)){
            $sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal
                                    FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%'
                                    /*AND no_rekam_medik not ilike '%AP%'
                                    AND no_rekam_medik not ilike '%RM%'*/
                                    and length(no_rekam_medik) = ".($digit_rm)."
                                    ORDER BY no_rekam_medik DESC
                                    LIMIT 1";
        }
        // var_dump($prefix, $sql);
        $pasien = Yii::app()->db->createCommand($sql)->queryRow();

        if(isset($pasien['nomaksimal'])){
			$nomaksimal = $pasien['nomaksimal']+1;
			$sql = "SELECT normlama_min, normlama_maks FROM konfigsystem_k LIMIT 1";
			$normlama = Yii::app()->db->createCommand($sql)->queryRow();

                        // var_dump($nomaksimal);
                        if (isset($cek_no_range['nomaksimal'])){
                            if ($cek_no_range['nomaksimal'] == $sesuairange){
                                if($nomaksimal == $normlama['normlama_min']){
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                    $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                                }
                            }else{
                                $nomaksimal = ((int)$cek_no_range['nomaksimal'])+1;
                            }
                        }else{
                            if($nomaksimal == $normlama['normlama_min']){
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            } else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                                $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                            }
                        }
			$no_rm_baru = $prefix.str_pad($nomaksimal, $digit_rm, 0,STR_PAD_LEFT);
		}else{
			$no_rm_baru = $prefix.$default;
		}
                // var_dump($no_rm_baru); die;
        return (string)$no_rm_baru;
    }
    /**
     * Generate no_rekam_medik untuk pasien_m (Penunjang)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikAPS($prefix)
    {
		return self::noRekamMedikNew($prefix,'TRUE');
    }
    /**
     * Generate no_rekam_medik untuk pasien_m (Penunjang)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikPenunjang($prefix)
    {
		return self::noRekamMedik($prefix,'TRUE');
    }

    /**
     * Generate no_rekam_medik untuk pasien_m (Janji Poli)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikJanjiPoli($prefix = 'JP')
    {
        return self::noRekamMedik($prefix,'TRUE');
    }
    /**
     * Generate no_rekam_medik untuk pasien_m (Booking Kamar)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikBookingKamar($prefix = 'BK')
    {
        return self::noRekamMedik($prefix,'TRUE');
    }
    /**
     * Generate no_pendaftaran untuk pendaftaran_t
     * @param type $instalasi_id
     * @param type $tgl_pendaftaran
     * @return string
     */
    // public static function noPendaftaran($instalasi_id, $tgl_pendaftaran = null)
    // {
    //     $default = '0001';
    // 	$konfig = KonfigsystemK::model()->find();
    // 	$tgl = date('ymd');
    // 	if(!empty($tgl_pendaftaran)){
    // 		$tgl = date('ymd', strtotime($tgl_pendaftaran));
    // 	}
    // 	$kode_instalasi = "";
    // 	if($instalasi_id == Params::INSTALASI_ID_RJ){
    // 		$kode_instalasi = $konfig->nopendaftaran_rj;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_RD){
    // 		$kode_instalasi = $konfig->nopendaftaran_gd;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_RI){
    // 		$kode_instalasi = $konfig->nopendaftaran_ri;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_LAB){
    // 		$kode_instalasi = $konfig->nopendaftaran_lab;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_RAD){
    // 		$kode_instalasi = $konfig->nopendaftaran_rad;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_IBS){
    // 		$kode_instalasi = $konfig->nopendaftaran_ibs;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_REHAB){
    // 		$kode_instalasi = $konfig->nopendaftaran_rehabmedis;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_JZ){
    // 		$kode_instalasi = $konfig->nopendaftaran_jenazah;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_FARMASI){
    // 		$kode_instalasi = $konfig->nopendaftaran_apotik;
    // 	}else if($instalasi_id == Params::INSTALASI_ID_APS){
    //         $kode_instalasi = $konfig->mr_pasienaps;
    //     }else{
    // 		$kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    // 	}

    //     $prefix=$kode_instalasi.$tgl;
    //     $sql = "SELECT CAST(MAX(SUBSTR(no_pendaftaran,".(strlen($prefix)).",".strlen($default).")) AS integer) nomaksimal 
    // 			FROM pendaftaran_t
    // 			WHERE no_pendaftaran LIKE ('".$prefix."%')"; // tracing error
    //     // echo "<pre>";
    //     // var_dump($sql, $kode_instalasi . $tgl);die;
    //     $nopendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
    //     $no_pendaftaran_baru=$prefix.(isset($nopendaftaran['nomaksimal']) ? (str_pad($nopendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
    //     return $no_pendaftaran_baru;
    // }

    public static function noPendaftaran($instalasi_id, $tgl_pendaftaran = null)
    {
        $default = '0001';
        $konfig = KonfigsystemK::model()->find();
        $tgl = date('ymd');
        if (!empty($tgl_pendaftaran)) {
            $tgl = date('ymd', strtotime($tgl_pendaftaran));
        }
        $kode_instalasi = "";
        if ($instalasi_id == Params::INSTALASI_ID_RJ) {
            $kode_instalasi = $konfig->nopendaftaran_rj;
        } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
            $kode_instalasi = $konfig->nopendaftaran_gd;
        } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
            $kode_instalasi = $konfig->nopendaftaran_ri;
        } else if ($instalasi_id == Params::INSTALASI_ID_LAB) {
            $kode_instalasi = $konfig->nopendaftaran_lab;
        } else if ($instalasi_id == Params::INSTALASI_ID_RAD) {
            $kode_instalasi = $konfig->nopendaftaran_rad;
        } else if ($instalasi_id == Params::INSTALASI_ID_IBS) {
            $kode_instalasi = $konfig->nopendaftaran_ibs;
        } else if ($instalasi_id == Params::INSTALASI_ID_REHAB) {
            $kode_instalasi = $konfig->nopendaftaran_rehabmedis;
        } else if ($instalasi_id == Params::INSTALASI_ID_JZ) {
            $kode_instalasi = $konfig->nopendaftaran_jenazah;
        } else if ($instalasi_id == Params::INSTALASI_ID_FARMASI) {
            $kode_instalasi = $konfig->nopendaftaran_apotik;
        } else {
            $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        }

        $prefix = $kode_instalasi . $tgl;

        $col = "SUBSTR(no_pendaftaran,".(strlen($prefix)+1).",".strlen($default).")";

        $sql = "SELECT MAX(CAST(".$col." AS integer)) nomaksimal
				FROM pendaftaran_t
				WHERE no_pendaftaran LIKE ('".$prefix."%') 
                and ".$col." ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$' 
                and (".$col.") is not null";
        $nopendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pendaftaran_baru = $prefix . (isset($nopendaftaran['nomaksimal']) ? (str_pad($nopendaftaran['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_pendaftaran_baru;
    }

    /**
     * Generate noPendaftaranPenjualanResep untuk pendaftaran_t
     * @param type
     * @return string
     */
    public static function noPendaftaranPenjualanResep($tgl_pendaftaran = null)
    {
		return self::noPendaftaran(Params::INSTALASI_ID_FARMASI, $tgl_pendaftaran);
    }

    /**
     * Generate noPendaftaranPenjualanResep untuk pendaftaran_t
     * @param type
     * @return string
     */
    public static function noPendaftaranPenjualanAPS($tgl_pendaftaran = null)
    {
		return self::noPendaftaran(Params::INSTALASI_ID_APS, $tgl_pendaftaran);
    }

    /**
     * Generate no_pengambilansample untuk pengambilansample_t
     * @return string
	 * RND-8327
     */
    public static function noPengambilanSample($alatmedis_id = null)
    {
		$default = "0001";
		$prefix = date('y')."00";
		if(!empty($alatmedis_id)){
			$sqlalat = "SELECT *
					FROM alatmedis_m
					WHERE alatmedis_id = ".$alatmedis_id;
			$alatmedis = Yii::app()->db->createCommand($sqlalat)->queryRow();
			$prefix = date('y').$alatmedis['alatmedis_kode'];
			if(!empty($alatmedis['alatmedis_format'])){
				$default = $alatmedis['alatmedis_format'];
			}
		}
        $sql = "SELECT CAST(MAX(SUBSTR(no_pengambilansample,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengambilansample_t
				WHERE no_pengambilansample LIKE ('".$prefix."%')";
        $pengambilanSample = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pengambilansample_baru=$prefix.(isset($pengambilanSample['nomaksimal']) ? (str_pad($pengambilanSample['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pengambilansample_baru;
    }

    /**
     * Generate bookingkamar_no untuk bookingkamar_t
     * @return string
     */
    public static function noBookingKamar()
    {
		$default = '001';
        $tgl = date('ymd');
        $prefix = 'BOOK'.$tgl;
        $sql = "SELECT CAST(MAX(SUBSTR(bookingkamar_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM bookingkamar_t
				WHERE bookingkamar_no LIKE ('".$prefix."%')";
        $bookingKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_book_baru = $prefix.(isset($bookingKamar['nomaksimal']) ? (str_pad($bookingKamar['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		return $no_book_baru;
    }

    /**
     * Generate no_urutantri untuk pendaftaran_t
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrian($ruangan_id, $tgl = null, $jenis = '', $lantai = '')
    {
        $default = '001';        
        $cond = " AND ruangan_id = '" . $ruangan_id . "' ";
        
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }
        
        if ($jenis == 'hd'){
            $cond = " AND lantai_hd ilike '" . $lantai . "' ";

            // cek data pendaftaran ke konsulpoli_t
            $sql2 = "select max(no_antriankonsul) nomaksimal 
                    from konsulpoli_t 
                    where date(tglkonsulpoli) = '" . $tgl . "' and lantai_hd = '" . $lantai . "'";
            $konsul = Yii::app()->db->createCommand($sql2)->queryRow();
            $no_konsul = !empty($konsul['nomaksimal']) ? $konsul['nomaksimal'] : "";
            
            $sql = "select max(no_urutantri) nomaksimal
                from pendaftaran_t 
                where date(tgl_pendaftaran) = '" . $tgl . "' " . $cond . " ";
            $pendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
            
            $nomor = "";
            if (!empty($pendaftaran['nomaksimal'])) {
                if ($pendaftaran['nomaksimal'] > $no_konsul) {
                    $nomor = $pendaftaran['nomaksimal'];
                } else if (!empty($no_konsul)) {
                    $nomor = $no_konsul;
                }
            } else {
                $nomor = $no_konsul;
            }
            $no_urut_baru = (!empty($nomor) ? (str_pad($nomor + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        }else{
            $sql_poli = "select max(no_urutantri) nomaksimal
                                    from pendaftaran_t 
                                    where date(tgl_pendaftaran) = '".$tgl."'::date AND ruangan_id = '".$ruangan_id."'";
            $pendaftaran_poli = Yii::app()->db->createCommand($sql_poli)->queryRow();

            $sql_janjipoli = "select max(no_antrianjanji) nomaksimal
                                    from buatjanjipoli_t 
                                    where date(tgljadwal) = '".$tgl."'::date AND ruangan_id = '".$ruangan_id."'";
            $pendaftaran_janji_poli = Yii::app()->db->createCommand($sql_janjipoli)->queryRow();
    //        
            $max_poli = isset($pendaftaran_poli['nomaksimal']) ? $pendaftaran_poli['nomaksimal'] : 0;
            $max_janji = isset($pendaftaran_janji_poli['nomaksimal']) ? $pendaftaran_janji_poli['nomaksimal'] : 0;
            
            if ((int)$max_poli < (int)$max_janji) {
                $max_poli = $max_janji;
            }

            $no_urut_baru = str_pad($max_poli+1, strlen($default), 0,STR_PAD_LEFT);
        }
//        
        
        
        
        return $no_urut_baru;
    }

    /**
     * Generate no_urutantri untuk pendaftaran_t
     * dan Generate no_antriankonsul untuk konsulpoli_t
     * karena ada rujukan poli, jadi terjadi duplikat kalau generate no pendaftaran dan no konsul di pisah
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrianPPKonsul($ruangan_id)
    {
        $default = '001';
        $tgl = date('Y-m-d');
        $sqlPendaftaran = "select max(no_urutantri) nomaksimal
				from pendaftaran_t
				where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $pendaftaran = Yii::app()->db->createCommand($sqlPendaftaran)->queryRow();
        $no_urut_baru_pendaftaran=(isset($pendaftaran['nomaksimal']) ? (str_pad($pendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        $sqlKonsulPoli = "select max(no_antriankonsul) nomaksimal
				from konsulpoli_t
				where date(tglkonsulpoli) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $konsulPoli = Yii::app()->db->createCommand($sqlKonsulPoli)->queryRow();
        $no_urut_baru_konsul=(isset($konsulPoli['nomaksimal']) ? (str_pad($konsulPoli['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        if(empty($pendaftaran['nomaksimal']) && empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_pendaftaran;
        }
        else if(!empty($pendaftaran['nomaksimal']) && empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_pendaftaran;
        }
        else if(empty($pendaftaran['nomaksimal']) && !empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_konsul;
        }
        else if(!empty($pendaftaran['nomaksimal']) && !empty($konsulPoli['nomaksimal'])){
            $no_daftar = (int)$no_urut_baru_pendaftaran;
            $no_konsul = (int)$no_urut_baru_konsul;
            if($no_daftar >= $no_konsul){
                return $no_urut_baru_pendaftaran;
            }
            else{
                return $no_urut_baru_konsul;
            }
        }

    }


    public static function noAntrianPPKonsul2($ruangan_id)
    {
        $default = '001';
        $tgl = date('Y-m-d');
        $sqlPendaftaran = "select max(no_urutantri) nomaksimal
				from pendaftaran_t
				where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $pendaftaran = Yii::app()->db->createCommand($sqlPendaftaran)->queryRow();
        $no_urut_baru_pendaftaran=(isset($pendaftaran['nomaksimal']) ? (str_pad($pendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        $sqlKonsulPoli = "select max(no_antrianordertindakan) nomaksimal
				from ruangtindakan_t
				where date(tglordertindakan) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $konsulPoli = Yii::app()->db->createCommand($sqlKonsulPoli)->queryRow();
        $no_urut_baru_konsul=(isset($konsulPoli['nomaksimal']) ? (str_pad($konsulPoli['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        if(empty($pendaftaran['nomaksimal']) && empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_pendaftaran;
        }
        else if(!empty($pendaftaran['nomaksimal']) && empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_pendaftaran;
        }
        else if(empty($pendaftaran['nomaksimal']) && !empty($konsulPoli['nomaksimal'])){
            return $no_urut_baru_konsul;
        }
        else if(!empty($pendaftaran['nomaksimal']) && !empty($konsulPoli['nomaksimal'])){
            $no_daftar = (int)$no_urut_baru_pendaftaran;
            $no_konsul = (int)$no_urut_baru_konsul;
            if($no_daftar >= $no_konsul){
                return $no_urut_baru_pendaftaran;
            }
            else{
                return $no_urut_baru_konsul;
            }
        }

    }


    /**
     * Generate no_masukpenunjang untuk pasienmasukpenunjang_t
     * @param type $kode_instalasi
     * @return string
     */
    public static function noMasukPenunjang($kode_instalasi = '', $tgl = null)
    {
        $default = "001";
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }
        if(empty($kode_instalasi)){
                $kode_instalasi = Yii::app()->user->getState('instalasi_singkatan');
        }
        $prefix = $kode_instalasi;
        $sql = "SELECT CAST(MAX(SUBSTR(no_masukpenunjang,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pasienmasukpenunjang_t
				WHERE no_masukpenunjang LIKE ('".$kode_instalasi."%') AND DATE(tglmasukpenunjang) = '".$tgl."'";
        $pasienMasukPenunjang = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masukpenunjang_baru=$prefix.(isset($pasienMasukPenunjang['nomaksimal']) ? (str_pad($pasienMasukPenunjang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_masukpenunjang_baru;
    }


    public static function noMasukPenunjang2($kode_instalasi = '', $tgl = null)
    {
        $default = "0001";
        if (empty($tgl)) {
            $tgl = date('Ymd');
        }
        if(empty($kode_instalasi)){
                $kode_instalasi = Yii::app()->user->getState('instalasi_singkatan');
        }
        $prefix = $kode_instalasi.$tgl;
        $sql = "SELECT CAST(MAX(SUBSTR(no_masukpenunjang,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pasienmasukpenunjang_t
				WHERE no_masukpenunjang LIKE ('".$prefix."%')";
        $pasienMasukPenunjang = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masukpenunjang_baru=$prefix.(isset($pasienMasukPenunjang['nomaksimal']) ? (str_pad($pasienMasukPenunjang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_masukpenunjang_baru;
    }

    /**
     * Generate noperminatanpenujang untuk permintaankepenunjang_t
     * @param type $prefix
     * @return string
     */
    public static function noPermintaanPenunjang($prefix='')
    {
		$default = "0001";
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(noperminatanpenujang,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                        FROM permintaankepenunjang_t
                        WHERE noperminatanpenujang LIKE ('".$prefix."%') AND DATE(tglpermintaankepenunjang) = '".$tgl."'";
        $no = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permintaan_baru=$prefix.(isset($no['nomaksimal']) ? (str_pad($no['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permintaan_baru;
    }

    public static function noPermintaanPasienKirimKeunitlain($prefix='')
    {
		$default = "0001";
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(no_permintaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                        FROM pasienkirimkeunitlain_t
                        WHERE no_permintaan LIKE ('".$prefix."%') AND DATE(tgl_kirimpasien) = '".$tgl."'";
        $no = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permintaan_baru=$prefix.(isset($no['nomaksimal']) ? (str_pad($no['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permintaan_baru;
    }

    /**
     * Generate no_urutperiksa untuk pasienmasukpenunjang_t
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrianPenunjang($ruangan_id)
    {
        if(!empty($ruangan_id)){
			$default = '001';
            $tgl = date('Y-m-d');
            $sql = "select max(no_urutperiksa) nomaksimal
					from pasienmasukpenunjang_t
					where date(tglmasukpenunjang) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $pasienMasukPenunjang = Yii::app()->db->createCommand($sql)->queryRow();
            $no_urutperiksa_baru=(isset($pasienMasukPenunjang['nomaksimal']) ? (str_pad($pasienMasukPenunjang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $no_urutperiksa_baru;
        } else {
            return null;
        }
    }

    /**
     * Generate nourut untuk pasienkirimkeunitlain_t
     * @param type $ruangan_id
     * @return int
     */
    public static function noUrutPasienKirimKeUnitLain($ruangan_id)
    {
        $nourut_baru = null;
        if(!empty($ruangan_id)){
            $tgl = date('Y-m-d');
            $sql = "select max(nourut) nomaksimal
					from pasienkirimkeunitlain_t
					where date(tgl_kirimpasien) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $pasienKeUnitLain = Yii::app()->db->createCommand($sql)->queryRow();
            $nourut_baru = (isset($pasienKeUnitLain['nomaksimal']) ? $pasienKeUnitLain['nomaksimal']+1 : 1);
        }
        return $nourut_baru;
    }
    /**
     * Generate norencanaoperasi untuk rencanaoperasi_t
     * @return string
     */
    public static function noRencanaOperasi()
    {
		$default = "001";
        $prefix = 'RENCANA'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(norencanaoperasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanaoperasi_t
				WHERE norencanaoperasi LIKE ('".$prefix."%')";
        $rencanaOperasi= Yii::app()->db->createCommand($sql)->queryRow();
        $norencanaoperasi_baru=$prefix.(isset($rencanaOperasi['nomaksimal']) ? (str_pad($rencanaOperasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $norencanaoperasi_baru;
    }

    /**
     * Generate nohasilrm untuk hasilpemeriksaanrm_t
     * @return string
     */
    public static function noHasilPemeriksaanRM()
    {
		$default = "001";
        $prefix = 'HASIL'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nohasilrm,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanrm_t
				WHERE nohasilrm LIKE ('".$prefix."%')";
        $hasilPemeriksaan= Yii::app()->db->createCommand($sql)->queryRow();
        $nohasilrm_baru=$prefix.(isset($hasilPemeriksaan['nomaksimal']) ? (str_pad($hasilPemeriksaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nohasilrm_baru;
    }

    /**
     * Generate nopengajuan untuk pengajuanbahanmkn_t
     * @return string
     */
    public static function noPengajuanBahan($typeSumber=null)
    {
        $sumber = "RS";
        if(!empty($typeSumber)){
            $sumber = $typeSumber;
        }

		$default = "001";
//        $prefix = 'PB'.date('ymd');
        $prefix = 'BELIBM'.$sumber.''.date('ymd');

        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuanbahanmkn_t
				WHERE nopengajuan LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nobaru=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobaru;
    }

    /**
     * Generate nopenerimaanbahan untuk terimabahanmakan_t
     * @return string
     */
    public static function noPenerimaanBahan()
    {
		$default = "001";
        $prefix = 'TB'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopenerimaanbahan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimabahanmakan_t
				WHERE nopenerimaanbahan LIKE ('".$prefix."%')";
		$terimaBahan= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaanbahan_baru=$prefix.(isset($terimaBahan['nomaksimal']) ? (str_pad($terimaBahan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaanbahan_baru;
    }

    /**
     * Generate nopesanmenu untuk pesanmenudiet_t
     * @return string
     */
    public static function noPesanMenuDiet()
    {
		$default = "00001";
        $prefix = 'PD'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopesanmenu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanmenudiet_t
				WHERE nopesanmenu LIKE ('".$prefix."%')";
        $pesanMenuDiet= Yii::app()->db->createCommand($sql)->queryRow();
        $nopesanmenu_baru = $prefix.(isset($pesanMenuDiet['nomaksimal']) ? (str_pad($pesanMenuDiet['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopesanmenu_baru;
    }

    /**
     * generate nokirimmenu untuk kirimmenudiet_t
     * @return string
     */
    public static function noKirimMenuDiet()
    {
		$default = "00001";
        $prefix = 'KD'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nokirimmenu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM kirimmenudiet_t
				WHERE nokirimmenu LIKE ('".$prefix."%')";
        $kirimMenuDiet= Yii::app()->db->createCommand($sql)->queryRow();
        $nokirimmenu_baru=$prefix.(isset($kirimMenuDiet['nomaksimal']) ? (str_pad($kirimMenuDiet['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokirimmenu_baru;
    }

    /**
     * Generate nojadwal untuk jadwalkunjunganrm_t
     * @return string
     */
    public static function noUrutJadwalRencanaRM()
    {
		$default = "001";
        $prefix = "JADWAL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nojadwal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jadwalkunjunganrm_t
				WHERE nojadwal LIKE ('".$prefix."%')";
        $jadwalKunjungan= Yii::app()->db->createCommand($sql)->queryRow();
        $nojadwal_baru = $prefix.(isset($jadwalKunjungan['nomaksimal']) ? (str_pad($jadwalKunjungan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nojadwal_baru;
    }
    /**
     * Generate noresep untuk penjualanresep_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noResep($instalasi_id)
    {
		$instalasi = InstalasiM::model()->findByPk($instalasi_id);
		$default = "0001";
        $prefix = "PR".strtoupper($instalasi->instalasi_singkatan).date("ymd");
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    /**
     * Generate noresep untuk reseptur_t
     * @return string
     */
    public static function noResepReseptur()
    {
        $default = "0001";
        $prefix = "R".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM reseptur_t
				WHERE noresep LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    /**
     * Generate noresep untuk reseptur_t
     * @return string
     */



    public static function noResepTriage()
    {
        $default = "0001";
        $prefix = "RT".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(noresep_triage,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengambilanobat_triage_t
				WHERE noresep_triage LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }

    public static function noResepOK()
    {
        $default = "0001";
        $prefix = "ROK".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(noresep_ok,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM resepturok_t
				WHERE noresep_ok LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }


    
    public static function noUangMuka($loginpemakai_id = null)
    {

        if (empty($loginpemakai_id)) {
            $loginpemakai_id = Params::LOGINPEMAKAI_ID_ADMIN;
        }

        $peg = LoginpemakaiK::model()->findByPk($loginpemakai_id, array('select'=>'loginpemakai_id, pegawai_id'));

        $default = "00001";
        $prefix = "UMP".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(nouangmuka,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM bayaruangmuka_t
				WHERE nouangmuka LIKE ('".$prefix."%')
                and create_loginpemakai_id = ".$loginpemakai_id;

        $uangmuka= Yii::app()->db->createCommand($sql)->queryRow();
        $uangmuka_baru = $prefix
            .(isset($uangmuka['nomaksimal']) ? (str_pad($uangmuka['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default)
            .($peg->pegawai_id ?? Params::LOGINPEMAKAI_ID_ADMIN);
        return $uangmuka_baru;
    }

    /**
     * Generate nourutkasir untuk tandabuktibayar_t
     * @param type $ruangan_id
     * @return type
     */
    public static function noUrutKasir($ruangan_id)
    {
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(nourutkasir) AS integer) nourut FROM tandabuktibayar_t
                WHERE ruangan_id = $ruangan_id AND date(tglbuktibayar)='".$tgl."'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nourutkasir_baru = (isset($data['nourut']) ? $data['nourut']+1 : 1);
        return $nourutkasir_baru;
    }

    /**
     * Generate nobuktibayar untuk tandabuktibayar_t
     * @return type
     */
    public static function noBuktiBayar()
    {
		$default = "000001";
        $prefix = "/BKM/".CustomFunction::romawi(date('m')).'/'.date('Y');
        //$prefix = 'BKM'.date('ymd');

        $col = "SUBSTR(nobuktibayar, 0, ".(strlen($default)+1).")";

        $regexp = "regexp_replace(".$col.", '\D', '', 'g')";

        $sql = "SELECT MAX(CAST(".$regexp." AS integer)) nomaksimal
				FROM tandabuktibayar_t
				WHERE nobuktibayar LIKE ('%".$prefix."%')";
        /*
		$sql = "SELECT CAST(MAX(SUBSTR(nobuktibayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktibayar_t
				WHERE nobuktibayar LIKE ('".$prefix."%')";
         *
         */
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktibayar_baru = (isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default).$prefix;
        return $nobuktibayar_baru;
    }

    public static function noBuktiBayarNew()
    {
		$default = "000001";
        $jumlahAngka = 6;
        $prefix = '/'.date('dmy') . '/' . Yii::app()->user->getState('pegawai_id');
        $loginpemakai = Yii::app()->user->getState('loginpemakai_id');

        $query = "SELECT  MAX(CAST(SUBSTRING(nobuktibayar, 0, 7) AS INTEGER)) AS nobuktibayar FROM tandabuktibayar_t where nobuktibayar ILIKE ('%".$prefix."%') AND create_loginpemakai_id = '" . $loginpemakai ."'";

        $data = Yii::app()->db->createCommand($query)->queryRow();
        // var_dump($data);die;
        $maxNoBuktiBayar = $data['nobuktibayar'];
        if ($data['nobuktibayar'] === null) {
            $maxNoBuktiBayar = 0;
        }
        $maxNoBuktiBayar = str_pad($maxNoBuktiBayar+1, $jumlahAngka, '0', STR_PAD_LEFT);
        // return $maxKodeBarang;
        // var_dump($maxNoBuktiBayar);die;
        return $maxNoBuktiBayar . $prefix;
        //$prefix = 'BKM'.date('ymd');

    }

	/**
     * Generate nobuktibayar untuk tandabuktibayar_t
     * @return type
     */
    public static function noBuktiBayarAnggaran($tglbuktibayar = null)
    {
        return self::noBuktiBayar();
        /*
		$default = "00001";
		$tgl = date('Y-m-d');
		if(!empty($tglbuktibayar)){
			$tgl = $tglbuktibayar;
		}
        $prefix = 'BKMA'.date('ymd',  strtotime($tgl));
		$sql = "SELECT CAST(MAX(SUBSTR(nobuktibayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktibayar_t
				WHERE nobuktibayar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktibayar_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktibayar_baru;
         *
         */
    }

    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return type
     */
    public static function noBuktiKeluarAnggaran($tglbuktikeluar = null)
    {
        return self::noBuktiKeluar();

        /*
		$default = "00001";
		$tgl = date('Y-m-d');
		if(!empty($tglbuktikeluar)){
			$tgl = $tglbuktikeluar;
		}
        $prefix = 'BKKA'.date('ymd',  strtotime($tgl));
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE nokaskeluar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = $prefix.(isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $nokaskeluar_baru;
         *
         */
    }

    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return type
     */
    public static function noBuktiKeluar()
    {
		$default = "0001";

        $prefix = "/BKK/".CustomFunction::romawi(date('m')).'/'.date('Y');
        //$prefix = 'BKK'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar, 0, ".(strlen($default)+1).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE nokaskeluar LIKE ('%".$prefix."%')";
        /*
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE nokaskeluar LIKE ('".$prefix."%')";
         *
         */

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = (isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default).$prefix;
        return $nokaskeluar_baru;
    }

    /**
     * Generate nopembayaran untuk pembayaranpelayanan_t
     * @return string
     */
    public static function noPembayaran($kode = null, $loginpemakai_id = null)
    {
		$default = "00001";


        if (empty($kode)) {
            $kode = 'K';
        }

        $prefix = $kode.'-'.date('ymd').'-';

        $col = "SUBSTR(nopembayaran,".(strlen($prefix)+1).",".(strlen($default)).")";
        $regexp = "regexp_replace(".$col.", '\D', '', 'g')";

        $sql = "SELECT MAX(CAST(".$regexp." AS integer)) nomaksimal
				FROM pembayaranpelayanan_t
				WHERE nopembayaran LIKE ('".$prefix."%')";

        if (!empty($loginpemakai_id)) {
            $sql .= ' and create_loginpemakai_id = '.$loginpemakai_id;
        }

		$data = Yii::app()->db->createCommand($sql)->queryRow();


        $nopembayaran_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $nopembayaran_baru;
    }

    /**
     * Generate noreturbayar untuk returbayarpelayanan_t
     * @return string
     */
    public static function noReturBayarPelayanan()
    {
		$default = "0001";
        $prefix = 'RTB'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturbayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returbayarpelayanan_t
				WHERE noreturbayar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $noretur_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noretur_baru;
    }

    /**
     * Generate nopenerimaan untuk penerimaanumum_t
     * @return string
     */
    public static function noPenerimaanUmum()
    {
        $default = "00001";
        $prefix = 'TRU'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penerimaanumum_t
				WHERE nopenerimaan LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaan_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaan_baru;
    }

    /**
     * Generate nopengeluaran untuk pengeluaranumum_t
     * @return string
     */
    public static function noPengeluaranUmum()
    {
		$default = "00001";
        $prefix = 'KLU'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopengeluaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengeluaranumum_t
				WHERE nopengeluaran LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nopengeluaran_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopengeluaran_baru;
    }

    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return string
     */
    public static function noKasKeluar()
    {
        return self::noBuktiKeluar();
        /*
		$default = "00001";
        $prefix = 'KKL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE nokaskeluar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokaskeluar_baru;
         *
         */
    }

    /**
     * Generate nourutbayi untuk kelahiranbayi_t
     * @return string
     */
    public static function noUrutBayi($pasien_id){
        $persalinan = PersalinanT::model()->findByAttributes(array('pasien_id'=>$pasien_id));
        $sql = "select MAX(nourutbayi) AS nomaksimal
				from kelahiranbayi_t
				where persalinan_id= '$persalinan->persalinan_id'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nourut_baru = (isset($data['nomaksimal']) ? $data['nomaksimal'] + 1 : 1);
        return $nourut_baru;
    }

    /**
     * Generate nopemesanan untuk pesanobatalkes_t
     * @return string
     */
    public static function noPemesanan()
    {
        $default = "00001";
        $prefix = 'PSNOA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopemesanan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanobatalkes_t
				WHERE nopemesanan LIKE ('".$prefix."%')";
		$nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nopemesanan_baru = $prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemesanan_baru;
    }

    /**
     * Generate nomutasioa untuk mutasioaruangan_t
     * @return string
     */
    public static function noMutasi()
    {
		$default = "00001";
        $prefix = 'MUTOA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomutasioa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM mutasioaruangan_t
				WHERE nomutasioa LIKE ('".$prefix."%')";
        $no_penawaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_penawaran_baru = $prefix.(isset($no_penawaran['nomaksimal']) ? (str_pad($no_penawaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_penawaran_baru;
    }

    /**
     * Generate noterimamutasi untuk terimamutasi_t
     * @return string
     */
    public static function noTerimaMutasi()
    {
		$default = "00001";
        $prefix = 'TRMUT'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noterimamutasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimamutasi_t
				WHERE noterimamutasi LIKE ('".$prefix."%')";
        $terimaMutasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noterimamutasi_baru = $prefix.(isset($terimaMutasi['nomaksimal']) ? (str_pad($terimaMutasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noterimamutasi_baru;
    }
    /**
     * generate nourut_pinjam untuk peminjamanrm_t
     * @return type
     */
    public static function noUrutPinjamRM()
    {
		$default = "00001";
// RND-8408       $prefix = 'PJMRM'.date('ymd'); // nourut terlalu panjang maks. 5 karakter
        $prefix = '';
		$sql = "SELECT CAST(MAX(SUBSTR(nourut_pinjam,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM peminjamanrm_t
				WHERE nourut_pinjam LIKE ('".$prefix."%')";
        $peminjamanRM = Yii::app()->db->createCommand($sql)->queryRow();
        $nourut_pinjam_baru = $prefix.(isset($peminjamanRM['nomaksimal']) ? (str_pad($peminjamanRM['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nourut_pinjam_baru;
    }
    /**
     * generate nourut_keluar untuk pengirimanrm_t
     * @return type
     */
	public static function noUrutKeluarRM()
    {
		$default = "00001";
        $prefix = '';
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(nourut_keluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal FROM pengirimanrm_t
                WHERE date(tglpengirimanrm)='".$tgl."'";
        $pengirimanRM = Yii::app()->db->createCommand($sql)->queryRow();
		$nourut_keluar_baru = $prefix.(isset($pengirimanRM['nomaksimal']) ? (str_pad($pengirimanRM['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nourut_keluar_baru;
    }
    /**
     * Generate nodokumenrm untuk dokrekammedis_m
     * @return string
     */
    public static function noDokumenRM()
    {
		$default = "0001";
        $prefix = date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nodokumenrm,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM dokrekammedis_m
				WHERE nodokumenrm LIKE ('".$prefix."%')";
        $dokRekammedis = Yii::app()->db->createCommand($sql)->queryRow();
        $nodokumenrm_baru = $prefix.(isset($dokRekammedis['nomaksimal']) ? (str_pad($dokRekammedis['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nodokumenrm_baru;
    }

    /**
     * generate nourut_penggunaan coolbox
     * @author  Andyka Putra <andykaputra@.com>
     * @return type
     */
    public static function noPenggunaanCoolbox() {
        $default = "0001";
        $prefix = 'CB' . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_penggunaan_coolbox," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                        FROM penggunaan_coolbox_t
                        WHERE no_penggunaan_coolbox LIKE ('" . $prefix . "%')";
        $dokpenggunaan = Yii::app()->db->createCommand($sql)->queryRow();
        $no_penggunaan_coolbox_baru = $prefix . (isset($dokpenggunaan['nomaksimal']) ? (str_pad($dokpenggunaan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_penggunaan_coolbox_baru;
    }

    /**
     * Generate barang_kode untuk barang_m
     * @return type
     */
    public static function kodeBarang()
    {
        $sql = "SELECT MAX(barang_kode) AS kodebarang FROM barang_m";
        $barang = Yii::app()->db->createCommand($sql)->queryRow();
        $kodebarang_baru = (isset($barang['kodebarang']) ? $barang['kodebarang']+1 : 1);
        return $kodebarang_baru;
    }
    /**
     * Generate nopemesanan untuk pesanbarang_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noPemesananBarang()
    {
        $default = "0001";
        $prefix = "PSNBRG".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopemesanan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanbarang_t
				WHERE nopemesanan LIKE ('".$prefix."%')";
		$pesanBarang= Yii::app()->db->createCommand($sql)->queryRow();
        $nopemesanan_baru = $prefix.(isset($pesanBarang['nomaksimal']) ? (str_pad($pesanBarang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemesanan_baru;
    }
    /**
     * Generate nomutasibrg untuk mutasibrg_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noMutasiBarang()
    {
        $default = "0001";
        $prefix = "MUTBRG".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomutasibrg,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM mutasibrg_t
				WHERE nomutasibrg LIKE ('".$prefix."%')";
		$mutasiBrg= Yii::app()->db->createCommand($sql)->queryRow();
        $nomutasibrg_baru=$prefix.(isset($mutasiBrg['nomaksimal']) ? (str_pad($mutasiBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomutasibrg_baru;
    }
    /**
     * Generate nopembelian untuk pembelianbarang_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noPembelianBarang($sumber=null)
    {
        $default = "0001";
        $prefix = "BLIBRG".(!empty($sumber)?$sumber:"")."".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembelianbarang_t
				WHERE nopembelian LIKE ('".$prefix."%')";
		$nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nopembelian_baru=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopembelian_baru;
    }
    /**
     * Generate nopenerimaan untuk terimapersediaan_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noPenerimaanPersediaan()
    {
        $default = "0001";
        $prefix = "TRMBRG".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimapersediaan_t
				WHERE nopenerimaan LIKE ('".$prefix."%')";
		$terimaPersediaan= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaan_baru=$prefix.(isset($terimaPersediaan['nomaksimal']) ? (str_pad($terimaPersediaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaan_baru;
    }
    /**
     * Generate noreturterima untuk returpenerimaan_t
     * @return string
     */
    public static function noReturTerima()
    {
		$default = "0001";
        $prefix = "RTRBRG".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturterima,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returpenerimaan_t
				WHERE noreturterima LIKE ('".$prefix."%')";
        $returPenerimaan= Yii::app()->db->createCommand($sql)->queryRow();
        $noreturterima_baru=$prefix.(isset($returPenerimaan['nomaksimal']) ? (str_pad($returPenerimaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noreturterima_baru;
    }

    public static function noReturTerimaBahanMakanan()
    {
		$default = "0001";
        $prefix = "RTRBHN".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturbahanmakan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returpenbahanmakan_t
				WHERE noreturbahanmakan LIKE ('".$prefix."%')";
        $returPenerimaan= Yii::app()->db->createCommand($sql)->queryRow();
        $noreturterima_baru=$prefix.(isset($returPenerimaan['nomaksimal']) ? (str_pad($returPenerimaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noreturterima_baru;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeTerimaPersediaan()
    {
        $default = "001";
        $prefix = "TRMSTOK".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodePemakaianBarang()
    {
        $default = "001";
        $prefix = "PEMSTOK".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeMutasiBarang()
    {
        $default = "001";
        $prefix = "MUTSTOK".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeTerimaMutasi()
    {
        $default = "001";
        $prefix = "MTSSTOK".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeStokAwalPersediaan()
    {
        $default = "001";
        $prefix = "STOKAWL".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodePenyesuaianPersediaan()
    {
        $default = "001";
        $prefix = "STOKPNY".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generate noformulir untuk formuliropname_r
     * @return string
     */
    public static function noFormulirOpname()
    {
		$default = "001";
        $prefix = 'FOPNM'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noformulir,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM formuliropname_r
				WHERE noformulir LIKE ('".$prefix."%')";
		$formulirOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $noformulir_baru=$prefix.(isset ($formulirOpname['nomaksimal']) ? (str_pad($formulirOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noformulir_baru;
    }

    /**
     * Generate noformulir untuk formuliropname_r
     * @return string
     */
    public static function noFormulirOpnameGizi()
    {
		$default = "001";
        $prefix = 'FOPNMGZ'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noformulir,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM formuliropnamegizi_r
				WHERE noformulir LIKE ('".$prefix."%')";
		$formulirOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $noformulir_baru=$prefix.(isset ($formulirOpname['nomaksimal']) ? (str_pad($formulirOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noformulir_baru;
    }

    /**
     * Generate nostokopname untuk stokopname_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noStokOpname($instalasi_id)
    {
        $default = "00001";
        $prefix = 'SOPNM'.date('ymd');

        $col = "SUBSTR(nostokopname,".(strlen($prefix)+1).",".(strlen($default)).")";

        $regexp = "regexp_replace(".$col.", '\D', '', 'g')";

        $sql = "SELECT MAX(CAST(".$regexp." AS integer)) nomaksimal
				FROM stokopname_t
				WHERE nostokopname LIKE ('".$prefix."%')";
        $stokOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $nostokopname_baru = $prefix.(isset($stokOpname['nomaksimal']) ? (str_pad($stokOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nostokopname_baru;
    }
    /**
     * Generate nostokopname untuk stokopname_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noStokOpnameGizi()
    {
        $default = "001";
        $prefix = 'SOPNMGZ'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nostokopnamegizi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM stokopnamegizi_t
				WHERE nostokopnamegizi LIKE ('".$prefix."%')";
        $stokOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $nostokopname_baru = $prefix.(isset($stokOpname['nomaksimal']) ? (str_pad($stokOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nostokopname_baru;
    }
    /**
     * Generate pengangkatantphl_noperjanjian untuk pengangkatantphl_t
     * @return string
     */
    public static function noPerjanjian()
    {
		$default = "001";
        $prefix = 'PJNJ'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(pengangkatantphl_noperjanjian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengangkatantphl_t
				WHERE pengangkatantphl_noperjanjian LIKE ('".$prefix."%')";
		$pengangkatanTphl= Yii::app()->db->createCommand($sql)->queryRow();
        $noperjanjian_baru=$prefix.(isset($pengangkatanTphl['nomaksimal']) ? (str_pad($pengangkatanTphl['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noperjanjian_baru;
    }

    /**
     * Generate nopenggajian untuk penggajianpeg_t
     */
    public static function noPenggajian($tgl='')
    {
		$default = "001";
		//if (empty($tgl)){
			if (empty($tgl)){
				$prefix = 'GAJI'.date('ymd');
			}else{
				$prefix = 'GAJI'.date('ymd', strtotime($tgl));
			}
			$sql = "SELECT CAST(MAX(SUBSTR(nopenggajian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
					FROM penggajianpeg_t
					WHERE nopenggajian LIKE ('".$prefix."%')";
		//}
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $nopenggajian;
    }

    /**
     * Generate nopesangon untuk pesangonpeg_t
     */
    public static function noPesangon($tgl='')
    {
		$default = "001";
		//if (empty($tgl)){
			if (empty($tgl)){
				$prefix = 'PESANGON'.date('ymd');
			}else{
				$prefix = 'PESANGON'.date('ymd', strtotime($tgl));
			}
			$sql = "SELECT CAST(MAX(SUBSTR(nopesangon,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
					FROM pesangonpeg_t
					WHERE nopesangon LIKE ('".$prefix."%')";
		//}
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $nopenggajian;
    }
    /**
     * Generate nopenggajian untuk penggajianpeg_t
     */
    public static function noRealisasiLembur()
    {
		$default = "001";
        $prefix = 'RLP'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(norealisasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM realisasilembur_t
				WHERE norealisasi LIKE ('".$prefix."%')";
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $nopenggajian;
    }
    /**
     * Generate nobayarjasa untuk pembayaranjasa_id
     * @return string
     */
    public static function noBayarJasa()
    {
        $default = "001";
        $prefix = 'PJM'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nobayarjasa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembayaranjasa_t
				WHERE nobayarjasa LIKE ('".$prefix."%')";
        $pembayaranJasa = Yii::app()->db->createCommand($sql)->queryRow();
        $nobayarjasa_baru =$prefix.(isset($pembayaranJasa['nomaksimal']) ? (str_pad($pembayaranJasa['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobayarjasa_baru;
    }

    /**
     * Generate noresep untuk penjualanresep_t (retailer)
     * @return string
     */
    public static function noResepRetailer($prefix='NR')
    {
		$default = "0001";
        $prefix = $prefix.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru=$prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    /**
     * Generate noresep untuk penjualanresep_t (Penjualan Bebas)
     * @param type $prefix
     * @return string
     */
    public static function noResepPenjualanBebas($prefix=null){
		$default = "0001";
        $prefix = (isset($prefix) ? $prefix : 'BEBAS').date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru=$prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }

    /**
     * Generate nopembayaranklaim untuk pembayarklaim_t
     * @return string
     */
    public static function noPembayaranKlaim()
    {
		$default = "0001";
        $prefix = "PMBKP/".date('Y').'/'.date('m').'/';
        $sql = "SELECT CAST(MAX(SUBSTR(nopembayaranklaim,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembayarklaim_t
				WHERE nopembayaranklaim LIKE ('".$prefix."%')";
        $pembayarKlaim = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pembayarklaim_baru = $prefix.(isset($pembayarKlaim['nomaksimal']) ? (str_pad($pembayarKlaim['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pembayarklaim_baru;
    }
	 /**
     * Generate nopembayaranklaim untuk pembayarklaim_t
     * @return string
     */
    public static function noPengajuanKlaim()
    {
        $default = "0001";
        // $prefix = "/KEU/".CustomFunction::romawi(date('m')).'/RSMD-'.date('Y');
        $prefix = "PNGKP/".date('Y').'/'.date('m').'/';
        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuanklaimanklaim, ".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuanklaimpiutang_t
				WHERE nopengajuanklaimanklaim LIKE ('".$prefix."%')";

        $pengajuanKlaim = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pengajuanklaim_baru = $prefix.(isset($pengajuanKlaim['nomaksimal']) ? (str_pad($pengajuanKlaim['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pengajuanklaim_baru;
    }

    /**
     * Generate nobuktijurnal untuk jurnalrekening_t
     * @return string
     */
    public static function noBuktiJurnalRek($header = 'JU')
    {
		$default = "00001";
        $prefix = $header.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nobuktijurnal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jurnalrekening_t
				WHERE SUBSTR(nobuktijurnal, ".(strlen($header) + 1).") LIKE ('".date('ymd')."%')";

        // echo $header." - ".$sql; die;

        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktijurnal_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktijurnal_baru;
    }


    /**
     * Generate nobuktijurnal untuk jurnalrekening_t
     * @return string
     */
    public static function noBuktiJurnalRekTanggal($tgl, $header = 'JU')
    {
		$default = "00001";
        $prefix = $header.date('ymd', strtotime($tgl));
        $sql = "SELECT CAST(MAX(SUBSTR(nobuktijurnal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jurnalrekening_t
				WHERE SUBSTR(nobuktijurnal, ".(strlen($header) + 1).") LIKE ('".date('ymd', strtotime($tgl))."%')";

        // echo $header." - ".$sql; die;

        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktijurnal_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktijurnal_baru;
    }


    /**
     * Generate kodejurnal untuk jurnalrekening_t
     * @return type
     */
    public static function kodeJurnalRek()
    {
		$default = "000000001";
        $prefix = "";
        $sql = "SELECT CAST(MAX(SUBSTR(kodejurnal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jurnalrekening_t
				WHERE kodejurnal LIKE ('".$prefix."%')";
        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $kodejurnal_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kodejurnal_baru;
    }

    
    /** Generator nomor Kode Supplier
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public static function kodeSupplierNew() {
        // IHS-3722
        // supplier_kode(character varying(10)), jd nilai default dikurangin 2 karakter
        $default = "001";
         // $default = "00001";
        $prefix = "SUP" . date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(supplier_kode," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM supplier_m 
            WHERE supplier_kode LIKE ('" . $prefix . "%')";
        $nomorSupplier = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorSupplier_baru = $prefix . (isset($nomorSupplier['nomaksimal']) ? (str_pad($nomorSupplier['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorSupplier_baru;
    }

     /** Generator nomor Kode Supplier
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public static function kodeSupplier() {
        $default = "00001";
        $prefix = "SUP" . date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(supplier_kode," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM supplier_m 
            WHERE supplier_kode LIKE ('" . $prefix . "%')";
        $nomorSupplier = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorSupplier_baru = $prefix . (isset($nomorSupplier['nomaksimal']) ? (str_pad($nomorSupplier['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorSupplier_baru;
    }

     /**
     * Generate kode supplier
     * @return type
     */
    public static function kodeMobilAmbulans()
    {
        $default = "01";
        $prefix = 'AMB-';
        $sql = "SELECT CAST(MAX(SUBSTR(mobilambulans_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM mobilambulans_m
				WHERE mobilambulans_kode LIKE ('%".$prefix."%')";
        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_baru;
    }

    /**
     * Generate noverifikasi untuk verifikasitagihan_t
     * @return string
     */
    public static function noVerifikasi()
    {
		$default = "0001";
        $prefix = 'VR'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifikasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifikasitagihan_t
				WHERE noverifikasi LIKE ('".$prefix."%')";
        $verifikasiTagihan = Yii::app()->db->createCommand($sql)->queryRow();
        $noverifikasi_baru = $prefix.(isset($verifikasiTagihan['nomaksimal']) ? (str_pad($verifikasiTagihan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noverifikasi_baru;
    }

    /**
     * Generate noverifikasi untuk verifbataltindakan_t
     * Author: Refi Fadholi
     * refifadholi.@gmail.com
     * @return string
     */
    public static function noBatalTindakan()
    {
		$default = "0001";
        $prefix = 'BTL'.date('ym');
        $batal = VerifbataltindakanT::model()->count("noverifikasi_batal ILIKE '%$prefix%'");

        return $prefix . date('d') . str_pad(($batal + 1),4,"0", STR_PAD_LEFT);
    }

    /**
     * Generate nokodeobat untuk obatalkes_m
     * @param string $obatalkes_nama
     * @return string
     */
    public static function noKodeObatAlkes($obatalkes_nama = ""){
		$default = "000000001";
        $prefix=(!empty($obatalkes_nama)) ? strtoupper(substr(trim($obatalkes_nama),0,3)) : "";
        $sql = "SELECT CAST(MAX(SUBSTR(obatalkes_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM obatalkes_m
				WHERE obatalkes_kode LIKE ('".$prefix."%')";
        $obatAlkes = Yii::app()->db->createCommand($sql)->queryRow();
        $nokodeobat_baru = $prefix.(isset($obatAlkes['nomaksimal']) ? (str_pad($obatAlkes['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokodeobat_baru;
    }
    /**
     * Generate no_pendaftaran untuk pesanambulans_t
     * @param type $kode_instalasi
     * @return string
     */
    public static function noPesanAmbulans($instalasi_id, $tgl = null)
    {
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }
        $default = "0001";
        $prefix = "PAMB".date('ymd', strtotime($tgl));
        $sql = "SELECT CAST(MAX(SUBSTR(pesanambulans_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanambulans_t
				WHERE pesanambulans_no LIKE ('".$prefix."%')";
		$nopendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pendaftaran_baru=$prefix.(isset($nopendaftaran['nomaksimal']) ? (str_pad($nopendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pendaftaran_baru;
    }

    /**
     * Generate nomorsurat untuk suratketerangan_r
     * @param type $jenissurat_id
     * @return integer
     */
    public static function noSurat($jenissurat_id, $kode_surat = "SK")
    {

        $konfig =  KonfigsystemK::model()->find()->prefix_kode_surat;

        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(substring(nomorsurat, 1, 3)) AS nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat'";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = str_pad((int)$genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."/".$kode_surat."/".$konfig."/".$bulanRomawi."/".$tahun;
        return trim($noSurat);
    }

    public static function noSuratCpt($kode_surat = "MMPISA", $jenissurat_id = null)
    {

        $konfig =  KonfigsystemK::model()->find()->prefix_kode_surat;

        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(substring(nomorsurat, 1, 3)) AS nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat'";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = $kode_surat."/".str_pad((int)$genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."/".$bulanRomawi."/".$tahun;
        return trim($noSurat);
    }

    public static function noSuratCpt2($jenissurat_id)
    {

        $konfig =  KonfigsystemK::model()->find()->prefix_kode_surat;

        $bulan = date('m');
        // if($bulan < 10){
        //     $bln = number_format($bulan);
        // }else{
        //     $bln = $bulan;
        // }
        // $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(substring(qrcode, 1, 3)) AS nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat'";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = str_pad($genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."".$bulan."".$tahun;
        return trim($noSurat);
    }
    /**
     * Generate permohonanoa_nomor untuk permohonanoa_t
     * @return string
     */
    public static function noPermohonanBantuan()
    {
        $default = "0001";
        $prefix = "PBOA".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(permohonanoa_nomor,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM permohonanoa_t
				WHERE permohonanoa_nomor LIKE ('".$prefix."%')";
        $permohonanOa = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permohonanoa = $prefix.(isset($permohonanOa['nomaksimal']) ? (str_pad($permohonanOa['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permohonanoa;
    }

    /**
     * Generate nopemusnahan untuk pemusnahanobatalkes_t
     * @return string
     */
    public static function noPemusnahan()
    {
		$default = "0001";
        $prefix = "MSOA".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopemusnahan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemusnahanobatalkes_t
				WHERE nopemusnahan LIKE ('".$prefix."%')";
        $no_pemusnahan = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pemusnahan_baru = $prefix.(isset($no_pemusnahan['nomaksimal']) ? (str_pad($no_pemusnahan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pemusnahan_baru;
    }

	/**
     * Generate no_antriankonsul untuk konsulpoli_t
     * @return string
     */
    public static function noAntrianKonsulPoli($ruangan_id = null, $format = "000")
    {
        $sql = "SELECT CAST(MAX(SUBSTR(no_antriankonsul,1,".(strlen($format)).")) AS integer) nomaksimal FROM konsulpoli_t
                WHERE DATE(tglkonsulpoli)='".date('Y-m-d')."'
                    ".(!empty($ruangan_id) ? " AND ruangan_id = ".$ruangan_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
        $noantrian_baru = str_pad($antrian['nomaksimal']+1, strlen($format), 0, STR_PAD_LEFT);
        return $noantrian_baru;
    }

	/**
	* Fungsi Untuk Mengenerate No Pemakaian Barang Secara Otomatis
	* @return string
	*/
    public static function noPemakaianBarang()
    {
		$default = "0001";
        $prefix = "PMBR".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopemakaianbrg,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemakaianbarang_t
				WHERE nopemakaianbrg LIKE ('".$prefix."%')";
        $noPemakaian = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemakaianBaru =$prefix.(isset($noPemakaian['nomaksimal']) ? (str_pad($noPemakaian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPemakaianBaru;
    }

	/**
	* Fungsi Untuk Mengenerate No Hasil MCU Secara Otomatis
	* @return string
	*/
    public static function noHasilMcu()
    {
		$default = "0001";
        $prefix = "HMCU".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nohasilmcu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanmcu_t
				WHERE nohasilmcu LIKE ('".$prefix."%')";
        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorbaru = $prefix.(isset($nomor['nomaksimal']) ? (str_pad($nomor['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomorbaru;
    }

	/**
     * Fungsi Untuk Menggenerate No. Antrian Janji Poli Secara Otomatis
     * @return string
     */
    public static function noAntrianJanjiPoli($ruangan_id = null, $format = "000")
    {
		$tgl = date('Y-m-d');
		$antrian = 0;

        $sql_pendaftaran = "select max(no_urutantri) nourut from pendaftaran_t where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $pendaftaran = Yii::app()->db->createCommand($sql_pendaftaran)->queryRow();
		$no_pendaftaran = isset($pendaftaran['nourut']) ? $pendaftaran['nourut'] : "001";

		$sql_konsulpoli = "SELECT max(no_antriankonsul) no_antriankonsul FROM konsulpoli_t
                WHERE DATE(tglkonsulpoli)='".$tgl."'
                    ".(!empty($ruangan_id) ? " AND ruangan_id = ".$ruangan_id : "");
        $konsul = Yii::app()->db->createCommand($sql_konsulpoli)->queryRow();
		$no_konsul = isset($konsul['no_antriankonsul']) ? $konsul['no_antriankonsul'] : "001";

        $sql_buatjanji = "select max(no_antrianjanji) no_antrian from buatjanjipoli_t where date(tglbuatjanji) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $buatjanji = Yii::app()->db->createCommand($sql_buatjanji)->queryRow();
		$no_buatjanji = isset($buatjanji['no_antrian']) ? $buatjanji['no_antrian'] : "001";

		if((int)$no_pendaftaran < (int)$no_konsul){
			if((int)$no_konsul < (int)$no_buatjanji){
				$antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
			}else{
				$antrian = (str_pad($no_konsul+1, 3, 0,STR_PAD_LEFT));
			}
		}else{
			if((int)$no_pendaftaran < (int)$no_buatjanji){
				$antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
			}else{
				$antrian = $antrian = (str_pad($no_pendaftaran+1, 3, 0,STR_PAD_LEFT));
			}
		}
		return $antrian;
    }

    /**
     * Generate no_buatjanji di buatjanjipoli_t
     * @param type $kode_ruangan	
     * @return string
     */
    public static function noJanjiPoli($kode_ruangan = "JP") {
        $default = "0001";
        $prefix = $kode_ruangan . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_buatjanji," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM buatjanjipoli_t 
				WHERE no_buatjanji LIKE ('" . $prefix . "%')";
        $nobuatjanji = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuatjanji_baru = $prefix . (isset($nobuatjanji['nomaksimal']) ? (str_pad($nobuatjanji['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nobuatjanji_baru;
    }

    /**
     * Generate nodocmedis untuk resumemedis_r
     * @return string
     */
    public static function noDokMedis()
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoDok = "SELECT MAX(nodocmedis) AS nodoc FROM resumemedis_r WHERE date_part('year', tglresume)='".$tahun."' AND date_part('month', tglresume) = '".$bulan."'";
        $noDok = Yii::app()->db->createCommand($sqlNoDok)->queryRow();
        $noDokMedis = str_pad((int)$noDok['nodoc']+1, STR_PAD_LEFT)."/Resume Medis/".$bulanRomawi."/".$tahun;
        return trim($noDokMedis);
	}

    /**
     * Generate nodocmedis untuk resumeperawat_r
     * @return string
     */
    public static function noDokResPerwt()
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoDok = "SELECT MAX(nodocresperwt) AS nodoc FROM resumeperawat_r WHERE date_part('year', tglreseumperwt)='".$tahun."' AND date_part('month', tglreseumperwt) = '".$bulan."'";
        $noDok = Yii::app()->db->createCommand($sqlNoDok)->queryRow();
        $noDokMedis = str_pad($noDok['nodoc']+1, STR_PAD_LEFT)."/Resume Keperawatan/".$bulanRomawi."/".$tahun;
        return trim($noDokMedis);
	}
	/**
	* Fungsi Untuk Mengenerate No Verifikasi Tindakan secara Otomatis
	* @return string
	*/
    public static function noVerifikasiTindakan()
    {
		$default = "0001";
        $prefix = "VER".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifikasi_renc,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifrenctindakan_t
				WHERE noverifikasi_renc LIKE ('".$prefix."%')";
        $noVerifikasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noVerifikasiBaru = $prefix.(isset($noVerifikasi['nomaksimal']) ? (str_pad($noVerifikasi['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noVerifikasiBaru;
    }

	/**
     * Generate nosuratrujukan untuk pasiendirujukkeluar_t
     * @return string
     */
    public static function noSuratRujukanKeluar()
    {
        $tahun = date('Y/m');

        $default = "0001";
        $ekor = "/BP5000/".$tahun."-S1";


        $sqlNoSurat = "SELECT MAX(substr(nosuratrujukan, 1, 4)) AS nosuratrujukan FROM pasiendirujukkeluar_t WHERE nosuratrujukan ilike '%".$ekor."'";
        $noSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();

        $nomor = empty($noSurat['nosuratrujukan']) ? $default : str_pad($noSurat['nosuratrujukan'] + 1, 4, 0, STR_PAD_LEFT);


        $noSuratRujukan = $nomor.$ekor;
        return trim($noSuratRujukan);
    }

    /**
     * Generate pabrik_kode untuk pabrik_m
     * @return type
     */
    public static function kodePabrik()
    {
		$default = "0001";
        $prefix = "PM"; // (Pharmacy Manufactory) LNG-1221
        $sql = "SELECT CAST(MAX(SUBSTR(pabrik_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pabrik_m
				WHERE pabrik_kode LIKE ('".$prefix."%')";
        $kodePabrik = Yii::app()->db->createCommand($sql)->queryRow();
        $kodepabrik_baru = $prefix.(isset($kodePabrik['nomaksimal']) ? (str_pad($kodePabrik['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kodepabrik_baru;
    }

    /**
     * Generate rencanggaranpeng_no untuk rencanggaranpeng_t
     * @return string
     */
    public static function noRencAnggPeng()
    {
		$default = "000001";
        $prefix = "RAPNG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(rencanggaranpeng_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanggaranpeng_t
				WHERE rencanggaranpeng_no LIKE ('".$prefix."%')";
        $noRencAnggPeng = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencAnggPeng_baru = $prefix.(isset($noRencAnggPeng['nomaksimal']) ? (str_pad($noRencAnggPeng['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencAnggPeng_baru;

    }

    /**
     * Generate noren_penerimaan untuk renanggpenerimaan_t
     * @return string
     */
    public static function noRencAnggPen()
    {
		$default = "000001";
        $prefix = "RAPNR".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(noren_penerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM renanggpenerimaan_t
				WHERE noren_penerimaan LIKE ('".$prefix."%')";
        $noRencAnggPen = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencAnggPen_baru = $prefix.(isset($noRencAnggPen['nomaksimal']) ? (str_pad($noRencAnggPen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencAnggPen_baru;

    }
    
    /**
     * Generate no_antrianjanji untuk no antrian mobile
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrianJanjiPoliKsSehat($ruangan_id, $pegawai_id) {
        if (!empty($ruangan_id) && !empty($pegawai_id)) {
            $default = '001';
            $tgl = date('Y-m-d', strtotime('+1 day'));
            $sql = "select max(no_urutantri) nomaksimal
                from pendaftaran_t
                where date(tglperiksa) = '" . $tgl . "'  AND pegawai_id = " . $pegawai_id . " AND ruangan_id = " . $ruangan_id . " ";
            $buatJanjiPoli = Yii::app()->db->createCommand($sql)->queryRow();
            $no_urutperiksa_baru = (isset($buatJanjiPoli['nomaksimal']) ? (str_pad($buatJanjiPoli['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
            return $no_urutperiksa_baru;
        } else {
            return null;
        }
    }

    /**
     * Generate no_antrianjanji untuk no antrian mobile
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrianJanjiPoliKsSakit($ruangan_id, $pegawai_id) {
        if (!empty($ruangan_id) && !empty($pegawai_id)) {
            $default = '001';
            $tgl = date('Y-m-d', strtotime('+1 day'));
            $sql = "select max(no_urutantri) nomaksimal
                from pendaftaran_t
                where date(tglperiksa) = '" . $tgl . "'  AND pegawai_id = " . $pegawai_id . " AND ruangan_id = " . $ruangan_id . " ";
            $buatJanjiPoli = Yii::app()->db->createCommand($sql)->queryRow();
            $no_urutperiksa_baru = (isset($buatJanjiPoli['nomaksimal']) ? (str_pad($buatJanjiPoli['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
            return $no_urutperiksa_baru;
        } else {
            return null;
        }
    }

	/**
     * Generate nosimulasianggaran untuk simulasianggaran_t
     * @return string
     */
    public static function noSimulasiAnggaran()
    {
        $default = "000001";
        $prefix = "SIMAG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(nosimulasianggaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM simulasianggaran_t
				WHERE nosimulasianggaran LIKE ('".$prefix."%')";
		$noSimulasiRes = Yii::app()->db->createCommand($sql)->queryRow();
        $noSimulasiBaru = $prefix.(isset($noSimulasiRes['nomaksimal']) ? (str_pad($noSimulasiRes['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noSimulasiBaru;
	}

    /**
     * Generate no_realisasi_peng untuk realisasianggpeng_t
     * @return string
     */
    public static function noReaAnggPeng()
    {
		$default = "000001";
        $prefix = "REAPNG".date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(no_realisasi_peng,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM realisasianggpeng_t
				WHERE no_realisasi_peng LIKE ('".$prefix."%')";
        $noReaAnggPeng = Yii::app()->db->createCommand($sql)->queryRow();
        $noReaAnggPeng_baru = $prefix.(isset($noReaAnggPeng['nomaksimal']) ? (str_pad($noReaAnggPeng['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noReaAnggPeng_baru;

    }

	/**
	 * Generate no_alokasi untuk alokasianggaran_t
	 * @return string
	 */
	public static function noAlokasiAnggaran(){
		$default = "000001";
        $prefix = "ALOAG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(no_alokasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) as nomaksimal
				FROM alokasianggaran_t
				WHERE no_alokasi LIKE ('".$prefix."%')";

		//var_dump($sql); die;
        $noAlokasiAnggaran = Yii::app()->db->createCommand($sql)->queryRow();
		//var_dump($noAlokasiAnggaran);
        $noAlokasiAnggaran_baru = $prefix.(isset($noAlokasiAnggaran['nomaksimal']) ? (str_pad($noAlokasiAnggaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        //var_dump($noAlokasiAnggaran_baru); die;
		return $noAlokasiAnggaran_baru;

	}

	/**
	 * Generate norencanadiklat untuk rencanadiklat_t
	 * @return string
	 */
	public static function noRencanaDiklat(){
		$default = "001";
        $prefix = "RENPEL".date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(norencanadiklat,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanadiklat_t
				WHERE norencanadiklat LIKE ('".$prefix."%')";
        $noRencanaDiklat = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencanaDiklat_baru = $prefix.(isset($noRencanaDiklat['nomaksimal']) ? (str_pad($noRencanaDiklat['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencanaDiklat_baru;

	}

        /**
	 * Generate norencanadiklat untuk realisasidiklat_t
	 * @return string
	 */
	public static function noRealisasiDiklat(){
		$default = "001";
        $prefix = "REAPEL".date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(norealisasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM realisasidiklat_t
				WHERE norealisasi LIKE ('".$prefix."%')";
        $noRencanaDiklat = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencanaDiklat_baru = $prefix.(isset($noRencanaDiklat['nomaksimal']) ? (str_pad($noRencanaDiklat['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencanaDiklat_baru;

	}

	/**
	* Fungsi Untuk Mengenerate No Pemanggilan MCU secara Otomatis
	* @return string
	*/
    public static function noPemanggilanMcu()
    {
		$default = "0001";
        $prefix = "MCU".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_pemanggilan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemanggilanmcu_t
				WHERE no_pemanggilan LIKE ('".$prefix."%')";
        $noPemanggilan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemanggilanBaru = $prefix.(isset($noPemanggilan['nomaksimal']) ? (str_pad($noPemanggilan['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPemanggilanBaru;
    }

	/**
	* Fungsi Untuk Mengenerate No Verifikasi Berkas MCU secara Otomatis
	* @return string
	*/
    public static function noVerifikasiBerkasMcu()
    {
		$default = "0001";
        $prefix = "VER".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifkasiberkasmcu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifikasiberkasmcu_t
				WHERE noverifkasiberkasmcu LIKE ('".$prefix."%')";
        $noVerifikasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noVerifikasiBaru = $prefix.(isset($noVerifikasi['nomaksimal']) ? (str_pad($noVerifikasi['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noVerifikasiBaru;
    }

	/**
	* Fungsi Untuk Mengenerate No Perawatan Linen
	* @return string
	*/
    public static function noPerawatanLinen()
    {
		$default = "0001";
        $prefix = "PWL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noperawatan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM perawatanlinen_t
				WHERE noperawatan LIKE ('".$prefix."%')";
        $noPerawatan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPerawatanBaru = $prefix.(isset($noPerawatan['nomaksimal']) ? (str_pad($noPerawatan['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPerawatanBaru;
    }

	/**
	* Fungsi Untuk Mengenerate No Pengiriman Linen
	* @return string
	*/
    public static function noPengirimanLinen()
    {
		$default = "0001";
        $prefix = "KRM".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopengirimanlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengirimanlinen_t
				WHERE nopengirimanlinen LIKE ('".$prefix."%')";
        $noPengiriman = Yii::app()->db->createCommand($sql)->queryRow();
        $noPengirimanBaru = $prefix.(isset($noPengiriman['nomaksimal']) ? (str_pad($noPengiriman['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPengirimanBaru;
	}

    /**
     * Generate nopenyusutanaset untuk penyusutanaset_t
     * @return string
     */
    public static function noPenyusutanAset()
    {
		$default="0001";
        $prefix = 'ST'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_penyusutan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penyusutanaset_t
				WHERE no_penyusutan LIKE ('".$prefix."%')";
        $penyusutanAset = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($penyusutanAset['nomaksimal']) ? (str_pad($penyusutanAset['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

    /**
     * Generate noregisterlinen untuk linen_m
     * @return string
     */
    public static function noRegisterLinen()
    {
		$default="0001";
        $prefix = 'RL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noregisterlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM linen_m
				WHERE noregisterlinen LIKE ('".$prefix."%')";
        $registerLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($registerLinen['nomaksimal']) ? (str_pad($registerLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

    /**
     * Generate noregisterlinen untuk pengperawatanlinen_t
     * @return string
     */
    public static function noPengPerawatanLinen()
    {
		$default="0001";
        $prefix = 'PPL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pengperawatanlinen_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengperawatanlinen_t
				WHERE pengperawatanlinen_no LIKE ('".$prefix."%')";
        $pengPerawatanLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($pengPerawatanLinen['nomaksimal']) ? (str_pad($pengPerawatanLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

    /**
     * Generate nopenerimaanlinen untuk penerimaanlinen_t
     * @return string
     */
    public static function noPenerimaanLinen()
    {
		$default="0001";
        $prefix = 'PL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaanlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penerimaanlinen_t
				WHERE nopenerimaanlinen LIKE ('".$prefix."%')";
        $penerimaanLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($penerimaanLinen['nomaksimal']) ? (str_pad($penerimaanLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }

    /**
     * Generate nopenerimaanlinen untuk penerimaanlinen_t
     * @return string
     */
    public static function noBarangPecahBelah()
    {
		$default="0001";
        $prefix = 'BPB'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(barangpecahbelah_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM barangpecahbelah_t
				WHERE barangpecahbelah_no LIKE ('".$prefix."%')";
        $barangPecahBelah = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru =$prefix.(isset($barangPecahBelah['nomaksimal']) ? (str_pad($barangPecahBelah['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_baru;
    }

	/**
     * Generate nopencucianlinen untuk pencucianlinen_t
     * @return string
     */
    public static function noPencucianLinen()
    {
		$default="0001";
        $prefix = 'PCL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopencucianlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pencucianlinen_t
				WHERE nopencucianlinen LIKE ('".$prefix."%')";
        $noPencucian = Yii::app()->db->createCommand($sql)->queryRow();
        $noPencucianBaru =$prefix.(isset($noPencucian['nomaksimal']) ? (str_pad($noPencucian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPencucianBaru;
    }

	/**
     * Generate nopenyimpananlinen untuk penyimpananlinen_t
     * @return string
     */
    public static function noPenyimpananLinen()
    {
		$default="0001";
        $prefix = 'PYL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenyimpananlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penyimpananlinen_t
				WHERE nopenyimpananlinen LIKE ('".$prefix."%')";
        $noPenyimpanan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenyimpananBaru =$prefix.(isset($noPenyimpanan['nomaksimal']) ? (str_pad($noPenyimpanan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenyimpananBaru;
    }

    /**
     * Generate nopenerimaanlinen untuk penlinenruangan_t
     * @return string
     */
    public static function noPenerimaanLinenR()
    {
		$default="0001";
        $prefix = 'PLR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenlinenruangan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penlinenruangan_t
				WHERE nopenlinenruangan LIKE ('".$prefix."%')";
        $penLinenRuangan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenerimaanLinenBaru =$prefix.(isset($penLinenRuangan['nomaksimal']) ? (str_pad($penLinenRuangan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenerimaanLinenBaru;
	}

    /**
     * Generate pengajuansterlilisasi_no untuk pengajuansterlilisasi_t
     * @return string
     */
    public static function noPengSterilisasi()
    {
		$default="0001";
        $prefix = 'PSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pengajuansterlilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuansterlilisasi_t
				WHERE pengajuansterlilisasi_no LIKE ('".$prefix."%')";
        $pengSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPengSterilBaru =$prefix.(isset($pengSteril['nomaksimal']) ? (str_pad($pengSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPengSterilBaru;
	}

    /**
     * Generate pesanperlinensteril_no untuk pesanperlinensteril_t
     * @return string
     */
    public static function noPesanSterilisasi()
    {
		$default="0001";
        $prefix = 'PESTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pesanperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanperlinensteril_t
				WHERE pesanperlinensteril_no LIKE ('".$prefix."%')";
        $pesSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPesSterilBaru =$prefix.(isset($pesSteril['nomaksimal']) ? (str_pad($pesSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPesSterilBaru;
	}

    /**
     * Generate penerimaansterilisasi_no untuk penerimaansterilisasi_t
     * @return string
     */
    public static function noPenerimaanSteril()
    {
		$default="0001";
        $prefix = 'PRSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(penerimaansterilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penerimaansterilisasi_t
				WHERE penerimaansterilisasi_no LIKE ('".$prefix."%')";
        $penSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenSterilBaru =$prefix.(isset($penSteril['nomaksimal']) ? (str_pad($penSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenSterilBaru;
	}

	/**
     * Generate dekontaminasi_no untuk dekontaminasi_t
     * @return string
     */
    public static function noDekontaminasi()
    {
		$default="0001";
        $prefix = 'DK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(dekontaminasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM dekontaminasi_t
				WHERE dekontaminasi_no LIKE ('".$prefix."%')";
        $noDekontaminasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noDekontaminasiBaru =$prefix.(isset($noDekontaminasi['nomaksimal']) ? (str_pad($noDekontaminasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noDekontaminasiBaru;
    }

	/**
     * Generate sterilisasi_no untuk sterilisasi_t
     * @return string
     */
    public static function noSterilisasi()
    {
		$default="0001";
        $prefix = 'STR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(sterilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM sterilisasi_t
				WHERE sterilisasi_no LIKE ('".$prefix."%')";
        $noSterilisasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noSterilisasiBaru =$prefix.(isset($noSterilisasi['nomaksimal']) ? (str_pad($noSterilisasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noSterilisasiBaru;
	}

    /** Generate terimaperlinensteril_no untuk terimaperlinensteril_t
     * @return string
     */
    public static function noPenerimaanSterilRuangan()
    {
		$default="0001";
        $prefix = 'PSR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(terimaperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimaperlinensteril_t
				WHERE terimaperlinensteril_no LIKE ('".$prefix."%')";
        $noPenerimaan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenerimaanBaru =$prefix.(isset($noPenerimaan['nomaksimal']) ? (str_pad($noPenerimaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenerimaanBaru;
    }

	/**
     * Generate kirimperlinensteril_no untuk kirimperlinensteril_t
     * @return string
     */
    public static function noKirimSterilisasi()
    {
		$default="0001";
        $prefix = 'KRMSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(kirimperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM kirimperlinensteril_t
				WHERE kirimperlinensteril_no LIKE ('".$prefix."%')";
        $noKirimSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noKirimSterilBaru =$prefix.(isset($noKirimSteril['nomaksimal']) ? (str_pad($noKirimSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noKirimSterilBaru;
    }

	/**
     * Generate penyimpanansteril_no untuk penyimpanansteril_t
     * @return string
     */
    public static function noPenyimpananSteril()
    {
		$default="0001";
        $prefix = 'PNSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(penyimpanansteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penyimpanansteril_t
				WHERE penyimpanansteril_no LIKE ('".$prefix."%')";
        $noPenyimpananSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenyimpananSterilBaru =$prefix.(isset($noPenyimpananSteril['nomaksimal']) ? (str_pad($noPenyimpananSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenyimpananSterilBaru;
	}

	/**
     * Generate pemeliharaanaset_no untuk pemeliharaanaset_t
     * @return string
     */
    public static function noPemeliharaanAset()
    {
		$default="0001";
        $prefix = 'PMAST'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pemeliharaanaset_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemeliharaanaset_t
				WHERE pemeliharaanaset_no LIKE ('".$prefix."%')";
        $noPemeliharaan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemeliharaanBaru =$prefix.(isset($noPemeliharaan['nomaksimal']) ? (str_pad($noPemeliharaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPemeliharaanBaru;
	}

	/**
     * Generate rekonsiliasibank_no untuk rekonsiliasibank_t
     * @return string
     */
    public static function noRekonsiliasiBank()
    {
		$default="0001";
        $prefix = 'REKBANK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(rekonsiliasibank_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rekonsiliasibank_t
				WHERE rekonsiliasibank_no LIKE ('".$prefix."%')";
        $noRekonsiliasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noRekonsiliasiBaru =$prefix.(isset($noRekonsiliasi['nomaksimal']) ? (str_pad($noRekonsiliasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRekonsiliasiBaru;
	}

	/**
     * Generate norenpengembalian untuk renpengembalianed_t
     * @return string
     */
    public static function noRenPengemED()
    {
		$default="0001";
        $prefix = 'RENPENG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(norenpengembalian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM renpengembalianed_t
				WHERE norenpengembalian LIKE ('".$prefix."%')";
        $noRenPengemED = Yii::app()->db->createCommand($sql)->queryRow();
        $noRenPengemEDBaru =$prefix.(isset($noRenPengemED['nomaksimal']) ? (str_pad($noRenPengemED['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRenPengemEDBaru;
	}

	/**
     * Generate no_pembuatanjadwal untuk penjadwalan_t
     * @return string
     */
    public static function noPenjadwalanPegawai()
    {
		$default="0001";
        $prefix = 'PP'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_pembuatanjadwal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjadwalan_t
				WHERE no_pembuatanjadwal LIKE ('".$prefix."%')";
        $noPenjadwalan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenjadwalanBaru =$prefix.(isset($noPenjadwalan['nomaksimal']) ? (str_pad($noPenjadwalan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenjadwalanBaru;
	}
        

	/**
     * Generate no_permohonanpertukaran untuk pertukaranjadwal_t
     * @return string
     */
    public static function noPertukaranJadwal()
    {
		$default="0001";
        $prefix = 'PJ'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_permohonanpertukaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pertukaranjadwal_t
				WHERE no_permohonanpertukaran LIKE ('".$prefix."%')";
        $noPertukaranJadwal = Yii::app()->db->createCommand($sql)->queryRow();
        $noPertukaranJadwalBaru =$prefix.(isset($noPertukaranJadwal['nomaksimal']) ? (str_pad($noPertukaranJadwal['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPertukaranJadwalBaru;
	}
	/**
     * Generate noproduksiobt untuk produksiobat_t
     * @return string
     */
	public static function noProduksiObat()
    {
		$default = "0001";
        $prefix = "PO"; //
        $sql = "SELECT CAST(MAX(SUBSTR(noproduksiobt,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM produksiobat_t
				WHERE noproduksiobt LIKE ('".$prefix."%')";
        $noproduksi = Yii::app()->db->createCommand($sql)->queryRow();
        $noproduksi_baru = $prefix.(isset($noproduksi['nomaksimal']) ? (str_pad($noproduksi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noproduksi_baru;
    }
	/**
     * Generate nopemakaian_obat untuk pemakaianobat_t
     * @return string
     */
	public static function noPemakaianObat()
    {
		$default = "001";
        $prefix = "PKOB".date('ymd'); //
        $sql = "SELECT CAST(MAX(SUBSTR(nopemakaian_obat,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemakaianobat_t
				WHERE nopemakaian_obat LIKE ('".$prefix."%')";
        $nopemakaian = Yii::app()->db->createCommand($sql)->queryRow();
        $nopemakaian_baru = $prefix.(isset($nopemakaian['nomaksimal']) ? (str_pad($nopemakaian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemakaian_baru;
    }
	/**
     * Generate lookup_kode, lookup_type = 'satuanbarang' untuk lookup_m
     * @return string
     */
	public static function kodeSatuanBarang()
    {
		$default = "0001";
        $prefix = "STBR";
        $sql = "SELECT CAST(MAX(SUBSTR(lookup_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM lookup_m
				WHERE lookup_kode LIKE ('".$prefix."%') AND lookup_type = 'satuanbarang'";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix.(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }

	/**
     * Generate obatalkes_kode untuk obatalkes_m
     * @return string
     */
	public static function kodeObatAlkes($prefix)
    {
		$default = "0001";
        $sql = "SELECT CAST(MAX(SUBSTR(obatalkes_kode,".(strlen($prefix)+2).",".(strlen($default)).")) AS integer) nomaksimal
				FROM obatalkes_m
				WHERE obatalkes_kode LIKE ('".$prefix."-%')";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix."-".(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }

	public static function kodeObatAlkesSementara($prefix)
    {
		$default = "00001";
        $sql = "SELECT CAST(MAX(SUBSTR(obatalkes_kode,".(strlen($prefix)+2).",".(strlen($default)).")) AS integer) nomaksimal
				FROM obatalkes_m
				WHERE obatalkes_kode LIKE ('".$prefix."-%')";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix."-".(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }

    public static function kodeSubSubKelompokBarang($subsubkelompok_id)
    {
        $sql = "SELECT  subsubkelompok_kode
				FROM subsubkelompok_m
				WHERE subsubkelompok_id = '$subsubkelompok_id' ";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $kode['subsubkelompok_kode'];
        return $kode_baru;
    }

    /**
     * Generate invbarang_no untuk invbarang_t
     * @return string
     */
    public static function noInventarisasiBarang()
    {
		$default="0001";
        $prefix = 'INVBRG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(invbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM invbarang_t
				WHERE invbarang_no LIKE ('".$prefix."%')";
        $noInvBrg = Yii::app()->db->createCommand($sql)->queryRow();
        $noInvBrgBaru =$prefix.(isset($noInvBrg['nomaksimal']) ? (str_pad($noInvBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noInvBrgBaru;
    }

    /**
     * Generate forminvbarang_no untuk formulirinvbarang_r
     * @return string
     */
    public static function noFormInventarisasiBarang()
    {
		$default="0001";
        $prefix = 'FORMINVBRG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(forminvbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM formulirinvbarang_r
				WHERE forminvbarang_no LIKE ('".$prefix."%')";
        $noFormInvBrg = Yii::app()->db->createCommand($sql)->queryRow();
        $noFormInvBrgBaru =$prefix.(isset($noFormInvBrg['nomaksimal']) ? (str_pad($noFormInvBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noFormInvBrgBaru;
    }

    /**
     * Generate nosetorankasir untuk setorankasir_t
     * @return string
     */
    public static function noSetoranKasir()
    {
        $default = "0001";
        $prefix = "SEKA".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(nosetorankasir,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM setorankasir_t
				WHERE nosetorankasir LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nosetoran_baru;
    }

	/**
     * Generate nosetorankasir untuk setorankasir_t
     * @return string
     */
    public static function noSetoranBendahara()
    {
        $default = "0001";
        $prefix = "SEBH".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(nosetoranbdhara,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM setoranbdhara_t
				WHERE nosetoranbdhara LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nosetoran_baru;
    }

	public static function noRujukanLokalBpjs()
	{
		$default = "001";
        $prefix = date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(norujukan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM sep_t
				WHERE norujukan LIKE ('".$prefix."%')";
        $rujukan= Yii::app()->db->createCommand($sql)->queryRow();
        $norujukan_baru = $prefix.(isset($rujukan['nomaksimal']) ? (str_pad($rujukan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $norujukan_baru;
	}

    public static function noReferensiLokalBpjs()
    {
        $profil = ProfilrumahsakitM::model()->find();
        $default = "001";
        $prefix = "RSSA" . date("dmyHis");
        $sql = "SELECT CAST(MAX(SUBSTR(norujukan," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM sep_t 
				WHERE norujukan LIKE ('" . $prefix . "%')";
        $rujukan = Yii::app()->db->createCommand($sql)->queryRow();
        $norujukan_baru = $prefix . (isset($rujukan['nomaksimal']) ? (str_pad($rujukan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $norujukan_baru;
    }

        // generator nomor pengkajian perawatan pasien

        public static function noPengkajianAskep()
        {
            $default = "0001";
            $prefix = "PEKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(no_pengkajian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM pengkajianaskep_t
                                    WHERE no_pengkajian LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noResumeAskep()
        {
            $default = "001";
            $prefix = "RESKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(noresume,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM resumeaskep_r
                                    WHERE noresume LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noRencanaKeperawatan()
        {
            $default = "001";
            $prefix = "RENCASKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(no_rencana,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM rencanaaskep_t
                                    WHERE no_rencana LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noImplementasiKeperawatan()
        {
            $default = "001";
            $prefix = "IMPASKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(no_implementasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM implementasiaskep_t
                                    WHERE no_implementasi LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noEvaluasiKeperawatan()
        {
            $default = "001";
            $prefix = "EVALASKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(no_evaluasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM evaluasiaskep_t
                                    WHERE no_evaluasi LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noVerifikasiKeperawatan()
        {
            $default = "001";
            $prefix = "VERIFASKEP".date("ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(verifikasiaskep_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM verifikasiaskep_t
                                    WHERE verifikasiaskep_no LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function noPinjamPegawai()
        {
            $default = "0001";
            $prefix = "PNJ".date("Ymd");
                    $sql = "SELECT CAST(MAX(SUBSTR(nopinjam,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                    FROM pinjamanpeg_t
                                    WHERE nopinjam LIKE ('".$prefix."%')";
            $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
            $nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $nosetoran_baru;
        }

        public static function kodeGolongan()
        {
            $default = "01";
            $sql = "SELECT CAST(MAX(golongan_kode) AS integer) nomaksimal
                            FROM golongan_m                            ";
            $kodeGolongan= Yii::app()->db->createCommand($sql)->queryRow();
            $kodeGolongan_baru = (isset($kodeGolongan['nomaksimal']) ? (str_pad($kodeGolongan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $kodeGolongan_baru;
        }

        public static function kodeBidang($kode_golongan)
        {
            $default = "01";
            $sql = "SELECT CAST(MAX(SUBSTR(bidang_kode,".(strlen($kode_golongan)+2).",".(strlen($default)).")) AS integer) nomaksimal
                            FROM bidang_m WHERE bidang_kode ILIKE '".$kode_golongan."%' ";
            $kodeGolongan= Yii::app()->db->createCommand($sql)->queryRow();
            $kodeGolongan_baru = $kode_golongan.'.'.(!empty($kodeGolongan['nomaksimal']) ? (str_pad($kodeGolongan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $kodeGolongan_baru;
        }

        public static function kodeKelompok($kode_bidang)
        {
            $default = "01";
            $sql = "SELECT CAST(MAX(SUBSTR(kelompok_kode,".(strlen($kode_bidang)+2).",".(strlen($default)).")) AS integer) nomaksimal
                            FROM kelompok_m WHERE kelompok_kode ILIKE '".$kode_bidang."%' ";
            $kodeBidang= Yii::app()->db->createCommand($sql)->queryRow();
            $kodeBidang_baru = $kode_bidang.'.'.(!empty($kodeBidang['nomaksimal']) ? (str_pad($kodeBidang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $kodeBidang_baru;
        }

        public static function kodeSubKelompok($kode_kelompok)
        {
            $default = "01";
            $sql = "SELECT CAST(MAX(SUBSTR(subkelompok_kode,".(strlen($kode_kelompok)+2).",".(strlen($default)).")) AS integer) nomaksimal
                            FROM subkelompok_m WHERE subkelompok_kode ILIKE '".$kode_kelompok."%' ";
            $kodeKelompok= Yii::app()->db->createCommand($sql)->queryRow();
            $kodeKelompok_baru = $kode_kelompok.'.'.(!empty($kodeKelompok['nomaksimal']) ? (str_pad($kodeKelompok['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $kodeKelompok_baru;
        }

        public static function kodeSubSubKelompok($kode_subkelompok)
        {
            $default = "01";
            $sql = "SELECT CAST(MAX(SUBSTR(subsubkelompok_kode,".(strlen($kode_subkelompok)+2).",".(strlen($default)).")) AS integer) nomaksimal
                            FROM subsubkelompok_m WHERE subsubkelompok_kode ILIKE '".$kode_subkelompok."%' ";
            $kodeSubKelompok= Yii::app()->db->createCommand($sql)->queryRow();
            $kodeSubKelompok_baru = $kode_subkelompok.'.'.(!empty($kodeSubKelompok['nomaksimal']) ? (str_pad($kodeSubKelompok['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $kodeSubKelompok_baru;
        }

        public static  function generateNoPermohonan() {
		$date = 'PP'.date('Ym');
		$sql = "select cast(max(substr(nopermohonan, 9, 4)) as integer) as urut from permohonanpinjaman_t where substr(nopermohonan, 1, 8) ilike '%".$date."%'";
		$dat =  Yii::app()->db->createCommand($sql)->queryRow();

		$cnt = str_pad(($dat['urut']+1), 4, '0', STR_PAD_LEFT);
		return $date.$cnt;
	}

        public static function generateNoPinjaman($jenispinjaman) {
		$head = '';
		if (strtolower($jenispinjaman) == 'uang') $head = "PU";
		else if (strtolower($jenispinjaman) == 'barang') $head = "PB";
		$head .= date("Ym");

		$sql = "select cast(max(substr(no_pinjaman, 9,4)) as integer) as urut from pinjaman_t where no_pinjaman ilike '%".$head."%'";
		$dat =  Yii::app()->db->createCommand($sql)->queryRow();

		$cnt = str_pad(($dat['urut']+1), 4, '0', STR_PAD_LEFT);
		return $head.$cnt;
	}

        public static function generateNoBKK($tipe = null) {
		$date = date('Ym');
		$sql = "select count(no_bkk) as urut from buktikaskeluarkop_t where substr(no_bkk, 1, 12) ilike '%BKK".$date."%'";
		$dat =  Yii::app()->db->createCommand($sql)->queryRow();

		$cnt = str_pad(($dat['urut']+1), 4, '0', STR_PAD_LEFT);
		return 'BKK'.$date.$cnt;
	}

	public static function generateNoSimpanan($singkatan) {
		$head = $singkatan.date('ym');

		$sql = "select cast(max(substr(nosimpanan,7,4)) as integer) as nourut from simpanan_t where nosimpanan ilike '".$singkatan."%'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		$roll = str_pad($data['nourut']+1, 4, 0, STR_PAD_LEFT);
		return $head.$roll;
	}

	/**
	 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @return string
	 * - digunakan untuk mengenerate nomor pengajuan anggaran operasional
	 */
	public static function noPengajuanAnggaranOperasional()
	{
		$default = "0001";
		$prefix = "PAO".date("ymd");
				$sql = "SELECT CAST(MAX(SUBSTR(pengajuanpetty_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
								FROM pengajuanpetty_t
								WHERE pengajuanpetty_no LIKE ('".$prefix."%')";
		$reseptur= Yii::app()->db->createCommand($sql)->queryRow();
		$nosetoran_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		return $nosetoran_baru;
	}


    /**
     * Generate no pendaftaran pemakaian ambulan pasien luar
     * @param string $tgl_pendaftaran
     * @return string
     */
    public static function noPendaftaranPemakaianAmbulan($tgl_pendaftaran = null)
    {
        return self::noPendaftaran(Params::INSTALASI_ID_AMBULAN, $tgl_pendaftaran);
    }


    /**
     * Generate no permintaan kantong darah ke PMI
     * @return string
     */
    public static function noPermintaanKantongDarahPmi() {
        $default = "00001";
        $prefix = 'N' . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_permintaan," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM permintaandarahpmi_t
            WHERE no_permintaan LIKE ('" . $prefix . "%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permintaan_baru = $prefix . (isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_permintaan_baru;
    }

    /**
     * Generate no permintaan kantong darah
     * @return string
     */
    public static function noPermintaanKantongDarah()
    {
		$default = "0001";
                $prefix = 'PKDR'.date('ymd');
                $sql = "SELECT CAST(MAX(SUBSTR(no_permintaandarah,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM permintaandarah_t
				WHERE no_permintaandarah LIKE ('".$prefix."%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permintaan_baru =$prefix.(isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permintaan_baru;
    }

    /** Generate Nomor Penerimaan Darah dari PMI dengan format
     * D[2 digit tahun][2 digit bulan][2 digit hari][5 digit counter]
     * Counter di-refresh setiap tahun.
     *
     * @return string
     */
    public static function noPenerimaanDarahPMI() {
        $default = "00001";
        $prefix = 'D'.date('ymd');
        $prefix_filter = 'D'.date('y');
        $sql = "SELECT MAX(substr(no_penerimaan, ".(strlen($prefix) + 1).")) AS nourut FROM penerimaandarahpmi_t WHERE no_penerimaan ilike '".$prefix_filter."%'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();

        $nomor_baru = $prefix.(isset($data['nourut']) ? (str_pad($data['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * generate  uji kompatiilitas ke berapa
     *
     * @return string
     */
    public static function ujiKompatibilitasKe($ujidarahtube_id) {
        $default = 1;
        $sql = "SELECT MAX(ujikompatibilitas_ke) AS nourut FROM ujikompatibilitas_t WHERE ujidarahpasien_id = '".$ujidarahtube_id."' ";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $ke = (isset($data['nourut']) ? $data['nourut']+1: $default);
        return $ke;
    }

    /**
     * generate  uji penyiapan darah ke berapa
     *
     * @return string
     */
    public static function penyiapanDarahKe($pasienkirimkeunitlain_id) {
        $default = 1;
        $sql = "SELECT MAX(penyiapandarah_ke) AS nourut FROM penyiapandarah_t WHERE pasienkirimkeunitlain_id = '".$pasienkirimkeunitlain_id."' ";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $ke = (isset($data['nourut']) ? $data['nourut']+1: $default);
        return $ke;
    }

    /**
     * generate  uji penyerahan darah ke berapa
     *
     * @return string
     */
    public static function penyerahanDarahKe($permintaandarah_id) {
        $default = 1;
        $sql = "SELECT MAX(penyerahandarah_ke) AS nourut FROM penyerahandarah_t WHERE permintaandarah_id = '".$permintaandarah_id."' ";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $ke = (isset($data['nourut']) ? $data['nourut']+1: $default);
        return $ke;
    }

    /**
     * Generator Nomor Distribusi Darah
     * Format : PYD[2 digit tahun][5 digit counter]
     * @return string
     */
    public static function registrasiPenyedia() {
        $default = "00001";
        $tahun = date('Y');
        $year  = substr($tahun, 2, 2);
        $prefix = "PYD".$year;
        $sql = "SELECT CAST(MAX(SUBSTR(penyedia_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
                FROM penyedia_m
                WHERE penyedia_kode LIKE ('".$prefix."%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * Generate nomorsurat untuk suratstudiluarmcu_t
     * @author Elham Budianto <elhambudianto1@gmail.com>
     * @return string
     */
    public static function noSuratStudiLuar()
    {
        $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratstudiluarmcu_t";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $temp = explode('/',$genSurat['nop']);
        $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/". CustomFunction::romawi(date('m'))."/TKI/RSDS/".date('Y');
        return trim($noSurat);
    }

    /**
     * Generate no_pembersihan
     * @return string
     */
    public static function noPembersihan()
    {
		$default = "0001";
		$prefix = 'PMB'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_pembersihan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembersihan_t
				WHERE no_pembersihan LIKE ('".$prefix."%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pembersihan_baru =$prefix.(isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pembersihan_baru;
    }

    /**
     * Generate nomorsurat keterangan sehat untuk umum
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @return integer
     */
    public static function noSuratSehat($pendaftaran_id, $pasien_id, $jenissurat_id)
    {

        $criteria = new CDbCriteria;
        $criteria->condition ="(pendaftaran_id = $pendaftaran_id) AND (pasien_id = $pasien_id)";
        $cekPasien = SuratketeranganR::model()->find($criteria);

        if(!empty($cekPasien)){
            $tahun = date('Y');
            $sqlNoSurat = "SELECT nomorsurat AS nop FROM suratketerangan_r WHERE pendaftaran_id = $pendaftaran_id AND pasien_id=$pasien_id";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop'], 4, 0,STR_PAD_LEFT)."/A/SS/RSDS/".$tahun;
        }else{
            $tahun = date('Y');
            $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=9 OR jenissurat_id=10 OR jenissurat_id=11 OR jenissurat_id=12";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/A/SS/RSDS/".$tahun;
        }

        return trim($noSurat);
    }

    /**
     * Generate No Persetujuan Tindakan
     * @return string
     */
    public static function noPersetujuan(){
        $default = "001";
        $prefix = "PRT".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopersetujuan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
            FROM suratpersetujuantm_t
            WHERE nopersetujuan LIKE ('".$prefix."%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * Generate Kode Barang
     * @return string
     */
    public static function kodebarangPerTipebarang($tipebarang){
        $default = "0001";
        $prefix = $tipebarang;
        if(!empty($tipebarang)){
            $prefix = $tipebarang."-";
        }

        $sql = "SELECT CAST(MAX(SUBSTR(barang_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
            FROM barang_m
            WHERE barang_kode ILIKE ('".$prefix."%') and barang_aktif = true";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * fungsi generate no pemusnaahan rekam medik
     * */
    public static function noPemusnahanDokRM() {
        $default = "001";
        $prefix = "PMSNRM".date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopemusnahanrekammedis,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
                FROM pemusnahanrekammedis_t 
                WHERE nopemusnahanrekammedis LIKE ('".$prefix."%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
     
    }
    /**
	* Fungsi Untuk Mengenerate No Pemakaian Bahan Makanan Secara Otomatis
	* @return string
	*/
    public static function noPemakaianBahanMakanan()
    {
		$default = "0001";
        $prefix = "PMBM".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_pemakaianbhnmkn,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemakaianbhnmkn_t
				WHERE no_pemakaianbhnmkn LIKE ('".$prefix."%')";
        $noPemakaian = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemakaianBaru =$prefix.(isset($noPemakaian['nomaksimal']) ? (str_pad($noPemakaian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPemakaianBaru;
    }

        /**
     * Fungsi Untuk Menggenerate No. Antrian Janji Poli Secara Otomatis
     * @return string
     */
    public static function noAntrianJanjiMCU($ruangan_id = null, $format = "000")
    {
            $tgl = date('Y-m-d');
            $antrian = 0;

            $sql_pendaftaran = "select max(no_urutantri) nourut from pendaftaran_t where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $pendaftaran = Yii::app()->db->createCommand($sql_pendaftaran)->queryRow();
                    $no_pendaftaran = isset($pendaftaran['nourut']) ? $pendaftaran['nourut'] : "001";

                    $sql_konsulpoli = "SELECT max(no_antriankonsul) no_antriankonsul FROM konsulpoli_t
                    WHERE DATE(tglkonsulpoli)='".$tgl."'
                        ".(!empty($ruangan_id) ? " AND ruangan_id = ".$ruangan_id : "");
            $konsul = Yii::app()->db->createCommand($sql_konsulpoli)->queryRow();
                    $no_konsul = isset($konsul['no_antriankonsul']) ? $konsul['no_antriankonsul'] : "001";

            $sql_buatjanji = "select max(no_antrianjanji) no_antrian from buatjanjipoli_t where date(tglbuatjanji) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $buatjanji = Yii::app()->db->createCommand($sql_buatjanji)->queryRow();
                    $no_buatjanji = isset($buatjanji['no_antrian']) ? $buatjanji['no_antrian'] : "001";

                    if((int)$no_pendaftaran < (int)$no_konsul){
                            if((int)$no_konsul < (int)$no_buatjanji){
                                    $antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
                            }else{
                                    $antrian = (str_pad($no_konsul+1, 3, 0,STR_PAD_LEFT));
                            }
                    }else{
                            if((int)$no_pendaftaran < (int)$no_buatjanji){
                                    $antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
                            }else{
                                    $antrian = $antrian = (str_pad($no_pendaftaran+1, 3, 0,STR_PAD_LEFT));
                            }
                    }
                    return $antrian;
    }

    /**
     * Generate no_buatjanji di buatjanjipoli_t
     * @param type $kode_ruangan
     * @return string
     */
    public static function noJanjiMCU($kode_ruangan = "MCU")
    {
        $default = "0001";
        $prefix = $kode_ruangan.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_buatjanji,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM buatjanjipoli_t
				WHERE no_buatjanji LIKE ('".$prefix."%')";
		$nobuatjanji = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuatjanji_baru=$prefix.(isset($nobuatjanji['nomaksimal']) ? (str_pad($nobuatjanji['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuatjanji_baru;
    }

    /**
     * Generate nomorsurat keterangan sehat untuk dokter
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @return integer
     */
    public static function noSuratDokter($pendaftaran_id, $pasien_id, $jenissurat_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition ="(pendaftaran_id = $pendaftaran_id) AND (pasien_id = $pasien_id)";
        $cekPasien = SuratketeranganR::model()->find($criteria);

        if(!empty($cekPasien)){
            $tahun = date('Y');
            $sqlNoSurat = "SELECT nomorsurat AS nop FROM suratketerangan_r WHERE pendaftaran_id = $pendaftaran_id AND pasien_id=$pasien_id";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop'], 4, 0,STR_PAD_LEFT)."/A/SS/RSDS/".$tahun;
        }else{
            $tahun = date('Y');
            $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=9 OR jenissurat_id=10 OR jenissurat_id=11 OR jenissurat_id=12";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/A/SS/RSDS/".$tahun;
        }
        return trim($noSurat);
    }

    /**
     * Generate nomorsurat keterangan sehat laboratorium untuk dokter
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @return type
     */
    public static function noSuratLabDokter($pendaftaran_id, $pasien_id, $jenissurat_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition ="(pendaftaran_id = $pendaftaran_id) AND (pasien_id = $pasien_id)";
        $cekPasien = SuratketeranganR::model()->find($criteria);

        if(!empty($cekPasien)){
            $tahun = date('Y');
            $sqlNoSurat = "SELECT nomorsurat AS nop FROM suratketerangan_r WHERE pendaftaran_id = $pendaftaran_id AND pasien_id=$pasien_id";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop'], 4, 0,STR_PAD_LEFT)."/B/SS/RSDS/".$tahun;
        }else{
            $tahun = date('Y');
            $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=9 OR jenissurat_id=10 OR jenissurat_id=11 OR jenissurat_id=12";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/B/SS/RSDS/".$tahun;
        }
        return trim($noSurat);
    }

    /**
     * Generate nomorsurat keterangan sehat fisik dan mental
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @return type
     */
    public static function noSuratFisikMental($pendaftaran_id, $pasien_id, $jenissurat_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition ="(pendaftaran_id = $pendaftaran_id) AND (pasien_id = $pasien_id)";
        $cekPasien = SuratketeranganR::model()->find($criteria);

        if(!empty($cekPasien)){
            $tahun = date('Y');
            $sqlNoSurat = "SELECT nomorsurat AS nop FROM suratketerangan_r WHERE pendaftaran_id = $pendaftaran_id AND pasien_id=$pasien_id";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop'], 4, 0,STR_PAD_LEFT);
        }else{
            $tahun = date('Y');
            $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=9 OR jenissurat_id=10 OR jenissurat_id=11 OR jenissurat_id=12";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT);
        }
        return trim($noSurat);
    }

    /**
     * Generate nomorsurat keterangan sehat laboratorium untuk umum
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @return integer
     */
    public static function noSuratLab($pendaftaran_id,$pasien_id, $jenissurat_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition ="(pendaftaran_id = $pendaftaran_id) AND (pasien_id = $pasien_id)";
        $cekPasien = SuratketeranganR::model()->find($criteria);

        if(!empty($cekPasien)){
            $tahun = date('Y');
            $sqlNoSurat = "SELECT nomorsurat AS nop FROM suratketerangan_r WHERE pendaftaran_id = $pendaftaran_id AND pasien_id=$pasien_id";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop'], 4, 0,STR_PAD_LEFT)."/B/SS/RSDS/".$tahun;
        }else{
            $tahun = date('Y');
            $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=9 OR jenissurat_id=10 OR jenissurat_id=11 OR jenissurat_id=12";
            $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
            $temp = explode('/',$genSurat['nop']);
            $noSurat = str_pad((int)$genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/B/SS/RSDS/".$tahun;
        }
        return trim($noSurat);
    }

    public static function noHitunganPajak() {
        $default = "0000001";
        $prefix = "1.3.".date('m').".".date('y')."-";
//        $prefix = 'PJPR'.date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_perhitungan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pajakdokter_t
				WHERE no_perhitungan LIKE ('".$prefix."%')";
		$nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru=$prefix.(isset($nomor['nomaksimal']) ? (str_pad($nomor['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    public static function noSuratKeteranganRencPulang($digitawal,$jenissurat_id, $ruangan_id, $carabayar, $ruanganlainnya=false){
        $default = $digitawal."0001";
        $profil = ProfilrumahsakitM::model()->find();
        $prefix = "/".$profil->namapendek_rumahsakit."/KONTROL/". strtoupper($carabayar).'/'.CustomFunction::Romawi(date('m')).'/'.date('Y');

        $ruanganCriteria = "create_ruangan = ".$ruangan_id;
        if($ruanganlainnya == true){
            $ruanganCriteria = "create_ruangan <> ".$ruangan_id;
        }
//        (strlen($prefix)+1)
        $sql = "SELECT CAST(MAX(SUBSTR(nomorsurat,1,".(strlen($default)).")) AS integer) nourut
            FROM suratketerangan_r
            WHERE nomorsurat LIKE ('%".$prefix."%') AND jenissurat_id = ".$jenissurat_id.' AND '.$ruanganCriteria;

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = (isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default).$prefix;
        return $nomor_baru;
    }

    public static function lookupkodebankpasien()
    {
		$default = "0001";
        $prefix = "BNK";
        $sql = "SELECT CAST(MAX(SUBSTR(lookup_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM lookup_m
				WHERE lookup_kode LIKE ('".$prefix."%') AND lookup_type = 'bank'";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix.(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }

    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeBatalMutasiBarang()
    {
        $default = "001";
        $prefix = "BTMSTOK".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }

    /**
     * Generator Nomor Distribusi Darah
     * Format : DD[2 digit tahun][2 digit bulan][2 digit hari][5 digit counter]
     *
     * @return string
     */
    public static function noDistribusiDarah() {
        $default = "00001";
        $prefix = "DD".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_pengiriman,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
                FROM distribusidarah_t
                WHERE nomor_pengiriman LIKE ('".$prefix."%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    public static function noSetoranPembelian()
    {
		$default = "00001";
        $prefix = date('y').".";
		$sql = "SELECT CAST(MAX(SUBSTR(no_setorpajakpembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE no_setorpajakpembelian LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

    public static function noUangMukaPembelian()
    {
        $default = "0001";

        $prefix = "BUMP".date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopembayaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM uangmukabeli_t
				WHERE nopembayaran LIKE ('%".$prefix."%')";

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $no_baru;
    }

     public static function noPengajuanPerubahanHarga()
    {
        $prefix = "PRBOA";
        $default = "0001";
        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuanhargaoa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuanhargaoa_t
				WHERE nopengajuanhargaoa LIKE ('%".$prefix."%')";

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);

        return $no_baru;
    }

    public static function noSetoranPajakHutang($jenistype = null)
    {
        $type = 'STPG';
        if(!empty($jenistype)){
            if($jenistype == Params::JENISSETORAN_PPHPEGAWAI){
                $type = 'STPG';
            }else if($jenistype == Params::JENISSETORAN_PPHJASADOKTER){
                $type = 'STPD';
            }else if($jenistype == Params::JENISSETORAN_BPJSTK){
                $type = 'STBTK';
            }else if($jenistype == Params::JENISSETORAN_PPHPEMBELIAN){
                $type = 'STPM';
            }else if($jenistype == Params::JENISSETORAN_BPJSKS){
                $type = 'STBKS';
            }else if($jenistype == Params::JENISSETORAN_PENGELUARANKAS){
                $type = 'STPKLU';
            }




        }

		$default = "0001";
        $prefix = $type.''.date('ym');
		$sql = "SELECT CAST(MAX(SUBSTR(no_setorpajakpembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE no_setorpajakpembelian LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

    public static function noSetoranPembayaranKolektif()
    {
        $type = 'PBS';
		      $default = "0001";
        $prefix = $type.''.date('ym');
		$sql = "SELECT CAST(MAX(SUBSTR(no_setorpajakpembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t
				WHERE no_setorpajakpembelian LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

    public static function noPengajuanBonusThr($tgl='', $jenisgaji='')
    {
        $default = "001";
        if (empty($tgl)){
                $prefix = strtoupper($jenisgaji).''.date('ymd');
        }else{
                $prefix = strtoupper($jenisgaji).''.date('ymd', strtotime($tgl));
        }
        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                        FROM pengbonusthr_t
                        WHERE nopengajuan LIKE ('".$prefix."%')";
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $nopenggajian;
    }

    public static function noPenerimaanPembayaranPiutang()
    {
        $type = 'PBPU';
		      $default = "0001";
        $prefix = $type.''.date('Ym');
		$sql = "SELECT CAST(MAX(SUBSTR(nopembayaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembpiutangbank_t
				WHERE nopembayaran LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

    public static function noSetoranHutangPPNKeluar()
    {
        $type = 'PBPPK';
		      $default = "0001";
        $prefix = $type.''.date('Ym');
		$sql = "SELECT CAST(MAX(SUBSTR(no_setorpajakpembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
            FROM tandabuktikeluar_t
            WHERE no_setorpajakpembelian LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

    public static function noPembayaranBonusThr($jenistype = null)
    {
        $type = 'PMTHR';
        if(!empty($jenistype)){
            if($jenistype == 'Bonus'){
                $type = 'PMBNS';
            }
        }

	      $default = "0001";
        $prefix = $type.'/'.date('y').'/'.date('m').'/';
	      $sql = "SELECT CAST(MAX(SUBSTR(nopembayaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
  				FROM pembbonusthr_t
  				WHERE nopembayaran LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_baru;
    }

        /**
     * Generator untuk nomor inaktif dokumen rekam medis
     * @return string $nomor_baru
     */
    public static function noInaktifDokRM() {
        $default = "001";
        $prefix = date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noretensiinaktif,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nourut
                FROM inaktifrekammedis_t 
                WHERE noretensiinaktif LIKE ('".$prefix."%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix.(isset($nomors['nourut']) ? (str_pad($nomors['nourut']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
     
        return $nomor_baru;
    }
    
    /**
     * Generate nomor urut diagnosis keperawatan
     * @return string
     */
    public static function noDiagnosisKeperawatan() {
        $default = "001";
        $prefix = "DIAGNOSIS" . date("ymd");
        $sql = "SELECT CAST(MAX(SUBSTR(no_diagnosisaskep," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                FROM diagnosisaskep_t
                WHERE no_diagnosisaskep LIKE ('" . $prefix . "%')";
        $reseptur = Yii::app()->db->createCommand($sql)->queryRow();
        $nosetoran_baru = $prefix . (isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nosetoran_baru;
    }
    
    public static function generateNomorPermintaan($ruangan_id) {
        $r = RuanganM::model()->findByPk($ruangan_id);
        $initial_r = $r->ruangan_singkatan;

        $default = "001";
        $prefix = $initial_r . '-';
        $sql = "SELECT CAST(MAX(SUBSTR(no_permintaan," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                        FROM pasienkirimkeunitlain_t
                        WHERE no_permintaan LIKE ('" . $prefix . "%') AND DATE(tgl_kirimpasien) = '" . date('Y-m-d') . "' ";        
        $permintaan = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix . (isset($permintaan['nomaksimal']) ? (str_pad($permintaan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);        
        return $no_baru;
    }
    
    /**
     * 
     * @return string
     */
    public static function noAnestesi() {
        $default = "0001";
        $prefix = 'AT' . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noanestesi," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal 
				FROM pasienanastesi_t 
				WHERE noanestesi LIKE ('" . $prefix . "%')";
        $noAnestesi = Yii::app()->db->createCommand($sql)->queryRow();
        $noAnestesiBaru = $prefix . (isset($noAnestesi['nomaksimal']) ? (str_pad($noAnestesi['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $noAnestesiBaru;
    }

    /**
     * Genarator nomor rencana umum pengadaan (RUP)
     * @return string
     */
    public static function NoRUP() {
        $default = "001";
        $prefix = "RUP" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(rencanaumumpengadaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM rencanaumumpengadaan_t 
                WHERE rencanaumumpengadaan_nomor LIKE ('" . $prefix . "%')";

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Genarator nomor persiapan pengadaan
     * @return string
     */
    public static function NoPersiapanPengadaan() {
        $default = "001";
        $prefix = "PP" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(persiapanpengadaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM persiapanpengadaan_t 
                WHERE persiapanpengadaan_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Generate nomor transaksi untuk penetapanpemenang_t
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string 
     */
    public static function noPenetapanPemenang() {
        $default = "0001";
        $prefix = "PNP" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(penetapanpemenang_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM penetapanpemenang_t 
				WHERE penetapanpemenang_nomor LIKE ('" . $prefix . "%')";
        $nomorPenetapan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorPenetapan_baru = $prefix . (isset($nomorPenetapan['nomaksimal']) ? (str_pad($nomorPenetapan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorPenetapan_baru;
    }
    
    /**
     * Generate nomor transaksi untuk penetapanpemenang_t
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string 
     */
    public static function noPengumumanPemenang() {
        $default = "0001";
        $prefix = "PGP" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(pengumumanpemenang_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM pengumumanpemenang_t 
				WHERE pengumumanpemenang_nomor LIKE ('" . $prefix . "%')";
        $nomorPenetapan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorPenetapan_baru = $prefix . (isset($nomorPenetapan['nomaksimal']) ? (str_pad($nomorPenetapan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorPenetapan_baru;
    }
    
    /*
     * Generate nomor transaksi untuk penunjukanpenyedia_t
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string 
     */
    public static function noPenunjukanPenyedia() {
        $default = "0001";
        $prefix = "SPPBJ" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(penunjukanpenyedia_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM penunjukanpenyedia_t 
				WHERE penunjukanpenyedia_nomor LIKE ('" . $prefix . "%')";
        $nomorPenetapan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorPenetapan_baru = $prefix . (isset($nomorPenetapan['nomaksimal']) ? (str_pad($nomorPenetapan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorPenetapan_baru;
    }
    
    /**
     * Genarator nomor surat perjanjian kerja
     * @author  Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function NoSuratPerjanjianKerja() {
        $default = "001";
        $prefix = "SPK" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nosuratperjanjiankerja," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM suratperjanjiankerja_t
                WHERE nosuratperjanjiankerja LIKE ('" . $prefix . "%')";

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Generate nomor transaksi untuk perintahmulaikerja_t
     * @author  Yusuf Putra Anugrah <yusufputra@.com>
     * @return string 
     */
    public static function noPerintahmulaikerja() {
        $default = "0001";
        $prefix = "SPMK" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(perintahmulaikerja_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM perintahmulaikerja_t 
				WHERE perintahmulaikerja_nomor LIKE ('" . $prefix . "%')";
        $nomorPerintah = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorPerintah_baru = $prefix . (isset($nomorPerintah['nomaksimal']) ? (str_pad($nomorPerintah['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorPerintah_baru;
    }
    
    /**
     * Generator nomor nota dinas ppk
     * @return string
     */
    public static function NoSSKK() {
        $default = "0001";
        $prefix = "SSKK" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(syaratkhususkontrak_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM syaratkhususkontrak_t 
                WHERE syaratkhususkontrak_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Genarator nomor nota dinas pengadaan
     * @author  Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function NoNotaDinasPengadaan() {
        $default = "0001";
        $prefix = "NDPP" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(notadinaspengadaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM notadinaspengadaan_t
                WHERE notadinaspengadaan_nomor LIKE ('" . $prefix . "%')";

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Genarator nomor surat BA Negosiasi/Klarifikasi
     * @author  Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function NoBANegosiasi() {
        $default = "001";
        $prefix = "BAKN" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(banegosiasi_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM banegosiasi_t
                WHERE banegosiasi_nomor LIKE ('" . $prefix . "%')";

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Genarator nomor surat BA Penjelasan Pengadaan Langsung
     * @author  Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function NoBAPengadaanLangsung() {
        $default = "001";
        $prefix = "BAPPL" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapengadaanlangsung_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM bapengadaanlangsung_t
                WHERE bapengadaanlangsung_nomor LIKE ('" . $prefix . "%')";

        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Generator nomor nota dinas ppk
     * @return string
     */
    public static function NoSuratDenda() {
        $default = "001";
        $prefix = "DND" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(suratdenda_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM suratdenda_t 
                WHERE suratdenda_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * Generator nomor nota dinas ppk
     * @return string
     */
    public static function NoDokSuratDenda() {
        $default = "001";
        $prefix_awal = '027/';
        $prefix_akhir = '/301/PPHP/' . date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_dokumen," . (strlen($prefix_awal) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM suratdenda_t 
                WHERE nomor_dokumen LIKE ('" . $prefix_awal . "%') AND nomor_dokumen LIKE ('%" . $prefix_akhir . "')   ";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix_awal . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . $prefix_akhir;
        return $nomor_baru;    
    }
    
    public static function noSKM() {
        $profilrs = ProfilrumahsakitM::model()->find();
        $koderumahsakit = $profilrs->ppkpelayanan;
        $kode_skm = '0537apk';
        $default = "0000001";
        $prefix = $kode_skm . $koderumahsakit . date('ym');
        $bulan = date('m');
        $sql = "SELECT CAST(MAX(SUBSTR(noskp," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM skp_t 
				WHERE noskp LIKE ('" . $prefix . "%') AND date_part('month', create_time)='" . $bulan . "'";
        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomor['nomaksimal']) ? (str_pad($nomor['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
        
    
    /**
     * Genarator nomor surat Evaluasi Penawaran
     * @author  Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function NoEvaluasiPenawaran() {
        $default = "001";
        $prefix = "BAEP" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(evaluasipenawaran_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM evaluasipenawaran_t
                WHERE evaluasipenawaran_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }    
    
    /** Generator nomor Nota Dinas PPTK
     * @author Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function noNotaDinaspptk() {
        $default = "001";
        $prefix = "NDPPTK" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(notadinaspptk_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM notadinaspptk_t 
            WHERE notadinaspptk_nomor LIKE ('" . $prefix . "%')";
        $nomorNotaDinaspptk = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorNotaDinaspptk_baru = $prefix . (isset($nomorNotaDinaspptk['nomaksimal']) ? (str_pad($nomorNotaDinaspptk['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorNotaDinaspptk_baru;
    }
    
    /**
     * Generator nomor BA Pembelian Langsung
     * @return string
     */
    public static function noBAPembelianLangsung() {
        $default = "001";
        $prefix = "BAPL" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapembelianlangsung_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapembelianlangsung_t 
            WHERE bapembelianlangsung_nomor LIKE ('" . $prefix . "%')";
        $nomorBABeliLangsung = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBABeliLangsung_baru = $prefix . (isset($nomorBABeliLangsung['nomaksimal']) ? (str_pad($nomorBABeliLangsung['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBABeliLangsung_baru;
    }
    
    /** Generator nomor BA Kemajuan Hasil Pekerjaan
     * @author Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function noBAKemajuanHasilPekerjaan() {
        $default = "001";
        $prefix = "BAKP" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bakemajuanhasilpekerjaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bakemajuanhasilpekerjaan_t 
            WHERE bakemajuanhasilpekerjaan_nomor LIKE ('" . $prefix . "%')";
        $nomorBAKemajuanHasil = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAKemajuanHasil_baru = $prefix . (isset($nomorBAKemajuanHasil['nomaksimal']) ? (str_pad($nomorBAKemajuanHasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAKemajuanHasil_baru;
    }
    
    /**
     * Generator nomor nota dinas ppk
     * @return string
     */
    public static function NoNotaDinasPPK() {
        $default = "001";
        $prefix = "NDPPK" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(notadinasppk_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM notadinasppk_t 
                WHERE notadinasppk_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /** Generator nomor BA Uji Coba
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public static function noBAUjiCoba() {
        $default = "001";
        $prefix = "BAUC" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(baujifungsi_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM baujifungsi_t 
            WHERE baujifungsi_nomor LIKE ('" . $prefix . "%')";
        $nomorBAUjiCoba = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAUjiCoba_baru = $prefix . (isset($nomorBAUjiCoba['nomaksimal']) ? (str_pad($nomorBAUjiCoba['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAUjiCoba_baru;
    }
    
    /**
     * Generator nomor BA Pemeriksaan Pekerjaan
     * @param type $kode_dokumen
     * @param type $bapemeriksaanpekerjaan_tanggal
     * @return string
     */
    public static function noBeritaAcaraPemeriksaanPekerjaan($kode_dokumen, $bapemeriksaanpekerjaan_tanggal) {
        $default = "0001";
        $prefix = "027/";
        $prefix2 = "/301/";
        $tahunpembuatan = '/' . $bapemeriksaanpekerjaan_tanggal;
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_beritaacara," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapemeriksaanpekerjaan_t 
            WHERE nomor_beritaacara LIKE ('" . $prefix . "%')";
        $nomorBAPeriksaKerja = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPeriksaKerja_baru = $prefix . (isset($nomorBAPeriksaKerja['nomaksimal']) ? (str_pad($nomorBAPeriksaKerja['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) . $prefix2 . $kode_dokumen . $tahunpembuatan : $default . $prefix2 . $kode_dokumen . $tahunpembuatan);
        return $nomorBAPeriksaKerja_baru;
    }
    
    /**
     * Generator nomor Transaksi BA Pemeriksaan Pekerjaan
     * @return string
     */
    public static function noBAPemeriksaanPekerjaan() {
        $default = "001";
        $prefix = "BAPP" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapemeriksaanpekerjaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapemeriksaanpekerjaan_t 
            WHERE bapemeriksaanpekerjaan_nomor LIKE ('" . $prefix . "%')";
        $nomorBAPeriksaKerja = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPeriksaKerja_baru = $prefix . (isset($nomorBAPeriksaKerja['nomaksimal']) ? (str_pad($nomorBAPeriksaKerja['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAPeriksaKerja_baru;
    }
    
    /**
     * Generator nomor BA Hasil Pemeriksaan Pekerjaan
     * @return string
     */
    public static function noBAHasilPemeriksaanPekerjaan() {
        $default = "001";
        $prefix = "BAHP" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bahasilpemeriksaanpekerjaan_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bahasilpemeriksaanpekerjaan_t 
            WHERE bahasilpemeriksaanpekerjaan_nomor LIKE ('" . $prefix . "%')";
        $nomorBAHasil = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAHasil_baru = $prefix . (isset($nomorBAHasil['nomaksimal']) ? (str_pad($nomorBAHasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAHasil_baru;
    }
    
    /** Generator nomor BA Serah Terima
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public static function noBASerahTerima() {
        $default = "001";
        $prefix = "BAST" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(baserahterima_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM baserahterima_t 
            WHERE baserahterima_nomor LIKE ('" . $prefix . "%')";
        $nomorBASerahTerima = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBASerahTerima_baru = $prefix . (isset($nomorBASerahTerima['nomaksimal']) ? (str_pad($nomorBASerahTerima['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBASerahTerima_baru;
    }
    
    /** Generator nomor BA Serah Terima
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public static function noBAPenyerahanBarangJasa() {
        $default = "001";
        $prefix = "BAPBJ" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapenyerahanbarangjasa_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapenyerahanbarangjasa_t 
            WHERE bapenyerahanbarangjasa_nomor LIKE ('" . $prefix . "%')";
        $nomorBAPenyerahanBarangJasa = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPenyerahanBarangJasa_baru = $prefix . (isset($nomorBAPenyerahanBarangJasa['nomaksimal']) ? (str_pad($nomorBAPenyerahanBarangJasa['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAPenyerahanBarangJasa_baru;
    }
    
    /** Generator nomor BA Pemeriksaan Administratif PjPHP
     * @author Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function noBAPemeriksaanAdmPjPHP() {
        $default = "001";
        $prefix = "BAPJ" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapemeriksaanadmpjphp_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapemeriksaanadmpjphp_t 
            WHERE bapemeriksaanadmpjphp_nomor LIKE ('" . $prefix . "%')";
        $nomorBAPemeriksaanAdmPjPHP = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPemeriksaanAdmPjPHP_baru = $prefix . (isset($nomorBAPemeriksaanAdmPjPHP['nomaksimal']) ? (str_pad($nomorBAPemeriksaanAdmPjPHP['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAPemeriksaanAdmPjPHP_baru;
    }
    
    /**
     *  Generator nomor Berita Acara Pemeriksaan Administratif PjPHP
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @param type $tanggal
     * @return string
     */
    public static function noBAPemeriksaanPjPHP($tanggal) {
        $kode = "027/";
        $default = "0001";
        $prefix = "/301/PJPHP/" . date('Y', strtotime($tanggal));
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_beritaacara, 5, 4)) AS integer) nomaksimal
            FROM bapemeriksaanadmpjphp_t";
        $nomorBAPemeriksaanPjPHP = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPemeriksaanPjPHP_baru = $kode . (isset($nomorBAPemeriksaanPjPHP['nomaksimal']) ? (str_pad($nomorBAPemeriksaanPjPHP['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . $prefix;
        return $nomorBAPemeriksaanPjPHP_baru;
    }
    
    /** Generator nomor BA Pemeriksaan Administratif PPHP
     * @author Andyka Putra <andykaputra@.com>
     * @return string
     */
    public static function noBAPemeriksaanAdmPPHP() {
        $default = "001";
        $prefix = "BAPH" . date('Ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(bapemeriksaanadmpphp_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
            FROM bapemeriksaanadmpphp_t 
            WHERE bapemeriksaanadmpphp_nomor LIKE ('" . $prefix . "%')";
        $nomorBAPemeriksaanAdmPPHP = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPemeriksaanAdmPPHP_baru = $prefix . (isset($nomorBAPemeriksaanAdmPPHP['nomaksimal']) ? (str_pad($nomorBAPemeriksaanAdmPPHP['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomorBAPemeriksaanAdmPPHP_baru;
    }
    
    /**
     * Generator nomor Berita Acara Pemeriksaan Administratif PPHP
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @param type $tanggal
     * @return string
     */
    public static function noBAPemeriksaanPPHP($tanggal) {
        $kode = "027/";
        $default = "0001";
        $prefix = "/301/PPHP/" . date('Y', strtotime($tanggal));
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_beritaacara, 5, 4)) AS integer) nomaksimal FROM bapemeriksaanadmpphp_t";
        $nomorBAPemeriksaanPPHP = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBAPemeriksaanPPHP_baru = $kode . (isset($nomorBAPemeriksaanPPHP['nomaksimal']) ? (str_pad($nomorBAPemeriksaanPPHP['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . $prefix;
        return $nomorBAPemeriksaanPPHP_baru;
    }
    
    /**
     * Nomor Insiden Selain Pasien
     * @return type
     */
    public static function noInsidenSelainPasien() {
        $sqlNoSurat = "SELECT MAX(no_kejadian) AS nop FROM insidenrs_selainpasien_t";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();

        $noSurat = str_pad((int) $genSurat['nop'] + 1, 3, 0, STR_PAD_LEFT) . "/SMK3RS/RSDS";
        return trim($noSurat);
    }
    
     /**
     * Nomor Insiden Tumpahan B3
     * @return type
     */
    public static function noInsidenTumpahanB3() {
        $sqlNoSurat = "SELECT MAX(no_dokumen) AS nop FROM insidentumpahanb3_t";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();

        $noSurat = str_pad((int) $genSurat['nop'] + 1, 3, 0, STR_PAD_LEFT) . "/SMK3RS/RSDS";
        return trim($noSurat);
    }
    
    /**
     * Nomor Insiden Tumpahan B3
     * @return type
     */
    public static function noInsidenKebakaran() {
        $sqlNoSurat = "SELECT MAX(no_dokumen) AS nop FROM insidenkebakaran_t";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();

        $noSurat = str_pad((int) $genSurat['nop'] + 1, 3, 0, STR_PAD_LEFT) . "/SMK3RS/RSDS";
        return trim($noSurat);
    }
    
    /**
     * Generator untuk nomor Insiden RS 
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string $nomor_baru
     */
    public static function nomorInsidenRs() {
        $default = "001";
        $prefix = "INS" . date('mY');
        $sql = "SELECT CAST(MAX(SUBSTR(insidenrs_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM insidenrs_t 
                WHERE insidenrs_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Generate norevisi untuk InsidenTumpahanB3T
     * @return string 
     */
    public static function noRevisiTumpahanB3($insidentumpahanb3_id) {
        if (!empty($insidentumpahanb3_id)) {
            $default = "01";
            $sql = "select max(no_revisi) nomaksimal
					from insidentumpahanb3_t 
					where insidentumpahanb3_id = '" . $insidentumpahanb3_id . "'";
            $revisi = Yii::app()->db->createCommand($sql)->queryRow();
            $norevisi_baru = (isset($revisi['nomaksimal']) ? (str_pad($revisi['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
            return $norevisi_baru;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param type $barang_id
     * @return string
     */
    public static function kodeTanah($barang_id) {
        $default = "00001";
        $barang = BarangM::model()->findByPk($barang_id);

        $subsub = SubsubkelompokM::model()->findByPk($barang->subsubkelompok_id);

        if (empty($subsub)) {
            return "0";
        }

        $sql = "SELECT CAST(MAX(SUBSTR(invtanah_kode, length(invtanah_kode) - 2, 3)) AS integer) nomaksimal
                        FROM invtanah_t
                        WHERE invtanah_kode ILIKE '" . $subsub->subsubkelompok_kode . ".%'";

        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBaru = $subsub->subsubkelompok_kode . (isset($nomor['nomaksimal']) ? "." . (str_pad($nomor['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : "." . $default);

        return $nomorBaru;
    }
    
    public static function Kodenoregister($barang_id) {
        $default = "000001";
        $sql = "SELECT * FROM barang_m WHERE barang_id=$barang_id";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_barang = $kode['barang_kode'];

        //select profilrumahsakit
        $sql1 = "select * from profilrumahsakit_m";
        $kode2 = Yii::app()->db->createCommand($sql1)->queryRow();
        $kode_penggunabrg = $kode2['kd_penggunabrg'];
        $kode_esselon = $kode2['kd_esselon1'];
        $kode_wilayah = $kode2['kd_wilayah'];
        $kode_kuasapenggunabrg = $kode2['kd_kuasapenggunabrg'];
        $kode_pembantukuasapenggunabrg = $kode2['kd_pembantukuasapenggunabrg'];

        $kode_register = $kode_penggunabrg . "." . $kode_esselon . "." . $kode_wilayah . "." . $kode_kuasapenggunabrg . "." . $kode_pembantukuasapenggunabrg . "." . "JK" . "." . $kode_barang;

        return $kode_register;
    }
    
    /* 
     * @param type $barang_id
     * @return string
     */
    public static function kodePeralatanMesin($barang_id) {
        $default = "00001";
        $barang = BarangM::model()->findByPk($barang_id);
        $subsub = SubsubkelompokM::model()->findByPk($barang->subsubkelompok_id);
        $prefix = $subsub->subsubkelompok_kode;

        if (empty($subsub)) {
            return "0";
        }

        $sql = "SELECT CAST(MAX(SUBSTR(invperalatan_kode," . (strlen($prefix) + 2) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                        FROM invperalatan_t
                        WHERE invperalatan_kode ILIKE '" . $prefix . ".%'";

        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBaru = $subsub->subsubkelompok_kode . (isset($nomor['nomaksimal']) ? "." . (str_pad($nomor['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : "." . $default);

        return $nomorBaru;
    }
    
    /**
     * 
     * @param type $barang_id
     * @return string
     */
    public static function kodeGedung($barang_id) {
        $default = "00001";
        $barang = BarangM::model()->findByPk($barang_id);
        $subsub = SubsubkelompokM::model()->findByPk($barang->subsubkelompok_id);
        $prefix = $subsub->subsubkelompok_kode;

        if (empty($subsub)) {
            return "0";
        }

        $sql = "SELECT CAST(MAX(SUBSTR(invgedung_kode," . (strlen($prefix) + 2) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                        FROM invgedung_t
                        WHERE invgedung_kode ILIKE '" . $prefix . ".%'";

        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBaru = $subsub->subsubkelompok_kode . (isset($nomor['nomaksimal']) ? "." . (str_pad($nomor['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : "." . $default);

        return $nomorBaru;
    }
    
    /**
     * Set kode awal no register lalu digabung dengan kode aset
     * @return string
     */
    public static function KodeAwalnoregister() {
        //select profilrumahsakit
        $sql1 = "select * from profilrumahsakit_m";
        $kode2 = Yii::app()->db->createCommand($sql1)->queryRow();
        $kode_penggunabrg = $kode2['kd_penggunabrg'];
        $kode_esselon = $kode2['kd_esselon1'];
        $kode_wilayah = $kode2['kd_wilayah'];
        $kode_kuasapenggunabrg = $kode2['kd_kuasapenggunabrg'];
        $kode_pembantukuasapenggunabrg = $kode2['kd_pembantukuasapenggunabrg'];

        $kode_register = $kode_penggunabrg . "." . $kode_esselon . "." . $kode_wilayah . "." . $kode_kuasapenggunabrg . "." . $kode_pembantukuasapenggunabrg . "." . "JK" . ".";

        return $kode_register;
    }
    
     /**
     * @author Deni Hamdani
     * 
     * Generate Kode Aset berdasarkan Kode Sub Sub Kelompok Barang.
     * 
     * @param  integer $barang_id ID barang_m
     * @return string Nomor dengan format <kode subsubkelopok><3digit counter>
     */
    public static function kodeJalan($barang_id) {
        $default = "00001";
        $barang = BarangM::model()->findByPk($barang_id);

        $subsub = SubsubkelompokM::model()->findByPk($barang->subsubkelompok_id);

        if (empty($subsub)) {
            return "0";
        }

        $sql = "SELECT CAST(MAX(SUBSTR(invjalan_kode, length(invjalan_kode) - 2, 3)) AS integer) nomaksimal
                        FROM invjalan_t
                        WHERE invjalan_kode ILIKE '" . $subsub->subsubkelompok_kode . ".%'";

        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorBaru = $subsub->subsubkelompok_kode . (isset($nomor['nomaksimal']) ? "." . (str_pad($nomor['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : "." . $default);

        return $nomorBaru;
    }
    
    /** Generate Corrective Maintenance untuk Corrective Maintenance
     * @return string 
     */
    public static function noCorrectiveMaintenance() {
        $default = "0001";
        $prefix = 'CM' . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(korektifmainten_no," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal 
				FROM korektifmainten_t 
				WHERE korektifmainten_no LIKE ('" . $prefix . "%')";
        $rencanaLembur = Yii::app()->db->createCommand($sql)->queryRow();
        $no_rencana = $prefix . (isset($rencanaLembur['nomaksimal']) ? (str_pad($rencanaLembur['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_rencana;
    }
    
    /** Generator nomor kalibrasi
     * @param type $tanggal
     * @return string
     */
    public static function noInvKalibrasi() {
        $default = "001";
        $prefix = 'KAL' . date('dmy');
        $sql = "SELECT CAST(MAX(SUBSTR(nokalibrasi," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from invkalibarasi_t "
                . "where nokalibrasi LIKE ('" . $prefix . "%') ";
        $pengemasan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($pengemasan['nomaksimal']) ? (str_pad($pengemasan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Generate nomutasiaset untuk mutasiaset_t
     * 
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * @return string
     */
    public static function noMutasiAset() {
        $default = "1";
        $suffix = "/MA/" . date('Y');
        //$sql = "SELECT CAST(MAX(SUBSTR(nomutasiaset, 1, char_length(nomutasiaset)::integer - ".(strlen($suffix)).")) AS integer) nomaksimal
        $sql = " SELECT MAX(left(nomutasiaset," . (0 - strlen($suffix)) . ")::integer) as  nomaksimal
				FROM mutasiaset_t 
				WHERE nomutasiaset LIKE ('%" . $suffix . "')";
        $mutasiAset = Yii::app()->db->createCommand($sql)->queryRow();

        $nomutasiaset_baru = (isset($mutasiAset['nomaksimal']) ? ($mutasiAset['nomaksimal'] + 1) : $default) . $suffix;
        return $nomutasiaset_baru;
    }
    
    /** Generator nomor pencucian bj 
     * @param type $tanggal
     * @return string
     */
    public static function noUsulanHapusAset() {
        $default = "001";
        $prefix = 'UPH' . date('dmy');
        $sql = "SELECT CAST(MAX(SUBSTR(usulanpenghapusanaset_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from usulanpenghapusanaset_t "
                . "where usulanpenghapusanaset_nomor LIKE ('" . $prefix . "%') ";
        $pengemasan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($pengemasan['nomaksimal']) ? (str_pad($pengemasan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**
     * Genarator nomor peminjaman barang
     * @return string
     */
    public static function NoPeminjamanBarang() {
        $default = "001";
        $prefix = "PP" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(peminjamanbrg_nomor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM peminjamanbrg_t 
                WHERE peminjamanbrg_nomor LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }
    
    /**    
     * Generate no work order untuk workorder_t 
     * @return string 
     */
    public static function noWorkOrder() {
        $default = "001";
        $prefix = "WO" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(workorder_no," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal 
                        FROM workorder_t 
                        WHERE workorder_no LIKE ('" . $prefix . "%')";
        $getNoWO = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = $prefix . (isset($getNoWO['nomaksimal']) ? (str_pad($getNoWO['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_baru;
    }
    
    // private function kodeSurat(){
    //     $konfig =  KonfigsystemK::model()->find()->prefix_kode_surat;
    //     return $konfig->prefix_kode_surat;
    // }

    public static function noSuratInternal($type, $tglsurat)
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $perfix = "/".$type."/DIR/".$bulanRomawi."/".$tahun;
        $default = "01";
        
        $sqlNoSurat = "SELECT CAST(MAX(SUBSTR(nomorsurat, 1,".(strlen($default)).")) AS integer) nomaksimal FROM suratinternal_t where tglsurat::date = '".$tglsurat."' and nomorsurat LIKE ('%".$perfix."')";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
       
        $noSurat = (isset($genSurat['nomaksimal']) ? (str_pad($genSurat['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default).$perfix;
        return trim($noSurat);
    }
    
    public static function noCatatanEdukasi()
    {
		$default = "0001";
        $prefix = "CTEDU".date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomorcatatanedukasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM catatanedukasi_t
				WHERE nomorcatatanedukasi LIKE ('".$prefix."%')";
        $noCatatan= Yii::app()->db->createCommand($sql)->queryRow();
        $noreturterima_baru=$prefix.(isset($noCatatan['nomaksimal']) ? (str_pad($noCatatan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noreturterima_baru;
    }

    public static function noTutupJadwalDokter() {
        $default = "00001";
        $prefix = "CJD-";
		$sql = "SELECT CAST(MAX(SUBSTR(no_tutupjadwaldokter,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tutupjadwaldokter_t
				WHERE no_tutupjadwaldokter LIKE ('".$prefix."%')";
        $noCatatan= Yii::app()->db->createCommand($sql)->queryRow();
        $notutup=$prefix.(isset($noCatatan['nomaksimal']) ? (str_pad($noCatatan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $notutup;
    }

    public static function generateNIPOtomatis()
    {
		$default = "00";
        if(!empty(Yii::app()->user->getState('jumlahdigit_nokepegawaian'))){
            $del = "";
            for($i=0; $i < Yii::app()->user->getState('jumlahdigit_nokepegawaian'); $i++){
                $del .= "0";
            }
            $default = (str_pad($del+1, strlen($del), 0,STR_PAD_LEFT));
        }
        
        $prefix = (!empty(Yii::app()->user->getState('labeldepan_nokepegawaian'))? Yii::app()->user->getState('labeldepan_nokepegawaian'): "");
		
        $sql = "SELECT CAST(MAX(SUBSTR(nomorindukpegawai,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pegawai_m
				WHERE nomorindukpegawai LIKE ('".$prefix."%')";
        $mod= Yii::app()->db->createCommand($sql)->queryRow();
        $no=$prefix.(isset($mod['nomaksimal']) ? (str_pad($mod['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no;
    }
    public static function noPengajuanAdvancePayment($kode = null, $profilrs_id = null)
    {
        $modProf = ProfilrumahsakitM::model()->findByPk($profilrs_id);

		$default = "0001";
        $prefix = 'OMDC-'.$kode.'/'.($modProf ? $modProf->namacabang : "").'/'.date('Y').'/'.date('m').'/';
    
		$sql = "SELECT CAST(MAX(SUBSTR(nopengajuan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM advancepayment_t
				WHERE nopengajuan LIKE ('".$prefix."%')";

        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

    public static function noSettlement($profilrs_id = null)
    {
        $modProf = ProfilrumahsakitM::model()->findByPk($profilrs_id);

		$default = "0001";
        $prefix = 'OMDC-SAP'.'/'.($modProf ? $modProf->namacabang : "").'/'.date('Y').'/'.date('m').'/';
    
		$sql = "SELECT CAST(MAX(SUBSTR(nosettlement,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM settlementpayment_t
				WHERE nosettlement LIKE ('".$prefix."%')";

        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

    public static function noSuratKontrolNew($jenissurat_id, $ruangan_id)
    {
        $profil = ProfilrumahsakitM::model()->find();
        $bulan = date('m');
        $ks = "Kontrol";
        $default = "0001";

        $cekPrefix = RuanganM::model()->findByAttributes(array('ruangan_id'=>$ruangan_id));

        if($jenissurat_id == 20){
            $ks = "RAWAT";
        }
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(suratketerangan_id) AS nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat' and nomorsurat LIKE ('".$cekPrefix->ruangan_singkatan."%')";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = $cekPrefix->ruangan_singkatan.''.str_pad($genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/".$ks."/".$profil->namapendek_rumahsakit."/".$bulanRomawi."/".$tahun;

        return trim($noSurat);
    }

    public static function noSuratKontrol($jenissurat_id, $ruangan_id)
    {
        $profil = ProfilrumahsakitM::model()->find();
        $bulan = date('m');
        $ks = "Kontrol";
        $default = "0001";

        $cekPrefix = RuanganM::model()->findByAttributes(array('ruangan_id'=>$ruangan_id));

        if($jenissurat_id == 20){
            $ks = "RAWAT";
        }
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT CAST(MAX(SUBSTR(nomorsurat,".(strlen($cekPrefix->ruangan_singkatan) + 1).",4)) AS integer) nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat' and nomorsurat LIKE ('".$cekPrefix->ruangan_singkatan."%') 
        and SUBSTR(nomorsurat,".(strlen($cekPrefix->ruangan_singkatan) + 1).",4) ~ '^[0-9\.]+$'";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = $cekPrefix->ruangan_singkatan.''.str_pad($genSurat['nop']+1, 4, 0,STR_PAD_LEFT)."/".$ks."/".$profil->namapendek_rumahsakit."/".$bulanRomawi."/".$tahun;

        return trim($noSurat);
    }



    public static function noSuratPerintahRI($instalasi_id, $isperinatologi)
    {
        $profil = ProfilrumahsakitM::model()->find();
        $bulan = date('m');
        $noDigit = "";
        $default = "0001";

        if($instalasi_id == 3){
          $noDigit = "70";
        }else if($instalasi_id == 2){
          $noDigit = "60";
        }

        if($isperinatologi == true){
          $noDigit = "90";
        }

        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $bulanRomawi."/".$tahun;
        $prefix = "/".$profil->namapendek_rumahsakit."/SPRI/".$bulanRomawi."/".$tahun;

        $sqlNoSurat = "SELECT CAST(MAX(SUBSTR(nomorsurat,".(strlen($noDigit)).",".(strlen($default)+1).")) AS integer) nomaksimal
				FROM suratperintahranap_t
				WHERE (nomorsurat LIKE ('".$noDigit."%') and nomorsurat LIKE ('%".$prefix."')) and instalasi_id = ".$instalasi_id." and isranap_perinatologi = ".(($isperinatologi==true)?'true':'false');

         // $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratperintahranap_t where instalasi_id = ".$instalasi_id.' and isranap_perinatologi = '.(($isperinatologi==true)?'true':'false');
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = $noDigit.''.str_pad($genSurat['nomaksimal']+1, 4, 0,STR_PAD_LEFT)."/".$profil->namapendek_rumahsakit."/SPRI/".$bulanRomawi."/".$tahun;
        return trim($noSurat);
    }

    public static function noSuratPerintahRIUrut($instalasi_id, $isperinatologi)
    {
      $profil = ProfilrumahsakitM::model()->find();
      $bulan = date('m');
      $noDigit = "";
      $default = "0001";

      if($instalasi_id == 3){
        $noDigit = "70";
      }else if($instalasi_id == 2){
        $noDigit = "60";
      }

      if($isperinatologi == true){
        $noDigit = "90";
      }

      if($bulan < 10){
          $bln = number_format($bulan);
      }else{
          $bln = $bulan;
      }
      $bulanRomawi = CustomFunction::Romawi($bln);
      $tahun = date('Y');
      $tglsurat = $bulanRomawi."/".$tahun;
      $prefix = "/".$profil->namapendek_rumahsakit."/SPRI/".$bulanRomawi."/".$tahun;

      $sqlNoSurat = "SELECT CAST(MAX(SUBSTR(nomorsurat,".(strlen($noDigit)).",".(strlen($default)+1).")) AS integer) nomaksimal
      FROM suratperintahranap_t
      WHERE (nomorsurat LIKE ('".$noDigit."%') and nomorsurat LIKE ('%".$prefix."')) and instalasi_id = ".$instalasi_id." and isranap_perinatologi = ".(($isperinatologi==true)?'true':'false');

       // $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratperintahranap_t where instalasi_id = ".$instalasi_id.' and isranap_perinatologi = '.(($isperinatologi==true)?'true':'false');
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();
        $noSurat = ($genSurat['nomaksimal']+1);
        return $noSurat;
    }
    
    public static function noAntrianJanjiPoliBaru($pasien_id,$pegawai_id,$ruangan_id, $tgl = null, $jenis = '', $lantai = '', $no_antrian_base = 0)
    {
        $default = '001';        
        $cond = " AND ruangan_id = '" . $ruangan_id . "' ";        
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }

        if ($jenis == 'hd'){
            $cond = " AND lantai_hd ilike '" . $lantai . "' ";

            // cek data pendaftaran ke konsulpoli_t
            $sql2 = "select max(no_antriankonsul) nomaksimal 
                    from konsulpoli_t 
                    where date(tglkonsulpoli) = '" . $tgl . "' and lantai_hd = '" . $lantai . "'";
            $konsul = Yii::app()->db->createCommand($sql2)->queryRow();
            $no_konsul = !empty($konsul['nomaksimal']) ? $konsul['nomaksimal'] : "";
            
            $sql = "select max(no_urutantri) nomaksimal
                from pendaftaran_t 
                where date(tgl_pendaftaran) = '" . $tgl . "' " . $cond . " ";
            $pendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
            
            $nomor = "";
            if (!empty($pendaftaran['nomaksimal'])) {
                if ($pendaftaran['nomaksimal'] > $no_konsul) {
                    $nomor = $pendaftaran['nomaksimal'];
                } else if (!empty($no_konsul)) {
                    $nomor = $no_konsul;
                }
            } else {
                $nomor = $no_konsul;
            }
            $no_urut_baru = (!empty($nomor) ? (str_pad($nomor + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        }else{
            
            $condpeg = '';
            if (!empty($pegawai_id)){
                $condpeg = " AND pegawai_id = '".$pegawai_id."'  ";
            }
            
            $sql_poli = "select max(no_urutantri) nomaksimal
                                    from pendaftaran_t 
                                    where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'  ".$condpeg;
            $pendaftaran_poli = Yii::app()->db->createCommand($sql_poli)->queryRow();
           
            $sql_janjipoli = "select max(no_antrianjanji) nomaksimal
                                    from buatjanjipoli_t 
                                    where date(tgljadwal) = '".$tgl."'::date AND ruangan_id = '".$ruangan_id."'  ".$condpeg;
            $pendaftaran_janji_poli = Yii::app()->db->createCommand($sql_janjipoli)->queryRow();
            $max_poli = isset($pendaftaran_poli['nomaksimal']) ? $pendaftaran_poli['nomaksimal'] : 0;
            $max_janji = isset($pendaftaran_janji_poli['nomaksimal']) ? $pendaftaran_janji_poli['nomaksimal'] : 0;
            if ((int)$max_poli < (int)$max_janji) {
                $max_poli = $max_janji;
            }
            
            $no_urut_baru = str_pad($max_poli+1, strlen($default), 0,STR_PAD_LEFT);
        }

        if ($no_antrian_base != 0 && (int)$no_urut_baru < $no_antrian_base) {
            $no_urut_baru = str_pad($no_antrian_base, strlen($default), "0", STR_PAD_LEFT);
        }

        return $no_urut_baru;
    }

    public static function noAntrianNursestation($nursestation_id)
    {
        $ns = NursestationM::model()->findByPk($nursestation_id);
        $prefix = "";
        if (!empty($ns)) {
            $prefix = $ns->nursestation_singkatan."-";
        }

        $default = '001';
        $tgl = date('Y-m-d');
        $sqlPendaftaran = "select CAST(MAX(SUBSTR(nourut_antriannursestation,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                from pendaftaran_t
                where date(tgl_pendaftaran) = '".$tgl."' and nourut_antriannursestation LIKE ('".$prefix."%')";
        $pendaftaran = Yii::app()->db->createCommand($sqlPendaftaran)->queryRow();
        $no_urut_baru_pendaftaran=$prefix.(isset($pendaftaran['nomaksimal']) ? (str_pad($pendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);

        return $no_urut_baru_pendaftaran;
    }

    /** Generator nomor PENGAJUAN KASBON
     * @param type $tanggal
     * @return string
     */
    public static function noPengajuanKasbon() {
        $default = "001";
        $prefix = 'PK' . date('dmy');
        $sql = "SELECT CAST(MAX(SUBSTR(no_pengajuan," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from pengajuankasbon_t "
                . "where no_pengajuan LIKE ('" . $prefix . "%') ";
        $pengajuan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($pengajuan['nomaksimal']) ? (str_pad($pengajuan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

     /** Generator nomor KUITANSI PENGAJUAN KASBON
     * @param type $tanggal
     * @return string
     */
    public static function noKuitansiKasbon() {
        $default = "001";
        $prefix = date('dmy');
        $sql = "SELECT CAST(MAX(SUBSTR(no_kuitansi," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from pengajuankasbon_t "
                . "where no_kuitansi LIKE ('" . $prefix . "%') ";
        $pengajuan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = (isset($pengajuan['nomaksimal']) ? (str_pad($pengajuan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) ."/". $prefix;
        return $nomor_baru;
    }

     /** Generator nomor VOUCHER PENGAJUAN KASBON
     * @param type $tanggal
     * @return string
     */
    public static function noVoucherLPJ() {
        $default = "001";
        $prefix = date('dmy');
        $sql = "SELECT CAST(MAX(SUBSTR(no_lpj," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal "
                . "from pengajuankasbon_t "
                . "where no_lpj LIKE ('" . $prefix . "%') ";
        $pengajuan = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = (isset($pengajuan['nomaksimal']) ? (str_pad($pengajuan['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . "/".$prefix;
        return $nomor_baru;
    }

    public static function kodetindakanluarGen() {
        $default = "0001";
        $prefix = "TLU" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(tindakanluar_kode," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM tindakanpelayanan_t
				WHERE tindakanluar_kode LIKE ('" . $prefix . "%')";
        $query = Yii::app()->db->createCommand($sql)->queryRow();
        $nocreate = $prefix . (isset($query['nomaksimal']) ? (str_pad($query['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nocreate;
    }

    /**
     * generator untuk penerimaan distribusi darah
     */
    public static function NoPenerimaanDistribusiDarah() {
        $default = "00001";
        $prefix = "TDD" . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nomor_terima," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nourut
                FROM terimadistribusidarah_t
                WHERE nomor_terima LIKE ('" . $prefix . "%')";
        $nomors = Yii::app()->db->createCommand($sql)->queryRow();
        $nomor_baru = $prefix . (isset($nomors['nourut']) ? (str_pad($nomors['nourut'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $nomor_baru;
    }

    /**
     * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
     * @author   Andyka Putra <andykaputra@.com>
     * @author   Aida Rahmawati <aidarahmawati@.com>
     * @version  2.0.0
     * @param    integer $jeniskantongdarah_id ID Jenis Kantong Darah
     * @param    integer $komponendarah ID Komponen Darah
     * @param    integer $bulan Bulan yang dipilih
     * @param    type $tahun Tahun yang dipilih
     * @return   string Hasil nomor kantong darah untuk kolom : kantongdarah_t.no_kantongdarah
     */
    public static function noKantongDarah($jeniskantongdarah_id, $komponendarah, $bulan, $tahun) {
        $default = "00001";
        $jenis = JeniskantongdarahM::model()->findByPk($jeniskantongdarah_id);
        $komponen = KomponendarahM::model()->findByPk($komponendarah);
        $prefix = $komponen->singkatan_komp . $bulan . $tahun;
        $suffix = $jenis->nama_jenis_sngkt;

        $sql = "SELECT CAST(MAX(SUBSTR(no_kantongdarah, " . (strlen($prefix) + 1) . ", 5)) AS integer) nomaksimal
                        FROM kantongdarah_t
                        WHERE no_kantongdarah LIKE ('" . $prefix . "%') AND jeniskantongdarah_id = " . $jeniskantongdarah_id;

        $no = Yii::app()->db->createCommand($sql)->queryRow();

        $no_baru = $prefix . (isset($no['nomaksimal']) ? (str_pad($no['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . $suffix;
        return $no_baru;
    }

    /**
     *
     * Generate Nomor transaksi Kantong Darah
     *
     * @author   M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @version  2.0.0
     * @param    integer $jeniskantongdarah_id ID Jenis Kantong Darah
     * @param    string $tipe untuk mengirimkan data prefix tambahan untuk membedakan antara 'UTAMA' atau 'SAMPEL'
     * @return   string Hasil nomor kantong darah untuk kolom : kantongdarah_t.no_kantongdarah
     */
    public static function noBarcodeKantongDarah($jeniskantongdarah_id, $tipe = '') {
        $default = "00001";
        $jenis = JeniskantongdarahM::model()->findByPk($jeniskantongdarah_id);
        $prefix = $tipe . date("my");
        $suffix = $jenis->nama_jenis_sngkt;

        $sql = "SELECT CAST(MAX(SUBSTR(nomorbarcode_sample, " . (strlen($prefix) + 1) . ", 5)) AS integer) nomaksimal
                        FROM kantongdarah_t
                        WHERE nomorbarcode_sample LIKE ('" . $prefix . "%') AND SUBSTR(nomorbarcode_sample, " . (strlen($prefix) + 1) . ", 5) ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$' ";

        $no = Yii::app()->db->createCommand($sql)->queryRow();

        $no_baru = $prefix . (isset($no['nomaksimal']) ? (str_pad($no['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default) . $suffix;
        return $no_baru;
    }

    /**
     * Generate no pendonor_m
     * @return string
     */
    public static function noPendonor() {
        $default = "00000001";
        $prefix = "";
        $sql = "SELECT CAST(MAX(SUBSTR(no_pendonor," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM pendonor_m
				WHERE no_pendonor LIKE ('" . $prefix . "%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pendonorbaru = $prefix . (isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_pendonorbaru;
    }

    /**
     * Generate pendaftaran Pendonor
     * @return string
     */
    public static function noFormulirPendonor() {
        $default = "0001";
        $prefix = 'DNR' . date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_formulir," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM daftardonasi_t
				WHERE no_formulir LIKE ('" . $prefix . "%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_formulir_baru = $prefix . (isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_formulir_baru;
    }

    /**
     * Generate no Pengiriman kantong darah
     * @return string
     */
    public static function noPengiriman() {
        $default = "0001";
        $prefix = 'KKD' . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(no_kirimkantong," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM kirimkantongdarah_t
				WHERE no_kirimkantong LIKE ('" . $prefix . "%')";
        $hasil = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pengiriman = $prefix . (isset($hasil['nomaksimal']) ? (str_pad($hasil['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_pengiriman;
    }

    // untuk generator no-penerimaan kantong darah
    public static function noPenerimaanKantong() {
        $default = "0001";
        $prefix = "TKD" . date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(no_terimakantong," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal
				FROM terimakantongdarah_t
				WHERE no_terimakantong LIKE ('" . $prefix . "%')";
        $no_terimakantong = Yii::app()->db->createCommand($sql)->queryRow();
        $no_terimakantongbaru = $prefix . (isset($no_terimakantong['nomaksimal']) ? (str_pad($no_terimakantong['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_terimakantongbaru;
    }

    public static function noTransaksiIurBea() {
        $default = "0001";
        $prefix = "TIB" . date("ymd");

        $sql = "SELECT CAST(MAX(SUBSTR(notransaksiiurbea, " . (strlen($prefix) + 1) . ", 4)) AS integer) nomaksimal
                        FROM iurbea_t
                        WHERE notransaksiiurbea LIKE ('" . $prefix . "%')";

        $no = Yii::app()->db->createCommand($sql)->queryRow();

        $no_baru = $prefix . (isset($no['nomaksimal']) ? (str_pad($no['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $no_baru;
    }
}
?>
