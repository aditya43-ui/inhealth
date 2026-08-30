<?php

class SuratInternalController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.suratInternal.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new SuratinternalT;
    $model->tglsurat = date('Y-m-d H:i:s');
    $model->nomorsurat = "-Otomatis-";
   

    if (isset($_POST['SuratinternalT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $tersimpan = false;

        $model->attributes = $_POST['SuratinternalT'];
        $model->tglsurat = (!empty($model->tglsurat)? $format->formatDateTimeForDb($model->tglsurat): null);
        
        if($model->jenissurat == 'Surat Keluar'){
          $typeSurat = "";
          if(!empty($model->tipesurat)){
            if($model->tipesurat == 'Surat Tugas'){
              $typeSurat = "ST";
            }else if($model->tipesurat == 'Berita Acara'){
              $typeSurat = "BA";
            }
          }
          $model->nomorsurat = MyGenerator::noSuratInternal($typeSurat, date('Y-m-d',strtotime($model->tglsurat)));
        }
        
        $model->tglmulaiberlaku = (!empty($model->tglmulaiberlaku)? $format->formatDateTimeForDb($model->tglmulaiberlaku): null);
        $model->tglakhirberlaku = (!empty($model->tglakhirberlaku)? $format->formatDateTimeForDb($model->tglakhirberlaku): null);
        $model->tgldisposisi = (!empty($model->tgldisposisi)? $format->formatDateTimeForDb($model->tgldisposisi): null);
        $model->statussurat ="Proses";

        $model->dokumen = CUploadedFile::getInstance($model, 'dokumen');
        $dokumenUpload = $model->dokumen;
        $locationDok = "";
        if(!empty($model->dokumen)){
          $random = rand(000000, 999999);
          $model->dokumen = $random . $model->dokumen;
          $locationDok = Params::pathDokumenSuratInternalDirectory() . $model->dokumen;
        }

        if ($model->save()) {
          if (!empty($locationDok)) {
            $dokumenUpload->saveAs($locationDok);
          }

          $tersimpan = true;
          $tersimpanPihak = true;

          if(!empty($_POST['PihaksuratinternalT'])){
            foreach($_POST['PihaksuratinternalT'] as $dataPihak){
              $modPihak = new PihaksuratinternalT();
              $modPihak->attributes = $dataPihak;
              $modPihak->jenispihak = "Disposisi";
              $modPihak->suratinternal_id = $model->suratinternal_id;

              if(!$modPihak->save()){
                $tersimpanPihak = false;
              }
            }
          }

          if($tersimpanPihak == false){
            $tersimpan = false;
          }
        }

        if($tersimpan==true){
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
          $this->redirect(array('index', 'suratinternal_id' => $model->suratinternal_id, 'sukses' => 1));
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

  public function actionAutoCompleteUnitkerja()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }

      $returnVal = array();
      $criteria = new CDbCriteria();
      
      $criteria->compare('LOWER(t.namaunitkerja)', strtolower($_GET['term']), true);
      $criteria->order = 't.namaunitkerja';
      $criteria->limit = 5;
      $models = UnitkerjaM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namaunitkerja;
        $returnVal[$i]['value'] = $model->unitkerja_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

}
