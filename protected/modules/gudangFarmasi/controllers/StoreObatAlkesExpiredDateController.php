<?php

class StoreObatAlkesExpiredDateController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.storeObatAlkesEd.';
    public $storeedsimpan = false;
    public $storeeddetailsimpan = true;
    public $stokobatalkessimpan = true;

    public function actionIndex($storeed_id = null) {
        $model = new GFStoreedT;
        $format = new MyFormatter;
        $modDetails = array();
        $model->tglstoreed = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));


        if (!empty($storeed_id)) {
            $model = GFStoreedT::model()->findByPk($storeed_id);
            $modDetails = GFStoreeddetailT::model()->findByAttributes(array('storeed_id' => $storeed_id));
        }

        $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['GFStoreedT'])) {
            $model = $this->simpanStoreEd($_POST['GFStoreedT']);
            if ($this->storeedsimpan) {
                if (!empty($_POST['GFStoreeddetailT'])) {
                    $detailGroups = array();
                    foreach ($_POST['GFStoreeddetailT'] as $i => $postDetail) {
                        $modDetails[$i] = new GFStoreeddetailT;
                        $modDetails[$i]->attributes = $postDetail;
                        $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                        $obatalkes_id = $postDetail['obatalkes_id'];
                        if (isset($detailGroups[$obatalkes_id])) {
                            $detailGroups[$obatalkes_id]['qtystoked'] += $postDetail['qtystoked'];
                            $detailGroups[$obatalkes_id]['sumberdana_id'] = $postDetail['sumberdana_id'];
                        } else {
                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                            $detailGroups[$obatalkes_id]['qtystoked'] = $postDetail['qtystoked'];
                            $detailGroups[$obatalkes_id]['satuankecil_id'] = $postDetail['satuankecil_id'];
                            $detailGroups[$obatalkes_id]['sumberdana_id'] = $postDetail['sumberdana_id'];
                        }
                    }
                }
                $obathabis = "";
                foreach ($detailGroups as $i => $detail) {
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qtystoked'], Yii::app()->user->getState('ruangan_id'), $detail['sumberdana_id']);
                    if (!empty($modStokOAs)) {
                        foreach ($modStokOAs as $i => $stok) {
                            $modeDetails[$i] = $this->simpanStoreEdDetail($model, $stok, $_POST['GFStoreeddetailT'], $detail['sumberdana_id']);
//							$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modeDetails[$i]); //RND-10577
                        }
                    } else {
                        $this->stokobatalkessimpan &= false;
                        $obathabis .= "<br>-" . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                    }
                }
                try {
                    if ($this->storeeddetailsimpan && $this->stokobatalkessimpan) {                         
                        $transaction->commit();
                        $sukses = 1;
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                        $this->redirect(array('index', 'storeed_id' => $model->storeed_id, 'sukses' => $sukses));
                    } else {                        
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data detail store expired date gagal disimpan !");
                        if (!$this->stokobatalkessimpan) {
                            Yii::app()->user->setFlash('error', "Data detail store expired date gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
                        }
                    }
                } catch (Exception $ex) {                    
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data store expired date gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
                }
            }
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model, 'modDetails' => $modDetails
        ));
    }

    public function simpanStoreEd($poststoreed) {
        $format = new MyFormatter;
        $model = new GFStoreedT;
        $model->attributes = $poststoreed;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglstoreed = $format->formatDateTimeForDb($model->tglstoreed);
        $model->periodetgled = $format->formatDateTimeForDb(date('Y-m-d H:i:s'));
        $model->sampaidenganed = $format->formatDateTimeForDb(date('Y-m-d H:i:s'));
        $model->create_time = $format->formatDateTimeForDb(date('Y-m-d H:i:s'));
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($model->validate()) {
            $model->save();
            $this->storeedsimpan = true;
        } else {
            $this->storeeddetailsimpan = false;
            Yii::app()->user->setFlash('error', "Data Store expired date Tidak valid");
        }
        return $model;
    }

    public function simpanStoreEdDetail($model, $stokObat, $postStoreEdDetail, $sumberdana_id = null) {
        $format = new MyFormatter;
        $modStoreEdDetail = new GFStoreeddetailT();
        $modStoreEdDetail->attributes = $stokObat->attributes;
        $modStoreEdDetail->storeed_id = $model->storeed_id;
        $modStoreEdDetail->qtystoked = $stokObat->qtystok_terpakai;
        $modStoreEdDetail->satuankecil_id = $stokObat->satuankecil_id;
        $modStoreEdDetail->obatalkes_id = $stokObat->obatalkes_id;
        $modStoreEdDetail->tglkadaluarsa = $stokObat->tglkadaluarsa;
        $modStoreEdDetail->sumberdana_id = $sumberdana_id;
        if ($modStoreEdDetail->save()) {
            $this->storeeddetailsimpan &= true;
            $this->simpanStokObatAlkesOut($stokObat['stokobatalkes_id'], $modStoreEdDetail);
        } else {
            $this->storeeddetailsimpan &= false;
        }
        return $modStoreEdDetail;
    }

    public function simpanStokObatAlkesOut($stokobatalkesasal_id, $modStoreEdDetail) {
        $format = new MyFormatter();
        $modStokObat = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);

        $modStokObatNew = new StokobatalkesT;
        $modStokObatNew->attributes = $modStokObat->attributes;
        $modStokObatNew->unsetIdTransaksi();
        $modStokObatNew->qtystok_in = 0;
        $modStokObatNew->qtystok_out = $modStoreEdDetail->qtystoked;
        $modStokObatNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokObatNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokObatNew->storeeddetail_id = $modStoreEdDetail->storeeddetail_id;
        $modStokObatNew->sumberdana_id = $modStoreEdDetail->sumberdana_id;
        $modStokObatNew->tglstok_in = null;
        $modStokObatNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokObatNew->create_time = date('Y-m-d H:i:s');
        $modStokObatNew->update_time = date('Y-m-d H:i:s');
        $modStokObatNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokObatNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokObatNew->create_ruangan = Yii::app()->user->ruangan_id;
        if ($modStokObatNew->validateStok()) {
            $modStokObatNew->save();
            $modStokObatNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkessimpan &= false;
        }
        return $modStokObatNew;
    }

    public function actionAutocompleteObatExpiredDate() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
            $sumberdana = (isset($_GET['sumberdana']) && !empty($_GET['sumberdana'])) ? $_GET['sumberdana'] : null;
            $criteria->join = 'JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
							JOIN supplier_m ON t.supplier_id=supplier_m.supplier_id
							JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id';
            $criteria->compare('LOWER(obatalkes_m.obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ObatsupplierM::model()->findAll($criteria);

            if (!empty($models)) {
                foreach ($models as $i => $model) {

                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
//					$qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'), $sumberdana);

                    $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
                    $returnVal[$i]['obatalkes_nama'] = $model->obatalkes->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes_id;
                    $returnVal[$i]['supplier_nama'] = $model->supplier->supplier_nama;
                    $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
                    $returnVal[$i]['satuankecil_id'] = $model->satuankecil->satuankecil_id;
                    $returnVal[$i]['tglkadaluarsa'] = $format->formatDateTimeForUser($model->obatalkes->tglkadaluarsa);
                }
            } else {
                $returnVal = null;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionSetFormObatAlkesEd() {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $obatalkes_nama = $_POST['obatalkes_nama'];
            $supplier_nama = $_POST['supplier_nama'];
            $satuankecil_id = $_POST['satuankecil_id'];
            $tglkadaluarsa = $_POST['tglkadaluarsa'];
            $jumlah = $_POST['qtystoked'];
            $sumberdana = $_POST['sumberdana'];
            $pesan = "";
            $form = "";
            $format = new MyFormatter();
            $modStoreEdDetail = new GFStoreeddetailT();
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id, $sumberdana);
            $modSatuankecil = SatuankecilM::model()->findByPk($satuankecil_id);

            if (!empty($modStokOAs)) {
                foreach ($modStokOAs as $i => $stok) {
                    $modStoreEdDetail->satuankecil_id = $satuankecil_id;
                    $modStoreEdDetail->obatalkes_id = $obatalkes_id;
                    $modStoreEdDetail->stokobatalkes_id = $stok->stokobatalkes_id;
                    $modStoreEdDetail->obatalkes_nama = $obatalkes_nama;
                    $modStoreEdDetail->supplier_nama = $supplier_nama;
                    $modStoreEdDetail->qtystoked = $jumlah;
                    $modStoreEdDetail->tglkadaluarsa = $tglkadaluarsa;
                    $modStoreEdDetail->satuankecil_nama = $modSatuankecil->satuankecil_nama;
                    $modStoreEdDetail->sumberdana_id = $sumberdana;
                    $form .= $this->renderPartial($this->path_view . '_rowDetailStoreEd', array('modStoreEdDetail' => $modStoreEdDetail, 'format' => $format, 'stok' => $stok), true);
                }
            } else {
                $pesan = "Stok habis!";
            }


            echo CJSON::encode(array('status' => 'create_form', 'form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionPrint($storeed_id, $caraPrint = null) {
        $format = new MyFormatter;
        $modStoreEd = GFStoreedT::model()->findByPk($storeed_id);

        //pencarian detail storeed
        $criteria2 = new CDbCriteria();
        $criteria2->select = "t.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id,"
                . "supplier_m.supplier_nama, obatsupplier_m.obatsupplier_id, obatsupplier_m.obatalkes_id, obatsupplier_m.supplier_id,"
                . "satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama";

        $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id
							LEFT JOIN obatsupplier_m ON t.obatalkes_id=obatsupplier_m.obatalkes_id
							LEFT JOIN supplier_m ON obatsupplier_m.supplier_id=supplier_m.supplier_id';
        if (!empty($storeed_id)) {
            $criteria2->addCondition('t.storeed_id =' . $storeed_id);
        }
        $modStoreEdDetail = GFStoreeddetailT::model()->findAll($criteria2);

        $judul_print = 'Store Expired Date Obat Alkes';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }
        $this->render($this->path_view . 'Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modStoreEd' => $modStoreEd,
            'modStoreEdDetail' => $modStoreEdDetail,
            'caraPrint' => $caraPrint
        ));
    }

}
?>

