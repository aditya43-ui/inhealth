<?php

class OrderBatalPembayaranController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.orderBatalPembayaran.';
    public $path_view_apotek = 'billingKasir.views.informasipenjualanresep.';

    public function actionIndex($id = null) {
        $format = new MyFormatter();
        $modKunjungan = new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
        $model = new BKPembayaranpelayananT;
        $dataTindakans = array();
        $dataOas = array();

        $modPiutangAsuransi = new BKPiutangasuransiT();

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

        $modTanggungan = new TanggunganpenjaminM();
        $penjamin_id = null;


        // var_dump($_POST); die;

        if (isset($_POST['pendaftaran_id']) && isset($_POST['orderBatal'])) {

            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {

                foreach ($_POST['orderBatal'] as $pembayaranpelayanan_id => $val) {
                    if (!isset($val['ceklis'])) {
                        continue;
                    }
                    $bayar = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
                    $det = new OrderbatalpembayaranpelayananT;
                    $det->attributes = $val;
                    $det->pembayaranpelayanan_id = $pembayaranpelayanan_id;

                    if ($det->isNewRecord) {
                        $det->create_time = date('Y-m-d H:i:s');
                        $det->create_login = Yii::app()->user->id;
                    }

                    $det->update_time = date('Y-m-d H:i:s');
                    $det->update_login = Yii::app()->user->id;
                    
                    // var_dump($det->attributes);
                    $ok = $ok && $det->save();

                    
                }

                // var_dump($ok); die;

                if ($ok) {

                    $trans->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    $this->redirect(array('index'));

                } else {

                    Yii::app()->user->setFlash('error', 'Data alokasi gagal dibatalkan !');
                    $trans->rollback();

                }

            } catch (Exception $exc) {
                $trans->rollback(); var_dump($exc->getMessage(), $exc->getTraceAsString()); die;
                Yii::app()->user->setFlash('error', "Data order batal bayar gagal disimpan " . $exc->getMessage());
            } 

        }


        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modKunjungan' => $modKunjungan,
            'dataTindakans' => $dataTindakans,
            'dataOas' => $dataOas,
        ));
    }

    public function actionInformasi() {
        $model = new BKInformasiorderbatalpembayaranV;
        $model->unsetAttributes();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['BKInformasiorderbatalpembayaranV'])) {
            $model->attributes = $_GET['BKInformasiorderbatalpembayaranV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['BKInformasiorderbatalpembayaranV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['BKInformasiorderbatalpembayaranV']['tgl_akhir']);
        }

        $this->render($this->path_view . "informasi/index", array(
            'model'=>$model,
        ));
    }

    public function actionVerifikasi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();

        try {
            $ok = true;
    
            $id = $_POST['orderbatalpembayaranpelayanan_id'];
            $order = OrderbatalpembayaranpelayananT::model()->findByPk($id);
            $bayar = PembayaranpelayananT::model()->findByPk($order->pembayaranpelayanan_id);
            $tindakan = TindakansudahbayarT::model()->findAllByAttributes(array(
                'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id
            ));
            $oa = OasudahbayarT::model()->findAllByAttributes(array(
                'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id
            ));

            $bayar->orderbatalpembayaranpelayanan_id = $id;
            $ok = $ok && $bayar->save(false, array('orderbatalpembayaranpelayanan_id'));

            foreach ($tindakan as $item) {
                $item->orderbatalpembayaranpelayanan_id = $id;
                $ok = $ok && $item->save(false, array('orderbatalpembayaranpelayanan_id'));
                
                $modTindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
                $modTindakan->tindakansudahbayar_id = null;
                $modTindakan->save(false, array('tindakansudahbayar_id'));
            }

            foreach ($oa as $item) {
                $item->orderbatalpembayaranpelayanan_id = $id;
                $ok = $ok && $item->save(false, array('orderbatalpembayaranpelayanan_id'));

                $modOa = ObatalkespasienT::model()->findByPk($item->obatalkespasien_id);
                $modOa->oasudahbayar_id = null;
                $modOa->save(false, array('oasudahbayar_id'));
            }

            // hapus pemakaian uang muka
            $uangmuka = PemakaianuangmukaT::model()->findAllByAttributes(array(
                'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id
            ));

            foreach ($uangmuka as $item) {
                $modUangMuka = BayaruangmukaT::model()->findByPk($item->bayaruangmuka_id);
                if (!empty($modUangMuka)) {
                    // $uangmuka->pembayaranpelayanan_id = null;
                    $modUangMuka->uangmukadipakai = $modUangMuka->uangmukadipakai - $item->pemakaianuangmuka;
                    $modUangMuka->pemakaianuangmuka_id = null;
                    $modUangMuka->save(false, array('uangmukadipakai', 'pemakaianuangmuka'));
                }
                $item->delete();
            }


            // var_dump($ok); die;

            if ($ok) {
                $trans->commit();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Order batal berhasil diverifikasi. ',
                ));
            } else {
                $trans->rollback();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Order batal gagal diverifikasi. ',
                ));
            }

            // var_dump($ok, $_POST); die;

        } catch (Exception $e) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Order batal gagal di-update. '.$e->getMessage(),
            ));
        }
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
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $notif = array('ok' => 1, 'msg' => '');
            $pesan = "";
            $ok = true;
            $criteria = new CDbCriteria();
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
            }
            if (!empty($pasienadmisi_id)) {
                $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
            }
            if (!empty($instalasi_id)) {
                $criteria->addCondition("instalasi_id = " . $instalasi_id);
            }
            $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));


            $returnVal['dpjp1'] = "";
            $returnVal['dpjp2'] = "";
            $returnVal['dpjp3'] = "";
            $returnVal['dokterpenerima'] = "";
            $returnVal['persen_diskon'] = '0';
            $returnVal['persen_admin'] = '0';
            $returnVal['nilai_admin'] = '0';

            $reseptur = ResepturT::model()->findAllByAttributes(array(
                'pendaftaran_id' => $pendaftaran_id,
            ), array(
                'condition' => 'penjualanresep_id is null',
            ));

            $konfig = KonfigsystemK::model()->find();

            // if ($instalasi_id == Params::INSTALASI_ID_RJ && $konfig->isonestopbilling) {
            if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = InfokunjunganrjV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                if (!empty($penjamin->diskon_tagihan)) {
                    $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                }

                if (!empty($penjamin->diskon_rj)) {
                    $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
                }
                $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");

            } else if ($instalasi_id == Params::INSTALASI_ID_MCU2) {
                $model = BKInformasikasirmcuV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

            } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
                $model = InformasikasirhemodialisaV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
                // $returnVal['persen_admin'] = number_format($penja    min->biaya_administrasi, 2, ",", "");
                // /*
                if ($model->status_hd != Params::STATUS_HD_SELESAI) {
                    if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $ok &= 9;
                        $pesan .= "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
                    } else {
                        $ok &= 0;
                        $pesan .= "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
                            . " di ${ruangan}";
                    }
                }

            } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $model = InfokunjunganrdV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                if ($instalasi_id == Params::INSTALASI_ID_RD) {
                    if (!empty($penjamin->diskon_tagihan)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                    }

                    if (!empty($penjamin->diskon_rd)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_rd, 2, ",", "");
                    }

                    $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
                }

            } else if (in_array($instalasi_id, Params::grupInstalasiRIID())) {

                $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pasienadmisi_id' => $pendaftaran->pasienadmisi_id,
                ));

                if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                    $model = BKInfokunjunganRIV::model()->find($criteria);
                } else {
                    $model = BKInfokunjunganRIV::model()->find($criteria);
                }



                $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
                $nama = $model->namadepan . $model->nama_pasien;
                $ruangan = $model->ruangan_nama;


                $penjamin = PenjaminpasienM::model()->findByPk($admisi->penjamin_id);

                if (!empty($admisi->dokterpenerima_id)) {
                    $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
                    $returnVal['dokterpenerima'] = $peg->namaLengkap;
                }

                if (!empty($admisi->pegawai_id)) {
                    $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
                    $returnVal['dpjp1'] = $peg->namaLengkap;
                }

                if (!empty($admisi->dpjp2_id)) {
                    $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
                    $returnVal['dpjp2'] = $peg->namaLengkap;
                }

                if (!empty($admisi->dpjp3_id)) {
                    $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
                    $returnVal['dpjp3'] = $peg->namaLengkap;
                }

                if (in_array($instalasi_id, Params::grupInstalasiRIID())) {
                    if (!empty($penjamin->diskon_tagihan)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                    }

                    if (!empty($penjamin->diskon_ri)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_ri, 2, ",", "");
                    }
                    $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
                }

                $returnVal['nilai_admin'] = 0;

                $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
                    'pendaftaran_id' => $model->pendaftaran_id,
                ), array(
                    'order' => 'verifikasitagihan_id desc',
                ));

                if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
                    $returnVal['persen_admin'] = "0,00";
                    $returnVal['nilai_admin'] = MyFormatter::formatNumberForPrint($verifikasi->biaya_administrasi);
                }

            } else if ($instalasi_id == Params::INSTALASI_ID_REHAB) {
                // $model = BKInformasikasirfisioterapiV::model()->find($criteria);

                // $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);
                $model = BKPembayarantagihanpenunjangV::model()->find($criteria);
                $modPendaftaran = BKPendaftaranT::model()->findByPk($model->pendaftaran_id);
                $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;
                $model->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $model->carabayar_id = $modPendaftaran->carabayar_id;
                $model->tanggal_lahir = $modPendaftaran->pasien->tanggal_lahir;
                $model->nama_pegawai = $modPendaftaran->pegawai->nama_pegawai;
                $model->penjamin_id = $penjamin->penjamin_id;

                $returnVal['alamat_pasien'] = $modPendaftaran->pasien->alamat_pasien;
                $returnVal['ruangan_id'] = $modPendaftaran->ruangan_id;
                $returnVal['pasien_id'] = $modPendaftaran->pasien_id;

            } else if ($instalasi_id == Params::INSTALASI_ID_LAB || $instalasi_id == Params::INSTALASI_ID_RAD) {
                // $criteria = new CDbCriteria();
                $model = new BKPasienmasukpenunjangV;
                $model->instalasi_id = $instalasi_id;
                $criteria = $model->criteriaGroupByPendaftaran();
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }
                if (!empty($pasienadmisi_id)) {
                    $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
                }
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran));
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik));
                $model = $model->find($criteria);
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal["$attribute"] = $model->$attribute;
                }
                $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
                $modPenunjangAkhir = $model->getPenunjangAkhir();
                $returnVal["ruangan_id"] = $modPenunjangAkhir->ruangan_id;
                $returnVal["ruangan_nama"] = $modPenunjangAkhir->ruangan_nama;

                $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
                $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);

                $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);


                //load uang muka
                $crit_uangmuka = new CDbCriteria();
                if (!empty($model->pendaftaran_id)) {
                    $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
                }
                if (!empty($model->pasienadmisi_id)) {
                    $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
                }
                $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                $returnVal["notif"] = $notif;
            }

            $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $returnVal['jumlah_tindakan'] = TindakanpelayananT::model()->countByAttributes(array(
                'pendaftaran_id' => $model->pendaftaran_id,
            ), array(
                'condition' => 'tindakansudahbayar_id is null',
            ));
            $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

            $attributes = $model->attributeNames();

            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }


            $returnVal['kelastanggungan_id'] = null;
            $returnVal['kelastanggungan_nama'] = null;

            $returnVal['kelastanggungan_nilai'] = null;
            $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);

            if (!empty($asuransi)) {
                $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
                $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
                $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
                if (!empty($asuransi->nopeserta)) {
                    $bpjs = new BpjsVklaim;
                    $dataPeserta = CJSON::decode($bpjs->search_kartu($asuransi->nopeserta));
                    if (!empty($dataPeserta['response'] && $dataPeserta['metaData']['code'] == 200)) {
                        // var_dump($dataPeserta);
                        $returnVal['kelas_hak_bpjs'] = $dataPeserta['response']['peserta']['hakKelas']['keterangan'];
                        $returnVal['kelas_hak_kode'] = $dataPeserta['response']['peserta']['hakKelas']['kode'];
                        $criteria_asuransi = new CDbCriteria();
                        $criteria_asuransi->compare('kelasbpjs_id', $returnVal['kelas_hak_kode']);
                        
                        // var_dump($returnVal['kelas_hak_bpjs'], $criteria_asuransi); die;
                        
                        
                        $kelas = KelaspelayananM::model()->find($criteria_asuransi);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                    } else {
                        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id) ?? 0;
                    }
                }
            }

            $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
            $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);


            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["notif"] = $notif;
            //load uang muka
            $crit_uangmuka = new CDbCriteria();
            if (!empty($model->pendaftaran_id)) {
                $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
            }
            if (!empty($model->pasienadmisi_id)) {
                $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
            }

            //perubahan pengambilan uang muka (RSN-1195)
            $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if (!empty($modBayarUangMuka)) {
                // $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('bayaruangmuka_id'=>$modBayarUangMuka->bayaruangmuka_id),array('order'=>'pemakaianuangmuka_id DESC','limit'=>1));
                // if (!empty($modPemakaianUangMuka)){
                //     $returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
                // }else{
                //     $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                //     $crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
                //     $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                //     $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                //     $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                // }
                if (!empty($modBayarUangMuka->pembatalanuangmuka_id) && empty($modBayarUangMuka->pembatalanuangmuka_id)) {
                    $returnVal["jumlahuangmuka"] = 0;
                } else if (empty($modBayarUangMuka->pembatalanuangmuka_id) && !empty($modBayarUangMuka->pemakaianuangmuka_id)) {
                    // $returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
                    $total = 0;
                    foreach ($modBayarUangMuka as $i) {
                        $total += $i->jumlahuangmuka - $i->uangmukadipakai;
                    }
                    $returnVal["jumlahuangmuka"] = $total;
                } else {
                    $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                    $crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
                    $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                    $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                    $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                }
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }


}