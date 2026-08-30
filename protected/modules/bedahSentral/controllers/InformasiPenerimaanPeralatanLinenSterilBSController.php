<?php
class InformasiPenerimaanPeralatanLinenSterilBSController extends MyAuthController
{
  public $path_view = 'bedahSentral.views.informasiPenerimaanPeralatanLinenSterilBS.';

  public function actionIndex($linkHalaman = null)
  {
    $format = new MyFormatter();
    $model = new BSKirimperlinensterilT('searchInformasi');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['BSKirimperlinensterilT'])) {
      $model->attributes = $_GET['BSKirimperlinensterilT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSKirimperlinensterilT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSKirimperlinensterilT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionBatalPengiriman($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = KirimperlinensterildetT::model()->deleteAllByAttributes(array('kirimperlinensteril_id' => $id));
      $deletePengiriman = KirimperlinensterilT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePengiriman) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}
