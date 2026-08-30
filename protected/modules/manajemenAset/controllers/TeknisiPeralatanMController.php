<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php

class TeknisiPeralatanMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/iframe';Umdns
	public $defaultAction = 'admin';
	public $path_view='manajemenAset.views.teknisiPeralatanM.';
	public $path_tips='manajemenAset.views.tips.';
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $modSertifikat = SertifikatteknisiM::model()->findAllByAttributes(array('teknisiperalatan_id'=>$id));
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
            'modSertifikat'=>$modSertifikat,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new TeknisiperalatanM();
		$modSertifikat=new SertifikatteknisiM();
               
        $transaction = Yii::app()->db->beginTransaction();
		if(isset($_POST['TeknisiperalatanM']))
		{
            $model->attributes=$_POST['TeknisiperalatanM'];
            $model->tgllahir = MyFormatter::formatDateTimeForDb($_POST['TeknisiperalatanM']['tgllahir']);
            if($model->save()){
                foreach($_POST['SertifikatteknisiM'] AS $i => $postDetail){
                    $modDetails[$i] = new SertifikatteknisiM();
                    $modDetails[$i]->attributes = $postDetail;
                    $modDetails[$i]->berlaku_sd = MyFormatter::formatDateTimeForDb($postDetail['berlaku_sd']);
                    $modDetails[$i]->teknisiperalatan_id = $model->teknisiperalatan_id;
                    $modDetails[$i]->create_time = date('Y-m-d');
                    $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                    $modDetails[$i]->update_time = date('Y-m-d');
                    $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modDetails[$i]->file_sertifikat = CUploadedFile::getInstance($modSertifikat, '['.$i.']file_sertifikat');
                    if(!empty($modDetails[$i]->file_sertifikat)){
                        $file = $modDetails[$i]->file_sertifikat;
                        if(!empty($modDetails[$i]->file_sertifikat))
                        { 
                               $fullImgName =$modDetails[$i]->file_sertifikat;   
                               $fullImgSource = ParamsUrl::pathSertifikatTeknisiDirectory().$fullImgName;

                          }
                          
                          if (!file_exists( ParamsUrl::pathSertifikatTeknisiDirectory())){
                                mkdir( ParamsUrl::pathSertifikatTeknisiDirectory(),0775, true);
                            }
                        $file->saveAs($fullImgSource);
                    }
                    $modDetails[$i]->save();
                    if(!$modDetails[$i]->save()){
                        $transaction->rollback();
                       
                    }
                }
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin','id'=>$model->teknisiperalatan_id));
            }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
            'modSertifikat'=>$modSertifikat,
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
        $supplier = SupplierM::model()->findByPk($model->supplier_id);
        $model->supplier_nama = $supplier->supplier_nama;
        $kabupaten = KabupatenM::model()->findByPk($model->kabupaten_id);
        $model->kabupaten_nama = $kabupaten->kabupaten_nama;
        $model->tgllahir = MyFormatter::formatDateTimeForUser($model->tgllahir);
        $modSertifikat = SertifikatteknisiM::model()->findAllByAttributes(array('teknisiperalatan_id'=>$id));
        $transaction = Yii::app()->db->beginTransaction();
        if(isset($_POST['TeknisiperalatanM']))
		{
			$model->attributes=$_POST['TeknisiperalatanM'];
            $model->tgllahir = MyFormatter::formatDateTimeForDb($_POST['TeknisiperalatanM']['tgllahir']);
			if($model->save()){
                if(isset($_POST['SertifikatteknisiM'])){
                $modSertifikat = new SertifikatteknisiM();
                foreach($_POST['SertifikatteknisiM'] AS $i => $postDetail){
                    //dilakukan pengecekan apakah termassuk data sertifikat baru atau lama
                    if($postDetail['sertifikatteknisi_id'] == NULL){
                        //jika data sertifikat baru maka membuat record baaru
                        $modDetails[$i] = new SertifikatteknisiM();
                        $modDetails[$i]->attributes = $postDetail;
                        $modDetails[$i]->berlaku_sd = MyFormatter::formatDateTimeForDb($postDetail['berlaku_sd']);
                        $modDetails[$i]->teknisiperalatan_id = $model->teknisiperalatan_id;
                        $modDetails[$i]->create_time = date('Y-m-d');
                        $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $modDetails[$i]->update_time = date('Y-m-d');
                        $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->file_sertifikat = CUploadedFile::getInstance($modSertifikat, '['.$i.']file_sertifikat');
                        if(!empty($modDetails[$i]->file_sertifikat)){
                            $file = $modDetails[$i]->file_sertifikat;
                            if(!empty($modDetails[$i]->file_sertifikat))
                            { 
                                   $fullImgName =$modDetails[$i]->file_sertifikat;   
                                   $fullImgSource = ParamsUrl::pathSertifikatTeknisiDirectory().$fullImgName;

                              }
                              
                            if (!file_exists( ParamsUrl::pathSertifikatTeknisiDirectory())){
                                mkdir( ParamsUrl::pathSertifikatTeknisiDirectory(),0775, true);
                            }
                              
                            $file->saveAs($fullImgSource);
                        }
                        $modDetails[$i]->save();
                        if(!$modDetails[$i]->save()){
                            $transaction->rollback();

                        }
                    }else{
                        //ketika data sertifikat sudah ada sebelumnya maka , hanya di update biasa
                        $modDetails[$i] = SertifikatteknisiM::model()->findByPk($postDetail['sertifikatteknisi_id']);
                        $modDetails[$i]->attributes = $postDetail;
                        $modDetails[$i]->berlaku_sd = MyFormatter::formatDateTimeForDb($postDetail['berlaku_sd']);
                        $modDetails[$i]->teknisiperalatan_id = $model->teknisiperalatan_id;
                        $modDetails[$i]->create_time = date('Y-m-d');
                        $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $modDetails[$i]->update_time = date('Y-m-d');
                        $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->save();
                        if(!$modDetails[$i]->save()){
                            $transaction->rollback();

                        }
                    }
                    
                }
                }
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin','id'=>$model->teknisiperalatan_id));
                //Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				//$this->redirect(array('admin','id'=>$model->teknisiperalatan_id));
            }
		}

		$this->render($this->path_view.'update',array(
			'model'=>$model,
            'modSertifikat'=>$modSertifikat,
		));
	}

	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TeknisiperalatanM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new TeknisiperalatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TeknisiperalatanM']))
			$model->attributes=$_GET['TeknisiperalatanM'];

		$this->render($this->path_view.'admin',array(
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
		$model=TeknisiperalatanM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='umdns-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    /*public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            //untuk delete semua sertifikat yang bereelasi
            //setelah sertifikat dihapus maka dihapus yang parentnya
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus.');
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }*/
    
    public function actionDelete()
	{         
		if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
            $workorder = WorkorderT::model()->findAllByAttributes(array('teknisiperalatan_id'=>$id));
            if(empty($workorder)){
                $sertifikat = SertifikatteknisiM::model()->deleteAllByAttributes(array('teknisiperalatan_id'=>$id));
                $this->loadModel($id)->delete();
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
            }       
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

     /**
     *Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary()
    {
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = TeknisiperalatanM::model()->updateByPk($id,array('teknisiperalatan_aktif'=>false));
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
    
    public function actionAktifkan()
    {
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = TeknisiperalatanM::model()->updateByPk($id,array('teknisiperalatan_aktif'=>true));
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
        
        public function actionPrint() {
		$model = new TeknisiperalatanM;
		if (isset($_REQUEST['TeknisiperalatanM'])) {
			$model->attributes = $_REQUEST['TeknisiperalatanM'];
		}
		$judulLaporan = 'Data Teknisi Peralatan ';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');				  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');						   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			//$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'colspan'=>10),true));
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
		}
	}
    
    public function actionAutoCompleteSupplier($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $criteria = new CDbCriteria;
        $criteria->compare('lower(supplier_nama)', strtolower($term), true);
        $criteria->addCondition('supplier_aktif = true');
        $criteria->order = 'supplier_nama';
        $criteria->limit = 10;
        
        $model = SupplierM::model()->findAll($criteria);
        $res = array();
        
        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->supplier_nama;
            $sub['value'] = $item->supplier_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    public function actionAutoCompleteKabupaten($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $criteria = new CDbCriteria;
        $criteria->compare('lower(kabupaten_nama)', strtolower($term), true);
        $criteria->addCondition('kabupaten_aktif = true');
        $criteria->order = 'kabupaten_nama';
        $criteria->limit = 10;
        
        $model = KabupatenM::model()->findAll($criteria);
        $res = array();
        
        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->kabupaten_nama;
            $sub['value'] = $item->kabupaten_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    public function actionSetFormSertifikat()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $nomor_sertifikat = $_POST["no_sertifikat_teknisi"];
            $nama_sertifikat = $_POST["nama_sertifikat"];
            $sertifikat_ket = $_POST["sertifikat_ket"];
            $berlaku_sd = $_POST["berlaku_sd"];
            $form = "";
            $pesan = "";
            //$no_sertifikat = $_POST['SertifikatteknisiM']['no_sertifikat_teknisi'];
            $modSertifikat = new SertifikatteknisiM();
            //$modSertifikat->attributes = $_POST['SertifikatteknisiM'];
            $modSertifikat->no_sertifikat_teknisi= $nomor_sertifikat;
            $modSertifikat->nama_sertifikat= $nama_sertifikat;
            $modSertifikat->sertifikat_ket= $sertifikat_ket;
            $modSertifikat->berlaku_sd= $berlaku_sd;
            //$modSertifikat->no_sertifikat_teknisi = $no_sertifikat; 
            $form .= $this->renderPartial($this->path_view.'_rowDetail', array('modSertifikat'=>$modSertifikat), true);
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
    
    public function actionDeleteSertifikat(){
        if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
            $model = SertifikatteknisiM::model()->findByPk($id);
            $model->delete();
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
	                    
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
}
