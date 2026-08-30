<?php
yii::import('application.modules.kepegawaian.models.*');

class PegawaiMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = "laboratorium.views.pegawaiM.";
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id='', $sukses='')
	{
             if ($sukses == 1):
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');    
            endif;
		$loginpemakai = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition('loginpemakai_id = '.$loginpemakai);
		$pegawai = LoginpemakaiK::model()->find($criteria);
		if(empty($id)){
			$id = $pegawai->pegawai_id;
                }                    
		$this->render($this->path_view.'view',
                        array(
                            'model'=>$this->loadModel($id)
                        ));
	}
        
	public function actionProfilKlinik()
	{
		$loginpemakai_id = Yii::app()->user->id;
		$criteria = new CDbCriteria; 
		$criteria->addCondition('loginpemakai_id = '.$loginpemakai_id);
		$pegawai = LoginpemakaiK::model()->find($criteria);
		if(empty($idPegawai))
			$idPegawai = $pegawai->pegawai_id;
                                    
		$this->render('profilKlinik',array(
			'model'=>$this->loadModel($idPegawai),
		));
                }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new PegawaiM;
                $modRuanganPegawai = new RuanganpegawaiM;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['PegawaiM']))
		{
			
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                              $model=new PegawaiM;
                              $random= $model->nomorindukpegawai;
                              $model->attributes=$_POST['PegawaiM'];
                              $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                              if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
                              { 
                                  $model->pegawai_aktif=true;
                                  $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
                                  $gambar=$model->photopegawai;

                                  if(!empty($model->photopegawai))//Klo User Memasukan Logo
                                  { 

                                        $model->photopegawai =$random.'.'.$model->photopegawai->getExtensionName();

                                        Yii::import("ext.EPhpThumb.EPhpThumb");

                                         $thumb=new EPhpThumb();
                                         $thumb->init(); //this is needed

                                         $fullImgName =$model->photopegawai;   
                                         $fullImgSource = Params::pathPegawaiDirectory().$fullImgName;
                                         $fullThumbSource = Params::pathPegawaiTumbsDirectory().'kecil_'.$fullImgName;

                                         if($model->save())
                                              {
                                                   $gambar->saveAs($fullImgSource);
                                                   $thumb->create($fullImgSource)
                                                         ->resize(200,200)
                                                         ->save($fullThumbSource);
                                              }
                                          else
                                              {
                                                   Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
                                              }
                                    }
                              }   
                             else 
                              {
                                 $model->photopegawai=$_POST['PegawaiM']['tempPhoto'];
                                 if($model->validate())
                                    {
                                        $model->save();
                                    }
                                 else 
                                    {
                                         unlink(Params::pathPegawaiDirectory().$_POST['PegawaiM']['tempPhoto']);
                                         unlink(Params::pathPegawaiTumbsDirectory().$_POST['PegawaiM']['tempPhoto']);
                                    }
                               }
                  
                            $jumlahRuanganPegawai=COUNT($_POST['ruangan_id']);
                            $pegawai_id=$model->pegawai_id;
                            $hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
                            for($i=0; $i<=$jumlahRuanganPegawai; $i++)
                                {
                                    $modRuanganPegawai = new RuanganpegawaiM;
                                    $modRuanganPegawai->ruangan_id=$_POST['ruangan_id'][$i];
                                    $modRuanganPegawai->pegawai_id=$pegawai_id;
                                    $modRuanganPegawai->save();

                                }
                         $transaction->commit();
                         Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');    
                         $this->redirect(array('admin'));  
                     }
                    catch (Exception $e)
                     {
                          $transaction->rollback();
                          Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                     }   
              
		}

		$this->render('create',array(
			'model'=>$model,'modRuanganPegawai'=>$modRuanganPegawai
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id='')
	{
                $loginpemakai = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition('loginpemakai_id = '.$loginpemakai);
		$pegawai = LoginpemakaiK::model()->find($criteria);
		if(empty($id)){
			$id = $pegawai->pegawai_id;
                }
		$model=$this->loadModel($id);
		$modRuanganPegawai=RuanganpegawaiM::model()->findAll('pegawai_id='.$id.'');
		$temLogo=$model->photopegawai;
		$format = new MyFormatter();
		if(isset($_POST['KPPegawaiM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
					  $random= $model->nomorindukpegawai;
					  $model->attributes=$_POST['KPPegawaiM'];
					  $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
					  $model->update_time = date('Y-m-d');
					  $model->update_loginpemakai_id = Yii::app()->user->id;
					  if(!empty($_POST['KPPegawaiM']['tgl_lahirpegawai'])){
							$model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
					  }else{
						  $model->tgl_lahirpegawai = null;
					  }

					  if(!empty($_POST['KPPegawaiM']['tglditerima'])){
							$model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
					  }else{
						  $model->tglditerima = null;
					  }

					$model->pegawai_aktif=true;
					$model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
					$gambar=$model->photopegawai;
					if(isset($model->photopegawai)){ 
						if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
						{ 
							if(!empty($model->photopegawai))//Klo User Memasukan Logo
							{ 
								$model->photopegawai =$random.'.'.$model->photopegawai->getExtensionName();
								Yii::import("ext.EPhpThumb.EPhpThumb");
								$thumb=new EPhpThumb();
								$thumb->init(); //this is needed
								$fullImgName =$model->photopegawai;   
								$fullImgSource = Params::pathPegawaiDirectory().$fullImgName;
								$fullThumbSource = Params::pathPegawaiTumbsDirectory().'kecil_'.$fullImgName;
//                                    if($model->save())
								if($model->update())
								{ 
									if(!empty($temLogo))
									{ 
										if(file_exists(Params::pathPegawaiDirectory().$temLogo))
										{
											unlink(Params::pathPegawaiDirectory().$temLogo);
										}
										if(file_exists(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo))
										{
											unlink(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo);
										}
									}
									$gambar->saveAs($fullImgSource);
									$thumb->create($fullImgSource)
										->resize(200,200)
										->save($fullThumbSource);
								}
								else
								{
									Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
								}
							}else{
							   $model->photopegawai = $model->photopegawai;
							}

						}   
						else 
						{
							////Jika user Memasukan Photo Dari Webcam
							if(!empty($temLogo))
							{                        
								if(!empty($temLogo))
								{ 
									if(file_exists(Params::pathPegawaiDirectory().$temLogo))
									{
										unlink(Params::pathPegawaiDirectory().$temLogo);
									}
									if(file_exists(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo))
									{
										unlink(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo);
									}                                        
								}
							}
							$model->update();
						}
					}else{
						$model->photopegawai = $temLogo;
					}

					/*if(!empty($_POST['ruangan_id']))
						$jumlahRuanganPegawai = COUNT($_POST['ruangan_id']);
					else
						$jumlahRuanganPegawai = 0;
						$pegawai_id=$model->pegawai_id;
						$hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
						for($i=0; $i<$jumlahRuanganPegawai; $i++)
						{
							$modRuanganPegawai = new RuanganpegawaiM;
							$modRuanganPegawai->ruangan_id=isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null;
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}*/
						// $gelardepan = LookupM::model()->findByPk($model->gelardepan);
						// $model->gelardepan = $gelardepan->lookup_name;
						$model->update(); // update data 
						$transaction->commit();
				 Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');    
				 $this->redirect(array('view','sukses'=>1));  
			 }
			catch (Exception $e)
			{
				 $transaction->rollback();
				 Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
			}                 
		}
                
			$this->render('update',array(
			'model'=>$model,'modRuanganPegawai'=>$modRuanganPegawai,'format'=>$format
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
		$dataProvider=new CActiveDataProvider('PegawaiM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new PegawaiM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PegawaiM']))
			$model->attributes=$_GET['PegawaiM'];

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
		$model=KPPegawaiM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapegawai-m-form')
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
                PegawaiM::model()->updateByPk($id, array('pegawai_aktif'=>false));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new PegawaiM;
            $model->attributes=$_REQUEST['PegawaiM'];
            $judulLaporan='Data Pegawai';
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
