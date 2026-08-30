<?php

class SetoranHutangPPhJasaDokterController extends MyAuthController
{
  public $path_view = 'keuangan.views.setoranHutangPPhJasaDokter.';
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
    $model->pajak_id = 1;
    $modPajak = PajakM::model()->findByPk($model->pajak_id);
    $model->pajak_nama = (isset($modPajak) ? $modPajak->pajak_nama : "");
    $model->jenissetoran = Params::JENISSETORAN_PPHJASADOKTER;
    $modBuktiKeluar->nokaskeluar = "Otomatis";

    $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranPajakHutang($model->jenissetoran);
    $modBuktiKeluar->untukpembayaran = "Setoran PPh 21 Jasa Dokter - " . $modBuktiKeluar->no_setorpajakpembelian;

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
          $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranPajakHutang($model->jenissetoran);
          $modBuktiKeluar->tahun = date('Y');
          $modBuktiKeluar->biayaadministrasi = 0;

          if ($modBuktiKeluar->validate()) {
            if ($modBuktiKeluar->save()) {
              $this->tandabuktikeluartersimpan = true;
              $saveDetail = false;

              if (isset($_POST['PembayaranjasaT']) && count((array)$_POST['PembayaranjasaT']) > 0) {

                foreach ($_POST['PembayaranjasaT'] as $detailData) {
                  if ($detailData['checklist'] == 1) {
                    $modelDet = new KUSetoranpajakT();
                    $modelDet->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                    $modelDet->tglsetoranpajak = $format->formatDateTimeForDB($_POST['KUSetoranpajakT']['tglsetoranpajak']);
                    $modelDet->totalhutang = $detailData['total_pajak'];
                    $modelDet->jmlpembayaran = $detailData['jmlsetoran'];
                    $modelDet->totalsisahutang = $detailData['sisahutang'];
                    $modelDet->create_time = date('Y-m-d H:i:s');
                    $modelDet->create_loginpemakai = Yii::app()->user->id;
                    $modelDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modelDet->jenissetoran = Params::JENISSETORAN_PPHJASADOKTER;
                    $modelDet->keterangansetoran = $detailData['keterangan'];

                    if ($modelDet->save()) {
                      $saveDetail = true;
                      $periodeGaji = MyFormatter::formatDateTimeForDb($detailData['periodejasa']);
                      $modPegGaji = PembayaranjasaT::model()->findAllByAttributes(array('periodejasa' => $periodeGaji, 'pajak_id' => $detailData['pajak_id']));

                      if (count((array)$modPegGaji) > 0) {
                        foreach ($modPegGaji as $dataGaji) {
                          $modsisahutang = new SisahutangpajakT();
                          $hitungJmlbayar = (($modelDet->jmlpembayaran / $modelDet->totalhutang) * $dataGaji->total_pajak);
                          $sisahutang = ($dataGaji->total_pajak - $hitungJmlbayar);

                          $modsisahutang->setoranpajak_id = $modelDet->setoranpajak_id;
                          $modsisahutang->pembayaranjasa_id = $dataGaji->pembayaranjasa_id;
                          $modsisahutang->jmlpembayaran = round($hitungJmlbayar, 2);
                          $modsisahutang->totalsisahutang = round($sisahutang, 2);
                          $modsisahutang->save();
                        }
                      }
                    }
                  }
                }
              }

              if (Yii::app()->user->getState('isjurnalotomatis') == true) {

                if (isset($_POST['RekeningakuntansiV'])) {
                  if (count((array)$_POST['RekeningakuntansiV']) > 0) {
                    $modJurnalRekening = $this->saveJurnalRekening($_POST['KUSetoranpajakT'], $modBuktiKeluar);

                    foreach ($_POST['RekeningakuntansiV'] as $dataRekening) {
                      $this->saveJurnalDetail($modJurnalRekening, $dataRekening['rekening5_id'], $dataRekening['saldodebit'], $dataRekening['saldokredit'], $dataRekening['nourut']);
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
    ));
  }

  /**
   * method untuk save pembayaran ke supplier 
   * digunakan di
   * 1. keuangan/PembayaranKeSupplierUmum/index
   * @param array $postBayarSupplier post request $_POST['KUBayarkesupplierT']
   * @param obj $modBayar KUBayarkesupplierT
   * @return object KUBayarkesupplierT
   */
  protected function saveBayarSupplier($postBayarSupplier, $modBayar)
  {
    $format = new MyFormatter();
    $modBayar->attributes = $postBayarSupplier;
    $modBayar->tglbayarkesupplier = $format->formatDateTimeForDB($postBayarSupplier['tglbayarkesupplier']);
    if ($modBayar->validate()) {
      $modBayar->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
    }
    return $modBayar;
  }

  /**
   * method untuk save tanda bukti keluar ke supplier 
   * digunakan di
   * 1. keuangan/PembayaranKeSupplierUmum/index
   * @param array $postBuktiKeluar post request $_POST['KUTandaBuktiKeluarT']
   * @param object $modBayarSupplier KUBayarSupplierT
   * @param object $modBuktiKeluar KUTandaBuktiKeluarT
   * @return object KUTandaBuktiKeluarT
   */
  protected function saveBuktiKeluar($postBuktiKeluar, $modBuktiKeluar)
  {
    $format = new MyFormatter();

    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($postBuktiKeluar['tglkaskeluar']);
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->no_notabayar = MyGenerator::noNotaBayar();
    $modBuktiKeluar->tahun = date('Y');
    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->succesSave = $this->succesSave && true;
    } else {
      $this->succesSave = false;
    }
    return $modBuktiKeluar;
  }

  protected function updateBayarSupplier($modBayarSupplier, $modBuktiKeluar)
  {

    KUBayarkesupplierT::model()->updateByPk($modBayarSupplier->bayarkesupplier_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
  }

  public function actionPrint($id)
  {
    $totalhutang = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $tglsetoran = "";
    $jenispajak = "PPh 21";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($id);
    $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));

    if (count((array)$model) > 0) {
      foreach ($model as $dataSetor) {
        $totalhutang += $dataSetor->totalhutang;
        $totalsisahutang += $dataSetor->totalsisahutang;
        $jmlpembayaran += $dataSetor->jmlpembayaran;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglsetoranpajak);
        //                        $jenispajak = $dataSetor->jenissetoran;
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
        'jenispajak' => $jenispajak,

      ));
    }
  }

  public function actionSetFromHutangPajak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";
      $pajak_id = isset($_POST['pajak_id']) ? $_POST['pajak_id'] : null;
      $periodetahun = isset($_POST['periodetahun']) ? $_POST['periodetahun'] : null;

      $criteria = new CDbCriteria();
      $criteria->select = "t.periodejasa, pajak_m.pajak_id, pajak_m.pajak_nama, sum(total_pajak) as total_pajak";
      $criteria->group = "t.periodejasa, pajak_m.pajak_id, pajak_m.pajak_nama";
      $criteria->join = "JOIN pajak_m ON pajak_m.pajak_id = t.pajak_id";

      $criteria->addCondition("date_part('year',t.periodejasa) = '" . $periodetahun . "'");
      if (!empty($pajak_id)) {
        $criteria->addCondition('pajak_m.pajak_id = ' . $pajak_id);
      }
      $criteria->addCondition('t.jurnalrekening_id IS NOT NULL');
      $dataDetail = PembayaranjasaT::model()->findAll($criteria);

      if (count((array)$dataDetail) > 0) {
        $no = 1;
        foreach ($dataDetail as $i => $data) {
          $pajakNilai = 0;

          $modPenggajianPegAll = PembayaranjasaT::model()->findAllByAttributes(array('periodejasa' => $data->periodejasa, 'pajak_id' => $data->pajak_id));

          if (count((array)$modPenggajianPegAll) > 0) {
            $arrCekSetoran = array();
            foreach ($modPenggajianPegAll as $dataSisaHutang) {
              $modSisaHutang = SisahutangpajakT::model()->findAllByAttributes(array('pembayaranjasa_id' => $dataSisaHutang->pembayaranjasa_id));
              if (count((array)$modSisaHutang) > 0) {
                foreach ($modSisaHutang as $dataHutang) {
                  $modSetoran = SetoranpajakT::model()->findByAttributes(array('setoranpajak_id' => $dataHutang->setoranpajak_id, 'jenissetoran' => Params::JENISSETORAN_PPHJASADOKTER, 'batalpegawai_id' => NULL));
                  if (isset($modSetoran)) {
                    $arrCekSetoran[$dataSisaHutang->periodejasa][$modSetoran->setoranpajak_id] = $modSetoran->jmlpembayaran;
                  }
                }
              }
            }
            if (isset($arrCekSetoran[$data->periodejasa]) && count((array)$arrCekSetoran[$data->periodejasa]) > 0) {
              foreach ($arrCekSetoran[$data->periodejasa] as $dataCek) {
                $pajakNilai += $dataCek;
              }
            }
          }

          $data->total_pajak = ($data->total_pajak - $pajakNilai);
          if ($data->total_pajak > 0) {
            $form .= $this->renderPartial($this->path_view . '_rowSetoran', array('modDetail' => $data, 'index' => $no), true);
            $no++;
          }
        }
      } else {
        $pesan = 'Data Setoran Hutang PPh 21 tidak ditemukan';
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

  public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldodebit, $nilaisaldokredit, $nourut)
  {
    $valid = true;

    $modelJurnalDetail = new JurnaldetailT();
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modelJurnalDetail->nourut = $nourut;
    $modelJurnalDetail->saldokredit = $nilaisaldokredit;
    $modelJurnalDetail->saldodebit = $nilaisaldodebit;

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
}
