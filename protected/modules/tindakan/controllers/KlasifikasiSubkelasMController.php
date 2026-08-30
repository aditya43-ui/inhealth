
<?php

class KlasifikasiSubkelasMController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view = 'rawatJalan.views.klasifikasiSubkelasM.';
    // public $link_bank = 'sistemAdministrator/KlasifikasiSubkelasM';
    //     ublic $link_rekening = 'sistemAdministrator/rekeningBank';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$model = KlasifikasiSubkelasM::model()->findByPk($id);

		$this->render($this->path_view . 'view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($sukses='') {
            if ($sukses == 1):
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            endif;
		$model=new KlasifikasiSubkelasM;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['KlasifikasiSubkelasM']))
		{
			// var_dump($_POST);
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['KlasifikasiSubkelasM'];
			
			
			if ($model->validate()) {
				$ok = $model->save();
			} else $ok = false;
			
			if ($ok) {
				$trans->commit();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			} else {
				$trans->rollback();
				Yii::app()->user->setFlash('error', '<strong>Error!</strong> Data gagal disimpan.');
				$this->redirect(array('create'));
			}
			
			/*
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('create','id'=>$model->bank_id));
                        }
			 * 
			 */
		}

		$this->render($this->path_view . 'create', array(
			'model'=>$model,
		));
	}


	public function actionUpdate($id, $sukses='') {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		//$model = $this->loadModel($id);
                 if ($sukses == 1):
                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                 endif;
		$model=$this->loadModel($id);
		
		if(isset($_POST['KlasifikasiSubkelasM']))
		{
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['KlasifikasiSubkelasM'];
			
			// var_dump($_POST); die;
			
			if ($model->validate()) {
				$ok = $model->save();
			} else $ok = false;
		
			
            // var_dump($_POST); die;
          
			if ($ok) {
				$trans->commit();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			} else {
				$trans->rollback();
				Yii::app()->user->setFlash('error', '<strong>Error!</strong> Data gagal disimpan.');
				$this->redirect(array('create'));
			}
		}

		$this->render($this->path_view . 'update',array(
			'model'=>$model
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
			// $ok = $ok && KlasifikasiSubkelasM::model()->deleteAllByAttributes(array('bank_id'=>$_POST['id']));
			
			if ($ok) {
				$trans->commit();
				$data['sukses'] = 1;
			} else {
				$trans->rollback();
				$data['sukses'] = 0;
			}  
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_GET['ajax']))
			//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			
			echo CJSON::encode($data);
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * 
	 * @throws CHttpException
	 */
	public function actionDeleteMaster()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$trans = Yii::app()->db->beginTransaction();
			$data = array('sukses'=>0);
			
			$ok = true;
			
			
			if ($ok) {
				$trans->commit();
				$data['sukses'] = 1;
			} else {
				$trans->rollback();
				$data['sukses'] = 0;
			}  
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_GET['ajax']))
			//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			
			echo CJSON::encode($data);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('KlasifikasiSubkelasM');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model=new KlasifikasiSubkelasM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KlasifikasiSubkelasM']))
			$model->attributes=$_GET['KlasifikasiSubkelasM'];

		$this->render($this->path_view . 'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = KlasifikasiSubkelasM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'klasifikasisubkelas-m-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Mengubah status aktif
	 * @param type $id 
	 */
	public function actionRemoveTemporary($id) {
		if(Yii::app()->request->isAjaxRequest)
		{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                $data = array('sukses' => 0);
				if (KlasifikasiSubkelasM::model()->updateByPk($id, array('domain_aktif'=>false))) {
					$data['sukses'] = 1;
				}
				echo CJSON::encode($data);
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionPrint() {
		$model= new KlasifikasiSubkelasM;
                
                if(isset($_REQUEST['KlasifikasiSubkelasM'])){
                    $model->attributes=$_REQUEST['KlasifikasiSubkelasM'];
                }
            
            $judulLaporan='Data Klasifikasi Subkelas';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view . 'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view . 'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                // $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
            }             
	}




}
