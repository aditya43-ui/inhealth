<?php
class PemakaianBahanMCUController extends MyAuthController
{
    public $path_view = "mcu.views.pemakaianBahan.";
    public $path_view_bmhp = "mcu.views.pemakaianBmhp.";
    public $obatalkespasientersimpan = true; //dilooping
    public $stokobatalkestersimpan = true;

    public function actionIndex($pendaftaran_id = null)
    {
        $format = new MyFormatter();
        $modKunjungan = new InfokunjunganmcuV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modObatAlkesPasien = new ObatalkespasienT;
        $dataOas = array();

        if (!empty($pendaftaran_id)) {
            $modKunjungan = InfokunjunganmcuV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        }

        if (isset($_POST['ObatalkespasienT'])) {
            if (isset($_POST['pendaftaran_id'])) {
                $modPendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (count((array)$_POST['ObatalkespasienT']) > 0) {
                        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                        $detailGroups = array();
                        foreach ($_POST['ObatalkespasienT'] as $i => $postDetail) {
                            $modDetails[$i] = new ObatalkespasienT;
                            $modDetails[$i]->attributes = $postDetail;

                            $modDetails[$i] = $this->simpanObatAlkesPasien2($modPendaftaran, $modDetails[$i]);
                            $this->simpanStokObatAlkesOut2($modDetails[$i]);
                        }
                        //END GROUP
                    }

                    $this->notifPemakaianBahan($modPendaftaran, $modDetails);

                    if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
                        $transaction->commit();
                        $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan !");
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'modKunjungan' => $modKunjungan,
            'modObatAlkesPasien' => $modObatAlkesPasien,
            'dataOas' => $dataOas,
        ));
    }

