<?php

class MonitoringIntraTHDController extends MyAuthController{
    public $layout = '//layouts/column1';
    public $ok = true;
    public $path_view = 'hemodialisa.views.monitoringIntraTHD.';
    
    public function actionIndex($pendaftaran_id, $monitoringintraid=null, $salin_id=null, $konsulpoli_id=null)
    {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $modAksesVaskular = AksesVaskularT::model()->findAll("pendaftaran_id = ".$pendaftaran_id);
//        echo count($modAkses);die;
        $model = new HDMonitoringIntraHdT();
        $modDetail = new HDMonitoringIntraHdDetT();
        $modPrescriptionDokter = new HDPrescriptionHdT();
        $model->tanggal = date('d M Y');
        $model->dpjp_id = $modPendaftaran->pegawai_id;
        $model->dpjp_nama = $modPendaftaran->pegawai->nama_pegawai;
        $model->perawat1_id = Yii::app()->user->getState('pegawai_id');
        $model->perawat1_nama = $modPegawai->nama_pegawai;
//        $model->akses_vaskular = (!empty($modAkses->nama_akses_vaskular)) ? $modAkses->nama_akses_vaskular : "-";
        $modLoadDetail = array();

        
        if(!empty($monitoringintraid)){
            $model = HDMonitoringIntraHdT::model()->findByPk($monitoringintraid);
            $modLoadDetail = HDMonitoringIntraHdDetT::model()->findAll("monitoring_intra_hd_id = ".$monitoringintraid);
//            $model->tanggal = MyFormatter::formatDateTimeForUser(date('d-m-Y'), strtotime($model->tanggal));

            $model->tanggal = date('d M Y', strtotime($model->tanggal));

            $model->dpjp_nama = $model->dpjp->nama_pegawai;
            $model->perawat1_nama = $model->perawat1->nama_pegawai;
            $model->perawat2_nama = (!empty($model->perawat2_id)) ? $model->perawat2->nama_pegawai : "";
        }
        $load  = PrescriptionHdT::model()->find(" pendaftaran_id = ".$modPendaftaran->pendaftaran_id." ORDER BY  create_time DESC ");
        
        $modDetail->blood_flow = !empty($load)?$load->blood_flow:null;
        
        if(isset($_POST['HDMonitoringIntraHdT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                // echo "<pre>";
                // var_dump($_POST);die;
                $model->attributes = $_POST['HDMonitoringIntraHdT'];
                //echo "<pre>";
                //var_dump($_POST);die;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->pendaftaran_id = $pendaftaran_id;
                
                if(!empty($monitoringintraid)){
                    if(!empty($salin_id)){
                        $model = new HDMonitoringIntraHdT();
                        $model->attributes = $_POST['HDMonitoringIntraHdT'];
                        $model->tanggal = MyFormatter::formatDateTimeForDb($_POST['HDMonitoringIntraHdT']['tanggal']);
                        $model->pasien_id = $modPendaftaran->pasien_id;
                        $model->pendaftaran_id = $pendaftaran_id;
                        $model->create_time = date('Y-m-d');
                        $model->creale_login = Yii::app()->user->id;
                    }else{
                        $model->tanggal = MyFormatter::formatDateTimeForDb($_POST['HDMonitoringIntraHdT']['tanggal']);
                        $model->update_time = date('Y-m-d');
                        $model->update_loginpemakai_id = Yii::app()->user->id;
                    }
                }else{
                    $model->create_time = date('Y-m-d');
                    $model->creale_login = Yii::app()->user->id;
                }
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                
                if($model->save()){
                    //echo "<pre>";
                    //var_dump($model->attributes);die;
                    
                    
                    // Update status periksa 
//                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                    if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISAGRAHA || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
//                        $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
//                        if (!empty($modKonsul)) {
//                            $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modKonsul->update_time = date("Y-m-d H:i:s");
//                            $modKonsul->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modKonsul->save();
//                        } else {
//                            $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modPendaftaran->update_time = date("Y-m-d H:i:s");
//                            $modPendaftaran->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modPendaftaran->save();
//                        }
//                    }
                    $this->ubah_status($pendaftaran_id, $konsulpoli_id);
                    
                    if(isset($_POST['HDMonitoringIntraHdDetT'])){
                        if(!empty($monitoringintraid)){
                            if(!empty($salin_id)){
                                $this->saveMonitoringIntraDetail($modDetail,$_POST['HDMonitoringIntraHdDetT'],$model, $modPendaftaran);
                            }else{
                                $modDetail = HDMonitoringIntraHdDetT::model()->find("monitoring_intra_hd_id = ".$monitoringintraid);
                            $this->updateMonitoringIntraDetail($modDetail,$_POST['HDMonitoringIntraHdDetT'],$model, $modPendaftaran, $monitoringintraid);
                            }
                            
                        }else{
                            $this->saveMonitoringIntraDetail($modDetail,$_POST['HDMonitoringIntraHdDetT'],$model, $modPendaftaran);
                        }
//                        $this->saveMonitoringIntraDetail($modDetail,$_POST['HDMonitoringIntraHdDetT'],$model, $modPendaftaran);
                        $this->savePrescriptionDokter($modPendaftaran->pendaftaran_id,$_POST['HDPrescriptionHdT']);
                        if($this->ok == true){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                            $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'sukses'=>1,'konsulpoli_id'=>$konsulpoli_id,'intra_hd_id'=>$model->monitoring_intra_hd_id));
                        }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($modDetail));
                        }
                    }else{
                        //var_dump($transaction);die;
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'sukses'=>1,'konsulpoli_id'=>$konsulpoli_id,'intra_hd_id'=>$model->monitoring_intra_hd_id));
                    }
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
        }
        
        $crit = new CDbCriteria();
        $crit->addCondition("pendaftaran_id = ".$pendaftaran_id);
        $loadRiwayat = HDMonitoringIntraHdT::model()->findAll($crit);
        
        $this->render($this->path_view.'index', array(
            'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'modDetail'=>$modDetail,
            'modLoadDetail'=>$modLoadDetail,
            'loadRiwayat'=>$loadRiwayat,
            'modAksesVaskular'=>$modAksesVaskular,
            'modPrescriptionDokter'=>$modPrescriptionDokter,
        ));
    }

    public function savePrescriptionDokter($pendaftaran_id,$modPrescriptionDokter){
        // echo "<pre>";
        // var_dump($modPrescriptionDokter);die;
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $aksesvaskular = AksesVaskularT::model()->findAll("pendaftaran_id = ".$pendaftaran_id);
        if (!empty($prescription_id)){
            $model = HDPrescriptionHdT::model()->findByPk($prescription_id);            
        }elseif (!empty($salin_id)){
            $model = HDPrescriptionHdT::model()->findByPk($salin_id);            
        }else{            
            $new_pres = true;
            $model = HDPrescriptionHdT::model()->find("pasien_id = ".$modPendaftaran->pasien_id.' ORDER BY pendaftaran_id DESC, create_time DESC, prescription_hd_id DESC');               
        }
        
        if(!empty($model->prescription_hd_id)){            
            if($model->prescription_dokter_akut == true){
                $pres = 'akut';
            }elseif ($model->prescription_dokter_kronis == true) {
                $pres = 'kronis';
            }elseif ($model->prescription_dokter_pirrt == true){
                $pres='pirrt';
            }else{
                $pres='';
            }

            $model->prescription_dokter = $pres;
            $model->dpjp_nama = !empty($model->dpjp->namaLengkap)?$model->dpjp->namaLengkap:null;
            
            if ($new_pres){
                unset($model->prescription_hd_id);
                $model->isNewRecord = true;    
            }
        }else{
            $model = new HDPrescriptionHdT;
            $model->waktu_prescription = date('d/m/Y H:i:s');
            $model->dpjp_id = $modPendaftaran->pegawai_id;
            $model->dpjp_nama = $modPendaftaran->pegawai->nama_pegawai;
                        
            $akses = "";
            if(count($aksesvaskular)>0){
                foreach ($aksesvaskular as $av){
                    $init = '';
                    if (!empty($av->hd_kateter)){
                        $init = ' - '.$av->hd_kateter;                    
                    }
                    $akses .= $av->nama_akses_vaskular.$init.", ";
                }                            
            }
            
            $model->akses_vaskular = $akses;
        }               
        
        if(isset($_POST['HDPrescriptionHdT'])){
            $ok = true;
            //$transaction = Yii::app()->db->beginTransaction();
            //try{
                $model->attributes = $_POST['HDPrescriptionHdT'];
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pegawai_id = $modPendaftaran->pegawai_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->waktu_prescription = MyFormatter::formatDateTimeForDb($_POST['HDPrescriptionHdT']['waktu_prescription']);
                if(isset($_POST['HDPrescriptionHdT']['prescription_dokter'])){
                    if($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'akut'){
                        $model->prescription_dokter_akut = true;
                        $model->prescription_dokter_kronis = 0;
                        $model->prescription_dokter_pirrt = 0;
                    }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'kronis'){
                        $model->prescription_dokter_akut = 0;
                        $model->prescription_dokter_kronis = true;
                        $model->prescription_dokter_pirrt = 0;
                    }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'pirrt'){
                        $model->prescription_dokter_akut = 0;
                        $model->prescription_dokter_kronis = 0;
                        $model->prescription_dokter_pirrt = true;
                    }
                }else{
                    $model->prescription_dokter_akut = 0;
                    $model->prescription_dokter_kronis = 0;
                    $model->prescription_dokter_pirrt = true;
                }
                
                if(isset($_POST['aksesvaskular'])){
                    $akvas = "";
                    foreach ($_POST['aksesvaskular'] as $key=>$value){
                        $akvas .= $value.",";
                    }
                    $model->akses_vaskular = $akvas;
                }
                
                if (!empty($salin_id)){
                    unset($model->prescription_hd_id);
                    $model->isNewRecord = true;                    
                }
                
                $new = false;
                if (empty($model->prescription_hd_id)){
                    $model->create_time = date('Y-m-d');
                    $model->create_loginpmakai_id = Yii::app()->user->id;
                    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $new = true;
                }else{
                    $model->update_time = date('Y-m-d');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                                                                
                $ok &= $model->save();
                       
                if ($new){
                    if ($modPendaftaran->instalasi_id == ParamsConst::INSTALASI_ID_HEMODIALISA) {
                        $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
                        if (!empty($modKonsul)) {
                            $modKonsul->update_time = date("Y-m-d h:i:s");
                            $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                            $ok = $ok&& $modKonsul->save(); 
                        } else {
                            $modPendaftaran->update_time = date("Y-m-d h:i:s");
                            $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                            $ok = $ok && $modPendaftaran->save(); 
                        }
                    }
                }
                
                //if($ok){
                    //$transaction->commit();
                    //Yii::app()->user->setFlash('success',"Data Resep berhasil disimpan");
                    //$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'sukses'=>1));
                //}else{
                    //$transaction->rollback();
                    //Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                //}
            //} //catch (Exception $exc) {
                //$transaction->rollback();
                //Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            //}
            
        }
    }
    
    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->save();
            }
        }                
    }
    
    public function saveMonitoringIntraDetail($modDetail, $post, $model, $modPendaftaran){
        $a=0;
        foreach ($post as $i => $value){
            $modDetail = new HDMonitoringIntraHdDetT();
            $modDetail->attributes = $post[$a];
            $modDetail->jam_observasi = !empty($modDetail->jam_observasi)?$modDetail->jam_observasi:null;
            $modDetail->monitoring_intra_hd_id = $model->monitoring_intra_hd_id;
            
            $modDetail->create_time = date('Y-m-d');
            $modDetail->creale_login = Yii::app()->user->id;
            $modDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if($modDetail->save()){
                $this->ok = true;
            }else{
                $this->ok = false;
            }
            $a++;
        }
    }
    
    public function updateMonitoringIntraDetail($modDetail, $post, $model, $modPendaftaran, $monitoringintraid){
        $ok = true;
        $cekDetail = HDMonitoringIntraHdDetT::model()->find("monitoring_intra_hd_id = ".$monitoringintraid);
        if(!empty($cekDetail)){
            $ok = $ok && HDMonitoringIntraHdDetT::model()->deleteAll("monitoring_intra_hd_id = ".$monitoringintraid);
        }
        $a=0;
        foreach ($post as $i => $value){
            $modDetail = new HDMonitoringIntraHdDetT();
            $modDetail->attributes = $post[$a];
            $modDetail->monitoring_intra_hd_id = $model->monitoring_intra_hd_id;
            $modDetail->jam_observasi = !empty($modDetail->jam_observasi)?$modDetail->jam_observasi:null;
            $modDetail->create_time = date('Y-m-d');
            $modDetail->creale_login = Yii::app()->user->id;
            $modDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if($modDetail->save()){
                $this->ok = true;
            }else{
                $this->ok = false;
            }
            $a++;
        }
    }
    
    public function actionSetTindakanKeperawatan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $form = "";
            $pesan = "";
            $pendaftaran_id = $_POST['pendaftaran_id'];
