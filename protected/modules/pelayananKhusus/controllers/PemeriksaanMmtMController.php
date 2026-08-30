<?php

class PemeriksaanMmtMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
 	public $defaultAction = 'admin';
	public $path_view = 'rehabMedis.views.pemeriksaanMmtM.';

	public function actionAdmin()
	{
		$model = new RMPemeriksaanmmtM('search');
		$model->unsetAttributes();  // clear any default values
		$model->pemeriksaanmmt_aktif = 1;

		if(isset($_GET['RMPemeriksaanmmtM']))
			$model->attributes=$_GET['RMPemeriksaanmmtM'];

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model = new RMPemeriksaanmmtM;
		$oriPemeriksaan = RMPemeriksaanmmtM::model()->findAll();
		$model->urutan = (count($oriPemeriksaan)+1);

		if(isset($_POST['RMPemeriksaanmmtM']))
		{
			$model->attributes=$_POST['RMPemeriksaanmmtM'];
			$model->pemeriksaanmmt_aktif = 1;
			$model->create_time = date('Y-m-d H:i:s');
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->create_loginpemakai_id = Yii::app()->user->id;

			if($model->save()){
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->pemeriksaanmmt_id));
      }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['RMPemeriksaanmmtM']))
		{
			$model->attributes=$_POST['RMPemeriksaanmmtM'];
			$model->update_time = date('Y-m-d H:i:s');
			$model->update_loginpemakai_id = Yii::app()->user->id;

			if($model->save()){
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
      }
		}

		$this->render($this->path_view.'update',array(
			'model'=>$model,
		));
	}

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

	public function actionDelete()
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
            $this->loadModel($id)->delete();
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
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionRemoveTemporary()
	{

			$id = $_POST['id'];
			if(isset($_POST['id']))
			{
				 $update = RMPemeriksaanmmtM::model()->updateByPk($id,array('pemeriksaanmmt_aktif'=>false));
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

	public function loadModel($id)
	{
		$model= RMPemeriksaanmmtM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rmpemeriksaanmmt-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionPrint()
    {
        $model= new RMPemeriksaanmmtM;

				if(isset($_REQUEST['RMPemeriksaanmmtM'])){
						$model->attributes=$_REQUEST['RMPemeriksaanmmtM'];
				}

        $judulLaporan='Data Master MMT';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output();
        }
    }
}
