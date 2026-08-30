<?php

class SetoranHutangPPNController extends MyAuthController
{
  public $path_view = 'keuangan.views.setoranHutangPPN.';
  public $tandabuktikeluartersimpan = false;
  public $pengeluaranumumtersimpan = false;
  public $pembayarankesuppliertersimpan = false;
  public $succesSave = true;
  public $pesan = '';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KUSetoranpajakT();
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modSrch = new KUPembayaranppnkeluaranV();
    $modSrch->pajak_id = 6;

    $modPajak = PajakM::model()->findByPk($modSrch->pajak_id);

    if (isset($modPajak)) {
      $modSrch->pajak_nama = $modPajak->pajak_nama;
    }

    $modBuktiKeluar->nokaskeluar = "Otomatis";
    $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranHutangPPNKeluar();
    $modBuktiKeluar->untukpembayaran = "Setoran Pajak PPN Keluaran - " . $modBuktiKeluar->no_setorpajakpembelian;

    if (isset($_POST['KUSetoranpajakT']) && isset($_POST['KUTandabuktikeluarT'])) {
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
          $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranHutangPPNKeluar();
          $modBuktiKeluar->tahun = date('Y');
          $modBuktiKeluar->biayaadministrasi = 0;

          if ($modBuktiKeluar->validate()) {
            if ($modBuktiKeluar->save()) {
              $this->tandabuktikeluartersimpan = true;
              $saveDetail = false;
              $jumlahPembayaran = 0;

              if (isset($_POST['KUPembayaranppnkeluaranV']) && count((array)$_POST['KUPembayaranppnkeluaranV']) > 0) {

                foreach ($_POST['KUPembayaranppnkeluaranV'] as $detailData) {
                  if ($detailData['checklist'] == 1) {
                    $modelDet = new KUSetoranpajakT();
                    $modelDet->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                    $modelDet->obatalkespasien_id = $detailData['obatalkespasien_id'];
                    $modelDet->tglsetoranpajak = $format->formatDateTimeForDB($_POST['KUSetoranpajakT']['tglsetoranpajak']);
                    $modelDet->totalhutang = $detailData['jumlahppn'];
                    $modelDet->jmlpembayaran = $detailData['jmldibayarkan'];
                    $modelDet->totalsisahutang = $detailData['sisahutang'];
                    $modelDet->bayarke = $detailData['bayarke'];
                    $modelDet->pajak_id = $detailData['pajak_id'];
                    $modelDet->create_time = date('Y-m-d H:i:s');
                    $modelDet->create_loginpemakai = Yii::app()->user->id;
                    $modelDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modelDet->keterangansetoran = $detailData['keterangan'];
                    $modelDet->jenissetoran = "Setoran Hutang PPN Keluaran";

                    if ($modelDet->save()) {
                      $jumlahPembayaran += $modelDet->jmlpembayaran;
                      $saveDetail = true;
                    }
                  }
                }
              }

              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                $modJurnalRekening = $this->saveJurnalRekening($_POST['KUSetoranpajakT'], $modBuktiKeluar);
                $nourutJurnal = 2;

                //debit ppn keluaran
                $rekeningcolumnDPPN = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_SETORANPAJAKT, 'column_name' => Params::REKENINGCOLUMN_COLUMN_SETORANPAJAKPPN, 'debitkredit' => 'D'));
                if (isset($rekeningcolumnDPPN)) {
                  $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnDPPN->rekening5_id, $jumlahPembayaran, 'D', 1);
                }

