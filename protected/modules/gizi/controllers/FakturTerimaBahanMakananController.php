<?php

class FakturTerimaBahanMakananController extends MyAuthController
{
  public $path_view = 'gizi.views.fakturTerimaBahanMakanan.';
  public $succesSave = true;
  public $successSave = true;
  public $pesan = "";

  public function actionAutocompleteTerimaBahanMakanan($term = null)
  {
    $model = new GZTerimabahanmakan;
    $model->nopenerimaanbahan = $term;

    $prov = $model->searchInformasiUntukFaktur();
    $prov->pagination = false;

    $res = array();
    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nopenerimaanbahan . " - " . MyFormatter::formatDateTimeForUser($item->tglterimabahan);
      $sub['value'] = $item->terimabahanmakan_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionIndex($id = null, $linkHalaman = null)
  {
    $model = new GZTerimabahanmakan;
    $model->tglfaktur = date('d M Y H:i:s');
    $model->tgljatuhtempo = date('d M Y H:i:s');
    $modDetail = array();
    $modUangmuka = new UangmukabeliT();

    if (!empty($id)) {
      $model = GZTerimabahanmakan::model()->findByPk($id);
      $supplier = null;
      if (!empty($model->supplier_id)) {
        $supplier = SupplierM::model()->findByPk($model->supplier_id);
      }

      if (!empty($supplier)) {
        $model->supplier_nama = $supplier->supplier_nama;
      }
    }

    if (isset($_POST['GZTerimabahanmakan'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $model = GZTerimabahanmakan::model()->findByPk($_POST['GZTerimabahanmakan']['terimabahanmakan_id']);
      $model->attributes = $_POST['GZTerimabahanmakan'];
      $model->tglterimabahan = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglterimabahan']);
      $model->tglsurjalan = (!empty($_POST['GZTerimabahanmakan']['tglsurjalan']) ? MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglsurjalan']) : null);
      $model->tgljatuhtempo = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tgljatuhtempo']);
      $model->tglfaktur = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglfaktur']);
      //            $model->persenpph = isset($_POST['GZTerimabahanmakan']['persenpph_22'])?MyFormatter::formatNumberForDb($_POST['GZTerimabahanmakan']['persenpph_22']):0;

      if ($model->validate()) {
        $ok = $ok && $model->save();
      } else {
        $ok = false;
      }

      if (isset($_POST['GZTerimabahandetailT'])) {
        foreach ($_POST['GZTerimabahandetailT'] as $item) {
          $detail = GZTerimabahandetailT::model()->findByPk($item['terimabahandetail_id']);
          $detail->attributes = $item;

          if ($detail->validate()) {
            $ok = $ok && $detail->save();
            $ok = $ok && $this->updateBahanMakanan($_POST['GZTerimabahanmakan'], $detail, $item);
          } else {
            $ok = false;
          }
        }
      }

      if ($ok) {

        if (Yii::app()->user->getState('isjurnalotomatis') == true) {
          $checkDatadetail = 0;
          $modDetailTerima = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

          if (count((array)$modDetailTerima) > 0) {
            foreach ($modDetailTerima as $dtFakturDetail) {
              $modBahanmknM = BahanmakananM::model()->findByPk($dtFakturDetail->bahanmakanan_id);

              if (isset($modBahanmknM)) {
                if (!empty($modBahanmknM->kelbahanmakanan)) {
                  $modKelBahanMknRek = KelbahanmakananrekM::model()->findAllByAttributes(array('kelbahanmakanan' => $modBahanmknM->kelbahanmakanan, 'ispenerimaan' => true));

                  if (count((array)$modKelBahanMknRek) > 0) {
                    $checkDatadetail++;
                  } else {
                    if ($checkDatadetail > 1) {
                      $checkDatadetail--;
                    }
                  }
                }
              }
            }
          }

          if ($checkDatadetail > 0) {
            foreach ($modDetailTerima as $dtFakturDetail) {
              $modBahanmknM = BahanmakananM::model()->findByPk($dtFakturDetail->bahanmakanan_id);
              if (isset($modBahanmknM)) {
                if (!empty($modBahanmknM->kelbahanmakanan)) {
                  $modKelBahanMknRek = KelbahanmakananrekM::model()->findAllByAttributes(array('kelbahanmakanan' => $modBahanmknM->kelbahanmakanan, 'ispenerimaan' => true));

                  if (count((array)$modKelBahanMknRek) > 0) {
                    $modJurnalRekening = $this->saveJurnalRekening($model, $dtFakturDetail);
                    foreach ($modKelBahanMknRek as $dtkelmknrek) {
                      $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $dtkelmknrek);
                    }
                    if ($model->pajakppn > 0) {
                      $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMABAHANDETAILT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_TERIMABAHANDETAILID . "'");
                      if (isset($rekeningcolumn)) {
                        $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, true);
                      }
                    }
                    if ($model->pajakpph > 0) {
                      $modPajak = PajakM::model()->findByPk($model->pajak_id);

                      if (isset($modPajak)) {
                        if (!empty($modPajak->rekening5_id)) {
                          $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $modPajak, null, true);
                        }
                      }

                      //                                                $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_TERIMABAHANMAKANT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_PERSENPPH."'");

                    }
                  }
                }
              }
            }
          }

          $modJurnalFaktuAfter = JurnalrekeningT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

          if (count((array)$modJurnalFaktuAfter) > 0) {
            $rekening_id = null;

            foreach ($modJurnalFaktuAfter as $dataFakturAf) {
              $criteriaJud = new CDbCriteria();
              $criteriaJud->addCondition('jurnalrekening_id = ' . $dataFakturAf->jurnalrekening_id);
              $criteriaJud->addCondition('saldokredit > 0');
              $criteriaJud->order = "nourut DESC";
              $criteriaJud->limit = 1;
              $modFakturJurDetAfter = JurnaldetailT::model()->find($criteriaJud);

              if (isset($modFakturJurDetAfter)) {
                $rekening_id = $modFakturJurDetAfter->rekening5_id;
              }
            }

            if (!empty($model->jmluangmukabeli) && $model->jmluangmukabeli > 0) {
              $modJurnalRekening = $this->saveJurnalRekeningUangMuka($model);

              $modRekening5 = Rekening5M::model()->findByPk($rekening_id);

              if (isset($modRekening5)) {
                $this->saveJurnalDetailUangMuka($modJurnalRekening, $modRekening5, $model->jmluangmukabeli, 'D', 1);
              }

              $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TERIMABAHANMAKANT, 'column_name' => Params::REKENINGCOLUMN_COLUMN_JMLUANGMUKABELI));
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetailUangMuka($modJurnalRekening, $rekeningcolumn, $model->jmluangmukabeli, 'K', 2);
              }
            }
          }
        }

