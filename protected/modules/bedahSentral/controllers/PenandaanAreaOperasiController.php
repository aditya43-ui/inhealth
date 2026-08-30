<?php

class PenandaanAreaOperasiController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'bedahSentral.views.penandaanAreaOperasi.';
    public $areaoperasisimpan = true;
    public $areaoperasidetsimpan = true;


    public function actionIndex($pendaftaran_id, $areaoperasi_id = null ,$jenis = null)
    {
        $this->layout = '//layouts/iframe';
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI){
            $pasienadmisi_id = $pendaftaran->pasienadmisi_id;
        }
        $modAreaOperasi = new BSAreaoperasiT;
        $modGambarTubuh = new BSGambartubuhM();
        $modBagianTubuh = new BSBagiantubuhM();
        $modAreaDetOp = array();

        // $modKunjungan = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = PasienM::model()->findByAttributes(array('pasien_id' => $pendaftaran->pasien_id));
        
        $tblRencanaOperasi = RencanaoperasiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'rencanaoperasi_id DESC'));
            
        if (empty($tblRencanaOperasi)){
            $tblRencanaOperasi = new RencanaoperasiT;
        } else  {
            $modAreaOperasi->tgl_penandaanarea = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));
            $modAreaOperasi->pegawai_id = !empty($tblRencanaOperasi->dokter1) ? $tblRencanaOperasi->dokterpelaksana1_id : '';
            $modAreaOperasi->pegawai_nama = !empty($tblRencanaOperasi->dokter1) ? $tblRencanaOperasi->dokter1->namaLengkap : '';
        }

        $gambartubuh_id = 0;
        $tblAreaOperasi = AreaoperasiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (!empty($tblAreaOperasi)) {
            $tblAreaOperasiSide = AreaoperasidetT::model()->findByAttributes(array('areaoperasi_id' => $tblAreaOperasi->areaoperasi_id));
            if (!empty($tblAreaOperasiSide)) {
                $gambartubuh_id = $tblAreaOperasiSide->gambartubuh_id;
            }
        }

        if (isset($_POST['BSAreaoperasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                if ($jenis == 'salin'){
                    $modAreaOperasi = new BSAreaoperasiT;
                }
                $modAreaOperasi->attributes = $_POST['BSAreaoperasiT'];
                $modAreaOperasi->pendaftaran_id = $pendaftaran_id;
                $modAreaOperasi->rencanaoperasi_id = !empty($tblRencanaOperasi->rencanaoperasi_id) ? $tblRencanaOperasi->rencanaoperasi_id : '';
                // $modAreaOperasi->pelayananpembedahan_id = $model->pelayananpembedahan_id;
                $modAreaOperasi->pasienadmisi_id = !empty($pasienadmisi_id) ? $pasienadmisi_id : '';
                // $modAreaOperasi->kamarruangan_id = !empty($kamar) ? $kamar->kamarruangan_id : '';
                $modAreaOperasi->pasien_id = !empty($pendaftaran->pasien_id) ? $pendaftaran->pasien_id : '';
                $modAreaOperasi->pegawai_id = $_POST['BSAreaoperasiT']['pegawai_id'];
                $modAreaOperasi->tgl_penandaanarea = MyFormatter::formatDateTimeForDb($_POST['BSAreaoperasiT']['tgl_penandaanarea']);
                if ($modAreaOperasi->isNewRecord) {
                    $modAreaOperasi->create_time = date("Y-m-d H:i:s");
                    $modAreaOperasi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modAreaOperasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $modAreaOperasi->update_time = date("Y-m-d H:i:s");
                    $modAreaOperasi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                $ok &= $modAreaOperasi->save();                
                
                if ($modAreaOperasi->save()) {
                    if (isset($_POST['BSAreaoperasidetT'])) {
                        foreach ($_POST['BSAreaoperasidetT'] as $iiii => $val) {
                            $modAreaOpDet = BSAreaoperasidetT::model()->findByAttributes(array(
                                'areaoperasi_id' => $modAreaOperasi->areaoperasi_id,
                                'gambartubuh_id' => $val['gambartubuh_id'],
                                'bagiantubuh_id' => $val['bagiantubuh_id'],
                                'kordinat_tubuh_x' => $val['kordinat_tubuh_x'],
                                'kordinat_tubuh_y' => $val['kordinat_tubuh_y'],
                                'areaoperasidet_ket' => $val['areaoperasidet_ket'],
                            ));

                            if (empty($modAreaOpDet)) {
                                $modAreaOpDet = new BSAreaoperasidetT();
                                $modAreaOpDet->attributes = $_POST['BSAreaoperasidetT'][$iiii];
                                $modAreaOpDet->areaoperasi_id = $modAreaOperasi->areaoperasi_id;
                                $ok &= $modAreaOpDet->save();
                            } else {
                                $modAreaOpDet->attributes = $_POST['BSAreaoperasidetT'][$iiii];
                                $ok &= $modAreaOpDet->save();
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
                    echo '<pre>'; var_dump('gagal',$_POST, $modAreaOperasi->getErrors()); die;
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
            'jenis' => $jenis,
            'pendaftaran' => $pendaftaran,
            'gambartubuh_id' => $gambartubuh_id,
            'modAreaOperasi' => $modAreaOperasi, 
            'modBagianTubuh' => $modBagianTubuh, 
            'modGambarTubuh' => $modGambarTubuh,
            'modPasien' => $modPasien, 
            'modAreaDetOp' => $modAreaDetOp, 
        ));
    }

    public function actionTambahBagianTubuh()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $pesan = '';
        $form = '';
        if (!empty($_POST['bagiantubuh_id'])) {
            $modPemeriksaanGbr = new BSAreaoperasidetT();
            $modPemeriksaanGbr->bagiantubuh_id      = $_POST['bagiantubuh_id'];
            $modPemeriksaanGbr->namabagtubuh      = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
            $modPemeriksaanGbr->areaoperasidet_ket    = $_POST['keterangan'];
            $modPemeriksaanGbr->kordinat_tubuh_x    = $_POST['pic_x'];
            $modPemeriksaanGbr->kordinat_tubuh_y    = $_POST['pic_y'];
            $modPemeriksaanGbr->gambartubuh_id          = $_POST['gambartubuh_id'];
            $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
            $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
            $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
            echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
        } else {
            $pesan = 'Bagian tubuh tidak boleh kosong!';
            echo CJSON::encode(array('pesan' => $pesan));
        }
        }
        Yii::app()->end();
    }

    public function actionHapusBagianTubuh()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $pesan = '';
        $ok = 0;
        $del = true;
        $areaOp = BSAreaoperasiT::model()->findAll(" pasienmasukpenunjang_id = " . $_POST['pasienmasukpenunjang_id'] . " ");
        //var_dump(count((array)$areaOp));die;
        foreach ($areaOp as $ar) {
            $det = BSAreaoperasidetT::model()->findAll(" areaoperasi_id = " . $ar->areaoperasi_id . " ");

            foreach ($det as $cek) {
            $ok = BSAreaoperasidetT::model()->findByAttributes(
                array(
                'areaoperasi_id' => $cek->areaoperasi_id,
                'gambartubuh_id' => $_POST['gambartubuh_id'],
                'bagiantubuh_id' => $_POST['bagiantubuh_id'],
                'kordinat_tubuh_x' => $_POST['kordinat_tubuh_x'],
                'kordinat_tubuh_y' => $_POST['kordinat_tubuh_y'],
                'areaoperasidet_ket' => $_POST['areaoperasidet_ket'],
                )
            );

            if (!empty($ok)) {
                $del = $del && $ok->delete();
            }
            }
        }

        if ($del) {
            $pesan = 'Data Berhasil Dihapus dari database';
            $ok = 1;
            echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
        } else {
            $ok = 0;
            $pesan = "Bagian Tubuh gagal dihapus!";
            echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
        }
        }
        Yii::app()->end();
    }

    public function actionHapusRiwayat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $areaoperasi_id = (isset($_POST['areaoperasi_id']) ? $_POST['areaoperasi_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                BSAreaoperasidetT::model()->deleteAllByAttributes(array('areaoperasi_id' => $areaoperasi_id));
                $delete = BSAreaoperasiT::model()->deleteByPk($areaoperasi_id);
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

    public function actionPrint($pendaftaran_id, $areaoperasi_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modCeklist = CekliskelengkapanpreoperasiT::model()->findByPk($areaoperasi_id); 
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
