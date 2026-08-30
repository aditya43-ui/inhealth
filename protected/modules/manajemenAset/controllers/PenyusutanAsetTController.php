<?php

class PenyusutanAsetTController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $penyusutan = false;
    public $penyusutanDetail = true;
    public $penjurnalan = false;
    public $penjurnalanDetail = true;
    public $path_view = "manajemenAset.views.penyusutanAsetT.";

    public function actionIndex() {
        $format = new MyFormatter;
        $model = new MAPenyusutanasetT('search');
        $model->unsetAttributes();  // clear any default values
        $model->tgl_penyusutan = $format->formatDateTimeForUser(date("Y-m-d"), strtotime($model->tgl_penyusutan));
        $model->no_penyusutan = '-- Otomatis --';
        if (isset($_POST['MAPenyusutanasetT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // insert ke penyusutanaset_t & penyusutanasetdetail_t
                $model->attributes = $_POST['MAPenyusutanasetT'];
                $model->tgl_penyusutan = $format->formatDateTimeForDb($_POST['MAPenyusutanasetT']['tgl_penyusutan']);
                $model->no_penyusutan = MyGenerator::noPenyusutanAset();
                $model->barang_id = $_POST['barang_id'];
                $model->create_time = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                if ($_POST['nama_inv'] == "Gedung") {
                    $model->invgedung_id = $_POST['inv_id'];
                } else if ($_POST['nama_inv'] == "Jalan") {
                    $model->invjalan_id = $_POST['inv_id'];
                } else if ($_POST['nama_inv'] == "Peralatan") {
                    $model->invperalatan_id = $_POST['inv_id'];
                } else if ($_POST['nama_inv'] == "Tanah") {
                    $model->invtanah_id = $_POST['inv_id'];
                } else {
                    $model->invasetlain_id = $_POST['inv_id'];
                }

                if ($model->validate()) {
                    $ok &= $model->save();
                }

                if (isset($_POST['MAPenyusutanasetdetailT'])) {
                    if (count($_POST['MAPenyusutanasetdetailT']) > 0) {
                        foreach ($_POST['MAPenyusutanasetdetailT'] as $i => $postDetail) {
                            $modDetail = new MAPenyusutanasetdetailT;
                            $modDetail->attributes = $postDetail;
                            $modDetail->penyusutanaset_id = $model->penyusutanaset_id;
                        }
                        if ($modDetail->validate()) {
                            $ok &= $modDetail->save();
                        }
                    }
                }


                // end insert penyusutanaset_t & penyusutanasetdetail_t
                // header jurnal
                if ($ok) {
                    $modJurnalRekening = new MAJurnalrekeningT;
                    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENYUSUTAN;
                    
                    $modRek = RekperiodM::model()->findByAttributes(array('isclosing' => false),array('order' => 'rekperiod_id desc'));
//                    $modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
                    $modJurnalRekening->rekperiod_id = $modRek->rekperiod_id;

                    $modJurnalRekening->tglbuktijurnal = $model->tgl_penyusutan;
                    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
                    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
                    $modJurnalRekening->noreferensi = 0;
                    $modJurnalRekening->tglreferensi = $model->tgl_penyusutan;
                    $modJurnalRekening->nobku = "";
                    $modJurnalRekening->urianjurnal = "Penyusutan Jurnal";
                    $modJurnalRekening->create_time = $model->tgl_penyusutan;
                    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
                    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');


                    $ok &= $modJurnalRekening->save();

                    if ($ok) {
                        if (isset($_POST['RekeningakuntansiV'])) {
                            if (count($_POST['RekeningakuntansiV']) > 0) {
                                foreach ($_POST['RekeningakuntansiV'] as $x => $jurnalDetail) {
                                    $modJurnalDet = new MAJurnaldetailT;
                                    $modJurnalDet->attributes = $jurnalDetail;
                                    $modJurnalDet->rekperiod_id = $modJurnalRekening->rekperiod_id;
                                    $modJurnalDet->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
                                    $modJurnalDet->uraiantransaksi = isset($jurnalDetail['nama_rekening']) ? $jurnalDetail['nama_rekening'] : "";
                                    $modJurnalDet->saldodebit = isset($jurnalDetail['saldodebit']) ? (int) $jurnalDetail['saldodebit'] : 0;
                                    $modJurnalDet->saldokredit = isset($jurnalDetail['saldokredit']) ? (int) $jurnalDetail['saldokredit'] : 0;
                                    $modJurnalDet->nourut = $x + 1;
                                    $modJurnalDet->rekening5_id = isset($jurnalDetail['rekening5_id']) ? $jurnalDetail['rekening5_id'] : null;
                                    $modJurnalDet->catatan = "";
                                }

                                if ($modJurnalDet->validate()) {
                                    $ok &= $modJurnalDet->save();
                                }
                            }
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    $this->redirect(array('index', 'penyusutanaset_id' => $model->penyusutanaset_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /*
     * untuk mencari barang melalui autocomplete
     */

    public function actionAutocompleteBarang() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('barang_statusregister IS true');
            $criteria->compare('LOWER(barang_type)', strtolower(Params::TYPE_BARANG_ASET), true);
            $criteria->limit = 5;

            $models = MABarangV::model()->findAll($criteria);
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

    public function actionSetAutoLoad() {
        if (Yii::app()->request->isAjaxRequest) {
            $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
            $pesan = "";
            $kodeInventarisasi = "";
            $tglguna = "";
            $noRegister = "";
            $umurEkonomis = "";
            $inv_id = "";
            $nama_inv = "";
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $criteria->addCondition('barang_id =' . $barang_id);
            $criteria->addCondition('barang_statusregister IS true');
            $criteria->order = 't.barang_id';
            $modBarang = MABarangV::model()->find($criteria);
            if ($modBarang) {
                $kodeInventarisasi = $modBarang->barang_kode; // kode inventarisasi hanya diambil dari barang saja.
                if (!empty($modBarang->invgedung_noregister)) {
//					$kodeInventarisasi = $modBarang->invgedung_kode;
                    $tglguna = $format->formatDateTimeForUser($modBarang->invgedung_tglguna);
                    $noRegister = $modBarang->invgedung_noregister;
                    $umurEkonomis = "";
                    $inv_id = $modBarang->invgedung_id;
                    $nama_inv = "Gedung";
                } else if (!empty($modBarang->invjalan_noregister)) {
//					$kodeInventarisasi = $modBarang->invjalan_kode; 
                    $tglguna = $format->formatDateTimeForUser($modBarang->invjalan_tglguna);
                    $noRegister = $modBarang->invjalan_noregister;
                    $umurEkonomis = "";
                    $inv_id = $modBarang->invjalan_id;
                    $nama_inv = "Jalan";
                } else if (!empty($modBarang->invperalatan_noregister)) {
//					$kodeInventarisasi = $modBarang->invperalatan_kode; 
                    $tglguna = $format->formatDateTimeForUser($modBarang->invperalatan_tglguna);
                    $noRegister = $modBarang->invperalatan_noregister;
                    $umurEkonomis = $umurEkonomis = $modBarang->invperalatan_umurekonomis;
                    $inv_id = $modBarang->invperalatan_id;
                    $nama_inv = "Peralatan";
                } else if (!empty($modBarang->invtanah_noregister)) {
//					$kodeInventarisasi = $modBarang->invtanah_kode; 
                    $tglguna = $format->formatDateTimeForUser($modBarang->invtanah_tglguna);
                    $noRegister = $modBarang->invtanah_noregister;
                    $umurEkonomis = $modBarang->invtanah_umurekonomis;
                    $inv_id = $modBarang->invtanah_id;
                    $nama_inv = "Tanah";
                } else if (!empty($modBarang->invasetlain_noregister)) {
//					$kodeInventarisasi = $modBarang->invasetlain_kode; 
                    $tglguna = $format->formatDateTimeForUser($modBarang->invasetlain_tglguna);
                    $noRegister = $modBarang->invasetlain_noregister;
                    $umurEkonomis = "";
                    $inv_id = $modBarang->invasetlain_id;
                    $nama_inv = "AsetLain";
                }
            } else {
                $pesan = "Data Tidak Ada!";
            }
            echo CJSON::encode(array(
                'kodeInventarisasi' => $kodeInventarisasi,
                'tglguna' => $tglguna,
                'noRegister' => $noRegister,
                'umurEkonomis' => !empty($umurEkonomis) ? $umurEkonomis : 1,
                'inv_id' => $inv_id,
                'nama_inv' => $nama_inv,
                'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionLoadDetailPenyutusan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $model = new MAPenyusutanasetT;
            $modDetail = new MAPenyusutanasetdetailT;
            $nilai_residu = $format->formatNumberForDb($_POST['residu']);
            $hargaPerolehan = $format->formatNumberForDb($_POST['hargaPerolehan']);
            $tgl_guna = $format->formatDateTimeForDb($_POST['tglguna']);
            $umur_ekonomis = $format->formatNumberForDb($_POST['umurEkonomis']);
            $total_bulan = $umur_ekonomis * 12;
            $saldo_penyusutan = ($hargaPerolehan - $nilai_residu) / $umur_ekonomis;
            $total_penyusutan = $total_bulan * $saldo_penyusutan;
            echo CJSON::encode(array(
                'form' => $this->renderPartial($this->path_view . '_detailPenyusutanAset', array(
                    'format' => $format,
                    'modDetail' => $modDetail,
                    'tgl_guna' => $tgl_guna,
                    'total_bulan' => $total_bulan,
                    'umur_ekonomis' => $umur_ekonomis,
                    'saldo_penyusutan' => $saldo_penyusutan,
                        ), true),
                'foot' => $this->renderPartial($this->path_view . '_tfoot', array(
                    'format' => $format,
                    'model' => $model,
                    'total_penyusutan' => $total_penyusutan,
                        ), true),
                    )
            );
            exit;
        }
    }

    // fungsi untuk penjurnalan di transaksi penyusutan aset
    public function actionAmbilDataRekening() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
            $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
            $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
            $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
            $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;

            $criteria = new CDbCriteria;
            if (!empty($rekening5_id)) {
                $criteria->addCondition("rekening5_id = " . $rekening5_id);
            }
            if (!empty($rekening4_id)) {
                $criteria->addCondition("rekening4_id = " . $rekening4_id);
            }
            if (!empty($rekening3_id)) {
                $criteria->addCondition("rekening3_id = " . $rekening3_id);
            }
            if (!empty($rekening2_id)) {
                $criteria->addCondition("rekening2_id = " . $rekening2_id);
            }
            if (!empty($rekening1_id)) {
                $criteria->addCondition("rekening1_id = " . $rekening1_id);
            }

            $model = MARekeningakuntansiV::model()->findAll($criteria);
            if ($model) {
                echo CJSON::encode(
                        $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'status' => $status), true)
                );
            }
            Yii::app()->end();
        }
    }

    /*
     * Digunakan di Manajemen Aset - Transaksi penyusutan aset
     * Penjurnalan (autocomplete rekening debit & kredit)
     */

    public function actionAutocompleteRekeningAkuntansi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));

            $condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
            if (isset($_GET['id_jenis_rek'])) {
                $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D')";
                if ($_GET['id_jenis_rek'] == 'Kredit') {
                    $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K')";
                }
            }

            $criteria->addCondition($condition);
            $criteria->limit = 5;

            $models = RekeningakuntansiV::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                if (isset($model->rekening5_id)) {
                    $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
                    $nama_rekening = $model->nmrekening5;
                } else {
                    if (isset($model->obyek_id)) {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
                        $nama_rekening = $model->nmrekening4;
                    } else {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
                        $nama_rekening = $model->nmrekening3;
                    }
                }
                $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
                $returnVal[$i]['value'] = $nama_rekening;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
