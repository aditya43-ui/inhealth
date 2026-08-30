
<?php

class RuanganMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';

        public function actionCreatePegawaiRuangan()
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                           
           $model=new RuanganpegawaiM; 
                if(isset($_POST['RuanganpegawaiM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahRuanganPegawai=COUNT($_POST['pegawai_id']);
                                    $ruangan_id=$_POST['RuanganpegawaiM']['ruangan_id'];
                                    $hapusTindakanRuangan=RuanganpegawaiM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahRuanganPegawai; $i++)
                                        {
                                            $modRuanganPegawai = new RuanganpegawaiM;
                                            $modRuanganPegawai->ruangan_id=$ruangan_id;
                                            $modRuanganPegawai->pegawai_id=$_POST['pegawai_id'][$i];
                                            $modRuanganPegawai->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Pegawai Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Pegawai Gagal Disimpan");
                                }     
                    }
           $this->render('createRuanganPegawai',array('model'=>$model
		));
	}
        
        public function actionCreateDaftarTindakan()
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                           
           $model=new TindakanruanganM; 
                if(isset($_POST['TindakanruanganM']))
                    {
                    $ruangan_id = $_POST['ruanganid'];

                        $transaction = Yii::app()->db->beginTransaction();
                            try {
//                                    TindakanruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    foreach ($_POST['Tindakanruangan'] as $i=>$row)
                                        {
                                            $modTindakanRuangan = new TindakanruanganM;
                                            $modTindakanRuangan->ruangan_id=$row['ruangan_id'];
                                            $modTindakanRuangan->daftartindakan_id=$row['daftartindakan_id'];
                                            $modTindakanRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan ");
                                }     
                    }
           $this->render('createTindakanRuangan',array('model'=>$model
		));
	}
        public function actionUpdate($id)
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
           $model= HDRuanganM::model()->findByPk($id); 
           $modTindakan = TindakanruanganM::model()->findAllByAttributes(array('ruangan_id'=>$id));
           foreach($modTindakan as $i=>$row){
               $modDetails[$i] = new TindakanruanganM();
               $modDetails[$i]->attributes = $row->attributes;
           }
                if(isset($_POST['HDRuanganM']))
                    {
                    $ruangan_id = $_POST['ruanganid'];

                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    TindakanruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    foreach ($_POST['Tindakanruangan'] as $i=>$row)
                                        {
                                            $modTindakanRuangan = new TindakanruanganM;
                                            $modTindakanRuangan->ruangan_id=$row['ruangan_id'];
                                            $modTindakanRuangan->daftartindakan_id=$row['daftartindakan_id'];
                                            $modTindakanRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                                }     
                    }
           $this->render('update',array('model'=>$model, 'modDetails'=>$modDetails
		));
	}
        
        public function actionCreateKelasRuangan()
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                           
           $model=new KelasruanganM; 
                if(isset($_POST['KelasruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahKelasPelayanan=COUNT($_POST['kelaspelayanan_id']);
                                    $ruangan_id=$_POST['KelasruanganM']['ruangan_id'];
                                    $hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahKelasPelayanan; $i++)
                                        {
                                            $modKasusRuangan = new KelasruanganM;
                                            $modKasusRuangan->ruangan_id=$ruangan_id;
                                            $modKasusRuangan->kelaspelayanan_id=$_POST['kelaspelayanan_id'][$i];
                                            $modKasusRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
                                }     
                    }
           $this->render('createKelasRuangan',array('model'=>$model
		));
	}
        
        public function actionCreateJenisKasusPenyakit()
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                  
           $model=new KasuspenyakitruanganM; 
                if(isset($_POST['KasuspenyakitruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahJenisKasusPenyakit=COUNT($_POST['jeniskasuspenyakit_id']);
                                    $ruangan_id=$_POST['KasuspenyakitruanganM']['ruangan_id'];
                                    $hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahJenisKasusPenyakit; $i++)
                                        {
                                            $modKasusRuangan = new KasuspenyakitruanganM;
                                            $modKasusRuangan->ruangan_id=$ruangan_id;
                                            $modKasusRuangan->jeniskasuspenyakit_id=$_POST['jeniskasuspenyakit_id'][$i];
                                            $modKasusRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
                                }     
                    }
           $this->render('createJenisKasusPenyakit',array('model'=>$model
		));
	}
        /**
	 * Deletes Temporary a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
        public function actionRemoveTemporary()
        {
            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//             HDRuanganM::model()->updateByPk($id, array('ruangan_aktif'=>false));
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

            $id = $_GET['id'];   
            if(isset($_GET['id']))
            {
               $update = HDRuanganM::model()->updateByPk($id,array('ruangan_aktif'=>false));
               if($update)
                {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
                 }
            } else {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
            }

        }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $modKasusPenyakitRuangan=array();
		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'modKasusPenyakitRuangan'=>$modKasusPenyakitRuangan,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                  
		$model=new HDRuanganM;
                $modRiwayatRuangan=new SARiwayatRuanganR;

		// Uncomment the following line if AJAX validation is needed
		
                if(isset($_POST['HDRuanganM']))
                {
                  $transaction = Yii::app()->db->beginTransaction();
                  try {
                        $modRiwayatRuangan=new SARiwayatRuanganR; 
                        $modRiwayatRuangan->attributes=$_POST['SARiwayatRuanganR'];
                        $modRiwayatRuangan->save();
                        $valid=true;
                        foreach($_POST['HDRuanganM'] as $i=>$item):
                            if(is_integer($i)) {
                              $model=new HDRuanganM;
                              $random=rand(0000000,9999999);
                              $model->attributes=$_POST['HDRuanganM'][$i];
                              $model->instalasi_id=$_POST['instalasi_id'];
                              $model->ruangan_image = CUploadedFile::getInstance($model, '['.$i.']ruangan_image');
                              $model->riwayatruangan_id=$modRiwayatRuangan->riwayatruangan_id;
                              $gambar=$model->ruangan_image;
                              if(!empty($model->ruangan_image)){//Klo User Memasukan Logo

                                     $model->ruangan_image = $random.$model->ruangan_image;
                                     Yii::import("ext.EPhpThumb.EPhpThumb");
                                     $thumb=new EPhpThumb();
                                     $thumb->init(); //this is needed
                                     $fullImgName =$model->ruangan_image;   
                                     $fullImgSource = Params::pathRuanganDirectory().$fullImgName;
                                     $fullThumbSource = Params::pathRuanganTumbsDirectory().'kecil_'.$fullImgName;
                                     $model->ruangan_image = $fullImgName;
                                     if($model->save()){
                                               $gambar->saveAs($fullImgSource);
                                               $thumb->create($fullImgSource)
                                                     ->resize(200,200)
                                                     ->save($fullThumbSource);
                                     }
                              }else{//Klo User Tidak Memasukan Logo
                                    $model->save();
                                   }

                           }
                       endforeach;
                       $transaction->commit();
                       Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                       $this->redirect(array('admin'));
                    } catch(Exception $exc){
                               $transaction->rollback();
                               Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc,true).'');

                      }
                }   
		

		$this->render('create',array(
			'model'=>$model,'modRiwayatRuangan'=>$modRiwayatRuangan
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
//	public function actionUpdate($id)
//	{
//                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
//		$model=$this->loadModel($id);
//                $modKasusPenyakitRuangan=KasuspenyakitruanganM::model()->findAll('ruangan_id='.$id.'');
//                $modKelasRuangan=KelasruanganM::model()->findAll('ruangan_id='.$id.'');
//                $modTindakanRuangan=TindakanruanganM::model()->findAll('ruangan_id='.$id.'');
//                $modRuanganPegawai=RuanganpegawaiM::model()->findAll('ruangan_id='.$id.'');
//                $modRiwayatRuangan=RiwayatruanganR::model()->findByPk($model->riwayatruangan_id);
//
//		// Uncomment the following line if AJAX validation is needed
//		
//                  
//		if(isset($_POST['HDRuanganM']))
//		{
//                    
//                        $transaction = Yii::app()->db->beginTransaction();
//                            try {
//                                    $model->attributes=$_POST['HDRuanganM'];
//                                    $model->save();
//                                    $jumlahKelasPelayanan=COUNT($_POST['kelaspelayanan_id']);
//                                    $jumlahJenisKasusPenyakit=COUNT($_POST['jeniskasuspenyakit_id']);
//                                    $jumlahDaftarTindakan=COUNT($_POST['daftartindakan_id']);
//                                    $jumlahRuanganPegawai=COUNT($_POST['pegawai_id']);
//
//    
//                                    $ruangan_id=$model->ruangan_id;
//                                    $hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
//                                    $hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
//                                    $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
//                                    $hapusRuanganPegawai=RuanganpegawaiM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
//
//                                    if($jumlahJenisKasusPenyakit>0)
//                                        {
//                                            for($i=0; $i<=$jumlahJenisKasusPenyakit; $i++)
//                                                {
//                                                    $modKasusRuangan = new KasuspenyakitruanganM;
//                                                    $modKasusRuangan->ruangan_id=$ruangan_id;
//                                                    $modKasusRuangan->jeniskasuspenyakit_id=$_POST['jeniskasuspenyakit_id'][$i];
//                                                    $modKasusRuangan->save(); 
//                                                }
//                                        }
//                                        
//                                    if($jumlahKelasPelayanan>0)
//                                        {    
//                                            for($i=0; $i<=$jumlahKelasPelayanan; $i++)
//                                                {
//                                                    $modKasusRuangan = new KelasruanganM;
//                                                    $modKasusRuangan->ruangan_id=$ruangan_id;
//                                                    $modKasusRuangan->kelaspelayanan_id=$_POST['kelaspelayanan_id'][$i];
//                                                    $modKasusRuangan->save();
//                                                }
//                                        }
//                                        
//                                      if($jumlahDaftarTindakan>0)
//                                        {    
//                                        
//                                              for($j=0; $j<=$jumlahDaftarTindakan; $j++)
//                                                {
//                                                    $modTindakanRuangan = new TindakanruanganM;
//                                                    $modTindakanRuangan->ruangan_id=$ruangan_id;
//                                                    $modTindakanRuangan->daftartindakan_id=$_POST['daftartindakan_id'][$j];
//                                                    $modTindakanRuangan->save();
//                                                }
//                                        }
//                                        
//                                      if($jumlahRuanganPegawai>0)
//                                        {    
//                                        
//                                              for($j=0; $j<=$jumlahRuanganPegawai; $j++)
//                                                {
//                                                    $modRuanganPegawai = new RuanganpegawaiM;
//                                                    $modRuanganPegawai->ruangan_id=$ruangan_id;
//                                                    $modRuanganPegawai->pegawai_id=$_POST['pegawai_id'][$j];
//                                                    $modRuanganPegawai->save();
//                                                }
//                                        }
//                                        
//                                        
//                                        
//                                        
//                                         Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
//                                         $transaction->commit();
//                                         $this->redirect(array('admin','id'=>$model->ruangan_id));
//                                }   
//                            catch (Exception $e)
//                                {
//                                    $transaction->rollback();
//                                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
//                                }   
//			
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//                        'modKasusPenyakitRuangan'=>$modKasusPenyakitRuangan,
//                        'modKelasRuangan'=>$modKelasRuangan,
//                        'modTindakanRuangan'=>$modTindakanRuangan,
//                        'modRuanganPegawai'=>$modRuanganPegawai,
//                        'modRiwayatRuangan'=>$modRiwayatRuangan
//		));
//	}

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
                     $transaction = Yii::app()->db->beginTransaction();
                     try {
                         TindakanruanganM::model()->deleteAll('ruangan_id='.$id.''); 
//                            $this->loadModel($id)->delete(); 
                            $transaction->commit();
                         }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
                                }   
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
		$dataProvider=new CActiveDataProvider('HDRuanganM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                                         
		$model=new HDRuanganM('search');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
//		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HDRuanganM'])){
			$model->attributes=$_GET['HDRuanganM'];
            $model->ruangan_nama = $_GET['HDRuanganM']['ruangan_nama'];
            $model->kategoritindakan_nama = $_GET['HDRuanganM']['kategoritindakan_nama'];
            $model->daftartindakan_kode = $_GET['HDRuanganM']['daftartindakan_kode'];
            $model->daftartindakan_nama = $_GET['HDRuanganM']['daftartindakan_nama'];
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
		$model=HDRuanganM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='saruangan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionPrint()
        {
                                                
            $model= new HDRuanganM();
//            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
//            $model->attributes=$_REQUEST['HDRuanganM'];
            
//            echo "<pre>";print_r($_REQUEST['HDRuanganM']);print_r($model->attributes);exit;
            $judulLaporan='Laporan Ruangan';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') { 
                $this->layout='//layouts/printWindows'; 
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint)); 
            }
            else if($caraPrint=='EXCEL') { 
                Yii::app()->bootstrap->coreCss = false;
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->mirrorMargins = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
		
		public function actionGetRiwayatRuangan() {
			if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id=$_POST['instalasi_id'];
		   $sql="SELECT 
				 riwayatruangan_r.tglpenetapanruangan, 
				 riwayatruangan_r.nopenetapanruangan, 
				 riwayatruangan_r.tentangpenetapan, 
				 instalasi_m.instalasi_id, 
				 instalasi_m.instalasi_nama
			   FROM 
				 public.instalasi_m, 
				 public.riwayatruangan_r
			   WHERE 
				 instalasi_m.riwayatruangan_id = riwayatruangan_r.riwayatruangan_id
				 AND instalasi_m.instalasi_id=".$instalasi_id."";
		   $riwayatRuangan=Yii::app()->db->createCommand($sql)->query();
		   foreach($riwayatRuangan AS $tampil):
			   $data['tglpenetapanruangan']=$tampil['tglpenetapanruangan'];
			   $data['nopenetapanruangan']=$tampil['nopenetapanruangan'];
			   $data['tentangpenetapan']=$tampil['tentangpenetapan'];

		   endforeach;

		   echo json_encode($data);
			Yii::app()->end();
		   }
	   }
}
