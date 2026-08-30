<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LaporanOperasiController extends MyAuthController
{

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    protected $path_view = 'bedahSentral.views.laporanOperasi.';
    public $path_view_rawat_jalan = 'rawatJalan.views.diagnosaTRJNew.';

    public function actionIndex($pendaftaran_id)
    {

        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }

        $modMorbiditas = new PasienmorbiditasT();
        $modPasienIcd9 = new Pasienicd9cmT();
        
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-diagnosa-x-grid') {
                    $this->renderPartial($this->path_view . 'grid/_daftar_diagnosa_x', ['model' => $modMorbiditas]);
                    echo "kesitu";
                    exit;
                }
            }           
        }

        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $laporanoperasi_id = isset($_GET['laporanoperasi_id']) ? $_GET['laporanoperasi_id'] : null;
        $modInstalasiPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        // $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if(!empty($modPendaftaran->pasien_id)){
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        } else {
            echo 'Id Pasien Kosong';
            die;
        }
        $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), array('order' => 'create_time DESC'));
        $pasienmasukpenunjang_id = isset($modPenunjang) ? $modPenunjang->pasienmasukpenunjang_id : null;

        
        
        
        $rencana = RencanaoperasiT::model()->findByAttributes(array(
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
        ), array(
            'order' => 'rencanaoperasi_id asc',
        ));

        $rencanaoperasiList = RencanaoperasiT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
        ), array(
            'order' => 'rencanaoperasi_id asc',
        ));

        if (!empty($rencana)) {
            $listDataOperasi = CHtml::listData(RencanaoperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)), 'operasi_id', 'operasi.operasi_nama');
        } else {
            $listDataOperasi = CHtml::listData(OperasiM::model()->findAll('operasi_aktif = true order by operasi_nama ASC'), 'operasi_id', 'operasi_nama');
        }


        if (empty($rencana)) {
            $rencana = new RencanaoperasiT();
        }

        if (!empty($laporanoperasi_id)) {
            $model = LaporanoperasiT::model()->findByPk($laporanoperasi_id);

            if ($model->is_cyto == true) {
                if ($model->is_pa == true) {
                    $model->kirimpemeriksaanket = 'PA';
                } else if ($model->is_vc == true) {
                    $model->kirimpemeriksaanket = 'VC';
                } else if ($model->is_kultur == true) {
                    $model->kirimpemeriksaanket = 'Kultur';
                } else if ($model->is_analisa == true) {
                    $model->kirimpemeriksaanket = 'Analisa';
                }
            }
        } else {
            $model = new LaporanoperasiT();
            $model->operasi_id = $rencana->operasi_id;
            $model->golonganoperasi_keterangan = (!empty($rencana->golonganoperasi) ? $rencana->golonganoperasi->golonganoperasi_nama : null);
            $model->rencanaoperasi_id = $rencana->rencanaoperasi_id;
            $model->dokterpelaksana1_id = $rencana->dokterpelaksana1_id;
            $model->dokterpelaksana2_id = $rencana->dokterpelaksana2_id;
        }
        $model->tglrencanoeprasi = (!empty($rencana->tglrencanaoperasi) ? MyFormatter::formatDateTimeForUser($rencana->tglrencanaoperasi) : MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')));
        $pasienmobiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = !empty($modPasien) ? $modPasien->pasien_id : '';
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        //=====================================
        $modAdmisi = null;
        if (!empty($pasienadmisi_id)) {
            $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
        }
        $modUraianIx = new PasienmorbiditasT();
        $modDiagnosaix = new DiagnosaicdixM();
               
        $modMorbiditas->pendaftaran_id = $model->pendaftaran_id;
        $modPasienIcd9->pendaftaran_id = $model->pendaftaran_id;
        
        $model->setLoadDiagnosaX = $modMorbiditas->loadPasienMorbiditas();
        $model->setLoadDiagnosaIX = $modPasienIcd9->loadPasienIcd9();
                
        
        //=====================================
        if (isset($_POST['LaporanoperasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $is_create = false;
                $is_insert = false;
                $is_simpan = false;
                if ((!empty($_GET['jenis']) && $_GET['jenis'] == 'ubah')) {
                    $model = LaporanoperasiT::model()->findByPk($laporanoperasi_id);
                } else {
                    $model = new LaporanoperasiT();
                }
                $model->attributes = $_POST['LaporanoperasiT'];
                if (!empty($_POST['LaporanoperasiT']['kirimpemeriksaanket'])) {
                    if ($_POST['LaporanoperasiT']['kirimpemeriksaanket'] == 'PA') {
                        $model->is_pa = true;
                        $model->is_vc = false;
                        $model->is_kultur = false;
                        $model->is_analisa = false;
                    } else if ($_POST['LaporanoperasiT']['kirimpemeriksaanket'] == 'VC') {
                        $model->is_pa = false;
                        $model->is_vc = true;
                        $model->is_kultur = false;
                        $model->is_analisa = false;
                    } else if ($_POST['LaporanoperasiT']['kirimpemeriksaanket'] == 'Kultur') {
                        $model->is_pa = false;
                        $model->is_vc = false;
                        $model->is_kultur = true;
                        $model->is_analisa = false;
                    } else if ($_POST['LaporanoperasiT']['kirimpemeriksaanket'] == 'Analisa') {
                        $model->is_pa = false;
                        $model->is_vc = false;
                        $model->is_kultur = false;
                        $model->is_analisa = true;
                    }
                }

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $ok = true;
                    
                    $morbiditas_id = null;
                    if (isset($_POST['PasienmorbiditasT'])){
                        foreach($_POST['PasienmorbiditasT'] as $key => $det){
                            $modDetMorbi = new PasienmorbiditasT;
                            $cek = PasienmorbiditasT::model()->findByPk($det['pasienmorbiditas_id']);
                            if (!empty($cek)){
                                $modDetMorbi = $cek;
                            }
                            $modDetMorbi->attributes = $det;
                            $modDetMorbi->pasien_id = $model->pasien_id;
                            $modDetMorbi->pendaftaran_id = $model->pendaftaran_id;                            
                            
                            $daftar = $model->pendaftaran;
                            $modDetMorbi->kelompokumur_id = $daftar->kelompokumur_id;
                            $modDetMorbi->jeniskasuspenyakit_id = $daftar->jeniskasuspenyakit_id;
                            $modDetMorbi->golonganumur_id = $daftar->golonganumur_id;
                            
                            $modDetMorbi->tglmorbiditas = MyFormatter::formatDateTimeForDb($modDetMorbi->tglmorbiditas);
                            if (empty($modDetMorbi->pasienmorbiditas_id)){
                                $modDetMorbi->create_time = date('Y-m-d H:i:s');
                                $modDetMorbi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDetMorbi->ruangan_id = $modDetMorbi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }else{
                                $modDetMorbi->update_time = date('Y-m-d H:i:s');
                                $modDetMorbi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            }
                            
                            $ok &= $modDetMorbi->save();    
                            
                            if ($modDetMorbi->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA){
                                $morbiditas_id = $modDetMorbi->pasienmorbiditas_id;
                            }
                        }
                    }
                                        
                    
                    if (isset($_POST['Pasienicd9cmT'])){
                        foreach($_POST['Pasienicd9cmT'] as $key => $det){
                            $modDet9 = new Pasienicd9cmT;
                            $cek = Pasienicd9cmT::model()->findByPk($det['pasienicd9cm_id']);
                            if (!empty($cek)){
                                $modDet9 = $cek;
                            }
                            
                            $daftar = $model->pendaftaran;
                            
                            $modDet9->attributes = $det;                            
                            $modDet9->pendaftaran_id = $model->pendaftaran_id;                            
                            $modDet9->pasienmorbiditas_id = $morbiditas_id;
                            $modDet9->pasienadmisi_id = $daftar->pasienadmisi_id;                                                                                    
                            if (empty($modDet9->pasienicd9cm_id)){
                                $modDet9->create_time = date('Y-m-d H:i:s');
                                $modDet9->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDet9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                            }else{
                                $modDet9->update_time = date('Y-m-d H:i:s');
                                $modDet9->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            }
                            
                            $ok &= $modDet9->save();                            
                        }
                    }
                    
                    if (isset($_POST['morbi_hapus'])){
                        $criDel = new CDbCriteria;
                        $criDel->addInCondition("pasienmorbiditas_id",$_POST['morbi_hapus']);
                        $del = PasienmorbiditasT::model()->deleteAll($criDel);
                    }
                    
                    if (isset($_POST['pasien9_hapus'])){
                        $criDel = new CDbCriteria;
                        $criDel->addInCondition("pasienicd9cm_id",$_POST['pasien9_hapus']);
                        $del = Pasienicd9cmT::model()->deleteAll($criDel);
                    }
                    
                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1, 'type' => $_GET['type'], 'frame' => $_GET['frame']));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal disimpan. ");
                }
            } catch (Exception $exc) {
                echo $exc;
                exit;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render(
            $this->path_view . 'index',
            array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                // 'modPasien' => $modPasien,
                'rencana' => $rencana,
                'pasienmobiditas' => $pasienmobiditas,
                'rencanaoperasiList' => $rencanaoperasiList,
                'listDataOperasi' => $listDataOperasi,
                'modDiagnosaix' => $modDiagnosaix,
                'modPendaftaran' => $modPendaftaran,
                'modUraianIx' => $modUraianIx,
                'modAdmisi' => $modAdmisi,
                'modMorbiditas' => $modMorbiditas,
                'modPasienIcd9' => $modPasienIcd9
            )
        );
    }


    public function actionPrint()
    {
        $this->layout = '//layouts/printWindows_baru';
        $laporanoperasi_id = $_GET['id'];

        $model = LaporanoperasiT::model()->findByPk($laporanoperasi_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $rencana = RencanaoperasiT::model()->findByPk($model->rencanaoperasi_id);
        if (empty($rencana)) {
            $rencana = new RencanaoperasiT();
        }

        $this->render(
            $this->path_view . 'print',
            array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'rencana' => $rencana
            )
        );
    }

    public function actionDetail($laporanoperasi_id)
    {
        $this->layout = '//layouts/iframe';
        $model = LaporanoperasiT::model()->findByPk($laporanoperasi_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $rencana = RencanaoperasiT::model()->findByPk($model->rencanaoperasi_id);
        if (empty($rencana)) {
            $rencana = new RencanaoperasiT();
        }

        $pasienmobiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

        $rencanaoperasiList = RencanaoperasiT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
        ), array(
            'order' => 'rencanaoperasi_id asc',
        ));


        $this->render($this->path_view . 'detail', array(
            'model' => $model,
            'rencana' => $rencana,
            'pasienmobiditas' => $pasienmobiditas,
            'rencanaoperasiList' => $rencanaoperasiList
        ));
    }

    public function actionHapusRiwayat()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";

        try {
            $id = $_POST['id'];
            $hapus = LaporanoperasiT::model()->deleteByPk($id);

            if ($hapus) {
                $trans->commit();
            } else {
                $ok = 0;
                $msg = "Data gagal dihapus";
            }
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. " . $ex->getMessage();
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'msg' => $msg,
        ));
    }

    public function actionGetDiagnosaixM()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $criteria = new CDbCriteria;
            $returnVal = array();

            if ($_GET['param'] == "kode") {
                $criteria->compare('LOWER(diagnosaicdix_kode)', strtolower($_GET['term']), true);
            }

            if ($_GET['param'] == "nama") {
                $criteria->compare('LOWER(diagnosaicdix_nama)', strtolower($_GET['term']), true);
            }

            if ($_GET['param'] == "lainnya") {
                $criteria->compare('LOWER(diagnosaicdix_namalainnya)', strtolower($_GET['term']), true);
            }
            $criteria->order = 'diagnosaicdix_nama';
            $criteria->addCondition("diagnosaicdix_aktif = true");
            $models = DiagnosaicdixM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = ($_GET['param'] == "lainnya" ? $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_namalainnya : $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_nama);
                $returnVal[$i]['value'] = $model->diagnosaicdix_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true, $ruangan_id = null)
    {
        $result = array();
        $klasifikasi = Params::klasifikasiHiv();
        $isHiv = false;
        foreach ($params as $i => $val) {
            if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "" || (strlen($val['pasienmorbiditas_id']) == 0)) {
                if ($is_diagnosa) {
                    $attributes = array(
                        'pendaftaran_id' => $pendaftaran_id,
                        'diagnosa_id' => $val['diagnosa_id'],
                        'diagnosaicdix_id' => null,
                        'ruangan_id' => $ruangan_id,
                        'statusdiagnosapasien' => $val['statusdiagnosapasien']
                    );

                    $diag = DiagnosaM::model()->findByPk($val['diagnosa_id']);
                    if (in_array($diag->klasifikasidiagnosa->klasifikasidiagnosa_kode, $klasifikasi)) {
                        $isHiv = true;
                    }
                } else {
                    $attributes = array(
                        'pendaftaran_id' => $pendaftaran_id,
                        'diagnosaicdix_id' => $val['diagnosaicdix_id'],
                        'ruangan_id' => $ruangan_id,
                        'statusdiagnosapasien' => isset($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : ""
                    );
                }
                $model = PasienmorbiditasT::model()->findByAttributes($attributes);

                if ($isHiv) {
                    $daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
                    $pasien = $daftar->pasien;
                    if (empty($pasien->no_reg_hiv)) {
                        $pasien->no_reg_hiv = $pasien->setRegNomorHiv();
                        $pasien->update();
                    }
                }

                if (!$model) {
                    $result[] = $val;
                }
            } else {
                $result[] = $val;
            }
        }
        return $result;
    }

    public function loadModel($pendaftaran_id)
    {
        $criteria = new CDbCriteria;
        if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }
        $criteria->addCondition('diagnosaicdix_id IS NULL');
        $model = PasienmorbiditasT::model()->findAll($criteria);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
    
    public function actionLoadDataPenunjang(){
        if (Yii::app()->request->isAjaxRequest){
            
            $id = isset($_GET['id'])?$_GET['id']:null;
            
            $data = [];
            if ($id){
                $load = RencanaoperasiT::model()->findByAttributes([
                    'pasienmasukpenunjang_id' => $id
                ]);

                $data['asistenbedah'] = !empty($load->dokter2)?$load->dokter2->namaLengkap:'';
                $data['asistenbedah2'] = !empty($load->suster)?$load->suster->namaLengkap:'';
                $data['dokteranestesi'] = !empty($load->dokteranastesi)?$load->dokteranastesi->namaLengkap:'';
                $data['perawatinstrumen'] = !empty($load->bidan)?$load->bidan->namaLengkap:'';
                $data['tglrencanoeprasi'] = !empty($load->tglrencanaoperasi)?$load->tglrencanaoperasi:'';
            }
            
            echo json_encode($data);
            exit;
        }
    }
}
