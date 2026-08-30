
<?php

class KesejahteraanIbuController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $path_view = "persalinan.views.kesejahteraanIbu.";
    public $layout = "//layouts/iframe";
	public $defaultAction = 'create';

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
        
        $partograf = PartografpasienT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));
        
        if (empty($partograf)) {
            echo 'Mohon untuk mengisi Data Awal Terlebih Dahulu';
            Yii::app()->end();
        }                
        
        $cekData = KesejahteraanibuT::model()->findByPk($id);
        if (!empty($cekData)) {
            $model = $cekData;
        } else {
            $model = new KesejahteraanibuT;
            $model->partografpasien_id = $partograf->partografpasien_id;
            $model->tgl_pemeriksaan = date('Y-m-d');
            $model->jam_pemeriksaan = date('H:i:s');
            $model->pemeriksaanke = $model->getNoPemeriksaan();
        }
        
        $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan);
        
        //biar hanya refresh grid viewnya saja
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                
                if ($ajax == 'kesejahteraan-ibu-grid'){
                    $this->renderPartial($this->path_view.'_riwayat',['model'=>$model, 'pendaftaran_id'=>$pendaftaran_id]);
                    Yii::app()->end();
                }
            }
        }
        

		if(isset($_POST['KesejahteraanibuT']))
		{
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            
            
            try {
                $model->attributes = $_POST['KesejahteraanibuT'];
                
                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }

                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                
                $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($model->tgl_pemeriksaan);
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }
                
                KesejahteraanibunaditdT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
                ));
                if (isset($_POST['is_nadi']) && $_POST['is_nadi'] == 1 && isset($_POST['KesejahteraanibunaditdT'])) {
                    $det = new KesejahteraanibunaditdT;
                    $det->attributes = $model->attributes;
                    $det->attributes = $_POST['KesejahteraanibunaditdT'];
                    
                    $ok = $ok && $det->save();
                    
//                    vaR_dump($det->attributes);
                }
                
                
                KesejahteraanibusuhuT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
                ));
                if (isset($_POST['is_suhu']) && $_POST['is_suhu'] == 1 && isset($_POST['KesejahteraanibusuhuT'])) {
                    $det = new KesejahteraanibusuhuT;
                    $det->attributes = $model->attributes;
                    $det->attributes = $_POST['KesejahteraanibusuhuT'];
                    
                    $ok = $ok && $det->save();
                    
//                    vaR_dump($det->attributes);
                }
                
                
                KesejahteraanibuoksitosinT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
                ));
                if (isset($_POST['is_oksitosin']) && $_POST['is_oksitosin'] == 1 && isset($_POST['KesejahteraanibuoksitosinT'])) {
                    $det = new KesejahteraanibuoksitosinT;
                    $det->attributes = $model->attributes;
                    $det->attributes = $_POST['KesejahteraanibuoksitosinT'];
                    
                    $ok = $ok && $det->save();
                    
//                    vaR_dump($det->attributes);
                }
                
                
                
                KesejahteraanibuurineT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
                ));
                if (isset($_POST['is_urine']) && $_POST['is_urine'] == 1 && isset($_POST['KesejahteraanibuurineT'])) {
                    $det = new KesejahteraanibuurineT;
                    $det->attributes = $model->attributes;
                    $det->attributes = $_POST['KesejahteraanibuurineT'];
                    
                    $ok = $ok && $det->save();
                    
//                    vaR_dump($det->attributes);
                }
                
                
                ObatpartografT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
                ));
                if (isset($_POST['is_obat']) && $_POST['is_obat'] == 1 && isset($_POST['ObatpartografT']['detail'])) {
                    
                    foreach ($_POST['ObatpartografT']['detail'] as $obat_id => $items) {
                        $det = new ObatpartografT;
                        $det->attributes = $model->attributes;
                        $det->attributes = $items;

                        $ok = $ok && $det->save();

//                        vaR_dump($det->attributes);
                        
                    }
                    
                }
                
//                var_dump($ok, $model->attributes, $_POST); die;
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('create', 'pendaftaran_id'=>$pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
            
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id, 'partograf'=>$partograf,
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
            $trans = Yii::app()->db->beginTransaction();
            $ok = 1;
            $msg = "Data berhasil dihapus";
            $id = $_POST['id'];
            
            try {
                KesejahteraanibunaditdT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$id,
                ));
                KesejahteraanibusuhuT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$id,
                ));
                KesejahteraanibuoksitosinT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$id,
                ));
                KesejahteraanibuurineT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$id,
                ));
                ObatpartografT::model()->deleteAllByAttributes(array(
                    'kesejahteraanibu_id'=>$id,
                ));
                
                $data = KesejahteraanibuT::model()->findByPk($id);
                KesejahteraanibuT::model()->deleteByPk($id);
                KesejahteraanibuT::resetUrutanPeriksa($data->partografpasien_id);
                
                $trans->commit();
                
            } catch (Exception $ex) {
                $trans->rollback();
                $ok = 0;
                $msg = "Data gagal dihapus. ".$ex->getMessage();
            }
            
            
            echo CJSON::encode(array(
                'ok'=>$ok,
                'msg'=>$msg,
            ));
            
		}
	}
    

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new KesejahteraanibuT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KesejahteraanibuT'])){
			$model->attributes = $_GET['KesejahteraanibuT'];
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
		$model = KesejahteraanibuT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kesejahteraanibu-t-form')
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
		$model = new KesejahteraanibuT;
		$model->attributes = $_REQUEST['KesejahteraanibuT'];
		$judulLaporan='Data KesejahteraanibuT';
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
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
    
    public function actionTambahObat() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        
        $det = new ObatpartografT();
        $det->obatalkes_id = $id;
        $det->qty_obat = 0;
        
        echo CJSON::encode(array(
            'html'=>$this->renderPartial($this->path_view."form._rowObat", array(
                'model'=>$det,
            ), true),
        ));
    }
    
    
    public function actionDetail($id) {
        $partograf = PartografpasienT::model()->findByPk($id);
        
        if (empty($partograf)) {
            echo "Lakukan input Data Awal sebelum melihat detail ini.";
            Yii::app()->end();
        }
        
        $model = new KesejahteraanibuT;
        $model->unsetAttributes();
        $model->partografpasien_id = $partograf->partografpasien_id;
        
        $this->render($this->path_view.'detail', array(
            'partograf'=>$partograf,
            'model'=>$model,
            'pendaftaran_id'=>$partograf->pendaftaran_id,
        ));
    }
}
