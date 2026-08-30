
<?php

class LoginpemakaiKController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                                $sqlRuangan  = "SELECT 
                                                          ruangan_m.ruangan_id, 
                                                          ruangan_m.instalasi_id, 
                                                          ruangan_m.ruangan_nama, 
                                                          instalasi_m.instalasi_nama ,
                                                          instalasi_m.instalasi_aktif,
                                                          ruangan_m.ruangan_aktif
                                                        FROM 
                                                          public.instalasi_m, 
                                                          public.ruangan_m, 
                                                          public.ruanganpemakai_k
                                                        WHERE 
                                                          ruangan_m.instalasi_id = instalasi_m.instalasi_id AND
                                                          ruanganpemakai_k.ruangan_id = ruangan_m.ruangan_id AND ruanganpemakai_k.loginpemakai_id = $id 
                                                        ORDER BY instalasi_m.instalasi_nama asc";
                                $sqlModul  = "SELECT 
                                                          moduluser_k.modul_id, 
                                                          moduluser_k.loginpemakai_id, 
                                                          modul_k.modul_nama
                                                        FROM 
                                                          public.modul_k, 
                                                          public.moduluser_k
                                                        WHERE 
                                                          moduluser_k.modul_id = modul_k.modul_id AND moduluser_k.loginpemakai_id = $id
                                                        ORDER BY modul_k.modul_nama asc";
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                                                'modRuanganPemakai'=> Yii::app()->db->createCommand($sqlRuangan)->queryAll(),
                                                'modModulPemakai'=>Yii::app()->db->createCommand($sqlModul)->queryAll(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new LoginpemakaiK;
                $format = new MyFormatter();
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['LoginpemakaiK']))
		{
			$model->attributes=$_POST['LoginpemakaiK'];
                                $model->katakunci_pemakai = $model->new_password;
                                $model->ruangan=$_POST['ruangan_id'];
                                $model->modul=$_POST['modul_id'];
                                $model->loginpemakai_aktif = TRUE;
                                $model->lastlogin = empty($model->lastlogin) ? null : $format->formatDateTimeForDb($model->lastlogin);
                                $model->tglpembuatanlogin = empty($model->tglpembuatanlogin) ? null : $format->formatDateTimeForDb($model->tglpembuatanlogin);
                                $model->tglupdatelogin = empty($model->tglupdatelogin) ? null : $format->formatDateTimeForDb($model->tglupdatelogin);
                                $model->setScenario('insert');

                                    if($model->save() && $this->insertRuanganPemakai($model->loginpemakai_id) && $this->insertModulPemakai($model->loginpemakai_id)){
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('admin','id'=>$model->loginpemakai_id));
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
                                $model=$this->loadModel($id);
                                $modRuanganPemakai = $this->loadRuanganLogin($id);
                                $modModulPemakai = $this->loadModulLogin($id);
                               

		// Uncomment the following line if AJAX validation is needed
		
                                
		if(isset($_POST['LoginpemakaiK']))
		{
			$model->attributes=$_POST['LoginpemakaiK'];
                                                $model->old_password = $_POST['LoginpemakaiK']['old_password'];
                                                // if a new password has been entered
                                                if (!empty ($model->new_password) || !empty ($model->new_password_repeat) || !empty($model->old_password)) {
                                                    $model->setScenario('changePassword');
                                                }
                                                else{
                                                    $model->setScenario('update');
                                                }
                                                $model->lastlogin = date('Y-m-d');
                                                $model->tglupdatelogin = date('Y-m-d');
                                                if ($model->validate())
                                                {
                                                    if ($model->new_password !== '' && $model->old_password !=='')
                                                    {
                                                          if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
                                                             $model->katakunci_pemakai = $model->encrypt($model->new_password);
                                                          }else{
                                                              Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang anda inputkan tidak sesuai dengan database.');
                                                              $this->redirect(array('update','id'=>$model->loginpemakai_id));
                                                          }
                                                     }
                                                    $this->deleteRuanganLogin($id);
                                                    $this->deleteModulLogin($id);
                                                    if($model->update() && $this->insertRuanganPemakai($id) && $this->insertModulPemakai($id))
                                                    {
                                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                                        $this->redirect(array('view','id'=>$model->loginpemakai_id));
                                                    }
                                                    else
                                                    {
                                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
                                                         $this->redirect(array('admin','id'=>$model->loginpemakai_id));
                                                    }
                                                }
		}

		$this->render('update',array(
			'model'=>$model,
                                                'modRuanganPemakai'=>$modRuanganPemakai,
                                                'modModulPemakai'=>$modModulPemakai,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                                                $this->deleteRuanganLogin($id);
                                                $this->deleteModulLogin($id);
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
		$dataProvider=new CActiveDataProvider('LoginpemakaiK');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                                
		$model=new LoginpemakaiK('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LoginpemakaiK']))
                                {  
                                    $model->attributes=$_GET['LoginpemakaiK'];  
                                }

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
		$model=LoginpemakaiK::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='loginpemakai-k-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
                public function actionRemoveTemporary($id)
	{
                    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                    LoginpemakaiK::model()->updateByPk($id, array('loginpemakai_aktif'=>false));
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
                
                /**
                 * Menghapus ruangan-ruangan berdasarkan loginpemakai_id di ruanganpemakai_k
                 * @param type $loginId 
                 */
                public function deleteRuanganLogin($loginId)
                {
                    $result = RuanganpemakaiK::model()->deleteAllByAttributes(array('loginpemakai_id'=>$loginId));

                }
                
                /**
                 *Mengambil nilai dari ruanganpemakai_k berdasarkan loginpemakai_id
                 * @param type $loginId
                 * @return $result array() 
                 */
                public function loadRuanganLogin($loginId)
                {
                    $result = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id'=>$loginId));
                    return $result;

                }
                
                /**
                 * Menyimpan data ke tabel ruanganpemakai_k
                 * @param type $status
                 */
                 
                public function insertRuanganPemakai($id)
                {
                         $status = TRUE;
                         $hitung = count($_POST['ruangan_id']);
                         if($hitung < 1){return $status = TRUE;} //kondisi apabila tidak ada inputan di emultiselect
                         for($i=0;$i<$hitung;$i++){
                            $ruangan = new RuanganpemakaiK;
                            $ruangan->loginpemakai_id = $id;
                            $ruangan->ruangan_id = $_POST['ruangan_id'][$i];
                            if($ruangan->save()){
                                $status = TRUE;
                            }else{
                                $status = FALSE;
                            }
                         }
                             
                          return $status;
                    
                }
                
                /**
                 * Menghapus modul-modul berdasarkan loginpemakai_id di moduluser_k
                 * @param type $loginId 
                 */
                public function deleteModulLogin($loginId)
                {
                    $result = ModuluserK::model()->deleteAllByAttributes(array('loginpemakai_id'=>$loginId));

                }
                
                /**
                 *Mengambil nilai dari moduluser_k berdasarkan loginpemakai_id
                 * @param type $loginId
                 * @return $result array() 
                 */
                public function loadModulLogin($loginId)
                {
                    $result = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id'=>$loginId));
                    return $result;

                }
                
                /**
                 * Menyimpan data ke tabel moduluser_k
                 * @param type $status
                 */
                 
                public function insertModulPemakai($id)
                {
                         $status = TRUE;
                         $hitung = count($_POST['modul_id']);
                         if($hitung < 1){return $status = TRUE;} //kondisi apabila tidak ada inputan di emultiselect
                         for($i=0;$i<$hitung;$i++){
                            $modul = new ModuluserK;
                            $modul->loginpemakai_id = $id;
                            $modul->modul_id = $_POST['modul_id'][$i];
                            if($modul->save()){
                                $status = TRUE;
                            }else{
                                $status = FALSE;
                            }
                         }
                             
                          return $status;
                    
                }
                
                public function actionPrint()
                {
                 $model= new LoginpemakaiK;
                 $model->attributes=$_REQUEST['LoginpemakaiK'];
                 $judulLaporan=' Data Pemakai';
                 $caraPrint=$_REQUEST['caraPrint'];
                if($caraPrint=='PRINT')
                    {
                        $this->layout='//layouts/printWindows';
                        $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                    }
                else if($caraPrint=='EXCEL')    
                    {
                        $this->layout='//layouts/printExcel';
                        $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                    }
                else if($_REQUEST['caraPrint']=='PDF')
                    {

                        $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                        $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
                        $mpdf=new MyPDF('',$ukuranKertasPDF); 
                        $mpdf->useOddEven = 2;  
                        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                        $mpdf->WriteHTML($stylesheet,1);  
                        $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                        $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                        $mpdf->Output();
                    }                       
                }
                
                /**
                 * fungsi untuk mengganti password login pemakai
                 * @param type $id integer
                 */
                public function actionGantiPassword($id=''){
                    if(empty ($id))
                        $id = Yii::app()->user->id;
                    
                    //echo $_SESSION['username'];
                    //echo Yii::app()->user->name;
                    //echo Yii::app()->session['instalasi_id'];
                    //echo Yii::app()->user->getState('instalasi_id');
                    $model = $this->loadModel($id);
                    $prevUrl = Yii::app()->request->getUrlReferrer();
                    if(isset ($_POST['LoginpemakaiK'])){
                        $model->attributes=$_POST['LoginpemakaiK'];
                        $model->old_password = $_POST['LoginpemakaiK']['old_password'];
                        $model->setScenario('changePassword');
                        $model->lastlogin = date('Y-m-d');
                        $model->tglupdatelogin = date('Y-m-d');
                        if ($model->validate())
                        {
                            if ($model->new_password !== '' && $model->old_password !=='')
                            {
                                  if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
                                     $model->katakunci_pemakai = $model->encrypt($model->new_password);
                                  }else{
                                      Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang anda inputkan tidak sesuai dengan database.');
                                      $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                                  }
                             }
                            if($model->update())
                            {
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Password berhasil disimpan.');
                                $this->redirect($_POST['prevUrl']);  
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
                                 $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                            }
                        }
                    }
                        $this->render('gantiPassword',array(
                            'model'=>$model,'prevUrl'=>$prevUrl,
                    ));
                    
                    
                }
}
