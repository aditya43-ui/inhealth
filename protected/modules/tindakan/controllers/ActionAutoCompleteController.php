<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends MyAuthController
{
  public function actionDaftarPasienTindakanRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'tgl_pendaftaran DESC';
      $models = RJInfokunjunganrjV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->tgl_pendaftaran;
          $returnVal[$i]['value'] = $model->no_rekam_medik;
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionloadDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = RJInfokunjunganrjV::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
      $post = array(
        'tgl_pendaftaran' => $data->tgl_pendaftaran,
        'no_pendaftaran' => $data->no_pendaftaran,
        'umur' => $data->umur,
        'jeniskasuspenyakit_nama' => $data->jeniskasuspenyakit_nama,
        'instalasi_nama' => $data->instalasi_nama,
        'ruangan_nama' => $data->ruangan_nama,
        'pendaftaran_id' => $data->pendaftaran_id,
        'pasien_id' => $data->pasien_id,
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'nama_pasien' => $data->nama_pasien,
        'nama_bin' => $data->nama_bin,
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }
}
