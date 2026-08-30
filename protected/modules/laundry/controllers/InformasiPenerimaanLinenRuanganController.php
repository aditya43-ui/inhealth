<?php

class InformasiPenerimaanLinenRuanganController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.informasiPenerimaanLinenRuangan.';
  public function actionIndex()
  {
    $format = new MyFormatter();
    $modPengirimanlinen = new LAPengirimanlinenT;
    $modPengirimanlinen->tgl_awal = date("Y-m-d");
    $modPengirimanlinen->tgl_akhir = date("Y-m-d");
    if (isset($_GET['LAPengirimanlinenT'])) {
      $modPengirimanlinen->attributes = $_GET['LAPengirimanlinenT'];
      $modPengirimanlinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPengirimanlinenT']['tgl_awal']);
      $modPengirimanlinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPengirimanlinenT']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPengirimanlinen' => $modPengirimanlinen
    ));
  }

  public function actionBatalPengiriman($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = PengirimanlinendetailT::model()->deleteAllByAttributes(array('pengirimanlinen_id' => $id));
      $deletePengiriman = PengirimanlinenT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePengiriman) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}
