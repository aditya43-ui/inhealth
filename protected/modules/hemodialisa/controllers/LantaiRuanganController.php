<?php

class LantaiRuanganController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'admin';
    public $lookupTersimpan = true;

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
    	$model=new HDLookupM;
        $model->lookup_type = 'lantai_ruangan_hd';
        $modDetail=new HDLookupM;
        if(isset($_POST['HDLookupM']))
        {
//            var_dump($_POST['lookup_type']);die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
//                $lookup_type = 'lantai_ruangan_id';
                $this->simpanLookup($_POST['lookup_type'],$_POST['HDLookupM']);
                if ($this->lookupTersimpan){
                    $transaction->commit();
                    $this->redirect(array('admin','sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!!'.CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!!!'.MyExceptionMessage::getMessage($exc));
            }
        }   
		$this->render('create',array(
			'model'=>$model,
                        'modDetail'=>$modDetail
		));
    }
    
 

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
	$model=$this->loadModel($id);
        $model->lookup_type = 'lantai_ruangan_hd';
        $modDetail=new HDLookupM;
        if(isset($_POST['HDLookupM']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->updateLookup($_POST['lookup_type'],$_POST['HDLookupM']);
//                echo "<pre>";
//				print_r($_POST['SALookupM']);exit;
		if ($this->lookupTersimpan){
                    $transaction->commit();
                    $this->redirect(array('admin','sukses'=>1));
                }else{
                    $transaction->rollback();
                    echo "hahah";exit();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
              //  echo "string";exit();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!'.MyExceptionMessage::getMessage($exc));
            }
        }    

		$this->render('update',array(
			'model'=>$model,
                        'modDetail'=>$modDetail
		));
    }
    
    /**
     * Memanggil dan menonaktifkan status 
     */
    public function actionNonActive($id)
    {
            if(Yii::app()->request->isAjaxRequest)
            {
                    $data['sukses'] = 0;
                    $model = $this->loadModel($id);
                    // set non-active this
                    // example: 
                     $model->lookup_aktif = 0;
                     if($model->save()){
                            $data['sukses'] = 1;
                     }
                    echo CJSON::encode($data); 
            }
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
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if($this->loadModel($id)->delete()){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

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
        $dataProvider=new CActiveDataProvider('HDLookupM');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
                
        $model=new HDLookupM('search');
        
//        $model->unsetAttributes();  // clear any default values
//        $model->nama_lantai = $model->lookup_name;
        if(isset($_GET['HDLookupM']))
            $model->attributes=$_GET['HDLookupM'];
//            $model->lookup_name = $_GET['HDLookupM']['nama_lantai'];

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
        $model=HDLookupM::model()->findByPk($id);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='salookup-m-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function simpanLookup($lookup_type, $post){
        foreach ($post as $i => $lookup) {
//            var_dump($lookup);die;
            if(empty($lookup['lookup_id'])){
                $model= new HDLookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
//                $model->lookup_name = $lookup[$i]['lookup_name'];
//                $model->lookup_value = $lookup[$i]['lookup_value'];
//                $model->lookup_urutan = $lookup[$i]['lookup_urutan'];
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan =  Yii::app()->user->getState('ruangan_id');
                
                if(!$model->save()){
                    $this->lookupTersimpan &= false;
                }
            }
        }
    }

    public function updateLookup($lookup_type, $post){
        foreach ($post as $i => $lookup) {
			
            if(!empty($lookup['lookup_id'])){
                $model= new HDLookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
                HDLookupM::model()->updateByPk($lookup['lookup_id'],array(
                    'lookup_name'=>$model->lookup_name,
                    'lookup_value'=>$model->lookup_value,
                    'lookup_kode'=>$model->lookup_kode,
                    'lookup_urutan'=>$model->lookup_urutan,
                    'lookup_aktif'=>$model->lookup_aktif
                ));
            } else {
                $model= new HDLookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
                $model->lookup_aktif = true;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->save();
            }
        }
    }
	
    public function actionPrint()
    {
        $model= new HDLookupM;
        $model->attributes=$_REQUEST['HDLookupM'];
        $judulLaporan='Data HDLookupM';
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

    public function actionGetLookup()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new HDLookupM;
            $data['form'] = "";
            $models = $this->loadModelByType($_POST['lookup_type']);
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    $data['form'] .= $this->renderPartial('_rowLookup',array('model'=>$model),true);
                }
            }else{
                $data['form'] .= $this->renderPartial('_rowLookup',array('model'=>$model),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    private function loadModelByType($lookup_type){
        $model = HDLookupM::model()->findAllByAttributes(array('lookup_type'=>$lookup_type),array('order'=>'lookup_urutan'));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}