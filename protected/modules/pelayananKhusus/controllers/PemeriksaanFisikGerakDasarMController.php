<?php

class PemeriksaanFisikGerakDasarMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
 	public $defaultAction = 'admin';
	public $path_view = 'rehabMedis.views.pemeriksaanFisikGerakDasarM.';

	public function actionAdmin()
	{
		$model = new RMPeriksafungsigerakdasarM('search');
		$model->unsetAttributes();  // clear any default values
		$model->periksafungsigerakdasar_aktif = 1;

		if(isset($_GET['RMPeriksafungsigerakdasarM']))
			$model->attributes=$_GET['RMPeriksafungsigerakdasarM'];

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model = new RMPeriksafungsigerakdasarM;
		$oriPemeriksaan = RMPeriksafungsigerakdasarM::model()->findAll();
		$model->periksafungsigerakdasar_urutan = (count($oriPemeriksaan)+1);

		if(isset($_POST['RMPeriksafungsigerakdasarM']))
		{
			$model->attributes=$_POST['RMPeriksafungsigerakdasarM'];
			$model->periksafungsigerakdasar_aktif = 1;
			$model->create_time = date('Y-m-d H:i:s');
			$model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
			$model->create_loginpemakai_id = Yii::app()->user->id;

			if($model->save()){
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
      }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['RMPeriksafungsigerakdasarM']))
		{
			$model->attributes=$_POST['RMPeriksafungsigerakdasarM'];
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
				 $update = RMPeriksafungsigerakdasarM::model()->updateByPk($id,array('periksafungsigerakdasar_aktif'=>false));
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
		$model= RMPeriksafungsigerakdasarM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rmpemeriksaanfisikgerakdasar-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionPrint()
    {
        $model= new RMPeriksafungsigerakdasarM;

				if(isset($_REQUEST['RMPeriksafungsigerakdasarM'])){
						$model->attributes=$_REQUEST['RMPeriksafungsigerakdasarM'];
				}

        $judulLaporan='Data Pemeriksaan Fisik Gerak Dasar';
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
