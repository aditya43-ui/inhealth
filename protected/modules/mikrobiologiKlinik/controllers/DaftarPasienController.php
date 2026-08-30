<?php
/**
 * Daftar Pasien di modul radiologi
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */

 Yii::import('application.modules.rawatJalan.models.*');
class DaftarPasienController extends MyAuthController {
    
    /**
     * Halaman Index Daftar Pasien Mikrobiologi
     */
    public function actionIndex() {
      $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
      // if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_KLINIK){
      $modPasienMasukPenunjang = new MKPasienMasukPenunjangV;
      // }else{
      //     $modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
      // } 
      $format = new MyFormatter();
      $modPasienMasukPenunjang->statusperiksahasil = NULL;
      //		$modPasienMasukPenunjang->tgl_awal = date('Y-m-d', strtotime('-5 days'));
      $modPasienMasukPenunjang->tgl_awal = date('Y-m-d');
      $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
      //$modPasienMasukPenunjang->tgl_awall = date('Y-m-d');
      //$modPasienMasukPenunjang->tgl_akhirl = date('Y-m-d');
      $modPasienMasukPenunjang->ceklis = false;
      if (isset($_REQUEST['MKPasienMasukPenunjangV'])) {
        $modPasienMasukPenunjang->attributes = $_REQUEST['MKPasienMasukPenunjangV'];
        // $modPasienMasukPenunjang->ceklis = $_REQUEST['MKPasienMasukPenunjangV']['ceklis'];
        // $modPasienMasukPenunjang->statusperiksahasil = $_REQUEST['MKPasienMasukPenunjangV']['statusperiksahasil'];
        $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['MKPasienMasukPenunjangV']['tgl_awal']);
        $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MKPasienMasukPenunjangV']['tgl_akhir']);
        //$modPasienMasukPenunjang->tgl_awall = $format->formatDateTimeForDb($_REQUEST['MKPasienMasukPenunjangV']['tgl_awall']);
        //$modPasienMasukPenunjang->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['MKPasienMasukPenunjangV']['tgl_akhirl']);
        $modPasienMasukPenunjang->prefix_pendaftaran = $_REQUEST['MKPasienMasukPenunjangV']['prefix_pendaftaran'];
      }
      $this->render('index', array('format' => $format, 'model' => $modPasienMasukPenunjang));
    }

    public function actionInformasiRiwayatPasien($id)
    {
      $modelRiwayat = new RJCpptpasienT();
      // $pendaftaran_id = $_GET['pendaftaran_id'];
      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
      $ruangan_id = Yii::app()->user->getState("ruangan_id");
  
      if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
        $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => $ruangan_id));
      } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
        if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
          $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => $ruangan_id));
        }
      }
      if (isset($_GET['RJCpptpasienT'])) {
        $modelRiwayat->attributes = $_GET['RJCpptpasienT'];
      }
      $this->render('rawatJalan.views.daftarPasien._riwayatCPPT', array(
        'modelRiwayat' => $modelRiwayat,
        'modPendaftaran' => $modPendaftaran
      ));
    }

    /**
     * @author Rusdiyanto<rusdiyanto@.com>
     * penambahan fungsi untuk ubah DPJTM
     * @param type $pasienmasukpenunjang_id
     */
    public function actionUbahDokterDPJTM($pasienmasukpenunjang_id) {
        $this->layout = '//layouts/iframe';
        $modPegawai = new PegawaiM();
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        if (isset($modPasienMasukPenunjang->pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByPk($modPasienMasukPenunjang->pegawai_id);
        }

        if (isset($_POST['PasienmasukpenunjangT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $modPasienMasukPenunjang->attributes = $_POST['PasienmasukpenunjangT'];
                $modPasienMasukPenunjang->update_time = date('Y-m-d H:i:s');
                $modPasienMasukPenunjang->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                $ok = $ok && $modPasienMasukPenunjang->save();

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('UbahDokterDPJTM', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modPasienMasukPenunjang));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render('_formUbahDokterDPJTM', array(
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modPegawai' => $modPegawai
        ));
    }

    /**
   * mengenerate riwayat anamnesa
   */
  public function actionSetRiwayatAnamnesa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = MKPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $anamnesa = AnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($anamnesa)) {
        $modAnamnesa = $anamnesa;
      } else {
        $modAnamnesa = new AnamnesaT();
        $modAnamnesa->pendaftaran_id = $pendaftaran_id;
      }
      $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatAnamnesa", array('i' => 0, 'modAnamnesa' => $modAnamnesa), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * mengenerate riwayat pemeriksaan fisik
   */
  public function actionSetRiwayatPemeriksaanFisik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $periksafisik = PemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($periksafisik)) {
        $modPemeriksaan = $periksafisik;
      } else {
        $modPemeriksaan = new PemeriksaanfisikT;
        $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
      }
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatPemeriksaanFisik", array('i' => 0, 'modPemeriksaan' => $modPemeriksaan), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * mengenerate riwayat diagnosa
   */
  public function actionSetRiwayatDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = MKPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $modPasienMorbiditas = new PasienmorbiditasT();
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatDiagnosa", array('i' => 0, 'modPasienMorbiditas' => $modPasienMorbiditas, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  
    /**
     * Halaman mengisi Hasil Analis
     */
    public function actionHasilAnalis($penilaian_kelayakan_spesimen_id, $pasienmasukpenunjang_id, $pemeriksaan = null) {

        $model = MKPenialianKelayakanSpesimenT::model()->findByPk($penilaian_kelayakan_spesimen_id);
        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

        $riwayat_kultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_pewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_cci = PemeriksaancciT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_viralload = PemeriksaanviralloadT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_pcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_tbc = null;

        // echo '<pre>'; var_dump($riwayat_kultur); die;

        $kultur = new PemeriksaankulturT();
        
        $this->render('hasilAnalis', array('model' => $model, 'modKunjungan' => $modKunjungan, 'kultur' => $kultur,
        'riwayat_kultur' => $riwayat_kultur, 'riwayat_pewarnaan' => $riwayat_pewarnaan, 'riwayat_cci' => $riwayat_cci, 'riwayat_viralload' => $riwayat_viralload, 'riwayat_pcr' => $riwayat_pcr, 'riwayat_tbc'=>$riwayat_tbc));
      }

    /**
     * Halaman mengisi Hasil Analis
     */
    public function actionPemeriksaanKultur($penilaian_kelayakan_spesimen_id, $pasienmasukpenunjang_id, $pemeriksaan = null, $pemeriksaankultur_id = null) {

        $model = MKPenialianKelayakanSpesimenT::model()->findByPk($penilaian_kelayakan_spesimen_id);
        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

        $kultur = new PemeriksaankulturT();
        $kelompok = new KelompokpemeriksaanmikroT();

        if(isset($pemeriksaankultur_id)) {
          $kultur = PemeriksaankulturT::model()->findByPk($pemeriksaankultur_id);
        }

        // echo '<pre>'; var_dump($kultur->attributes); die;

        $tindakan = TindakanpelayananT::model()->find("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

        $jns_pemeriksaan = isset($_GET['jenispemeriksaanlab_id']) ? JenispemeriksaanlabM::model()->findByPk($_GET['jenispemeriksaanlab_id'])->jenispemeriksaanlab_nama : ' - ';

        $kultur->jenis_pemeriksaan = $jns_pemeriksaan;

        //Riwayat semua
        $riwayat_kultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_pewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_cci = PemeriksaancciT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_viralload = PemeriksaanviralloadT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_pcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
        $riwayat_tbc = null;

        if(!empty($pemeriksaankultur_id)) {
          $kultur = PemeriksaankulturT::model()->findByPk($pemeriksaankultur_id);
        }

        if (isset($_POST['PemeriksaankulturT'])) {
          $ok = true;
          $trans = Yii::app()->db->beginTransaction();
          try {
              
              $kultur->attributes = $_POST['PemeriksaankulturT'];
              $kultur->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaankulturT']['tgl_pemeriksaan']);
              $kultur->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
              
              $kultur->pendaftaran_id = $modKunjungan->pendaftaran_id;
              $kultur->pasien_id = $modKunjungan->pasien_id;
              $kultur->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

              $kultur->no_lab = $penunjang->no_lab;

              if(!empty($tindakan)) {
                $kultur->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                $kultur->daftartindakan_id = $tindakan->daftartindakan_id;
              }

              if(empty($pemeriksaankultur_id)) {
                $kultur->create_time = date('Y-m-d H:i:s');
                $kultur->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                $kultur->create_ruangan = Yii::app()->user->getState('ruangan_id');
              } else {
                $kultur->update_time = date('Y-m-d H:i:s');
                $kultur->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
              }
              
              // $kultur->pemeriksaankultur_id = 2;

              $ok = $ok && $kultur->save();

              if($ok && !isset($pemeriksaankultur_id)) {
                $kelompok->pemeriksaankultur_id = $kultur->pemeriksaankultur_id;

                $kelompok->pendaftaran_id = $kultur->pendaftaran_id;
                $kelompok->pasien_id = $kultur->pasien_id;
                $kelompok->pasienadmisi_id = $kultur->pasienadmisi_id;
                $kelompok->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;

                $kelompok->tgl_pemeriksaan = $kultur->tgl_pemeriksaan;

                $kelompok->create_time = date('Y-m-d H:i:s');
                $kelompok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

                $kelompok->no_lab = $penunjang->no_lab;
                $kelompok->pegawai_id = $penunjang->pegawai_id;
                $kelompok->dpjp_id = $penunjang->dpjp_id;
                $kelompok->perawat_id = $penunjang->perawat_id;

                $kelompok->is_pemeriksaankultur = true;

                if(!empty($tindakan)) {
                  $kelompok->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                }

                $ok = $ok && $kelompok->save();


              }

              // echo '<pre>'; var_dump($ok, $kultur->attributes, '----- -----------------------------------', '----------------------------------------', $_POST['PemeriksaankulturT']); die;


              if ($ok) {
                  $trans->commit();
                  Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                  $this->redirect(array('pemeriksaanKultur', 'penilaian_kelayakan_spesimen_id' => $penilaian_kelayakan_spesimen_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaan' => 'kultur', 'pemeriksaankultur_id' => $kultur->pemeriksaankultur_id,  'sukses' => 1));
              } else {
                  $trans->rollback();
                  Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($kultur));
              }
          } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
              $trans->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }
        
        $this->render('hasilAnalis', array('model' => $model, 'modKunjungan' => $modKunjungan, 'kultur' => $kultur,
         'riwayat_kultur' => $riwayat_kultur, 'riwayat_pewarnaan' => $riwayat_pewarnaan, 'riwayat_cci' => $riwayat_cci, 'riwayat_viralload' => $riwayat_viralload, 'riwayat_pcr' => $riwayat_pcr, 'riwayat_tbc'=>$riwayat_tbc));
    }

    /**
     * Mencetak pemeriksaan kultur
     * @param type $pemeriksaankultur_id
     */
    public function actionPrintKultur($pemeriksaankultur_id)
    {
      $this->layout = '//layouts/printWindows';

      $kultur = PemeriksaankulturT::model()->findByPk($pemeriksaankultur_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($kultur->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($kultur->pasien_id);

      $this->render('_hasilAnalis/_printKultur', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'kultur' => $kultur));

    }

    public function actionHapusKultur() {
      if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
      }

      $id = $_POST['id'];
      $trans = Yii::app()->db->beginTransaction();
      
      try {

        KelompokpemeriksaanmikroT::model()->deleteAllByAttributes(array(
          'pemeriksaankultur_id'=>$id
        ));
        PemeriksaankulturT::model()->deleteByPk($id);

        $trans->commit();
        echo CJSON::encode(array(
          'ok'=>1,
          'msg'=>'Hasil pemeriksaan berhasil dihapus',
        ));

        // var_dump($_POST); die;

      } catch (Exception $e) {
        $trans->rollback();
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>$e->getMessage()
        ));
      }

    }


    /**
     * Halaman mengisi Hasil Analis
     */
    public function actionPewarnaanLangsung($penilaian_kelayakan_spesimen_id, $pasienmasukpenunjang_id, $pemeriksaanpewarnaan_id = null) {

      $model = MKPenialianKelayakanSpesimenT::model()->findByPk($penilaian_kelayakan_spesimen_id);
      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

      $kultur = new PemeriksaankulturT();
      $pewarnaan = new PemeriksaanpewarnaanT();
      $kelompok = new KelompokpemeriksaanmikroT();

      $tindakan = TindakanpelayananT::model()->find("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $jns_pemeriksaan = isset($_GET['jenispemeriksaanlab_id']) ? JenispemeriksaanlabM::model()->findByPk($_GET['jenispemeriksaanlab_id'])->jenispemeriksaanlab_nama : ' - ';

      $pewarnaan->jenis_pemeriksaan = $jns_pemeriksaan;

      $riwayat_kultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_cci = PemeriksaancciT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_viralload = PemeriksaanviralloadT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_tbc = null;

      if(!empty($pemeriksaanpewarnaan_id)) {
        $pewarnaan = PemeriksaanpewarnaanT::model()->findByPk($pemeriksaanpewarnaan_id);
      }

      if (isset($_POST['PemeriksaanpewarnaanT'])) {
        $ok = true;
        $trans = Yii::app()->db->beginTransaction();
        try {
            
            $pewarnaan->attributes = $_POST['PemeriksaanpewarnaanT'];
            // if(empty($_POST['PemeriksaanpewarnaanT']['pemeriksaanpewarnaan_id'])) {
            //   $pewarnaan->pemeriksaanpewarnaan_id = null;
            // }
            $pewarnaan->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaanpewarnaanT']['tgl_pemeriksaan']);
            $pewarnaan->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
            
            $pewarnaan->pendaftaran_id = $modKunjungan->pendaftaran_id;
            $pewarnaan->pasien_id = $modKunjungan->pasien_id;
            $pewarnaan->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

            $pewarnaan->no_lab = $penunjang->no_lab;

            if(!empty($tindakan)) {
              $pewarnaan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
              $pewarnaan->daftartindakan_id = $tindakan->daftartindakan_id;
            }

            if(empty($pemeriksaankultur_id)) {
              $pewarnaan->create_time = date('Y-m-d H:i:s');
              $pewarnaan->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
              $pewarnaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            } else {
              $pewarnaan->update_time = date('Y-m-d H:i:s');
              $pewarnaan->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            } 

            $ok = $ok && $pewarnaan->save();

            if($ok && !isset($pemeriksaanpewarnaan_id)) {
              $kelompok->pemeriksaanpewarnaan_id = $pewarnaan->pemeriksaanpewarnaan_id;
              $kelompok->is_pemeriksaanpewarnaan = true;

              $kelompok->pendaftaran_id = $modKunjungan->pendaftaran_id;
              $kelompok->pasien_id = $modKunjungan->pasien_id;
              $kelompok->pasienadmisi_id = $modKunjungan->pasienadmisi_id;
              $kelompok->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
              $kelompok->tgl_pemeriksaan = $pewarnaan->tgl_pemeriksaan;
              $kelompok->no_lab = $pewarnaan->no_lab;
              $kelompok->pegawai_id = $pewarnaan->pegawai_id;
              $kelompok->dpjp_id = $pewarnaan->dpjp_id;
              $kelompok->perawat_id = $pewarnaan->perawat_id;
              $kelompok->tindakanpelayanan_id = $pewarnaan->tindakanpelayanan_id;

              $kelompok->create_time = date('Y-m-d H:i:s');
              $kelompok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

              $ok = $ok && $kelompok->save();
              
            }

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                $this->redirect(array('pewarnaanLangsung', 'penilaian_kelayakan_spesimen_id' => $penilaian_kelayakan_spesimen_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaan' => 'pewarnaan', 'pemeriksaanpewarnaan_id' => $pewarnaan->pemeriksaanpewarnaan_id,  'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($pewarnaan));
            }
        } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
    }
      
    $this->render('hasilAnalis', array('model' => $model, 'modKunjungan' => $modKunjungan, 'kultur' => $kultur, 'pewarnaan' => $pewarnaan,
    'riwayat_kultur' => $riwayat_kultur, 'riwayat_pewarnaan' => $riwayat_pewarnaan, 'riwayat_cci' => $riwayat_cci, 'riwayat_viralload' => $riwayat_viralload, 'riwayat_pcr' => $riwayat_pcr, 'riwayat_tbc'=>$riwayat_tbc));
  }


    public function actionPrintPewarnaan($pemeriksaanpewarnaan_id)
    {
      $this->layout = '//layouts/printWindows';

      $pewarnaan = PemeriksaanpewarnaanT::model()->findByPk($pemeriksaanpewarnaan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pewarnaan->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($pewarnaan->pasien_id);

      $this->render('_hasilAnalis/_printPewarnaan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'pewarnaan' => $pewarnaan));

    }

    public function actionHapusPewarnaan() {
      if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
      }

      $id = $_POST['id'];
      $trans = Yii::app()->db->beginTransaction();
      
      try {

        KelompokpemeriksaanmikroT::model()->deleteAllByAttributes(array(
          'pemeriksaankultur'=>$id
        ));
        PemeriksaanpewarnaanT::model()->deleteByPk($id);

        $trans->commit();
        echo CJSON::encode(array(
          'ok'=>1,
          'msg'=>'Hasil pemeriksaan berhasil dihapus',
        ));

        // var_dump($_POST); die;

      } catch (Exception $e) {
        $trans->rollback();
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>$e->getMessage()
        ));
      }

    }


     /**
     * Halaman mengisi Hasil Analis
     */
    public function actionCci($penilaian_kelayakan_spesimen_id, $pasienmasukpenunjang_id, $pemeriksaancci_id = null) {

      $model = MKPenialianKelayakanSpesimenT::model()->findByPk($penilaian_kelayakan_spesimen_id);
      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

      $kultur = new PemeriksaankulturT();
      $pewarnaan = new PemeriksaanpewarnaanT();
      $cci = new PemeriksaancciT();
      $kelompok = new KelompokpemeriksaanmikroT();

      $tindakan = TindakanpelayananT::model()->find("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $jns_pemeriksaan = isset($_GET['jenispemeriksaanlab_id']) ? JenispemeriksaanlabM::model()->findByPk($_GET['jenispemeriksaanlab_id'])->jenispemeriksaanlab_nama : ' - ';
      $jns_pemeriksaan_id = isset($_GET['jenispemeriksaanlab_id']) ? $_GET['jenispemeriksaanlab_id'] : null;

      $cci->jenis_pemeriksaan = $jns_pemeriksaan;

      $riwayat_kultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_cci = PemeriksaancciT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_viralload = PemeriksaanviralloadT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_tbc = null;

      if(!empty($pemeriksaancci_id)) {
        $cci = PemeriksaancciT::model()->findByPk($pemeriksaancci_id);
      }
      // echo '<pre>'; var_dump($_POST); die;

      if (isset($_POST['PemeriksaancciT'])) {
        $ok = true;
        $trans = Yii::app()->db->beginTransaction();
        try {

            $cci->attributes = $_POST['PemeriksaancciT'];
            // if(empty($_POST['PemeriksaancciT']['pemeriksaancci_id'])) {
            //   $cci->pemeriksaancci_id = null;
            // }
            $cci->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaancciT']['tgl_pemeriksaan']);
            $cci->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
            
            $cci->pendaftaran_id = $modKunjungan->pendaftaran_id;
            $cci->pasien_id = $modKunjungan->pasien_id;
            $cci->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

            $cci->no_lab = $penunjang->no_lab;

            if(!empty($tindakan)) {
              $cci->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
              $cci->daftartindakan_id = $tindakan->daftartindakan_id;
            }

            if(empty($pemeriksaancci_id)) {
              $cci->create_time = date('Y-m-d H:i:s');
              $cci->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
              $cci->create_ruangan = Yii::app()->user->getState('ruangan_id');
            } else {
              $cci->update_time = date('Y-m-d H:i:s');
              $cci->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            } 

            $ok = $ok && $cci->save();

            if($ok && !isset($pemeriksaancci_id)) {
              $kelompok->pemeriksaancci_id = $cci->pemeriksaancci_id;
              $kelompok->is_pemeriksaancci = true;

              $kelompok->pendaftaran_id = $modKunjungan->pendaftaran_id;
              $kelompok->pasien_id = $modKunjungan->pasien_id;
              $kelompok->pasienadmisi_id = $modKunjungan->pasienadmisi_id;
              $kelompok->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
              $kelompok->tgl_pemeriksaan = $cci->tgl_pemeriksaan;
              $kelompok->no_lab = $cci->no_lab;
              $kelompok->pegawai_id = $cci->pegawai_id;
              $kelompok->dpjp_id = $cci->dpjp_id;
              $kelompok->perawat_id = $cci->perawat_id;
              $kelompok->tindakanpelayanan_id = $cci->tindakanpelayanan_id;

              $kelompok->create_time = date('Y-m-d H:i:s');
              $kelompok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

              $ok = $ok && $kelompok->save();
              
            }

            // var_dump($ok); die;

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                $this->redirect(array('Cci', 'penilaian_kelayakan_spesimen_id' => $penilaian_kelayakan_spesimen_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaan' => 'cci', 'pemeriksaancci_id' => $cci->pemeriksaancci_id, 'jenispemeriksaanlab_id' => $jns_pemeriksaan_id, 'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($cci));
            }
        } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
    }
      
    $this->render('hasilAnalis', array('model' => $model, 'modKunjungan' => $modKunjungan,'cci' => $cci,
    'riwayat_kultur' => $riwayat_kultur, 'riwayat_pewarnaan' => $riwayat_pewarnaan, 'riwayat_cci' => $riwayat_cci, 'riwayat_viralload' => $riwayat_viralload, 'riwayat_pcr' => $riwayat_pcr, 'riwayat_tbc'=>$riwayat_tbc));
  }

  public function actionPrintCci($pemeriksaancci_id)
  {
    $this->layout = '//layouts/printWindows';

    $cci = PemeriksaancciT::model()->findByPk($pemeriksaancci_id);
    $modKelompokcci = KelompokpemeriksaanmikroT::model()->findByAttributes(['pemeriksaancci_id' => $pemeriksaancci_id]);

    $modPendaftaran = PendaftaranT::model()->findByPk($cci->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($cci->pasien_id);

    $this->render('_hasilAnalis/_printCci', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'cci' => $cci, 'modKelompokcci' => $modKelompokcci));

  }

  public function actionHapusCci() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $trans = Yii::app()->db->beginTransaction();
    
    try {

      KelompokpemeriksaanmikroT::model()->deleteAllByAttributes(array(
        'pemeriksaancci'=>$id
      ));
      PemeriksaancciT::model()->deleteByPk($id);

      $trans->commit();
      echo CJSON::encode(array(
        'ok'=>1,
        'msg'=>'Hasil pemeriksaan berhasil dihapus',
      ));

      // var_dump($_POST); die;

    } catch (Exception $e) {
      $trans->rollback();
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>$e->getMessage()
      ));
    }

  }

   /**
     * Halaman mengisi Hasil Analis
     */
    public function actionViralLoad($penilaian_kelayakan_spesimen_id, $pasienmasukpenunjang_id, $pemeriksaanviralload_id = null) {

      $model = MKPenialianKelayakanSpesimenT::model()->findByPk($penilaian_kelayakan_spesimen_id);
      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

      $viralload = new PemeriksaanviralloadT();
      $kelompok = new KelompokpemeriksaanmikroT();

      $tindakan = TindakanpelayananT::model()->find("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $jns_pemeriksaan = isset($_GET['jenispemeriksaanlab_id']) ? JenispemeriksaanlabM::model()->findByPk($_GET['jenispemeriksaanlab_id'])->jenispemeriksaanlab_nama : ' - ';
      $jns_pemeriksaan_id = isset($_GET['jenispemeriksaanlab_id']) ? $_GET['jenispemeriksaanlab_id'] : null;

      $viralload->jenis_pemeriksaan = $jns_pemeriksaan;

      $riwayat_kultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_cci = PemeriksaancciT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_viralload = PemeriksaanviralloadT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_pcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = $pasienmasukpenunjang_id");
      $riwayat_tbc = null;

      if(!empty($pemeriksaanviralload_id)) {
        $viralload = PemeriksaanviralloadT::model()->findByPk($pemeriksaanviralload_id);
      }
      // echo '<pre>'; var_dump($_POST); die;

      if (isset($_POST['PemeriksaanviralloadT'])) {
        $ok = true;
        $trans = Yii::app()->db->beginTransaction();
        try {

            $viralload->attributes = $_POST['PemeriksaanviralloadT'];
            // if(empty($_POST['PemeriksaanviralloadT']['pemeriksaanviralload_id'])) {
            //   $viralload->pemeriksaanviralload_id = null;
            // }
            $viralload->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaanviralloadT']['tgl_pemeriksaan']);
            $viralload->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
            
            $viralload->pendaftaran_id = $modKunjungan->pendaftaran_id;
            $viralload->pasien_id = $modKunjungan->pasien_id;
            $viralload->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

            $viralload->no_lab = $penunjang->no_lab;

            if(!empty($tindakan)) {
              $viralload->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
              $viralload->daftartindakan_id = $tindakan->daftartindakan_id;
              $viralload->daftartindakan_nama = $tindakan->daftartindakan->daftartindakan_nama;
            }

            if(empty($pemeriksaanviralload_id)) {
              $viralload->create_time = date('Y-m-d H:i:s');
              $viralload->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
              $viralload->create_ruangan = Yii::app()->user->getState('ruangan_id');
            } else {
              $viralload->update_time = date('Y-m-d H:i:s');
              $viralload->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            } 

            // echo '<pre>'; var_dump($viralload->attributes); die;

            $ok = $ok && $viralload->save();

            if($ok && !isset($pemeriksaanviralload_id)) {
              $kelompok->pemeriksaanviralload_id = $viralload->pemeriksaanviralload_id;
              $kelompok->is_pemeriksaanviralload = true;

              $kelompok->pendaftaran_id = $modKunjungan->pendaftaran_id;
              $kelompok->pasien_id = $modKunjungan->pasien_id;
              $kelompok->pasienadmisi_id = $modKunjungan->pasienadmisi_id;
              $kelompok->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
              $kelompok->tgl_pemeriksaan = $viralload->tgl_pemeriksaan;
              $kelompok->no_lab = $viralload->no_lab;
              $kelompok->pegawai_id = $viralload->pegawai_id;
              $kelompok->dpjp_id = $viralload->dpjp_id;
              $kelompok->perawat_id = $viralload->perawat_id;
              $kelompok->tindakanpelayanan_id = $viralload->tindakanpelayanan_id;

              $kelompok->create_time = date('Y-m-d H:i:s');
              $kelompok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

              $ok = $ok && $kelompok->save();
              
            }

            // var_dump($ok); die;

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                $this->redirect(array('viralLoad', 'penilaian_kelayakan_spesimen_id' => $penilaian_kelayakan_spesimen_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaan' => 'viralload', 'pemeriksaanviralload_id' => $viralload->pemeriksaanviralload_id, 'jenispemeriksaanlab_id' => $jns_pemeriksaan_id, 'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($cci));
            }
        } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
    }
      
    $this->render('hasilAnalis', array('model' => $model, 'modKunjungan' => $modKunjungan,
    'viralload' => $viralload,
    'riwayat_kultur' => $riwayat_kultur, 'riwayat_pewarnaan' => $riwayat_pewarnaan, 'riwayat_cci' => $riwayat_cci, 'riwayat_viralload' => $riwayat_viralload, 'riwayat_pcr' => $riwayat_pcr, 'riwayat_tbc'=>$riwayat_tbc));
  }

  public function actionPrintViralLoad($pemeriksaanviralload_id)
  {
    $this->layout = '//layouts/printWindows';

    $viralload = PemeriksaanviralloadT::model()->findByPk($pemeriksaanviralload_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($viralload->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($viralload->pasien_id);

    $this->render('_hasilAnalis/_printViralLoad', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'viralload' => $viralload));

  }


  public function actionHapusViralLoad() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $trans = Yii::app()->db->beginTransaction();
    
    try {

      KelompokpemeriksaanmikroT::model()->deleteAllByAttributes(array(
        'pemeriksaanviralload_id'=>$id
      ));
      PemeriksaanviralloadT::model()->deleteByPk($id);

      $trans->commit();
      echo CJSON::encode(array(
        'ok'=>1,
        'msg'=>'Hasil pemeriksaan berhasil dihapus',
      ));

      // var_dump($_POST); die;

    } catch (Exception $e) {
      $trans->rollback();
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>$e->getMessage()
      ));
    }

  }



    /**
     * Halaman mengisi Hasil Analis
     */
    public function actionPcrCovid($pasienmasukpenunjang_id, $daftartindakan_id, $tindakanpelayanan_id, $pemeriksaanpcr_id = null, $pemeriksaanpcr_id_copy = null) {

      if (!empty($pemeriksaanpcr_id)) {
        $model = MKPemeriksaanpcrT::model()->findByPk($pemeriksaanpcr_id);
      }

      if (!empty($pemeriksaanpcr_id_copy)) {
        $model = MKPemeriksaanpcrT::model()->findByPk($pemeriksaanpcr_id_copy);
        $model->pemeriksaanpcr_id = null;
        $model->isNewRecord = true;
      }

      if (empty($model)) {
        $model = new MKPemeriksaanpcrT;
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $model->tgl_pemeriksaan = date('Y-m-d H:i:s');
      }

      $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan);
      $model->is_negative = $model->is_negative ? "1" : "0";


      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));
      $tindakan = TindakanpelayananT::model()->findByPk($tindakanpelayanan_id);
      $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $jns_pemeriksaan = isset($_GET['jenispemeriksaanlab_id']) ? JenispemeriksaanlabM::model()->findByPk($_GET['jenispemeriksaanlab_id'])->jenispemeriksaanlab_nama : ' - ';

      $model->jenis_pemeriksaan = $jns_pemeriksaan;

      if (isset($_POST['MKPemeriksaanpcrT'])) {
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;

        try {
          $model->attributes = $_POST['MKPemeriksaanpcrT'];

          $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($model->tgl_pemeriksaan);
          $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
          
          $model->pendaftaran_id = $modKunjungan->pendaftaran_id;
          $model->pasien_id = $modKunjungan->pasien_id;
          $model->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

          // $model->no_lab = $penunjang->no_lab;
          $model->no_lab = $tindakan->no_lab;
          
          $model->daftartindakan_nama = $tindakan->daftartindakan->daftartindakan_nama ?? "";

          if(!empty($tindakan)) {
            $model->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
            $model->daftartindakan_id = $tindakan->daftartindakan_id;
          }

          if(empty($pemeriksaanpcr_id)) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
          } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
          } 

          $ok = $ok && $model->save();


          // simpan periksa mikro
          $mikro = KelompokpemeriksaanmikroT::model()->findByAttributes(array(
            'pemeriksaanpcr_id'=>$model->pemeriksaanpcr_id
          ));

          if (empty($mikro)) {
            $mikro = new KelompokpemeriksaanmikroT;
          }

          $mikro->attributes = $model->attributes;

          if ($mikro->isNewRecord) {
            $mikro->tindakanpelayanan_id = $model->tindakanpelayanan_id;
            $mikro->is_validasi = false;
            $mikro->is_kirimhasil = false;
            $mikro->is_pemeriksaanpcr = true;
          }

          $ok = $ok && $mikro->save();


          // var_dump($ok, $model->errors, $model->attributes, $mikro->attributes);
          // die;

          if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
            $this->redirect(array('pcrCovid', 'penilaian_kelayakan_spesimen_id' => null, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'daftartindakan_id' => $daftartindakan_id, 'tindakanpelayanan_id'=>$tindakanpelayanan_id, 'pemeriksaanpcr_id' => $model->pemeriksaanpcr_id,  'sukses' => 1));
          } else {
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan. " . CHtml::errorSummary($model));
          }


        } catch (CException $e) {
          //echo '<pre>'; var_dump($exc); die;
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan. " . $e->getMessage());
        }
      }

      $this->render('_pcrCovid/index', array('model' => $model, 'modKunjungan' => $modKunjungan, 'model' => $model));
    }

    /**
     * Mencetak pemeriksaan pcr
     * @param type $pemeriksaanpcr_id
     */
    public function actionPrintPcr($pemeriksaanpcr_id)
    {
      $this->layout = '//layouts/printWindows';

      $model = MKPemeriksaanpcrT::model()->findByPk($pemeriksaanpcr_id);
      $modPendaftaran = PemeriksaankulturT::model()->findByPk($model->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($model->pasien_id);

      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $model->pasienmasukpenunjang_id));
      $tindakan = TindakanpelayananT::model()->findByPk($model->tindakanpelayanan_id);
      $penunjang = PasienmasukpenunjangT::model()->findByPk($model->pasienmasukpenunjang_id);

      $jns_pemeriksaan = !empty($tindakan) ? $tindakan->daftartindakan->daftartindakan_nama : ' - ';

      $model->jenis_pemeriksaan = $jns_pemeriksaan;


      $this->render('_pcrCovid/_printPcr', array(
        'modPendaftaran' => $modPendaftaran, 
        'modPasien' => $modPasien,
        'model' => $model,
        'tindakan' => $tindakan,
        'modKunjungan' => $modKunjungan,
        'penunjang' => $penunjang,
      ));

    }

    public function actionHapusPcr() {
      if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
      }

      $id = $_POST['id'];
      $trans = Yii::app()->db->beginTransaction();
      
      try {


        KelompokpemeriksaanmikroT::model()->deleteAllByAttributes(array(
          'pemeriksaanpcr_id'=>$id
        ));
        MKPemeriksaanpcrT::model()->deleteByPk($id);

        $trans->commit();
        echo CJSON::encode(array(
          'ok'=>1,
          'msg'=>'Hasil pemeriksaan berhasil dihapus',
        ));

        // var_dump($_POST); die;

      } catch (Exception $e) {
        $trans->rollback();
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>$e->getMessage()
        ));
      }

    }


    
}