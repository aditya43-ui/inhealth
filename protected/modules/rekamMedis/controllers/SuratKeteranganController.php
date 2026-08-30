<?php

class SuratKeteranganController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'Index';
    public $path_view = 'rekamMedis.views.suratKeterangan.';
    public $kodepos = "-";

    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Surat Keterangan";
        $modJenisSurat = new RKJenisSuratM;
        $model = new RKSuratketeranganR;
        $modPendaftaran = new RKPendaftaranT;
        $modPasien = new RKPasienM;

        if (isset($_POST['RKSuratketeranganR'])) {
            $model->attributes = $_POST['RKSuratketeranganR'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                $this->redirect(array('index', 'id' => $model->suratketerangan_id));
            } else {
                Yii::app()->user->setFlash('error', "Data  gagal disimpan !");
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modJenisSurat' => $modJenisSurat,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
        ));
    }
    public function actionSuratKeterangan($pendaftaran_id=null) {
        $this->layout = '//layouts/iframe';
        $pendaftaran_id = $_GET["pendaftaran_id"];
        $modJenisSurat = new RKJenisSuratM;
        $model = new RKSuratketeranganR;
        $modPendaftaran = new RKPendaftaranT;
        $modPasien = new RKPasienM;
        // var_dump($pendaftaran_id);die;

        if (isset($_POST['RKSuratketeranganR'])) {
            $model->attributes = $_POST['RKSuratketeranganR'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                $this->redirect(array('index', 'id' => $model->suratketerangan_id));
            } else {
                Yii::app()->user->setFlash('error', "Data  gagal disimpan !");
            }
        }
        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        // echo "<pre>";
        // var_dump($modPendaftaran);die;

        $this->render($this->path_view . 'suratketerangan', array(
            'model' => $model,
            'modJenisSurat' => $modJenisSurat,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
        ));
    }

    // Tabular : Istirahat 
    public function actionIstirahat($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1, "SKD");

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            //            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN ISTIRAHAT";
                $model->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);
                $model->istirahat_tgl_sd = $format->formatDateTimeForDb($model->istirahat_tgl_sd);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $transaction->commit();
                    //$model->isNewRecord = FALSE;
                    //if(!empty($_GET['pendaftaran_id'])){
                    //  $model->suratketerangan_id = $model->suratketerangan_id;
                    // }
                    Yii::app()->user->setFlash('success', "Surat Keterangan Istirahat berhasil disimpan");
                    $this->redirect(array(
                        'Istirahat', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id, 'lama_hari' => $_POST['RKSuratketeranganR']['lamaistirahat']
                    ));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Istirahat gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'istirahat/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintIstirahat($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'istirahat/printSuratIstirahatV2', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Istirahat
    public function actionIstirahatv2($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $jenisSurat = Params::JENISSURAT_SAKIT;
        $model->nomorsurat = MyGenerator::noSurat($jenisSurat, "SKD");

        if (isset($_POST['RKSuratketeranganR'])) {
            // var_dump($_POST);die;
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            //            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = Params::JENISSURAT_SAKIT;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->judulsurat = "SURAT KETERANGAN SAKIT";
                $model->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);
                $model->istirahat_tgl_sd = $format->formatDateTimeForDb($model->istirahat_tgl_sd);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                

                if ($model->save()) {
                    // var_dump($model);die;
                    $transaction->commit();
                    //$model->isNewRecord = FALSE;
                    //if(!empty($_GET['pendaftaran_id'])){
                    //  $model->suratketerangan_id = $model->suratketerangan_id;
                    // }
                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'Istirahatv2', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id, 'lama_hari' => $_POST['RKSuratketeranganR']['lamaistirahat']
                    ));
                } else {
                    // echo "<pre>";
                var_dump($transaction);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                var_dump($exc->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Sakit gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'istirahatv2/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintIstirahatv2($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        // var_dump($modPegawai);die;
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        /*
          if($caraPrint=='PRINT') {
          $this->layout='//layouts/printWindows';
          }
          $this->render($this->path_view.'istirahatv2/printSuratIstirahat',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'model'=>$model,
          'judulLaporan'=>$judulLaporan,
          'caraPrint'=>$caraPrint));
         * 
         */

        $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'istirahatv2/printSuratIstirahat', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'model' => $model,
                    'judulLaporan' => $judulLaporan,
                    'caraPrint' => $caraPrint,
                    'modPegawai'=>$modPegawai
                        ), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }

    // end Tabular sakit
    // Tabular : Opname (Sudah Pulang)
    public function actionOpnameSP($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;

        $model->nomorsurat = MyGenerator::noSurat(1);
        $modAdmisi->tgladmisi = date("Y-m-d") . " 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d") . " 00:00:00";

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->judulsurat = "SURAT KETERANGAN OPNAME (SUDAH PULANG)";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                //                    echo "<pre>";
                //                    echo print_r($model->getAttributes());exit;
                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'OpnameSP', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Opname (Sudah Pulang) gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'opnameSP/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi,
        ));
    }

    public function actionPrintOpnameSP($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        //        if(!empty($modPendaftaran->pasienadmisi_id)){            
        //            $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        //            $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        //        }else{
        //            $modDokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        //            $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        //        }

        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);


        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'opnameSP/printSuratOpnameSP', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAdmisi' => $modAdmisi,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Opname (Sudah Pulang)
    // Tabular : Opname (Sedang Dirawat)
    public function actionOpnameRI($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();

        $model->nomorsurat = MyGenerator::noSurat(1, "SKRI");
        $modAdmisi->tgladmisi = date("Y-m-d") . " 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d") . " 00:00:00";

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->judulsurat = "SURAT KETERANGAN RAWAT INAP";

                $model->tglistirahat = MyFormatter::formatDateTimeForDb($model->tglistirahat);
                $model->istirahat_tgl_sd = MyFormatter::formatDateTimeForDb($model->istirahat_tgl_sd);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                //                    echo "<pre>";
                //                    echo print_r($model->getAttributes());exit;

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'OpnameRI', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Dirawat gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'opnameRI/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi,
        ));
    }

    public function actionPrintOpnameRI($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        //        if(!empty($modPendaftaran->pasienadmisi_id)){
        //            $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        //        }else{
        //            $modDokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        //        }
        //        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        /*
          if($caraPrint=='PRINT') {
          $this->layout='//layouts/printWindows';
          $this->render($this->path_view.'opnameRI/printSuratOpnameRIV2',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'modAdmisi'=>$modAdmisi,
          'model'=>$model,
          'judulLaporan'=>$judulLaporan,
          'caraPrint'=>$caraPrint));
          } else if ($caraPrint=='PDF') {
         * 
         */
        $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->renderPartial(
                        $this->path_view . 'opnameRI/printSuratOpnameRIV2', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'modAdmisi' => $modAdmisi,
                    'model' => $model,
                    'judulLaporan' => $judulLaporan,
                    'caraPrint' => $caraPrint
                        ), true
        ));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        //}
    }

    // end Tabular Opname (Sedang Dirawat)
    // 
    // Tabular : Indikasi Rawat Inap
    public function actionIndikasiRI($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->judulsurat = "SURAT KETERANGAN INDIKASI RAWAT INAP";
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'IndikasiRI', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Indikasi Rawat Inap gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'indikasiRI/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintIndikasiRI($pendaftaran_id = null, $suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'indikasiRI/printSuratIndikasiRI', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Indikasi Rawat Inap
    // Tabular : Diagnosa
    public function actionDiagnosa($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN DIAGNOSA";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'Diagnosa', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Diagnosa gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'diagnosa/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintDiagnosa($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'diagnosa/printSuratDiagnosa', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Surat Diagnosa
    // Tabular : Surat Meninggal
    public function actionSuratMeninggal($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;
        $model->nomorsurat = MyGenerator::noSurat(1);
        $modAdmisi->tgladmisi = date("Y-m-d") . " 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d") . " 00:00:00";

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN MENINGGAL";
                $model->penyebabkematian = $_POST['penyebabkematian'];

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                //var_dump($model->attributes); die;

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'SuratMeninggal', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Meninggal gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'meninggal/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi
        ));
    }

    public function actionPrintSuratMeninggal($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        //        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        //        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'meninggal/printSuratMeninggal', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAdmisi' => $modAdmisi,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Surat Meninggal
    // Tabular : Surat Lahir
    public function actionSuratLahir($pendaftaran_id = null, $kelahiranbayi_id = null) {
        $this->layout = '//layouts/iframe';

        $kelahiran_list = array();
        if (empty($kelahiranbayi_id)) {
            $modPersalinan = PersalinanT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran_id,
            ));
            if (!empty($modPersalinan)) {
                $modKelahiran = KelahiranbayiT::model()->findByAttributes(array(
                    'persalinan_id' => $modPersalinan->persalinan_id,
                ));
                $kelahiran_list = KelahiranbayiT::model()->findAllByAttributes(array(
                    'persalinan_id' => $modPersalinan->persalinan_id,
                ));

                if (!empty($modKelahiran)) {
                    $kelahiranbayi_id = $modKelahiran->kelahiranbayi_id;
                }
            }
        } else {
            $modPersalinan = PersalinanT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran_id,
            ));
            if (!empty($modPersalinan)) {
;
                $kelahiran_list = KelahiranbayiT::model()->findAllByAttributes(array(
                    'persalinan_id' => $modPersalinan->persalinan_id,
                ));
            }
        }

        if (!empty($kelahiranbayi_id)) {
            $cekSurat = SuratketeranganR::model()->findByAttributes(array('kelahiranbayi_id' => $kelahiranbayi_id));
        } else {
            echo "Pasien belum dicatat kelahiran bayi-nya.";
            exit;
        }

        if (!empty($cekSurat)) {
            $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
            $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
            $model = SuratketeranganR::model()->findByPk($cekSurat->suratketerangan_id);
            $format = new MyFormatter();

            $model->lahir_tgllahir = array(
                'date' => date('Y-m-d', strtotime($model->lahir_tgllahir)),
                'time' => date('H:i:s', strtotime($model->lahir_tgllahir)),
            );
        } else {
            $format = new MyFormatter();
            $model = new SuratketeranganR;
            $modPekerjaan = '';
            $modPropinsi = '';
            $modKelurahan = '';
            $modKecamatan = '';
            $modKelahiran = '';
            $modPendaftaranData = '';
            $modPasienData = '';
            $modKabupaten = '';

            $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
            $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);

            if (isset($modPersalinan)) {
                $modPendaftaranData = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
                $modPasienData = PasienM::model()->findByPk($modPendaftaranData->pasien_id);
                if (isset($modPasienData)) {
                    $modPekerjaan = PekerjaanM::model()->findByPk($modPasienData->pekerjaan_id);
                    $modKelurahan = KelurahanM::model()->findByPk($modPasienData->kelurahan_id);
                    $modPropinsi = PropinsiM::model()->findByPk($modPasienData->propinsi_id);
                    $modKecamatan = KecamatanM::model()->findByPk($modPasienData->kecamatan_id);
                    $modKabupaten = KabupatenM::model()->findByPk($modPasienData->kabupaten_id);
                }
                if (isset($modKelahiran)) {
                    $model->lahir_beratbadan_gram = $modKelahiran->bb_gram;
                    $model->lahir_panjangbadan_cm = $modKelahiran->tb_cm;
                    $model->lahir_namaibu = $modPasienData->nama_pasien;
                    $model->lahir_tgllahir = array(
                        'date' => date('Y-m-d', strtotime($modKelahiran->tgllahirbayi)),
                        'time' => date('H:i:s', strtotime($modKelahiran->tgllahirbayi)),
                    );
                    $model->lahir_ibu_umur = $modPendaftaranData->umur;
                    $model->lahir_pekerjaan_ibu = isset($modPekerjaan) ? $modPekerjaan->pekerjaan_nama : '';
                    $model->lahir_ktp_ibu = $modPasienData->no_identitas_pasien;
                    $model->lahir_alamat = $modPasienData->alamat_pasien;
                    $model->lahir_propinsi = $modPropinsi->propinsi_id;
                    $model->lahir_kabupaten = $modKabupaten->kabupaten_id;
                    $model->lahir_kecamatan = $modKecamatan->kecamatan_id;
                    $model->lahir_jeniskelahiran = ""; //$modPersalinan->jnskelahiranhidup;
                }
            }
            $modPasien = new PasienM;
            $modPendaftaran = new PendaftaranT;
            $model->nomorsurat = MyGenerator::noSurat(18, "SKL");
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        if (isset($_POST['SuratketeranganR'])) {


            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 18; //surat keterangan lahir
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = isset($_POST['SuratketeranganR']['mengetahui_surat']) ? $_POST['SuratketeranganR']['mengetahui_surat'] : null;
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN LAHIR";
                $model->lahir_panjangbadan_cm = $_POST['SuratketeranganR']['lahir_panjangbadan_cm'];
                $model->lahir_beratbadan_gram = $_POST['SuratketeranganR']['lahir_beratbadan_gram'];
                $model->lahir_namaibu = $_POST['SuratketeranganR']['lahir_namaibu'];
                $model->lahir_namaayah = $_POST['SuratketeranganR']['lahir_namaayah'];
                $model->lahir_pekerjaan_ayah = $_POST['SuratketeranganR']['lahir_pekerjaan_ayah'];
                $model->no_pekerja_badge = isset($_POST['SuratketeranganR']['no_pekerja_badge']) ? $_POST['SuratketeranganR']['no_pekerja_badge'] : null;
                $model->no_ktp_ayah = $_POST['SuratketeranganR']['no_ktp_ayah'];
                $model->lahir_alamat = $_POST['SuratketeranganR']['lahir_alamat'];
                $model->dokter_persalinan_id = $_POST['SuratketeranganR']['dokter_persalinan_id'];
                $model->lahir_tgllahir = $format->formatDateTimeForDb($_POST['lahir_tgllahir']['date'] . " " . $_POST['lahir_tgllahir']['time']);
                $model->lahir_kabupaten = $model->lahir_kabupaten;
                $model->lahir_kecamatan = $model->lahir_kecamatan;
                $model->lahir_propinsi = $model->lahir_propinsi;
                $model->kelahiranbayi_id = $kelahiranbayi_id;
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {

                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'suratLahir', 'pendaftaran_id' => $pendaftaran_id, 'kelahiranbayi_id' => $kelahiranbayi_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Lahir gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'lahir/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modKelahiran' => $modKelahiran,
            'modPersalinan' => $modPersalinan,
            'kelahiran_list' => $kelahiran_list,
            'kelahiranbayi_id' => $kelahiranbayi_id,
        ));
    }

    public function actionPrintSuratLahir($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        //        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        //        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        /*
          if($caraPrint=='PRINT') {
          $this->layout='//layouts/printWindows';
          }
          $this->render($this->path_view.'lahir/printSuratLahirV2',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'modAdmisi'=>$modAdmisi,
          'model'=>$model,
          'judulLaporan'=>$judulLaporan,
          'caraPrint'=>$caraPrint));
         * 
         */
        $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'lahir/printSuratLahirV2', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'modAdmisi' => $modAdmisi,
                    'model' => $model,
                    'judulLaporan' => $judulLaporan,
                    'caraPrint' => $caraPrint
                        ), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }

    // end Tabular Surat Lahir
    // Tabular : Surat Berbadan Sehat
    public function actionSuratBadanSehat($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();
        $jenissurat_id = Params::JENISSURAT_SEHAT;
        $model->nomorsurat = MyGenerator::noSurat($jenissurat_id, "SKS");

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = Params::JENISSURAT_SEHAT;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->keterangan = isset($_POST['RKSuratketeranganR']['keterangan']) ? $_POST['RKSuratketeranganR']['keterangan'] : null;
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN SEHAT";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->butawarna = isset($_POST['RKSuratketeranganR']['butawarna']) ? $_POST['RKSuratketeranganR']['butawarna'] : "";
                $model->hasil_periksa = isset($_POST['RKSuratketeranganR']['hasil_periksa']) ? $_POST['RKSuratketeranganR']['hasil_periksa'] : "";
                $model->pergunaan_surat = isset($_POST['RKSuratketeranganR']['pergunaan_surat']) ? $_POST['RKSuratketeranganR']['pergunaan_surat'] : "";
                $model->hasil_swab = isset($_POST['RKSuratketeranganR']['hasil_swab']) ? $_POST['RKSuratketeranganR']['hasil_swab'] : "";
                $model->catatan_dokter = isset($_POST['RKSuratketeranganR']['catatan_dokter']) ? $_POST['RKSuratketeranganR']['catatan_dokter'] : "";
                $model->kesimpulan = isset($_POST['RKSuratketeranganR']['kesimpulan']) ? $_POST['RKSuratketeranganR']['kesimpulan'] : "";
                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'SuratBadanSehat', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Berbadan Sehat gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'badanSehat/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi
        ));
    }

    public function actionPrintSuratBadanSehat($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPegawai= PegawaiM::model()->findByAttributes(['pegawai_id'=>$modPendaftaran->pegawai_id]);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        /*
          if($caraPrint=='PRINT') {
          $this->layout='//layouts/printWindows';
          }
          $this->render($this->path_view.'badanSehat.printSuratBerbadanSehatV2',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'model'=>$model,
          'judulLaporan'=>$judulLaporan,
          'caraPrint'=>$caraPrint));
         * 
         */
        $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'badanSehat.printSuratBerbadanSehatV2', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'model' => $model,
                    'judulLaporan' => $judulLaporan,
                    'caraPrint' => $caraPrint,
                    'modPegawai' => $modPegawai
                        ), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }

    // end Tabular Surat Berbadan Sehat
    // Tabular : Penyakit Rawat Darurat Sehat
    public function actionPenyakitRD($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN PENYAKIT GAWAT DARURAT";
                $labrad = isset($_POST['RKSuratketeranganR']['lab_rad']) ? $_POST['RKSuratketeranganR']['lab_rad'] : null;

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'PenyakitRD', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Penyakit Gawat Darurat gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'penyakitRD/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi
        ));
    }

    public function actionPrintPenyakitRD($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'penyakitRD/printPenyakitRD', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Surat Berbadan Sehat
    // Tabular : Layak Naik Pesawat
    public function actionLayakNaikPesawat($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN LAYAK NAIK PESAWAT TERBANG";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'LayakNaikPesawat', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Layak Naik Pesawat Terbang gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'layakNaikPesawat/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintLayakNaikPesawat($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'layakNaikPesawat/printLayakNaikPesawat', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Layak Naik Pesawat
    // Tabular : Cuti Hamil
    public function actionCutiHamil($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN CUTI HAMIL";
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);
                $model->tglperkiraanpartus = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglperkiraanpartus']);
                $model->usiakehamilan = $_POST['RKSuratketeranganR']['usiakehamilan'];

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'CutiHamil', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Cuti Hamil gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'cutiHamil/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintCutiHamil($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'cutiHamil/printCutiHamil', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Cuti Hamil
    // Tabular : Cuti Melahirkan
    public function actionCutiMelahirkan($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN CUTI PASCA MELAHIRKAN";
                $model->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];
                $model->usiakehamilan = $_POST['RKSuratketeranganR']['usiakehamilan'];
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'CutiMelahirkan', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id, 'lama_hari' => $_POST['RKSuratketeranganR']['lamaistirahat']
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Cuti Melahirkan gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'cutiMelahirkan/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintCutiMelahirkan($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'cutiMelahirkan/printCutiMelahirkan', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Cuti Melahirkan
    // Tabular : Ambulans Antar Jenazah
    public function actionAntarJenazah($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT JALAN AMBULANCE ANTAR JENAZAH";

                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'AntarJenazah', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', " Surat Jalan Ambulance Antar Jenazah gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'antarJenazah/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintAntarJenazah($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'antarJenazah/printAntarJenazah', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Ambulans Antar Jenazah
    // Tabular : Ambulans Jemput Pasien
    public function actionJemputPasien($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT JALAN AMBULANCE JEMPUT PASIEN";
                $model->dari_ke = $_POST['RKSuratketeranganR']['dari_ke'];
                $model->kepadayth = $_POST['RKSuratketeranganR']['kepadayth'];
                $model->namapesawat = $_POST['RKSuratketeranganR']['namapesawat'];
                $tgl = $format->formatDateTimeForDb($_POST['tgl_berangkat']);
                $waktu = $_POST['waktu'];
                $model->tglberangkatpst = $tgl . " " . $waktu;

                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim
                // yang bertandatangan
                $model->ygbertandatangan_id = $_POST['RKSuratketeranganR']['ygbertandatangan_id'];

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'JemputPasien', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Surat Jalan Ambulance Jemput Pasien Di Bandara gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'jemputPasien/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintJemputPasien($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'jemputPasien/printJemputPasien', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Ambulans Jemput Pasien
    // Tabular : Ambulans Jemput Jenazah ke Bandara
    public function actionJemputJenazah($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->profilrs_id = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->dari_ke = $_POST['RKSuratketeranganR']['dari_ke'];
                $model->kepadayth = $_POST['RKSuratketeranganR']['kepadayth'];
                $model->namapesawat = $_POST['RKSuratketeranganR']['namapesawat'];
                $tgl = $format->formatDateTimeForDb($_POST['tgl_berangkat']);
                $waktu = $_POST['waktu'];
                $model->tglberangkatpst = $tgl . " " . $waktu;
                $model->judulsurat = " SURAT JALAN AMBULANCE JEMPUT JENAZAH ";

                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim
                // yang bertandatangan
                $model->ygbertandatangan_id = $_POST['RKSuratketeranganR']['ygbertandatangan_id'];

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'JemputJenazah', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Jalan Ambulance Jemput Jenazah Di Bandara gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'jemputJenazah/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintJemputJenazah($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'jemputJenazah/printJemputJenazah', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Ambulans Jemput Jenazah ke Bandara
    // Tabular : Refraksi Mata
    public function actionRefraksiMata($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->visummtkanan = $_POST['RKSuratketeranganR']['visummtkanan'];
                $model->visummatakiri = $_POST['RKSuratketeranganR']['visummatakiri'];
                $model->fundcopy = $_POST['RKSuratketeranganR']['fundcopy'];
                $model->butawarna = $_POST['RKSuratketeranganR']['butawarna'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT KETERANGAN REFRAKSI MATA ";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'RefraksiMata', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Refraksi Mata gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'refraksiMata/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrintRefraksiMata($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'refraksiMata/printRefraksiMata', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Refraksi Mata
    // Tabular : Pengurusan Paspor
    public function actionPengurusanPaspor($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->tujuan_negara = $_POST['RKSuratketeranganR']['tujuan_negara'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT KETERANGAN PENGURUSAN PASPOR ";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'PengurusanPaspor', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Pengurusan Paspor gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'pengurusanPaspor/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi,
        ));
    }

    public function actionPrintPengurusanPaspor($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'pengurusanPaspor/printPengurusanPaspor', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Pengurusan Paspor
    // Tabular : Surat Rujukan
    public function actionSuratRujukan($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();
        $jenissurat_id = Params::JENISSURAT_RUJUKAN;
        $model->nomorsurat = MyGenerator::noSurat($jenissurat_id, "SKRJK");

        $anamnesa = AnamnesaT::model()->findByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
                ), array(
            'order' => 'anamesa_id desc',
        ));
        if (!empty($anamnesa)) {
            $model->rujukan_anamnesis = $anamnesa->keluhanutama;
        }

        $crFisik = new CDbCriteria();
        $crFisik->join = "left join pemeriksaankala_t k on k.pemeriksaanfisik_id = t.pemeriksaanfisik_id";
        $crFisik->addCondition("k.pemeriksaanfisik_id is null");
        $crFisik->compare('t.pendaftaran_id', $pendaftaran_id);
        $crFisik->order = 't.pemeriksaanfisik_id desc';

        $fisik = PemeriksaanfisikT::model()->find($crFisik);
        if (!empty($fisik)) {
            $model->rujukan_fisik = $fisik->keadaanumum;
        }


        $reseptur = ResepturT::model()->findByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
                ), array(
            'order' => 'reseptur_id desc',
        ));

        if (!empty($reseptur)) {
            $str_resep = "";
            $detail = ResepturdetailT::model()->findAllByAttributes(array(
                'reseptur_id' => $reseptur->reseptur_id,
            ));

            $arr_oa = array();
            foreach ($detail as $item) {
                $str_item = $item->obatalkes->obatalkes_nama . " (" . $item->qty_reseptur;
                $str_item .= empty($item->obatalkes->satuankecil) ? "" : " " . $item->obatalkes->satuankecil->satuankecil_nama;
                $str_item .= ")";

                $arr_oa[] = $str_item;
            }
            $model->rujukan_terapi = implode(", ", $arr_oa);
        }

        // penunjang
        $penunjang = PasienmasukpenunjangV::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
        ));

        $arr_penunjang = array();
        foreach ($penunjang as $item) {

            if (empty($arr_penunjang[$item->instalasi_nama])) {
                $arr_penunjang[$item->instalasi_nama] = array();
            }

            if ($item->instalasi_id == Params::INSTALASI_ID_LAB) {
                $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id,
                ));

                $det = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array(
                    'hasilpemeriksaanlab_id' => $hasil->hasilpemeriksaanlab_id,
                ));

                foreach ($det as $item2) {
                    if (empty($arr_penunjang[$item->instalasi_nama][$item2->pemeriksaanlab_id])) {
                        $arr_penunjang[$item->instalasi_nama][$item2->pemeriksaanlab_id] = $item2->pemeriksaanlab->pemeriksaanlab_nama;
                    }
                }
            } else if ($item->instalasi_id == Params::INSTALASI_ID_RAD) {
                $hasil = HasilpemeriksaanradT::model()->findAllByAttributes(array(
                    'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id,
                ));

                foreach ($hasil as $item2) {
                    if (empty($arr_penunjang[$item->instalasi_nama]["rad_" . $item2->pemeriksaanrad_id])) {
                        $arr_penunjang[$item->instalasi_nama]["rad_" . $item2->pemeriksaanrad_id] = $item2->pemeriksaanrad->pemeriksaanrad_nama;
                    }
                }
            } else if ($item->instalasi_id == Params::INSTALASI_ID_REHAB) {
                $hasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array(
                    'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id,
                ));

                foreach ($hasil as $item2) {
                    if (empty($arr_penunjang[$item->instalasi_nama]["rehab_" . $item2->tindakanrm_id])) {
                        $arr_penunjang[$item->instalasi_nama]["rehab_" . $item2->tindakanrm_id] = $item2->tindakanrm->tindakanrm_nama;
                    }
                }
            }

            /*
              $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
              'pasienmasukpenunjang_id'=>$item->pasienmasukpenunjang_id,
              ));


              foreach ($tindakan as $item2) {
              $arr_penunjang[$item->instalasi_nama][] = $item2->daftartindakan->daftartindakan_nama;
              }
             * 
             */
        }

        $str_penunjang = "";
        foreach ($arr_penunjang as $instalasi => $item) {
            $str_penunjang .= $instalasi . "\n";

            $str_penunjang .= "- " . implode(", ", $item) . "\n";
        }
        $model->rujukan_penunjang = $str_penunjang;
        // var_dump($arr_penunjang); die;


        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = Params::JENISSURAT_RUJUKAN;
                $model->nomorsurat = MyGenerator::noSurat(1, "SKRJK");
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->keterangan = isset($_POST['RKSuratketeranganR']['keterangan']) ? $_POST['RKSuratketeranganR']['keterangan'] : null;
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN RUJUKAN";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->butawarna = isset($_POST['RKSuratketeranganR']['butawarna']) ? $_POST['RKSuratketeranganR']['butawarna'] : "";
                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }

                    Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                    $this->redirect(array(
                        'SuratRujukan', 'pendaftaran_id' => $pendaftaran_id,
                        'suratketerangan_id' => $model->suratketerangan_id
                    ));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Rujukan gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'rujukan/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modAdmisi' => $modAdmisi
        ));
    }

    public function actionPrintSuratRujukan($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

        $model->rujukan_penunjang = str_replace("\n", "<br/>", $model->rujukan_penunjang);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        /*
          if($caraPrint=='PRINT') {
          $this->layout='//layouts/printWindows';
          }
          $this->render($this->path_view.'rujukan.printSuratRujukan',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'model'=>$model,
          'judulLaporan'=>$judulLaporan,
          'caraPrint'=>$caraPrint));
         * 
         */

        $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'rujukan.printSuratRujukan', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'model' => $model,
                    'judulLaporan' => $judulLaporan,
                    'caraPrint' => $caraPrint
                        ), true));
        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }

    // end Tabular Surat Rujukan

    public function actionDaftarPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $format = new MyFormatter();
            $criteria->select = 'pendaftaran_t.pendaftaran_id,pendaftaran_t.instalasi_id, pasienadmisi_t.caramasuk_id, t.pasien_id, pendaftaran_t.pasienadmisi_id, t.nama_pasien,
                                     pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,jeniskelamin,no_rekam_medik,
                                     carabayar_m.carabayar_id,carabayar_m.carabayar_nama,penjaminpasien_m.penjamin_id,penjaminpasien_m.penjamin_nama,
                                     umur,jeniskasuspenyakit_m.jeniskasuspenyakit_nama,ruangan_m.ruangan_nama, t.namadepan';

            if (isset($_GET['term']))
                $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['term']), true);
            else if (isset($_GET['term2']))
                $criteria->compare('LOWER(t.nama_pasien)', strtolower($_GET['term2']), true);

            $criteria->limit = 5;

            $criteria->join = 'JOIN pendaftaran_t ON t.pasien_id = pendaftaran_t.pasien_id
                            LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                            LEFT JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                            LEFT JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
                            LEFT JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                            LEFT JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                            LEFT JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id';
            $criteria->order = 'pendaftaran_t.tgl_pendaftaran DESC';
            //kembalikan format

            $models = RKPasienM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . ' - ' . $model->no_pendaftaran . ' - ' . $format->formatDateTimeForUser($model->tgl_pendaftaran); //.' - '.$model->statusperiksa
                $returnVal[$i]['value'] = $model->no_rekam_medik;
                $returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
                $returnVal[$i]['namapasien'] = $model->namadepan . $model->nama_pasien;
                $returnVal[$i]['namabin'] = $model->nama_bin;
                $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit_nama;
                $returnVal[$i]['namainstalasi'] = $model->instalasi_nama;
                $returnVal[$i]['namaruangan'] = $model->ruangan_nama;
                $returnVal[$i]['carabayar_nama'] = $model->carabayar_nama;
                $returnVal[$i]['penjamin_nama'] = $model->penjamin_nama;
                $returnVal[$i]['no_pendaftaran'] = $model->no_pendaftaran;
                $returnVal[$i]['tgl_pendaftaran'] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
                $returnVal[$i]['pendaftaran_id'] = $model->pendaftaran_id;
                $returnVal[$i]['pasienadmisi_id'] = $model->pasienadmisi_id;
                $returnVal[$i]['instalasi_id'] = $model->instalasi_id;
                $returnVal[$i]['caramasuk_id'] = $model->caramasuk_id;
                $returnVal[$i]['umur'] = $model->umur;
                $returnVal[$i]['jeniskasuspenyakit_nama'] = $model->jeniskasuspenyakit_nama;
                //cari tanggungan penjamin
                $criteria = new CDbCriteria();
                if (!empty($model->penjamin_id)) {
                    $criteria->addCondition("pendaftaran_t.penjamin_id = " . $model->penjamin_id);
                }
                if (!empty($model->kelaspelayanan_id)) {
                    $criteria->addCondition("pendaftaran_t.kelaspelayanan_id = " . $model->kelaspelayanan_id);
                }
                if (!empty($model->carabayar_id)) {
                    $criteria->addCondition("pendaftaran_t.carabayar_id = " . $model->carabayar_id);
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function terbilang($x, $style = 4, $strcomma = ",") {
        if ($x < 0) {
            $result = "minus " . trim($this->ctword($x));
        } else {
            $arrnum = explode("$strcomma", $x);
            $arrcount = count((array) $arrnum);
            if ($arrcount == 1) {
                $result = trim($this->ctword($x));
            } else if ($arrcount > 1) {
                $result = trim($this->ctword($arrnum[0])) . " koma " . trim($this->ctword($arrnum[1]));
            }
        }
        switch ($style) {
            case 1: //1=uppercase  dan
                $result = strtoupper($result);
                break;
            case 2: //2= lowercase
                $result = strtolower($result);
                break;
            case 3: //3= uppercase on first letter for each word
                $result = ucwords($result);
                break;
            default: //4= uppercase on first letter
                $result = ucfirst($result);
                break;
        }
        return $result;
    }

    public function ctword($x) {
        $x = abs((int) $x);
        $number = array(
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        );
        $temp = "";

        if ($x < 12) {
            $temp = " " . $number[$x];
        } else if ($x < 20) {
            $temp = $this->ctword($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->ctword($x / 10) . " puluh" . $this->ctword($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->ctword($x - 100);
        } else if ($x < 1000) {
            $temp = $this->ctword($x / 100) . " ratus" . $this->ctword($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . $this->ctword($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->ctword($x / 1000) . " ribu" . $this->ctword($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->ctword($x / 1000000) . " juta" . $this->ctword($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->ctword($x / 1000000000) . " milyar" . $this->ctword(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = $this->ctword($x / 1000000000000) . " trilyun" . $this->ctword(fmod($x, 1000000000000));
        }
        return $temp;
    }

    // Tabular : Surat Keterangan Sehat
    /**
     * Digunakan sebagai halaman index surat keterangan sehat 
     * @param type $pendaftaran_id
     * @param type $suratketerangan_id
     */
    public function actionIndexKeteranganSehat($pendaftaran_id = null, $suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $model = new RKSuratketeranganR();
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modLampiran = new RKLampiransuratsehatR();

        if (isset($_POST['RKSuratketeranganR'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (empty($_POST['RKSuratketeranganR']['suratketerangan_id'])) {
                    $model = new RKSuratketeranganR();
                } else {
                    $model = SuratketeranganR::model()->findByPk($_POST['RKSuratketeranganR']['suratketerangan_id']);
                }

                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = $format->formatDateTimeForDb($_POST['tglsurat']);
                $model->jenissurat_id = $model->jenissurat_id;

                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                if (!empty($modPendaftaran->pegawai_id)) {
                    $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                } else {
                    $model->mengetahuipeg_id = $_POST['RKSuratketeranganR']['mengetahuipeg_id'];
                }
                $modPegawai = PegawaiM::model()->findByPk($model->mengetahuipeg_id);
                $model->mengetahui_surat = $modPegawai->namaLengkap;
                $model->keterangan = isset($_POST['RKSuratketeranganR']['keterangan']) ? $_POST['RKSuratketeranganR']['keterangan'] : null;
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->judulsurat = "SURAT KETERANGAN SEHAT";

                if (empty($_POST['RKSuratketeranganR']['suratketerangan_id'])) {
                    if ($model->jenissurat_id == 9) {
                        $model->nomorsurat = MyGenerator::noSuratSehat($pendaftaran_id, $modPendaftaran->pasien_id, $model->jenissurat_id);
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                        // $model->no_sk = $_POST['RKSuratketeranganR']['no_sk'];
                    } elseif ($model->jenissurat_id == 10) {
                        $model->nomorsurat = MyGenerator::noSuratDokter($pendaftaran_id, $modPendaftaran->pasien_id, $model->jenissurat_id);
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 11) {
                        $model->nomorsurat = MyGenerator::noSuratLab($pendaftaran_id, $modPendaftaran->pasien_id, $model->jenissurat_id);
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 12) {
                        $model->nomorsurat = MyGenerator::noSuratLabDokter($pendaftaran_id, $modPendaftaran->pasien_id, $model->jenissurat_id);
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 14) {
                        $model->nomorsurat = MyGenerator::noSuratFisikMental($pendaftaran_id, $modPendaftaran->pasien_id, $model->jenissurat_id);
                        $model->npaidi_dokter = $_POST['RKSuratketeranganR']['npaidi_dokter'];
                        $model->idi_cabang = $_POST['RKSuratketeranganR']['idi_cabang'];
                        $model->suratkeputusan = $_POST['RKSuratketeranganR']['suratkeputusan'];
                        $model->suratkeputusan_no = $_POST['RKSuratketeranganR']['suratkeputusan_no'];
                        $model->no_sk = $_POST['RKSuratketeranganR']['no_sk'];
                        $model->spesialis = $_POST['RKSuratketeranganR']['spesialis'];
                    }
                    $model->create_time = date('Y-m-d');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    if ($model->jenissurat_id == 9) {
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                        // $model->no_sk = $_POST['RKSuratketeranganR']['no_sk'];
                    } elseif ($model->jenissurat_id == 10) {
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 11) {
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 12) {
                        $model->tinggibadan = $_POST['RKSuratketeranganR']['tinggibadan'];
                        $model->beratbadan = $_POST['RKSuratketeranganR']['beratbadan'];
                        $model->tekanandarah_sistolik = $_POST['RKSuratketeranganR']['tekanandarah_sistolik'];
                        $model->tekanandarah_diastolik = $_POST['RKSuratketeranganR']['tekanandarah_diastolik'];
                    } elseif ($model->jenissurat_id == 14) {
                        $model->npaidi_dokter = $_POST['RKSuratketeranganR']['npaidi_dokter'];
                        $model->idi_cabang = $_POST['RKSuratketeranganR']['idi_cabang'];
                        $model->suratkeputusan = $_POST['RKSuratketeranganR']['suratkeputusan'];
                        $model->suratkeputusan_no = $_POST['RKSuratketeranganR']['suratkeputusan_no'];
                        $model->no_sk = $_POST['RKSuratketeranganR']['no_sk'];
                        $model->spesialis = $_POST['RKSuratketeranganR']['spesialis'];
                    }
                    $model->nomorsurat = $model->nomorsurat;
                    $model->update_time = date('Y-m-d');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }

                if (!empty($modFisik)) {
                    // Update Berat Badan dll ketika data pasien ada di McuPemeriksaanumumT
                    $modFisik->tinggibadan = isset($_POST['RKSuratketeranganR']['tinggibadan']) ? $_POST['RKSuratketeranganR']['tinggibadan'] : $modFisik->tinggibadan;
                    $modFisik->beratbadan = isset($_POST['RKSuratketeranganR']['beratbadan']) ? $_POST['RKSuratketeranganR']['beratbadan'] : $modFisik->beratbadan;
                    $modFisik->tekanandarah_sistolik = isset($_POST['RKSuratketeranganR']['tekanandarah_sistolik']) ? $_POST['RKSuratketeranganR']['tekanandarah_sistolik'] : $modFisik->tekanandarah_sistolik;
                    $modFisik->tekanandarah_diastolik = isset($_POST['RKSuratketeranganR']['tekanandarah_diastolik']) ? $_POST['RKSuratketeranganR']['tekanandarah_diastolik'] : $modFisik->tekanandarah_diastolik;
                    $modFisik->save();
                }

                if ($model->validate()) {
                    if ($model->save()) {

                        //Insert Lampiran
                        RKLampiransuratsehatR::model()->deleteAllByAttributes(array('suratketerangan_id' => $model->suratketerangan_id));
                        if (isset($_POST['RKLampiransuratsehatR'])) {
                            $ok = true;
                            foreach ($_POST['RKLampiransuratsehatR'] as $i => $item) {
                                if (is_integer($i)) {
                                    $modLampiran = new RKLampiransuratsehatR;
                                    if (isset($_POST['RKLampiransuratsehatR'][$i])) {
                                        $modLampiran->attributes = $_POST['RKLampiransuratsehatR'][$i];
                                        $modLampiran->suratketerangan_id = $model->suratketerangan_id;
                                        $ok = $ok && $modLampiran->save();
                                    }
                                }
                            }
                        } else {
                            $ok = true;
                        }

                        if ($ok) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                            $this->redirect(array('IndexKeteranganSehat', 'pendaftaran_id' => $pendaftaran_id, 'suratketerangan_id' => $model->suratketerangan_id, 'jenissurat_id' => $model->jenissurat_id));
                        } else {
                            $transaction->rollback();
                        }
                    } else {
                        echo "gagal Simpan";
                        exit;
                    }
                }
            } catch (Exception $exc) {

                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Keterangan Berbadan Sehat gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'keteranganSehat/index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modFisik' => $modFisik,
            'modLampiran' => $modLampiran
        ));
    }

    /**
     * Digunakan untuk load form surat kesehatan
     */
    public function actionLoadForm1() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $jenissurat_id = isset($_POST['jenissurat_id']) ? $_POST['jenissurat_id'] : null;

            $model = RKSuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $id, 'jenissurat_id' => $jenissurat_id));
            if (!empty($model)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();

                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehat', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            } else {

                $model = new RKSuratketeranganR();
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();
                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                $model->tglsurat = date('d M Y');
                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehat', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk load form surat kesehatan dokter
     */
    public function actionLoadForm2() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $jenissurat_id = isset($_POST['jenissurat_id']) ? $_POST['jenissurat_id'] : null;

            $model = RKSuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $id, 'jenissurat_id' => $jenissurat_id));
            if (!empty($model)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();

                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatDokter', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            } else {
                $model = new RKSuratketeranganR();
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();
                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                $model->tglsurat = date('d M Y');
                if (!empty($modPendaftaran->pegawai_id)) {
                    $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                    $model->dokter = $cekPegawai->namaLengkap;
                    $model->jabatan = (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
                }
                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatDokter', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk load form surat kesehatan laboratorium
     */
    public function actionLoadForm3() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $jenissurat_id = isset($_POST['jenissurat_id']) ? $_POST['jenissurat_id'] : null;

            $model = RKSuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $id, 'jenissurat_id' => $jenissurat_id));
            if (!empty($model)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();

                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatLaboratorium', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            } else {

                $model = new RKSuratketeranganR();
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();
                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                $model->tglsurat = date('d M Y');
                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatLaboratorium', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk load form surat kesehatan dokter
     */
    public function actionLoadForm4() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $jenissurat_id = isset($_POST['jenissurat_id']) ? $_POST['jenissurat_id'] : null;

            $model = RKSuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $id, 'jenissurat_id' => $jenissurat_id));
            if (!empty($model)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();

                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatDokterLaboratorium', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            } else {
                $model = new RKSuratketeranganR();
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();
                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                $model->tglsurat = date('d M Y');
                if (!empty($modPendaftaran->pegawai_id)) {
                    $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                    $model->dokter = $cekPegawai->namaLengkap;
                    $model->jabatan = (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
                }
                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatDokterLaboratorium', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk load form surat keterangan fisik dan mental
     */
    public function actionLoadForm5() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $jenissurat_id = isset($_POST['jenissurat_id']) ? $_POST['jenissurat_id'] : null;

            $model = RKSuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $id, 'jenissurat_id' => $jenissurat_id));
            if (!empty($model)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();

                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatFisikdanMental', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            } else {
                $model = new RKSuratketeranganR();
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modFisik = McuPemeriksaanumumT::model()->findByAttributes(array('pendaftaran_id' => $id));
                $modLampiran = new RKLampiransuratsehatR();
                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                $model->tglsurat = date('d M Y');
                if (!empty($modPendaftaran->pegawai_id)) {
                    $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                    $model->dokter = $cekPegawai->namaLengkap;
                    $model->jabatan = (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
                }
                $data['suratketerangan_id'] = $model->suratketerangan_id;
                $data['sukses'] = 1;
                $data['html'] = $this->renderPartial($this->path_view . 'keteranganSehat.suratKeteranganSehatFisikdanMental', array(
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modPendaftaran' => $modPendaftaran,
                    'modFisik' => $modFisik,
                    'modLampiran' => $modLampiran
                        ), true);
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * menegenerate printout surat keterangan sehat untuk umum
     * @param type $suratketerangan_id
     */
    public function actionPrintSuratKeteranganSehat($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'keteranganSehat.printSuratKeteranganSehat', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }
    public function actionPrintSuratKelayakanCovid19($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'suratKelayakanCovid19/printNew', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * menegenerate printout surat keterangan sehat laboratorium untuk umum
     * @param type $suratketerangan_id
     */
    public function actionPrintSuratKeteranganSehatLaboratorium($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'keteranganSehat.printSuratKeteranganSehatLaboratorium', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * menegenerate printout surat keterangan sehat untuk dokter
     * @param type $suratketerangan_id
     */
    public function actionPrintSuratKeteranganSehatDokter($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'keteranganSehat.printSuratKeteranganSehatDokter', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * menegenerate printout surat keterangan sehat laboratorium untuk dokter
     * @param type $suratketerangan_id
     */
    public function actionPrintSuratKeteranganSehatDokterLaboratorium($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'keteranganSehat.printSuratKeteranganSehatDokterLaboratorium', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    // end Tabular Surat Keterangan Sehat

    /**
     * menegenerate printout surat keterangan sehat laboratorium untuk dokter
     * @param type $suratketerangan_id
     */
    public function actionPrintSuratKeteranganSehatFisikdanMental($suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPendaftaran = RKPendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id' => $suratketerangan_id));

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'keteranganSehat.printSuratKeteranganSehatFisikdanMental', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modFisik' => $modFisik,
            'model' => $model,
            'modLampiran' => $modLampiran,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * Ajax Load data SIP dokter MCU
     */
    /*
      public function actionGenerateSIP() {
      if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
      }
      echo CJSON::encode($this->loadData($_POST['peg']));
      }

      /**
     * Load data dropdown dokter pemeriksa dipilih
     * @param type $peg
     * @return type
     */
    /*
      public function loadData($peg){
      $ok = 1;
      $msg = " ";
      // $model = StrT::model()->findByAttributes(array('pegawai_id' => $peg, 'jenis_str' => 'SIP'));
      $model = PegawaiM::model()->findByPk($peg);

      // Jika STR tidak ditamukan maka muncul warning"
      if (empty($model)) {
      $ok = 0;
      $msg = "Nomor SIP di Pencatatan Pegawai belum diisi";

      return array('ok'=>$ok, 'msg'=>$msg);
      }

      $data = $model->attributes;
      return array('ok'=>$ok, 'msg'=>$msg, 'data'=>$data);
      } */

    // Tabular : Istirahat 
    public function actionPemeriksaanMata($pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $jenisSurat = JenissuratM::model()->findByPk(ParamsConst::SURAT_KETERANGAN_PEMERIKSAAN_MATA_ID);
        if (!empty($jenisSurat)){
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $cekSurat = RKSuratketeranganR::model()->findByAttributes([
               'pendaftaran_id' => $pendaftaran_id 
            ]);
            if (!empty($cekSurat)){
                $model = $cekSurat;
            }else{
                $model->nomorsurat = MyGenerator::noSurat($jenisSurat->jenissurat_id, "SKPM");
            }
            
            $modFisik = PemeriksaanfisikT::model()->findByAttributes([
               'pendaftaran_id' => $pendaftaran_id
            ]);
            if (empty($modFisik)){
                $modFisik = new PemeriksaanfisikT;
            }

            if (isset($_POST['RKSuratketeranganR'])) {            


                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $model->attributes = $_POST['RKSuratketeranganR'];
                    $model->tglsurat = date('Y-m-d');
                    $model->jenissurat_id = 1;
                    $model->nourutsurat = 1;
                    $model->pendaftaran_id = $pendaftaran_id;
                    $model->pasien_id = $modPendaftaran->pasien_id;
                    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $model->jmlprint_surat = 1;
                    $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                    $model->profilrs_id = 1;
                    $model->judulsurat = $jenisSurat->jenissurat_namalain;                                        

                    $model->create_time = date('Y-m-d');
                    $model->update_time = date('Y-m-d');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    if ($model->save()) {
                        $transaction->commit();
                       
                        Yii::app()->user->setFlash('success', $jenisSurat->jenissurat_nama." berhasil disimpan");
                        $this->redirect(array(
                            'pemeriksaanMata', 'pendaftaran_id' => $pendaftaran_id,
                            'suratketerangan_id' => $model->suratketerangan_id
                        ));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $jenisSurat->jenissurat_nama." gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                }
            }
            $this->render($this->path_view . 'pemeriksaanMata/index', array(
                'model' => $model,
                'modPasien' => $modPasien,
                'modPendaftaran' => $modPendaftaran,
                'modFisik' => $modFisik
            ));
        }
    }

    public function actionPrintPemeriksaanMata($suratketerangan_id) {
        $this->layout = '//layouts/iframe';
        
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        $modPasien = RKPasienM::model()->findByPk($model->pasien_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modFisik = PemeriksaanfisikT::model()->findByAttributes([
           'pendaftaran_id'=>$model->pendaftaran_id 
        ]);
        if (empty($modFisik)){
            $modFisik = new PemeriksaanfisikT;
        }
        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'pemeriksaanMata/print', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint,
            'modFisik' => $modFisik
        ));
    }

  // Tabular : Surat Kesehatan Jiwa
  public function actionSuratKesehatanJiwa($pendaftaran_id = null, $suratketerangan_id = null)
  {
    $this->layout = '//layouts/iframe';
    $form = '';
    $format = new MyFormatter();
    $modPasien = new RKPasienM;
    $modPendaftaran = new RKPendaftaranT;
    $modAdmisi = new PasienadmisiT();

    if (!empty($suratketerangan_id)) {
      $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
    } else { 
      $model = new RKSuratketeranganR;
      $model->nomorsurat = MyGenerator::noSuratCpt("MMPISA", 57); //disamakan dengan id jenissurat
      // $model->nomorsurat = MyGenerator::noSurat(99998, "SKJ");
      $model->judulsurat = "SURAT KETERANGAN KESEHATAN JIWA";
      $model->mengetahui_surat = "dr. RINES HARLEN THEODORA, Sp.KJ.";
      $model->qrcode = MyGenerator::noSuratCpt2(57); //nosurat untuk qrcode
    }

    // var_dump($model->attributes); die;

    if (isset($_POST['RKSuratketeranganR'])) {
      $pendaftaran_id = $_GET['pendaftaran_id'];
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RKSuratketeranganR'];
        $model->tglsurat = date('Y-m-d');
        // $model->jenissurat_id = 99998;
        $model->jenissurat_id = Params::SURAT_KETERANGAN_KESEHATAN_JIWA;
        $model->nourutsurat = 1;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPasien->pasien_id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jmlprint_surat = 1;
        $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
        // $model->keterangan = isset($_POST['RKSuratketeranganR']['keterangan']) ? $_POST['RKSuratketeranganR']['keterangan'] : null;
        $model->profilrs_id = 1;
        $model->judulsurat = "SURAT KETERANGAN KESEHATAN JIWA";
        $model->tgl_periksa = MyFormatter::formatDateTimeForDb($model->tgl_periksa);

        $model->create_time = date('Y-m-d');
        $model->update_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $model->psikopatologi = isset($_POST['RKSuratketeranganR']['psikopatologi']) ? $_POST['RKSuratketeranganR']['psikopatologi'] : null;
        $model->kepribadian = isset($_POST['RKSuratketeranganR']['kepribadian']) ? $_POST['RKSuratketeranganR']['kepribadian'] : null;
        $model->nama_pegawai_instansi = isset($_POST['RKSuratketeranganR']['nama_pegawai_instansi']) ? $_POST['RKSuratketeranganR']['nama_pegawai_instansi'] : null;
        $model->jabatan_instansi = isset($_POST['RKSuratketeranganR']['jabatan_instansi']) ? $_POST['RKSuratketeranganR']['jabatan_instansi'] : null;
        $model->instansi_instansi = isset($_POST['RKSuratketeranganR']['instansi_instansi']) ? $_POST['RKSuratketeranganR']['instansi_instansi'] : null;
        $model->perihal_instansi = isset($_POST['RKSuratketeranganR']['perihal_instansi']) ? $_POST['RKSuratketeranganR']['perihal_instansi'] : null;
        

        // if (is_array($model->hasilperiksanarkoba)) {
        //   $model->hasilperiksanarkoba = CJSON::encode($model->hasilperiksanarkoba);
        // }

        // var_dump($model->attributes, $_POST); die;
        
        if ($model->validate()) {
          if ($model->save()) {
            // echo "OK"; die;
            $transaction->commit();
            $model->isNewRecord = FALSE;
            if (!empty($_GET['pendaftaran_id'])) {
              $model->suratketerangan_id = $model->suratketerangan_id;
            }
          } else {
            // var_dump($model->errors); die;
            // echo "gagal Simpan";
            exit;
          }

          Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
          $this->redirect(array(
            'suratKesehatanJiwa', 'pendaftaran_id' => $pendaftaran_id,
            'suratketerangan_id' => $model->suratketerangan_id
          ));
        }
      } catch (Exception $exc) {
        // $transaction->rollback(); var_dump($exc->getMessage()); die;
        Yii::app()->user->setFlash('error', "Surat Keterangan Pemeriksaan Wawancara Psikiatrik dan Tes Psikometrik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    // var_dump($model->attributes); die;
    $this->render($this->path_view . 'suratKesehatanJiwa/index', array(
      'model' => $model,
      'form' => $form,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi
    ));
  }

  public function actionPrintSuratKesehatanJiwa($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

    $judulLaporan = '';

    $caraPrint = $_REQUEST['caraPrint'];
    /*
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'badanSehat.printSuratBerbadanSehatV2',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
         * 
         */
    $ukuranKertasPDF = 'A4';                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
    $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
    $mpdf->WriteHTML($formatkonten, 1);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($this->renderPartial($this->path_view . 'suratKesehatanJiwa.printSuratKesehatanJiwa', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint
    ), true));
    $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
  }
  
  // Tabular : Surat kelayakan covid-19
    public function actionSuratKelayakanCovid19($pendaftaran_id = null, $suratketerangan_id = null) {
        $this->layout = '//layouts/iframe';
        $form = '';
        $format = new MyFormatter();

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);       
        
        $modPendaftaran->dokter_pemeriksa = $modPendaftaran->pegawai->namaLengkap;
        
        if (!empty($suratketerangan_id)) {
            $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        } else {
            $model = new RKSuratketeranganR;
            $model->nomorsurat = MyGenerator::noSurat(Params::SURAT_KETERANGAN_KELAYAKAN_COVID19); //disamakan dengan id jenissurat
            $model->judulsurat = "SURAT KETERANGAN KELAYAKAN VAKSINASI COVID-19";
            $model->mengetahui_surat = !empty($modPendaftaran) ? $modPendaftaran->pegawai->namaLengkap : '-';                        
        }

        if (isset($_POST['RKSuratketeranganR'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = Params::SURAT_KETERANGAN_KELAYAKAN_COVID19;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->tgl_periksa = MyFormatter::formatDateTimeForDb($model->tgl_periksa);
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                // echo "<pre>";
                // var_dump($model);die;

                if ($model->validate()) {
                    if ($model->save()) {
                        // echo "OK"; die;
                        $trans->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                        
                        Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                        $this->redirect(array(
                            'suratKelayakanCovid19', 'pendaftaran_id' => $pendaftaran_id,
                            'suratketerangan_id' => $model->suratketerangan_id
                        ));
                    }else{
                        Yii::app()->user->setFlash('error', "Surat Keterangan Pemeriksaan Wawancara Psikiatrik dan Tes Psikometrik gagal disimpan ");
                        $trans->rollback();
                    }
                }
            } catch (Exception $exc) { 
                var_dump($exc->getMessage());die;               
                Yii::app()->user->setFlash('error', "Surat Keterangan Pemeriksaan Wawancara Psikiatrik dan Tes Psikometrik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $trans->rollback();
            }
        }

        $this->render($this->path_view . 'suratKelayakanCovid19/index', array(
            'model' => $model,
            'form' => $form,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionSuratKeteranganbebas($pendaftaran_id = null, $suratketerangan_id = null)
    {
        $this->layout = '//layouts/iframe';
        // $modJenisSurat=new RKJenisSuratM;
        $model = new RKSuratketeranganR;
        $form = '';
        $format = new MyFormatter();

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);       
        
        $modPendaftaran->dokter_pemeriksa = $modPendaftaran->pegawai->namaLengkap;
      
        if (!empty($suratketerangan_id)) {
            $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
        } else {
            $model = new RKSuratketeranganR;
            $model->nomorsurat = MyGenerator::noSurat(Params::SURAT_KETERANGAN_KELAYAKAN_COVID19); //disamakan dengan id jenissurat
            $model->judulsurat = "SURAT KETERANGAN";
            $model->mengetahui_surat = !empty($modPendaftaran) ? $modPendaftaran->pegawai->namaLengkap : '-';                        
        }
        // $model->mengetahuipeg_id = $modApproval->direkturrs_id;    
        // if (isset($_GET['sukses']) && $_GET['sukses'] == 1) {
        //     $model = $this->loadModel($_GET['id']);

        //     $model->keterangan = strip_tags($model->keterangan);

        // }
        if(isset($_POST['RKSuratketeranganR']))
        {
                // $model->attributes=$_POST['RKSuratketeranganR'];
            $trans = Yii::app()->db->beginTransaction();   
            try{
                $model->attributes = $_POST['RKSuratketeranganR'];
                $model->tglsurat = date('Y-m-d');
                $model->jenissurat_id = Params::SURAT_KETERANGAN;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->tgl_periksa = MyFormatter::formatDateTimeForDb($model->tgl_periksa);
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->keterangan = isset($_POST['RKSuratketeranganR']['keterangan']) ? $_POST['RKSuratketeranganR']['keterangan'] : null;

                if ($model->validate()) {
                    if ($model->save()) {
                        // echo "OK"; die;
                        $trans->commit();
                        $model->isNewRecord = FALSE;
                        if (!empty($_GET['pendaftaran_id'])) {
                            $model->suratketerangan_id = $model->suratketerangan_id;
                        }
                        
                        Yii::app()->user->setFlash('success', 'Data ' . $model->nomorsurat . ' berhasil disimpan.');
                        $this->redirect(array(
                            'suratKeteranganbebas', 'pendaftaran_id' => $pendaftaran_id,
                            'suratketerangan_id' => $model->suratketerangan_id
                        ));
                    }else{
                        Yii::app()->user->setFlash('error', "Surat Keterangan gagal disimpan ");
                        $trans->rollback();
                    }
                }
            }catch (Exception $exc){
                var_dump($exc->getMessage());die;               
                Yii::app()->user->setFlash('error', "Surat Keterangan gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $trans->rollback();
            }
            // if ($_POST['RKSuratketeranganR_pegawaittd']) {
            //         $image_text = str_replace('data:image/png;base64,', '', $_POST['KUSuratketeranganT_pegawaittd']);
            //         $name = substr(md5(microtime()),rand(0,26),5);
            //         $filename = $name.'.png';

            //         $image_text = str_replace(' ', '+', $image_text);
            //         $image_text = base64_decode($image_text);                        
            //         $file = Params::pathResepturDirectory().$filename;
            //         $success = file_put_contents($file, $image_text);            
            //         $source_img = imagecreatefromstring($image_text);                                
            //         $model->pegawaittd_image = $filename;

            //         imagedestroy($source_img);
            //     }
            //     if($model->save()){
            //             Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            //             $this->redirect(array('index','id'=>$model->suratketerangan_id,'sukses' => 1));
            //     }
        }

        $this->render($this->path_view.'suratKeteranganBebas/index',array(
            'model' => $model,
            'form' => $form,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
        ));
    }

    public function actionPrint($suratketerangan_id = null){
        $this->layout = '//layouts/iframe';

        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);    
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id); 
        // var_dump($modPendaftaran);die;       

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'suratKeteranganBebas.print',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }

}
