<?php

class DaftarPasienController extends MyAuthController
{
    /**
     * @return array action filters
     */
    public $successSave = false;
    public $successSavePA = true; //variabel untuk validasi data opsional (pasien anastesi) diisi ketika dokter anastesi not empty
    public $isAnastesi = false; //variabel untuk validasi data opsional (pasien anastesi) diisi ketika dokter anastesi not empty
    public $isAdaTarif = true;
    public $path_view = 'bedahSentral.views.daftarPasien.';
    public $pelaksanaoperasisimpan = true;
    public $simpan_timeout = true;
    public $simpan_timeoutdet = true;
    public $simpan_signout = true;
    public $simpan_signoutdet = true;

    //	FILTER DENGAN SRBAC
    //	public function filters()
    //	{
    //		return array(
    //			'accessControl', // perform access control for CRUD operations
    //		);
    //	}

    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
        $modPasienMasukPenunjang = new BSMasukPenunjangV;
        $format = new MyFormatter();
        $modPasienMasukPenunjang->tgl_awal = date("Y-m-d");
        $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
        $modPasienMasukPenunjang->tgl_awall = date('Y-m-d');
        $modPasienMasukPenunjang->tgl_akhirl = date('Y-m-d');
        $modPasienMasukPenunjang->ceklis = false;
        if (isset($_REQUEST['BSMasukPenunjangV'])) {
            // echo "<pre>";
            // var_dump($_REQUEST['BSMasukPenunjangV']);die;
            $modPasienMasukPenunjang->attributes = $_REQUEST['BSMasukPenunjangV'];
            $modPasienMasukPenunjang->ceklis = $_REQUEST['BSMasukPenunjangV']['ceklis'];
            $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_awal']);
            $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_akhir']);
            $modPasienMasukPenunjang->tgl_awall = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_awall']);
            $modPasienMasukPenunjang->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_akhirl']);
            $modPasienMasukPenunjang->statuspendaftaran = isset($_REQUEST['BSMasukPenunjangV']['statuspendaftaran']) ? $_REQUEST['BSMasukPenunjangV']['statuspendaftaran'] : null;
            //$modPasienMasukPenunjang->ceklis = $_REQUEST['BSMasukPenunjangV']['ceklis'];
        }
        $this->render('index', array(
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang
        ));
    }
    /**
     * menggunakan perhitungan baru berdasarkan typeanastesis_m
     * 20-Jan-2014
     * @param type $id
     */
    public function actionUpdateRencana($id)
    {

        $format = new MyFormatter();
        $this->pageTitle = Yii::app()->name . " - Operasi";
        $modRencanaOperasi = $this->loadAllByPasienMasukPenunjang($id);
        $modRencanaOperasiAttrib = $this->loadByPasienMasukPenunjang($id);
        // echo "<pre>"; echo count((array)$modRencanaOperasiAttrib);exit();
        //JANGAN KE VIEW KARENA SERING DATANYA TIDAK ADA
        $modPasienPenunjang = BSMasukPenunjangV::model()->findByAttributes(
            array('pasienmasukpenunjang_id' => $id)
        ); //data pasien penunjang

        $dokTerima = PendaftaranT::model()->findByPk($modPasienPenunjang->pendaftaran_id);
        $dpjp = PasienadmisiT::model()->findByAttributes(array('pasienadmisi_id' => $modPasienPenunjang->pasienadmisi_id));
        $tanggungan = AsuransipasienM::model()->findByPk($dokTerima->asuransipasien_id);

        $modPasienPenunjang->dokterpenerima_nama = (!empty($dpjp->dokpenerima->namaLengkap)) ? $dpjp->dokpenerima->namaLengkap : $dokTerima->pegawai->namaLengkap;
        $modPasienPenunjang->dpjp_nama =  (!empty($dpjp)) ? $dpjp->pegawai->namaLengkap : '';
        $modPasienPenunjang->kelastanggungan_nama = (!empty($tanggungan) ? $tanggungan->kelastanggunganasuransi->kelaspelayanan_nama : '');
        $modPasienPenunjang->kamarruangan_nokamar = !empty($dpjp) ? $dpjp->kamarruangan->kamarruangan_nokamar : '';
        $modPasienPenunjang->kamarruangan_nobed = !empty($dpjp) ? $dpjp->kamarruangan->kamarruangan_nobed : '';

        $modPenunjang = new BSMasukPenunjangV; //untuk mengenerate isi dropdownlist
        $modKegiatanOperasi = BSKegiatanOperasiM::model()->findAllByAttributes(
            array('kegiatanoperasi_aktif' => true),
            array('order' => 'kegiatanoperasi_nama')
        );
        $modOperasi = BSOperasiM::model()->findAllByAttributes(
            array('operasi_aktif' => true),
            array('order' => 'operasi_nama')
        );
        if (empty($modRencanaOperasiAttrib)) {
            $modAnastesi = new PasienanastesiT;
            $modRO = new BSRencanaOperasiT;
            $modRencanaOperasiAttrib = new BSRencanaOperasiT;
        } else {
            $modAnastesi = $this->loadAnastesi($modRencanaOperasiAttrib->pasienanastesi_id);
            $modAnastesi->pakeAnastesi = (!empty($modRencanaOperasiAttrib->dokteranastesi_id) ? true : false);
            $modAnastesi->dokteranastesi_id = (!empty($modRencanaOperasiAttrib->dokteranastesi_id) ? $modRencanaOperasiAttrib->dokteranastesi_id : '');
            $modAnastesi->perawatanastesi_id = $modRencanaOperasiAttrib->suster_id;
            $modRO = $modRencanaOperasiAttrib;
        }
        $modTindakanPelayanan = new BSTindakanPelayananT;
        $modTindakanKomponen = new BSTindakanKomponenT;


        $attrOperasi = '';
        $attrCeklis = '';

        if (isset($_POST['BSRencanaOperasiT'])) {
            /* Looping dari data grid */
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // if(isset($_POST['BSTindakanPelayananT']))
                $dataGrid = $_POST['BSTindakanPelayananT'];
                $is_succes = true;
                $msg_error = '';
                //set null pembayaran supaya muncul di informasi belum bayar
                PendaftaranT::model()->updateByPk(
                    $modPasienPenunjang->pendaftaran_id,
                    array('pembayaranpelayanan_id' => null)
                );
                $total_seluruh = 0;

                $jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modPasienPenunjang->penjamin_id))->jenistarif_id;
                foreach ($dataGrid as $i => $data) {
                    if (strlen($data['ceklis']) > 0) { //jika di ceklis

                        /* proses simpan / update rencana operasi*/
                        if (strlen(trim($dataGrid[$i]['rencanaoperasi_id'])) > 0) {
                            /* proses jika sudah ada rencana_opereasi_id = update data*/
                            $modRencana = $this->loadById($dataGrid[$i]['rencanaoperasi_id']);
                            $modRencana->update_time = date('Y-m-d H:i:s');
                            $modRencana->update_loginpemakai_id = Yii::app()->user->id;
                        } else {
                            $modRencana = new BSRencanaOperasiT();
                            $modRencana->create_time = date('Y-m-d H:i:s');
                            $modRencana->create_loginpemakai_id = Yii::app()->user->id;
                            $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            $modRencana->update_time = null;
                            $modRencana->update_loginpemakai_id = null;
                        }

                        $modRencana->attributes = $dataGrid[$i];
                        $modRencana->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                        $modRencana->pasienadmisi_id = $modPasienPenunjang->pasienadmisi_id;
                        $modRencana->golonganoperasi_id = empty($dataGrid[$i]['golonganoperasi_id']) ? NULL : $dataGrid[$i]['golonganoperasi_id'];
                        $modRencana->jenis_penyulit = empty($dataGrid[$i]['jenis_penyulit']) ? NULL : $dataGrid[$i]['jenis_penyulit'];
                        $modRencana->pendaftaran_id = empty($modPasienPenunjang->pendaftaran_id) ? NULL : $modPasienPenunjang->pendaftaran_id;
                        $modRencana->pasien_id = empty($modPasienPenunjang->pasien_id) ? NULL : $modPasienPenunjang->pasien_id;
                        $modRencana->norencanaoperasi = $_POST['BSRencanaOperasiT']['norencanaoperasi'];
                        $modRencana->tglrencanaoperasi = empty($_POST['BSRencanaOperasiT']['tglrencanaoperasi']) ? NULL : $format->formatDateTimeForDb($_POST['BSRencanaOperasiT']['tglrencanaoperasi']);
                        $modRencana->kamarruangan_id = empty($_POST['BSRencanaOperasiT']['kamarruangan_id']) ? NULL : $_POST['BSRencanaOperasiT']['kamarruangan_id'];
                        $modRencana->dokterpelaksana1_id = empty($_POST['BSRencanaOperasiT']['dokterpelaksana1_id']) ? NULL : $_POST['BSRencanaOperasiT']['dokterpelaksana1_id'];
                        $modRencana->dokterpelaksana2_id = empty($_POST['BSRencanaOperasiT']['dokterpelaksana2_id']) ? NULL : $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'];
                        $modRencana->paramedis_id = empty($_POST['BSRencanaOperasiT']['paramedis_id']) ? NULL : $_POST['BSRencanaOperasiT']['paramedis_id'];
                        $modRencana->bidan_id = empty($_POST['BSRencanaOperasiT']['bidan_id']) ? NULL : $_POST['BSRencanaOperasiT']['bidan_id'];
                        $modRencana->suster_id = empty($_POST['BSRencanaOperasiT']['suster_id']) ? NULL : $_POST['BSRencanaOperasiT']['suster_id'];
                        $modRencana->keterangan_rencana = $_POST['BSRencanaOperasiT']['keterangan_rencana'];
                        $modRencana->statusoperasi = 'MULAI';
                        $modRencana->is_operasibersama = ($dataGrid[$i]['is_operasibersama'] > 0) ? true : false;

                        if ($modRencana->validate()) {
                            $modRencana->save();

                            if (isset($_POST['BSPelaksanaoperasiT'])) {
                                foreach ($_POST['BSPelaksanaoperasiT'] as $iiii => $val) {
                                    if (empty($val['pelaksanaoperasi_id'])) {
                                        $modPelaksanaOp = new BSPelaksanaoperasiT();
                                        $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                                        $modPelaksanaOp->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
                                        $modPelaksanaOp->create_time = date('Y-m-d H:i:s');
                                        $modPelaksanaOp->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                        $modPelaksanaOp->create_ruangan = Yii::app()->user->getState('create_ruangan');

                                        $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                                    } else {
                                        $modPelaksanaOp = BSPelaksanaoperasiT::model()->findByPk($val['pelaksanaoperasi_id']);
                                        $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                                        $modPelaksanaOp->update_time = date('Y-m-d H:i:s');
                                        $modPelaksanaOp->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                                        $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                                    }
                                }
                            }

                            /* proses simpan tindakanpelayanan */
                            if (strlen(trim($dataGrid[$i]['tindakanpelayanan_id'])) > 0) {
                                /* proses jika sudah ada rencana_opereasi_id = update data*/
                                $modTindakanPelayanan = BSTindakanPelayananT::model()->findByPk($dataGrid[$i]['tindakanpelayanan_id']);
                            } else {
                                $modTindakanPelayanan = new BSTindakanPelayananT;
                            }

                            $modTindakanPelayanan->attributes = $dataGrid[$i];
                            $modTindakanPelayanan->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
                            $modTindakanPelayanan->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                            $modTindakanPelayanan->pasienadmisi_id = $modPasienPenunjang->pasienadmisi_id;
                            $modTindakanPelayanan->penjamin_id = $modPasienPenunjang->penjamin_id;
                            $modTindakanPelayanan->pasien_id = $modPasienPenunjang->pasien_id;
                            $modTindakanPelayanan->kelaspelayanan_id = $modPasienPenunjang->kelaspelayanan_id;
                            $modTindakanPelayanan->pendaftaran_id = $modPasienPenunjang->pendaftaran_id;
                            $modTindakanPelayanan->carabayar_id = $modPasienPenunjang->carabayar_id;
                            $modTindakanPelayanan->jeniskasuspenyakit_id = $modPasienPenunjang->jeniskasuspenyakit_id;
                            $modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
                            $modTindakanPelayanan->tipepaket_id = 1;
                            $modTindakanPelayanan->tgl_tindakan = $format->formatDateTimeForDb($dataGrid[$i]['mulaioperasi']);
                            $modTindakanPelayanan->satuantindakan = 'KALI';
                            //                                $modTindakanPelayanan->qty_tindakan = 1;
                            $modTindakanPelayanan->qty_tindakan = $dataGrid[$i]['qty_tindakan'];
                            $modTindakanPelayanan->discount_tindakan = 0;
                            $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
                            $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
                            $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
                            $modTindakanPelayanan->iurbiaya_tindakan = 0;
                            $modTindakanPelayanan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
                            $modTindakanPelayanan->instalasi_id = Yii::app()->user->getState('instalasi_id');
                            $modTindakanPelayanan->dokterpemeriksa1_id = $_POST['BSRencanaOperasiT']['dokterpelaksana1_id'];
                            $modTindakanPelayanan->dokterpemeriksa2_id = $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'];
                            $modTindakanPelayanan->perawat_id = isset($_POST['BSRencanaOperasiT']['paramedis_id']) ? $_POST['BSRencanaOperasiT']['paramedis_id'] : null;
                            $modTindakanPelayanan->bidan_id = $_POST['BSRencanaOperasiT']['bidan_id'];
                            $modTindakanPelayanan->perawat2_id = $_POST['BSRencanaOperasiT']['perawatsirkuler_id'];
                            $modTindakanPelayanan->suster_id = $_POST['BSRencanaOperasiT']['suster_id'];
                            //                                $modTindakanPelayanan->tarifcyto_tindakan = 0;
                            $modTindakanPelayanan->tarif_satuan = MyFormatter::formatRupiahForDB($dataGrid[$i]['tarif_satuan']);
                            //                                $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->tarif_satuan * $modTindakanPelayanan->qty_tindakan;
                            $modTindakanPelayanan->tarif_tindakan = MyFormatter::formatRupiahForDB($dataGrid[$i]['tarif_tindakan']);
                            $modTindakanPelayanan->tarifcyto_tindakan = (int) $modTindakanPelayanan->qty_tindakan * (int)$modTindakanPelayanan->tarif_satuan * (double) $dataGrid[$i]['persencyto_tind'] / 100;
                            $modTindakanPelayanan->cyto_tindakan = (($dataGrid[$i]['cyto_tindakan'] == TRUE) ? 1 : 0);

                            if (isset($_POST['pemakaianAlat'])) {
                                foreach ($_POST['pemakaianAlat'] as $item_alat) {
                                    if ($item_alat['daftartindakan_id'] == $modTindakanPelayanan->daftartindakan_id) {
                                        $modTindakanPelayanan->alatmedis_id = $item_alat['alatmedis_id'];
                                    }
                                }
                            }

                            if ($modTindakanPelayanan->validate()) {
                                if (isset($_POST['pakeAnastesi'])) {
                                    $modAnastesi->pakeAnastesi = true;
                                    $tipeAnastesi = empty($dataGrid[$i]['typeanastesi_id']) ? NULL : $dataGrid[$i]['typeanastesi_id'];
                                    $modAnastesi = $this->saveAnastesi($_POST['PasienanastesiT'], $modRencana, $tipeAnastesi);
                                }

                                if (isset($_POST['paketBmhp'])) {
                                    $modObatPasiens = $this->savePaketBmhp($modPasienPenunjang, $_POST['paketBmhp'], $modTindakanPelayanan);
                                }

                                if (isset($_POST['pemakaianBahan'])) {
                                    $modPemakainBahans = $this->savePemakaianBahan($modPasienPenunjang, $_POST['pemakaianBahan'], $modTindakanPelayanan);
                                }

                                if ($modTindakanPelayanan->save()) {
                                    $this->isAdaTarif = $modTindakanPelayanan->saveTindakanKomponen();
                                }

                                $total_jasa_medis = 0;
                                $total_jasa_paramedis = 0;
                                $total_jasa_bhp = 0;
                                $total_jasa_rs = 0;
                                $total_tarif_satuan = 0;
                                $total_lokal = 0;
                                $jasaDokterAnastesi = 0;

                                /* update tindakanpelayanan_id DI Rencana Operasi */
                                $updateRencanaOperasi = BSRencanaOperasiT::model()->findByPk($modRencana->rencanaoperasi_id);
                                $updateRencanaOperasi->tindakanpelayanan_id = $modTindakanPelayanan->tindakanpelayanan_id;
                                $updateRencanaOperasi->save();
                                /*update komponentarif_id = 6 (Total)*/
                                //                              ADA KOMPONEN YG GAK KE TOTAL >>  $total_tarif_satuan = $total_jasa_rs + $total_jasa_medis + $total_jasa_paramedis + $total_jasa_bhp;
                                $updateKomponenTotal = BSTindakanKomponenT::model()->findByAttributes(array('tindakanpelayanan_id' => $modTindakanPelayanan->tindakanpelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
                                if ($total_lokal > 0) {
                                    $total_tarif_satuan = $total_lokal; //replace
                                }
                                if (isset($updateKomponenTotal)) {
                                    $updateKomponenTotal->tarif_kompsatuan = $total_tarif_satuan;
                                    $updateKomponenTotal->tarif_tindakankomp = $updateKomponenTotal->tarif_kompsatuan * $modTindakanPelayanan->qty_tindakan;
                                    $updateKomponenTotal->save();
                                }
                            } else {
                                foreach ($modTindakanPelayanan->getErrors() as $key => $val) {
                                    $msg_error .= $key . ' => ' . implode( ',',$val) . '<br>';
                                }
                                $is_succes = false;
                            }
                        } else {
                            foreach ($modRencana->getErrors() as $key => $val) {
                                $msg_error .= $key . ' => ' . implode( ',',$val) . '<br>';
                            }
                            $is_succes = false;
                        }
                    } else {
                        /* proses hapus rencana */
                        $is_succes = true;
                        if (isset($dataGrid[$i]['rencanaoperasi_id'])) {
                            $updateRencana = $this->loadById($dataGrid[$i]['rencanaoperasi_id']);
                            $pasienanastesiId = $updateRencana->pasienanastesi_id;
                            $tindakanId = $updateRencana->tindakanpelayanan_id;
                            $updateRencana->tindakanpelayanan_id = null;
                            $updateRencana->pasienanastesi_id = null;
                            $updateRencana->save();
                            $deleteAnastesi = PasienanastesiT::model()->deleteByPk($pasienanastesiId);
                            if (!$deleteAnastesi) {
                                $is_succes = false;
                            }
                            $findTindakanPelayanan = BSTindakanPelayananT::model()->findByPk($tindakanId);
                            if ($findTindakanPelayanan) {
                                $deleteTarifKomponen = BSTindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $findTindakanPelayanan->tindakanpelayanan_id));
                                if ($deleteTarifKomponen) {
                                    $deleteTindakanPelayanan = BSTindakanPelayananT::model()->deleteByPk($findTindakanPelayanan->tindakanpelayanan_id);
                                } else {
                                    $is_succes = false;
                                }
                            }
                            $deleteRencana = BSRencanaOperasiT::model()->deleteByPk($updateRencana->rencanaoperasi_id);
                            if (!$deleteRencana) {
                                $is_succes = false;
                            }
                        }
                    }
                }

                $judul = 'Kegiatan Operasi mulai dilakukan.'; //.$modKunjungan->no_rekam_medik.' - '.$modKunjungan->nama_pasien;

                $isi = $modPasienPenunjang->no_pendaftaran . ' - ' . $modPasienPenunjang->no_rekam_medik . ' - ' . $modPasienPenunjang->nama_pasien;

                $ruangan = RuanganM::model()->findByPk($modPasienPenunjang->ruanganasal_id);

                $tujuan = array(
                    array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => !empty($ruangan->modul_id) ? $ruangan->modul_id : null),
                    array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState("ruangan_id"), 'modul_id' => Params::MODUL_ID_BEDAHSENTRAL),
                );

                $n_pendaftaran = PendaftaranT::model()->findByPk($modPasienPenunjang->pendaftaran_id);
                if (!empty($n_pendaftaran->pasienadmisi_id)) {
                    $n_admisi = PasienadmisiT::model()->findByPk($n_pendaftaran->pasienadmisi_id);

                    if (!empty($n_admisi) && $ruangan->ruangan_id != $n_admisi->ruangan_id) {
                        $ruangan_admisi = RuanganM::model()->findByPk($n_admisi->ruangan_id);
                        $tujuan[] = array('instalasi_id' => $ruangan_admisi->instalasi_id, 'ruangan_id' => $ruangan_admisi->ruangan_id, 'modul_id' => (!empty($ruangan_admisi->modul_id)) ? $ruangan_admisi->modul_id : Yii::app()->user->getState('modul_id'));
                    }
                }

                CustomFunction::broadcastNotif($judul, $isi, $tujuan);

                if ($is_succes && ($this->isAdaTarif)) {
                    $transaction->commit();

                    $this->redirect(array('updateRencana', 'id' => $modPasienPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br>" . $msg_error);
                }
            } catch (Exception $exc) {
//                print_r($exc->getMessage()); die;
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }
        $modViewBahan = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(
            array(
                'pendaftaran_id' => $modPasienPenunjang->pendaftaran_id,
                'oa' => 'OA',
                'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            )
        );
        $modViewBmhp = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(
            array(
                'pendaftaran_id' => $modPasienPenunjang->pendaftaran_id,
                'oa' => 'OA',
                'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            )
        );

        $this->render(
            'updateRencanaOperasi',
            array(
                'modRencanaOperasi' => $modRencanaOperasi,
                'modRencanaOperasiAttrib' => $modRencanaOperasiAttrib,
                'modPenunjang' => $modPenunjang,
                'modPasienPenunjang' => $modPasienPenunjang,
                'modKegiatanOperasi' => $modKegiatanOperasi,
                'modOperasi' => $modOperasi,
                'modAnastesi' => $modAnastesi,
                'modRO' => $modRO,
                'modTindakanPelayanan' => $modTindakanPelayanan,
                'modTindakanKomponen' => $modTindakanKomponen,
                'modViewBahan' => $modViewBahan,
                'modViewBmhp' => $modViewBmhp,
                'format' => $format
            )
        );
    }

    public function saveTindakanPelayanT($attrPenunjang, $attrRencanaOperasi, $attrTindakanPelayanan, $attrOperasi)
    {
        $validTindakanPelayanan = 'true';
        $arrSave = array();

        $daftar_tindakan = $attrTindakanPelayanan['daftartindakan_id'][$attrOperasi];

        $kelaspelayanan_id = $attrTindakanPelayanan['kelaspelayanan_id'][$attrOperasi];

        $tarifTotal = 0;

        $tarifRS = 0;

        $tarifBHP = 0;

        $tarifParamedis = 0;

        $tarifMedis = 0;

        $modTindakanPelayanan = new BSTindakanPelayananT;
        $modTindakanPelayanan->rencanaoperasi_id = $attrRencanaOperasi->rencanaoperasi_id;
        $modTindakanPelayanan->penjamin_id = $attrPenunjang->penjamin_id;
        $modTindakanPelayanan->pasien_id = $attrPenunjang->pasien_id;
        $modTindakanPelayanan->kelaspelayanan_id = $kelaspelayanan_id;
        $modTindakanPelayanan->tipepaket_id = 1;
        $modTindakanPelayanan->instalasi_id = Params::INSTALASI_ID_IBS;
        $modTindakanPelayanan->pendaftaran_id = $attrPenunjang->pendaftaran_id;
        $modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakanPelayanan->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
        $modTindakanPelayanan->daftartindakan_id = $daftar_tindakan;
        $modTindakanPelayanan->carabayar_id = $attrPenunjang->carabayar_id;
        $modTindakanPelayanan->jeniskasuspenyakit_id = $attrPenunjang->jeniskasuspenyakit_id;
        $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
        $modTindakanPelayanan->qty_tindakan = $attrTindakanPelayanan['qty_tindakan'][$attrOperasi];
        $modTindakanPelayanan->tarif_tindakan = $attrTindakanPelayanan['tarif_tindakan'][$attrOperasi] * $modTindakanPelayanan->qty_tindakan;
        $modTindakanPelayanan->tarif_satuan = $modTindakanPelayanan->tarif_satuan;
        $modTindakanPelayanan->tarif_rsakomodasi = (!empty($tarifRS)) ? $tarifRS->harga_tariftindakan : 0;
        $modTindakanPelayanan->tarif_medis = (!empty($tarifMedis)) ? $tarifMedis->harga_tariftindakan : 0;
        $modTindakanPelayanan->tarif_paramedis = (!empty($tarifParamedis)) ? $tarifParamedis->harga_tariftindakan : 0;
        $modTindakanPelayanan->tarif_bhp = (!empty($tarifBHP)) ? $tarifBHP->harga_tariftindakan : 0;
        $modTindakanPelayanan->satuantindakan = $attrTindakanPelayanan['satuantindakan'][$attrOperasi];
        $modTindakanPelayanan->cyto_tindakan = $attrTindakanPelayanan['cyto_tindakan'][$attrOperasi];

        if ($modTindakanPelayanan->cyto_tindakan) {
            $modTindakanPelayanan->tarifcyto_tindakan = $modTindakanPelayanan->tarif_tindakan * ($attrTindakanPelayanan['persencyto_tind'][$attrOperasi] / 100);
        } else {
            $modTindakanPelayanan->tarifcyto_tindakan = 0;
        }

        $modTindakanPelayanan->discount_tindakan = 0;
        $modTindakanPelayanan->dokterpemeriksa1_id = $attrRencanaOperasi->dokterpelaksana1_id;
        $modTindakanPelayanan->dokterpemeriksa2_id = (!empty($attrRencanaOperasi->dokterpelaksana2_id)) ? $attrRencanaOperasi->dokterpelaksana2_id : null;
        $modTindakanPelayanan->dokteranastesi_id = (!empty($attrRencanaOperasi->dokteranastesi_id)) ? $attrRencanaOperasi->dokteranastesi_id : null;
        $modTindakanPelayanan->dokterdelegasi_id = (!empty($attrRencanaOperasi->dokterdelegasi_id)) ? $attrRencanaOperasi->dokterdelegasi_id : null;
        $modTindakanPelayanan->perawat_id = (!empty($attrRencanaOperasi->perawat_id)) ? $attrRencanaOperasi->perawat_id : null;
        $modTindakanPelayanan->bidan_id = (!empty($attrRencanaOperasi->bidan_id)) ? $attrRencanaOperasi->bidan_id : null;
        $modTindakanPelayanan->suster_id = (!empty($attrRencanaOperasi->bidan_id)) ? $attrRencanaOperasi->suster_id : null;
        $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
        $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
        $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
        $modTindakanPelayanan->iurbiaya_tindakan = 0;
        $modTindakanPelayanan->ruangan_id =  Yii::app()->user->getState('ruangan_id');

        if ($modTindakanPelayanan->validate()) {
            $arrSave[$i] = $modTindakanPelayanan; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave

        } else {
            $validTindakanPelayanan = 'false';
        }
        if ($validTindakanPelayanan == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
        {
            foreach ($arrSave as $x => $simpan) {
                if ($simpan->save()) {
                    $simpan->saveTindakanKomponen();
                }
                $this->upadateRencanaOperasi($simpan);
            }
            $this->successSave = true;
        } else {
            $this->successSave = false;
        }

        return $modTindakanPelayanan;
    }

    //        RND-6260
    //        public function saveTindakanKomponenT($attrTindakanPelayanan)
    //        {
    //            $arrSave = array();
    //            $validTindakanKomponen = 'true';
    //            $daftarTindakan_id = $attrTindakanPelayanan->daftartindakan_id;
    //            $kelaspelayanan_id = $attrTindakanPelayanan->kelaspelayanan_id;
    //            
    //            $arrTarifTindakan = "
    //                select * 
    //                from tariftindakan_m 
    //                where daftartindakan_id = ".$daftarTindakan_id." and 
    //                kelaspelayanan_id = ".$kelaspelayanan_id." and 
    //                komponentarif_id <> ".Params::KOMPONENTARIF_ID_TOTAL."
    //            ";
    //            $query = Yii::app()->db->createCommand($arrTarifTindakan)->queryAll();
    //            foreach ($query as $i => $tarifKomponen) {
    //                $modTarifKomponen = new BSTindakanKomponenT;
    //                $modTarifKomponen->tindakanpelayanan_id = $attrTindakanPelayanan->tindakanpelayanan_id;
    //                $modTarifKomponen->komponentarif_id = $tarifKomponen['komponentarif_id'];
    //                $modTarifKomponen->tarif_tindakankomp = $tarifKomponen['harga_tariftindakan'] * $attrTindakanPelayanan->qty_tindakan;
    //                $modTarifKomponen->tarif_kompsatuan = $modTarifKomponen->tarif_tindakankomp;
    //                if($attrTindakanPelayanan->cyto_tindakan){
    //                    $modTarifKomponen->tarifcyto_tindakankomp = $tarifKomponen['harga_tariftindakan'] * ($tarifKomponen['persencyto_tind']/100);
    //                } else {
    //                    $modTarifKomponen->tarifcyto_tindakankomp = 0;
    //                }
    //                $modTarifKomponen->subsidiasuransikomp = 0;
    //                $modTarifKomponen->subsidipemerintahkomp = 0;
    //                $modTarifKomponen->subsidirumahsakitkomp = 0;
    //                $modTarifKomponen->iurbiayakomp = 0;
    //                if ($modTarifKomponen->validate()){
    //                    $arrSave[$i] = $modTarifKomponen; // menyimpan objek tarif komponen ke dalam sebuah array dan siap untuk disave
    //
    //                }else
    //                {
    //                    $validTindakanKomponen = 'false';
    //                }
    //            } // ending foreach
    //            if($validTindakanKomponen == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
    //            {
    //                foreach ($arrSave as $f => $simpan) {
    //                    $simpan->save();
    //                }
    //                $this->successSave = true;
    //            }
    //            else
    //            {
    //                $this->successSave = false;
    //            }
    //            return $modTarifKomponen;
    //        }

    public function saveRencanaOperasi(
        $attrPenunjang,
        $attrRencana,
        $attrOperasi,
        $attrCeklis,
        $attrTindakanPelayanan,
        $attrTambahan,
        $modAnastesi
    ) {
        $format = new MyFormatter;
        $arrSave = array();
        $validRencana = 'true';
        $arrOperasi = array(); // array untuk menampung operasi yg nantinnya digunakan pada proses saveTindakanPelayanan
        for ($i = 0; $i < count((array)$attrCeklis); $i++) {
            $patokan = $attrCeklis[$i];
            $modRencana = $this->loadById($attrTambahan['rencanaoperasi_id'][$patokan]);
            $modRencana->attributes = $attrRencana->attributes;

            $modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null;
            $modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null;
            $modRencana->perawat_id = (!empty($modRencana->perawat_id)) ? $modRencana->perawat_id : null;
            $modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null;
            $modRencana->dokterdelegasi_id = (!empty($modRencana->dokterdelegasi_id)) ? $modRencana->dokterdelegasi_id : null;
            $modRencana->bidan_id = (!empty($modRencana->bidan_id)) ? $modRencana->bidan_id : null;
            $modRencana->suster_id = (!empty($modRencana->suster_id)) ? $modRencana->suster_id : null;

            $modRencana->selesaioperasi = $format->formatDateTimeForDb($attrTambahan['selesaioperasi'][$patokan]);
            $modRencana->mulaioperasi = $format->formatDateTimeForDb($attrTambahan['mulaioperasi'][$patokan]);
            $modRencana->golonganoperasi_id = (!empty($attrTambahan['golonganoperasi_id'][$patokan])) ? $attrTambahan['golonganoperasi_id'][$patokan] : null;

            $modRencana->statusoperasi = $attrTambahan['statusoperasi'][$patokan];

            $modRencana->operasi_id = $attrOperasi[$patokan];

            $arrOperasi[$i] = array(
                'operasi' => $attrOperasi[$patokan]
            );

            $modRencana->update_time = date('Y-m-d H:i:s');
            $modRencana->update_loginpemakai_id = Yii::app()->user->id;

            if ($modRencana->validate()) {
                $arrSave[$i] = $modRencana; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave
                $validRencana = 'true'; // variabel untuk menentukan rencana operasi valid

            } else {
                $modRencana->tglrencanaoperasi = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($modRencana->tglrencanaoperasi, 'yyyy-MM-dd'),
                    'medium',
                    null
                );

                $validRencana = $validRencana . 'false';
            }
        } //ENDING FOR 
        if ($validRencana == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
        {
            foreach ($arrOperasi as $x => $hasilOperasi) {
                $operasiNya[$x] = $hasilOperasi['operasi'];
            }
            foreach ($arrSave as $f => $simpan) {
                $simpan->save();
                $this->saveTindakanPelayanT($attrPenunjang, $simpan, $attrTindakanPelayanan, $operasiNya[$f]);

                if ($this->isAnastesi) {
                    $modAnastesi = $this->saveAnastesi($modAnastesi, $simpan);
                }

                $this->successSave = true;
            }
        } else {
            $this->successSave = false;
        }
        return $modRencana;
    }

    public function saveAnastesi($attrAnastesi, $modRencana, $tipeAnastesi = null)
    {
        $arrSave = array();
        $validAnastesi = 'true';
        //            $modUpdateRencana = $this->loadAllByPasienMasukPenunjang($modRencana->pasienmasukpenunjang_id);
        $attributes = array(
            'pendaftaran_id' => $modRencana->pendaftaran_id,
            'rencanaoperasi_id' => $modRencana->rencanaoperasi_id
        );
        $is_empty = PasienanastesiT::model()->findByAttributes($attributes);
        if (!$is_empty) {
            $modAnastesi = new PasienanastesiT;
        } else {
            $modAnastesi = $is_empty;
        }
        $modAnastesi->attributes = $attrAnastesi;
        $modAnastesi->jenisanastesi_id = (!empty($attrAnastesi['jenisanastesi_id'])) ? $attrAnastesi['jenisanastesi_id'] : null;
        $modAnastesi->anastesi_id = (!empty($attrAnastesi['anastesi_id'])) ? $attrAnastesi['anastesi_id'] : null;
        //          UNTUK TIPE GUNAKAN YANG DI TABEL DETAIL OPERASI >>  $modAnastesi->typeanastesi_id = (!empty($attrAnastesi['typeanastesi_id'])) ? $attrAnastesi['typeanastesi_id'] : null;
        $modAnastesi->typeanastesi_id = $tipeAnastesi;
        $modAnastesi->perawatanastesi_id = (!empty($attrAnastesi['perawatanastesi_id'])) ? $attrAnastesi['perawatanastesi_id'] : null;
        $modAnastesi->pendaftaran_id = $modRencana->pendaftaran_id;
        $modAnastesi->pasien_id = $modRencana->pasien_id;
        $modAnastesi->pasienmasukpenunjang_id = $modRencana->pasienmasukpenunjang_id;
        $modAnastesi->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
        $modAnastesi->tglanastesi = date('Y-m-d h:i:s');
        $modAnastesi->create_time = date('Y-m-d H:i:s');
        $modAnastesi->create_loginpemakai_id = Yii::app()->user->id;
        $modAnastesi->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modAnastesi->validate()) {
            $modAnastesi->save();
            $updateRencana = $this->loadById($modRencana->rencanaoperasi_id);
            $updateRencana->pasienanastesi_id = $modAnastesi->pasienanastesi_id;
            $updateRencana->dokteranastesi_id = $modAnastesi->dokteranastesi_id;
            $updateRencana->save();

            /*
                foreach ($modUpdateRencana as $rencana)
                {
                    $updateRencana = $this->loadById($rencana->rencanaoperasi_id); //update pasienanastesi_id ke rencanaoperasi_t
                    $updateRencana->pasienanastesi_id = $modAnastesi->pasienanastesi_id;
                    $updateRencana->save();
                }
                 * 
                 */

            if ($modAnastesi->save() && $updateRencana->save()) {
                $this->successSavePA = true;
            } else {
                $this->successSavePA = false;
            }
        } else {
            $this->successSavePA = false;
        }
        return $modAnastesi;
    }

    /**
     * Fungsi untuk mengembalikan object $model dengan method findAllByAttributes yang nanti digunakan untuk mendeskripsikan operasi_id
     * @param type $id
     * @return type 
     */
    public function loadAllByPasienMasukPenunjang($id)
    {
        $model = BSRencanaOperasiT::model()->findAllByAttributes(
            array(
                'pasienmasukpenunjang_id' => $id
            )
        );

        return $model;
    }
    /**
     * Fungsi untuk mengembalikan object $model dengan method findByAttributes yang nanti digunakan untuk mendeskripsikan data-data rencanaOperasiT
     * @param type $id
     * @return type 
     */
    public function loadByPasienMasukPenunjang($id)
    {
        $model = BSRencanaOperasiT::model()->findByAttributes(
            array(
                'pasienmasukpenunjang_id' => $id
            )
        );
        return $model;
    }
    /**
     * Fungsi untuk mengembalikan object $model dengan method findByPk yang nanti digunakan untuk menyimpan data-data rencanaOperasiT
     * @param type $id
     * @return type 
     */
    public function loadById($id)
    {
        $model = BSRencanaOperasiT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
         * Fungsi untuk mengembalikan object pasienanastesiT yg dicari berdasarkan rencanaoperasi_id
         */
    public function loadAnastesi($id)
    {
        $model = PasienanastesiT::model()->findByPk($id);
        if (!empty($model)) {
            return $model;
        } else {
            return new PasienanastesiT;
        }
    }

    /**
     * Fungsi untuk mengupadte rencana operasi menset tindakanpelayanan id
     * @param type $modTindPelayanan model object
     */
    protected function upadateRencanaOperasi($modTindPelayanan)
    {
        $modRencana = $this->loadById($modTindPelayanan->rencanaoperasi_id);
        $modRencana->tindakanpelayanan_id = $modTindPelayanan->tindakanpelayanan_id;
        $modRencana->save();
    }

    public function actionGetDataOperasi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id_operasi = $_POST['idOperasi'];
            $is_operasi = $_POST['is_operasi'];
            $is_operasibersama = $_POST['is_operasibersama'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];

            $criteria = new CDbCriteria;
            if (!empty($id_operasi)) {
                $criteria->addCondition('operasi_id = ' . $id_operasi);
            }
            $criteria->with = array('kegiatanoperasi');
            $data = new CActiveDataProvider(
                'BSOperasiM',
                array(
                    'criteria' => $criteria,
                )
            );

            $rec = array();
            foreach ($data->getData() as $idx => $val) {
                $rec['nama_operasi'] = $val['kegiatanoperasi']['kegiatanoperasi_nama'] . ' - ' . $val['operasi_nama'];
                $rec['label'] = $val['operasi_nama'];
                $rec['daftartindakan_id'] = $val['daftartindakan_id'];
                $rec['tarif_tindakan'] = 0;
                $rec['tarifcyto_tindakan'] = 0;

                $criteria = new CDbCriteria();
                $criteria->addCondition("daftartindakan_id = " . $val['daftartindakan_id']);
                $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
                $criteria->addCondition("komponentarif_id = " . Params::KOMPONENTARIF_ID_TOTAL);
                $record = TariftindakanM::model()->findAll($criteria);


                foreach ($record as $idx => $values) {
                    if ($values['komponentarif_id'] == Params::KOMPONENTARIF_ID_TOTAL) {
                        $rec['tarif_tindakan'] = $values['harga_tariftindakan'];
                        $rec['tarif_satuan'] = $values['harga_tariftindakan'];
                    }
                    //                    PERHITUNGAN TARIF CYTO DINONAKTIFKAN KARENA DIBUAT TINDAKAN YANG BERBEDA
                    $rec['tarifcyto_tindakan'] = 0;
                }

                foreach ($val as $key => $value) {
                    $rec[$key] = $value;
                }
            }
            $rec['is_operasi'] = $is_operasi;
            $tindakanPelayananT = new BSTindakanPelayananT;
            $tindakanPelayananT->attributes = $rec;

            $rencanaOperasi = new BSRencanaOperasiT;
            $rencanaOperasi->attributes = $rec;
            $rencanaOperasi->statusoperasi = 'MULAI';
            $rencanaOperasi->mulaioperasi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date("Y-m-d H:i:s"), 'yyyy-MM-dd hh:mm:ss', 'medium', null));
            $rencanaOperasi->selesaioperasi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date("Y-m-d H:i:s"), 'yyyy-MM-dd hh:mm:ss', 'medium', null));
            $rencanaOperasi->is_operasibersama = $is_operasibersama;

            $form = $this->renderPartial(
                '_gridRencanaOperasi',
                array(
                    'data' => $rec,
                    'tindakanPelayananT' => $tindakanPelayananT,
                    'rencanaOperasi' => $rencanaOperasi,
                ),
                true
            );

            $return = array(
                'success' => true,
                'item' => $rec['daftartindakan_id'],
                'label' => $rec['nama_operasi'],
                'rec' => $form
            );
            echo json_encode($return);
            Yii::app()->end();
        }
    }

    protected function savePemakaianBahan($modPendaftaran, $pemakaianBahan, $tindakan)
    {
        $valid = true;
        foreach ($pemakaianBahan as $i => $bmhp) {
            if ($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']) {
                $modPakaiBahan[$i] = new ObatalkespasienT();
                $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                if (!empty($modPendaftaran->pasienadmisi_id)) {
                    $modPakaiBahan[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                }
                $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
                $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
                $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
                $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
                $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modPakaiBahan[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                $modPakaiBahan[$i]->tipepaket_id = $tindakan->tipepaket_id;
                $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
                $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
                $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
                $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
                $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
                $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
                $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
                $modPakaiBahan[$i]->hargajual_oa = $modPakaiBahan[$i]->hargasatuan_oa * $modPakaiBahan[$i]->qty_oa; //$bmhp['subtotal'];
                $modPakaiBahan[$i]->oa = Params::OBATALKESPASIEN_BMHP;
                $valid = $modPakaiBahan[$i]->validate() && $valid;
                if ($valid) {
                    $modPakaiBahan[$i]->save();
                    $this->simpanStokKeluar($modPakaiBahan[$i]);
                    /*
                        StokObatAlkesT::kurangiStok(
                            $modPakaiBahan[$i]->qty_oa,
                            $modPakaiBahan[$i]->obatalkes_id
                        );
                         * 
                         */
                }
            }
        }
    }

    function simpanStokKeluar($modPemakaianBahan)
    {
        $format = new MyFormatter;
        //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $oa = ObatalkesM::model()->findByPk($modPemakaianBahan->obatalkes_id);
        //var_dump($oa->attributes);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->attributes = $modPemakaianBahan->attributes; //duplicate
        //$modStokOaNew->unsetIdTransaksi();
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = ceil($modPemakaianBahan->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokOaNew->obatalkespasien_id = $modPemakaianBahan->obatalkespasien_id;
        //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

        //$modStokOaNew->validate();
        //var_dump($modStokOaNew->errors); 


        if ($modStokOaNew->validate()) {
            $modStokOaNew->save();
            // $modStokOaNew->setStokOaAktifBerdasarkanStok();
        }

        // var_dump($this->stokobatalkestersimpan);

        return $modStokOaNew;
    }

    protected function savePaketBmhp($modPendaftaran, $paketBmhp, $tindakan)
    {
        $valid = true;
        $totalBmhp = 0;
        foreach ($paketBmhp as $i => $bmhp) {
            if ($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']) {
                $modObatPasien[$i] = new RJObatalkesPasienT;
                $modObatPasien[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modObatPasien[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                $modObatPasien[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                if (!empty($modPendaftaran->pasienadmisi_id)) {
                    $modObatPasien[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                }
                $modObatPasien[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
                $modObatPasien[$i]->sumberdana_id = $bmhp['sumberdana_id'];
                $modObatPasien[$i]->pasien_id = $modPendaftaran->pasien_id;
                $modObatPasien[$i]->satuankecil_id = $bmhp['satuankecil_id'];
                $modObatPasien[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modObatPasien[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                $modObatPasien[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                $modObatPasien[$i]->obatalkes_id = $bmhp['obatalkes_id'];
                $modObatPasien[$i]->pegawai_id = $modPendaftaran->pegawai_id;
                $modObatPasien[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modObatPasien[$i]->shift_id = Yii::app()->user->getState('shift_id');
                $modObatPasien[$i]->tglpelayanan = date('Y-m-d H:i:s');
                $modObatPasien[$i]->qty_oa = $bmhp['qtypemakaian'];
                $modObatPasien[$i]->harganetto_oa = $bmhp['harganetto'];
                $modObatPasien[$i]->hargasatuan_oa = $bmhp['hargapemakaian'];
                $modObatPasien[$i]->hargajual_oa = $modObatPasien[$i]->hargasatuan_oa * $modObatPasien[$i]->qty_oa; //$bmhp['hargapemakaian'];
                $totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];
                $valid = $modObatPasien[$i]->validate() && $valid;
                if ($valid) {
                    $modObatPasien[$i]->save();
                    //                        StokObatAlkesT::kurangiStok($modObatPasien[$i]->qty_oa, $modObatPasien[$i]->obatalkes_id);
                }
            }
        }

        $totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
        $tindakan->tarif_bhp = $totalBmhp;
        $tindakan->update();
        return $modObatPasien;
    }
    /**
     * membatalkan pemeriksaan penunjang IBS
     */
    public function actionBatalPeriksa()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $transaction = Yii::app()->db->beginTransaction();
            $pesan = 'success';
            $status = 'ok';

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
            $smspasien = 1;
            $nama_pasien = '';

            try {
                $idPenunjang = $_POST['idPenunjang'];
                $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
                if ($idPenunjang) {
                    $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
                    $modPendaftaran = PendaftaranT::model()->findByPk($pasienMasukPenunjang->pendaftaran_id);
                    if ($modPendaftaran->pembayaranpelayanan_id) { // sudah lunas semua
                        $status = 'not';
                        $pesan = 'exist';
                        $keterangan = "<div class='flash-success'>Pasien <b> " . $pasienMasukPenunjang->pendaftaran->pasien->nama_pasien . " 
                                                </b> sudah melakukan pembayaran pemeriksaan </div>";
                    } else {
                        $criteria = new CdbCriteria;
                        $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                        $criteria->addCondition('tindakansudahbayar_id > 0');
                        $tindakan = TindakanpelayananT::model()->findAll($criteria);
                        if (count((array)$tindakan) > 0) {
                            $status = 'not';
                            $pesan = 'exist';
                            $keterangan = "<div class='flash-success'>Pasien <b> " . $pasienMasukPenunjang->pendaftaran->pasien->nama_pasien . " 
                                                    </b> sudah melakukan pembayaran pemeriksaan </div>";
                        } else {
                            //$ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
                            //  'pasienmasukpenunjang_id' => $idPenunjang,
                            //));


                            $model = new PasienbatalperiksaR();
                            $model->pendaftaran_id = $pasienMasukPenunjang->pendaftaran_id;
                            $model->pasien_id = $pasienMasukPenunjang->pasien_id;
                            $model->pasienmasukpenunjang_id = $pasienMasukPenunjang->pasienmasukpenunjang_id;
                            $model->pasienkirimkeunitlain_id = $pasienMasukPenunjang->pasienkirimkeunitlain_id;
                            $model->tglbatal = date('Y-m-d');
                            $model->keterangan_batal = $keterangan_batal;
                            $model->create_time = date('Y-m-d H:i:s');
                            $model->update_time = null;
                            $model->create_loginpemakai_id = Yii::app()->user->id;
                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            if ($model->save()) {
                                $status = 'ok';
                                $pesan = 'exist';
                                $keterangan = "<div class='flash-success'>Pemeriksaan Berhasil dibatalkan ! </div>";
                            }
                        }
                    }
                }

                /*
                     * kondisi_commit
                     */
                if ($status == 'ok') {
                    // SMS GATEWAY
                    $sms = new Sms();
                    $modPasien = PasienM::model()->findByPk($model->pasien_id);
                    $nama_pasien = $modPasien->nama_pasien;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }

                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                            if (!empty($modPasien->no_mobile_pasien)) {
                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                            } else {
                                $smspasien = 0;
                            }
                        }
                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                } else {
                    $transaction->rollback();
                }
            } catch (Exception $ex) {
                print_r($ex);
                $status = 'not';
                $transaction->rollback();
            }

            $data['pesan'] = $pesan;
            $data['status'] = $status;
            $data['keterangan'] = $keterangan;
            $data['smspasien'] = $smspasien;
            $data['nama_pasien'] = $nama_pasien;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
            $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            if (isset($pasienMasukPenunjang)) {
                if ($pasienMasukPenunjang->panggilantrian == true) {
                    if ($keterangan == "batal") {
                        $pasienMasukPenunjang->panggilantrian = false;
                        if ($pasienMasukPenunjang->update()) {
                            $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
                        }
                    } else {
                        $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " sudah dipanggil sebelumnya !";
                    }
                } else {
                    $pasienMasukPenunjang->panggilantrian = true;
                    if ($pasienMasukPenunjang->update()) {
                        $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
                        // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
                        //              AKAN DIGANTI MENGGUNAKAN NODE JS
                        // self::postTelnet($data_telnet);
                    }
                }
            }

            $attributes = $pasienMasukPenunjang->attributeNames();
            foreach ($attributes as $i => $attribute) {
                $data["$attribute"] = $pasienMasukPenunjang->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionGetAntrianTerakhir()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $data['pesan'] = "";
            $criteria = new CDbCriteria;
            $criteria->addCondition('panggilantrian != TRUE');
            $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
            $criteria->order = 'no_urutperiksa ASC';

            $model = BSMasukPenunjangV::model()->find($criteria);
            if (!empty($model)) {
                $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
                $data['ruangan_singkatan'] = $model->ruangan_singkatan;
                $data['no_urutperiksa'] = $model->no_urutperiksa;
                $data['ruangan_id'] = $model->ruangan_id;
            } else {
                $data['pesan'] = "Tidak ada antrian!";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAddFormPemakaianBahan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
            $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
            $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $persenjual = $this->persenJualRuangan();
            $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

            echo CJSON::encode(array(
                'pendaftaran_id' => $pendaftaran_id,
                'namaObat' => $modObatAlkes->obatalkes_nama,
                'form' => $this->renderPartial('_formAddPemakaianBahan', array(
                    'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
                    'modPendaftaran' => $modPendaftaran,
                ), true),
            ));
            exit;
        }
    }

    protected function persenJualRuangan()
    {
        switch (Yii::app()->user->getState('instalasi_id')) {
            case Params::INSTALASI_ID_RI:
                $persen = Yii::app()->user->getState('ri_persjual');
                break;
            case Params::INSTALASI_ID_RJ:
                $persen = Yii::app()->user->getState('rj_persjual');
                break;
            case Params::INSTALASI_ID_RD:
                $persen = Yii::app()->user->getState('rd_persjual');
                break;
            default:
                $persen = 0;
                break;
        }

        return $persen;
    }

    public function actionAddFormPemakaianAlat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idAlat = $_POST['idAlat'];
            $idDaftartindakan = $_POST['idDaftartindakan'];
            $modAlat = AlatmedisM::model()->findByPk($idAlat);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            $modObatAlkes = new ObatalkesM;
            echo CJSON::encode(array(
                'namaAlat' => $modAlat->alatmedis_nama,
                'form' => $this->renderPartial('_formAddPemakaianAlat', array(
                    'modAlat' => $modAlat, 'modDaftartindakan' => $modDaftartindakan, 'modObatAlkes' => $modObatAlkes
                ), true),
            ));
            exit;
        }
    }

    public function actionAddFormPaketBmhp()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idKelUmur = (isset($_POST['idKelUmur']) ? $_POST['idKelUmur'] : null);
            $id = (isset($_POST['id']) ? $_POST['id'] : null);
            $idDaftarTindakan = (isset($_POST['idDaftarTindakan']) ? $_POST['idDaftarTindakan'] : null);
            $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array(
                'daftartindakan_id' => $idDaftarTindakan,
                'kelompokumur_id' => $idKelUmur,
            ));
            $modPasienPenunjang = $this->loadByPasienMasukPenunjang($id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modPasienPenunjang->pendaftaran_id);

            echo CJSON::encode(array(
                'form' => $this->renderPartial('_formAddPaketBmhp', array(
                    'modPaketBmhp' => $modPaketBmhp, 'modPendaftaran' => $modPendaftaran,
                ), true),
            ));
            exit;
        }
    }

    public function actionSelesaiOperasi($pasienmasukpenunjang_id)
    {
        $this->layout = '//layouts/iframe';
        $operasiselesai = false;
        $modRencanaOperasi = BSRencanaOperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

        if (isset($_POST['BSRencanaOperasiT'])) {
            $format = new MyFormatter();
            $transaction = Yii::app()->db->beginTransaction();
            try {

                if (count((array)$modRencanaOperasi) > 0) {
                    foreach ($modRencanaOperasi as $i => $value) {
                        $modRencanaOperasi[$i]->selesaioperasi = $_POST['BSRencanaOperasiT']['selesaioperasi'];
                        $modRencanaOperasi[$i]->statusoperasi = $_POST['statusoperasi'];
                        if ($modRencanaOperasi[$i]->validate()) {
                            $modRencanaOperasi[$i]->update();
                            $operasiselesai = true;
                        }
                    }
                }

                if ($operasiselesai) {
                    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));
                    //						$penunjang = PasienmasukpenunjangV::model()->find("pasienmasukpenunjang_id = '".$pasienmasukpenunjang_id."' "); 
                    //						

                    $r = RuanganM::model()->findByPk($penunjang->ruanganasal_id);

                    $judul = 'Operasi Sudah Selesai';

                    $isi = $penunjang->no_rekam_medik . ' ' . $penunjang->nama_pasien . ' Operasi Sudah Selesai';

                    $tujuan = array(
                        array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => (!empty($r->modul_id)) ? $r->modul_id : Yii::app()->user->getState('modul_id')),
                        array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->user->getState('modul_id')),
                    );

                    $pendaftaran = PendaftaranT::model()->findByPk($penunjang->pendaftaran_id);
                    if (!empty($pendaftaran->pasienadmisi_id)) {
                        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

                        if (!empty($admisi) && $r->ruangan_id != $admisi->ruangan_id) {
                            $ruangan_admisi = RuanganM::model()->findByPk($admisi->ruangan_id);
                            $tujuan[] = array('instalasi_id' => $ruangan_admisi->instalasi_id, 'ruangan_id' => $ruangan_admisi->ruangan_id, 'modul_id' => (!empty($ruangan_admisi->modul_id)) ? $ruangan_admisi->modul_id : Yii::app()->user->getState('modul_id'));
                        }
                    }

                    CustomFunction::broadcastNotif($judul, $isi, $tujuan);

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $exc) {
                // var_dump($exc->getMessage()); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
        }
        $this->render('_formSelesaiOperasi', array('modRencanaOperasi' => $modRencanaOperasi, 'sukses' => 1));
    }

    // copas dari ActionDynamicController
    public function actionGetTypeAnastesi($encode = false, $namaModel = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            if ($namaModel !== '' && $attr == '') {
                $anastesi_id = $_POST["$namaModel"]['anastesi_id'];
            } elseif ($namaModel == '' && $attr !== '') {
                $anastesi_id = $_POST["$attr"];
            } elseif ($namaModel !== '' && $attr !== '') {
                $anastesi_id = $_POST["$namaModel"]["$attr"];
            }
            if (!empty($anastesi_id)) {
                $typeanastesi = TypeAnastesiM::model()->findAllByAttributes(array('typeanastesi_id' => $anastesi_id), array('order' => 'typeanastesi_nama'));
            } else {
                $typeanastesi = TypeAnastesiM::model()->findAll();
            }
            $typeanastesi = CHtml::listData($typeanastesi, 'typeanastesi_id', 'typeanastesi_nama');

            if ($encode) {
                echo CJSON::encode($typeanastesi);
            } else {
                if (empty($typeanastesi)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($typeanastesi as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * menambah asal rujukan dari tombol "+" / Dialogbox
     */
    public function actionAddKruBedah()
    {

        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : null;
            $length = isset($_POST['length']) ? $_POST['length'] : null;
            $sukses = 0;

            $peg = PegawaiM::model()->findByPk($id);

            if (!empty($peg)) {
                $sukses = 1;
            }
            $model = new BSPelaksanaoperasiT();
            $model->pegawai_id = $peg->pegawai_id;
            $model->pegawai_nama = $peg->namaLengkap;
            $model->krubedah = $lookup;

            echo CJSON::encode(array(
                'sukses' => $sukses,
                'look' => ucwords(strtolower($lookup)),
                'lookup' => str_replace(' ', '-', strtolower($lookup)),
                'id' => $id,
                'div' => $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $model, 'i' => 0), true)
            ));
            Yii::app()->end();
        }
    }

    /**
     * membatalkan pegawai kru bedah
     */
    public function actionBatalKruBedah()
    {

        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : null;
            $sukses = 0;
            $pesan = '';

            $peg = BSPelaksanaoperasiT::model()->findByPk($id);

            if (!empty($peg)) {

                $batalKruBedah = new BatalpelaksanaoperasiT();
                $batalKruBedah->pelaksanaoperasi_id = $peg->pelaksanaoperasi_id;
                $batalKruBedah->rencanaoperasi_id = $peg->rencanaoperasi_id;
                $batalKruBedah->create_time = date('Y-m-d H:i:s');
                $batalKruBedah->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $batalKruBedah->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $batalKruBedah->pegpembatal_id = Yii::app()->user->getState('pegawai_id');

                if ($batalKruBedah->save()) {
                    $peg->batalpelaksanaoperasi_id = $batalKruBedah->batalpelaksanaoperasi_id;

                    if ($peg->save()) {
                        $sukses = 1;
                        $pesan = "Data Sukses Dibatalkan !";
                    } else {
                        $pesan = "Data Gagal Dibatalkan !";
                    }
                } else {
                    $pesan = "Data Gagal Dibatalkan !";
                }
            } else {
                $pesan = "Data Tidak Ditemukan !";
            }


            echo CJSON::encode(array(
                'sukses' => $sukses,
                'pesan' => $pesan,
            ));
            Yii::app()->end();
        }
    }

    /**
     * menambahkan lookup kru bedah
     */
    public function actionAddLookupKruBedah()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $krubedah = isset($_POST['krubedah']) ? $_POST['krubedah'] : null;
            $sukses = 0;
            $pesan = '';

            $cri = new CDbCriteria();
            $cri->addCondition(" lookup_type = '" . Params::LOOKUPTYPE_KRU_BEDAH . "' ");
            $cri->addCondition(" lookup_value ilike '" . strtolower($krubedah) . "' ");
            $look = LookupM::model()->find($cri);

            if (!empty($look)) {
                $pesan = "Data Kru Bedah sudah ada !";
            } else {
                $look = new LookupM;
                $look->lookup_type = Params::LOOKUPTYPE_KRU_BEDAH;
                $look->lookup_name = $krubedah;
                $look->lookup_value = strtoupper($krubedah);
                $look->lookup_aktif = true;
                $look->lookup_urutan = $look->getNoUrutan(Params::LOOKUPTYPE_KRU_BEDAH);
                $look->create_time = date('Y-m-d H:i:s');
                $look->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $look->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($look->save()) {
                    $sukses = 1;
                    $pesan = "Data Kru Bedah baru berhasil disimpan !";
                } else {
                    $pesan = "Data gagal disimpan !";
                }
            }

            $a = strtolower($look->lookup_value);

            if (strpos($a, 'anestesi') > -1) {
                $ada = 'ada';
            } else {
                $ada = 'tidak';
            }



            $drop = LookupM::model()->getDropUrutan(Params::LOOKUPTYPE_KRU_BEDAH);

            echo CJSON::encode(array(
                'sukses' => $sukses,
                'pesan' => $pesan,
                'drop' => $drop,
                'look' => $krubedah,
                'anestesi' => $ada
            ));
            Yii::app()->end();
        }
    }

    public function actionTimeOut($pasienmasukpenunjang_id, $pendaftaran_id)
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        $modOpSignin = BSOperasisigninT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $modPenunjang->pasienkirimkeunitlain_id));


        $model = BSOperasitimeoutT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));

        $cekTimeOut = array();
        $cekTimeOutIsi = array();
        $cekTimeOutDel = array();
        $getDet = array();

        if (empty($model)) {
            $model = new BSOperasitimeoutT;
            $model->timeout_tgl = date('Y-m-d H:i:s');
        } else {
            $model->dokteranestesi_nama = $model->dokteranestesi->namaLengkap;
            $model->perawatsirkuler_nama = $model->perawatsirkuler->namaLengkap;
            $model->dokterbedah_nama = $model->dokterbedah->namaLengkap;

            $getDet = BSOperasitimeoutdetT::model()->findAllByAttributes(array('operasitimeout_id' => $model->operasitimeout_id));

            foreach ($getDet as $det) {
                if ($det->timeoutdet_hasil == true) {
                    $st = 'true';
                } else {
                    $st = 'false';
                }

                if ($det->checklisttimeout_id == null || $det->checklisttimeout_id == '') {
                    $checklist = 'kosong';
                } else {
                    $checklist = $det->checklisttimeout_id;
                }

                $iden = $det->formtimeout_id . $checklist;
                $cekTimeOut["$iden"] = $iden . $st;
                $cekTimeOutIsi["$iden"] = $det->timeoutdet_isian;
                $cekTimeOutDel["$iden"] = $det->operasitimeoutdet_id;
            }
        }

        $modDet = new BSOperasitimeoutdetT;

        $cri = new CDbCriteria();
        $cri->select = " fs.formtimeout_inputtype, fs.formtimeout_id, fs.formtimeout_nama, fs.haschecklist, t.checklisttimeout_nama, t.checklisttimeout_id, t.checklisttimeout_inputtype";
        $cri->join = " RIGHT JOIN formtimeout_m fs ON fs.formtimeout_id = t.formtimeout_id ";
        $cri->addCondition(" fs.formtimeout_aktif = TRUE ");
        $cri->addCondition(" t.checklisttimeout_aktif = TRUE OR t.checklisttimeout_aktif IS NULL ");
        $cri->order = " fs.formtimeout_urutan ASC, t.checklisttimeout_urutan ASC ";
        $loadFormIsian = BSChecklisttimeoutM::model()->findAll($cri);

        $loadTimeOut = array();

        if (count((array)$loadFormIsian) > 0) {
            foreach ($loadFormIsian as $load) {
                if ($load->checklisttimeout_id == null || $load->checklisttimeout_id == '') {
                    $checklist = 'kosong';
                } else {
                    $checklist = $load->checklisttimeout_id;
                }
                $loadTimeOut[$load->formtimeout_id]['form_id'] =  $load->formtimeout_id;
                $loadTimeOut[$load->formtimeout_id]['check_id'] =  'kosong';
                $loadTimeOut[$load->formtimeout_id]['type'] =  $load->formtimeout_inputtype;
                $loadTimeOut[$load->formtimeout_id]['form_nama'] =  $load->formtimeout_nama;
                $loadTimeOut[$load->formtimeout_id]['form_haschecklist'] =  $load->haschecklist;
                $loadTimeOut[$load->formtimeout_id]['value'] = isset($cekTimeOut[$load->formtimeout_id . 'kosong']) ? $cekTimeOut[$load->formtimeout_id . 'kosong'] : null;
                $loadTimeOut[$load->formtimeout_id]['isian'] = isset($cekTimeOutIsi[$load->formtimeout_id . 'kosong']) ? $cekTimeOutIsi[$load->formtimeout_id . 'kosong'] : null;
                if ($load->haschecklist) {
                    $loadTimeOut[$load->formtimeout_id]['checklist'][$load->checklisttimeout_id]['check_id'] =  $checklist;
                    $loadTimeOut[$load->formtimeout_id]['checklist'][$load->checklisttimeout_id]['check_nama'] =  $load->checklisttimeout_nama;
                    $loadTimeOut[$load->formtimeout_id]['checklist'][$load->checklisttimeout_id]['value'] =  isset($cekTimeOut[$load->formtimeout_id . $checklist]) ? $cekTimeOut[$load->formtimeout_id . $checklist] : null;
                    $loadTimeOut[$load->formtimeout_id]['checklist'][$load->checklisttimeout_id]['isian'] =  isset($cekTimeOutIsi[$load->formtimeout_id . $checklist]) ? $cekTimeOutIsi[$load->formtimeout_id . $checklist] : null;
                    $loadTimeOut[$load->formtimeout_id]['checklist'][$load->checklisttimeout_id]['type'] =  $load->checklisttimeout_inputtype;
                }
                //var_dump($checklist);
                $checklist = 'kosong';
            }
        }

        if (isset($_POST['BSOperasitimeoutT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['BSOperasitimeoutT'];
                $model->timeout_tgl = MyFormatter::formatDateTimeForDb($model->timeout_tgl);
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                if (!empty($model->pasienadmisi_id)) {
                    $adm = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
                    $model->kamarruangan_id = $adm->kamarruangan_id;
                }
                $model->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->operasisignin_id = $modOpSignin->operasisignin_id;
                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }

                $this->simpan_timeout = $this->simpan_timeout && $model->save();
                if ($this->simpan_timeout) {
                    if (isset($_POST['BSOperasitimeoutdetT']['timeout'])) {
                        foreach ($_POST['BSOperasitimeoutdetT']['timeout'] as $i => $val) {
                            $modDet->attributes = $_POST['BSOperasitimeoutdetT']['timeout'][$i];

                            $cri = new CDbCriteria();

                            if ($modDet->checklisttimeout_id == 'kosong' || $modDet->checklisttimeout_id == '') {
                                $modDet->checklisttimeout_id = null;
                                $cri->addCondition(" checklisttimeout_id IS NULL ");
                            } else {
                                $cri->addCondition(" checklisttimeout_id = " . $modDet->checklisttimeout_id . " ");
                            }
                            $cri->addCondition(" operasitimeout_id = " . $model->operasitimeout_id . " ");
                            $cri->addCondition(" formtimeout_id = " . $modDet->formtimeout_id . " ");

                            $cek = BSOperasitimeoutdetT::model()->find($cri);


                            //var_dump($_POST['BSOperasitimeoutdetT']['signin']);
                            if (empty($cek)) {
                                $modDet = new BSOperasitimeoutdetT;
                                $modDet->attributes =  $_POST['BSOperasitimeoutdetT']['timeout'][$i];
                                if ($modDet->checklisttimeout_id == 'kosong') {
                                    $modDet->checklisttimeout_id = null;
                                }

                                if ($modDet->timeoutdet_hasil == '0') {
                                    $modDet->timeoutdet_hasil = false;
                                } elseif ($modDet->timeoutdet_hasil == '1') {
                                    $modDet->timeoutdet_hasil = true;
                                } else {
                                    $modDet->timeoutdet_hasil = null;
                                }

                                $modDet->operasitimeout_id = $model->operasitimeout_id;
                                $this->simpan_timeoutdet = $this->simpan_timeoutdet && $modDet->save();
                            } else {
                                $cek->attributes =  $_POST['BSOperasitimeoutdetT']['timeout'][$i];

                                if ($cek->checklisttimeout_id == 'kosong' || $cek->checklisttimeout_id == '') {
                                    $cek->checklisttimeout_id = null;
                                    $checklist = 'kosong';
                                } else {
                                    $checklist = $cek->checklisttimeout_id;
                                }

                                if ($cek->timeoutdet_hasil == '0') {
                                    $cek->timeoutdet_hasil = false;
                                } elseif ($cek->timeoutdet_hasil == '1') {
                                    $cek->timeoutdet_hasil = true;
                                } else {
                                    $cek->timeoutdet_hasil = null;
                                }

                                $this->simpan_timeoutdet = $this->simpan_timeoutdet && $cek->save();

                                $iden = $cek->formtimeout_id . $checklist;
                                //var_dump($iden);
                                //var_dump($iden);										
                                if (!empty($cekTimeOutDel)) {
                                    unset($cekTimeOutDel[$iden]);
                                }
                            }
                        }

                        $del = $cekTimeOutDel;

                        if (!empty($del)) {
                            $delete =  array();
                            foreach ($del as $d) {
                                $delete[] = $d;
                            }


                            $cri = new CDbCriteria();
                            $cri->addCondition("operasitimeout_id = '" . $model->operasitimeout_id . "' ");
                            $cri->addInCondition('operasitimeoutdet_id', $delete);
                            $up = BSOperasitimeoutdetT::model()->deleteAll($cri);
                        }
                    } else {
                        $del = $cekTimeOutDel;

                        if (!empty($del)) {
                            $delete =  array();
                            foreach ($del as $d) {
                                $delete[] = $d;
                            }


                            $cri = new CDbCriteria();
                            $cri->addCondition("operasitimeout_id = '" . $model->operasitimeout_id . "' ");
                            $cri->addInCondition('operasitimeoutdet_id', $delete);
                            $up = BSOperasitimeoutdetT::model()->deleteAll($cri);
                        }
                    }



                    //$judul = 'Pengiriman Berkas Rekam Medis';

                    //$isi = $modUbahStatus->pendaftaran->no_pendaftaran.' - '.$modUbahStatus->pasien->no_rekam_medik.' - '.$modUbahStatus->pasien->nama_pasien;

                    //CustomFunction::broadcastNotif($judul, $isi, array(
                    //	array('instalasi_id'=> $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id'=> $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id'=> !empty($modUbahStatus->ruangantujuan->modul_id)?$modUbahStatus->ruangantujuan->modul_id:null),
                    //));   
                    if ($this->simpan_timeoutdet && $this->simpan_timeout) {
                        $transaction->commit();
                        $status = true;
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                        $this->redirect(array('timeOut', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        $status = false;
                        Yii::app()->user->setFlash('success', "Data gagal disimpan !");
                    }
                } else {
                    $transaction->rollback();
                    $status = false;
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . 'timeout._formTimeOut', array(
            'modPendaftaran' => $modPendaftaran,
            'modPenunjang' => $modPenunjang,
            'model' => $model,
            'loadTimeOut' => $loadTimeOut,
            'modDet' => $modDet,
            'getDet' => $getDet
        ));
    }

    public function actionAddTambahDetailTimeout()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $form_id = isset($_POST['form_id']) ? $_POST['form_id'] : null;
            $check_id = isset($_POST['check_id']) ? $_POST['check_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            $isian = isset($_POST['isian']) ? $_POST['isian'] : null;
            $identifier = $form_id . '_' . $check_id;

            $pesan = '';
            $sukses = 1;

            $modDet = new BSOperasitimeoutdetT;
            $modDet->formtimeout_id = $form_id;
            $modDet->checklisttimeout_id = $check_id;
            $modDet->timeoutdet_hasil = $status;
            $modDet->timeoutdet_isian = $isian;
            $modDet->identifier = $identifier;


            $tr = $this->renderPartial($this->path_view . "timeout._formGetTimeOut", array('modDet' => $modDet, 'i' => 0), true);

            echo json_encode(array(
                'tr' => $tr,
                'pesan' => $pesan,
                'sukses' => $sukses,
                'identifier' => $identifier
            ));

            Yii::app()->end();
        }
    }


    public function actionSignOut($pasienmasukpenunjang_id, $pendaftaran_id, $timeout_id = '')
    {
        $this->layout = '//layouts/iframe';
        //$format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        if (!empty($modPenunjang->pasienadmisi_id)) {
            $modAdmisi = PasienadmisiT::model()->findByPk($modPenunjang->pasienadmisi_id);
        } else {
            $modAdmisi = new PasienadmisiT();
        }

        $modOpTimeout = BSOperasitimeoutT::model()->findByPk($timeout_id);


        $model = BSOperasisignoutT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));

        $cekSignOut = array();
        $cekSignOutIsi = array();
        $cekSignOutDel = array();
        $getDet = array();

        if (empty($model)) {
            $model = new BSOperasisignoutT;
            $model->signout_tgl = date('Y-m-d H:i:s');
        } else {
            $model->dokteranestesi_nama = $model->dokteranestesi->namaLengkap;
            $model->perawatsirkuler_nama = $model->perawatsirkuler->namaLengkap;
            $model->dokterbedah_nama = $model->dokterbedah->namaLengkap;

            $getDet = BSOperasisignoutdetT::model()->findAllByAttributes(array('operasisignout_id' => $model->operasisignout_id));

            foreach ($getDet as $det) {
                if ($det->signoutdet_hasil == true) {
                    $st = 'true';
                } else {
                    $st = 'false';
                }

                if ($det->checklistsignout_id == null || $det->checklistsignout_id == '') {
                    $checklist = 'kosong';
                } else {
                    $checklist = $det->checklistsignout_id;
                }

                $iden = $det->formsignout_id . $checklist;
                $cekSignOut["$iden"] = $iden . $st;
                $cekSignOutIsi["$iden"] = $det->signoutdet_isian;
                $cekSignOutDel["$iden"] = $det->operasisignoutdet_id;
            }
        }

        $modDet = new BSOperasisignoutdetT;

        $cri = new CDbCriteria();
        $cri->select = " fs.formsignout_inputtype, fs.formsignout_id, fs.formsignout_nama, fs.haschecklist, t.checklistsignout_nama, t.checklistsignout_id, t.checklistsignout_inputtype";
        $cri->join = " RIGHT JOIN formsignout_m fs ON fs.formsignout_id = t.formsignout_id ";
        $cri->addCondition(" fs.formsignout_aktif = TRUE ");
        $cri->addCondition(" t.checklistsignout_aktif = TRUE OR t.checklistsignout_aktif IS NULL ");
        $cri->order = " fs.formsignout_urutan ASC, t.checklistsignout_urutan ASC ";
        $loadFormIsian = BSChecklistsignoutM::model()->findAll($cri);

        $loadSignOut = array();

        if (count((array)$loadFormIsian) > 0) {
            foreach ($loadFormIsian as $load) {
                if ($load->checklistsignout_id == null || $load->checklistsignout_id == '') {
                    $checklist = 'kosong';
                } else {
                    $checklist = $load->checklistsignout_id;
                }
                $loadSignOut[$load->formsignout_id]['form_id'] =  $load->formsignout_id;
                $loadSignOut[$load->formsignout_id]['check_id'] =  'kosong';
                $loadSignOut[$load->formsignout_id]['type'] =  $load->formsignout_inputtype;
                $loadSignOut[$load->formsignout_id]['form_nama'] =  $load->formsignout_nama;
                $loadSignOut[$load->formsignout_id]['form_haschecklist'] =  $load->haschecklist;
                $loadSignOut[$load->formsignout_id]['value'] = isset($cekSignOut[$load->formsignout_id . 'kosong']) ? $cekSignOut[$load->formsignout_id . 'kosong'] : null;
                $loadSignOut[$load->formsignout_id]['isian'] = isset($cekSignOutIsi[$load->formsignout_id . 'kosong']) ? $cekSignOutIsi[$load->formsignout_id . 'kosong'] : null;
                if ($load->haschecklist) {
                    $loadSignOut[$load->formsignout_id]['checklist'][$load->checklistsignout_id]['check_id'] =  $checklist;
                    $loadSignOut[$load->formsignout_id]['checklist'][$load->checklistsignout_id]['check_nama'] =  $load->checklistsignout_nama;
                    $loadSignOut[$load->formsignout_id]['checklist'][$load->checklistsignout_id]['value'] =  isset($cekSignOut[$load->formsignout_id . $checklist]) ? $cekSignOut[$load->formsignout_id . $checklist] : null;
                    $loadSignOut[$load->formsignout_id]['checklist'][$load->checklistsignout_id]['isian'] =  isset($cekSignOutIsi[$load->formsignout_id . $checklist]) ? $cekSignOutIsi[$load->formsignout_id . $checklist] : null;
                    $loadSignOut[$load->formsignout_id]['checklist'][$load->checklistsignout_id]['type'] =  $load->checklistsignout_inputtype;
                }
                //var_dump($checklist);
                $checklist = 'kosong';
            }
        }

        if (isset($_POST['BSOperasisignoutT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['BSOperasisignoutT'];
                $model->signout_tgl = MyFormatter::formatDateTimeForDb($model->signout_tgl);
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                if (!empty($model->pasienadmisi_id)) {
                    $adm = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
                    $model->kamarruangan_id = $adm->kamarruangan_id;
                }
                $model->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->operasitimeout_id = $modOpTimeout->operasitimeout_id;
                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }

                $this->simpan_signout = $this->simpan_signout && $model->save();
                if ($this->simpan_signout) {
                    if (isset($_POST['BSOperasisignoutdetT']['signout'])) {
                        foreach ($_POST['BSOperasisignoutdetT']['signout'] as $i => $val) {
                            $modDet->attributes = $_POST['BSOperasisignoutdetT']['signout'][$i];

                            $cri = new CDbCriteria();

                            if ($modDet->checklistsignout_id == 'kosong' || $modDet->checklistsignout_id == '') {
                                $modDet->checklistsignout_id = null;
                                $cri->addCondition(" checklistsignout_id IS NULL ");
                            } else {
                                $cri->addCondition(" checklistsignout_id = " . $modDet->checklistsignout_id . " ");
                            }
                            $cri->addCondition(" operasisignout_id = " . $model->operasisignout_id . " ");
                            $cri->addCondition(" formsignout_id = " . $modDet->formsignout_id . " ");

                            $cek = BSOperasisignoutdetT::model()->find($cri);


                            //var_dump($_POST['BSOperasisignoutdetT']['signin']);
                            if (empty($cek)) {
                                $modDet = new BSOperasisignoutdetT;
                                $modDet->attributes =  $_POST['BSOperasisignoutdetT']['signout'][$i];
                                if ($modDet->checklistsignout_id == 'kosong') {
                                    $modDet->checklistsignout_id = null;
                                }

                                if ($modDet->signoutdet_hasil == '0') {
                                    $modDet->signoutdet_hasil = false;
                                } elseif ($modDet->signoutdet_hasil == '1') {
                                    $modDet->signoutdet_hasil = true;
                                } else {
                                    $modDet->signoutdet_hasil = null;
                                }

                                $modDet->operasisignout_id = $model->operasisignout_id;
                                $this->simpan_signoutdet = $this->simpan_signoutdet && $modDet->save();
                            } else {
                                $cek->attributes =  $_POST['BSOperasisignoutdetT']['signout'][$i];

                                if ($cek->checklistsignout_id == 'kosong' || $cek->checklistsignout_id == '') {
                                    $cek->checklistsignout_id = null;
                                    $checklist = 'kosong';
                                } else {
                                    $checklist = $cek->checklistsignout_id;
                                }

                                if ($cek->signoutdet_hasil == '0') {
                                    $cek->signoutdet_hasil = false;
                                } elseif ($cek->signoutdet_hasil == '1') {
                                    $cek->signoutdet_hasil = true;
                                } else {
                                    $cek->signoutdet_hasil = null;
                                }

                                $this->simpan_signoutdet = $this->simpan_signoutdet && $cek->save();

                                $iden = $cek->formsignout_id . $checklist;
                                //var_dump($iden);
                                //var_dump($iden);										
                                if (!empty($cekSignOutDel)) {
                                    unset($cekSignOutDel[$iden]);
                                }
                            }
                        }

                        $del = $cekSignOutDel;

                        if (!empty($del)) {
                            $delete =  array();
                            foreach ($del as $d) {
                                $delete[] = $d;
                            }


                            $cri = new CDbCriteria();
                            $cri->addCondition("operasisignout_id = '" . $model->operasisignout_id . "' ");
                            $cri->addInCondition('operasisignoutdet_id', $delete);
                            $up = BSOperasisignoutdetT::model()->deleteAll($cri);
                        }
                    } else {
                        $del = $cekSignOutDel;

                        if (!empty($del)) {
                            $delete =  array();
                            foreach ($del as $d) {
                                $delete[] = $d;
                            }


                            $cri = new CDbCriteria();
                            $cri->addCondition("operasisignout_id = '" . $model->operasisignout_id . "' ");
                            $cri->addInCondition('operasisignoutdet_id', $delete);
                            $up = BSOperasisignoutdetT::model()->deleteAll($cri);
                        }
                    }



                    $judul = 'Pasien sudah dilakukan Operasi';


                    $isi = $modPendaftaran->no_pendaftaran . ' - ' . $modPendaftaran->pasien->no_rekam_medik . ' - ' . $modPendaftaran->pasien->nama_pasien;

                    $ruangan_asal = RuanganM::model()->findByPk($modPenunjang->ruanganasal_id);

                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => $ruangan_asal->instalasi_id, 'ruangan_id' => $ruangan_asal->ruangan_id, 'modul_id' => $ruangan_asal->modul_id),
                    ));

                    if ($this->simpan_signoutdet && $this->simpan_signout) {
                        $transaction->commit();
                        $status = true;
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                        $this->redirect(array('signOut', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        $status = false;
                        Yii::app()->user->setFlash('success', "Data gagal disimpan !");
                    }
                } else {
                    $transaction->rollback();
                    $status = false;
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . 'signout._formSignOut', array(
            'modPendaftaran' => $modPendaftaran,
            'modPenunjang' => $modPenunjang,
            'model' => $model,
            'loadSignOut' => $loadSignOut,
            'modDet' => $modDet,
            'getDet' => $getDet,
            'modAdmisi' => $modAdmisi
        ));
    }

    public function actionAddTambahDetailSignout()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $form_id = isset($_POST['form_id']) ? $_POST['form_id'] : null;
            $check_id = isset($_POST['check_id']) ? $_POST['check_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            $isian = isset($_POST['isian']) ? $_POST['isian'] : null;
            $identifier = $form_id . '_' . $check_id;

            $pesan = '';
            $sukses = 1;

            $modDet = new BSOperasisignoutdetT;
            $modDet->formsignout_id = $form_id;
            $modDet->checklistsignout_id = $check_id;
            $modDet->signoutdet_hasil = $status;
            $modDet->signoutdet_isian = $isian;
            $modDet->identifier = $identifier;


            $tr = $this->renderPartial($this->path_view . "signout._formGetSignOut", array('modDet' => $modDet, 'i' => 0), true);

            echo json_encode(array(
                'tr' => $tr,
                'pesan' => $pesan,
                'sukses' => $sukses,
                'identifier' => $identifier
            ));

            Yii::app()->end();
        }
    }

    public function actionApproveMengetahui($pasienmasukpenunjang_id, $approve = false)
    {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPasienMasukPenunjang = BSMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modRencanaOperasi = BSRencanaOperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

        if ($approve) {
            $update = BSRencanaOperasiT::model()->updateByPk($modRencanaOperasi->rencanaoperasi_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
            if ($update) {

                $judul = 'Approval Rencana Operasi'; //.$modKunjungan->no_rekam_medik.' - '.$modKunjungan->nama_pasien;

                $isi = $modPasienMasukPenunjang->no_pendaftaran . ' - ' . $modPasienMasukPenunjang->no_rekam_medik . ' - ' . $modPasienMasukPenunjang->nama_pasien . "<br/>"
                    . "Status : Disetujui.";

                $ruangan = RuanganM::model()->findByPk($modPasienMasukPenunjang->ruanganasal_id);

                CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => $modPasienMasukPenunjang->instalasiasal_id, 'ruangan_id' => $modPasienMasukPenunjang->ruanganasal_id, 'modul_id' => !empty($ruangan->modul_id) ? $ruangan->modul_id : null),
                    array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState("ruangan_id"), 'modul_id' => Params::MODUL_ID_BEDAHSENTRAL),
                ));


                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->redirect(array('ApproveMengetahui', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'sukses' => 1));
            } else {
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
            }
        }
        $judulLaporan = 'Approve Pasien untuk Operasi';
        $this->render($this->path_view . '_mengetahui', array(
            'format' => $format,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modRencanaOperasi' => $modRencanaOperasi,
            'judulLaporan' => $judulLaporan
        ));
    }

    public function actionPrintApproveMengetahui($pasienmasukpenunjang_id)
    {
        $format = new MyFormatter();

        $modPasienMasukPenunjang = BSMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modRencanaOperasi = BSRencanaOperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $judulLaporan = 'Approve Pasien untuk Operasi';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modRencanaOperasi' => $modRencanaOperasi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modRencanaOperasi' => $modRencanaOperasi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modRencanaOperasi' => $modRencanaOperasi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id ='. $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms =[];
    foreach ($modDokfilerm as $dok) {
        if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
            $modDokfilerms[]=$dok; 
        }
    }
    $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms));
  }

  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = null;
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }



    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = $pegawai_id;


    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RI;
      $modUbahStatus->ruangan_id = $modAdmisi->ruangan_id;

      // var_dump($modUbahStatus->attributes); die;
    }

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        //var_dump($_POST);die;
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;
          $modPendaftaran->save();

          $judul = 'Pengiriman Berkas Rekam Medis';

          $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
          ));

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'modAdmisi' => $modAdmisi,
      'status' => $status
    ));
  }

  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionDetailScanRM($dokfilerm_id) {
    $this->layout = '//layouts/iframe';
        
        $file = DokfilermR::model()->findByPk($dokfilerm_id);
            
        $this->render("detail_scandokumen", array(
        'file'=>$file,
    ));
  }

  
}
