<?php

class PenjualanResepRSController extends MyAuthController {

    public $path_view = 'farmasiApotek.views.penjualanResepRS.';
    public $penjualantersimpan = false;
    public $obatalkespasientersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping

    public function actionIndex($penjualanresep_id = null) {
      
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'datakunjungan-grid') {
                $this->renderPartial('_dialogPasien');
                Yii::app()->end();
            }
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obatracikan-api-grid') {
                $this->renderPartial($this->path_view . '_dialogObatRacikan');
                Yii::app()->end();
            }
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obatnonracikan-api-grid') {
                $this->renderPartial($this->path_view . '_dialogObatNonRacikan');
                Yii::app()->end();
            }
        }
        $sukses = false;
        $modPendaftaran = new FAPendaftaranT;
        $modInfoRI = new FAInfopasienmasukkamarV;
        $modPasien = new FAPasienM;
        $modReseptur = new FAResepturT;
        $modAntrian = new FAAntrianFarmasiT;
        $modResepturDetail = new FAResepturDetailT;
        $konfigFarmasi = KonfigfarmasiK::model()->find();
        $modObatAlkesPasien = array();
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
        $modReseptur->noresep_depan = $modReseptur->noresep . '/';
        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan->noresep = $modReseptur->noresep;

        $modPenjualan->totharganetto = 0;
        $modPenjualan->jasapelayanan_farmasi = 0;
        $modPenjualan->totalhargajual = 0;
        $modPenjualan->totaltarifservice = 0;
        $modPenjualan->biayaadministrasi = 0;
        $modPenjualan->biayakonseling = 0;
        $modPenjualan->pembulatanharga = 0;
        $modPenjualan->jasadokterresep = 0;
        $modPenjualan->discount = 0;
        $modPenjualan->subsidiasuransi = 0;
        $modPenjualan->subsidipemerintah = 0;
        $modPenjualan->subsidirs = 0;
        $modPenjualan->iurbiaya = 0;
        $modPenjualan->isresepperawatan = 1;

        $modReseptur->admracikan = KonfigfarmasiK::model()->find()->admracikan;
		$modReseptur->administrasi = KonfigfarmasiK::model()->find()->administrasi;

        $modObatAlkes = array();
        
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
        // if (isset($_GET['reseptur_id'])){
        //     var_dump($_GET['reseptur_id']);die;
        //     $modResepturDetail = FAResepturDetailT::model()->findByAttributes(array('reseptur_id' => $_GET['reseptur_id']));
        // }
        
        if (!empty($penjualanresep_id)) {

            $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
            $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
            $modResepturDetail = FAResepturDetailT::model()->findByAttributes(array('reseptur_id' => $modPenjualan->reseptur_id));
            // var_dump($modResepturDetail);die;
            $modInfoDataRI = FAObatalkesPasienT::model()->findByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
            $modInfoRI->no_pendaftaran = $modInfoDataRI->pendaftaran->no_pendaftaran;
            $modInfoRI->tgl_pendaftaran = $modInfoDataRI->pendaftaran->tgl_pendaftaran;
            $modInfoRI->ruangan_nama = $modInfoDataRI->pendaftaran->ruangan->ruangan_nama;
            $modInfoRI->instalasi_id = $modInfoDataRI->pendaftaran->instalasi_id;
            $modInfoRI->kelaspelayanan_nama = $modInfoDataRI->pendaftaran->kelaspelayanan->kelaspelayanan_nama;
            $modInfoRI->jeniskasuspenyakit_id = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_id;
            $modInfoRI->jeniskasuspenyakit_nama = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
            $modInfoRI->carabayar_nama = $modInfoDataRI->pendaftaran->carabayar->carabayar_nama;
            $modInfoRI->penjamin_nama = $modInfoDataRI->pendaftaran->penjamin->penjamin_nama;
            $modInfoRI->no_rekam_medik = $modInfoDataRI->pendaftaran->pasien->no_rekam_medik;
            $modInfoRI->namadepan = $modInfoDataRI->pendaftaran->pasien->namadepan;
            $modInfoRI->nama_pasien = $modInfoDataRI->pendaftaran->pasien->nama_pasien;
            $modInfoRI->nama_bin = $modInfoDataRI->pendaftaran->pasien->nama_bin;
            $modInfoRI->tanggal_lahir = MyFormatter::formatDateTimeForUser($modInfoDataRI->pendaftaran->pasien->tanggal_lahir);
            $modInfoRI->umur = $modInfoDataRI->pendaftaran->umur;
            $modInfoRI->jeniskelamin = $modInfoDataRI->pendaftaran->pasien->jeniskelamin;
            $modInfoRI->penanggungjawab_id = $modInfoDataRI->pendaftaran->penanggungjawab_id;
            $modInfoRI->alamat_pasien = $modInfoDataRI->pendaftaran->pasien->alamat_pasien;
        }

        $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
        if (!empty($pendaftaran_id)) {
            $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = FAPasienM::model()->findByPk($modPendaftaran->pasien_id);
        }

        $modAntrian->tglambilantrian = date('Y-m-d H:i:s');
        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
        $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
        $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
        $racikanDetail = array();
        foreach ($modRacikanDetail as $i => $mod) { //convert object to array
            $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
            $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
            $racikanDetail[$i]['qtymin'] = $mod->qtymin;
            $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
            $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
        }

        $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['FAPenjualanResepT'])) {
            // echo '<pre>';var_dump($_POST);die;
            $modPendaftaran = FAPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $modPenjualan = $this->savePenjualanResepRS($modPendaftaran, $_POST['FAPenjualanResepT']);

            if ($this->penjualantersimpan) {
                if (isset($_POST['FAObatalkesPasienT']) && count((array)$_POST['FAObatalkesPasienT']) > 0) {
                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                    $detailGroups = array();
                    foreach ($_POST['FAObatalkesPasienT'] AS $i => $postDetail) {
                        $modDetails[$i] = new FAObatalkesPasienT;
                        $modDetails[$i]->attributes = $postDetail;
                        $oa = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);
                        $modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
                        $modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                        $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
                        $modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
                        $modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
                        $modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
                        $modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
                        $modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
                        $modDetails[$i]->tglpelayanan = date("Y-m-d H:i:s");
                        $modDetails[$i]->r = "R/";
                        $modDetails[$i]->satuankecil_id = $oa->satuankecil_id;
                        $modDetails[$i]->permintaan_oa = MyFormatter::formatNumberForDb($modDetails[$i]->permintaan_oa);
                        if (!empty($_POST['obatlain'])){
                            $modDetails[$i]->obatalkes_nama = $_POST['obatlain'];
                        }
                        //$modDetails[$i]->qty_oa = $postDetail['qty_dilayani'];
                        //$modDetails[$i]->hargajual_oa = $postDetail['hargajual_reseptur'];
                        //$modDetails[$i]->harganetto_oa = $postDetail['harganetto_reseptur'];
                        //$modDetails[$i]->hargasatuan_oa = $postDetail['hargasatuan_reseptur'];
                        //$modDetails[$i]->signa_oa = $postDetail['signa_reseptur'];
                        $modDetails[$i]->create_time = date("Y-m-d H:i:s");
                        $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
                        $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
                        $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
                        $modDetails[$i]->qty_oa = MyFormatter::formatRupiahForDB($modDetails[$i]->qty_oa);
                        $modDetails[$i]->qty_jual = $modDetails[$i]->qty_oa;
                        $modDetails[$i]->kekuatan_oa = MyFormatter::formatRupiahForDB($modDetails[$i]->kekuatan_oa);
                        $modDetails[$i]->jumlahppn = $postDetail['jumlahppn'];
                        $modDetails[$i]->persenppnjual = $postDetail['ppnpersen'];

                        $modDetails[$i]->total_embalase = (!empty($postDetail['total_embalase'])?$postDetail['total_embalase']:0);
                        // $modDetails[$i]->persen_discount = $postDetail['persen_discount'];


                        $modDetails[$i]->jumlahpermintaan_obatracikan = !empty($postDetail['jumlahpermintaan_obatracikan']) ? $postDetail['jumlahpermintaan_obatracikan'] : "";
						$modDetails[$i]->jumlahpermintaan_obatnonracikan = !empty($postDetail['jumlahpermintaan_obatnonracikan']) ? $postDetail['jumlahpermintaan_obatnonracikan'] : "";
						$modDetails[$i]->satuansediaan = $postDetail['satuansediaan'];

                        $modDetails[$i]->permintaan_dosis = isset($postDetail['permintaan_dosis']) ? MyFormatter::formatNumberForDb($postDetail['permintaan_dosis']) : 0;
                        //insert pajak_id = 6 //pajak ppn
                        if(!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0){
                          $modDetails[$i]->pajak_id = 6; //pajak ppn
                        }
                        $modDetails[$i]->kadaluarsa = !empty($postDetail['kadaluarsa']) ? MyFormatter::formatDateTimeForDb($postDetail['kadaluarsa']) : null;
                        //var_dump($postDetail);
                        //var_dump($modPenjualan->attributes);
                        // var_dump($modDetails[$i]->attributes);
                        //var_dump($modDetails[$i]->validate());
                        //var_dump($modDetails[$i]->getErrors());
                        // die;


                        if ($modDetails[$i]->validate()) {

                            // var_dump($modDetails[$i]->attributes); die;

                            $this->obatalkespasientersimpan &= $modDetails[$i]->save();
                        } else {
                            $this->obatalkespasientersimpan &= false;
                        }

                        // var_dump($modDetails[$i]->attributes); die;

                        // die;
                        //var_dump($this->obatalkespasientersimpan);

                        $this->simpanStokObatAlkesOut2($modDetails[$i]);

                        /*
                          $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                          $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                          $obatalkes_id = $postDetail['obatalkes_id'];
                          if(isset($detailGroups[$obatalkes_id])){
                          $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                          }else{
                          $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                          $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                          } */
                    }

                    //END GROUP
                }
               
                if(isset($_POST['FAResepturDetailT']) && count((array)$_POST['FAResepturDetailT']) > 0) {
                    $this->simpanObatAlkesPasienDariReseptur($modPenjualan);
                }

                try {
                    if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
                        // SMS GATEWAY
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modPenjualan->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }

                            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPenjualan->tglpenjualan), $isiPesan);

                            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                if (!empty($modPasien->no_mobile_pasien)) {
                                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                } else {
                                    $smspasien = 0;
                                }
                            }
                        }

                        $modTindakan = new TindakanpelayananT;
                        $modTindakan->attributes = $modPendaftaran->attributes;
                        $modTindakan->daftartindakan_id = 74;
                        $modTindakan->penjualanresep_id = $modPenjualan->penjualanresep_id;
                        $modTindakan->tarif_tindakan = $modPenjualan->totalhargajual;
                        $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
                        $modTindakan->create_time = date('Y-m-d H:i:s');
                        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
                        $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

                        $modTindakan->qty_tindakan = 1;
                        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
                        $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
                        $modTindakan->discount_tindakan = 0;
                        $modTindakan->subsidiasuransi_tindakan = 0;
                        $modTindakan->subsidipemerintah_tindakan = 0;
                        $modTindakan->subsisidirumahsakit_tindakan = 0;
                        $modTindakan->iurbiaya_tindakan = 0;
                        $modTindakan->tarif_rsakomodasi = 0;
                        $modTindakan->tarif_medis = 0;
                        $modTindakan->tarif_paramedis = 0;
                        $modTindakan->tarif_bhp = 0;
                        $modTindakan->tarifcyto_tindakan = 0;


                        $modTindakan->satuantindakan = 'KALI'; 

                        $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

                        if(!empty($md_noawal)) {
                            $noawal = intval($md_noawal->nopelayanan) + 1;
                        } else {
                            $noawal = 1;
                        }
                    
                        $modTindakan->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);

                        $tindakantersimpan = $modTindakan->save();

						
                        if($tindakantersimpan) {
                            $this->broadcastPenjualanKeKasir($modPenjualan);
    
                            // END SMS GATEWAY
                            $transaction->commit();
							$this->setAPIPenjualanResepOA($modPenjualan, $modDetails);
                            $cekPenjualan = PenjualanresepT::model()->findByPk($modPenjualan->penjualanresep_id);
							if(!empty($cekPenjualan)) {
                                $sukses = 1;
                                $this->redirect(array('index', 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'sukses' => $sukses, 'smspasien' => $smspasien));
                            } else {
                                Yii::app()->user->setFlash('error', "Data gagal disimpan [4 Cek Log Api]!");
                            }
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan !");
                        if (!$this->stokobatalkestersimpan) {
                            Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:"); //.$obathabis);
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollback(); var_dump($e->getMessage()); die;
                    Yii::app()->user->setFlash('error', "Data penjualan resep gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'modReseptur' => $modReseptur,
            'modPendaftaran' => $modPendaftaran,
            'modInfoRI' => $modInfoRI,
            'modPasien' => $modPasien,
            'modPenjualan' => $modPenjualan,
            'modAntrian' => $modAntrian,
            'modObatAlkesPasien' => $modObatAlkesPasien,
            'racikan' => $racikan,
            'racikanDetail' => $racikanDetail,
            'nonRacikan' => $nonRacikan,
            'obatAlkes' => $modObatAlkes,
            'sukses' => $sukses,
            'modResepturDetail'=>$modResepturDetail,
            'konfigFarmasi' => $konfigFarmasi
        ));
    }

    function simpanObatAlkesPasienDariReseptur($modPenjualan) {
        // echo '<pre>';var_dump($_POST);die;
        foreach ($_POST['FAResepturDetailT'] AS $i => $postDetail) {
            $modDetails[$i] = new FAObatalkesPasienT;
            $modDetails[$i]->attributes = $postDetail;
            $oa = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);
            $modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
            $modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
            $modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
            $modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
            $modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
            $modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
            $modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
            $modDetails[$i]->tglpelayanan = date("Y-m-d H:i:s");
            $modDetails[$i]->r = "R/";
            $modDetails[$i]->satuankecil_id = $oa->satuankecil_id;
            $modDetails[$i]->permintaan_oa = MyFormatter::formatNumberForDb($modDetails[$i]->permintaan_oa);
            if (!empty($_POST['obatlain'])){
                $modDetails[$i]->obatalkes_nama = $_POST['obatlain'];
            }
            
            $modDetails[$i]->create_time = date("Y-m-d H:i:s");
            $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
            $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
            $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
            $modDetails[$i]->qty_oa = $postDetail['qty_reseptur'];
            $modDetails[$i]->qty_oa = MyFormatter::formatRupiahForDB($modDetails[$i]->qty_oa);
            $modDetails[$i]->qty_jual = MyFormatter::formatRupiahForDB($modDetails[$i]->qty_oa);
            $modDetails[$i]->kekuatan_oa = MyFormatter::formatRupiahForDB($modDetails[$i]->kekuatan_oa);
            $modDetails[$i]->jumlahppn = $postDetail['jumlahppn'];
            $modDetails[$i]->persenppnjual = $postDetail['ppnpersen'];

            $modDetails[$i]->total_embalase = (!empty($postDetail['total_embalase'])?$postDetail['total_embalase']:0);
            // $modDetails[$i]->persen_discount = $postDetail['persen_discount'];


            $modDetails[$i]->jumlahpermintaan_obatracikan = !empty($postDetail['jumlahpermintaan_obatracikan']) ? $postDetail['jumlahpermintaan_obatracikan'] : "";
            $modDetails[$i]->jumlahpermintaan_obatnonracikan = !empty($postDetail['jumlahpermintaan_obatnonracikan']) ? $postDetail['jumlahpermintaan_obatnonracikan'] : "";
            $modDetails[$i]->satuansediaan = isset($postDetail['satuansediaan']) ? $postDetail['satuansediaan'] : null;

            //insert pajak_id = 6 //pajak ppn
            if(!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0){
                $modDetails[$i]->pajak_id = 6; //pajak ppn
            }
            
            if ($modDetails[$i]->validate()) {
                $this->obatalkespasientersimpan &= $modDetails[$i]->save();
            } else {
                $this->obatalkespasientersimpan &= false;
            }

            $this->simpanStokObatAlkesOut2($modDetails[$i]);
            if(isset($postDetail['resepturdetail_id'])) {
                $modVerifikasiPenjualan = VerifikasipenjualanfarmasiT::model()->findByAttributes(['resepturdetail_id' => $postDetail['resepturdetail_id']]);
                $modVerifikasiPenjualan->is_jual = true;
                $modVerifikasiPenjualan->update();
            }
        }

    }

    /**
     * untuk melakukan penjualan dari reseptur (informasi pasien resep)
     * @param type $reseptur_id
     */
    // di komen karena dibuat controller baru
    // LNG-342
