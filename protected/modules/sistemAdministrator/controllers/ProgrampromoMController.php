<?php

class ProgrampromoMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/iframe';
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
		$model=new SAProgrampromoM;

		// Uncomment the following line if AJAX validation is needed
		
		if(isset($_POST['SAProgrampromoM']))
		{
			$model->attributes=$_POST['SAProgrampromoM'];

			$random = rand(0000000, 9999999);
			$model->gambarpromo = CUploadedFile::getInstance($model, 'gambarpromo');
		// var_dump(CUploadedFile::getInstance($model, 'gambarpromo'));die;
			
			$gambar = $model->gambarpromo;
			if (!empty($model->gambarpromo)) {
				$model->gambarpromo = $random . $model->gambarpromo;
				// var_dump($model->gambarpromo);die;
				Yii::import("ext.EPhpThumb.EPhpThumb");

				$thumb = new EPhpThumb();
				$thumb->init(); //this is needed

				$fullImgName = $model->gambarpromo;
				// var_dump($fullImgName);die;
				$fullImgSource = Params::pathPromoDirectory() . $fullImgName;
				$fullThumbSource = Params::pathPromoTumbsDirectory() . 'kecil_' . $fullImgName;

				$model->gambarpromo = $fullImgName;

				 if ($model->save()) {
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $gambar->saveAs($fullImgSource);
                            $thumb->create($fullImgSource)
                                    ->resize(200, 200)
                                    ->save($fullThumbSource);
                        } else {
                            Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
                        }
			}else{
				 $model->save();
			}

				 $this->redirect(array('admin','id'=>$model->programpromo_id));


                 


			// if($model->save()){
			// 		// Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
			// 		// $gambar->saveAs($fullImgSource);
			// 		// $thumb->create($fullImgSource)
			// 		// 		->resize(200, 200)
			// 		// 		->save($fullThumbSource);
					
			// 	$this->redirect(array('admin','id'=>$model->programpromo_id));
   //                      }
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

		// Uncomment the following line if AJAX validation is needed
		
		$temLogo = $model->gambarpromo;


		if(isset($_POST['SAProgrampromoM']))
		{
		// var_dump(CUploadedFile::getInstance($model, 'gambarpromo'));die;

			$model->attributes=$_POST['SAProgrampromoM'];

		    // if (empty(CUploadedFile::getInstance($model, 'gambarpromo'))) {
      //               $model->gambarpromo = $temLogo;
      //               var_dump('safsfsdfsdf');die;
      //           } else {

      //               $model->gambarpromo = CUploadedFile::getInstance($model, 'gambarpromo');
      //               $gambarpromo = $model->gambarpromo;
      //               var_dump($gambarpromo);die;
                    
      //               $random = rand(0000000, 9999999);
      //               if (isset($model->gambarpromo) && ($model->gambarpromo != $temLogo)) {//jika data lama dan baru tidaksama;
      //                   if (!empty($temLogo)) {
      //                       if (file_exists(Params::pathPromoDirectory() . $temLogo)) {
      //                           unlink(Params::pathPromoDirectory() . $temLogo);
      //                       }
      //                   }
      //                   $model->gambarpromo = strtolower(str_replace(" ", "_", $random . $model->gambarpromo));
      //                   $rand_gambar = $model->gambarpromo;
      //                   $fullImgName = $rand_gambar;
      //                   $fullImgSource = Params::pathPromoDirectory() . $fullImgName;
      //                   $model->gambarpromo = $fullImgName;
      //                   $gambarpromo->saveAs($fullImgSource);
      //               }
      //           }

			
			if($model->validate()){

                    $random = rand(0000000, 9999999);
                    $model->gambarpromo = CUploadedFile::getInstance($model, 'gambarpromo');
                    $gambar = $model->gambarpromo;

                    if (isset($model->gambarpromo) && ($model->gambarpromo != $temLogo)) {
                        // $model->path_logorumahsakit = $random . $model->gambarpromo;
                        // var_dump('safsafsf');die;
                        $model->gambarpromo = $random . $model->gambarpromo;

                        Yii::import("ext.EPhpThumb.EPhpThumb");

                        $fullImgName = $model->gambarpromo;
                        $fullImgSource = Params::pathPromoDirectory() . $fullImgName;
                        $fullThumbSource = Params::pathPromoTumbsDirectory() . 'kecil_' . $fullImgName;

                        if (!isset($model->gambarpromo)) {
                            $model->gambarpromo = $temLogo;
                        } else {
                            $model->gambarpromo = $fullImgName;
                        }

                        if ($model->save()) {
                            if (!empty($temLogo)) {
//                               
                            }


                            $gambar->saveAs($fullImgSource);


            
                        }
                    } else {
                        $model->gambarpromo = $temLogo;
                        $model->save();

                       
                    }
				// $gambar->saveAs($fullImgSource);
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						
					
						$this->redirect(array('admin','id'=>$model->programpromo_id));
             }
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('SAProgrampromoM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SAProgrampromoM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAProgrampromoM']))
			$model->attributes=$_GET['SAProgrampromoM'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
//	public function actionViewCard()
//	{
//                
//		$model=new SAProgrampromoM('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['SAProgrampromoM']))
//			$model->attributes=$_GET['SAProgrampromoM'];
//
//		$this->render('viewtabel',array(
//			'model'=>$model,
//		));
//	}

	public function actionKeterangan($programpromo_id)
	{
		$this->layout='//layouts/iframe';
		$this->render('keterangan',array(
			'model'=>$this->loadModel($programpromo_id),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SAProgrampromoM::model()->findByPk($id);
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
            $model= new SAProgrampromoM;
            $model->attributes=$_REQUEST['SAProgrampromoM'];
            $judulLaporan='Data Program Promo';
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
        
         public function actionViewCard() {
            $this->layout = "//layouts/iframe";

        $model = SAProgrampromoM::model()->findAllByAttributes(array('programpromo_aktif' => true), array(
            'order' => 'namaprogrampromo asc'));
        $item_count = count($model);
        $page_size = 10;
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
       

        $dataProvider = new CActiveDataProvider('SAProgrampromoM', array(
            'criteria' => array(
                'condition' => 'programpromo_aktif=true',
                'order' => 'namaprogrampromo asc',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

      

        $this->render('viewindex', array(
            'model' => $model,
       
            'pages' => $pages,
            
            'dataProvider' => $dataProvider,
            
        ));
    }
    
    public function actionSearchViewCard($q = null) {
        $this->layout = "//layouts/iframe";
        $criteria = new CDbCriteria();
        $criteria->addCondition('programpromo_aktif = true');
        $criteria->condition = "LOWER(namaprogrampromo) like '%" . $q . "%' or LOWER(deskripsi) like '%" . $q . "%'";
        $criteria->order = 'namaprogrampromo desc';
        $criteria->limit = '10';
       
        $model = SAProgrampromoM::model()->findAllByAttributes(array('programpromo_aktif' => true), array(
            'order' => 'namaprogrampromo asc'));

        $item_count = count($model);
        $page_size = 10;
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);

        $dataProvider = new CActiveDataProvider('SAProgrampromoM', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        $this->render('searchviewcard', array(
            'model' => $model,
            'pages' => $pages,
            'dataProvider' => $dataProvider,
            
        ));
    }
}