//            $format = new MyFormatter();
            $model = new HDMonitoringIntraHdT;
            $modDetail = new HDMonitoringIntraHdDetT;

            if(!empty($_POST['penyulit_id'])){
                $penyulit = PenyulitHdM::model()->findByPk($_POST['penyulit_id']);
                $penyulit_nama = $penyulit->penyulit_hd_nama;
            }
            
            $modDetail->penyulit_hd_id = isset($_POST['penyulit_id']) ? $_POST['penyulit_id'] : "" ;
            $modDetail->jenis_observasi = isset($_POST['observasi']) ? $_POST['observasi'] : "" ;
            $modDetail->jam_observasi = isset($_POST['jam']) ? $_POST['jam'] : "" ;
            $modDetail->blood_flow = isset($_POST['blood_flow']) ? $_POST['blood_flow'] : "" ;
            $modDetail->uf_rate = isset($_POST['uf_rate']) ? $_POST['uf_rate'] : "" ;
            $modDetail->tensi_sistolik = isset($_POST['tensi_sis']) ? $_POST['tensi_sis'] : "" ;
            $modDetail->tensi_diastolik = isset($_POST['tensi_dia']) ? $_POST['tensi_dia'] : "" ;
            $modDetail->nadi = isset($_POST['nadi']) ? $_POST['nadi'] : "" ;
            $modDetail->suhu = isset($_POST['suhu']) ? $_POST['suhu'] : "" ;
            $modDetail->respirasi = isset($_POST['respirasi']) ? $_POST['respirasi'] : "" ;
            $modDetail->intake_nacl = $_POST['intakeNaclBol'];
            $modDetail->intake_nacl_keterangan = isset($_POST['intakeNacl']) ? $_POST['intakeNacl'] : "" ;
            $modDetail->intake_lainnya = $_POST['intakeLainBol'];
            $modDetail->intake_lainnya_keterangan = isset($_POST['intakeLain']) ? $_POST['intakeLain'] : "" ;
            $modDetail->output_uf_goal = $_POST['outputUfBol'];
            $modDetail->output_uf_goal_keterangan = isset($_POST['outputUf']) ? $_POST['outputUf'] : "" ;
            $modDetail->output_lainnya = $_POST['outputLainBol'];
            $modDetail->output_lainnya_keterangan = isset($_POST['outputLain']) ? $_POST['outputLain'] : "" ;             
            
            $data['penyulit_hd_id'] = isset($_POST['penyulit_id']) ? $_POST['penyulit_id'] : "";
            $data['observasi'] = isset($_POST['observasi']) ? $_POST['observasi'] : "";
            $data['blood_flow'] = isset($_POST['blood_flow']) ? $_POST['blood_flow'] : "";
            $data['uf_rate'] = isset($_POST['uf_rate']) ? $_POST['uf_rate'] : "" ;
            $data['jam'] = isset($_POST['jam']) ? $_POST['jam'] : "" ;
            $data['tensi_sis'] = isset($_POST['tensi_sis']) ? $_POST['tensi_sis'] : "" ;
            $data['tensi_dia'] = isset($_POST['tensi_dia']) ? $_POST['tensi_dia'] : "" ;
            $data['nadi'] = isset($_POST['nadi']) ? $_POST['nadi'] : "" ;
            $data['suhu'] = isset($_POST['suhu']) ? $_POST['suhu'] : "" ;
            $data['respirasi'] = isset($_POST['respirasi']) ? $_POST['respirasi'] : "" ;
            $data['intake_nacl'] = isset($_POST['intakeNacl']) ? $_POST['intakeNacl'] : "" ;
            $data['intake_lain'] = isset($_POST['intakeLain']) ? $_POST['intakeLain'] : "" ;
            $data['output_uf_goal'] = isset($_POST['outputUf']) ? $_POST['outputUf'] : "" ;
            $data['output_lain'] = isset($_POST['outputLain']) ? $_POST['outputLain'] : "" ; 
            $data['intra_tanggal'] = isset($_POST['intra_tanggal']) ? $_POST['intra_tanggal'] : "" ;
            $data['intra_dpjp'] = isset($_POST['intra_dpjp']) ? $_POST['intra_dpjp'] : "" ;
            $data['intra_perawat1'] = isset($_POST['intra_perawat1']) ? $_POST['intra_perawat1'] : "" ;
            $data['intra_perawat2'] = isset($_POST['intra_perawat2']) ? $_POST['intra_perawat2'] : "" ;
            $data['intra_akses_vaskular'] = isset($_POST['intra_akses_vaskular']) ? $_POST['intra_akses_vaskular'] : "" ;
            $data['intra_dosis_awal'] = isset($_POST['intra_dosis_awal']) ? $_POST['intra_dosis_awal'] : "" ;
            $data['intra_dosis_maintenan'] = isset($_POST['intra_dosis_maintenan']) ? $_POST['intra_dosis_maintenan'] : "" ;
            $data['intra_tidak_per_jam'] = isset($_POST['intra_tidak_per_jam']) ? $_POST['intra_tidak_per_jam'] : "" ;
            $data['intra_tidak_per_set_jam'] = isset($_POST['intra_tidak_per_set_jam']) ? $_POST['intra_tidak_per_set_jam'] : "" ;
            $data['konsulpoli_id'] = isset($_POST['konsulpoli_id'])?$_POST['konsulpoli_id']:null;            
            
            if(!empty($_POST['penyulit_id'])){
                $data['subyektif'] = 'Mengganti Alat';
                $form .= $this->renderPartial($this->path_view.'_rowDetailPenyulit', array('modDetail'=>$modDetail, 'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id, 'data'=>$data, 'penyulit_nama'=>$penyulit_nama), true);
                
            }else{
                $form .= $this->renderPartial($this->path_view.'_rowDetail', array('modDetail'=>$modDetail, 'model'=>$model), true);
                
            }
            
				
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
            
        }
    }
    
    public function actionSetObservasi(){
        if(Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
//            echo $pendaftaran_id;die;
        
            $cri = new CDbCriteria();
            $cri->addCondition("pendaftaran_id = ".$pendaftaran_id);
            $modPre = MonitoringPreHdT::model()->find($cri);

            if(!empty($modPre)){
                $data['nadi'] = $modPre->nadi;
                $data['tensi_sis'] = $modPre->tensi_sistolik;
                $data['tensi_dia'] = $modPre->tensi_diastolik;
                $data['suhu'] = $modPre->suhu;
                $data['respirasi'] = $modPre->respirasi;
            }else{
                $data['nadi'] = 0;
                $data['tensi_sis'] = 0;
                $data['tensi_dia'] = 0;
                $data['suhu'] = 0;
                $data['respirasi'] = 0;
            }
            
            echo CJSON::encode($data);
            Yii::app()->end();
            
        }
        
    }
    
    public function actionHapusRiwayat(){
        if(Yii::app()->request->isAjaxRequest){
            $id=$_POST['id'];
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $hapusDetail = HDMonitoringIntraHdDetT::model()->find("monitoring_intra_hd_id = ".$id);
                if(!empty($hapusDetail)){
                    $ok = $ok && HDMonitoringIntraHdDetT::model()->deleteAll("monitoring_intra_hd_id = ".$id);
                }
                $ok = $ok && HDMonitoringIntraHdT::model()->deleteByPk($id);
                
                if($ok){
                    $data['sukses']=1;
                    $data['pesan']="Data Berhasil Dihapus!";
                    $trans->commit();
                }else{
                    $data['sukses']=0;
                    $data['pesan']="Data Gagal Dihapus";
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses']=0;
                $data['pesan']="Data Gagal Dihapus";
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionPrintRiwayat($monitoringintraid, $id, $konsulpoli_id=null){
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = HDMonitoringIntraHdT::model()->findByPk($monitoringintraid);
        $model->set_intra_det = $model->loadIntraDet();
        
        $modPres = HDPrescriptionHdT::model()->find(" pendaftaran_id = ".$id." ORDER BY create_time DESC ");
        if (empty($modPres)){
            $modPres = new HDPrescriptionHdT;
        }        
           
        $modDaftar = PendaftaranT::model()->findByPk($id);
        
        $modPost = HDMonitoringPostHdT::model()->findByAttributes([
            'pendaftaran_id' => $id
        ],['order'=>'create_time DESC']);
        
        if (empty($modPost)){
            $modPost = new HDMonitoringPostHdT;
        }
        
        $modJadwal = JadwalhemodialisaT::model()->findByPk($modPost->jadwalhemodialisa_id);
        if (empty($modJadwal)){
            $modJadwal = new JadwalhemodialisaT;
        }
        
        $no_dok = '';
        $view = 'print/index';
            
        $judullaporan = '';
        $alias = '';
        
        $pasien = $modDaftar->pasien;
        
        $umur = CustomFunction::getUmurTahun($pasien->tanggal_lahir, $modDaftar->tgl_pendaftaran);;
        
        if ($umur < 18){
            return parent::actionPrint($id);
        }
        
        $data = [
            'judul_laporan' => $judullaporan,
            'no_dok' => $no_dok,
            'alias' => $alias,
            'nama_lengkap' => $pasien->nama_pasien,
            'no_rm' => $pasien->no_rekam_medik,
            'tanggal_lahir' => date('d/m/Y', strtotime($pasien->tanggal_lahir)),
        ];
                      
        $ukuranKertasPDF = Params::getUkuranKertas();
        $mpdf = new MyPDF('', $ukuranKertasPDF['A4']);
        $mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $posisi = Yii::app()->user->getState('posisi_kertas');  
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->WriteHTML( $this->renderPartial($view, array(
            'format' => $format,
            'model' => $model,
            'modPres' => $modPres,
            'modJadwal' => $modJadwal,
            'modPost' => $modPost,
            'judullaporan' => $judullaporan,
            'data' => $data,        
        ),true));
        $mpdf->Output($judullaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
    
    function actionGenerateForm(){
        if (Yii::app()->request->isAjaxRequest){
            $this->path_view = 'rawatInap.views.perkembanganTerintegrasiPasienT.';
            parse_str($_POST['formdata'], $arr);
            $pendaftaran_id = $_POST['pendaftaran_id'];
//            print_r($arr);die;
            $format = new MyFormatter();
            $modTampilAsesmen = AsesmenRencanaKeperawatanT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $modPenunjang = new PasienmasukpenunjangT;
            $model = new PerkembanganTerintegrasiPasienT;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if(!empty($modTampilAsesmen)){
                foreach ($modTampilAsesmen as $i => $modAsesmen) {
                    $modTampilAsesmenDetail = AsesmenRencanaKeperawatanDetT::model()->findByAttributes(array('asesmen_rencana_keperawatan_id' => $modAsesmen->asesmen_rencana_keperawatan_id));
                }
            }else{
                $modTampilAsesmenDetail = new AsesmenRencanaKeperawatanDetT;
            }
            
            $tr = $this->renderPartial("rawatInap.views.perkembanganTerintegrasiPasienT.createIntegrasi", array(
                "modTampilAsesmen"=>$modTampilAsesmen, 
                "modPenunjang"=>$modPenunjang, 
                "model"=>$model, 
                "modPendaftaran"=>$modPendaftaran, 
                "modAdmisi"=>$modAdmisi, 
                "modPasien"=>$modPasien, 
                "format"=>$format
                    ),true);
            
            $data['sukses'] = 1;
            $data['html'] = $tr;

            echo json_encode($data);

            Yii::app()->end();
        }
    }
    
    public function actionStopTindakanDialisis() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $konsulpoli_id = isset($_POST['konsulpoli_id']) ? $_POST['konsulpoli_id'] : null;
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPendaftaran->status_hd = 'TIDAK SELESAI';
                $ok = $ok && $modPendaftaran->update();

                $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
                if (!empty($konsul)) {
                    if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())) {
                        $konsul->statusperiksa = 'TIDAK SELESAI';
                        $ok &= $konsul->save();
                    }
                }

                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Tindakan Dialisis Telah di Stop";
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = "Tindakan Dialisis Gagal di Stop";
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = "Tindakan Dialisis Gagal di Stop";
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
}

