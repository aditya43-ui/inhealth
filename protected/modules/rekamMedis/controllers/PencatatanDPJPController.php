<?php

class PencatatanDPJPController extends MyAuthController
{
    public $judul = 'Pencatatan DPJP';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.pencatatanDPJP.';

    public function actionIndex($pendaftaran_id, $pencatatandpjp_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if(empty($pencatatandpjp_id)){
            $modPencatatan = new PencatatandpjpT();
            $modPencatatanDet = new PencatatandpjpdetT();
            $new = true;

            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $modPencatatan->pegawai_id = $peg->pegawai_id;
            $modPencatatan->pegawai_nama = $peg->namaLengkap;
            $modPencatatan->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

            // $modPencatatanDet->tglmulai_dpjp = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
            // $modPencatatanDet->tglberakhir_dpjp = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
            // $modPencatatanDet->tglmulai_dpjputama = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
            // $modPencatatanDet->tglberakhir_dpjputama = MyFormatter::formatDateTimeForUser(date('Y-m-d'));

            $modDiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('condition' => 'diagnosaicdix_id is null'));
        } else {
            $modPencatatan = PencatatandpjpT::model()->findByPk($pencatatandpjp_id);
            $modPencatatanDet = new PencatatandpjpdetT();
            $peg = PegawaiM::model()->findByPk($modPencatatan->pegawai_id);
            $modPencatatan->pegawai_id = $peg->pegawai_id;
            $modPencatatan->pegawai_nama = $peg->namaLengkap;
            $modPencatatan->tanggal = MyFormatter::formatDateTimeForUser($modPencatatan->tanggal);
            $modDiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('condition' => 'diagnosaicdix_id is null'));
            $new = false;
        }

        if (isset($_POST['PencatatandpjpT'])) {
            // echo '<pre>'; var_dump('1', $_POST); die;
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {

                if ($jenis == 'salin'){
                    $modPencatatan = new PencatatandpjpT;
                }

                $modPencatatan->attributes = $_POST['PencatatandpjpT'];
                $modPencatatan->tanggal = MyFormatter::formatDateTimeForDb($_POST['PencatatandpjpT']['tanggal']);
                $modPencatatan->pegawai_id = $_POST['PencatatandpjpT']['pegawai_id'];
                $modPencatatan->pasien_id = !empty($pendaftaran->pasien_id) ? $pendaftaran->pasien_id : '';
                $modPencatatan->pendaftaran_id = !empty($pendaftaran->pendaftaran_id) ? $pendaftaran->pendaftaran_id : '';
                $modPencatatan->pasienadmisi_id = !empty($pendaftaran->pasienadmisi_id) ? $pendaftaran->pasienadmisi_id : '';
                if ($jenis != 'ubah') {
                    $modPencatatan->create_time = date("Y-m-d H:i:s");
                    $modPencatatan->create_loginpemakai_id = Yii::app()->user->id;
                    $modPencatatan->create_ruangan_id = Yii::app()->user->ruangan_id;
                } else {
                    $modPencatatan->update_time = date("Y-m-d H:i:s");
                    $modPencatatan->update_loginpemakai_id = Yii::app()->user->id;
                }
                $ok = $ok && $modPencatatan->save();

                // if(($jenis != 'ubah') && ($jenis != 'salin')){
                if ($ok) {
                    if (isset($_POST['PencatatandpjpdetT'])) {
                        if($jenis == 'ubah'){
                            $modDelete = PencatatandpjpdetT::model()->deleteAllByAttributes(array('pencatatandpjp_id' => $modPencatatan->pencatatandpjp_id));
                        }

                        foreach ($_POST['PencatatandpjpdetT'] as $iv => $value) {
                            $modPencatatanDet = new PencatatandpjpdetT;
                            $modPencatatanDet->attributes = $value;
                            $modPencatatanDet->pasien_id = !empty($pendaftaran->pasien_id) ? $pendaftaran->pasien_id : '';
                            $modPencatatanDet->pendaftaran_id = !empty($pendaftaran->pendaftaran_id) ? $pendaftaran->pendaftaran_id : '';
                            $modPencatatanDet->pasienadmisi_id = !empty($pendaftaran->pasienadmisi_id) ? $pendaftaran->pasienadmisi_id : '';
                            $modPencatatanDet->pencatatandpjp_id = $modPencatatan->pencatatandpjp_id;
                            $modPencatatanDet->diagnosa_id = $value['diagnosa_id'];
                            $modPencatatanDet->dpjp_id = $value['dpjp_id'];
                            $modPencatatanDet->tglmulai_dpjp = MyFormatter::formatDateTimeForDb($value['tglmulai_dpjp']);
                            $modPencatatanDet->tglberakhir_dpjp = MyFormatter::formatDateTimeForDb($value['tglberakhir_dpjp']);
                            $modPencatatanDet->dpjputama_id = $value['dpjputama_id'];
                            $modPencatatanDet->tglmulai_dpjputama = MyFormatter::formatDateTimeForDb($value['tglmulai_dpjputama']);
                            $modPencatatanDet->tglberakhir_dpjputama = MyFormatter::formatDateTimeForDb($value['tglberakhir_dpjputama']);
                            $modPencatatanDet->keterangan = $value['keterangan'];
                            $modPencatatanDet->create_time = date("Y-m-d H:i:s");
                            $modPencatatanDet->create_loginpemakai_id = Yii::app()->user->id;
                            $modPencatatanDet->create_ruangan_id = Yii::app()->user->ruangan_id;
                            $ok = $ok && $modPencatatanDet->save();
                        }
                    }
                }
                // }

                if($ok){
                    // echo '<pre>'; var_dump('masuk', $_POST); die;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    // echo '<pre>'; var_dump('gagal',$_POST, $modPencatatan->getErrors(), $modPencatatanDet->getErrors()); die;
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
            'modDiagnosa' => $modDiagnosa,
            'modPencatatan' => $modPencatatan,
            'modPencatatanDet' => $modPencatatanDet,
            'jenis' => $jenis,
            'new' => $new,
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

    public function actionHapusRiwayatPencatatanDPJP()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pencatatandpjp_id = (isset($_POST['pencatatandpjp_id']) ? $_POST['pencatatandpjp_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                PencatatandpjpdetT::model()->deleteAllByAttributes(array('pencatatandpjp_id' => $pencatatandpjp_id));
                $deleteDPJP = PencatatandpjpT::model()->deleteByPk($pencatatandpjp_id);
                if ($deleteDPJP) {
                    $data['sukses'] = 1;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Riwayat Pencatatan DPJP Berhasil Dihapus!');
                } else {
                    $data['sukses'] = 0;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Menghapus Pencatatan DPJP');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal Menghapus Pencatatan DPJP !!" . MyExceptionMessage::getMessage($exc, true));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionPrintPencatatanDPJP($pendaftaran_id, $pencatatandpjp_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPencatatan = PencatatandpjpT::model()->findByPk($pencatatandpjp_id); 
      $modPencatatanDet = PencatatandpjpdetT::model()->findAllByAttributes(array('pencatatandpjp_id' => $modPencatatan->pencatatandpjp_id));
      $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

      $judulLaporan = 'Terduga TB';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPencatatan' => $modPencatatan, 'modPencatatanDet' => $modPencatatanDet, 'modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPencatatan' => $modPencatatan, 'modPencatatanDet' => $modPencatatanDet, 'modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

        $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPencatatan' => $modPencatatan, 'modPencatatanDet' => $modPencatatanDet, 'modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }
}
