<?php

/**
 * Informasi penerimaan darah dari UTD PMI
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiPenerimaanDarahPMIController extends MyAuthController
{
  /**
   * Default menu informasi penerimaan darah dari PMI
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Darah Pmi";
    $model = new BDPenerimaandarahpmiT;

    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_GET['BDPenerimaandarahpmiT'])) {
      $model->attributes = $_GET['BDPenerimaandarahpmiT'];
      $model->petugas_penerima_nama = $_GET['BDPenerimaandarahpmiT']['petugas_penerima_nama'];
      $model->petugas_mengetahui_nama = $_GET['BDPenerimaandarahpmiT']['petugas_mengetahui_nama'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDPenerimaandarahpmiT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDPenerimaandarahpmiT']['tgl_akhir']);
    }

    $this->render(
      'index',
      array(
        'model' => $model,
      )
    );
  }

  /**
   * Batal penerimaan darah PMI
   */
  public function actionBatalPenerimaan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $res = array();
    $penerimaandarahpmi_id = $_POST['penerimaandarahpmi_id'];

    try {
      $trans = Yii::app()->db->beginTransaction();
      $hapusDetail = BDPenerimaandarahpmidetT::model()->deleteAllByAttributes(array('penerimaandarahpmi_id' => $penerimaandarahpmi_id));
      $hapusTerima = BDPenerimaandarahpmiT::model()->deleteByPk($penerimaandarahpmi_id);
      if ($hapusDetail && $hapusTerima) {
        $trans->commit();
        $res['sukses'] = 1;
      } else {
        $trans->rollback();
        $res['sukses'] = 1;
      }
    } catch (Exception $ex) {
      $trans->rollback();
      $res['sukses'] = 1;
    }

    echo CJSON::encode($res);
  }
}
