<?php

class ObatSupplierController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $successSaveSupplier = false;
  public $path_view = 'sistemAdministrator.views.obatSupplier.';
  public $path_tips = 'sistemAdministrator.views.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = SASupplierM::model()->findByPk($id);
    $modSupplier = SAObatsupplierM::model()->findAllByAttributes(array('supplier_id' => $id));
    $this->render($this->path_view . 'view', array(
      'model' => $model,
      'modSupplier' => $modSupplier,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $modDetails = array();
    $modDetail = array();
    $model = new SASupplierM;
    $modObatSupplier = new ObatsupplierM;
    if (isset($_POST['ObatsupplierM'])) {
      $modObatSupplier->attributes = (isset($_POST['ObatsupplierM']) ? $_POST['ObatsupplierM'] : null);
      $modObatSupplier->supplier_id = (isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null);

      if (count((array)$_POST['ObatsupplierM']) > 0) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = false;
          $modDetails = $this->validasiTabular($_POST['ObatsupplierM'], $modObatSupplier);
          foreach ($modDetails as $i => $data) {
            if ($data->obatalkes_id > 0) {
              if ($data->save()) {
                //                                            ObatalkesM::model()->updateAll(array('obatalkes_aktif'=>TRUE),'obatalkes_id>=:obatalkes_id',array(':obatalkes_id'=>$data->obatalkes_id));
                $success = true;
              } else {
                $success = false;
              }
            }
          }
          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data ' . $data->supplier->supplier_nama . ' berhasil disimpan');
            $this->redirect(array('admin', 'id' => 1/*,'supplier_id'=>$model->supplier_id*/));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
        }
      } else {
        $modObatSupplier->validate();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modObatSupplier' => $modObatSupplier, 'modDetail' => $modDetail, 'modDetails' => $modDetails
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */

  protected function validasiTabular($datas)
  {
    $valid = true;
    foreach ($datas as $i => $row) {
      $modDetails[$i] = new ObatsupplierM();
      $modDetails[$i]->attributes = $row;
      if (!empty($row['obatalkes_id']) && !empty($row['supplier_id'])) {
        $valid = $modDetails[$i]->validate() && $valid;
      }
    }
    return $modDetails;
  }

  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //$model=RESupplierM::model()->findByAttributes(array('supplier_id'=>$supplier_id));

    $modDetails = array();
    $modDetail = array();
    $modObatSupplier = SAObatsupplierM::model()->findAllByAttributes(array('obatsupplier_id' => $id));
    $model = SASupplierM::model()->findByPk($id);

    $modObat = new ObatalkesM;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAObatsupplierM'])) {
      if (is_array($_POST['SAObatsupplierM']) && count((array)$_POST['SAObatsupplierM']) > 0) {
        $modDetails = $this->validasiTabularUpdate($_POST['SAObatsupplierM']);
        //                            echo "<pre>".print_r($modDetails,1)."</pre>"; exit;
        //                            if ($model->validate()){
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = false;
          //                                    if($model->save()){
          $modDetails = $this->validasiTabularUpdate($_POST['SAObatsupplierM']);
          foreach ($modDetails as $i => $data) {
            ObatsupplierM::model()->deleteAllByAttributes(array('supplier_id' => $data->supplier_id, 'obatalkes_id' => $data->obatalkes_id));
            if ($data->obatalkes_id > 0) {
              if ($data->save()) {
                ObatalkesM::model()->updateAll(array('obatalkes_aktif' => TRUE), 'obatalkes_id>=:obatalkes_id', array(':obatalkes_id' => $data->obatalkes_id));
                $success = true;
              } else {
                $success = false;
              }
            }
          }
          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data ' . $data->supplier->supplier_nama . ' berhasil disimpan');
            $this->redirect(array('admin', 'id' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
        }

        //                            }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }
    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'modObatSupplier' => $modObatSupplier,
      'modObat' => $modObat,
      'modDetails' => $modDetails,
      'modDetail' => $modDetail,
    ));
  }

  protected function validasiTabularUpdate($datas)
  {
    $valid = true;
    foreach ($datas as $i => $row) {
      $modDetails[$i] = new ObatsupplierM();
      $modDetails[$i]->attributes = $row;
      //$modDetails[$i]->harganetto = (ceil($row['harganettoppn'] / 1.1));
      $valid = $modDetails[$i]->validate() && $valid;
      //                echo "<pre>".print_r($datas[$i],1)."</pre>";
      //                echo "<pre>".print_r($modDetails[$i]->getAttributes(),1)."</pre>";
      //                exit;
    }
    return $modDetails;
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  //	public function actionDelete($id)
  //	{
  //		if(Yii::app()->request->isPostRequest)
  //		{
  //			// we only allow deletion via POST request
  //                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
  ////			  $transaction = Yii::app()->db->beginTransaction();
  ////                          try {
  ////                                $hapusObatSupplier=SAObatsupplierM::model()->deleteAll('supplier_id='.$id.'');       
  //                                $this->loadModel($id)->delete();
  ////                                $transaction->commit();
  ////                          }catch(Exception $exc){
  ////                            $transaction->rollback();
  ////                            Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
  ////                           }
  //                           
  //			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
  //			if(!isset($_GET['ajax']))
  //				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  //		}
  //		else
  //			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  //	}

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SASupplierM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {

    $model = new SAObatsupplierM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAObatsupplierM'])) {
      $model->attributes = $_GET['SAObatsupplierM'];

      if (isset($_GET['SAObatsupplierM']['supplier_nama'])) {
        $model->supplier_nama = $_GET['SAObatsupplierM']['supplier_nama'];
      } else {
        $model->supplier_nama = null;
      }
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($obatalkes_id, $supplier_id)
  {
    $model = ObatsupplierM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id, 'supplier_id' => $supplier_id));

    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  public function actionDelete($obatalkes_id, $supplier_id)
  {
    $this->loadModel($obatalkes_id, $supplier_id)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionDeleteupdate($obatalkes_id, $supplier_id)
  {
    $this->loadModel($obatalkes_id, $supplier_id)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(Yii::app()->createUrl('sistemAdministrator/obatSupplier/admin'));
    $this->refresh();
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfsupplier-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    SASupplierM::model()->updateByPk($id, array('supplier_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new SAObatsupplierM('search');
    $model->attributes = $_REQUEST['SAObatsupplierM'];

    $judulLaporan = 'Data Obat Alkes Supplier';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  // -- Modul Gudang Farmasi -- //
  public function actionGetObatAlkesSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $supplier_id = $_POST['supplier_id'];

      $modSupplier = SupplierM::model()->findByPk($supplier_id);
      $modObatSupplier = new ObatsupplierM;
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
      $nourut = 1;
      $tr = "<tr>
						<td>" . CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
        CHtml::activeHiddenField($modObatSupplier, '[' . $obatalkes_id . ']obatalkes_id', array('value' => $modObatAlkes->obatalkes_id, 'class' => 'obatAlkes')) .
        CHtml::activeHiddenField($modObatSupplier, '[' . $obatalkes_id . ']supplier_id', array('value' => $modSupplier->supplier_id, 'class' => 'supplier')) .
        "</td>
						<td>" . $modSupplier->supplier_nama . "</td>
						<td>" . $modObatAlkes->obatalkes_nama . "</td>
						<td>" . CHtml::activeDropDownList($modObatSupplier, '[' . $obatalkes_id . ']satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 satuankecil', 'onkeypress' => "return $(this).focusNextInputField(event)", 'options' => array($modObatAlkes->satuankecil_id => array('selected' => true)),)) . "</td>
						<td>" . CHtml::activeDropDownList($modObatSupplier, '[' . $obatalkes_id . ']satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(), 'satuanbesar_id', 'satuanbesar_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 satuanbesar', 'onkeypress' => "return $(this).focusNextInputField(event)", 'options' => array($modObatAlkes->satuanbesar_id => array('selected' => true)),)) . "</td>
						<td>" . CHtml::activetextField($modObatSupplier, '[' . $obatalkes_id . ']hargabelibesar', array('onkeyup' => 'setHargaJual(this);', 'value' => ceil($modObatAlkes->harganetto), 'class' => 'span1 numbersOnly netto', 'readonly' => FALSE)) . "</td>
						<td>" . CHtml::activetextField($modObatSupplier, '[' . $obatalkes_id . ']hargabelikecil', array('value' => ceil($modObatAlkes->harganetto), 'class' => 'span1 numbersOnly hargajual', 'readonly' => FALSE)) . "</td>
						<td>" . CHtml::activetextField($modObatSupplier, '[' . $obatalkes_id . ']diskon_persen', array('class' => 'span1 numbersOnly diskon_persen', 'readonly' => FALSE, 'value' => 0)) . "</td>
						<td>" . CHtml::activetextField($modObatSupplier, '[' . $obatalkes_id . ']ppn_persen', array('class' => 'span1 numbersOnly ppn_persen', 'readonly' => FALSE, 'value' => 0)) . "</td>
						<td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '#', 'onclick' => 'remove(this);return false;', 'style' => 'text-decoration:none;', 'class' => 'cancel')) . "</td>
					  </tr>";

      $data['tr'] = $tr;
      //           $data['obatalkes']=$supplier_id;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
