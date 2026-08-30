
<?php

class HasilPemeriksaanUsgController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.hasilPemeriksaanUSG.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $pemeriksaanusgpasien_id = null)
    {
        $format = new MyFormatter();
        $modPendaftaran= RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RJPemeriksaanusgpasienT();
        $modDetail = new RJPemeriksaanusgpasiendetT();
        $modDetailUsg = array();

        $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;

        $dokterId = $modPendaftaran->pegawai_id;
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        if(isset($modPasienAdmisi)){
            $dokterId = $modPasienAdmisi->pegawai_id;
        }

        $model->dokterpemeriksa_id = $dokterId;
        $model->ruanganperiksausg_id = Yii::app()->user->getState("ruangan_id");


//        $model->pemeriksaanke= (count(RDObservasipasienigdT::model()->findAll())+1);

//        $cekAsesNyeri =array();
//
//
//
//        $criFla = new CDbCriteria();
//        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
//        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
//        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
//        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);
//
//        $getFlaCcs = null;
//
//        $dataFlaCcs = array();
//        $cekFlaCcs = array();

        if(!empty($pemeriksaanusgpasien_id)){
            $model = RJPemeriksaanusgpasienT::model()->findByPk($pemeriksaanusgpasien_id);
            $modDetailUsg = RJPemeriksaanusgpasiendetT::model()->findAllByAttributes(array('pemeriksaanusgpasien_id'=>$pemeriksaanusgpasien_id));
            $model->is_trimester = $model->trimesterkehamilan;
            if($model->jumlahjanin_ket == 'Lainnya'){
                $model->jumlahjaninlain = $model->jumlahjanin;
            }

//            $getFlaCcs = RDAsesmentnyerianakigddetObservT::model()->findAllByAttributes(array('observasipasienigd_id'=>$model->observasipasienigd_id));
//
//            if (count($getFlaCcs)>0)
//                foreach($getFlaCcs as $det){
//                    $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->asesmentnyerianakigddet_observ_id;
//                    $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
//                    $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
//                    $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
//                    $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->observasipasienigd_id;
//                }
        }


//        foreach ($modNyeriFlaCcs as $dtF){
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']:null;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']:null;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']:null;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']:null;
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
//                    'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']:null,
//                    'keterangan' => $dtF->skalanyeriflaccs_desc
//            );
//            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']:null;
//        }


        if(isset($_POST['RJPemeriksaanusgpasienT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['RJPemeriksaanusgpasienT'];
                $model->tgl_pemeriksaan = (!empty($_POST['RJPemeriksaanusgpasienT']['tgl_pemeriksaan'])?MyFormatter::formatDateTimeForDb($_POST['RJPemeriksaanusgpasienT']['tgl_pemeriksaan']):null);

                if(!empty($model->pemeriksaanusgpasien_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                $tersimpandetail = true;

                if($model->save()){
                    $this->tersimpan = true;

                    if(isset($_POST['RJPemeriksaanusgpasiendetT']) && count($_POST['RJPemeriksaanusgpasiendetT']) >0){
                        RJPemeriksaanusgpasiendetT::model()->deleteAllByAttributes(array('pemeriksaanusgpasien_id'=>$model->pemeriksaanusgpasien_id));

                        foreach ($_POST['RJPemeriksaanusgpasiendetT'] as $dataDet){
                            $modDetail = new RJPemeriksaanusgpasiendetT();
                            $modDetail->attributes = $dataDet;
                            $modDetail->pemeriksaanusgpasien_id = $model->pemeriksaanusgpasien_id;
                            $modDetail->taksiranmelahirkan = (!empty($dataDet['taksiranmelahirkan'])?MyFormatter::formatDateTimeForDb($dataDet['taksiranmelahirkan']):null);

                            if(!empty($modDetail->pemeriksaanusgpasiendet_id)){
                                    $modDetail->update_time = date('Y-m-d H:i:s');
                                    $modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }else{
                                    $modDetail->create_time = date('Y-m-d H:i:s');
                                    $modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }
                                 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");
                                 $modDetail->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");

                             if(!$modDetail->save()){
                                $tersimpandetail = false;
                            }
                        }
                    }
                }else{
                   $this->tersimpan = false;
                }

                if($this->tersimpan == true && $tersimpandetail == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id, 'type'=>$_GET['type'], 'frame'=>$_GET['frame']));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view.'index',
                array('modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                    'modDetail'=>$modDetail,
                    'modDetailUsg'=>$modDetailUsg

        ));
    }

    public function actionHasilPemeriksaan($pendaftaran_id, $pemeriksaanusgpasien_id) {
        $model = PemeriksaanusgpasienT::model()->findByPk($pemeriksaanusgpasien_id);
        $modDetail = PemeriksaanusgpasiendetT::model()->findAllByAttributes(array('pemeriksaanusgpasien_id'=>$pemeriksaanusgpasien_id));
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

         $this->render($this->path_view.'detailHasilPemeriksaan',
                array('modPendaftaran'=>$modPendaftaran,
                    'model'=>$model,
                    'modDetail'=>$modDetail,
        ));
    }

    public function actionPrint($pemeriksaanusgpasien_id, $pendaftaran_id)
    {
        $model = PemeriksaanusgpasienT::model()->findByPk($pemeriksaanusgpasien_id);
        $modDetail = PemeriksaanusgpasiendetT::model()->findAllByAttributes(array('pemeriksaanusgpasien_id'=>$pemeriksaanusgpasien_id));
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL')
        {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $judulLaporan = "SURAT PERSETUJUAN UMUM";
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }
    }

    public function actionHapusHasilPemeriksaan(){
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $pendaftaranId = $_POST['pendaftaran_id'];

            $deleteDetail = PemeriksaanusgpasiendetT::model()->deleteAllByAttributes(array('pemeriksaanusgpasien_id'=>$id));
            $deleteData = PemeriksaanusgpasienT::model()->deleteByPk($id);
            $message = "";
            $sukses = 0;

            if($deleteDetail && $deleteData){
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
}
