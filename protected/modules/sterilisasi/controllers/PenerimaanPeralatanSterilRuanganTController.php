<?php

class PenerimaanPeralatanSterilRuanganTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.penerimaanPeralatanSterilRuanganT.';
  public $penerimaanSteril = false;
  public $pengirimanSterilUpdate = false;
  public $penerimaanSterilDet = true;

  public function actionIndex($kirimperlinensteril_id = null)
  {
    $format = new MyFormatter;
    $model = new STTerimaperlinensterilT;
    $model->terimaperlinensteril_no = MyGenerator::noPenerimaanSterilRuangan();

    // data untuk pencarian
    $modCari = new STKirimperlinensterilT;
    $modCari->tgl_awal = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_awal));
    $modCari->tgl_akhir = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_akhir));
    $modCariDetail = new STKirimperlinensterildetT;
    $modPengDetails = array();
    if (isset($_POST['STKirimperlinensterilT'])) {
      $tgl_awal = $format->formatDateTimeForDb($_POST['STKirimperlinensterilT']['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_POST['STKirimperlinensterilT']['tgl_akhir']);
      $pengirimansterlilisasi_no = $_POST['STKirimperlinensterilT']['kirimperlinensteril_no'];
      $modCari->kirimperlinensteril_no = $pengirimansterlilisasi_no;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $criteria = new CDbCriteria();
      $criteria->join = 'left join pesanperlinensteril_t p on p.pesanperlinensteril_id = t.pesanperlinensteril_id '
        . 'left join kirimperlinensteril_t a on a.kirimperlinensteril_id = t.kirimperlinensteril_id';
      $criteria->addBetweenCondition('DATE(t.kirimperlinensteril_tgl)', $tgl_awal, $tgl_akhir);
      if (!empty($ruangan_id)) {
        $criteria->addCondition('a.ruangan_id = ' . $ruangan_id);
      }
      $criteria->compare('LOWER(t.kirimperlinensteril_no)', strtolower($pengirimansterlilisasi_no), true);

      // var_dump($criteria); die;

      $modPengiriman = STKirimperlinensterilT::model()->findAll($criteria);
      foreach ($modPengiriman as $i => $modPengirimanDetail) {
        $modPengDetails = STKirimperlinensterildetT::model()->findAllByAttributes(array('kirimperlinensteril_id' => $modPengirimanDetail->kirimperlinensteril_id));
      }

      // var_dump(count((array)$modPengDetails)); die;
    }

    if (!empty($kirimperlinensteril_id)) {

      if (!isset($_GET['sukses']) && !Yii::app()->request->isPostRequest) {
        $this->setReferrer();
      }
      $modCari = STKirimperlinensterilT::model()->findByPk($kirimperlinensteril_id);
      $modPengDetails = STKirimperlinensterildetT::model()->findAllByAttributes(array('kirimperlinensteril_id' => $kirimperlinensteril_id));
    } else {
      $this->cleanReferrer();
    }

    // data untuk proses simpan
    $modDetails = array();
    $modDetail = new STTerimaperlinensterildetT;
    if (isset($_POST['STKirimperlinensterildetT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STTerimaperlinensterilT'];
        $model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->kirimperlinensteril_id = $_POST['STKirimperlinensterildetT'][0]['kirimperlinensteril_id'];
        $model->terimaperlinensteril_tgl = $format->formatDateTimeForDb($_POST['STTerimaperlinensterilT']['terimaperlinensteril_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->penerimaanSteril = true;
          // update ke tabel kirimperlinensteril_t untuk field isterimaperlinensteril menjadi true
          $modUpdatePengiriman = STKirimperlinensterilT::model()->updateByPk($model->kirimperlinensteril_id, array('isterimaperlinensteril' => true));
          if ($modUpdatePengiriman) {
            $this->pengirimanSterilUpdate = true;
            if (count((array)$_POST['STKirimperlinensterildetT']) > 0) {
              foreach ($_POST['STKirimperlinensterildetT'] as $i => $postPengirimanSteril) {
                if ($_POST['STKirimperlinensterildetT'][$i]['checklist']) {
                  $modDetail = new STTerimaperlinensterildetT;
                  $modDetail->attributes = $postPengirimanSteril;
                  $modDetail->terimaperlinensteril_id = $model->terimaperlinensteril_id;
                  $modDetail->linen_id = $postPengirimanSteril['linen_id'];
                  $modDetail->barang_id = $postPengirimanSteril['barang_id'];
                  //												$modDetail->terimaperlinensterildet_jml = $postPengirimanSteril['terimaperlinensterildet_jml'];
                  $modDetail->terimaperlinensterildet_jml = $postPengirimanSteril['kirimperlinensterildet_jml'];
                  $modDetail->terimaperlinensterildet_ket = $postPengirimanSteril['kirimperlinensterildet_ket'];
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
          $transaction->commit();
          $this->redirect(array('index', 'terimaperlinensteril_id' => $model->terimaperlinensteril_id, 'sukses' => 1));
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
   * untuk print data pengajuan perawatan
   */
  public function actionPrint($terimaperlinensteril_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaan = STTerimaperlinensterilT::model()->findByPk($terimaperlinensteril_id);
    $modPenerimaanDetail = STTerimaperlinensterildetT::model()->findAllByAttributes(array('terimaperlinensteril_id' => $terimaperlinensteril_id));

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
}
