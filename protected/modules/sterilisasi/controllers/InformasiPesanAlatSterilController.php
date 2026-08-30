<?php

class InformasiPesanAlatSterilController extends MyAuthController
{
  //	public $layout = '//layouts/column1';
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Peralatan Steril";
    $format = new MyFormatter();
    $modPesanAlatSteril = new STPesanperlinensterilT('searchInformasi');
    $modPesanAlatSteril->tgl_awal = date("Y-m-d");
    $modPesanAlatSteril->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STPesanperlinensterilT'])) {
      $modPesanAlatSteril->attributes = $_GET['STPesanperlinensterilT'];
      $modPesanAlatSteril->tgl_awal = $format->formatDateTimeForDb($_GET['STPesanperlinensterilT']['tgl_awal']);
      $modPesanAlatSteril->tgl_akhir = $format->formatDateTimeForDb($_GET['STPesanperlinensterilT']['tgl_akhir']);
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3036);

    $this->render('index', array(
      'format' => $format,
      'modPesanAlatSteril' => $modPesanAlatSteril,
      'linkHalaman' => $linkHalaman
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

  public function actionDetail($pesanperlinensteril_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = STPesanperlinensterilT::model()->findByPk($pesanperlinensteril_id);
    $modDetails = STPesanperlinensterildetT::model()->findAllByAttributes(array('pesanperlinensteril_id' => $model->pesanperlinensteril_id));

    $judulLaporan = 'Penerimaan Peralatan Steril';
    $deskripsi = $format->formatDateTimeForUser($model->pesanperlinensteril_tgl);
    $this->render('_detail', array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      'model' => $model,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails,
    ));
  }

  public function actionPrintDetail($pesanperlinensteril_id)
  {
    $detail = array();
    $modPrograms = array();
    $format = new MyFormatter();
    $model = STPesanperlinensterilT::model()->findByPk($pesanperlinensteril_id);
    $modDetails = STPesanperlinensterildetT::model()->findAllByAttributes(array('pesanperlinensteril_id' => $model->pesanperlinensteril_id));
    $judulLaporan = 'Pemesanan Peralatan Steril';
    $deskripsi = $format->formatDateTimeForUser($model->pesanperlinensteril_tgl);
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
