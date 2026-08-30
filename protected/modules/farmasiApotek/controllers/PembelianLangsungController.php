<?php

class PembelianLangsungController extends MyAuthController {

    public $penerimaanbarangberhasiltersimpan = true;
    public $penerimaanbarangdetailtersimpan = true;
    public $stokobatalkestersimpan = true;

    public function actionIndex($penerimaanbarang_id = null, $permintaanpembelian_id = null) {
        $format = new MyFormatter();
        $modPenerimaanBarang = new FAPenerimaanbarangT;
        $modPermintaanPembelian = new FAPermintaanpembelianT;
        $modFakturPembelian = new FAFakturpembelianT;
        $modPenerimaanBarang->tglterima = date('Y-m-d H:i:s');
        $modPenerimaanBarang->tglsuratjalan = date('Y-m-d H:i:s');
        $modPenerimaanBarang->tglkadaluarsa = date('Y-m-d H:i:s');
        $modFakturPembelian->biayamaterai = 0;
        $modFakturPembelian->tglfaktur = date('Y-m-d H:i:s');
        $modFakturPembelian->tgljatuhtempo = date('Y-m-d H:i:s');
        $modDetails = array();

        if (!empty($penerimaanbarang_id)) {
            $modPenerimaanBarang = FAPenerimaanbarangT::model()->findByPk($penerimaanbarang_id);
            $modPenerimaanBarang->pegawaimengetahui_nama = !empty($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "";
            $modPenerimaanBarang->pegawaimenyetujui_nama = !empty($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "";

            $modDetails = FAPenerimaandetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $modPenerimaanBarang->penerimaanbarang_id));
        }

        if (isset($_POST['FAPenerimaanbarangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPenerimaanBarang->attributes = $_POST['FAPenerimaanbarangT'];
                $modPenerimaanBarang->noterima = MyGenerator::noTerimaBarang();
                $modPenerimaanBarang->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $modPenerimaanBarang->tglterima = $format->formatDateTimeForDb($_POST['FAPenerimaanbarangT']['tglterima']);
                $modPenerimaanBarang->tglsuratjalan = $format->formatDateTimeForDb($_POST['FAPenerimaanbarangT']['tglsuratjalan']);
                $modPenerimaanBarang->create_time = date('Y-m-d H:i:s');
                $modPenerimaanBarang->update_time = date('Y-m-d H:i:s');
                $modPenerimaanBarang->create_loginpemakai_id = Yii::app()->user->id;
                $modPenerimaanBarang->update_loginpemakai_id = Yii::app()->user->id;
                $modPenerimaanBarang->create_ruangan = Yii::app()->user->ruangan_id;
                $modPenerimaanBarang->pembelianlangsung = true;
                if ($modPenerimaanBarang->save()) {
                    if (count($_POST['FAPenerimaandetailT']) > 0) {
                        foreach ($_POST['FAPenerimaandetailT'] AS $i => $postOa) {
                            $modDetails[$i] = $this->simpanPenerimaanBarangDetail($modPenerimaanBarang, $postOa);
                            $this->simpanStokObatAlkes($modDetails[$i], $postOa, $modPenerimaanBarang);
                        }
                    }
                } else {
                    $this->penerimaanbarangberhasiltersimpan = false;
                }
                if ($this->penerimaanbarangberhasiltersimpan && $this->penerimaanbarangdetailtersimpan && $this->stokobatalkestersimpan) {
                    $transaction->commit();
                    $modPenerimaanBarang->isNewRecord = FALSE;
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                    $this->redirect(array('index', 'penerimaanbarang_id' => $modPenerimaanBarang->penerimaanbarang_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Pembelian gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Penerimaan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('index', array(
            'format' => $format,
            'modPenerimaanBarang' => $modPenerimaanBarang,
            'modPermintaanPembelian' => $modPermintaanPembelian,
            'modFakturPembelian' => $modFakturPembelian,
            'modDetails' => $modDetails,
        ));
    }

    public function actionLoadFormPenerimaanBarang() {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $tgl_kadaluarsa = $_POST['tgl_kadaluarsa'];

            $format = new MyFormatter();
            $modPenerimaanBarang = new FAPenerimaanbarangT();
            $modPenerimaanBarangDetail = new FAPenerimaandetailT;
            $modObatAlkes = FAObatalkesM::model()->findByPk($obatalkes_id);
            $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
            $modPenerimaanBarangDetail->jmlpermintaan = $jumlah;
            $modPenerimaanBarangDetail->jmlterima = $jumlah;
            $modPenerimaanBarangDetail->harganettoper = $modObatAlkes->harganetto;
            $modPenerimaanBarangDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
            $modPenerimaanBarangDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
            $modPenerimaanBarangDetail->persenppn = 0;
            $modPenerimaanBarangDetail->persenpph = 0;
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForUser($tgl_kadaluarsa) : null);
            $modPenerimaanBarangDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
            $modPenerimaanBarangDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
            $modPenerimaanBarangDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForDb($tgl_kadaluarsa) : "");
            $modPenerimaanBarangDetail->nobatch = $modObatAlkes->nobatch;

            echo CJSON::encode(array(
                'status' => 'create_form',
                'form' => $this->renderPartial('_rowObatPenerimaanBarang', array(
                    'modPenerimaanBarang' => $modPenerimaanBarang,
                    'modPenerimaanBarangDetail' => $modPenerimaanBarangDetail,
                    'format' => $format
                        ), true))
            );
            exit;
        }
    }

    public function simpanPenerimaanBarangDetail($modPenerimaanBarang, $post) {

        $format = new MyFormatter();
        $modPenerimaanBarangDetail = new FAPenerimaandetailT;
        $modPenerimaanBarangDetail->attributes = $post;
        $modPenerimaanBarangDetail->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id; //fake id
        $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForDb($post['tglkadaluarsa']);
        if (empty($modPenerimaanBarangDetail->tglkadaluarsa)) {
            $modPenerimaanBarangDetail->tglkadaluarsa = date('Y-m-d H:i:s', strtotime("+2 years"));
        }
        $modPenerimaanBarangDetail->persenppn = 0;
        $modPenerimaanBarangDetail->persenpph = 0;
        $hpp = $post['harganettoper'] - ($post['harganettoper'] * $post['persendiscount'] / 100); //di persendiscount dan jmldiscount HARUS salahsatu
        if ($modPenerimaanBarangDetail->persenppn > 0) {
            $hpp = ($hpp + ($hpp * ($modPenerimaanBarangDetail->persenppn / 100)));
        }
        if ($modPenerimaanBarangDetail->persenpph > 0) {
            $hpp = ($hpp + ($hpp * ($modPenerimaanBarangDetail->persenpph / 100)));
        }

//		$modPenerimaanBarangDetail->hargasatuanper = round($hpp);
        $modPenerimaanBarangDetail->hargasatuanper = $hpp;
        $modPenerimaanBarangDetail->jmlterima = $post['jmlpermintaan'];
        $modPenerimaanBarangDetail->nobatch = $post['nobatch'];
        $modPenerimaanBarangDetail->biaya_lainlain = 0;
        $modPenerimaanBarangDetail->fakturdetail_id = NULL;
        $modPenerimaanBarangDetail->returdetail_id = NULL;
        $modPenerimaanBarangDetail->stokobatalkes_id = NULL;

        if ($post['satuanobat'] == PARAMS::SATUAN_KECIL) {
            $modPenerimaanBarangDetail->satuanbesar_id = NULL;
        } else {
            $modPenerimaanBarangDetail->satuankecil_id = NULL;
        }
        if ($modPenerimaanBarangDetail->validate()) {
            $modPenerimaanBarangDetail->save();
            $this->penerimaanbarangdetailtersimpan &= true;
        } else {
            $this->penerimaanbarangdetailtersimpan &= false;
        }
        return $modPenerimaanBarangDetail;
    }

    public function simpanStokObatAlkes($modPenerimaanDetail, $postOa, $modPenerimaanBarang) {
        $format = new MyFormatter;
        $modStok = new StokobatalkesT;
        $loadObatAlkes = FAObatalkesM::model()->findByPk($modPenerimaanDetail->obatalkes_id);
        $modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStok->penerimaandetail_id = $modPenerimaanDetail->penerimaandetail_id;
        $modStok->tglkadaluarsa = !empty($modPenerimaanDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa) : null;
        $modStok->obatalkes_id = $modPenerimaanDetail->obatalkes_id;
        $modStok->nobatch = $postOa['nobatch'];
        $modStok->tglstok_in = $modPenerimaanBarang->tglterima;
        $modStok->tglstok_out = NULL;
        if (!empty($modPenerimaanDetail->satuanbesar_id)) {
            $modStok->qtystok_in = $modPenerimaanDetail->jmlterima * $modPenerimaanDetail->kemasanbesar;
            $modStok->harganetto = ($modPenerimaanDetail->harganettoper / $modStok->qtystok_in);
        } else {
            $modStok->qtystok_in = $modPenerimaanDetail->jmlterima;
            $modStok->harganetto = $modPenerimaanDetail->harganettoper;
        }

        $modStok->qtystok_out = 0;
        $modStok->persendiscount = $modPenerimaanDetail->persendiscount;
        $modStok->jmldiscount = $modPenerimaanDetail->jmldiscount;
        $modStok->persenppn = $modPenerimaanDetail->persenppn;
        $modStok->persenpph = $modPenerimaanDetail->persenpph;
        $modStok->persenmargin = $loadObatAlkes->margin;
        $modStok->jmlmargin = 0;
        $modStok->create_time = date('Y-m-d H:i:s');
        $modStok->update_time = date('Y-m-d H:i:s');
        $modStok->create_loginpemakai_id = Yii::app()->user->id;
        $modStok->update_loginpemakai_id = Yii::app()->user->id;
        $modStok->create_ruangan = Yii::app()->user->ruangan_id;
        $modStok->tglterima = $modPenerimaanDetail->penerimaanbarang->tglterima;
        $modStok->satuankecil_id = (isset($modPenerimaanDetail->satuankecil_id) ? $modPenerimaanDetail->satuankecil_id : $loadObatAlkes->satuankecil_id);

        if ($modStok->validate()) {
            $modStok->save();
            $loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
            $loadObatAlkes->harganetto = $modStok->harganetto;
            $loadObatAlkes->discount = (($modStok->jmldiscount > 0) ? $modStok->jmldiscount : $modStok->harganetto * $modStok->persendiscount / 100);
            $loadObatAlkes->ppn_persen = $modStok->persenppn;
            $loadObatAlkes->hpp = $modStok->HPP;
            $loadObatAlkes->kemasanbesar = $modPenerimaanDetail->kemasanbesar;
            $loadObatAlkes->satuankecil_id = $modStok->satuankecil_id;
            $loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);

            if ($modStok->persenmargin > 0) {
                $hargajual = ($modStok->HPP + ($modStok->HPP * ($modStok->persenmargin / 100)));
            } else {
                $hargajual = $modStok->HPP + $modStok->jmlmargin;
            }
            if ($hargajual > $loadObatAlkes->hargamaksimum) {
                $loadObatAlkes->hargamaksimum = $hargajual;
            }
            if ($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum) {
                $loadObatAlkes->hargaminimum = $hargajual;
            }
            if ($loadObatAlkes->hargaaverage > 0 && $hargajual > 0) {
                $loadObatAlkes->hargaaverage = ($loadObatAlkes->hargaaverage + $hargajual) / 2;
            } else {
                $loadObatAlkes->hargaaverage = $hargajual;
            }
            $loadObatAlkes->hargajual = $hargajual;

            if ($loadObatAlkes->save()) {
                
            } else {
                $this->stokobatalkestersimpan &= false;
            }
        } else {
            $this->stokobatalkestersimpan &= false;
        }

        return $modStok;
    }

    public function actionPrint($penerimaanbarang_id, $caraPrint = null) {
        $format = new MyFormatter;
        $modPenerimaanBarang = FAPenerimaanbarangT::model()->findByPk($penerimaanbarang_id);
        $modPenerimaanBarangDetail = FAPenerimaandetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $penerimaanbarang_id));
        $modFakturPembelian = FAFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id' => $penerimaanbarang_id));

        $judul_print = 'Penerimaan Obat dan Alat Kesehatan Dari Supplier';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }
        $this->render('Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPenerimaanBarang' => $modPenerimaanBarang,
            'modPenerimaanBarangDetail' => $modPenerimaanBarangDetail,
            'modFakturPembelian' => $modFakturPembelian,
            'caraPrint' => $caraPrint
        ));
    }

    public function actionAutocompleteObatAlkes() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                            JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                            LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
                            ";
            $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('obatalkes_farmasi = TRUE');
            $criteria->addCondition('obatalkes_aktif = true');
            $criteria->limit = 5;
            $models = ObatalkesM::model()->findAll($criteria);
            $format = new MyFormatter();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Harga " . $model->hargajual . " - Jumlah Stok " . $qty_stok;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                $returnVal[$i]['qty_stok'] = $qty_stok;
                $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}

?>
