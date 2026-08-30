<?php

/**
 * Inform Consent
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.rawatDarurat
 * @subpackage controllers
 * @category Controller
 */
class AsesmenRadiologiController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'radiologi.views.asesmenRadiologi.';
    // public $path_view_keterangan = 'rawatDarurat.views.persetujuanTindakanTRD.';
    // public $url_persetujuan = 'persetujuanTindakanTRD';
    // public $url_inform_consent = 'asesmenRadiologi';

    public function actionIndex($pendaftaran_id, $persetujuan_id = null, $frame = 0) {

        if ($frame) {
            $this->layout = '//layouts/iframe';
        }

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modRadiologi = new AsesmenawalradiologiT;

        $modRadiologi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modRadiologi->pasien_id = $modPendaftaran->pasien_id;
        $modRadiologi->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modRadiologi->penanggungjawab_id = $modPendaftaran->penanggungjawab_id;

        $modRadiologiDet = new AsesmenawalradiologidetT;

        // if (!empty($modPendaftaran->pasienadmisi_id)) {
        //     $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        //     $modRadiologi->dokter_id = $admisi->pegawai_id;
        // }
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        if (isset($_POST['AsesmenawalradiologiT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {

                // echo '<pre>'; var_dump($_POST['AsesmenawalradiologiT']); die;

                $modRadiologi->attributes = $_POST['AsesmenawalradiologiT'];
                $modRadiologi->tanggal_asesmenawal = MyFormatter::formatDateTimeForDb($_POST['AsesmenawalradiologiT']['tanggal_asesmenawal']);
                $modRadiologi->riwayatalergi = isset($_POST['AsesmenawalradiologiT']['riwayatalergi']) ? json_encode($_POST['AsesmenawalradiologiT']['riwayatalergi']) : '';
                $modRadiologi->riwayatkebiasaan = isset($_POST['AsesmenawalradiologiT']['riwayatkebiasaan']) ? json_encode($_POST['AsesmenawalradiologiT']['riwayatkebiasaan']) : '';
                $modRadiologi->riwayatalergi_lainnya = $_POST['AsesmenawalradiologiT']['riwayatalergi_lainnya'];
                $modRadiologi->riwayatkebiasaan_lainnya = $_POST['AsesmenawalradiologiT']['riwayatkebiasaan_lainnya'];
                $modRadiologi->status_persetujuan = $_POST['AsesmenawalradiologiT']['status_persetujuan'];
                $modRadiologi->riwayatpenyakit = $_POST['AsesmenawalradiologiT']['riwayatpenyakit'];
                if ($modRadiologi->isNewRecord) {
                    $modRadiologi->create_time = date('Y-m-d H:i:s');
                    $modRadiologi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modRadiologi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $modRadiologi->update_time = date('Y-m-d H:i:s');
                    $modRadiologi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }

                $ok = $ok && $modRadiologi->save();

                if ($ok) {
                    // echo '<pre>';var_dump('masuk', $_POST);die;
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id' => $pendaftaran_id, 'frame' => $frame, 'sukses' => 1));
                } else {
                    // echo '<pre>';var_dump('gagal',$modRadiologi->validate(), $modRadiologi->getErrors(), $_POST);die;
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan.");
                }
            } catch (Exception $ex) {
                // echo '<pre>';var_dump('keluar',$ex, $_POST);die;
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $urlDir = $this->path_view . 'index';
        if ($this->module->id == 'radiologi') {
            $urlDir = $this->path_view . 'index';
        }

        $anamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modRadiologi->keluhan = empty($anamnesa) ? '' : $anamnesa->keluhanutama;
        $modRadiologi->riwayatpenyakit = empty($anamnesa) ? '' : $anamnesa->riwayatpenyakitterdahulu;

        $modRadiologi->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $pegawai = PegawairuanganV::model()->findByAttributes(array('pegawai_id' => $modRadiologi->pegawai_id));
        $modRadiologi->pegawai_nama = $pegawai->nama_pegawai;
        $modRadiologi->tanggal_asesmenawal = date('d M Y H:i:s');

        $this->render($urlDir, array(
            'modPendaftaran' => $modPendaftaran,
            'modRadiologi' => $modRadiologi,
            'modRadiologiDet' => $modRadiologiDet,
            'modPasien' => $modPasien,
            'anamnesa' => $anamnesa
        ));
    }

    public function actionPenolakan($pendaftaran_id = null, $persetujuan_id = null, $frame = 0) {

        if ($frame) {
            $this->layout = '//layouts/iframe';
        }

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $model = new SuratpersetujuantmT;
        $modInform = new InformconsentT;
        $inform = new InformconsentT();

        $model->pendaftaran_id = $pendaftaran_id;
        $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;

        $model->dokter_id = $modPendaftaran->pegawai_id;

        if (!empty($modPendaftaran->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $model->dokter_id = $admisi->pegawai_id;
        }


        if (!empty($persetujuan_id)) {
            $model = SuratpersetujuantmT::model()->findByPk($persetujuan_id);
            $model->pemberiinformasi_nama = !empty($model->pemberiinfo) ? $model->pemberiinfo->namaLengkap : null;

            $inform = InformconsentT::model()->findByAttributes(array(
                'suratpersetujuantm_id' => $persetujuan_id,
            ));

            $inform->informasi_tindakan_medis = CJSON::decode($inform->informasi_tindakan_medis);
        }

        if (!empty($modPendaftaran->pasien)) {
            $modPas = $modPendaftaran->pasien;
            $model->nama_pasien = $modPas->nama_pasien;
            $model->jeniskelamin = $modPas->jeniskelamin;
            $model->alamat_pasien = $modPas->alamat_pasien;
            $model->umur = $modPendaftaran->umur;
            $model->no_rekam_medik = $modPas->no_rekam_medik;
            $model->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPas->tanggal_lahir);
        }

        if (isset($_POST['SuratpersetujuantmT']) && isset($_POST['InformconsentT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {

                $model->attributes = $_POST['SuratpersetujuantmT'];
                $model->tglpersetujuan = $model->create_time = date('Y-m-d H:i:s');
                $model->nopersetujuan = MyGenerator::noPersetujuan();
                $model->nama_menyetujui = $model->nama_yangmenyetujui;

                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->ruangan_id = $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->tindakanterhadap = "-";
                $model->alamat_menyetujui = "-";
                $model->jeniskelamin_menyetujui = "-";
                $model->umur_menyetujui = "-";

                if ($model->validate()) {
                    $ok = $ok && $model->save();

                    $inform->attributes = $_POST['InformconsentT'];
                    $inform->informasi_tindakan_medis = CJSON::encode($inform->informasi_tindakan_medis);
                    $inform->suratpersetujuantm_id = $model->suratpersetujuantm_id;

                    $ok = $ok && $inform->save();
                } else {
                    $ok = false;
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Inform Consent berhasil disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id' => $pendaftaran_id, 'persetujuan_id' => $model->suratpersetujuantm_id, 'frame' => $frame));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id' => $pendaftaran_id, 'frame' => $frame));
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }


        $urlDir = $this->path_view . 'index';
        if ($this->module->id == 'rawatDarurat') {
            $urlDir = $this->path_view . 'indexNew';
        }

        $this->render($urlDir, array(
            'modPendaftaran' => $modPendaftaran,
            'model' => $model,
            'inform' => $inform,
            'frame' => $frame,
            'modInform' => $modInform
        ));
    }

    public function actionPrint($pendaftaran_id, $persetujuan_id = null) {

        // if ($this->module->id == 'radiologi'){
        //     $this->layout = '//layouts/_auto_pdf';
        // }else{
        //     $this->layout = '//layouts/printWindows';
        // }

        $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modRadiologi = AsesmenawalradiologiT::model()->findByAttributes(array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
        ), array('order' => 'create_time DESC'));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $urlDir = $this->path_view . 'print';
        if ($this->module->id == 'radiologi') {
            $urlDir = $this->path_view . 'print';
        }
        $caraPrint = 'PRINT';
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($urlDir, array(
                'modPendaftaran' => $modPendaftaran,
                'modRadiologi' => $modRadiologi,
                'modPasien' => $modPasien,
                'modProfilRs' => $modProfilRs));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($urlDir, array(
                'modPendaftaran' => $modPendaftaran,
                'modRadiologi' => $modRadiologi,
                'modPasien' => $modPasien,
                'modProfilRs' => $modProfilRs));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($urlDir, array(
                'modPendaftaran' => $modPendaftaran,
                'modRadiologi' => $modRadiologi,
                'modPasien' => $modPasien,
                'modProfilRs' => $modProfilRs), true));
            $mpdf->Output();
        }
        // $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        // $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        // $mpdf = new MyPDF60('', $ukuranKertasPDF);
        // //$mpdf->useOddEven = 2;
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        // $mpdf->WriteHTML($stylesheet, 1);
        // $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        // $mpdf->WriteHTML($this->renderPartial($urlDir, array(
        //     'modPendaftaran' => $modPendaftaran,
        //     'modRadiologi' => $modRadiologi,
        //     'modPasien' => $modPasien,
        //     'modProfilRs' => $modProfilRs
        // ), true));
        // $mpdf->Output();               
    }

    public function actionHapusConcent(){
        if (Yii::app()->request->isAjaxRequest){
            $id = $_POST['id'];
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = 0;
            try{
                $del = InformconsentT::model()->deleteAllByAttributes([
                    'suratpersetujuantm_id'=>$id
                ]);
                    
                $del = SuratpersetujuantmT::model()->deleteByPk($id);                
                if ($del){
                    $ok = 1;
                    $trans->commit();
                }else{
                    $ok = 0;
                    $trans->rollback();
                }
            }catch(Exception $e){
                var_dump($e->getMessage());die;
                $ok = 0;
                $trans->rollback();
            }
            
            echo json_encode([
                'sukses'=>$ok
            ]);
            Yii::app()->end();
        }
    }
}
