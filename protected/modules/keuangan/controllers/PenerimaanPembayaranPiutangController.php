<?php

class PenerimaanPembayaranPiutangController extends MyAuthController
{
  public $path_view = 'keuangan.views.penerimaanPembayaranPiutang.';
  public $tandabuktikeluartersimpan = false;
  public $pengeluaranumumtersimpan = false;
  public $pembayarankesuppliertersimpan = false;
  public $succesSave = true;
  public $pesan = '';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KUPembpiutangbankT();
    $modBuktiBayar = new KUTandabuktibayarT();
    $modBuktiBayar->nobuktibayar = "Otomatis";

    $model->nopembayaran = MyGenerator::noPenerimaanPembayaranPiutang();
    $modBuktiBayar->sebagaipembayaran_bkm = "Pembayaran Piutang - " . $model->nopembayaran;
    $modBuktiBayar->carapembayaran = 'TRANSFER';

    if (isset($_POST['KUPembpiutangbankT']) && isset($_POST['KUTandabuktibayarT'])) {
      $transaction = Yii::app()->db->beginTransaction();

      try {
        if (isset($_POST['KUTandabuktibayarT'])) {
          $modBuktiBayar->attributes = $_POST['KUTandabuktibayarT'];
          $modBuktiBayar->tglbuktibayar = $format->formatDateTimeForDB($_POST['KUTandabuktibayarT']['tglbuktibayar']);
          $modBuktiBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modBuktiBayar->shift_id = Yii::app()->user->getState('shift_id');
          $modBuktiBayar->nourutkasir = 1;
          $modBuktiBayar->sebagaipembayaran_bkm = $_POST['KUTandabuktibayarT']['sebagaipembayaran_bkm'];
          $modBuktiBayar->darinama_bkm = $_POST['KUTandabuktibayarT']['namapengirim'];
          $modBuktiBayar->alamat_bkm = $_POST['KUTandabuktibayarT']['alamatpengirim'];
          $modBuktiBayar->jmlpembulatan = 0;
          $modBuktiBayar->jmlpembayaran = (!empty($_POST['KUPembpiutangbankT']['totalbayar']) ? $_POST['KUPembpiutangbankT']['totalbayar'] : 0);
          $modBuktiBayar->uangkembalian = 0;
          $modBuktiBayar->create_time = date('Y-m-d H:i:s');
          $modBuktiBayar->create_loginpemakai_id = Yii::app()->user->id;
          $modBuktiBayar->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modBuktiBayar->nobuktibayar = MyGenerator::noBuktiBayar();
          $modBuktiBayar->keterangan_pembayaran = 0;

          if ($modBuktiBayar->validate()) {
            if ($modBuktiBayar->save()) {
              $this->tandabuktikeluartersimpan = true;
              $saveDetail = false;
              $savePemb = false;

              if (isset($_POST['KUPembpiutangbankT'])) {
                $model->attributes = $_POST['KUPembpiutangbankT'];
                $model->tglpembayaran = $format->formatDateTimeForDB($_POST['KUPembpiutangbankT']['tglpembayaran']);
                $model->nopembayaran = MyGenerator::noPenerimaanPembayaranPiutang();
                $model->carapembayaran = $modBuktiBayar->carapembayaran;
                $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                  $savePemb = true;
                  $pembayaranpelayanan_id = null;
                  $pembjnspembayar_id = null;
                  $pembbank_id = null;

                  if (isset($_POST['PenerimaanbayarpiutangV']) && count((array)$_POST['PenerimaanbayarpiutangV']) > 0) {
                    foreach ($_POST['PenerimaanbayarpiutangV'] as $detailData) {
                      if ($detailData['checklist'] == 1) {
                        $modelDet = new KUPembpiutangbankdetailT();
                        $modelDet->attributes = $detailData;
                        $modelDet->pembpiutangbank_id = $model->pembpiutangbank_id;
                        $modelDet->tandabuktibayar_id = $modBuktiBayar->tandabuktibayar_id;
                        $modelDet->bank_id  = $detailData['bankpenerima_id'];
                        $modelDet->keterangan = $detailData['keterangan'];
                        $modelDet->jmlpiutang = $detailData['jumlahpembayaran'];
                        $modelDet->jmlbayar = $detailData['jmldibayarkan'];
                        $modelDet->jmlsisapiutang = $detailData['sisahutang'];
                        $modBuktiBayarKasir = KUTandabuktibayarT::model()->findByPk($detailData['tandabuktibayar_id']);
                        $pembayaranpelayanan_id = $detailData['pembayaranpelayanan_id'];

                        if ($modelDet->save()) {
                          $saveDetail = true;
                          $pembjnspembayar_id = $modelDet->jnspembayar_id;
                          $pembbank_id = $modelDet->bank_id;

                          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                            $modJurnalRekening = $this->saveJurnalRekening($model, $modelDet, $modBuktiBayar, $modBuktiBayarKasir);
                            $rekening5Db_id = null;
                            $nourutJurnal = 2;

                            if ($modBuktiBayar->carapembayaran == Params::CARAPEMBAYARAN_TRANSFER) {
                              if (!empty($modBuktiBayar->bank_id)) {
                                $modBankRek = BankrekM::model()->findByAttributes(array('bank_id' => $modBuktiBayar->bank_id, 'debitkredit' => 'D'));

                                if (isset($modBankRek) && !empty($modBankRek)) {
                                  $rekening5Db_id = $modBankRek->rekening5_id;
                                }
                              }
                            } else {
                              $modRekColumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIBAYART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_TANDABUKTIBAYARCASH, 'debitkredit' => 'D'));

                              if (isset($modRekColumn) && !empty($modRekColumn)) {
                                $rekening5Db_id = $modRekColumn->rekening5_id;
                              }
                            }

                            if (!empty($rekening5Db_id)) {
                              $this->saveJurnalDetail($modJurnalRekening, $rekening5Db_id, $modelDet->jmlpenerimaan, 0, 1);
                            }

                            if ($modBuktiBayar->biayaadministrasi > 0) {
                              $nourutJurnal = 3;
                              //Debit administrasi
                              $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIBAYART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAADMINISTRASI, 'debitkredit' => 'D'));
                              if (isset($rekeningcolumn)) {
                                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modelDet->biayaadministrasi, 0, 'D', 2);
                              }
                            }

                            if ($modBuktiBayar->biayamaterai > 0) {
                              if ($modBuktiBayar->biayamaterai > 0) {
                                $nourutJurnal = 4;
                              } else {
                                $nourutJurnal = 3;
                              }

                              //Debit biayaongkos_kirim
                              $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TANDABUKTIBAYART, 'column_name' => Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAIBAYAR, 'debitkredit' => 'D'));
                              if (isset($rekeningcolumn)) {
                                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modelDet->biaya_materai, 0, 'D', 3);
                              }
                            }

                            if (!empty($pembjnspembayar_id)) {
                              if (!empty($pembayaranpelayanan_id)) {
                                $modPembayaranT = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);

                                if (isset($modPembayaranT) && !empty($modPembayaranT)) {
                                  $modRekJurnalPemb = JurnalrekeningT::model()->findByAttributes(array('tandabuktibayar_id' => $modPembayaranT->tandabuktibayar_id));

                                  if (isset($modRekJurnalPemb) && !empty($modRekJurnalPemb)) {
                                    $jurnaldetailPemb = JurnaldetailT::model()->findByAttributes(array('jurnalrekening_id' => $modRekJurnalPemb->jurnalrekening_id, 'jnspembayar_id' => $pembjnspembayar_id, 'bank_id' => $pembbank_id));

                                    if (isset($jurnaldetailPemb) && !empty($jurnaldetailPemb)) {
                                      $this->saveJurnalDetail($modJurnalRekening, $jurnaldetailPemb->rekening5_id, 0, $modelDet->jmlbayar, 'K', $nourutJurnal);
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                } else {
                  $savePemb = false;
                }
              }
              if ($savePemb && $saveDetail) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->redirect(array('index', 'tandabuktibayar_id' => $modBuktiBayar->tandabuktibayar_id, 'sukses' => 1));
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
      'modBuktiBayar' => $modBuktiBayar,
    ));
  }

  public function actionPrint($id)
  {
    $modBuktibayar = TandabuktibayarT::model()->findByPk($id);
    $modPembDetail = KUPembpiutangbankdetailT::model()->findAllByAttributes(array('tandabuktibayar_id' => $id));
    $pemb_id = null;
    $jenispembayaran = "";
    $banknama = "";

    if (isset($modPembDetail) && count((array)$modPembDetail) > 0) {
      foreach ($modPembDetail as $dataPem) {
        $pemb_id = $dataPem->pembpiutangbank_id;
        $banknama = (isset($dataPem->bank) ? $dataPem->bank->namabank : "-");
        $jenispembayaran = (isset($dataPem->jnspembayar) ? $dataPem->jnspembayar->jnspembayar_nama : "");
      }
    }
    $model = KUPembpiutangbankT::model()->findByPk($pemb_id);

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array(
        'caraPrint' => $caraPrint,
        'modBuktibayar' => $modBuktibayar,
        // 'totalhutang' => $totalhutang,
        // 'totalsisahutang' => $totalsisahutang,
        'banknama' => $banknama,
        'jenispembayaran' => $jenispembayaran,
        'model' => $model,
        'modPembDetail' => $modPembDetail,

      ));
    }
  }

  public function actionSetFromPembayaranPiutang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = 'Data tidak ditemukan';

      if (isset($_POST['KUPembpiutangbankT'])) {
        $tglawal = MyFormatter::formatDateTimeForDb($_POST['KUPembpiutangbankT']['tgl_awal']);
        $tglakhir = MyFormatter::formatDateTimeForDb($_POST['KUPembpiutangbankT']['tgl_akhir']);
        $ceklis = $_POST['KUPembpiutangbankT']['ceklis'];
        $tgljthtempo_awal = MyFormatter::formatDateTimeForDb($_POST['KUPembpiutangbankT']['tgljthtempo_awal']);
        $tgljthtempo_akhir = MyFormatter::formatDateTimeForDb($_POST['KUPembpiutangbankT']['tgljthtempo_akhir']);
        $nopembayaran = $_POST['KUPembpiutangbankT']['nopembayaran_srch'];

        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date(tglpembayaran)', $tglawal, $tglakhir);

        if ($ceklis) {
          $criteria->addBetweenCondition('date(tgljatuhtempo)', $tgljthtempo_awal, $tgljthtempo_akhir);
        }
        $criteria->compare('lower(nopembayaran)', strtolower($nopembayaran), true);

        if (isset($_POST['KUPembpiutangbankT']['jenispembayaran_id'])) {
          if (is_array($_POST['KUPembpiutangbankT']['jenispembayaran_id'])) {

            $criteria->addInCondition('jnspembayar_id', $_POST['KUPembpiutangbankT']['jenispembayaran_id']);
          } else {
            if (!empty($_POST['KUPembpiutangbankT']['jenispembayaran_id'])) {
              $criteria->addCondition('jnspembayar_id = ' . $_POST['KUPembpiutangbankT']['jenispembayaran_id']);
            }
          }
        }

        if (isset($_POST['KUPembpiutangbankT']['bank_id'])) {
          if (is_array($_POST['KUPembpiutangbankT']['bank_id'])) {
            $criteria->addInCondition('bankpenerima_id', $_POST['KUPembpiutangbankT']['bank_id']);
          } else {
            if (!empty($_POST['KUPembpiutangbankT']['bank_id'])) {
              $criteria->addCondition('bankpenerima_id = ' . $_POST['KUPembpiutangbankT']['bank_id']);
            }
          }
        }

        $listData = PenerimaanbayarpiutangV::model()->findAll($criteria);

        if (count((array)$listData) > 0) {
          $pesan = '';
          $no = 1;
          foreach ($listData as $modList) {
            $pajakNilai = 0;
            $criteriaDt = new CDbCriteria();
            $criteriaDt->join = "JOIN pembpiutangbank_t ON pembpiutangbank_t.pembpiutangbank_id = t.pembpiutangbank_id";
            $criteriaDt->addCondition('t.pembayaranpelayanan_id = ' . $modList->pembayaranpelayanan_id);
            $criteriaDt->addCondition('t.jnspembayar_id = ' . $modList->jnspembayar_id);
            if (!empty($modList->bankpenerima_id)) {
              $criteriaDt->addCondition('t.bank_id = ' . $modList->bankpenerima_id);
            }
            $criteriaDt->addCondition('pembpiutangbank_t.pegawaibatal_id IS NULL');
            $modDetPiutang = KUPembpiutangbankdetailT::model()->findAll($criteriaDt);
            // $modDetPiutang = KUPembpiutangbankdetailT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>$modList->pembayaranpelayanan_id, 'jnspembayar_id'=>$modList->jnspembayar_id, 'bank_id'=>$modList->bankpenerima_id),array('pegawaibatal_id IS NULL'));
            $modList->bayarke = 1;
            if (isset($modDetPiutang) && count((array)$modDetPiutang) > 0) {
              foreach ($modDetPiutang as $detPiutang) {
                $pajakNilai += $detPiutang->jmlbayar;
              }
            }

            $criteriaDt2 = new CDbCriteria();
            $criteriaDt2->join = "JOIN pembpiutangbank_t ON pembpiutangbank_t.pembpiutangbank_id = t.pembpiutangbank_id";
            $criteriaDt2->addCondition('t.pembayaranpelayanan_id = ' . $modList->pembayaranpelayanan_id);
            $criteriaDt2->addCondition('t.jnspembayar_id = ' . $modList->jnspembayar_id);
            if (!empty($modList->bankpenerima_id)) {
              $criteriaDt2->addCondition('t.bank_id = ' . $modList->bankpenerima_id);
            }
            $criteriaDt2->addCondition('pembpiutangbank_t.pegawaibatal_id IS NULL');
            $criteriaDt2->order = "bayarke DESC";
            $criteriaDt2->limit = 1;
            $modDetPiutangBayar = KUPembpiutangbankdetailT::model()->find($criteriaDt2);
            // $modDetPiutangBayar = KUPembpiutangbankdetailT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modList->pembayaranpelayanan_id, 'jnspembayar_id'=>$modList->jnspembayar_id, 'bank_id'=>$modList->bankpenerima_id),array('order'=>'bayarke DESC'));
            if (isset($modDetPiutangBayar) && !empty($modDetPiutangBayar)) {
              $modList->bayarke = ($modDetPiutangBayar->bayarke + 1);
            }

            $modList->jumlahpembayaran = ($modList->jumlahpembayaran - $pajakNilai);
            if ($modList->jumlahpembayaran > 0) {
              $form .= $this->renderPartial($this->path_view . '_rowSetoran', array('modDetail' => $modList, 'index' => $no), true);
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


  protected function saveJurnalRekening($model, $modDetail, $modBuktiBayar, $modBuktiBayarKasir)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpembayaran);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nopembayaran;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpembayaran);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "Pembayaran Piutang " . (isset($modDetail->jnspembayar) ? $modDetail->jnspembayar->jnspembayar_nama : "") . " " . (isset($modDetail->bank) ? $modDetail->bank->namabank : "") . ' - ' . (isset($modBuktiBayarKasir->pembayaranpelayanan) ? $modBuktiBayarKasir->pembayaranpelayanan->nopembayaran : "");

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->pembpiutangbankdetail_id = $modDetail->pembpiutangbankdetail_id;

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


  // public function actionAmbilDataRekeningCarabayar() {
  //     if (Yii::app()->getRequest()->getIsAjaxRequest()) {
  //         $carabayar = isset($_POST['carabayar']) ? $_POST['carabayar'] : null;
  //         $bankid = isset($_POST['bankid']) ? $_POST['bankid'] : null;
  //
  //         $criteria = new CDbCriteria;
  //         $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
  //                 . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
  //                 . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
  //                 . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
  //                 . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
  //         $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
  //
  //         if(!empty($bankid)){
  //             $criteria->addCondition("t.bank_id = ".$bankid);
  //             $criteria->addCondition("t.debitkredit = 'K'");
  //         }else{
  //             if (!empty($carabayar)) {
  //                 $criteria->addCondition("t.carabayarkeluar = 'TUNAI'");
  //                 $criteria->addCondition("t.debitkredit = 'K'");
  //              }
  //         }
  //         $criteria->order = 't.debitkredit ASC';
  //         $criteria->limit = 1;
  //
  //        if(!empty($bankid)){
  //             $model = BankrekM::model()->findAll($criteria);
  //         }else{
  //             if (!empty($carabayar)) {
  //                 $model = CarabayarkeluarrekM::model()->findAll($criteria);
  //             }
  //         }
  //
  //         if (count((array)$model) > 0) {
  //             echo CJSON::encode(
  //                     $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'K','tr'=>'trKreditCarabayar', 'nourut'=>3), true)
  //             );
  //         }
  //         Yii::app()->end();
  //     }
  // }

  // public function actionAmbilDataRekColumn() {
  //     if (Yii::app()->getRequest()->getIsAjaxRequest()) {
  //         $jmlBayar = isset($_POST['jmlBayar']) ? $_POST['jmlBayar'] : 0;
  //         $biayamaterai = isset($_POST['biayamaterai']) ? $_POST['biayamaterai'] : 0;
  //         $pajak_id = isset($_POST['pajak_id']) ? $_POST['pajak_id'] : null;
  //         $dataArr = "";
  //
  //         $criteria = new CDbCriteria;
  //         $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
  //                 . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
  //                 . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
  //                 . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
  //                 . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
  //         $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
  //         $criteria->addCondition("pajak_id = ".$pajak_id);
  //         $model = KUPajakM::model()->findAll($criteria);
  //
  //         if(isset($jmlBayar) && $jmlBayar > 0 && !empty($pajak_id)){
  //             if (count((array)$model) > 0) {
  //                 $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D','tr'=>'trDebitPPh', 'nourut'=>1), true);
  //             }
  //         }
  //
  //         $criteria = new CDbCriteria;
  //         $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
  //                 . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
  //                 . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
  //                 . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
  //                 . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
  //         $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
  //
  //         $criteria->addCondition("debitkredit = 'D'");
  //
  //         if(isset($biayamaterai) && $biayamaterai > 0){
  //             $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART,false);
  //             $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI,false);
  //             $model = RekeningcolumnM::model()->findAll($criteria);
  //
  //             if (count((array)$model) >0) {
  //                 $dataArr .=$this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D','tr'=>'trDebitMaterai', 'nourut'=>2), true);
  //
  //             }
  //         }
  //         echo CJSON::encode($dataArr);
  //
  //         Yii::app()->end();
  //     }
  // }

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
