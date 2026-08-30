<?php
/**
 * Controller untuk Master UMBNS
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.gudangUmum
 * @subpackage controllers
 * @category controller
 */
class MasterUmdnsController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view='gudangUmum.views.masterUmdns.';
	public $path_tips='gudangUmum.views.tips.';
        
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
		$model=new GUUmdnsM;
               

		if(isset($_POST['GUUmdnsM']))
		{
			$model->attributes=$_POST['GUUmdnsM'];
            $model->create_time = date('Y-m-d');
            $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $model->update_time = date('Y-m-d');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->umdns_id));
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
	public function actionUpdate($id) {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
            $model = $this->loadModel($id);
            if ($model->umdns_aktif == false) {
                $model->umdns_aktif = 0;
            } else {
                $model->umdns_aktif = 1;
            }
            // Uncomment the following line if AJAX validation is needed


            if (isset($_POST['GUUmdnsM'])) {
                $model->attributes = $_POST['GUUmdnsM'];
                $status_aktif = $_POST['GUUmdnsM']['umdns_aktif'];
                if ($status_aktif == 0) {
                    $model->umdns_aktif = false;
                } else {
                    $model->umdns_aktif = true;
                }
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin', 'id' => $model->umdns_id));
                }
            }

            $this->render($this->path_view . 'update', array(
                'model' => $model,
            ));
        }

        /**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('GUUmdnsM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new GUUmdnsM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GUUmdnsM']))
			$model->attributes=$_GET['GUUmdnsM'];

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
		$model=GUUmdnsM::model()->findByPk($id);
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
        public function actionDelete($id) {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                $this->loadModel($id)->delete();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus.');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        /**
         * Cetak master UMDNS
         */
        public function actionPrint() {
            $model = new GUUmdnsM;
            if (isset($_REQUEST['GUUmdnsM'])) {
                $model->attributes = $_REQUEST['GUUmdnsM'];
            }
            $judulLaporan = 'Data Universal Medical Device Nomenclature System';
            $caraPrint = $_REQUEST['caraPrint'];
            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
                $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
            } else if ($caraPrint == 'EXCEL') {
                $this->layout = '//layouts/printExcel';
                $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
            } else if ($_REQUEST['caraPrint'] == 'PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('', $ukuranKertasPDF);
                $mpdf->useOddEven = 2;
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet, 1);
                $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
                $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
            }
        }

}
