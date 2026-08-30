
<?php

class IsiinformasiMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'admin';
    public $path_view = "sistemAdministrator.views.isiinformasiM.";

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
		$model = new IsiinformasiM;

		if(isset($_POST['IsiinformasiM']) && isset($_POST['IsiinformasiM']['jenisinformasi_id']))
		{
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                
                $id = $_POST['IsiinformasiM']['jenisinformasi_id'];
                
                IsiinformasiM::model()->deleteAllByAttributes(array(
                    'jenisinformasi_id'=>$id
                ));
                
                if (isset($_POST['tipe_input'])) {
                    $tipe = $_POST['tipe_input'];
                    
                    if ($tipe == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
                        $ok = $ok && $this->saveDetailInputCheckBox($_POST);
                    } else if ($tipe == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
                        $ok = $ok && $this->saveDetailInputPenjelasan($_POST);
                    } else if ($tipe == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
                        $ok = $ok && $this->saveDetailInputUser($_POST);
                    }
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
            }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}
    
    public function saveDetailInputCheckBox($post) {
        $ok = true;
        
        foreach ($post['detail'] as $item) {
            $model = new IsiinformasiM();
            $model->attributes = $post['IsiinformasiM'];
            $model->attributes = $item;
            
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            if ($model->validate()) {
                $ok = $ok && $model->save();
            } else {
                $ok = false;
            }
        }
        
        return $ok;
    }

    public function saveDetailInputPenjelasan($post) {
        $ok = true;
        
        $model = new IsiinformasiM();
        $model->attributes = $post['IsiinformasiM'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->isiinformasi_urutan = 1;
        
        if ($model->validate()) {
            $ok = $ok && $model->save();
        } else {
            $ok = false;
        }
        
        return $ok;
    }
    
    public function saveDetailInputUser($post) {
        
        $ok = true;
        
        $model = new IsiinformasiM();
        $model->attributes = $post['IsiinformasiM'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->isiinformasi_urutan = 1;
        
        if ($model->validate()) {
            $ok = $ok && $model->save();
        } else {
            $ok = false;
        }
        
        return $ok;
        
    }
    
	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $model->jenissurat_id = $model->jenisinformasi->jenissurat_id;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['IsiinformasiM']) && isset($_POST['IsiinformasiM']['jenisinformasi_id']))
		{
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                // var_dump($_POST); die;
                $id = $_POST['IsiinformasiM']['jenisinformasi_id'];
                
                IsiinformasiM::model()->deleteAllByAttributes(array(
                    'jenisinformasi_id'=>$id
                ));
                
                if (isset($_POST['tipe_input'])) {
                    $tipe = $_POST['tipe_input'];
                    
                    if ($tipe == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
                        $ok = $ok && $this->saveDetailInputCheckBox($_POST);
                    } else if ($tipe == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
                        $ok = $ok && $this->saveDetailInputPenjelasan($_POST);
                    } else if ($tipe == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
                        $ok = $ok && $this->saveDetailInputUser($_POST);
                    }
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
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
		$dataProvider = new CActiveDataProvider('IsiinformasiM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new IsiinformasiM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IsiinformasiM'])){
			$model->attributes = $_GET['IsiinformasiM'];
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
		$model = IsiinformasiM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='isiinformasi-m-form')
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
		$model = new IsiinformasiM;
		$model->attributes = $_REQUEST['IsiinformasiM'];
		$judulLaporan='Data IsiinformasiM';
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
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
    
    public function actionLoadInformasiPenjelasan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        
        $jenis = JenisinformasiM::model()->findByPk($id);
        $isi = IsiinformasiM::model()->findByAttributes(array(
            'jenisinformasi_id'=>$id,
        ));
        
        $val = "";
        if (!empty($isi)) {
            $val = $isi->isiinformasi_nama;
        }
        
        echo CJSON::encode(array('isi'=>$val));
        
    }
    
    public function actionLoadInformasiCekBox() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        
        $jenis = JenisinformasiM::model()->findByPk($id);
        
        $cr = new CDbCriteria();
        $cr->compare('jenisinformasi_id', $id);
        $cr->order = 'isiinformasi_urutan asc';
        
        $res = IsiinformasiM::model()->findAll($cr);
        
        if (count($res) == 0) {
            $kosong = new IsiinformasiM();
            $kosong->unsetAttributes();
            $kosong->jenisinformasi_id = $id;
            
            $res = array($kosong);
        }
        
        $html = "";
        foreach ($res as $item) {
            $html .= $this->renderPartial($this->path_view."_rowCekbox", array('model'=>$item), true);
        }
        
        echo CJSON::encode(array('html'=>$html));
        
    }
    
    public function actionSetDropDownJenisInformasi($namaModel) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $jenissurat = isset($_POST[$namaModel]['jenissurat_id']) ? $_POST[$namaModel]['jenissurat_id'] : null;
        
        $res = array();
        
        if (!empty($jenissurat)) {
            $cr = new CDbCriteria();
            $cr->compare('jenissurat_id', $jenissurat);
            $cr->addCondition('jenisinformasi_aktif = true');
            $cr->order = 'jenisinformasi_urutan';
            
            $data = JenisinformasiM::model()->findAll($cr);
            
            foreach ($data as $item) {
                array_push($res, '<option value="'.$item->jenisinformasi_id.'" data-tipe="'.$item->tipeinput_isiinformasi.'">'.$item->jenisinformasi_nama.'</option>');
            }
        }
        
        array_unshift($res, '<option value="" data-tipe="">-- Pilih --</option>');
        
        echo implode("", $res);
        
    }
}
