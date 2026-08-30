<?php

class PemakaianbarangTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.pemakaianbarangT.';
  public $succesSave = true;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Barang";
    $format = new MyFormatter();
    $model = new GUPemakaianbarangT;
    $ruangan_id       = Yii::app()->user->getState('ruangan_id');
    $model->ruangan_id    = $ruangan_id;
    $model->nopemakaianbrg   = "-- Otomatis --";
    $model->create_ruangan  = $ruangan_id;
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->create_time = date('Y-m-d H:i:s');
    $model->tglpemakaianbrg = date('Y-m-d H:i:s');
    //$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modDetails = array();

    if (isset($_GET['id'])) {
      $model = GUPemakaianbarangT::model()->findByPk($_GET['id']);
      $modDetails = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $model->pemakaianbarang_id));
    }

    if (isset($_POST['GUPemakaianbarangT'])) {
      $model->attributes = $_POST['GUPemakaianbarangT'];
      $model->tglpemakaianbrg = $format->formatDateTimeForDb($model->tglpemakaianbrg);
      $model->nopemakaianbrg   = MyGenerator::noPemakaianBarang();
      //$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
      // var_dump($model->attributes); die;
      if (count((array)$_POST['GUPemakaianbrgdetailT']) > 0) {
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            if ($model->save()) {
              $modDetails = $this->validasiTabular($model, $_POST['GUPemakaianbrgdetailT']);
              foreach ($modDetails as $i => $data) {
                if ($data->jmlpakai > 0) {
                  if ($data->save()) {
                    $success = $success && InventarisasiruanganT::simpanStokPemakaian($model, $data);
                    //                                    	InventarisasiruanganT::kurangiStok($data->jmlpakai, $data->barang_id);
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            $this->setNotifPemakaianBarang($model);
            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $modDetailPemakaian = PemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $model->pemakaianbarang_id));

              if (count((array)$modDetailPemakaian) > 0) {
                foreach ($modDetailPemakaian as $detailPemakai) {
                  $barang = BarangM::model()->findByPk($detailPemakai->barang_id);

                  if (isset($barang)) {
                    $modJnsBarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $barang->jenisbarang_id, 'ispemakaian' => true));

                    if (count((array)$modJnsBarangRek) > 0) {
                      $modJurnalRekening = $this->saveJurnalRekening($model, $detailPemakai);

                      foreach ($modJnsBarangRek as $jnsbrgRek) {
                        $this->saveJurnalDetail($modJurnalRekening, $detailPemakai, $jnsbrgRek);
                      }

                      $success = $this->succesSave;
                    }
                  }
                }
              }
            }


            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', 'Data ' . $model->nopemakaianbrg . ' berhasil disimpan.');
              $this->redirect(array('index', 'id' => $model->pemakaianbarang_id, 'sukses' => 1));
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
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1688);

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetails' => $modDetails, 'linkHalaman' => $linkHalaman
    ));
  }


  protected function setNotifPemakaianBarang($model)
  {

    $judul = "Pemakaian Barang - " . $model->nopemakaianbrg;

    $asal = RuanganM::model()->findByPk($model->ruangan_id);

    $isi = "Tgl. Pemakaian : " . MyFormatter::formatDateTimeForUser($model->tglpemakaianbrg) . "<br/>";
    $isi .= "No. Pemakaian : " . $model->nopemakaianbrg . "<br/>";
    $isi .= "Untuk Keperluan : " . $model->untukkeperluan . "<br/>";

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
    ));
  }

  protected function validasiTabular($model, $data)
  {
    $valid = true;
    foreach ($data as $i => $row) {
      $modDetails[$i] = new GUPemakaianbrgdetailT;
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->pemakaianbarang_id = $model->pemakaianbarang_id;
      $modDetails[$i]->ppn = 0;
      $modDetails[$i]->disc = 0;
      $modDetails[$i]->hpp = 0;
      $modDetails[$i]->catatanbrg = '-';

      $valid = $modDetails[$i]->validate() && $valid;
    }
    return $modDetails;
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    // Uncomment the following line if AJAX validation is needed
    if (isset($_POST['GUPemakaianbarangT'])) {
      $model->attributes = $_POST['GUPemakaianbarangT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pemakaianbarang_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new GUPemakaianbarangT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GUPemakaianbarangT']))
      $model->attributes = $_GET['GUPemakaianbarangT'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GUPemakaianbarangT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gupemakaianbarang-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionInformasi($linkHalaman = null)
  {
    $model = new GUPemakaianbarangT();
    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y H:i:s');
    if (isset($_GET['GUPemakaianbarangT'])) {
      $model->attributes = $_GET['GUPemakaianbarangT'];
      $format = new MyFormatter();
      $model->tglAwal = $format->formatDateTimeForDB($_GET['GUPemakaianbarangT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeForDB($_GET['GUPemakaianbarangT']['tglAkhir']);
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1432);

    $this->render($this->path_view . 'informasi', array(
      'model' => $model, 'linkHalaman' => $linkHalaman
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/frameDialog';
    $modPemakaianbarang = GUPemakaianbarangT::model()->findByPk($id);
    if (!empty($modPemakaianbarang)) {
      $modDetailPemakaian = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $id));
      $this->render($this->path_view . 'detailInformasi', array(
        'modPemakaianbarang' => $modPemakaianbarang,
        'modDetailPemakaian' => $modDetailPemakaian,
      ));
    }
  }

  public function actionGetStokBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
      $jumlah = isset($_POST['qty']) ? $_POST['qty'] : null;

      $checkStok = false;
      if (Yii::app()->user->getState('isstokumumminus') == false) {
        $stokBarang = InventarisasiruanganT::tampilStok($barang_id);

        if (intval($jumlah) > intval($stokBarang)) {
          $checkStok = true;
        }
      }
      if (!$checkStok) {

        //            if (KonfigsystemK::getKonfigKurangiStokUmum() == true){ // fungsi dikomment karena tida ada fungsi tersebut dlm model yg bersangkutan
        //                if (InventarisasiruanganT::validasiStok($jumlah, $barang_id) == false){ RSPMC-1113
        //                    $pesan = 'kosong';
        //                }else{
        $pesan = 'tersedia';
        //				}
        //            }
      } else {
        $pesan = 'kosong';
      }
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /*
	 * untuk menampilkan baris pemakaian barang
	 */
  public function actionGetPemakaianBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $barang_id = $_POST['barang_id'];
      $jumlah = $_POST['jumlah'];
      $satuan = $_POST['satuan'];

      $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($barang_id);
      $modDetail = new GUPemakaianbrgdetailT();
      $modDetail->barang_id = $barang_id;
      $modDetail->satuanpakai = $satuan;
      $modDetail->jmlpakai = $jumlah;
      $modDetail->harganetto = number_format($modBarang->barang_harganetto, 0, "", ".");
      $modDetail->hargajual = number_format($modBarang->barang_hargajual, 0, "", ".");
      $modDetail->ppn = $modBarang->barang_ppn;
      $modDetail->disc = $modBarang->barang_persendiskon;
      $modDetail->hpp = $modBarang->barang_hpp;
      // $modDetail->jmldlmkemasan = $modBarang->barang_jmldlmkemasan;

      $tr = $this->renderPartial($this->path_view . '_detailPemakaianBarang', array('modBarang' => $modBarang, 'modDetail' => $modDetail), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /*
	 * untuk mencari barang melalui autocomplete
	 */
  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->join = "JOIN inventarisasiruangan_t inv ON inv.barang_id = t.barang_id";
      $criteria->addCondition("inv.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
      $criteria->order = 't.barang_id';
      $models = GUBarangM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pemakaianbarang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPemakaianBarang = GUPemakaianbarangT::model()->findByPk($pemakaianbarang_id);
    $modPemakaianBarangDetail = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $pemakaianbarang_id));

    $judul_print = 'PEMAKAIAN BARANG';
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
      'modPemakaianBarang' => $modPemakaianBarang,
      'modPemakaianBarangDetail' => $modPemakaianBarangDetail,
      'caraPrint' => $caraPrint
    ));
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpemakaianbrg);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nopemakaianbrg;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpemakaianbrg);
    $modJurnalRekening->nobku = "";
    $ruangan_nama = "";
    $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
    }

    $modJurnalRekening->urianjurnal = 'Pemakaian Barang ' . $dtDetail->barang->barang_nama . " Ruangan " . $ruangan_nama . " - " . $model->nopemakaianbrg;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->ruangan_id;
    $modJurnalRekening->pemakaianbarang_id = $model->pemakaianbarang_id;

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
    $modBarang = BarangM::model()->findByPk($postRekenings->barang_id);

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

    $totalHasilQty = ($modBarang->barang_hpp * $postRekenings->jmlpakai);

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
