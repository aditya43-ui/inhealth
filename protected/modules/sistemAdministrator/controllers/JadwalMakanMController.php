<?php

class JadwalMakanMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  private $_valid;

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  public function actionGetJadwalMakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['jeniswaktu'])) {
        $jeniswaktu = $_POST['jeniswaktu'];
      }

      $jenisdietid = $_POST['jenisdietid'];
      $tipedietid = $_POST['tipedietid'];
      $jeniswaktuid = $_POST['jeniswaktuid'];
      $menudietid = $_POST['menudietid'];
      $modJadwalMakan = new JadwalMakanM;
      $modJenisdiet = JenisdietM::model()->findByPk($jenisdietid);
      $modTipeDiet = TipeDietM::model()->findByPK($tipedietid);
      $modJenisWaktu = JenisWaktuM::model()->findByPK($jeniswaktuid);
      $modMenuDiet = MenuDietM::model()->findByPK($menudietid);
      $return = array();
      $tipejeniswaktu = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true ORDER BY jeniswaktu_id');
      $tr = "";
      $tr .= "<tr><td>";
      $tr .= CHtml::checkBox('JadwalMakanM[][checkList]', true, array('class' => 'cekList'));
      $tr .= "</td><td>";
      $tr .= $modJenisdiet->jenisdiet_nama;
      $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]jenisdiet_id', array('value' => $modJenisdiet->jenisdiet_id));
      if (isset($modTipeDiet)) {
        $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]tipediet_id', array('value' => $modTipeDiet->tipediet_id));
      }
      $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]jeniswaktu_id', array('value' => $modJenisWaktu->jeniswaktu_id));
      $tr .= "</td><td>";
      if (isset($modTipeDiet)) {
        $tr .= $modTipeDiet->tipediet_nama;
      } else {
        $tr .= " - ";
      }
      $tr .= "</td>";

      foreach ($tipejeniswaktu as $waktu) {
        if (in_array($waktu->jeniswaktu_id, $jeniswaktuid)) {
          $tr .= "<td>";
          $tr .= CHtml::hiddenField('JadwalMakanM[][menudiet_id][' . $waktu->jeniswaktu_id . ']', $modMenuDiet->menudiet_id, array('class' => 'menudiet'));
          $tr .= '<div class="input-append">';
          $tr .= CHtml::textField('namaMenuDiet', $modMenuDiet->menudiet_nama, array('class' => 'adamenudiet span2'));
          $tr .= '<span class="add-on"><a href="javascript:void(0);" onclick="openDialog(this);return false;"><i class="icon-list-alt icon-search"></i><i class="entypo-search"></i></a></span>';
          $tr .= '</div>';
          //                    $tr .= $modMenuDiet->menudiet_nama;
          $tr .= "</td>";
        } else {
          $tr .= "<td>";
          $tr .= CHtml::hiddenField('JadwalMakanM[][menudiet_id][' . $waktu->jeniswaktu_id . ']', '', array('class' => 'menudiet'));
          $tr .= '<div class="input-append">';
          $tr .= CHtml::textField('namaMenuDiet', '', array('class' => 'adamenudiet span2'));
          $tr .= '<span class="add-on"><a href="javascript:void(0);" onclick="openDialog(this);return false;"><i class="icon-list-alt icon-search"></i><i class="entypo-search"></i></a></span>';
          $tr .= '</div>';
          //                    $tr .= $modMenuDiet->menudiet_nama;
          $tr .= "</td>";
        }
      }

      $tr .= "</tr>";
      $return .= $tr;
      $data['return'] = $return;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

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


    if (isset($_POST['jenisdietid'])) {
      //                                                $model->jeniswaktu_id = $_POST['jeniswaktu_id'];
      //                                                $model->jenisdiet_id = $_POST['jenisdiet_id'];
      //                                                $model->tipediet_id = $_POST['tipediet_id'];
      //                                                $model->menudiet_id = $_POST['menudiet_id'];
      //                                                echo '<pre>';
      //                                                echo print_r($_POST['JadwalMakanM']);
      //                                                foreach ($_POST['JadwalMakanM'] as $i=>$row){
      //                                                            foreach($row['menudiet_id'] as $j=>$v){
      //                                                                $models = new JadwalMakanM;
      //                                                                $models->attributes = $row;
      //                                                                $models->menudiet_id = $v;
      //                                                                $models->jeniswaktu_id = $j;
      //                                                                echo '<pre>';
      //                                                                echo print_r($models->attributes);
      //                                                            }
      //                                                        }
      //                                                        exit();
      //                                                echo '<pre>';
      //                                                echo print_r($_POST['JadwalMakanM']);
      //                                                exit();
      //                                                if($model->validate()){
      $modDetails = $this->validateTable($_POST['JadwalMakanM']);
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $success = true;
        foreach ($_POST['JadwalMakanM'] as $i => $row) {
          if ($row['checkList'] == 1) {
            foreach ($row['menudiet_id'] as $j => $v) {
              $models = new JadwalMakanM;
              $models->attributes = $row;
              $models->menudiet_id = $v;
              $models->jeniswaktu_id = $j;
              if (!empty($models->menudiet_id)) {
                if ($models->save()) {
                } else {
                  $success = false;
                }
              }
            }
          }
        }

        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil !</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
      //                                                    for($i=0;$i<count((array)$_POST['jenisdiet_id']);$i++)
      //                                                    {
      //                                                        $model = new JadwalMakanM;
      ////                                                        $model->attributes =$_POST['jadwalMakanM']
      //                                                        $jenisdiet = $_POST['jenisdiet_id'][$i];
      //                                                        $model->jeniswaktu_id = $_POST['jeniswaktu_id'][$i];
      //                                                        $model->tipediet_id = $_POST['tipediet_id'][$i];
      //                                                        if($model->validate())
      //                                                            $model->save();
      //                                                         for($a=0;$a<count((array)$_POST['jeniswaktu_id']);$a++)
      //                                                           {
      //                                                                        $model=new JadwalMakanM;
      //                                                                        $jeniswaktu = $_POST['jeniswaktu_id'][$i][$a];
      //                                                                        $model->jeniswaktu_id = $_POST['jeniswaktu_id'][$i][$a];
      //                                                                        $model->menudiet_id = $_POST['menudiet_id'][$jeniswaktu];
      //                                                                        if($model->validate())
      //                                                                            $model->save();
      //                                                           }
      //                                                    }
      //                                                }

    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  protected function validateTable($data)
  {
    $valid = true;
    foreach ($data as $i => $row) {
      foreach ($row['menudiet_id'] as $j => $v) {
        $models[$i] = new JadwalMakanM;
        $models[$i]->attributes = $row;
        $models[$i]->menudiet_id = $v;
        $models[$i]->jeniswaktu_id = $j;
        $models[$i]->validate();
      }
    }

    return $models;
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
      $model->menudiet_id = $_POST['menudiet_id'];
      if ($model->save())
        $this->redirect(array('admin', 'id' => $model->jadwalmakan_id));
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

    $model = new SAJadwalMakanM;
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