//    public function actionPenjualanDariReseptur($reseptur_id= null)
//    {
//        $sukses = false;
//        $modPendaftaran = new FAPendaftaranT;
//        $modInfoRI = new FAInfopasienmasukkamarV;
//        $modPasien = new FAPasienM;
//        $modReseptur = new FAResepturT;
//        $modAntrian = new FAAntrianFarmasiT;
//        $modDetailReseptur = array();
//        $modObatAlkesPasien =array();
//        $instalasi_id = Yii::app()->user->getState('instalasi_id');
//        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
//        $modReseptur->noresep_depan = $modReseptur->noresep.'/';
//        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null));
//        $modPenjualan = new FAPenjualanResepT;
//        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss','medium',null));
//        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss','medium',null));
//        $modPenjualan->noresep = $modReseptur->noresep;
//
//        $modPenjualan->totharganetto= 0;
//        $modPenjualan->totalhargajual= 0;
//        $modPenjualan->totaltarifservice= 0;
//        $modPenjualan->biayaadministrasi= 0;
//        $modPenjualan->biayakonseling= 0;
//        $modPenjualan->pembulatanharga= 0;
//        $modPenjualan->jasadokterresep= 0;
//        $modPenjualan->discount= 0;
//        $modPenjualan->subsidiasuransi= 0;
//        $modPenjualan->subsidipemerintah= 0;
//        $modPenjualan->subsidirs= 0;
//        $modPenjualan->iurbiaya= 0;
//
//        $modObatAlkes = array();
//
//
//
//        if (!empty($reseptur_id)) {
//            $modReseptur = FAResepturT::model()->findByPk($reseptur_id);
//            $modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id));
//        }
//
//        $modAntrian->tglambilantrian= date('Y-m-d H:i:s');
//        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
//            $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
//            $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
//            $racikanDetail = array();
//            foreach ($modRacikanDetail as $i => $mod){ //convert object to array
//                $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
//                $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
//                $racikanDetail[$i]['qtymin'] = $mod->qtymin;
//                $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
//                $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
//            }
//        $transaction = Yii::app()->db->beginTransaction();
//        if(isset($_POST['FAPenjualanResepT'])){
//
//            $modPendaftaran = FAPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
//            $modPenjualan = $this->savePenjualanResepRS($modPendaftaran,$_POST['FAPenjualanResepT'],$modReseptur);
//
//            if($this->penjualantersimpan){
//                if(count((array)$_POST['FAObatalkesPasienT']) > 0){
//                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
//                    $detailGroups = array();
//                    foreach($_POST['FAObatalkesPasienT'] AS $i => $postDetail){
//                        $modDetails[$i] = new FAObatalkesPasienT;
//                        $modDetails[$i]->attributes = $postDetail;
//                        $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
//                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
//                        $obatalkes_id = $postDetail['obatalkes_id'];
//                        if(isset($detailGroups[$obatalkes_id])){
//                            $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
//                        }else{
//                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
//                            $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
//                        }
//                    }
//                    //END GROUP
//                }
//
//                $obathabis = "";
//                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
//                foreach($detailGroups AS $i => $detail){
//                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
//                    if(count((array)$modStokOAs) > 0){
//                        foreach($modStokOAs AS $i => $stok){
//                            $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stok, $_POST['FAObatalkesPasienT'] );
//                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
//                        }
//                    }else{
//                        $this->stokobatalkestersimpan &= false;
//                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
//
//                    }
//                }
//
//                try {
//                    if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
//                        $transaction->commit();
//                        $sukses = 1;
//                        $this->redirect(array('index','penjualanresep_id'=>$modPenjualan->penjualanresep_id, 'sukses'=>$sukses));
//                    }else{
//                        $transaction->rollback();
//                        Yii::app()->user->setFlash('error',"Data detail penjualan resep gagal disimpan !");
//                        if(!$this->stokobatalkestersimpan){
//                            Yii::app()->user->setFlash('error',"Data ddetail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:".$obathabis);
//                        }
//                    }
//                } catch (Exception $e) {
//                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error',"Data penjualan resep gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
//                }
//            }
//        }
//        $this->render($this->path_view.'index',array(
//                                            'modReseptur'=>$modReseptur,
//                                            'modPendaftaran'=>$modPendaftaran,
//                                            'modInfoRI'=>$modInfoRI,
//                                            'modPasien'=>$modPasien,
//                                            'modPenjualan'=>$modPenjualan,
//                                            'modAntrian'=>$modAntrian,
//                                            'modObatAlkesPasien'=>$modObatAlkesPasien,
//                                            'racikan'=>$racikan,
//                                            'racikanDetail'=>$racikanDetail,
//                                            'nonRacikan'=>$nonRacikan,
//                                            'obatAlkes'=>$modObatAlkes,
//                                            'sukses'=>$sukses,
//                                            'modDetailReseptur'=>$modDetailReseptur,
//                                            ));
//    }

    protected function savePenjualanResepRS($modPendaftaran, $penjualanResep, $modReseptur = null) {
        
        $format = new MyFormatter();
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->attributes = $penjualanResep;
        $modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPenjualan->penjamin_id = $modPendaftaran->penjamin_id;
        $modPenjualan->carabayar_id = $modPendaftaran->carabayar_id;
        $modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null;
        $modPenjualan->pegawai_id = isset($_POST['FAPenjualanResepT']['pegawai_id']) ? $_POST['FAPenjualanResepT']['pegawai_id'] : $_POST['FAResepturT']['pegawai_id'];
        $modPenjualan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPenjualan->pasien_id = $modPendaftaran->pasien_id;
        $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array("pendaftaran_id" => $modPendaftaran->pendaftaran_id, "pasien_id" => $modPendaftaran->pasien_id));
        $modPenjualan->pasienadmisi_id = (empty($modPasienAdmisi->pasienadmisi_id)) ? null : $modPasienAdmisi->pasienadmisi_id;
        $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
        $modPenjualan->tglresep = date('Y-m-d H:i:s');
        $modPenjualan->ruanganasal_nama = Yii::app()->user->getState('ruangan_nama');
        $modPenjualan->instalasiasal_nama = Yii::app()->user->getState('instalasi_nama');
        $modPenjualan->reseptur_id = (!empty($modReseptur->reseptur_id) ? $modReseptur->reseptur_id : null);

        $modPenjualan->statusobat = isset($penjualanResep['statusobat']) ? $penjualanResep['statusobat'] : null;

        if (isset($_POST['ruangan_id'])) { //dari form
            $ruangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
            $modPenjualan->ruanganasal_nama = $ruangan->ruangan_nama;
            $modPenjualan->instalasiasal_nama = $ruangan->instalasi->instalasi_nama;
        }
        if (isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/2') { //dari form
            $modPenjualan->takaranresep = 0.5;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/3'){
            $modPenjualan->takaranresep = 0.3;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/4'){
            $modPenjualan->takaranresep = 0.25;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '2/3'){
            $modPenjualan->takaranresep = 0.67;
        }
        $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
        $modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'];
        $modPenjualan->subsidiasuransi = 0;
        $modPenjualan->subsidipemerintah = 0;
        $modPenjualan->subsidirs = 0;
        $modPenjualan->iurbiaya = 0;
        $modPenjualan->discount = 0;
        $modPenjualan->jasapelayanan_farmasi = isset($penjualanResep['jasapelayanan_farmasi']) ? $penjualanResep['jasapelayanan_farmasi'] : null;
        $modPenjualan->create_time = date("Y-m-d H:i:s");
        $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
        $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->jasapelayanan_farmasi = (!empty($penjualanResep['jasapelayanan_farmasi']) ? $penjualanResep['jasapelayanan_farmasi'] : 0);
        $modPenjualan->jasaembalase = isset($penjualanResep['jasaembalase']) ? $penjualanResep['jasaembalase'] : 0;
        $modPenjualan->totalkronis = isset($penjualanResep['totalkronis']) ? $penjualanResep['totalkronis'] : 0;
        $modPenjualan->totalinacbg = isset($penjualanResep['totalinacbg']) ? $penjualanResep['totalinacbg'] : 0;

        $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $modPenjualan->jenislayanan_inv = !empty($modRuangan->kodeJL_inventory) ? $modRuangan->kodeJL_inventory : '-';
        $modPenjualan->tempatlayanan_inv = !empty($modRuangan->kodeTL_inventory) ? $modRuangan->kodeTL_inventory : '-';
        $modPenjualan->kodedokter_inventory = '-';
        $modPenjualan->kodepetugas_inv = !empty($modPegawai->kodepetugas_inventory) ? $modPegawai->kodepetugas_inventory : '-';
        // echo "<pre>"; var_dump($modPenjualan->attributes);die;

        if ($modPenjualan->validate()) {
            $modPenjualan->save();
            PendaftaranT::model()->updateByPk($modPenjualan->pendaftaran_id, array('pembayaranpelayanan_id' => null));
            if (!empty($modReseptur->reseptur_id))
                ResepturT::model()->updateByPk($modReseptur->reseptur_id, array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
            $this->penjualantersimpan = true;
        } else {
            $this->penjualantersimpan = false;
            Yii::app()->user->setFlash('error', "Data Penjualan Resep Tidak valid");
            // echo '<pre>';var_dump($modPenjualan->getErrors());die;
        }

        return $modPenjualan;
    }

    /**
     * simpan ObatalkesPasienT Jumlah Out
     * @param type $modPenjualan
     * @param type $postObatAlkesPasien
     * @return \ObatalkesPasienT
     */
    protected function simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stokOa, $postObatAlkesPasien) {
        $format = new MyFormatter;
        $modObatAlkes = new FAObatalkesPasienT;
        $modObatAlkes->attributes = $stokOa->attributes;
        $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkes->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkes->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkes->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkes->create_time = date("Y-m-d H:i:s");
        $modObatAlkes->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkes->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->penjualanresep_id = $modPenjualan->penjualanresep_id;
        $modObatAlkes->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkes->jmlstok = $stokOa->qtystok;
        $modObatAlkes->harganetto_oa = $stokOa->HPP;
        $modObatAlkes->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkes->hargajual_oa = $modObatAlkes->hargasatuan_oa * $modObatAlkes->qty_oa;
        foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
                $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];
                $modObatAlkes->jmlstok = $postDetail['jmlstok'];
                $modObatAlkes->r = $postDetail['r'];
                $modObatAlkes->rke = $postDetail['rke'];
                $modObatAlkes->permintaan_oa = $postDetail['permintaan_oa'];
                $modObatAlkes->kekuatan_oa = $postDetail['kekuatan_oa'];
                $modObatAlkes->kekuatan_oa = str_replace(",", ".", $modObatAlkes->kekuatan_oa);
                $modObatAlkes->jmlkemasan_oa = $postDetail['jmlkemasan_oa'];

