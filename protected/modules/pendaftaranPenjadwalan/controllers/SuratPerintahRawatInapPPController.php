<?php

Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.SuratPerintahRawatInapController');

class SuratPerintahRawatInapPPController extends SuratPerintahRawatInapController {

    public function actionIndex($pendaftaran_id = null, $suratperintahranap_id = null) { 
               
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                                
                if ($ajax == 'datakunjungan-grid')
                    $path = 'grid/_daftar_pasien_rdri';                                
                
                $this->renderPartial($path);
            }else{
                if (isset($_GET['jenis'])){
                    $this->getDataInfoPasien();
                }else{
                    $format = new MyFormatter();
                    $returnVal = array();
                    $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
                    $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
                    $insId = $_GET['instalasi_id'];

                    $load = new InfokunjunganrdV('searchDialogKunjungan');
                    $load->unsetAttributes();
                    $load->instalasi_id = $insId;
                    $load->no_rekam_medik = $no_rekam_medik;
                    $load->nama_pasien = $nama_pasien;            

                    $models = $load->searchDialogKunjunganForSPRI();            

                    foreach ($models->getData() as $i => $model) {
                        $attributes = $model->attributeNames();
                        foreach ($attributes as $j => $attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->no_pendaftaran.' '.$model->nama_pasien;
                        $returnVal[$i]['value'] = $model->pendaftaran_id;
                    }
                    echo CJSON::encode($returnVal);
                }
            }
            exit;
        }
        
        $modPendaftaran = new PendaftaranT;
        $modInfoKunjungan = new InfokunjunganrdV;
        $modPasien = new PasienM;
          
