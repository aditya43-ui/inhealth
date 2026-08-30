<?php

Yii::import("keuangan.models.*");

class PenggajianController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";
  //		public $layout='//layouts/column1';
  //        public $defaultAction = 'admin';
  public $path_view = 'penggajian.views.penggajian.';

  public function actionIndex($idPenggajian = null, $pengeluaranumum_id = null, $linkHalaman = null)
  {
    $modPengUmum = new GJPengeluaranumumT;
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;

    $modPengUmum->periodegaji = MyFormatter::formatMonthForUser(date('Y-m'));

    $modUraian[0] = new GJUraiankeluarumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;


    if (!empty($idPenggajian)) {

      $modGaji = PenggajianpegT::model()->findByPk($idPenggajian);
      $jmlgaji = $modGaji->totalterima;
      $modUraian[0] = new GJUraiankeluarumumT;
      $modUraian[0]->uraiantransaksi = 'Gaji Periode ' . $modGaji->periodegaji . '(' . $modGaji->pegawai->nama_pegawai . ' - ' . $modGaji->pegawai->nomorindukpegawai . ')';
      $modUraian[0]->volume = 1;
      $modUraian[0]->hargasatuan = $jmlgaji;
      $modUraian[0]->totalharga = $jmlgaji;
      $pegawai_id = $modGaji->pegawai_id;
    }
    if (!empty($pengeluaranumum_id)) {
      $modGaji = PenggajianpegT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
    }

    if (!empty($jmlgaji)) {
      $modPengUmum->jmlgaji = $jmlgaji;
    }
    $modPengUmum->nopengeluaran = '-- Otomatis --'; //MyGenerator::noPengeluaranUmum();

    if (!empty($pegawai_id)) {
      $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
    }

    $modBuktiKeluar = new GJTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = "-- Otomatis --";
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;
    $modBuktiKeluar->namapenerima = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : "";
    $modBuktiKeluar->alamatpenerima = isset($modPegawai->alamat_pegawai) ? $modPegawai->alamat_pegawai : "";
    $modBuktiKeluar->untukpembayaran = 'Gaji ' . $modPengUmum->periodegaji;

    $modJurnalRekening = new GJJurnalrekeningT;
    $modJurnalDetail = new GJJurnaldetailT;
    $modJurnalPosting = new GJJurnalpostingT;

    if (!empty($pengeluaranumum_id)) {
      $modBuktiKeluar = GJTandabuktikeluarT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
      if (empty($modBuktiKeluar)) {
        $modBuktiKeluar = new GJTandabuktikeluarT;
      }
    }

    if (isset($_POST['GJPengeluaranumumT'])) {

      // var_dump($_POST); die;

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['GJTandabuktikeluarT']);
        $modPengUmum = $this->savePengeluaranUmum($_POST['GJPengeluaranumumT'], $modBuktiKeluar, $_POST['GJUraiankeluarumumT']);
        $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

        if ($modPengUmum->isurainkeluarumum && isset($_POST['GJUraiankeluarumumT'])) {
          $modUraian = $this->saveUraian($_POST['GJUraiankeluarumumT'], $modPengUmum, $idPenggajian);
        }

        // var_dump($modBuktiKeluar->attributes);
        // var_dump($modPengUmum->attributes);
        // var_dump($this->succesSave);
        // die;

        if ($this->succesSave) {

          $this->notifBayarGaji($modPengUmum, $modBuktiKeluar);

          $sukses = 1;
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pembayaran gaji nomor Pengeluaran " . $modBuktiKeluar->nokaskeluar . " berhasil disimpan !");
          $this->redirect(array('index', 'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id, 'sukses' => $sukses));
          $model->isNewRecord = false;
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
      'modPengUmum' => $modPengUmum,
      'modUraian' => $modUraian,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modJurnalRekening' => $modJurnalRekening,
      'modJurnalDetail' => $modJurnalDetail,
      'modJurnalPosting' => $modJurnalPosting,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function notifBayarGaji($modPengUmum, $modBuktiKeluar)
  {

    $judul = "Pembayaran Gaji - " . $modPengUmum->nopengeluaran;
    $isi = "Tgl. Pembayaran Gaji : " . MyFormatter::formatDateTimeForUser($modPengUmum->tglpengeluaran) . "<br/>";
    $isi .= "Keterangan : " . $modBuktiKeluar->untukpembayaran . "<br/>";
    $isi .= "Cara Pembayaran : " . $modBuktiKeluar->carabayarkeluar . "<br/>";
    $isi .= "Nama Penerima : " . $modBuktiKeluar->namapenerima . "<br/>";
    $isi .= "Alamat Penerima : " . $modBuktiKeluar->alamatpenerima . "<br/>";
    $isi .= "Nominal : " . MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar) . "<br/>";


    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    //$ruanganKepegawaian = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEPEGAWAIAN);
    $ruanganPenggajian = RuanganM::model()->findByPk(Params::RUANGAN_ID_PENGGAJIAN);


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //array('instalasi_id'=>$ruanganKepegawaian->instalasi_id, 'ruangan_id'=>$ruanganKepegawaian->ruangan_id, 'modul_id'=>$ruanganKepegawaian->modul_id),
      array('instalasi_id' => $ruanganPenggajian->instalasi_id, 'ruangan_id' => $ruanganPenggajian->ruangan_id, 'modul_id' => $ruanganPenggajian->modul_id),
    ));


    //        var_dump($judul, $isi, $modPengUmum->attributes, $modBuktiKeluar->attributes);
    //
    //        die;

  }


  protected function updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum)
  {
    GJTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, array('pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id));
  }

  public function actionSimpanPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $format = new MyFormatter();
      if (isset($data_parsing['GJPengeluaranumumT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {

          $modBuktiKeluar = $this->saveTandaBuktiKeluar($data_parsing['GJTandabuktikeluarT']);
          $data_parsing['GJPengeluaranumumT']['tglpengeluaran'] = $format->formatDateTimeForDB($data_parsing['GJPengeluaranumumT']['tglpengeluaran']);
          $modPengUmum = $this->savePengeluaranUmum($data_parsing['GJPengeluaranumumT'], $modBuktiKeluar);
          if (isset($data_parsing['GJPengeluaranumumT']['isurainkeluarumum'])) {
            $modUraian = $this->saveUraian($data_parsing['GJUraiankeluarumumT'], $modPengUmum);
          }

          // die;

          $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['GJPengeluaranumumT']);

          $params = array(
            'modJurnalRekening' => $modJurnalRekening,
            'jenis_simpan' => $_REQUEST['jenis_simpan'],
            'RekeningakuntansiV' => $data_parsing['RekeningakuntansiV'],
          );
          $insertDetailJurnal = MyFunction::insertDetailJurnal($params);
          $this->succesSave = $insertDetailJurnal;


          if ($_REQUEST['jenis_simpan'] == 'posting') {
            $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          }
          $modJurnalDetail = $this->saveJurnalDetail(
            $data_parsing['AKPenerimaanUmumT'],
            $modJurnalRekening,
            $modJurnalPosting,
            $data_parsing['RekeningakuntansiV']
          );

          if ($this->succesSave) {
            $transaction->commit();
            $this->pesan = array(
              'nopengeluaran' => MyGenerator::noPengeluaranUmum(),
              'nokaskeluar' => MyGenerator::noKasKeluar()
            );
          } else {
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          print_r($exc);
          $this->pesan = $exc;
          $this->succesSave = false;
          $transaction->rollback();
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

  protected function saveTandaBuktiKeluar($postBuktiKeluar)
  {
    $modBuktiKeluar = new GJTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = $postBuktiKeluar['biayaadministrasi'];
    // $modBuktiKeluar->jmlkaskeluar = 0;
    $modBuktiKeluar->namapenerima = !empty($postBuktiKeluar['namapenerima']) ? $postBuktiKeluar['namapenerima'] : "-";
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tglkaskeluar = MyFormatter::formatDateTimeForDb($postBuktiKeluar['tglkaskeluar']);
    $this->succesSave = false;
    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modBuktiKeluar->getErrors();
    }

    return $modBuktiKeluar;
  }

  protected function savePengeluaranUmum($postPengeluaran, $modBuktiKeluar, $postUraian)
  {
    $totalharga = 0;

    $modUraian = array();

    if (count((array)$postUraian) > 0) {

      // var_dump($postUraian); die;
      $last = 0;
      foreach ($postUraian as $i => $value) {

        // if (!isset($value['totalharga'])) continue;

        $modUraian[$i] = new GJUraiankeluarumumT;
        $modUraian[$i]->totalharga = $value['totalharga'];
        $modUraian[$i]->hargasatuan = $value['hargasatuan'];
        $modUraian[$i]->satuanvol = $value['satuanvol'];
        $totalharga += $modUraian[$i]->totalharga;
        $last = $i;
      }
    }

    $format = new MyFormatter();
    $modPengUmum = new GJPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
    $modPengUmum->totalharga = $totalharga;
    $modPengUmum->hargasatuan = $totalharga;
    $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_PENGGAJIAN;
    $modPengUmum->satuanvol = $modUraian[$last]->satuanvol;
    $modPengUmum->tglpengeluaran = $format->formatDateTimeForDB($postPengeluaran['tglpengeluaran']);
    $modPengUmum->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPengUmum->create_loginpemakai_id = Yii::app()->user->id;
    $modPengUmum->create_time = date('Y-m-d H:i:s');
    $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
    $modPengUmum->ispenggajian = true;

    // var_dump($modPengUmum->attributes); die;

    if ($modPengUmum->validate()) {

      $modPengUmum->save();
      $this->succesSave = true;
      $attributes = array(
        'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id,
        //                    'jurnalrekening_id' => $modJurnalRekening->jurnalrekening_id
      );
      GJTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, $attributes);

      if (isset($_POST['RekeningakuntansiV'])) {
          $postRekenings = $_POST['RekeningakuntansiV']; // komen sementara => tabel belum dibuat untuk RekeningakuntansiV
          if (isset($postRekenings)) { //simpan jurnal rekening
            if (count((array)$postRekenings) > 0) {
              $modJurnalRekening = PenggajianController::saveJurnalRekening($modPengUmum, $postPengeluaran, $modBuktiKeluar);
              $saveDetailJurnal = PenggajianController::saveJurnalDetail($modJurnalRekening, $postRekenings, null);
            }
          }
      }
    } else {
      $this->succesSave = false;
      $this->pesan = $modPengUmum->getErrors();
    }

    return $modPengUmum;
  }

  protected function saveUraian($arrPostUraian, $modPengUmum, $idPenggajian)
  {
    $valid = false;
    $modUraian = array();

    // var_dump($arrPostUraian);

    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {



      $modUraian[$i] = new GJUraiankeluarumumT;
      $modUraian[$i]->attributes = $arrPostUraian[$i];
      $penggajianpeg_id = isset($arrPostUraian[$i]['penggajianpeg_id']) ? $arrPostUraian[$i]['penggajianpeg_id'] : null;
      $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
      $modUraian[$i]->penggajianpeg_id = $penggajianpeg_id;

      // var_dump($modUraian[$i]->attributes); die;

      if ($modUraian[$i]->validate()) {
        $modUraian[$i]->save();
        $valid = true;

        if (!empty($penggajianpeg_id)) {

          $penggajianpeg_id = CJSON::decode($penggajianpeg_id);

          // var_dump($penggajianpeg_id, $modPengUmum->pengeluaranumum_id);
          PenggajianpegT::model()->updateByPk($penggajianpeg_id, array(
            'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id
          ));
        }
      } else {
        $this->pesan = $modUraian[$i]->getErrors();
      }
    }

    $this->succesSave = $valid;
    return $modUraian;
  }

  protected function saveJurnalRekening($modPenUmum, $postPenUmum, $modBuktiKeluar = null)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new GJJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopengeluaran;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobku = "";
    //$postPenUmum['jenisKodeNama'];
    $uraian = 'PEMBAYARAN GAJI ' . strtoupper($postPenUmum['periodegaji']);
    if (!empty($modBuktiKeluar)) {
      $modJurnalRekening->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
      $uraian = strtoupper($modBuktiKeluar->untukpembayaran);
    }
    $modJurnalRekening->urianjurnal = $uraian;


    /*
          $attributes = array(
          'jenisjurnal_aktif' => true
          );
          $jenisjurnal_id = JenisjurnalM::model()->findByAttributes($attributes);
          $modJurnalRekening->jenisjurnal_id = $jenisjurnal_id->jenisjurnal_id;
         *
         */

    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    //            $periodeID = Yii::app()->session['periodeID'];
    //            $modJurnalRekening->rekperiod_id = $periodeID[0];
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->tandabuktikeluar_id = $modPenUmum->tandabuktikeluar_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $jenisSimpan = null)
  {
    $valid = true;
    //        $modJurnalPosting = null;
    //        if ($jenisSimpan == 'posting') {
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

    foreach ($postRekenings as $i => $rekening) {
      $model[$i] = new JurnaldetailT();
      //            $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model[$i]->uraiantransaksi = $modJurnalRekening->urianjurnal;
      $model[$i]->saldodebit = isset($rekening['saldodebit']) ? $rekening['saldodebit'] : 0;
      $model[$i]->saldokredit = isset($rekening['saldokredit']) ? $rekening['saldokredit'] : 0;
      $model[$i]->nourut = $i + 1;
      // $model[$i]->rekening1_id = $rekening['rekening1_id'];
      // $model[$i]->rekening2_id = $rekening['rekening2_id'];
      // $model[$i]->rekening3_id = $rekening['rekening3_id'];
      // $model[$i]->rekening4_id = $rekening['rekening4_id'];
      $model[$i]->rekening5_id = $rekening['rekening5_id'];
      $model[$i]->catatan = "";
      if ($model[$i]->validate()) {
        $model[$i]->save();
      } else {
        //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
        $valid = false;
        break;
      }
    }

    return $valid;
  }

  /*
      protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null)
      {
      $valid = true;
      for($i=0;$i<2;$i++)
      {
      $model[$i] = new GJJurnaldetailT();
      $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model[$i]->saldodebit = 0;
      $model[$i]->saldokredit = 0;
      $model[$i]->nourut = $i+1;
      if($i == 0)
      {
      $jenisPnrm = JnspengeluaranrekM::model()->findByAttributes(
      array(
      'jenispengeluaran_id'=>$arrJurnal['jenispengeluaran_id'],
      'saldonormal' => 'D'
      )
      );
      $model[$i]->saldodebit = $arrJurnal['totalharga'];
      }else{
      $jenisPnrm = JnspengeluaranrekM::model()->findByAttributes(
      array(
      'jenispengeluaran_id'=>$arrJurnal['jenispengeluaran_id'],
      'saldonormal' => 'K'
      )
      );
      $model[$i]->saldokredit = $arrJurnal['totalharga'];
      }
      $model[$i]->rekening1_id = $jenisPnrm['rekening1_id'];
      $model[$i]->rekening2_id = $jenisPnrm['rekening2_id'];
      $model[$i]->rekening3_id = $jenisPnrm['rekening3_id'];
      $model[$i]->rekening4_id = $jenisPnrm['rekening4_id'];
      $model[$i]->rekening5_id = $jenisPnrm['rekening5_id'];
      $model[$i]->catatan = "";
      if($model[$i]->validate())
      {
      $model[$i]->save();
      }else{
      $this->pesan = $model[$i]->getErrors();
      $valid = false;
      break;
      }
      }
      $this->succesSave = $valid;
      }
     */

  protected function saveJurnalPosting($arrJurnalPosting)
  {
    $modJurnalPosting = new GJJurnalpostingT;
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

  public function actionAmbilRekeningGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode_gaji = MyFormatter::formatMonthForDB($_POST['periode']);
      //            $cara_bayar = $_POST['carapembayarankeluar'];
      $kategori = $_POST['kategori'];
      $carabayarkeluar = isset($_POST['carabayarkeluar']) ? $_POST['carabayarkeluar'] : null;
      $bankid = ((isset($_POST['bankid']) && !empty($_POST['bankid'])) ? $_POST['bankid'] : null);

      // $modPenggajian  = PenggajianpegawaiV::model()->findAllByAttributes(array(''));

      $conditions = "(case when t.periodegaji is null then t.tglpenggajian::date else t.periodegaji::date end)::date between '" . $periode_gaji . '-01' . "'::date and '" . date("Y-m-t", strtotime($periode_gaji . '-01')) . "'::date";
      $criteria = new CDbCriteria;
      $criteria->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
      $criteria->compare('p.kategoripegawaiasal', $kategori);
      $criteria->addCondition($conditions);
      $criteria->order = 't.nama_pegawai';
      $modPenggajian = PenggajianpegawaiV::model()->findAll($criteria);
      if (count((array)$modPenggajian) > 0) {
        $i = 0;
        $row_rekening = "";
        $total_gaji = 0;
        $total_pajak = 0;
        foreach ($modPenggajian as $k => $model) {

          // jurnal rekening
          $gaji = PenggajianpegT::model()->findByPk($model->penggajianpeg_id);
          $total_gaji += $model->penerimaanbersih;
          //$total_pajak += $gaji->totalpajak;



          $i++;
        }
        $debit_gaji = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'penggajianpeg_t',
          'column_name' => 'penerimaanbersih',
          'debitkredit' => 'K',
        ));

        $debit_pajak = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'penggajianpeg_t',
          'column_name' => 'totalpajak',
          'debitkredit' => 'K',
        ));

        //                $kredit_gaji = CarabayarkeluarrekM::model()->findByAttributes(array(
        //                    'carabayarkeluar' => $cara_bayar,
        //                    'debitkredit' => 'K',
        //                ));
        $criteriaCaraByr = new CDbCriteria;
        $criteriaCaraByr->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5,rekening4_m.rekening4_id, rekening4_m.kdrekening4, rekening4_m.nmrekening4,rekening3_m.rekening3_id, rekening3_m.kdrekening3, rekening3_m.nmrekening3,rekening2_m.rekening2_id, rekening2_m.kdrekening2, rekening2_m.nmrekening2,rekening1_m.rekening1_id, rekening1_m.kdrekening1, rekening1_m.nmrekening1, t.debitkredit";
        $criteriaCaraByr->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
          . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
          . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
          . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
          . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id";

        if (!empty($bankid)) {
          $criteriaCaraByr->addCondition("t.bank_id = " . $bankid);
          $criteriaCaraByr->addCondition("t.debitkredit = 'K'");
        } else {
          if (!empty($carabayarkeluar)) {
            $criteriaCaraByr->compare('LOWER(t.carabayarkeluar)', strtolower(trim($carabayarkeluar)), false);
            $criteriaCaraByr->addCondition("t.debitkredit = 'K'");
          }
        }
        $criteriaCaraByr->order = 't.debitkredit ASC';
        $criteriaCaraByr->limit = 1;

        if (!empty($bankid)) {
          $kredit_gaji = BankrekM::model()->find($criteriaCaraByr);
        } else {
          if (!empty($carabayarkeluar)) {
            $kredit_gaji = CarabayarkeluarrekM::model()->find($criteriaCaraByr);
          }
        }

        $row_rekening .= $this->renderPartial('penggajian.views.penggajian.__formKodeRekeningAkuntansiRow', array(
          'detail' => $debit_gaji, 'saldo_debit' => MyFormatter::formatNumberForPrint($total_gaji), 'saldo_kredit' => 0, 'key' => 0,
        ), true);
        if ($total_pajak > 0) {
          $row_rekening .= $this->renderPartial('penggajian.views.penggajian.__formKodeRekeningAkuntansiRow', array(
            'detail' => $debit_pajak, 'saldo_debit' => MyFormatter::formatNumberForPrint($total_pajak), 'saldo_kredit' => 0, 'key' => 1,
          ), true);
        }
        $row_rekening .= $this->renderPartial('penggajian.views.penggajian.__formKodeRekeningAkuntansiRow', array(
          'detail' => $kredit_gaji, 'saldo_debit' => 0, 'saldo_kredit' => MyFormatter::formatNumberForPrint($total_gaji), 'key' => 2,
        ), true);

        echo CJSON::encode(
          $row_rekening
        );
      } else {
        echo '';
      }
      Yii::app()->end();
    }
  }

  public function actionAmbilDataGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode_gaji = MyFormatter::formatMonthForDB($_POST['periode']);
      $kategori = $_POST['kategori'];

      // $modPenggajian  = PenggajianpegawaiV::model()->findAllByAttributes(array(''));

      $conditions = "(case when t.periodegaji is null then t.tglpenggajian::date else t.periodegaji::date end)::date between '" . $periode_gaji . '-01' . "'::date and '" . date("Y-m-t", strtotime($periode_gaji . '-01')) . "'::date";
      $criteria = new CDbCriteria;
      $criteria->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
      $criteria->compare('p.kategoripegawaiasal', $kategori);
      $criteria->addCondition($conditions);
      $criteria->order = 't.nama_pegawai';
      $modPenggajian = PenggajianpegawaiV::model()->findAll($criteria);

      $pegawai_id = array();
      $penggajinapeg_id = array();


      if (count((array)$modPenggajian) > 0) {
        $i = 0;
        $models = array();
        $models[0]['uraian'] = "Pembayaran Gaji " . $kategori . " Periode " . $_POST['periode'];
        $models[0]['penerimaanbersih'] = 0;
        $models[0]['thr_thrbersih'] = 0;
        $models[0]['totalpajak'] = 0;
        $models[0]['tglpenggajian'] = 0;
        $models[0]['totalharga'] = 0;
        foreach ($modPenggajian as $k => $model) {
          $gaji = PenggajianpegT::model()->findByPk($model->penggajianpeg_id);

          $uraian = UraiankeluarumumT::model()->findAllByAttributes(array(
            'penggajianpeg_id' => $model->penggajianpeg_id
          ));
          $total = 0;
          foreach ($uraian as $det) {
            $total += $det->totalharga;
          }

          if ($total >= $model->penerimaanbersih)
            continue;

          $model->penerimaanbersih -= $total;
          $pegawai_id[] = $model->pegawai_id;
          $penggajinapeg_id[] = $model->penggajianpeg_id;

          $models[0]['periodegaji'] = $model->periodegaji;
          $models[0]['penerimaanbersih'] += $model->penerimaanbersih;
          $models[0]['thr_thrbersih'] += $gaji->thr_thrbersih;
          $models[0]['totalpajak'] += $model->totalpajak;
          //$models[0]['tglpenggajian']      = $model->tglpenggajian;
          $models[0]['volume'] = 1;
          $models[0]['satuanvol'] = 'BULAN';
          $models[0]['totalharga'] += $model->penerimaanbersih;

          $i++;
        }
        $models[0]['pegawai_id'] = CJSON::encode($pegawai_id);
        $models[0]['penggajianpeg_id'] = CJSON::encode($penggajinapeg_id);
        echo CJSON::encode(
          $this->renderPartial('penggajian.views.penggajian._rinciangaji', array('modRinciangaji' => $models), true)
        );
      } else {
        echo '';
      }
      Yii::app()->end();
    }
  }

  public function actionTampilRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode = explode('-', $_POST['periode']);
      $periode_bulan = $periode[1];
      $periode_tahun = $periode[0];
      // $format         = new MyFormatter;
      // $bulan_angka    = $format->formatMonthForDb($periode_bulan);
      $periode_gaji = $periode_tahun . '-' . $periode_bulan;

      $conditions = "EXTRACT(YEAR FROM tglpenggajian) || '-' || EXTRACT(MONTH FROM tglpenggajian) = '" . $periode_gaji . "' ";
      $criteria = new CDbCriteria;
      $criteria->select = 'SUM(penerimaanbersih) AS penerimaanbersih';
      $criteria->addCondition($conditions);
      $modPenggajian = PenggajianpegawaiV::model()->find($criteria);
      $modKas = $modPenggajian->penerimaanbersih;

      $criteria = new CDbCriteria;
      $criteria->addCondition('rekening5_id IS NOT NULL');
      $criteria->order = 'nourutgaji';
      $modKomponenGaji = KomponengajirekM::model()->findAll($criteria);

      if (count((array)$modKomponenGaji) > 0) {
        $ind = 1;
        foreach ($modKomponenGaji as $i => $model) {
          $modRekening[$ind]['kdstruktur'] = $model->rekening->rekening1->kdrekening1;
          $modRekening[$ind]['struktur_id'] = $model->rekening->rekening1_id;
          $modRekening[$ind]['kdkelompok'] = $model->rekening->rekening2->kdrekening2;
          $modRekening[$ind]['kelompok_id'] = $model->rekening->rekening2_id;
          $modRekening[$ind]['kdjenis'] = $model->rekening->rekening3->kdrekening3;
          $modRekening[$ind]['jenis_id'] = $model->rekening->rekening3_id;
          $modRekening[$ind]['kdobyek'] = $model->rekening->rekening4->kdrekening4;
          $modRekening[$ind]['obyek_id'] = $model->rekening->rekening4_id;
          $modRekening[$ind]['kdrincianobyek'] = $model->rekening->kdrekening5;
          $modRekening[$ind]['rincianobyek_id'] = $model->rekening->rekening5_id;
          $modRekening[$ind]['nama_rekening'] = $model->rekening->nmrekening5;
          $modRekening[$ind]['rekDebitKredit'] = $model->rekening->nmrekening5;

          $conditions = "periodegaji = '" . $periode_gaji . "' AND pengeluaranumum_id is null AND komponengaji_id=" . $model->komponengaji_id . "";
          $criteria = new CDbCriteria;
          $criteria->select = 'SUM(jumlah) AS jumlah';
          $criteria->addCondition($conditions);
          $modNilai = RekapgajipegawaiV::model()->find($criteria);

          if ($model->ispotongan == TRUE) {
            $modRekening[$ind]['saldodebit'] = 0;
            $modRekening[$ind]['saldokredit'] = isset($modNilai->jumlah) ? $modNilai->jumlah : 0;
          } else {
            $modRekening[$ind]['saldodebit'] = isset($modNilai->jumlah) ? $modNilai->jumlah : 0;
            $modRekening[$ind]['saldokredit'] = 0;
          }

          $ind++;
        }

        echo CJSON::encode(
          $this->renderPartial('penggajian.views.penggajian._listRekening', array('modRekening' => $modRekening, 'modKas' => $modKas), true)
        );
      } else {
        echo CJSON::encode();
      }
      Yii::app()->end();
    }
  }

  public function actionPrint($tandabuktikeluar_id)
  {
    $this->layout = '//layouts/printWindows';
    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);


    $this->render($this->path_view . 'print', array(
      'modBuktiKeluar' => $modBuktiKeluar,
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

      //			dicomment karena : RND-8713
      //			$data = array();
      //			$params = array();
      //			foreach($_POST['id_rekening'] as $key=>$val)
      //			{
      //				if($key != 'status')
      //				{
      //					if(strlen(trim($val)) > 0)
      //					{
      //						$data[] = $key . ' = :' . $key;
      //						$params[(string) ':'.$key] = $val;
      //					}
      //				}
      //			}
      //
      //			$criteria->select = '*';
      //			$criteria->condition = implode($data, ' AND ');
      //			$criteria->params = $params;

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

      $model = RekeningakuntansiV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'status' => $status), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningByJnsPengeluaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispengeluaran_id = isset($_POST['jenispengeluaran_id']) ? $_POST['jenispengeluaran_id'] : null;
      $criteria = new CDbCriteria;
      //			dicomment RND-8517
      //			$criteria->select = '*, jnspenerimaanrek_m.saldonormal';
      //			$criteria->join = '
      //				JOIN jnspenerimaanrek_m ON
      //					jnspenerimaanrek_m.rekening1_id = t.struktur_id AND
      //					jnspenerimaanrek_m.rekening2_id = t.kelompok_id AND
      //					jnspenerimaanrek_m.rekening3_id = t.jenis_id AND
      //					jnspenerimaanrek_m.rekening4_id = t.obyek_id AND
      //					jnspenerimaanrek_m.rekening5_id = t.rincianobyek_id
      //			';
      //			$criteria->condition = 'jnspenerimaanrek_m.jenispenerimaan_id = :jenispenerimaan_id';
      //			$criteria->params = array(':jenispenerimaan_id'=>$jenispenerimaan_id);
      //			$model = RekeningakuntansiV::model()->findAll($criteria);
      if (!empty($jenispengeluaran_id)) {
        $criteria->addCondition('jenispengeluaran_id = ' . $jenispengeluaran_id);
      }
      //			$criteria->order = 'saldonormal ASC';
      $model = JenispengeluaranrekeningV::model()->findAll($criteria);

      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'dariDialog' => true), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningManual()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = RekeningcolumnM::model()->findAllByAttributes(array(
        'table_name' => 'pengeluaranumum_t:pembayarangaji',
        'column_name' => 'jmlpph_21',
      ));

      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiKolom', array('model' => $model, 'dariDialog' => true), true)
        );
      }
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
}
