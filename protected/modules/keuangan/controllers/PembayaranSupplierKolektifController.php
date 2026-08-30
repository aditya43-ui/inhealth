<?php

class PembayaranSupplierKolektifController extends MyAuthController
{
  public $path_view = 'keuangan.views.pembayaranSupplierKolektif.';
  public $tandabuktikeluartersimpan = false;
  public $pengeluaranumumtersimpan = false;
  public $pembayarankesuppliertersimpan = false;
  public $succesSave = true;
  public $pesan = '';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Supplier Kolektif";
    $format = new MyFormatter();
    $model = new KUBayarkesupplierT();
    $modBuktiKeluar = new KUTandabuktikeluarT();
    $modFakturPembelian = new KUFakturpembeliantopembayaranV();

    $modBuktiKeluar->nokaskeluar = "Otomatis";
    $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranPembayaranKolektif();
    $modBuktiKeluar->untukpembayaran = "Pembayaran Supplier - " . $modBuktiKeluar->no_setorpajakpembelian;

    if (isset($_POST['KUFakturpembeliantopembayaranV']) && isset($_POST['KUTandabuktikeluarT'])) {
      $transaction = Yii::app()->db->beginTransaction();

      try {

        if (isset($_POST['KUTandabuktikeluarT'])) {
          $modBuktiKeluar->attributes = $_POST['KUTandabuktikeluarT'];
          $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($_POST['KUTandabuktikeluarT']['tglkaskeluar']);
          $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
          $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
          $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
          $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
          $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranPembayaranKolektif();
          $modBuktiKeluar->tahun = date('Y');

          if ($modBuktiKeluar->validate()) {
            if ($modBuktiKeluar->save()) {
              $this->tandabuktikeluartersimpan = true;
              $saveDetail = false;
              $rekeningkreditfaktur_id = null;
              $jmlpembayaran = 0;

              if (isset($_POST['KUFakturpembeliantopembayaranV']) && count((array)$_POST['KUFakturpembeliantopembayaranV']) > 0) {

                foreach ($_POST['KUFakturpembeliantopembayaranV'] as $detailData) {
                  if ($detailData['checklist'] == 1) {
                    $modelDet = new KUBayarkesupplierT();
                    if ($detailData['typefaktur'] == 'barang') {
                      $modelDet->terimapersediaan_id = $detailData['faktur_id'];
                    } else if ($detailData['typefaktur'] == 'obatalkes') {
                      $modelDet->fakturpembelian_id = $detailData['faktur_id'];
                    } else if ($detailData['typefaktur'] == 'gizi') {
                      $modelDet->terimabahanmakan_id = $detailData['faktur_id'];
                    }
                    $jmlpembayaran += $detailData['jmldibayarkan'];

                    $modelDet->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                    $modelDet->tglbayarkesupplier = $format->formatDateTimeForDB($_POST['KUBayarkesupplierT']['tglbayarkesupplier']);
                    $modelDet->totaltagihan = $detailData['totalhutangusaha'];
                    $modelDet->jmldibayarkan = $detailData['jmldibayarkan'];
                    $modelDet->totalsisatagihan = $detailData['sisahutang'];
                    $modelDet->keterangan = $detailData['keterangan'];
                    $modelDet->bayarke = $detailData['bayarke'];
                    $modelDet->create_time = date('Y-m-d H:i:s');
                    $modelDet->create_loginpemakai_id = Yii::app()->user->id;
                    $modelDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    if ($modelDet->save()) {
                      $saveDetail = true;

                      $criteriaJurnalFaktur = new CDbCriteria();
                      if (!empty($modelDet->terimapersediaan_id)) {
                        $criteriaJurnalFaktur->addCondition('terimapersediaan_id = ' . $modelDet->terimapersediaan_id);
                      }

                      if (!empty($modelDet->fakturpembelian_id)) {
                        $criteriaJurnalFaktur->addCondition('fakturpembelian_id = ' . $modelDet->fakturpembelian_id);
                      }

                      if (!empty($modelDet->terimabahanmakan_id)) {
                        $criteriaJurnalFaktur->addCondition('terimapersediaan_id = ' . $modelDet->terimabahanmakan_id);
                      }
                      $criteriaJurnalFaktur->limit = 1;
                      $jurnalfaktur = JurnalrekeningT::model()->find($criteriaJurnalFaktur);

                      if (isset($jurnalfaktur)) {
                        $jurnaldetFaktur = JurnaldetailT::model()->findByAttributes(array('jurnalrekening_id' => $jurnalfaktur->jurnalrekening_id), array('condition' => 'saldokredit > 0', 'order' => 'nourut DESC'));

                        if (isset($jurnaldetFaktur)) {
                          $rekeningkreditfaktur_id = $jurnaldetFaktur->rekening5_id;
                        }
                      }
                    }
                  }
                }
              }

              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                $modJurnalRekening = $this->saveJurnalRekening($modBuktiKeluar);
                $nourutJurnal = 2;

                //Debit jurnal rekening mengambil dari transaksi faktur
                if (!empty($rekeningkreditfaktur_id)) {
                  $this->saveJurnalDetail($modJurnalRekening, $rekeningkreditfaktur_id, $jmlpembayaran, 'D', 1);
                }

                if ($modBuktiKeluar->biayaadministrasi > 0) {
                  $nourutJurnal = 3;
                  //Debit administrasi
                  $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAADMINISTRASI, 'debitkredit' => 'D'));
                  if (isset($rekeningcolumn)) {
                    $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modBuktiKeluar->biayaadministrasi, 'D', 2);
                  }
                }

                if ($modBuktiKeluar->biayaongkos_kirim > 0) {
                  if ($modBuktiKeluar->biayaadministrasi > 0) {
                    $nourutJurnal = 4;
                  } else {
                    $nourutJurnal = 3;
                  }

                  //Debit biayaongkos_kirim
                  $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAONGKOSKIRIM, 'debitkredit' => 'D'));
                  if (isset($rekeningcolumn)) {
                    $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modBuktiKeluar->biayaongkos_kirim, 'D', 3);
                  }
                }

                //Kredit Pembayaran
                if (!empty($modBuktiKeluar->carabayarkeluar)) {
                  if ($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER) {
                    $modBankRek = BankrekM::model()->findByAttributes(array('bank_id' => $modBuktiKeluar->bank_id, 'debitkredit' => 'K'));
                    if (isset($modBankRek)) {
                      $this->saveJurnalDetail($modJurnalRekening, $modBankRek->rekening5_id, $modBuktiKeluar->jmlkaskeluar, 'K', $nourutJurnal);
                    }
                  } else {
                    $modCarabayarKeluarrek = CarabayarkeluarrekM::model()->findByAttributes(array('carabayarkeluar' => $modBuktiKeluar->carabayarkeluar));
                    if (isset($modCarabayarKeluarrek)) {
                      $this->saveJurnalDetail($modJurnalRekening, $modCarabayarKeluarrek->rekening5_id, $modBuktiKeluar->jmlkaskeluar, 'K', $nourutJurnal);
                    }
                  }
                }
              }

              if ($saveDetail) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->redirect(array('index', 'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id, 'sukses' => 1));
              } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                $transaction->rollback();
              }
            }
          } else {
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            $transaction->rollback();
          }
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modFakturPembelian' => $modFakturPembelian
    ));
  }


  public function actionPrint($id)
  {

    $totaltagihan = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $detailPembayaran = array();
    $supplier = "";
    $jenisupplier = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($id);
    $modDetail = BayarkesupplierT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
    // $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id));
    //
    if (count((array)$modDetail) > 0) {
      foreach ($modDetail as $dataSetor) {

        $criteria = new CDbCriteria();
        if (!empty($dataSetor->terimapersediaan_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->terimapersediaan_id);
          $criteria->addCondition("typefaktur = 'barang'");
        }

        if (!empty($dataSetor->fakturpembelian_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->fakturpembelian_id);
          $criteria->addCondition("typefaktur = 'obatalkes'");
        }

        if (!empty($dataSetor->terimabahanmakan_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->terimabahanmakan_id);
          $criteria->addCondition("typefaktur = 'gizi'");
        }
        $criteria->limit = 1;
        $modFakur = FakturpembeliantopembayaranV::model()->find($criteria);
        $pemby = array();
        $pemby['nofaktur'] = "-";
        $pemby['tglfaktur'] = "-";
        $pemby['tgljatuhtempo'] = "-";
        $pemby['instalasi'] = "-";
        $pemby['ruangan'] = "-";
        if (isset($modFakur)) {
          $pemby['nofaktur'] = $modFakur->nofaktur;
          $pemby['tglfaktur'] = MyFormatter::formatDateTimeForUser($modFakur->tglfaktur);
          $pemby['tgljatuhtempo'] = (!empty($modFakur->tgljatuhtempo) ? MyFormatter::formatDateTimeForUser($modFakur->tgljatuhtempo) : "-");
          $pemby['instalasi'] = $modFakur->instalasi_nama;
          $pemby['ruangan'] = $modFakur->ruangan_nama;
          $supplierMod = SupplierM::model()->findByPk($modFakur->supplier_id);

          if (isset($supplierMod)) {
            $supplier = $supplierMod->supplier_nama;
            $jenisupplier = $supplierMod->supplier_jenis;
          }
        }
        $pemby['totaltagihan'] = $dataSetor->totaltagihan;
        $pemby['totalsisatagihan'] = $dataSetor->totalsisatagihan;
        $pemby['jmldibayarkan'] = $dataSetor->jmldibayarkan;
        $pemby['keterangan'] = $dataSetor->keterangan;
        $totaltagihan += $dataSetor->totaltagihan;
        $totalsisahutang += $dataSetor->totalsisatagihan;
        $jmlpembayaran += $dataSetor->jmldibayarkan;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglbayarkesupplier);
        $detailPembayaran[] = $pemby;
      }
    }

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array(
        'caraPrint' => $caraPrint,
        'modBuktiKeluar' => $modBuktiKeluar,
        'totaltagihan' => $totaltagihan,
        'totalsisahutang' => $totalsisahutang,
        'jmlpembayaran' => $jmlpembayaran,
        'detailPembayaran' => $detailPembayaran,
        'tglsetoran' => $tglsetoran,
        'supplier' => $supplier,
        'jenisupplier' => $jenisupplier

      ));
    }
  }

  public function actionSetFromFakturPembelian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";
      $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : null;
      $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : null;
      $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null;

      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('date(tglfaktur)', $tgl_awal, $tgl_akhir);
      if (!empty($supplier_id)) {
        $criteria->addCondition('supplier_id = ' . $supplier_id);
      }
      $dataDetail = KUFakturpembeliantopembayaranV::model()->findAll($criteria);

      if (count((array)$dataDetail) > 0) {
        $no = 1;
        foreach ($dataDetail as $i => $data) {
          $pajakNilai = 0;
          $data->bayarke = 1;

          $criteriabayar = new CDbCriteria();
          if ($data->typefaktur == 'barang') {
            $criteriabayar->addCondition('terimapersediaan_id = ' . $data->faktur_id);
          } else if ($data->typefaktur == 'obatalkes') {
            $criteriabayar->addCondition('fakturpembelian_id = ' . $data->faktur_id);
          } else if ($data->typefaktur == 'gizi') {
            $criteriabayar->addCondition('terimabahanmakan_id = ' . $data->faktur_id);
          }
          $modBayarSupplier = BayarkesupplierT::model()->findAll($criteriabayar);

          $criteriaBayarFind = clone $criteriabayar;
          $criteriaBayarFind->order = "bayarke DESC";
          $modBayarSupplierFind = BayarkesupplierT::model()->find($criteriaBayarFind);

          if (isset($modBayarSupplier) && count((array)$modBayarSupplier) > 0) {
            foreach ($modBayarSupplier as $valSupplier) {
              $pajakNilai += $valSupplier->jmldibayarkan;
            }
          }

          if (isset($modBayarSupplierFind) && !empty($modBayarSupplierFind)) {
            $data->bayarke = ($modBayarSupplierFind->bayarke + 1);
          }

          $data->totalhutangusaha = ($data->totalhutangusaha - $pajakNilai);
          if ($data->totalhutangusaha > 0) {
            $form .= $this->renderPartial($this->path_view . '_rowSetoran', array('modDetail' => $data, 'index' => $no), true);
            $no++;
          }
        }
      } else {
        $pesan = 'Data Faktur Pembelian tidak ditemukan';
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionGetMasterBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bank_id = isset($_GET['bank_id']) ? $_GET['bank_id'] : null;

      $model = BankM::model()->findByPk($bank_id);
      $data = array();

      if (isset($model)) {
        $data['norekening'] = $model->norekening;
        $data['namabank'] = $model->namabank;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }


  protected function saveJurnalRekening($modBuktiKeluar)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modBuktiKeluar->tglkaskeluar);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modBuktiKeluar->no_setorpajakpembelian;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modBuktiKeluar->tglkaskeluar);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $modBuktiKeluar->untukpembayaran;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut)
  {
    $valid = true;

    $modelJurnalDetail = new JurnaldetailT();
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modelJurnalDetail->nourut = $nourut;
    if ($typeSaldo == 'K') {
      $modelJurnalDetail->saldokredit = $nilaisaldo;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($typeSaldo == 'D') {
      $modelJurnalDetail->saldodebit = $nilaisaldo;
      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      $valid = false;
    }

    return $valid;
  }


  public function actionAmbilDataRekeningCarabayar()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $carabayar = isset($_POST['carabayar']) ? $_POST['carabayar'] : null;
      $bankid = isset($_POST['bankid']) ? $_POST['bankid'] : null;

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";

      if (!empty($bankid)) {
        $criteria->addCondition("t.bank_id = " . $bankid);
        $criteria->addCondition("t.debitkredit = 'K'");
      } else {
        if (!empty($carabayar)) {
          $criteria->addCondition("t.carabayarkeluar = 'TUNAI'");
          $criteria->addCondition("t.debitkredit = 'K'");
        }
      }
      $criteria->order = 't.debitkredit ASC';
      $criteria->limit = 1;

      if (!empty($bankid)) {
        $model = BankrekM::model()->findAll($criteria);
      } else {
        if (!empty($carabayar)) {
          $model = CarabayarkeluarrekM::model()->findAll($criteria);
        }
      }

      if (count((array)$model) > 0) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'K', 'tr' => 'trKreditCarabayar', 'nourut' => 3), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionAmbilDataRekColumn()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jmlBayar = isset($_POST['jmlBayar']) ? $_POST['jmlBayar'] : 0;
      $biayamaterai = isset($_POST['biayamaterai']) ? $_POST['biayamaterai'] : 0;

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";

      $criteria->addCondition("debitkredit = 'D'");
      $dataArr = "";
      if (isset($jmlBayar) && $jmlBayar > 0) {
        $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_SETORANPAJAKT, false);
        $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_SETORANPAJAKPPH, false);
        $model = RekeningcolumnM::model()->findAll($criteria);

        if (count((array)$model) > 0) {
          $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D', 'tr' => 'trDebitPPh', 'nourut' => 1), true);
        }
      }

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";

      $criteria->addCondition("debitkredit = 'D'");

      if (isset($biayamaterai) && $biayamaterai > 0) {
        $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, false);
        $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI, false);
        $model = RekeningcolumnM::model()->findAll($criteria);

        if (count((array)$model) > 0) {
          $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D', 'tr' => 'trDebitMaterai', 'nourut' => 2), true);
        }
      }
      echo CJSON::encode($dataArr);

      Yii::app()->end();
    }
  }

  public function actionAutocompleteMasterSupplier($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $criteria = new CDbCriteria;
    $criteria->compare('lower(supplier_nama)', strtolower($term), true);
    $criteria->addCondition('supplier_aktif = true');
    $criteria->order = 'supplier_nama';
    $criteria->limit = 10;

    $model = SupplierM::model()->findAll($criteria);
    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->supplier_nama;
      $sub['value'] = $item->supplier_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}
