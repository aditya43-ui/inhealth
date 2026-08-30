
<?php

class GrafikTandaVitalController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'create';
	public $path_view = 'rawatInap.views.grafikTandaVital.';

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
	public function actionCreate($pendaftaran_id, $id = null)
	{
		
        $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
		));

		if(empty($kunjungan)) {
			$kunjungan = PendaftaranT::model()->findByPk($pendaftaran_id);
		}
        
		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD){
			$kunjungan = InfokunjunganrdV::model()->findByAttributes(array(
				'pendaftaran_id'=>$pendaftaran_id,
			));
			$kunjungan->pasienadmisi_id = null;
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
			$kunjungan = InfokunjunganrjV::model()->findByAttributes(array(
				'pendaftaran_id'=>$pendaftaran_id,
			));
			$kunjungan->pasienadmisi_id = null;
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
			$kunjungan = InfokunjunganpersalinanV::model()->findByAttributes(array(
				'pendaftaran_id'=>$pendaftaran_id,
			));
			$kunjungan->pasienadmisi_id = null;
		}

		if(empty($kunjungan)) {


		}
 
        if (!empty($id)) {
            $model = GrafiktandavitalT::model()->findByPk($id);
            if (empty($model)) {
                $model = new GrafiktandavitalT;
                $model->pendaftaran_id = $kunjungan->pendaftaran_id;
                $model->pasienadmisi_id = $kunjungan->pasienadmisi_id;
            }
        } else {
            $model = new GrafiktandavitalT;
            $model->pendaftaran_id = $kunjungan->pendaftaran_id;
            $model->pasienadmisi_id = $kunjungan->pasienadmisi_id;
        }
        
        if (!empty($model->tglmonitoring)) {
            $model->tglmonitoring = MyFormatter::formatDateTimeForUser($model->tgl_monitoring);
        }
        if (!empty($model->petugaspengisi)) {
            $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
        }
        
		$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$kunjungan->pendaftaran_id,
            'pasienadmisi_id'=>$kunjungan->pasienadmisi_id,
        ), array(
            'order'=>'tgl_monitoring desc, jam_monitoring',
        ));


        if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$pendaftaran_id,
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$kunjungan->pendaftaran_id,
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$kunjungan->pendaftaran_id,
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}

		if(isset($_POST['GrafiktandavitalT']))
		{
			$model->attributes = $_POST['GrafiktandavitalT'];
            $model->tgl_monitoring = MyFormatter::formatDateTimeForDB($model->tgl_monitoring);
            $model->pasienadmisi_id = $model->pasienadmisi_id == 0 ? null : $model->pasienadmisi_id;
            
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;
            
			// if($model->save()){
			// 	Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
			// 	$this->redirect(array('create','pendaftaran_id'=>$model->pendaftaran_id, 'type'=> $_GET['type'], 'frame'=> $_GET['frame']));
			// }

			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('create','pendaftaran_id'=>$model->pendaftaran_id));
			}
		}

		$this->render($this->path_view .'create',array(
			'model'=>$model,
            'riwayat'=>$riwayat,
		));
	}

	public function actionAjaxDetail() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
			$model = GrafiktandavitalT::model()->findByPk($id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetail', array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                    ), true);

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
		

		if(isset($_POST['GrafiktandavitalT']))
		{
			$model->attributes = $_POST['GrafiktandavitalT'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->grafiktandavital_id, 'type'=> $_GET['type'], 'frame'=> $_GET['frame']));
			}
		}

		$this->render($this->path_view .'update',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
        $ok = 1;
        $msg = "Data berhasil dihapus";
		if(Yii::app()->request->isAjaxRequest)
		{
            $id = $_POST['id'];
            
            try {
                // we only allow deletion via POST request
                $this->loadModel($id)->delete();
                
            } catch (Exception $ex) {
                $ok = 0;
                $msg = "Data gagal dihapus. ".$ex->getMessage();

            }
            
		} else {
			$ok = 0;
            $msg = "Data gagal dihapus";
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg
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
		$dataProvider = new CActiveDataProvider('GrafiktandavitalT');
		$this->render($this->path_view .'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new GrafiktandavitalT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GrafiktandavitalT'])){
			$model->attributes = $_GET['GrafiktandavitalT'];
		}
		$this->render($this->path_view .'admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = GrafiktandavitalT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='grafiktandavital-t-form')
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
		$model = new GrafiktandavitalT;
		$model->attributes = $_REQUEST['GrafiktandavitalT'];
		$judulLaporan='Data GrafiktandavitalT';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view .'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view .'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view .'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
    
    public function actionPrintGrafik($id)
	{
		$model = new GrafiktandavitalT;
		//$model->attributes = $_REQUEST['GrafikbayiT'];
		$judulLaporan='Data Grafik Tanda Vital';
		$modPendaftaran = PendaftaranT::model()->findByPk($id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		//echo print_r($modPasien).exit();
		$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$id,
            'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,
        ), array(
            'order'=>'tgl_monitoring, jam_monitoring',
		));

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$id,
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$id,
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}

		if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
			$riwayat = GrafiktandavitalT::model()->findAllByAttributes(array(
				'pendaftaran_id'=>$id
			), array(
				'order'=>'tgl_monitoring, jam_monitoring',
			));
		}
		
		$this->layout = '//layouts/printWindows';
		$this->render($this->path_view .'PrintGrafik',array(
			'model'=>$model,
			'judulLaporan'=>$judulLaporan, 
			'riwayat'=>$riwayat, 
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=> $modPasien));
		
	}
}
