<?php

class SepInternalController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $septersimpan = false;
    public $updatesep = false;
    public $deletesep = false;
    public $bridgingsep = true;
    public $bridginglaporansep = true;
    public $laporanseptersimpan = true;
    public $succesSaveStok = true; //looping
    public $succesKembaliStok = true; //looping
    public $path_view = 'asuransi.views.sepInternal.';
    public $path_view_tips = 'asuransi.views.tips.';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->pageTitle = Yii::app()->name . " - Lihat SEP Rujukan Internal";
        $model = $this->loadModel($id);
        $bpjs = new BpjsVklaim();

        $this->render($this->path_view . 'viewSep', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate($id = null, $pendaftaran_id = null, $konsulpoli_id = null) {

        $pengajuanapprovalsep_id = null;

        $this->pageTitle = Yii::app()->name . " - Tambah SEP Rujukan Internal";
        $status = '';
        $model = new ARSepT;
        $model->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
        $model->ppkpelayanan_nama = Yii::app()->user->getState('nama_ppkpelayanan');
        $model->tglsep = date('Y-m-d');
        $model->carabayar_id = Params::CARABAYAR_ID_BPJS;
        $model->penjamin_id = Params::CARABAYAR_ID_BPJS;
        $model->jnspelayanan = 2;
        $model->jenispeserta_id = 2;
        $model->is_polieksekutif = 0;
        $model->is_cob = 0;
        $model->katarak = 0;
        $model->is_lakalantas = 0;
        $model->suplesi_jasaraharja = 0;
        $model->status_nosep = "TIDAK";
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if(isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)){
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        }else{
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modAsuransiPasien = new ARAsuransipasienM;
        $modAsuransiPasienBpjs = new ARAsuransipasienbpjsM;
        $modInfoKunjungan = InformasisepinternalV::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
            'konsulpoli_id'=>$konsulpoli_id,
        ));
        $modRujukanBpjs->tanggal_rujukan = date('Y-m-d');
        $modPendaftaran = new PendaftaranT();
        $modPasien = new PasienM();
        $modPengajuanApproval = new PengajuanapprovalsepT();

        /*
        if (!empty($pengajuanapprovalsep_id)){
            $modPengajuanApproval = PengajuanapprovalsepT::model()->findByPk($pengajuanapprovalsep_id);

            if(!empty($modPengajuanApproval)){
                $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modPengajuanApproval->pendaftaran_id));
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                if(!empty($modPendaftaran->pasienadmisi_id)){
                    $modInfoKunjungan->instalasi_id = $modPendaftaran->pasienadmisi->instalasi_id;
                }else{
                    $modInfoKunjungan->instalasi_id = $modPendaftaran->instalasi_id;
                }
            }
        }

        */
        if (!empty($id)) {
            $model = ARSepT::model()->findByPk($id);
            $modPendaftaran = ARPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $model->nopeserta = $model->nokartuasuransi;
            $model->no_rekam_medik = $modPasien->no_rekam_medik;
            $model->carabayar_id = $modPendaftaran->carabayar_id;
            $model->penjamin_id = $modPendaftaran->penjamin_id;
            $model->kelastanggungan_id = $model->klsrawat;
            $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
            $modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
//            $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            $modRujukanBpjs->no_rujukan = $model->norujukan;
            $modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
        }
        

        if (!empty($pendaftaran_id)) {
            $modPendaftaran = InformasisepinternalV::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id
            ));
            $rujukan_asal = RujukandariM::model()->findByAttributes(array(
                'ppkrujukan'=>$modInfoKunjungan->ppkrujukan_utama
            ));
            $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
            ), array(
                'order'=>'pasienmorbiditas_id desc',
            ));

            // var_dump($morbid); die;

            
            
            // var_dump($rujukan_asal->attributes); die;
            $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modelUtama = ARSepT::model()->findByPk($modPendaftaran->seputama_id);
            $modelUtama->nopeserta = $modelUtama->nokartuasuransi;
            $modelUtama->no_rekam_medik = $modelUtama->no_rekam_medik;
            $modelUtama->carabayar_id = $modelUtama->carabayar_id;
            $modelUtama->penjamin_id = $modelUtama->penjamin_id;
            $modelUtama->kelastanggungan_id = $modelUtama->klsrawat;
            //$model->attributes = $modelUtama->attributes;
            $model->jenis_kunjungan = (string)"0";
            $model->nokartuasuransi = $model->nopeserta = $modInfoKunjungan->nokartuasuransi;
            $model->norujukan = $modInfoKunjungan->norujukan_utama;
            $model->ppkrujukan = $modInfoKunjungan->ppkrujukan_utama;
            if (!empty($rujukan_asal)) {
                $model->ppkrujukan_nama = $rujukan_asal->namaperujuk; 
            }

            if (!empty($morbid)) {
                $model->diagnosaawal = $morbid->diagnosa->diagnosa_kode;
            }


            // $model->ppkrujukan_nama = Yii::app()->user->getState('nama_rumahsakit');
            $model->politujuan = $modInfoKunjungan->kodebpjs_ruangantujuan;
            $model->no_telpon_peserta = $modInfoKunjungan->no_telpon_pesertautama;
            if (!empty($modInfoKunjungan->kodedokter_bpjs)) {
                $model->dpjpygmelayani_kode = $modInfoKunjungan->kodedokter_bpjs;
                // var_dump($model->attributes, $modInfoKunjungan->attributes); die;
                $model->dpjpygmelayani_nama = $modInfoKunjungan->nama_pegawai;
            }
            $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modelUtama->nokartuasuransi));
            $modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta' => $modelUtama->nokartuasuransi));
