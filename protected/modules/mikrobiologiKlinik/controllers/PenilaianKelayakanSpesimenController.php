<?php

/**
 * Proses penilaian kelayanan spesimen Lab Mikro
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class PenilaianKelayakanSpesimenController extends MyAuthController {

    public $path_view_spesimen = "mikrobiologiKlinik.views.penilaianKelayakanSpesimen.";

    /**
     * Default menu transaksi
     * @param integer $pasienkirimkeunitlain_id
     */
    public function actionIndex($pasienkirimkeunitlain_id = null) {
        $modKunjungan = new MKPasienKirimKeUnitLainV;
        $modTindakan = new MKTindakanPelayananT;
        $modPemeriksaanLab = new MKTarifpemeriksaanlabruanganV;
        $modPpds = new PpdsM;
        $modPpdsAlamat = new PpdsalamatM;
        $modPenilaian = new MKPenialianKelayakanSpesimenT;
        $modSpesimen = new MKSpesimenT;
        $modSpesimen2 = new SpesimenT;
        $modPermintaanKePenunjang = array();
        $dataTindakans = array();
        $dataKirimSpesimen = new KirimspesimenlabT;
        $dataSpesimen = new MKSpesimenT;

        $modPpdsAlamat->no_mobile = null;

        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");

        if (!empty($pasienkirimkeunitlain_id)) {
            $modKunjungan = MKPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            $modePasienKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
            if (!empty($modePasienKirimUnitlain->ppds_id)) {
                $modPpds = PpdsM::model()->findByPk($modePasienKirimUnitlain->ppds_id);
                $modPpdsAlamat = PpdsalamatM::model()->findByAttributes(array('ppds_id' => $modPpds->ppds_id));
                if (empty($modPpdsAlamat->ppds_id)) {
                    $modPpdsAlamat = new PpdsalamatM;
                    $modPpdsAlamat->no_mobile = null;
                }
            }
            $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));

            $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            if (!empty($modPenilaian->penilaian_kelayakan_spesimen_id)) {
                $modPenilaian->manajerpelayanan_nama = !empty($modPenilaian->manajerpelayanan_id) ? PegawaiM::model()->findByPk($modPenilaian->manajerpelayanan_id)->namaLengkap : "";
                $modPenilaian->dpjtm_nama = !empty($modPenilaian->dpjtm_id) ? PegawaiM::model()->findByPk($modPenilaian->dpjtm_id)->namaLengkap : "";
                $modPenilaian->ppds_nama = !empty($modPenilaian->ppds_id) ? PpdsM::model()->findByPk($modPenilaian->ppds_id)->ppds_nama : "";
                $dataSpesimen = MKSpesimenT::model()->findByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));
                $modSpesimen2 = SpesimenT::model()->findByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));
                $modKunjungan = MKPasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
                $modPendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
                $modKunjungan->no_pendaftaran = $modPendaftaran->no_pendaftaran;
                $modKunjungan->carabayar_id = $modPendaftaran->carabayar_id;
                $modKunjungan->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
                $modKunjungan->penjamin_id = $modPendaftaran->penjamin_id;
                $modKunjungan->penjamin_nama = $modPendaftaran->penjamin->penjamin_nama;
                $modKunjungan->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;
                $modKunjungan->namadepan = $modPendaftaran->pasien->namadepan;
                $modKunjungan->nama_pasien = $modPendaftaran->pasien->nama_pasien;
                $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir);
                $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
                $modKunjungan->umur = $modPendaftaran->umur;
                $modKunjungan->jeniskelamin = $modPendaftaran->pasien->jeniskelamin;
                $modKunjungan->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
                $modKunjungan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modKunjungan->kelaspelayanan_nama = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
                $modKunjungan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modKunjungan->jeniskasuspenyakit_nama = $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
                $modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
                $modKunjungan->instalasiasal_nama = $modKunjungan->instalasi->instalasi_nama;
                $modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
                $modKunjungan->ruanganasal_nama = $modKunjungan->ruangan->ruangan_nama;
                $modKunjungan->gelardepan = $modKunjungan->pegawai->namaLengkap;
            } else {
                $modPenilaian = new MKPenialianKelayakanSpesimenT;
            }

            $dataKirimSpesimen = KirimspesimenlabT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
        }

        if (isset($_GET['penilaian_kelayakan_spesimen_id'])) {
            $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByPk($_GET['penilaian_kelayakan_spesimen_id']);
            $modPenilaian->manajerpelayanan_nama = !empty($modPenilaian->manajerpelayanan_id) ? PegawaiM::model()->findByPk($modPenilaian->manajerpelayanan_id)->namaLengkap : "";
            $modPenilaian->dpjtm_nama = !empty($modPenilaian->dpjtm_id) ? PegawaiM::model()->findByPk($modPenilaian->dpjtm_id)->namaLengkap : "";
            $modPenilaian->ppds_nama = !empty($modPenilaian->ppds_id) ? PpdsM::model()->findByPk($modPenilaian->ppds_id)->ppds_nama : "";
            // $modPenilaian->samplelab_nama = $_GET['penilaian_kelayakan_spesimen_id']['samplelab_nama'];

            $dataSpesimen = MKSpesimenT::model()->findByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));
        }

        if (isset($_POST['MKPenialianKelayakanSpesimenT'])) {
            $sukses = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPenilaian->attributes = $_POST['MKPenialianKelayakanSpesimenT'];
                $modPenilaian->tanggal = MyFormatter::formatDateTimeForDb($modPenilaian->tanggal);
                $modPenilaian->manajerpelayanan_id = $modPenilaian->manajerpelayanan_id;
                $modPenilaian->dpjtm_id = $modPenilaian->dpjtm_id;
                $modPenilaian->ppds_id = $modPenilaian->ppds_id;
                $modPenilaian->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;                                
                
                $modPenilaian->validate();
                echo CHtml::errorSummary($modPenilaian);
                if ($modPenilaian->save()) {
                    $sukses &= true;
                } else {
                    $sukses &= false;
                }

                if ($sukses && isset($_POST['MKSpesimenT'])) {
                    $no_spesimen = MyGenerator::noSpesimenLab('01', $_POST['KirimspesimenlabT']['samplelab_id']);$no_spesimen = MyGenerator::noSpesimenLab('01', $_POST['KirimspesimenlabT']['samplelab_id'], "PenilaianKelayakanSpesimen");

                    foreach ($_POST['MKSpesimenT'] as $i => $value) {
                        if (!empty($value['statusspesimen'] && $value['statusspesimen'] == 1)) {
                            if (!empty($value['spesimen_id'])) {
                                $modSpesimen = SpesimenT::model()->findByPk($value['spesimen_id']);
                                if ($modSpesimen->delete()) {
                                    $sukses &= true;
                                } else {
                                    $sukses &= false;
                                }
                            }

                            if (!empty($value['permintaankepenunjang_id'])) {
                                $modPermintaan = PermintaankepenunjangT::model()->findByPk($value['permintaankepenunjang_id']);
                                if ($modPermintaan->delete()) {
                                    $sukses &= true;
                                } else {
                                    $sukses &= false;
                                }
                            }
                        } else {
                            if (!empty($value['spesimen_id'])) {
                                $modSpesimen = MKSpesimenT::model()->findByPk($value['spesimen_id']);
                                $modSpesimen->attributes = $value;
                                $modSpesimen->tindakanpelayanan_id = $value['tindakanpelayanan_id'];

                                if ($modSpesimen->validate()) {
                                    if ($modSpesimen->save()) {
                                        $sukses &= true;
                                    } else {
                                        $sukses &= false;
                                    }
                                }
                            } else {
                                $modSpesimen = new MKSpesimenT;
                                $modSpesimen->attributes = $value;
                                $modSpesimen->tindakanpelayanan_id = $value['tindakanpelayanan_id'];
                                $modSpesimen->spesimen_id = null;
                                $modSpesimen->no_spesimen = !empty($_POST['SpesimenT']['no_spesimen']) ? $_POST['SpesimenT']['no_spesimen'] : $no_spesimen;
                                $modSpesimen->penilaian_kelayakan_spesimen_id = $modPenilaian->penilaian_kelayakan_spesimen_id;
                                $modSpesimen->waktu_pengambilan_spesimen = date("Y-m-d H:i:s");

                                if (empty($value['permintaankepenunjang_id'])) {
                                    $modPermintaan = new PermintaankepenunjangT;
                                    $modPermintaan->daftartindakan_id = $value['daftartindakan_id'];
                                    $modPermintaan->pemeriksaanlab_id = $modSpesimen->pemeriksaanlab_id;
                                    $modPermintaan->pemeriksaanrad_id = null;
                                    $modPermintaan->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                                    $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
                                    $modPermintaan->qtypermintaan = 1;
                                    $modPermintaan->tarif_pelayananan = $value['tarif_pelayananan'];
                                    $modPermintaan->tglpermintaankepenunjang = date('Y-m-d H:i:s');
                                    if ($modSpesimen->validate() && $modPermintaan->validate()) {
                                        if ($modSpesimen->save() && $modPermintaan->save()) {
                                            $sukses &= true;
                                        } else {
                                            $sukses &= false;
                                        }
                                    }
                                } else {
                                    if ($modSpesimen->validate()) {
                                        if ($modSpesimen->save()) {
                                            $sukses &= true;
                                        } else {
                                            $sukses &= false;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($sukses) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                    $this->redirect(array('index', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view_spesimen . 'index', array(
            'modKunjungan' => $modKunjungan,
            'modPemeriksaanLab' => $modPemeriksaanLab,
            'modTindakan' => $modTindakan,
            'modPpds' => $modPpds,
            'modPpdsAlamat' => $modPpdsAlamat,
            'modPenilaian' => $modPenilaian,
            'modSpesimen' => $modSpesimen,
            'modPermintaanKePenunjang' => $modPermintaanKePenunjang,
            'dataKirimSpesimen' => $dataKirimSpesimen,
            'dataSpesimen' => $dataSpesimen,
            'modSpesimen2' => $modSpesimen2
        ));
    }

    /**
     * Load data permintaan dari work order
     */
    public function actionSetPermintaanKePenunjang() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $penjamin_id = $_POST['penjamin_id'];
            $modPermintaans = LBPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
            if (count($modPermintaans) > 0) {
                foreach ($modPermintaans AS $i => $modPermintaan) {
                    $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
                    if (isset($modPemeriksaan->daftartindakan_id)) {
                        $modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
                        $rows .= $this->renderPartial("_rowPermintaanKePenunjang", array('i' => 0, 'modPermintaan' => $modPermintaan, 'penjamin_id' => $penjamin_id), true);
                    }
                }
            }
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pegawai ruangan
     */
    public function actionAutoCompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete PPDS
     */
    public function actionAutocompletePpds() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("ppds_aktif IS TRUE ");
            $criteria->order = 'ppds_nama';
            $criteria->limit = 5;
            $models = PpdsM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nim . " - " . $model->ppds_nama;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pemeriksaan Lab Mikro
     */
    public function actionAutocompletePemeriksaan() {
        if (Yii::app()->request->isAjaxRequest) {

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("ruangan_id = " . $_GET['ruangan_id']);
            $criteria->addCondition("penjamin_id = " . $_GET['penjamin_id']);
            $criteria->addCondition("kelaspelayanan_id = " . $_GET['kelaspelayanan_id']);
            if (isset($_GET['daftartindakan_id'])) {
                $criteria->addInCondition('daftartindakan_id', $_GET['daftartindakan_id']);
            }
            $criteria->order = 'pemeriksaanlab_nama';
            $criteria->limit = 5;
            $models = MKTarifpemeriksaanlabruanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->pemeriksaanlab_nama . " - " . $model->jenispemeriksaanlab_nama;
                $returnVal[$i]['value'] = $model->pemeriksaanlab_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Sample Lab
     */
    public function actionAutoCompleteSampleLab() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(samplelab_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("samplelab_aktif IS TRUE ");
            $criteria->order = 'samplelab_nama';
            $criteria->limit = 5;
            $models = SamplelabM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }

                if (!empty($model->kelompoksamplelab_id)) {
                    $modKel = KelompoksamplelabM::model()->findByPk($model->kelompoksamplelab_id);
                    $kelompoksamplelab_nama = $modKel->kelompoksamplelab_nama;
                } else {
                    $kelompoksamplelab_nama = "";
                }

                $returnVal[$i]['label'] = $model->samplelab_nama . " - " . $kelompoksamplelab_nama;
                $returnVal[$i]['value'] = $model->samplelab_id;
                $returnVal[$i]['kelompoksamplelab_nama'] = $kelompoksamplelab_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Tambah tindakan lain
     */
    public function actionAddTindakanPilihan() {
        if (Yii::app()->request->isAjaxRequest) {
            $pemeriksaanlab_id = isset($_POST['id']) ? $_POST['id'] : null;
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_MIKROBIOLOGI);
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

            $criteria = new CDbCriteria();
            $criteria->addInCondition('daftartindakan_id', $pemeriksaanlab_id);
            $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
            $criteria->addCondition('penjamin_id = ' . $penjamin_id);
            $criteria->addCondition('ruangan_id = ' . $ruangan_id);
            $modTarif = TarifpemeriksaanlabruanganV::model()->findAll($criteria);

            $id_tindakan = null;
            $paket = null;
            $str = "";

            if (count($modTarif) > 0) {
                foreach ($modTarif as $key => $value) {
                    $crPaket = new CDbCriteria();
                    $crPaket->compare('t.daftartindakan_id', $value->daftartindakan_id);
                    $crPaket->addCondition('t.tipepaket_id <> ' . Params::TIPEPAKET_ID_NONPAKET);
                    $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
                    $crPaket->addCondition('p.tindakanpelayanan_id is null');
                    $crPaket->order = 'p.tindakanpelayanan_id asc';

                    $tindakanPaket = TindakanpelayananT::model()->find($crPaket);

                    if (!empty($tindakanPaket)) {
                        $id_tindakan = $tindakanPaket->tindakanpelayanan_id;
                        $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
                    }

                    $str .= $this->renderPartial('_formLoadPemeriksaanLab', array('key' => $key, 'modTarif' => $value, 'id_tindakan' => $id_tindakan, 'paket' => $paket, 'permintaankepenunjang_id' => null), true);
                }
            }

            $data['row'] = $str;
            $data['ada'] = true;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Hapus permintaan penunjang
     */
    public function actionHapusPermintaanPenunjang() {
        if (Yii::app()->request->isAjaxRequest) {
            $permintaankepenunjang_id = isset($_POST['permintaankepenunjang_id']) ? $_POST['permintaankepenunjang_id'] : null;
            $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);

            try {
                if (!empty($modPermintaanKePenunjang->tindakanpelayanan_id)) {
                    $data['pesan'] = "Tindakan Sudah Dibayar, Tidak Dapat Dibatalkan";
                    $data['sukses'] = 0;
                } else {
                    if ($modPermintaanKePenunjang->delete()) {
                        $data['pesan'] = "Ok";
                        $data['sukses'] = 1;
                    } else {
                        $data['pesan'] = "Terjadi Kesalahan Data gagal dihapus";
                        $data['sukses'] = 0;
                    }
                }
            } catch (Exception $ex) {
                $data['pesan'] = "Terjadi Kesalahan Data gagal dihapus";
                $data['sukses'] = 0;
            }

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Hapus / batal spesimen
     */
    public function actionHapusSpesimen() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen_id = isset($_POST['spesimen_id']) ? $_POST['spesimen_id'] : null;
            $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);

            try {
                if ($modSpesimen->delete()) {
                    $data['pesan'] = "Ok";
                    $data['sukses'] = 1;
                } else {
                    $data['pesan'] = "Terjadi Kesalahan Data gagal dihapus";
                    $data['sukses'] = 0;
                }
            } catch (Exception $ex) {
                $data['pesan'] = "Terjadi Kesalahan Data gagal dihapus";
                $data['sukses'] = 0;
            }

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Set tabel pemeriksaan spesimen
     */
    public function actionSetTabelPemeriksaanSpesimen() {
        if (Yii::app()->request->isAjaxRequest) {
            $is_pilih_pemeriksaan = isset($_POST['is_pilih_pemeriksaan']) ? $_POST['is_pilih_pemeriksaan'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
            $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;

            $jenispemeriksaanlab = array();
            $cekKelompok = JenispemeriksaanlabM::model()->findAllByAttributes(array('jenispemeriksaanlab_kelompok' => 'MIKROBIOLOGI KLINIK'));
            foreach ($cekKelompok as $value):
                $jenispemeriksaanlab[] = $value->jenispemeriksaanlab_id;
            endforeach;


            $criteria = new CDbCriteria();
            $criteria->select = 'pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_nama';
            $criteria->addInCondition('jenispemeriksaanlab_id', $jenispemeriksaanlab);
//            $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
//            $criteria->addCondition('penjamin_id = ' . $penjamin_id);
//            $criteria->addCondition('ruangan_id = ' . $ruangan_id);
            $criteria->group = 'pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_nama';
            $criteria->order = 'jenispemeriksaanlab_nama ASC';
            $modTarif = TariftindakanlaboratoriumV::model()->findAll($criteria);

            $tr = "";
            if (count($modTarif)) {
                foreach ($modTarif as $key => $value) {
                    $tr .= "
                        <tr>
                            <td>" . CHtml::Link("<i class='icon-form-check'></i>", "#", array(
                                "class" => "btn-small",
                                "id" => "selectSample",
                                "onClick" => " 
                                        setTindakanSpesimen('$value->pemeriksaanlab_id','$value->pemeriksaanlab_nama');
                                        $('#dialogTindakanSpesimen').dialog('close');return false;"
                                    )
                            ) . "</td>
                            <td>" . $value->jenispemeriksaanlab_nama . "</td>
                            <td>" . $value->pemeriksaanlab_nama . "</td>
                        </tr>
                    ";
                }
            }

            $data['tr'] = $tr;
            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk Print Barcode
     * @param type $spesimen_id
     * @param type $pasienkirimkeunitlain_id
     */
    public function actionPrintBarcodeSample($spesimen_id, $pasienkirimkeunitlain_id) {
        $this->layout = '//layouts/printWindows';
        $judulLaporan = "";

        $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);
        $modKunjungan = MKPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));


        $this->render('printBarcodeSample', array(
            'modKunjungan' => $modKunjungan,
            'modSpesimen' => $modSpesimen,
            'judulLaporan' => $judulLaporan,
        ));
    }

    /**
     * Cetak QR Code Spesimen
     * @param type $spesimen_id
     * @param type $pasienkirimkeunitlain_id
     */
    public function actionPrintQrSample($spesimen_id, $pasienkirimkeunitlain_id) {
        $this->layout = '//layouts/printWindows';
        $judulLaporan = "";
        $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);
        $modKunjungan = MKPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));


        $this->render('printQrSample', array(
            'modKunjungan' => $modKunjungan,
            'modSpesimen' => $modSpesimen,
            'judulLaporan' => $judulLaporan,
        ));
    }

    /**
     * Mendapatkan data detail
     */
    public function actionSetDetail() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $data['form'] = "";
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $penjamin_id = $_POST['penjamin_id'];
            $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
            $modSpesimen = new MKSpesimenT;
            $dataSpesimen = array();

            $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));

            if (!empty($modPenilaian->penilaian_kelayakan_spesimen_id)) {
                $modPenilaian->manajerpelayanan_nama = !empty($modPenilaian->manajerpelayanan_id) ? PegawaiM::model()->findByPk($modPenilaian->manajerpelayanan_id)->namaLengkap : "";
                $modPenilaian->dpjtm_nama = !empty($modPenilaian->dpjtm_id) ? PegawaiM::model()->findByPk($modPenilaian->dpjtm_id)->namaLengkap : "";
                $modPenilaian->ppds_nama = !empty($modPenilaian->ppds_id) ? PpdsM::model()->findByPk($modPenilaian->ppds_id)->ppds_nama : "";
                $dataSpesimen = MKSpesimenT::model()->findAllByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));
            } else {
                $modPenilaian = new MKPenialianKelayakanSpesimenT;
            }

            $cek = PermintaankepenunjangT::model()->findAllbyAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            if (count($dataSpesimen) > 0) {
                $cek = $dataSpesimen;
            }
            $a = 0;
            foreach ($cek AS $key => $value) {
                $modSpesimen->attributes = $value->attributes;
                $modSpesimen->spesimen_id = isset($value->spesimen_id) ? $value->spesimen_id : null;
                if (empty($modSpesimen->spesimen_id)) {
                    $modTarif = TariftindakanlaboratoriumV::model()->findByAttributes(array(
                        'daftartindakan_id' => $value['daftartindakan_id'],
                        'penjamin_id' => $penjamin_id,
                        'pemeriksaanlab_id' => $value['pemeriksaanlab_id']
                    ));
                    $modSpesimen->daftartindakan_id = $modTarif->daftartindakan_id;
                    $modSpesimen->tarif_pelayananan = $modTarif->harga_tariftindakan;
                    $modSpesimen->permintaankepenunjang_id = $value['permintaankepenunjang_id'];
                } else {
                    $modPermintaan = PermintaankepenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pemeriksaanlab_id' => $value['pemeriksaanlab_id']));
                    $modSpesimen->permintaankepenunjang_id = $modPermintaan['permintaankepenunjang_id'];
                }
                $dataKirimSpesimen = KirimspesimenlabT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                if (!empty($dataKirimSpesimen->samplelab_id)) {
                    $modSampleLab = SamplelabM::model()->findByPk($dataKirimSpesimen->samplelab_id);
                    $modSpesimen->samplelab_id = $modSampleLab->samplelab_id;
                    $modSpesimen->samplelab_nama = $modSampleLab->samplelab_nama;
                }
                if (!empty($value->pemeriksaanlab_id)) {
                    $modPeriksaLab = PemeriksaanlabM::model()->findByPk($value->pemeriksaanlab_id);
                    $modSpesimen->pemeriksaanlab_id = $modPeriksaLab->pemeriksaanlab_id;
                    $modSpesimen->pemeriksaanlab_nama = $modPeriksaLab->pemeriksaanlab_nama;
                }
                $modSpesimen->status = 'Biasa';
                $data['form'] .= $this->renderPartial($this->path_view_spesimen . '_tabelSpesimenDetail', array('modSpesimen' => $modSpesimen, 'i' => $a, 'minus' => false), true);
                $a++;
            }
            $data['message'] = 'sukses';

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Hapus data berdasarkan spesimen_id dan permintaankepenunjang_id
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $spesimen_id = $_POST['spesimen_id'];
            $permintaankepenunjang_id = $_POST['permintaankepenunjang_id'];
            $data['sukses'] = 0;
            $sukses = true;
            $data['pesan'] = "Data gagal dihapus!";
            try {
                if (!empty($spesimen_id)) {
                    $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);
                    if ($modSpesimen->delete()) {
                        $sukses = true;
                    } else {
                        $sukses = false;
                    }
                }

                if (!empty($permintaankepenunjang_id)) {
                    $modPermintaan = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
                    if ($modPermintaan->delete()) {
                        $sukses2 = true;
                    } else {
                        $sukses2 = false;
                    }
                }

                if ($sukses2 == true && $sukses == true) {
                    $data['pesan'] = 'Data Berhasil Dihapus';
                    $data['sukses'] = 1;
                } else {
                    $data['pesan'] = 'Data Gagal Dihapus';
                    $data['sukses'] = 0;
                }
            } catch (Exception $exc) {
                $data['sukses'] = 0;
                $data['pesan'] = "Data gagal dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}
