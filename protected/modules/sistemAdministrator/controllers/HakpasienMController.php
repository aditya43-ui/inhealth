
<?php

class HakpasienMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';

	public $path_view = 'sistemAdministrator.views.hakpasienM.';

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate()
	{
		$model = new HakpasienM;

		if(isset($_POST['HakpasienM']))
		{
			$model->attributes = $_POST['HakpasienM'];
			$model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionGetKelompok()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$model = new HakpasienM;
			$data=array();
			$kel =$_POST['kel'];
		
			$criteria=new CDbCriteria;
			
		    $criteria->addCondition("lower(kelompok) = '".strtolower($kel)."' ");			
			
			$criteria->order = "hakpasien_urutan DESC";
			
			$hak = HakpasienM::model()->find($criteria);
			$data['data']= $hak->hakpasien_urutan+1;

			echo json_encode($data);
			Yii::app()->end();
		}
	}
	

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['HakpasienM']))
		{
			$model->attributes = $_POST['HakpasienM'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
			// $model->modelaktif = false;
			// if($model->save()){
			//	$data['sukses'] = 1;
			// }
			echo CJSON::encode($data); 
		}
	}

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('HakpasienM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new HakpasienM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HakpasienM'])){
			$model->attributes = $_GET['HakpasienM'];
		}
		$this->render('admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = HakpasienM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='hakpasien-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new HakpasienM;
		$model->attributes = $_REQUEST['HakpasienM'];
		//$model->hakpasien_aktif = $_REQUEST['HakpasienM']['hakpasien_aktif'];
		$judulLaporan = 'Data Hak & Kewajiban Pasien';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
		  $this->layout = '//layouts/printWindows';
		  $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
		  $this->layout = '//layouts/printExcel';
		  $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
		  $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
		  $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
		  $mpdf = new MyPDF60('', $ukuranKertasPDF);
		  ////$mpdf->useOddEven = 2;  
		  $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		  $mpdf->WriteHTML($stylesheet, 1);
		  $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
		  $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
		  $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
		}
	}
}
