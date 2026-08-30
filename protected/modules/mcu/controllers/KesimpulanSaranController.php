<?php

/**
 * issue RSST-2598
 * controller utama
 * 
 * @package application.modules.Mcu
 * @subpackage controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto1@gmail.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
class KesimpulanSaranController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'mcu.views.kesimpulanSaran';

  /**
   * action utama untuk mengakses menu kesimpulan mcu
   * @param type $pendaftaran_id
   * @param type $kesimpulanmcu_id
   * @param type $suratstudiluarmcu_id
   */
  public function actionIndex($pendaftaran_id, $kesimpulanmcu_id = null, $suratstudiluarmcu_id = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = MCPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    //$modPemeriksaanFisik = MCAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

    /**
     * -------- Untuk Model Surat Studi Luar -------
     */
    $modSuratStudiLuar = MCSuratstudiluarmcuT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($modSuratStudiLuar)) {
      if (!empty($_GET['jenis_surat'])) {
        $modSuratStudiLuar->jenis_surat = 'suratstudiluar';
      }
      $modSuratStudiLuar->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($modSuratStudiLuar->tgl_pemeriksaan);
    } else {
      $modSuratStudiLuar = new MCSuratstudiluarmcuT();
      $modSuratStudiLuar->nomorsurat = '-- Otomatis --';
      $modSuratStudiLuar->pegawai_id = Params::PEGAWAI_MCU_KOORDINATOR_ID;
      $modSuratStudiLuar->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));
      $modPemeriksaanUmum = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modPemeriksaanLainLain = McuPemeriksaanlainlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($modPemeriksaanUmum)) {
        if (!empty($modPemeriksaanUmum->beratbadan)) {
          $modSuratStudiLuar->weight = $modPemeriksaanUmum->beratbadan;
        }
        if (!empty($modPemeriksaanUmum->tinggibadan)) {
          $modSuratStudiLuar->height = $modPemeriksaanUmum->beratbadan;
        }
        if (!empty($modPemeriksaanUmum->diagnosis)) {
          $modSuratStudiLuar->keperluan = $modPemeriksaanUmum->diagnosis;
        }
        if (!empty($modPemeriksaanUmum->tekanandarah)) {
          $dataTekananDarah = explode('/', $modPemeriksaanUmum->tekanandarah);
          $jumlah = count((array)$dataTekananDarah);
          if ($jumlah == 2) {
            $modSuratStudiLuar->diastolic_bloodpressure = $dataTekananDarah[0];
            $modSuratStudiLuar->sistolic_bloodpressure = $dataTekananDarah[1];
          } else {
            $modSuratStudiLuar->diastolic_bloodpressure = $dataTekananDarah[0];
            $modSuratStudiLuar->sistolic_bloodpressure = 0;
          }
        }
        if (!empty($modPemeriksaanUmum->nadi)) {
          $modSuratStudiLuar->pulse = $modPemeriksaanUmum->nadi;
        }
      }
      if (!empty($modPemeriksaanLainLain)) {
        if (!empty($modPemeriksaanLainLain->visus_kanan)) {
          $modSuratStudiLuar->vision_right = $modPemeriksaanLainLain->visus_kanan;
        }
        if (!empty($modPemeriksaanLainLain->visus_kiri)) {
          $modSuratStudiLuar->vision_left = $modPemeriksaanLainLain->visus_kiri;
        }
      }
    }
    /*
         * ------ Penutup Model Surat Studi Luar -----------
         */

    $ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByattributes(array('pendaftaran_id' => $pendaftaran_id));
    $nosaran = '';
    if (!empty($ModKesimpulanMCU)) {
      if ($ModKesimpulanMCU->kesimpulan1_status == true) {
        $ModKesimpulanMCU->kesimpulan_radio = 1;
      }
      if ($ModKesimpulanMCU->kesimpulan2_status == true) {
        $ModKesimpulanMCU->kesimpulan_radio = 2;
      }
      if ($ModKesimpulanMCU->kesimpulan3_status == true) {
        $ModKesimpulanMCU->kesimpulan_radio = 3;
      }
      $ModKesimpulanMCU->kesimpulan_checkbox = true;
      $ModKesimpulanMCU->saran_checkbox = true;
    } else {        
      $ModKesimpulanMCU = new MCKesimpulanmcuT();
      //$ModKesimpulanMCU->no_sarandankesimpulan = MyGenerator::noKeperluanMCU();                        
      $ModKesimpulanMCU->no_sarandankesimpulan = '-- Otomatis --';
      $ModKesimpulanMCU->kordinator_id = Params::PEGAWAI_MCU_KOORDINATOR_ID;
      $ModKesimpulanMCU->kesimpulan1_desc = 'Baik / dapat bekerja di tempat sekarang tanpa syarat (FIT)';
      $ModKesimpulanMCU->kesimpulan2_desc = 'Ada kelainan dan perlu pemeriksaan atau pengobatan lebih lanjut, namun masih dapat tetap bekerja ditempat sekarang (FIT dengan Catatan)';
      $ModKesimpulanMCU->kesimpulan3_desc = 'perlu pemeriksaan lebih lanjut, untuk sementara tidak dapat bekerja ditempat sekarang (UNFIT)';
      $ModKesimpulanMCU->kesimpulan_checkbox = 0;
      $ModKesimpulanMCU->saran1_status = 0;
      $ModKesimpulanMCU->saran1_desc = 'Kembali ke Poliklinik untuk :';
      $ModKesimpulanMCU->saran1_1_status = 0;
      $ModKesimpulanMCU->saran1_1_desc = 'Berobat / konsuitasi ke dokter';
      $ModKesimpulanMCU->saran1_2_status = 0;
      $ModKesimpulanMCU->saran1_2_desc = 'Pemeriksaan ulang';
      $ModKesimpulanMCU->saran1_3_status = 0;
      $ModKesimpulanMCU->saran1_3_desc = 'Konsultasi diet / olahraga';
      $ModKesimpulanMCU->saran2_status = 0;
      $ModKesimpulanMCU->saran2_desc = 'Periksa secara teratur ke dokter';
      $ModKesimpulanMCU->saran3_status = 0;
      $ModKesimpulanMCU->saran3_desc = 'Penerapan pola hidup sehat';
      $ModKesimpulanMCU->saran3_1_desc = '* Tidak merokok';
      $ModKesimpulanMCU->saran3_2_desc = '* Olah raga teratur dengan detak jantung minimal 110.0x/mnt, maksimal 140.0x/mnt yang dilakukan sealam 30-40mnt.
	Jenis olahraga : Jalan cepat, senam aerobic';
      $ModKesimpulanMCU->saran3_3_desc = '* Diet';
      $ModKesimpulanMCU->saran3_3_1_status = 0;
      $ModKesimpulanMCU->saran3_3_1_desc = 'Rendah Lemak';
      $ModKesimpulanMCU->saran3_3_2_status = 0;
      $ModKesimpulanMCU->saran3_3_2_desc = 'Rendah Purine';
      $ModKesimpulanMCU->saran3_3_3_status = 0;
      $ModKesimpulanMCU->saran3_3_3_desc = 'Rendah Kalori';
      $ModKesimpulanMCU->saran3_3_4_status = 0;
      $ModKesimpulanMCU->saran3_3_4_desc = 'Rendah Garam';
      $ModKesimpulanMCU->saran3_4_desc = '* Tidur cukup 6-8jam/hari. Kelola stress';
      $ModKesimpulanMCU->tgl_kesimpulanmcu = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

      $nosaran = $ModKesimpulanMCU->no_sarandankesimpulan;
    }

    /*
          untuk detail pemeriksaan lab
         */
    $modDetailHasilPemeriksaans = array();
    $cri = new CDbCriteria();
    $modKunjungan = MCPasienMasukPenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $data = array();
    $modHasilPemeriksaan = array();
    $modHasilPemeriksaanRad = array();
    $modTinLab = '';

    if (!empty($modKunjungan)) {

      $idLab = array();
      $idRLab = array();
      $idRad = array();
      $idRRad = array();
      foreach ($modKunjungan as $d) {
        if ($d->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $idLab[] = $d->pasienmasukpenunjang_id;
          $idRLab[] = $d->ruangan_id;
        }

        if ($d->ruangan_id == Params::RUANGAN_ID_RAD) {
          $idRad[] = $d->pasienmasukpenunjang_id;
          $idRRad[] = $d->ruangan_id;
        }
      }

      $idDaftarAda = array();
      if (!empty($idLab)) {
        $criLab = new CDbCriteria();
        $criLab->addInCondition(" pasienmasukpenunjang_id ", $idLab);
        $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findAll($criLab);
        if (isset($modHasilPemeriksaan)) {
          $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
        }
        if (count((array)$modDetailHasilPemeriksaans) > 0) {
          foreach ($modDetailHasilPemeriksaans as $dt) {
            $idDaftarAda[] = $dt->pemeriksaanlab->daftartindakan_id;
            $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
            $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
            $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
            $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
            $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
            $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
          }
        }

        if (!empty($idLab)) {
          $criLab = new CDbCriteria();
          $criLab->addInCondition(" pasienmasukpenunjang_id ", $idLab);
          $criLab->addInCondition(" ruangan_id ", $idRLab);
          $modHasilPemeriksaan = TindakanpelayananT::model()->findAll($criLab);

          if (!empty($modHasilPemeriksaan)) {
            $idTin = array();
            foreach ($modHasilPemeriksaan as $det) {
              $idTin[] = $det->daftartindakan_id;
            }

            if (!empty($idTin)) {
              $cri = new CDbCriteria();
              $cri->addInCondition(" daftartindakan_id ", $idTin);
              if (!empty($idDaftarAda)) {
                $cri->addNotInCondition(" daftartindakan_id ", $idDaftarAda);
              }
              $lab = PemeriksaanlabM::model()->findAll($cri);

              foreach ($lab as $l) {
                $modTinLab .= $l->pemeriksaanlab_nama . ' : ';
                $modTinLab .= '<br/><br/>';
              }
            }
          }
        }
      }


      if (!empty($idRad)) {
        $criLab = new CDbCriteria();
        $criLab->addInCondition(" pasienmasukpenunjang_id ", $idRad);
        $modHasilPemeriksaanRad = MCHasilpemeriksaanradT::model()->findAll($criLab);
      }
    }
    /* end */

    /* end */

    $modPemeriksaanFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgl_pemeriksaan DESC'));
    if (!empty($modPemeriksaanFisik)) {
      if (empty($ModKesimpulanMCU->kesimpulanmcu_id)) {
        $ModKesimpulanMCU->periksaumum_tinggibadan = $modPemeriksaanFisik->tinggibadan;
        $ModKesimpulanMCU->periksaumum_beratbadan = $modPemeriksaanFisik->beratbadan;
        $ModKesimpulanMCU->periksaumum_tekanandarah = $modPemeriksaanFisik->tekanandarah;
        $ModKesimpulanMCU->periksaumum_sistolic = $modPemeriksaanFisik->tekanandarah_sistolik;
        $ModKesimpulanMCU->periksaumum_diastolic = $modPemeriksaanFisik->tekanandarah_diastolik;
        $ModKesimpulanMCU->periksaumum_nadi = $modPemeriksaanFisik->nadi;
        $ModKesimpulanMCU->periksaumum_nilaibmi = $modPemeriksaanFisik->nilai_bmi;
        $ModKesimpulanMCU->periksaumum_bmikategori = $modPemeriksaanFisik->bmi_kategori;
        $ModKesimpulanMCU->bodymassindex_id = $modPemeriksaanFisik->bodymassindex_id;
        $ModKesimpulanMCU->keperluan = $modPemeriksaanFisik->diagnosis;
      }
    }

    $modPemeriksaanJantung = McuPemeriksaanjantungT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgl_pemeriksaan DESC'));
    $modKandungan = McuPemeriksaankandunganT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgl_pemeriksaan DESC'));
    $modTreadmill = TreadmillT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modHearing = HearingtestT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKonsul = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modDiagnosis = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modSpirometri = SpirometriT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modSurat = SuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modReseptur = ResepturT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $modLain = McuPemeriksaanlainlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgl_pemeriksaan DESC'));

    if (!empty($modLain)) {
      if (empty($ModKesimpulanMCU->kesimpulanmcu_id)) {
        $ModKesimpulanMCU->mata_visus_kanan = $modLain->visus_kanan;
        $ModKesimpulanMCU->mata_visus_kiri = $modLain->visus_kiri;
        $ModKesimpulanMCU->mata_presepsi_warna = $modLain->persepsi_warna;
        if ($modLain->mata_normal == true) {
          $ModKesimpulanMCU->mata = 'Normal';
        } elseif ($modLain->mata_abnormal == true) {
          $ModKesimpulanMCU->mata = 'Abnormal';
        } else {
          $ModKesimpulanMCU->mata = $modLain->mata_keterangan;
        }
      }
    }

    if (isset($_POST['MCKesimpulanmcuT'])) {
      
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        $ModKesimpulanMCU = new MCKesimpulanmcuT();
        $ModKesimpulanMCU->attributes = $_POST['MCKesimpulanmcuT'];
        $ModKesimpulanMCU->pendaftaran_id = $pendaftaran_id;
        $ModKesimpulanMCU->mata = $_POST['MCKesimpulanmcuT']['mata'];
        $ModKesimpulanMCU->mata_visus_kanan = $_POST['MCKesimpulanmcuT']['mata_visus_kanan'];
        $ModKesimpulanMCU->mata_visus_kiri = $_POST['MCKesimpulanmcuT']['mata_visus_kiri'];
        $ModKesimpulanMCU->mata_presepsi_warna = $_POST['MCKesimpulanmcuT']['mata_presepsi_warna'];
        if (empty($ModKesimpulanMCU->kesimpulanmcu_id)) {
          $ModKesimpulanMCU->create_time = date('Y-m-d H:i:s');
          $ModKesimpulanMCU->create_loginpemakai_id = Yii::app()->user->id;
          $ModKesimpulanMCU->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $ModKesimpulanMCU->no_sarandankesimpulan = MyGenerator::noKeperluanMCU();
          
          $ModKesimpulanMCU->kesimpulan1_status = !empty($ModKesimpulanMCU->kesimpulan1_status)?$ModKesimpulanMCU->kesimpulan1_status:'-';
            $ModKesimpulanMCU->kesimpulan1_desc = !empty($ModKesimpulanMCU->kesimpulan1_desc)?$ModKesimpulanMCU->kesimpulan1_desc:'-';
            $ModKesimpulanMCU->saran1_status = !empty($ModKesimpulanMCU->saran1_status)?$ModKesimpulanMCU->saran1_status:'-';
            $ModKesimpulanMCU->saran1_desc = !empty($ModKesimpulanMCU->saran1_desc)?$ModKesimpulanMCU->saran1_desc:'-';
            $ModKesimpulanMCU->saran1_1_status = !empty($ModKesimpulanMCU->saran1_1_status)?$ModKesimpulanMCU->saran1_1_status:'-';
            $ModKesimpulanMCU->saran1_1_desc = !empty($ModKesimpulanMCU->saran1_1_desc)?$ModKesimpulanMCU->saran1_1_desc:'-';
            $ModKesimpulanMCU->saran1_2_status = !empty($ModKesimpulanMCU->saran1_2_status)?$ModKesimpulanMCU->saran1_2_status:'-';
            $ModKesimpulanMCU->saran1_2_desc = !empty($ModKesimpulanMCU->saran1_2_desc)?$ModKesimpulanMCU->saran1_2_desc:'-';
            $ModKesimpulanMCU->saran1_3_status = !empty($ModKesimpulanMCU->saran1_3_status)?$ModKesimpulanMCU->saran1_3_status:'-';
            $ModKesimpulanMCU->saran1_3_desc = !empty($ModKesimpulanMCU->saran1_3_desc)?$ModKesimpulanMCU->saran1_3_desc:'-';
            
            $ModKesimpulanMCU->kesimpulan2_status = !empty($ModKesimpulanMCU->kesimpulan2_status)?$ModKesimpulanMCU->kesimpulan2_status:'-';
            $ModKesimpulanMCU->kesimpulan2_desc = !empty($ModKesimpulanMCU->kesimpulan2_desc)?$ModKesimpulanMCU->kesimpulan2_desc:'-';
            $ModKesimpulanMCU->saran2_status = !empty($ModKesimpulanMCU->saran2_status)?$ModKesimpulanMCU->saran2_status:'-';
            $ModKesimpulanMCU->saran2_desc = !empty($ModKesimpulanMCU->saran2_desc)?$ModKesimpulanMCU->saran2_desc:'-';
            
            $ModKesimpulanMCU->kesimpulan3_status = !empty($ModKesimpulanMCU->kesimpulan3_status)?$ModKesimpulanMCU->kesimpulan3_status:'-';
            $ModKesimpulanMCU->kesimpulan3_desc = !empty($ModKesimpulanMCU->kesimpulan3_desc)?$ModKesimpulanMCU->kesimpulan3_desc:'-';
            $ModKesimpulanMCU->saran3_status = !empty($ModKesimpulanMCU->saran3_status)?$ModKesimpulanMCU->saran3_status:'-';
            $ModKesimpulanMCU->saran3_desc = !empty($ModKesimpulanMCU->saran3_desc)?$ModKesimpulanMCU->saran3_desc:'-';
            $ModKesimpulanMCU->saran3_3_1_status = !empty($ModKesimpulanMCU->saran3_3_1_status)?$ModKesimpulanMCU->saran3_3_1_status:'-';
            $ModKesimpulanMCU->saran3_3_1_desc = !empty($ModKesimpulanMCU->saran3_3_1_desc)?$ModKesimpulanMCU->saran3_3_1_desc:'-';
            $ModKesimpulanMCU->saran3_3_2_status = !empty($ModKesimpulanMCU->saran3_3_2_desc)?$ModKesimpulanMCU->saran3_3_2_desc:'-';
            $ModKesimpulanMCU->saran3_3_2_desc = !empty($ModKesimpulanMCU->saran3_3_2_desc)?$ModKesimpulanMCU->saran3_3_2_desc:'-';
            $ModKesimpulanMCU->saran3_3_3_status = !empty($ModKesimpulanMCU->saran3_3_3_status)?$ModKesimpulanMCU->saran3_3_3_status:'-';
            $ModKesimpulanMCU->saran3_3_3_desc = !empty($ModKesimpulanMCU->saran3_3_3_desc)?$ModKesimpulanMCU->saran3_3_3_desc:'-';
            $ModKesimpulanMCU->saran3_3_4_status = !empty($ModKesimpulanMCU->saran3_3_4_status)?$ModKesimpulanMCU->saran3_3_4_status:'-';
            $ModKesimpulanMCU->saran3_3_4_desc = !empty($ModKesimpulanMCU->saran3_3_4_desc)?$ModKesimpulanMCU->saran3_3_4_desc:'-';
            
            $ModKesimpulanMCU->saran3_1_desc = !empty($ModKesimpulanMCU->saran3_1_desc)?$ModKesimpulanMCU->saran3_1_desc:'-';
            $ModKesimpulanMCU->saran3_2_desc = !empty($ModKesimpulanMCU->saran3_2_desc)?$ModKesimpulanMCU->saran3_2_desc:'-';
            $ModKesimpulanMCU->saran3_3_desc = !empty($ModKesimpulanMCU->saran3_3_desc)?$ModKesimpulanMCU->saran3_3_desc:'-';
            $ModKesimpulanMCU->saran3_4_desc = !empty($ModKesimpulanMCU->saran3_4_desc)?$ModKesimpulanMCU->saran3_4_desc:'-';
            
          
        } else {
          $ModKesimpulanMCU->update_loginpemakai_id = Yii::app()->user->id;
          $ModKesimpulanMCU->update_time = date('Y-m-d H:i:s');
          $ModKesimpulanMCU->no_sarandankesimpulan = $_POST['MCKesimpulanmcuT']['no_sarandankesimpulan'];
        }
        $ModKesimpulanMCU->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $ModKesimpulanMCU->pasien_id = $modPendaftaran->pasien_id;
        $ModKesimpulanMCU->keperluan = $_POST['MCKesimpulanmcuT']['keperluan'];
        $ModKesimpulanMCU->kordinator_id = $_POST['MCKesimpulanmcuT']['kordinator_id'];
        $ModKesimpulanMCU->tgl_kesimpulanmcu = MyFormatter::formatDateTimeForDb($_POST['MCKesimpulanmcuT']['tgl_kesimpulanmcu']);



        if ($ModKesimpulanMCU->validate()) {
          if ($ModKesimpulanMCU->save()) {

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'kesimpulanmcu_id' => $ModKesimpulanMCU->kesimpulanmcu_id, 'sukses' => 1));
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    //Untuk menyimpan transaksi di tabel suratstudiluarmcu_t
    if (isset($_POST['MCSuratstudiluarmcuT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modSuratStudiLuar->attributes = $_POST['MCSuratstudiluarmcuT'];
        if (empty($modSuratStudiLuar->suratstudiluarmcu_id)) {
          $modSuratStudiLuar->nomorsurat = MyGenerator::noSuratStudiLuar();
        }
        $modSuratStudiLuar->pendaftaran_id = $pendaftaran_id;
        $modSuratStudiLuar->pasien_id = $modPendaftaran->pasien_id;
        $modSuratStudiLuar->tgl_pemeriksaan = $_POST['MCSuratstudiluarmcuT']['tgl_pemeriksaan'];
        $date = strtotime(date("Y-m-d", strtotime($modSuratStudiLuar->tgl_pemeriksaan)) . " +3 month");
        $modSuratStudiLuar->masaberlaku = MyFormatter::formatDateTimeForDb(date("Y-m-d H:i:s", $date));
        $modSuratStudiLuar->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($modSuratStudiLuar->tgl_pemeriksaan);

        if ($modSuratStudiLuar->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'suratstudiluar_id' => $modSuratStudiLuar->suratstudiluarmcu_id, 'sukses' => 1, 'jenis_surat' => 'suratstudiluar'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'ModKesimpulanMCU' => $ModKesimpulanMCU,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'data' => $data,
      'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad,
      'modTinLab' => $modTinLab,
      'modSuratStudiLuar' => $modSuratStudiLuar,
      'modPemeriksaanJantung'=>$modPemeriksaanJantung,
      'modKandungan'=>$modKandungan,
      'modTreadmill'=>$modTreadmill,
      'modHearing'=>$modHearing,
      'modKonsul'=>$modKonsul,
      'modDiagnosis'=>$modDiagnosis,
      'modKoroner'=>$modKoroner,
      'modSpirometri'=>$modSpirometri,
      'modSurat'=>$modSurat,
      'modReseptur'=>$modReseptur,
    ));
  }

  /**
   * digunakan untuk mengenerate data detail hasil pemeriksaan lab
   * @param type $modHasilPemeriksaan
   * @return type
   */
  public function loadDetailHasilPemeriksaans($modHasilPemeriksaan)
  {

    $idhasil = array();
    foreach ($modHasilPemeriksaan as $d) {
      $idhasil[] = $d->hasilpemeriksaanlab_id;
    }

    $criteria = new CDbCriteria();
    $criteria->join = "                        
                        LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
			LEFT JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        LEFT JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        LEFT JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addInCondition('t.hasilpemeriksaanlab_id', $idhasil);
    $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);

    return $modDetailHasilPemeriksaans;
  }

  /**
   * @param type $kesimpulanmcu_id
   */
  public function actionPrintMcu($kesimpulanmcu_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByPk($kesimpulanmcu_id);
    $modPendaftaran = MCPendaftaranT::model()->findByPk($ModKesimpulanMCU->pendaftaran_id);

    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaanFisik = MCAsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modPeriksaKacamata = MCPeriksakacamataT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modHearingTest = MCHearingtestT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modHasilPemeriksaanRad = MCHasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));
    $modTreadMill = MCTreadmillT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modJantungKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modPasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));
    $modHasilPemeriksaanLab = MCHasilPemeriksaanLabT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));

    if (count((array)$modHasilPemeriksaanLab) > 0) {
      //$modHasilPemeriksaanLabDetail = MCDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('pemeriksaanlab_id'=>$modHasilPemeriksaanLab->pemeriksaanlab_id));
      $modHasilPemeriksaanLabDetail = null;
    } else {
      $modHasilPemeriksaanLabDetail = null;
    }

    $modKunjungan = MCPasienMasukPenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $idLab = array();
    $idRad = array();
    if (!empty($modKunjungan)) {
      foreach ($modKunjungan as $d) {
        if ($d->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $idLab[] = $d->pasienmasukpenunjang_id;
        }

        if ($d->ruangan_id == Params::RUANGAN_ID_RAD) {
          $idRad[] = $d->pasienmasukpenunjang_id;
        }
      }
    }


    $criLab = new CDbCriteria();
    $criLab->addInCondition(" pasienmasukpenunjang_id ", $idLab);
    $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findAll($criLab);
    $modDetailHasilPemeriksaans = array();
    if (!empty($modHasilPemeriksaan)) {
      $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
    }
    $data = array();
    if (count((array)$modDetailHasilPemeriksaans) > 0) {
      foreach ($modDetailHasilPemeriksaans as $dt) {
        $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
        $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
        $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
        $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
        $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
        $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
        $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
      }
    }


    $judul_print = 'Medical Check Up';
    $this->render('printMcuSimpp', array(
      'format' => $format,
      'ModKesimpulanMCU' => $ModKesimpulanMCU,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'judul_print' => $judul_print,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPeriksaKacamata' => $modPeriksaKacamata,
      'modHearingTest' => $modHearingTest,
      'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad,
      'modTreadMill' => $modTreadMill,
      'modJantungKoroner' => $modJantungKoroner,
      'modPasienMorbiditas' => $modPasienMorbiditas,
      'modHasilPemeriksaanLabDetail' => $modHasilPemeriksaanLabDetail,
      'data' => $data
    ));
  }

  /**
   * @param type $kesimpulanmcu_id
   */
  public function actionPrintMcuLuar($suratstudiluarmcu_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modSuratStudiLuar = MCSuratstudiluarmcuT::model()->findByPk($suratstudiluarmcu_id);
    $modPendaftaran = MCPendaftaranT::model()->findByPk($modSuratStudiLuar->pendaftaran_id);

    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'Medical Check Up';
    $this->render('printMcuLuar', array(
      'format' => $format,
      'modSuratStudiLuar' => $modSuratStudiLuar,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'judul_print' => $judul_print,
    ));
  }

  public function actionPrintMcuPerorangan($kesimpulanmcu_id)
  {
    $this->layout = '//layouts/printWindows';
    $ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByPk($kesimpulanmcu_id);
    $modPendaftaran = MCPendaftaranT::model()->findByPk($ModKesimpulanMCU->pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modHasilPemeriksaanLab = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));
    $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modJantungKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
    $modHasilPemeriksaanLabMCU = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => Params::RUANGAN_ID_KLINIK_MCU), array('order' => 'create_time ASC'));
    if (!empty($modHasilPemeriksaanLabMCU) > 0) {
      $modDetailHasilPemeriksaanLabMCU = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaanLabMCU->hasilpemeriksaanlab_id), array('order' => 'detailhasilpemeriksaanlab_id ASC'));
    } else {
      $modDetailHasilPemeriksaanLabMCU = null;
    }
    if (!empty($modAnamnesa)) {
      $modRiwayatIndividuR = RiwayatindividuR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id), array('order' => 'riwayatindividu_id ASC'));
      $modRiwayatKeluargaR = RiwayatkeluargaR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id), array('order' => 'riwayatkeluarga_id ASC'));
      $criteria = new CDbCriteria;
      $criteria->group = 'jenis_faktor_resiko,anamesa_id';
      $criteria->select = 'jenis_faktor_resiko,anamesa_id';
      $criteria->addCondition("anamesa_id = " . $modAnamnesa->anamesa_id);
      $modRiwayatResikoKerjaJenis = MCRiwayatresikokerjaR::model()->findAll($criteria);
    } else {
      $modRiwayatIndividuR = null;
      $modRiwayatKeluargaR = null;
      $modRiwayatResikoKerjaJenis = null;
    }
    if (!empty($modPemeriksaanFisik)) {
      $criteria = new CDbCriteria;
      $criteria->group = 'jenis_tht,pemeriksaanfisik_id';
      $criteria->select = 'jenis_tht,pemeriksaanfisik_id';
      $criteria->addCondition("pemeriksaanfisik_id = " . $modPemeriksaanFisik->pemeriksaanfisik_id);
      $modRiwayatThtJenis = MCRiwayatthtR::model()->findAll($criteria);
    } else {
      $modRiwayatThtJenis = null;
    }
    $modHasilPemeriksaanRad = MCHasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id' => 33288), array('order' => 'create_time ASC'));





    $this->render('printMcuPerorangan', array(
      'ModKesimpulanMCU' => $ModKesimpulanMCU,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      'modHasilPemeriksaanLab' => $modHasilPemeriksaanLab,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modJantungKoroner' => $modJantungKoroner,
      'modHasilPemeriksaanLabMCU' => $modHasilPemeriksaanLabMCU,
      'modDetailHasilPemeriksaanLabMCU' => $modDetailHasilPemeriksaanLabMCU,
      'modRiwayatIndividuR' => $modRiwayatIndividuR,
      'modRiwayatKeluargaR' => $modRiwayatKeluargaR,
      'modRiwayatResikoKerjaJenis' => $modRiwayatResikoKerjaJenis,
      'modRiwayatThtJenis' => $modRiwayatThtJenis,
      'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad
    ));
  }
}
