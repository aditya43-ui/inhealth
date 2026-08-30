
<?php

class CatatanPemberianObatController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "rawatInap.views.catatanPemberianObat.";


	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($pendaftaran_id, $pasienadmisi_id = null, $id = null)
	{
        // echo "<pre>";
        // echo print_r($_POST);exit;
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

        $model = CatatanpemberianobatT::model()->findByPk($id);

        $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$id));



        if (empty($modPemberianObatDet)) {

            $modPemberianObatDet = new CatatanpemberianobatdetT;
        }

            // echo print_r($modPemberianObatDet).exit();

        if (empty($model)) {
            $model = new CatatanpemberianobatT;
            $model->pendaftaran_id = $kunjungan->pendaftaran_id;
            $model->pasien_id = $kunjungan->pasien_id;
        }


        if (!empty($model->obatalkes)) {
            $model->obatalkes_nama = $model->obatalkes->obatalkes_nama;
        }

        if (!empty($model->petugaspengisi)) {
            $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
        }

				$conditionRiwayat_infus = array();
				$riwayat_oral = array();
				if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK){
					$conditionRiwayat_infus = array('condition'=>"jenisinfus in ('INJEKSI','INFUS')");

					$riwayat_oral = CatatanpemberianobatT::model()->findAllByAttributes(array(
	            'pendaftaran_id'=>$pendaftaran_id,
	        ), array('condition'=>"jenisinfus in ('ORAL','OBAT LUAR')"));
				}

        $riwayat_infus = CatatanpemberianobatT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ), $conditionRiwayat_infus);


		if(isset($_POST['CatatanpemberianobatT']))
		{
			$model->attributes = $_POST['CatatanpemberianobatT'];


            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->isalergiobat = $_POST['CatatanpemberianobatT']['isalergiobat'];
            $model->carapemberian = $_POST['CatatanpemberianobatT']['carapemberian'];
            $model->cairanmasuk = $_POST['CatatanpemberianobatT']['cairanmasuk'];
            $model->jeniscairanmasuk = $_POST['CatatanpemberianobatT']['jeniscairanmasuk'];
            $model->dosisobat = $_POST['CatatanpemberianobatT']['dosisobat'];
            $model->aturanpakaiobat = $_POST['CatatanpemberianobatT']['aturanpakaiobat'];
            $model->pegawai_id = $_POST['CatatanpemberianobatT']['pegawai_id'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;

			if($model->save()){
                $sukses = true;
                if (!empty($modPemberianObatDet)){
                    // echo print_r($modPemberianObatDet).exit();
                    $hapusRiwayat = CatatanpemberianobatdetT::model()->deleteAll('catatanpemberianobat_id='.$model->catatanpemberianobat_id.'');
                }
                if(isset($_POST['CatatanpemberianobatdetT'])){

                    if (count($_POST['CatatanpemberianobatdetT']) > 0){
                        $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$model->catatanpemberianobat_id));


                        foreach($_POST['CatatanpemberianobatdetT'] as $det){
                            $modPemberianObatDet = new CatatanpemberianobatdetT;
                            $modPemberianObatDet->catatanpemberianobat_id = $model->catatanpemberianobat_id;
                            $modPemberianObatDet->tanggal_pemberian = MyFormatter::formatDateTimeForDB($det['tanggal_pemberian']);
                            $modPemberianObatDet->tanda = $det['tanda'];
                            $modPemberianObatDet->initial = $det['initial'];
                            $modPemberianObatDet->jam_pemberian = $det['jam_pemberian'];
                            $modPemberianObatDet->waktu_monitoring = $det['waktu_monitoring'];
                            if($modPemberianObatDet->save()){
                                $sukses = true;
                            }else{
                                $sukses = false;
                            }
                        }
                    }

                }


			}else{
                $sukses = false;
            }

            if($sukses){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('create','pendaftaran_id'=>$model->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:"")));

            }
		}
        // echo print_r(($modPemberianObatDet)).exit();
		$this->render($this->path_view.'create',array(
			'model'=>$model,
            'kunjungan'=>$kunjungan,
            'riwayat_infus'=>$riwayat_infus,
						'riwayat_oral'=>$riwayat_oral,
            'modPemberianObatDet'=>$modPemberianObatDet
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
		$model = CatatanpemberianobatT::model()->findByPk($id);
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
		$model = new CatatanpemberianobatT;
		$model->attributes = $_REQUEST['CatatanpemberianobatT'];
		$judulLaporan='Data CatatanpemberianobatT';
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
		$typeoa = $_GET['typeoa'];
        $judulLaporan = '';

        if(!empty($typeoa)){
            if($typeoa == 'obat'){
                $judulLaporan = "CATATAN PEMBERIAN (CPO) INJEKSI/INFUS";
            }else if($typeoa == 'luar'){
                $judulLaporan = "CATATAN PEMBERIAN (CPO) ORAL DAN OBAT LUAR";
            }
        }

        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id));
        $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $modDiagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		
		$caraPrint = $_REQUEST['caraprint'];
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view.'Print',array('modAdmisi'=>$modAdmisi, 'modDiagnosa'=>$modDiagnosa,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
		
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
        $modObatAlkes->pendaftaran_id = $_GET['pendaftaran_id'];
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

    public function actionAjaxDetail(){
            if(Yii::app()->request->isAjaxRequest) {
            $id = $_POST['catatanpemberianobat_id'];
            $detail = CatatanpemberianobatdetT::model()->findallByAttributes(array('catatanpemberianobat_id'=>$id));
            $data['result'] = $this->renderPartial($this->path_view.'_Detail', array('modDetail'=>$detail), true);

            echo json_encode($data);
             Yii::app()->end();
            }
    }
}
