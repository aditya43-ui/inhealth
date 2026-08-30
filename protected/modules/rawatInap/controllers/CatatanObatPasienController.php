
<?php

class CatatanObatPasienController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "rawatInap.views.catatanObatPasien.";


	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($pendaftaran_id, $pasienadmisi_id = null, $id = null)
	{
        $this->layout = '//layouts/iframe';
        
        if (!empty($pasienadmisi_id)) {
            $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ));
        } else {
            $kunjungan = PendaftaranT::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ));
        }
        
        $model = CatatanobatpasienT::model()->findByPk($id);
        
        if (empty($model)) {
            $model = new CatatanobatpasienT;
            $model->pendaftaran_id = $kunjungan->pendaftaran_id;
            $model->pasien_id = $kunjungan->pasien_id;
            $model->ruangan_id = $kunjungan->ruangan_id;
            $model->tgl_pemberian = date('Y-m-d');
            $model->jam_pemberian = date('H:i:s');
            $model->waktupemberian = null;
        }
        
        
        $model->tgl_pemberian = MyFormatter::formatDateTimeForUser($model->tgl_pemberian);
        
        if (!empty($model->obatalkes)) {
            $model->obatalkes_nama = $model->obatalkes->obatalkes_nama;
        }
        
        if (!empty($model->petugaspengisi)) {
            $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
        }
        
        
        $riwayat = CatatanobatpasienT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ), array(
            'order'=>'tgl_pemberian, jam_pemberian',
        ));
        
        
		if(isset($_POST['CatatanobatpasienT']))
		{
			$model->attributes = $_POST['CatatanobatpasienT'];
            $model->tgl_pemberian = MyFormatter::formatDateTimeForDB($model->tgl_pemberian);
            $model->jam_pemberian = $_POST['CatatanobatpasienT']['jam_pemberian'];
            
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;

			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('create','pendaftaran_id'=>$model->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id));
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
            'kunjungan'=>$kunjungan,
            'riwayat'=>$riwayat,
		));
	}


	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        // Yii::app()->db->beginTransaction();
        
        $ok = 1;
        $msg = "Data catatan berhasil dihapus.";
        
        try {
            $id = $_POST['id'];
            $this->loadModel($id)->delete();
            
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data catatan gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg
        ));
        
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = CatatanobatpasienT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catatanobatpasien-t-form')
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
		$model = new CatatanobatpasienT;
		$model->attributes = $_REQUEST['CatatanobatpasienT'];
		$judulLaporan='Data CatatanobatpasienT';
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
    

    public function actionPrintNew($pendaftaran_id)
	{
        $modelInjeksi = CatatanobatpasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'jenisobat'=>'Obat Injeksi'));
        $modelNon = CatatanobatpasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'jenisobat'=>'Obat Non Injeksi'));
        $modelSup = CatatanobatpasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'jenisobat'=>'Obat Suppositoria'));
        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id));
        $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $modDiagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		$judulLaporan='Catatan Obat';
		$caraPrint = $_REQUEST['caraprint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'PrintNew',array('modAdmisi'=>$modAdmisi, 'modDiagnosa'=>$modDiagnosa, 'modelInjeksi'=>$modelInjeksi,'modelNon'=>$modelNon, 'modelSup'=>$modelSup,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('modelInjeksi'=>$modelInjeksi,'modelNon'=>$modelNon, 'modelSup'=>$modelSup, 'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
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
    
    public function actionAutocompletePetugas($term = "") {
        $modPetugas = new PegawairuanganV('searchPegawaiMenyetujui');
        $modPetugas->unsetAttributes();
        $modPetugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPetugas->pegawai_aktif = true;
        $modPetugas->nama_pegawai = $term;
        
        $prov = $modPetugas->search();
        $prov->pagination = false;
        
        $res = array();
        
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['namaLengkap'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    public function actionAutocompleteObat($term = "") {
        $modObatAlkes = new RIObatalkesM('search');
        $modObatAlkes->unsetAttributes();
        $modObatAlkes->pendaftaran_id = $kunjungan->pendaftaran_id;
        $modObatAlkes->obatalkes_nama = $term;
        
        $prov = $modObatAlkes->searchObatAlkesPasienDijual();
        $prov->pagination = false;
        
        $res = array();
        
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->obatalkes_nama;
            $sub['value'] = $item->obatalkes_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
}
