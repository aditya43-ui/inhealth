<?php
class InformasiAntrianPendaftaranController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Antrian Pendaftaran";
    $modAntrianPendaftaran = new INAntrianT();
    $modAntrianPendaftaran->unsetAttributes();
    if (isset($_GET['INAntrianT'])) {
      $modAntrianPendaftaran->attributes = $_GET['INAntrianT'];
      //$modAntrianPendaftaran->loket_id=$_GET['INAntrianT']['loket_id'];
    }
    $this->render('index', array('modAntrianPendaftaran' => $modAntrianPendaftaran));
  }
  public function actionPrintKarcis($antrian_id)
  {
    $this->redirect(Yii::app()->createUrl('antrian/ambilTiket/print/', array("antrian_id" => $antrian_id)));
  }
}
