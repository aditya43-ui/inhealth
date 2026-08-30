
<?php

class RencanaKebBarangController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.rencanaKebBarang.';
    public $rencanakebutuhantersimpan = true;

    public function actionIndex($renkebbarang_id = null, $linkHalaman = null) {
        $format = new MyFormatter();
        $modRencanaKebBarang = new ADRenkebbarangT;
        $modRencanaKebBarang->renkebbarang_tgl = date('Y-m-d H:i:s');
        $modRencanaKebBarang->renkebbarang_no = '-Otomatis-';
        $mengetahui = Yii::app()->user->getState('pegawai_id');

        $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
        if (isset($modApprovalotorisasiM)) {
            $menyetujui = $modApprovalotorisasiM->kepalaumum_id;
        }

        if (!empty($mengetahui)) {
            $data = GUPegawaiM::model()->findByPk($mengetahui);
            $modRencanaKebBarang->pegmengetahui_id = $data->pegawai_id;
            $modRencanaKebBarang->pegmengetahui_nama = $data->namaLengkap;
        }

        if (!empty($menyetujui)) {
            $data = GUPegawaiM::model()->findByPk($menyetujui);
            $modRencanaKebBarang->pegmenyetujui_id = $data->pegawai_id;
            $modRencanaKebBarang->pegmenyetujui_nama = $data->namaLengkap;
        }

        $modDetails = array();
        if (!empty($renkebbarang_id)) {
            $modRencanaKebBarang = ADRenkebbarangT::model()->findByPk($renkebbarang_id);
            $modRencanaKebBarang->pegmengetahui_nama = !empty($modRencanaKebBarang->pegmengetahui_id) ? $modRencanaKebBarang->pegawaimengetahui->namaLengkap : "";
            $modRencanaKebBarang->pegmenyetujui_nama = !empty($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->namaLengkap : "";

            $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id' => $modRencanaKebBarang->renkebbarang_id));
            foreach ($modDetails as $dataDtl) {
                $dataDtl->harga_barang = $dataDtl->harga_barangdet;
            }
        }

        if (isset($_GET['ubah'])) {
            if (isset($modApprovalotorisasiM)) {
                $menyetujui = $modApprovalotorisasiM->kepalaumum_id;
            }
            if (!empty($menyetujui)) {
                $data = GUPegawaiM::model()->findByPk($menyetujui);
                $modRencanaKebBarang->pegmenyetujui_id = $data->pegawai_id;
                $modRencanaKebBarang->pegmenyetujui_nama = $data->namaLengkap;
            }
        }


        if (isset($_POST['ADRenkebbarangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRencanaKebBarang->attributes = $_POST['ADRenkebbarangT'];

                $pegawai = Yii::app()->user->getState('pegawai_id');
                if (empty($pegawai))
                    $pegawai = '0';
                $modRencanaKebBarang->renkebbarang_no = MyGenerator::noPerencanaanKebutuhanBarang();
                $modRencanaKebBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modRencanaKebBarang->pegawai_id = $pegawai;
                $modRencanaKebBarang->renkebbarang_tgl = $format->formatDateTimeForDb($_POST['ADRenkebbarangT']['renkebbarang_tgl']);
                $modRencanaKebBarang->ro_barang_bulan = $_POST['ADRenkebbarangT']['ro_barang_bulan'];
                if (isset($_GET['ubah'])) {
                    $modRencanaKebBarang->update_time = date('Y-m-d H:i:s');
                    $modRencanaKebBarang->update_loginpemekai_id = Yii::app()->user->id;
                } else {
                    $modRencanaKebBarang->create_time = date('Y-m-d H:i:s');
                    $modRencanaKebBarang->create_loginpemekai_id = Yii::app()->user->id;
                    $modRencanaKebBarang->create_ruangan = Yii::app()->user->ruangan_id;
                }

                if ($modRencanaKebBarang->save()) {
                    $this->rencanakebutuhantersimpan = true;
                    if (isset($_GET['ubah'])) {
                        $modRencanaDetailKeb = ADRenkebbarangdetT::model()->deleteAllByAttributes(array('renkebbarang_id' => $modRencanaKebBarang->renkebbarang_id));
                    }
                    if (count((array)$_POST['ADRenkebbarangdetT']) > 0) {
                        foreach ($_POST['ADRenkebbarangdetT'] AS $i => $post) {
                            $modDetails[$i] = $this->simpanRencanaKebutuhan($modRencanaKebBarang, $post);
                        }
                    } else {
                        $this->rencanakebutuhantersimpan = false;
                    }
                }

                $this->insertNotifRencana($modRencanaKebBarang);

                if ($this->rencanakebutuhantersimpan) {
                    $transaction->commit();
                    $modRencanaKebBarang->isNewRecord = FALSE;
                    $this->redirect(array('index', 'renkebbarang_id' => $modRencanaKebBarang->renkebbarang_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'modRencanaKebBarang' => $modRencanaKebBarang,
            'modDetails' => $modDetails,
        ));
    }

    public function insertNotifRencana($model) {

        $ruangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_PURCHASING);
        // $asal = RuanganM::model()->findByPk($model->ruanganasal_id);
        $judul = 'Rencana Kebutuhan Barang';

        $isi = "Tgl. Rencana : ".MyFormatter::formatDateTimeForUser($model->renkebbarang_tgl)."<br/>";
        $isi = "No. Rencana : ".$model->renkebbarang_no."<br/>";

        $link = "";

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => Params::MODUL_ID_GUDANGUMUM),
                    array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => Params::MODUL_ID_GUDANGFARMASI),
                    // array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
                        // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));

        //var_dump($ok); die;
    }

    public function simpanRencanaKebutuhan($modRencanaKebBarang, $post) {
        $format = new MyFormatter();
        // var_dump($post);

        $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
        $modRencanaDetailKebBarang->attributes = $post;
        $modRencanaDetailKebBarang->barang_id = $post['barang_id'];
        $modRencanaDetailKebBarang->renkebbarang_id = $modRencanaKebBarang->renkebbarang_id; //fake id
        $modRencanaDetailKebBarang->satuanbarangdet = !empty($post['satuanbarangdet']) ? $post['satuanbarangdet'] : "-";
        $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $post['jmlpermintaanbarangdet'];
        ;
        $modRencanaDetailKebBarang->harga_barangdet = $post['harga_barang'];
        $modRencanaDetailKebBarang->stokakhir_barangdet = 0;
        //$modRencanaDetailKebBarang->minstok_barangdet = 0;
        //$modRencanaDetailKebBarang->makstok_barangdet = 0;
        //$modRencanaDetailKeb->hargatotalrenc = $modRencanaDetailKeb->jmlpermintaan * $modRencanaDetailKeb->harganettorenc;
        if ($modRencanaDetailKebBarang->validate()) {
            $modRencanaDetailKebBarang->save();
        } else {
            $this->rencanakebutuhantersimpan &= false;
        }
        return $modRencanaDetailKebBarang;
    }

    public function actionLoadFormRencanaKebutuhan() {
        if (Yii::app()->request->isAjaxRequest) {
            $barang_id = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];

            //$format = new MyFormatter();
            $modRencanaKebBarang = new ADRenkebbarangT;
            $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
            $modBarang = ADBarangM::model()->findByPk($barang_id);
            $modRencanaDetailKebBarang->harga_barang = $modBarang->barang_harganetto;
            $modRencanaDetailKebBarang->barang_id = $modBarang->barang_id;

            $modRencanaDetailKebBarang->minstok_barangdet = (!empty($modBarang->minimalstok)? $modBarang->minimalstok:0);
            $modRencanaDetailKebBarang->makstok_barangdet = (!empty($modBarang->maksimalstok)? $modBarang->maksimalstok:0);
            $modRencanaDetailKebBarang->stokakhir_barangdet = InventarisasiruanganT::tampilStok($barang_id);
            $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;
            $modRencanaDetailKebBarang->barang_nama = $modBarang->barang_nama;
            $modRencanaDetailKebBarang->satuanbarangdet = $modBarang->barang_satuan;
            $modRencanaDetailKebBarang->persen_ppn = (!empty($modBarang->ppn_persen)?$modBarang->ppn_persen:0);

            echo CJSON::encode(array(
                'status' => 'create_form',
                'form' => $this->renderPartial($this->path_view . '_rowBarangRencanaKebutuhan', array(
                    'modRencanaKebBarang' => $modRencanaKebBarang,
                    'modRencanaDetailKebBarang' => $modRencanaDetailKebBarang,
                        ),
                        true))
            );
            exit;
        }
    }

    public function actionAutocompletePegawaiMengetahui() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutocompletePegawaiMenyetujui() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * untuk menampilkan barang dari autocomplete
     */
    public function actionAutoCompleteBarang() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(barang_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('inventarisasi_stok <= minimalstok');
            $criteria->order = 'barang_nama';

            $models = GUInformasistokbarangV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->barang_nama;
                $returnVal[$i]['value'] = $model->barang_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Mencetak data rencana kebutuhan barang
     * @param $renkebbarang
     */
    public function actionPrint($renkebbarang_id, $caraprint = null) {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        } else if ($caraprint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }
        $format = new MyFormatter;
        $modRencanaKebBarang = ADRenkebbarangT::model()->findByPk($renkebbarang_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('renkebbarang_id = ' . $renkebbarang_id);
        $modRencanaKebBarangDetail = ADRenkebbarangdetT::model()->findAll($criteria);

        $judul_print = 'Rencana Kebutuhan Barang';

        $this->render($this->path_view . 'Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modRencanaKebBarang' => $modRencanaKebBarang,
            'modRencanaKebBarangDetail' => $modRencanaKebBarangDetail,
            'caraprint' => $caraprint
        ));
    }

    public function actionSetHitungRO() {
        if (Yii::app()->request->isAjaxRequest) {
            $form = '';
            $pesan = '';

            $ruangan_id = Params::RUANGAN_ID_GUDANG_UMUM;
            $jumlah = 0;
            $lt = 0.5;
            $t = isset($_POST['ro_barang_bulan']) ? $_POST['ro_barang_bulan'] : null;
            $tgl_sekarang = date('Y-m-d');
            $tgl_ro = date("Y-m-d", strtotime("-" . $t . " months"));
            $modRencanaDetailKebBarang = new ADRenkebbarangdetT;

            $modBarang = ADBarangM::model()->findAll();
            if (count((array)$modBarang) > 0) {
                foreach ($modBarang as $i => $barang) {
                    $minimal_stok = isset($barang->barang_min) ? $barang->barang_min : 0;
                    $maksimal_stok = isset($barang->barang_max) ? $barang->barang_max : 0;
                    $criteria = new CDbCriteria();

                    $criteria->select = 'barang_id,sum(inventarisasi_qty_skrg) as inventarisasi_qty_skrg';
                    $criteria->addCondition('barang_id = ' . $barang->barang_id);
                    $criteria->addCondition('ruangan_id = ' . $ruangan_id);
                    $criteria->group = 'barang_id';
                    $criteria->order = 'inventarisasi_qty_skrg,barang_id ASC';
                    $stok_barang = ADInventarisasiruanganT::model()->find($criteria);

                    if (!empty($stok_barang)) {
                        if ($stok_barang->inventarisasi_qty_skrg <= $minimal_stok) {
                            $criteria2 = new CDbCriteria();

                            $criteria2->select = 'barang_id,sum(inventarisasi_qty_out) as inventarisasi_qty_out';
                            $criteria2->addBetweenCondition('DATE(tgltransaksi)', $tgl_ro, $tgl_sekarang);
                            $criteria2->addCondition('barang_id = ' . $barang->barang_id);
                            $criteria2->addCondition('ruangan_id = ' . $ruangan_id);
                            $criteria2->group = 'barang_id';
                            $criteria->order = 'inventarisasi_qty_out,barang_id ASC';
                            $jumlah_barang_keluar = ADInventarisasiruanganT::model()->find($criteria2);

                            if (!empty($jumlah_barang_keluar)) {
                                if ($jumlah_barang_keluar->inventarisasi_qty_out >= $maksimal_stok) {
                                    $selisih_stok = $maksimal_stok - $stok_barang->inventarisasi_qty_skrg;
                                    $jumlah = $selisih_stok;
                                    $modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                                    $modRencanaDetailKebBarang->barang_id = $barang->barang_id;
                                    $modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                                    $modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                                    $modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                                    $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;
                                    $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                                    $modRencanaDetailKebBarang->satuanbarangdet = $barang->barang_satuan;
                                } else {
                                    $jumlah = $jumlah_barang_keluar->inventarisasi_qty_out;
                                    $modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                                    $modRencanaDetailKebBarang->barang_id = $barang->barang_id;
                                    $modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                                    $modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                                    $modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                                    $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;
                                    $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                                    $modRencanaDetailKebBarang->satuanbarangdet = $barang->barang_satuan;
                                }
                            } else {
                                //$modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                                $modRencanaDetailKebBarang->barang_id = $barang->barang_id;
                                //$modRencanaDetailKebBarang->asal_barang = $barang->barang_nama;
                                //$modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                                //$modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                                //$modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                                //$modRencanaDetailKebBarang->jmlpermintaanbarangdet = 0;
                                $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                                $modRencanaDetailKebBarang->satuanbarangdet = $barang->barang_satuan;
                            }
                            $form .= $this->renderPartial($this->path_view . '_rowBarangRencanaKebutuhan', array('modRencanaDetailKebBarang' => $modRencanaDetailKebBarang), true);
                        }
                    }
                }
            } else {
                $pesan = 'Data Barang tidak ditemukan.';
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'lead_time' => $lt));
        }
        Yii::app()->end();
    }

}