    public function notifPemakaianBahan($modPendaftaran, $modDetails)
    {
        if (count((array)$modDetails) == 0) {
            return;
        }

        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $pasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul = "Pemakaian Bahan Pasien";
        $isi = "Pasien : " . $modPendaftaran->no_pendaftaran . " - " . $pasien->no_rekam_medik . " - " . $pasien->nama_pasien . "<br/>"
            . "Tgl. Transaksi : " . MyFormatter::formatDateTimeForUser($modDetails[0]->tglpelayanan) . "<br/>"
            . "<ul>";
        foreach ($modDetails as $item) {
            $oa = ObatalkesM::model()->findByPk($item->obatalkes_id);
            $isi .= "<li>" . $oa->obatalkes_nama . " (" . $item->qty_oa . ")</li>";
        }
        $isi .= "</ul>";

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
        ));
    }


    public function actionPrint($pendaftaran_id)
    {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = InfokunjunganmcuV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

        $judul_print = 'Pemakaian Bahan ' . $modPendaftaran->ruangan_nama;
        $this->render($this->path_view . 'printPemakaianBahan', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran,
            'modObatAlkesPasien' => $modObatAlkesPasien,
        ));
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
            $modObatAlkes->hargajual = round($modObatAlkes->hargajual); //floor(($persenjual + 100 ) / 100 * $modObatAlkes->hargajual);
            $modObatAlkes->statusoa = Params::OA_STATUS_DIGUNAKAN;

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

    public function actionInformasi()
    {
        $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan";
        $model = new ObatalkespasienT;
        $model->unsetAttributes();
        $format = new MyFormatter();
        //        $model->tglAwal = date('Y-m-d').' 00:00:00';
        //        $model->tglAkhir = date('Y-m-d').' 23:59:59';
        $model->tglAwal = date('Y-m-d');
        $model->tglAkhir = date('Y-m-d');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['ObatalkespasienT'])) {
            $model->attributes = $_GET['ObatalkespasienT'];
            //            $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAwal']).' 00:00:00';
            //            $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAkhir'].' 23:59:59');            
            $model->tglAwal = $format->formatDateTimeForDb($_GET['ObatalkespasienT']['tglAwal']);
            $model->tglAkhir = $format->formatDateTimeForDb($_GET['ObatalkespasienT']['tglAkhir']);
            $model->no_pendaftaran = $_GET['ObatalkespasienT']['no_pendaftaran'];
            $model->no_rekam_medik = $_GET['ObatalkespasienT']['no_rekam_medik'];
            $model->nama_pasien = $_GET['ObatalkespasienT']['nama_pasien'];
            $model->carabayar_id = $_GET['ObatalkespasienT']['carabayar_id'];
            $model->penjamin_id = $_GET['ObatalkespasienT']['penjamin_id'];

            $model->jenisobatalkes_id = $_GET['ObatalkespasienT']['jenisobatalkes_id'];
            $model->obatalkes_kategori = $_GET['ObatalkespasienT']['obatalkes_kategori'];
            $model->obatalkes_golongan = $_GET['ObatalkespasienT']['obatalkes_golongan'];
            $model->obatalkes_nama = $_GET['ObatalkespasienT']['obatalkes_nama'];
            $model->prefix_pendaftaran = isset($_GET['ObatalkespasienT']['prefix_pendaftaran']) ? $_GET['ObatalkespasienT']['prefix_pendaftaran'] : '';
        }

        $linkHalaman = CustomFunction::getUrlByMenuID(2957);

        $this->render($this->path_view . 'informasi', array(
            'model' => $model,
            'linkHalaman' => $linkHalaman
        ));
    }


    /**
     * simpan LBObatalkespasienT
     * @param type $modPendaftaran
     * @param type $postObatAlkesPasien
     * @return \LBObatalkespasienT
     */
    public function simpanObatAlkesPasien2($modPendaftaran, $postObatAlkesPasien)
    {
        $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien->obatalkes_id);
        $modObatAlkesPasien = new ObatalkespasienT;
        $modObatAlkesPasien->attributes = $postObatAlkesPasien->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
        $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = round($oa->hargajual); //$stokOa->HargaJualSatuan;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
        $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
        // $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;


        // var_dump($modObatAlkesPasien->attributes); die;

        if ($modObatAlkesPasien->save()) {
            $this->obatalkespasientersimpan &= true;
        } else {
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkesPasien;
    }


    /**
     * simpan StokobatalkesT Jumlah Out (Lepas Validasi Stok)
     * @param type $stokobatalkesasal_id
     * @param type $modObatAlkesPasien
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
    {
        $format = new MyFormatter;
        // $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        // $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

        $modStokOaNew->tglterima = $modStokOaNew->create_time;

        // var_dump($modStokOaNew->attributes); 
        // var_dump($modStokOaNew->validate());
        // var_dump($modStokOaNew->errors);
        // die;

        if ($modStokOaNew->validate()) {
            $modStokOaNew->save();
            // $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;
    }


    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
            $model = $this->loadModPasien($_POST['pendaftaran_id']);

            /*
            if(isset($model)){
                $loadPendaftran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                if(isset($loadPendaftran)){
                    if(strtolower(trim($loadPendaftran->statusperiksa)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
                        $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
                    }
                }
            }
             * 
             */

            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * @param type $pasienmasukpenunjang_id
     * @return LBPasienMasukPenunjangV
     */
    public function loadModPasien($pendaftaran_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
        $model = InfokunjunganmcuV::model()->find($criteria);
        return $model;
    }
    /**
     * untuk form kunjungan
     */
    public function actionAutocompleteKunjungan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
            $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition('ruangan_id = ' . $ruangan_id);
            $criteria->order = 'no_pendaftaran, no_masukpenunjang, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = LBPasienMasukPenunjangV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * untuk form tambah obat alkes
     */
    public function actionAutocompleteObatAlkes()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->join = " JOIN stokobatalkes_t stok ON stok.obatalkes_id = t.obatalkes_id ";
            $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('t.obatalkes_farmasi = TRUE');
            $criteria->addCondition('t.obatalkes_aktif = true');
            $criteria->addCondition("stok.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
            $criteria->order = 't.obatalkes_nama';
            $criteria->limit = 5;
            $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
            $format = new MyFormatter();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qty_stok;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                $returnVal[$i]['qty_stok'] = $qty_stok;
                $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatObatAlkesPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $loadOaPasiens = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id' => $_POST['pendaftaran_id'],
                'ruangan_id' => Yii::app()->user->getState('ruangan_id')
            ), array(
                'condition' => 'penjualanresep_id is null',
            ));
            if (count((array)$loadOaPasiens) > 0) {
                foreach ($loadOaPasiens as $i => $modObatAlkesPasien) {
                    $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
                    $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
                    $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
                    $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
                    $rows .= $this->renderPartial($this->path_view . "_rowRiwayatObatAlkesPasien", array('modObatAlkesPasien' => $modObatAlkesPasien), true);
                }
            }
            echo CJSON::encode(array(
                'rows' => $rows
            ));
        }
        Yii::app()->end();
    }
    /**
     * hapus LBObatalkespasienT yang sudah ada di database
     * @params obatalkespasien_id
     */
    public function actionHapusObatAlkesPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);
                $kembalikanstok = $this->kembalikanStok($loadObatAlkesPasien);
                if ($kembalikanstok) {
                    if ($loadObatAlkesPasien->delete()) {
                        $transaction->commit();
                        $data['pesan'] = "Obat / Alat Kesehatan berhasil dihapus!";
                        $data['sukses'] = 1;
                    } else {
                        $transaction->rollback();
                        $data['pesan'] = "Stok Obat / Alat Kesehatan gagal dikembalikan!";
                        $data['sukses'] = 0;
                    }
                } else {
                    $transaction->rollback();
                    $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus!";
                    $data['sukses'] = 0;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    /**
     * mengembalikan stok jika ada pembatalan
     * @param type $obatAlkesT
     */
    protected function kembalikanStok($modObatAlkesPasien)
    {
        $format = new MyFormatter();
        StokobatalkesT::model()->deleteAllByAttributes(array(
            'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
        ));
        return true;
    }

    /**
     * menampilkan obat
     * @return row table 
     */
    public function actionSetFormObatAlkesPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
            $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkesPasien = new ObatalkespasienT();
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            // if(count((array)$modStokOAs) > 0){

            // foreach($modStokOAs AS $i => $stok){
            $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
            $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
            $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
            $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
            $modObatAlkesPasien->hargasatuan_oa = round($oa->hargajual); //$stok->HargaJualSatuan;
            $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
            $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
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
            $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
            $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
            $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
            // $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
            $modObatAlkesPasien->ruangan_id = $ruangan_id;

            $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
            //}
            // }else{
            //    $pesan = "Stok tidak mencukupi!";
            // }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
}