        if ((empty($suratperintahranap_id))) {
            $model = new SuratperintahranapT();            
            $model->tgl_suratperintahranap = date('d M Y H:i:s');
            $modInfoKunjungan = InfokunjunganrdV::model()->findByAttributes([
                'pendaftaran_id'=>$model->pendaftaran_id 
            ]);

            if (empty($modInfoKunjungan)) {
                $modInfoKunjungan = new InfokunjunganrdV;
            }
        } else {
            $model = SuratperintahranapT::model()->findByPk($suratperintahranap_id);
            $model->tgl_suratperintahranap = MyFormatter::formatDateTimeForUser($model->tgl_suratperintahranap);
            
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);            
            $modInfoKunjungan = InfokunjunganrdV::model()->findByAttributes([
               'pendaftaran_id'=>$model->pendaftaran_id 
            ]);
        }

        if (empty($modInfoKunjungan) && !empty($model->pendaftaran_id)) {
            $modInfoKunjungan = InfopasienpengunjungV::model()->findByAttributes(array(
                'pendaftaran_id'=>$model->pendaftaran_id,
            ));
        }

        $vclaim_msg = "";

        if (isset($_POST['SuratperintahranapT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {                
                if (!empty($_POST['SuratperintahranapT']['suratperintahranap_id'])){
                    $model = SuratperintahranapT::model()->findByPk($_POST['SuratperintahranapT']['suratperintahranap_id']);
                }
                $model->attributes = $_POST['SuratperintahranapT'];
                if (!isset($model->suratperintahranap_id) || empty($model->suratperintahranap_id)) {
                    $model->nomorsurat = MyGenerator::noSuratPerintahRI($model->instalasi_id, $model->isranap_perinatologi);
                    $model->nourutsurat = MyGenerator::noSuratPerintahRIUrut($model->instalasi_id, $model->isranap_perinatologi);
                }                
                $model->tgl_suratperintahranap = MyFormatter::formatDateTimeForDB($model->tgl_suratperintahranap);
                $model->tgl_rencanaranap = MyFormatter::formatDateTimeForDB($model->tgl_rencanaranap);
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->ruangansurat_id = Yii::app()->user->getState("ruangan_id");

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");

                // var_dump($_POST);

                $modPendaftaran->carabayar_id = isset($_POST['PendaftaranT']['carabayar_id']) ? $_POST['PendaftaranT']['carabayar_id'] : $modPendaftaran->carabayar_id;

                if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == true) {

                    $kode_dokter = "";
                    if (!empty($model->dpjp_id)) {
                        $dok = PegawaiM::model()->findByPk((int)$model->dpjp_id);
                        if (!empty($dok)) {
                            // var_dump($dok->attributes);
                            $kode_dokter = $dok->kodedokter_bpjs;
                        }
                    }
                    $no_kartu = "";
                    if (isset($_POST['SepT']['nokartuasuransi'])) {
                        $no_kartu = $_POST['SepT']['nokartuasuransi'];
                    } else if (isset($_POST['SuratperintahranapT']['nokartubpjs'])) {
                        $no_kartu = $_POST['SuratperintahranapT']['nokartubpjs'];
                    }
                    $poli = SpesialissubspesialisM::model()->findByPk($model->spesialissubspesialis_id);
                    $kontrol_poli = $poli->spesialissubspesialis_kode;
                    $kontrol_tgl_rencana = date('Y-m-d', strtotime($model->tgl_rencanaranap));
                    $user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $kontrol_user_res = empty($user) ? "" : trim($user->nama_pegawai);

                    $bpjs = new Bpjs_Vklaim;

                    $model->nokartubpjs = $no_kartu;

                    // var_dump($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res); die;

                    if (!empty($model->nomorspri_bpjs)) {
                        $res_kontrol = $bpjs->update_spri($model->nomorspri_bpjs, $no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    } else {
                        $res_kontrol = $bpjs->create_spri($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    }

                    $vclaim_msg = "";

                    if (!$res_kontrol) {
                        $vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
                    }
                    $res_json = CJSON::decode($res_kontrol);

                    if ($res_json['metaData']['code'] != 200) {
                        $vclaim_msg = "Note : " . $res_json['metaData']['message'];
                        $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                        if(!empty($modDaftar)){
                            $modDaftar = $modPendaftaran;
                        }
                        if (!empty($model->nomorspri_bpjs)) {
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['update_spri']);
                        }else{
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['create_spri']);
                        }
                    } else {
                        $model->nomorspri_bpjs = $res_json['response']['noSPRI'];
                        $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                        if (!empty($modDaftar)) {
                            $modDaftar = $modPendaftaran;
                        }
                        if (!empty($model->nomorspri_bpjs)) {
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['update_spri']);
                        } else {
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['create_spri']);
                        }
                    }
                    $model->responspri_bpjs = CJSON::encode($res_json['response']);
                    if ($model->save() && $res_json['metaData']['code'] == 200) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan ! " . $vclaim_msg);
                        $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $vclaim_msg);
                        $modDaftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                        if (!empty($modDaftar)) {
                            $modDaftar = $modPendaftaran;
                        }
                        if (!empty($model->nomorspri_bpjs)) {
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['update_spri']);
                        } else {
                            $this->logBpjs($modDaftar, $res_json, $bpjs->server_new['create_spri']);
                        }
                    }
                }else{
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan ! " . $vclaim_msg);
                        $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $vclaim_msg);
                    }
                }

                // echo "OK"; die;

                
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render('buat', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }

    //save log bpjs
    function logBpjs($model, $reqSep, $api = null)
    {
        $log = new BpjslogR;
        $log->tgl_log = date('Y-m-d H:i:s');
        $log->code = $reqSep['metaData']['code'];
        $log->loginpemakai_id = Yii::app()->user->id;
        if (isset($reqSep['metaData']['message'])) {
            $log->pesan = $reqSep['metaData']['message'];
        }
        if (!empty($reqSep['request_vars'])) {
            $log->json_request_respose = $reqSep['request_vars'];
        }
        $log->pendaftaran_id = $model->pendaftaran_id;
        $request = Yii::app()->request;
        $ipAddress = $request->getUserHostAddress();
        $log->ip_address = $ipAddress;
        $log->api = $api;
        $log->save();
    }
    
    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function getDataInfoPasien() {
        $format = new MyFormatter();
        $modelSep = new ARSepT;
        $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
        $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
        $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
        $returnVal = array();
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }
        if (!empty($pasienadmisi_id) && $pasienadmisi_id !== 'null') {
            $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
        $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
        if ($instalasi_id == Params::INSTALASI_ID_RD) {
            $model = InfokunjunganrdV::model()->find($criteria);
        }else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
            $model = InfokunjunganrjV::model()->find($criteria);
        }else{
            $model = InfokunjunganriV::model()->find($criteria);
        }
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }
        $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
        $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
        $modpend = PendaftaranT::model()->findByPk($pendaftaran_id);
        $returnVal["instalasiasal_id"] = $modpend->instalasi_id;                        

        $modpasien = PasienM::model()->findByPk($modpend->pasien_id);
        $returnVal["no_mobile_pasien"] = $modpasien->no_mobile_pasien;

        $ceksurat = SuratperintahranapT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));
        
        $surat = new SuratperintahranapT;                        
        if (!empty($ceksurat)){
            // var_dump("1");
            $surat = $ceksurat;
            $surat->tgl_suratperintahranap = MyFormatter::formatDateTimeForUser($surat->tgl_suratperintahranap);
        }else{
            // var_dump("2");
            $surat->nomorsurat = MyGenerator::noSuratPerintahRI($model->instalasi_id, $surat->isranap_perinatologi);
            $surat->nourutsurat = MyGenerator::noSuratPerintahRIUrut($model->instalasi_id, $surat->isranap_perinatologi);                        
            $surat->pendaftaran_id = $modpend->pendaftaran_id;
            $surat->pasien_id = $modpend->pasien_id;
            $surat->pasienpulang_id = $modpend->pasienpulang_id;
            $surat->instalasi_id = $modpend->instalasi_id;            
            $surat->tgl_suratperintahranap = date('d M Y H:i:s');           
        }

        // var_dump($modpend->attributes, $modpasien->attributes); die;

        $returnVal["isisurat"] = array("html" => $this->renderPartial($this->path_view.'_isiSurat',[
            'model'=>$surat,
            'modPendaftaran'=>$modpend,
            'modPasien'=>$modpasien,                
        ], true));



        echo CJSON::encode($returnVal);
    }

}
