<?php

class BahanMenuDietMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAaction = 'admin';
  public $bahanmenudietsimpan;

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

  public function actionGetBahanMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $menudiet_id = $_POST['menudiet_id'];
      $bahanmakanan_id = $_POST['bahanmakanan_id'];
      $jmlbahan = $_POST['jmlbahan'];
      $satuan = $_POST['satuan'];
      $modBahanMenuDiet = new GZBahanMenuDietM();
      $modMenuDiet = MenuDietM::model()->findByPk($menudiet_id);
      $modBahanMakanan = BahanmakananM::model()->findByPK($bahanmakanan_id);
      /*$return = "";
					$tr = "";
					$tr .="<tr><td>";
					$tr .= CHtml::checkBox('checkList[]',true,array('class'=>'cekList', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
					$tr .= "</td><td>";
					$tr .= $modMenuDiet->menudiet_nama;
					$tr .= CHtml::hiddenField('menudiet_id[]',$modMenuDiet->menudiet_id);
					$tr .= CHtml::hiddenField('bahanmakanan_id[]',$modBahanMakanan->bahanmakanan_id);
					$tr .= "</td><td>";
					$tr .= $modBahanMakanan->namabahanmakanan;
					$tr .= "</td><td>";
					$tr .= CHtml::textField('jmlbahan[]',$jmlbahan, array('class'=>'float2','onkeypress'=>"return $(this).focusNextInputField(event);"));
					$tr .="</td><td>";
					$tr .= $satuan;
					$tr .="</td>";
					$tr .= "</tr>";   
				$return .= $tr;*/

      $modBahanMenuDiet->satuanbahan = $modBahanMakanan->satuanbahan;
      $modBahanMenuDiet->jmlbahan = $jmlbahan;
      $modBahanMenuDiet->bahanmakanan_id = $bahanmakanan_id;
      $modBahanMenuDiet->namabahanmakanan = $modBahanMakanan->namabahanmakanan;


      $return = $this->renderPartial("_rowMenuDiet", array('model' => $modBahanMenuDiet, 'i' => 1), true);

      $data['return'] = $return;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new BahanMenuDietM;

    // Uncomment the following line if AJAX validation is needed

    //var_dump($_POST);die;
    if (isset($_POST['BahanMenuDietM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $this->simpanBahanMenuDiet($_POST['BahanMenuDietM']['menudiet_id'], $_POST['GZBahanMenuDietM']);
        //	var_dump($_POST);die;

        if ($this->bahanmenudietsimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash("success", "Data BahanM Menu Diet berhasil Disimpan");
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
      }
      // $model->attributes=$_POST['BahanMenuDietM'];
      /*  for($i=0;$i<count((array)$_POST['menudiet_id']);$i++)
	            {
	                $model=new BahanMenuDietM;
	                $menu = $_POST['menudiet_id'][$i];
	                $model->menudiet_id=$menu;
	                $model->bahanmakanan_id=$_POST['bahanmakanan_id'][$i];
	                $model->jmlbahan=$_POST['jmlbahan'][$i];
	                if($model->save()){
		                Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data berhasil disimpan');
						$this->redirect(array('admin'));
					} else {
						Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
					}
	            }*/
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

    $getAll = GZBahanMenuDietM::model()->findAllByAttributes(array('menudiet_id' => $model->menudiet_id));
    // Uncomment the following line if AJAX validation is needed


    /*	if(isset($_POST['bahanmenudiet_id']))
		{
			for($i=0;$i<count((array)$_POST['bahanmenudiet_id']);$i++)
			{
				 $id = $_POST['bahanmenudiet_id'][$i];
				 $model = $this->loadModel($id);
				 $model->jmlbahan = $_POST['jmlbahan'][$id];
				 $model->save();
			}
			$this->redirect(array('admin','id'=>$model->bahanmenudiet_id));
		}*/

    if (isset($_POST['BahanMenuDietM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $this->updateBahanMenuDiet($_POST['BahanMenuDietM']['menudiet_id'], $_POST['GZBahanMenuDietM']);
        //	var_dump($_POST);die;

        if ($this->bahanmenudietsimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash("success", "Data BahanM Menu Diet berhasil Disimpan");
          $this->redirect(array('admin'));
        } else {
          Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
          $transaction->rollback();
        }
      } catch (Exception $e) {
        Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
        $transaction->rollback();
      }
    }

    $this->render('update', array(
      'model' => $model,
      'getAll' => $getAll
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
      //$this->loadModel($id)->delete();
      // we only allow deletion via POST request
      $data['sukses'] = 0;
      $data['pesan'] = "Data gagal dihapus!";
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($this->loadModel($id)->delete()) {
          $data['sukses'] = 1;
          $data['pesan'] = "Data berhasil dihapus!";
          $transaction->commit();
        } else {
          $transaction->rollback();
          $data['sukses'] = 0;
          $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['sukses'] = 0;
        $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();

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
    $dataProvider = new CActiveDataProvider('BahanMenuDietM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new BahanMenuDietM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BahanMenuDietM']))
      $model->attributes = $_GET['BahanMenuDietM'];

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
    $model = BahanMenuDietM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'bahan-menu-diet-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new GZBahanMenuDietM;
    if (isset($_GET['BahanMenuDietM']))
      $model->attributes = $_GET['BahanMenuDietM'];
    $judulLaporan = 'Data Bahan Menu Diet';
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

  public function actionGetmenuDiet()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $models = GZBahanMenuDietM::model()->findAllByAttributes(array('menudiet_id' => $_POST['id']));
      $data['form'] = "";

      if (count((array)$models) > 0) {
        $a = 1;
        foreach ($models as $i => $model) {
          $model->namabahanmakanan = $model->bahanmakanan->namabahanmakanan;
          $model->jmlbahan = number_format($model->jmlbahan, 2, ",", ".");
          $data['form'] .= $this->renderPartial('_rowMenuDiet', array('model' => $model, 'i' => $a), true);
          $a++;
        }
      } else {
        $model = new GZBahanMenuDietM();
        // $data['form'] .= $this->renderPartial('_rowMenuDiet',array('model'=>$model),true);
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  public function simpanBahanMenuDiet($menudiet_id, $post)
  {

    foreach ($post as $i => $bahandiet) {


      if (empty($bahandiet['bahanmenudiet_id'])) {
        $model = new GZBahanMenuDietM;
        $model->attributes = $bahandiet;
        $model->menudiet_id = $menudiet_id;


        //if($model->save()){
        $this->bahanmenudietsimpan = $model->save() && true;
        //}else{

        //}
        //var_dump($model->save());
      }
    }

    //	die;
  }

  public function updateBahanMenuDiet($menudiet_id, $post)
  {
    foreach ($post as $i => $bahandiet) {

      if (!empty($bahandiet['bahanmenudiet_id'])) {
        $model = GZBahanMenuDietM::model()->findByPk($bahandiet['bahanmenudiet_id']);
        $model->attributes = $bahandiet;
      } else {
        $model = new GZBahanMenuDietM;
        $model->attributes = $bahandiet;
        $model->menudiet_id = $menudiet_id;
      }

      $this->bahanmenudietsimpan = $model->save() && true;
      var_dump($model->getErrors());
    }
  }
}
