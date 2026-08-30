<?php

/**
 * Controller untuk halaman transaksi Culture
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class CultureTController extends MyAuthController {

    /**
     * Halaman Index
     * @param type $spesimen_id
     * @param type $culture_id
     */
    public function actionIndex($spesimen_id, $culture_id = null) {
        $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);
        $modPenilaian = PenialianKelayakanSpesimenT::model()->findByPk($modSpesimen->penilaian_kelayakan_spesimen_id);
        if (!empty($culture_id)) {
            $modCulture = CultureT::model()->findByPk($culture_id);
            $modCulture->tanggal_culture = MyFormatter::formatDateTimeForUser($modCulture->tanggal_culture);
//            $modCulture->analis_nama = $modCulture->analis->namaLengkap;
//            $modCulture->analis_nip = $modCulture->analis->nomorindukpegawai;
        } else {
            $modCulture = new CultureT();
            $modCulture->tanggal_culture = date('d M Y H:i:s');
        }
        if(!empty($modSpesimen->tindakanpelayanan_id)){
            $modTindakan = TindakanpelayananT::model()->findByPk($modSpesimen->tindakanpelayanan_id);
            $cekTindakan = DaftartindakanM::model()->findByPk($modTindakan->daftartindakan_id);
            $modCulture->tindakanpelayanan_id = $modSpesimen->tindakanpelayanan_id;
            $modCulture->daftartindakan_id = $modTindakan->daftartindakan_id;
            $modCulture->daftartindakan_nama = $cekTindakan->daftartindakan_nama;
        }
        $modRiwayatCulture = CultureT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id));
        if (!empty($modRiwayatCulture)) {
            $modRiwayatCulture = $modRiwayatCulture;
        }
        $modBlood = new BloodAgarT();
        $modBloodGambar = new BloodagarGambarT();
        $modChoc = new ChocAgarT();
        $modChocGambar = new ChocagarGambarT();
        $modMcConcey = new McconceyAgarT();
        $modMcConceyGambar = new McconceyagarGambarT();
        $modBrucella = new RosellaAgarT();
        $modBrucellaGambar = new RosellaagarGambarT();
        $modCook = new CookedmeatbrothT();
        $modThigli = new ThiglikolatbrothT();
        
        $ok = true;
                
        if (isset($_POST['CultureT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($_POST['CultureT']['verifikasiPPDS'] == 'Ya' && empty($_POST['CultureT']['verifikasiDPJTM'])) {
                    if (isset($_POST['BloodAgarT']['detail'])) {
                        $this->verifikasiPPDSBlood($_POST);
                    }
                    if (isset($_POST['ChocAgarT']['detail'])) {
                        $this->verifikasiPPDSChoc($_POST);
                    }
                    if (isset($_POST['McconceyAgarT']['detail'])) {
                        $this->verifikasiPPDSMcconcey($_POST);
                    }
                    if (isset($_POST['RosellaAgarT']['detail'])) {
                        $this->verifikasiPPDSRosella($_POST);
                    }
                    $ok = true;
                }else if ($_POST['CultureT']['verifikasiDPJTM'] == 'Ya' && empty($_POST['CultureT']['verifikasiPPDS'])) {
                    if (isset($_POST['BloodAgarT']['detail'])) {
                        $this->verifikasiDPJTMBlood($_POST);
                    }
                    if (isset($_POST['ChocAgarT']['detail'])) {
                        $this->verifikasiDPJTMChoc($_POST);
                    }
                    if (isset($_POST['McconceyAgarT']['detail'])) {
                        $this->verifikasiDPJTMMcconcey($_POST);
                    }
                    if (isset($_POST['RosellaAgarT']['detail'])) {
                        $this->verifikasiDPJTMRosella($_POST);
                    }
                    $ok = true;
                    
                    $modBlood2 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id)); 
                    $modChoc2 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                    $modMc2 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));

                    $modBlood3 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null')); 
                    $modChoc3 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                    $modMc3 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));

                    if (count($modBlood2) == count($modBlood3) && count($modChoc2) == count($modChoc3) && count($modMc2) == count($modMc3)) {
                        if ($modCulture->daftartindakan_id = 3524) {
                            CultureT::model()->updateByPk($modCulture->culture_id, array('status_verifikasi' => 'Terverifikasi'));
                        }
                    }
                }else if(empty($_POST['CultureT']['verifikasiPPDS']) && empty($_POST['CultureT']['verifikasiDPJTM'])){
                    $modCulture->attributes = $_POST['CultureT'];
                    $modCulture->spesimen_id = $spesimen_id;
                    $modCulture->tanggal_culture = MyFormatter::formatDateTimeForDb($modCulture->tanggal_culture);
                    $modCulture->create_loginpemakai_id = Yii::app()->user->id;
                    $modCulture->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modCulture->create_time = date('Y-m-d H:i:s');
                    $modCulture->tindakanpelayanan_id = $modSpesimen->tindakanpelayanan_id;
                    if ($modCulture->save()) {
                        if (isset($_POST['BloodAgarT']['detail'])) {
                            $this->simpanBlood($modCulture->culture_id, $_POST);
                        }

                        if (isset($_POST['ChocAgarT']['detail'])) {
                            $this->simpanChoc($modCulture->culture_id, $_POST);
                        }

                        if (isset($_POST['McconceyAgarT']['detail'])) {
                            $this->simpanMcconcey($modCulture->culture_id, $_POST);
                        }

                        if (isset($_POST['RosellaAgarT']['detail'])) {
                            $this->simpanRosella($modCulture->culture_id, $_POST);
                        }
                        if($_POST['CookedmeatbrothT']['pilih'] == 1){
                            $this->simpanCook($modCulture->culture_id, $_POST);
                        }
                        if($_POST['ThiglikolatbrothT']['pilih'] == 1){
                            $this->simpanThigli($modCulture->culture_id, $_POST);
                        }
                    }
                    
                }
                
                $modBlood = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id)); 
                $modChoc = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                $modMc = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                $modBrucella = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));

                $modBlood2 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null')); 
                $modChoc2 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));
                $modMc2 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));
                $modBrucella2 = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));

                $modBlood3 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null')); 
                $modChoc3 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $modMc3 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $modBrucella3 = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));

                if (count($modBlood) == count($modBlood2) && count($modChoc) == count($modChoc2) && count($modMc) == count($modMc2) && count($modBrucella) == count($modBrucella2)) {
                    if (count($modBlood) == count($modBlood3) && count($modChoc) == count($modChoc3) && count($modMc) == count($modMc3) && count($modBrucella) == count($modBrucella3)) {
                        $modCulture->status_verifikasi = 'Terverifikasi DPJTM';
                    } else {
                        $modCulture->status_verifikasi = 'Terverifikasi PPDS';
                    }
                } else {
                    $modCulture->status_verifikasi = 'Belum terverifikasi';
                }
                $modCulture->save();

                if ($ok) {
                    $transaction->commit();
                    SpesimenT::model()->updateByPk($spesimen_id, array('status_pemeriksaan' => 'CULTURE'));
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'spesimen_id' => $modCulture->spesimen_id, 'culture_id' => $modCulture->culture_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modCulture));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array(
            'modRiwayatCulture' => $modRiwayatCulture,
            'modCulture' => $modCulture,
            'modBlood' => $modBlood,
            'modBloodGambar' => $modBloodGambar,
            'modChoc' => $modChoc,
            'modChocGambar' => $modChocGambar,
            'modMcConcey' => $modMcConcey,
            'modMcConceyGambar' => $modMcConceyGambar,
            'modBrucella' => $modBrucella,
            'modBrucellaGambar' => $modBrucellaGambar,
            'modCook' => $modCook,
            'modThigli' => $modThigli,
            'modSpesimen' => $modSpesimen,
            'modPenilaian' => $modPenilaian
        ));
    }

    /**
     * Verifikasi Blood Agar PPDS
     * @param type $post
     */
    public function verifikasiPPDSBlood($post){
        foreach ($post['BloodAgarT']['detail'] as $i => $blood) :
            if($blood['pilih'] == 1){
                if (!empty($blood['blood_agar_id'])) {
                    $detBlood = BloodAgarT::model()->findByPk($blood['blood_agar_id']);
                    $detBlood->tgl_verifikasi_ppds = date('Y-m-d H:i:s');
                    $detBlood->save();
                }
            }
        endforeach;
    }
    
    /**
     * Verifikasi Choc Agar PPDS
     * @param type $post
     */
    public function verifikasiPPDSChoc($post){
        foreach ($post['ChocAgarT']['detail'] as $i => $choc) :
            if($choc['pilih'] == 1){
                if (!empty($choc['choc_agar_id'])) {
                    $modChoc = ChocAgarT::model()->findByPk($choc['choc_agar_id']);
                    $modChoc->tgl_verifikasi_ppds = date('Y-m-d H:i:s');
                    $modChoc->save();
                }
            }
        endforeach;
    }
    
    /**
     * Verifikasi Mc Concey PPDS
     * @param type $post
     */
    public function verifikasiPPDSMcconcey($post){
        foreach ($post['McconceyAgarT']['detail'] as $m => $mc) :
            if($mc['pilih'] == 1){
                if (!empty($mc['mcconcey_agar_id'])) {
                    $modMcConcey = McconceyAgarT::model()->findByPk($mc['mcconcey_agar_id']);
                    $modMcConcey->tgl_verifikasi_ppds = date('Y-m-d H:i:s');
                    $modMcConcey->save();
                }
            }
        endforeach;
    }

    /**
     * Verifikasi Rosella PPDS
     * @param type $post
     */
    public function verifikasiPPDSRosella($post){
        foreach ($post['RosellaAgarT']['detail'] as $m => $rs) :
            if($rs['pilih'] == 1){
                if (!empty($rs['rosella_agar_id'])) {
                    $modBrucella = RosellaAgarT::model()->findByPk($rs['rosella_agar_id']);
                    $modBrucella->tgl_verifikasi_ppds = date('Y-m-d H:i:s');
                    $modBrucella->save();
                }
            }
        endforeach;
    }
    
    /**
     * Verifikasi Blood Agar DPJTM
     * @param type $post
     */
    public function verifikasiDPJTMBlood($post){
        foreach ($post['BloodAgarT']['detail'] as $i => $blood) :
            if($blood['pilih'] == 1){
                if (!empty($blood['blood_agar_id'])) {
                    $detBlood = BloodAgarT::model()->findByPk($blood['blood_agar_id']);
                    $detBlood->tgl_verifikasi_dpjtm = date('Y-m-d H:i:s');
                    $detBlood->save();
                }
            }
        endforeach;
    }
    
    /**
     * Verifikasi Choc Agar DPJTM
     * @param type $post
     */
    public function verifikasiDPJTMChoc($post){
        foreach ($post['ChocAgarT']['detail'] as $i => $choc) :
            if($choc['pilih'] == 1){
                if (!empty($choc['choc_agar_id'])) {
                    $modChoc = ChocAgarT::model()->findByPk($choc['choc_agar_id']);
                    $modChoc->tgl_verifikasi_dpjtm = date('Y-m-d H:i:s');
                    $modChoc->save();
                }
            }
        endforeach;
    }
    
    /**
     * Verifikasi Mc Concey DPJTM
     * @param type $post
     */
    public function verifikasiDPJTMMcconcey($post){
        foreach ($post['McconceyAgarT']['detail'] as $m => $mc) :
            if($mc['pilih'] == 1){
                if (!empty($mc['mcconcey_agar_id'])) {
                    $modMcConcey = McconceyAgarT::model()->findByPk($mc['mcconcey_agar_id']);
                    $modMcConcey->tgl_verifikasi_dpjtm = date('Y-m-d H:i:s');
                    $modMcConcey->save();
                }
            }
        endforeach;
    }

    /**
     * Verifikasi Rosella DPJTM
     * @param type $post
     */
    public function verifikasiDPJTMRosella($post){
        foreach ($post['RosellaAgarT']['detail'] as $m => $rs) :
            if($rs['pilih'] == 1){
                if (!empty($rs['rosella_agar_id'])) {
                    $modBrucella = RosellaAgarT::model()->findByPk($rs['rosella_agar_id']);
                    $modBrucella->tgl_verifikasi_dpjtm = date('Y-m-d H:i:s');
                    $modBrucella->save();
                }
            }
        endforeach;
    }
    
    /**
     * Simpan Blood Agar
     * @param type $culture_id
     * @param type $post
     */
    public function simpanBlood($culture_id, $post){
        $temp = '';
        foreach ($post['BloodAgarT']['detail'] as $i => $blood) :
//            if($blood['pilih'] == 1){
                if (!empty($blood['blood_agar_id'])) {
                    $detBlood = BloodAgarT::model()->findByPk($blood['blood_agar_id']);
                    $detBlood->attributes = $blood;
                    $detBlood->culture_id = $culture_id;
                    $detBlood->dpjtm_id = !empty($blood['dpjtm_id']) ? $blood['dpjtm_id'] : null;
                    $detBlood->ppds_id = !empty($blood['ppds_id']) ? $blood['ppds_id'] : null;
                    $detBlood->status_plate = $blood['status_plate'];
                    $detBlood->analis_id = !empty($blood['analis_id']) ? $blood['analis_id'] : null;
                } else {
                    $detBlood = new BloodAgarT();
                    $detBlood->attributes = $blood;
                    $detBlood->culture_id = $culture_id;
                    $detBlood->dpjtm_id = !empty($blood['dpjtm_id']) ? $blood['dpjtm_id'] : null;
                    $detBlood->ppds_id = !empty($blood['ppds_id']) ? $blood['ppds_id'] : null;
                    $detBlood->status_plate = $blood['status_plate'];
                    $detBlood->tanggal = MyFormatter::formatDateTimeForDb($blood['tanggal']);
                    $detBlood->analis_id = !empty($blood['analis_id']) ? $blood['analis_id'] : null;
                }
                if ($detBlood->save()) {
                    if (isset($post['BloodagarGambarT']['detail'][$i])) {
                        foreach ($post['BloodagarGambarT']['detail'][$i] as $j => $blooddet) :
                            if (!empty($blooddet['bloodagar_gambar_id'])) {
                                $bloodGambar = BloodagarGambarT::model()->findByPk($blooddet['bloodagar_gambar_id']);
                                $bloodGambar->blood_agar_id = $detBlood->blood_agar_id;
                                $temp = $blooddet['temp_file'];
                                $bloodGambar->bloodagar_gambar = CUploadedFile::getInstance($bloodGambar, '[detail]['.$i.']['.$j.']bloodagar_gambar');
                                if (!empty($bloodGambar->bloodagar_gambar)) {
                                    $dokumen_pendukung = $bloodGambar->bloodagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokBloodAgarDirectory() . $fullImgName;
                                    $bloodGambar->bloodagar_gambar = $fullImgName;
                                } else {
                                    $bloodGambar->bloodagar_gambar = $temp;
                                }
                            } else { 
                                $bloodGambar = new BloodagarGambarT();
                                $bloodGambar->blood_agar_id = $detBlood->blood_agar_id;
                                $bloodGambar->bloodagar_gambar = CUploadedFile::getInstance($bloodGambar, '[detail]['.$i.']['. $j.']bloodagar_gambar');
                                if (!empty($bloodGambar->bloodagar_gambar)) {
                                    $dokumen_pendukung = $bloodGambar->bloodagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokBloodAgarDirectory() . $fullImgName;
                                    $bloodGambar->bloodagar_gambar = $fullImgName;
                                }
                            }

                            if ($bloodGambar->save()) {
                                if (!empty($dokumen_pendukung)) {
//                                    if ($bloodGambar->bloodagar_gambar != $temp) {
//                                        if (!empty($temp)) {
//                                            if (file_exists(Params::pathDokBloodAgarDirectory() . $temp)) {
//                                                unlink(Params::pathDokBloodAgarDirectory() . $temp);
//                                            }
//                                        }
//                                    }
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        endforeach;
                    }
                }
//            }
        endforeach;
    }
    
    /**
     * Simpan Choc Agar
     * @param type $culture_id
     * @param type $post
     */
    public function simpanChoc($culture_id, $post){
        $temp = '';
        foreach ($post['ChocAgarT']['detail'] as $i => $choc) :
//            if($choc['pilih'] == 1){
                if (!empty($choc['choc_agar_id'])) :
                    $modChoc = ChocAgarT::model()->findByPk($choc['choc_agar_id']);
                    $modChoc->attributes = $choc;
                    $modChoc->culture_id = $culture_id;
                    $modChoc->dpjtm_id = !empty($choc['dpjtm_id']) ? $choc['dpjtm_id'] : null;
                    $modChoc->ppds_id = !empty($choc['ppds_id']) ? $choc['ppds_id'] : null;
                    $modChoc->status_plate = $choc['status_plate'];
                    $modChoc->analis_id = !empty($choc['analis_id']) ? $choc['analis_id'] : null;
                else :
                    $modChoc = new ChocAgarT();
                    $modChoc->attributes = $choc;
                    $modChoc->culture_id = $culture_id;
                    $modChoc->dpjtm_id = !empty($choc['dpjtm_id']) ? $choc['dpjtm_id'] : null;
                    $modChoc->ppds_id = !empty($choc['ppds_id']) ? $choc['ppds_id'] : null;
                    $modChoc->status_plate = $choc['status_plate'];
                    $modChoc->tanggal = MyFormatter::formatDateTimeForDb($choc['tanggal']);
                    $modChoc->analis_id = !empty($choc['analis_id']) ? $choc['analis_id'] : null;
                endif; 

                if ($modChoc->save()) {
                    if (isset($post['ChocagarGambarT']['detail'][$i])) {
                        foreach ($post['ChocagarGambarT']['detail'][$i] as $j => $chocDet) :
                            if (!empty($chocDet['chocagar_gambar_id'])) {
                                $modChocGambar = ChocagarGambarT::model()->findByPk($chocDet['chocagar_gambar_id']);
                                $modChocGambar->choc_agar_id = $modChoc->choc_agar_id;
                                $temp = $chocDet['temp_file'];
                                $modChocGambar->chocagar_gambar = CUploadedFile::getInstance($modChocGambar, '[detail]['.$i.']['.$j.']chocagar_gambar');
                                $random = rand(0000000, 9999999);
                                if (!empty($modChocGambar->chocagar_gambar)) {
                                    $dokumen_pendukung = $modChocGambar->chocagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $random. $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokChocAgarDirectory() . $fullImgName;

                                    $modChocGambar->chocagar_gambar = $fullImgName;
                                } else {
                                    $modChocGambar->chocagar_gambar = $temp; 
                                }
                            } else {
                                $modChocGambar = new ChocagarGambarT();
                                $modChocGambar->choc_agar_id = $modChoc->choc_agar_id;
                                $modChocGambar->chocagar_gambar = CUploadedFile::getInstance($modChocGambar, '[detail][' .$i .']['.$j.']chocagar_gambar');
                                $random = rand(0000000, 9999999);
                                if (!empty($modChocGambar->chocagar_gambar)) {
                                    $dokumen_pendukung = $modChocGambar->chocagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $random. $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokChocAgarDirectory() . $fullImgName;

                                    $modChocGambar->chocagar_gambar = $fullImgName;
                                }
                            }

                            if ($modChocGambar->save()) {
                                if (!empty($dokumen_pendukung)) {
//                                    if ($modChocGambar->chocagar_gambar != $temp) {
//                                        if (!empty($temp)) {
//                                            if (file_exists(Params::pathDokChocAgarDirectory() . $temp)) {
//                                                unlink(Params::pathDokChocAgarDirectory() . $temp);
//                                            }
//                                        }
//                                    }
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        endforeach;
                    }
                }
//            }
        endforeach;
    }
    
    /**
     * Simpan Mc Concey
     * @param type $culture_id
     * @param type $post
     */
    public function simpanMcconcey($culture_id, $post){
        $temp = '';
        foreach ($post['McconceyAgarT']['detail'] as $m => $mc) :
//            if($mc['pilih'] == 1){
                if (!empty($mc['mcconcey_agar_id'])) {
                    $modMcConcey = McconceyAgarT::model()->findByPk($mc['mcconcey_agar_id']);
                    $modMcConcey->attributes = $mc;
                    $modMcConcey->culture_id = $culture_id;
                    $modMcConcey->dpjtm_id = !empty($mc['dpjtm_id']) ? $mc['dpjtm_id'] : null;
                    $modMcConcey->ppds_id = !empty($mc['ppds_id']) ? $mc['ppds_id'] : null;
                    $modMcConcey->status_plate = $mc['status_plate'];
                    $modMcConcey->analis_id = !empty($mc['analis_id']) ? $mc['analis_id'] : null;
                } else {
                    $modMcConcey = new McconceyAgarT();
                    $modMcConcey->attributes = $mc;
                    $modMcConcey->culture_id = $culture_id;
                    $modMcConcey->dpjtm_id = !empty($mc['dpjtm_id']) ? $mc['dpjtm_id'] : null;
                    $modMcConcey->ppds_id = !empty($mc['ppds_id']) ? $mc['ppds_id'] : null;
                    $modMcConcey->status_plate = $mc['status_plate'];
                    $modMcConcey->tanggal = MyFormatter::formatDateTimeForDb($mc['tanggal']);
                    $modMcConcey->analis_id = !empty($mc['analis_id']) ? $mc['analis_id'] : null;
                }

                if ($modMcConcey->save()) {
                    if (isset($post['McconceyagarGambarT']['detail'][$m])) {
                        foreach ($post['McconceyagarGambarT']['detail'][$m] as $n => $mcDet) :
                            if (!empty($mcDet['mcconceyagar_gambar_id'])) {
                                $modMcConceyGambar = McconceyagarGambarT::model()->findByPk($mcDet['mcconceyagar_gambar_id']);
                                $modMcConceyGambar->mcconcey_agar_id = $modMcConcey->mcconcey_agar_id;
                                $temp = $mcDet['temp_file'];
                                $modMcConceyGambar->mcconceyagar_gambar = CUploadedFile::getInstance($modMcConceyGambar, '[detail]['.$m.']['.$n.']mcconceyagar_gambar');
                                if (!empty($modMcConceyGambar->mcconceyagar_gambar)) {
                                    $dokumen_pendukung = $modMcConceyGambar->mcconceyagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokMcconceyAgarDirectory() . $fullImgName;
                                    $modMcConceyGambar->mcconceyagar_gambar = $fullImgName;
                                } else {
                                    $modMcConceyGambar->mcconceyagar_gambar = $temp;
                                }
                            } else {
                                $modMcConceyGambar = new McconceyagarGambarT();
                                $modMcConceyGambar->mcconcey_agar_id = $modMcConcey->mcconcey_agar_id;
                                $modMcConceyGambar->mcconceyagar_gambar = CUploadedFile::getInstance($modMcConceyGambar, '[detail]['.$m.']['.$n.']mcconceyagar_gambar');
                                if (!empty($modMcConceyGambar->mcconceyagar_gambar)) {
                                    $dokumen_pendukung = $modMcConceyGambar->mcconceyagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokMcconceyAgarDirectory() . $fullImgName;
                                    $modMcConceyGambar->mcconceyagar_gambar = $fullImgName;
                                }
                            }

                            if ($modMcConceyGambar->save()) {
                                if (!empty($dokumen_pendukung)) {
//                                    if ($modMcConceyGambar->mcconceyagar_gambar != $temp) {
//                                        if (!empty($temp)) {
//                                            if (file_exists(Params::pathDokMcconceyAgarDirectory() . $temp)) {
//                                                unlink(Params::pathDokMcconceyAgarDirectory() . $temp);
//                                            }
//                                        }
//                                    }
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        endforeach;
                    }
                }
//            }
        endforeach;
    }

    /**
     * Simpan Rosella
     * @param type $culture_id
     * @param type $post
     */
    public function simpanRosella($culture_id, $post){
        $temp = '';
        foreach ($post['RosellaAgarT']['detail'] as $m => $rs) :
//            if($rs['pilih'] == 1){
                if (!empty($rs['rosella_agar_id'])) {
                    $modBrucella = RosellaAgarT::model()->findByPk($rs['rosella_agar_id']);
                    $modBrucella->attributes = $rs;
                    $modBrucella->culture_id = $culture_id;
                    $modBrucella->dpjtm_id = !empty($rs['dpjtm_id']) ? $rs['dpjtm_id'] : null;
                    $modBrucella->ppds_id = !empty($rs['ppds_id']) ? $rs['ppds_id'] : null;
                    $modBrucella->status_plate = $rs['status_plate'];
                    $modBrucella->analis_id = !empty($rs['analis_id']) ? $rs['analis_id'] : null;
                } else {
                    $modBrucella = new RosellaAgarT();
                    $modBrucella->attributes = $rs;
                    $modBrucella->culture_id = $culture_id;
                    $modBrucella->dpjtm_id = !empty($rs['dpjtm_id']) ? $rs['dpjtm_id'] : null;
                    $modBrucella->ppds_id = !empty($rs['ppds_id']) ? $rs['ppds_id'] : null;
                    $modBrucella->status_plate = $rs['status_plate'];
                    $modBrucella->tanggal = MyFormatter::formatDateTimeForDb($rs['tanggal']);
                    $modBrucella->analis_id = !empty($rs['analis_id']) ? $rs['analis_id'] : null;
                }

                if ($modBrucella->save()) {
                    if (isset($post['RosellaagarGambarT']['detail'][$m])) {
                        foreach ($post['RosellaagarGambarT']['detail'][$m] as $n => $rsDet) :
                            if (!empty($rsDet['rosellaagar_gambar_id'])) {
                                $modBrucellaGambar = RosellaagarGambarT::model()->findByPk($rsDet['rosellaagar_gambar_id']);
                                $modBrucellaGambar->rosella_agar_id = $modBrucella->rosella_agar_id;
                                $temp = $rsDet['temp_file'];
                                $modBrucellaGambar->rosellaagar_gambar = CUploadedFile::getInstance($modBrucellaGambar, '[detail]['.$m.']['.$n.']rosellaagar_gambar');
                                if (!empty($modBrucellaGambar->rosellaagar_gambar)) {
                                    $dokumen_pendukung = $modBrucellaGambar->rosellaagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokRosellaAgarDirectory() . $fullImgName;
                                    $modBrucellaGambar->rosellaagar_gambar = $fullImgName;
                                } else {
                                    $modBrucellaGambar->rosellaagar_gambar = $temp;
                                }
                            } else {
                                $modBrucellaGambar = new RosellaagarGambarT();
                                $modBrucellaGambar->rosella_agar_id = $modBrucella->rosella_agar_id;
                                $modBrucellaGambar->rosellaagar_gambar = CUploadedFile::getInstance($modBrucellaGambar, '[detail]['.$m.']['.$n.']rosellaagar_gambar');
                                if (!empty($modBrucellaGambar->rosellaagar_gambar)) {
                                    $dokumen_pendukung = $modBrucellaGambar->rosellaagar_gambar;
                                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                    $fullImgSource = Params::pathDokRosellaAgarDirectory() . $fullImgName;
                                    $modBrucellaGambar->rosellaagar_gambar = $fullImgName;
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                            if ($modBrucellaGambar->save()) {
                                if (!empty($dokumen_pendukung)) {
//                                    if ($modBrucellaGambar->rosellaagar_gambar != $temp) {
//                                        if (!empty($temp)) {
//                                            if (file_exists(Params::pathDokRosellaAgarDirectory() . $temp)) {
//                                                unlink(Params::pathDokRosellaAgarDirectory() . $temp);
//                                            }
//                                        }
//                                    }
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        endforeach;
                    }
                }
//            }
        endforeach;
    }
    
    /**
     * Simpan Cooked Meat Broth
     * @param type $culture_id
     * @param type $post
     */
    public function simpanCook($culture_id, $post){
        $temp = '';
        foreach ($post['CookedmeatbrothT']['detail'] as $m => $ck) :
            if (!empty($ck['cookedmeatbroth_id'])) {
                $modCook = CookedmeatbrothT::model()->findByPk($ck['cookedmeatbroth_id']);
                $modCook->attributes = $ck;
                $modCook->culture_id = $culture_id;
            } else {
                $modCook = new CookedmeatbrothT();
                $modCook->attributes = $ck;
                $modCook->culture_id = $culture_id;
                $modCook->tanggal_cookedmeatbroth = MyFormatter::formatDateTimeForDb($ck['tanggal_cookedmeatbroth']);
            }
            $modCook->save();
        endforeach;
    }
    
    /**
     * Simpan ThiglikolatbrothT Broth
     * @param type $culture_id
     * @param type $post
     */
    public function simpanThigli($culture_id, $post){
        $temp = '';
        foreach ($post['ThiglikolatbrothT']['detail'] as $m => $tg) :
            if (!empty($tg['thiglikolatbroth_id'])) {
                $modThigli = ThiglikolatbrothT::model()->findByPk($tg['thiglikolatbroth_id']);
                $modThigli->attributes = $tg;
                $modThigli->culture_id = $culture_id;
            } else {
                $modThigli = new ThiglikolatbrothT();
                $modThigli->attributes = $tg;
                $modThigli->culture_id = $culture_id;
                $modThigli->tanggal_thiglikolatbroth = MyFormatter::formatDateTimeForDb($tg['tanggal_thiglikolatbroth']);
            }
            $modThigli->save();
        endforeach;
    }
    
    /**
     * Membuka halaman detail
     * @param type $culture_id
     */
    public function actionDetail($culture_id) {
        $this->layout = '//layouts/iframe';
        $modCulture = CultureT::model()->findByPk($culture_id);
        $this->render('detail', array('modCulture' => $modCulture));
    }

    /**
     * Verifikasi hanya bisa dilakukan oleh pegawai verifikator
     */
    public function actionVerifikasi() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];
        $ok = 1;
        $msg = "Verifikasi berhasil dilakukan";
        $date = date('d M Y');
        // update 
        $modCulture = CultureT::model()->findByPk($id);
        $modCulture->status_verifikasi = Params::VERIFIKASI_DISETUJUI;
        $modCulture->tgl_verifikasi = $date;
        if ($modCulture->save()) {
            $msg = "Verifikasi berhasil dilakukan";
        } else {
            $msg = "Verifikasi gagal dilakukan";
        }
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
        Yii::app()->end();
    }

    /**
     * Hapus seluruh data culture
     */
    public function actionHapusCulture() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "Culture berhasil dihapus.";
        $id = $_POST['id'];
        $model = CultureT::model()->findByPk($id);
        try {
            
            // Delete blood agar
            $blood_agar = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $model->culture_id));
            if (!empty($blood_agar)) {
                foreach($blood_agar as $blood){
                    $blood_gbr = BloodagarGambarT::model()->findAllByAttributes(array('blood_agar_id' => $blood->blood_agar_id));
                    if (!empty($blood_gbr)) {
                        foreach ($blood_gbr as $gbr) {
                            $file_sk_temp = $gbr->bloodagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokBloodAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokBloodAgarDirectory() . $file_sk_temp);
                            }
                            BloodagarGambarT::model()->deleteByPk($gbr->bloodagar_gambar_id);
                        }
                    }
                    BloodAgarT::model()->deleteByPk($blood->blood_agar_id);
                }
            }

            // Delete Choc Agar 
            $choc_agars = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $model->culture_id));
            if (!empty($choc_agars)) {
                foreach($choc_agars as $choc_agar) :
                    $choc_gbrs = ChocagarGambarT::model()->findAllByAttributes(array('choc_agar_id' => $choc_agar->choc_agar_id));
                    if (!empty($choc_gbrs)) {
                        foreach ($choc_gbrs as $choc_gbr):                      
                            $file_sk_temp = $choc_gbr->chocagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokChocAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokChocAgarDirectory() . $file_sk_temp);
                            }
                        endforeach;
                        ChocagarGambarT::model()->deleteAllByAttributes(array('choc_agar_id' => $choc_agar->choc_agar_id));
                    }
                    ChocAgarT::model()->deleteByPk($choc_agar->choc_agar_id);
                endforeach;
            }
            
            // Delete Choc Agar
            $mcconceys = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $model->culture_id));
            if (!empty($mcconceys)) {
                foreach($mcconceys as $mcconcey):
                    $mc_gbr = McconceyagarGambarT::model()->findAllByAttributes(array('mcconcey_agar_id' => $mcconcey->mcconcey_agar_id));
                    if (!empty($mc_gbr)) {
                        foreach($mc_gbr as $mc):
                            $file_sk_temp = $mc->mcconceyagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp);
                            }
                        endforeach;
                        McconceyagarGambarT::model()->deleteAllByAttributes(array('mcconcey_agar_id' => $mcconcey->mcconcey_agar_id));
                    }
                    McconceyAgarT::model()->deleteByPk($mcconcey->mcconcey_agar_id);
                endforeach;
            }
            // hapus data Culture
            CultureT::model()->deleteByPk($model->culture_id);
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Hapus culture tidak dapat dilakukan.<br/>"
                    . $ex->getMessage();
            echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
            Yii::app()->end();
        }
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
        Yii::app()->end();
    }

    /**
     * Load blood agar
     */
    public function actionloadBlood() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;

            $modCulture = CultureT::model()->findByPk($culture);
            $new = new BloodAgarT;

            $html = '';
            if ($jenis == 'load') {
                $modBlood = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modBlood)) {
                    foreach($modBlood as $i => $mBlood){
                        $html .= $this->renderPartial('_formLoadBloodAgarSubmit', array('modBlood' => $mBlood, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadBloodAgar', array('modBlood' => $new, 'i' => 0), true);
                }
                
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadBloodAgarPertama', array('modBlood' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadBloodAgar', array('modBlood' => $new, 'i' => 0), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Load data choc agar
     */
    public function actionLoadChoc() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;
            
            $modCulture = CultureT::model()->findByPk($culture);
            $new = new ChocAgarT;

            $html = '';
            if ($jenis == 'load') {
                $modChoc = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modChoc)) {
                    foreach($modChoc as $i => $mChoc){
                        $html .= $this->renderPartial('_formLoadChocAgarSubmit', array('modChoc' => $mChoc, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadChocAgar', array('modChoc' => $new, 'i' => 0), true);
                }
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadChocAgarPertama', array('modChoc' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadChocAgar', array('modChoc' => $new, 'i' => 0), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Load Data Mc Concey
     */
    public function actionLoadMc() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;

            $new = new McconceyAgarT;
            $modCulture = CultureT::model()->findByPk($culture);

            $html = '';
            
            if ($jenis == 'load') {
                $modMc = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modMc)) {
                    foreach($modMc as $i => $mMc){
                        $html .= $this->renderPartial('_formLoadMcAgarSubmit', array('modMcConcey' => $mMc, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadMcAgar', array('modMcConcey' => $new, 'i' => 0), true);
                }
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadMcAgarPertama', array('modMcConcey' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadMcAgar', array('modMcConcey' => $new, 'i' => 0), true);
            }


            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Load Data Rosela
     */
    public function actionLoadRosela() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;

            $new = new RosellaAgarT;
            $modCulture = CultureT::model()->findByPk($culture);

            $html = '';
            
            if ($jenis == 'load') {
                $modRs = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modRs)) {
                    foreach($modRs as $i => $mRs){
                        $html .= $this->renderPartial('_formLoadRsAgarSubmit', array('modBrucella' => $mRs, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadRsAgar', array('modBrucella' => $new, 'i' => 0), true);
                }
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadRsAgarPertama', array('modBrucella' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadRsAgar', array('modBrucella' => $new, 'i' => 0), true);
            }


            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Load data cook agar
     */
    public function actionLoadCook() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;
            
            $modCulture = CultureT::model()->findByPk($culture);
            $new = new CookedmeatbrothT;

            $html = '';
            if ($jenis == 'load') {
                $modCook = CookedmeatbrothT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modCook)) {
                    foreach($modCook as $i => $mCook){
                        $html .= $this->renderPartial('_formLoadCookAgarSubmit', array('modCook' => $mCook, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadCookAgar', array('modCook' => $new, 'i' => 0), true);
                }
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadCookAgarPertama', array('modCook' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadCookAgar', array('modCook' => $new, 'i' => 0), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Load data thigli agar
     */
    public function actionLoadThigli() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $culture = isset($_POST['culture']) ? $_POST['culture'] : null;
            
            $modCulture = CultureT::model()->findByPk($culture);
            $new = new ThiglikolatbrothT;

            $html = '';
            if ($jenis == 'load') {
                $modThigli = ThiglikolatbrothT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                if (!empty($modThigli)) {
                    foreach($modThigli as $i => $mThigli){
                        $html .= $this->renderPartial('_formLoadThigliAgarSubmit', array('modThigli' => $mThigli, 'i' => 0), true);
                    }
                } else {
                    $html .= $this->renderPartial('_formLoadThigliAgar', array('modThigli' => $new, 'i' => 0), true);
                }
            } else if($jenis == 'pertama'){
                $html .= $this->renderPartial('_formLoadThigliAgarPertama', array('modThigli' => $new, 'i' => 0), true);
            } else {
                $html .= $this->renderPartial('_formLoadThigliAgar', array('modThigli' => $new, 'i' => 0), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Hapus Data Rosela Agar
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteRosela($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $rosella = RosellaAgarT::model()->findByPk($id);
                if (!empty($rosella)) {
                    $rs_gbr = RosellaagarGambarT::model()->findAllByAttributes(array('rosella_agar_id' => $rosella->rosella_agar_id));
                    if (!empty($rs_gbr)) {
                        foreach ($rs_gbr as $rs) {
                            $file_sk_temp = $rs->rosellaagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokRosellaAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokRosellaAgarDirectory() . $file_sk_temp);
                            }
                        }
                        $modRsGambar = RosellaagarGambarT::model()->deleteAllByAttributes(array('rosella_agar_id' => $rosella->rosella_agar_id));
                    }
                    $modRs = RosellaAgarT::model()->deleteByPk($rosella->rosella_agar_id);
                }
                if($modRsGambar && $modRs){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Data Mc Concey Agar
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteMc($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $mcconcey = McconceyAgarT::model()->findByPk($id);
                if (!empty($mcconcey)) {
                    $mc_gbr = McconceyagarGambarT::model()->findAllByAttributes(array('mcconcey_agar_id' => $mcconcey->mcconcey_agar_id));
                    if (!empty($mc_gbr)) {
                        foreach ($mc_gbr as $mc) {
                            $file_sk_temp = $mc->mcconceyagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp);
                            }
                        }
                        $modMcGambar = McconceyagarGambarT::model()->deleteAllByAttributes(array('mcconcey_agar_id' => $mcconcey->mcconcey_agar_id));
                    }
                    $modMc = McconceyAgarT::model()->deleteByPk($mcconcey->mcconcey_agar_id);
                }
                if($modMcGambar && $modMc){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Data Choc Agar
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteChoc($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $choc_agar = ChocAgarT::model()->findByPk($id);
                $choc_gbr = ChocagarGambarT::model()->findAllByAttributes(array('choc_agar_id' => $id));
                if (!empty($choc_gbr)) {
                    foreach ($choc_gbr as $choc) {
                        $file_sk_temp = $choc->chocagar_gambar;
                        if (!empty($file_sk_temp) && file_exists(Params::pathDokChocAgarDirectory() . $file_sk_temp)) {
                            unlink(Params::pathDokChocAgarDirectory() . $file_sk_temp);
                        }
                    }
                    $modChocGambar = ChocagarGambarT::model()->deleteAllbyAttributes(array('choc_agar_id' => $choc_agar->choc_agar_id));
                }
                $modChoc = ChocAgarT::model()->deleteByPk($choc_agar->choc_agar_id);
                if($modChocGambar && $modChoc){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Hapus Data Choc Agar
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteBlood($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $blood_agar = BloodAgarT::model()->findByPk($id);
                if (!empty($blood_agar)) {
                    $blood_gbr = BloodagarGambarT::model()->findAllByAttributes(array('blood_agar_id' => $blood_agar->blood_agar_id));
                    if (!empty($blood_gbr)) {
                        foreach ($blood_gbr as $gbr) {
                            $file_sk_temp = $gbr->bloodagar_gambar;
                            if (!empty($file_sk_temp) && file_exists(Params::pathDokBloodAgarDirectory() . $file_sk_temp)) {
                                unlink(Params::pathDokBloodAgarDirectory() . $file_sk_temp);
                            }
                        }
                        $modBloodGambar = BloodagarGambarT::model()->deleteAllByAttributes(array('blood_agar_id' => $blood_agar->blood_agar_id));
                    }
                    $modBlood = BloodAgarT::model()->deleteByPk($blood_agar->blood_agar_id);
                }
                if($modBloodGambar && $modBlood){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Gambar Blood
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteGambarBlood($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $blood_agar = BloodagarGambarT::model()->findByPk($id);
                if (!empty($blood_agar)) {
                    $file_sk_temp = $blood_agar->bloodagar_gambar;
                    if (!empty($file_sk_temp) && file_exists(Params::pathDokBloodAgarDirectory() . $file_sk_temp)) {
                        unlink(Params::pathDokBloodAgarDirectory() . $file_sk_temp);
                    }
                    $modBloodGambar = BloodagarGambarT::model()->deleteByPk($id);
                }
                if($modBloodGambar){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Gambar Choc
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteGambarChoc($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $choc_agar = ChocagarGambarT::model()->findByPk($id);
                if (!empty($choc_agar)) {
                    $file_sk_temp = $choc_agar->chocagar_gambar;
                    if (!empty($file_sk_temp) && file_exists(Params::pathDokChocAgarDirectory() . $file_sk_temp)) {
                        unlink(Params::pathDokChocAgarDirectory() . $file_sk_temp);
                    }
                    $modChocAgar = ChocagarGambarT::model()->deleteByPk($id);
                }
                if($modChocAgar){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Gambar Mc Concey
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteGambarMc($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $mc_agar = McconceyagarGambarT::model()->findByPk($id);
                if (!empty($mc_agar)) {
                    $file_sk_temp = $mc_agar->mcconceyagar_gambar;
                    if (!empty($file_sk_temp) && file_exists(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp)) {
                        unlink(Params::pathDokMcconceyAgarDirectory() . $file_sk_temp);
                    }
                    $modMcAgar = McconceyagarGambarT::model()->deleteByPk($id);
                }
                if($modMcAgar){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Hapus Gambar Rosela
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeleteGambarRs($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $rs_agar = RosellaagarGambarT::model()->findByPk($id);
                if (!empty($rs_agar)) {
                    $file_sk_temp = $rs_agar->rosellaagar_gambar;
                    if (!empty($file_sk_temp) && file_exists(Params::pathDokRosellaAgarDirectory() . $file_sk_temp)) {
                        unlink(Params::pathDokRosellaAgarDirectory() . $file_sk_temp);
                    }
                    $modRsAgar = RosellaagarGambarT::model()->deleteByPk($id);
                }
                if($modRsAgar){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Autocomplete PPDS
     */
    public function actionGetPpds() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['ppds_id'])) {
                if (!empty($_GET['ppds_id'])) {
                    $criteria->addCondition("t.ppds_id = " . $_GET['ppds_id']);
                }
            }
            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'ppds_nama ASC';
            $criteria->addCondition("t.ppds_aktif IS TRUE");
            $criteria->addCondition("t.verifikasi_status = 'Disetujui'");
            $criteria->limit = 10;
            $models = PpdsM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nim . " - " . $model->ppds_nama;
                $returnVal[$i]['ppds_nama'] = $model->ppds_nama;
                $returnVal[$i]['ppds_nim'] = $model->ppds_nim;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete DPJTM
     */
    public function actionGetDpjtm() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->addCondition("t.pegawai_aktif IS TRUE");
            $criteria->limit = 10;
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete PPDS
     */
    public function actionGetAnalis() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['analis_id'])) {
                if (!empty($_GET['analis_id'])) {
                    $criteria->addCondition("t.pegawai_id = " . $_GET['analis_id']);
                }
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->addCondition("t.pegawai_aktif IS TRUE");
            $criteria->addCondition("t.kelompokpegawai_id != " . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->limit = 10;
            $models = MKPegawairuanganV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
        
}