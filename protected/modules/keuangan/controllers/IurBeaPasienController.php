<?php

Yii::import("billingKasir.models.*");

class IurBeaPasienController extends MyAuthController
{
    public $path_view = "keuangan.views.iurBeaPasien.";

    public function actionIndex($id = null)
    {
        $model = new KUIurbeaT;
        $modKunjungan = new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RI;

        $model->inacbg_kelasperawatan = "0,00";
        $model->inacbg_kelastanggungan = "0,00";
        $model->totalinacbg_naikkelasperawatan = "0,00";


        if (!empty($id)) {
            $model = KUIurbeaT::model()->findByPk($id);
            $model->inacbg_kelasperawatan = MyFormatter::formatNumberForPrint($model->inacbg_kelasperawatan, 2);
            $model->inacbg_kelastanggungan = MyFormatter::formatNumberForPrint($model->inacbg_kelastanggungan, 2);
            $model->totalinacbg_naikkelasperawatan = MyFormatter::formatNumberForPrint($model->totalinacbg_naikkelasperawatan, 2);
        }

        if (isset($_GET['instalasi_id'])) {
            if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ) {
                $loadKunjungan = BKInformasikasirrawatjalanV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RD) {
                $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
            } else if (in_array($_GET['instalasi_id'], Params::grupInstalasiRIID())) {
                $pendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $pendaftaran->pasienadmisi_id,
                ));

