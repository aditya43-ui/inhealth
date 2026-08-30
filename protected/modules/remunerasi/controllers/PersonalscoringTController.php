<?php

class PersonalscoringTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $this->render('detail', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($personalscoring_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Personal Scoring";
    $model = new PersonalscoringT;
    $modIndexing = new IndexingM('search');
    $modScoringdetail = new ScoringdetailT('search');
    $modPegawai = new PegawaiM;
    $modLoginpemakai = PegawaiM::model()->findByPK(Yii::app()->user->id);
    $format = new MyFormatter;
    $transaction = Yii::app()->db->beginTransaction();

    if (!empty($personalscoring_id)) {
      $model = PersonalscoringT::model()->findByPk($personalscoring_id);
      $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
    }
    if (isset($_POST['PersonalscoringT'])) {
      $model->attributes = $_POST['PegawaiM'];
      $model->attributes = $_POST['PersonalscoringT'];
      $modPegawai->attributes = $_POST['PegawaiM'];
      $modPegawai->pegawai_id = $_POST['PegawaiM']['pegawai_id'];
      $model->pegawai_id = $_POST['PegawaiM']['pegawai_id'];
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->ruangan_id;
      $model->tglscoring = $format->formatDateTimeForDb($_POST['PersonalscoringT']['tglscoring']);
      $model->periodescoring = $format->formatDateTimeForDb($_POST['PersonalscoringT']['periodescoring']);
      $model->sampaidengan = $format->formatDateTimeForDb($_POST['PersonalscoringT']['sampaidengan']);
      $model->gajipokok = str_replace(".", "", $model->gajipokok);
      $model->jabatan = $_POST['PegawaiM']['jabatan_id'];
      $model->pendidikan = $_POST['PegawaiM']['pendidikan_id'];

      $model->totalscore = str_replace(",", ".", $model->totalscore);

      //var_dump($_POST);
      try {
        if ($model->save()) {
          $jumlah = 0;
          if (count((array)$_POST['ScoringdetailT']) > 0) {
            foreach ($_POST['ScoringdetailT']['indexing_id'] as $i => $value) {
              $modScoringdetail = new ScoringdetailT;
              $modScoringdetail->personalscoring_id = $model->personalscoring_id;
              $modScoringdetail->index_personal = str_replace(",", ".", $_POST['ScoringdetailT']['indexing_nilai'][$i]);
              $modScoringdetail->ratebobot_personal = str_replace(",", ".", $_POST['ScoringdetailT']['ratebobot_personal'][$i]);
              $modScoringdetail->kelrem_id = $_POST['ScoringdetailT']['kelrem_id'][$i];
              $modScoringdetail->indexing_id = $_POST['ScoringdetailT']['indexing_id'][$i];
              $modScoringdetail->score_personal = str_replace(",", ".", $_POST['ScoringdetailT']['score_personal'][$i]);
              $modScoringdetail->score_ordinal = $_POST['ScoringdetailT']['score_ordinal'][$i];
              //var_dump($modScoringdetail->attributes, $modScoringdetail->validate(), $modScoringdetail->errors);
              if ($modScoringdetail->save()) {
                $jumlah++;
              }
            }
          }
          //var_dump(($jumlah>0) && ($jumlah == count((array)$_POST['ScoringdetailT']['indexing_id']))); die;
          if (($jumlah > 0) && ($jumlah == count((array)$_POST['ScoringdetailT']['indexing_id']))) {
            $transaction->commit();
            echo Yii::app()->user->setFlash('success', 'Data Scoring Pegawai ' . $modPegawai->nama_pegawai . ' berhasil disimpan.');
            $this->redirect(array('create', 'personalscoring_id' => $model->personalscoring_id, 'sukses' => 1));
          } else {
            throw new Exception("Transaksi gagal");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modIndexing' => $modIndexing,
      'modScoringdetail' => $modScoringdetail,
      'modPegawai' => $modPegawai,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PersonalscoringT'])) {
      $model->attributes = $_POST['PersonalscoringT'];
      if ($model->save())
        $this->redirect(array('view', 'id' => $model->personalscoring_id));
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PersonalscoringT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionInformasi()
  {
    $format = new MyFormatter;
    $model = new REPersonalscoringT('searchInformasi');
    $model->unsetAttributes();
    $model->periodescoring = date('Y-m-d');
    $model->sampaidengan = date('Y-m-d');
    $model->tglscoring = date('Y-m-d');

    if (isset($_GET['REPersonalscoringT'])) {
      $model->attributes = $_GET['REPersonalscoringT'];
      /*
                if ($_GET['REPersonalscoringT']['tglscoring'] > '0') {
                    $model->tglscoring = $format->formatDateTimeForDb($_GET['REPersonalscoringT']['tglscoring']);
                }
                if ($_GET['REPersonalscoringT']['periodescoring'] > '0') {
                    $model->periodescoring = $format->formatDateTimeForDb($_GET['REPersonalscoringT']['periodescoring']);
                }
                if ($_GET['REPersonalscoringT']['sampaidengan'] > '0') {
                    $model->sampaidengan = $format->formatDateTimeForDb($_GET['REPersonalscoringT']['sampaidengan']);
                }
                 * 
                 */
      $model->nama_pegawai = isset($_GET['REPersonalscoringT']['nama_pegawai']) ? $_GET['REPersonalscoringT']['nama_pegawai'] : null;
    }
    $this->render('informasi', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new PersonalscoringT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PersonalscoringT']))
      $model->attributes = $_GET['PersonalscoringT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PersonalscoringT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'personalscoring-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengurai data pegawai berdasarkan:
   * - pegawai_id
   * @throws CHttpException
   */
  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $nama_pegawai = isset($_POST['nama_pegawai']) ? $_POST['nama_pegawai'] : null;

      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pegawai_id)) {
        $criteria->addCondition('pegawai_id =' . $pegawai_id);
      }
      $criteria->compare('LOWER(nama_pegawai)', strtolower(trim($nama_pegawai)));

      $model =  REPegawaiM::model()->find($criteria);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
        $photopegawai = Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai;
      } else {
        $photopegawai =  Params::urlPegawaiDirectory() . 'no_photo.jpeg';
      }
      $returnVal["tgl_lahirpegawai"] = $format->formatDateTimeForUser($model->tgl_lahirpegawai);
      $returnVal["tempatlahir_pegawai"] = $model->tempatlahir_pegawai;
      $returnVal["jabatan"] = isset($model->jabatan_id) ? $model->jabatan->jabatan_nama : "-";
      $returnVal["pangkat"] = isset($model->pangkat_id) ? $model->pangkat->pangkat_nama : "-";
      $returnVal["pendidikan"] = isset($model->pendidikan_id) ? $model->pendidikan->pendidikan_nama : "-";
      $returnVal["gajipokok"] = isset($model->gajipokok) ? MyFormatter::formatNumberForPrint($model->gajipokok) : "0";
      $returnVal["kategoripegawai"] = isset($model->kategoripegawai) ? $model->kategoripegawai : "-";
      $returnVal["kategoripegawaiasal"] = isset($model->kategoripegawaiasal) ? $model->kategoripegawaiasal : "-";
      $returnVal["kelompokpegawai"] = isset($model->kelompokpegawai_id) ? $model->kelompokpegawai->kelompokpegawai_nama : "-";
      $returnVal["photopegawai"] = $photopegawai;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = REPegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
          $photopegawai = Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai;
        } else {
          $photopegawai =  Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg';
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['photopegawai'] = $photopegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
