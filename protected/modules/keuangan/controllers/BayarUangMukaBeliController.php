<?php

class BayarUangMukaBeliController extends MyAuthController
{
  protected $successSave = true;
  protected $succesSave = true;
  protected $pesan = "";
  public $path_view = 'keuangan.views.bayarUangMukaBeli.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Uang Muka Pembelian";
    $modSupplier = new KUSupplierM;
    $modUangMuka = new KUUangmukabeliT;
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modPermintaan = new KUPermintaanpembeliantouangmukaV();

    $modBuktiKeluar->untukpembayaran = 'Pembayaran Uang Muka Pembelian';

    $modUangMuka->nopembayaran = "Otomatis";
    $modBuktiKeluar->nokaskeluar = "Otomatis";
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;


    if (!empty($tandabuktikeluar_id)) {
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    }
    if (isset($_POST['KUTandabuktikeluarT']) && isset($_POST['KUUangmukabeliT'])  && isset($_POST['KUPermintaanpembeliantouangmukaV'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modUangMuka = $this->saveBayarUangMukaBeli($_POST['KUUangmukabeliT'], $_POST['KUPermintaanpembeliantouangmukaV']);
        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $modUangMuka);

        if ($this->successSave) {
          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            $modJurnalRekening = $this->saveJurnalRekening($modUangMuka, $modBuktiKeluar);

            $modRekeningColumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_UANGMUKABELIT, 'column_name' => Params::REKENINGCOLUMN_COLUMN_JUMLAHUANG));

            if (isset($modRekeningColumn)) {
              $this->saveJurnalDetail($modJurnalRekening, $modRekeningColumn->rekening5_id, $modUangMuka->jumlahuang, 'D', 1);
            }

            $nourutJurnal = 2;
            if ($modBuktiKeluar->biayaadministrasi > 0) {
              $nourutJurnal = 3;
              //Debit administrasi
              $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_TANDABUKTI_BIAYAADMINISTRASI));
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modBuktiKeluar->biayaadministrasi, 'D', 2);
              }
            }



            if ($modBuktiKeluar->biaya_materai > 0) {
              if ($modBuktiKeluar->biayaadministrasi > 0) {
                $nourutJurnal = 4;
              } else {
                $nourutJurnal = 3;
              }

              //Debit biaya materai
              $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI));
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modBuktiKeluar->biaya_materai, 'D', 3);
              }
            }
            //Kredit Carabayarkeluar
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
            //
          }
          $this->notifUangMuka($modUangMuka, $modBuktiKeluar);

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'uangmukabeli_id' => $modUangMuka->uangmukabeli_id, 'sukses' => 1));
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
      'modSupplier' => $modSupplier,
      'modUangMuka' => $modUangMuka,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modPermintaan' => $modPermintaan
    ));
  }

  protected function notifUangMuka($model, $keluar)
  {
    //        print_r($model->attributes);
    //        print_r($keluar->attributes);
    //        die;

    $suplier = SupplierM::model()->findByPk($model->supplier_id);

    $judul = "Uang Muka Pembelian - " . $keluar->nokaskeluar;

    $isi = "Tgl. Uang Muka : " . MyFormatter::formatDateTimeForUser($model->tgluangmukabeli) . "<br/>";
    $isi .= "Supplier : " . (empty($suplier) ? "-" : $suplier->supplier_nama) . "<br/>";
    $isi .= "Jumlah : " . MyFormatter::formatNumberForPrint($model->jumlahuang) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    //$ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //    array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    ));
  }

  protected function saveBuktiKeluar($postBuktiKeluar, $modUangMuka)
  {
    $format = new MyFormatter;
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($modBuktiKeluar->tglkaskeluar);
    $modBuktiKeluar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
    $supplier = (isset($modUangMuka->supplier) ? $modUangMuka->supplier->supplier_nama : "");
    $tgluangmuka = date('d M Y', strtotime($modUangMuka->tgluangmukabeli));
    $modBuktiKeluar->untukpembayaran = "Pembayaran Uang Muka Supplier - " . $supplier . " - " . $tgluangmuka;
    $modBuktiKeluar->tahun = date('Y');

    if ($modBuktiKeluar->validate()) {
      if ($modBuktiKeluar->save()) {
        $this->successSave = $this->successSave && true;
      }
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function saveBayarUangMukaBeli($modUangMuka, $permintaanpembelian)
  {
    $modBayarUangMuka = new KUUangmukabeliT;
    $modBayarUangMuka->supplier_id = $modUangMuka['supplier_id'];
    $modBayarUangMuka->nopembayaran = MyGenerator::noUangMukaPembelian();
    $modBayarUangMuka->jumlahuang = $modUangMuka['jumlahuang'];
    $modBayarUangMuka->jmlsisauangmuka = $modUangMuka['jmlsisauangmuka'];
    $modBayarUangMuka->totalpo = $modUangMuka['totalpo'];
    $modBayarUangMuka->totalsisahutangpo = $modUangMuka['totalsisahutangpo'];
    $modBayarUangMuka->tgluangmukabeli = MyFormatter::formatDateTimeForDb($modUangMuka['tgluangmukabeli']);

    if ($modUangMuka['typepermintaan'] == 'barang') {
      $modBayarUangMuka->pembelianbarang_id = $modUangMuka['permintaanpembelian_id'];
    } else if ($modUangMuka['typepermintaan'] == 'obatalkes') {
      $modBayarUangMuka->permintaanpembelian_id = $modUangMuka['permintaanpembelian_id'];
    } else if ($modUangMuka['typepermintaan'] == 'gizi') {
      $modBayarUangMuka->pengajuanbahanmkn_id = $modUangMuka['permintaanpembelian_id'];
    }

    if ($modBayarUangMuka->validate()) {
      if ($modBayarUangMuka->save()) {
        $this->successSave = $this->successSave && true;
      }
    } else {
      $this->successSave = false;
    }

    return $modBayarUangMuka;
  }

  public function actionDaftarNoPermintaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //$criteria->with = array();
      $criteria->compare('LOWER(nopermintaan)', strtolower($_GET['term']), true);
      $models = KUPermintaanpembeliantouangmukaV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopermintaan;
        $returnVal[$i]['value'] = $model->nopermintaan;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($uangmukabeli_id)
  {
    $this->layout = '//layouts/printWindows';
    $model = UangmukabeliT::model()->findByPk($uangmukabeli_id);
    $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('uangmukabeli_id' => $model->uangmukabeli_id));

    $this->render($this->path_view . 'print', array(
      'modBuktiKeluar' => $modBuktiKeluar,
      'model' => $model,
    ));
  }


  protected function saveJurnalRekening($model, $modBuktiKeluar)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tgluangmukabeli);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nopembayaran;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tgluangmukabeli);
    $modJurnalRekening->nobku = "";

    $modJurnalRekening->urianjurnal = $modBuktiKeluar->untukpembayaran;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->uangmukabeli_id = $model->uangmukabeli_id;

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
    $modJurnalPosting = null;

    //        if(Yii::app()->user->getState('ispostingotomatis'))
    //        {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if($modJurnalPosting->validate()){
    //                $modJurnalPosting->save();
    //            }
    //        }

    $modelJurnalDetail = new JurnaldetailT();
    //        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
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
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
