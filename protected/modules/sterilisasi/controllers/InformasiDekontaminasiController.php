<?php
class InformasiDekontaminasiController extends MyAuthController
{
  public $path_view = 'sterilisasi.views.informasiDekontaminasi.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dekontaminasi";
    $format = new MyFormatter();
    $modDekontaminasi = new STDekontaminasiT('searchInformasi');
    $modDekontaminasi->tgl_awal = date("Y-m-d");
    $modDekontaminasi->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STDekontaminasiT'])) {
      $modDekontaminasi->attributes = $_GET['STDekontaminasiT'];
      $modDekontaminasi->tgl_awal = $format->formatDateTimeForDb($_GET['STDekontaminasiT']['tgl_awal']);
      $modDekontaminasi->tgl_akhir = $format->formatDateTimeForDb($_GET['STDekontaminasiT']['tgl_akhir']);
      $modDekontaminasi->ruangan_id = $_GET['STDekontaminasiT']['ruangan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modDekontaminasi
    ));
  }


  public function actionDetail($dekontaminasi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
    $modDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $model->dekontaminasi_id));

    $judulLaporan = 'Dekontaminasi';
    $deskripsi = $format->formatDateTimeForUser($model->dekontaminasi_tgl);
    $this->render($this->path_view . '_detailDekontaminasi', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
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
      $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  public function actionPrintDetail($dekontaminasi_id)
  {
    $detail = array();
    $modPrograms = array();
    $format = new MyFormatter();
    $model = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
    $modDetails = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $model->dekontaminasi_id));

    $judulLaporan = 'Dekontaminasi';
    $deskripsi = $format->formatDateTimeForUser($model->dekontaminasi_tgl);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printDetail', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'detail' => $detail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printDetail', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'detail' => $detail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printDetail', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'detail' => $detail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
