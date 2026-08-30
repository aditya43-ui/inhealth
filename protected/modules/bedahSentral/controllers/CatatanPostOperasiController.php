
<?php

class CatatanPostOperasiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'create';
  public $path_view = "bedahSentral.views.catatanPostOperasi.";

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pasienmasukpenunjang_id)
  {
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = BedahanastesilokalPostopT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $spesimen = SpesimenhasiloperasiT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ), array(
      'condition' => 'laporanoperasipasien_id is null'
    ));


    if (empty($model)) {
      $model = new BedahanastesilokalPostopT;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    }

    $model->perdarahan_jml = number_format($model->perdarahan_jml, 2, ",", "");
    $model->hb_nilai = number_format($model->hb_nilai, 2, ",", "");
    $model->suhubadan = number_format($model->suhubadan, 2, ",", "");
    $model->ht_nilai = number_format($model->ht_nilai, 2, ",", "");
    $model->beratbadan = number_format($model->beratbadan, 2, ",", "");

    if (isset($_POST['BedahanastesilokalPostopT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        $model->attributes = $_POST['BedahanastesilokalPostopT'];
        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        //            var_dump($model->attributes); die;

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }


        if (isset($_POST['SpesimenhasiloperasiT'])) {
          foreach ($_POST['SpesimenhasiloperasiT'] as $spesimen_id => $item) {
            $det = SpesimenhasiloperasiT::model()->findByPk($spesimen_id);
            $det->attributes = $item;
            $det->save();

            SpesimenhasiloperasidetT::model()->deleteAllByAttributes(array(
              'spesimenhasiloperasi_id' => $det->spesimenhasiloperasi_id,
            ));
            if (isset($item['permintaanPeriksa']) && !empty($item['permintaanPeriksa'])) {
              foreach ($item['permintaanPeriksa'] as $permintaan) {
                $perm = new SpesimenhasiloperasidetT;
                $perm->spesimenhasiloperasi_id = $det->spesimenhasiloperasi_id;
                $perm->pemeriksaanlab_id = $permintaan;
                $perm->daftartindakan_id = empty($perm->pemeriksaanlab) ? null : $perm->pemeriksaanlab->daftartindakan_id;

                $perm->save();
                //                            var_dump($perm->attributes);
              }
            }

            //                    var_dump($det->attributes);
          }
        }





        //            var_dump($ok, $model->attributes, $_POST); die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'spesimen' => $spesimen,
    ));
  }


  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BedahanastesilokalPostopT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'bedahanastesilokal-postop-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionHapusSpesimen()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "Data spesimen berhasil dihapus.";

    try {
      SpesimenhasiloperasiT::model()->deleteByPk($id);
      $trans->commit();
    } catch (Exception $ex) {
      $trans->rollback();
      $ok = 0;
      $msg = "Data spesimen berhasil dihapus. " . $ex->getMessage();
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
}
