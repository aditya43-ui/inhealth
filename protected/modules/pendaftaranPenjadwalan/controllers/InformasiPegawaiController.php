<?php

class InformasiPegawaiController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Info Pegawai";
    $format = new MyFormatter();
    $modPPPegawaiM = new PPPegawaiV;

    if (isset($_REQUEST['PPPegawaiV'])) {
      $modPPPegawaiM->attributes = $_REQUEST['PPPegawaiV'];
    }

    $this->render('index', array('modPPPegawaiM' => $modPPPegawaiM));
  }

  public function actionViewPegawai($id)
  {
    $this->render('viewPegawai', array(
      'modPPPegawaiM' => $this->loadModel($id),
    ));
  }
  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $modPPPegawaiM = PPPegawaiM::model()->findByPk($id);
    if ($modPPPegawaiM === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $modPPPegawaiM;
  }
}
