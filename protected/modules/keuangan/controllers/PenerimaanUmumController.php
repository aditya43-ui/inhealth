<?php

class PenerimaanUmumController extends MyAuthController
{
  public $succesSave = true;
  public $pesan = "succes";
  public $is_action = "insert";
  public $path_view = 'keuangan.views.penerimaanUmum.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Kas / Umum";
    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->volume = 1;
    $modPenUmum->hargasatuan = 0;
    $modPenUmum->totalharga = 0;
    $modPenUmum->persenppn = 0;
    $modPenUmum->nomor = '-- Otomatis --';
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modUraian[0] = new KUUraianpenumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;

    $modTandaBukti = new KUTandabuktibayarT;
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->jmlpembayaran = $modPenUmum->totalharga;
    $modTandaBukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
    $modJurnalRekening = array();
    $modJurnalDetail = array();
    $modJUrnalPosting = array();
    if (isset($_POST['KUPenerimaanUmumT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modTandaBukti = $this->saveTandaBukti($_POST['KUTandabuktibayarT']);
        $modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti);

        if ($modPenUmum->isuraintransaksi && isset($_POST['KUUraianpenumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraianpenumumT'], $modPenUmum);
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render(
      $this->path_view . 'index',
      array(
        'modPenUmum' => $modPenUmum,
        'modUraian' => $modUraian,
        'modTandaBukti' => $modTandaBukti,
        'modJurnalRekening' => $modJurnalRekening,
        'modJurnalDetail' => $modJurnalDetail,
        'modJurnalPosting' => $modJUrnalPosting,
        'modUraian' => $modUraian
      )
    );
  }

  public function actionSimpanPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPenUmum = new KUPenerimaanUmumT;
      $modTandaBukti = new KUTandabuktibayarT;
      $modJurnalPosting = null;
      parse_str($_REQUEST['data'], $data_parsing);
      $format = new MyFormatter();

      if (isset($data_parsing['KUPenerimaanUmumT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $modTandaBukti = $this->saveTandaBukti($data_parsing['KUTandabuktibayarT']);

          $data_parsing['KUPenerimaanUmumT']['tglpenerimaan'] = $format->formatDateTimeForDb($data_parsing['KUPenerimaanUmumT']['tglpenerimaan']);

          $modPenUmum = $this->savePenerimaan($data_parsing['KUPenerimaanUmumT'], $modTandaBukti);
          if (isset($data_parsing['KUUraianpenumumT'])) {
            $modUraian = $this->saveUraian($data_parsing['KUUraianpenumumT'], $modPenUmum);
          }

          $modJurnalRekening = $this->saveJurnalRekening($modPenUmum, $data_parsing['KUPenerimaanUmumT']);


          $modJurnalDetail = $this->saveJurnalDetail(
            $data_parsing['KUPenerimaanUmumT'],
            $modJurnalRekening,
            null,
            $data_parsing['RekeningakuntansiV']
          );

          if ($_REQUEST['jenis_simpan'] == 'posting') {
            $res = Yii::app()->db
              ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(" . $modJurnalRekening->jurnalrekening_id . ") as simpan")
              ->queryRow();

            if (!empty($res)) {
              $this->succesSave = $this->succesSave && $res['simpan'];
            }
            //$modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          }

          $this->notifPenerimaanKas($modPenUmum, $modTandaBukti);


          if ($this->succesSave) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $this->pesan = array(
              'nopenerimaan' => MyGenerator::noPenerimaanUmum(),
              'id' => $modPenUmum->penerimaanumum_id,
            );
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $exc) {
          $this->pesan = $exc;
          $this->succesSave = false;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }

      $result = array(
        'action' => $this->is_action,
        'pesan' => $this->pesan,
        'status' => ($this->succesSave == true ? 'ok' : 'not'),
      );

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  public function notifPenerimaanKas($model, $modTandaBukti)
  {

    $judul = "Penerimaan Umum - " . $model->nopenerimaan;
    $jenis = JenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);

    $isi = "Tgl. Peneriman : " . MyFormatter::formatDateTimeForUser($model->tglpenerimaan) . "<br/>";
    $isi .= "Jenis : " . $jenis->jenispenerimaan_nama . "<br/>";
    $isi .= "Nominal : " . MyFormatter::formatNumberForPrint($modTandaBukti->jmlpembayaran) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
    ));


    //        print_r($model->attributes);
    //
    //        die;
  }


  public function saveTandaBukti($postTandaBukti)
  {
    $format = new MyFormatter();
    $modTandaBukti = new KUTandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBukti;
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
    $modTandaBukti->shift_id = Yii::app()->user->getState('shift_id');
    $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
    $modTandaBukti->create_time = date('Y-m-d H:i:s');
    $modTandaBukti->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');

    $modTandaBukti->alamat_bkm = empty($modTandaBukti->alamat_bkm) ? "-" : $modTandaBukti->alamat_bkm;
    $modTandaBukti->jmlpembulatan = empty($modTandaBukti->jmlpembulatan) ? 0 : $modTandaBukti->jmlpembulatan;
    $modTandaBukti->biayaadministrasi = empty($modTandaBukti->biayaadministrasi) ? 0 : $modTandaBukti->biayaadministrasi;
    $modTandaBukti->biayamaterai = empty($modTandaBukti->biayamaterai) ? 0 : $modTandaBukti->biayamaterai;

    if ($modTandaBukti->validate()) {
      $modTandaBukti->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modTandaBukti->getErrors();
    }
    return $modTandaBukti;
  }

  public function savePenerimaan($postPenerimaan, $modTandaBukti)
  {

    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->attributes = $postPenerimaan;
    $modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
    $modPenUmum->shift_id = Yii::app()->user->getState('shift_id');
    $modPenUmum->pegawai_id = Yii::app()->user->getState('pegawai_id');

    if ($modPenUmum->validate()) {
      $modPenUmum->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modPenUmum->getErrors();
    }
    return $modPenUmum;
  }

  protected function saveUraian($arrPostUraian, $modPenUmum)
  {
    $valid = false;
    $modUraian = array();
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      if (strlen($arrPostUraian[$i]['uraiantransaksi']) > 0) {
        $modUraian[$i] = new KUUraianpenumumT;
        $modUraian[$i]->attributes = $arrPostUraian[$i];
        $modUraian[$i]->penerimaanumum_id = $modPenUmum->penerimaanumum_id;
        if ($modUraian[$i]->validate()) {
          $modUraian[$i]->save();
          $valid = true;
        } else {
          $this->pesan = $modUraian[$i]->getErrors();
        }
      }
    }
    $this->succesSave = $valid;
    return $modUraian;
  }

  public function saveJurnalRekening($modPenUmum, $postPenUmum)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPenUmum->tglpenerimaan, 'JTK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopenerimaan;
    $modJurnalRekening->tglreferensi = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $postPenUmum['jenisKodeNama'];
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = $period;
    $modJurnalRekening->create_time = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi = null)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new KUJurnaldetailT();
      // $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      //                $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      //            $model->nourut = $i + 1;
      if ($model->saldokredit > 0) {
        $model->nourut = $i + 1;
      } else {
        $model->nourut = $i + 1;
      }
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";