//            $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            $modRujukanBpjs->no_rujukan = $model->norujukan;
            $modRujukanBpjs->tanggal_rujukan = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modInfoKunjungan->tglrujukan_utama)));
            $model->klsrawat = $modelUtama->klsrawat;
            $model->statuskecelakaan_kode = $modelUtama->statuskecelakaan_kode;
            $model->catatansep = $model->catatansep ?? "-";
            // var_dump($rujukan_asal->attributes, $modInfoKunjungan->attributes); die;

            if (!empty($modAsuransiPasien->kelastanggunganasuransi_id)) {
                $kelas_tanggung = KelaspelayananM::model()->findByPk($modAsuransiPasien->kelastanggunganasuransi_id);
                if (!empty($kelas_tanggung)) {
                    $modAsuransiPasien->kelastanggunganasuransi_id = $kelas_tanggung->kelasbpjs_id;
                }
            }

            // var_dump($modAsuransiPasienBpjs->attributes); die;
        }

         
        if (isset($_POST['ARSepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $konsul = KonsulpoliT::model()->findByPk($modPendaftaran->konsulpoli_id);
                
                
                $model->attributes = $_POST['ARSepT'];
                $model->tglsep = MyFormatter::formatDateTimeForDb($model->tglsep);
                
                $model->pendaftaran_id =  $_POST['pendaftaran_id'];
                $model->issep_internal = true;
                
                $model = $this->simpanSep_baru($model, $_POST['ARSepT'], $_POST['ARRujukanbpjsT'], $_POST['ARAsuransipasienM']);
                
                // var_dump($_POST, $model->attributes, $konsul->attributes, $model->attributes); die;
                
                // var_dump($this->septersimpan, $konsul->attributes); die;

                if ($model) {
                    if ($this->bridgingsep == false) {
                        $status = 'Data gagal disimpan karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
                    } else if ($this->septersimpan == false) {
                        $status = 'Data gagal disimpan karna kesalahan data / database!';
                    } else {
                        $status = 'Data SEP berhasil disimpan';
                    }
                    if ($this->septersimpan && $this->bridgingsep) {
                        $this->bridgingsep = true;

                        $modDaftar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
                        $lakalantas = $model->lakalantas;
                        $eksekutif = 0;
                        $cob = null;
                        $penjamin = $model->penjamin_id;
                        $lokasiLaka = null;
                        $noTelp= $model->no_telpon_peserta;
                        $user = null;
                        $peg_user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                        if(isset($peg_user)){
                                $user = $peg_user->nama_pegawai;
                        }
                        $tglKejadian = (!empty($model->tanggal_kejadian)? $model->tanggal_kejadian : "");
                        $keterangan = $model->catatansep;
                        $suplesi = (!empty($model->suplesi_jasaraharja)? $model->suplesi_jasaraharja : 0);
                        $noSepSuplesi= (!empty($model->no_suplesi)? $model->no_suplesi : "");
                        $kdPropinsi = (!empty($model->propinsi_lakalantas_id)? $model->propinsi_lakalantas_id : "");
                        $kdKabupaten = (!empty($model->kabupaten_lakalantas_id)? $model->kabupaten_lakalantas_id : "");
                        $kdKecamatan = (!empty($model->kecamatan_lakalantas_id)? $model->kecamatan_lakalantas_id : "");
                        $noSurat = $model->no_surat;
                        $kodeDPJP = $model->kode_dpjp;
                        $katarak = 0;
                        $bpjs = new BpjsVklaim();

                        // var_dump($modInfoKunjungan->attributes); die;

                        // if ($model->modPendaftaran)


                        if($modInfoKunjungan->instalasitujuan_id == Params::INSTALASI_ID_RD){
                            $model->tglrujukan= "";
                            $model->norujukan= "";
                            $model->ppkrujukan="";
                        }

                        // var_dump($model->attributes); die;

                        /*
                        $reqSep = array(
                            "metaData"=>array(
                                "code" => 200
                            ),
                            "response"=>array(
                                "sep"=>array(
                                    "noSep"=>"0301R0011117V000008",
                                    "penjamin"=>"-",
                                )
                            ),
                        );
                        */
                        $asalRujukan_data = $model->jnspelayanan;
                        if (!empty($modelUtama)) {
                            if ($modelUtama->norujukan == $model->norujukan) {
                                // $asalRujukan_data = 1;
                            }
                        }



                        $reqSep = json_decode($bpjs->create_sep_versi2($model->nokartuasuransi,$model->tglsep,$model->ppkpelayanan,$model->jnspelayanan,$model->klsrawat,$modDaftar->pasien->no_rekam_medik,$asalRujukan_data,$model->tglrujukan,$model->norujukan,$model->ppkrujukan,$model->catatansep,$model->diagnosaawal,$model->politujuan,$eksekutif,$cob,$lakalantas,$penjamin,$lokasiLaka,$noTelp,$user,$tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak, $model),true);
						// var_dump($reqSep);
                        
                        $pesansep = "";			
						$pesansep = "";			
                        $pesansep = "";			
                        if ($reqSep['metaData']['code']==200) {

                            
                            
                                $model->nosep = $reqSep['response']['sep']['noSep'];
                                $model->penjaminsep_kll = $reqSep['response']['sep']['penjamin'];
                                
                                // load sep internal
                                $res_list = json_decode($bpjs->search_sep_internal($model->nosep), true);
                                // var_dump($res_list); die;
                                $param_update = array(
                                    'nosep'=>$model->nosep,
                                    'penjaminsep_kll'=>$model->penjaminsep_kll,
                                );
                                if ($res_list['metaData']['code']==200) {
                                    $list = $res_list['response']['list'];
                                    $list = array_reverse($list);

                                    foreach ($list as $item) {
                                        if ($item['kdpolituj'] == $model->politujuan) {
                                            $param_update['nosepref'] = $item['nosepref'];
                                            $param_update['nosurat_rujukaninternal'] = $item['nosurat'];
                                            $param_update['tglrujukinternal'] = $item['tglrujukinternal'];
                                            $param_update['flaginternal'] = $item['flaginternal'];
                                            $param_update['opsikonsul'] = $item['opsikonsul'];
                                            $param_update['flagsep'] = strtolower($item['flagsep']) != "false";

                                            break;
                                        }
                                    }
                                }

                                // var_dump($param_update); die;
                                // die;

                                
                                SepT::model()->updateByPk($model->sep_id, $param_update);

                                $konsul->sep_id = $model->sep_id;
                                $konsul->save();

                                $this->bridgingsep = true;
                        } else {
                            $this->bridgingsep = false;
                            $pesansep = $reqSep['metaData']['message'];	
                        }
                        

                        if($this->bridgingsep == true){
                            $transaction->commit();
                            $this->logBpjs($model, $reqSep);
                            Yii::app()->user->setFlash('success', $status);
                            $this->redirect(array('create', 'id' => $model->sep_id, 'pendaftaran_id'=>$pendaftaran_id, 'konsulpoli_id'=>$konsul->konsulpoli_id, 'sukses' => 1));
                        }else{
                            $transaction->rollback();
                            $this->logBpjs($model, $reqSep);
                            Yii::app()->user->setFlash('error', "Data SEP gagal disimpan ! " . $pesansep);
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', $status);
                    }
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data SEP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modInfoKunjungan' => $modInfoKunjungan,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'modPengajuanApproval'=>$modPengajuanApproval
        ));
    }

    public function logBpjs($model, $reqSep) {
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
		$log->save();
	}

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->pageTitle = Yii::app()->name . " - Ubah SEP Rujukan Internal";
        $format = new MyFormatter();
        $model = $this->loadModel($id);
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modAsuransiPasien = new ARAsuransipasienM;
        $modAsuransiPasienBpjs = new ARAsuransipasienbpjsM;

        if (!empty($id)) {
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $model->sep_id));
            if (isset($modPendaftaran)) {
                $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
                $model->no_rekam_medik = $modPasien->no_rekam_medik;
                $model->carabayar_id = $modPendaftaran->carabayar_id;
                $model->penjamin_id = $modPendaftaran->penjamin_id;
            }
            $model->nopeserta = $model->nokartuasuransi;
            $model->kelastanggungan_id = $model->klsrawat;
            $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
            $modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
//            $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            $modRujukanBpjs->no_rujukan = $model->norujukan;
            $modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
        }
        $bpjs = new BpjsVklaim();
        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['ARSepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ARSepT'];
                $model->tglpulang = isset($_POST['ARSepT']['tglpulang']) ? $format->formatDateTimeForDb($_POST['ARSepT']['tglpulang']) : null;
                $reqSep = json_decode($bpjs->update_tanggal_pulang_sep($model->nosep, $model->tglpulang, $model->ppkpelayanan), true);
                if ($reqSep['metadata']['code'] == 200) {
                    $this->bridgingsep = true;
                    if ($model->save()) {
                        $this->septersimpan = true;
                    }
                } else {
                    $this->bridgingsep = false;
                }

                if ($this->septersimpan && $this->bridgingsep) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data SEP berhasil disimpan !");
                    $this->redirect(array('admin', 'id' => $model->sep_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data SEP gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data SEP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->pageTitle = Yii::app()->name . " - Hapus SEP Rujukan Internal";
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Memanggil dan menonaktifkan status 
     */
    public function actionNonActive($id) {
        $this->pageTitle = Yii::app()->name . " - Nonaktifkan SEP Rujukan Internal";
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            // $model->modelaktif = false;
            // if($model->save()){
            //	$data['sukses'] = 1;
            // }
            echo CJSON::encode($data);
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Surat SEP Rujukan Internal";
        $dataProvider = new CActiveDataProvider('ARSepT');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $this->pageTitle = Yii::app()->name . " - Surat SEP Rujukan Internal";
        $format = new MyFormatter();
        
        $model = new InformasisepinternalV;
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->tgl_awal_utama = date('Y-m-d');
        $model->tgl_akhir_utama = date('Y-m-d');
        if (isset($_GET['InformasisepinternalV'])) {
            $model->attributes = $_GET['InformasisepinternalV'];
            $model->is_sep = $_GET['InformasisepinternalV']['is_sep'];
            $model->tgl_awal = isset($_GET['InformasisepinternalV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['InformasisepinternalV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_akhir']) : null;
            $model->tgl_awal_utama = isset($_GET['InformasisepinternalV']['tgl_awal_utama']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_awal_utama']) : null;
            $model->tgl_akhir_utama = isset($_GET['InformasisepinternalV']['tgl_akhir_utama']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_akhir_utama']) : null;
        }
        $this->render($this->path_view . 'admin_new', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ARSepT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'assep-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $this->pageTitle = Yii::app()->name . " - Cetak SEP Rujukan Internal";
//        $model = new ARSepT;
//        $model->attributes = $_REQUEST['ARSepT'];
        $format = new MyFormatter;
        $model = new InformasisepinternalV;
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->tgl_awal_utama = date('Y-m-d');
        $model->tgl_akhir_utama = date('Y-m-d');
        if (isset($_GET['InformasisepinternalV'])) {
            $model->attributes = $_GET['InformasisepinternalV'];
            $model->is_sep = $_GET['InformasisepinternalV']['is_sep'];
            $model->tgl_awal = isset($_GET['InformasisepinternalV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['InformasisepinternalV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_akhir']) : null;
            $model->tgl_awal_utama = isset($_GET['InformasisepinternalV']['tgl_awal_utama']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_awal_utama']) : null;
            $model->tgl_akhir_utama = isset($_GET['InformasisepinternalV']['tgl_akhir_utama']) ? $format->formatDateTimeForDb($_GET['InformasisepinternalV']['tgl_akhir_utama']) : null;
        }
        $judulLaporan = 'Data SEP Internal';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) OR $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }
            $jenis_rujukan = isset($_GET['jenis_rujukan'])? $_GET['jenis_rujukan'] : 1;

//                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
//                    
//                }else{
//                    $server = 'http://'.$_GET['server'];
//                }

            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    print_r($bpjs->search_kartu($query));
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_nik($query));
                    break;
                case '3':
                    $query = $_GET['query'];
                    if($jenis_rujukan==1){
                        print_r($bpjs->search_rujukan_no_rujukan($query));
                    }else{
                        print_r($bpjs->search_rujukan_no_rujukan_rs($query));
                    }
                    break;
                case '4':
                    $query = $_GET['query'];
                    $tgl = isset($_GET['tgl']) ? MyFormatter::formatDateTimeForDb($_GET['tgl']) : null;
                    $suksesrujukan = false;
                    $dataRujukan = json_decode($bpjs->search_rujukan_rs_no_bpjs($query)); // search no rujukan by no kartu rs
                    if ($dataRujukan->metaData->code != 200) {
                        print_r($bpjs->search_rujukan_no_bpjs($query)); // search no rujukan pcare
                    } else {
                        print_r($bpjs->search_rujukan_rs_no_bpjs($query));
                    }
                    // $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($query));

                    // if(isset($dataRujukan->metaData)){
                    //     if($dataRujukan->metaData->message == 'OK'){
                    //         $suksesrujukan = true;
                    //     }
                    // }

                    // if($suksesrujukan){
                    //     print_r(json_encode($dataRujukan));
                    // }else{
                    //     print_r($bpjs->search_rujukan_rs_no_bpjs($query));
                    //     //print_r($bpjs->search_kartu($query, $tgl));
                    // }
                    break;
                // case '4':
                //     $query = $_GET['query'];
                //     $tgl = isset($_GET['tgl']) ? MyFormatter::formatDateTimeForDb($_GET['tgl']) : null;
                //     $suksesrujukan = false;
                    
                //     $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($query));
                    
                //     if(isset($dataRujukan->metaData)){
                //         if($dataRujukan->metaData->message == 'OK'){
                //             $suksesrujukan = true;
                //         }
                //     }
                    
                //     if($suksesrujukan){
                //         print_r(json_encode($dataRujukan));
                //     }else{
                //         print_r($bpjs->search_kartu($query, $tgl));
                //     }
                //     break;
                case '5':
                    $query = $_GET['query'];
                    $start = $_GET['start'];
                    $limit = $_GET['limit'];
                    print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
                    break;
                case '6':
                    $nokartu = $_GET['no_kartu'];
                    $tglsep = (!empty($_GET['tgl_sep'])?MyFormatter::formatDateTimeForDb($_GET['tgl_sep']):"");
                    $tglrujukan = $_GET['tgl_rujukan'];
                    $norujukan = $_GET['no_rujukan'];
                    $ppkrujukan = $_GET['ppk_rujukan'];
                    $ppkpelayanan = $_GET['ppk_pelayanan'];
                    $jnspelayanan = $_GET['jns_pelayanan'];
                    $catatan = $_GET['catatan'];
                    $diagawal = $_GET['diag_awal'];
                    $politujuan = $_GET['poli_tujuan'];
                    $klsrawat = $_GET['kls_rawat'];
                    $user = $_GET['user'];
                    $nomr = $_GET['no_mr'];
                    $notrans = $_GET['no_trans'];
                    print_r($bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans));
                    break;
                case '7':
                    $nosep = $_GET['nosep'];
                    $tglpulang = (!empty($_GET['tglpulang'])?MyFormatter::formatDateTimeForDb($_GET['tglpulang']):"");
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan));
                    break;
                case '8':
                    $nosep = $_GET['nosep'];
                    $notrans = $_GET['notrans'];
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan));
                    break;
                case '9':
                    $nosep = $_GET['nosep'];
                    $ppkpelayanan = $_GET['ppkpelayanan'];
                    print_r($bpjs->delete_transaksi($nosep, $ppkpelayanan));
                    break;
                case '10':
                    $nokartu = $_GET['nokartu'];
                    print_r($bpjs->riwayat_terakhir($nokartu));
                    break;
                case '11':
                    $nosep = $_GET['nosep'];
                    print_r($bpjs->detail_sep($nosep));
                    break;
                case '12':
                    $ppkpelayanan = $_GET['ppkrujukan'];
                    $start = $_GET['start'];
                    $limit = $_GET['limit'];
                    print_r($bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit));
                    break;
                case '13':
                    $noMR = $_GET['noMR'];
                    $noKartu = $_GET['noKartu'];
                    $tglSep = MyFormatter::formatDateTimeForDb($_GET['tglSep']);
                    $ppkPelayanan = $_GET['ppkPelayanan'];
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $klsRawat = $_GET['klsRawat'];
                    $asalRujukan = $_GET['asalRujukan'];
                    $tglRujukan = MyFormatter::formatDateTimeForDb($_GET['tglRujukan']);
                    $noRujukan = $_GET['noRujukan'];
                    $ppkRujukan = $_GET['ppkRujukan'];
                    $catatan = $_GET['catatan'];
                    $diagAwal = $_GET['diagAwal'];
                    $tujuan = $_GET['tujuan'];
                    $eksekutif = $_GET['eksekutif'];
                    $cob = $_GET['cob'];
                    $lakaLantas = $_GET['lakaLantas'];
                    $penjamin = $_GET['penjamin'];
                    $lokasiLaka = $_GET['lokasiLaka'];
                    $noTelp = $_GET['noTelp'];
                    $user = $_GET['user'];
                    
                    $tglKejadian = MyFormatter::formatDateTimeForDb($_GET['tglKejadian']);
                    $keterangan = $_GET['keterangan'];
                    $suplesi = $_GET['suplesi'];
                    $noSepSuplesi = $_GET['noSepSuplesi'];
                    $kdPropinsi = $_GET['kdPropinsi'];
                    $kdKabupaten = $_GET['kdKabupaten'];
                    $kdKecamatan = $_GET['kdKecamatan'];
                    $noSurat = $_GET['noSurat'];
                    $kodeDPJP = $_GET['kodeDPJP'];
                    $katarak = $_GET['katarak'];

                    print_r($bpjs->create_sep_new($noKartu,$tglSep,$ppkPelayanan,$jnsPelayanan,$klsRawat,$noMR,$asalRujukan,$tglRujukan,$noRujukan,$ppkRujukan,$catatan,$diagAwal,$tujuan,$eksekutif,$cob,$lakaLantas,$penjamin,$lokasiLaka,$noTelp,$user,$tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak));
                    break;
                case '14':
                    $noMR = $_GET['noMR'];
                    $noKartu = $_GET['noKartu'];
                    $tglSep = MyFormatter::formatDateTimeForDb($_GET['tglSep']);
                    $ppkPelayanan = $_GET['ppkPelayanan'];
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $klsRawat = $_GET['klsRawat'];
                    $asalRujukan = $_GET['asalRujukan'];
                    $tglRujukan = MyFormatter::formatDateTimeForDb($_GET['tglRujukan']);
                    $noRujukan = $_GET['noRujukan'];
                    $ppkRujukan = $_GET['ppkRujukan'];
                    $catatan = $_GET['catatan'];
                    $diagAwal = $_GET['diagAwal'];
                    $tujuan = $_GET['tujuan'];
                    $eksekutif = $_GET['eksekutif'];
                    $cob = $_GET['cob'];
                    $lakaLantas = $_GET['lakaLantas'];
                    $penjamin = $_GET['penjamin'];
                    $lokasiLaka = $_GET['lokasiLaka'];
                    $noTelp = $_GET['noTelp'];
                    $user = $_GET['user'];
                    $noSep = $_GET['noSep'];
                    
                    $tglKejadian = $_GET['tglKejadian'];
                    $keterangan = $_GET['keterangan'];
                    $suplesi = $_GET['suplesi'];
                    $noSepSuplesi = $_GET['noSepSuplesi'];
                    $kdPropinsi = $_GET['kdPropinsi'];
                    $kdKabupaten = $_GET['kdKabupaten'];
                    $kdKecamatan = $_GET['kdKecamatan'];
                    $noSurat = $_GET['noSurat'];
                    $kodeDPJP = $_GET['kodeDPJP'];
                    $katarak = $_GET['katarak'];
                    
                    print_r($bpjs->update_sep_new($noSep,$noKartu,$tglSep,$ppkPelayanan,$jnsPelayanan,$klsRawat,$noMR,$asalRujukan,$tglRujukan,$noRujukan,$ppkRujukan,$catatan,$diagAwal,$tujuan,$eksekutif,$cob,$lakaLantas,$penjamin,$lokasiLaka,$noTelp,$user,$tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak));
                    break;
                case '15':
                    $tglPulang = MyFormatter::formatDateTimeForDb($_GET['tglPulang']);
                    $user = $_GET['user'];
                    $noSep = $_GET['noSep'];
                    
                    print_r($bpjs->update_sep_pulang($noSep,$tglPulang,$user));
                    break;
                case '16':
                   $query = $_GET['kodeppkpelayanan'];
                    $query = explode(" ",$query);
                    $query = $query[0];
                    $query1 = $_GET['jenis_rujukan'];
                    $query1 = explode(" ",$query1);
                    $query1 = $query1[0];
                    $start = 1;
                    $limit = 10;
                    if($query!='' && $query1==''){
                        $query = $query;
                    }else if($query!='' && $query1!=''){
                        $query = $query.'/'.$query1;
                    }else if($query=='' && $query1!=''){
                        $query = $query.'/'.$query1;
                    }
                    print_r($bpjs->fasilitas_kesehatan($query,$start, $limit) );
                    break;
                case '17':
                    $query1 = $_GET['katakunci1'];
                    $query2 = MyFormatter::formatDateTimeForDb($_GET['katakunci2']);
                    $query3 = (!empty($_GET['katakunci3'])?$_GET['katakunci3']:"");
                    $query = $query1 ."/tglPelayanan/". $query2 ."/Spesialis/" .$query3;
                    $start = 1;
                    $limit = 10;
                    print_r( $bpjs->search_dpjp($query,$start, $limit) );
                    break;
                case '18':
                    $query = $_GET['query'];
                    $jenisfaskes = $_GET['jenisfaskes'];
                    if($jenisfaskes == '2'){
                        print_r( $bpjs->search_rujukan_rs_multi($query) );
                    }else{
                        print_r( $bpjs->search_rujukan_pcare_multi($query) );
                    }
                    break;
                case '19':
                    $query = $_GET['query'];
                    
                    $str = $bpjs->search_no_surat_kontrol($query);
                    if (!empty($str)) {
                        $json = CJSON::decode($str);
                        if (!empty($json['response']) && $json['response'] != "") {
                            $json['response']['poli_tujuan'] = "-";
                            $json['response']['sep']['peserta']['tglLahir'] = date('d/m/Y', strtotime($json['response']['sep']['peserta']['tglLahir']));
                            $json['response']['sep']['tglSep'] = date('d/m/Y', strtotime($json['response']['sep']['tglSep']));
                            $json['response']['tglTerbit'] = date('d/m/Y', strtotime($json['response']['tglTerbit']));
                            // var_dump($json); die;
                            
                            $tgl_rencana =  $json['response']['tglRencanaKontrol'];
                            
                            $date_rencana = new DateTime($tgl_rencana);
                            $date_sekarang = new DateTime(date('Y-m-d'));
                            
                            $status = 0;
                            if ($date_sekarang > $date_rencana) {
                                $status = 1;
                            } else if ($date_sekarang < $date_rencana) {
                                $status = -1;
                            }
                            
                            $json['response']['status_kontrol'] = $status;
                            $json['response']['tglRencanaKontrol'] = date('d/m/Y', strtotime($json['response']['tglRencanaKontrol']));
                            
                            $ruangan = RuanganM::model()->findByAttributes(array(
                                'kode_bpjs'=>$json['response']['poliTujuan'],
                                'ruangan_aktif'=>true,
                            ));
                            
                            if (!empty($ruangan)) {
                                $json['response']['poli_tujuan'] = $ruangan->ruangan_nama;
                            }
                            
                            
                        }
                        
                        print_r(CJSON::encode($json));
                    }
                    
                    break;
                case '99':
                    $bpjs->identity_magic();
                    break;
                case '100':
                    print_r($bpjs->help());
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    /**
     * Load autocomplete asuransi 
     * @throws CHttpException
     */
    public function actionAutocompleteAsuransi() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nopeserta = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
            $criteria->addCondition('penjamin_id=' . $penjamin_id);
            $criteria->addCondition('asuransipasien_aktif is true');
            if (empty($pasien_id)) {
//                $criteria->addCondition('pasien_id is null');
            } else {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            $criteria->order = 'namapemilikasuransi';
            $criteria->limit = 5;
            $models = ARAsuransipasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nopeserta;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Simpan SEP 
     * @param ARSepT $model
     * @param type $postSep
     * @param type $modRujukanBpjs
     * @param type $modAsuransiPasien
     * @return \ARSepT
     */
    public function simpanSep($model, $postSep, $modRujukanBpjs, $modAsuransiPasien) {
        $jumlah_diagnosa = count((array)$modRujukanBpjs['diagnosa_rujukan']);
        $diagnosa = '';
        for ($i = 0; $i < $jumlah_diagnosa; $i++) {
            $diagnosa[$i] = $modRujukanBpjs['diagnosa_rujukan'][$i];
        }

        $diagnosa = implode(',', $diagnosa);
        $format = new MyFormatter();
        $reqSep = null;
        $model = new ARSepT;
        $bpjs = new BpjsVklaim();

        $model->attributes = $postSep;
        $model->tglsep = date('Y-m-d H:i:s');
        $model->nokartuasuransi = $postSep['nokartuasuransi'];
        $model->tglrujukan = $format->formatDateTimeForDb($modRujukanBpjs['tanggal_rujukan']);
        $model->norujukan = $modRujukanBpjs['no_rujukan'];
        $model->ppkrujukan = $postSep['ppkrujukan'];
        $model->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
        $model->jnspelayanan = $postSep['jnspelayanan'];
        $model->catatansep = $postSep['catatansep'];
        $model->diagnosaawal = isset($diagnosa) ? $diagnosa : '';
        $model->politujuan = $model->politujuan;
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($postSep['klsrawat']));
        $kelastanggungan = KelaspelayananM::model()->find($criteria);
        $kelastanggungan = isset($kelastanggungan) ? $kelastanggungan->kelaspelayanan_id : null;
        $model->klsrawat = $kelastanggungan;
        $model->tglpulang = isset($modRujukanBpjs['tanggal_rujukan']) ? $format->formatDateTimeForDb($modRujukanBpjs['tanggal_rujukan']) : date('Y-m-d H:i:s)');
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if (isset($_POST['isSepManual'])) {
            if ($_POST['isSepManual'] == false) {
                
            } else {
                $model->nosep = $_POST['ARSepT']['nosep'];
                if ($model->save()) {
                    $modPasien = ARPasienM::model()->findByAttributes(array('no_rekam_medik' => $postSep['no_rekam_medik']));
                    if (isset($modPasien)) {
                        $pasien_id = $modPasien->pasien_id;
                        // $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pasien_id' => $pasien_id), array('order' => 'pendaftaran_id DESC'));
                        // $modPendaftaran->sep_id = $model->sep_id;
                        // $modPendaftaran->update();
                    }
                    $this->septersimpan = true;
                }
            }
        } else {
            $modPoli = RuanganM::model()->findByPk($model->politujuan);
            $model->politujuan = (!empty($modPoli->kode_ruanganpoli) ? $modPoli->kode_ruanganpoli : $model->politujuan);
            $notrans = '';
            $reqSep = json_decode($bpjs->create_sep($model->nokartuasuransi, $model->tglsep, $model->tglrujukan, $model->norujukan, $model->ppkrujukan, $model->ppkpelayanan, $model->jnspelayanan, $model->lakalantas, $model->catatansep, $model->diagnosaawal, $model->politujuan, $model->klsrawat, $model->create_loginpemakai_id, $model->no_rekam_medik, $notrans), true);
            if ($reqSep['metadata']['code'] == 200) {
                $this->bridgingsep = true;
                $model->nosep = $reqSep['response'];
                if ($model->save()) {
                    $modPasien = ARPasienM::model()->findByAttributes(array('no_rekam_medik' => $postSep['no_rekam_medik']));
                    if (isset($modPasien)) {
                        $pasien_id = $modPasien->pasien_id;
                        // $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pasien_id' => $pasien_id), array('order' => 'pendaftaran_id DESC'));
                        // $modPendaftaran->sep_id = $model->sep_id;
                        // $modPendaftaran->update();
                    }
                    $this->septersimpan = true;
                } else {
                    $this->septersimpan = false;
                }
            } else {
                $this->bridgingsep = false;
            }
        }
        return $model;
    }
    
    /**
     * Simpan SEP baru 
     * @param type $model
     * @param type $postSep
     * @param type $modRujukanBpjs
     * @param type $modAsuransiPasien
     * @return type
     */
    public function simpanSep_baru($model, $postSep, $modRujukanBpjs, $modAsuransiPasien) {
        $format = new MyFormatter();
        $bpjs = new BpjsVklaim();
        $ok = true;
        $model->attributes = $postSep;
        // $model->tglsep = $postSep['tglsep'];
        $model->nokartuasuransi = $postSep['nopeserta'];
        $model->tglsep = $format->formatDateTimeForDb($model->tglsep);
        $model->tglrujukan = $format->formatDateTimeForDb($modRujukanBpjs['tanggal_rujukan']);
        $model->norujukan = $modRujukanBpjs['no_rujukan'];
        $model->ppkrujukan = $postSep['ppkrujukan'];
        $model->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
        
        $modDaftar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $modKelas = KelaspelayananM::model()->findByPk($modDaftar->kelaspelayanan_id); 
        $model->jnspelayanan = $model->jnspelayanan;

        $model->catatansep = $postSep['catatansep'];
        $model->klsrawat = (isset($postSep['klsrawat'])?$postSep['klsrawat']:null); 
//        $model->klsrawat = ($model->jnspelayanan==1)? KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id'=>$_POST['ARSepT']['klsrawat']))->kelaspelayanan_id : KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id'=>3))->kelaspelayanan_id;
        $model->kelasrawat_kode = $model->klsrawat;
        $model->hakkelas_kode = (!empty($modAsuransiPasien['kelastanggunganasuransi_id'])) ? KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id'=>$modAsuransiPasien['kelastanggunganasuransi_id']))->kelaspelayanan_id : KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id'=>$modKelas->kelaspelayanan_id));
        $model->jenisrujukan_kode = $postSep['jenispeserta_id'];
        $model->jenisrujukan_nama = ($model->jenisrujukan_kode==1)? "PCare" : "Rumah Sakit";
        $model->no_rekam_medik = !empty($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : $modDaftar->pasien->no_rekam_medik;
//        $model->jenispeserta_id = $postSep['jenispeserta_id'];
        $model->is_polieksekutif = $postSep['is_polieksekutif'];
        $model->poli_eksekutif = $postSep['is_polieksekutif'];
        $model->is_cob = $postSep['is_cob'];
        $model->cob = $postSep['is_cob'];
        $model->is_lakalantas = isset($postSep['is_lakalantas'])? $postSep['is_lakalantas'] : 0;
        $model->lakalantas = isset($postSep['is_lakalantas'])? $postSep['is_lakalantas'] : 0;
        $model->penjamin_lakalantas = isset($postSep['penjamin_lakalantas']) ? $postSep['penjamin_lakalantas'] : null;
        $model->lokasi_lakalantas = isset($postSep['lokasi_lakalantas'])? $postSep['lokasi_lakalantas'] : null;
        $model->no_telpon_peserta = $postSep['no_telpon_peserta'];
        $model->pembuat_sep = $postSep['pembuat_sep'];
        $model->namaasuransi_cob = $postSep['namaasuransi_cob'];
        $model->no_asuransi_cob = $postSep['no_asuransi_cob'];
        $model->nama_diagnosaawal = $postSep['nama_diagnosaawal'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->tanggal_kejadian = !empty($postSep['tanggal_kejadian'])? $format->formatDateTimeForDb($postSep['tanggal_kejadian']): null;
        $model->nosep = "-";

        $model->propinsi_lakalantas_id = isset($postSep['propinsi_lakalantas_id'])? $postSep['propinsi_lakalantas_id'] : null;
        $model->kabupaten_lakalantas_id = isset($postSep['kabupaten_lakalantas_id'])? $postSep['kabupaten_lakalantas_id'] : null;
        $model->kecamatan_lakalantas_id = isset($postSep['kecamatan_lakalantas_id'])? $postSep['kecamatan_lakalantas_id'] : null;
        $model->propinsi_lakalantas_nama = isset($postSep['propinsi_lakalantas_nama'])? $postSep['propinsi_lakalantas_nama'] : null;
        $model->kabupaten_lakalantas_nama = isset($postSep['kabupaten_lakalantas_nama'])? $postSep['kabupaten_lakalantas_nama'] : null;
        $model->kecamatan_lakalantas_nama = isset($postSep['kecamatan_lakalantas_nama'])? $postSep['kecamatan_lakalantas_nama'] : null;
        $model->issep_internal = true;

        // var_dump($model->attributes); die;

        if ($model->save()) {
            /*
            $modPasien = ARPasienM::model()->findByAttributes(array('no_rekam_medik' => $model->no_rekam_medik));
            if (isset($modPasien)) {
                $pasien_id = $modPasien->pasien_id;
                $modPendaftaran = ARPendaftaranT::model()->findByPk($modDaftar->pendaftaran_id);
                $modAsuransiPasien = ARAsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                if(!empty($modPendaftaran->asuransipasien_id)){
                    $modAsuransiPasien = $modAsuransiPasien;
                    $modAsuransiPasien->attributes = $_POST['ARAsuransipasienM'];
                    $modAsuransiPasien->pasien_id = $modPasien->pasien_id;
                    $modAsuransiPasien->tglcetakkartuasuransi = !empty($_POST['ARAsuransipasienM']['tglcetakkartuasuransi'])? MyFormatter::formatDateTimeForDb($_POST['ARAsuransipasienM']['tglcetakkartuasuransi']) : null;
                    $modAsuransiPasien->nopeserta = $model->nokartuasuransi;
                    $modAsuransiPasien->nokartuasuransi = $_POST['ARAsuransipasienM']['nokartuasuransi'];
                    $modAsuransiPasien->kodefeskestk1 = $_POST['ARSepT']['ppkrujukan'];
                    $modAsuransiPasien->nama_feskestk1 = $_POST['ARSepT']['ppkrujukan_nama'];
                    $modAsuransiPasien->carabayar_id = $modPendaftaran->carabayar_id;
                    $modAsuransiPasien->penjamin_id = $modPendaftaran->penjamin_id;
                    $modAsuransiPasien->update_time = date('Y-m-d H:i:s');
                    $modAsuransiPasien->update_loginpemakai_id = Yii::app()->user->id;
                    $modAsuransiPasien->jenispeserta_bpjs = (isset($_POST['ARAsuransipasienM']['jenispeserta_bpjs'])?$_POST['ARAsuransipasienM']['jenispeserta_bpjs']:null);
                    $modAsuransiPasien->jenispersertakode_bpjs = (isset($_POST['ARAsuransipasienM']['jenispersertakode_bpjs'])?$_POST['ARAsuransipasienM']['jenispersertakode_bpjs']:null);
                }else{
                    $modAsuransiPasien = new ARAsuransipasienM;
                    $modAsuransiPasien->attributes = $_POST['ARAsuransipasienM'];
                    $modAsuransiPasien->pasien_id = $modPasien->pasien_id;
                    $modAsuransiPasien->carabayar_id = $modPendaftaran->carabayar_id;
                    $modAsuransiPasien->nopeserta = !empty($_POST['ARAsuransipasienM']['nopeserta']) ? $_POST['ARAsuransipasienM']['nopeserta'] : $_POST['ARSepT']['nopeserta'];
                    $modAsuransiPasien->nokartuasuransi = !empty($_POST['ARAsuransipasienM']['nokartuasuransi']) ? $_POST['ARAsuransipasienM']['nokartuasuransi'] : $modAsuransiPasien->nopeserta; 
                    $modAsuransiPasien->tglcetakkartuasuransi = !empty($_POST['ARAsuransipasienM']['tglcetakkartuasuransi'])? MyFormatter::formatDateTimeForDb($_POST['ARAsuransipasienM']['tglcetakkartuasuransi']) : null;
                    $modAsuransiPasien->penjamin_id = $modPendaftaran->penjamin_id;
                    $modAsuransiPasien->kelastanggunganasuransi_id = $modPendaftaran->kelaspelayanan_id;
                    $modAsuransiPasien->kodefeskestk1 = $_POST['ARSepT']['ppkrujukan'];
                    $modAsuransiPasien->nama_feskestk1 = $_POST['ARSepT']['ppkrujukan_nama'];
                    $modAsuransiPasien->create_time = date('Y-m-d H:i:s');
                    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
                    $modAsuransiPasien->jenispeserta_bpjs = (isset($_POST['ARAsuransipasienM']['jenispeserta_bpjs'])?$_POST['ARAsuransipasienM']['jenispeserta_bpjs']:null);
                    $modAsuransiPasien->jenispersertakode_bpjs = (isset($_POST['ARAsuransipasienM']['jenispersertakode_bpjs'])?$_POST['ARAsuransipasienM']['jenispersertakode_bpjs']:null);
                }
                $modAsuransiPasien->save(); 
                                        
                $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
                $modPendaftaran->sep_id = $model->sep_id;
                $modPendaftaran->update();
            }
            */
            $this->septersimpan = true;
        } else {
            $this->septersimpan = false;
        }

        return $model;
    }

    /**
     * untuk menampilkan pasien lama dari autocomplete
     * 1. no_rekam_medik
     */
    public function actionAutocompleteInfoPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition('ispasienluar = FALSE');
            $criteria->order = 'no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = PasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal[$i]['value'] = $model->no_rekam_medik;
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * set dropdown penjamin pasien dari carabayar_id
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
            if ($encode) {
                echo CJSON::encode($penjamin);
            } else {
                if (empty($carabayar_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                    if (count((array)$penjamin) > 1) {
                        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    foreach ($penjamin as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Load data rujukan
     * @param type $encode
     * @param type $namaModel
     */
    public function actionGetRujukanDari($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

            if ($encode) {
                echo CJSON::encode($rujukandari);
            } else {
                if (empty($asalrujukan_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
                    $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
                    foreach ($rujukandari as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Cetak SEP 
     * @param type $sep_id
     */
    public function actionPrintSep($sep_id) {
        $this->pageTitle = Yii::app()->name . " - Cetak Surat Eligibilitas Peserta";
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modSep = ARSepT::model()->findByPk($sep_id);
        if (isset($modSep->print_ke) && !empty($modSep->print_ke)) {
            $modSep->print_ke++;
            $modSep->update(array('print_ke'));
        }
        $modInfoKunjungan = InformasisepinternalV::model()->findByAttributes(array(
            'sep_id'=>$sep_id,
        ));
        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi),array('order'=>'asuransipasien_id DESC'));
        $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = ARRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modPendaftaran = ARPendaftaranT::model()->findByPk($modInfoKunjungan->pendaftaran_id);        
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
        
        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
        $this->render($this->path_view . 'printSep_baru', array(
            'format' => $format,
            'modSep' => $modSep,
            'judul_print' => $judul_print,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJenisPeserta' => $modJenisPeserta,
            'modRujukan' => $modRujukan,
        ));
    }

    /**
     * Laporan SEP 
     * @param type $sep_id
     */
    public function actionLihatLaporanSEP($sep_id) {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }

        $format = new MyFormatter;
        $bpjs = new BpjsVklaim();
        $modInacbg = new ARInacbgT();
        $modLaporanSep = new ARLaporansepR();
        $modSep = ARSepT::model()->findByPk($sep_id);
        $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        $laporanSep = ARLaporansepR::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        if (count((array)$laporanSep) <= 0) {
            $reqSep = json_decode($bpjs->create_laporan_sep($modSep->nosep), true);
            if ($reqSep['metadata']['code'] == 200) {
                $this->bridginglaporansep = true;
                $modLaporanSep->inacbg_id = null;
                $modLaporanSep->pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
                $modLaporanSep->sep_id = $modSep->sep_id;
                $modLaporanSep->laporansep_tgl = date('Y-m-d');
                $modLaporanSep->kdinacbg = 'A';
                $modLaporanSep->kdseverity = 'B';
                $modLaporanSep->nminacbg = 'C';
                $modLaporanSep->bytagihan = 0;
                $modLaporanSep->bytarifgruper = 0;
                $modLaporanSep->bytarifrs = 0;
                $modLaporanSep->bytopup = 0;
                $modLaporanSep->jnspelayanan = $modSep->jnspelayanan;
                $modLaporanSep->nomr = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_rekam_medik : "";
                $modLaporanSep->nosep = $modSep->nosep;
                $modLaporanSep->nama = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->nama_pasien : "";
                $modLaporanSep->nokartu = $modSep->nokartuasuransi;
                $modLaporanSep->kdstatsep = 'D';
                $modLaporanSep->nmstatsep = 'E';
                $modLaporanSep->tglpulang = $modSep->tglpulang;
                $modLaporanSep->tglsep = $modSep->tglsep;
                $modLaporanSep->create_time = date('Y-m-d H:i:s');
                $modLaporanSep->login_pemakai_id = Yii::app()->user->id;
                $modLaporanSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
                if ($modLaporanSep->save()) {
                    $this->laporanseptersimpan = true;
                } else {
                    $this->laporanseptersimpan = false;
                }
            } else {
                $this->bridgingsep = false;
            }
        }
        $judulLaporan = 'LAPORAN SEP';

        $this->render($this->path_view . 'laporanSep', array(
            'format' => $format,
            'modSep' => $modSep,
            'laporanSep' => $laporanSep,
            'judulLaporan' => $judulLaporan
        ));
    }

    /**
     * Ubah Tanggal Pulang
     *  @param type $sep_id
     */
    public function actionUbahTanggalPulang($sep_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modSep = ARSepT::model()->findByPk($sep_id);
        $bpjs = new BpjsVklaim();
        $status = '';
        if (isset($_POST['ARSepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modSep->attributes = $_POST['ARSepT'];
                $modSep->tglpulang = $format->formatDateTimeForDb($_POST['ARSepT']['tglpulang']);
                $attributes = array('tglpulang' => $modSep->tglpulang);
                $reqSep = json_decode($bpjs->update_tanggal_pulang_sep($modSep->nosep, $modSep->tglpulang, $modSep->ppkpelayanan), true);
                if ($reqSep['metadata']['code'] == 200) {
                    $this->bridgingsep = true;
                    if ($modSep->update()) {
                        $this->updatesep = true;
                    }
                } else {
                    $this->bridgingsep = false;
                }

                if ($this->bridgingsep == false) {
                    $status = 'Data gagal diubah karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
                } else if ($this->updatesep == false) {
                    $status = 'Data gagal diubah karna kesalahan data / database!';
                } else {
                    $status = 'Data SEP berhasil diubah';
                }
                if ($this->updatesep && $this->bridgingsep) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Berhasil</strong>" . $status);
                } else {
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong>' . $status);
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . '_formUbahTanggal', array(
            'modSep' => $modSep,
        ));
    }

    /**
     * Get data SEP
     */
    public function actionGetDataSep() {
        if (Yii::app()->request->isAjaxRequest) {
            $sep_id = $_POST['sep_id'];
            $model = ARSepT::model()->findByPk($sep_id);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal["tglpulang"] = (!empty($model->tglpulang) ? date("d/m/Y H:i:s", strtotime($model->tglpulang)) : null);
            }
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    /**
     * Menghapus data SEP
     * @param type $id
     */
    public function actionHapusSEP($id) {
        $this->pageTitle = Yii::app()->name . " - Hapus Surat Eligibilitas Peserta";
        if (Yii::app()->request->isAjaxRequest) {


            $data['sukses'] = 0;
            $data['status'] = '';
            $model = $this->loadModel($id);


            $modUser = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
            $nama = (isset($modUser->user_pemakai_bpjs)&&!empty($modUser->user_pemakai_bpjs))? $modUser->user_pemakai_bpjs : $modUser->nama_pemakai ;
            $bpjs = new BpjsVklaim();
            $transaction = Yii::app()->db->beginTransaction();
            $reqSep = json_decode($bpjs->delete_sep_internal($model->nosep, $model->nosurat_rujukaninternal, $model->tglrujukinternal, $model->politujuan, $nama), true);
            // $reqSep = json_decode($bpjs->delete_transaksi_sep($model->nosep, $nama), true);
            if ($reqSep['metaData']['code'] == 200) {
                $this->bridgingsep = true;
                KonsulpoliT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $model->sep_id);
                if ($model->delete()) {
                    $this->deletesep = true;
                    $transaction->commit();
                }
            } else {
                $this->bridgingsep = false;
                $transaction->rollback();
            }

            if ($this->bridgingsep == false) {
                $data['status'] = 'Data gagal dihapus karena '.$reqSep['metaData']['message'];
            } else {
                $data['status'] = 'Data SEP berhasil dihapus';
            }

            echo CJSON::encode($data);
        }
    }

    /**
     * periksa SEP
     * @param type $id
     */
    public function actionPeriksaSEP($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['status'] = '';
            $model = $this->loadModel($id);
            $bpjs = new BpjsVklaim();
            $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $model->sep_id));
            if (isset($modPendaftara)) {
                $notrans = $modPendaftaran->no_pendaftaran;
            } else {
                $notrans = '';
            }
            $reqSep = json_decode($bpjs->mapping_trans($model->nosep, $notrans, $model->ppkpelayanan), true);
            if ($reqSep['metadata']['code'] == 200) {
                $this->bridgingsep = true;
            } else {
                $this->bridgingsep = false;
            }

            if ($this->bridgingsep == false) {
                $data['status'] = 'Data gagal dilakukan transaksi mapping karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
            } else {
                $data['status'] = 'Data SEP berhasil dilakukan transaksi maaping';
            }

            echo CJSON::encode($data);
        }
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
    public function actionGetDataInfoPasien() {
        if (Yii::app()->request->isAjaxRequest) {
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
            } else if($instalasi_id == Params::INSTALASI_ID_HD || $instalasi_id == Params::INSTALASI_ID_HD_GA) {
                 $model = InfokunjunganhdV::model()->find($criteria);
            } else if(in_array($instalasi_id, $modelSep->InstalasiPelayananRJ())) {
                $model = InfokunjunganrjV::model()->find($criteria);
            } else if(in_array($instalasi_id, $modelSep->InstalasiPelayananRI())) {
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
            
            $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $returnVal["ruangan_kode_bpjs"] = $modRuangan->kode_bpjs;

            $modpasien = PasienM::model()->findByPk($modpend->pasien_id);
            $returnVal["no_mobile_pasien"] = $modpasien->no_mobile_pasien;

            $nokartu = "";
            if(!empty($modpend->sep_id)){
                $sepT = SepT::model()->findByAttributes(array('sep_id'=>$modpend->sep_id));
                if(!empty($sepT)){
                    $nokartu = $sepT->nokartuasuransi;
                }
            }
            $returnVal["no_peserta"] = $nokartu;

            $nosuratspri = "";
            $spri = SuratperintahranapT::model()->findByAttributes(array(
            'pendaftaran_id'=>$modpend->pendaftaran_id,
            ));

            if(!empty($spri)){
                $nosuratspri = $spri->nomorspri_bpjs;  
            }
            $returnVal["nomorspri_bpjs"] = $nosuratspri;

            
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Set form poli 
     */
    public function actionSetFormPoli() {
        if (Yii::app()->request->isAjaxRequest) {
            $poliList = $_POST['poliList'];
            $form = '';
            $pesan = '';
            if (count((array)$poliList) > 0) {
                foreach ($poliList AS $i => $poli) {
                    $kdPoli = $poli['kode'];
                    $nmPoli = $poli['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_politujuan').val('".$kdPoli."');$('#dialogPoli').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kdPoli."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmPoli."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Set form diagnosa
     */
    public function actionSetFormDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $diagnosaList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count((array)$diagnosaList) > 0) {
                foreach ($diagnosaList AS $i => $diagnosa) {
                    $kddiagnosa = $diagnosa['kode'];
                    $nmdiagnosa = $diagnosa['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_diagnosaawal').val('".$kddiagnosa."');$('#ARSepT_nama_diagnosaawal').val('" . $nmdiagnosa . "');$('#dialogDiagnosaBpjs').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kddiagnosa."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmdiagnosa."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Set form faskes
     */
    public function actionSetFormFaskes() {
        if (Yii::app()->request->isAjaxRequest) {
            $faskesList = $_POST['faskesList'];
            $form = '';
            $pesan = '';
            if (count((array)$faskesList) > 0) {
                foreach ($faskesList AS $i => $faskes) {
                    $kdfaskes = $faskes['kode'];
                    $nmfaskes = $faskes['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_ppkrujukan').val('".$kdfaskes."');$('#ARSepT_ppkrujukan_nama').val('".$nmfaskes."');$('#dialogPpk').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kdfaskes."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmfaskes."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Set form dokter
     */
    public function actionSetFormDokter() {
        if(Yii::app()->request->isAjaxRequest) { 
            $dokterList = $_POST['diagnosaList'];
			$form = '';
			$pesan = '';
            if(count((array)$dokterList) > 0){
                foreach($dokterList AS $i => $dokter){
                    $kode = $dokter['kode'];
                    $nama = $dokter['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_nama_dpjp').val('".$nama."');$('#ARSepT_kode_dpjp').val('".$kode."');$('#dialogDpjp').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kode."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nama."</span>
                        </td>
                    </tr>";
                }
            }else{
                $pesan = "Data tidak ada!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
    
    /**
     * Load form suplesi 
     */
    public function actionSetFormSuplesi() {
        if (Yii::app()->request->isAjaxRequest) {
            $suplesiList = $_POST['suplesiList'];
            $form = '';
            $pesan = '';
            if (count((array)$suplesiList) > 0) {
                foreach ($suplesiList AS $i => $suplesi) {
                    $no_register = $suplesi['noRegister'];
                    $noSep = $suplesi['noSep'];
                    $noSepAwal = $suplesi['noSepAwal'];
                    $noSuratJaminan = $suplesi['noSuratJaminan'];
                    $tglKejadian = $suplesi['tglKejadian'];
                    $tglSep = $suplesi['tglSep'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_no_suplesi').val('".$noSep."');$('#dialogSuplesi').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli'>".$no_register."</span>
                        </td>
                        <td>
                            <span id='nmPoli'>".$noSep."</span>
                        </td>
                        <td>
                            <span id='nmPoli'>".$noSepAwal."</span>
                        </td>
                        <td>
                            <span id='nmPoli'>".$noSuratJaminan."</span>
                        </td>
                        <td>
                            <span id='nmPoli'>".$tglKejadian."</span>
                        </td>
                        <td>
                            <span id='nmPoli'>".$tglSep."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Load dropdown propinsi 
     */
    public function actionSetDropdownPropinsi() {
        if (Yii::app()->request->isAjaxRequest) {
            $propinsiList = $_POST['propinsiList'];
            $form = '<option value="">-- Pilih Propinsi --</option>';
            $pesan = '';
            if (count((array)$propinsiList) > 0) {
                foreach ($propinsiList AS $i => $propinsi) {
                    $kode = $propinsi['kode'];
                    $nama = $propinsi['nama'];
                    $form .= 
                    "
                        <option value='".$kode."'>".$nama."</option>
                    ";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Load data kabupaten
     */
    public function actionSetDropdownKabupaten() {
        if (Yii::app()->request->isAjaxRequest) {
            $propinsiList = $_POST['propinsiList'];
            $form = '<option value="">-- Pilih Kabupaten --</option>';
            $pesan = '';
            if (count((array)$propinsiList) > 0) {
                foreach ($propinsiList AS $i => $propinsi) {
                    $kode = $propinsi['kode'];
                    $nama = $propinsi['nama'];
                    $form .= 
                    "
                        <option value='".$kode."'>".$nama."</option>
                    ";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Set dropdown kecamatan 
     */
    public function actionSetDropdownKecamatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $kabupatenList = $_POST['kabupatenList'];
            $form = '<option value="">-- Pilih Kecamatan --</option>';
            $pesan = '';
            if (count((array)$kabupatenList) > 0) {
                foreach ($kabupatenList AS $i => $kabupaten) {
                    $kode = $kabupaten['kode'];
                    $nama = $kabupaten['nama'];
                    $form .= 
                    "
                        <option value='".$kode."'>".$nama."</option>
                    ";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    /**
     * Update SEP 
     * @param type $sep_id
     * @param type $no_rekam_medik
     */
    public function actionUpdateSEP($sep_id,$no_rekam_medik){
        $this->pageTitle = Yii::app()->name . " - Ubah Surat Eligibilitas Peserta";
        $this->layout = '//layouts/iframe';
        $modInfoKunjungan = new InfopasienmasukkamarV;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $model = ARSepT::model()->findByPk($sep_id);
        $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $model->sep_id));
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model->nopeserta = $model->nokartuasuransi;
        $model->no_rekam_medik = $modPasien->no_rekam_medik;
        $model->carabayar_id = $modPendaftaran->carabayar_id;
        $model->penjamin_id = $modPendaftaran->penjamin_id;
        $model->kelastanggungan_id = $model->klsrawat;
        $model->is_polieksekutif = $model->poli_eksekutif;
        $model->hakkelas_kode = (empty($model->hakkelas_kode))? $model->klsrawat : $model->hakkelas_kode;
        $model->is_cob = $model->cob;
        $model->is_lakalantas = $model->lakalantas;
        $model->kelastanggungan = $model->kelasrawat;
        $model->jenispeserta_id = 2;
        $model->katarak = 0;
        $model->is_lakalantas = 0;
        $model->suplesi_jasaraharja = 0;
        $model->status_nosep = ($model->cob==0)? "TIDAK" : "YA";
        $modUser = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
        $nama = (isset($modUser->user_pemakai_bpjs)&&!empty($modUser->user_pemakai_bpjs))? $modUser->user_pemakai_bpjs : $modUser->nama_pemakai ;
        $model->pembuat_sep = $nama;
        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
        $modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
        if (empty($modAsuransiPasienBpjs)) {
            $modAsuransiPasienBpjs = new ARAsuransipasienbpjsM();
            $modAsuransiPasienBpjs->pasien_id = $modPasien->pasien_id;   
        }
        if (!empty($modAsuransiPasien)) {
            $modJenisPeserta = JenispesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            $modAsuransiPasien = $modAsuransiPasien; 
        } else {
            $modJenisPeserta = new JenispesertaM();
            $modAsuransiPasien = new ARAsuransipasienM;
        }
        $modAsuransiPasien->pasien_id = $modPasien->pasien_id; 
        $modRujukanBpjs->no_rujukan = $model->norujukan;
        $model->tglsep = date("Y-m-d", strtotime($model->tglsep));
        $model->tglrujukan = date("Y-m-d", strtotime($model->tglrujukan));
        $modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
        $model->ppkrujukan_nama = !empty($modAsuransiPasien) ? $modAsuransiPasien->nama_feskestk1 : "";
        $model->ppkpelayanan_nama = !empty($modAsuransiPasien) ? $modAsuransiPasien->nama_feskestk1 : "";
        
        if(!empty($modPendaftaran->rujukan_id)){
            $model->ppkrujukan_nama = RujukanT::model()->findByPk($modPendaftaran->rujukan_id)->nama_perujuk;
            $model->ppkpelayanan_nama = RujukanT::model()->findByPk($modPendaftaran->rujukan_id)->nama_perujuk;
        }
        $model->klsrawat = !empty($modAsuransiPasienBpjs->kelastanggunganasuransi_id) ? $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id : "";
        if(isset($_POST['ARSepT'])){
            $trans = Yii::app()->db->beginTransaction();
            $ok = true; 
            $model->attributes = $_POST['ARSepT'];
            $model->norujukan = $_POST['ARRujukanbpjsT']['no_rujukan'];
            $model->tglrujukan =  MyFormatter::formatDateTimeForDb($_POST['ARRujukanbpjsT']['tanggal_rujukan']);
            $model->klsrawat = ($model->jnspelayanan==1)? $_POST['ARSepT']['klsrawat'] : 3;
            $model->kelasrawat_kode = $model->klsrawat;
            $model->poli_eksekutif = $_POST['ARSepT']['poli_eksekutif'];
            $model->cob = $_POST['ARSepT']['cob'];
            $model->lakalantas = isset($_POST['ARSepT']['is_lakalantas'])? $_POST['ARSepT']['is_lakalantas'] : 0;
            if($model->lakalantas==1){
                $model->penjamin_lakalantas = $_POST['ARSepT']['penjamin_lakalantas'] ?? null;
                $model->lokasi_lakalantas = $_POST['ARSepT']['lokasi_lakalantas'] ?? null;
            }
            $model->no_telpon_peserta = $_POST['ARSepT']['no_telpon_peserta'];
            $model->pembuat_sep = $_POST['ARSepT']['pembuat_sep'];
            $model->catatansep = $_POST['ARSepT']['catatansep'];
            $model->ppkrujukan_nama = $_POST['ARSepT']['ppkrujukan_nama'];
            $model->update_time = date('Y-m-d H:i:s');
            //$model->update_loginpemakai_id = Yii::app()->user->id;
            $model->nama_diagnosaawal = $_POST['ARSepT']['nama_diagnosaawal'];
            $model->tanggal_kejadian = !empty($_POST['ARSepT']['tanggal_kejadian'])? MyFormatter::formatDateTimeForDb($_POST['ARSepT']['tanggal_kejadian']): null;
            
            $model->katarak = 0;
            $model->cob = 0;
            
            if (!empty($modAsuransiPasien->asuransipasien_id)) {                
                $modAsuransiPasien->attributes = $_POST['ARAsuransipasienM'];
                $modAsuransiPasien->kodefeskestk1 = $_POST['ARSepT']['ppkrujukan'];
                $modAsuransiPasien->nama_feskestk1 = $_POST['ARSepT']['ppkrujukan_nama'];
                $modAsuransiPasien->tglcetakkartuasuransi = date('Y-m-d H:i:s');
                $modAsuransiPasien->update_time = date('Y-m-d H:i:s');
                $modAsuransiPasien->update_loginpemakai_id = Yii::app()->user->id;
                $ok = $modAsuransiPasien->update();
            }

            $bpjs = new BpjsVklaim();

            $noSep = $model->nosep;
            $nokartu = $model->nokartuasuransi;
            $tglsep = $model->tglsep;
            $ppkpelayanan = $model->ppkpelayanan;
            $jnspelayanan = $model->jnspelayanan;
            $klsrawat = $model->klsrawat;
            $nomr = $modPasien->no_rekam_medik;
            $asalrujukan = $model->jenisrujukan_kode;
            $norujukan = $model->norujukan;
            $tglrujukan = $model->tglrujukan;
            $ppkrujukan = $model->ppkrujukan;
            $catatan = $model->catatansep;
            $diagawal = $model->diagnosaawal;
            $politujuan = $model->politujuan;
            $eksekutif = $model->poli_eksekutif;
            $cob = $model->cob;
            $lakalantas = $model->lakalantas;
            $penjamin = $model->penjamin_lakalantas;
            $lokasilakalantas = $model->lokasi_lakalantas;
            $notlp = $model->no_telpon_peserta;
            $user = Yii::app()->user->getState('nama_pemakai');
            $tglKejadian = $model->tanggal_kejadian;
            $keterangan = $model->keterangan_kejadian;
            $suplesi = $model->suplesi_jasaraharja;
            $noSepSuplesi = $model->no_suplesi;
            $kdPropinsi = $model->propinsi_lakalantas_nama;
            $kdKabupaten = $model->kabupaten_lakalantas_nama;
            $kdKecamatan = $model->kecamatan_lakalantas_nama;
            $noSurat = $model->no_surat;
            $kodeDPJP = $model->kode_dpjp;
            $katarak = $model->katarak;

            
            
            if($model->update() && $ok) {
                $res = $bpjs->update_sep_new($noSep, $nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, 
                $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, 
                $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, 
                $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,
                $noSurat,$kodeDPJP,$katarak, $model);
                
                $res_json = CJSON::decode($res);

                if (is_array($res_json) && !empty($res_json['metaData']['code'])) {
                    if (!$res_json['metaData']['code'] == 200) {
                        $ok = false;
                        $msg = "[Error ".$res_json['metaData']['code']."] ".$res_json['metaData']['message'];
                    }
                } else {
                    $ok = false;
                    $msg = "Terjadi kesalahan pada Ubah SEP";
                }

                if(!empty($modPendaftaran->rujukan_id)){
                    RujukanT::model()->updateAll(array('nama_perujuk' => $model->ppkrujukan_nama), 'rujukan_id = ' . $modPendaftaran->rujukan_id);
                }
                
                // var_dump($ok, $_POST, $model->attributes, $res); die;
                

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "SEP berhasil disimpan.");
                    $this->redirect(array('UpdateSEP', 'sep_id' => $sep_id,'no_rekam_medik'=>$no_rekam_medik, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "SEP gagal disimpan. ".$msg);
                }

            }else{
                $trans->rollback();
                Yii::app()->user->setFlash('error', "SEP gagal disimpan");
            }
        }
        
        $this->render($this->path_view . '_formUpdate_new', array(
            'model' => $model,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modInfoKunjungan' => $modInfoKunjungan,
            'no_rekam_medik' => $no_rekam_medik,
            'modPendaftaran' => $modPendaftaran,
        ));
    }
    
    /**
     * Update tanggal pulang
     * @param type $sep_id
     * @param type $no_rekam_medik
     */
    public function actionUpdateTglPulang($sep_id,$no_rekam_medik){
        $this->layout = '//layouts/iframe';
        $modInfoKunjungan = new InfopasienmasukkamarV;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $model = ARSepT::model()->findByPk($sep_id);
        $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $model->sep_id));
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model->nopeserta = $model->nokartuasuransi;
        $model->no_rekam_medik = $modPasien->no_rekam_medik;
        $model->carabayar_id = $modPendaftaran->carabayar_id;
        $model->penjamin_id = $modPendaftaran->penjamin_id;
        $model->is_polieksekutif = $model->poli_eksekutif;
        $model->is_cob = $model->cob;
        $model->is_lakalantas = $model->lakalantas;
        $model->jenispeserta_id = 1;
        $modUser = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
        $nama = (isset($modUser->user_pemakai_bpjs)&&!empty($modUser->user_pemakai_bpjs))? $modUser->user_pemakai_bpjs : $modUser->nama_pemakai ;
        $model->pembuat_sep = $nama;
        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
        $modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta' => $model->nokartuasuransi));
        if (empty($modAsuransiPasienBpjs)) {
            $modAsuransiPasienBpjs = new ARAsuransipasienbpjsM();
            $modAsuransiPasienBpjs->pasien_id = $modPasien->pasien_id;   
        }
        if (!empty($modAsuransiPasien)) {
            $modJenisPeserta = JenispesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            $modAsuransiPasien = $modAsuransiPasien;
        } else {
            $modJenisPeserta = new JenispesertaM();
            $modAsuransiPasien = new AsuransipasienM();
            $modAsuransiPasien->nokartuasuransi = $model->nopeserta;
            $modAsuransiPasien->pasien_id = $model->pasien_id;
        }
        $modRujukanBpjs->no_rujukan = $model->norujukan;
        $model->tglsep = date("Y-m-d", strtotime($model->tglsep));
        $model->tglrujukan = date("Y-m-d", strtotime($model->tglrujukan));
        $model->tglpulang = date("Y-m-d");
        $modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
        $model->klsrawat = !empty($modAsuransiPasienBpjs->kelastanggunganasuransi_id) ? $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id : "";

        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
        ), array(
            'condition'=>'carakeluar_id <> 5',
        ));
        // var_dump(!empty($pulang), empty($model->statuspulang_kode)); // die;
        if (!empty($pulang) && empty($model->statuspulang_kode)) {
            // die;
            $model->statuspulang_kode = $pulang->carakeluar_id;
        }

        if (!empty($model->statuspulang_kode)) {
            $cara = CarakeluarM::model()->findByAttributes(array(
                'carakeluar_id'=>$model->statuspulang_kode
            ), array(
                'order'=>'carakeluar_id',
            ));
        }

        // var_dump($pulang->attributes, $model->statuspulang_kode); die;

        $model->kelastanggungan_id = !empty($model->klsrawat) ? $model->klsrawat : "";
        $model->kelastanggungan = !empty($model->klsrawat) ? $model->klsrawat : "";

        if(isset($_POST['ARSepT'])){
            
            $model->attributes = $_POST['ARSepT'];
            $model->tglpulang = $_POST['ARSepT']['tglpulang'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;
            $model->tglpulang = empty($model->tglpulang) ? null : MyFormatter::formatDateTimeForDb($model->tglpulang);
            $model->tgl_meninggal = (empty($model->tgl_meninggal) || $model->statuspulang_kode != 4) ? null : MyFormatter::formatDateTimeForDb($model->tgl_meninggal);
            // var_dump($model->attributes, $_POST); die;
            if($model->update()){
                // var_dump($model->attributes); die;

                $carakeluar = CarakeluarM::model()->findByPk($model->statuspulang_kode);
                $kode_status = "";
                if (!empty($carakeluar)) {
                    $kode_status = $carakeluar->kode_carakeluar_bpjs;
                }

                $bpjs = new BpjsVklaim();

                $reqSep = json_decode($bpjs->update_sep_pulang_2($model->nosep, $model->tglpulang, $kode_status, $model->tgl_meninggal, $model->nosurat_ketmeninggal, $model->pembuat_sep), true);
                // var_dump($reqSep); die;
                $pesan = "";
                if ($reqSep['metaData']['code'] == 200) {
                    $this->bridgingsep = true;
                } else {
                    $this->bridgingsep = false;
                    $pesan = $reqSep['metaData']['message'];
                }
                if($this->bridgingsep){
                    $this->redirect(array('UpdateTglPulang', 'sep_id' => $sep_id,'no_rekam_medik'=>$no_rekam_medik, 'sukses' => 1));
                }else{
                    Yii::app()->user->setFlash('error', "SEP gagal disimpan ".$pesan);
                }
            }else{
                Yii::app()->user->setFlash('error', "SEP gagal disimpan");
            }
        }
        
        $this->render($this->path_view . '_formUpdatePulang', array(
            'model' => $model,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modInfoKunjungan' => $modInfoKunjungan,
            'no_rekam_medik' => $no_rekam_medik,
        ));
    }
    
    /**
     * @author Tantowy <tantowijaya@.com>
     * 
     * Proses laad data item bpjs seperti (diagnosa, ppk, poli)
     * 
     * @throws CHttpException
     */
    public function actionAutocompleteItemSEP() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $term = $_GET['term'];
            $item = $_GET['item'];
            $bpjs = new BpjsVklaim();
            
            /* Load data diagnosa*/
            if($item=="diagnosa"){
                $response = json_decode($bpjs->search_diagnosa($term,'', ''), true);
                if (!empty($response['response'])) {
                    foreach ($response['response']['diagnosa'] as $i => $value) {
                        $returnVal[$i]['label'] = $value['nama'];
                        $returnVal[$i]['kode'] = $value['kode'];
                        $returnVal[$i]['nama'] = $value['nama'];
                    }
                }
            }
            /* Load data poli / sub spesialis */
            if($item=="poli"){
                $response = json_decode($bpjs->search_poli($term), true);
                if (!empty($response['response'])) {
                    foreach ($response['response']['poli'] as $i => $value) {
                        $returnVal[$i]['label'] = $value['kode']." - ".$value['nama'];
                        $returnVal[$i]['kode'] = $value['kode'];
                        $returnVal[$i]['nama'] = $value['nama'];
                    }
                }
            }
            /* Load data ppk / faskes bpjs */
            if($item=="ppk"){
                $response = json_decode($bpjs->fasilitas_kesehatan($term.'/1','',''), true);
                /* Pertama load dengan jenis non reumah sakit */
                if (!empty($response['response'])) {
                    foreach ($response['response']['faskes'] as $i => $value) {
                        $returnVal[$i]['label'] = $value['nama'];
                        $returnVal[$i]['kode'] = $value['kode'];
                        $returnVal[$i]['nama'] = $value['nama'];
                    }
                }else{
                    /* Pertama load dengan jenis reumah sakit */
                    $response = json_decode($bpjs->fasilitas_kesehatan($term.'/2','',''), true);
                    if (!empty($response['response'])) {
                        foreach ($response['response']['faskes'] as $i => $value) {
                            $returnVal[$i]['label'] = $value['nama'];
                            $returnVal[$i]['kode'] = $value['kode'];
                            $returnVal[$i]['nama'] = $value['nama'];
                        }
                    }
                }
            }
            
            echo CJSON::encode($returnVal);
            
        } else {
            throw new CHttpException(403, 'Tidak dapat mengurai data');
            Yii::app()->end();
        }
    }

    public function actionSetFormDokterMelayani() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokterList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count($dokterList) > 0) {
                foreach ($dokterList AS $i => $dokter) {
                    $kode = $dokter['kode'];
                    $nama = $dokter['nama'];
                    $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_dpjpygmelayani_nama').val('" . $nama . "');$('#ARSepT_dpjpygmelayani_kode').val('" . $kode . "');$('#dialogDpjpMelayani').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kode . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nama . "</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionGetRujukanDariBpjs(){
        if(Yii::app()->request->isAjaxRequest) {
            $kodeppk = $_POST['kodeppk'];
            $asarujukan = (isset($_POST['asarujukan'])?$_POST['asarujukan']:null);
            $data['rujukandari'] = "";
            $data['asalrujukan'] = "";

            $criteria = new CDbCriteria();

            if(!empty($asarujukan)){
                    $criteria->addCondition('asalrujukan_id = '.$asarujukan);
            }
            $criteria->compare('kodeppk',$kodeppk,true);


            $model = RujukandariM::model()->find($criteria);

            if(isset($model)){
                $data['rujukandari'] = $model->rujukandari_id;
                $data['asalrujukan'] = $model->asalrujukan_id;

                $modRujukanDari = RujukandariM::model()->findAll('asalrujukan_id = '.$model->asalrujukan_id .' ORDER BY namaperujuk ASC');

                if(count((array)$modRujukanDari) > 0){
                        $option = "";
                        $dataRujukan = CHtml::listData($modRujukanDari,'rujukandari_id', 'namaperujuk');
                    foreach($dataRujukan as $value=>$name){
                                    $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                    $data['datarujukandari'] = $option;
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionSetKelasRawatBpjs() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = $_GET['instalasi_id'];
            $pasienadmisi_id = (!empty($_GET['pasienadmisi_id'])? $_GET['pasienadmisi_id'] : null);

            $form = "";

            if($instalasi_id == Params::INSTALASI_ID_RI && !empty($pasienadmisi_id)){
                $modPasienadmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                if(!empty($modPasienadmisi)){
                    $option = CHtml::tag('option',array('value'=>''),'-Pilih-',true);
                    $modKelaspelRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$modPasienadmisi->ruangan_id));
                    if(!empty($modKelaspelRuangan)){
                        foreach($modKelaspelRuangan as $dataKelas){
                            $option .= CHtml::tag('option',array('value'=>$dataKelas->kelaspelayanan->kelasbpjs_id),CHtml::encode($dataKelas->kelaspelayanan->kelaspelayanan_nama),true);
                        }
                    }
                    $form = $option;
                }
            }else{
                $option = CHtml::tag('option',array('value'=>''),'-Pilih-',true);
                $modKelaspel = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true and kelasbpjs_id is not null order by urutankelas ASC');
                if(!empty($modKelaspel)){
                    foreach($modKelaspel as $dataKelas){
                        $option .= CHtml::tag('option',array('value'=>$dataKelas->kelasbpjs_id),CHtml::encode($dataKelas->kelaspelayanan_nama),true);
                    }
                }
                $form = $option;
            }
            echo CJSON::encode(array('html' => $form));
            Yii::app()->end();
        }
    }

}
