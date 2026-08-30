<?php

Yii::import("billingKasir.controllers.PembayaranTagihanPasienController");

class PembayaranUangMukaController extends PembayaranTagihanPasienController
{
    public $path_view = 'billingKasir.views.pembayaranUangMuka.';
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BKInfokunjunganrjV;
        $model=new BKBayaruangmukaT;
        $modTandabukti = new BKTandabuktibayarT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayaruangmuka = new BKBayaruangmukaT;
        $modTandabukti->tglbuktibayar = $format->formatDateTimeForUser(date('Y-m-d H:m:s'));
		//$modKunjungan->tglselesaiperiksa=date('Y-m-d H:m:s');

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

        // Uncomment the following line if AJAX validation is needed

        if(isset($_GET['instalasi_id'])){
            if($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ){
                $loadKunjungan = BKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RD){
                $loadKunjungan = BKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));;
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RI){
				//$loadKunjungan = BKInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'pasienadmisi_id'=>@$_POST['pasienadmisi_id']));;
				$loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));;
			}
            if(isset($loadKunjungan)){
                $modKunjungan = $loadKunjungan;
            }
        }

        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }


        if(isset($_POST['BKTandabuktibayarT']))
        {
            $modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $tandaBuktiBayarUangMuka = $_POST['BKTandabuktibayarT'];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!empty($_GET['frame']))
                {
                    $modBayaruangmuka = $this->updateBayarUangMuka($modBayaruangmuka, $_POST);
                }else{
                    $modTandabukti = $this->saveTandaBuktiBayar(
                        $tandaBuktiBayarUangMuka,$modPendaftaran,$modPasien
                    );
                }

                // die;

                // SMS GATEWAY

                $transaction->commit();
                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                if(empty($modBayaruangmuka->bayaruangmuka_id))
                    $modBayaruangmuka = BKBayaruangmukaT::model()->findByAttributes(array('tandabuktibayar_id'=>$modTandabukti->tandabuktibayar_id));
                $this->redirect(array('index','id'=>$modBayaruangmuka->bayaruangmuka_id,'pendaftaran_id'=>$modBayaruangmuka->pendaftaran_id,'instalasi_id'=>$modPendaftaran->instalasi_id,'sukses'=>1));
            }catch(Exception $exc){
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }

        if(!empty($id)){
            $model = BKBayaruangmukaT::model()->findByPk($id);
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
            $modTandabukti->is_menggunakankartu = 0;
        }

        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
        //$modKunjungan->tglselesaiperiksa = $format->formatDateTimeForUser($_POST['tglselesaiperiksa']);
        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modKunjungan'=>$modKunjungan,
            'modPemakaianuangmuka'=>$modPemakaianuangmuka,
        ));
    }



     /**
     * form verifikasi sebelum submit
     * @param type $id
     */
    public function actionVerifikasi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = '//layouts/iframe';
            if (isset($_POST['BKBayaruangmukaT'])) {
                $format = new MyFormatter();
                $criteria = new CdbCriteria();
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }
                if (!empty($pasienadmisi_id)) {
                    $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
                }
                if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RJ) {
                    $modKunjungan = BKInfokunjunganrjV::model()->find($criteria);
                } else if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RD) {
                    $modKunjungan = BKInfokunjunganrdV::model()->find($criteria);
                } else if (in_array($_POST['instalasi_id'], array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) {
                    $modKunjungan = BKInformasikasirinappulangV::model()->find($criteria);
                }
                $model = new BKBayaruangmukaT;
                $modTandabukti = new BKTandabuktibayarT;

                $model->attributes = $_POST['BKBayaruangmukaT'];
                $model->totbiayasementara = $_POST['BKBayaruangmukaT']['totbiayasementara'];
                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];

                $modJenisPembayaran = array();
                $indexJns = 1;
                if (isset($_POST['JenispembayaranT']['detail']) && count((array) $_POST['JenispembayaranT']['detail']) > 0) {
                    foreach ($_POST['JenispembayaranT']['detail'] as $jnsPem) {
                        $jnsPembyr = JnspembayarM::model()->findByPk($jnsPem['jenispembayaran']);
                        $banknama = "";
                        if (isset($jnsPem['bankpenerima_id'])) {
                            $bankPen = BankM::model()->findByPk($jnsPem['bankpenerima_id']);
                            $banknama = (isset($bankPen) ? $bankPen->namabank : "");
                        }

                        $jenisPm = array(
                            'jnspembayar_nama' => (isset($jnsPembyr) ? $jnsPembyr->jnspembayar_nama : ""),
                            'bank_nama' => $banknama,
                            'tgltransaksi' => $jnsPem['tgltransaksi'],
                            'nominal' => $jnsPem['jumlahpembayaran'],
                            'bayarke' => $indexJns
                        );
                        $indexJns += 1;

                        $modJenisPembayaran[] = $jenisPm;
                    }
                }
            }
            echo CJSON::encode(array(
                'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
                    'format' => $format,
                    'modKunjungan' => $modKunjungan,
                    'model' => $model,
                    'modTandabukti' => $modTandabukti,
                    'modJenisPembayaran' => $modJenisPembayaran
                ), true)
            ));
            exit;
        }
    }

    protected function updateBayarUangMuka($model_bayar_muka,$post)
        {
            $update = BKBayaruangmukaT::model()->updateByPk(
                $model_bayar_muka->bayaruangmuka_id,
                array(
                    'jumlahuangmuka'=>$post['BKTandabuktibayarUangMukaT']['jmlpembayaran']
                )
            );

            $update_bukti_bayar = TandabuktibayarT::model()->updateByPk(
                $model_bayar_muka->tandabuktibayar_id,
                array(
                    'jmlpembayaran'=>$post['BKTandabuktibayarUangMukaT']['jmlpembayaran'],
                    'uangditerima'=>$post['BKTandabuktibayarUangMukaT']['uangditerima'],
                )
            );
            return $update;
        }


    protected function saveTandaBuktiBayar($postTandaBukti,$modPendaftaran,$modPasien)
    {
        $format = new MyFormatter;
        $modTandaBukti = new BKTandabuktibayarT;
        $modTandaBukti->attributes = $postTandaBukti;
        $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($modTandaBukti->tglbuktibayar);
        $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
        $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayarNew();
        $modTandaBukti->alamat_bkm = isset($modTandaBukti->alamat_bkm)?$modTandaBukti->alamat_bkm:'-';
		$modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modTandaBukti->create_time = date("Y-m-d H:i:s");
		$modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
		$modTandaBukti->shift_id= Yii::app()->user->getState('shift_id');

      // if ($model->totaliurbiaya == $modTandabukti->bank_nominal) {
      //     $modTandabukti->jmlpembulatan = 0;
      // }

        if($modTandaBukti->validate())
        {
            if($modTandaBukti->save()){
              $this->simpanDetailPembayaran($modTandaBukti);
              $this->saveBayarUangMuka($modTandaBukti, $modPendaftaran, $modPasien);

            }
        }else{
            throw new Exception('Data Tanda Bukti Bayar tidak valid');
        }

        return $modTandaBukti;
    }

    protected function simpanDetailPembayaran($modTandaBukti, $model = null) {
        $nominal = 0;
        if (isset($_POST['JenispembayaranT']['detail'])
            && count((array)$_POST['JenispembayaranT']['detail']) > 0
            && isset($_POST['BKTandabuktibayarT']['is_menggunakankartu'])
            && $_POST['BKTandabuktibayarT']['is_menggunakankartu'] == 1) {

            foreach ($_POST['JenispembayaranT']['detail'] as $item) {
                $jenis = new JenispembayaranT;
                $jenis->attributes = $item;
                $jenis->jnspembayar_id = $item['jenispembayaran'];
                $jenis->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;

                if (!empty($jenis->tgltransaksi)) {
                    $jenis->tgltransaksi = MyFormatter::formatDateTimeForDB($jenis->tgltransaksi);
                }

                if (!empty($jenis->tgljatuhtempo)) {
                    $jenis->tgljatuhtempo = MyFormatter::formatDateTimeForDB($jenis->tgljatuhtempo);
                }

                if ($jenis->validate()) {
                    $jenis->save();
                } else {
                    $this->tandabuktibayar_tersimpan = false;
                }

                $nominal += $jenis->jumlahpembayaran;
            }

        }


        $modTandaBukti->bank_nominal = $nominal;
        $modTandaBukti->save();
    }

    protected function saveBayarUangMuka($modTandaBukti,$modPendaftaran,$modPasien)
    {
		// var_dump($modPendaftaran->attributes); die;

		$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

        $modUangMuka = new BayaruangmukaT;
        $modUangMuka->attributes = $_POST['BKBayaruangmukaT'];
        $modUangMuka->nouangmuka = MyGenerator::noUangMuka(Yii::app()->user->id);
        $modUangMuka->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
        $modUangMuka->tgluangmuka = $modTandaBukti->tglbuktibayar;
        //$modUangMuka->jumlahuangmuka = $modTandaBukti->jmlpembayaran;
        $modUangMuka->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUangMuka->pasien_id = $modPendaftaran->pasien_id;
        $modUangMuka->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
//      --RND-9743  $modUangMuka->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modUangMuka->ruangan_id = empty($admisi)?$modPendaftaran->ruangan_id:$admisi->ruangan_id;
		$modUangMuka->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modUangMuka->create_time = date("Y-m-d H:i:s");
		$modUangMuka->create_loginpemakai_id = Yii::app()->user->id;

		// var_dump($modUangMuka->attributes, $_POST); die;

        if($modUangMuka->validate())
        {
            $modUangMuka->save();
            $this->updateTandaBukti($modTandaBukti, $modUangMuka);

            $konfig = KonfigsystemK::model()->find();
            if ($konfig->isjurnalotomatis) {
                $this->simpanJurnalBayarUangMuka($modUangMuka, $modTandaBukti);
            }


            $this->notifUangMuka($modUangMuka, $modTandaBukti);

        }else{
            throw new Exception('Data Uang Muka tidak valid');
        }

        // var_dump($modUangMuka->attributes, $modTandaBukti->attributes);

        // die;
    }


    protected function notifUangMuka($modUangMuka, $modTandaBukti) {

        $judul = "Pembayaran Uang Muka - ".$modUangMuka->nouangmuka;
        $pasien = PasienM::model()->findByPk($modUangMuka->pasien_id);
        $pendaftaran = PendaftaranT::model()->findByPk($modUangMuka->pendaftaran_id);

        $isi = "";
        $isi .= "Tgl. Pembayaran : ".MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmuka)."<br/>";
        $isi .= "No. Pendaftaran : ".$pendaftaran->no_pendaftaran."<br/>";
        $isi .= "No. RM : ".$pasien->no_rekam_medik."<br/>";
        $isi .= "Nama Pasien : ".$pasien->nama_pasien."<br/>";
        $isi .= "Nilai : ".MyFormatter::formatNumberForPrint($modUangMuka->jumlahuangmuka)."<br/>";


        $ruanganKasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);


        $cur = array(
            array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
            array('instalasi_id'=>$ruanganKasir->instalasi_id, 'ruangan_id'=>$ruanganKasir->ruangan_id, 'modul_id'=>$ruanganKasir->modul_id)
        );

        CustomFunction::broadcastNotif($judul, $isi, $cur);
    }


    protected function simpanJurnalBayarUangMuka($modUangMuka, $modTandaBukti) {

        $pendaftaran = PendaftaranT::model()->findByPk($modUangMuka->pendaftaran_id);
        $pasien = PasienM::model()->findByPk($modUangMuka->pasien_id);


        // $saldo_kas = $modTandaBukti->jmlpembayaran - $modTandaBukti->bank_nominal;
        $saldo_kas = $modTandaBukti->uangditerima;
        $saldo_bank = $modTandaBukti->bank_nominal;
        // $saldo_uangmuka = $modTandaBukti->jmlpembayaran;
        $saldo_uangmuka = $modUangMuka->jumlahuangmuka;

        $saldo_bulat = $modTandaBukti->jmlpembulatan;

        $rek_kas = CarapembrekM::model()->findByAttributes(array(
            'carapembayaran'=>Params::CARAPEMBAYARAN_TUNAI,
            'debitkredit'=>'D',
        ));
        $rek_bank = BankrekM::model()->findByAttributes(array(
            'bank_id'=>$modTandaBukti->bank_id,
            'saldonormal'=>'D',
        ));
        $rek_uangmuka = RekeningcolumnM::model()->findByAttributes(array(
            'table_name'=>'bayaruangmuka_t',
            'column_name'=>'jumlahuangmuka',
            'debitkredit'=>'K',
        ));
        $rek_bulatK = RekeningcolumnM::model()->findByAttributes(array(
            'table_name'=>'tandabuktibayar_t',
            'column_name'=>'jmlpembulatan',
            'debitkredit'=>'K',
        ));

        // simpan jurnal rekening
        $ok = true;

        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modJurnalRekening->tglbuktijurnal, 'JTK');
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $modUangMuka->nouangmuka;
        $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = "Pembayaran Uang Muka Pasien - ".$modUangMuka->nouangmuka
                ." - ".$pendaftaran->no_pendaftaran." - ".$pasien->no_rekam_medik." ".$pasien->namadepan.$pasien->nama_pasien;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
        $modJurnalRekening->rekperiod_id = RekperiodM::model()->findByAttributes(array('isclosing'=>false))->rekperiod_id;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->bayaruangmuka_id = $modUangMuka->bayaruangmuka_id;

        if ($modJurnalRekening->validate()) {
            $ok = $ok && $modJurnalRekening->save();

            // simpan jurnal detail

            $debiturut = 1;
            if ($saldo_bank > 0) {
                $modJenisPembayaran = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$modTandaBukti->tandabuktibayar_id));

                if(count((array)$modJenisPembayaran) >0){
                  foreach ($modJenisPembayaran as $jnsPem) {
                    $rek5_id = null;
                    $jumlahpembayaran = 0;
                    $bankPenId = (!empty($jnsPem->bankpenerima_id)?$jnsPem->bankpenerima_id:null);
                    $modJnsRek = JnspembrekM::model()->findByAttributes(array('bank_id'=>$bankPenId,'jnspembayar_id'=>$jnsPem->jnspembayar_id,'debitkredit'=>'D'));

                    if(isset($modJnsRek)){
                      $rek5_id = $modJnsRek->rekening5_id;
                      $jumlahpembayaran = $jnsPem->jumlahpembayaran;
                    }

                    if(!empty($rek5_id)){
                      $this->simpanJurnalDetail($modJurnalRekening, $rek5_id, $jumlahpembayaran, true, $debiturut);
                      $debiturut = ($debiturut + 1);
                    }
                  }
                }
                // $this->simpanJurnalDetail($modJurnalRekening, $rek_bank->rekening5_id, $saldo_bank, true, 2);
            }else{
              if (!empty($rek_kas) && $saldo_kas > 0) {
                  $this->simpanJurnalDetail($modJurnalRekening, $rek_kas->rekening5_id, $saldo_kas, true, $debiturut);
              }
            }
            if ($saldo_bulat != 0) {
              $debiturut = ($debiturut + 1);

              if(isset($rek_bulatK)){
                if($saldo_bulat > 0){
                      $this->simpanJurnalDetail($modJurnalRekening, $rek_bulatK->rekening5_id, $saldo_bulat, false, $debiturut);
                }else{
                      $this->simpanJurnalDetail($modJurnalRekening, $rek_bulatK->rekening5_id, abs($saldo_bulat), true, $debiturut);
                }
              }

            }

            if (!empty($rek_uangmuka) && $saldo_uangmuka > 0) {
              $debiturut = ($debiturut + 1);
                $this->simpanJurnalDetail($modJurnalRekening, $rek_uangmuka->rekening5_id, $saldo_uangmuka, false, $debiturut);
            }

        } else {
            $ok = false;
        }


        // var_dump($ok, $modJurnalRekening->errors, $modJurnalRekening->attributes);


        // var_dump($modUangMuka->attributes, $modTandaBukti->attributes);

        // die;
    }

    protected function simpanJurnalDetail($modJurnalRekening, $rek, $saldo, $is_debit, $no_urut = 1) {
        $detail = new JurnaldetailT();
        $detail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $detail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $detail->nourut = $no_urut;
        $detail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $detail->rekening5_id = $rek;

        $detail->saldodebit = $is_debit ? $saldo : 0;
        $detail->saldokredit = $is_debit ? 0 : $saldo;

        $ok = true;
        if ($detail->validate()) {
            $ok = $ok && $detail->save();
        } else {
            $ok = false;
        }
    }

    protected function updateTandaBukti($modTandaBukti,$modUangMuka)
    {
        TandabuktibayarT::model()->updateByPk($modTandaBukti->tandabuktibayar_id, array('bayaruangmuka_id'=>$modUangMuka->bayaruangmuka_id));
    }

    /**
     * menghitung rincian tagihan tindakan
     */
    public function actionSetRincianTindakan(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $dataTindakans = array();
            $dataOas = array();
            if(!empty($pendaftaran_id)){

                $criteria = new CDbCriteria;
                $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
                $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
                $modRincians = RinciantagihanpasienV::model()->findAll($criteria);

                $jumlah_tagihan = 0;

                $grp = array();

                $suba = 0;
                $subp = 0;
                $subr = 0;
                $subtotal = 0;
                $subtotalKotor = 0;
                $admin = 0;
                $jasafarmasi = 0;
                $totalembalase = 0;

                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);


                $modTanggungan = null;
                if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                    $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id,'penjamin_id'=>$modPendaftaran->penjamin_id));
                } else if(isset($modPendaftaran->asuransipasien_id)){
                    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    if(isset($modAsuransiPasien->kelastanggunganasuransi_id)&&isset($penjamin_id)){
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransiPasien->kelastanggunganasuransi_id,'penjamin_id'=>$penjamin_id));
                    }
                }

                $subsidiasuransitind = 0;
                $subsidipemerintahtind = 0;
                $subsidirstind = 0;

                if(!empty($modTanggungan->tanggunganpenjamin_id)){
                    $subsidiasuransitind = $modTanggungan->subsidiasuransitind;
                    $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
                    $subsidirstind = $modTanggungan->subsidirumahsakittind;
                } else {
                    if (count((array)$modRincians) > 0) {
                        $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
                        $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);

                        if ($cb->issubsidiasuransi) $subsidiasuransitind = 100;
                        if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                        if ($cb->issubsidirs) $subsidirstind = 100;
                    }
                }


                $modRincians2 = array();

                foreach ($modRincians as $item) {
                    $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
                        'select'=>'daftartindakan_akomodasi'
                    ));
                    if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
                        array_unshift($modRincians2, $item);
                    } else {
                        $modRincians2[] = $item;
                    }
                }

                unset($modRincians);

                // echo '<pre>'; var_dump($modRincians2); die;

                foreach ($modRincians2 as $item) {

                    $is_akomodasi = false;

                    $tindakan =TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);

                    if (!$item->is_alkes) {
                    if(!empty($tindakan->penjualanresep_id)) {
                        continue;
                    } else {
                        $verifBatal = VerifbataltindakanT::model()->findByPk($tindakan->verifbataltindakan_id);
                        if (!empty($verifBatal) && $verifBatal->isverif = true) {
                            continue;
                        }
                    }
                    if (trim($tindakan->nopelayanan) == "" || trim($tindakan->nopelayanan) == "-") {
                        continue;
                    }

                    if ($tindakan->daftartindakan->daftartindakan_akomodasi) {
                        $item->ruangan_id = "AKO";
                        $item->ruangan_nama = "AKOMODASI";
                        $item->daftartindakan_nama = "Akomodasi";
                        $is_akomodasi = true;
                    }
                    }

                    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
                    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
                    
                    $is_paket = $item->is_paketbmhp && !empty($item->paketbmhp_id);


                    if ($item->instalasi_id == Params::INSTALASI_ID_RD) {
                        $item->ruangan_id = "IGD";
                        $item->ruangan_nama = "RAWAT DARURAT";
                    }

                    if ($item->is_alkes) {
                        $item->ruangan_id = 'FA9';
                        $item->ruangan_nama = 'FARMASI';
                    }


                    if ($is_paket) {
                        $item->ruangan_id = "PKT_01";
                        $item->ruangan_nama = "PAKET";
                    }

                    if (empty($grp[$item->ruangan_id])) {
                        $grp[$item->ruangan_id] = array(
                            'nama'=>$item->ruangan_nama,
                            'content'=>array(),
                            'total'=>0,
                        );
                    }

                    

                    /*
                    if (empty($item->tindakansudahbayar_id)) {
                        $item->subsidiasuransi_tindakan = $item->tarif_hargajual * $subsidiasuransitind / 100;
                        $item->subsidipemerintah_tindakan = $item->tarif_hargajual * $subsidipemerintahtind / 100;
                        $item->subsisidirumahsakit_tindakan = $item->tarif_hargajual * $subsidirstind / 100;
                    } else continue;
                    */

                    if($item->is_alkes){
                        if($item->qty_tindakan <= 0){
                            continue;
                        }
                    }

                    if ($item->qty_tindakan == 0) {
                        $item->subsidiasuransi_tindakan = 0;
                        $item->subsidipemerintah_tindakan = 0;
                        $item->subsisidirumahsakit_tindakan = 0;
                    }



                    $suba += $item->subsidiasuransi_tindakan;
                    $subp += $item->subsidipemerintah_tindakan;
                    $subr += $item->subsisidirumahsakit_tindakan;

                    if($item->is_alkes){
                    // $item->tarif_satuan = $item->tarif_hargajual;

                    }
                    // $item->tarif_satuan = round($item->tarif_satuan);

                    $subtotal += $item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

                    $item->tgl_tindakan = MyFormatter::formatDateTimeForDb($item->tgl_tindakan);


                    $detail_ambulans = null;

                    if ($item->komponenunit_id == Params::KOMPONENUNIT_ID_AMBULANS && !$item->is_alkes) {
                        $pemakaian = PemakaianambulansT::model()->findByAttributes(array('tindakanpelayanan_id'=>$item->tindakanpelayanan_id));
                        if (!empty($pemakaian)) {
                            $item->daftartindakan_nama .= " - ".$pemakaian->alamattujuan;
                            $detail_ambulans = empty($pemakaian->jasasarana_ambulans) ? array() : array(
                                array('nama'=>"Jasa Sarana", 'biaya'=>$pemakaian->jasasarana_ambulans),
                                array('nama'=>"BHP", 'biaya'=>$pemakaian->bhp),
                                array('nama'=>"Jasa Pengemudi", 'biaya'=>$pemakaian->jasapengemudi),
                                array('nama'=>"Jasa Pendamping", 'biaya'=>$pemakaian->jasapendamping),
                                array('nama'=>"Jasa Dokter", 'biaya'=>$pemakaian->jasadokter),
                                array('nama'=>"Biaya Tol", 'biaya'=>$pemakaian->biayatol),
                            );
                        } else {
                            $detail_ambulans = array();
                        }
                    }
                    

                    $tanggal = date('d/m/Y', strtotime($item->tgl_tindakan));
                    $daftartindakan_id = $item->daftartindakan_id."_".($item->is_alkes ? "0" : "1");
                    if($item->cyto_tindakan == true){
                        $harga = $item->tarifcyto_tindakan;
                    }else{
                        $harga = $item->tarif_satuan;
                    }
                    $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
                        'select'=>'daftartindakan_akomodasi'
                    ));

                    
                    if ($is_paket) {
                        $idx_line = "BMHP_".$item->paketbmhp_id."_".date('YmdHi', strtotime($item->tgl_tindakan));
                    } else {
                        if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
                            // $idx_line = $item->tindakanpelayanan_id."::".$item->pegawai_id."::".$harga;
                            $idx_line = "AKO_1";
                        } else if(!empty($tindakan->tindakanluar_nama)) {
                            $idx_line = $item->tindakanpelayanan_id . "::" . $harga;
                        } else {
                            $idx_line =  $item->tindakanpelayanan_id."::".$item->pegawai_id."::".$tanggal."::".$harga;
                        }
                    }


                    $total_lunas = 0;
                    $no_nota = "";
                    if ($item->is_alkes) {
                        $modBayar = OasudahbayarT::model()->findAllByAttributes(array(
                            'obatalkespasien_id'=>$item->tindakanpelayanan_id
                        ), array(
                            'condition'=>'orderbatalpembayaranpelayanan_id is null'
                        ));

                        foreach ($modBayar as $itemBayar) {
                            $total_lunas += $itemBayar->jmliurbiaya + $itemBayar->jmlsubsidi_asuransi;
                        }


                        $oa = ObatalkespasienT::model()->findByPk($item->tindakanpelayanan_id);


                        if (!empty($oa->penjualanresep_id)) {
                            $tindakan_oa = TindakanpelayananT::model()->findByAttributes(array(
                                'penjualanresep_id'=>$oa->penjualanresep_id,
                            ));
                            if (!empty($tindakan_oa) && !empty($tindakan_oa->nopelayanan)) {
                                $no_nota = $tindakan_oa->noNota;
                            } else {
                                $no_nota = "-";
                            }
                        }
                    } else {
                        $modBayar = TindakansudahbayarT::model()->findAllByAttributes(array(
                            'tindakanpelayanan_id'=>$item->tindakanpelayanan_id
                        ), array(
                            'condition'=>'orderbatalpembayaranpelayanan_id is null'
                        ));
                        foreach ($modBayar as $itemBayar) {
                            $total_lunas += $itemBayar->jmliurbiaya + $itemBayar->jmlsubsidi_asuransi;
                        }

                        
                        
                        if (!empty($tindakan->nopelayanan)) {
                            $no_nota = $tindakan->noNota;
                        } else {
                            $no_nota = "-";
                        }
                    }


                    $item->tarif_satuan = (($item->cyto_tindakan == true && $item->tarifcyto_tindakan != 0) ? $item->tarifcyto_tindakan :$item->tarif_satuan);
                    $tarifsatuanHarga = ($item->tarif_satuan + $item->biayaadministrasi +  ($item->qty_tindakan == 0 ? 0 : ($item->jumlahppn/$item->qty_tindakan)));
                    // $tarifSubtota = (($tarifsatuanHarga * $item->qty_tindakan)- $item->discount_tindakan - $item->subsidiasuransi_tindakan -$item->subsisidirumahsakit_tindakan);
                    $tarifSubtota = ($tarifsatuanHarga * $item->qty_tindakan) - $item->discount_tindakan - $item->subsisidirumahsakit_tindakan;
                    
                    $jumlah_tagihan += $tarifSubtota;

                }



                

                // var_dump($admin, $jasafarmasi, $totalembalase);


            }

            // uang muka
            $uangmuka = BKBayaruangmukaT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ), array(
                'condition'=>'pembatalanuangmuka_id is null',
            ));

            foreach ($uangmuka as $item) {
                $jumlah_tagihan -= $item->jumlahuangmuka;
            }

            $default_uangmuka = 0;
            if ($jumlah_tagihan > 0) {
                $default_uangmuka = $jumlah_tagihan * 0.4;
            }

            $data['tagihan']=$jumlah_tagihan;
            $data['uangmuka']=$default_uangmuka;
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_pendaftaran
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
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
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $models = BKInfokunjunganrjV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $models = BKInfokunjunganrdV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $models = BKInformasikasirinappulangV::model()->findAll($criteria);
            }
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
                $returnVal[$i]['value'] = $model->no_pendaftaran;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Mengurai data kunjungan berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
			}
			if(!empty($instalasi_id)){
				// $criteria->addCondition("instalasi_id = ".$instalasi_id);
			}

			// var_dump($pendaftaran_id); die;
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
			// var_dump($criteria); die;
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = BKInfokunjunganrjV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = BKInfokunjunganrdV::model()->find($criteria);
            }else if(in_array($instalasi_id, Params::grupInstalasiRIID())){
                $model = BKInformasikasirinappulangV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
                $model = BKInformasikasirinappulangV::model()->find($criteria);
            // }else if ($instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
            //    $model = BKInformasikasirrdpulangV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_LAB || $instalasi_id == Params::INSTALASI_ID_RAD){
                $model = BKPasienmasukpenunjangV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_REHAB){
                $model = BKPasienmasukpenunjangV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_HD){
                $model = InformasikasirhemodialisaV::model()->find($criteria);
            }

            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            //load uang muka
            $crit_uangmuka = new CDbCriteria();
			if(!empty($model->pendaftaran_id)){
				$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);
			}
			if(!empty($model->pasienadmisi_id)){
				$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);
			}
            $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL and pembatalanuangmuka_id is null");
            $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
            $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);

			$carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
			$returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);

            $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
    {
            if (!isset($caraPrint)){
                    $caraPrint=null;
            }
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('bayaruangmuka_id = '.$idPembayaran);
//		$criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
            $criteria->order = 'ruangan_id';
            $detail = BKBayaruangmukaT::model()->findAll($criteria);

            $no_bkm = '';
            $tgl_bkm = '';
            $pembayar = '';
            $total_bayar = '';
            $total_bayar_huruf = '';
            $rec = array();
            foreach($detail as $key=>$val)
            {
                    $data[] = null;
                    $data['tglpembayaran'] = date('d-m-Y', strtotime($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar"))));
                    $data['keterangan'] = 'Pembayaran uang muka';
                    $data['jumlah'] = $val->jumlahuangmuka;
//
                    $total_bayar += $val->jumlahuangmuka;
                    $no_bkm = $val->getTandaBukti("nobuktibayar");
                    $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
                    $pembayar = $val->getTandaBukti("darinama_bkm");
//
                    $rec[] = $data;
            }

            $data = array(
                    'header'=>array(
                            'no_bkm'=>$no_bkm,
                            'tgl_bkm'=>$tgl_bkm,
                            'total_bayar'=>$format->formatUang($total_bayar, "Rp. "),
                            'total_bayar_huruf'=>$format->formatNumberTerbilang($total_bayar),
                            'pembayar'=>$pembayar,
                    ),
                    'detail'=>$rec,
                    'footer'=>123,
            );
            if($caraPrint == 'PRINT')
            {
                    $this->layout='//layouts/printWindows';
                    $this->render('detailKasMasuk',
                            array(
                                    'data'=>$data,
                                    'caraPrint'=>$caraPrint,
                                    'format'=>$format
                            )
                    );
            }else{
                    $this->layout = '//layouts/iframe';
                    $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
                    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                    $mpdf = new MyPDF60('',$ukuranKertasPDF);
                    //$mpdf->useOddEven = 2;
//                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet, 1);
                    $mpdf->AddPage($posisi,'','','','',5,5,5,5);
                    $mpdf->WriteHTML(
                            $this->render('detailKasMasuk',
                                    array(
                                            'format'=>$format,
                                            'data'=>$data,
                                            'caraPrint'=>$caraPrint
                                    ),true
                            )
                    );
                    $mpdf->Output();
            }
    }

	/**
     * method untuk print kwitansi
     * @param int $bayaruangmuka_id bayaruangmuka_id
     */
    public function actionPrintKuitansi($bayaruangmuka_id)
    {
        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = BKBayaruangmukaT::model()->findByPk($bayaruangmuka_id);
        $modTandaBukti = BKTandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $criteria = new CdbCriteria();

        if(!empty($modBayar->pendaftaran_id)){
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        }else{
            $modPendaftaran = new PendaftaranT;
        }
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
		$discount = 0;

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'printKuitansi', array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint, 'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'printKuitansi',array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint,'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            //$mpdf = new MyPDF60('',$ukuranKertasPDF);
            //$mpdf = new MyPDF60('','B5-L');
            $mpdf = new MyPDF60('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            /*
             * cara ambil margin
             * tinggi_header * 72 / (72/25.4)
             *  tinggi_header = inchi
             */

            /*font-family: tahoma;*/
            // $header = 0.50 * 72 / (72/25.4);
            $header = 0.3 * 72 / (72/25.4);
            $mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
            $mpdf->WriteHTML(
                $this->renderPartial(
                    $this->path_view.'printKuitansiPdf',
                    array(
                        'model'=>$model,
                        'pembayarans'=>$pembayarans,
                        'modPendaftaran'=>$modPendaftaran,
                        'judulKuitansi'=>$judulKuitansi,
                        'caraPrint'=>$caraPrint,
                        'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar
                    ),true
                )
            );
            $mpdf->Output();
        }
    }

    public function actionGetCaraPembayaranLookup() {
        if (Yii::app()->request->isAjaxRequest) {
            $carapembayaran = $_POST["carapembayaran"];
            $carabayar ="";
             $modMaster = LookupM::model()->findByAttributes(array('lookup_type'=> 'carapembayaran','lookup_value'=>$carapembayaran));
            if(isset($modMaster)){
                $carabayar = $modMaster->lookup_name;
            }
            $data['value']= $carabayar;
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrintRincianPembayaran($bayaruangmuka_id)
    {
        $format = new MyFormatter();
        $modBayar = BKBayaruangmukaT::model()->findByPk($bayaruangmuka_id);
        $modTandaBukti = BKTandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modBayar->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $jenispembayaran = "";
        $bank = "";
        $jmlpembayaran = 0;

        $modJnsPembayaran = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$modTandaBukti->tandabuktibayar_id));

        if(count((array)$modJnsPembayaran) > 0){
          foreach ($modJnsPembayaran as $jnsPem) {
            $jenispembayaran = (isset($jnsPem->jnspembayar)?$jnsPem->jnspembayar->jnspembayar_nama:"-");
            $bank = (isset($jnsPem->bankpenerima)?$jnsPem->bankpenerima->namabank:"-");
            $jmlpembayaran += $jnsPem->jumlahpembayaran;
          }
        }

        $dataTindakans = array();
        $dataOas = array();
        $jumlah_tagihan = 0;
        if(!empty($modPendaftaran->pendaftaran_id)){
            $criteria = new CdbCriteria();
            $criteria->select = "sum((tarif_satuan * qty_tindakan) + tarifcyto_tindakan - discount_tindakan - pembebasan_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan) as total";
            $criteria->addCondition("pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
            $criteria->addCondition("tindakansudahbayar_id IS NULL");
            $dataTindakan=BKTindakanPelayananT::model()->find($criteria);

            $criteria = new CdbCriteria();
            $criteria->select = "sum((hargasatuan_oa * qty_oa) + tarifcyto-discount + (biayaservice + biayakonseling + biayakemasan + biayaadministrasi) - subsidiasuransi - subsidirs) as total";
            $criteria->addCondition("pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
            $criteria->addCondition("oasudahbayar_id IS NULL");
            $dataOa=BKObatalkesPasienT::model()->find($criteria);

            $jumlah_tagihan = $dataTindakan->total + $dataOa->total;
        }

        // uang muka
        $uangmuka = BKBayaruangmukaT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
        ), array(
            'condition'=>'pembatalanuangmuka_id is null',
        ));

        foreach ($uangmuka as $item) {
            $jumlah_tagihan -= $item->jumlahuangmuka;
        }

        $this->layout='//layouts/printWindows';
        $this->render($this->path_view.'printRincianPembayaran', array('modPendaftaran'=>$modPendaftaran,
            'modPasienAdmisi'=>$modPasienAdmisi,
            'modPasien'=>$modPasien,
             'modTandaBukti'=>$modTandaBukti,
             'modBayar'=>$modBayar,
             'jenispembayaran'=>$jenispembayaran,
           'bank'=>$bank,
         'jmlpembayaran'=>$jmlpembayaran,
       'jumlah_tagihan'=>$jumlah_tagihan));
    }
}
