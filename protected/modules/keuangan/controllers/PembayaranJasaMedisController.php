<?php

class PembayaranJasaMedisController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";
  public $path_view = 'keuangan.views.pembayaranJasaMedis.';

  public function actionIndex($pembayaranjasa_id = null, $pengeluaranumum_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Jasa Dokter";
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;

    $modPengUmum->periodegaji = MyFormatter::formatMonthForUser(date('Y-m'));

    $modUraian[0] = new KUUraiankeluarumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;


    if (!empty($pembayaranjasa_id)) {

      $modGaji = PembayaranjasaT::model()->findByPk($pembayaranjasa_id);
      $jmlgaji = $modGaji->totaljasa;
      $modUraian[0] = new KUUraiankeluarumumT;
      $modUraian[0]->uraiantransaksi = 'Jasa Periode ' . $modGaji->periodejasa . '(' . $modGaji->pegawai->nama_pegawai . ' - ' . $modGaji->pegawai->nomorindukpegawai . ')';
      $modUraian[0]->volume = 1;
      $modUraian[0]->hargasatuan = $jmlgaji;
      $modUraian[0]->totalharga = $jmlgaji;
      $pegawai_id = $modGaji->pegawai_id;
    }
    if (!empty($pengeluaranumum_id)) {
      $modGaji = PembayaranjasaT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
    }

    if (!empty($jmlgaji)) {
      $modPengUmum->jmlgaji = $jmlgaji;
    }
    $modPengUmum->nopengeluaran = '-- Otomatis --'; //MyGenerator::noPengeluaranUmum();

    if (!empty($pegawai_id)) {
      $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
    }

    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = "-- Otomatis --";
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;
    $modBuktiKeluar->namapenerima = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : "";
    $modBuktiKeluar->alamatpenerima = isset($modPegawai->alamat_pegawai) ? $modPegawai->alamat_pegawai : "";
    $modBuktiKeluar->untukpembayaran = 'Jasa ' . $modPengUmum->periodegaji;

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalDetail = new KUJurnaldetailT;
    $modJurnalPosting = new KUJurnalpostingT;

    if (!empty($pengeluaranumum_id)) {
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
      if (empty($modBuktiKeluar)) {
        $modBuktiKeluar = new KUTandabuktikeluarT;
      }
    }

    if (isset($_POST['KUPengeluaranumumT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['KUTandabuktikeluarT']);
        $modPengUmum = $this->savePengeluaranUmum($_POST['KUPengeluaranumumT'], $modBuktiKeluar, $_POST['KUUraiankeluarumumT']);
        $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

        if ($modPengUmum->isurainkeluarumum && isset($_POST['KUUraiankeluarumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraiankeluarumumT'], $modPengUmum, $pembayaranjasa_id);
        }

        if (Yii::app()->user->getState('isjurnalotomatis') == true) {
          $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $_POST['KUUraiankeluarumumT']);
          $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
        }

        if ($this->succesSave) {
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
      'modJurnalPosting' => $modJurnalPosting
    ));
  }

  public function actionSimpanPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $format = new MyFormatter();
      if (isset($data_parsing['KUPengeluaranumumT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {

          $modBuktiKeluar = $this->saveTandaBuktiKeluar($data_parsing['KUTandabuktikeluarT']);
          $data_parsing['KUPengeluaranumumT']['tglpengeluaran'] = $format->formatDateTimeForDB($data_parsing['KUPengeluaranumumT']['tglpengeluaran']);
          $modPengUmum = $this->savePengeluaranUmum($data_parsing['KUPengeluaranumumT'], $modBuktiKeluar);
          if (isset($data_parsing['KUPengeluaranumumT']['isurainkeluarumum'])) {
            $modUraian = $this->saveUraian($data_parsing['KUUraiankeluarumumT'], $modPengUmum);
          }

          // die;

          // $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['GJPengeluaranumumT']);

          //                    $params = array(
          //                        'modJurnalRekening' => $modJurnalRekening,
          //                        'jenis_simpan'=>$_REQUEST['jenis_simpan'],
          //                        'RekeningakuntansiV'=>$data_parsing['RekeningakuntansiV'],
          //                    );
          //                    $insertDetailJurnal = MyFunction::insertDetailJurnal($params);
          //                    $this->succesSave = $insertDetailJurnal;


          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['KUUraiankeluarumumT']);
            $this->saveJurnalDetail($modJurnalRekening, $data_parsing['RekeningakuntansiV']);
          }

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
            //                        $transaction->commit();
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
    $modBuktiKeluar = new KUTandabuktikeluarT;
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

        $modUraian[$i] = new KUUraiankeluarumumT;
        $modUraian[$i]->totalharga = $value['totalharga'];
        $modUraian[$i]->hargasatuan = $value['hargasatuan'];
        $modUraian[$i]->satuanvol = $value['satuanvol'];
        $totalharga += $modUraian[$i]->totalharga;
        $last = $i;
      }
    }

    $format = new MyFormatter();
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
    $modPengUmum->totalharga = $totalharga;
    $modPengUmum->hargasatuan = $totalharga;
    $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_PEMBAYARANJASA;
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
      KUTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, $attributes);
    } else {
      $this->succesSave = false;
      $this->pesan = $modPengUmum->getErrors();
    }

    return $modPengUmum;
  }

  protected function saveJurnalRekening($modPenUmum, $uraian)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopengeluaran;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobku = "";
    $namaPeg = "";
    $periode = "";

    if (count((array)$uraian) > 0) {
      $pembayaranjasa = $uraian[0]['pembayaranjasa_id'];
    }
    $pembyr = PembayaranjasaT::model()->findByPk($pembayaranjasa);


    if (isset($pembyr)) {
      if (count((array)$uraian) == 1) {
        $namaPeg = "- " . $pembyr->pegawai->namaLengkap;
      }
      $periode = date('M Y', strtotime($format->formatDateTimeForDB($pembyr->periodejasa)));
    }
    $modJurnalRekening->urianjurnal = 'Pembayaran Jasa Dokter ' . $namaPeg . " - " . $periode; //$postPenUmum['jenisKodeNama'];


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
    //        if($jenisSimpan == 'posting')
    //        {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if($modJurnalPosting->validate()){
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

  protected function updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum)
  {
    KUTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, array('pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id));
  }

  protected function saveUraian($arrPostUraian, $modPengUmum, $pembayaranjasa_id)
  {
    $valid = false;
    $modUraian = array();

    // var_dump($arrPostUraian);

    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {



      $modUraian[$i] = new KUUraiankeluarumumT;
      $modUraian[$i]->attributes = $arrPostUraian[$i];
      $pembayaranjasa_id = isset($arrPostUraian[$i]['pembayaranjasa_id']) ? $arrPostUraian[$i]['pembayaranjasa_id'] : null;
      $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
      $modUraian[$i]->pembayaranjasa_id = $pembayaranjasa_id;

      // var_dump($modUraian[$i]->attributes); die;

      if ($modUraian[$i]->validate()) {
        $modUraian[$i]->save();
        $valid = true;

        if (!empty($pembayaranjasa_id)) {
          // var_dump($penggajianpeg_id, $modPengUmum->pengeluaranumum_id);
          PembayaranjasaT::model()->updateByPk($pembayaranjasa_id, array(
            'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id,
            'tandabuktikeluar_id' => $modPengUmum->tandabuktikeluar_id
          ));
        }
      } else {
        $this->pesan = $modUraian[$i]->getErrors();
      }
    }


    $this->succesSave = $valid;
    return $modUraian;
  }

  public function actionAmbilDataGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode_gaji = MyFormatter::formatMonthForDB($_POST['periode']);
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;

      $conditions = "(case when periodejasa is null then tglbayarjasa::date else periodejasa::date end)::date between '" . $periode_gaji . '-01' . "'::date and '" . date("Y-m-t", strtotime($periode_gaji . '-01')) . "'::date";
      $criteria = new CDbCriteria;
      $criteria->addCondition($conditions);
      if (!empty($pegawai_id)) {
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
      }
      $criteria->addCondition("jurnalrekening_id IS NOT NULL");

      $criteria->order = 'nama_pegawai';
      $modPembayaranjasa  = PembayaranjasapegawaiV::model()->findAll($criteria);
      if (count((array)$modPembayaranjasa) > 0) {
        $i = 0;
        foreach ($modPembayaranjasa as $k => $model) {

          $uraian = UraiankeluarumumT::model()->findAllByAttributes(array(
            'pembayaranjasa_id' => $model->pembayaranjasa_id
          ));
          $total = 0;
          foreach ($uraian as $det) {
            $total += $det->totalharga;
          }

          if ($total >= $model->total_terima) continue;

          $model->total_terima -= $total;

          $models[$i]['uraian']             = $model->nama_pegawai . ' - ' . $model->nobayarjasa;
          $models[$i]['pegawai_id']         = $model->pegawai_id;
          $models[$i]['periodegaji']        = $model->periodejasa;
          $models[$i]['pembayaranjasa_id']   = $model->pembayaranjasa_id;
          $models[$i]['penerimaanbersih']   = $model->total_terima;
          $models[$i]['totalpajak']         = $model->pajakprogressif;
          $models[$i]['tglpenggajian']      = $model->tglbayarjasa;
          $models[$i]['volume']             = 1;
          $models[$i]['satuanvol']          = 'BULAN';
          $models[$i]['totalharga']         = $models[$i]['volume'] * $models[$i]['penerimaanbersih'];

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
      $periode        = explode('-', $_POST['periode']);
      $periode_bulan  = $periode[1];
      $periode_tahun  = $periode[0];
      // $format         = new MyFormatter;
      // $bulan_angka    = $format->formatMonthForDb($periode_bulan);
      $periode_gaji   = $periode_tahun . '-' . $periode_bulan;

      $conditions = "EXTRACT(YEAR FROM tglpenggajian) || '-' || EXTRACT(MONTH FROM tglpenggajian) = '" . $periode_gaji . "' ";
      $criteria       = new CDbCriteria;
      $criteria->select = 'SUM(penerimaanbersih) AS penerimaanbersih';
      $criteria->addCondition($conditions);
      $modPenggajian  = PenggajianpegawaiV::model()->find($criteria);
      $modKas = $modPenggajian->penerimaanbersih;

      $criteria   = new CDbCriteria;
      $criteria->addCondition('rekening5_id IS NOT NULL');
      $criteria->order = 'nourutgaji';
      $modKomponenGaji = KomponengajirekM::model()->findAll($criteria);

      if (count((array)$modKomponenGaji) > 0) {
        $ind = 1;
        foreach ($modKomponenGaji as $i => $model) {
          $modRekening[$ind]['kdstruktur']      = $model->rekening->rekening1->kdrekening1;
          $modRekening[$ind]['struktur_id']     = $model->rekening->rekening1_id;
          $modRekening[$ind]['kdkelompok']      = $model->rekening->rekening2->kdrekening2;
          $modRekening[$ind]['kelompok_id']     = $model->rekening->rekening2_id;
          $modRekening[$ind]['kdjenis']         = $model->rekening->rekening3->kdrekening3;
          $modRekening[$ind]['jenis_id']        = $model->rekening->rekening3_id;
          $modRekening[$ind]['kdobyek']         = $model->rekening->rekening4->kdrekening4;
          $modRekening[$ind]['obyek_id']        = $model->rekening->rekening4_id;
          $modRekening[$ind]['kdrincianobyek']  = $model->rekening->kdrekening5;
          $modRekening[$ind]['rincianobyek_id'] = $model->rekening->rekening5_id;
          $modRekening[$ind]['nama_rekening']   = $model->rekening->nmrekening5;
          $modRekening[$ind]['rekDebitKredit']  = $model->rekening->nmrekening5;

          $conditions = "periodegaji = '" . $periode_gaji . "' AND pengeluaranumum_id is null AND komponengaji_id=" . $model->komponengaji_id . "";
          $criteria       = new CDbCriteria;
          $criteria->select = 'SUM(jumlah) AS jumlah';
          $criteria->addCondition($conditions);
          $modNilai   = RekapgajipegawaiV::model()->find($criteria);

          if ($model->ispotongan == TRUE) {
            $modRekening[$ind]['saldodebit']      = 0;
            $modRekening[$ind]['saldokredit']     = isset($modNilai->jumlah) ? $modNilai->jumlah : 0;
          } else {
            $modRekening[$ind]['saldodebit']      = isset($modNilai->jumlah) ? $modNilai->jumlah : 0;
            $modRekening[$ind]['saldokredit']     = 0;
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
      $status      = isset($_POST['status']) ? $_POST['status'] : null;
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
      $jmlkaskeluar = isset($_POST['jmlkaskeluar']) ? $_POST['jmlkaskeluar'] : 0;
      //                        $carabayar = isset($_POST['carabayar']) ? $_POST['carabayar'] : null;
      $carabayarkeluar = isset($_POST['carabayarkeluar']) ? $_POST['carabayarkeluar'] : null;
      $bankid = ((isset($_POST['bankid']) && !empty($_POST['bankid'])) ? $_POST['bankid'] : null);
      //			$criteria = new CDbCriteria;
      //
      $debit_kas = RekeningcolumnM::model()->findByAttributes(array(
        'table_name' => 'pembayaranjasa_t',
        'column_name' => 'total_terima',
        'debitkredit' => 'D',
      ));

      $debit_jasa = RekeningcolumnM::model()->findByAttributes(array(
        'table_name' => 'pembayaranjasa_t',
        'column_name' => 'total_terima',
        'debitkredit' => 'K',
      ));

      $debit_bni = RekeningcolumnM::model()->findByAttributes(array(
        'table_name' => 'pembayaranjasa_t',
        'column_name' => 'pengeluaranumum_id',
        'debitkredit' => 'D',
      ));
      $row_rekening = "";

      $row_rekening .= $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiRow', array(
        'detail' => $debit_jasa, 'saldo_debit' => MyFormatter::formatNumberForPrint($jmlkaskeluar), 'saldo_kredit' => 0, 'key' => 0,
      ), true);

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

      $row_rekening .= $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiRow', array(
        'detail' => $kredit_gaji, 'saldo_debit' => 0, 'saldo_kredit' => MyFormatter::formatNumberForPrint($jmlkaskeluar), 'key' => 1,
      ), true);

      //                        if(!empty($carabayar)){
      //                            if($carabayar == "TRANSFER"){
      //                                 $row_rekening .= $this->renderPartial($this->path_view .'__formKodeRekeningAkuntansiRow', array(
      //                                    'detail'=>$debit_bni, 'saldo_debit'=> 0, 'saldo_kredit'=>MyFormatter::formatNumberForPrint($jmlkaskeluar), 'key'=>1,
      //                                ), true);
      //                            }else{
      //                               $row_rekening .= $this->renderPartial($this->path_view .'__formKodeRekeningAkuntansiRow', array(
      //                                    'detail'=>$debit_kas, 'saldo_debit'=> 0, 'saldo_kredit'=>MyFormatter::formatNumberForPrint($jmlkaskeluar), 'key'=>1,
      //                                ), true);
      //                            }
      //                        }

      echo CJSON::encode(
        $row_rekening
      );
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningManual()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = RekeningcolumnM::model()->findAllByAttributes(array(
        'table_name' => 'pengeluaranumum_t:pembayaranjasa',
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
