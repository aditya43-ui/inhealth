<?php

class PemakaianbahanmakanTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.pemakaianbahanmakanT.';
  public $stokbahanmakanantersimpan = true;
  public $succesSave = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan Makanan";
    $format = new MyFormatter();
    $model = new GZPemakaianbhnmknT;
    $model->no_pemakaianbhnmkn = "-- Otomatis --";
    $modDetails = array();

    $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
    if (isset($modApprovalotorisasiM)) {
      $model->pegmengetahui_id = $modApprovalotorisasiM->kepalagizi_id;
      $model->pegmengetahui_nama = $modApprovalotorisasiM->kepalagizi->namaLengkap;
    }

    if (isset($_GET['id'])) {
      $model = GZPemakaianbhnmknT::model()->findByPk($_GET['id']);
      if (!empty($model->pegmengetahui_id)) {
        $modPegawai = PegawaiM::model()->findByPk($model->pegmengetahui_id);
        $model->pegmengetahui_nama = $modPegawai->nama_pegawai;
      }

      $modDetails = GZPemakaianbhnmkndetT::model()->findAllByAttributes(array('pemakaianbhnmkn_id' => $model->pemakaianbhnmkn_id));
    }

    if (isset($_POST['GZPemakaianbhnmknT'])) {
      $model->attributes = $_POST['GZPemakaianbhnmknT'];
      $model->tglpemakaianbhnmkn = $format->formatDateTimeForDb($model->tglpemakaianbhnmkn);
      $model->no_pemakaianbhnmkn = MyGenerator::noPemakaianBahanMakanan();
      $model->ruanganpemakaibhnmkn = Yii::app()->user->getState('ruangan_id');
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if (count((array)$_POST['GZPemakaianbhnmkndetT']) > 0) {
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            if ($model->save()) {
              foreach ($_POST['GZPemakaianbhnmkndetT'] as $i => $data) {
                $modDetails[$i] = new GZPemakaianbhnmkndetT();
                $modDetails[$i]->attributes = $data;
                $modDetails[$i]->pemakaianbhnmkn_id = $model->pemakaianbhnmkn_id;

                if ($data['jmlpemakaianbhnmkn'] > 0) {

                  if ($modDetails[$i]->save()) {

                    $this->simpanStokBahanMakananOut($modDetails[$i], $data['jmlpemakaianbhnmkn']);
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            if (Yii::app()->user->getState('isjurnalotomatis') == true) {

              $modDetailPemakaian = PemakaianbhnmkndetT::model()->findAllByAttributes(array('pemakaianbhnmkn_id' => $model->pemakaianbhnmkn_id));

              if (count((array)$modDetailPemakaian) > 0) {
                foreach ($modDetailPemakaian as $detailPemakai) {
                  $modBahanmknM = BahanmakananM::model()->findByPk($detailPemakai->bahanmakanan_id);

                  if (isset($modBahanmknM)) {
                    $modKelBahanMknRek = KelbahanmakananrekM::model()->findAllByAttributes(array('kelbahanmakanan' => $modBahanmknM->kelbahanmakanan, 'ispemakaian' => true));

                    if (count((array)$modKelBahanMknRek) > 0) {
                      $modJurnalRekening = $this->saveJurnalRekening($model, $detailPemakai);
                      foreach ($modKelBahanMknRek as $kelbahanRek) {
                        $this->saveJurnalDetail($modJurnalRekening, $detailPemakai, $kelbahanRek);
                      }
                      $success = $this->succesSave;
                    }
                  }
                }
              }
            }

            if ($success == true && $this->stokbahanmakanantersimpan) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', 'Data ' . $model->no_pemakaianbhnmkn . ' berhasil disimpan.');
              $this->redirect(array('index', 'id' => $model->pemakaianbhnmkn_id, 'sukses' => 1));
            } else {

              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          } catch (Exception $ex) {

            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', 'Data detail barang harus diisi.');
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetails' => $modDetails, 'format' => $format
    ));
  }


  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzpemakaianbhnmkn-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /*
	 * untuk menampilkan baris pemakaian barang
	 */
  public function actionGetPemakaianBahanMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bahanmakan_id = $_POST['bahanmakan_id'];
      $jumlah = $_POST['jumlah'];
      $satuan = $_POST['satuan'];
      $format = new MyFormatter();

      //            $modStocBhnMkn = StokbahanmakananT::model()->find('')
      $modBhnMkn = BahanmakananM::model()->with('golbahanmakanan')->findByPk($bahanmakan_id);
      $modDetail = new GZPemakaianbhnmkndetT();
      $modDetail->bahanmakanan_id = $bahanmakan_id;
      $modDetail->satuanbahan = $satuan;
      $modDetail->jmlpemakaianbhnmkn = $jumlah;
      $modDetail->harganetto = number_format($modBhnMkn->harganettobahan, 0, "", ".");

      $tr = $this->renderPartial($this->path_view . '_detailPemakaianBarang', array('modBahanmkn' => $modBhnMkn, 'modDetail' => $modDetail, 'format' => $format), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /*
	 * untuk mencari barang melalui autocomplete
	 */
  public function actionAutocompleteBahanMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->select = "bm.namabahanmakanan, bm.bahanmakanan_id";
      $criteria->group = $criteria->select;
      $criteria->join = " JOIN bahanmakanan_m bm ON bm.bahanmakanan_id = t.bahanmakanan_id ";
      $criteria->compare('LOWER(bm.namabahanmakanan)', strtolower($_GET['term']), true);
      $models = GZStokbahanmakananT::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namabahanmakanan;
        $returnVal[$i]['value'] = $model->bahanmakanan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pemakaianbhnmkn_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPemakaianBhnmkn = GZPemakaianbhnmknT::model()->findByPk($pemakaianbhnmkn_id);
    $modPemakaianBhnmknDetail = GZPemakaianbhnmkndetT::model()->findAllByAttributes(array('pemakaianbhnmkn_id' => $pemakaianbhnmkn_id));
    $modPegawai = PegawaiM::model()->findByPk($modPemakaianBhnmkn->pegmengetahui_id);
    $modPemakaianBhnmkn->pegmengetahui_nama = $modPegawai->NamaLengkap;

    $judul_print = 'PEMAKAIAN BAHAN MAKANAN';
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
      'modPemakaianBhnmkn' => $modPemakaianBhnmkn,
      'modPemakaianBhnmknDetail' => $modPemakaianBhnmknDetail,
      'caraPrint' => $caraPrint
    ));
  }

  protected function simpanStokBahanMakananOut($pemakaianmknbhndet, $jumlah)
  {
    $format = new MyFormatter;

    $oa = BahanmakananM::model()->findByPk($pemakaianmknbhndet->bahanmakanan_id);
    $modStokPemakaian = PemakaianbhnmknT::model()->findByAttributes(array('pemakaianbhnmkn_id' => $pemakaianmknbhndet->pemakaianbhnmkn_id));
    $modStokOaNew = new StokbahanmakananT();
    $modStokOaNew->attributes = $oa->attributes; //duplicate
    $modStokOaNew->qty_masuk = 0;
    $modStokOaNew->qty_keluar = $jumlah;
    $modStokOaNew->qty_current = $modStokOaNew->qty_masuk - $modStokOaNew->qty_keluar;

    $modStokOaNew->tgltransaksi = $modStokPemakaian->tglpemakaianbhnmkn;
    $modStokOaNew->pemakaianhbnmkndet_id = $pemakaianmknbhndet->pemakaianbhnmkndet_id;

    if ($modStokOaNew->validate()) {
      if ($modStokOaNew->save()) {
        $stokPemakaian = StokbahanmakananT::model()->findAllByAttributes(array('bahanmakanan_id' => $oa->bahanmakanan_id));
        $totalQty = 0;

        if (count((array)$stokPemakaian) > 0) {
          foreach ($stokPemakaian as $data) {
            $totalQty += $data->qty_current;
          }
        }
        BahanmakananM::model()->updateByPk($oa->bahanmakanan_id, array(
          'jmlpersediaan' => $totalQty,
        ));
      }
    } else {
      $this->stokbahanmakanantersimpan &= false;
    }
    return $modStokOaNew;
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpemakaianbhnmkn);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->no_pemakaianbhnmkn;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpemakaianbhnmkn);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Pemakaian Bahan Makanan ' . $dtDetail->bahanmakanan->namabahanmakanan . " - " . $model->no_pemakaianbhnmkn;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->pemakaianbhnmkn_id = $model->pemakaianbhnmkn_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
  {
    $valid = true;
    $modJurnalPosting = null;
    $modBahan = BahanmakananM::model()->findByPk($postRekenings->bahanmakanan_id);

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



    $modelJurnalDetail = new JurnaldetailT();

    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($modBahan->harganettobahan * $postRekenings->jmlpemakaianbhnmkn);

    if ($modelRek->debitkredit == 'K') {
      $modelJurnalDetail->nourut = 2;
      $modelJurnalDetail->saldokredit = $totalHasilQty;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      $modelJurnalDetail->nourut = 1;
      $modelJurnalDetail->saldodebit = $totalHasilQty;
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
      //                            if($modJurnalPosting->save()){
      //                                JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
      //                            }
      //                        }
      //                    }
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
