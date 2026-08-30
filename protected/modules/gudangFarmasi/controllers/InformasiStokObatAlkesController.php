<?php

class InformasiStokObatAlkesController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiStokObatAlkes.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Farmasi";
    $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');
    $model = new GFInfostokobatalkesruanganV('search');
    $model->unsetAttributes();
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['GFInfostokobatalkesruanganV'])) {
      $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
      $model->ceklisminimal = $_GET['GFInfostokobatalkesruanganV']['ceklisminimal'];
    }
    $format = new MyFormatter();

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
    ));
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
      $models = CHtml::listData(GFRuanganM::getRuanganStokOas($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  public function actionUbahLokasiObat($obatalkes_id, $ruangan_id)
  {
    $this->layout = '//layouts/iframe';
    $modViewStokOA = GFInformasistokobatalkesV::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id, 'ruangan_id' => $ruangan_id));
    $modLokasiObat = new GFLokasiobatM();
    $modRakObat = new GFRakobatM();
    if (isset($_POST['GFInformasistokobatalkesV'])) {
      $modStokObatAlkess = GFStokObatAlkesT::model()->findAllByAttributes(array('obatalkes_id' => $obatalkes_id, 'ruangan_id' => $ruangan_id));
      $save = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($modStokObatAlkess as $i => $modStokObatAlkes) {
          $modStokObatAlkes->attributes = $_POST['GFInformasistokobatalkesV'];
          $modStokObatAlkes->lokasiobat_id = $_POST['lokasiobat_id'];
          $modStokObatAlkes->rakobat_id = $_POST['rakobat_id'];
          $modStokObatAlkes->update_time = date('Y-m-d H:i:s');
          $modStokObatAlkes->update_loginpemakai_id = Yii::app()->user->id;
          $save &= $modStokObatAlkes->update();
        }
        if ($save) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('ubahLokasiObat', 'obatalkes_id' => $obatalkes_id, 'ruangan_id' => $ruangan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render('_formUbahLemariObat', array(
      'modViewStokOA' => $modViewStokOA,
      'modLokasiObat' => $modLokasiObat,
      'modRakObat' => $modRakObat
    ));
  }

  public function actionRincian($id, $ruangan_id)
  {
    $this->layout = '//layouts/iframe';
    $modRuangan = RuanganM::model()->findByPk($ruangan_id);
    $ruangan_nama = "";
    $instalasi_nama = "";

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
      $instalasi_nama = (isset($modRuangan->instalasi) ? $modRuangan->instalasi->instalasi_nama : "");
    }

    $model = StokobatalkesT::model()->findAllByAttributes(array('obatalkes_id' => $id, 'ruangan_id' => $ruangan_id));
    $judulLaporan = 'RINCIAN STOK OBAT ALKES';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (!empty($caraPrint)) {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
      }
    }

    $this->render($this->path_view . 'rincian', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'barang_id' => $id,
      'ruangan_id' => $ruangan_id,
      'caraPrint' => $caraPrint,
      'ruangan_nama' => $ruangan_nama,
      'instalasi_nama' => $instalasi_nama,
    ));
  }

  public function actionPrint()
  {
    $model = new GFInfostokobatalkesruanganV('search');
    $model->unsetAttributes();
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['GFInfostokobatalkesruanganV'])) {
      $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
      $model->ceklisminimal = $_GET['GFInfostokobatalkesruanganV']['ceklisminimal'];
    }

    $judulLaporan = 'INFORMASI STOK OBAT ALKES';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
