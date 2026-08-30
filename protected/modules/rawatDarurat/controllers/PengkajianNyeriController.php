
<?php

class PengkajianNyeriController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "rawatDarurat.views.pengkajianNyeri.";

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($pendaftaran_id, $id)
	{
        $this->layout = "//layouts/iframe";
        
        $model = null;
        if (!empty($id)) {
            $model = PengkajiannyeriT::model()->findByPk($id);
        }
        if (empty($model)) {
            echo "Data tidak ditemukan";
            Yii::app()->end();
        } else {
            $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $model->deskripsinyeri_kualitasnyeri = CJSON::decode($model->deskripsinyeri_kualitasnyeri);
            $model->deskripsinyeri_frekuensinyeri = CJSON::decode($model->deskripsinyeri_frekuensinyeri);
        }
        
        $model->waktupengkajian = MyFormatter::formatDateTimeForUser($model->waktupengkajian);
        
        
		$this->render($this->path_view.'view',array(
				'model'=>$model, 'daftar'=>$daftar, 'pendaftaran_id'=>$pendaftaran_id,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($pendaftaran_id, $id=null)
	{
        $this->layout = "//layouts/iframe";
        
        $daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        
        $model = null;
        if (!empty($id)) {
            $model = PengkajiannyeriT::model()->findByPk($id);
        }
        if (empty($model)) {
            $model = new PengkajiannyeriT;
            $model->pendaftaran_id = $daftar->pendaftaran_id;
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->waktupengkajian = date('Y-m-d H:i:s');
        } else {
            $model->deskripsinyeri_kualitasnyeri = CJSON::decode($model->deskripsinyeri_kualitasnyeri);
            $model->deskripsinyeri_frekuensinyeri = CJSON::decode($model->deskripsinyeri_frekuensinyeri);
        }
        
        $model->waktupengkajian = MyFormatter::formatDateTimeForUser($model->waktupengkajian);

		if(isset($_POST['PengkajiannyeriT']))
		{
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            
            try {
                
                $model->attributes = $_POST['PengkajiannyeriT'];
                $model->deskripsinyeri_kualitasnyeri = CJSON::encode($model->deskripsinyeri_kualitasnyeri);
                $model->deskripsinyeri_frekuensinyeri = CJSON::encode($model->deskripsinyeri_frekuensinyeri);
                $model->waktupengkajian = MyFormatter::formatDateTimeForDb($model->waktupengkajian);
                
                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                }
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }
                
                PengkajiannyeriskalaflaccsT::model()->deleteAllByAttributes(array(
                    'pengkajiannyeri_id'=>$model->pengkajiannyeri_id,
                ));
                
                if (isset($_POST['PengkajiannyeriskalaflaccsT'])) {
                    foreach ($_POST['PengkajiannyeriskalaflaccsT'] as $item) {
                        if (!isset($item['skalanyeriflaccs_id']) || !isset($item['ispilih']) || $item['ispilih'] == 0) {
                            continue;
                        }
                        $det = new PengkajiannyeriskalaflaccsT;
                        $det->pengkajiannyeri_id = $model->pengkajiannyeri_id;
                        $det->skalanyeriflaccs_id = $item['skalanyeriflaccs_id'];
                        
                        $ok = $ok && $det->save();
                        // $det->skalanyeriflaccs_id = $item['kat_skalanyeri_id'];
                        
//                        var_dump($det->attributes);
                    }
                }
                
                PengkajiannyeriskalabpsT::model()->deleteAllByAttributes(array(
                    'pengkajiannyeri_id'=>$model->pengkajiannyeri_id,
                ));
                PengkajiannyeriskalanipsT::model()->deleteAllByAttributes(array(
                    'pengkajiannyeri_id'=>$model->pengkajiannyeri_id,
                ));
                if (isset($_POST['PengkajiannyeriskalabpsT']['bpstv'])) {
                    foreach ($_POST['PengkajiannyeriskalabpsT']['bpstv'] as $param => $item) {
                        $det = new PengkajiannyeriskalabpsT;
                        $det->attributes = $model->attributes;
                        $det->attributes = $item;
                        $det->pengkajiannyeri_id = $model->pengkajiannyeri_id;
                        $det->parameter = $param;
                        $det->ispakaiventilator = false;
                        
                        $ok = $ok && $det->save();
                        
//                        var_dump($det->attributes, $det->errors);
                        
                    }
                }
                if (isset($_POST['PengkajiannyeriskalabpsT']['bpst'])) {
                    foreach ($_POST['PengkajiannyeriskalabpsT']['bpst'] as $param => $item) {
                        $det = new PengkajiannyeriskalabpsT;
                        $det->attributes = $model->attributes;
                        $det->attributes = $item;
                        $det->pengkajiannyeri_id = $model->pengkajiannyeri_id;
                        $det->parameter = $param;
                        $det->ispakaiventilator = true;
                        
                        $ok = $ok && $det->save();
                        
//                        var_dump($det->attributes, $det->errors);
                        
                    }
                }
                if (isset($_POST['PengkajiannyeriskalanipsT']['nips'])) {
                    foreach ($_POST['PengkajiannyeriskalanipsT']['nips'] as $param => $item) {
                        $det = new PengkajiannyeriskalanipsT;
                        $det->attributes = $model->attributes;
                        $det->attributes = $item;
                        $det->pengkajiannyeri_id = $model->pengkajiannyeri_id;
                        $det->parameter = $param;
                        
                        
                        $ok = $ok && $det->save();
                        
//                        var_dump($det->attributes, $det->errors, $param, $item);
                        
                    }
                }
                
                
                
//                var_dump($ok, $model->attributes, $_POST);
//                die;
                if($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('create','pendaftaran_id'=>$pendaftaran_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""),'sukses'=>1));       
                } else {
                    //var_dump($modFisik->getErrors());die;
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data pengkajian nyeri gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data pengkajian nyeri gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['PengkajiannyeriT']))
		{
			$model->attributes = $_POST['PengkajiannyeriT'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pengkajiannyeri_id));
			}
		}

		$this->render($this->path_view.'update',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            
            PengkajiannyeriskalaflaccsT::model()->deleteAllByAttributes(array(
                'pengkajiannyeri_id'=>$id,
            ));
            
            PengkajiannyeriskalabpsT::model()->deleteAllByAttributes(array(
                'pengkajiannyeri_id'=>$id,
            ));
            PengkajiannyeriskalanipsT::model()->deleteAllByAttributes(array(
                'pengkajiannyeri_id'=>$id,
            ));
            
            $deleteData = PengkajiannyeriT::model()->deleteByPk($id);

            $message = "";
            $sukses = 0;

            if($deleteData){
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            }else{
                $message = "Data gagal Dihapus!";
                $sukses = 0;
            }

            echo CJSON::encode(array(
                    'sukses'=> $sukses,
                    'msg'=>$message,
                    ));
            exit;
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
		$dataProvider = new CActiveDataProvider('PengkajiannyeriT');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new PengkajiannyeriT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PengkajiannyeriT'])){
			$model->attributes = $_GET['PengkajiannyeriT'];
		}
		$this->render($this->path_view.'admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = PengkajiannyeriT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pengkajiannyeri-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint($pasien_id)
	{
		$model = new PengkajiannyeriT;
        $model->pasien_id = $pasien_id;
        if (isset($_GET['PengkajiannyeriT'])) {
            $model->attributes = $_GET['PengkajiannyeriT'];

            $model->tgl_awal_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_kaji']);
            $model->tgl_akhir_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_kaji']);

            if (isset($_GET['PengkajiannyeriT']['is_ceklis']) && $_GET['PengkajiannyeriT']['is_ceklis'] == 1) {
                $model->is_ceklis = $_GET['PengkajiannyeriT']['is_ceklis'];
                $model->tgl_awal_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_daftar']);
                $model->tgl_akhir_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_daftar']);
            }
        }
		$judulLaporan='PENGKAJIAN NYERI';
        
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			// $mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
    
    public function actionVerifikasi() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data pengkajian berhasil diverifikasi.";
        
        try {
            PengkajiannyeriT::model()->updateByPk($_POST['verifikasi']['nyeri_id'], array(
                'isverifikasipetugas'=>true,
                'verifikasipetugas_tanggal'=>MyFormatter::formatDateTimeForDB($_POST['verifikasi']['verifikasipetugas_tanggal']),
                'verifikasipetugas_catatan'=>$_POST['verifikasi']['verifikasipetugas_catatan'],
            ));
            $trans->commit();
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data pengkajian gagal diverifikasi. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok, 'msg'=>$msg
        ));
    }
}