                if ($modBuktiKeluar->biaya_materai > 0) {
                  $nourutJurnal = 3;
                  //Debit Materai
                  $rekeningcolumnMaterai = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI, 'debitkredit' => 'D'));
                  if (isset($rekeningcolumnMaterai)) {
                    $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumnMaterai->rekening5_id, $modBuktiKeluar->biaya_materai, 'D', 2);
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
      'modSrch' => $modSrch
    ));
  }


  public function actionPrint($id)
  {
    $totalhutang = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $tglsetoran = "";
    $pajak_nama = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($id);
    $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));

    if (count((array)$model) > 0) {
      foreach ($model as $dataSetor) {
        $totalhutang += $dataSetor->totalhutang;
        $totalsisahutang += $dataSetor->totalsisahutang;
        $jmlpembayaran += $dataSetor->jmlpembayaran;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglsetoranpajak);
        $pajak_nama = (isset($dataSetor->pajak) ? $dataSetor->pajak->pajak_nama : "");
      }
    }

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array(
        'caraPrint' => $caraPrint,
        'modBuktiKeluar' => $modBuktiKeluar,
        'totalhutang' => $totalhutang,
        'totalsisahutang' => $totalsisahutang,
        'tglsetoran' => $tglsetoran,
        'jmlpembayaran' => $jmlpembayaran,
        'model' => $model,
        'pajak_nama' => $pajak_nama,

      ));
    }
  }

  public function actionSetFromSetoranPencarian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = 'Data tidak ditemukan';

      if (isset($_POST['KUPembayaranppnkeluaranV'])) {
        $tgl_awal = isset($_POST['KUPembayaranppnkeluaranV']['tgl_awal']) ? MyFormatter::formatDateTimeForDB($_POST['KUPembayaranppnkeluaranV']['tgl_awal']) : null;
        $tgl_akhir = isset($_POST['KUPembayaranppnkeluaranV']['tgl_akhir']) ? MyFormatter::formatDateTimeForDB($_POST['KUPembayaranppnkeluaranV']['tgl_akhir']) : null;
        $nopembayaran = isset($_POST['KUPembayaranppnkeluaranV']['nopembayaran']) ? $_POST['KUPembayaranppnkeluaranV']['nopembayaran'] : null;
        $nopendaftaran = isset($_POST['KUPembayaranppnkeluaranV']['no_pendaftaran']) ? $_POST['KUPembayaranppnkeluaranV']['no_pendaftaran'] : null;
        $carabayar_id = isset($_POST['KUPembayaranppnkeluaranV']['carabayar_id']) ? $_POST['KUPembayaranppnkeluaranV']['carabayar_id'] : null;
        $penjamin_id = isset($_POST['KUPembayaranppnkeluaranV']['penjamin_id']) ? $_POST['KUPembayaranppnkeluaranV']['penjamin_id'] : null;
        $pajak_id = isset($_POST['KUPembayaranppnkeluaranV']['pajak_id']) ? $_POST['KUPembayaranppnkeluaranV']['pajak_id'] : null;

        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date(tglpembayaran)', $tgl_awal, $tgl_akhir);
        $criteria->compare('lower(nopembayaran)', strtolower($nopembayaran), true);
        $criteria->compare('lower(no_pendaftaran)', strtolower($nopendaftaran), true);

        if (!empty($pajak_id)) {
          $criteria->addCondition('pajak_id = ' . $pajak_id);
        }

        if (!empty($carabayar_id)) {
          if (is_array($carabayar_id)) {
            $criteria->addInCondition('carabayar_id', $carabayar_id);
          } else {
            $criteria->addCondition('carabayar_id = ' . $carabayar_id);
          }
        }

        if (!empty($penjamin_id)) {
          if (is_array($penjamin_id)) {
            $criteria->addInCondition('penjamin_id', $penjamin_id);
          } else {
            $criteria->addCondition('penjamin_id = ' . $penjamin_id);
          }
        }

        $dataDetail = KUPembayaranppnkeluaranV::model()->findAll($criteria);

        if (count((array)$dataDetail) > 0) {
          $no = 1;
          $pesan = "";
          foreach ($dataDetail as $i => $data) {
            $pajakNilai = 0;
            $data->bayarke = 1;

            $criteriabayar = new CDbCriteria();
            $criteriabayar->addCondition('obatalkespasien_id = ' . $data->obatalkespasien_id);
            $criteriabayar->addCondition('batalpegawai_id IS NULL');
            $criteriabayar->order = "bayarke DESC";
            $criteriabayar->limit = 1;
            $modSetor = SetoranpajakT::model()->find($criteriabayar);

            if (isset($modSetor) && !empty($modSetor)) {
              $data->bayarke = ($modSetor->bayarke + 1);
            }

            $criteria1 = new CDbCriteria();
            $criteria1->addCondition('obatalkespasien_id = ' . $data->obatalkespasien_id);
            $criteria1->addCondition('batalpegawai_id IS NULL');
            $modSetor2 = SetoranpajakT::model()->findAll($criteria1);

            if (isset($modSetor2) && count((array)$modSetor2) > 0) {
              foreach ($modSetor2 as $setorData) {
                $pajakNilai += $setorData->jmlpembayaran;
              }
            }

            $data->jumlahppn = ($data->jumlahppn - $pajakNilai);
            if ($data->jumlahppn > 0) {
              $form .= $this->renderPartial($this->path_view . '_rowSetoran', array('modDetail' => $data, 'index' => $no), true);
              $no++;
            }
          }
        }
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


  protected function saveJurnalRekening($postSetoran, $modBuktiKeluar)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($postSetoran['tglsetoranpajak']);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modBuktiKeluar->no_setorpajakpembelian;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($postSetoran['tglsetoranpajak']);
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
        $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_SETORANPAJAKBPJSTK, false);
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
}
