<?php

class PersiapanPraBedahController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = "bedahSentral.views.persiapanPraBedah.";

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionIndex($pendaftaran_id, $pelayananpembedahan_id = null ,$jenis = null) {
        $this->layout = '//layouts/iframe';

        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }
        
        $modAreaOperasi = new BSAreaoperasiT;
        $modGambarTubuh = new BSGambartubuhM();
        $modBagianTubuh = new BSBagiantubuhM();
        $modAreaDetOp = array();
        /**
         * LOAD GAMBAR TUBUH
         */
        $data = array();
        $pendaftaran_id = $_GET['pendaftaran_id'];
        // if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_RI){
        //     $pasienadmisi_id = $_GET['pasienadmisi_id'];
        // }
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $tblPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id'=>Params::RUANGAN_ID_BEDAH));

        if (!empty($tblPasienMasukPenunjang->pasienmasukpenunjang_id)) {
            $tblRencanaOperasi = RencanaoperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $tblPasienMasukPenunjang->pasienmasukpenunjang_id));
            
            if (empty($tblRencanaOperasi)){
                $tblRencanaOperasi = new RencanaoperasiT;
            }
            $modAreaOperasi = BSAreaoperasiT::model()->find("pasienmasukpenunjang_id = '" . $tblPasienMasukPenunjang->pasienmasukpenunjang_id . "' ");
            if (!empty($modAreaOperasi)) {
                $modAreaOperasi->pegawai_nama = !empty($modAreaOperasi->pegawai)?$modAreaOperasi->pegawai->namaLengkap:null;

                $modAreaDetOp = BSAreaoperasidetT::model()->findAll(" areaoperasi_id = '" . $modAreaOperasi->areaoperasi_id . "' ");

                if (count((array)$modAreaDetOp) < 1) {
                $modAreaDetOp = array();
                }
            } else {
                $modAreaOperasi = new BSAreaoperasiT();
            }
        } else {
            $tblRencanaOperasi = new RencanaoperasiT;
        }
        $gambartubuh_id = 0;
        $tblAreaOperasi = AreaoperasiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (!empty($tblAreaOperasi)) {
            $tblAreaOperasiSide = AreaoperasidetT::model()->findByAttributes(array('areaoperasi_id' => $tblAreaOperasi->areaoperasi_id));
            if (!empty($tblAreaOperasiSide)) {
                $gambartubuh_id = $tblAreaOperasiSide->gambartubuh_id;
            }
        }
        // $modBagianTubuh = GambartubuhM::model()->findByPk($gambartubuh_id);
        //====================================================
        $modKunjungan = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $model = PelayananpembedahanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (empty($model)) {
            // echo '<pre>'; var_dump('1'); die;
            $model = new PelayananpembedahanT;
            $model->pendaftaran_id = $pendaftaran_id;
            $model->pasien_id = $modPendaftaran->pasien_id;
            $model->tanggal = date('d M Y H:i:s');
            $model->waktu_operasi = $tblRencanaOperasi->tglrencanaoperasi;
            
            $kamar = KamarruanganM::model()->findByPk($tblRencanaOperasi->tglrencanaoperasi);
            $model->kamar_ruangan = !empty($kamar)?$kamar->kamarruangan_nobed.' - '.$kamar->kamarruangan_nokamar:'';
            $model->waktu_operasi = $tblRencanaOperasi->tglrencanaoperasi;
            $model->operator = !empty($tblRencanaOperasi->dokter1)?$tblRencanaOperasi->dokter1->namaLengkap:'';
            $model->asisten_operator = !empty($tblRencanaOperasi->dokter2)?$tblRencanaOperasi->dokter2->namaLengkap:'';
            $model->dokter_anestesi = !empty($tblRencanaOperasi->dokteranastesi)?$tblRencanaOperasi->dokteranastesi->namaLengkap:'';
            $model->perawat_anestesi = !empty($tblRencanaOperasi->paramedis)?$tblRencanaOperasi->paramedis->namaLengkap:'';
            $model->perawat_sirkuler = !empty($tblRencanaOperasi->perawatsirkuler)?$tblRencanaOperasi->perawatsirkuler->namaLengkap:'';
            
            $modPelaksana = new PelaksanaoperasiT;            
            $modPelaksana->rencanaoperasi_id = $tblRencanaOperasi->rencanaoperasi_id;
            
            $model->setKruBedah = $modPelaksana->loadKruBedah();
        } else if (!empty($pelayananpembedahan_id)) {
            // echo '<pre>'; var_dump('2'); die;
            $model = PelayananpembedahanT::model()->findByPk($pelayananpembedahan_id);
            $model->perawat_nama = $model->perawat->namaLengkap;
            // if(!empty($model->is_ceklispreoperasi)) {
                if($model->is_ceklispreoperasi == true) {
                    $model->is_ceklispreoperasi = 'ada';
                } else {
                    $model->is_ceklispreoperasi = 'tidak ada';
                }
            // }
        // } else {
        //     echo '<pre>'; var_dump('3'); die;
        }

        if (isset($_POST['PelayananpembedahanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                // echo '<pre>'; var_dump('test 1',$_POST); die;
                if ($jenis == 'salin'){
                    $model = new PelayananpembedahanT;
                }

                $ok = true;
                $model->attributes = $_POST['PelayananpembedahanT'];
                $model->pasienicd9cm_id = $_POST['PelayananpembedahanT']['rencanaoperasi_id'];
                $model->pasienkirimkeunitlain_id = $_POST['PelayananpembedahanT']['pasienkirimkeunitlain_id'];
                $model->tanggal = MyFormatter::formatDateTimeForDb($_POST['PelayananpembedahanT']['tanggal']);

                if(!empty($_POST['PelayananpembedahanT']['rencanaoperasi_id']) && !empty($_POST['PelayananpembedahanT']['pasienkirimkeunitlain_id'])) {
                    $model1 = PelayananpembedahanT::model()->findByAttributes(array('pasienicd9cm_id' => $_POST['PelayananpembedahanT']['rencanaoperasi_id']));
                    $model2 = PelayananpembedahanT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['PelayananpembedahanT']['pasienkirimkeunitlain_id']));
                    if(!empty($model1) && !empty($model2)){
                        Yii::app()->user->setFlash('error', "Data pelayanan pembedahan dengan permintaan bedah dan tindakan tersebut sudah ditambahkan");
                        // $ok = false;
                        // $transaction->rollback();
                    }
                }

                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                }

                if(!empty($_POST['PelayananpembedahanT']['is_ceklispreoperasi'])) {
                    if($_POST['PelayananpembedahanT']['is_ceklispreoperasi'] == 'ada') {
                        $model->is_ceklispreoperasi = true;
                    } else {
                        $model->is_ceklispreoperasi = false;
                    }
                }

                // $model->pasienmasukpenunjang_id = 1513;
                $model->jam_pasang = !empty($model->jam_pasang) ? $model->jam_pasang : null;
                $model->jam_lepas = !empty($model->jam_lepas) ? $model->jam_lepas : null;
                
                $ok &= $model->save();

                if (isset($_POST['BSAreaoperasiT'])) {
                    $modAreaOperasi = new BSAreaoperasiT;
                    $modAreaOperasi->attributes = $_POST['BSAreaoperasiT'];
                    $modAreaOperasi->pendaftaran_id = $pendaftaran_id;
                    $modAreaOperasi->pelayananpembedahan_id = $model->pelayananpembedahan_id;
                    $modAreaOperasi->pasienadmisi_id = !empty($pasienadmisi_id) ? $pasienadmisi_id : '';
                    // $modAreaOperasi->kamarruangan_id = !empty($kamar) ? $kamar->kamarruangan_id : '';
                    $modAreaOperasi->pasien_id = $model->pasien_id;
                    $modAreaOperasi->tgl_penandaanarea = date("Y-m-d H:i:s");
                    $modAreaOperasi->create_time = date("Y-m-d H:i:s");
                    $modAreaOperasi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modAreaOperasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
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

                                // var_dump($ok, $modAreaOpDet->getErrors()); die;

                            }
                        }
                    } 
                }



                if ($ok) {
                    // echo '<pre>'; var_dump('masuk',$_POST); die;
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $transaction->commit();
                } else {
                    // echo '<pre>'; var_dump('keluar',$model->getErrors()); die;
                    Yii::app()->user->setFlash('error', "Data tidak berhasil disimpan");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                echo '<pre>'; var_dump('gagal', $exc, $model->attributes); die();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            // 'temp_file' => !empty($modBagianTubuh) ? $modBagianTubuh->nama_file_gbr : "",
            'gambartubuh_id' => $gambartubuh_id,
            'tblRencanaOperasi' => $tblRencanaOperasi,
            'modAreaOperasi' => $modAreaOperasi,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modAreaDetOp' => $modAreaDetOp,
            'modKunjungan' => $modKunjungan,
            'jenis' => $jenis,
        ));
    }

    public function actionSetLoadBahanMedis() {
        // var_dump('masuk sini gak?');die;
        if (Yii::app()->request->isAjaxRequest) {
            $tipepaket_id = (!empty($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
            $isbukanbebanpasien = (!empty($_GET['isbukanbebanpasien']) ? $_GET['isbukanbebanpasien'] : false);
            $obatalkes_id = (!empty($_GET['obatalkes_id']) ? $_GET['obatalkes_id'] : null);
            $qtypakaibahan = (!empty($_GET['qtypakaibahan']) ? $_GET['qtypakaibahan'] : 1);
            $form = "";

            $modTipepaket = TipepaketM::model()->findByPk($tipepaket_id);
            $details = array();
            $stoktidakcukup = false;
            $namapesan = "";
            $tipepaket = true;

            if ($modTipepaket->isnonpaket == true) {
                $modAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
                $harga = (($isbukanbebanpasien == 1) ? 0 : $modAlkes->hargajual);
                $details[$modTipepaket->tipepaket_id]['tipepaket_id'] = $modTipepaket->tipepaket_id;
                $details[$modTipepaket->tipepaket_id]['tipepaket_nama'] = $modTipepaket->tipepaket_nama;
                
                $jmlstok = StokobatalkesT::getJumlahStok($modAlkes->obatalkes_id, Yii::app()->user->getState("ruangan_id"));
                $namapesan = "Nama Bahan Medis '" . $modAlkes->obatalkes_nama . "'";
                
                $ismendekatiminimalstok = false;
                if ($qtypakaibahan <= $modAlkes->minimalstok) {
                    $stoktidakcukup = true;
                    $tipepaket = false;
                    $ismendekatiminimalstok = true;
                }
                
                $details[$modTipepaket->tipepaket_id]['detail'][] = array(
                    'obatalkes_id' => $modAlkes->obatalkes_id,
                    'obatalkes_nama' => $modAlkes->obatalkes_nama,
                    'jenisobatalkes_nama' => $modAlkes->jenisobatalkes->jenisobatalkes_nama,
                    'tglkadaluarsa' => MyFormatter::formatDateTimeForUser($modAlkes->activedate),
                    'hargajual' => $harga,
                    'qty' => $qtypakaibahan,
                    'satuankecil' => (!empty($modAlkes->satuankecil) ? $modAlkes->satuankecil->satuankecil_nama : ""),
                    'mendekatiminimalstok' =>($ismendekatiminimalstok)?'ya':'tidak'
                );                
            } else {
                $modBmhp = PaketbmhpM::model()->findAllByAttributes(array('tipepaket_id' => $modTipepaket->tipepaket_id));
                $namapesan = "Tipe paket '" . $modTipepaket->tipepaket_nama . "'";
                if (!empty($modBmhp)) {
                    $isstok = 0;                                        
                    foreach ($modBmhp as $bmhp) {
                        $jmlstok = StokobatalkesT::getJumlahStok($bmhp->obatalkes->obatalkes_id, Yii::app()->user->getState("ruangan_id"));
                        $modAlkes = ObatalkesM::model()->findByPk($bmhp->obatalkes->obatalkes_id);
                        $ismendekatiminimalstok = false;
                        
                        if ($bmhp->qtypemakaian <= $modAlkes->minimalstok) {
                            $isstok += 1;
                            $ismendekatiminimalstok = true;
                        } else {
                            if ($isstok > 0) {
                                $isstok -= 1;
                            }
                        }

                        $harga = (($isbukanbebanpasien == 1) ? 0 : $bmhp->obatalkes->hargajual);
                        $details[$bmhp->tipepaket_id]['tipepaket_id'] = $bmhp->tipepaket_id;
                        $details[$bmhp->tipepaket_id]['tipepaket_nama'] = $bmhp->tipepaket->tipepaket_nama;
                        $details[$bmhp->tipepaket_id]['detail'][] = array(
                            'obatalkes_id' => $bmhp->obatalkes->obatalkes_id,
                            'obatalkes_nama' => $bmhp->obatalkes->obatalkes_nama,
                            'jenisobatalkes_nama' => $bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama,
                            'tglkadaluarsa' => MyFormatter::formatDateTimeForUser($bmhp->obatalkes->activedate),
                            'hargajual' => $harga,
                            'qty' => $bmhp->qtypemakaian,
                            'satuankecil' => (!empty($bmhp->obatalkes->satuankecil) ? $bmhp->obatalkes->satuankecil->satuankecil_nama : ""),
                            'mendekatiminimalstok' =>($ismendekatiminimalstok)?'ya':'tidak'
                        );
                    }

                    if ($isstok > 0) {
                        $stoktidakcukup = true;
                        $tipepaket = true;
                    }
                }
            }

            $pesan = "";
            if ($stoktidakcukup == false) {
                if (!empty($details)) {
                    foreach ($details as $detail) {
                        $form = $this->renderPartial($this->path_view . '_rowBmhp', array('detail' => $detail, 'tipepaket' => $tipepaket), true);
                    }
                }
            } else {
                if($tipepaket == true){
                    $pesan = $namapesan . " stok mendekati minimal stok ";
                    if (!empty($details)) {
                        foreach ($details as $detail) {
                            $form = $this->renderPartial($this->path_view . '_rowBmhp', array('detail' => $detail, 'tipepaket' => $tipepaket), true);
                        }
                    }
                } else {
                    $pesan = $namapesan . " stok mendekati minimal stok ";
                }
            }

            $data['html'] = $form;
            $data['pesan'] = $pesan;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrintRiwayatPelayanan($pendaftaran_id, $pelayananpembedahan_id, $caraPrint)
    {
      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPembedahan = PelayananpembedahanT::model()->findByPk($pelayananpembedahan_id); 
      $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

      $judulLaporan = 'Terduga TB';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPembedahan' => $modPembedahan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPembedahan' => $modPembedahan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

        $mpdf->WriteHTML($this->renderPartial('_print', array('format' => $format, 'modProfilRs' => $modProfilRs, 'modPembedahan' => $modPembedahan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
      }
    }

    public function actionHapusRiwayatPelayanan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pelayananpembedahan_id = (isset($_POST['pelayananpembedahan_id']) ? $_POST['pelayananpembedahan_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $area = AreaoperasiT::model()->findByAttributes(array('pelayananpembedahan_id' => $pelayananpembedahan_id));
                if(!empty($area)){
                    AreaoperasidetT::model()->deleteAllByAttributes(array('areaoperasi_id' => $area->areaoperasi_id));
                    $delArea = AreaoperasiT::model()->deleteByPk($area->areaoperasi_id);
                    if($delArea){
                        $delete = PelayananpembedahanT::model()->deleteByPk($pelayananpembedahan_id);
                    }
                }
                if ($delete) {
                    $data['sukses'] = 1;
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Riwayat Pelayanan Pembedahan Berhasil Dihapus!');
                } else {
                    $data['sukses'] = 0;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Menghapus Pelayanan Pembedahan');
                }
            } catch (Exception $exc) {                                                                                                                  
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal Menghapus Pelayanan Pembedahan !!" . MyExceptionMessage::getMessage($exc, true));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionSetDropdownTindakan($encode = false, $model_nama = '', $attr = '', $domisili = false)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new PelayananpembedahanT;
            if ($model_nama !== '' && $attr == '') {
                $pasienkirimkeunitlain_id = $_POST["$model_nama"]['pasienkirimkeunitlain_id'];
                if ($domisili) {
                    $pasienkirimkeunitlain_id = $_POST["$model_nama"]['propinsi_domisili_id'];
                }
            } elseif ($model_nama == '' && $attr !== '') {
                $pasienkirimkeunitlain_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $pasienkirimkeunitlain_id = $_POST["$model_nama"]["$attr"];
            } elseif ($model_nama == '' && $attr == '') {
                $pasienkirimkeunitlain_id = $_POST['propinsi_domisili_id'];
            }

            $pasienicd = null;
            if ($pasienkirimkeunitlain_id) {
                $pasienkirimunitlain = BSPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
                // var_dump($pasienkirimunitlain->pendaftaran_id);die;
                $pasienicd = $model->getPasienIcdItems($pasienkirimunitlain->pendaftaran_id);
                $pasienicd = CHtml::listData($pasienicd, 'pasienicd9cm_id', 'nama');
            }

            if ($encode) {
                echo CJSON::encode($pasienicd);
            } else {
                if (empty($pasienicd)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($pasienicd as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
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
}