        $this->notifFakturTerimaBahanMakanan($model);

        //$this->notifPenerimaanKas($model);

        $trans->commit();
        // $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session['modul_id']));
        //$transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('index', 'id' => $model->terimabahanmakan_id, 'sukses' => 1));
        // $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session->modul_id));
        //$this->refresh();
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'modUangmuka' => $modUangmuka,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function updateBahanMakanan($post, $detail, $postdetail)
  {
    $ok = true;
    $bahan = BahanmakananM::model()->findByPk($detail->bahanmakanan_id);

    $jmlDiskon = (($detail['harganettobhn'] * $detail['persendiscount']) / 100);
    $jmlPpn = ((($detail['harganettobhn'] - $jmlDiskon) * $detail['persenppn']) / 100);
    $jmlPph = ((($detail['harganettobhn'] - $jmlDiskon) * $detail['persenpph']) / 100);
    $subtotal = ($detail['harganettobhn'] - $jmlDiskon + $jmlPpn + $jmlPph);

    $updateHarganetto = false;

    if ($bahan->harganettobahan != $detail['harganettobhn']) {
      if ($postdetail['hppcheck'] > 0) {
        $updateHarganetto = true;
      }
    }
    if ($updateHarganetto) {
      $bahan->harganettobahan = $detail['harganettobhn'];
      $judul = 'Perubahan Harga Netto Bahan Makanan';
      $isi = $bahan->namabahanmakanan;
      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => Params::INSTALASI_ID_GIZI, 'ruangan_id' => Params::RUANGAN_ID_GIZI, 'modul_id' => Params::MODUL_ID_GIZI),
      ));
    }
    $bahan->hargajualbahan = $subtotal;
    $bahan->discount = $jmlDiskon;

    //        $persen_diskon = ($post['totaldiscount']/$post['totalharganetto']) * 100;

    //        $bahan->harganettobahan = round($detail->harganettobhn * (100 - $persen_diskon) / 100);
    //        $bahan->hargajualbahan = $bahan->harganettobahan;
    //        $bahan->discount = $bahan->harganettobahan * $persen_diskon / 100;


    if ($bahan->validate()) {
      $ok = $ok && $bahan->save();
    } else {
      $ok = false;
    }

    return $ok;
  }

  public function actionGetTerimaBahanMakanan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $terima = GZTerimabahanmakan::model()->findByPk($id);

    if (empty($terima)) {
      $ok = 0;
    } else {
      $ok = 1;
      $detail = GZTerimabahandetailT::model()->findAllByAttributes(array(
        'terimabahanmakan_id' => $id,
      ));

      $supplier = SupplierM::model()->findByPk($terima->supplier_id);
      if (!empty($supplier)) {
        $terima->supplier_nama = $supplier->supplier_nama;
      }

      $jmluangmukabeli = 0;
      $checkuangmuka = false;
      $tglbayaruangmuka = "";
      $nobayaruangmuka = "";
      if (!empty($terima->pengajuanbahanmkn_id)) {
        $modUangMuka = UangmukabeliT::model()->findByAttributes(array('pengajuanbahanmkn_id' => $terima->pengajuanbahanmkn_id));
        if (isset($modUangMuka)) {
          $jmluangmukabeli = $modUangMuka->jumlahuang;
          $checkuangmuka = true;
          $tglbayaruangmuka = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
          $nobayaruangmuka = $modUangMuka->nopembayaran;
        }
      }

      $data = $terima->attributes;
      $data['supplier_nama'] = $terima->supplier_nama;
      $data['detail'] = '';
      $pengajuan = PengajuanbahanmknT::model()->findByPk($terima->pengajuanbahanmkn_id);

      $data['nopengajuan'] = (isset($pengajuan) ? $pengajuan->nopengajuan : "");
      $data['jumlahuangmuka'] = $jmluangmukabeli;
      $data['tglbayaruangmuka'] = $tglbayaruangmuka;
      $data['nobayaruangmuka'] = $nobayaruangmuka;
      $data['pajak_nama'] = (isset($terima->pajak) ? $terima->pajak->pajak_nama : "");

      foreach ($detail as $item) {
        $data['detail'] .= $this->renderPartial($this->path_view . '_rowMakanan', array(
          'model' => $terima,
          'modDetail' => $item,

        ), true);
      }
    }


    echo CJSON::encode(array('ok' => $ok, 'terima' => $data, 'checkuangmuka' => $checkuangmuka));
  }

  public function actionDetailPenerimaan($id, $print = 0)
  {

    $this->layout = '//layouts/iframe';
    if ($print == 1) {
      $this->layout = '//layouts/printWindows';
    }

    $modTerima = TerimabahanmakanT::model()->findByPk($id);
    $modDetailTerima = TerimabahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('terimabahanmakan_id' => $modTerima->terimabahanmakan_id), array('order' => 'nourutbahan ASC'));
    $modPengajuan = PengajuanbahanmknT::model()->findByAttributes(array('terimabahanmakan_id' => $modTerima->terimabahanmakan_id));
    $this->render($this->path_view . 'detailInformasi', array(
      'modTerima' => $modTerima,
      'modDetailTerima' => $modDetailTerima,
      'modPengajuan' => $modPengajuan
    ));
  }

  public function actionPrintDetailPenerimaan($id)
  {

    $judulLaporan = 'Faktur Penerimaan Bahan Makanan';

    $modTerima = TerimabahanmakanT::model()->findByPk($id);
    $modDetailTerima = TerimabahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('terimabahanmakan_id' => $modTerima->terimabahanmakan_id), array('order' => 'nourutbahan ASC'));


    //if (isset($_GET['frame'])){
    //$this->layout='//layouts/iframe';
    // }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      //   var_dump($id);die;
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'detailInformasi', array('modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
  }

  /**
   * Manages all models.
   */
  public function actionInformasi($linkHalaman = null)
  {
    //
    $model = new GZTerimabahanmakan('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZTerimabahanmakan'])) {
      $model->attributes = $_GET['GZTerimabahanmakan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nofaktur;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Faktur Pembelian Bahan Makanan ' . $dtDetail->bahanmakanan->kelbahanmakanan . " " . $dtDetail->bahanmakanan->namabahanmakanan . " - " . $model->supplier->supplier_nama . " - " . $model->nofaktur;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->ruangan_id;
    $modJurnalRekening->terimabahanmakan_id = $model->terimabahanmakan_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek, $isPPN = null, $ispph = null)
  {
    $valid = true;
    $modJurnalPosting = null;
    $modTerima = TerimabahanmakanT::model()->findByPk($postRekenings->terimabahanmakan_id);

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



    $modelJurnalDetail = new JurnaldetailT();

    // $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($postRekenings->harganettobhn * $postRekenings->qty_terima);
    $diskonHarga = ($totalHasilQty * ($postRekenings->persendiscount / 100));
    $totalNetto = ($totalHasilQty - $diskonHarga);
    $ppnHarga = ($totalNetto * ($postRekenings->persenppn / 100));
    $pphHarga = ($totalNetto * ($postRekenings->persenpph / 100));
    $totalAll = $totalNetto + $ppnHarga - $pphHarga;

    if ($modelRek->debitkredit == 'K') {
      if ($modTerima->pajakppn > 0) {
        $modelJurnalDetail->nourut = 3;
      }
      if ($modTerima->pajakpph > 0) {
        if (!empty($ispph)) {
          $modelJurnalDetail->nourut = 4;
        }
      }
      if (empty($isPPN) && empty($ispph)) {
        $modelJurnalDetail->nourut = 5;
      }
      if (!empty($ispph)) {
        $modelJurnalDetail->saldokredit = $pphHarga;
      } else {
        $modelJurnalDetail->saldokredit = $totalAll;
      }
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      if (!empty($isPPN)) {
        $modelJurnalDetail->nourut = 2;
        $modelJurnalDetail->saldodebit = $ppnHarga;
      }

      if (empty($isPPN) && empty($ispph)) {
        $modelJurnalDetail->nourut = 1;
        $modelJurnalDetail->saldodebit = $totalNetto;
      }

      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();

      //                    if(Yii::app()->user->getState('ispostingotomatis'))
      //                    {
      //                        $modJurnalPosting = new JurnalpostingT;
      //                        $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      //                        $modJurnalPosting->keterangan = "Posting automatis";
      //                        $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      //                        $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      //                        $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                        $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
      //                        $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
      //
      //                        $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
      //                        if (!empty($periode)) {
      //                            $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
      //                        }
      //
      //                        if($modJurnalPosting->validate()){
      //                            $modJurnalPosting->save();
      //                            $modelJurnalDetail->jurnalposting_id = $modJurnalPosting->jurnalposting_id;
      //                            $modelJurnalDetail->save();
      //                        }
      //                    }


    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }

  public function actionMenyetujui($terimabahanmakan_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modTerima = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);
    $modDetailTerima = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
    if ($approve) {
      $modAppr = ApprovalotorisasiM::model()->find();
      $pegawaid = "";

      if (isset($modAppr)) {
        if ($modTerima->sumberdanabhn == "PT. SHB") {
          $pegawaid = $modAppr->managerkeuanganpt_id;
        } else {
          $pegawaid = $modAppr->managerkeuangan_id;
        }
      }
      $update = TerimabahanmakanT::model()->updateByPk($terimabahanmakan_id, array('tgl_menyetujuikeuangan' => date("Y-m-d"), 'pegawaimenyetujuikeuangan_id' => $pegawaid));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'terimabahanmakan_id' => $terimabahanmakan_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Faktur Pembelian Bahan Makanan';
    $deskripsi = '';
    $this->render($this->path_view . 'menyetujui', array(
      'format' => $format,
      'modTerima' => $modTerima,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetailTerima' => $modDetailTerima
    ));
  }

  public function actionPrintMenyetujui($terimabahanmakan_id)
  {
    $format = new MyFormatter();
    $modTerima = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);
    $modDetailTerima = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
    $judulLaporan = 'Faktur Pembelian Bahan Makanan';
    $deskripsi = '';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionUbahFaktur($terimabahanmakan_id)
  {
    $format = new MyFormatter();

    $model = GZTerimabahanmakan::model()->findByPk($terimabahanmakan_id);
    $model->pajak_nama = (isset($model->pajak) ? $model->pajak->pajak_nama : null);
    $model->nopengajuan = (isset($model->pengajuanbahanmkn) ? $model->pengajuanbahanmkn->nopengajuan : null);
    $modDetails = GZTerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
    $model->supplier_nama = (!empty($model->supplier_id) ? $model->supplier->supplier_nama : "");

    $modUangmuka = new UangmukabeliT();

    if (!empty($model->pengajuanbahanmkn_id)) {
      $modUangmuka = UangmukabeliT::model()->findByAttributes(array('pengajuanbahanmkn_id' => $model->pengajuanbahanmkn_id));
      if (isset($modUangmuka)) {
        $modUangmuka->tgluangmukabeli = MyFormatter::formatDateTimeForUser($modUangmuka->tgluangmukabeli);
      } else {
        $modUangmuka = new UangmukabeliT();
      }
    }

    if (isset($_POST['GZTerimabahanmakan'])) {
      $model->attributes = $_POST['GZTerimabahanmakan'];
      $model->update_loginpemakai_id = Yii::app()->user->id;
      $model->update_time = date('Y-m-d H:i:s');
      $model->tglterimabahan = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglterimabahan']);
      $model->tglsurjalan = (!empty($_POST['GZTerimabahanmakan']['tglsurjalan']) ? MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglsurjalan']) : null);
      $model->tgljatuhtempo = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tgljatuhtempo']);
      $model->tglfaktur = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglfaktur']);

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;
          if ($model->save()) {
            if (isset($_POST['GZTerimabahandetailT'])) {
              if (count((array)$_POST['GZTerimabahandetailT']) > 0) {
                foreach ($_POST['GZTerimabahandetailT'] as $i => $data) {
                  $modelDet = GZTerimabahandetailT::model()->findByPk($data['terimabahandetail_id']);
                  $modelDet->attributes = $data;

                  if ($modelDet->save()) {
                    $this->updateBahanMakanan($_POST['GZTerimabahanmakan'], $modelDet, $data);
                  }
                }
              }
            }
            if ($success == true) {
              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                $checkDatadetail = 0;
                $modDetailTerima = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

                if (count((array)$modDetailTerima) > 0) {
                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modBahanmknM = BahanmakananM::model()->findByPk($dtFakturDetail->bahanmakanan_id);

                    if (isset($modBahanmknM)) {
                      if (!empty($modBahanmknM->kelbahanmakanan)) {
                        $modKelBahanMknRek = KelbahanmakananrekM::model()->findAllByAttributes(array('kelbahanmakanan' => $modBahanmknM->kelbahanmakanan, 'ispenerimaan' => true));

                        if (count((array)$modKelBahanMknRek) > 0) {
                          $checkDatadetail++;
                        } else {
                          if ($checkDatadetail > 1) {
                            $checkDatadetail--;
                          }
                        }
                      }
                    }
                  }
                }

                if ($checkDatadetail > 0) {
                  $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

                  if (isset($modJurnalBefore)) {
                    if (count((array)$modJurnalBefore) > 0) {
                      foreach ($modJurnalBefore as $jurnalBef) {
                        $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                        if (count((array)$jurnaldetail) > 0) {
                          foreach ($jurnaldetail as $jurnaldetBefor) {
                            $jurnaldetBefor->delete();
                          }
                        }
                        $jurnalBef->delete();
                      }
                    }
                  }

                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modBahanmknM = BahanmakananM::model()->findByPk($dtFakturDetail->bahanmakanan_id);
                    if (isset($modBahanmknM)) {
                      if (!empty($modBahanmknM->kelbahanmakanan)) {
                        $modKelBahanMknRek = KelbahanmakananrekM::model()->findAllByAttributes(array('kelbahanmakanan' => $modBahanmknM->kelbahanmakanan, 'ispenerimaan' => true));

                        if (count((array)$modKelBahanMknRek) > 0) {
                          $modJurnalRekening = $this->saveJurnalRekening($model, $dtFakturDetail);
                          foreach ($modKelBahanMknRek as $dtkelmknrek) {
                            $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $dtkelmknrek);
                          }
                          if ($model->pajakppn > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMABAHANDETAILT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_TERIMABAHANDETAILID . "'");
                            if (isset($rekeningcolumn)) {
                              $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, true);
                            }
                          }
                          if ($model->pajakpph > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMABAHANMAKANT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_PERSENPPH . "'");
                            if (isset($rekeningcolumn)) {
                              $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, null, true);
                            }
                          }
                        }
                      }
                    }
                  }
                }

                $modJurnalFaktuAfter = JurnalrekeningT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

                if (count((array)$modJurnalFaktuAfter) > 0) {
                  $rekening_id = null;

                  foreach ($modJurnalFaktuAfter as $dataFakturAf) {
                    $criteriaJud = new CDbCriteria();
                    $criteriaJud->addCondition('jurnalrekening_id = ' . $dataFakturAf->jurnalrekening_id);
                    $criteriaJud->addCondition('saldokredit > 0');
                    $criteriaJud->order = "nourut DESC";
                    $criteriaJud->limit = 1;
                    $modFakturJurDetAfter = JurnaldetailT::model()->find($criteriaJud);

                    if (isset($modFakturJurDetAfter)) {
                      $rekening_id = $modFakturJurDetAfter->rekening5_id;
                    }
                  }

                  if (!empty($model->jmluangmukabeli) && $model->jmluangmukabeli > 0) {
                    $modJurnalRekening = $this->saveJurnalRekeningUangMuka($model);

                    $modRekening5 = Rekening5M::model()->findByPk($rekening_id);

                    if (isset($modRekening5)) {
                      $this->saveJurnalDetailUangMuka($modJurnalRekening, $modRekening5, $model->jmluangmukabeli, 'D', 1);
                    }

                    $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TERIMABAHANMAKANT, 'column_name' => Params::REKENINGCOLUMN_COLUMN_JMLUANGMUKABELI));
                    if (isset($rekeningcolumn)) {
                      $this->saveJurnalDetailUangMuka($modJurnalRekening, $rekeningcolumn, $model->jmluangmukabeli, 'K', 2);
                    }
                  }
                }
              }
            }

            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('ubahFaktur', 'terimabahanmakan_id' => $model->terimabahanmakan_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan<br/>" . $ex->getMessage() . "<br/>" . MyExceptionMessage::getMessage($ex, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan. ");
      }
    }

    $this->render($this->path_view . 'ubahFaktur', array(
      'model' => $model,
      'modDetails' => $modDetails,
      'format' => $format,
      'modUangmuka' => $modUangmuka
    ));
  }

  public function actionBatalFaktur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $terimabahanmakan_id = isset($_POST['terimabahanmakan_id']) ? $_POST['terimabahanmakan_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal = isset($_POST['pegawaibatal']) ? $_POST['pegawaibatal'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);

      try {
        if (isset($model)) {
          $sukses = true;

          $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('terimabahanmakan_id' => $model->terimabahanmakan_id));

          if (isset($modJurnalBefore)) {
            if (count((array)$modJurnalBefore) > 0) {
              foreach ($modJurnalBefore as $jurnalBef) {
                $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                if (count((array)$jurnaldetail) > 0) {
                  foreach ($jurnaldetail as $jurnaldetBefor) {
                    $jurnaldetBefor->delete();
                  }
                }
                $jurnalBef->delete();
              }
            }
          }

          $modupdate = TerimabahanmakanT::model()->updateByPk($model->terimabahanmakan_id, array('tglfaktur' => null, 'nofaktur' => null, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));

          if (!$modupdate) {
            $sukses = false;
          }

          if ($sukses) {
            $keterangan = "Data Berhasil Dibatalkan! ";
            $status = 'ok';
            $transaction->commit();
          } else {
            $keterangan = "Data Gagal Dibatalkan! ";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $keterangan = "Data Gagal Dibatalkan! " . print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionLoadJatuhTempo()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tglfaktur = (isset($_POST['tgl_faktur']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_faktur']) : date('Y-m-d H:i:s'));
      $supplier_id = $_POST['supplier_id'];

      $dateJatuhTempo = date('d M Y H:i:s');
      $termin = 0;

      $modSupplier = SupplierM::model()->findByPk($supplier_id);

      if (isset($modSupplier)) {
        $termin = $modSupplier->terminpembayaran;
      }
      if ($termin > 0) {
        $dateJatuhTempo = date('d M Y H:i:s', strtotime('+' . $termin . ' days', strtotime($tglfaktur)));
      }
      echo CJSON::encode(array('value' => $dateJatuhTempo));
      Yii::app()->end();
    }
  }

  protected function notifFakturTerimaBahanMakanan($model)
  {

    $judul = "Faktur Terima Bahan Makanan - " . $model->nopenerimaanbahan;

    //$isi = "Tgl. Penerimaan : ".MyFormatter::formatDateTimeForUser($model->tglterimabahan)."<br/>";
    $isi = "Tgl. Faktur : " . MyFormatter::formatDateTimeForUser($model->tglfaktur) . "<br/>";
    $isi = "No Faktur : " . $model->nofaktur . "<br/>";
    $isi = "Supplier : " . $model->supplier_nama . "<br/>";
    $isi = "Nominal : " . MyFormatter::formatNumberForPrint($model->totalkeseluruhan) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
    ));
  }

  protected function saveJurnalRekeningUangMuka($model)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nofaktur;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Pengurangan Hutang Usaha dari Uang Muka';

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->terimabahanmakan_id = $model->terimabahanmakan_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetailUangMuka($modJurnalRekening, $modelRek, $nilai, $saldonormal, $nourut)
  {
    $valid = true;
    //        $modJurnalPosting = null;

    if (empty($modelRek)) {
      return true;
    }

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



    //        if (Yii::app()->user->getState('ispostingotomatis')) {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if ($modJurnalPosting->validate()) {
    //                $modJurnalPosting->save();
    //            }
    //        }

    $modelJurnalDetail = new JurnaldetailT();
    //        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modelJurnalDetail->nourut = $nourut;
    if ($saldonormal == 'K') {
      $modelJurnalDetail->saldokredit = $nilai;
      $modelJurnalDetail->saldodebit = 0;
    } else {
      $modelJurnalDetail->saldokredit = 0;
      $modelJurnalDetail->saldodebit = $nilai;
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
