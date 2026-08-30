<?php

class PenerimaanLinenRuanganTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.penerimaanLinenRuanganT.';
  public $penerimaanLinenRuangan = false;
  public $penerimaanLinenRuanganDet = true;

  public function actionIndex($id = null)
  {
    $format = new MyFormatter;
    //load header
    $modPengiriman = LAPengirimanlinenT::model()->findByPk($id);
    $model = new LAPenlinenruanganT;
    $model->nopenlinenruangan = MyGenerator::noPenerimaanLinenR();
    $model->ruanganasal_id = $modPengiriman->ruangantujuan_id;
    $model->ruanganasal_nama = RuanganM::model()->findByPk($modPengiriman->ruangantujuan_id)->ruangan_nama;
    $model->keterangan_penlinenruangan = $modPengiriman->keterangan_pengiriman;
    $model->pengirimanlinen_id = $modPengiriman->pengirimanlinen_id;
    // load detail
    $modPengirimanDetail = LAPengirimanlinendetailT::model()->findAllByAttributes(array('pengirimanlinen_id' => $modPengiriman->pengirimanlinen_id));

    $modDetails = array();
    $modDetail = new LAPenlinenruangandetailT;
    if (isset($_POST['LAPenlinenruanganT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LAPenlinenruanganT'];
        $model->tglpenlinenruangan = $format->formatDateTimeForDb($_POST['LAPenlinenruanganT']['tglpenlinenruangan']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->penerimaanLinenRuangan = true;
          if (count((array)$_POST['LAPengirimanlinendetailT']) > 0) {
            foreach ($_POST['LAPengirimanlinendetailT'] as $i => $postPenerimaanLinenRuanganDet) {
              $modDetails[$i] = $this->simpanPenerimaanLinenRuanganDet($model, $postPenerimaanLinenRuanganDet);
            }
          }

          if (isset($model->pengirimanlinen_id)) {
            PengirimanlinenT::model()->updateByPk($model->pengirimanlinen_id, array('issudahditerima' => true)); //RSPMC-961
          }

          $this->notifTerimaLinen($model);

          if ($this->penerimaanLinenRuangan && $this->penerimaanLinenRuanganDet) {
            $transaction->commit();
            Yii::app()->user->setFlash("success", "Data Penerimaan linen Ruangan berhasil disimpan!");
            $this->redirect(array('index', 'id' => $id, 'penlinenruangan_id' => $model->penlinenruangan_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Penerimaan Linen Ruangan gagal disimpan !");
          }
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penerimaan Linen Ruangan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format, 'modPengirimanDetail' => $modPengirimanDetail
    ));
  }

  protected function notifTerimaLinen($model)
  {

    $ruangan_laundry = RuanganM::model()->findByPk(Params::RUANGAN_ID_LAUNDRY);
    $ruangan_terima = RuanganM::model()->findByPk($model->ruanganasal_id);

    //var_dump($model->attributes, $ruangan_laundry->attributes, $ruangan_terima->attributes);
    //die;

    $judul = "Penerimaan Linen";
    $isi_asal = "Tgl. Penerimaan : " . MyFormatter::formatDateTimeForuser($model->tglpenlinenruangan) . '<br/>';
    $isi_asal .= "No. Penerimaan : " . $model->nopenlinenruangan . '<br/>';
    $isi_asal .= "Ruangan {posisi} : {ruangan}<br/>";
    $isi_asal .= "Keterangan : " . $model->keterangan_penlinenruangan . '<br/>';

    $isi_tujuan = $isi_asal;

    $isi_tujuan = str_replace("{ruangan}", $ruangan_terima->ruangan_nama, $isi_tujuan);
    $isi_tujuan = str_replace("{posisi}", 'Penerima', $isi_tujuan);
    $isi_asal = str_replace("{ruangan}", $ruangan_laundry->ruangan_nama, $isi_asal);
    $isi_asal = str_replace("{posisi}", 'Pengirim', $isi_asal);


    $ok = CustomFunction::broadcastNotif($judul, $isi_asal, array(
      array('instalasi_id' => $ruangan_terima->instalasi_id, 'ruangan_id' => $ruangan_terima->ruangan_id, 'modul_id' => $ruangan_terima->modul_id),
    ));
    $ok = CustomFunction::broadcastNotif($judul, $isi_tujuan, array(
      array('instalasi_id' => $ruangan_laundry->instalasi_id, 'ruangan_id' => $ruangan_laundry->ruangan_id, 'modul_id' => $ruangan_laundry->modul_id),
    ));
  }


  /**
   * simpan LAPenlinenruangandetailT
   * @param type $model
   * @param type $post
   * @return LAPenlinenruangandetailT
   */
  public function simpanPenerimaanLinenRuanganDet($model, $post)
  {
    $format = new MyFormatter();
    $modDetail = new LAPenlinenruangandetailT;
    $modDetail->attributes = $post;
    $modDetail->penlinenruangan_id = $model->penlinenruangan_id;
    $modDetail->keterangan = $post['keterangan_linen'];
    if ($modDetail->save()) {
      $this->penerimaanLinenRuanganDet &= true;
    } else {
      $this->penerimaanLinenRuanganDet &= false;
    }
    return $modDetail;
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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
   * untuk print data penerimaan linen ruangan
   */
  public function actionPrint($penlinenruangan_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaanLinenRuangan = LAPenlinenruanganT::model()->findByPk($penlinenruangan_id);
    $modPenerimaanLinenRuanganDetail = LAPenlinenruangandetailT::model()->findAllByAttributes(array('penlinenruangan_id' => $penlinenruangan_id));

    $judul_print = 'Pengajuan Perawatan Linen';
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
      'modPenerimaanLinenRuangan' => $modPenerimaanLinenRuangan,
      'modPenerimaanLinenRuanganDetail' => $modPenerimaanLinenRuanganDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
