<?php

class ChecklistKelengkapanController extends MyAuthController
{
    public $judul = 'Checklist Kelengkapan Pasien PRe Operasi';
    public $defaultAction = 'index';
    public $path_view = 'bedahSentral.views.checklistKelengkapan.';

    public function actionIndex($pendaftaran_id, $cekliskelengkapanpreoperasi_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if(empty($cekliskelengkapanpreoperasi_id)){
            $modCeklist = new CekliskelengkapanpreoperasiT();
            $modCeklist->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            $new = true;
        } else {
            $modCeklist = CekliskelengkapanpreoperasiT::model()->findByPk($cekliskelengkapanpreoperasi_id);
            $modCeklist->petugasok_nama = empty($modCeklist->petugasok) ? '' : $modCeklist->petugasok->namaLengkap;
            $modCeklist->pertugasrawatinap_nama = empty($modCeklist->pertugasrawatinap) ? '' : $modCeklist->pertugasrawatinap->namaLengkap;
            $new = false;
        }

        if (isset($_POST['CekliskelengkapanpreoperasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {

                if ($jenis == 'salin'){
                    $modCeklist = new CekliskelengkapanpreoperasiT;
                }

                $modCeklist->attributes = $_POST['CekliskelengkapanpreoperasiT'];
                $modCeklist->tanggal = MyFormatter::formatDateTimeForDb($_POST['CekliskelengkapanpreoperasiT']['tanggal']);
                $modCeklist->petugasok_id = $_POST['CekliskelengkapanpreoperasiT']['petugasok_id'];
                $modCeklist->pertugasrawatinap_id = $_POST['CekliskelengkapanpreoperasiT']['pertugasrawatinap_id'];
                $modCeklist->pasien_id = !empty($pendaftaran->pasien_id) ? $pendaftaran->pasien_id : '';
                $modCeklist->pendaftaran_id = !empty($pendaftaran->pendaftaran_id) ? $pendaftaran->pendaftaran_id : '';
                $modCeklist->pasienadmisi_id = !empty($pendaftaran->pasienadmisi_id) ? $pendaftaran->pasienadmisi_id : '';
                if ($modCeklist->isNewRecord) {
                    $modCeklist->create_time = date("Y-m-d H:i:s");
                    $modCeklist->create_loginpemakai_id = Yii::app()->user->id;
                    $modCeklist->createruangan_id = Yii::app()->user->ruangan_id;
                } else {
                    $modCeklist->update_time = date("Y-m-d H:i:s");
                    $modCeklist->update_loginpemakai_id = Yii::app()->user->id;
                }
                $ok = $ok && $modCeklist->save();

                if($ok){
                    // echo '<pre>'; var_dump('masuk', $_POST); die;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    // echo '<pre>'; var_dump('gagal',$_POST, $modCeklist->getErrors()); die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
                }
            } catch (Exception $e) {
                // echo '<pre>'; var_dump('gagal 2', $e); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan !!" . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('index', array(
            'pendaftaran' => $pendaftaran,
            'modCeklist' => $modCeklist,
            'jenis' => $jenis,
        ));
    }

    public function actionHapusRiwayat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $cekliskelengkapanpreoperasi_id = (isset($_POST['cekliskelengkapanpreoperasi_id']) ? $_POST['cekliskelengkapanpreoperasi_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $deleteDPJP = CekliskelengkapanpreoperasiT::model()->deleteByPk($cekliskelengkapanpreoperasi_id);
                if ($deleteDPJP) {
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

    public function actionPrint($pendaftaran_id, $cekliskelengkapanpreoperasi_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modCeklist = CekliskelengkapanpreoperasiT::model()->findByPk($cekliskelengkapanpreoperasi_id); 
      $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

      $judulLaporan = 'CHECK LIST PASIEN PRE OPERASI';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modCeklist' => $modCeklist, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modCeklist' => $modCeklist, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

        $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modCeklist' => $modCeklist, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }
}
