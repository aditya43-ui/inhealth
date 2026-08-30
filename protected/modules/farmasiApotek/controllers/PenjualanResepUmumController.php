<?php
Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
Yii::import('farmasiApotek.views.penjualanResepRS.*');

class PenjualanResepUmumController extends PenjualanResepRSController{

    public $defaultAction = 'index';
    public $path_view = 'farmasiApotek.views.penjualanResepRS.';
    public $path_view_umum = 'farmasiApotek.views.penjualanResepUmum.';
    public $obatalkespasientersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping
    public $pendaftarantersimpan = false;

    public function actionIndex($penjualanresep_id = null){
        if(Yii::app()->request->isAjaxRequest) {
            
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obatracikan-api-grid') {
                $this->renderPartial($this->path_view . '_dialogObatRacikan');
                Yii::app()->end();
            }
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obatnonracikan-api-grid') {
                $this->renderPartial($this->path_view . '_dialogObatNonRacikan');
                Yii::app()->end();
            }

            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasien-m-grid') {
                $this->renderPartial($this->path_view_umum . '_dialogPasien');
                Yii::app()->end();
                
            }
        }
        $format = new MyFormatter();
        $sukses = false;
        $modPendaftaran = new FAPendaftaranT;
        $modPasien = new FAPasienM;
        $modReseptur = new FAResepturT;
        $modAntrian = new FAAntrianFarmasiT;
        $modObatAlkesPasien =array();
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $konfigFarmasi = KonfigfarmasiK::model()->find();
        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
        $modReseptur->noresep_depan = $modReseptur->noresep.'/';
        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null));
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss','medium',null));
        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss','medium',null));
        $modPenjualan->noresep = MyGenerator::noResep($instalasi_id);;
        $modPenjualan->jenispenjualan = 'PENJUALAN RESEP LUAR';
        $modPenjualan->carabayar_id= Params::CARABAYAR_ID_MEMBAYAR;
        $modPenjualan->penjamin_id= Params::PENJAMIN_ID_UMUM;
        $modPenjualan->totharganetto= 0;
        $modPenjualan->totalhargajual= 0;
        $modPenjualan->totaltarifservice= 0;
        $modPenjualan->biayaadministrasi= 0;
        $modPenjualan->biayakonseling= 0;
        $modPenjualan->pembulatanharga= 0;
        $modPenjualan->jasadokterresep= 0;
        $modPenjualan->discount= 0;
        $modPenjualan->subsidiasuransi= 0;
        $modPenjualan->subsidipemerintah= 0;
        $modPenjualan->subsidirs= 0;
        $modPenjualan->iurbiaya= 0;
        
        $modReseptur->admracikan = $konfigFarmasi->admracikan;
		$modReseptur->administrasi = $konfigFarmasi->administrasi;

        $modObatAlkes = array();

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id',$modul_id);
        $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
        $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
        if(isset($_POST['tujuansms'])){
            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);


        if(!empty($penjualanresep_id)){
            $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
            $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$modPenjualan->penjualanresep_id));
        }

        $modAntrian->tglambilantrian= date('Y-m-d H:i:s');
        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
        $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
        $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
        $racikanDetail = array();
        foreach ($modRacikanDetail as $i => $mod){ //convert object to array
            $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
            $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
            $racikanDetail[$i]['qtymin'] = $mod->qtymin;
            $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
            $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
        }
        
        $transaction = Yii::app()->db->beginTransaction();
        if(isset($_POST['FAPenjualanResepT'])){
            
            if($_POST['FAPenjualanResepT']['is_pasien']){
                if(isset($_POST['FAPasienM'])){
                    $modPasien = $this->simpanPasienApotek($modPasien, $_POST['FAPasienM']);
                }
            }else{
                $modPasien = FAPasienM::model()->findByPk(Params::DEFAULT_PASIEN_APOTEK_UMUM);
            }
			//RND-5298
			$modPendaftaran = $this->simpanPendaftaran($modPendaftaran,$modPasien);

            $modPenjualan = $this->savePenjualanResep($modPasien,$_POST['FAPenjualanResepT'],$modPendaftaran);
            if($this->penjualantersimpan){
                if(count((array)$_POST['FAObatalkesPasienT']) > 0){
                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                    $detailGroups = array();
                    foreach($_POST['FAObatalkesPasienT'] AS $i => $postDetail){

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
                        $modDetails[$i]->qty_oa = MyFormatter::formatNumberForDb($modDetails[$i]->qty_oa);
                        $modDetails[$i]->qty_jual = $modDetails[$i]->qty_oa;
                        $modDetails[$i]->kekuatan_oa = MyFormatter::formatRupiahForDB($modDetails[$i]->kekuatan_oa);
                        $modDetails[$i]->hargajual_oa = $postDetail['hargajual_oa'];
                        $modDetails[$i]->jumlahppn = $postDetail['jumlahppn'];
                        $modDetails[$i]->persenppnjual = $postDetail['ppnpersen'];

                        $modDetails[$i]->jumlahpermintaan_obatracikan = !empty($postDetail['jumlahpermintaan_obatracikan']) ? $postDetail['jumlahpermintaan_obatracikan'] : "";
						$modDetails[$i]->jumlahpermintaan_obatnonracikan = !empty($postDetail['jumlahpermintaan_obatnonracikan']) ? $postDetail['jumlahpermintaan_obatnonracikan'] : "";
						$modDetails[$i]->satuansediaan = $postDetail['satuansediaan'];

                        if(!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0){
                          $modDetails[$i]->pajak_id = 6; //pajak ppn
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

                        if (empty($modDetails[$i]->pegawai_id) || $modDetails[$i]->pegawai_id == 0) {
                            $modDetails[$i]->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        }
                        $modDetails[$i]->total_embalase = (!empty($postDetail['total_embalase'])?$postDetail['total_embalase']:0);

                        //var_dump($postDetail);
                        //var_dump($modPenjualan->attributes);
                        //var_dump($modDetails[$i]->attributes);
                        //var_dump($modDetails[$i]->validate());
                        //var_dump($modDetails[$i]->getErrors());
                        //die;


                        // var_dump($modDetails[$i]->attributes);

                        if ($modDetails[$i]->validate()) {
                            $this->obatalkespasientersimpan &= $modDetails[$i]->save();
                        } else {
                            $this->obatalkespasientersimpan &= false;
                        }

                        // var_dump($modDetails[$i]->getErrors());die;

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
                        }
                         *
                         */
                    }
                    //END GROUP
                }
                /*
                $obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach($detailGroups AS $i => $detail){
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));

                    if(count((array)$modStokOAs) > 0){
                        foreach($modStokOAs AS $i => $stok){
                            $modDetails[$i] = $this->simpanObatAlkesPasien($modPasien, $modPenjualan, $stok, $_POST['FAObatalkesPasienT'] );
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                        }
                    }else{
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                    }
                }
                 *
                 */
		// var_dump($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan&&$this->pendaftarantersimpan); die;
                // die;

                //var_dump($this->obatalkespasientersimpan,$this->stokobatalkestersimpan,$this->pendaftarantersimpan);

                try {
                    if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan&&$this->pendaftarantersimpan){

                        // SMS GATEWAY

                        $sms = new Sms();
                        $smspasien = 1;
                        /*
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPenjualan->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }

                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPenjualan->tglpenjualan),$isiPesan);

                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }

                        }
                         *
                         */
                        // END SMS GATEWAY
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
    
                            $transaction->commit();
							$this->setAPIPenjualanResepOA($modPenjualan, $modDetails);
                            $sukses = 1;
                            if ($modPasien->is_random) {
                                // $modPasien->generateNoRMDanSimpan(Yii::app()->user->getState('mr_apotik'),'TRUE');
                                $modPasien->generateNoRMDanSimpanNew(Yii::app()->user->getState('mr_apotik'),'TRUE');
                            }
                            // cek apakah penjualan api berhasil apa tidak 
							$cekPenjualan = PenjualanresepT::model()->findByPk($modPenjualan->penjualanresep_id);
							if(!empty($cekPenjualan)) {
								Yii::app()->user->setFlash('success', "Data Berhasil disimpan !");
								$this->redirect(array('index','penjualanresep_id'=>$modPenjualan->penjualanresep_id, 'sukses'=>$sukses, 'smspasien'=>$smspasien));
							} else {
								Yii::app()->user->setFlash('error', "Data gagal disimpan [4 Cek Log Api]!");
							}
                        }
                    }else{

                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data detail penjualan resep gagal disimpan !");
                        if(!$this->stokobatalkestersimpan){
                            Yii::app()->user->setFlash('error',"Data detail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:");
                        }
                    }
                } catch (Exception $e) {

                    $transaction->rollback(); var_dump($e->getMessage()); die;
                    Yii::app()->user->setFlash('error',"Data penjualan resep gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                }
            }
        }
        
        $this->render('index',array(
                'modReseptur'=>$modReseptur,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modPenjualan'=>$modPenjualan,
                'modAntrian'=>$modAntrian,
                'modObatAlkesPasien'=>$modObatAlkesPasien,
                'racikan'=>$racikan,
                'racikanDetail'=>$racikanDetail,
                'nonRacikan'=>$nonRacikan,
                'obatAlkes'=>$modObatAlkes,
                'konfigFarmasi'=>$konfigFarmasi,
                'sukses'=>$sukses,
        ));
    }


    public function broadcastPenjualanKeKasir($modPenjualan) {
        // var_dump($modPenjualan->attributes); die;

        $pegawai = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
//        $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);

        $ruanganKasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

        $judul = ucwords(strtolower($modPenjualan->jenispenjualan))." - ".$modPenjualan->noresep;
        $isi = "Tgl. Penjualan : ".MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan)."<br/>";
        $isi .= "Dokter Resep : ".(empty($pegawai) ? "-" : $pegawai->namaLengkap)."<br/>";

        CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruanganKasir->instalasi_id, 'ruangan_id' => $ruanganKasir->ruangan_id, 'modul_id' => $ruanganKasir->modul_id),
            array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
        ));

        // var_dump($isi);
    }

    /**
    *
    * @param type $postsimpan / update pasien
    */
    public function simpanPasienApotek($modPasien, $post){
        $format = new MyFormatter();
        if(isset($post['pasien_id']) && !empty($post['pasien_id'])){
            if($post['pasien_id']){
                $loadPasien = FAPasienM::model()->findByPk($post['pasien_id']);
                if(isset($loadPasien)){
                    $modPasien = $loadPasien;
                    $modPasien->attributes = $_POST['FAPasienM'];
                    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
                    $modPasien->update_time = date("Y-m-d H:i:s");
                    $modPasien->update_loginpemakai_id = Yii::app()->user->id;
                    $modPasien->update();
                }
            }
        } else {
            $modPasien->attributes = $post;
            $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
            $modPasien->tanggal_lahir = $format->dateTimeForDb($modPasien->tanggal_lahir);
            $modPasien->no_rekam_medik = $modPasien->generateNoRandom(); // MyGenerator::noRekamMedik(Yii::app()->user->getState('mr_apotik'),'TRUE');
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
            $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $modPasien->ispasienluar = true;
            $modPasien->profilrs_id = Yii::app()->user->getState('profilrs_id');
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->agama = Params::DEFAULT_AGAMA;
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasien->create_time = date("Y-m-d H:i:s");
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->save();
        }
        return $modPasien;
    }

    protected function savePenjualanResep($modPasien,$penjualanResep,$modPendaftaran)
    {
        $format = new MyFormatter();
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->attributes = $penjualanResep;
        $modPenjualan->jenispenjualan = Params::JENISPENJUALAN_RESEP_LUAR;
        $modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPenjualan->penjamin_id = $penjualanResep['penjamin_id'];
        $modPenjualan->carabayar_id = $penjualanResep['carabayar_id'];
        $modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null ;
        $modPenjualan->pegawai_id = $penjualanResep['pegawai_id'];
        $modPenjualan->kelaspelayanan_id = null;
        $modPenjualan->pasien_id = $modPasien->pasien_id;
        $modPenjualan->pasienadmisi_id = null;
        if (isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/2') { //dari form
            $modPenjualan->takaranresep = 0.5;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/3'){
            $modPenjualan->takaranresep = 0.3;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '1/4'){
            $modPenjualan->takaranresep = 0.25;
        }else if(isset($_POST['FAPenjualanResepT']['takaranresep'])== '2/3'){
            $modPenjualan->takaranresep = 0.67;
        }
        $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
        $modPenjualan->tglresep = date('Y-m-d H:i:s');
        $modPenjualan->ruanganasal_nama = 'Apotek Pelayanan 1';
        $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
        $modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'] ;
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

        $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $modPenjualan->jenislayanan_inv = !empty($modRuangan->kodeJL_inventory) ? $modRuangan->kodeJL_inventory : '-';
        $modPenjualan->tempatlayanan_inv = !empty($modRuangan->kodeTL_inventory) ? $modRuangan->kodeTL_inventory : '-';
        $modPenjualan->kodedokter_inventory = '-';
        $modPenjualan->kodepetugas_inv = !empty($modPegawai->kodepetugas_inventory) ? $modPegawai->kodepetugas_inventory : '-';

        if($modPenjualan->validate()){
            $modPenjualan->save();
            $this->penjualantersimpan = true;
        } else {
            $this->penjualantersimpan = false;
            Yii::app()->user->setFlash('error',"Data Penjualan Resep Tidak valid");
        }

        return $modPenjualan;
    }

    /**
     * simpan ObatalkesPasienT Jumlah Out
     * @param type $modPenjualan
     * @param type $postObatAlkesPasien
     * @return \ObatalkesPasienT
     */
    protected function simpanObatAlkesPasien($modPasien,$modPenjualan,$stokOa,$postObatAlkesPasien){
        $format = new MyFormatter;
        $modObatAlkes = new FAObatalkesPasienT;
        $modObatAlkes->attributes = $stokOa->attributes;
        $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->carabayar_id = $modPenjualan->carabayar_id;
        $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkes->pendaftaran_id = null;
        $modObatAlkes->pasien_id = $modPasien->pasien_id;
        $modObatAlkes->penjamin_id = $modPenjualan->penjamin_id;
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
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];
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
//                $modObatAlkes->discount = $postDetail['discount'];
                $modObatAlkes->signa_oa = $postDetail['signa_oa'];
                $modObatAlkes->etiket = $postDetail['etiket'];
            }
            $modObatAlkes->iurbiaya = $modObatAlkes->hargajual_oa;
        }

        if($modObatAlkes->save()){
            $this->obatalkespasientersimpan &= true;
        }else{
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkes;
    }

    /**
    * set dropdown penjamin pasien dari carabayar_id
    * @param type $encode
    * @param type $namaModel
    */
    public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
           if($encode)
           {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                    if(count((array)$penjamin) > 1)
                    {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }
                    $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                    foreach($penjamin as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
           }
        }
        Yii::app()->end();
    }

    /**
     * untuk print data penjualan dokter
     */
    public function actionPrint($penjualanresep_id = null,$caraPrint = null)
    {
        $this->layout='//layouts/iframe';
        if ($penjualanresep_id == null){
            $penjualanresep_id = $_GET['id'];
        }
        $format = new MyFormatter;
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));

        $judul_print = 'RINCIAN PENJUALAN RESEP UMUM';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }

        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPenjualan'=>$modPenjualan,
                'modPenjualanDetail'=>$modPenjualanDetail,
                'caraPrint'=>$caraPrint
        ));
    }

    /**
     * Mengurai data pasien berdasarkan:
     * - pasien_id
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
			if(!empty($pasien_id)){
				$criteria->addCondition("pasien_id = ".$pasien_id);
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            $model = FAPasienM::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
    * action Pasien Lama Apotek digunakan untuk pendaftaran pasien apotek
    */
    public function actionAutocompletePasienApotek()
    {
       if(Yii::app()->request->isAjaxRequest) {
           $criteria = new CDbCriteria();
           $criteria->compare('LOWER(no_rekam_medik)', 'AP'.strtolower($_GET['term']), true);
		   $criteria->addCondition('ispasienluar = TRUE');
           $criteria->order = 'no_rekam_medik';
           $models = PasienM::model()->findAll($criteria);
           foreach($models as $i=>$model)
           {
               $attributes = $model->attributeNames();
               foreach($attributes as $j=>$attribute) {
                   $returnVal[$i]["$attribute"] = $model->$attribute;
               }
               $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
               $returnVal[$i]['value'] = $model->no_rekam_medik;
           }

           echo CJSON::encode($returnVal);
       }
       Yii::app()->end();
    }

    /**
     * proses simpan / ubah data pendaftaran
	 * RND-5298
     * @return type
     */
    public function simpanPendaftaran($model,$modPasien){
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->pasien_id = (isset($modPasien->pasien_id) ? $modPasien->pasien_id : null);
      //  $model->pasien_id = $modPasien['pasien_id'];
        $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
        $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
        $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
        $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
        $model->statuspasien = (empty($_POST['FAPasienM']['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
        $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
        $model->shift_id = Yii::app()->user->getState('shift_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_time = date("Y-m-d H:i:s");
        $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
		$model->carabayar_id = $_POST['FAPenjualanResepT']['carabayar_id'];
		$model->penjamin_id = $_POST['FAPenjualanResepT']['penjamin_id'];
        $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
        $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
		if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
			$model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
		}else{
			$model->tgl_pendaftaran = date("Y-m-d H:i:s");
		}
        $model->no_pendaftaran = MyGenerator::noPendaftaranPenjualanResep($model->tgl_pendaftaran);

        if($model->save()){
            $this->pendaftarantersimpan = true;
        }else{
            $this->pendaftarantersimpan = false;
        }
        return $model;
    }

    public function actionSetFormObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = str_replace(",",".",trim($_POST['jumlah']));
            $therapiobat_id = isset($_POST['therapiobat_id'])?$_POST['therapiobat_id']:null;
			$penggunaan_oa = isset($_POST['penggunaan_oa'])?$_POST['penggunaan_oa']:null;
            $racikan = isset($_POST['racikan'])?$_POST['racikan']:false;
            $instalasi = isset($_POST['instalasi_id'])?$_POST['instalasi_id']:null;
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
            $satuansediaan = isset($_POST['satuansediaan']) ? $_POST['satuansediaan'] : null;
            $jmlkemasan = isset($_POST['jmlkemasan']) ? $_POST['jmlkemasan'] : 0;
            $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;

            $st_fornas = isset($_POST['st_fornas']) ? $_POST['st_fornas']: '';
            $sumberdana_id = isset($_POST['sumberdana_id']) ? $_POST['sumberdana_id']: '';
            $hargasatuan_reseptur = isset($_POST['hargasatuan_reseptur']) ? $_POST['hargasatuan_reseptur']: 0;

            // echo '<pre>';var_dump($keterangan);die;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkesPasien = new FAObatalkesPasienT;
            $konfigFarmasi = KonfigfarmasiK::model()->find();

            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            // $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            $modeObatApi = new ObatAPI();
            $dataObatApi = $modeObatApi->searchStokByDepo($oa->sumberdana_id, $oa->kodeobat_inventory);
            $jmlStok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0;
            // $hargajual = $oa->hjanonresep;
            $hargajual = $oa->hargajual;

            if(!empty($konfigFarmasi->marginpenjualanresepumum)){
                $marginjual = (($oa->hpp * $konfigFarmasi->marginpenjualanresepumum)/100);
                $hargajual = ($oa->hpp + $marginjual);   
            }

//            $hargajual = $this->cekHargaJualBerdasarkanInstalasi($oa, $instalasi);
//            var_dump($hargajual); die;
            //if(count((array)$modStokOAs) > 0){

            //    foreach($modStokOAs AS $i => $stok){
                    $modObatAlkesPasien->sumberdana_id = $sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
                    $modObatAlkesPasien->qty_oa = number_format($jumlah, 2, ',', ''); //ceil($stok->qtystok_terpakai); // LNG Ceil (Pembulatan keatas request pak tito)
                    // $modObatAlkesPasien->qty_oa = $jmlkemasan;
                    $modObatAlkesPasien->harganetto_oa = round($oa->harganetto * 100) / 100; //$stok->HPP;
                    $modObatAlkesPasien->hargasatuan_oa = $hargasatuan_reseptur; //$stok->HargaJualSatuan;
                    $modObatAlkesPasien->jmlstok = $jmlStok;
                    $modObatAlkesPasien->r = 'R/';
                    $modObatAlkesPasien->hargajual_oa = round($jumlah * $modObatAlkesPasien->hargasatuan_oa * 100) / 100;
                    $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
                    $modObatAlkesPasien->iurbiaya = $jumlah * $modObatAlkesPasien->hargasatuan_oa;
					$modObatAlkesPasien->therapiobat_id = $therapiobat_id;
					$modObatAlkesPasien->ket_penggunaan = $penggunaan_oa;
                    $modObatAlkesPasien->racikan_id = $racikan == "true" ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;
                    $modObatAlkesPasien->keterangan = $keterangan;
                    $modObatAlkesPasien->administrasi = $konfigFarmasi->administrasi;
                    $modObatAlkesPasien->st_fornas = $st_fornas;
                    $modObatAlkesPasien->hargasatuan_reseptur = $hargasatuan_reseptur;
                    $modObatAlkesPasien->satuansediaan = $satuansediaan;

                    // if($racikan == "true"){
                    //     $modObatAlkesPasien->obatalkes_biaya_r = $konfigFarmasi->admracikan;
                    // }else{
                    //     $modObatAlkesPasien->obatalkes_biaya_r = $konfigFarmasi->administrasi;
                    // }

                    if($konfigFarmasi->ishargaperpenjamin == true){
                        if(!empty($penjamin_id)){
                            $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id'=>$oa->jenisobatalkes_id,'penjamin_id'=>$penjamin_id));

                            if(!empty($obatalkesPenjamin)){
                                $marginRp = round((($oa->hpp * $obatalkesPenjamin->persmargin)/100),2);
                                $hargaSatuan = round(($oa->hpp + $marginRp),2);
                                // $modObatAlkesPasien->hargasatuan_oa = $hargaSatuan;
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

                    $modObatAlkesPasien->hargasatuan_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargasatuan_oa, 2);
                    $modObatAlkesPasien->qty_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->qty_oa, 2);
                    $modObatAlkesPasien->jumlahpermintaan_obatracikan = $jumlah;
                    $modObatAlkesPasien->jumlahpermintaan_obatnonracikan = $jumlah;
//                    var_dump($modObatAlkesPasien->attributes); die;

                    $form .= $this->renderPartial($this->path_view_umum.'_rowDetail', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
            //    }
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}

            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end();
        }
    }
}

?>
