<?php

class SinkronisasiSEPController extends MyAuthController {

    public $pathView = 'pendaftaranPenjadwalan.views.sinkronisasiSEP.';
    public function actionIndex() {
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                                
                if ($ajax == 'datakunjungan-grid')
                    $path = $this->pathView.'grid/_daftar_pasien_rjrdri';                                
                
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

                    $models = $load->searchDialogKunjunganForSRK();            

                    foreach ($models->getData() as $i => $model) {

                        $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                        $asuransi = AsuransipasienM::model()->findByPk($daftar->asuransipasien_id);

                        $attributes = $model->attributeNames();
                        foreach ($attributes as $j => $attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->no_pendaftaran.' '.$model->nama_pasien;
                        $returnVal[$i]['value'] = $model->pendaftaran_id;
                        $returnVal[$i]['nokartuasuransi'] = empty($asuransi) ? "-" : $asuransi->nokartuasuransi;
                    }
                    echo CJSON::encode($returnVal);
                }
            }
            exit;
        }
                
        $modInfoKunjungan = new InfokunjunganrdV; 

        if (isset($_POST['pendaftaran_id'])) {
            $modPendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
            $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
            
            if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RI) {
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                if (!empty($modAdmisi)) {
                    $sep = SepT::model()->findByPk($modAdmisi->sep_id);
                }
            }
            $profil = ProfilrumahsakitM::model()->find();


            if (!empty($sep)) {

                $bpjs = new BpjsVklaim;
                $res = CJSON::decode($bpjs->search_sep($_POST['no_sep']));

                if (!empty($res['response'])) {

                    $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($res['response']['noRujukan']));

                    $sep->nosep = $_POST['no_sep'];
                    $sep->tglsep = $_POST['tgl_sep'];
                    $sep->nokartuasuransi = $res['response']['peserta']['noKartu'];
                    $sep->jnspelayanan = $res['response']['jnsPelayanan'] == "Rawat Jalan" ? "2" : "1";
                    $sep->catatansep = $res['response']['catatan'];
                    $sep->politujuan = $res['response']['poli'];
                    $sep->klsrawat = $res['response']['klsRawat']['klsRawatHak'];
                    $sep->statuskecelakaan_kode = $res['response']['kdStatusKecelakaan'];
                    $sep->statuskecelakaan_nama = $res['response']['nmstatusKecelakaan'];
                    $sep->dpjpygmelayani_nama = $res['response']['dpjp']['nmDPJP'];
                    $sep->dpjpygmelayani_kode = $res['response']['dpjp']['kdDPJP'];
                    $sep->no_surat = $res['response']['kontrol']['noSurat'];
                    $sep->kode_dpjp = $res['response']['kontrol']['kdDokter'];
                    $sep->nama_dpjp = $res['response']['kontrol']['nmDokter'];
                    $sep->poli_eksekutif = $res['response']['poliEksekutif'];
                    $sep->cob = $res['response']['cob'];
                    $sep->katarak = $res['response']['katarak'];
                    // rujukan
                    $sep->norujukan = $res['response']['noRujukan'];
                    if (!empty($res_rujukan['response'])) {
                        $sep->tglrujukan = $res_rujukan['response']['rujukan']['tglKunjungan'];
                        $sep->ppkrujukan = $res_rujukan['response']['rujukan']['provPerujuk']['kode'];
                        $sep->diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['kode'];
                        $sep->nama_diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['nama'];
                    }else{
                        $sep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
                    }


                    if (empty($sep->catatansep)) {
                        $sep->catatansep = "-";
                    }

                    $diagnosa_nama = str_replace(" ", "%20", $res['response']['diagnosa']);
                    $diagnosa = CJSON::decode($bpjs->search_diagnosa($diagnosa_nama, null, null));
                    if (!empty($diagnosa['response'])) {
                        foreach ($diagnosa['response']['diagnosa'] as $item) {
                            if (strpos(strtolower($item['nama']), strtolower($res['response']['diagnosa'])) !== false) {
                                $nama = explode(" - ", $item['nama']);
                                array_shift($nama);
                                $sep->diagnosaawal = $item['kode'];
                                $sep->nama_diagnosaawal = implode($nama);
                            }
                        }
                    }

                    if (!empty($sep->no_surat)) {
                        $sep->jenis_kunjungan = 2;
                        $sep->asesmen_pelayanan = 5;
                    } else {
                        $sep->jenis_kunjungan = 0;
                    }

                    if (empty($sep->catatansep)) {
                        $sep->catatansep = "-";
                    }

                    if (empty($sep->tglrujukan)) {
                        $sep->tglrujukan = $sep->tglsep;
                    }

                    if ($sep->save()) {

                        if (!empty($asuransi)) {
                            $asuransi->nokartuasuransi = $asuransi->nopeserta = $sep->nokartuasuransi;
                            $asuransi->save(false);
                        }


                        Yii::app()->user->setFlash('success', 'Data SEP berhasil di-set');
                        $this->redirect(array('index', 'success' => 1));
                    } else {
                        var_dump($sep->errors); die;
                        Yii::app()->user->setFlash('error', 'Data SEP gagal di-set');
                    }

                    // var_dump($sep->attributes, $res_rujukan['response'], $res['response'], $_POST); die;
                } else {
                    Yii::app()->user->setFlash('error', 'Data SEP Tidak Ditemukan');
                }


                
            } else {
                $sep = new SepT;
                $bpjs = new BpjsVklaim;

                $res = CJSON::decode($bpjs->search_sep($_POST['no_sep']));

                if (!empty($res['response'])) {
                    $response = $res['response'];
                    // var_dump($response); die;
                    $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($response['noRujukan']));
                    //var_dump($res_rujukan);
                    if (empty($res_rujukan['response'])) {
                        $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($response['noRujukan']));
                    }
                    // var_dump($res_rujukan); die;

                    $sep->tglsep = $response['tglSep'];
                    $sep->nosep = $response['noSep'];
                    $sep->ppkpelayanan = $profil->ppkpelayanan;
                    $sep->nokartuasuransi = $response['peserta']['noKartu'];
                    $sep->jnspelayanan = $response['jnsPelayanan'] == "Rawat Jalan" ? "2" : "1";
                    $sep->catatansep = $response['catatan'];
                    $sep->politujuan = $response['poli'];
                    $sep->klsrawat = $response['klsRawat']['klsRawatHak'];
                    $sep->statuskecelakaan_kode = $response['kdStatusKecelakaan'];
                    $sep->statuskecelakaan_nama = $response['nmstatusKecelakaan'];
                    $sep->dpjpygmelayani_nama = $response['dpjp']['nmDPJP'];
                    $sep->dpjpygmelayani_kode = $response['dpjp']['kdDPJP'];
                    $sep->no_surat = $response['kontrol']['noSurat'];
                    $sep->kode_dpjp = $response['kontrol']['kdDokter'];
                    $sep->nama_dpjp = $response['kontrol']['nmDokter'];
                    $sep->poli_eksekutif = $response['poliEksekutif'];
                    $sep->cob = $response['cob'];
                    $sep->katarak = $response['katarak'];
                    // rujukan
                    $sep->norujukan = $response['noRujukan'];
                    $sep->ppkrujukan = substr($sep->norujukan, 0, 8);
                    // var_dump($res_rujukan); die;
                    if (!empty($res_rujukan['response'])) {
                        $sep->tglrujukan = $res_rujukan['response']['rujukan']['tglKunjungan'];
                        $sep->ppkrujukan = $res_rujukan['response']['rujukan']['provPerujuk']['kode'];
                        $sep->diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['kode'];
                        $sep->nama_diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['nama'];
                    }else{
                        $sep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
                    }

                    // pencarian diagnosa diganti dengan kode diagnosa yang di dapat dari form
                    $diagnosa_kode = isset($_POST['diagnosaLengkap']) ? explode(' - ',$_POST['diagnosaLengkap']) : '';
                    $diagnosa_kode = isset($diagnosa_kode[0]) ? $diagnosa_kode[0] : '';
                    $diagnosa_kode = str_replace(" ", "%20", $diagnosa_kode);
                    $diagnosa = CJSON::decode($bpjs->search_diagnosa($diagnosa_kode, null, null));
                    
                    if (!empty($diagnosa['response'])) {
                        foreach ($diagnosa['response']['diagnosa'] as $item) {
                            // if (strpos(strtolower($item['nama']), strtolower($response['diagnosa'])) !== false) {
                            //     $nama = explode(" - ", $item['nama']);
                            //     array_shift($nama);
                            //     $sep->diagnosaawal = $item['kode'];
                            //     $sep->nama_diagnosaawal = implode($nama);
                            // }
                            if ($item['kode'] == $diagnosa_kode) {
                                $nama = explode(" - ", $item['nama']);
                                array_shift($nama);
                                $sep->diagnosaawal = $item['kode'];
                                $sep->nama_diagnosaawal = implode($nama);
                            }

                        }
                    }

                    if (!empty($sep->no_surat)) {
                        $sep->jenis_kunjungan = 2;
                        $sep->asesmen_pelayanan = 5;
                    } else {
                        $sep->jenis_kunjungan = 0;
                    }

                    $sep->create_time = $sep->update_time = date('Y-m-d');
                    $sep->create_loginpemakai_id = Yii::app()->user->id;
                    $sep->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    if (empty($sep->catatansep)) {
                        $sep->catatansep = "-";
                    }

                    if (empty($sep->tglrujukan)) {
                        $sep->tglrujukan = $sep->tglsep;
                    }
                    // var_dump($sep->attributes, $response, $_POST); die;

                    if ($sep->save()) {
                        if (!empty($asuransi)) {
                            $asuransi->nokartuasuransi = $asuransi->nopeserta = $sep->nokartuasuransi;
                            $asuransi->save(false);
                        }

                        $modPendaftaran->sep_id = $sep->sep_id;
                        $modPendaftaran->save(false, array('sep_id'));

                        Yii::app()->user->setFlash('success', 'Data SEP berhasil di-set');
                        $this->redirect(array('index', 'success' => 1));
                    } else {
                        var_dump($sep->errors); die;
                        Yii::app()->user->setFlash('error', 'Data SEP gagal di-set');
                    }

                } else {
                    Yii::app()->user->setFlash('error', 'Data SEP Tidak Ditemukan');
                }



                // Yii::app()->user->setFlash('error', 'Data SEP Tidak Ditemukan');
            }
        }
        
        // var_dump($_POST); die;
                  
        $this->render($this->pathView.'buat', array(            
            'model' => $modInfoKunjungan,
        ));
    }

    public function actionGetLoadRiwayatSEP() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "";

        $nokartu = $_POST['nokartu'];

        $bpjs = new BpjsVklaim;

        $konfig = KonfigsystemK::model()->find();
        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-'.$hari_riwayat.' days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($tgl_histori[count($tgl_histori) - 1]) && $tgl_histori[count($tgl_histori) - 1] != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        foreach ($tgl_histori as $idx => $item) {
            if (empty($tgl_histori[$idx + 1])) {
                continue;
            }

            $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
            if (!empty($res_temp['response']['histori'])) {
                $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
            }
        }

        /*
        $res = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, '2015-01-01', date('Y-m-d')));

        if (empty($res) || empty($res['metaData']['code'])) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi Kesalahan ketika melihat Riwayat SEP.',
                'html'=>'',
            ));
            Yii::app()->end();
        }

        if ($res['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Error BPJS '.$res['metaData']['code']." - ".$res['metaData']['message'],
                'html'=>'',
            ));
            Yii::app()->end();
        }
        */
        
        $list = $res_histori; //$res['response']['histori'];
        $html = "";

        $cnt = 0;
        foreach ($list as $item) {
            $html .= $this->renderPartial($this->pathView."grid._rowSEP", array(
                'detail'=>$item,
            ), true);
            $cnt++;
            if ($cnt >= 15) {
                break;
            }
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'',
            'html'=>$html,
        ));


        // var_dump($res); die;
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
        }elseif ($instalasi_id == Params::INSTALASI_ID_RJ) {
            $model = InfokunjunganrjV::model()->find($criteria);
        } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
            $model = InfokunjunganhdV::model()->find($criteria);
        } else if ($instalasi_id == Params::INSTALASI_ID_FISIOTERAPI) {
            $model = PasienmasukpenunjangV::model()->find($criteria);
        } else {
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
        
        echo CJSON::encode($returnVal);
    }

    /**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
                        die('param can\'not empty value');
                }else{
                        $param = $_GET['param'];
                }

                $bpjs = new BpjsVklaim();

                switch ($param) {
                        case '1':
                                $query = $_GET['query'];
                                print_r( $bpjs->search_sep($query) );
                                break;
                        default:
                                die('error number, please check your parameter option');
                                break;
                }
                Yii::app()->end();
            }
	}

    public function actionIndexGrup() {
        // var_dump($_POST); die;

        if (isset($_POST['list'])) {

            // var_dump($_POST); die;

            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            $bpjs = new BpjsVklaim;
            $profil = ProfilrumahsakitM::model()->find();

            $crDiag = new CDbCriteria;
            $crDiag->addCondition("lower(diagnosa_nama) = :param1");

            foreach ($_POST['list'] as $pendaftaran_id => $item) {
                if (empty($item['no_kartu']) || empty($item['no_sep'])) {
                    continue;
                }

                if (empty($item['data_sep'])) {
                    $res = CJSON::decode($bpjs->search_sep($item['no_sep']));
                } else {
                    $res = CJSON::decode($item['data_sep']);
                }


                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                $asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                $sep = SepT::model()->findByPk($modPendaftaran->sep_id);

                if (!empty($sep)) {

                    if (!empty($res['response'])) {
    
                        $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($res['response']['noRujukan']));
    
                        $sep->nosep = $response['noSep'];
                        $sep->tglsep = $response['tglSep'];
                        $sep->nokartuasuransi = $res['response']['peserta']['noKartu'];
                        $sep->jnspelayanan = $res['response']['jnsPelayanan'] == "Rawat Jalan" ? "2" : "1";
                        $sep->catatansep = $res['response']['catatan'];
                        $sep->politujuan = $res['response']['poli'];
                        $sep->klsrawat = $res['response']['klsRawat']['klsRawatHak'];
                        $sep->statuskecelakaan_kode = $res['response']['kdStatusKecelakaan'];
                        $sep->statuskecelakaan_nama = $res['response']['nmstatusKecelakaan'];
                        $sep->dpjpygmelayani_nama = $res['response']['dpjp']['nmDPJP'];
                        $sep->dpjpygmelayani_kode = $res['response']['dpjp']['kdDPJP'];
                        $sep->no_surat = $res['response']['kontrol']['noSurat'];
                        $sep->kode_dpjp = $res['response']['kontrol']['kdDokter'];
                        $sep->nama_dpjp = $res['response']['kontrol']['nmDokter'];
                        $sep->poli_eksekutif = $res['response']['poliEksekutif'];
                        $sep->cob = $res['response']['cob'];
                        $sep->katarak = $res['response']['katarak'];
                        // rujukan
                        $sep->norujukan = $res['response']['noRujukan'];
                        if (!empty($res_rujukan['response'])) {
                            $sep->tglrujukan = $res_rujukan['response']['rujukan']['tglKunjungan'];
                            $sep->ppkrujukan = $res_rujukan['response']['rujukan']['provPerujuk']['kode'];
                            $sep->diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['kode'];
                            $sep->nama_diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['nama'];
                        } else {
                            $sep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
                        }
    
    
                        if (empty($sep->catatansep)) {
                            $sep->catatansep = "-";
                        }
    
                        $diagnosa_nama = str_replace(" ", "%20", $res['response']['diagnosa']);
                        $diagnosa = CJSON::decode($bpjs->search_diagnosa($diagnosa_nama, null, null));
                        if (!empty($diagnosa['response'])) {
                            foreach ($diagnosa['response']['diagnosa'] as $itemDiag) {
                                if (strpos(strtolower($itemDiag['nama']), strtolower($res['response']['diagnosa'])) !== false) {
                                    $nama = explode(" - ", $itemDiag['nama']);
                                    array_shift($nama);
                                    $sep->diagnosaawal = $itemDiag['kode'];
                                    $sep->nama_diagnosaawal = implode($nama);
                                }
                            }
                        }

                        if (empty($sep->diagnosaawal)) {
                            $crDiag->params[':param1'] = strtolower($response['diagnosa']);
                            $diagnosa_data = DiagnosaM::model()->find($crDiag);
                            if (!empty($diagnosa_data)) {
                                $sep->diagnosaawal = $diagnosa_data->diagnosa_kode;
                                $sep->nama_diagnosaawal = $diagnosa_data->diagnosa_nama;
                            }
                        }
    
                        if (!empty($sep->no_surat)) {
                            $sep->jenis_kunjungan = 2;
                            $sep->asesmen_pelayanan = 5;
                        } else {
                            $sep->jenis_kunjungan = 0;
                        }
    
                        if (empty($sep->catatansep)) {
                            $sep->catatansep = "-";
                        }
    
                        if (empty($sep->tglrujukan)) {
                            $sep->tglrujukan = $sep->tglsep;
                        }
    
                        if ($sep->save()) {
    
                            if (!empty($asuransi)) {
                                $asuransi->nokartuasuransi = $asuransi->nopeserta = $sep->nokartuasuransi;
                                $ok = $ok && $asuransi->save(false);
                            }

                            if ($_POST['cari']['jns_pelayanan'] == "Rawat Inap") {
                                PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array(
                                    'sep_id'=>$sep->sep_id,
                                ));
                            }

                        } else {
                            var_dump($sep->errors);
                            $ok = false;
                        }
    
                        // var_dump($sep->attributes, $res_rujukan['response'], $res['response'], $_POST); die;
                    } else {
                        continue;
                    }
    
    
                    
                } else {
                    $sep = new SepT;
    
                    if (!empty($res['response'])) {
                        $response = $res['response'];
                        // var_dump($response); die;
                        $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($response['noRujukan']));
                        //var_dump($res_rujukan);
                        if (empty($res_rujukan['response'])) {
                            $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($response['noRujukan']));
                        }
                        // var_dump($res_rujukan); die;
    
                        $sep->tglsep = $response['tglSep'];
                        $sep->nosep = $response['noSep'];
                        $sep->ppkpelayanan = $profil->ppkpelayanan;
                        $sep->nokartuasuransi = $response['peserta']['noKartu'];
                        $sep->jnspelayanan = $response['jnsPelayanan'] == "Rawat Jalan" ? "2" : "1";
                        $sep->catatansep = $response['catatan'];
                        $sep->politujuan = $response['poli'];
                        $sep->klsrawat = $response['klsRawat']['klsRawatHak'];
                        $sep->statuskecelakaan_kode = $response['kdStatusKecelakaan'];
                        $sep->statuskecelakaan_nama = $response['nmstatusKecelakaan'];
                        $sep->dpjpygmelayani_nama = $response['dpjp']['nmDPJP'];
                        $sep->dpjpygmelayani_kode = $response['dpjp']['kdDPJP'];
                        $sep->no_surat = $response['kontrol']['noSurat'];
                        $sep->kode_dpjp = $response['kontrol']['kdDokter'];
                        $sep->nama_dpjp = $response['kontrol']['nmDokter'];
                        $sep->poli_eksekutif = $response['poliEksekutif'];
                        $sep->cob = $response['cob'];
                        $sep->katarak = $response['katarak'];
                        // rujukan
                        $sep->norujukan = $response['noRujukan'];
                        $sep->ppkrujukan = substr($sep->norujukan, 0, 8);
                        // var_dump($res_rujukan); die;
                        if (!empty($res_rujukan['response'])) {
                            $sep->tglrujukan = $res_rujukan['response']['rujukan']['tglKunjungan'];
                            $sep->ppkrujukan = $res_rujukan['response']['rujukan']['provPerujuk']['kode'];
                            $sep->diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['kode'];
                            $sep->nama_diagnosaawal = $res_rujukan['response']['rujukan']['diagnosa']['nama'];
                        } else {
                            $sep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
                        }
    
                        $diagnosa_nama = str_replace(" ", "%20", $response['diagnosa']);
                        $diagnosa = CJSON::decode($bpjs->search_diagnosa($diagnosa_nama, null, null));
                        if (!empty($diagnosa['response'])) {
                            foreach ($diagnosa['response']['diagnosa'] as $itemDiag) {
                                if (strpos(strtolower($itemDiag['nama']), strtolower($response['diagnosa'])) !== false) {
                                    $nama = explode(" - ", $itemDiag['nama']);
                                    array_shift($nama);
                                    $sep->diagnosaawal = $itemDiag['kode'];
                                    $sep->nama_diagnosaawal = implode($nama);
                                }
                            }
                        }

                        if (empty($sep->diagnosaawal)) {
                            $crDiag->params[':param1'] = strtolower($response['diagnosa']);
                            $diagnosa_data = DiagnosaM::model()->find($crDiag);
                            if (!empty($diagnosa_data)) {
                                $sep->diagnosaawal = $diagnosa_data->diagnosa_kode;
                                $sep->nama_diagnosaawal = $diagnosa_data->diagnosa_nama;
                            }
                        }
    
                        if (!empty($sep->no_surat)) {
                            $sep->jenis_kunjungan = 2;
                            $sep->asesmen_pelayanan = 5;
                        } else {
                            $sep->jenis_kunjungan = 0;
                        }
    
                        $sep->create_time = $sep->update_time = date('Y-m-d');
                        $sep->create_loginpemakai_id = Yii::app()->user->id;
                        $sep->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        if (empty($sep->catatansep)) {
                            $sep->catatansep = "-";
                        }
    
                        if (empty($sep->tglrujukan)) {
                            $sep->tglrujukan = $sep->tglsep;
                        }
                        // var_dump($sep->attributes, $response, $_POST); die;
    
                        if ($sep->save()) {
                            if (!empty($asuransi)) {
                                $asuransi->nokartuasuransi = $asuransi->nopeserta = $sep->nokartuasuransi;
                                $ok = $ok && $asuransi->save(false);
                            }
    
                            $modPendaftaran->sep_id = $sep->sep_id;
                            $ok = $ok && $modPendaftaran->save(false, array('sep_id'));

                            if ($_POST['cari']['jns_pelayanan'] == "Rawat Inap") {
                                PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array(
                                    'sep_id'=>$sep->sep_id,
                                ));
                            }
                        } else {
                            var_dump($sep->errors, $res, $diagnosa);
                            $ok = false;
                        }
    
                    } else {
                        continue;
                    }
    
    
    
                    // Yii::app()->user->setFlash('error', 'Data SEP Tidak Ditemukan');
                }

                $res_kartu = CJSON::decode($bpjs->search_kartu($sep->nokartuasuransi));
                // var_dump($sep->attributes);
                if (empty($asuransi)) {
                    $asuransi = new AsuransipasienT;
                } // ('carabayar_id', 'penjamin_id', 'nokartuasuransi', 'nopeserta', 'namaperusahaan', 'status_konfirmasi', 'tgl_konfirmasi', 'asuransipasien_aktif', 'nominal_tanggungan')
                $asuransi->carabayar_id = $modPendaftaran->carabayar_id;
                $asuransi->penjamin_id = $modPendaftaran->penjamin_id;
                $asuransi->nokartuasuransi = $asuransi->nopeserta = $sep->nokartuasuransi;
                $asuransi->namaperusahaan = "BPJS";
                $asuransi->status_konfirmasi = "SUDAH DIKONFIRMASI";
                $asuransi->tgl_konfirmasi = date('Y-m-d H:i:s');
                $asuransi->asuransipasien_aktif = true;
                $asuransi->nominal_tanggungan = 0;
                
                if (!empty($res['response'])) {
                    $asuransi->namapemilikasuransi = substr($res['response']['peserta']['nama'], 0, 50);
                    $kelas = KelaspelayananM::model()->findByAttributes(array(
                        'kelasbpjs_id'=>$res['response']['klsRawat']['klsRawatHak'],
                    ));
                    if (!empty($kelas)) {
                        $asuransi->kelastanggunganasuransi_id = $kelas->kelaspelayanan_id;
                    }
                }

                if (!empty($res_kartu['response'])) {
                    $asuransi->bpjs_pesertadinsos = $res_kartu['response']['peserta']['informasi']['dinsos'];
                    $asuransi->bpjs_prolanisprb = $res_kartu['response']['peserta']['informasi']['prolanisPRB'];
                    $asuransi->bpjs_nosktm = $res_kartu['response']['peserta']['informasi']['noSKTM'];
                    $asuransi->jenispersertakode_bpjs = $res_kartu['response']['peserta']['jenisPeserta']['kode'];
                    $asuransi->jenispeserta_bpjs = $res_kartu['response']['peserta']['jenisPeserta']['keterangan'];
                }

                //var_dump($asuransi->attributes); die;

                $ok = $ok && $asuransi->save();
                $modPendaftaran->asuransipasien_id = $asuransi->asuransipasien_id;
                $ok = $ok && $modPendaftaran->save(false, array('asuransipasien_id'));

                // var_dump($asuransi->attributes, $res);

            }
            // var_dump($ok); die;

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', 'Data SEP berhasil di-set');
                $this->redirect(array('indexGrup', 'success' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('success', 'Data SEP berhasil di-set');
                $this->redirect(array('indexGrup', 'success' => 1));
            }

            

        }

        $this->render($this->pathView.'grup/buat', array());
    }

    public function actionSearchNoSEPList() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $tgl_pendaftaran = MyFormatter::formatDateTimeForDB($_POST['tgl_pendaftaran']);
        $jns_pelayanan = $_POST['jns_pelayanan'];

        $cr = new CDbCriteria;
        $cr->compare('tgl_pendaftaran::date', $tgl_pendaftaran);
        $cr->compare('lower(jnspelayanan)', strtolower($jns_pelayanan));
        $cr->limit = 30;

        $res = SinkronisasisepallV::model()->findAll($cr);

        $html = "";
        $bpjs = new BpjsVklaim;

        foreach ($res as $idx => $item) {

            $nosep = "";

            $res_sep = CJSON::decode($bpjs->search_monitoring_historipelayanan($item->nokartuasuransi, $item->tgl_pendaftaran, $item->tgl_pendaftaran));
            // var_dump($res_sep); die;

            $sep_hasil = "";

            if (!empty($res_sep['response']['histori'])) {
                foreach ($res_sep['response']['histori'] as $sep) {
                    if ($jns_pelayanan == "Rawat Jalan" && $sep['jnsPelayanan'] == 2) {
                        $nosep = $sep['noSep'];
                        $true_sep = CJSON::decode($bpjs->search_sep($nosep));
                        if (!empty($true_sep['response'])) {
                            $sep_hasil = CJSON::encode($true_sep);
                        }
                    }
                    if ($jns_pelayanan == "Rawat Inap" && $sep['jnsPelayanan'] == 1) {
                        $nosep = $sep['noSep'];
                        $true_sep = CJSON::decode($bpjs->search_sep($nosep));
                        if (!empty($true_sep['response'])) {
                            $sep_hasil = CJSON::encode($true_sep);
                        }
                    }
                }
            }

            $html .= $this->renderPartial($this->pathView."grup/_rowNoSep", array(
                'item'=>$item,
                'idx'=>$idx,
                'sep_hasil'=>$sep_hasil,
                'nosep'=>$nosep,
            ), true);
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>"",
            'html'=>$html,
        ));


    }

}