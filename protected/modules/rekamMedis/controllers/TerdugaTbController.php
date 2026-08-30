<?php

class TerdugaTbController extends MyAuthController
{
    public $judul = 'Terduga TB';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.terdugaTb.';

    public function actionIndex($pendaftaran_id, $terdugatb_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';

        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }
        
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if(empty($terdugatb_id)){
            $modTerdugaTb = new TerdugatbT();
            $modUjiTerdugaTb = new UjiterdugatbT();
            $new = true;


            $modTerdugaTb->tglterdugatb = date('Y-m-d H:i:s');
            $modTerdugaTb->tglhasil_xpertmtbrif = date('Y-m-d');
            $modTerdugaTb->tglhasil_biakan = date('Y-m-d');
            $modTerdugaTb->tglmulaipengobatan = date('Y-m-d');
            $modTerdugaTb->tglselesaipengobatan = date('Y-m-d');
            $modUjiTerdugaTb->tglpengambilan = date('Y-m-d');
            $modUjiTerdugaTb->tglhasil = date('Y-m-d');
        } else {
            $modTerdugaTb = TerdugatbT::model()->findByPk($terdugatb_id);
            $modUjiTerdugaTb = UjiterdugatbT::model()->findAllByAttributes(array('terdugatb_id' => $modTerdugaTb->terdugatb_id));
            $new = false;
        }

        if (isset($_POST['TerdugatbT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {

                if ($jenis == 'salin'){
                    $modTerdugaTb = new TerdugatbT;
                }

                $modTerdugaTb->attributes = $_POST['TerdugatbT'];
                if ($modTerdugaTb->isNewRecord) {
                    $modTerdugaTb->create_time = date('Y-m-d H:i:s');
                    $modTerdugaTb->create_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
                    $modTerdugaTb->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $modTerdugaTb->update_time = date('Y-m-d H:i:s');
                    $modTerdugaTb->update_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
                }
                $ok = $ok && $modTerdugaTb->save();

                if(($jenis != 'ubah') && ($jenis != 'salin')){
                    if ($ok) {
                        if (isset($_POST['UjiterdugatbT'])) {
                            foreach ($_POST['UjiterdugatbT'] as $iv => $value) {
                                $modUjiTerdugaTb = new UjiterdugatbT;
                                $modUjiTerdugaTb->attributes = $value;
                                $modUjiTerdugaTb->terdugatb_id = $modTerdugaTb->terdugatb_id;
                                $ok = $ok && $modUjiTerdugaTb->save();
                            }
                        }
                    }
                }

                if($ok){
                    // echo '<pre>'; var_dump('masuk', $_POST); die;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    // echo '<pre>'; var_dump('gagal', $modTerdugaTb->getErrors()); die;
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
            'modTerdugaTb' => $modTerdugaTb,
            'modUjiTerdugaTb' => $modUjiTerdugaTb,
            'jenis' => $jenis,
        ));
    }

    public function actionView($pendaftaran_id, $terdugatb_id)
    {
        $this->layout = "//layouts/iframe";

        if (!empty($terdugatb_id)) {
            $modTerdugaTb = TerdugatbT::model()->findByPk($terdugatb_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modUjiTerdugaTb = UjiterdugatbT::model()->findAllByAttributes(array('terdugatb_id' => $modTerdugaTb->terdugatb_id));
        } else {
            echo "Data tidak ditemukan";
            Yii::app()->end();
        }

        $this->render($this->path_view . 'view', array(
            'modTerdugaTb' => $modTerdugaTb,
            'modPendaftaran' => $modPendaftaran,
            'modUjiTerdugaTb' => $modUjiTerdugaTb
        ));
    }

    public function actionHapusRiwayatTerdugaTB()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $terdugatb_id = (isset($_POST['terdugatb_id']) ? $_POST['terdugatb_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                UjiterdugatbT::model()->deleteAllByAttributes(array('terdugatb_id' => $terdugatb_id));
                $deleteTedugaTb = TerdugatbT::model()->deleteByPk($terdugatb_id);
                if ($deleteTedugaTb) {
                    $data['sukses'] = 1;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Riwayat Terduga TB Berhasil Dihapus!');
                } else {
                    $data['sukses'] = 0;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Menghapus Terduga TB');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal Menghapus Terduga TB !!" . MyExceptionMessage::getMessage($exc, true));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionPrintTerdugaTB($pendaftaran_id, $terdugatb_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modTerdugaTb = TerdugatbT::model()->findByPk($terdugatb_id); 
      $modUjiTerdugaTb = UjiterdugatbT::model()->findAllByAttributes(array('terdugatb_id' => $modTerdugaTb->terdugatb_id));
      $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

      $judulLaporan = 'Terduga TB';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modTerdugaTb' => $modTerdugaTb, 'modUjiTerdugaTb' => $modUjiTerdugaTb, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modTerdugaTb' => $modTerdugaTb, 'modUjiTerdugaTb' => $modUjiTerdugaTb, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

        $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modTerdugaTb' => $modTerdugaTb, 'modUjiTerdugaTb' => $modUjiTerdugaTb, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }
}
