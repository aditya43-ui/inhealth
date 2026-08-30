<?php

class InformasiPasienTriageController extends MyAuthController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'index';
    public $path_view = 'farmasiApotek.views.informasiPasienTriage.';
    public $path_tips = 'sistemAdministrator.views.tips.';
    public $penjualantersimpan = false;
    public $obatalkespasientersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping

    /**
     * halaman informasi
     */
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new InformasibedtriageV('searchInfoPasienTriage');
        $modelData = new FAPengambilanObatT();
        
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['InformasibedtriageV'])) {
            $model->attributes = $_GET['InformasibedtriageV'];
            $model->tgl_awal = isset($_GET['InformasibedtriageV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['InformasibedtriageV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['InformasibedtriageV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['InformasibedtriageV']['tgl_akhir']) : null;
        }

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'informasi-stok-grid')
                    $path = $this->path_view . '_tabel';

                $this->renderPartial($path, ['model' => $model,'modelData' => $modelData]);
            }
            exit;
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modelData' => $modelData
        ));
    }

    function actionCekVerifikasiPJA() {
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $status = 0;
        if(!empty($pendaftaran_id)) {
            $criteria = new CDbCriteria();
            $criteria->limit = 1;
            $criteria->addCondition('pendaftaran_id=' . $pendaftaran_id);
            $criteria->addCondition("userapprovaltindaklanjut_id is not null and tanggal_approvaltindaklanjut is not null and isapprovaltindaklanjut is true");
            $model = TindakanpelayananT::model()->find($criteria);
    
            if(!empty($model)) {
               $status = 1;
            }
        }

        echo json_encode(['status' => $status]);
    }

    public function actionSetFormObatAlkesPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $keterangan = $_POST['keterangan'];
            $petugas_pengambil_obat = $_POST['petugas_pengambil_obat'];
            $petugasfarmasi_id = $_POST['petugasfarmasi_id'];
            $tgl_resep = $_POST['tgl_resep'];
            $noresep = $_POST['noresep'];
            $notriagepasien_id = $_POST['notriagepasien_id'];
            $nama_pasien = $_POST['nama_pasien'];
            $hargasatuanreseptur = $_POST['hargasatuanreseptur'];
            $sumberdana_id = $_POST['sumberdana_id'];
            $stfornas = $_POST['stfornas'];

            
            $status = 0;

            $petugasfarmasi = PegawaiM::model()->findByPk($petugasfarmasi_id);
            $obatalkes = ObatalkesM::model()->findByPk($obatalkes_id);
            $notriage = NotriagePasienT::model()->findByPk($notriagepasien_id);

            // cek verif pja
            $criteria = new CDbCriteria();
            $criteria->limit = 1;
            if(!empty($notriage->pendaftaran_id)) {
                $criteria->addCondition('pendaftaran_id=' . $notriage->pendaftaran_id);
                $criteria->addCondition("userapprovaltindaklanjut_id is not null and tanggal_approvaltindaklanjut is not null and isapprovaltindaklanjut is true");
                $model = TindakanpelayananT::model()->find($criteria);
    
                if(!empty($model)) {
                   $status = 1;
                }
            }

            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modPemakaianObat = new PengambilanobatTriagedetT();
            $modPemakaianObat->obatalkes_id = $obatalkes_id;
            $modPemakaianObat->jumlah = $jumlah;
            $modPemakaianObat->keterangan = $keterangan;
            $modPemakaianObat->petugasfarmasi_id = $petugasfarmasi_id;
            $modPemakaianObat->petugasfarmasi_nama = $petugasfarmasi->nama_pegawai ?? '';
            $modPemakaianObat->petugas_pengambil_obat = $petugas_pengambil_obat;
            $modPemakaianObat->tgl_resep = $tgl_resep;
            $modPemakaianObat->obatalkes_nama = $obatalkes->obatalkes_nama ?? '';
            $modPemakaianObat->noresep_triage = $noresep;
            $modPemakaianObat->nobed_triage = $notriage->no_bed_triage;
            $modPemakaianObat->nama_pasien = $nama_pasien;
            $modPemakaianObat->hargasatuan_reseptur = $hargasatuanreseptur;
            $modPemakaianObat->sumberdana_id = $sumberdana_id;
            $modPemakaianObat->stfornas = $stfornas;

            //echo '<pre>';var_dump($modStokOAs);die;

            //  $modPemakaianObatDetail->subtotal = $modPemakaianObatDetail->qty_satuanpakai * $modPemakaianObatDetail->harga_satuanpakai;
            $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modPemakaianObat' => $modPemakaianObat), true);
            
        } else {
            $pesan = "Stok tidak mencukupi!";
        }

        echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'status' => $status));
        Yii::app()->end();
    }
  
    /**
     * menampilkan dan menyimpan set petugas
     * @param type $id
     * @param type $proses
     */
    public function actionSetPendaftaran($id, $proses = null)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = NotriagePasienT::model()->findByPk($id);
            $modPas = !empty($model->pendaftaran) ? $model->pendaftaran->pasien : new PasienM;
            $ok = '';
            $pesan = '';

            if ($proses == 'simpan') {
                parse_str($_POST['formdata'], $arr);
                $ok = true;

                $trans = Yii::app()->db->beginTransaction();
                try {
                    $model->attributes = $arr['NotriagePasienT'];
                    
                    $model->pasien_id = $arr['NotriagePasienT']['pasien_id'];
                    $ok &= $model->update();
                    // print_r($model->notriage_pasien_id);
                    // exit;
                    $wpss = AsesmentriagewpssT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    if (!empty($wpss)) {
                        $wpss->pendaftaran_id = $model->pendaftaran_id;
                        $wpss->pasien_id = $model->pasien_id;
                        $ok &= $wpss->update();
                    }

                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                        $anamnesa->pasien_id = $model->pasien_id;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }

                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                        $pemeriksaanfisik->pasien_id = $model->pasien_id;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }

                    if ($ok) {
                        $trans->commit();
                        $pesan .= "set pendaftaran sukses simpan";
                    } else {
                        $trans->rollback();
                        $pesan .= "set pendaftaran gagal simpan";
                    }
                } catch (Exception $ex) {
                    $trans->rollback();
                    $pesan .= 'set pendaftaran gagal simpan <br/>' . $ex->getMessage();
                }
            }

            $html = $this->renderPartial($this->path_view . 'set-pendaftaran/index', [
                'model' => $model,
                'modPas' => $modPas,
                'sukses' => ($ok) ? 'ya' : (($ok === false) ? 'tidak' : ''),
                'pesan' => $pesan
            ], true);

            echo json_encode($html);
        }
        Yii::app()->end();
    }


    public function actionPengambilanObat($pendaftaran_id = null, $notriage_pasien_id = null){

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obat-api-grid') {
                $this->renderPartial($this->path_view . '_dialogObatApi');
                Yii::app()->end();
            }
        }        
        $sukses = 'tidak';
       
        if (empty($notriage_pasien_id)) {
            $notriage_pasien_id = null;
        }
        $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);

        $konsul = (Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
        ));

        if (!empty($konsul)) {
            $modPendaftaran->pegawai_id = $konsul->pegawai_id;
        }

        $model = FAPengambilanObatT::model()->findByPK($notriage_pasien_id);

        

        $modRiwatReseptur = new FAPengambilanObatT;
        $modRiwatReseptur->notriage_pasien_id = $notriage_pasien_id;

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarriwayat-v-grid') {
                $this->renderPartial('_listResep', [
                    'modRiwatReseptur' => $modRiwatReseptur
                ]);
                Yii::app()->end();
            }
        }

        
        $modRiwayatPenjualanResep = new FAPenjualanResepT('searchRiwayatPenjualan');
        $modRiwayatPenjualanResep->pendaftaran_id = $pendaftaran_id;
        $modRiwayatPenjualanResep->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'penjualanresepriwayat-v-grid') {
                $this->renderPartial('_riwayatPenjualanResep', [
                    'modRiwayatPenjualanResep' => $modRiwayatPenjualanResep
                ]);
                Yii::app()->end();
            }
        }
        //var_dump ($modRiwatReseptur); die;
        $modReseptur = new FAPengambilanObatT;
        $modReseptur->noresep_triage = MyGenerator::noResepTriage();
        //$modReseptur->create_time = date('y/m/d');
        $modReseptur->create_time = date('Y-m-d H:i:s');
        if(!empty($modPendaftaran->pasien->nama_pasien)) {
            $modReseptur->nama_pasien = $modPendaftaran->pasien->nama_pasien;
        }

        $kelompokpegawai_id = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->kelompokpegawai_id;
        if($kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP){
            $modReseptur->pegawai_id = Yii::app()->user->getState('pegawai_id');
        }
        $modReseptur->petugasfarmasi_id = Yii::app()->user->getState('pegawai_id');
        
     
        if (isset($_POST['FAPengambilanObatT'])) {
            
            $transaction = Yii::app()->db->beginTransaction();
            //echo '<pre>';var_dump($_POST);die;
            try {
                $is_save = false;
                if(isset($_POST['PengambilanobatTriagedetT']) && count($_POST['PengambilanobatTriagedetT']) > 0) {
                    foreach ($_POST['PengambilanobatTriagedetT'] as $key => $value) {
                        $reseptur = new FAPengambilanObatT;
                        // echo CJSON::encode($_POST);die;
                        $reseptur->pendaftaran_id = empty($pendaftaran_id) ? null : $pendaftaran_id;
                        $reseptur->notriage_pasien_id = $notriage_pasien_id;
                        $reseptur->petugasfarmasi_id = $value['petugasfarmasi_id'];
                        $reseptur->petugas_pengambil_obat = $value['petugas_pengambil_obat'];
                        $reseptur->create_time = date("Y-m-d H:i:s");
                        $reseptur->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        $reseptur->noresep_triage = $value['noresep_triage'];
                        $reseptur->jumlah = $value['jumlah'];
                        $reseptur->keterangan = $value['keterangan'];
                        $reseptur->obatalkes_id = $value['obatalkes_id'];
                        $reseptur->is_jual = false;
                        $reseptur->hargasatuan_reseptur = $value['hargasatuan_reseptur'];
                        $reseptur->sumberdana_id = $value['sumberdana_id'];
                        $reseptur->st_fornas = $value['stfornas'];
                        $reseptur->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        if($reseptur->validate()){
                            if($reseptur->save()){
                                $is_save = true;
                            } else {
                                Yii::app()->user->setFlash('success', "Data Berhasil disimpan [save]");
                                
                                $is_save = false;
                            }
                        }else{
                           $is_save = false;
                            Yii::app()->user->setFlash('success', "Data Berhasil disimpan [validate]");

                        } 
                    }
                }
                // echo '<pre>';var_dump($is_save);die;
                if($is_save) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan ");
                    $this->redirect(['PengambilanObat', 'pendaftaran_id' => $pendaftaran_id,'notriage_pasien_id' => $notriage_pasien_id, 'sukses' => 1]);
                } else {
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                // vaR_dump($exc->getMessage()); die;
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                    $transaction->rollback();

            }
        }

        $modRiwayatResep = PengambilanobatTriageT::model()->findAllByAttributes(array('notriage_pasien_id' => $notriage_pasien_id), array('order' => 't.create_time DESC'));
      
        $this->render('index2', array('model' => $model,'modPendaftaran'=>$modPendaftaran,'modReseptur'=>$modReseptur, 'modRiwayatResep'=>$modRiwayatResep,'modRiwatReseptur'=>$modRiwatReseptur, 'sukses' => $sukses, 'modRiwayatPenjualanResep' => $modRiwayatPenjualanResep));
    
    }

    function getBridgingHost() {
        $konfig = KonfigsystemK::model()->find();
        return $konfig->bridging_host;
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

			}

				


			// var_dump($res_logjual, $query, $penjualanAPI->attributes);

		}

		// die;
		// load oa ruangan
		

		// var_dump($oa->attributes); die;
	}
    

    public function actionSetPendaftaran2($id, $proses = null)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = NotriagePasienT::model()->findByPk($id);
            $modPas = !empty($model->pendaftaran) ? $model->pendaftaran->pasien : new PasienM;
            $ok = '';
            $pesan = '';

            if ($proses == 'simpan') {
                parse_str($_POST['formdata'], $arr);
                $ok = true;

                $trans = Yii::app()->db->beginTransaction();
                try {
                    $model->attributes = $arr['NotriagePasienT'];
                    
                    $model->pasien_id = $arr['NotriagePasienT']['pasien_id'];
                    $ok &= $model->update();
                    // print_r($model->notriage_pasien_id);
                    // exit;
                    $wpss = AsesmentriagewpssT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    if (!empty($wpss)) {
                        $wpss->pendaftaran_id = $model->pendaftaran_id;
                        $wpss->pasien_id = $model->pasien_id;
                        $ok &= $wpss->update();
                    }

                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                        $anamnesa->pasien_id = $model->pasien_id;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }

                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                        $pemeriksaanfisik->pasien_id = $model->pasien_id;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }

                    if ($ok) {
                        $trans->commit();
                        $pesan .= "set pendaftaran sukses simpan";
                    } else {
                        $trans->rollback();
                        $pesan .= "set pendaftaran gagal simpan";
                    }
                } catch (Exception $ex) {
                    $trans->rollback();
                    $pesan .= 'set pendaftaran gagal simpan <br/>' . $ex->getMessage();
                }
            }

            $html = $this->renderPartial($this->path_view . 'set-pendaftaran/index2', [
                'model' => $model,
                'modPas' => $modPas,
                'sukses' => ($ok) ? 'ya' : (($ok === false) ? 'tidak' : ''),
                'pesan' => $pesan
            ], true);

            echo json_encode($html);
        }
        Yii::app()->end();
    }

    public function actionLoadPendaftaran()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $id = $_GET['id'];

            $modDaftar = FAPendaftaranT::model()->findByPk($id);
            $return = [];
            $return['no_rekam_medik'] = '';
            $return['nama_pasien'] = '';
            $return['pasien_id'] = '';
            if (!empty($modDaftar)) {
                $return['no_rekam_medik'] = $modDaftar->pasien->no_rekam_medik;
                $return['nama_pasien'] = $modDaftar->pasien->nama_pasien;
                $return['alamat_pasien'] = $modDaftar->pasien->alamat_pasien;
                $return['pasien_id'] = $modDaftar->pasien_id;
                $return['pendaftaran_id'] = $modDaftar->pendaftaran_id;
            }

            echo json_encode($return);
            Yii::app()->end();
        }
    }

    public function actionTambahTriage() {
        $model = new FANotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['FANotriagePasienT'])) {

            if ($_POST['FANotriagePasienT'] != "") {

                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    $model->attributes = $_POST['FANotriagePasienT'];
                    $bedTriage = BedTriageM::model()->findByPk($_POST['FANotriagePasienT']['bed_triage_id']);
                    $model->no_bed_triage = $bedTriage->no_bed;
                    $model->no_triage_pasien = MyGenerator::noTriagePasien();
                    // $model->no_triage_pasien = ($model->bed_triage_id < 10) ? 'A0' . $model->bed_triage_id : 'A' . $model->bed_triage_id;
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    
                    // echo'<pre>';var_dump( $_POST, $model);die;
                    $ok && $model->save();

                    if ($ok) {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        ));
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formTambahPasienIGD', array('model' => $model), true)
            ));
            exit;
        }
    }

    public function actionTambahTriagePasien() {
        $model = new FANotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['FANotriagePasienT'])) {
            if (!empty($_POST['FANotriagePasienT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {

                    $model->attributes = $_POST['FANotriagePasienT'];
                    $model->pendaftaran_id = $_POST['FANotriagePasienT']['pendaftaran_id'];
                    $model->pasien_id = $_POST['FANotriagePasienT']['pasien_id'];
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $bedTriage = BedTriageM::model()->findByPk($_POST['FANotriagePasienT']['bed_triage_id']);
                    $model->no_bed_triage = $bedTriage->no_bed;
                    $model->no_triage_pasien = MyGenerator::noTriagePasien();
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                    $ok && $model->save();

                    if ($ok) {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        ));
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-error'>Data gagal disimpan.</div>" . $exc->getMessage(),
                    ));
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formTambahTriagePasienIGD', array('model' => $model, 'sukses' => 'tidak', 'jenisform' => 'tambah'), true)
            ));
            exit;
        }
    }

    public function actionLoadTriage() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $jenis = $_POST['jenis'];

            if ($jenis == 'ubah') {
                $model = FANotriagePasienT::model()->findByPk($id);

                $returnVal['no_bed_triage'] = $model->no_bed_triage;
                $returnVal['notriage_pasien_id'] = $model->notriage_pasien_id;
                $returnVal['keterangan'] = $model->keterangan;
                $returnVal['bed_triage_id'] = $model->bed_triage_id;
            } else {
                $model = NotriagepasienT::model()->findByPk($id);
                $returnVal['no_bed_triage'] = $model->no_bed;
                $returnVal['notriage_pasien_id'] = '';
                $returnVal['keterangan'] = '';
                $returnVal['bed_triage_id'] = $model->bed_triage_id;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }



    public function actionUpdateTriagePasien($pendaftaran_id, $notriage_pasien_id = null) {

        $this->layout = '//layouts/iframe';
        $sukses = 'tidak';
        $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);
        $model = new FANotriagePasienT;
        if (!empty($notriage_pasien_id)) {
            $model = FANotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));
        } else {
            $cekNo = FANotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if (!empty($cekNo)) {
                $model = $cekNo;
            }
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        if (isset($_POST['FANotriagePasienT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $clone = clone $model;
                if (!empty($_POST['FANotriagePasienT']['notriage_pasien_id'])) {
                    $cek = FANotriagePasienT::model()->findByPk($_POST['FANotriagePasienT']['notriage_pasien_id']);
                    if (!empty($cek)) {
                        $model = $cek;
                    }
                }
                $model->attributes = $_POST['FANotriagePasienT'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $ok && $model->update();

                // echo '<pre>'; var_dump($model->attributes, $clone->attributes); die();


                if (!empty($clone->notriage_pasien_id)) {
                    if ($clone->notriage_pasien_id != $model->notriage_pasien_id) {
                        $clone->pendaftaran_id = null;
                        $clone->pasien_id = null;
                        $clone->update();

                        $wpss = AsesmentriagewpssT::model()->findByAttributes([
                            'notriage_pasien_id' => $clone->notriage_pasien_id
                        ]);

                        if (!empty($wpss)) {
                            $wpss->pendaftaran_id = null;
                            $wpss->pasien_id = null;
                            $wpss->update();
                        }
                    } else {
                        $wpss = AsesmentriagewpssT::model()->findByAttributes([
                            'notriage_pasien_id' => $clone->notriage_pasien_id
                        ]);

                        if (!empty($wpss)) {
                            $wpss->pendaftaran_id = $model->pendaftaran_id;
                            $wpss->pasien_id = $model->pasien_id;
                            $wpss->update();
                        }
                    }
                }

                if ($ok) {
                    $trans->commit();
                    $sukses = 'iya';
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . $ex->getMessage());
            }
        }

        $this->render('_formTambahTriagePasienIGD', array('model' => $model, 'sukses' => $sukses));
    }

    function actionHapus() {
        $pengambilanobat_triage_id = $_POST['pengambilanobat_triage_id'];
        $berhasil = PengambilanobatTriageT::model()->deleteByPk($pengambilanobat_triage_id);
        if($berhasil) {
            $data['sukses'] = 1;
        } else {
            $data['sukses'] = 0;

        }

        echo json_encode($data);

    }

    function actionUbah($pengambilanobat_triage_id) {
        $this->layout = '//layouts/iframe';
        $modPengambilanObat = PengambilanobatTriageT::model()->findByPk($pengambilanobat_triage_id);
        $modPengambilanObat->obatalkes_nama = $modPengambilanObat->obatalkes->obatalkes_nama ??'';
        $is_save = false;
        if(isset($_POST['PengambilanobatTriageT'])) {
            $modPengambilanObat->jumlah = $_POST['PengambilanobatTriageT']['jumlah'];
            $modPengambilanObat->update_time = date('Y-m-d H:i:s');
            if($modPengambilanObat->save()) {
                Yii::app()->user->setFlash('success', "Data Berhasil Diubah ");
                
            } else {
                Yii::app()->user->setFlash('error', "Data gagal diubah ");

            }
        }
        if(!empty($modPengambilanObat)) {
            $this->render('_ubah', [
                'modPengambilanObat' => $modPengambilanObat
            ]);
        } else {
            echo 'data tidak ditemukan';
        }
    }

    function actionValidasi() {
        $data['sukses'] = 0;

        if(isset($_POST['pengambilanobat_triage_id'])) {
            $pengambilanobat_triage_id = $_POST['pengambilanobat_triage_id'];
            $modPengambilanObat = PengambilanobatTriageT::model()->findByPk($pengambilanobat_triage_id);
            if($modPengambilanObat->validasi == null || $modPengambilanObat->validasi == false) {
                $modPengambilanObat->validasi = true;
            } else {
                $modPengambilanObat->validasi = false;
            }
            $modPengambilanObat->update_time = date('Y-m-d H:i:s');
            if($modPengambilanObat->save()) {
                $data['sukses'] = 1;
            }
        }

        echo json_encode($data);

    }

    function actionCekValidasi() {
        $notriage_pasien_id = $_POST['notriage_pasien_id'];
        $type = $_POST['type'];
        $modPengambilanObat = PengambilanobatTriageT::model()->findAllByAttributes(['notriage_pasien_id' => $notriage_pasien_id]);

        $data['disabled'] = 0;

        $modPengambilanObatBelumValidasi = PengambilanobatTriageT::model()->findAllByAttributes(['notriage_pasien_id' => $notriage_pasien_id, 'is_jual' => false], 'validasi is false OR validasi is null');
        if(!empty($modPengambilanObatBelumValidasi)) {
            $data['disabled'] = 1; 
        } else {
            $data['disabled'] = 0;
            if($type == 'load' && empty($modPengambilanObat)) {
                $data['disabled'] = 1;
            }
        }
        
        echo json_encode($data);
    }

    function actionDetailPenjualan() {
        $caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
        $judulLaporan = 'Detail Penjualan';
        
        if(!empty($caraPrint)) {
            $this->layout = '//layouts/printWindows';
        } else {
            $this->layout = '//layouts/iframe';
        }
        $penjualanresep_id = $_GET['penjualanresep_id'];
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualan->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modTriage = NotriagePasienT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
		$modObatAlkes = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

        $this->render('_viewDetailPenjualan', [
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPenjualan' => $modPenjualan,
            'modObatAlkes' => $modObatAlkes,
            'caraPrint' => $caraPrint,
            'judulLaporan' => $judulLaporan,
            'modTriage' => $modTriage
        ]);
    }

    function actionCekPenjualan() {
        $notriage_pasien_id = $_POST['notriage_pasien_id'];
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $data['sukses'] = 0;
        if(!empty($pendaftaran_id)) {
            $modPenjualanResep = PenjualanresepT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
            if(!empty($modPenjualanResep)) {
                $data['penjualanresep_id'] = $modPenjualanResep->penjualanresep_id;
                $data['sukses'] = 1;
    
            }
        }

        echo json_encode($data);
    }

    function actionbuatPenjualanResepRS() {
        $notriage_pasien_id = $_POST['notriage_pasien_id'];
        $pendaftaran_id = $_POST['pendaftaran_id'];

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPengambilan = PengambilanobatTriageT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id], 'validasi is true and jumlah is not null and is_jual is not true');
        $data['sukses'] = 0;
        $data['penjualanresep_id'] = '';
        $modDetails = [];
        if(!empty($modPendaftaran)) {
            $modPengambilanObat = PengambilanobatTriageT::model()->findAllByAttributes(['notriage_pasien_id' => $notriage_pasien_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')], 'validasi is true and jumlah is not null and is_jual is not true');
            $penotalanharga['totharganetto'] = 0;
            $penotalanharga['totalhargajual'] = 0;
            foreach($modPengambilanObat as $key => $val){
                if (strpos($val->jumlah, "/")) {
                    $exJumlah = explode('/', $val->jumlah);
                    if(isset($exJumlah[0]) && isset($exJumlah[1])) {
                      $jumlah = $exJumlah[0] / $exJumlah[1];
                    } 
                  } else if(strpos($val->jumlah, ",") || strpos($val->jumlah, ".")) {
                    $jumlah = MyFormatter::formatNumberForDb($val->jumlah);
                  } else {
                    $jumlah = $val->jumlah;
                  }
                  
                $penotalanharga['totharganetto'] += $val->hargasatuan_reseptur;
                $penotalanharga['totalhargajual'] += ($val->hargasatuan_reseptur * $jumlah);
            }

            $transaction = Yii::app()->db->beginTransaction();

            try {

                $modPenjualan = $this->savePenjualanResepRS($modPendaftaran, $modPengambilan, $penotalanharga);

                foreach($modPengambilanObat as $i => $val) {
                    $modDetails[$i] = new FAObatalkesPasienT;
                    $oa = ObatalkesM::model()->findByPk($val->obatalkes_id);
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
                    $modDetails[$i]->permintaan_oa = $val->jumlah;
                    $modDetails[$i]->obatalkes_id = $val->obatalkes_id;
                    $modDetails[$i]->sumberdana_id = $val->sumberdana_id;
                    $modDetails[$i]->st_fornas = $val->st_fornas;
                    $modDetails[$i]->hargasatuan_oa = $val->hargasatuan_reseptur;
                    $jumlah = 0;
                    if (strpos($val->jumlah, "/")) {
                        $exJumlah = explode('/', $val->jumlah);
                        if(isset($exJumlah[0]) && isset($exJumlah[1])) {
                            $jumlah = $exJumlah[0] / $exJumlah[1];
                        } 
                    } else if(strpos($val->jumlah, ",") || strpos($val->jumlah, ".")) {
                        $jumlah = MyFormatter::formatNumberForDb($val->jumlah);
                    } else {
                        $jumlah = $val->jumlah;
                    }

                    $modDetails[$i]->hargajual_oa = $val->hargasatuan_reseptur * $jumlah;
                    
                    
                    $modDetails[$i]->create_time = date("Y-m-d H:i:s");
                    $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
                    $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
                    $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
                    
                    $modDetails[$i]->qty_oa = $jumlah;
                    $modDetails[$i]->qty_jual = $jumlah;
                    $modDetails[$i]->kekuatan_oa = null;
                    $modDetails[$i]->jumlahppn = 0;
                    $modDetails[$i]->persenppnjual = $oa->ppn_persen;
                    $modDetails[$i]->pengambilanobat_triage_id = $val->pengambilanobat_triage_id;

                    $modDetails[$i]->total_embalase = 0;

                    if(!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0){
                        $modDetails[$i]->pajak_id = 6; //pajak ppn
                    }

                    // var_dump($modDetails[$i]->attributes); die;

                    // var_dump($modDetails[$i]->validate(), $modDetails[$i]->getErrors());
                    if ($modDetails[$i]->validate()) {

                        $this->obatalkespasientersimpan &= $modDetails[$i]->save();
                        if($this->obatalkespasientersimpan) {
                            $update = PengambilanobatTriageT::model()->updateByPk($val->pengambilanobat_triage_id, [
                                'is_jual' => true
                            ]);
                        }
                    } else {
                        $this->obatalkespasientersimpan &= false;
                    }

                }
                // echo '<pre>';var_dump($this->obatalkespasientersimpan, $this->penjualantersimpan);die;
                if($this->obatalkespasientersimpan && $this->penjualantersimpan) {
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
                        $transaction->commit();
					    $this->setAPIPenjualanResepOA($modPenjualan, $modDetails);
                        // cek apakah penjualan api berhasil apa tidak 
                        $cekPenjualan = PenjualanresepT::model()->findByPk($modPenjualan->penjualanresep_id);
                        // jika data terhapus atau empty berarti ada kegagalan saat pengiriman api
                        if(!empty($cekPenjualan)) {
                            $data['sukses'] = 1;
                            $data['penjualanresep_id'] = $modPenjualan->penjualanresep_id;
                        } else {
                            $data['sukses'] = 2;
                            $data['pesan'] = 'Gagal Dilakukan Penjualan';
                        }
                    }
                }
            } catch (Exception $exc) {
                var_dump($exc->getMessage()); die;
                $transaction->rollback();

            }
        }

        echo json_encode($data);

    
    }

    protected function savePenjualanResepRS($modPendaftaran, $modPengambilan, $penotalanharga) {
        
        $format = new MyFormatter();
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPenjualan->penjamin_id = $modPendaftaran->penjamin_id;
        $modPenjualan->carabayar_id = $modPendaftaran->carabayar_id;
        $modPenjualan->antrianfarmasi_id = null;
        $modPenjualan->pegawai_id = $modPengambilan->petugasfarmasi_id;
        $modPenjualan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPenjualan->pasien_id = $modPendaftaran->pasien_id;
        $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array("pendaftaran_id" => $modPendaftaran->pendaftaran_id, "pasien_id" => $modPendaftaran->pasien_id));
        $modPenjualan->pasienadmisi_id = (empty($modPasienAdmisi->pasienadmisi_id)) ? null : $modPasienAdmisi->pasienadmisi_id;
        $modPenjualan->tglpenjualan = date('Y-m-d H:i:s');
        $modPenjualan->tglresep = $modPengambilan->create_time;
        $modPenjualan->ruanganasal_nama = Yii::app()->user->getState('ruangan_nama');
        $modPenjualan->instalasiasal_nama = Yii::app()->user->getState('instalasi_nama');
        $modPenjualan->reseptur_id = null;

        $modPenjualan->statusobat = null;

        $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
        $modPenjualan->noresep = MyGenerator::noResep(Yii::app()->user->getState('instalasi_id'));
        $modPenjualan->subsidiasuransi = 0;
        $modPenjualan->subsidipemerintah = 0;
        $modPenjualan->subsidirs = 0;
        $modPenjualan->iurbiaya = 0;
        $modPenjualan->discount = 0;
        $modPenjualan->jasapelayanan_farmasi = null;
        $modPenjualan->create_time = date("Y-m-d H:i:s");
        $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
        $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->jasapelayanan_farmasi = 0;
        $modPenjualan->jasaembalase = 0;
        $modPenjualan->totalkronis =  0;
        $modPenjualan->totalinacbg = 0;
        $modPenjualan->totharganetto = $penotalanharga['totharganetto'];
        $modPenjualan->totalhargajual = $penotalanharga['totalhargajual'];
        $modPenjualan->totaltarifservice = 0;
        $modPenjualan->biayaadministrasi = 0;
        $modPenjualan->biayakonseling = 0;
        
        $modPenjualan->kodedokter_inventory = "-";
        

        $petugas = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if(!empty($petugas)) {
            $modPenjualan->kodepetugas_inv = $petugas->kodepetugas_inventory;
        }
        if(!empty($modPendaftaran->ruangan)) {
            $modPenjualan->jenislayanan_inv = $modPendaftaran->ruangan->kodeJL_inventory;
            $modPenjualan->tempatlayanan_inv = $modPendaftaran->ruangan->kodeTL_inventory;
        }
        // echo "<pre>"; var_dump($modPenjualan->validate(), $modPenjualan->save());die;

        if ($modPenjualan->validate()) {
            $modPenjualan->save();
            PendaftaranT::model()->updateByPk($modPenjualan->pendaftaran_id, array('pembayaranpelayanan_id' => null));
            
            $this->penjualantersimpan = true;
        } else {
            $this->penjualantersimpan = false;
        }

        return $modPenjualan;
    }

    function actionPrintEtiketTriage($pengambilanobat_triage_id, $caraPrint) {
        
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;

        $modPengambilanObat = PengambilanobatTriageT::model()->findByPk($pengambilanobat_triage_id);
        $modObatAlkes = $modPengambilanObat->obatalkes;
        $modPasienTriage = $modPengambilanObat->notriage;


		$judul_print = 'Penjualan Resep Rumah Sakit';


		$view = "PrintEtiketV2";


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
					'modPengambilanObat' => $modPengambilanObat,
                    'modObatAlkes' => $modObatAlkes,
                    'modPasienTriage' => $modPasienTriage
				), true)
			);
			$mpdf->SetJS('this.print();');
			$mpdf->Output();
		}
	
    }

    function actionPrintEtiket($obatalkespasien_id, $penjualanresep_id) {

        $modPenjualanResep = PenjualanresepT::model()->findByPk($penjualanresep_id);
        $modObatAlkes = ObatalkespasienT::model()->findByPk($obatalkespasien_id);
        $modPasien = $modPenjualanResep->pasien;
        $modPendaftaran = $modPenjualanResep->pendaftaran;
        // echo '<pre>';var_dump($modObatAlkes);die;
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
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial('_printEtiket', array(
                'modObatAlkes' => $modObatAlkes,
                'modPenjualanResep' => $modPenjualanResep,
                'modPasien' => $modPasien,
                'modPendaftaran' => $modPendaftaran
            ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    function actionPrintAllEtiket($caraPrint, $penjualanresep_id) {

        $modPenjualanResep = PenjualanresepT::model()->findByPk($penjualanresep_id);
        $modObatAlkes = ObatalkespasienT::model()->findAllByAttributes(['penjualanresep_id' => $modPenjualanResep->penjualanresep_id]);
        $modPasien = $modPenjualanResep->pasien;
        $modPendaftaran = $modPenjualanResep->pendaftaran;

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
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial('_printAllEtiket', array(
                'modObatAlkes' => $modObatAlkes,
                'modPenjualanResep' => $modPenjualanResep,
                'modPasien' => $modPasien,
                'modPendaftaran' => $modPendaftaran
            ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }
}

