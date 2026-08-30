<?php

/**
 * untuk transaksi penerimaan sterilisasi
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.modules.sterilisasi
 * @subpackage controllers
 */
class PenerimaanPeralatanSterilTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.penerimaanPeralatanSteril.';
  public $penerimaanSteril = false;
  public $pengajuanSterilUpdate = false;
  public $penerimaanSterilDet = true;

  /**
   * digunakan untuk insert data 
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Pengajuan Steriliasi";
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $format = new MyFormatter;
    $model = new STPenerimaansterilisasiT;
    //$model->penerimaansterilisasi_no = MyGenerator::noPenerimaanSteril();
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->penerimaansterilisasi_no = "-- Otomatis --";
    $model->pegmenerima_id = $modLogin->pegawai_id;
    if (!empty($model->pegmenerima_id))
      $model->pegawaipenerima_nama = $modLogin->pegawai->nama_pegawai;
    // data untuk pencarian
    $modCari = new STPengajuansterlilisasiT;
    //$modCari->tgl_awal = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_awal));
    //$modCari->tgl_akhir = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_akhir));
    $modCari->tgl_awal = date("d M Y");
    $modCari->tgl_akhir = date("d M Y");

    /* if(isset ($_REQUEST['STPengajuansterlilisasiT'])){
          $modCari->attributes=$_REQUEST['STPengajuansterlilisasiT'];
          $modCari->tgl_awal = $format->formatDateTimeForDb($_REQUEST['STPengajuansterlilisasiT']['tgl_awal']);
          $modCari->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['STPengajuansterlilisasiT']['tgl_akhir']);
          } */

    $modCariDetail = new STPengajuansterlilisasidetT;
    $modPengDetails = array();

    // data dari pengajuan sterilisasi
    if (!empty($_GET['pengajuansterlilisasi_id'])) {
      $modCari = STPengajuansterlilisasiT::model()->findByPk($_GET['pengajuansterlilisasi_id']);
      $modCari->instalasi_id = $modCari->ruangan->instalasi_id;
      $modCari->tgl_awal = date("d M Y");
      $modCari->tgl_akhir = date("d M Y");
      $modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $_GET['pengajuansterlilisasi_id']));


      foreach ($modPengDetails as $i => $val) {
        $modPengDetails[$i]->keadaan = $modCari->keadaanperalatan;
      }
    }
    if (isset($_POST['STPengajuansterlilisasiT'])) {
      $tgl_awal = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_akhir']);
      $pengajuansterlilisasi_no = $_POST['STPengajuansterlilisasiT']['pengajuansterlilisasi_no'];
      $ruangan_id = $_POST['STPengajuansterlilisasiT']['ruangan_id'];
      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('DATE(pengajuansterlilisasi_tgl)', $tgl_awal, $tgl_akhir);
      if (!empty($ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      }
      $criteria->compare('LOWER(pengajuansterlilisasi_no)', strtolower($pengajuansterlilisasi_no), true);
      $modPengajuan = STPengajuansterlilisasiT::model()->findAll($criteria);
      foreach ($modPengajuan as $i => $modPengajuanDetail) {
        $modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $modPengajuanDetail->pengajuansterlilisasi_id));
      }
    }

    // data untuk proses simpan
    $modDetails = array();
    $modDetail = new STPenerimaansterilisasidetT;
    if (isset($_POST['STPengajuansterlilisasidetT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STPenerimaansterilisasiT'];
        //				$model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
        $model->pegmenerima_id = $modLogin->pegawai_id;
        $model->pegawaipenerima_nama = $modLogin->pegawai->nama_pegawai;
        $model->penerimaansterilisasi_no = MyGenerator::noPenerimaanSteril();
        $model->ruangan_id = $_POST['STPengajuansterlilisasidetT'][0]['ruangan_id'];
        $model->pengajuansterlilisasi_id = $_POST['STPengajuansterlilisasidetT'][0]['pengajuansterlilisasi_id'];
        $model->penerimaansterilisasi_tgl = $format->formatDateTimeForDb($_POST['STPenerimaansterilisasiT']['penerimaansterilisasi_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->penerimaanSteril = true;
          // update ke tabel pengajuansterlilisasi_t untuk field issudahditerima menjadi true
          $modUpdatePengajuan = STPengajuansterlilisasiT::model()->updateByPk($model->pengajuansterlilisasi_id, array('issudahditerima' => true));
          if ($modUpdatePengajuan) {
            $this->pengajuanSterilUpdate = true;
            if (count((array)$_POST['STPengajuansterlilisasidetT']) > 0) {
              foreach ($_POST['STPengajuansterlilisasidetT'] as $i => $postPengajuanSteril) {
                if ($_POST['STPengajuansterlilisasidetT'][$i]['checklist']) {
                  $modDetail = new STPenerimaansterilisasidetT;
                  $modDetail->attributes = $postPengajuanSteril;
                  $modDetail->penerimaansterilisasi_id = $model->penerimaansterilisasi_id;
                  $modDetail->peralatansterilisasi_id = $postPengajuanSteril['peralatansterilisasi_id'];
                  if (!empty($postPengajuanSteril['peralatansterilisasi_id'])) {
                    $mapBarang = MapbarangsterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $postPengajuanSteril['peralatansterilisasi_id']));
                    if (!empty($mapBarang)) {
                      $modDetail->barang_id = $mapBarang->barang_id;
                    }
                    $mapLinen = MaplinensterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $postPengajuanSteril['peralatansterilisasi_id']));
                    if (!empty($mapLinen)) {
                      $modDetail->barang_id = $mapLinen->linen_id;
                    }
                    $mapAlkes = MapalkessterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $postPengajuanSteril['peralatansterilisasi_id']));
                    if (!empty($mapAlkes)) {
                      $modDetail->barang_id = $mapAlkes->obatalkes_id;
                    }
                  }
                  $modDetail->penerimaansterilisasidet_jml = $postPengajuanSteril['pengajuansterlilisasidet_jml'];
                  $modDetail->penerimaansterilisasidet_ket = $postPengajuanSteril['pengajuansterlilisasidet_ket'];
                  $modDetail->keadaanperalatan = $postPengajuanSteril['keadaan'];
                  if ($modDetail->save()) {
                    $this->penerimaanSterilDet &= true;
                  } else {
                    $this->penerimaanSterilDet &= false;
                  }
                }
              }
            }
          }
        }

        if ($this->penerimaanSteril && $this->penerimaanSterilDet) {
          Yii::app()->user->setFlash('success', "Data  " . $model->penerimaansterilisasi_no . " berhasil disimpan !");
          $transaction->commit();
          $this->redirect(array('index', 'penerimaansterilisasi_id' => $model->penerimaansterilisasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penerimaan Peralatan Steril gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penerimaan Peralatan Steril gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format, 'modCari' => $modCari, 'modPengDetails' => $modPengDetails
    ));
  }

  /**
   * digunakan untuk informasi penerimaan sterilisasi
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Sterilisasi";
    $format = new MyFormatter;
    $model = new STPenerimaansterilisasiT;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STPenerimaansterilisasiT'])) {
      $model->attributes = $_GET['STPenerimaansterilisasiT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STPenerimaansterilisasiT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STPenerimaansterilisasiT']['tgl_akhir']);
      $model->ruangan_id = $_GET['STPenerimaansterilisasiT']['ruangan_id'];
    }

    $this->render($this->path_view . 'informasi', array(
      'format' => $format,
      'model' => $model
    ));
  }

  /**
   * digunakan untuk detail penerimaan
   * @param integer $id
   */
  public function actionDetailDekontaminasi($id)
  {
    $this->layout = '//layouts/iframe';
    $dekontaminasiDetail = DekontaminasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id' => $id));
    $dekontaminasi = DekontaminasiT::model()->findByPk($dekontaminasiDetail->dekontaminasi_id);
    $pegawaiPetugas = PegawaiM::model()->findByPk($dekontaminasi->pegpetugas_id);
    if ($pegawaiPetugas != NULL) {
      $dekontaminasi->pegpetugas_nama = $pegawaiPetugas->nama_pegawai;
    } else {
      $dekontaminasi->pegpetugas_nama = '-';
    }
    $dekontaminasi->dekontaminasi_tgl = MyFormatter::formatDateTimeforUser($dekontaminasi->dekontaminasi_tgl);
    $penerimaan = PenerimaansterilisasiV::model()->findByAttributes(array('penerimaansterilisasi_id' => $id));

    $this->render($this->path_view . '_detailDekontaminasi', array(
      'modDekontaminasi' => $dekontaminasi,
      'modDekontaminasiDetail' => $dekontaminasiDetail,
      'penerimaan' => $penerimaan,
    ));
  }

  /**
   * digunakan untuk detail sterilisasi
   * @param integer $id
   */
  public function actionDetailSterilisasi($id)
  {
    $this->layout = '//layouts/iframe';
    $sterilisasiDetail = SterilisasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id' => $id));
    $sterilisasi = SterilisasiT::model()->findByPk($sterilisasiDetail->sterilisasi_id);
    $pegawaiPetugas = PegawaiM::model()->findByPk($sterilisasi->pegsterilisasi_id);
    if ($pegawaiPetugas != NULL) {
      $sterilisasi->pegsterilisasi_nama = $pegawaiPetugas->nama_pegawai;
    } else {
      $sterilisasi->pegsterilisasi_nama = '-';
    }
    $sterilisasi->sterilisasi_tgl = MyFormatter::formatDateTimeforUser($sterilisasi->sterilisasi_tgl);
    $sterilisasiDetail->waktukadaluarsa = MyFormatter::formatDateTimeforUser($sterilisasiDetail->waktukadaluarsa);
    $penerimaan = PenerimaansterilisasiV::model()->findByAttributes(array('penerimaansterilisasi_id' => $id));

    $this->render($this->path_view . '_detailSterilisasi', array(
      'modSterilisasi' => $sterilisasi,
      'modSterilisasiDetail' => $sterilisasiDetail,
      'penerimaan' => $penerimaan,
    ));
  }

  /**
   * digunakan untuk autocompalte
   */
  public function actionAutocompletePegawaiPenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk autocomplete
   */
  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id" => $instalasi_id), "ruangan_aktif = true"), 'ruangan_id', 'ruangan_nama');
      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * untuk print data pengajuan perawatan
   * @param integer $penerimaansterilisasi_id
   * @param boolean $caraPrint
   */
  public function actionPrint($penerimaansterilisasi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaan = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);
    $modPenerimaanDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $penerimaansterilisasi_id));

    $judul_print = 'Penerimaan Peralatan Steril';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenerimaan' => $modPenerimaan,
      'modPenerimaanDetail' => $modPenerimaanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * digunakan untuk detail
   * @param integer $penerimaansterilisasi_id
   */
  public function actionDetail($penerimaansterilisasi_id)
  {
    $format = new MyFormatter;
    $modPenerimaan = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);
    $modPenerimaanDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $penerimaansterilisasi_id));

    $judul_print = 'Penerimaan Peralatan Steril';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenerimaan' => $modPenerimaan,
      'modPenerimaanDetail' => $modPenerimaanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionDetailKehilangan($penerimaansterilisasi_id)
  {
    $format = new MyFormatter;
    $modPenerimaan = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);
    $modPenerimaanDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $penerimaansterilisasi_id));

    $judul_print = 'Penerimaan Peralatan Steril';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $this->render($this->path_view . 'PrintKehilangan', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenerimaan' => $modPenerimaan,
      'modPenerimaanDetail' => $modPenerimaanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * digunakan untuk batal sterilisasi
   * @param integer $id
   */
  public function actionBatalPenerimaan($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = STPenerimaansterilisasidetT::model()->deleteAllByAttributes(array('penerimaansterilisasi_id' => $id));
      $deletePenerimaan = STPenerimaansterilisasiT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePenerimaan) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  /**
   * digunakan untuk search 
   */
  public function actionPencarianPenerimaanView()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modCari = new STPengajuansterlilisasiT;
      $modPengDetails = array();
      $form = "";
      $format = new MyFormatter;
      //var_dump($_POST['data']);die();
      if (!empty($_POST['pengajuansterlilisasi_id'])) {
        $modCari = STPengajuansterlilisasiT::model()->findByPk($_GET['pengajuansterlilisasi_id']);
        $modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $_GET['pengajuansterlilisasi_id']));
      }
      if (isset($_POST['STPengajuansterlilisasiT'])) {
        $tgl_awal = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_akhir']);
        $pengajuansterlilisasi_no = $_POST['STPengajuansterlilisasiT']['pengajuansterlilisasi_no'];
        $ruangan_id = $_POST['STPengajuansterlilisasiT']['ruangan_id'];
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(pengajuansterlilisasi_tgl)', $tgl_awal, $tgl_akhir);
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        $criteria->compare('LOWER(pengajuansterlilisasi_no)', strtolower($pengajuansterlilisasi_no), true);
        $modPengajuan = STPengajuansterlilisasiT::model()->findAll($criteria);
        foreach ($modPengajuan as $i => $modPengajuanDetail) {
          $modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $modPengajuanDetail->pengajuansterlilisasi_id));
        }
      }
      $form .= $this->renderPartial($this->path_view . '_tabelPengajuan', array('modPengDetails' => $modPengDetails), true);
      echo CJSON::encode(array('form' => $form, 'pesan' => ''));
      Yii::app()->end();
    }
  }
}