                if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                    $loadKunjungan = BKInfokunjunganRIV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
                } else {
                    $loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $pendaftaran->pasienadmisi_id));
                }
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_MCU2) {
                $loadKunjungan = BKInformasikasirmcuV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_HD) {
                $loadKunjungan = BKInformasikasirhdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_PERSALINAN) {
                $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_REHAB) {
                $loadKunjungan = BKInformasikasirfisioterapiV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            }
            if (isset($loadKunjungan)) {
                $modKunjungan = $loadKunjungan;
            }
        }


        if (isset($_POST['KUIurbeaT'])) {
            $model->attributes = $_POST['KUIurbeaT'];
            $model->tgl_transaksiiurbiaya = date('Y-m-d H:i:s');
            $model->is_bataliurbea = false;
            $model->pendaftaran_id = $_POST['pendaftaran_id'] ?? null;
            $model->pasien_id = $_POST['pasien_id'] ?? null;
            $model->notransaksiiurbea = MyGenerator::noTransaksiIurBea();

            $model->inacbg_kelasperawatan = is_numeric($model->inacbg_kelasperawatan) ? $model->inacbg_kelasperawatan : MyFormatter::formatRupiahForDB($model->inacbg_kelasperawatan);
            $model->inacbg_kelastanggungan = is_numeric($model->inacbg_kelastanggungan) ? $model->inacbg_kelastanggungan : MyFormatter::formatRupiahForDB($model->inacbg_kelastanggungan);
            $model->totalinacbg_naikkelasperawatan = is_numeric($model->totalinacbg_naikkelasperawatan) ? $model->totalinacbg_naikkelasperawatan : MyFormatter::formatRupiahForDB($model->totalinacbg_naikkelasperawatan);
            
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');;
                $model->create_loginpemakai_id = Yii::app()->user->id;
            }

            // var_dump($model->attributes, $model->validate(), $model->errors, $_POST); die;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                $this->redirect(array('index', 'id' => $model->iurbea_id, 'pendaftaran_id' => $model->pendaftaran_id, 'instalasi_id' => $modKunjungan->instalasi_id, 'sukses' => 1));
            } else {
                Yii::app()->user->setFlash('error', 'Data gagal disimpan !');
                $this->redirect(array('index'));
            }

            // var_dump($model->attributes, $_POST); die;
        }

        $this->render($this->path_view."index", array(
            'model'=>$model,
            'modKunjungan'=>$modKunjungan,
        ));
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
                $model = BKInformasikasirrawatjalanV::model()->find($criteria);

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
                $model = BKInformasikasirrdpulangV::model()->find($criteria);

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
                    $model = BKInformasikasirinappulangV::model()->find($criteria);
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

            $returnVal['total_tagihan'] = $this->hitungTotalTagianPasien($model->pendaftaran_id);


            $returnVal['kelastanggungan_id'] = null;
            $returnVal['kelastanggungan_nama'] = null;

            $returnVal['kelastanggungan_nilai'] = null;
            $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);
            $returnVal['pasiennaikkelas'] = null;
            // cek naik kelas 

            if(!empty($asuransi) && !empty($pendaftaran->admisi)) {
                if($asuransi->kelastanggunganasuransi_id != $pendaftaran->admisi->kelaspelayanan_id) {
                    $returnVal['pasiennaikkelas'] = 1;
                }
            }
            if (!empty($asuransi)) {
                $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
                $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
                $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
                if (!empty($asuransi->nopeserta)) {
                    $bpjs = new BpjsVklaim;

                        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id) ?? 0;

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

            // cek iur biaya
            $returnVal['ada_iurbea'] = 0;
            $iur = IurbeaT::model()->findByAttributes(array(
                'pendaftaran_id'=>$returnVal['pendaftaran_id']
            ), array(
                'condition'=>"is_approvalbatal = false"
            ));

            $returnVal['ada_iurbea'] = !empty($iur) ? 1 : 0;

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

    function hitungTotalTagianPasien($pendaftaran_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);

        $total = 0;
        

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
            

            if ($tarifSubtota != $total_lunas) {
                $total += $tarifSubtota;
            }


            

        }

        return $total;


    }


    public function actionBatalIurBea() {
        $model = new KUIurbeaT;
        $modKunjungan = new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RI;

        $this->render($this->path_view."batal/index", array(
            'model'=>$model,
            'modKunjungan'=>$modKunjungan,
        ));

    }

    public function actionApproveBatalIurBea() {
        $model = new KUIurbeaT;
        $modKunjungan = new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RI;

        $this->render($this->path_view."batal/approval", array(
            'model'=>$model,
            'modKunjungan'=>$modKunjungan,
        ));

    }

    public function actionlistIurBea() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $list = KUIurbeaT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id
        ), array(
            'order'=>'tgl_transaksiiurbiaya desc',
        ));

        $html = "";
        foreach ($list as $idx => $item) {
            $html .= $this->renderPartial($this->path_view."batal/_rowList", array(
                'detail'=>$item,
                'pendaftaran'=>$pendaftaran,
                'idx'=>$idx,
            ), true);
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'html'=>$html,
        ));
    }

    public function actionlistIurBeaBatal() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $list = KUIurbeaT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id
        ), array(
            'condition'=>'is_bataliurbea = true',
            'order'=>'tgl_transaksiiurbiaya desc',
        ));

        $html = "";
        foreach ($list as $idx => $item) {
            $html .= $this->renderPartial($this->path_view."batal/_rowListBatal", array(
                'detail'=>$item,
                'pendaftaran'=>$pendaftaran,
                'idx'=>$idx,
            ), true);
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'html'=>$html,
        ));
    }

    public function actionBatalBea() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        try {
            $iurbea_id = $_POST['verifikasi']['iurbea_id'];
            $model = KUIurbeaT::model()->findByPk($iurbea_id);
    
            $model->alasanpembatalan = $_POST['verifikasi']['alasanpembatalan'];
            $model->tgl_bataltransaksiiurbea = date('Y-m-d H:i:s');
            $model->is_bataliurbea = true;
    
            $model->save(false, array('alasanpembatalan', 'tgl_bataltransaksiiurbea', 'is_bataliurbea'));

            echo CJSON::encode(array(
                'ok'=>1,
                'msg'=>"Iur Bea Pasien berhasil dibatalkan",
            ));

        } catch (Exception $e) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$e->getMessage()
            ));
        }

    }

    public function actionApproveBatalBea() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        try {
            $iurbea_id = $_POST['iurbea_id'];
            $model = KUIurbeaT::model()->findByPk($iurbea_id);
    
            $model->tgl_approvalbatal = date('Y-m-d H:i:s');
            $model->is_approvalbatal = true;
            $model->pegawai_approvalbatal_id = Yii::app()->user->getState('pegawai_id');
    
            $model->save(false, array('tgl_approvalbatal', 'is_approvalbatal', 'pegawai_approvalbatal_id'));

            echo CJSON::encode(array(
                'ok'=>1,
                'msg'=>"Batal Iur Bea Pasien berhasil di-approve",
            ));

        } catch (Exception $e) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$e->getMessage()
            ));
        }

    }

    public function actionPrintBea($id, $caraPrint = null) {
        $model = $model = KUIurbeaT::model()->findByPk($id);

        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $judulKuitansi = '----- IUR BEA -----';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
 


        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint) {

            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
                $this->render($this->path_view . 'printBea', array(
                    'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'model'=>$model,
                ));
                //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            } else if ($caraPrint == 'EXCEL') {
                $this->layout = '//layouts/printExcel';
                $this->render($this->path_view . 'printBea', array(
                    'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'model'=>$model,
                ));
            } else if ($caraPrint == 'PDF') {
                //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                //$mpdf = new MyPDF60('',$ukuranKertasPDF);
                //$mpdf = new MyPDF60('','B5-L');
                $mpdf = new MyPDF60('', '', '15', '', 15, 15, 16, 16, 9, 9, 'B5');
                //$mpdf->useOddEven = 2;
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet, 1);
                /*
                    * cara ambil margin
                    * tinggi_header * 72 / (72/25.4)
                    *  tinggi_header = inchi
                    */

                /*font-family: tahoma;*/
                // $header = 0.50 * 72 / (72/25.4);
                $header = 0.3 * 72 / (72 / 25.4);
                $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
                $mpdf->WriteHTML(
                    $this->renderPartial(
                        $this->path_view . 'printBea',
                        array(
                            'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'model'=>$model,
                        ),
                        true
                    )
                );
                $mpdf->Output();
            }
        } else {

            $this->render($this->path_view . 'printBea', array(
                'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'model'=>$model,
            ));
        }

    }
}