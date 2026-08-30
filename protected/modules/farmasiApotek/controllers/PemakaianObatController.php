<?php

class PemakaianObatController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.pemakaianObat.';
  public $pemakaianobatsimpan = false;
  public $pemakaianobatdetailsimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping
  public $succesSave = true; //looping
  public $pesan = "";

  public function actionIndex($pemakaianobat_id = null, $linkHalaman = null)
  {
    $model = new FAPemakaianobatT();
    $model->nopemakaian_obat = '-- Otomatis --';
    $modDetails = array();

    if (!empty($pemakaianobat_id)) {
      $model = FAPemakaianobatT::model()->findByPk($pemakaianobat_id);
      $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $pemakaianobat_id));
    }

    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['FAPemakaianobatT'])) {
      $model = $this->savePemakaianObat($_POST['FAPemakaianobatT']);
      if ($this->pemakaianobatsimpan) {
        if (count((array)$_POST['FAPemakaianobatdetailT']) > 0) {
          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['FAPemakaianobatdetailT'] as $i => $postDetail) {
            $modDetails[$i] = new FAPemakaianobatdetailT;
            $modDetails[$i]->attributes = $postDetail;
            $modDetails[$i] = $this->savePemakaianObatDetail2($model, $postDetail);
            $this->simpanStokObatAlkesOut2($modDetails[$i]);
            /*
                                                $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
						$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
						$obatalkes_id = $postDetail['obatalkes_id'];
						if(isset($detailGroups[$obatalkes_id])){
							$detailGroups[$obatalkes_id]['qty_satuanpakai'] += $postDetail['qty_satuanpakai'];
						}else{
							$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
							$detailGroups[$obatalkes_id]['qty_satuanpakai'] = $postDetail['qty_satuanpakai'];
						} */
          }
          //END GROUP
        }
        /*
				$obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach($detailGroups AS $i => $detail){
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_satuanpakai'], Yii::app()->user->getState('ruangan_id'));
                    if(count((array)$modStokOAs) > 0){
                        foreach($modStokOAs AS $i => $stok){
                            $modDetails[$i] = $this->savePemakaianObatDetail($model, $stok, $_POST['FAPemakaianobatdetailT'] );
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                        }
                    }else{
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                    }
                } */
        //die;

        $judul = "Pemakaian Obat Ruangan " . Yii::app()->user->getState('ruangan_nama');
        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $isi = "Tgl. Pemakaian : " . MyFormatter::formatDateTimeForUser($model->tglpemakaianobat) . "<br/>";
        $isi .= "No. Pemakaian : " . $model->nopemakaian_obat . "<br/>";
        $isi .= "Untuk Keperluan : " . $model->untukkeperluan_obat;

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
        ));

        try {
          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            $modDetailPemakaian = PemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $model->pemakaianobat_id));

            if (count((array)$modDetailPemakaian) > 0) {
              foreach ($modDetailPemakaian as $detailPemakai) {
                $barang = ObatalkesM::model()->findByPk($detailPemakai->obatalkes_id);

                if (isset($barang)) {
                  $modJnsObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $barang->jenisobatalkes_id, 'ispemakaianruangan' => true, 'ruangan_id' => Yii::app()->user->getState("ruangan_id")));

                  if (count((array)$modJnsObatRek) > 0) {
                    $modJurnalRekening = $this->saveJurnalRekening($model, $detailPemakai);

                    foreach ($modJnsObatRek as $jnsObatRek) {
                      $this->saveJurnalDetail($modJurnalRekening, $detailPemakai, $jnsObatRek);
                    }

                    $this->pemakaianobatdetailsimpan = $this->succesSave;
                  }
                }
              }
            }
          }


          if ($this->pemakaianobatdetailsimpan && $this->stokobatalkestersimpan) {

            $transaction->commit();

            $sukses = 1;
            $this->redirect(array('index', 'pemakaianobat_id' => $model->pemakaianobat_id, 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data detail pemakaian obat gagal disimpan !");
            if (!$this->stokobatalkestersimpan) {
              Yii::app()->user->setFlash('error', "Data detail pemakaian obat gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
            }
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian obat gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetails' => $modDetails, 'linkHalaman' => $linkHalaman
    ));
  }

  public function actionInformasi($linkHalaman = null)
  {
    $model = new PemakaianobatT;
    $model->unsetAttributes();
    $model->tglAwal = date('Y-m-d'); //, time() - (3600 * 24 * 10
    $model->tglAkhir = date('Y-m-d');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['PemakaianobatT'])) {
      $model->attributes = $_GET['PemakaianobatT'];
      $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['PemakaianobatT']['tglAwal']);
      $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['PemakaianobatT']['tglAkhir']);
    }

    $this->render($this->path_view . 'informasi', array('model' => $model, 'linkHalaman' => $linkHalaman));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = FAPemakaianobatT::model()->findByPk($id);
    $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $id));
    $this->render($this->path_view . 'detail', array(
      'model' => $model,
      'modDetails' => $modDetails,
    ));
  }

  protected function savePemakaianObat($postpemakaian)
  {
    $format = new MyFormatter();
    $model = new FAPemakaianobatT();
    $model->attributes = $postpemakaian;
    $model->tglpemakaianobat = MyFormatter::formatDateTimeForDb($model->tglpemakaianobat);
    $model->nopemakaian_obat = MyGenerator::noPemakaianObat();
    $model->create_time = date("Y-m-d H:i:s");
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id'); //Yii::app()->user->id;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($model->validate()) {
      $model->save();
      $this->pemakaianobatsimpan = true;
    } else {
      $this->pemakaianobatsimpan = false;
      Yii::app()->user->setFlash('error', "Data Pemakaian Obat Tidak valid");
    }
    return $model;
  }

  protected function savePemakaianObatDetail2($model, $postPemakaianObatDetail)
  {
    $format = new MyFormatter;
    $oa = ObatalkesM::model()->findByPk($postPemakaianObatDetail['obatalkes_id']);
    $modPemakaianObatDetail = new FAPemakaianobatdetailT();
    $modPemakaianObatDetail->attributes = $postPemakaianObatDetail;
    $modPemakaianObatDetail->pemakaianobat_id = $model->pemakaianobat_id;
    //$modPemakaianObatDetail->qty_satuanpakai = $stokOa->qtystok_terpakai;
    //$modPemakaianObatDetail->harga_satuanpakai = $stokOa->HargaJualSatuan;
    //$modPemakaianObatDetail->harganetto_satuanpakai = $stokOa->HPP;
    $modPemakaianObatDetail->ket_obatpakai = $model->ket_pemakaianobat;
    $modPemakaianObatDetail->satuankecil_id = $oa->satuankecil_id;
    if ($modPemakaianObatDetail->save()) {
      $this->pemakaianobatdetailsimpan &= true;
    } else {
      $this->pemakaianobatdetailsimpan &= false;
    }
    return $modPemakaianObatDetail;
  }

  protected function savePemakaianObatDetail($model, $stokOa, $postPemakaianObatDetail)
  {
    $format = new MyFormatter;
    $modPemakaianObatDetail = new FAPemakaianobatdetailT();
    $modPemakaianObatDetail->attributes = $stokOa->attributes;
    $modPemakaianObatDetail->pemakaianobat_id = $model->pemakaianobat_id;
    $modPemakaianObatDetail->qty_satuanpakai = $stokOa->qtystok_terpakai;
    $modPemakaianObatDetail->harga_satuanpakai = $stokOa->HargaJualSatuan;
    $modPemakaianObatDetail->harganetto_satuanpakai = $stokOa->HPP;
    $modPemakaianObatDetail->ket_obatpakai = $model->ket_pemakaianobat;
    if ($modPemakaianObatDetail->save()) {
      $this->pemakaianobatdetailsimpan &= true;
    } else {
      $this->pemakaianobatdetailsimpan &= false;
    }
    return $modPemakaianObatDetail;
  }

  protected function simpanStokObatAlkesOut2($modPemakaianObatDetail)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modPemakaianObatDetail->obatalkes_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modPemakaianObatDetail->attributes; //duplicate
    $modStokOaNew->attributes = $oa->attributes;
    //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modPemakaianObatDetail->qty_satuanpakai;
    $modStokOaNew->pemakaianobatdetail_id = $modPemakaianObatDetail->pemakaianobatdetail_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->validate();
    //var_dump($modStokOaNew->errors); die;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();

      if (in_array($modStokOaNew->ruangan_id, array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1))) {
        StokobatalkesT::notifStokOALewatMinimalRuangan($modStokOaNew->obatalkes_id, $modStokOaNew->ruangan_id);
      }

      //$modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modPemakaianObatDetail)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);

    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modPemakaianObatDetail->qty_satuanpakai;
    $modStokOaNew->pemakaianobatdetail_id = $modPemakaianObatDetail->pemakaianobatdetail_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  public function actionAutocompleteObatReseptur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = explode(';', $_GET['term']);
      $obatalkes_nama = isset($term[0]) ? $term[0] : '';
      $hargajual = isset($term[1]) ? $term[1] : '';
      $criteria = new CDbCriteria();
      $criteria->join = " JOIN stokobatalkes_t stok ON stok.obatalkes_id = t.obatalkes_id ";
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
      if ($hargajual != '') {
        $criteria->addCondition('hargajual =' . $hargajual, 'or');
      }
      $criteria->addCondition('obatalkes_farmasi = TRUE');
      $criteria->addCondition('obatalkes_aktif = true');
      $criteria->addCondition("stok.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
      $persenjual = $this->persenJualRuangan();
      $format = new MyFormatter();
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();

          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
          $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
          $returnVal[$i]['value'] = $model->obatalkes_nama;
          $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
          $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
          $returnVal[$i]['qtyStok'] = $qtyStok;
          $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
          $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
          $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
          $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
          $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
        }
      } else {
        $returnVal = null;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }

  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modPemakaianObatDetail = new FAPemakaianobatdetailT();
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $checkData = false;

      $oa = ObatalkesM::model()->findByPk($obatalkes_id);

      if (Yii::app()->user->getState('isstokfarmasiminus') == false) {
        if (count((array)$modStokOAs) <= 0) {
          $checkData = true;
        }
      }
      //if(count((array)$modStokOAs) > 0){

      //foreach($modStokOAs AS $i => $stok){
      if ($checkData == false) {
        $modPemakaianObatDetail->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
        $modPemakaianObatDetail->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
        $modPemakaianObatDetail->stokobatalkes_id = null; //$stok->stokobatalkes_id;
        $modPemakaianObatDetail->qty_satuanpakai = $jumlah; //$stok->qtystok_terpakai;
        $modPemakaianObatDetail->harga_satuanpakai = $oa->hargajual; //$stok->HargaJualSatuan;
        $modPemakaianObatDetail->harganetto_satuanpakai = $oa->harganetto; //$stok->HPP;
        $modPemakaianObatDetail->jmlstok = 0; //$stok->qtystok;
        $modPemakaianObatDetail->subtotal = $modPemakaianObatDetail->qty_satuanpakai * $modPemakaianObatDetail->harga_satuanpakai;
        $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modPemakaianObatDetail' => $modPemakaianObatDetail), true);
      } else {
        $pesan = "Stok tidak mencukupi!";
      }
      //}
      //}else{
      //    $pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Data Pemakaian Obat';
    $model = FAPemakaianobatT::model()->findByPk($id);
    $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $id));
    $this->render($this->path_view . 'print', array(
      'judulLaporan' => $judulLaporan,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraPrint' => $caraPrint,
    ));
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpemakaianobat);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nopemakaian_obat;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpemakaianobat);
    $modJurnalRekening->nobku = "";
    $ruangan_nama = "";
    $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
    }

    $modJurnalRekening->urianjurnal = 'Pemakaian Obat Alkes ' . $dtDetail->obatalkes->obatalkes_nama . " Ruangan " . $ruangan_nama . " - " . $model->nopemakaian_obat;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->ruangan_id;
    $modJurnalRekening->pemakaianobat_id = $model->pemakaianobat_id;

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
    $modObatAlkes = ObatalkesM::model()->findByPk($postRekenings->obatalkes_id);

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

    $totalHasilQty = ($modObatAlkes->hpp * $postRekenings->qty_satuanpakai);

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

      //                if(Yii::app()->user->getState('ispostingotomatis'))
      //                {
      //                    $modJurnalPosting = new JurnalpostingT;
      //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->keterangan = "Posting automatis";
      //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
      //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
      //
      //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
      //                    if (!empty($periode)) {
      //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
      //                    }
      //
      //                    if($modJurnalPosting->validate()){
      //                        if($modJurnalPosting->save()){
      //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
      //                        }
      //                    }
      //                }
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
