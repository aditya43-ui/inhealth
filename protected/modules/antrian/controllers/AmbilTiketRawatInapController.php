<?php

Yii::import('application.modules.antrian.controllers.AmbilTiketController');
class AmbilTiketRawatInapController extends AmbilTiketController
{
  public $layout = '//layouts/kiosAntrian';
  public function actionIndex()
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('loket_aktif = true');
    $criteria->order = "loket_nourut";
    $modLokets = ANLoketM::model()->findAll('ispendaftaran = TRUE AND israwatinap = TRUE AND loket_aktif=TRUE ORDER BY loket_nourut');
    $model = new ANAntrianT;

    $this->render($this->pathView . 'index', array('model' => $model, 'modLokets' => $modLokets));
  }
}
