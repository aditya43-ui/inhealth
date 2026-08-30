<?php
Yii::import('rawatJalan.controllers.ResumeDokterController');
Yii::import('rawatJalan.models.*');
class ResumeDokterRDController extends ResumeDokterController
{
  public $path_view = "rawatJalan.views.resumeDokter.";
  // dicopy dari laboratorium.controller.pemakaianBmhp
  public function actionIndex($pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new RDInfokunjunganrdV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");

    if (!empty($pendaftaran_id)) {
      $modKunjungan = RDInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
    ));
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = $this->loadModPasienRawatJalan($_POST['pendaftaran_id']);
      if (!empty($model)) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal["$attribute"] = $model->$attribute;
        }
        $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
        $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * @param type $pendaftaran_id
   * @return InfokunjunganrjV
   */
  public function loadModPasienRawatDarurat($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
    $model = RDInfokunjunganrdV::model()->find($criteria);
    return $model;
  }
}
