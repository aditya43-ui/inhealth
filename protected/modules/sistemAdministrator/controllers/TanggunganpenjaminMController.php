<?php

class TanggunganpenjaminMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.tanggunganpenjaminM.';


  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new SATanggunganpenjaminM;
    $modTanggung = array();
    $dataTanggunganPenjamin = '';

    if (isset($_POST['SATanggunganpenjaminM'])) {
      $model->attributes = $_POST['SATanggunganpenjaminM'];
      $modTanggung = $this->validasiTabular($_POST['TanggunganpenjaminM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = 0;
        $list = CHtml::listData(TanggunganpenjaminM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'kelaspelayanan_id' => $model->kelaspelayanan_id)), 'tanggunganpenjamin_id', 'tanggunganpenjamin_id');
        foreach ($modTanggung as $i => $row) {
          if ($row->save()) {
            unset($list[$row->tanggunganpenjamin_id]);
            $success++;
          }
        }

        if (count((array)$list) > 0) {
          foreach ($list as $isi) {
            TanggunganpenjaminM::model()->deleteByPk($isi);
          }
        }
        
        if ((count((array)$modTanggung) > 0) && ($success == count((array)$modTanggung))) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
          $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
          $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
          //$this->redirect(Yii::app()->createUrl($module.'/'.$controller.'/admin'));
          $this->redirect(array('admin', 'id' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modTanggung' => $modTanggung, 'dataTanggunganPenjamin' => $dataTanggunganPenjamin
    ));
  }

  protected function validasiTabular($data)
  {
    $x = 0;
    foreach ($data as $i => $row) {
      if (!empty($row['tanggunganpenjamin_id'])) {
        $paket[$x] = TanggunganpenjaminM::model()->findByPk($row['tanggunganpenjamin_id']);
        $paket[$x]->attributes = $row;
        //                    $paket[$x]->subsidipemerintahtind = $row['subsidipemerintahtind'];
      } else {
        $paket[$x] = new TanggunganpenjaminM();
        $paket[$x]->attributes = $row;
      }

      $paket[$x]->subsidiasuransitind = MyFormatter::formatRupiahForDB($paket[$x]->subsidiasuransitind);
      $paket[$x]->subsidipemerintahtind = MyFormatter::formatRupiahForDB($paket[$x]->subsidipemerintahtind);
      $paket[$x]->subsidirumahsakittind = MyFormatter::formatRupiahForDB($paket[$x]->subsidirumahsakittind);
      $paket[$x]->subsidiasuransioa = MyFormatter::formatRupiahForDB($paket[$x]->subsidiasuransioa);
      $paket[$x]->subsidipemerintahoa = MyFormatter::formatRupiahForDB($paket[$x]->subsidipemerintahoa);
      $paket[$x]->subsidirumahsakitoa = MyFormatter::formatRupiahForDB($paket[$x]->subsidirumahsakitoa);
      $paket[$x]->persentanggcytopel = MyFormatter::formatRupiahForDB($paket[$x]->persentanggcytopel);
      $paket[$x]->makstanggpel = MyFormatter::formatRupiahForDB($paket[$x]->makstanggpel);
      $paket[$x]->iurbiayatind = 0;
      $paket[$x]->iurbiayaoa = 0;


      $paket[$x]->validate();

      // var_dump($paket[$x]->attributes);

      $x++;
    }
    // die;
    return $paket;
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id, $idKelas)
  {
    $model = $this->loadModel($id);
    $model->kelaspelayanan_id = $idKelas;
    $model->carabayar_id = $id;
    $modTanggung = TanggunganpenjaminM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'kelaspelayanan_id' => $idKelas));
    // Uncomment the following line if AJAX validation is needed

    $dataTanggunganPenjamin = '';
    if (isset($_POST['SATanggunganpenjaminM'])) {
      $model->attributes = $_POST['SATanggunganpenjaminM'];
      $modTanggung = $this->validasiTabular($_POST['TanggunganpenjaminM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = 0;
        $list = CHtml::listData(TanggunganpenjaminM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'kelaspelayanan_id' => $model->kelaspelayanan_id)), 'tanggunganpenjamin_id', 'tanggunganpenjamin_id');
        foreach ($modTanggung as $i => $row) {
          if ($row->save()) {
            unset($list[$row->tanggunganpenjamin_id]);
            $success++;
          }
        }

        if (count((array)$list) > 0) {
          foreach ($list as $isi) {
            TanggunganpenjaminM::model()->deleteByPk($isi);
          }
        }

        if ((count((array)$modTanggung) > 0) && ($success == count((array)$modTanggung))) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
          $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
          $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
          //$this->redirect(Yii::app()->createUrl($module.'/'.$controller.'/admin'));
          // $this->redirect(Yii::app()->createUrl($this->module->id.'/TanggunganpenjaminM/admin'));
          $this->redirect(array('admin', 'id' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modTanggung' => $modTanggung, 'dataTanggunganPenjamin' => $dataTanggunganPenjamin
    ));
  }

  //-- sistemAdministrator --//
  //function ajax get data Penjamin untuk form Master Tanggungan Penjamin
  public function actionGetPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idCaraBayar = $_POST['idCaraBayar'];
      $idKelasPelayanan = $_POST['idKelasPelayanan'];
      $modPenjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar));
      //            $TanggunganPenjamin = TanggunganpenjaminM::model()->with('penjamin')->findAllByAttributes(array('carabayar_id'=>$idCaraBayar));
      $tr = '';
      if (count((array)$modPenjamin) > 0) {
        foreach ($modPenjamin as $i => $row) {
          $tanggungan = TanggunganpenjaminM::model()->findByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_id' => $row->penjamin_id, 'kelaspelayanan_id' => $idKelasPelayanan));
          if (!empty($tanggungan)) {
            $tampilDetail = $tanggungan;
            $tampilDetail->subsidiasuransitind = MyFormatter::formatNumberForPrint($tampilDetail->subsidiasuransitind, 2);
            $tampilDetail->subsidipemerintahtind = MyFormatter::formatNumberForPrint($tampilDetail->subsidipemerintahtind, 2);
            $tampilDetail->subsidirumahsakittind = MyFormatter::formatNumberForPrint($tampilDetail->subsidirumahsakittind, 2);
            $tampilDetail->iurbiayatind = MyFormatter::formatNumberForPrint($tampilDetail->iurbiayatind, 2);
            $tampilDetail->subsidiasuransioa = MyFormatter::formatNumberForPrint($tampilDetail->subsidiasuransioa, 2);
            $tampilDetail->subsidipemerintahoa = MyFormatter::formatNumberForPrint($tampilDetail->subsidipemerintahoa, 2);
            $tampilDetail->subsidirumahsakitoa = MyFormatter::formatNumberForPrint($tampilDetail->subsidirumahsakitoa, 2);
            $tampilDetail->iurbiayaoa = MyFormatter::formatNumberForPrint($tampilDetail->iurbiayaoa, 2);
            $tampilDetail->persentanggcytopel = MyFormatter::formatNumberForPrint($tampilDetail->persentanggcytopel, 2);
          } else {
            $tampilDetail = new TanggunganpenjaminM;
            $tampilDetail->kelaspelayanan_id = $idKelasPelayanan;
            $tampilDetail->carabayar_id = $idCaraBayar;
            $tampilDetail->penjamin_id = $row->penjamin_id;
            $tampilDetail->subsidiasuransitind = "0,00";
            $tampilDetail->subsidipemerintahtind = "0,00";
            $tampilDetail->subsidirumahsakittind = "0,00";
            $tampilDetail->iurbiayatind = "0,00";
            $tampilDetail->subsidiasuransioa = "0,00";
            $tampilDetail->subsidipemerintahoa = "0,00";
            $tampilDetail->subsidirumahsakitoa = "0,00";
            $tampilDetail->iurbiayaoa = "0,00";
            $tampilDetail->persentanggcytopel = "0,00";
            $tampilDetail->makstanggpel = 0;
          }
          $tr .= "<tr>
                                <td>" . CHtml::TextField('noUrut', ($i + 1), array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
            CHtml::activeHiddenField($tampilDetail, '[' . $i . ']penjamin_id') .
            CHtml::activeHiddenField($tampilDetail, '[' . $i . ']carabayar_id') .
            CHtml::activeHiddenField($tampilDetail, '[' . $i . ']kelaspelayanan_id') .
            CHtml::activeHiddenField($tampilDetail, '[' . $i . ']tanggunganpenjamin_id') .
            "</td>
                                <td>" . $tampilDetail->penjamin->penjamin_nama . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidiasuransitind', array('group' => 'group1', 'class' => 'span1 asuransitind float2', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidipemerintahtind', array('group' => 'group1', 'class' => 'span1 float2 pemerintahtind', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidirumahsakittind', array('group' => 'group1', 'class' => 'span1 float2 rumahsakittind', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>" .
            // "<td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayatind',array('group'=>'group1','class'=>'span1 float2 iurbiayatind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>".
            "<td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidiasuransioa', array('group' => 'group2', 'class' => 'span1 float2 asuransioa', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidipemerintahoa', array('group' => 'group2', 'class' => 'span1 float2 pemerintahoa', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']subsidirumahsakitoa', array('group' => 'group2', 'class' => 'span1 float2 rumahsakitoa', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>" .
            // "<td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayaoa',array('group'=>'group2','class'=>'span1 numbersOnly iurbiayaoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>".
            "<td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']persentanggcytopel', array('group' => 'group3', 'class' => 'span1 float2 persentanggung', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextField($tampilDetail, '[' . $i . ']makstanggpel', array('class' => 'span2 integer2 makstanggpel', 'onblur' => 'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::link("<i class='icon-remove'></i>", '', array('href' => '', 'onclick' => 'delRow(this);return false;')) . "</td>
                            </tr>
                            ";
        }
      }

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id = null)
  {

    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      SATanggunganpenjaminM::model()->findByPk($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

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
    $dataProvider = new CActiveDataProvider('SATanggunganpenjaminM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {
    if ($id == 1) :
      Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
    endif;
    $model = new SATanggunganpenjaminM('search');
    $model->unsetAttributes();  // clear any default values
    //                $modCaraBayar = new SACaraBayarM('search');
    //                $modCaraBayar->unsetAttributes();
    ////                if(isset($_GET['SATanggunganpenjaminM']))
    ////                    $modCaraBayar->carabayar_nama=$_GET['SATanggunganpenjaminM'];
    //                $modCaraBayar->carabayar_aktif = true;

    if (isset($_GET['SATanggunganpenjaminM'])) {

      $model->attributes = $_GET['SATanggunganpenjaminM'];
      $model->penjamin = $_GET['SATanggunganpenjaminM']['penjamin'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $dataModel = SATanggunganpenjaminM::model()->findByAttributes(array('carabayar_id' => $id), array('limit' => 1));
    $model = SATanggunganpenjaminM::model()->findByPk($dataModel->tanggunganpenjamin_id);
    if ($model === null) {
      $model = new SATanggunganpenjaminM;
      $model->carabayar_id = $id;
    }
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'satanggunganpenjamin-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id = null)
  {
    // SATanggunganpenjaminM::model()->updateAll(array('tanggunganpenjamin_aktif'=>false),'carabayar_id='.$id.'');
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SATanggunganpenjaminM::model()->updateByPk($id, array('tanggunganpenjamin_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }


    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new SATanggunganpenjaminM();
    $model->attributes = $_REQUEST['SATanggunganpenjaminM'];
    //             echo print_r($model->attributes);
    //             exit();
    $judulLaporan = 'Data Tanggungan Penjamin';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
