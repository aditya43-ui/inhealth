<?php

class MonitoringPostTHDController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.monitoringPostTHD.';
    public $ok = true;

    public function actionIndex($pendaftaran_id, $monitoringpostid = null, $salin_id=null, $konsulpoli_id=null) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $cri = new CDbCriteria();
        $cri->select = "c.obatalkes_id, c.obatalkes_nama, b.qty_reseptur, b.resephd_id, b.resephd_det_id";
        $cri->join = "JOIN resepturdetail_t b ON t.reseptur_id=b.reseptur_id " .
                "JOIN obatalkes_m c ON b.obatalkes_id=c.obatalkes_id";
        $cri->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
        $cri->addCondition("b.resephd_id IS NOT NULL");
        $cri->addCondition("b.resephd_det_id IS NOT NULL");
        $modAlatBahan = ResepturT::model()->findAll($cri);
        $modKelengkapanAlat = new KelengkapanAlatHdT();
        $model = new HDMonitoringPostHdT();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->waktu = date('d-m-Y H:i:s');
        $model->dpjp_id = $modPendaftaran->pegawai_id;
        $model->dpjp_nama = $modPendaftaran->pegawai->nama_pegawai;
        $model->perawat1_id = Yii::app()->user->getState('pegawai_id');
        $model->perawat1_nama = $modPegawai->nama_pegawai;
        $modPresDetail = HDPrescriptionHdT::model()->find("pendaftaran_id = " . $pendaftaran_id);
        $modPrescription = HDPrescriptionHdT::model()->find("pendaftaran_id = " . $pendaftaran_id);
        $modAkandatang = JadwalhemodialisaT::model()->find("pendaftaran_id = ".$pendaftaran_id);
        if (empty($modAkandatang)){
            $modAkandatang = new JadwalhemodialisaT;
        }
        $modResephd = ResephdM::model()->findAll();
        if (!empty($monitoringpostid)) {
            $modPrescription = HDPrescriptionHdT::model()->find("monitoring_post_hd_id = ".$monitoringpostid);
            $crit = new CDbCriteria();
            $crit->select = "kelengkapan_alat_hd_id, monitoring_post_hd_id, pasien_id, pendaftaran_id, resephd_id, resephd_det_id, jumlah as qty_reseptur, obatalkes_id";
            $crit->addCondition("monitoring_post_hd_id = ".$monitoringpostid);
            $modAlatBahan = KelengkapanAlatHdT::model()->findAll($crit);
            
            $model = HDMonitoringPostHdT::model()->findByPk($monitoringpostid);
            $model->dpjp_nama = $model->dpjp->nama_pegawai;
            $model->perawat1_nama = !empty($model->perawat1->nama_pegawai)?$model->perawat1->nama_pegawai:null;
            $model->perawat2_nama = !empty($model->perawat2Id2->nama_pegawai)?$model->perawat2Id2->nama_pegawai:null;
            $model->waktu_meninggal = !empty($model->waktu_meninggal)?MyFormatter::formatDateTimeForUser($model->waktu_meninggal):null;
            if (!empty($model->asesmentnyeri_id)){
                $ases_nyeri = AsesmentnyeriT::model()->findByPk($model->asesmentnyeri_id);
                $model->keluhan_utama_nyeri = true;
                $model->skornyeri = $ases_nyeri->score_skalanyeri;
                $model->keterangan_skriningnyeri = $ases_nyeri->keteranganskala_nyeri; 
            }
        }
        if (!empty($modPrescription)) {
            $new = 1;
            if ($modPrescription->prescription_dokter_akut == true) {
                $pres = 'akut';
            } elseif ($modPrescription->prescription_dokter_kronis == true) {
                $pres = 'kronis';
            } elseif ($modPrescription->prescription_dokter_pirrt == true) {
                $pres = 'pirrt';
            } else {
                $pres = '';
            }
            $modPrescription->prescription_dokter = $pres;
            $modPrescription->time_satuan = $modPrescription->time_satuan;
            $model->presdokter = $pres;
            if ($modPrescription->heparinisasi_standar == true) {
                $model->heparinisasi = "standar";
            } elseif ($modPrescription->heparinisasi_minimal == true) {
                $model->heparinisasi = "minimal";
            } elseif ($modPrescription->heparinisasi_tanpaheparin == true) {
                $model->heparinisasi = $modPrescription->heparinisasi_tanpaheparin_penyebab;
            } elseif ($modPrescription->heparinisasi_lmwh == true) {
                $model->heparinisasi = "LMWH";
            } elseif ($modPrescription->heparinisasi_lainnya == true) {
                $model->heparinisasi = $modPrescription->heparinisasi_lainnya_penyebab;
            } else {
                $model->heparinisasi = "";
            }
        }

        if (empty($modPrescription)) {
            $modPrescription = new HDPrescriptionHdT();
            $new = 0;
            $model->presdokter = "";
            $model->heparinisasi = "";
        }
        $model->durasi_time = (!empty($modPrescription)) ? $modPrescription->durasi_time : "";
        $model->time_satuan = (!empty($modPrescription)) ? $modPrescription->time_satuan : "";
        $model->blood_flow = (!empty($modPrescription)) ? $modPrescription->blood_flow : "";
        $model->dialysate_flow = (!empty($modPrescription)) ? $modPrescription->dialysate_flow : "";
        $model->dialysate = (!empty($modPrescription)) ? ($modPrescription->dialysate_bicarbonat == true) ? "bicarbonat" : $modPrescription->dialysate_lainnya_keterangan : "";
        $model->dialyser = (!empty($modPrescription)) ? $modPrescription->diayser : "";
        $model->akses_vaskular = (!empty($modPrescription)) ? $modPrescription->akses_vaskular : "";
        $model->catatan_lain = (!empty($modPrescription)) ? $modPrescription->catatan_lain : "";
        $model->dialyser_temperatur = (!empty($modPrescription)) ? $modPrescription->dialyser_temperature : "";
        $model->uf_goal = (!empty($modPrescription)) ? $modPrescription->uf_goal : "";
        $model->selisih_bb = (!empty($modPrescription)) ? $modPrescription->selisih_berat_badan : "";
        $model->infus = (!empty($modPrescription)) ? $modPrescription->infus : "";
        $model->transfusi_darah = (!empty($modPrescription)) ? $modPrescription->transfusi_darah : "";
        
        if (isset($_POST['HDMonitoringPostHdT'])) {
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modJadwalhemodialisa = JadwalhemodialisaT::model()->find("pendaftaran_id = ".$pendaftaran_id);
                if (!empty($modJadwalhemodialisa)){
                    $modJadwalhemodialisa->jadwalhemodialisa_status = true;
                    $modJadwalhemodialisa->konsulpoli_id = $konsulpoli_id;
                    $modJadwalhemodialisa->jadwalhemodialisa_tgl_ke = isset($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke'])?MyFormatter::formatDateTimeForDb($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']):null;
                    if($modJadwalhemodialisa->update()){
                        $this->ok = true;
                    }else{
                        $this->ok = false;
                    }
                }else{
                    if (!empty($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke'])){
                        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);

                        $modJadwalhemodialisa = new JadwalhemodialisaT();
                        $modJadwalhemodialisa->attributes = $_POST['JadwalhemodialisaT'];
                        $modJadwalhemodialisa->jadwalhari_id = null;
                        $modJadwalhemodialisa->ruangan_id = !empty($konsul)?$konsul->ruangan_id:$modPendaftaran->ruangan_id;
                        $modJadwalhemodialisa->pendaftaran_id = $model->pendaftaran_id;
                        $modJadwalhemodialisa->konsulpoli_id = $konsulpoli_id;

                        $jml = JadwalhemodialisaT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id));
                        if(!empty($jml)){
                            $jadwal_ke = count($jml)+1;
                        }else{
                            $jadwal_ke = 1;
                        }                        
                        $modJadwalhemodialisa->jadwalhemodialisa_tgl_ke = isset($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke'])?MyFormatter::formatDateTimeForDb($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']):null;
                        $modJadwalhemodialisa->jadwalhemodialisa_hari = MyFormatter::getDayUser(date('w', strtotime($modJadwalhemodialisa->jadwalhemodialisa_tgl_ke)));
                        $modJadwalhemodialisa->jadwalhemodialisa_ke = $jadwal_ke;
                        $modJadwalhemodialisa->jadwalhemodialisa_status = true;
                        $modJadwalhemodialisa->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->membuat_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->mengetahui_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->pasien_id = $modPasien->pasien_id;
                        $kamarruangan_id = null;
                        if(!empty($modPendaftaran->kamarruangan_id)) {
                            $kamarruangan_id = $modPendaftaran->kamarruangan_id;
                        } else if(!empty($modPendaftaran->pasienadmisi->kamarruangan_id)) {
                            $kamarruangan_id = $modPendaftaran->pasienadmisi->kamarruangan_id;
                        }
                        $modJadwalhemodialisa->kamarruangan_id = $kamarruangan_id;
                        $modJadwalhemodialisa->jh_create_time = date("Y-m-d H:i:s");
                        $modJadwalhemodialisa->jh_create_loginid = Yii::app()->user->id;
                        $modJadwalhemodialisa->jh_create_ruanganid = Yii::app()->user->getState('ruangan_id');
                        $modJadwalhemodialisa->jh_create_ruanganiphost = getHostByName(getHostName());                    

                        if($modJadwalhemodialisa->save()){
                            $this->ok &= true;
                        }else{
                            $this->ok &= false;
                        }      
                        // echo '<pre>';var_dump($modJadwalhemodialisa->getErrors());die;                       
                    }
                }                                
                
                if($this->ok == true){
                    if(!empty($monitoringpostid)){
                        if(!empty($salin_id)){
                            $model = new HDMonitoringPostHdT();
                            $this->saveMonitoringPost($model, $_POST['HDMonitoringPostHdT'], $modPendaftaran, $modJadwalhemodialisa);
                        }else{
                            $model = HDMonitoringPostHdT::model()->findByPk($monitoringpostid);
                            $this->updateMonitoringPost($model, $_POST['HDMonitoringPostHdT'], $modPendaftaran, $modJadwalhemodialisa);
                        }

                    }else{
                        $this->saveMonitoringPost($model, $_POST['HDMonitoringPostHdT'], $modPendaftaran, $modJadwalhemodialisa);

                    }
                    if ($this->ok == true) {
                        
                         if ($model->catatan_meninggal == true && !empty($_GET['konsulpoli_id'])){
                            $konsul = KonsulpoliT::model()->findByPk($_GET['konsulpoli_id']);
                            $judul = 'Pasien Meninggal dari Hemodialisa';
                            $isi = 'Pasien atas nama '.$model->pasien->nama_pasien.' ('.$model->pasien->no_rekam_medik.') meninggal di instalasi Hemodialisa pada tanggal '.(!empty($model->waktu_meninggal)?MyFormatter::formatDateTimeForUser($model->waktu_meninggal,'long'):null);
                            
                            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                                array('instalasi_id'=>$konsul->poliasal->instalasi_id, 'ruangan_id'=>$konsul->asalpoliklinikkonsul_id, 'modul_id'=> Params::MODUL_ID_RI),                                        
                            ));  
                        }                        
                        
                        if ($_POST['HDMonitoringPostHdT']['perubahan'] == 'ya') {
                            if (isset($_POST['HDPrescriptionHdT'])) {

                                if ($new == 1) {
                                    $modPrescription = HDPrescriptionHdT::model()->findByPk($_POST['HDPrescriptionHdT']['prescription_hd_id']);
                                    $this->updatePrescription($modPrescription, $_POST['HDPrescriptionHdT'], $model, $modPendaftaran);
                                } else {
                                    $modPrescription = new HDPrescriptionHdT();
                                    $this->savePrescription($modPrescription, $_POST['HDPrescriptionHdT'], $model, $modPendaftaran);
                                }

                            }
                            if(isset($_POST['KelengkapanAlatHdT'])){
                                $this->saveKelengkapanAlatHD($modKelengkapanAlat, $_POST['KelengkapanAlatHdT'], $model, $modPendaftaran);
                            }

                            if ($this->ok == true) {
                                //ubah status
                                $this->ubah_status($pendaftaran_id, $konsulpoli_id);
                                                               
                                $transaction->commit();
                                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                                $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1,'konsulpoli_id'=>$konsulpoli_id, 'post_hd_id'=>$model->monitoring_post_hd_id));
                            } else {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modKelengkapanAlat));
                            }
                        } else {
                            //ubah status
                            $this->ubah_status($pendaftaran_id, $konsulpoli_id);
                            
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1,'konsulpoli_id'=>$konsulpoli_id, 'post_hd_id'=>$model->monitoring_post_hd_id));
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan ! ".CHtml::errorSummary($model));
                        echo Exception::getMessage()." Errrorrrrr";
                    }
                    
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan !!" . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $crit = new CDbCriteria();
        $crit->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $loadRiwayat = HDMonitoringPostHdT::model()->findAll($crit);


        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPrescription' => $modPrescription,
            'modPresDetail' => $modPresDetail,
            'modAlatBahan' => $modAlatBahan,
            'modKelengkapanAlat'=>$modKelengkapanAlat,
            'modAkandatang'=>$modAkandatang,
            'loadRiwayat' => $loadRiwayat,
            'modResephd'=>$modResephd,
        ));
    }
    
    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_HD_SELESAI;
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_HD_SELESAI;
                $konsul->save();
            }
        }                
    }

    public function saveMonitoringPost($model, $post, $modPendaftaran, $modJadwalhemodialisa) {
        $model->attributes = $post;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->jadwalhemodialisa_id = !empty($modJadwalhemodialisa->jadwalhemodialisa_id)?$modJadwalhemodialisa->jadwalhemodialisa_id:null;
        $model->waktu = MyFormatter::formatDateTimeForDb($post['waktu']);
        if (isset($post['perubahan'])) {
            $model->perubahan_perawatan = ($post['perubahan'] == 'ya') ? 1 : 0;
        } else {
            $model->perubahan_perawatan = 0;
        }
        $model->waktu_meninggal = !empty($model->waktu_meninggal)?MyFormatter::formatDateTimeForDb($model->waktu_meninggal):null;
        $model->create_time = date('Y-m-d');
        $model->creale_login = Yii::app()->user->id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
            $this->ok = true;
        } else {
            $this->ok = false;
        }
    }
    public function updateMonitoringPost($model, $post, $modPendaftaran, $modJadwalhemodialisa) {
        $model->attributes = $post;                        
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->jadwalhemodialisa_id = $modJadwalhemodialisa->jadwalhemodialisa_id;
        if (isset($post['perubahan'])) {
            $model->perubahan_perawatan = ($post['perubahan'] == 'ya') ? 1 : 0;
        } else {
            $model->perubahan_perawatan = 0;
        }
        $model->waktu_meninggal = !empty($model->waktu_meninggal)?MyFormatter::formatDateTimeForDb($model->waktu_meninggal):null;
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;
//        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
            $this->ok = true;
        } else {
            $this->ok = false;
        }
    }

    public function updatePrescription($modPrescription, $post, $model, $modPendaftaran) {
//        $modPrescription = HDPrescriptionHdT::model()->findByPk($post['prescription_hd_id']);
//        print_r($post);die;
        $modPrescription->attributes = $post;
        $modPrescription->monitoring_post_hd_id = $model->monitoring_post_hd_id;
        $modPrescription->update_time = date('Y-m-d');
        $modPrescription->update_loginpemakai_id = Yii::app()->user->id;

        if ($modPrescription->save()) {
            $this->ok = true;
        } else {
            $this->ok = false;
        }
    }

    public function savePrescription($modPrescription, $post, $model, $modPendaftaran) {
//        $modPrescription = new HDPrescriptionHdT();
        $modPrescription->attributes = $post;
        $modPrescription->dpjp_id = $modPendaftaran->pegawai_id;
        $modPrescription->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPrescription->pegawai_id = $modPendaftaran->pegawai_id;
        $modPrescription->pasien_id = $modPendaftaran->pasien_id;
        $modPrescription->monitoring_post_hd_id = $model->monitoring_post_hd_id;
        $modPrescription->waktu_prescription = date('Y-m-d');
        if (isset($post['prescription_dokter'])) {
            if ($post['prescription_dokter'] == 'akut') {
                $modPrescription->prescription_dokter_akut = true;
                $modPrescription->prescription_dokter_kronis = 0;
                $modPrescription->prescription_dokter_pirrt = 0;
            } elseif ($post['prescription_dokter'] == 'kronis') {
                $modPrescription->prescription_dokter_akut = 0;
                $modPrescription->prescription_dokter_kronis = true;
                $modPrescription->prescription_dokter_pirrt = 0;
            } elseif ($post['prescription_dokter'] == 'pirrt') {
                $modPrescription->prescription_dokter_akut = 0;
                $modPrescription->prescription_dokter_kronis = 0;
                $modPrescription->prescription_dokter_pirrt = true;
            }
        } else {
            $modPrescription->prescription_dokter_akut = 0;
            $modPrescription->prescription_dokter_kronis = 0;
            $modPrescription->prescription_dokter_pirrt = true;
        }
        $modPrescription->create_time = date('Y-m-d');
        $modPrescription->create_loginpmakai_id = Yii::app()->user->id;
        $modPrescription->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if ($modPrescription->save()) {
            $this->ok = true;
        } else {
            $this->ok = false;
        }
    }
    
    public function saveKelengkapanAlatHD($modKelengkapanAlat, $post, $model, $modPendaftaran){
        $cekKelengkapan = KelengkapanAlatHdT::model()->findAll("pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
        if(!empty($cekKelengkapan)){
            $hapusKelengkapan = KelengkapanAlatHdT::model()->deleteAll("pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
        }
        foreach($post as $key=>$value){
            $modKelengkapanAlat = new KelengkapanAlatHdT();
            $modKelengkapanAlat->attributes = $value;
            $modKelengkapanAlat->monitoring_post_hd_id = $model->monitoring_post_hd_id;
            $modKelengkapanAlat->pasien_id = $modPendaftaran->pasien_id;
            $modKelengkapanAlat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            
            if($modKelengkapanAlat->save()){
                $this->ok = true;
            }else{
                $this->ok = false;
            }
        }
    }

    public function actionHapusPostHd() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $hapusPrescription = HDPrescriptionHdT::model()->find("monitoring_post_hd_id = " . $id);
                if (!empty($hapusPrescription)) {
                    $ok = $ok && HDPrescriptionHdT::model()->deleteAll("monitoring_post_hd_id = " . $id);
                }

                $ok = $ok && HDMonitoringPostHdT::model()->deleteByPk($id);
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data Berhasil Dihapus';
                    $transaction->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data Gagal Dihapus';
                    $transaction->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = 'Data Gagal Dihapus';
                $transaction->rollback();
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionAddRowKelengkapanAlat(){
        if(Yii::app()->request->isAjaxRequest){
            $form = "";
            $no = $_POST['no'];
            $key = $_POST['key'];
            $modKelengkapanAlat = new KelengkapanAlatHdT();
        
            $form .= $this->renderPartial('_addRow', array('modKelengkapanAlat'=>$modKelengkapanAlat,'no'=>$no,'key'=>$key
            ), true);
            
            echo CJSON::encode(array('form'=>$form));
            Yii::app()->end();
        }
        
    }
    
    public function actionPrint($monitoringpostid, $id){
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = HDMonitoringIntraHdT::model()->findByAttributes([
            'pendaftaran_id' => $id
        ],['order'=>'create_time DESC']);
        $model->set_intra_det = $model->loadIntraDet();
        
        $modPres = HDPrescriptionHdT::model()->find(" pendaftaran_id = ".$id." ORDER BY create_time DESC ");
        if (empty($modPres)){
            $modPres = new HDPrescriptionHdT;
        }        
           
        $modDaftar = PendaftaranT::model()->findByPk($id);
        
        $modPost = HDMonitoringPostHdT::model()->findByPk($monitoringpostid);
        
        if (empty($modPost)){
            $modPost = new HDMonitoringPostHdT;
        }
        
        $modJadwal = JadwalhemodialisaT::model()->findByPk($modPost->jadwalhemodialisa_id);
        if (empty($modJadwal)){
            $modJadwal = new JadwalhemodialisaT;
        }
        
        $no_dok = '';
        $view = 'hemodialisa.views.monitoringIntraTHD.print/index';
            
        $judullaporan = '';
        $alias = '';
        
        $pasien = $modDaftar->pasien;
        
        $umur = CustomFunction::getUmurTahun($pasien->tanggal_lahir, $modDaftar->tgl_pendaftaran);;
        
        if ($umur < 18){
//            return parent::actionPrint($id);
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
    
    public function actionLoadPaket(){
        if (Yii::app()->request->isAjaxRequest){
            $paket_id = isset($_POST['paket_id'])?$_POST['paket_id']:null;
            
            $model = ResephdDetM::model()->findAll(" resephd_id = ".$paket_id." ");
            
            $tr = '';
            foreach($model as $i => $det){
                $modKelengkapanAlat = new KelengkapanAlatHdT;
                $modKelengkapanAlat->obatalkes_nama = $det->obatalkes->obatalkes_nama;
                $modKelengkapanAlat->obatalkes_id = $det->obatalkes_id;
                $modKelengkapanAlat->jumlah = 1;
                $modKelengkapanAlat->resephd_id = $det->resephd_id;
                $tr .= $this->renderPartial($this->path_view.'_addRow',['modKelengkapanAlat'=>$modKelengkapanAlat, 'key'=>$i, 'no'=>$i+1], true);
            }
            
            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
