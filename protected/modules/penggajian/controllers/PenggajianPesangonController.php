<?php

Yii::import("keuangan.models.*");

class PenggajianPesangonController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";
  //		public $layout='//layouts/column1';
  //        public $defaultAction = 'admin';
  public $path_view = 'penggajian.views.penggajianpesangon.';

  public function actionIndex($idPenggajian = null, $pengeluaranumum_id = null, $linkHalaman)
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
      $modGaji = PesangonpegT::model()->findByPk($idPenggajian);
      //			$modGaji = PenggajianpegT::model()->findByPk($idPenggajian);
      $jmlgaji = $modGaji->totalterima;
      $modUraian[0] = new GJUraiankeluarumumT;
      $modUraian[0]->uraiantransaksi = 'Pesangon Periode ' . $modGaji->periodegaji . '(' . $modGaji->pegawai->nama_pegawai . ' - ' . $modGaji->pegawai->nomorindukpegawai . ')';
      $modUraian[0]->volume = 1;
      $modUraian[0]->hargasatuan = $jmlgaji;
      $modUraian[0]->totalharga = $jmlgaji;
      $pegawai_id = $modGaji->pegawai_id;
    }
    if (!empty($pengeluaranumum_id)) {
      //			$modGaji = PenggajianpegT::model()->findByAttributes(array('pengeluaranumum_id'=>$pengeluaranumum_id));
      $modGaji = PesangonpegT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
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
    $modBuktiKeluar->untukpembayaran = 'Pesangon ' . $modPengUmum->periodegaji;

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

          $this->notifBayarPesangon($modPengUmum, $modBuktiKeluar);

          $sukses = 1;
          $transaction->commit();
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

  protected function notifBayarPesangon($modPengUmum, $modBuktiKeluar)
  {

    $judul = "Pembayaran Pesangon Pegawai - " . $modPengUmum->nopengeluaran;
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
          // $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['GJPengeluaranumumT']);

          $params = array(
            'modJurnalRekening' => $modJurnalRekening,
            'jenis_simpan' => $_REQUEST['jenis_simpan'],
            'RekeningakuntansiV' => $data_parsing['RekeningakuntansiV'],
          );
          $insertDetailJurnal = MyFunction::insertDetailJurnal($params);
          $this->succesSave = $insertDetailJurnal;

          /*
                      if($_REQUEST['jenis_simpan'] == 'posting')
                      {
                      $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
                      }
                      $modJurnalDetail = $this->saveJurnalDetail(
                      $data_parsing['AKPenerimaanUmumT'],
                      $modJurnalRekening,
                      $modJurnalPosting,
                      $data_parsing['RekeningakuntansiV']
                      );
                     */
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
    $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_PESANGON;
    $modPengUmum->satuanvol = $modUraian[$last]->satuanvol;
    $modPengUmum->tglpengeluaran = $format->formatDateTimeForDB($postPengeluaran['tglpengeluaran']);
    $modPengUmum->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPengUmum->create_loginpemakai_id = Yii::app()->user->id;
    $modPengUmum->create_time = date('Y-m-d H:i:s');
    $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
    $modPengUmum->ispenggajian = true;

    // var_dump($modPengUmum->attributes); die;

    if ($modPengUmum->validate()) {

      $postRekenings = $_POST['RekeningakuntansiV']; // komen sementara => tabel belum dibuat untuk RekeningakuntansiV
      if (isset($postRekenings)) { //simpan jurnal rekening
        if (count((array)$postRekenings) > 0) {
          $modJurnalRekening = PenggajianPesangonController::saveJurnalRekening($modPengUmum, $postPengeluaran);
          $saveDetailJurnal = PenggajianPesangonController::saveJurnalDetail($modJurnalRekening, $postRekenings, null);
        }
      }

      $modPengUmum->save();
      $this->succesSave = true;
      $attributes = array(
        'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id,
        //                    'jurnalrekening_id' => $modJurnalRekening->jurnalrekening_id
      );
      GJTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, $attributes);
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
      $pesangonpeg_id = isset($arrPostUraian[$i]['pesangonpeg_id']) ? $arrPostUraian[$i]['pesangonpeg_id'] : null;
      $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
      $modUraian[$i]->pesangonpeg_id = $pesangonpeg_id;

      // var_dump($modUraian[$i]->attributes); die;

      if ($modUraian[$i]->validate()) {
        $modUraian[$i]->save();
        $valid = true;

        if (!empty($pesangonpeg_id)) {
          // var_dump($penggajianpeg_id, $modPengUmum->pengeluaranumum_id);
          PesangonpegT::model()->updateByPk($pesangonpeg_id, array(
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

  protected function saveJurnalRekening($modPenUmum, $postPenUmum)
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
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Pesangon Pegawai'; //$postPenUmum['jenisKodeNama'];


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
      $model[$i]->uraiantransaksi = $rekening['nama_rekening'];
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

  public function actionAmbilDataGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode_gaji = MyFormatter::formatMonthForDB($_POST['periode']);


      $models = array();
      // $modPenggajian  = PenggajianpegawaiV::model()->findAllByAttributes(array(''));

      $conditions = "(case when t.periodegaji is null then t.tglpesangon::date else periodegaji::date end)::date between '" . $periode_gaji . '-01' . "'::date and '" . date("Y-m-t", strtotime($periode_gaji . '-01')) . "'::date and tgl_mengetahuipt is not null and tgl_mengetahui is not null and tgl_menyetujui is not null";
      //                        $conditions = "(case when t.periodegaji is null then t.tglpesangon::date else periodegaji::date end)::date between '".$periode_gaji.'-01'."'::date and '".date("Y-m-t", strtotime($periode_gaji.'-01'))."'::date";
      $criteria = new CDbCriteria;
      $criteria->addCondition($conditions);
      $criteria->order = 'pegawai.nama_pegawai';
      $criteria->with = array('pegawai');
      $modPenggajian = PesangonpegT::model()->findAll($criteria);
      //			$modPenggajian  = PenggajianpegawaiV::model()->findAll($criteria);

      if (count((array)$modPenggajian) > 0) {
        $i = 0;
        foreach ($modPenggajian as $k => $model) {

          $uraian = UraiankeluarumumT::model()->findAllByAttributes(array(
            'pesangonpeg_id' => $model->pesangonpeg_id
          ));
          $total = 0;
          if (count((array)$uraian) > 0) {
            foreach ($uraian as $det) {
              $total += $det->totalharga;
            }
          }


          if ($total >= $model->penerimaanbersih)
            continue;

          $model->penerimaanbersih -= $total;

          $models[$i]['uraian'] = (isset($model->pegawai_id) ? $model->pegawai->nama_pegawai : "") . ' - ' . $model->nopesangon;
          $models[$i]['pegawai_id'] = $model->pegawai_id;
          $models[$i]['periodegaji'] = $model->periodegaji;
          $models[$i]['pesangonpeg_id'] = $model->pesangonpeg_id;
          $models[$i]['penerimaanbersih'] = $model->penerimaanbersih;
          $models[$i]['totalpajak'] = $model->totalpajak;
          $models[$i]['tglpesangon'] = $model->tglpesangon;
          $models[$i]['volume'] = 1;
          $models[$i]['satuanvol'] = 'BULAN';
          $models[$i]['totalharga'] = $models[$i]['volume'] * $models[$i]['penerimaanbersih'];

          $i++;
        }

        echo CJSON::encode(
          $this->renderPartial($this->path_view . '_rinciangaji', array('modRinciangaji' => $models), true)
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

      $conditions = "EXTRACT(YEAR FROM tglpesangon) || '-' || EXTRACT(MONTH FROM tglpesangon) = '" . $periode_gaji . "' ";
      $criteria = new CDbCriteria;
      $criteria->select = 'SUM(penerimaanbersih) AS penerimaanbersih';
      $criteria->addCondition($conditions);
      $modPenggajian = PesangonpegT::model()->find($criteria);
      //      $modPenggajian  = PenggajianpegawaiV::model()->find($criteria);
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
          $this->renderPartial($this->path_view . '_listRekening', array('modRekening' => $modRekening, 'modKas' => $modKas), true)
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
        $criteria->addCondition("rekening5_id = " . $rekening5_id);
      }
      // if (!empty($rekening4_id)) {
      //   $criteria->addCondition("rekening4_id = " . $rekening4_id);
      // }
      // if (!empty($rekening3_id)) {
      //   $criteria->addCondition("rekening3_id = " . $rekening3_id);
      // }
      // if (!empty($rekening2_id)) {
      //   $criteria->addCondition("rekening2_id = " . $rekening2_id);
      // }
      // if (!empty($rekening1_id)) {
      //   $criteria->addCondition("rekening1_id = " . $rekening1_id);
      // }

      // $modRekKredit = Rekeningakuntansi5V('searchDialogAccount');

      $model = Rekening5M::model()->findAll($criteria);
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
        'table_name' => 'pengeluaranumum_t',
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
}
