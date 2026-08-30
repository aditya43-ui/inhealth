<?php
class InformasiAntrianFarmasiController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Antrian Farmasi";
    $modAntrianFarmasi = new INInformasipenjualanresepV();
    $modAntrianFarmasi->unsetAttributes();
    if (isset($_GET['INInformasipenjualanresepV'])) {
      $modAntrianFarmasi->attributes = $_GET['INInformasipenjualanresepV'];
      $modAntrianFarmasi->noantrian = $_GET['INInformasipenjualanresepV']['noantrian'];
      $modAntrianFarmasi->racikanantrian_id = $_GET['INInformasipenjualanresepV']['racikanantrian_id'];
    }
    $this->render('index', array('modAntrianFarmasi' => $modAntrianFarmasi));
  }

  /**
   * actionPrintPenjualanResep digunakan untuk print karcis antrian
   * @param type $id
   */
  public function actionPrintKarcis($antrianfarmasi_id)
  {
    $this->layout = '//layouts/iframe';
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $modAntrian = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
    $this->render('printKarcisFarmasi', array("modAntrian" => $modAntrian, "format" => $format));
  }
}
