<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends MyAuthController
{
  public function actionDaftarPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_RAD);
      $models = PasienkirimkeunitlainV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->ruanganasal_nama . ' - ' . $model->tgl_pendaftaran;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDaftarPasienAutoComplete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_RAD);
      $models = ROPasienMasukPenunjangV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->ruanganasal_nama . ' - ' . $model->tgl_pendaftaran;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
