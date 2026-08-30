<?php

class PengisiansaldoawalTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/iframe';
	public $defaultAction = 'create';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new BKPengisiansaldoawalT;
		$ruanganAsal = CHtml::listData(BKRuanganM::getRuanganItems(Yii::app()->user->getState('instalasi_id')),'ruangan_id','ruangan_nama');
        $profilrs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
		// $profilrs = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
		$ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
		$model->profilrs_id = $profilrs->profilrs_id;
		$model->nama_rumahsakit = $profilrs->nama_rumahsakit;
		$model->ruangan_id = $ruangan->ruangan_id;
		$model->ruangan_nama = $ruangan->ruangan_nama;

		$model->create_time = date('Y-m-d H:i:s');
		$model->kirim_tgl = date('Y-m-d H:i:s');
		$model->is_kirim = false;

		if(isset($_POST['BKPengisiansaldoawalT']))
		{
			$model->attributes=$_POST['BKPengisiansaldoawalT'];
			$model->tglpengisiansaldo = MyFormatter::formatDateTimeForDb($_POST['BKPengisiansaldoawalT']['tglpengisiansaldo']);
			$model->nilaisaldoawal = MyFormatter::formatRupiahForDB($_POST['BKPengisiansaldoawalT']['nilaisaldoawal']);
	
			

			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('update','id'=>$model->pengisiansaldoawal_id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,'ruanganAsal'=>$ruanganAsal,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);
		$ruanganAsal = CHtml::listData(BKRuanganM::getRuanganItems(Yii::app()->user->getState('instalasi_id')),'ruangan_id','ruangan_nama');
		$profilrs = ProfilrumahsakitM::model()->findByPk($model->profilrs_id);
		$ruangan = RuanganM::model()->findByPk($model->ruangan_id);

		$model->update_time = date('Y-m-d H:i:s');
		$model->is_kirim = false;
		$model->nilaisaldoawal = MyFormatter::formatNumberForUser($model->nilaisaldoawal,2);
		$model->nama_rumahsakit = $profilrs->nama_rumahsakit;
		$model->ruangan_nama = $ruangan->ruangan_nama;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['BKPengisiansaldoawalT']))
		{
			$model->attributes=$_POST['BKPengisiansaldoawalT'];
			$model->tglpengisiansaldo = MyFormatter::formatDateTimeForDb($model->tglpengisiansaldo);
			$model->nilaisaldoawal = MyFormatter::formatRupiahForDB($_POST['BKPengisiansaldoawalT']['nilaisaldoawal']);


			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('update','id'=>$model->pengisiansaldoawal_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,'ruanganAsal'=>$ruanganAsal,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
 public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
            $transaction = Yii::app()->db->beginTransaction();
            try {
               
                $model = $this->loadModel($id);
                $model->delete();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                $transaction->commit();
                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }catch (Exception $e){
                $transaction->rollback();
                echo 'error'.$e->getMessage();

            }
        }else{
            
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BKPengisiansaldoawalT');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new BKPengisiansaldoawalT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BKPengisiansaldoawalT']))
			$model->attributes=$_GET['BKPengisiansaldoawalT'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionViewCard()
	{
                
		$model=new BKPengisiansaldoawalT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BKPengisiansaldoawalT']))
			$model->attributes=$_GET['BKPengisiansaldoawalT'];

		$this->render('viewtabel',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=BKPengisiansaldoawalT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='saprogram-promo-m-form')
		{
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
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			$model->programpromo_aktif = false;
			if($model->save()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//		SAKelompokTindakanM::model()->updateByPk($id, array('kelompoktindakan_aktif'=>false));
//		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
			if(isset($_REQUEST['BKPengisiansaldoawalT'])){
				$model= new BKPengisiansaldoawalT;
				$model->attributes=$_REQUEST['BKPengisiansaldoawalT'];
				$judulLaporan='Data Pengisian Saldo Awal';
				$caraPrint=$_REQUEST['caraPrint'];

				if($caraPrint=='PRINT') {
					$this->layout='//layouts/printWindows';
					$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
				}
				else if($caraPrint=='EXCEL') {
					$this->layout='//layouts/printExcel';
					$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
				}
				else if($_REQUEST['caraPrint']=='PDF') {
					$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
					$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
					$mpdf = new MyPDF('',$ukuranKertasPDF); 
					$mpdf->useOddEven = 2;  
					$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
					$mpdf->WriteHTML($stylesheet,1);  
					$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
					$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
					$mpdf->Output();
				}
			}else{
				$print=$_REQUEST['id'];
				if($print) {
					$model = PengisiansaldoawalT::model()->findByPk($_REQUEST['id']);

					$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
					$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
					$mpdf = new MyPDF60('','A5'); 
					// $mpdf->useOddEven = 2;  
					$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
					$mpdf->WriteHTML($stylesheet,1);  
					$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
					$mpdf->WriteHTML($this->render('_kwitansi',array('model'=>$model),true));
					$mpdf->Output();
					// $this->layout='//layouts/printWindows';
					// $this->render('_kwitansi',array('model'=>$model));

				}
			}
           
			
			
        }
}
