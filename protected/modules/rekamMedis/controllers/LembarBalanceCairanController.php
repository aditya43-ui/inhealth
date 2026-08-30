<?php

class LembarBalanceCairanController extends MyAuthController
{
    public $judul = 'Kriteria Pasien Keluar NICU';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.lembarBalanceCairan.';

    public function actionIndex($pendaftaran_id, $balancecairan_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';

        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }
        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if(empty($balancecairan_id)){
            $modBalance = new BalancecairanT();
            // $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            // $modBalance->perawat_id = $peg->pegawai_id;
            // $modBalance->perawat_nama = $peg->namaLengkap;
            // $modBalance->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        } else {
            $modBalance = BalancecairanT::model()->findByPk($balancecairan_id);
            if(!empty($modBalance->pegawai)){
                $modBalance->pegawai_nama = $modBalance->pegawai->namaLengkap;
            }
        }

        if (isset($_POST['BalancecairanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {

                if ($jenis == 'salin'){
                    $modBalance = new BalancecairanT;
                }

                $modBalance->attributes = $_POST['BalancecairanT'];
                $modBalance->pendaftaran_id = !empty($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : '';
                $modBalance->pasien_id = !empty($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : '';
                $modBalance->tanggal = MyFormatter::formatDateTimeForDb($_POST['BalancecairanT']['tanggal']);
                
                $modBalance->pegawai_id = $_POST['BalancecairanT']['pegawai_id'];
                $modBalance->keterangan = empty($_POST['BalancecairanT']['keterangan']) ? '' : $_POST['BalancecairanT']['keterangan'];
                
                $modBalance->cairanmasuk_infus = empty($_POST['BalancecairanT']['cairanmasuk_infus']) ? '' : $_POST['BalancecairanT']['cairanmasuk_infus'];
                $modBalance->cairanmasuk_transfusi = empty($_POST['BalancecairanT']['cairanmasuk_transfusi']) ? '' : $_POST['BalancecairanT']['cairanmasuk_transfusi'];
                $modBalance->cairanmasuk_oral = empty($_POST['BalancecairanT']['cairanmasuk_oral']) ? '' : $_POST['BalancecairanT']['cairanmasuk_oral'];
                
                $modBalance->cairankeluar_urine = empty($_POST['BalancecairanT']['cairankeluar_urine']) ? '' : $_POST['BalancecairanT']['cairankeluar_urine'];
                $modBalance->cairankeluar_bab = empty($_POST['BalancecairanT']['cairankeluar_bab']) ? '' : $_POST['BalancecairanT']['cairankeluar_bab'];
                $modBalance->cairankeluar_drain = empty($_POST['BalancecairanT']['cairankeluar_drain']) ? '' : $_POST['BalancecairanT']['cairankeluar_drain'];
                $modBalance->cairankeluar_muntah = empty($_POST['BalancecairanT']['cairankeluar_muntah']) ? '' : $_POST['BalancecairanT']['cairankeluar_muntah'];
                $modBalance->cairankeluar_lainnya = empty($_POST['BalancecairanT']['cairankeluar_lainnya']) ? '' : $_POST['BalancecairanT']['cairankeluar_lainnya'];
                
                if($modBalance->isNewRecord){
                    $modBalance->create_time = date("Y-m-d H:i:s"); 
                    $modBalance->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                    $modBalance->create_loginpemakai = Yii::app()->user->getState('pegawai_id');
                    $modBalance->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modBalance->create_ruangan_id = Yii::app()->user->getState('ruangan_id');

                } else{
                    $modBalance->update_time = date("Y-m-d H:i:s");
                    $modBalance->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');  
                }

                $ok = $ok && $modBalance->save();

                if($ok){
                    // echo '<pre>'; var_dump('masuk', $_POST); die;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    echo '<pre>'; var_dump('gagal', $modBalance->getErrors()); die;
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
            'modBalance' => $modBalance,
            'jenis' => $jenis,
        ));
    }

    public function actionHapusRiwayat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $balancecairan_id = (isset($_POST['balancecairan_id']) ? $_POST['balancecairan_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $delete = BalancecairanT::model()->deleteByPk($balancecairan_id);
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

    public function actionPrint($pendaftaran_id, $balancecairan_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modBalance = BalancecairanT::model()->findByPk($balancecairan_id); 
      $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

      $judulLaporan = 'CHECK LIST PASIEN PRE OPERASI';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modBalance' => $modBalance, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modBalance' => $modBalance, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

        $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modPendaftaran' => $modPendaftaran, 'modProfilRs' => $modProfilRs, 'modBalance' => $modBalance, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }
}
