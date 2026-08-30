<?php

/**
 *   - digunakan sebagai url utama untuk mengelola transaksi asesmen triage
 *   @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *   @website	<piindonesia.co.id>
 */
Yii::import('rawatJalan.models.*');

class AsesmenTriageController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.asesmenTriage.';
    public $validPulang = false;

    public function actionAutocompletePegawai($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPPA = new PegawairuanganV('search');
        $modPPA->unsetAttributes();
        $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPPA->nama_pegawai = $term;

        $prov = $modPPA->search();
        $prov->sort->defaultOrder = 'nama_pegawai';

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->namaLengkap;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionGetSkor() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $query = DetailpemeriksaantriageM::model()->findByPk($_POST['id']);

        $data['skor'] = !empty($query)?$query->skor:0;
        echo CJSON::encode($data);
    }

    public function actionGetColor() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $query = PrioritastriageM::model()->findByAttributes(array('prioritas_nama' => $_POST['warna']));

        $data['warna'] = $query->prioritas_nama;
        $data['code'] = $query->warna;
        $data['prioritastriage_id'] = $query->prioritastriage_id;

        echo CJSON::encode($data);
    }

    public function actionGetNoTriage() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $query = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));

        
        $data['no_triage_pasien'] = $query->no_triage_pasien . ' - ' . $query->no_bed_triage;
        $data['notriage_pasien_id'] = $query->notriage_pasien_id;
        $data['tgl_masuk'] = MyFormatter::formatDateTimeForUser($query->create_time);

        echo CJSON::encode($data);
    }



    public function actionGetNoTriage2() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $query = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));

        $data['no_triage_pasien'] = $query->no_triage_pasien . ' - ' . $query->no_bed_triage;
        $data['notriage_pasien_id'] = $query->notriage_pasien_id;
        $data['tgl_masuk'] = MyFormatter::formatDateTimeForUser($query->create_time);

        echo CJSON::encode($data);
    }

    

    public function actionIndexWPS($pendaftaran_id = null, $frame=1, $notriage_pasien_id = null) {
        if ($frame == 0){
            $this->layout = '//layouts/mainNeonSidebar';
        }
        $format = new MyFormatter();
        $modPendaftaran = !empty($pendaftaran_id)?RJPendaftaranT::model()->findByPk($pendaftaran_id):new RJPendaftaranT;
        
        $modPasien = !empty($pendaftaran_id)?RJPasienM::model()->findByPk($modPendaftaran->pasien_id):new RJPasienM;
        
        if(!empty($pendaftaran_id)){
            // var_dump('2', $notriage_pasien_id);die;
            $getNoTriage = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $notriage_pasien_id = empty($getNoTriage->notriage_pasien_id) ? null : $getNoTriage->notriage_pasien_id;
        }
        
        // var_dump('on ',$pendaftaran_id, $notriage_pasien_id);die;
        if(!empty($pendaftaran_id) && empty($notriage_pasien_id)) {
            // var_dump('2', $notriage_pasien_id);die;
            if(empty($notriage_pasien_id)){
                echo 'Anda belum memilih No. triage Pasien';
                die;
            } else {
                $modAsesTriase = RDAsesmentriagewpssT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));

                $asesmen = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));
                // $asesmenDet = AsesmentriagewpssdetT::model()->findByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id));

                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;

                $modAsesTriase->waktudatang = $asesmen->waktudatang;
                $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;
                
                $modAsesTriase->caramasuk = $asesmen->caramasuk;
                if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                    $modAsesTriase->transportasi = 'Lainnya';
                    $modAsesTriase->transport_lain = $asesmen->transportasi;
                } else {
                    $modAsesTriase->transportasi = $asesmen->transportasi;
                }
                if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                    $modAsesTriase->dikirimoleh = 'Lainnya';
                    $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
                } else {
                    $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
                }
                $modAsesTriase->jeniskasus = $asesmen->jeniskasus;
                
                $modAsesTriase->appereance = $asesmen->appereance;
                $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
                $modAsesTriase->crculation = $asesmen->crculation;
                
                $modAsesTriase->totalskor = $asesmen->totalskor;
                $modAsesTriase->warnatriage = $asesmen->warnatriage;
                $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;
                
                // $modAsesTriase->ruang = $asesmen->ruang;
                $modAsesTriase->keputusan = $asesmen->keputusan;

                $pegLogin = PegawaiM::model()->findByPk($asesmen->petugastriage_id);
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                 //   $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            }

        } else if(empty($pendaftaran_id) && !empty($notriage_pasien_id)) {
            // var_dump('3');die;
            $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));

            $modAsesTriase = new RDAsesmentriagewpssT;
            $modAsesTriase->waktuperiksa = date('Y-m-d H:i:s');
            $modAsesTriase->waktudatang = $notTriageP->create_time;
            $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;
            $modAsesTriase->notriage_pasien_id = $notriage_pasien_id;
            
            $pegLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if (!empty($pegLogin)){
                $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
            }
            
        } else if(!empty($pendaftaran_id) && !empty($notriage_pasien_id)) {
            // tabulasi asesmen emergency care
            $cekas = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), ['order' => 'create_time desc']);
            // echo '<pre>';var_dump($cekas);die;
            if (empty($cekas)){
                // var_dump('13');die;
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));
                
                $modAsesTriase = new RDAsesmentriagewpssT;
                $modAsesTriase->waktuperiksa = date('Y-m-d H:i:s');
                $modAsesTriase->waktudatang = $notTriageP->create_time;
                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;
                $modAsesTriase->notriage_pasien_id = $notriage_pasien_id;
                
                $pegLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                    $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            } else {
                // var_dump('12');die;
                $modAsesTriase = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), ['order' => 'create_time desc']);

                // $modDet = AsesmentriagewpssdetT::model()->findAllByAttributes(array('asesmentriagewpss_id' => $modAsesTriase->asesmentriagewpss_id));
                // echo strval($modDet[intval($key)]->asesmentriagewpssdet_id);
                // $drop = DetailpemeriksaantriageM::model()->findAllByAttributes(array());

                $asesmen = RDAsesmentriagewpssT::model()->findByPk(array('asesmentriagewpss_id' => $modAsesTriase->asesmentriagewpss_id));
                $modAsesTriaseDet = AsesmentriagewpssdetT::model()->findAllByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id));

                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;

                $modAsesTriase->waktudatang = $asesmen->waktudatang;
                $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;
                
                $modAsesTriase->caramasuk = $asesmen->caramasuk;
                if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                    $modAsesTriase->transportasi = 'Lainnya';
                    $modAsesTriase->transport_lain = $asesmen->transportasi;
                } else {
                    $modAsesTriase->transportasi = $asesmen->transportasi;
                }
                if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                    $modAsesTriase->dikirimoleh = 'Lainnya';
                    $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
                } else {
                    $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
                }
                $modAsesTriase->jeniskasus = $asesmen->jeniskasus;
                
                $modAsesTriase->appereance = $asesmen->appereance;
                $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
                $modAsesTriase->crculation = $asesmen->crculation;
                
                // foreach($modAsesTriaseDet as $g => $pop){
                //     // echo '<pre>';var_dump('ini isinya pop ', $pop->asesmentriagewpssdet_id);die;
                //     // $a = array($pop['asesmentriagewpssdet_id'], '');
                //     $modAsesTriaseDet[$g]->asesmentriagewpssdet_id = $pop->asesmentriagewpssdet_id;
                // }

                $modAsesTriase->totalskor = $asesmen->totalskor;
                $modAsesTriase->warnatriage = $asesmen->warnatriage;
                $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;
                
                // $modAsesTriase->ruang = $asesmen->ruang;
                $modAsesTriase->keputusan = $asesmen->keputusan;
                // echo '<pre>';var_dump('12', $modAsesTriaseDet);die;
                $pegLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                    // $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            }

        }

        $modAsesTriaseDet = new RDAsesmentriagewpssdetT;
        $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
        $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        $modelPulang = new RDPasienPulangT;
        $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
        $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
        $modelPulang->pasien_id = $modPendaftaran->pasien_id;
        $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        $modSep = new SepT;
        if(!empty($modPendaftaran->sep_id)) {
            $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
        }

        $gagalSimpanAlert = [];
        $gagalSimpanAlert['status'] = false;
        if (isset($_POST['RDAsesmentriagewpssT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // echo '<pre>';var_dump($_POST);die;
                $modAsesTriase = new RDAsesmentriagewpssT();

                $modAsesTriase->attributes = $_POST['RDAsesmentriagewpssT'];
                $modAsesTriase->waktudatang = MyFormatter::formatDateTimeForDb($modAsesTriase->waktudatang);
                $modAsesTriase->waktuperiksa = MyFormatter::formatDateTimeForDb($modAsesTriase->waktuperiksa);
                $modAsesTriase->pasien_id = $modPendaftaran->pasien_id;
                
                if (!$modAsesTriase->isNewRecord) {
                    $modAsesTriase->update_time = date("Y-m-d H:i:s");
                    $modAsesTriase->update_loginpemakai_id = Yii::app()->user->id;
                } else {
                    $modAsesTriase->create_time = date("Y-m-d H:i:s");
                    $modAsesTriase->create_loginpemakai_id = Yii::app()->user->id;
                    $modAsesTriase->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                // if (!empty($notriage_pasien_id)){
                //     $modAsesTriase->create_ruangan = $notriage_pasien_id;
                // }

                if (!empty($_POST['RDAsesmentriagewpssT']['transport_lain'])) {
                    $modAsesTriase->transportasi = $_POST['RDAsesmentriagewpssT']['transport_lain'];
                }

                if (!empty($_POST['RDAsesmentriagewpssT']['dikirim_lain'])) {
                    $modAsesTriase->dikirimoleh = $_POST['RDAsesmentriagewpssT']['dikirim_lain'];
                }

                $ok = $ok && $modAsesTriase->save();

                if (isset($_POST['RDAsesmentriagewpssdetT'])) {
                    foreach ($_POST['RDAsesmentriagewpssdetT']['detailpemeriksaantriage_id'] as $key => $value) {
                        
                        if (!empty($value)) {
                            if(!empty($_POST['RDAsesmentriagewpssdetT']['asesmentriagewpssdet_id'])) {
                                $modAsesTriaseDet = RDAsesmentriagewpssdetT::model()->findByPk($_POST['RDAsesmentriagewpssdetT']['asesmentriagewpssdet_id']);
                                $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
                                $modAsesTriaseDet->asesmentriagewpss_id = $modAsesTriase->asesmentriagewpss_id;
                                $modAsesTriaseDet->pemeriksaantriage_id = $_POST['RDAsesmentriagewpssdetT']['pemeriksaantriage_id'][$key];
                                $modAsesTriaseDet->skor = $_POST['RDAsesmentriagewpssdetT']['skor'][$key];
                                $modAsesTriaseDet->detailpemeriksaantriage_id = $value;
                                $modAsesTriaseDet->update_time = date("Y-m-d H:i:s");
                                $modAsesTriaseDet->update_loginpemakai_id = Yii::app()->user->id;
                                // echo '<pre>';var_dump('13');die;
                                $ok = $ok && $modAsesTriaseDet->save();
                            } else {
                                $modAsesTriaseDet = new RDAsesmentriagewpssdetT();
                                $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
                                $modAsesTriaseDet->asesmentriagewpss_id = $modAsesTriase->asesmentriagewpss_id;
                                $modAsesTriaseDet->pemeriksaantriage_id = $_POST['RDAsesmentriagewpssdetT']['pemeriksaantriage_id'][$key];
                                $modAsesTriaseDet->skor = $_POST['RDAsesmentriagewpssdetT']['skor'][$key];
                                $modAsesTriaseDet->detailpemeriksaantriage_id = $value;
                                $modAsesTriaseDet->create_time = date("Y-m-d H:i:s");
                                $modAsesTriaseDet->create_loginpemakai_id = Yii::app()->user->id;
                                $modAsesTriaseDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                // echo '<pre>';var_dump('12');die;
                                $ok = $ok && $modAsesTriaseDet->save();
                            }
                        }
                    }
                    if(isset($_POST['RDPasienPulangT']) && $_POST['RDPasienPulangT']['kondisikeluar_id'] !== '') {
                        $modelPulang = $this->savePasienPulang($modelPulang, $_POST['RDPasienPulangT']);
                        if($this->validPulang) {
                            $ok = true;
                            if(!empty($modelPulang->pendaftaran_id)) {
                                PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id));
                    
                                RespontimeR::setPasienKeluar($modelPulang->pendaftaran_id, $modelPulang->tglpasienpulang);
                            }
                        } else {
                            $ok = false;
                        }
                    }
                }

                if ($ok) {                    
                    // echo '<pre>';var_dump('oke ', $_POST);die;                    
                    $transaction->commit();                    
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(empty($pendaftaran_id)){               
                        $this->redirect(
                            $this->createUrl('InformasiBedTriage/Index')
                        );
                    } else {                 
                        $this->redirect(array('indexWps', 'pendaftaran_id' => $pendaftaran_id, 'frame' => $frame, 'notriage_pasien_id' => $notriage_pasien_id, 'sukses' => 1));
                    }
                } else {
                    // echo '<pre>';var_dump('gagal ', $_POST);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data asesmen triase gagal disimpan " . CHtml::errorSummary($modAsesTriase));
                }
            } catch (Exception $exc) {
                // echo '<pre>';var_dump($exc);die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                if (YII_DEBUG == true) {
                    $gagalSimpanAlert['status'] = true;
                    $gagalSimpanAlert['pesan'] = MyExceptionMessage::getMessage($exc, true);
                } else {
                    $gagalSimpanAlert['status'] = true;
                    $gagalSimpanAlert['pesan'] = MyExceptionMessage::getMessage($exc, true);

                }
            }
        }

        if(isset($_GET['display'])){
            $asesmen = AsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));
            // $asesmenDet = AsesmentriagewpssdetT::model()->findByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
            $modAsesTriase->waktudatang = $asesmen->waktudatang;
            $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;

            $modAsesTriase->caramasuk = $asesmen->caramasuk;
            if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                $modAsesTriase->transportasi = 'Lainnya';
                $modAsesTriase->transport_lain = $asesmen->transportasi;
            } else {
                $modAsesTriase->transportasi = $asesmen->transportasi;
            }
            if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                $modAsesTriase->dikirimoleh = 'Lainnya';
                $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
            } else {
                $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
            }
            $modAsesTriase->jeniskasus = $asesmen->jeniskasus;

            $modAsesTriase->appereance = $asesmen->appereance;
            $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
            $modAsesTriase->crculation = $asesmen->crculation;
            
            $modAsesTriase->totalskor = $asesmen->totalskor;
            $modAsesTriase->warnatriage = $asesmen->warnatriage;
            $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;

            $modAsesTriase->ruang = $asesmen->ruang;
            $modAsesTriase->keputusan = $asesmen->keputusan;
        }

        $this->render($this->path_view . 'indexNew', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAsesTriase' => $modAsesTriase,
            'modAsesTriaseDet' => $modAsesTriaseDet,
            'modelPulang' => $modelPulang,
            'modSep' => $modSep,
            'gagalSimpanAlert' => $gagalSimpanAlert
        ));
    }





    public function actionUpdateWPS($asesmentriagewpss_id=null,$pendaftaran_id = null, $frame=1, $notriage_pasien_id = null) {
        if ($frame == 0){
            $this->layout = '//layouts/mainNeonSidebar';
        }
        $format = new MyFormatter();
        $modPendaftaran = !empty($pendaftaran_id)?RJPendaftaranT::model()->findByPk($pendaftaran_id):new RJPendaftaranT;
        
        $modPasien = !empty($pendaftaran_id)?RJPasienM::model()->findByPk($modPendaftaran->pasien_id):new RJPasienM;
        
        if(!empty($pendaftaran_id)){
            // var_dump('2', $notriage_pasien_id);die;
            $getNoTriage = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $notriage_pasien_id = empty($getNoTriage->notriage_pasien_id) ? null : $getNoTriage->notriage_pasien_id;
        }
        
        // var_dump('on ',$pendaftaran_id, $notriage_pasien_id);die;
        if(!empty($pendaftaran_id) && empty($notriage_pasien_id)) {
            // var_dump('2', $notriage_pasien_id);die;
            if(empty($notriage_pasien_id)){
                echo 'Anda belum memilih No. triage Pasien';
                die;
            } else {
                $modAsesTriase = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));

                $asesmen = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));
                // $asesmenDet = AsesmentriagewpssdetT::model()->findByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id));

                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;

                $modAsesTriase->waktudatang = $asesmen->waktudatang;
                $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;
                
                $modAsesTriase->caramasuk = $asesmen->caramasuk;
                if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                    $modAsesTriase->transportasi = 'Lainnya';
                    $modAsesTriase->transport_lain = $asesmen->transportasi;
                } else {
                    $modAsesTriase->transportasi = $asesmen->transportasi;
                }
                if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                    $modAsesTriase->dikirimoleh = 'Lainnya';
                    $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
                } else {
                    $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
                }
                $modAsesTriase->jeniskasus = $asesmen->jeniskasus;
                
                $modAsesTriase->appereance = $asesmen->appereance;
                $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
                $modAsesTriase->crculation = $asesmen->crculation;
                
                $modAsesTriase->totalskor = $asesmen->totalskor;
                $modAsesTriase->warnatriage = $asesmen->warnatriage;
                $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;
                
                $modAsesTriase->ruang = $asesmen->ruang;
                $modAsesTriase->keputusan = $asesmen->keputusan;

                $pegLogin = PegawaiM::model()->findByPk($asesmen->petugastriage_id);
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
             //       $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            }

        } else if(empty($pendaftaran_id) && !empty($notriage_pasien_id)) {
            // var_dump('3');die;
            $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));

            $modAsesTriase = new RDAsesmentriagewpssT;
            $modAsesTriase->waktuperiksa = date('Y-m-d H:i:s');
            $modAsesTriase->waktudatang = $notTriageP->create_time;
            $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;
            $modAsesTriase->notriage_pasien_id = $notriage_pasien_id;
            
            $pegLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if (!empty($pegLogin)){
                $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
              //  $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
            }
            
        } else if(!empty($pendaftaran_id) && !empty($notriage_pasien_id)) {
            $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));

        
            $cekas = RDAsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id, 'pendaftaran_id' => $pendaftaran_id));
            if (empty($cekas)){
                // var_dump('13');die;
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));
                
                $modAsesTriase = new RDAsesmentriagewpssT;
                $modAsesTriase->waktuperiksa = date('Y-m-d H:i:s');
                $modAsesTriase->waktudatang = $notTriageP->create_time;
                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;
                $modAsesTriase->notriage_pasien_id = $notriage_pasien_id;
                
                $pegLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                 //   $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            } else {
                // var_dump('12');die;
                $modAsesTriase = RDAsesmentriagewpssT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'notriage_pasien_id' => $notriage_pasien_id));

                // $modDet = AsesmentriagewpssdetT::model()->findAllByAttributes(array('asesmentriagewpss_id' => $modAsesTriase->asesmentriagewpss_id));
                // echo strval($modDet[intval($key)]->asesmentriagewpssdet_id);
                // $drop = DetailpemeriksaantriageM::model()->findAllByAttributes(array());

                $asesmen = RDAsesmentriagewpssT::model()->findByPk(array('asesmentriagewpss_id' => $modAsesTriase->asesmentriagewpss_id));
                $modAsesTriaseDet = AsesmentriagewpssdetT::model()->findAllByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
                $notTriageP = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $modAsesTriase->notriage_pasien_id));

                $modAsesTriase->no_triage = $notTriageP->no_bed_triage . '-' .$notTriageP->no_triage_pasien;

                $modAsesTriase->waktudatang = $asesmen->waktudatang;
                $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;
                
                $modAsesTriase->caramasuk = $asesmen->caramasuk;
                if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                    $modAsesTriase->transportasi = 'Lainnya';
                    $modAsesTriase->transport_lain = $asesmen->transportasi;
                } else {
                    $modAsesTriase->transportasi = $asesmen->transportasi;
                }
                if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                    $modAsesTriase->dikirimoleh = 'Lainnya';
                    $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
                } else {
                    $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
                }
                $modAsesTriase->jeniskasus = $asesmen->jeniskasus;
                
                $modAsesTriase->appereance = $asesmen->appereance;
                $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
                $modAsesTriase->crculation = $asesmen->crculation;
                
                // foreach($modAsesTriaseDet as $g => $pop){
                //     // echo '<pre>';var_dump('ini isinya pop ', $pop->asesmentriagewpssdet_id);die;
                //     // $a = array($pop['asesmentriagewpssdet_id'], '');
                //     $modAsesTriaseDet[$g]->asesmentriagewpssdet_id = $pop->asesmentriagewpssdet_id;
                // }

                $modAsesTriase->totalskor = $asesmen->totalskor;
                $modAsesTriase->warnatriage = $asesmen->warnatriage;
                $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;
                
                $modAsesTriase->ruang = $asesmen->ruang;
                $modAsesTriase->keputusan = $asesmen->keputusan;
                // echo '<pre>';var_dump('12', $modAsesTriaseDet);die;
                $pegLogin = PegawaiM::model()->findByPk($asesmen->petugastriage_id);
                if (!empty($pegLogin)){
                    $modAsesTriase->petugastriage_id = $pegLogin->pegawai_id;
                //   $modAsesTriase->petugastriage_nama = $pegLogin->namaLengkap;
                }
            }

        }

        if(!empty($asesmentriagewpss_id)) {
            $modAsesTriase = RDAsesmentriagewpssT::model()->findByPk($asesmentriagewpss_id);
            // var_dump($modAsesTriase);die;
        }

        $modAsesTriaseDet = new RDAsesmentriagewpssdetT;
        $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
        $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        if (isset($_POST['RDAsesmentriagewpssT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // echo '<pre>';var_dump($_POST);die;
                // var_dump($modAsesTriase);die;
                $modAsesTriase = new RDAsesmentriagewpssT();

                $modAsesTriase->attributes = $_POST['RDAsesmentriagewpssT'];
                $modAsesTriase->waktudatang = MyFormatter::formatDateTimeForDb($modAsesTriase->waktudatang);
                $modAsesTriase->waktuperiksa = MyFormatter::formatDateTimeForDb($modAsesTriase->waktuperiksa);
                $modAsesTriase->pasien_id = $modPendaftaran->pasien_id;
                $modAsesTriase->notriage_pasien_id = $notriage_pasien_id;
                
                if (!$modAsesTriase->isNewRecord) {
                    $modAsesTriase->update_time = date("Y-m-d H:i:s");
                    $modAsesTriase->update_loginpemakai_id = Yii::app()->user->id;
                } else {
                    $modAsesTriase->create_time = date("Y-m-d H:i:s");
                    $modAsesTriase->create_loginpemakai_id = Yii::app()->user->id;
                    $modAsesTriase->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                // if (!empty($notriage_pasien_id)){
                //     $modAsesTriase->create_ruangan = $notriage_pasien_id;
                // }

                if (!empty($_POST['RDAsesmentriagewpssT']['transport_lain'])) {
                    $modAsesTriase->transportasi = $_POST['RDAsesmentriagewpssT']['transport_lain'];
                }

                if (!empty($_POST['RDAsesmentriagewpssT']['dikirim_lain'])) {
                    $modAsesTriase->dikirimoleh = $_POST['RDAsesmentriagewpssT']['dikirim_lain'];
                }

                $ok = $ok && $modAsesTriase->save();

                if (isset($_POST['RDAsesmentriagewpssdetT'])) {
                    foreach ($_POST['RDAsesmentriagewpssdetT']['detailpemeriksaantriage_id'] as $key => $value) {
                        
                        if (!empty($value)) {
                            if(!empty($_POST['RDAsesmentriagewpssdetT']['asesmentriagewpssdet_id'])) {
                                $modAsesTriaseDet = RDAsesmentriagewpssdetT::model()->findByPk($_POST['RDAsesmentriagewpssdetT']['asesmentriagewpssdet_id']);
                                $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
                                $modAsesTriaseDet->asesmentriagewpss_id = $modAsesTriase->asesmentriagewpss_id;
                                $modAsesTriaseDet->pemeriksaantriage_id = $_POST['RDAsesmentriagewpssdetT']['pemeriksaantriage_id'][$key];
                                $modAsesTriaseDet->skor = $_POST['RDAsesmentriagewpssdetT']['skor'][$key];
                                $modAsesTriaseDet->detailpemeriksaantriage_id = $value;
                                $modAsesTriaseDet->update_time = date("Y-m-d H:i:s");
                                $modAsesTriaseDet->update_loginpemakai_id = Yii::app()->user->id;
                                // echo '<pre>';var_dump('13');die;
                                $ok = $ok && $modAsesTriaseDet->save();
                            } else {
                                $modAsesTriaseDet = new RDAsesmentriagewpssdetT();
                                $modAsesTriaseDet->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $modAsesTriaseDet->pasien_id = $modPendaftaran->pasien_id;
                                $modAsesTriaseDet->asesmentriagewpss_id = $modAsesTriase->asesmentriagewpss_id;
                                $modAsesTriaseDet->pemeriksaantriage_id = $_POST['RDAsesmentriagewpssdetT']['pemeriksaantriage_id'][$key];
                                $modAsesTriaseDet->skor = $_POST['RDAsesmentriagewpssdetT']['skor'][$key];
                                $modAsesTriaseDet->detailpemeriksaantriage_id = $value;
                                $modAsesTriaseDet->create_time = date("Y-m-d H:i:s");
                                $modAsesTriaseDet->create_loginpemakai_id = Yii::app()->user->id;
                                $modAsesTriaseDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                // echo '<pre>';var_dump('12');die;
                                $ok = $ok && $modAsesTriaseDet->save();
                            }
                        }
                    }
                }

                if ($ok) {                    
                    // echo '<pre>';var_dump('oke ', $_POST);die;                    
                    $transaction->commit();                    
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(empty($pendaftaran_id)){               
                        $this->redirect(
                            $this->createUrl('InformasiBedTriage/Index')
                        );
                    } else {                 
                        $this->redirect(array('indexWps', 'pendaftaran_id' => $pendaftaran_id, 'frame' => $frame, 'notriage_pasien_id' => $notriage_pasien_id, 'sukses' => 1));
                    }
                } else {
                    // echo '<pre>';var_dump('gagal ', $_POST);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data asesmen triase gagal disimpan " . CHtml::errorSummary($modAsesTriase));
                }
            } catch (Exception $exc) {
                // echo '<pre>';var_dump($exc);die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        if(isset($_GET['display'])){
            $asesmen = AsesmentriagewpssT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), array('order' => 'asesmentriagewpss_id DESC', 'limit'=>'1'));
            // $asesmenDet = AsesmentriagewpssdetT::model()->findByAttributes(array('asesmentriagewpss_id' => $asesmen->asesmentriagewpss_id));
            $modAsesTriase->waktudatang = $asesmen->waktudatang;
            $modAsesTriase->waktuperiksa = $asesmen->waktuperiksa;

            $modAsesTriase->caramasuk = $asesmen->caramasuk;
            if($asesmen->transportasi != 'Ambulan' && $asesmen->transportasi != 'Mobil'){
                $modAsesTriase->transportasi = 'Lainnya';
                $modAsesTriase->transport_lain = $asesmen->transportasi;
            } else {
                $modAsesTriase->transportasi = $asesmen->transportasi;
            }
            if($asesmen->dikirimoleh != 'Sendiri' && $asesmen->dikirimoleh != 'RS/PKM/BP' && $asesmen->dikirimoleh != 'Dokter/Bidan'){
                $modAsesTriase->dikirimoleh = 'Lainnya';
                $modAsesTriase->dikirim_lain = $asesmen->dikirimoleh;
            } else {
                $modAsesTriase->dikirimoleh = $asesmen->dikirimoleh;
            }
            $modAsesTriase->jeniskasus = $asesmen->jeniskasus;

            $modAsesTriase->appereance = $asesmen->appereance;
            $modAsesTriase->workofbreathing = $asesmen->workofbreathing;
            $modAsesTriase->crculation = $asesmen->crculation;
            
            $modAsesTriase->totalskor = $asesmen->totalskor;
            $modAsesTriase->warnatriage = $asesmen->warnatriage;
            $modAsesTriase->prioritastriage_id = $asesmen->prioritastriage_id;

            $modAsesTriase->ruang = $asesmen->ruang;
            $modAsesTriase->keputusan = $asesmen->keputusan;
        }

        $this->render($this->path_view . 'indexNew2', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAsesTriase' => $modAsesTriase,
            'modAsesTriaseDet' => $modAsesTriaseDet,
        ));
    }


    public function actionIndex($pendaftaran_id) {
        $format = new MyFormatter();
        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);

        $modLookup = LookupM::model()->findAllByAttributes(array('lookup_aktif' => TRUE, 'lookup_type' => 'triase_pemeriksaan'), array('order' => 'lookup_urutan ASC'));
        $modTriase = Triase::model()->findAllByAttributes(array('triase_aktif' => TRUE), array('order' => 'triase_urutan ASC'));
        $dataTriase = array();
        $cekTriase = array();
        $dataFlaCcs = array();
        $cekFlaCcs = array();

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = RDSkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $modFisik = RDPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (empty($modFisik)) {
            $modFisik = new RDPemeriksaanFisikT;
            $modFlaCcs = new RDAsesmennyeriflaccsT;

            if ((int) $umur > Params::SKALA_NYERI_UMUR_LEBIH) {
                $modFisik->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
            } elseif ((int) $umur <= Params::SKALA_NYERI_UMUR_KURANG) {
                $modFisik->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
            }
        } else {
            if ($modFisik->keluhan_nyeri == true || $modFisik->keluhan_nyeri == false) {
                $modFisik->keluhan_nyeri = ($modFisik->keluhan_nyeri == TRUE) ? 1 : 0;
            }
            if ($modFisik->rasanyeri_berpindah == true || $modFisik->rasanyeri_berpindah == false) {
                $modFisik->rasanyeri_berpindah = ($modFisik->rasanyeri_berpindah == TRUE) ? 1 : 0;
            }

            $getFlaCcs = RDAsesmennyeriflaccsT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modFisik->pemeriksaanfisik_id));

            if (count((array) $getFlaCcs) > 0)
                foreach ($getFlaCcs as $det) {
                    $cekFlaCcs["$det->skalanyeriflaccs_id"] = $det->skalanyeriflaccs_id;
                }
            $modFlaCcs = new RDAsesmennyeriflaccsT;
        }
        $getTriase = null;

        $modGcs = new RDGcsM();
        $modAsesTriase = RDAsesmentriaseT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
        if (!empty($modAsesTriase)) {

            $modAsesTriase->gcs_nama = RDGcsM::model()->keterangan($modAsesTriase->gcs_nilai);
            //				echo '<pre>';
            //				print_r($modAsesTriase->gcs_nama);
            //				exit();
            //						if (count((array)$modgc)>0){
            //							foreach($modgc as $det){
            //							if ($modAsesTriase->gcs_nama  $det-> && nilai < val.gcs_nilaimax) {
            //								
            //							}
            //							}
            //						}
            $getTriase = RDAsesmentriasedetT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));

            foreach ($getTriase as $det) {
                $cekTriase["$det->triase_id"] = $det->triase_id;
            }


            $modAsesTriDet = new RDAsesmentriasedetT;

            //                if (count((array)$modAsesTriDet)<=0){
            //                    
            //                    $modAsesTriDet = new RDAsesmentriasedetT;
            //                }

            $modTriPeg = RDAsesmentriasepegT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));
            if (count((array) $modTriPeg) <= 0) {
                $modTriPeg = new RDAsesmentriasepegT;
            }

            if ($modAsesTriase->istrauma) {
                $modAsesTriase->trauma = true;
                $modAsesTriase->nontrauma = false;
            } else {
                $modAsesTriase->trauma = false;
                $modAsesTriase->nontrauma = true;
            }
        } else {
            $modAsesTriase = new RDAsesmentriaseT;
            $modAsesTriase->tglasesmentriase = date('d M Y');
            $modAsesTriase->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modAsesTriase->pasien_id = $modPendaftaran->pasien_id;


            $modAsesTriDet = new RDAsesmentriasedetT;



            $modTriPeg = new RDAsesmentriasepegT;
        }

        foreach ($modTriase as $dt) {
            $dt->warna_triase = strtolower($dt->warna_triase);
            $dataTriase["$dt->triase_pemeriksaan"]["$dt->warna_triase"][] = array(
                'triase_id' => $dt->triase_id,
                'keterangan_triase' => $dt->keterangan_triase,
                'value' => isset($cekTriase["$dt->triase_id"]) ? $cekTriase["$dt->triase_id"] : null,
            );
        }

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => $dtF->skalanyeriflaccs_id,
                'keterangan' => $dtF->skalanyeriflaccs_desc,
                'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $cekFlaCcs["$dtF->skalanyeriflaccs_id"] : null,
            );
        }

        //echo "<pre>";
        //var_dump($dataFlaCcs);
        //echo "</pre>";die;
        if (isset($_POST['RDAsesmentriaseT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modAsesTriase->attributes = $_POST['RDAsesmentriaseT'];
                $modAsesTriase->tglasesmentriase = MyFormatter::formatDateTimeForDb($modAsesTriase->tglasesmentriase);
                if (empty($modAsesTriase->pegawai_id)) {
                    $modAsesTriase->pegawai_id = Yii::app()->user->getState('pegawai_id');
                }
                $modAsesTriase->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modAsesTriase->instalasi_id = Yii::app()->user->getState('instalasi_id');
                $modAsesTriase->create_time = date("Y-m-d H:i:s");
                $modAsesTriase->create_loginpemakai_id = Yii::app()->user->id;
                $modAsesTriase->create_ruangan = Yii::app()->user->getState('ruangan_id');
                if ($_POST['RDAsesmentriaseT']['trauma']) {
                    $modAsesTriase->istrauma = true;
                } else {
                    if ($_POST['RDAsesmentriaseT']['nontrauma']) {
                        $modAsesTriase->istrauma = false;
                    } else {
                        $modAsesTriase->istrauma = null;
                    }
                }


                $ok = $ok && $modAsesTriase->save();


                $del = array();

                if (isset($_POST['RDAsesmentriasedetT']['triase'])) {
                    foreach ($_POST['RDAsesmentriasedetT']['triase'] as $ii => $val) {
                        $modAsesTriDet->attributes = $_POST['RDAsesmentriasedetT']['triase'][$ii];


                        $cek = RDAsesmentriasedetT::model()->findByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id, 'triase_id' => $modAsesTriDet->triase_id));

                        if (!$cek) {
                            $modAsesTriDet = new RDAsesmentriasedetT;
                            $modAsesTriDet->attributes = $_POST['RDAsesmentriasedetT']['triase'][$ii];
                            $modAsesTriDet->asesmentriase_id = $modAsesTriase->asesmentriase_id;
                            $ok = $ok && $modAsesTriDet->save();
                        } else {
                            if (!empty($cekTriase)) {
                                unset($cekTriase[$modAsesTriDet->triase_id]);
                            }
                        }
                    }

                    $del = $cekTriase;

                    if (!empty($del)) {
                        $delete = array();
                        foreach ($del as $d) {
                            $delete[] = $d;
                        }

                        $cri = new CDbCriteria();
                        $cri->addCondition("asesmentriase_id = '" . $modAsesTriase->asesmentriase_id . "' ");
                        $cri->addInCondition('triase_id', $delete);
                        $up = RDAsesmentriasedetT::model()->deleteAll($cri);
                    }
                } else {
                    $del = $cekTriase;

                    if (!empty($del)) {
                        $delete = array();
                        foreach ($del as $d) {
                            $delete[] = $d;
                        }

                        $cri = new CDbCriteria();
                        $cri->addCondition("asesmentriase_id = '" . $modAsesTriase->asesmentriase_id . "' ");
                        $cri->addInCondition('triase_id', $delete);
                        $up = RDAsesmentriasedetT::model()->deleteAll($cri);
                    }
                }


                if (isset($_POST['RDPemeriksaanFisikT'])) {
                    $modFisik->attributes = $_POST['RDPemeriksaanFisikT'];
                    $modFisik->pegawai_id = $modPendaftaran->pegawai_id;
                    $modFisik->tglperiksafisik = $modAsesTriase->tglasesmentriase;
                    $modFisik->pasien_id = $modPendaftaran->pasien_id;
                    $modFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modFisik->resikojatuh_keterangan = $_POST['RDPemeriksaanFisikT'][0]['resikojatuh_keterangan'] . '{{pisah}}' . $_POST['RDPemeriksaanFisikT'][1]['resikojatuh_keterangan'];
                    if ($modFisik->keluhan_nyeri == 1 || $modFisik->keluhan_nyeri == 0) {
                        $modFisik->keluhan_nyeri = ($modFisik->keluhan_nyeri == 1) ? TRUE : FALSE;
                    }

                    if ($modFisik->rasanyeri_berpindah == 1 || $modFisik->rasanyeri_berpindah == 0) {
                        $modFisik->rasanyeri_berpindah = ($modFisik->rasanyeri_berpindah == 1) ? TRUE : FALSE;
                    }



                    $modFisik->create_time = date("Y-m-d H:i:s");
                    $modFisik->create_loginpemakai_id = Yii::app()->user->id;
                    $modFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $ok = $ok && $modFisik->save();
                }

                //var_dump($_POST['RDAsesmennyeriflaccsT']['flaccs']);die;

                if (isset($_POST['RDAsesmennyeriflaccsT']['flaccs'])) {
                    foreach ($_POST['RDAsesmennyeriflaccsT']['flaccs'] as $ii => $val) {
                        $modFlaCcs->attributes = $_POST['RDAsesmennyeriflaccsT']['flaccs'][$ii];


                        $cek = RDAsesmennyeriflaccsT::model()->findByAttributes(array('pemeriksaanfisik_id' => $modFisik->pemeriksaanfisik_id, 'skalanyeriflaccs_id' => $modFlaCcs->skalanyeriflaccs_id));

                        if (!$cek) {
                            $modFlaCcs = new RDAsesmennyeriflaccsT;
                            $modFlaCcs->attributes = $_POST['RDAsesmennyeriflaccsT']['flaccs'][$ii];
                            $modFlaCcs->pemeriksaanfisik_id = $modFisik->pemeriksaanfisik_id;

                            $ok = $ok && $modFlaCcs->save();

                            //var_dump($modFlaCcs->getErrors());
                        } else {
                            if (!empty($cekFlaCcs)) {
                                unset($cekFlaCcs[$modFlaCcs->skalanyeriflaccs_id]);
                            }
                        }
                    }
                    //die;

                    $delFlaCcs = $cekFlaCcs;

                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }


                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = RDAsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                } else {
                    $delFlaCcs = $cekFlaCcs;

                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }

                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = RDAsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                }



                //var_dump($_POST['RDAsesmentriasepegT']);die;
                //var_dump($_POST['RDAsesmentriasepegT']);die;

                $cekPegTri = array();
                $pegTri = RDAsesmentriasepegT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));

                if (count((array) $pegTri) > 0) {
                    foreach ($pegTri as $det) {
                        $cekPegTri["$det->pegawai_id"] = $det->pegawai_id;
                    }
                }
                if (isset($_POST['RDAsesmentriasepegT'])) {
                    foreach ($_POST['RDAsesmentriasepegT'] as $key => $val) {
                        if (!empty($val['pegawai_id'])) {
                            $cek = AsesmentriasepegT::model()->findByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id, 'pegawai_id' => $val['pegawai_id']));

                            if (empty($cek)) {
                                $modTriPeg = new RDAsesmentriasepegT;
                                $modTriPeg->attributes = $_POST['RDAsesmentriasepegT'][$key];
                                $modTriPeg->asesmentriase_id = $modAsesTriase->asesmentriase_id;

                                $ok = $ok && $modTriPeg->save();
                            } else {
                                if (!empty($cekPegTri)) {

                                    unset($cekPegTri[$cek->pegawai_id]);
                                }
                            }
                        } else {
                            
                        }
                        $delPegTri = $cekPegTri;

                        if (!empty($delPegTri)) {
                            $delete = array();
                            foreach ($delPegTri as $d) {
                                $delete[] = $d;
                            }


                            $cri = new CDbCriteria();
                            $cri->addCondition("asesmentriase_id = '" . $modAsesTriase->asesmentriase_id . "' ");
                            $cri->addInCondition('pegawai_id', $delete);
                            $up = RDAsesmentriasepegT::model()->deleteAll($cri);
                        }
                    }
                } else {
                    $delPegTri = $cekPegTri;

                    if (!empty($delPegTri)) {
                        $delete = array();
                        foreach ($delPegTri as $d) {
                            $delete[] = $d;
                        }


                        $cri = new CDbCriteria();
                        $cri->addCondition("asesmentriase_id = '" . $modAsesTriase->asesmentriase_id . "' ");
                        $cri->addInCondition('pegawai_id', $delete);
                        $up = RDAsesmentriasepegT::model()->deleteAll($cri);
                    }
                }

                if ($ok) {

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    //var_dump($modFisik->getErrors());die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data asesmen triase gagal disimpan " . CHtml::errorSummary($modAsesTriase));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }



        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
            'modLookup' => $modLookup,
            'dataTriase' => $dataTriase,
            'dataFlaCcs' => $dataFlaCcs,
            'modFisik' => $modFisik,
            'modAsesTriase' => $modAsesTriase,
            'modAsesTriDet' => $modAsesTriDet,
            'modFlaCcs' => $modFlaCcs,
            'getFlaCcs' => $getFlaCcs,
            'getTriase' => $getTriase,
            'modTriPeg' => $modTriPeg,
            'modGcs' => $modGcs,
        ));
    }

    /**
     * - digunakan untuk mencetak data
     * @param type $pendaftaran_id
     */
    public function actionPrintAsesmen($pendaftaran_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modTriase = Triase::model()->findAllByAttributes(array('triase_aktif' => TRUE), array('order' => 'triase_urutan ASC'));
        $modLookup = LookupM::model()->findAllByAttributes(array('lookup_aktif' => TRUE, 'lookup_type' => 'triase_pemeriksaan'), array('order' => 'lookup_urutan ASC'));
        $dataTriase = array();
        $cekTriase = array();

        $dataFlaCcs = array();
        $cekFlaCcs = array();

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = RDSkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modFisik = RDPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (empty($modFisik)) {
            $modFisik = new RDPemeriksaanFisikT;
            $modFlaCcs = new RDAsesmennyeriflaccsT;
        } else {

            if ($modFisik->keluhan_nyeri == true || $modFisik->keluhan_nyeri == false) {
                $modFisik->keluhan_nyeri = ($modFisik->keluhan_nyeri == TRUE) ? 1 : 0;
            }
            if ($modFisik->rasanyeri_berpindah == true || $modFisik->rasanyeri_berpindah == false) {
                $modFisik->rasanyeri_berpindah = ($modFisik->rasanyeri_berpindah == TRUE) ? 1 : 0;
            }
            $modFlaCcs = new RDAsesmennyeriflaccsT;
            $getFlaCcs = RDAsesmennyeriflaccsT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modFisik->pemeriksaanfisik_id));

            if (count((array) $getFlaCcs) > 0) {
                foreach ($getFlaCcs as $det) {
                    $cekFlaCcs["$det->skalanyeriflaccs_id"] = $det->skalanyeriflaccs_id;
                }
            }
        }

        $getTriase = null;

        $modAsesTriase = RDAsesmentriaseT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
        if (!empty($modAsesTriase)) {

            $getTriase = RDAsesmentriasedetT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));

            foreach ($getTriase as $det) {
                $cekTriase["$det->triase_id"] = $det->triase_id;
            }

            $modAsesTriDet = new RDAsesmentriasedetT;

            //            if (count((array)$modAsesTriDet)<=0){
            //
      //                $modAsesTriDet = new RDAsesmentriasedetT;
            //            }

            $modTriPeg = RDAsesmentriasepegT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));
            if (count((array) $modTriPeg) <= 0) {
                $modTriPeg = new RDAsesmentriasepegT;
            }

            if ($modAsesTriase->istrauma) {
                $modAsesTriase->trauma = true;
                $modAsesTriase->nontrauma = false;
            } else {
                $modAsesTriase->trauma = false;
                $modAsesTriase->nontrauma = true;
            }
        } else {
            $modAsesTriase = new RDAsesmentriaseT;
            $modAsesTriase->tglasesmentriase = date('d M Y');
            $modAsesTriase->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modAsesTriase->pasien_id = $modPendaftaran->pasien_id;


            $modAsesTriDet = new RDAsesmentriasedetT;

            $modTriPeg = new RDAsesmentriasepegT;
        }

        foreach ($modTriase as $dt) {
            $dt->warna_triase = strtolower($dt->warna_triase);
            $dataTriase["$dt->triase_pemeriksaan"]["$dt->warna_triase"][] = array(
                'triase_id' => $dt->triase_id,
                'keterangan_triase' => $dt->keterangan_triase,
                'value' => isset($cekTriase["$dt->triase_id"]) ? $cekTriase["$dt->triase_id"] : null,
            );
        }

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => $dtF->skalanyeriflaccs_id,
                'keterangan' => $dtF->skalanyeriflaccs_desc,
                'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $cekFlaCcs["$dtF->skalanyeriflaccs_id"] : null,
            );
        }

        $judul_print = 'ASESMEN PASIEN IGD';
        $this->render($this->path_view . 'printAsesmenTriaseV2', array(
            'format' => $format,
            'dataTriase' => $dataTriase,
            'modFisik' => $modFisik,
            'modAsesTriase' => $modAsesTriase,
            'modAsesTriDet' => $modAsesTriDet,
            'getTriase' => $getTriase,
            'modTriPeg' => $modTriPeg,
            'judulLaporan' => $judul_print,
            'modLookup' => $modLookup,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'getFlaCcs' => $getFlaCcs,
            'dataFlaCcs' => $dataFlaCcs,
            'modFlaCcs' => $modFlaCcs,
            'modPendaftaran' => $modPendaftaran
        ));
    }

    protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '') {
        $modelPulangNew = new RDPasienPulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date('Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;
        $modelPulangNew->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
        // var_dump($modelPulangNew->attributes); die;

        if (!$modelPulangNew->cekSisaPembayaranUntukPulang()) {
            throw new CException("Sisa tagihan pasien yang akan dipulangkan belum dibayarkan.");
        }

        // var_dump($modelPulangNew->attributes); die;

        if ($modelPulangNew->save()) {
            $this->validPulang = true;
        }

        return $modelPulangNew;
    }

    public function cekSisaPembayaranUntukPulang() {
		if ($this->carakeluar_id != Params::CARAKELUAR_ID_DIPULANGKAN) return true;
		
		$tindakan = TindakanpelayananT::model()->findByAttributes(array(
			'pendaftaran_id'=>$this->pendaftaran_id
		), array(
			'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0 and tarif_satuan > 0'
		));
		
		$oa = ObatalkespasienT::model()->findByAttributes(array(
			'pendaftaran_id'=>$this->pendaftaran_id,
		), array(
			'condition'=>'oasudahbayar_id is null and qty_oa <> 0 and hargasatuan_oa > 0'
		));
		
		return (empty($tindakan) && empty($oa));

		
		
		// var_dump($this->attributes); die;
		
	}
}