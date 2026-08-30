<?php

class RingkasanTransferController extends MyAuthController
{
    public $judul = '';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.ringkasanTransfer.';

    public function actionIndex($pendaftaran_id, $transferintrars_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modelTransfer = TransferintrarsT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'transferintrars_id DESC', 'limit' => 1));
        
        if(empty($modelTransfer)){
            if(empty($transferintrars_id)){
                $modelTransfer = new TransferintrarsT;
                $modelTransfer->tgl_transfer = date('d M Y H:i:s');
                $modelTransfer->tgl_diterima = date('d M Y H:i:s');

                if(Yii::app()->user->getState('ruangan_id') != 4){
                    $modelTransfer->dokter_id = empty($modPendaftaran->pegawai) ? '' : $modPendaftaran->pegawai->pegawai_id;
                    $modelTransfer->dokter_nama = empty($modPendaftaran->pegawai) ? '' : $modPendaftaran->pegawai->namaLengkap;
                } else {
                    $modelTransfer->dokter_id = empty($modPendaftaran->pasienadmisi) ? '' : $modPendaftaran->pasienadmisi->pegawai->pegawai_id;
                    $modelTransfer->dokter_nama = empty($modPendaftaran->pasienadmisi) ? '' : $modPendaftaran->pasienadmisi->pegawai->namaLengkap;
                }

                $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $modelTransfer->petugaspenerima_id = $peg->pegawai_id;
                $modelTransfer->petugaspenerima_nama = $peg->namaLengkap;

                $morbiditas = PasienmorbiditasT::model()->findByAttributes(array(
                    'pendaftaran_id' => $pendaftaran_id, 
                    // 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA
                ), array('order' => 'pasienmorbiditas_id DESC'));
                if (!empty($morbiditas)) {
                    $modelTransfer->diagnosa = $morbiditas->diagnosa->diagnosa_nama;
                }
            } else {
                $modelTransfer = TransferintrarsT::model()->findByPk($transferintrars_id);
                $peg = PegawaiM::model()->findByPk($modelTransfer->dokter_id);
                $modelTransfer->dokter_id = !empty($peg) ? $peg->pegawai_id : null;
                $modelTransfer->dokter_nama = !empty($peg) ? $peg->namaLengkap : null;

                $peg1 = PegawaiM::model()->findByPk($modelTransfer->pendamping1_id);
                $modelTransfer->pendamping1_id = !empty($peg1) ? $peg1->pegawai_id : null;
                $modelTransfer->pendamping1_nama = !empty($peg1) ? $peg1->namaLengkap : null;

                $peg2 = PegawaiM::model()->findByPk($modelTransfer->pendamping2_id);
                $modelTransfer->pendamping2_id = !empty($peg2) ? $peg2->pegawai_id : null;
                $modelTransfer->pendamping2_nama = !empty($peg2) ? $peg2->namaLengkap : null;

                $peg3 = PegawaiM::model()->findByPk($modelTransfer->petugaspenerima_id);
                $modelTransfer->petugaspenerima_id = !empty($peg3) ? $peg3->pegawai_id : null;
                $modelTransfer->petugaspenerima_nama = !empty($peg3) ? $peg3->namaLengkap : null;
            }
        } else {
            $peg = PegawaiM::model()->findByPk($modelTransfer->dokter_id);
            $modelTransfer->dokter_id = !empty($peg) ? $peg->pegawai_id : null;
            $modelTransfer->dokter_nama = !empty($peg) ? $peg->namaLengkap : null;

            $peg1 = PegawaiM::model()->findByPk($modelTransfer->pendamping1_id);
            $modelTransfer->pendamping1_id = !empty($peg1) ? $peg1->pegawai_id : null;
            $modelTransfer->pendamping1_nama = !empty($peg1) ? $peg1->namaLengkap : null;
            
            $peg2 = PegawaiM::model()->findByPk($modelTransfer->pendamping2_id);
            $modelTransfer->pendamping2_id = !empty($peg2) ? $peg2->pegawai_id : null;
            $modelTransfer->pendamping2_nama = !empty($peg2) ? $peg2->namaLengkap : null;

            $peg3 = PegawaiM::model()->findByPk($modelTransfer->petugaspenerima_id);
            $modelTransfer->petugaspenerima_id = !empty($peg3) ? $peg3->pegawai_id : null;
            $modelTransfer->petugaspenerima_nama = !empty($peg3) ? $peg3->namaLengkap : null;
        }

        if (isset($_POST['TransferintrarsT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                if ($jenis == 'salin'){
                    $modelTransfer = new TransferintrarsT;
                }
                $modelTransfer->attributes = $_POST['TransferintrarsT'];
                $modelTransfer->tgl_transfer = !empty($modelTransfer->tgl_transfer) ? MyFormatter::formatDateTimeForDb($_POST['TransferintrarsT']['tgl_transfer']) : null;
                $modelTransfer->tgl_diterima = !empty($modelTransfer->tgl_diterima) ? MyFormatter::formatDateTimeForDb($_POST['TransferintrarsT']['tgl_diterima']) : null;
                $modelTransfer->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modelTransfer->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                $modelTransfer->pasien_id = $modPendaftaran->pasien_id;
                if ($modelTransfer->isNewRecord) {
                    $modelTransfer->create_time = date('Y-m-d H:i:s');
                    $modelTransfer->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modelTransfer->createruangan_id = Yii::app()->user->getState('ruangan_id');
                } else {
                    $modelTransfer->update_time = date('Y-m-d H:i:s');
                    $modelTransfer->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                $ok = $ok && $modelTransfer->save();

                if($ok){
                    // echo '<pre>'; var_dump('masuk', $_POST); die;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    echo '<pre>'; var_dump('gagal', $modelTransfer->getErrors()); die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
                }
            } catch (Exception $e) {
                echo '<pre>'; var_dump('gagal 2', $e); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan !!" . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modelTransfer' => $modelTransfer,
            'jenis' => $jenis,
        ));
    }

    public function actionHapusRiwayat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $transferintrars_id = (isset($_POST['transferintrars_id']) ? $_POST['transferintrars_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $delete = TransferintrarsT::model()->deleteByPk($transferintrars_id);
                if ($delete) {
                    $data['sukses'] = 1;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Riwayat Berhasil Dihapus!');
                } else {
                    $data['sukses'] = 0;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Menghapus');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal Menghapus !!" . MyExceptionMessage::getMessage($exc, true));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionPrint($pendaftaran_id, $transferintrars_id, $caraPrint)
    {
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modelTransfer = TransferintrarsT::model()->findByAttributes(array('transferintrars_id' => $transferintrars_id));
        $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
        if(!empty($modelTransfer)){

            $peg = PegawaiM::model()->findByPk($modelTransfer->dokter_id);
            $modelTransfer->dokter_id = !empty($peg) ? $peg->pegawai_id : null;
            $modelTransfer->dokter_nama = !empty($peg) ? $peg->namaLengkap : null;

            $peg1 = PegawaiM::model()->findByPk($modelTransfer->pendamping1_id);
            $modelTransfer->pendamping1_id = !empty($peg1) ? $peg1->pegawai_id : null;
            $modelTransfer->pendamping1_nama = !empty($peg1) ? $peg1->namaLengkap : null;
            
            $peg2 = PegawaiM::model()->findByPk($modelTransfer->pendamping2_id);
            $modelTransfer->pendamping2_id = !empty($peg2) ? $peg2->pegawai_id : null;
            $modelTransfer->pendamping2_nama = !empty($peg2) ? $peg2->namaLengkap : null;

            $peg3 = PegawaiM::model()->findByPk($modelTransfer->petugaspenerima_id);
            $modelTransfer->petugaspenerima_id = !empty($peg3) ? $peg3->pegawai_id : null;
            $modelTransfer->petugaspenerima_nama = !empty($peg3) ? $peg3->namaLengkap : null;
        }
        $judulLaporan = '';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modelTransfer' => $modelTransfer, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modelTransfer' => $modelTransfer, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            // $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf = new MyPDF60Etiket('', $ukuranKertasPDF);
            // //$mpdf->useOddEven = 2;  

            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modelTransfer' => $modelTransfer, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
}
