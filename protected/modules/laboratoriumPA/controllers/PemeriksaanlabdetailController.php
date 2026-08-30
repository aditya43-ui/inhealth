
<?php

class PemeriksaanlabdetailController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

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
		$model=new LBPemeriksaanlabdetM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['LBPemeriksaanlabdetM']))
		{
			$model->attributes=$_POST['LBPemeriksaanlabdetM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pemeriksaanlabdet_id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
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
		//$model=$this->loadModel($id);
                $model = LBPemeriksaanlabdetM::model()->with('nilairujukan')->findByPk($id);
                
                $criteria = new CDbCriteria;
                $criteria->with = array('nilairujukan');
				if(!empty($model->pemeriksaanlab_id)){
					$criteria->addCondition('pemeriksaanlab_id = '.$model->pemeriksaanlab_id);
				}
                $modDetails = LBPemeriksaanlabdetM::model()->findAll($criteria);
                $modPemeriksaanLab = LBPemeriksaanlabM::model()->findByPk($model->pemeriksaanlab_id);
                
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['nilaiNormal']))
		{
                    $nilaiNormal = $_POST['nilaiNormal'];
                    foreach ($nilaiNormal as $jenKel => $kelUmurs) {
                        foreach ($kelUmurs as $kelUmur => $nilai){
                            //echo '<pre>'.print_r($nilai,1).'</pre>';
                            foreach ($nilai as $id => $normal) {
                                echo $id.': nilaiMin => '.$normal['nilaiMin'].' nilaiMax => '.$normal['nilaiMax'].' nilaiNama => '.$normal['nilaiNama'].'<br/>';
                                NilairujukanM::model()->updateByPk($id, array('nilairujukan_min'=>$normal['nilaiMin'],
                                                                              'nilairujukan_max'=>$normal['nilaiMax'],
                                                                              'nilairujukan_nama'=>$normal['nilaiNama']));
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin','modul_id'=>Yii::app()->session['modul_id']));
                    //echo '<pre>'.print_r($nilaiNormal,1).'</pre>';
                    //exit;
//			$model->attributes=$_POST['LBPemeriksaanlabdetM'];
//			if($model->save()){
//                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('admin','modul_id'=>Yii::app()->session['modul_id']));
//                        }
		}

		$this->render('update',array(
			'model'=>$model,
                        'modDetails'=>$modDetails,
                        'modPemeriksaanLab'=>$modPemeriksaanLab,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LBPemeriksaanlabdetM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new LBPemeriksaanlabdetM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LBPemeriksaanlabdetM']))
			$model->attributes=$_GET['LBPemeriksaanlabdetM'];

		$this->render('admin',array(
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
		$model=LBPemeriksaanlabdetM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lkpemeriksaanlabdet-m-form')
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
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new LBPemeriksaanlabdetM;
            $model->attributes=$_REQUEST['LBPemeriksaanlabdetM'];
            $judulLaporan='Data LBPemeriksaanlabdetM';
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
        }
}
