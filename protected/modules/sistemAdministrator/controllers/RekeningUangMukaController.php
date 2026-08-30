<?php
class RekeningUangMukaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.rekeningUangMuka.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  public function actionCreate()
  {
    $model = new SARekeninguangmukaM;
    $modTindakanRuangan = new SARekeninguangmukaM('search');
    $modTindakanRuangan->unsetAttributes();
    $modTindakanRuangan->instalasi_id = 0; //default tidak muncul data
    // if(Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN){
    // 	$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //	$model->instalasi_nama = Yii::app()->user->getState('instalasi_nama');
    //	$modTindakanRuangan->instalasi_id = Yii::app()->user->getState('instalasi_id');
    // }
    if (isset($_GET['SARekeninguangmukaM'])) {
      $modTindakanRuangan->attributes = $_GET['SARekeninguangmukaM'];
      $modTindakanRuangan->instalasi_id = $_GET['SARekeninguangmukaM']['instalasi_id'];
      $modTindakanRuangan->instalasi_nama = (isset($_GET['SARekeninguangmukaM']['instalasi_nama']) ? $_GET['SARekeninguangmukaM']['instalasi_nama'] : NULL);
      $modTindakanRuangan->nmrekening5 = (isset($_GET['SARekeninguangmukaM']['nmrekening5']) ? $_GET['SARekeninguangmukaM']['nmrekening5'] : NULL);
      $modTindakanRuangan->ispembatalan = (isset($_GET['SARekeninguangmukaM']['ispembatalan']) ? $_GET['SARekeninguangmukaM']['ispembatalan'] : NULL);
    }

    if (Yii::app()->request->isPostRequest) { //submit by ajax
      $data['sukses'] = 0;
      $data['pesan'] = "";

      if (isset($_POST['SARekeninguangmukaM'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $loadTindakanRuangan = SARekeninguangmukaM::model()->findByAttributes(array(
            'rekening5_id' => $_POST['SARekeninguangmukaM']['rekening5_id'],
            'instalasi_id' => $_POST['SARekeninguangmukaM']['instalasi_id'],
            'debitkredit' => $_POST['SARekeninguangmukaM']['debitkredit'],
            'ispembatalan' => $_POST['SARekeninguangmukaM']['ispembatalan'],
          ));
          if ($loadTindakanRuangan) {
            $data['sukses'] = 0;
            $data['pesan'] = "Rekening " . $loadTindakanRuangan->rekening5->nmrekening5 . " "
              . "(Saldo Normal : " . ($loadTindakanRuangan->debitkredit == 'D' ? "Debit" : "Kredit") . ", "
              . "Pembatalan : " . ($loadTindakanRuangan->debitkredit ? "Ya" : "Tidak") . ") sudah ada di " . $loadTindakanRuangan->instalasi->instalasi_nama . "!";
          } else {
            $model = new SARekeninguangmukaM;
            $model->instalasi_id = $_POST['SARekeninguangmukaM']['instalasi_id'];
            $model->rekening5_id = $_POST['SARekeninguangmukaM']['rekening5_id'];
            $model->debitkredit = $_POST['SARekeninguangmukaM']['debitkredit'];
            $model->ispembatalan = $_POST['SARekeninguangmukaM']['ispembatalan'];
            if ($model->save()) {
              $transaction->commit();
              $data['sukses'] = 1;
              Yii::app()->user->setFlash('success', 'Tindakan ' . $model->rekening5->nmrekening5 . ' di ' . $model->instalasi->instalasi_nama . '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $data['pesan'] = "Rekening " . $model->rekening5->nmrekening5 . " ("
                . "(Saldo Normal : " . ($model->debitkredit == 'D' ? "Debit" : "Kredit") . ", "
                . "Pembatalan : " . ($model->debitkredit ? "Ya" : "Tidak") . ") di " . $model->instalasi->instalasi_nama . " berhasil disimpan!";
            } else {

              $transaction->rollback();
              $data['sukses'] = 0;
              $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
            }
          }
        } catch (Exception $exc) {

          echo $exc->getMessage();
          die;

          $transaction->rollback();
          $data['sukses'] = 0;
          $data['pesan'] = 'Data gagal disimpan!' . MyExceptionMessage::getMessage($exc, true);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modTindakanRuangan' => $modTindakanRuangan,
    ));
  }


  public function actionAutocompleteTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nmrekening5)', strtolower($term), true);
      $criteria->compare('LOWER(kdrekening5)', strtolower($term), true, 'OR');
      $criteria->order = 'nmrekening5';
      $criteria->limit = 5;

      $models = Rekening5M::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->kdrekening5 . " " . $model->nmrekening5;
        $returnVal[$i]['value'] = $model->nmrekening5;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($idRuangan, $idTindakan)
  {
    $modKasusPenyakitRuangan = array();
    $this->render($this->path_view . 'view', array(
      'model' => InstalasiM::model()->findByPk($idRuangan),
      'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
    ));
  }
  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        SARekeninguangmukaM::model()->deleteByPk($_GET['rekeninguangmuka_id']);
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rekening Uang Muka gagal dihapus");
      }
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SARekeninguangmukaM('search');
    $model->unsetAttributes();  // clear any default values
    // if(Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN){
    //	$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    // }
    if (isset($_GET['SARekeninguangmukaM'])) {
      $model->attributes = $_GET['SARekeninguangmukaM'];
      //$model->instalasi_nama=$_GET['SARekeninguangmukaM']['instalasi_nama'];
      $model->kdrekening5 = $_GET['SARekeninguangmukaM']['kdrekening5'];
      $model->nmrekening5 = $_GET['SARekeninguangmukaM']['nmrekening5'];
      $model->ispembatalan = $_GET['SARekeninguangmukaM']['ispembatalan'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }
}