//                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
//                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
//                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
//                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
//                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
//                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
//                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
//                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
//                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
//                $modObatAlkes->iurbiaya = $postDetail['iurbiaya'];
//                $modObatAlkes->discount = $postDetail['discount'];
                $modObatAlkes->signa_oa = $postDetail['signa_oa'];
                $modObatAlkes->etiket = $postDetail['etiket'];
            }
        }

        if ($modObatAlkes->save()) {
            $this->obatalkespasientersimpan &= true;
        } else {
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkes;
    }

    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $modObatAlkesPasien
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien) {
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi();
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->tglstok_out = date('Y-m-d H:i:s'); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

        if ($modStokOaNew->validateStok()) {
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;
    }

    protected function simpanStokObatAlkesOut2($modObatAlkesPasien) {
        $format = new MyFormatter;
        //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
        $tglkadaluarsaData = StokobatalkesT::getTanggalKadaluarsaStok($modObatAlkesPasien->obatalkes_id, $modObatAlkesPasien->ruangan_id);

        //var_dump($tglkadaluarsa);die;
        //$data_kadaluarsa = StokobatalkesT::getTanggalKadaluarsaBerdasarkanStok($modObatAlkesPasien->obatalkes_id, $modObatAlkesPasien->ruangan_id,$modObatAlkesPasien->qty_oa);
        //var_dump($data_kadaluarsa);
        /* if (count((array)$data_kadaluarsa)>0){
          $qty_jual = ceil($modObatAlkesPasien->qty_oa);
          foreach ($data_kadaluarsa as $det){
          $modStokOaNew = new StokobatalkesT;
          $modStokOaNew->attributes = $oa->attributes;
          $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
          //$modStokOaNew->unsetIdTransaksi();
          //if (empty($oa->tglkadaluarsa)) {
          $modStokOaNew->tglkadaluarsa = $det['tglkadaluarsa'];
          //}
          $modStokOaNew->qtystok_in = 0;
          if ($det['stok'] <= $qty_jual){
          $qty_jual = $qty_jual - $det['stok'];
          $modStokOaNew->qtystok_out = $det['stok'];
          }else{
          $modStokOaNew->qtystok_out = $qty_jual;
          }
          //var_dump($modStokOaNew->qtystok_out);

          $modStokOaNew->qtystok_out = $qty_jual; //
          $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
          $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');

          $modStokOaNew->create_time = date('Y-m-d H:i:s');
          $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
          $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
          $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
          $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
          $modStokOaNew->persenppn = $oa->ppn_persen;
          $modStokOaNew->persenmargin = $oa->margin;

          //var_dump($modStokOaNew->attributes);die;
          //$modStokOaNew->validate();
          //var_dump($modStokOaNew->errors);

          // var_dump($modStokOaNew->attributes); die;

          if($modStokOaNew->validate()){
          $this->stokobatalkestersimpan &= $modStokOaNew->save();
          // $modStokOaNew->setStokOaAktifBerdasarkanStok();
          } else {
          $this->stokobatalkestersimpan &= false;
          }
          }
          }else{ */
        //var_dump($oa->attributes);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
        //$modStokOaNew->unsetIdTransaksi();
        if (!empty($tglkadaluarsaData)) {
            $modStokOaNew->tglkadaluarsa = $tglkadaluarsaData;
        } else {
            if (empty($oa->tglkadaluarsa)) {
                $modStokOaNew->tglkadaluarsa = date('Y-m-d', (time() + (2 * 265.5 * 24 * 3600)));
            }
        }
        //var_dump($tglkadaluarsaData);die;
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
        $modStokOaNew->persenppn = $oa->ppn_persen;
        $modStokOaNew->persenmargin = $oa->margin;

        //var_dump($modStokOaNew->attributes);die;
        //$modStokOaNew->validate();
        //var_dump($modStokOaNew->errors);
        // var_dump($modStokOaNew->attributes); die;

        if ($modStokOaNew->validate()) {
            $this->stokobatalkestersimpan &= $modStokOaNew->save();

            if (in_array($modStokOaNew->ruangan_id, array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1))) {
                StokobatalkesT::notifStokOALewatMinimalRuangan($modStokOaNew->obatalkes_id, $modStokOaNew->ruangan_id);
            }

            // $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        //}
        // var_dump($this->stokobatalkestersimpan);

        return $modStokOaNew;
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
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            if(empty($pasienadmisi_id) && !empty($modPendaftaran)) {
                $pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
            }
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
            }
            if (!empty($pasienadmisi_id)) {
                $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
            }
            // if (!empty($instalasi_id)) {
            //     $criteria->addCondition("instalasi_id = " . $instalasi_id);
            // }
            $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
            if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $model = FAInfoKunjunganRDV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = FAInfoKunjunganRJV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RI || in_array($instalasi_id, Params::INSTALASI_ID_RI_ARR)) {
                $model = FAInfopasienmasukkamarV::model()->find($criteria);
                if (empty($model)) {
                    $model = FAInfoKunjunganRJV::model()->find($criteria);
                }
            } else if ($instalasi_id == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
                $model = FAInfopasienmasukkamarV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
                $model = InfokunjunganhdV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
                $model = InfokunjunganpersalinanV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_REHAB) {
                $model = PasienmasukpenunjangV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_IBS) {
                $model = PasienmasukpenunjangV::model()->find($criteria);
            } else {
                $cr2 = new CDbCriteria;
                $cr2->compare("pendaftaran_id", $pendaftaran_id);
                $model = InfopasienpengunjungV::model()->find($cr2);
            }


            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            if ($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
              $pegRI = PegawaiM::model()->findByPk($model->dokterpenerima_id);
              if(!empty($pegRI)){
                $returnVal["nama_pegawai"] = $pegRI->namaLengkap;
                $returnVal["pegawai_id"] = $pegRI->pegawai_id;
              }
            }

            $returnVal["nama_pasien"] = $model->namadepan . $model->nama_pasien;
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $statusperiksa = $returnVal["statusperiksa"];

            $tindbayar = false;
            $oabayar = false;
            if (!empty($returnVal["pendaftaran_id"])) {
                $cek = ObatalkespasienT::model()->find(" pendaftaran_id = '" . $returnVal["pendaftaran_id"] . "' AND oasudahbayar_id IS NOT NULL ");

                if (!empty($cek)) {
                    $oabayar = true;
                }

                $cekTin = TindakanpelayananT::model()->find(" pendaftaran_id = '" . $returnVal["pendaftaran_id"] . "' AND tindakansudahbayar_id IS NOT NULL ");

                if (!empty($cekTin)) {
                    $tindbayar = true;
                }
            }

            $returnVal["lanjut_transaksi"] = false;

            if ($instalasi_id == Params::INSTALASI_ID_RD) { // || $instalasi_id == Params::INSTALASI_ID_RJ) {
                if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) && (($oabayar == true || $tindbayar == true))) {
                    $returnVal["lanjut_transaksi"] = true;
                } elseif (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) && (($oabayar == true || $tindbayar == true))) {
                    $returnVal["lanjut_transaksi"] = true;
                } else {
                    if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG)) {
                        $returnVal["lanjut_transaksi"] = true;
                    } else {
                        if ((($oabayar == true || $tindbayar == true))) {
                            $returnVal["lanjut_transaksi"] = true;
                        }
                    }
                }
            }
            $returnVal['rowObat'] = '';
            // untuk set row penjualan obat
            $modVerifikasiPenjualan = VerifikasipenjualanfarmasiT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id, 'is_jual' => false]);
            // echo '<pre>';var_dump($modVerifikasiPenjualan);die;
            $arr_resepturdetail_id = [];
            $reseptur_id = '';
            if(!empty($modVerifikasiPenjualan)) {
                foreach ($modVerifikasiPenjualan as $i => $data) {
                    $arr_resepturdetail_id[] = $data->resepturdetail_id;
                    $reseptur_id = $data->reseptur_id;
                }
            }

            // echo '<pre>';var_dump($arr_resepturdetail_id);die;
            $modReseptur = ResepturT::model()->findByPk($reseptur_id);
            $modPendaftaran = $model;
            $modObatAlkesPasien = new FAObatalkesPasienT();
            $criteria = new CDbCriteria();
            $criteria->addInCondition('resepturdetail_id', array_merge($arr_resepturdetail_id));
            // echo '<pre>';var_dump($criteria);die;
            $modDetailReseptur = FAResepturDetailT::model()->findAll($criteria);
            // echo '<pre>';var_dump($modDetailReseptur);die;
            $konfigFarmasi = KonfigfarmasiK::model()->find();

            if(!empty($modDetailReseptur)) {
                foreach ($modDetailReseptur as $ii => $detail) {
    
                    $terapi = TherapimapobatM::model()->findByAttributes(array(
                        'obatalkes_id' => $detail->obatalkes_id,
                    ));
                    $modOA = FAObatalkesM::model()->findByPk($detail->obatalkes_id);
                    $modDetailReseptur[$ii]->hargasatuan_reseptur = $detail->hargasatuan_reseptur;
                    $modDetailReseptur[$ii]->hargajual_reseptur = $detail->hargajual_reseptur;
                    $modDetailReseptur[$ii]->persen_discount = $detail->persdiskon;
                    // set verifikasi menjadi kosong
                    $modDetailReseptur[$ii]->is_verifkasiapoteker = '';
        
                    $modDetailReseptur[$ii]->ppnpersen = $detail->persenppnjual;
                    $modDetailReseptur[$ii]->jumlahppn = $detail->jumlahppn;
                    $modDetailReseptur[$ii]->subtotal = $detail->hargajual_reseptur;
                    $modDetailReseptur[$ii]->biayaadministrasi = $detail->biayaadministrasi;
                    $modDetailReseptur[$ii]->ppnpersen = 0;
                    if (!in_array($modOA->jenisobatalkes_id, array(Params::JENISOBATALKES_ID_ALKES, Params::JENISOBATALKES_ID_BHP))) {
                        if ($instalasi_id == Params::INSTALASI_ID_RJ || $instalasi_id == Params::INSTALASI_ID_HD || $instalasi_id == 74) {
                            $modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->rj_persjualppn;
                        } else if ($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
                            $modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->ri_persjualppn;
                        } else if ($instalasi_id == Params::INSTALASI_ID_RD || $instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
                            $modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->rd_persjualppn;
                        } else {
                            $modDetailReseptur[$ii]->ppnpersen = 0;
                        }
                    }
        
                    $penjamin_id = !empty($model->pasienadmisi_id) ? $model->penjamin_id : $model->penjamin_id;
        
                    // if ($konfigFarmasi->ishargaperpenjamin == true) {
                    // 	if (!empty($modPendaftaran->pen																								jamin_id)) {
                    $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $detail->obatalkes->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));
                    $persmargin = !empty($obatalkesPenjamin->persmargin) ? $obatalkesPenjamin->persmargin : 0;
                    // 		if (!empty($obatalkesPenjamin)) {
                    $marginRp = round((($detail->obatalkes->hargajual * $persmargin) / 100), 2);
                    $hargaSatuan = round(($detail->obatalkes->hargajual + $marginRp), 2);
                    // 			$modDetailReseptur[$ii]->hargasatuan_reseptur = $hargaSatuan;
                    // 			$modDetailReseptur[$ii]->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
                    // 			$modDetailReseptur[$ii]->persen_discount = $obatalkesPenjamin->persdiskon;
                    // 		}
                    // 	}
                    // }
        
                    $modDetailReseptur[$ii]->jumlahppn = $hargaSatuan * $modDetailReseptur[$ii]->ppnpersen;
                    $modDetailReseptur[$ii]->hargasatuan_reseptur = $detail->hargasatuan_reseptur;
                    $modDetailReseptur[$ii]->hargajual_reseptur = $detail->hargajual_reseptur;
        
                    // $modDetailReseptur[$ii]->subtotal = $detail->hargajual_reseptur;
                    $modDetailReseptur[$ii]->qty_dilayani = ceil($detail->qty_reseptur);
        
                    $modDetailReseptur[$ii]->harganetto_reseptur = round($modOA->harganetto);
                    $modDetailReseptur[$ii]->jasadokterresep = $modOA->jasadokter;
                    $modDetailReseptur[$ii]->discount = $modOA->discount;
                    $modDetailReseptur[$ii]->iurbiaya = $modDetailReseptur[$ii]->hargasatuan_reseptur * $modDetailReseptur[$ii]->qty_reseptur;
        
                    if (!empty($terapi)) {
                        $modDetailReseptur[$ii]->therapiobat_id = $terapi->therapiobat_id;
                    }
        
                    $modFormularium = FormulariumobatM::model()->findByAttributes([
                        'obatalkes_id' => $detail->obatalkes_id,
                        'carabayar_id' => $modReseptur->pendaftaran->carabayar_id,
                        'penjamin_id' => $modReseptur->pendaftaran->penjamin_id,
                    ]);
        
                    $modDetailReseptur[$ii]->formulariumobat_id = !empty($modFormularium) ? $modFormularium->formulariumobat_id : null;
        
        
                    $ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($modDetailReseptur[$ii]->obatalkes_id, $modDetailReseptur[$ii]->qty_reseptur, $ruangan_id);
                }
            }
            $ObatAPI = new ObatAPI;
            if (count((array)$modDetailReseptur) > 0) {
                foreach ($modDetailReseptur as $ii => $modDetail) {
                    $dataObatApi = $ObatAPI->searchStokDariApi($modDetail->obatalkes->obatalkes_nama, $modDetail->sumberdana_id);
                    $modDetail->jmlstok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0 ;
                    $modDetail->tglkadaluarsa = StokobatalkesT::getTanggalKadaluarsaStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $modDetail->tglkadalprev = StokobatalkesT::getTanggalKadaluarsaPrev($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $modDetail->hargasatuan_reseptur = is_numeric($modDetail->hargasatuan_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargasatuan_reseptur, 2) : $modDetail->hargasatuan_reseptur;
                    $modDetail->hargajual_reseptur = is_numeric($modDetail->hargajual_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargajual_reseptur, 2) : $modDetail->hargajual_reseptur;
                    // $modDetail->qty_reseptur = is_numeric($modDetail->qty_reseptur) ? number_format($modDetail->qty_reseptur, 2, ",", "") : $modDetail->qty_reseptur;
                    $modDetail->qty_dilayani = is_numeric($modDetail->qty_dilayani) ? number_format($modDetail->qty_dilayani, 2, ",", "") : $modDetail->qty_dilayani;
                    $modDetail->is_obatkronis = !empty($modDetail->formulaobatkronis_id) ? true : false;
                    $modDetail->is_tanggungan = 0;
                    $modDetail->st_fornas = ($modDetail->st_fornas == true ? 1 : 0);
                    $modDetail->subtotal = $modDetail->hargasatuan_reseptur;

                    $modKronis = FormulaobatkronisM::model()->findByPk($modDetail->formulaobatkronis_id);
                    if (!empty($modKronis)) {
                        $modDetail->jml_min = $modKronis->jumlahobat_minimal;
                        $modDetail->jml_max = $modKronis->jumlahobat_maksimal;
                    }
                    if (!empty($modDetail->permintaandosis_penyebut) && !empty($modDetail->permintaandosis_pembilang)) {
                        $modDetail->is_permitaandosispecahan = 1;
                    }

                    // $modDetail->hargajual_reseptur = round($modDetail->hargajual_reseptur);
                    $returnVal['rowObat'] .= $this->renderPartial($this->path_view . '_rowDetailDariVerif', array('modResepturDetail' => $modDetail, 'modObatAlkesPasien' => $modObatAlkesPasien, 'ii' => $ii, 'modPendaftaran' => $modPendaftaran, 'modReseptur' => $modReseptur), true);
                }
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * menampilkan obat
     * @return row table
     */
    public function actionSetFormObatAlkesPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = str_replace(",", ".", trim($_POST['jumlah']));
            $therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
            $penggunaan_oa = isset($_POST['penggunaan_oa']) ? $_POST['penggunaan_oa'] : null;
            $racikan = isset($_POST['racikan']) ? $_POST['racikan'] : false;
            $instalasi = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
            $is_kronis = isset($_POST['is_kronis'])?$_POST['is_kronis']:null;
            $formulaobatkronis_id = isset($_POST['formulaobatkronis_id'])?$_POST['formulaobatkronis_id']:null;
            $satuansediaan = isset($_POST['satuansediaan']) ? $_POST['satuansediaan'] : null;
            $jmlkemasan = isset($_POST['jmlkemasan']) ? $_POST['jmlkemasan'] : 0;
            $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;
            $obatlain = isset($_POST['obatlain']) ?"(".$_POST['obatlain'].")": '';
            $dosispermintaan = isset($_POST['dosispermintaan']) ? $_POST['dosispermintaan'] : '';

            $st_fornas = isset($_POST['st_fornas']) ? $_POST['st_fornas']: '';
            $sumberdana_id = isset($_POST['sumberdana_id']) ? $_POST['sumberdana_id']: '';
            $hargasatuan_reseptur = isset($_POST['hargasatuan_reseptur']) ? $_POST['hargasatuan_reseptur']: 0;
            // var_dump($obatlain);die;
            // var_dump($st_fornas, $sumberdana_id, $hargasatuan_reseptur, $satuansediaan, $jmlkemasan);die;


            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modResepturDetail = new FAResepturDetailT;
            $modObatAlkesPasien = new FAObatalkesPasienT;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            // $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            $modeObatApi = new ObatAPI();
            $dataObatApi = $modeObatApi->searchStokByDepo($oa->sumberdana_id, $oa->kodeobat_inventory);
            $jmlStok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0;
            // echo '<pre>';var_dump($dataObatApi);die;
            $hargajual = $this->cekHargaJualBerdasarkanInstalasi($oa, $instalasi);
            $modResepturDetail->obatalkes_id = $oa->obatalkes_id;
            $modResepturDetail->obatalkes_nama = $oa->obatalkes_nama."".$obatlain."";
            $modResepturDetail->sumberdana_id = $sumberdana_id;
            $modResepturDetail->satuankecil_id = $oa->satuankecil_id;
                $modResepturDetail->racikan_id = ($racikan == 0) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
            $modResepturDetail->r = 'R/';
            $modResepturDetail->qty_reseptur = number_format($jumlah, 2, ",", "");
            $modResepturDetail->jmlstok = $jmlStok;
            $modResepturDetail->kekuatan_reseptur = $oa->kekuatan;
            $modResepturDetail->satuankekuatan = $oa->satuankekuatan;
            $modResepturDetail->is_obatkronis = $is_kronis;
            $modResepturDetail->formulaobatkronis_id = $formulaobatkronis_id;
            //$modResepturDetail->dosis = $dosis;
            //$modResepturDetail->etiketwaktu = $etiketwaktu;
            //$modResepturDetail->resepturketerangan = $resepturketerangan;

            if(!empty($sumberdana_id)) {
                $modSumber = SumberdanaM::model()->findByPk($sumberdana_id);
                if(!empty($modSumber)) {
                    $modObatAlkesPasien->sumberdana_nama = $modSumber->sumberdana_nama;
                }
            }
            // var_dump($modObatAlkes->hpp);
            $instalasi = Yii::app()->user->getState('instalasi_id');

            $konfigFarmasi = KonfigfarmasiK::model()->find();
            if($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74){
                $modResepturDetail->persenppnjual = $konfigFarmasi->rj_persjualppn;
            }else if($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF){
                $modResepturDetail->persenppnjual = $konfigFarmasi->ri_persjualppn;
            }else if($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN){
                $modResepturDetail->persenppnjual = $konfigFarmasi->rd_persjualppn;
            }else{
                $modResepturDetail->persenppnjual = 0;
            }

            $modObatAlkesPasien->st_fornas = $st_fornas;
            //if(count((array)$modStokOAs) > 0){
            //    foreach($modStokOAs AS $i => $stok){
            $modObatAlkesPasien->sumberdana_id = $sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
            $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
            $modObatAlkesPasien->qty_oa = $jumlah; //ceil($stok->qtystok_terpakai); 
            $modObatAlkesPasien->jumlahpermintaan_obatracikan = $jumlah; 
            $modObatAlkesPasien->jumlahpermintaan_obatnonracikan = $jumlah; 
            $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama."".$obatlain."";
            // LNG Ceil (Pembulatan keatas request pak tito)
            $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
            //$modObatAlkesPasien->hargasatuan_oa = round($hargajual); //$stok->HargaJualSatuan;
            $modObatAlkesPasien->hargasatuan_oa = $hargasatuan_reseptur;
            $modObatAlkesPasien->jmlstok = $jmlStok;
            $modObatAlkesPasien->r = 'R/';
            //$modObatAlkesPasien->hargajual_oa = floor($jumlah * $modObatAlkesPasien->hargasatuan_oa * 100) / 100;
            $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
            $modObatAlkesPasien->biayaservice = 0;
            $modObatAlkesPasien->biayakonseling = 0;
            $modObatAlkesPasien->jasadokterresep = 0;
            $modObatAlkesPasien->biayakemasan = 0;
            $modObatAlkesPasien->biayaadministrasi = 0;
            $modObatAlkesPasien->permintaan_dosis = $dosispermintaan;
            $modObatAlkesPasien->tarifcyto = 0;
            $modObatAlkesPasien->discount = 0;
            $modObatAlkesPasien->subsidiasuransi = 0;
            $modObatAlkesPasien->subsidipemerintah = 0;
            $modObatAlkesPasien->subsidirs = 0;
            $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
            $modObatAlkesPasien->therapiobat_id = $therapiobat_id;
            $modObatAlkesPasien->ket_penggunaan = $penggunaan_oa;
            $modObatAlkesPasien->racikan_id = $racikan == "true" ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

            $modObatAlkesPasien->is_obatkronis = $is_kronis;
            $modObatAlkesPasien->formulaobatkronis_id = $formulaobatkronis_id;

            $modObatAlkesPasien->keterangan = $keterangan;
            
            $modObatAlkesPasien->admracikan = $konfigFarmasi->admracikan;
		    $modObatAlkesPasien->administrasi = $konfigFarmasi->administrasi;

            if($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74){
              $modObatAlkesPasien->ppnpersen = $konfigFarmasi->rj_persjualppn;
            }else if($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF){
              $modObatAlkesPasien->ppnpersen = $konfigFarmasi->ri_persjualppn;
            }else if($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN){
              $modObatAlkesPasien->ppnpersen = $konfigFarmasi->rd_persjualppn;
            }else{
                $modObatAlkesPasien->ppnpersen = 0;
            }
            $modObatAlkesPasien->jumlahppn = 0;

            $modResepturDetail->hargasatuan_reseptur = $hargasatuan_reseptur;
            $modResepturDetail->biayaadministrasi = 0;
            $modResepturDetail->persdiskon = 0;
            if($konfigFarmasi->ishargaperpenjamin == true){
                if(!empty($penjamin_id)){
                    $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id'=>$oa->jenisobatalkes_id,'penjamin_id'=>$penjamin_id));

                    if(!empty($obatalkesPenjamin)){
                        $marginRp = round((($oa->hpp * $obatalkesPenjamin->persmargin)/100),2);
                        $hargaSatuan = round(($oa->hpp + $marginRp),2);
                        $modObatAlkesPasien->hargasatuan_oa = $hargaSatuan;
                        $modObatAlkesPasien->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
                        $modObatAlkesPasien->persen_discount = $obatalkesPenjamin->persdiskon;
                    }    
                }
            }

            //jasafarmasi
            $jasafarmasi = null;
            if(!empty($penjamin_id)){
                $jasafarmasi = JasafarmasiM::model()->findByAttributes(array('penjamin_id'=>$penjamin_id));
            }
            if(empty($jasafarmasi)){
                $criteriajasa = new CDbCriteria();
                $criteriajasa->addCondition('penjamin_id is null');
                $criteriajasa->limit = 1;
                $jasafarmasi = JasafarmasiM::model()->find($criteriajasa);
            }

            if(!empty($jasafarmasi)){
                $modObatAlkesPasien->jasapelayanan_farmasi = $jasafarmasi->tarif_jasa;
            }
            $modObatAlkesPasien->jasapelayanan_farmasi = MyFormatter::formatNumberForPrint($modObatAlkesPasien->jasapelayanan_farmasi, 2);

            $modObatAlkesPasien->total_embalase = 0;
            
            if(!empty($satuansediaan)){
                $lookup = LookupM::model()->findByAttributes(array('lookup_type'=>Params::LOOKUPTYPE_SEDIAANOBATRACIKAN,'lookup_name'=>$satuansediaan));
                
                if(!empty($lookup)){
                    $nominal = (is_numeric($lookup->lookup_value)?$lookup->lookup_value:0);
                    $jmlembalase = round(($nominal * $jmlkemasan),2);
                    $modObatAlkesPasien->total_embalase = $jmlembalase;
                }
            }

            $modObatAlkesPasien->satuansediaan = $satuansediaan;

            $modObatAlkesPasien->hargasatuan_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargasatuan_oa, 2);
            $modObatAlkesPasien->qty_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->qty_oa, 2);
            // $modResepturDetail->save();

            $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modObatAlkesPasien' => $modObatAlkesPasien,'modResepturDetail'=>$modResepturDetail), true);
            //    }
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function cekHargaJualBerdasarkanInstalasi($oa, $instalasi = null) {

        $hargajual = $oa->hargajual;

        $konfig = KonfigfarmasiK::model()->find();

        if (in_array($instalasi, array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_REHAB, Params::INSTALASI_ID_HD))) {
            if (!empty($konfig) && !empty($konfig->rj_persjualppn)) {
                $hargajual += $hargajual * $konfig->rj_persjualppn / 100;
            }
        } else if (in_array($instalasi, array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) {
            if (!empty($konfig) && !empty($konfig->ri_persjualppn)) {
                $hargajual += $hargajual * $konfig->ri_persjualppn / 100;
            }
        } else if (in_array($instalasi, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) {
            if (!empty($konfig) && !empty($konfig->rd_persjualppn)) {
                $hargajual += $hargajual * $konfig->rd_persjualppn / 100;
            }
        }
        return $hargajual;
    }

    /**
     * untuk menampilkan data kunjungan dari autocomplete
     * - no_pendaftaran
     * - no_rekam_medik
     * - nama_pasien
     */
    public function actionAutocompleteInfoPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $models = FAInfoKunjunganRDV::model()->findAll($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $models = FAInfoKunjunganRJV::model()->findAll($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
                $models = FAInfopasienmasukkamarV::model()->findAll($criteria);
            } else {
                $models = FAInfopasienmasukkamarV::model()->findAll($criteria); //default
            }
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pendaftaran;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutocompleteObatReseptur() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = explode(';', $_GET['term']);
            $obatalkes_nama = isset($term[0]) ? $term[0] : '';
            $hargajual = isset($term[1]) ? $term[1] : '';
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
            if ($hargajual != '') {
                $criteria->addCondition('hargajual =' . $hargajual, 'or');
            }
            $criteria->addCondition('obatalkes_farmasi = TRUE');
            $criteria->addCondition('obatalkes_aktif = true');
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 15;
            $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
            $persenjual = $this->persenJualRuangan();
            $format = new MyFormatter();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
                $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
                $returnVal[$i]['qtyStok'] = $qtyStok;
                $returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
                $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
                $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
                $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
                $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    protected function persenJualRuangan() {
        switch (Yii::app()->user->getState('instalasi_id')) {
            case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
                break;
            case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
                break;
            case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
                break;
            default : $persen = 0;
                break;
        }

        return $persen;
    }

    /**
     * untuk print data penjualan dokter
     */
    public function actionPrint($penjualanresep_id, $caraPrint = null) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

        $judul_print = 'RINCIAN PENJUALAN RESEP RUMAH SAKIT';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }

        $this->render($this->path_view . 'Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPenjualan' => $modPenjualan,
            'modPenjualanDetail' => $modPenjualanDetail,
            'caraPrint' => $caraPrint
        ));
    }


    /**
     * untuk print data penjualan dokter
     */
    public function actionPrintTindakan($penjualanresep_id, $caraPrint = null) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

        $modTindakan = TindakanpelayananT::model()->find("penjualanresep_id = $modPenjualan->penjualanresep_id and daftartindakan_id = 74");

        $judul_print = 'NOTA TINDAKAN / PEMERIKSAAN / PEL. LAIN';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }

        $this->render($this->path_view . 'PrintTindakan', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPenjualan' => $modPenjualan,
            'modPenjualanDetail' => $modPenjualanDetail,
            'modTindakan' => $modTindakan,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * untuk print data penjualan dokter
     */
    public function actionPrintnew($penjualanresep_id, $caraPrint = null)
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPenjualan->printed_by = isset($modPenjualan->printed_by) ? $modPenjualan->printed_by + 1 : 0;
        $modPenjualan->save();

        $crit = new CDbCriteria();
        $crit->addCondition('penjualanresep_id = ' . $penjualanresep_id);
        // $crit->addCondition('is_ditanggungpasien <> true');
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAll($crit);
        $modPendaftaran = PendaftaranT::model()->findByattributes(array('pendaftaran_id' => $modPenjualanDetail[0]->pendaftaran_id));
        $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);

        $judulLaporan = 'RINCIAN PENJUALAN RESEP RUMAH SAKIT';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print_new', array(
                'judulLaporan' => $judulLaporan, 'modPenjualan' => $modPenjualan,
                'modPenjualanDetail' => $modPenjualanDetail,
                'caraPrint' => $caraPrint
            ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print_new', array(
                'judulLaporan' => $judulLaporan, 'modPenjualan' => $modPenjualan,
                'modPenjualanDetail' => $modPenjualanDetail,
                'caraPrint' => $caraPrint
            ));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $posisi = 'P';                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', [217, 140]);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLFooter('<span></span>');
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 10, 10, 10, 10);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print_new', array(
                'judulLaporan' => $judulLaporan,
                'caraPrint' => $caraPrint,
                'modPenjualan' => $modPenjualan,
                'modPenjualanDetail' => $modPenjualanDetail,
                'caraPrint' => $caraPrint
            ), true));
            $mpdf->Output();
        }
    }

    /**
     * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
     */
    public function actionSetTanggalLahir() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * set umur dari tanggal lahir (date)
     */
    public function actionSetUmur() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['umur'] = null;
            if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
                $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * menghitung proporsi obat
     */
    public function actionSetProporsiTakaranResep() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $takaran = $_POST['takaran'];
            parse_str($_POST['data'], $dataOAs);
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jml jika obat sama
            $detailGroups = array();
            if(!empty($dataOAs['FAObatalkesPasienT'])){
                foreach ($dataOAs['FAObatalkesPasienT'] AS $i => $postDetail) {
                    $obatalkes_id = $postDetail['obatalkes_id'];
                    if (isset($detailGroups[$obatalkes_id])) {
                        $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                    } else {
                        $detailGroups[$obatalkes_id] = $postDetail;
                        $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                    }
                }
            }
            
            //END GROUP
            //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
            $form = "";
            foreach ($detailGroups AS $i => $detail) {
                $qtyoa = round(((int)$detail['qty_oa'] * (int)$takaran), 2);
                $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $qtyoa, Yii::app()->user->getState('ruangan_id'));
                if (count((array)$modStokOAs) > 0) {
                    foreach ($modStokOAs AS $i => $stok) { //copy dari function actionSetFormObatAlkesPasien
                        $modObatAlkesPasien = new FAObatalkesPasienT;
                        $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                        $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
                        $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
                        $modObatAlkesPasien->harganetto_oa = $stok->HPP;
                        $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
                        $modObatAlkesPasien->jmlstok = $stok->qtystok;
                        $modObatAlkesPasien->r = 'R/';
                        $modObatAlkesPasien->rke = $detail['rke'];
                        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
                        $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
                        $modObatAlkesPasien->biayaservice = 0;
                        $modObatAlkesPasien->biayakonseling = 0;
                        $modObatAlkesPasien->jasadokterresep = 0;
                        $modObatAlkesPasien->biayakemasan = 0;
                        $modObatAlkesPasien->biayaadministrasi = 0;
                        $modObatAlkesPasien->tarifcyto = 0;
                        $modObatAlkesPasien->discount = 0;
                        $modObatAlkesPasien->subsidiasuransi = 0;
                        $modObatAlkesPasien->subsidipemerintah = 0;
                        $modObatAlkesPasien->subsidirs = 0;
                        $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;

                        $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
                    }
                }
            }
            $data['form'] = $form;
            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * method to get Therapi Obat
     * made for : LNG Projects
     * LNG-321
     */
    public function actionAutoCompleteTherapiObat() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = $_GET['term'];
            $criteria = new CDbCriteria();
            $criteria->addCondition("therapiobat_nama ILIKE '%" . $term . "%'");
            $criteria->addCondition('therapiobat_aktif = true');
            $models = FATherapiobatM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->therapiobat_nama;
                $returnVal[$i]['value'] = $model->therapiobat_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionSetTherapiobatid() {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $modTherapi = FATherapimapobatM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));
            if (!empty($modTherapi)) {
                $data = $modTherapi->therapiobat_id;
            } else {
                $data = null;
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionSetDropdownRke() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            $rmax = isset($_POST['rmax']) ? $_POST['rmax'] : null;
            if (!empty($rmax)) {
                for ($i = $rmax + 1; $i <= 20; $i++) {
                    $data .= CHtml::tag('option', array('value' => $i), CHtml::encode($i), true);
                }
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionListDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            if (isset($_GET['term'])) {
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            }
            //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai';
            if (isset($_GET['idPegawai'])) {
                $criteria->compare('pegawai_id', $_GET['idPegawai']);
            }
            $criteria->addCondition('kelompokpegawai_id = 1');
            $criteria->select = 'gelardepan, nama_pegawai, gelarbelakang_nama, pegawai_id';
            $criteria->group = 'gelardepan, nama_pegawai, gelarbelakang_nama, pegawai_id';
            $models = DokterV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function broadcastPenjualanKeKasir($modPenjualan) {
        // var_dump($modPenjualan->attributes);

        $pegawai = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
        $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);

        $ruanganKasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

        $judul = "Penjualan Resep Pasien - ".$modPenjualan->noresep;
        $isi = "Tgl. Penjualan : ".MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan)."<br/>";
        $isi .= "Pasien : ".(empty($pasien) ? "-" : ($pasien->no_rekam_medik." - ".$pasien->nama_pasien))."<br/>";
        $isi .= "Dokter Resep : ".(empty($pegawai) ? "-" : $pegawai->namaLengkap)."<br/>";


        // $isi = $pegawai->namaLengkap . " - " . $pasien->no_rekam_medik . " - " . $pasien->namadepan . $pasien->nama_pasien;

        CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruanganKasir->instalasi_id, 'ruangan_id' => $ruanganKasir->ruangan_id, 'modul_id' => $ruanganKasir->modul_id),
            array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
        ));

        // var_dump($isi);
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     *
     * Mengambil data lookup signa untuk autocomplete
     *
     * @param string $term input dari textfield autocomplete untuk memfilter nama lookup-nya.
     */
    public function actionGetSignaFarmasi($term = null) {
        $cr = new CDbCriteria();
        $cr->compare('lookup_type', 'signa_oa');
        $cr->compare('lower(lookup_name)', strtolower($term), true);
        $cr->addCondition('lookup_aktif = true');
        $cr->order = 'lookup_urutan';

        $signa = LookupM::model()->findAll($cr);

        $res = array();
        foreach ($signa as $item) {
            $res[] = array('label' => $item->lookup_name, 'value' => $item->lookup_name);
        }

        echo CJSON::encode($res);
    }

    public function actionKronis() {
        $this->layout = '//layouts/iframe';
        $model = new FormulaobatkronisM;
        if(isset($_GET['formulaobatkronis_id'])){
            $model = FormulaobatkronisM::model()->findByPk($_GET['formulaobatkronis_id']);
        }
        
        if (!empty($_POST['FormulaobatkronisM'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            try {
                $model = new FormulaobatkronisM;
                $model->attributes = $_POST['FormulaobatkronisM'];
                $model->is_aktif = true;
                $model->create_time = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan ! ");
                    $this->redirect(array('kronis', 'formulaobatkronis_id' => $model->formulaobatkronis_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . $ex->getMessage());
            }
        }
    
        $this->render($this->path_view . "kronis", array(
            'model' => $model,
        ));
    }

    public function actionSetListKronis()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $jumlah = $_POST['jumlah'];
        $formulaobatkronis_id = $_POST['formulaobatkronis_id'];

        $penjamins = FormulaobatkronisM::model()->findAllByAttributes(array('is_aktif' => true), array('order' => 'jumlahobat asc'));
        $option = "";
        foreach ($penjamins as $key => $value) {
            $name = $value->jumlahobat_minimal . ' / ' . $value->jumlahobat_maksimal;

            if ($value->formulaobatkronis_id == $formulaobatkronis_id)
            $option .= CHtml::tag('option', array('value' => $value->formulaobatkronis_id, 'selected' => true), CHtml::encode($name), true);
            else
            $option .= CHtml::tag('option', array('value' => $value->formulaobatkronis_id), CHtml::encode($name), true);
        }

        $dataList['listKronis'] = $option;

        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionPrintTelaah($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);

		$rke_max = ObatalkespasienT::model()->find("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke desc");
		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");

		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");
		$modResepturDet2 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 2 order by rke, obatalkespasien_id asc");
		$modPendaftaran = $modPenjualan->pendaftaran;
		$modPasien = $modPenjualan->pasien;
		$modSep = $modPendaftaran->sepTs ?? null;
		$modAnamnesa = AnamnesaT::model()->findAll("pendaftaran_id = $modPendaftaran->pendaftaran_id and riwayatalergiobat is not null");
		$modFisik = PemeriksaanfisikT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id order by pemeriksaanfisik_id desc");

		$view = "PrintTelaah";



		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(120, 540));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->WriteHTML(
			$this->renderPartial($view, array(
				'format' => $format,
				'modPenjualan' => $modPenjualan,
				'modReseptur' => $modReseptur,
				'modResepturDet1' => $modResepturDet1,
				'modResepturDet2' => $modResepturDet2,
				'modPendaftaran' => $modPendaftaran,
				'modPasien' => $modPasien,
				'modAnamnesa' => $modAnamnesa,
				'modFisik' => $modFisik,
				'rke_max' => $rke_max,
				'modSep' => $modSep
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}
    
    public function actionPrintEtiket($penjualanresep_id, $caraPrint = null, $racikan = null, $obatalkespasien_id = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);

		$racikan_id = ($racikan == 1) ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

		$crJual = new CDbCriteria;
		$crJual->compare('penjualanresep_id', $penjualanresep_id);
		$crJual->compare('racikan_id', $racikan_id);
		$crJual->compare('obatalkespasien_id', $obatalkespasien_id);
		$crJual->order = 'rke asc';

		$modPenjualanDetail = FAObatalkesPasienT::model()->findAll($crJual);


		$judul_print = 'Penjualan Resep Rumah Sakit';


		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);
		$modResepturDet = ResepturdetailT::model()->findByPk($modPenjualan->reseptur_id);

		$view = ($racikan == 1) ? "PrintEtiketRacikan" : "PrintEtiketV2";

		if(isset($_GET['pdf'])) {
			$view .= "PDF";
		}

		if ($caraPrint == "PRINT") {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = 'L'; //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', array(40, 65));
			$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
			ob_clean();
			$mpdf->WriteHTML($formatkonten, 1);
			ob_clean();
			$mpdf->mirrorMargins = 0;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 0, 0, -3, 0, 0, 0);
			$mpdf->SetHTMLFooter('<span></span>');
			$mpdf->WriteHTML(
				$this->renderPartial($view, array(
					'format' => $format,
					'judul_print' => $judul_print,
					'modPenjualan' => $modPenjualan,
					'modPenjualanDetail' => $modPenjualanDetail,
					'caraPrint' => $caraPrint,
					'modReseptur' => $modReseptur,
					'modResepturDet' => $modResepturDet,
					'racikan' => $racikan_id,
				), true)
			);
			$mpdf->SetJS('this.print();');
			$mpdf->Output();
		} else {
			$this->render($view, array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint,
				'modReseptur' => $modReseptur,
				'modResepturDet' => $modResepturDet,
				'racikan' => $racikan_id,
			));
		}
	}
    
    public function actionPrintEtiketRanapNew($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);

		$modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array(
			'penjualanresep_id' => $penjualanresep_id,
		), array('order' => 'rke asc'));
		
		// echo '<pre>';var_dump($modObatAlkesPasien);die;

		// untuk membuat etiket sejumlah signa atau frekuensinya
		$dataObat = [];
		if(count($modObatAlkesPasien) > 0) {
			foreach ($modObatAlkesPasien as $i => $data) {
				if(!empty($data->signa_oa)) {
					$signa_oa = explode('x', $data->signa_oa);

					if(isset($signa_oa[0])) {
						$frekuensi = trim($signa_oa[0]);

						if($frekuensi > 0) {
							for ($i=1; $i <= $frekuensi; $i++) { 
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['obatalkes_nama'] = $data->obatalkes->obatalkes_nama;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['permintaan_oa'] = $data->permintaan_oa;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['jumlahpermintaan_obatnonracikan'] = $data->jumlahpermintaan_obatnonracikan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['satuankekuatan'] = $data->satuankekuatan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['satuansediaan'] = $data->satuansediaan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['kadaluarsa'] = $data->kadaluarsa;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['rke'] = $data->rke;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['etiket'] = $data->etiket;

								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['obatalkes_id'] = $data->obatalkes_id;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['racikan_id'] = $data->racikan_id;
							}
						}
					}
				}
			}
		}

		// echo '<pre>';var_dump($dataObat);die;
		// die;


		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = 'L'; //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(40, 65));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, -3, 0, 0, 0);
		$mpdf->SetHTMLFooter('<span></span>');
		$mpdf->WriteHTML(
			$this->renderPartial('printEtiketRawatInap/print', array(
				'format' => $format,
				'modPenjualan' => $modPenjualan,
				'dataObat' => $dataObat
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

    public function setAPIPenjualanResepOA($penjualan, $detail) {

		$ok = true;
    	$logApiFarmasi = new ApifarmasilogR();

		$api = new MyAPI;
		$ruangan = RuanganM::model()->findByPk($penjualan->ruangan_id);
		$kode = $ruangan->kodedepo_inventory.date('Ym');

		$jualAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));

		// echo "Kode Depo : ".$ruangan->kodedepo_inventory."<br/>";
		// echo "Kode Depo Layanan : ".$kode."<br/>";
		
		// var_dump($kode, $ruangan->attributes); die;
		
		$header = array(
			"Accept" => "application/json",
			"Content-type" => "application/json"
		);

    	// mulai menjalankan api
  

		// get nomor Kode
		$bodyGetKode = CJSON::encode(array(
		'kode'=>$kode
		));
		$urlGetKode = $this->getBridgingHost() . "/getkode";
			$res_kode = CJSON::decode($api->apiRequest($urlGetKode, "POST", $header, $bodyGetKode) ?? "{}");
		
		$log1 = $logApiFarmasi->logFarmasi($res_kode, $bodyGetKode, $penjualan, $urlGetKode); //simpan ke log


		// get Nomor Singkatan
		$bodyGetInitial = CJSON::encode(array(
		'kode'=>$ruangan->kodedepo_inventory,
		));
		$urlGetInitial = $this->getBridgingHost() . "/getInisial";
			$res_inisial = CJSON::decode($api->apiRequest($urlGetInitial, "POST", $header, $bodyGetInitial) ?? "{}");

		$log2 = $logApiFarmasi->logFarmasi($res_inisial, $bodyGetInitial, $penjualan, $urlGetInitial); // simpan ke log


		$kode_cur = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		if (!empty($kode_cur)) {
			// var_dump($kode_cur, $kode);
			$nomor = substr($kode_cur, strlen($kode));

			$penjualan->kodedepo_inv = $kode.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
		} else {
			$penjualan->kodedepo_inv = $kode."000001";
		}
			
		// $penjualan->kodedepo_inv = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		$penjualan->inisialjual_inv = $res_inisial['data']['recordset'][0]['Inisial'] ?? null;
		

		//=======================================================

			// get Nomor Jual
		$kodejual_head = $penjualan->inisialjual_inv.date('Ym');
		$bodyGetNoJUal = CJSON::encode(array(
		'NoJual'=>$kodejual_head
		));
		$urlNoJual = $this->getBridgingHost() . "/getNoJual";

		$res_nojual = CJSON::decode($api->apiRequest($urlNoJual, "POST", $header, $bodyGetNoJUal) ?? "{}");

    	$log3 = $logApiFarmasi->logFarmasi($res_nojual, $bodyGetNoJUal, $penjualan, $urlNoJual); // simpan ke log

		$nojual_cur = $res_nojual['data']['recordset'][0]['NoJual'] ?? null;
		if (!empty($nojual_cur)) {
			$nomor = substr($nojual_cur, strlen($kodejual_head));

			$penjualan->nojual_inv = $kodejual_head.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
			// var_dump($penjualan->nojual_inv);
		} else {
			$penjualan->nojual_inv = $kodejual_head."000001";
		}

		// var_dump($kode, $res_kode, $penjualan->kodedepo_inv, 
		// $res_inisial, $res_nojual, $penjualan->nojual_inv); die;



		$ok = $ok && $penjualan->save(false, array('kodedepo_inv', 'inisialjual_inv', 'nojual_inv'));

		// var_dump($ok, $penjualan->kodedepo_inv, $penjualan->inisialjual_inv, $penjualan->nojual_inv); // die;
		// die;

		// Log Jual Resep	
		$penjualanAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));


		$petugas = empty($penjualanAPI->idpetugas) ? "PTG08120001" : $penjualanAPI->idpetugas;

		if (!empty($penjualanAPI)) {
      		$penjualanAPI->nott = ($penjualanAPI->nott == '') ? " " : $penjualanAPI->nott;
			$penjualanAPI->kodedokter = ($penjualanAPI->kodedokter == '') ? " " : $penjualanAPI->kodedokter;
      		$namapx = str_replace("'", '`', $penjualanAPI->namapx);
			$query = array(
				'NoRMPx'=>$penjualanAPI->normpx,
				'NamaPx'=>$namapx,
				'TglLahir'=>$penjualanAPI->tgllahir,
				'UmurPx'=>$penjualanAPI->umurpx,
				'KetUmur'=>$penjualanAPI->ketumur,
				'AlamatPx'=>$penjualanAPI->alamatpx,
				'NoTT'=>$penjualanAPI->nott ?? "",
				'NoBilling'=>$penjualanAPI->nobilling,
				'KodeDepo'=>$penjualanAPI->kodedepo,
				'KodeJamin'=>$penjualanAPI->kodejamin,
				'KodeDokter'=>$penjualanAPI->kodedokter,
				'KodeTL'=>$penjualanAPI->kodetl ?? " ",
				'IdPetugas'=>$petugas,
				'Kode'=>$penjualanAPI->kode,
				'NoJual'=>$penjualanAPI->nojual,
				'TglJual'=>$penjualanAPI->tgljual,
				'NoMinta'=>$penjualanAPI->nominta,
				'Aktif'=>$penjualanAPI->aktif,
				'StCetak'=>$penjualanAPI->stcetak,
				'StJual'=>$penjualanAPI->stjual,
				'TotJual'=>$penjualanAPI->totjual,
			);

			// var_dump($query, $penjualanAPI->attributes); die;
      		$urlLogJual = $this->getBridgingHost() . "/TTLogJual";
			$res_logjual = CJSON::decode($api->apiRequest(
				$urlLogJual, 
				"POST", $header, CJSON::encode($query)) ?? "{}");

      
      		$log4 = $logApiFarmasi->logFarmasi($res_logjual, $query, $penjualan, $urlLogJual, $penjualanAPI->nojual);

			// var_dump($kode, $res_kode, $res_inisial, $res_nojual, $res_logjual, $query); die;

			if (!empty($res_logjual) && !empty($res_logjual['status']['OK']) && $res_logjual['status']['OK'] == true) {
				// var_dump("MULAI SET DETAIL JUAL");

				$det = InslogjualdfarmasiInvV::model()->findAllByAttributes(array(
					'kodejual'=>$penjualan->nojual_inv,
					'kode'=>$penjualan->kodedepo_inv
				));

				// var_dump(count($det)); die;

				$cnt = 1;
				foreach ($det as $idx => $item) {

					// for ($k = 0; $k < 2; $k++) {

					// insert log detail obat alkes

					$kode_det = $penjualanAPI->kode.str_pad($cnt, 4, "0", STR_PAD_LEFT);
					$kode_jual = $penjualanAPI->kode;
					// var_dump($kode_det); die;

					$query_detail = array(
						'kodebarang'=>$item->kodebarang,
						'hpp'=>$item->hpp,
						'satuan'=>$item->satuan,
						'ststock'=>$item->ststock,
						'stracik'=>$item->stracik,
						'signa'=>$item->signa ?? " ",
						'frek'=>'', //$item->frek,
						'jfrek'=>'', //$item->jfrek ?? 1,
						'peng'=>0,
						'penf'=>0,
						'sp'=>0,
						'ss'=>0,
						'ssr'=>0,
						'sm'=>0,
						'jumlah'=>$item->jumlah,
						'harga'=>$item->harga,
						'hargaretur'=>$item->hargaretur,
						'kode'=>$kode_det,
						'kodejual'=>$kode_jual, //$penjualanAPI->nojual,
					);

					// var_dump($query_detail); die;

          			$urlLogJualD = $this->getBridgingHost() . "/TTLogjualD";
					$res_logjual_detail = CJSON::decode($api->apiRequest(
						$urlLogJualD, 
						"POST", $header, CJSON::encode($query_detail)) ?? "{}");
          
          			$logApiFarmasi->logFarmasi($res_logjual_detail, $query_detail, $penjualan, $urlLogJualD, $penjualanAPI->nojual);
					// var_dump($query_detail, $res_logjual_detail);

					if (!empty($res_logjual_detail['status']['OK']) && $res_logjual_detail['status']['OK'] == true) {
						// update stok

						$kodeDepo = $ruangan->kodedepo_inventory;
						$kodeBarang = $item->kodebarang;
						$periode = date('Ym');

						// $kodeDepo = "DEPO0808001";
						// $kodeBarang = "OBORAL3098";
						// $periode = "202305";


						$query_cek_stok = array(
							"jmlItem"=>$item->jumlah,
							"KodePeriode"=>$periode,
							"KodeDepo"=>$kodeDepo,
							"KodeBarang"=>$kodeBarang,
							"StStock"=>"$item->ststock",
						);
	
            			$urlCekStok = $this->getBridgingHost() . "/cekstok";
						$res_cek_stok = CJSON::decode($api->apiRequest(
							$urlCekStok, 
							"POST", $header, CJSON::encode($query_cek_stok)) ?? "{}");

            			$logApiFarmasi->logFarmasi($res_cek_stok, $query_cek_stok, $penjualan, $urlCekStok);
						// var_dump("https://ihdev-apisim.rssa.my.id/simgosfarmasirssa/cekstok", $query_cek_stok, $res_cek_stok);
	
							// TODO : Validasi ?
						if (
							!empty($res_cek_stok['status']['OK']) 
							&& $res_cek_stok['status']['OK'] == true
						) {
		
							$jml_stok = $res_cek_stok['data']['recordset'][0]['stok_akhir'] ?? 0;

							if ($jml_stok > 0) {
                				$urlUpdateStok = $this->getBridgingHost() . "/updatestok";
								$res_update_stok = CJSON::decode($api->apiRequest(
									$urlUpdateStok, 
									"PUT", $header, CJSON::encode($query_cek_stok)) ?? "{}");
                  				$logApiFarmasi->logFarmasi($res_update_stok, $query_cek_stok, $penjualan, $urlUpdateStok);
								// var_dump("https://ih-apisim.rssa.my.id/simgosfarmasirssa/updatestok", $query_cek_stok, $res_update_stok);
							}



						}

					}

					$cnt++;

					// }


				}
				// die

			}

				


			// var_dump($res_logjual, $query, $penjualanAPI->attributes);

		}

		// die;
		// load oa ruangan
		

		// var_dump($oa->attributes); die;
	}
    
	function getBridgingHost() {
        $konfig = KonfigsystemK::model()->find();
        return $konfig->bridging_host;
    }
}
