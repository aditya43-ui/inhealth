
<?php

class PreventifmaintenMController extends MyAuthController
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
    public function actionAutoCompleteBarang()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
            $criteria->order = 't.barang_id';
            $models = BarangM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->barang_nama;
                $returnVal[$i]['value'] = $model->barang_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

	public function actionView($id)
	{
        $barang = BarangM::model()->findByPk($id);
		$model = PreventifmaintenM::model()->findByAttributes(array(
            'barang_id'=>$id,
        ));
        $models = PreventifmaintenM::model()->findAllByAttributes(array(
            'barang_id'=>$id,
        ));
        $modHitung = PerhitunganemM::model()->findByAttributes(array('barang_id'=>$id));
		$this->render('view',array(
				'model'=>$model,
                'models'=>$models,
                'modHitung'=>$modHitung,
                'barang'=>$barang,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($id = null)
	{
            $model = new PreventifmaintenM;
            $models = array(new PreventifmaintenM);
            $modHitung = new PerhitunganemM();

            if (!empty($id)) {
                $model = PreventifmaintenM::model()->findByAttributes(array(
                    'barang_id'=>$id,
                ));
                $models = PreventifmaintenM::model()->findAllByAttributes(array(
                    'barang_id'=>$id,
                ));
                $modHitung = PerhitunganemM::model()->findByAttributes(array('barang_id'=>$id));
            }
            if (isset($_POST['idBarang']) && isset($_POST['PreventifmaintenM']) && isset($_POST['PreventifmaintenM'])) {
                $trans = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    
                    // simpan perhitungan
                    
                    $modHitung->attributes = $_POST['PerhitunganemM'];
                    $modHitung->barang_id = $_POST['idBarang'];
                    $modHitung->create_time = date('Y-m-d H:i:s');
                    $modHitung->create_loginpemakai_id = Yii::app()->user->id;
                    $modHitung->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    
                    if ($modHitung->validate()) {
                        $ok = $ok && $modHitung->save();
                    } else {
                        $ok = false;
                    }
                    
                    // simpan preventiv maintenance
                    
                    // var_dump($_POST['PreventifmaintenM']['detail']); die;
                    
                    foreach ($_POST['PreventifmaintenM']['detail'] as $ipm_id => $item) {
                        $model = PreventifmaintenM::model()->findByAttributes(array(
                            'barang_id'=>$_POST['idBarang'],
                            'ipmchecklist_id'=>$ipm_id,
                        ));
                        
                        if (empty($model)) {
                            $model = new PreventifmaintenM;
                            $model->barang_id = $_POST['idBarang'];
                        }
                        
                        $model->attributes = $_POST['PreventifmaintenM'];
                        $model->ipmchecklist_id = $ipm_id;
                        $model->ipmchecklist_list = ($item['ipmchecklist_id'] == 0) ? false : true;
                        
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        
                        
                        if ($model->validate()) {
                            $ok = $ok && $model->save();
                        } else {
                            $ok = false;
                        }
                    }
                    
                    // ceklis tambahan
                    // var_dump($_POST); die;
                    
                    if (isset($_POST['ceklis'])) {
                        $cnt = 1;
                        foreach ($_POST['ceklis'] as $item) {
                            $ceklis = new IpmchecklistM;
                            $ceklis->ipm_list_nourut = $cnt++;
                            $ceklis->ipm_jenis = 'NON IPM CHECKLIST';
                            $ceklis->ipm_listnama = $item;
                            $ceklis->ipm_ket = "";
                            $ceklis->ipm_aktif = true;
                            $ceklis->create_time = date('Y-m-d H:i:s');
                            $ceklis->create_loginpemakai_id = Yii::app()->user->id;
                            $ceklis->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            
                            if ($ceklis->validate()) {
                                $ok = $ok && $ceklis->save();
                                
                                $modelCek = new PreventifmaintenM;
                                $modelCek->attributes =$model->attributes;
                                $modelCek->preventifmainten_id = null;
                                $modelCek->ipmchecklist_id = $ceklis->ipmchecklist_id;
                                $modelCek->ipmchecklist_list = true;
                                
                                
                                if ($model->validate()) {
                                    $ok = $ok && $modelCek->save();
                                } else {
                                    $ok = false;
                                }
                                
                                
                            } else {
                                $ok = false;
                            }
                        }
                    }

                    if ($ok) {
                        $trans->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin', 'sukses'=>1));
                    } else {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ! ");
                        $this->refresh();
                    }
                } catch (Exception $e) {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                }
            }
            $this->render('create',array(
                    'model'=>$model,
                    'models'=>$models,
                    'modHitung' => $modHitung
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
		

		if(isset($_POST['PreventifmaintenM']))
		{
			$model->attributes = $_POST['PreventifmaintenM'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->preventifmainten_id));
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
            PerhitunganemM::model()->deleteAllByAttributes(array(
                'barang_id'=>$id,
            ));
            PreventifmaintenM::model()->deleteAllByAttributes(array(
                'barang_id'=>$id,
            ));
			//$this->loadModel($id)->delete();

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
		$dataProvider = new CActiveDataProvider('PreventifmaintenM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new PreventifmaintenM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PreventifmaintenM'])){
			$model->attributes = $_GET['PreventifmaintenM'];
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
		$model = PreventifmaintenM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='preventifmainten-m-form')
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
		$model = new PreventifmaintenM;
		$model->attributes = $_REQUEST['PreventifmaintenM'];
		$judulLaporan='Data PreventifmaintenM';
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
    public function actionSetFormCeklis(){
        if (Yii::app()->request->isAjaxRequest) {
            $ceklis_id = isset($_POST['ceklis_id']) ? $_POST['ceklis_id']: '';
            $ceklis = isset($_POST['ceklis']) ? $_POST['ceklis']: '';
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $model = new PreventifmaintenM;

            $model->ipmchecklist_id = $ceklis_id;
            $model->ipmchecklist_list = $ceklis;


            $form .= $this->renderPartial('_rowCeklis', array(
                'model' => $model
            ), true);
            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end(); 
        }
    }
        
}
