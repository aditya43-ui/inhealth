
<?php

class NursestationMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';

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
		$model = new SANursestationM;
		$model->nursestation_akitf = true;
		$modelnursekamar = array();
		if(isset($_POST['SANursestationM']))
		{
			$model->attributes = $_POST['SANursestationM'];
			if($model->save()){
				
				if(isset($_POST['ruangan_id'])){
					foreach ($_POST['ruangan_id'] as $value){
						$kamarnurse = new SANursestationruanganM;
						$kamarnurse->ruangan_id = $value;
						$kamarnurse->nursestation_id = $model->nursestation_id;
						$kamarnurse->save();
					}
				}
				
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->nursestation_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelnursekamar'=>$modelnursekamar,
		));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$modelnursekamar = array();
		// Uncomment the following line if AJAX validation is needed
		if(!empty($model->nursestation_pj_id)){
			$pegawai = PegawaiM::model()->findByPk($model->nursestation_pj_id);
			$model->nama_pj = $pegawai->nama_pegawai;
		}
		$modelnursekamar = SANursestationruanganM::model()->findAll('nursestation_id='.$model->nursestation_id);
		if(isset($_POST['SANursestationM']))
		{
			$model->attributes = $_POST['SANursestationM'];
			if($model->save()){
				
				$hapusNurseKamar=  SANursestationruanganM::model()->deleteAll('nursestation_id='.$model->nursestation_id); 
				if(isset($_POST['ruangan_id'])){
					foreach ($_POST['ruangan_id'] as $value){
						$kamarnurse = new SANursestationruanganM;
						$kamarnurse->ruangan_id = $value;
						$kamarnurse->nursestation_id = $model->nursestation_id;
						$kamarnurse->save();
					}
				}
				
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->nursestation_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelnursekamar'=>$modelnursekamar,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$model = $this->loadModel($id);
			
			if($model->delete()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}
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
			 $model->nursestation_akitf = 0;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('SANursestationM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new SANursestationM('search');
		$model->unsetAttributes();  // clear any default values
		$model->nursestation_akitf = true;
		if(isset($_GET['SANursestationM'])){
			$model->attributes = $_GET['SANursestationM'];
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
		$model = SANursestationM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nursestation-m-form')
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
		$model = new SANursestationM;
		$model->attributes = $_REQUEST['SANursestationM'];
		$judulLaporan='Data Nurse Station';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			ob_get_clean();
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			// $mpdf->mirrorMargins = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
	
	/**
	 * untuk autocomplete pegawai
	 */
	public function actionAutocompletePegawai()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->addCondition("pegawai_aktif = TRUE");
			$criteria->limit=5;
			$models = SAPegawaiM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->NamaLengkap;
				$returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
}
