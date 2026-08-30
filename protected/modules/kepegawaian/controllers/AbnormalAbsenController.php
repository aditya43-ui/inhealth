<?php

class AbnormalAbsenController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.abnormalAbsen.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new AbnormalabsenT;
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $model->tglpengajuan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

    if(!empty($model->pegawai_id)){
      $modPeg = PegawaiM::model()->findByPk($model->pegawai_id);

      if(!empty($modPeg)){
        $model->nama_pegawai = $modPeg->namaLengkap;
        $model->nama_unitkerja = (!empty($modPeg->unitkerja)?$modPeg->unitkerja->namaunitkerja:"");
      }
    }

    if (isset($_POST['AbnormalabsenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $tersimpan = false;

        $model->attributes = $_POST['AbnormalabsenT'];
        $model->tglpengajuan = $format->formatDateTimeForDb($model->tglpengajuan);
        $model->tglabnormalabsen = $format->formatDateTimeForDb($model->tglabnormalabsen);
        $model->jammasuk = (!empty($model->jammasuk)? $model->jammasuk : null);
        $model->jamkeluar = (!empty($model->jamkeluar)? $model->jamkeluar : null);

        if ($model->save()) {
          $tersimpan = true;
        }

        if($tersimpan==true){
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
          $this->redirect(array('index', 'abnormalabsen_id' => $model->abnormalabsen_id, 'sukses' => 1));
        }else{
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
        
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model
    ));
  }

  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }

      $returnVal = array();
      $criteria = new CDbCriteria();
      
      $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 't.nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

}
