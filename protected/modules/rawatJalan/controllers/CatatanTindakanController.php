<?php

class CatatanTindakanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = "rawatJalan.views.catatanTindakan.";


  public function actionIndex($pendaftaran_id) {

    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $model = 
    // CatatantindakanT::model()->findByAttributes(array(
    //     'pendaftaran_id'=>$pendaftaran_id
    // )) ?? 
    new CatatantindakanT;

    if ($model->isNewRecord) {
      $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_id = $pendaftaran->pasien_id;
      $model->tgl_catatantindakan = date('Y-m-d H:i:s');
    }


    if (isset($_POST['CatatantindakanT'])) {
      try {
        $model->attributes = $_POST['CatatantindakanT'];
        $model->tgl_catatantindakan = MyFormatter::formatDateTimeForDB($model->tgl_catatantindakan);
  
        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
        }
        $model->update_time = date('Y-m-d H:i:s');
  
        if ($model->save()) {
          Yii::app()->user->setFlash('success', "Data catatan dokter berhasil disimpan");
        } else {
          Yii::app()->user->setFlash('error', "Data catatan dokter gagal disimpan");
        }
      } catch (Exception $e) {
        Yii::app()->user->setFlash('error', "Data catatan dokter gagal disimpan. ".$e->getMessage());
      }
    }


    $model->tgl_catatantindakan = MyFormatter::formatDateTimeForUser($model->tgl_catatantindakan);

    $this->render($this->path_view."index", array(
        'model'=>$model,
        'pendaftaran'=>$pendaftaran,
    ));
  }

  public function actionDetail($id) {
    $model = CatatantindakanT::model()->findBypk($id);
    $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

    $this->render($this->path_view."detail", array(
      'model'=>$model,
      'pendaftaran'=>$pendaftaran,
  ));
  }

}