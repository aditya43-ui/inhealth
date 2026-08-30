<?php

class BarangPecahBelahController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = "gizi.views.barangPecahBelah.";

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($barangpecahbelah_id = null)
  {
    
    if (!empty($barangpecahbelah_id)) {

      $model = BarangpecahbelahT::model()->findByPk($barangpecahbelah_id);
      $model->barangpecahbelah_tgl = MyFormatter::formatDateTimeForUser($model->barangpecahbelah_tgl);
      $model->instalasi_id = $model->ruangan->instalasi_id;
      $model->pegawaimengetahui_nama = empty($model->pegmengetahui) ? "" : $model->pegmengetahui->nama_pegawai;
      $model->pegawaimenerima_nama = empty($model->pegmenerima) ? "" : $model->pegmenerima->nama_pegawai;
    } else {

      $model = new BarangpecahbelahT;
      $model->barangpecahbelah_no = "-- Otomatis --";
      $model->barangpecahbelah_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
      $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    }
    $this->pageTitle = Yii::app()->name . " - Pencatatan Barang Pecah Belah";
    $modDetail = new BarangpecahbelahdetT;
    $modDetail->jumlah = 1;

    $instalasiTujuans = CHtml::listData(InstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(RuanganM::getRuanganByInstalasi($model->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (isset($_POST['BarangpecahbelahT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $format = new MyFormatter();

        $model->attributes = $_POST['BarangpecahbelahT'];
        $model->barangpecahbelah_tgl = $format->formatDateTimeForDb($_POST['BarangpecahbelahT']['barangpecahbelah_tgl']);
        $model->barangpecahbelah_no = MyGenerator::noBarangPecahBelah();
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
       
        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }
        if (isset($_POST['BarangpecahbelahdetT'])) {
          foreach ($_POST['BarangpecahbelahdetT'] as $item) {
            $det = new BarangpecahbelahdetT;
            $det->attributes = $model->attributes;
            $det->attributes = $item;
            $barang = BarangM::model()->findByPk($det->barang_id);
            if (empty($barang)) {
              throw new CException("Barang tidak dipilih");
            }
            $det->harga_satuan = $barang->barang_harganetto;

            if ($det->validate()) {
              $ok = $ok && $det->save();
            } else {
              $ok = false;
            }

            //                        var_dump($det->attributes, $barang->attributes);
          }
        }

        $this->notifPecahBelah($model);
        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Pencatatan Barang Pecah Belah berhasil disimpan !");
          $this->redirect(array('create', 'barangpecahbelah_id' => $model->barangpecahbelah_id,'sukses'=>1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data Pencatatan Barang Pecah Belah gagal disimpan !");
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Pencatatan Barang Pecah Belah gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }


  public function notifPecahBelah($model)
  {

    $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
    $tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_LAUNDRY);

    $judul = "Barang Pecah Belah";
    $isi = "Tanggal : " . MyFormatter::formatDateTimeForuser($model->barangpecahbelah_tgl) . '<br/>';
    $isi .= "Nomor : " . $model->barangpecahbelah_no . '<br/>';
    $isi .= "Ruangan Kehilangan : " . $ruangan->ruangan_nama . '<br/>';
    $isi .= "Keterangan : " . $model->keterangan . '<br/>';

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
    ));
  }


  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Pencatatan Barang Pecah Belah";
    $model = new BarangpecahbelahT('search');
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BarangpecahbelahT'])) {
      $model->attributes = $_GET['BarangpecahbelahT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BarangpecahbelahT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BarangpecahbelahT']['tgl_akhir']);
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BarangpecahbelahT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'barangpecahbelah-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint($barangpecahbelah_id)
  {
    $model = BarangpecahbelahT::model()->findByPk($barangpecahbelah_id);
    $modDetail = BarangpecahbelahdetT::model()->findAllByAttributes(array(
      'barangpecahbelah_id' => $barangpecahbelah_id
    ));
    $judulLaporan = 'Barang Pecah Belah';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judul_print' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetail' => $modDetail));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judul_print' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetail' => $modDetail));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judul_print' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetail' => $modDetail), true));
      $mpdf->Output();
    }
  }

  /**
   * Mencetak data
   */
  public function actionView($barangpecahbelah_id)
  {
    $model = BarangpecahbelahT::model()->findByPk($barangpecahbelah_id);
    $modDetail = BarangpecahbelahdetT::model()->findAllByAttributes(array(
      'barangpecahbelah_id' => $barangpecahbelah_id
    ));
    $judulLaporan = 'Barang Pecah Belah';

    $this->layout = '//layouts/iframe';
    $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => null, 'modDetail' => $modDetail));
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
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = PegawaiV::model()->findAll($criteria);
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
      $models = PegawaiV::model()->findAll($criteria);
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

  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $nama_barang = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria->compare('LOWER(t.barang_nama)', strtolower($nama_barang), true);
      $criteria->addCondition('barang_aktif = true');
      $criteria->limit = 5;
      $models = BarangM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_kode . ' - ' . $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteKodeBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $nama_barang = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria->compare('LOWER(t.barang_kode)', strtolower($nama_barang), true);
      $criteria->addCondition('barang_aktif = true');
      $criteria->limit = 5;
      $models = BarangM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_kode . ' - ' . $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
