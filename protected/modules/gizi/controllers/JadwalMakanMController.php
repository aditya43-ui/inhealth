<?php

class JadwalMakanMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $jenisdiet_nama;
  public $tipediet_nama;
  public $menudiet_nama;

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */

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

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new JadwalMakanM;

    // Uncomment the following line if AJAX validation is needed

    if (isset($_POST['JadwalMakanM'])) {
      $jmlJadwal = count((array)$_POST['MenuDietM']);
      if (count((array)$_POST['JadwalMakanM']) > 0) {
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;
        foreach ($_POST['JadwalMakanM'] as $i => $postJadwalMakan) {
          if (isset($_POST['JenisdietM'][$i]['checkList'])) {
            foreach ($postJadwalMakan as $ii => $waktu) {
              if (!empty($waktu['jeniswaktu_id'])) {
                $model = new JadwalMakanM;
                $model->tipediet_id = $waktu['tipediet_id'];
                $model->jenisdiet_id = $waktu['jenisdiet_id'];
                $model->jeniswaktu_id = $ii;
                $model->menudiet_id = $waktu['menudiet_id'];
                var_dump($model->attributes);
                if ($model->validate()) {
                  $ok = $ok && $model->save();
                } else $ok = false;
              }
            }
          }
        }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        }
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
      }
    }

    $this->render('create', array(
      'model' => $model,
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


    if (isset($_POST['JadwalMakanM'])) {
      $model->attributes = $_POST['JadwalMakanM'];

      if ($model->validate()) {
        //				JadwalMakanM::model()->updateByPk($id, array('menudiet_id'=>$model->menudiet_id));
        $model->save();
        Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
        $this->redirect(array('admin', 'id' => $model->jadwalmakan_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
      }
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
    $dataProvider = new CActiveDataProvider('JadwalMakanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new JadwalMakanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['JadwalMakanM']))
      $model->attributes = $_GET['JadwalMakanM'];

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
    $model = JadwalMakanM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionGetJadwalMakan()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $jenisdietid = $_POST['jenisdietid'];
      $tipedietid = $_POST['tipedietid'];
      $jeniswaktuid = $_POST['jeniswaktuid'];
      $menudietid = $_POST['menudietid'];
      $modJadwalMakan = new JadwalMakanM;
      $modJenisdiet = JenisdietM::model()->findByPk($jenisdietid);
      $modTipeDiet = TipeDietM::model()->findByPK($tipedietid);
      $modJenisWaktu = JenisWaktuM::model()->findByPK($jeniswaktuid);
      $modMenuDiet = MenuDietM::model()->findByPK($menudietid);
      $return = "";
      $tipejeniswaktu = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true ORDER BY jeniswaktu_id');
      $tr = "";
      $tr .= "<tr><td hidden>";
      $tr .= CHtml::checkBox('JenisdietM[][checkList]', true, array('class' => 'cekList'));
      $tr .= "</td><td>";
      $tr .= $modJenisdiet->jenisdiet_nama;
      $tr .= "</td><td>";
      $tr .= $modTipeDiet->tipediet_nama;
      $tr .= "</td>";

      foreach ($tipejeniswaktu as $i => $waktu) {
        if (in_array($waktu->jeniswaktu_id, $jeniswaktuid)) {
          $tr .= "<td>";
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']jenisdiet_id', array('value' => $modJenisdiet->jenisdiet_id));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']tipediet_id', array('value' => $modTipeDiet->tipediet_id));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']jeniswaktu_id', array('value' => $modJenisWaktu->jeniswaktu_id, 'readonly' => true));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']menudiet_id', array('value' => $modMenuDiet->menudiet_id, 'readonly' => true, 'class' => 'menudiet'));
          $tr .= CHtml::activeTextField($modMenuDiet, '[ii][' . $waktu->jeniswaktu_id . ']menudiet_nama', array('class' => 'adamenudiet span2', 'readonly' => true));
          $tr .= "</td>";
        } else {
          $tr .= "<td>";
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']jenisdiet_id', array('value' => ''));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']tipediet_id', array('value' => ''));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']jeniswaktu_id', array('value' => '', 'readonly' => true));
          $tr .= CHtml::activeHiddenField($modJadwalMakan, '[ii][' . $waktu->jeniswaktu_id . ']menudiet_id',  array('value' => '', 'class' => 'menudiet', 'readonly' => true));
          $tr .= CHtml::activeTextField($modMenuDiet, '[ii][' . $waktu->jeniswaktu_id . ']menudiet_nama', array('value' => '', 'class' => 'adamenudiet span2', 'readonly' => true));
          $tr .= "</td>";
        }
      }
      $tr .= "<td>";
      $tr .= CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusRowJadwalMakan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan jadwal makan'));
      $tr .= "</td>";
      $tr .= "</tr>";
      $return .= $tr;
      $data['return'] = $return;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jadwal-makan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new GZJadwalMakanM;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['JadwalMakanM']))
      $model->attributes = $_GET['JadwalMakanM'];
    $judulLaporan = 'Data Jadwal Makan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  //-- Gizi -- 
  //Get List Jenis Diet untuk Pemesanan Menu Diet
  public function actionJenisDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenisdiet_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'jenisdiet_id';
      $models = JenisdietM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenisdiet_nama;
        $returnVal[$i]['value'] = $model->jenisdiet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionTipeDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.tipediet_nama)', strtolower($_GET['term']), true);
      $criteria->order = 't.tipediet_nama';
      $models = TipeDietM::model()->with('tipediet')->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->tipediet_nama;
        $returnVal[$i]['value'] = $model->tipediet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  //-- Gizi -- 
  //Get List Menu Diet untuk Pemesanan Menu Diet
  public function actionMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.menudiet_nama)', strtolower($_GET['term']), true);
      if (!empty($_GET['kelaspelayananId'])) {
        $criteria->compare('tariftindakan_m.kelaspelayanan_id', $_GET['kelaspelayananId']);
      }
      $criteria->order = 't.menudiet_nama';
      $criteria->join = 'JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
                               JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id';
      $models = MenuDietM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->menudiet_nama;
        $returnVal[$i]['value'] = $model->menudiet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
