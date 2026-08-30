<?php
Yii::import('rawatJalan.models.*');
class RadiologiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $updateHasilPemeriksaanRad = false;
  protected $path_view = 'mcu.views.radiologi.';
  protected $path_view_rad = 'rawatJalan.views.radiologi.';

  public function actionIndex($pendaftaran_id)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modHasilPemeriksaanRad = new MCHasilpemeriksaanradT;
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;

    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modPeriksaRad = RJPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));
    $modPermintaanPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPasien->pasien_id, 'ruangan_id' => Params::RUANGAN_ID_RAD), array('order' => 'pasienmasukpenunjang_id DESC'));

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
    }

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    if (isset($_POST['MCHasilpemeriksaanradT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (count((array)$_POST['MCHasilpemeriksaanradT']) > 0) {
          foreach ($_POST['MCHasilpemeriksaanradT'] as $i => $detail) {
            $modHasilPemeriksaanRads[$i] =  MCHasilpemeriksaanradT::model()->findByPk($detail['hasilpemeriksaanrad_id']);
            $modHasilPemeriksaanRads[$i]->hasil_radiologi = $detail['hasil_radiologi'];
            $modHasilPemeriksaanRads[$i]->kesan_hasilrad = $detail['kesan_hasilrad'];
            if ($modHasilPemeriksaanRads[$i]->save()) {
              $this->updateHasilPemeriksaanRad = true;
            }
          }
        }

        if ($this->updateHasilPemeriksaanRad) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_RAD
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modPeriksaRad' => $modPeriksaRad,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
      'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad,
      'modPermintaanPenunjang' => $modPermintaanPenunjang
    ));
  }

  protected function savePasienKirimKeUnitLain($modPendaftaran)
  {
    $format = new MyFormatter();
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_RAD;
    $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_RAD;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);

    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;
      $updateStatusPeriksa = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
      if (!empty($konsulPoli)) {
        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      }
      /* ================================================ */
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputpemeriksaanrad'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = $value['daftartindakan_id'];
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->pemeriksaanrad_id = $value['pemeriksaanrad_id'];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PR');
      $modPermintaan->qtypermintaan = 1;
      $modPermintaan->tarif_pelayananan = $value['tarifpaketpel'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if ($modPermintaan->validate()) {
        $modPermintaan->save();
        $this->statusSavePermintaanPenunjang = true;
      }
    }
  }

  /**
   * set MCPermintaanmcuT yang sudah ada di database
   * @params pendaftaran_id
   */
  public function actionSetPermintaanKeMcu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $modHasilPemeriksaanRads = array();
      $rows = "";
      $readonly = false;
      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      if (!empty($pasienkirimkeunitlain_id)) {
        $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
      } else {
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT();
      }
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $_POST['pendaftaran_id']);
      $criteria->addInCondition('ruangantujuan_id', array(Params::RUANGAN_ID_RAD));
      $modPermintaans = MCPermintaanmcuT::model()->findAll($criteria);
      $modTindakanPelayanan = MCTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id'], 'create_ruangan' => Params::RUANGAN_ID_KLINIK_MCU));
      $modHasilPemeriksaanRad = new MCHasilpemeriksaanradT;
      $modPasienDirujukKeluar = MCPasiendirujukkeluarT::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
      if (!empty($modPasienDirujukKeluar)) {
        $readonly = true;
      }
      if (count((array)$modTindakanPelayanan) > 0) {
        foreach ($modTindakanPelayanan as $i => $pemeriksaan) {
          if ($pemeriksaan->ruangan_id == Params::RUANGAN_ID_RAD) {
            $modDaftarTindakan = DaftartindakanM::model()->findByAttributes(array('daftartindakan_id' => $pemeriksaan->daftartindakan_id));
            $modPemeriksaanRad = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $pemeriksaan->daftartindakan_id));
            $criteria = new CDbCriteria();
            $criteria->join = "
										JOIN pemeriksaanrad_m ON pemeriksaanrad_m.pemeriksaanrad_id = t.pemeriksaanrad_id";
            $criteria->addCondition('t.tindakanpelayanan_id = ' . $pemeriksaan->tindakanpelayanan_id);
            $modHasilPemeriksaanRads = MCHasilpemeriksaanradT::model()->find($criteria);
            if (isset($modPemeriksaanRad)) {
              $modJenisPemeriksaan = JenispemeriksaanradM::model()->findByPk($modPemeriksaanRad->jenispemeriksaanrad_id);
            }
            if (!empty($modHasilPemeriksaanRads)) {
              $modHasilPemeriksaanRad->jenispemeriksaanrad_nama = $modJenisPemeriksaan->jenispemeriksaanrad_nama;
              $modHasilPemeriksaanRad->pemeriksaanrad_nama = $modHasilPemeriksaanRads->pemeriksaanrad->pemeriksaanrad_nama;
              $modHasilPemeriksaanRad->kesimpulan_hasilrad = $modHasilPemeriksaanRads->kesimpulan_hasilrad;
              $modHasilPemeriksaanRad->kesan_hasilrad = $modHasilPemeriksaanRads->kesan_hasilrad;
              $modHasilPemeriksaanRad->hasilexpertise = $modHasilPemeriksaanRads->hasilexpertise;
              $modHasilPemeriksaanRad->tindakanpelayanan_id = $modHasilPemeriksaanRads->tindakanpelayanan_id;
              $modHasilPemeriksaanRad->pendaftaran_id = $modHasilPemeriksaanRads->pendaftaran_id;
              $modHasilPemeriksaanRad->pemeriksaanrad_id = $modHasilPemeriksaanRads->pemeriksaanrad_id;
              $modHasilPemeriksaanRad->hasilpemeriksaanrad_id = $modHasilPemeriksaanRads->hasilpemeriksaanrad_id;
              $modHasilPemeriksaanRad->hasil_radiologi = isset($modHasilPemeriksaanRads->hasil_radiologi) ? $modHasilPemeriksaanRads->hasil_radiologi : "";
              $rows .= $this->renderPartial($this->path_view . "_rowRadiologi", array('i' => 0, 'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modTindakanPelayanan' => $modTindakanPelayanan, 'readonly' => $readonly), true);
            }
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  public function actionPrintHasil($pendaftaran_id, $caraPrint = '', $i = 0, $pemeriksaanrad_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $modTindakanPelayanan = MCTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Params::RUANGAN_ID_KLINIK_MCU, 'ruangan_id' => Params::RUANGAN_ID_RAD));
    $modPasienMasukPenunjang = MCPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modTindakanPelayanan->pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $pemeriksaanrad_id));
    $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $perujuk = isset($unitLain->pegawai_id) ? PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id)) : '-';
    $rumahSakit = ProfilrumahsakitM::model()->findByAttributes(array('profilrs_id' => 1));

    $this->render('radiologi.views.lihatHasil.hasilPrint', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'unitLain' => $unitLain,
      'perujuk' => $perujuk,
      'caraPrint' => $caraPrint,
      'rumahSakit' => $rumahSakit,
      'i' => $i,
    ));
  }

  public function actionPrintRiwayat()
  {
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judulLaporan = 'Permintaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_rad . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_rad . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');          //Posisi 
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view_rad . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
