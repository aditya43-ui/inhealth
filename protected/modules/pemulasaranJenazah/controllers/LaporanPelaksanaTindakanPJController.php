<?php
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.LaporanPelaksanaTindakanRJController');
class LaporanPelaksanaTindakanPJController extends LaporanPelaksanaTindakanRJController
{
  public function actionLaporan()
  {
    return LaporanPelaksanaTindakanRJController::actionLaporan();
  }

  public function actionPrintLaporan()
  {
    return LaporanPelaksanaTindakanRJController::actionPrintLaporan();
  }

  public function actionFrameGrafikLaporan()
  {
    return LaporanPelaksanaTindakanRJController::actionFrameGrafikLaporan();
  }
}
