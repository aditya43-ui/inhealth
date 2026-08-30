<?php

class InformasiPengambilanPencucianLinenUmumController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.informasiPengambilanPencucianLinenUmum.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Linen";
    $format = new MyFormatter();
    $model = new InformasiambilpencucianlinenumumV();
    $model->tgl_awal_pengajuan = date("Y-m-d");
    $model->tgl_akhir_pengajuan = date("Y-m-d");
    $model->tgl_awal_pengambilan = date("Y-m-d");
    $model->tgl_akhir_pengambilan = date("Y-m-d");
    $model->pengajuan = false;
    $model->pengambilan = true;
    if (isset($_GET['InformasiambilpencucianlinenumumV'])) {
      $model->attributes = $_GET['InformasiambilpencucianlinenumumV'];
      $model->pengajuan = $_REQUEST['InformasiambilpencucianlinenumumV']['pengajuan'];
      $model->pengambilan = $_REQUEST['InformasiambilpencucianlinenumumV']['pengambilan'];
      $model->tgl_awal_pengajuan = $format->formatDateTimeForDb($_GET['InformasiambilpencucianlinenumumV']['tgl_awal_pengajuan']);
      $model->tgl_akhir_pengajuan = $format->formatDateTimeForDb($_GET['InformasiambilpencucianlinenumumV']['tgl_akhir_pengajuan']);
      $model->tgl_awal_pengambilan = $format->formatDateTimeForDb($_GET['InformasiambilpencucianlinenumumV']['tgl_awal_pengambilan']);
      $model->tgl_akhir_pengambilan = $format->formatDateTimeForDb($_GET['InformasiambilpencucianlinenumumV']['tgl_akhir_pengambilan']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model
    ));
  }

  public function actionBatalPenerimaan($ambilpencucianlinenumum_id, $terimapencucianlinenumum_id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetailAmbil = AmbilpencucianlinenumumdetT::model()->deleteAllByAttributes(array('ambilpencucianlinenumum_id' => $ambilpencucianlinenumum_id));
      $deleteAmbil = AmbilpencucianlinenumumT::model()->deleteByPk($ambilpencucianlinenumum_id);
      $deleteDetailTerima = TerimapencucianlinenumumdetT::model()->deleteAllByAttributes(array('terimapencucianlinenumum_id' => $terimapencucianlinenumum_id));
      $deleteTerima = TerimapencucianlinenumumT::model()->deleteByPk($terimapencucianlinenumum_id);
      if ($deleteDetailAmbil && $deleteAmbil && $deleteDetailTerima && $deleteTerima) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionDetail($ambilpencucianlinenumum_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = InformasiambilpencucianlinenumumV::model()->findByAttributes(array('ambilpencucianlinenumum_id' => $ambilpencucianlinenumum_id));
    $modDetail = AmbilpencucianlinenumumdetT::model()->findAllByAttributes(array('ambilpencucianlinenumum_id' => $ambilpencucianlinenumum_id));
    $judulLaporan = 'Pengambilan Pencucian Linen Umum';
    $this->render('_detail', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail,
      'judulLaporan' => $judulLaporan,
    ));
  }
}