      if ($model->validate()) {
        $model->save();
      } else {
        $this->pesan = $model->getErrors();
        $valid = false;
        break;
      }
    }

    $this->succesSave = $valid;
  }

  protected function saveJurnalPosting($arrJurnalPosting)
  {
    $modJurnalPosting = new KUJurnalpostingT;
    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    $modJurnalPosting->keterangan = "Posting automatis";
    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modJurnalPosting->validate()) {
      $modJurnalPosting->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalPosting->getErrors();
    }
    return $modJurnalPosting;
  }

  protected function updateJurnalDetail($modJurnalDetail, $modJurnalPosting)
  {
    KUJurnaldetailT::model()->updateByPk($modJurnalDetail->jurnaldetail_id, array(
      'jurnalposting_id' => $modJurnalPosting->jurnalposting_id
    ));
  }

  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $criteria = new CDbCriteria;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekeninglast_id = " . $rekening5_id);
      }
      if (!empty($rekening4_id)) {
        $criteria->addCondition("rekening4_id = " . $rekening4_id);
      }
      if (!empty($rekening3_id)) {
        $criteria->addCondition("rekening3_id = " . $rekening3_id);
      }
      if (!empty($rekening2_id)) {
        $criteria->addCondition("rekening2_id = " . $rekening2_id);
      }
      if (!empty($rekening1_id)) {
        $criteria->addCondition("rekening1_id = " . $rekening1_id);
      }

      $model = KURekeningakuntansiV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'status' => $status), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionPrint($id)
  {
    $model = KUPenerimaanUmumT::model()->findByPk($id);
    $modUraian = KUUraianpenumumT::model()->findAllByAttributes(array('penerimaanumum_id' => $model->penerimaanumum_id));
    $modTanda = KUTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
    $judulLaporan = 'Detail Penerimaan Kas';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modTanda'=>$modTanda));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionGetDataRekeningByJnsPenerimaan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispenerimaan_id = isset($_POST['jenispenerimaan_id']) ? $_POST['jenispenerimaan_id'] : null;
      $is_kasbon = isset($_POST['is_kasbon']) ? $_POST['is_kasbon'] : null;
      $criteria = new CDbCriteria;
      $criteria->select = "t.rekening5_id, t.kdrekening5, t.nmrekening5, t.rekening5_nb as debitkredit";
      if (!empty($jenispenerimaan_id)) {
        $criteria->addCondition('jenispenerimaan_id = ' . $jenispenerimaan_id);
      }
      $criteria->addCondition("t.debitkredit = 'K'");
      $criteria->order = 't.rekening5_id ASC';

      $model = KUJenispenerimaanrekeningV::model()->findAll($criteria);

      $html = "";
      if (count((array)$model) > 0) {
        foreach ($model as $dataRek) {
          $dataRek->debitkredit = 'K';
        }
        $html = $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'rekeningtype' => "trrekjnspenerimaan"), true);
      }

      echo CJSON::encode(
        $html
      );
      Yii::app()->end();
    }
  }

  public function actionAutoCompletePegawaiTandaTangan()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modPegawaiMengetahui = new PegawaiV;
    $modPegawaiMengetahui->nama_pegawai = $_GET['term'];

    $prov = $modPegawaiMengetahui->search();

    $res = array();
    foreach ($prov->data as $item) {
      $attr = $item->attributes;
      $attr['label'] = $item->namaLengkap;
      $attr['value'] = $item->namaLengkap;
      $res[] = $attr;
    }


    echo CJSON::encode($res);
  }

  public function actionAutocompleteJenisPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenispenerimaan_nama)', strtolower($_GET['term']), true);
      //                $criteria->addCondition('LOWER(jenispenerimaan_kode) || \' - \' || LOWER(jenispenerimaan_nama) LIKE \'%'.strtolower($_GET['term']).'%\'');
      $criteria->addCondition("jenispenerimaan_id in(select jenispenerimaan_id from jnspenerimaanrek_m)");
      $models = JenispenerimaanM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
        $returnVal[$i]['value'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetDataRekeningByCaraPembayaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $carabayarkeluar = isset($_POST['carapembayaran']) ? $_POST['carapembayaran'] : null;
      $bankid = ((isset($_POST['bankid']) && !empty($_POST['bankid'])) ? $_POST['bankid'] : null);

      $criteria = new CDbCriteria;
      $criteria->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5, t.debitkredit";
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id ";

      if (!empty($bankid)) {
        $criteria->addCondition("t.bank_id = " . $bankid);
        $criteria->addCondition("t.debitkredit = 'K'");
      } else {
        if (!empty($carabayarkeluar)) {
          // $criteria->addCondition("t.carabayarkeluarrek_id = 3");
            $criteria->compare("t.carabayarkeluar", trim($carabayarkeluar), true);
            $criteria->addCondition("t.debitkredit = 'K'");
        }
      }
      $criteria->order = 't.debitkredit ASC';
      $criteria->limit = 1;

      if (!empty($bankid)) {
        $model = BankrekM::model()->findAll($criteria);
      } else {
        if (!empty($carabayarkeluar)) {
          $model = CarabayarkeluarrekM::model()->findAll($criteria);
        }
      }

      $html = "";
      if (count((array)$model) > 0) {
        foreach ($model as $dataRek) {
          $dataRek->debitkredit = 'D';
        }
        $html = $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'rekeningtype' => "trdebitcarabayar"), true);
      }

      echo CJSON::encode(
        $html
      );
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningByRekeningColumn()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jmlpph = isset($_POST['jmlpph']) ? $_POST['jmlpph'] : 0;
      $jmlpph1 = isset($_POST['jmlpph1']) ? $_POST['jmlpph1'] : 0;
      $jmlpph3 = isset($_POST['jmlpph3']) ? $_POST['jmlpph3'] : 0;
      $jmlppn = isset($_POST['jmlppn']) ? $_POST['jmlppn'] : 0;
      $biayaadministrasi = isset($_POST['biayaadministrasi']) ? $_POST['biayaadministrasi'] : 0;
      $biayamaterai = isset($_POST['biayamaterai']) ? $_POST['biayamaterai'] : 0;

      $criteria = new CDbCriteria;
      $criteria->select = "t.column_name, rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5, t.debitkredit";
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id ";
      $arrayColumn = array();

      if (!empty($jmlpph3) && $jmlpph3 > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_JMLPPH23);
      }

      if (!empty($jmlpph1) && $jmlpph1 > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_JMLPPH21);
      }

      if (!empty($jmlpph) && $jmlpph > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_JMLPPH22);
      }

      if (!empty($jmlppn) && $jmlppn > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_PENUM_JMLPPN);
      }

      if (!empty($biayaadministrasi) && $biayaadministrasi > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_PENERIMAANUMUMID);
      }

      if (!empty($biayamaterai) && $biayamaterai > 0) {
        array_push($arrayColumn, Params::REKENINGCOLUMN_COLUMN_NOPENERIMAAN);
      }
      $criteria->addCondition("t.table_name = '" . Params::REKENINGCOLUMN_TABLE_PENERIMAANUMUMT . "'");
      if (is_array($arrayColumn)) {
        $criteria->addInCondition('t.column_name', $arrayColumn);
      }
      $criteria->order = 't.debitkredit ASC';



      $model = RekeningcolumnM::model()->findAll($criteria);
      $html = "";
      if (count((array)$model) > 0) {
        $html = $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'rekeningtype' => "trdebitrekeningcolumn"), true);
      }

      echo CJSON::encode(
        $html
      );
      Yii::app()->end();
    }
  }
}
