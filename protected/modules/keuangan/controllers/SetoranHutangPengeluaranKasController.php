<?php

class SetoranHutangPengeluaranKasController extends MyAuthController
{
  public $path_view = 'keuangan.views.setoranHutangPengeluaranKas.';
  public $tandabuktikeluartersimpan = false;
  public $pengeluaranumumtersimpan = false;
  public $pembayarankesuppliertersimpan = false;
  public $succesSave = true;
  public $pesan = '';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Setoran Pajak Ppn Keluar";
    $format = new MyFormatter();
    $model = new KUSetoranpajakT();
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $model->jenissetoran = Params::JENISSETORAN_PENGELUARANKAS;
    $modBuktiKeluar->nokaskeluar = "Otomatis";

    $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranPajakHutang($model->jenissetoran);
    $modBuktiKeluar->untukpembayaran = "Setoran Pajak PPh Final - " . $modBuktiKeluar->no_setorpajakpembelian;

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

              if (isset($_POST['PengeluaranumumT']) && count((array)$_POST['PengeluaranumumT']) > 0) {

                foreach ($_POST['PengeluaranumumT'] as $detailData) {
                  if ($detailData['checklist'] == 1) {
                    $modelDet = new KUSetoranpajakT();
                    $modelDet->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                    $modelDet->tglsetoranpajak = $format->formatDateTimeForDB($_POST['KUSetoranpajakT']['tglsetoranpajak']);
                    $modelDet->totalhutang = $detailData['totalpajak'];
                    $modelDet->jmlpembayaran = $detailData['jmlsetoran'];
                    $modelDet->totalsisahutang = $detailData['sisahutang'];
                    $modelDet->create_time = date('Y-m-d H:i:s');
                    $modelDet->create_loginpemakai = Yii::app()->user->id;
                    $modelDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modelDet->jenissetoran = Params::JENISSETORAN_PENGELUARANKAS;
                    $modelDet->keterangansetoran = $detailData['keterangan'];
                    $modelDet->pengeluaranumum_id = $detailData['pengeluaranumum_id'];
                    $modelDet->pajak_id = $detailData['pajak_id'];

                    if ($modelDet->save()) {
                      $saveDetail = true;
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
      $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : null;
      $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : null;
      $jenispengeluaran_id = ((!empty($_POST['jenispengeluaran_id']) && $_POST['jenispengeluaran_id'] != 'null') ? $_POST['jenispengeluaran_id'] : null);

      $selectpajak = "";
      $joinpajakid = "";
      $pajakidattr = "";

      if (!empty($pajak_id)) {
        if ($pajak_id == 1) {
          $selectpajak = "t.jmlpph_21";
          $joinpajakid = "t.pph21_id";
          $pajakidattr = "pph21_id";
        } else if ($pajak_id == 2) {
          $selectpajak = "t.jmlpph_22";
          $joinpajakid = "t.pph22_id";
          $pajakidattr = "pph22_id";
        } else if ($pajak_id == 5) {
          $selectpajak = "t.jmlpph_23";
          $joinpajakid = "t.pph23_id";
          $pajakidattr = "pph23_id";
        }
      }

      $criteria = new CDbCriteria();
      $criteria->select = "t.pengeluaranumum_id, t.nopengeluaran, t.tglpengeluaran, pajak_m.pajak_id, pajak_m.pajak_nama, jenispengeluaran_m.jenispengeluaran_nama, $selectpajak as totalpajak";
      $criteria->join = "JOIN jenispengeluaran_m ON jenispengeluaran_m.jenispengeluaran_id = t.jenispengeluaran_id "
        . "JOIN pajak_m on pajak_m.pajak_id = $joinpajakid";

      $criteria->addBetweenCondition('date(tglpengeluaran)', $tgl_awal, $tgl_akhir);

      if (!empty($pajak_id)) {
        $criteria->addCondition($joinpajakid . ' = ' . $pajak_id);
      }

      if (is_array($jenispengeluaran_id)) {
        $criteria->addInCondition('t.jenispengeluaran_id', $jenispengeluaran_id);
      } else {
        if (!empty($jenispengeluaran_id)) {
          $criteria->addCondition('t.jenispengeluaran_id = ' . $jenispengeluaran_id);
        }
      }

      $dataDetail = PengeluaranumumT::model()->findAll($criteria);

      if (count((array)$dataDetail) > 0) {
        $no = 1;
        foreach ($dataDetail as $i => $data) {
          $modSetoran = SetoranpajakT::model()->findByAttributes(array('pengeluaranumum_id' => $data->pengeluaranumum_id, 'jenissetoran' => Params::JENISSETORAN_PENGELUARANKAS, 'batalpegawai_id' => NULL, 'pajak_id' => $data->pajak_id));
          $pajakNilai = (isset($modSetoran) ? $modSetoran->jmlpembayaran : 0);

          //                    $jenispph = false;
          //                    $criteriaPeg = new CDbCriteria();
          //                    $criteriaPeg->select = "t.penggajianpeg_id, t.periodegaji";
          //                    $criteriaPeg->group = "t.penggajianpeg_id, t.periodegaji";
          //                    $criteriaPeg->addCondition("date(t.periodegaji) = '".$data->periodegaji."'");
          //                    $criteriaPeg->addCondition("t.pajak_id = ".$data->pajak_id);
          //                    $criteriaPeg->addCondition('t.jurnalrekening_id IS NOT NULL');
          //                    $modPenggajianPegAll = PenggajianpegT::model()->findAll($criteriaPeg);
          ////                    $modPenggajianPegAll = PenggajianpegT::model()->findAllByAttributes(array('periodegaji'=>$data->periodegaji ,'pajak_id'=>$data->pajak_id));
          //                    
          //                    if(count((array)$modPenggajianPegAll) > 0){
          //                        $arrCekSetoran = array();
          //                        foreach ($modPenggajianPegAll as $dataSisaHutang){
          //                            $modSisaHutang = SisahutangpajakT::model()->findAllByAttributes(array('penggajianpeg_id'=>$dataSisaHutang->penggajianpeg_id));
          //                            if(count((array)$modSisaHutang) > 0){
          //                                foreach ($modSisaHutang as $dataHutang){
          //                                    $modSetoran = SetoranpajakT::model()->findByAttributes(array('setoranpajak_id'=>$dataHutang->setoranpajak_id ,'jenissetoran'=>Params::JENISSETORAN_PPHPEGAWAI, 'batalpegawai_id'=>NULL));
          //                                    if(isset($modSetoran)){
          //                                        $arrCekSetoran[$dataSisaHutang->periodegaji][$modSetoran->setoranpajak_id] = $modSetoran->jmlpembayaran;
          //                                    }
          //                                }
          //                            }
          //                        }
          //                        if(isset($arrCekSetoran[$data->periodegaji]) && count((array)$arrCekSetoran[$data->periodegaji]) > 0){
          //                            foreach ($arrCekSetoran[$data->periodegaji] as $dataCek){
          //                                $pajakNilai += $dataCek;
          //                            }
          //                        }
          //                    }

          //                    if(!empty($data->pph21_id)){
          //                        if($data->jmlpph_21 > 0){
          //                            $jenispph = true;
          ////                            $data->jmlpph_21 = ($data->jmlpph_21 - $pajakNilai);
          //                        }
          //                    }else if(!empty($data->pph22_id)){
          //                         if($data->jmlpph_22 > 0){
          //                             $jenispph = true;
          ////                            $data->jmlpph_21 = ($data->jmlpph_21 - $pajakNilai);
          //                        }
          //                    }else if(!empty($data->pph23_id)){
          //                         if($data->jmlpph_23 > 0){
          //                             $jenispph = true;
          ////                            $data->jmlpph_21 = ($data->jmlpph_21 - $pajakNilai);
          //                        }
          //                    }
          $data->totalpajak = ($data->totalpajak - $pajakNilai);
          if ($data->totalpajak > 0) {
            $form .= $this->renderPartial($this->path_view . '_rowSetoran', array('modDetail' => $data, 'index' => $no), true);
            $no++;
          }
        }
      } else {
        $pesan = 'Data Setoran Hutang Pajak Pengeluaran Kas  tidak ditemukan';
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
      $pajak_id = isset($_POST['pajak_id']) ? $_POST['pajak_id'] : null;
      $dataArr = "";

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
      $criteria->addCondition("pajak_id = " . $pajak_id);
      $model = KUPajakM::model()->findAll($criteria);

      if (isset($jmlBayar) && $jmlBayar > 0 && !empty($pajak_id)) {
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

  //    public function actionAmbilDataRekColumn() {
  //        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
  //            $jmlBayar = isset($_POST['jmlBayar']) ? $_POST['jmlBayar'] : 0;
  //            $biayamaterai = isset($_POST['biayamaterai']) ? $_POST['biayamaterai'] : 0;
  //            
  //            $criteria = new CDbCriteria;
  //            $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
  //                    . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
  //                    . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
  //                    . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
  //                    . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
  //            $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
  //            
  //            $criteria->addCondition("debitkredit = 'D'");
  //            $dataArr = "";
  //            if(isset($jmlBayar) && $jmlBayar > 0){
  //                $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_SETORANPAJAKT,false);
  //                $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_SETORANPAJAKPPH,false);
  //                $model = RekeningcolumnM::model()->findAll($criteria);
  //                
  //                if (count((array)$model) > 0) {
  //                    $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D','tr'=>'trDebitPPh', 'nourut'=>1), true);
  //                }
  //            }
  //            
  //            $criteria = new CDbCriteria;
  //            $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
  //                    . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
  //                    . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
  //                    . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
  //                    . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
  //            $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
  //            
  //            $criteria->addCondition("debitkredit = 'D'");
  //            
  //            if(isset($biayamaterai) && $biayamaterai > 0){
  //                $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART,false);
  //                $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI,false);
  //                $model = RekeningcolumnM::model()->findAll($criteria);
  //                
  //                if (count((array)$model) >0) {
  //                    $dataArr .=$this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D','tr'=>'trDebitMaterai', 'nourut'=>2), true);
  //                    
  //                }
  //            }
  //            echo CJSON::encode($dataArr);
  //            
  //            Yii::app()->end();
  //        }
  //    }
}
