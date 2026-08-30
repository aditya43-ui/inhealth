<?php
/**
* - digunakan sebagai Admin IPM CHECKLIST
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>


<?php

class IpmChecklistMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view='manajemenAset.views.ipmChecklistM.';
	public $path_tips='manajemenAset.views.tips.';
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
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
		$model=new MAIpmchecklistM;
               

		if(isset($_POST['MAIpmchecklistM']))
		{
			$model->attributes=$_POST['MAIpmchecklistM'];
            $model->create_time = date('Y-m-d');
            $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $model->update_time = date('Y-m-d');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->ipmchecklist_id));
                        }
		}

		$this->render($this->path_view.'create',array(
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
        if($model->ipm_aktif == false){
            $model->ipm_aktif = 0;
        }else{
            $model->ipm_aktif = 1;
        }
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['MAIpmchecklistM']))
		{
			$model->attributes=$_POST['MAIpmchecklistM'];
            $status_aktif = $_POST['MAIpmchecklistM']['ipm_aktif'];
            if($status_aktif==0){
                $model->ipm_aktif= false;
            }else{
                $model->ipm_aktif= true;
            }
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->ipmchecklist_id));
                        }
		}

		$this->render($this->path_view.'update',array(
			'model'=>$model,
		));
	}

	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MAIpmchecklistM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new MAIpmchecklistM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MAIpmchecklistM']))
			$model->attributes=$_GET['MAIpmchecklistM'];

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
		$model=MAIpmchecklistM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ipm-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    /*   public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
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
            $preventif = PreventifmaintenM::model()->findAllByAttributes(array('ipmchecklist_id'=>$id));
            $prevmainten = PrevmaintenT::model()->findAllByAttributes(array('ipmchecklist_id'=>$id));
            $prevmaintendet = PrevmaintendetT::model()->findAllByAttributes(array('ipmchecklist_id'=>$id));
            if($preventif == NULL && $prevmainten == NULL && $prevmaintendet==NULL){
                //var_dump($prevmainten);die();
                $this->loadModel($id)->delete();
                if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                            ));
                        exit;
                    }
            }      else{
                if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'gagal_form', 
                            'div'=>"<div class='flash-success'>Data gagal dihapus.</div>",
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
           $update = MAIpmchecklistM::model()->updateByPk($id,array('ipm_aktif'=>false));
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
		$model = new MAIpmchecklistM;
		if (isset($_REQUEST['MAIpmchecklistM'])) {
			$model->attributes = $_REQUEST['MAIpmchecklistM'];
		}
		$judulLaporan = 'Data IPM Checklist';
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
}

