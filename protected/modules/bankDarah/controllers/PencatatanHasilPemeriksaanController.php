<?php

/**
 * ada kondisi :
 * 1. untuk pemeriksaan klinik (BDHasilPemeriksaanLabT & BDDetailHasilPemeriksaanLabT)
 * 2. untuk pemeriksaan anatomi (BDHasilPemeriksaanPAT)
 */
Yii::import('bankDarah.controllers.PemeriksaanPasienBankDarahController');
class PencatatanHasilPemeriksaanController extends PemeriksaanPasienBankDarahController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "bankDarah.views.pemeriksaanPasienBankDarah.";
  public $path_view_pendaftaran = "bankDarah.views.pendaftaranBankDarah.";

  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   */
  public function actionIndex($pasienmasukpenunjang_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new BDPasienMasukPenunjangV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanLab = new BDTarifpemeriksaanlabruanganV;
    $modHasilPemeriksaan = new BDHasilPemeriksaanLabT;
    $modTindakan = new BDTindakanPelayananT;
    $modPasienMorbiditas = new BDPasienmorbiditasT();
    $dataHasilPemeriksaanPAs = array();
    $dataDetails = array();
    $modAnamnesa = new BDAnamnesaT;
    $modPemeriksaan = new BDPemeriksaanfisikT;
    $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : $pasienmasukpenunjang_id);
    if (!empty($pasienmasukpenunjang_id)) {
      $loadModKunjungan = $this->loadModPasienMasukPenunjang($pasienmasukpenunjang_id);
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $loadHasilPemeriksaan = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadModKunjungan->pasienmasukpenunjang_id));
          if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
            Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
          } else {
            $modHasilPemeriksaan = $loadHasilPemeriksaan;
          }
        } else if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
        }
      }
    }


    if (isset($_POST['pasienmasukpenunjang_id']) && (isset($_POST['BDHasilPemeriksaanLabT']) || isset($_POST['BDHasilPemeriksaanPAT']))) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
          $modHasilPemeriksaan->attributes = $_POST['BDHasilPemeriksaanLabT'];
          $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
          $modHasilPemeriksaan->tglhasilpemeriksaanlab = $format->formatDateTimeForDb($_POST['BDHasilPemeriksaanLabT']['tglhasilpemeriksaanlab']);
          $modHasilPemeriksaan->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['BDHasilPemeriksaanLabT']['tglpengambilanhasil']);
          $modHasilPemeriksaan->catatanlabklinik = (isset($_POST['BDHasilPemeriksaanLabT']['catatanlabklinik']) ? $_POST['BDHasilPemeriksaanLabT']['catatanlabklinik'] : null);
          $modHasilPemeriksaan->kesimpulan = (isset($_POST['BDHasilPemeriksaanLabT']['kesimpulan']) ? $_POST['BDHasilPemeriksaanLabT']['kesimpulan'] : null);
          $modHasilPemeriksaan->update_time = date('Y-m-d H:i:s');
          $modHasilPemeriksaan->update_loginpemakai_id = Yii::app()->user->id;
          if ($modHasilPemeriksaan->update()) {
            $this->hasilpemeriksaantersimpan = true;
          } else {
            $this->hasilpemeriksaantersimpan = false;
          }
        }
        if (isset($_POST['BDDetailHasilPemeriksaanLabT'])) {
          if (count((array)$_POST['BDDetailHasilPemeriksaanLabT']) > 0) {
            foreach ($_POST['BDDetailHasilPemeriksaanLabT'] as $i => $postDetail) {
              $dataDetails[$i] = $this->ubahDetailHasilPemeriksaanLab($postDetail);
            }
          }
        }
        if (isset($_POST['BDHasilPemeriksaanPAT'])) {
          if (count((array)$_POST['BDHasilPemeriksaanPAT']) > 0) {
            foreach ($_POST['BDHasilPemeriksaanPAT'] as $i => $postDetail) {
              $dataDetails[$i] = $this->ubahHasilPemeriksaanPA($postDetail);
            }
          }
        }
        if ($this->hasilpemeriksaantersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modTindakan' => $modTindakan,
      'dataDetails' => $dataDetails,
      'modAnamnesa' => $modAnamnesa,
      'modPemeriksaan' => $modPemeriksaan,
      'modPasienMorbiditas' => $modPasienMorbiditas,
    ));
  }
  /**
   * set form hasil pemeriksaan
   */
  public function actionPrint($pasienmasukpenunjang_id, $frame = null, $caraPrint = null)
  {
    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
    $modKunjungan = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
    //        $this->render('printHasilPemeriksaan',array(
    //            'format'=>$format,
    //            'modKunjungan'=>$modKunjungan,
    //            'modHasilPemeriksaan'=>$modHasilPemeriksaan,
    //            'modDetailHasilPemeriksaans'=>$modDetailHasilPemeriksaans,
    //            'judulLaporan'=>$judulLaporan,
    //            'caraPrint'=>$caraPrint,
    //        ));
    $this->render('printHasilPemeriksaan', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
    ));
  }
  /**
   * set form hasil pemeriksaan Patologi Anatomi
   */
  public function actionPrintPA($pasienmasukpenunjang_id, $frame = null, $caraPrint = null)
  {
    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Patologi Anatomi";
    $modKunjungan = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modKunjungan);
    $this->render('printHasilPemeriksaanPA', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaanPAs' => $modHasilPemeriksaanPAs,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
    ));
  }

  /**
   * load BDDetailHasilPemeriksaanLabT
   * @param type $modHasilPemeriksaan
   */
  public function loadDetailHasilPemeriksaans($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                        JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = BDDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    return $modDetailHasilPemeriksaans;
  }
  /**
   * load BDHasilPemeriksaanPAT
   */
  public function loadHasilPemeriksaanPAs($modPasienMasukPenunjang)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id";
    $criteria->addCondition('t.pasienmasukpenunjang_id = ' . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC";
    $modHasilPemeriksaanPAs = BDHasilPemeriksaanPAT::model()->findAll($criteria);
    return $modHasilPemeriksaanPAs;
  }
  /**
   * simpan BDDetailHasilPemeriksaanLabT
   */
  public function ubahDetailHasilPemeriksaanLab($post)
  {
    $modDetailHasilPemeriksaans = BDDetailHasilPemeriksaanLabT::model()->findByPk($post['detailhasilpemeriksaanlab_id']);
    $modDetailHasilPemeriksaans->hasilpemeriksaan = $post['hasilpemeriksaan'];
    $modDetailHasilPemeriksaans->hasil_laboratorium = isset($post['hasil_laboratorium']) ? $post['hasil_laboratorium'] : "";
    $modDetailHasilPemeriksaans->update_time = date("Y-m-d H:i:s");
    $modDetailHasilPemeriksaans->update_loginpemakai_id = Yii::app()->user->id;
    $modDetailHasilPemeriksaans->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modDetailHasilPemeriksaans->validate()) {
      $modDetailHasilPemeriksaans->update();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modDetailHasilPemeriksaans;
  }
  /**
   * simpan BDHasilPemeriksaanPAT
   */
  public function ubahHasilPemeriksaanPA($post)
  {
    $modHasilPemeriksaanPA = BDHasilPemeriksaanPAT::model()->findByPk($post['hasilpemeriksaanpa_id']);
    $modHasilPemeriksaanPA->makroskopis = $post['makroskopis'];
    $modHasilPemeriksaanPA->mikroskopis = $post['mikroskopis'];
    $modHasilPemeriksaanPA->kesimpulanpa = $post['kesimpulanpa'];
    $modHasilPemeriksaanPA->saranpa = $post['saranpa'];
    $modHasilPemeriksaanPA->catatanpa = $post['catatanpa'];
    $modHasilPemeriksaanPA->update_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->update_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->update();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaanPA;
  }

  /**
   * set form hasil pemeriksaan
   */
  public function actionSetFormHasilPemeriksaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rows = "";
      //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
      $modHasilPemeriksaan = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      $hasilPemeriksaan = array();
      $attributes = $modHasilPemeriksaan->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $hasilPemeriksaan["$attribute"] = $modHasilPemeriksaan->$attribute;
      }
      $hasilPemeriksaan['tglhasilpemeriksaanlab'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab));
      $hasilPemeriksaan['tglpengambilanhasil'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglpengambilanhasil));

      $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
      $rows = $this->renderPartial("_rowsHasilPemeriksaan", array('modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans), true);
      echo CJSON::encode(array(
        'hasilPemeriksaan' => $hasilPemeriksaan,
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * set form hasil pemeriksaan patologi anatomi
   */
  public function actionSetFormHasilPemeriksaanPA()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
      $dataHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modPasienMasukPenunjang);
      $rows = $this->renderPartial("_rowsHasilPemeriksaanPA", array('format' => $format, 'dataHasilPemeriksaanPAs' => $dataHasilPemeriksaanPAs), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatAnamnesa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $anamnesa = BDAnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($anamnesa)) {
        $modAnamnesa = $anamnesa;
      } else {
        $modAnamnesa = new BDAnamnesaT();
        $modAnamnesa->pendaftaran_id = $pendaftaran_id;
      }
      $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;
      $rows .= $this->renderPartial("bankDarah.views.pencatatanHasilPemeriksaan._riwayatAnamnesa", array('i' => 0, 'modAnamnesa' => $modAnamnesa), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatPemeriksaanFisik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $periksafisik = BDPemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($periksafisik)) {
        $modPemeriksaan = $periksafisik;
      } else {
        $modPemeriksaan = new BDPemeriksaanfisikT;
        $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
      }
      $rows .= $this->renderPartial("bankDarah.views.pencatatanHasilPemeriksaan._riwayatPemeriksaanFisik", array('i' => 0, 'modPemeriksaan' => $modPemeriksaan), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $modPasienMorbiditas = new BDPasienmorbiditasT();
      $rows .= $this->renderPartial("bankDarah.views.pencatatanHasilPemeriksaan._riwayatDiagnosa", array('i' => 0, 'modPasienMorbiditas' => $modPasienMorbiditas, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
}
