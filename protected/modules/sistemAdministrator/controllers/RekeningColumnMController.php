<?php

class RekeningColumnMController extends MyAuthController {

	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
        public $path_view = 'sistemAdministrator.views.rekeningColumnM.';
        public $successRekening = true;

				public function init(){
					if (isset($_GET['tab'])){
						if ($_GET['tab'] == 'frame'){
							$this->layout='//layouts/iframe';
						}
					}
				}
	public function actionView($id)
        {

            $model = SARekeningcolumnM::model()->findByAttributes(array('rekeningcolumn_id' => $id));
            $this->render($this->path_view.'view', array(
                    'model' => $model,
            ));
	}

        public function actionCreate($id='') {

		$model = new SARekeningcolumnM;

		if (isset($_POST['SARekeningcolumnM'])) {
                        $trans = Yii::app()->db->beginTransaction();
                        $ok = true;
                       if (isset($_POST['detail'])) {
                            foreach ($_POST['detail']['rekening5_id'] as $idx=>$item) {
                                    if (!empty($item)){
                                            $det = new SARekeningcolumnM;
                                            $det->table_name = $_POST['SARekeningcolumnM']['table_name'];
                                            $det->column_name = $_POST['SARekeningcolumnM']['column_name'];
                                            $det->keterangan = $_POST['SARekeningcolumnM']['keterangan'];

                                            $det->debitkredit= $_POST['detail']['debitkredit'][$idx];
                                            $det->rekening5_id = $item;
                                            if ($det->validate()) $ok = $ok && $det->save();
                                            else $ok = false;
                                    }
                            }
                        }

			if ($ok) {
                                $trans->commit();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','sukses'=>1));
			} else {
                                $trans->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                $this->redirect(array('create'));
                        }
		}

		$this->render($this->path_view.'create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {

            $model = $this->loadModel($id);

            if (isset($_POST['SARekeningcolumnM'])) {
                    $trans = Yii::app()->db->beginTransaction();
                    $ok = true;

                    if (isset($_POST['detail'])) {
                        $index = 0;
                        foreach ($_POST['detail']['rekening5_id'] as $idx=>$item) {
                            if (!empty($item)){
                                if($index == 0){
                                    $det = $model;
                                    $det->keterangan = $_POST['SARekeningcolumnM']['keterangan'];
                                    $det->debitkredit= $_POST['detail']['debitkredit'][$idx];
                                    $det->rekening5_id = $item;
                                }else{
                                    $det = new SARekeningcolumnM;
                                    $det->table_name = $_POST['SARekeningcolumnM']['table_name'];
                                    $det->column_name = $_POST['SARekeningcolumnM']['column_name'];
                                    $det->keterangan = $_POST['SARekeningcolumnM']['keterangan'];

                                    $det->debitkredit= $_POST['detail']['debitkredit'][$idx];
                                    $det->rekening5_id = $item;
                                }
                                $index++;
                                if ($det->validate()) $ok = $ok && $det->save();
                                else $ok = false;
                            }
                        }
                    }

                    if ($ok) {
                            $trans->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin','sukses'=>1));
                    } else {
                            $trans->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                            $this->redirect(array('update'));
                    }
            }

            $this->render($this->path_view.'update', array(
                    'model' => $model,
            ));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {

			$trans = Yii::app()->db->beginTransaction();
			$data = array('sukses'=>0);

			$ok = true;
			$ok = $ok && SARekeningcolumnM::model()->deleteAllByAttributes(array('rekeningcolumn_id' => $_POST['id']));

			if ($ok) {
				$trans->commit();
				$data['sukses'] = 1;
			} else {
				$trans->rollback();
				$data['sukses'] = 0;
			}
			echo CJSON::encode($data);


		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	// public function actionIndex() {
	// 	$dataProvider = new CActiveDataProvider('SARekeningcolumnM');
	// 	$this->render($this->path_view.'index', array(
	// 		'dataProvider' => $dataProvider,
	// 	));
	// }

	/**
	 * Manages all models.
	 */
	// public function actionAdmin() {
	// 	$model = new SARekeningcolumnM();
	// 	$model->unsetAttributes();
	// 	if (isset($_GET['SARekeningcolumnM'])) {
	// 		$model->attributes = $_GET['SARekeningcolumnM'];
	// 	}
	// 	$this->render($this->path_view.'admin', array(
	// 		'model' => $model,
	// 	));
	// }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	// public function loadModel($id) {
	// 	$model = SARekeningcolumnM::model()->findByPk($id);
	// 	if ($model === null)
	// 		throw new CHttpException(404, 'The requested page does not exist.');
	// 	return $model;
	// }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	// protected function performAjaxValidation($model) {
	// 	if (isset($_POST['ajax']) && $_POST['ajax'] === 'rekeningcolum-m-form') {
	// 		echo CActiveForm::validate($model);
	// 		Yii::app()->end();
	// 	}
	// }


	// public function actionPrint() {
	// 	$model = new SARekeningcolumnM;
	// 	if (isset($_GET['SARekeningcolumnM'])) {
	// 		$model->attributes = $_GET['SARekeningcolumnM'];
	// 	}
	// 	$judulLaporan = 'Data Jurnal Rekening Kolom';
	// 	$caraPrint = $_REQUEST['caraPrint'];
	// 	if ($caraPrint == 'PRINT') {
	// 		$this->layout = '//layouts/printWindows';
	// 		$this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
	// 	} else if ($caraPrint == 'EXCEL') {
	// 		$this->layout = '//layouts/printExcel';
	// 		$this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
	// 	} else if ($_REQUEST['caraPrint'] == 'PDF') {
	// 		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
	// 		$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
	// 		$mpdf = new MyPDF60('', $ukuranKertasPDF);
	// 		////$mpdf->useOddEven = 2;
	// 		  $footer = '
  //           <table width="100%">
  //           <tr>'
  //           . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
  //           . '</tr>
  //            <tr>'
  //           . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : '.MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')).'</b></i></td>'
  //           . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : '.$this->pageTitle=Yii::app()->user->nama_pemakai.' </b></i></td>'
  //           . '</tr>
  //           </table>';
  //           $mpdf->SetHtmlFooter($footer,'E');
  //           $mpdf->SetHtmlFooter($footer,'O');
	// 		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
	// 		$mpdf->WriteHTML($stylesheet, 1);
	// 		$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
	// 		$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
	// 		$mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
	// 	}
	// }


        // public function actionFormRekening() {
        //     if (Yii::app()->request->isAjaxRequest) {
        //         $r = Rekening5M::model()->findByPk($_POST['id']);
        //         $dk = $_POST['debitkredit'];
        //         $res = array();
        //         $res['dat'] = $this->renderPartial($this->path_view.'_rowRekening', array('r'=>$r, 'dk'=>$dk), true);

        //         echo CJSON::encode($res);
        //     }
        //     Yii::app()->end();
        // }

  //       public function actionGetListColumn(){
  //           if (Yii::app()->request->isAjaxRequest){
  //               $term = null;
  //               $tablename = null;
  //                if (isset($_GET['tablename']))
  //                   $tablename = "%$_GET[tablename]%";
  //               if (isset($_GET['term']))
  //                   $term = "%$_GET[term]%";
  //               $sql = "select column_name from information_schema.columns where table_schema = 'public' and table_name like :tabel and column_name ilike :kolom";
  //               $listTable = Yii::app()->db->createCommand($sql)->query(array(':tabel'=>$tablename,':kolom'=>$term));
  //               $hasil = array();
  //               foreach ($listTable as $value) {
  //                   $hasil[] = $value['column_name'];
  //               }
  //               echo json_encode($hasil);
  //               Yii::app()->end();
  //           }
  //           $index++;
  //           if ($det->validate()) $ok = $ok && $det->save();
  //           else $ok = false;
          
      

  //     if ($ok) {
  //       $trans->commit();
  //       Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //       $this->redirect(array('admin', 'sukses' => 1));
  //     } else {
  //       $trans->rollback();
  //       Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
  //       $this->redirect(array('update'));
  //     }
    

  //   $this->render('update', array(
  //     'model' => $model,
  //   ));
  // }


  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  // public function actionDelete()
  // {
  //   if (Yii::app()->request->isPostRequest) {

  //     $trans = Yii::app()->db->beginTransaction();
  //     $data = array('sukses' => 0);

  //     $ok = true;
  //     $ok = $ok && SARekeningcolumnM::model()->deleteAllByAttributes(array('rekeningcolumn_id' => $_POST['id']));

  //     if ($ok) {
  //       $trans->commit();
  //       $data['sukses'] = 1;
  //     } else {
  //       $trans->rollback();
  //       $data['sukses'] = 0;
  //     }
  //     echo CJSON::encode($data);
  //   } else
  //     throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  // }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SARekeningcolumnM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Jurnal Rekening Kolom";
    $model = new SARekeningcolumnM();
    $model->unsetAttributes();
    if (isset($_GET['SARekeningcolumnM'])) {
      $model->attributes = $_GET['SARekeningcolumnM'];
    }
    $this->render($this->path_view.'admin', array(
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
    $model = SARekeningcolumnM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rekeningcolum-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }


  public function actionPrint()
  {
    $model = new SARekeningcolumnM;
    if (isset($_GET['SARekeningcolumnM'])) {
      $model->attributes = $_GET['SARekeningcolumnM'];
    }
    $judulLaporan = 'Data Jurnal Rekening Kolom';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }


  public function actionFormRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $r = Rekening5M::model()->findByPk($_POST['id']);
      $dk = $_POST['debitkredit'];
      $res = array();
      $res['dat'] = $this->renderPartial($this->path_view.'_rowRekening', array('r' => $r, 'dk' => $dk), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }

  public function actionGetListColumn()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = null;
      $tablename = null;
      if (isset($_GET['tablename']))
        $tablename = "%$_GET[tablename]%";
      if (isset($_GET['term']))
        $term = "%$_GET[term]%";
      $sql = "select column_name from information_schema.columns where table_schema = 'public' and table_name like :tabel and column_name ilike :kolom";
      $listTable = Yii::app()->db->createCommand($sql)->query(array(':tabel' => $tablename, ':kolom' => $term));
      $hasil = array();
      foreach ($listTable as $value) {
        $hasil[] = $value['column_name'];
      }
      echo json_encode($hasil);
      Yii::app()->end();
    }
  }
}
