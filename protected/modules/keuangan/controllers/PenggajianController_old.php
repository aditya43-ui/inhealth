<?php

class PenggajianController_old extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";

  public function actionIndex($idPenggajian = null, $pengeluaranumum_id = null)
  {
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;

    $modUraian[0] = new KUUraiankeluarumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;


    if (!empty($idPenggajian)) {

      $modGaji = PenggajianpegT::model()->findByPk($idPenggajian);
      $jmlgaji = $modGaji->totalterima;
      $modUraian[0] = new KUUraiankeluarumumT;
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
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();

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
    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalDetail = new KUJurnaldetailT;
    $modJurnalPosting = new KUJurnalpostingT;

    if (!empty($pengeluaranumum_id)) {
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
    }

    if (isset($_POST['KUPengeluaranumumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['KUTandabuktikeluarT']);
        $modPengUmum = $this->savePengeluaranUmum($_POST['KUPengeluaranumumT'], $modBuktiKeluar, $_POST['KUUraiankeluarumumT']);
        $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

        if ($modPengUmum->isurainkeluarumum && isset($_POST['KUUraiankeluarumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraiankeluarumumT'], $modPengUmum, $idPenggajian);
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

    $this->render('index', array(
      'modPengUmum' => $modPengUmum,
      'modUraian' => $modUraian,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modJurnalRekening' => $modJurnalRekening,
      'modJurnalDetail' => $modJurnalDetail,
      'modJurnalPosting' => $modJurnalPosting
    ));
  }

  protected function updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum)
  {
    KUTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, array('pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id));
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

          $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['KUPengeluaranumumT']);

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
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = $postBuktiKeluar['biayaadministrasi'];
    // $modBuktiKeluar->jmlkaskeluar = 0;
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
    if (count((array)$postUraian) > 0) {
      foreach ($postUraian as $i => $value) {
        $modUraian[$i] = new KUUraiankeluarumumT;
        $modUraian[$i]->totalharga = $value['totalharga'];
        $modUraian[$i]->hargasatuan = $value['hargasatuan'];
        $modUraian[$i]->satuanvol = $value['satuanvol'];
        $totalharga += $modUraian[$i]->totalharga;
      }
    }
    $format = new MyFormatter();
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
    $modPengUmum->totalharga = $totalharga;
    $modPengUmum->hargasatuan = $totalharga;
    $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_PENGGAJIAN;
    $modPengUmum->satuanvol = $modUraian[$i]->satuanvol;
    $modPengUmum->tglpengeluaran = $format->formatDateTimeForDB($postPengeluaran['tglpengeluaran']);
    $modPengUmum->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPengUmum->create_loginpemakai_id = Yii::app()->user->id;
    $modPengUmum->create_time = date('Y-m-d H:i:s');
    $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;

    if ($modPengUmum->validate()) {
      //                $postRekenings = $_POST['RekeningakuntansiV']; // komen sementara => tabel belum dibuat untuk RekeningakuntansiV
      //                if(isset($postRekenings)){//simpan jurnal rekening
      //                    if(count((array)$postRekenings) > 0){
      //
      //                     $modJurnalRekening = PenggajianController::saveJurnalRekening($modPengUmum, $data_parsing['KUPengeluaranumumT']);
      //                     $saveDetailJurnal = PenggajianController::saveJurnalDetail($modJurnalRekening, $postRekenings, null);
      //                    }
      //            }

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

  protected function saveUraian($arrPostUraian, $modPengUmum, $idPenggajian)
  {
    $valid = false;
    $modUraian = array();
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      $modUraian[$i] = new KUUraiankeluarumumT;
      $modUraian[$i]->attributes = $arrPostUraian[$i];
      $penggajianpeg_id = isset($idPenggajian) ? $idPenggajian : null;
      $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
      if ($modUraian[$i]->validate()) {
        $modUraian[$i]->save();
        $valid = true;

        $attributes = array(
          'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id
        );
        PenggajianpegT::model()->updateByPk($penggajianpeg_id, $attributes);
      } else {
        $this->pesan = $modUraian[$i]->getErrors();
      }
    }

    $this->succesSave = $valid;
    return $modUraian;
  }

  protected function saveJurnalRekening($modPenUmum, $postPenUmum)
  {
    $format = new MyFormatter();
    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $postPenUmum['jenisKodeNama'];


    /*
            $attributes = array(
                'jenisjurnal_aktif' => true
            );
            $jenisjurnal_id = JenisjurnalM::model()->findByAttributes($attributes);
            $modJurnalRekening->jenisjurnal_id = $jenisjurnal_id->jenisjurnal_id;
             *
             */

    $modJurnalRekening->jenisjurnal_id = Params::JURNAL_PENGELUARAN_KAS;
    $periodeID = Yii::app()->session['periodeID'];
    $modJurnalRekening->rekperiod_id = $periodeID[0];
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($modPenUmum->tglpengeluaran);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');


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
    $modJurnalPosting = null;
    if ($jenisSimpan == 'posting') {
      $modJurnalPosting = new JurnalpostingT;
      $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      $modJurnalPosting->keterangan = "Posting automatis";
      $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      if ($modJurnalPosting->validate()) {
        $modJurnalPosting->save();
      }
    }

    foreach ($postRekenings as $i => $rekening) {
      $model[$i] = new JurnaldetailT();
      $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model[$i]->uraiantransaksi = $rekening['nama_rekening'];
      $model[$i]->saldodebit = $rekening['saldodebit'];
      $model[$i]->saldokredit = $rekening['saldokredit'];
      $model[$i]->nourut = $i + 1;
      // $model[$i]->rekening1_id = $rekening['struktur_id'];
      // $model[$i]->rekening2_id = $rekening['kelompok_id'];
      // $model[$i]->rekening3_id = $rekening['jenis_id'];
      // $model[$i]->rekening4_id = $rekening['obyek_id'];
      $model[$i]->rekening5_id = $rekening['rincianobyek_id'];
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
                $model[$i] = new KUJurnaldetailT();
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

  public function actionambilDataGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode        = explode(' ', $_POST['periode']);
      $periode_bulan  = $periode[0];
      $periode_tahun  = $periode[1];
      $format         = new MyFormatter;
      $bulan_angka    = $format->formatMonthForDb($periode_bulan);
      $periode_gaji   = $periode_tahun . '-' . $bulan_angka . '-01';

      // $modPenggajian  = PenggajianpegawaiV::model()->findAllByAttributes(array(''));

      $conditions = "periodegaji = '" . $periode_gaji . "' ";
      $criteria       = new CDbCriteria;
      $criteria->addCondition($conditions);
      $modPenggajian  = PenggajianpegawaiV::model()->findAll($criteria);
      if (count((array)$modPenggajian) > 0) {
        foreach ($modPenggajian as $i => $model) {
          $models[$i]['uraian']   = $model->nama_pegawai . ' - ' . $model->nopenggajian;
          $models[$i]['pegawai_id']     = $model->pegawai_id;
          $models[$i]['periodegaji']    = $model->periodegaji;
          $models[$i]['penggajianpeg_id']   = $model->penggajianpeg_id;
          $models[$i]['penerimaanbersih']   = $model->penerimaanbersih;
          $models[$i]['tglpenggajian']  = $model->tglpenggajian;
          $models[$i]['volume']       = 1;
          $models[$i]['satuanvol']    = 'BULAN';
          $models[$i]['totalharga']   = $models[$i]['volume'] * $models[$i]['penerimaanbersih'];
        }
        echo CJSON::encode(
          $this->renderPartial('keuangan.views.penggajian._rinciangaji', array('modRinciangaji' => $models), true)
        );
      } else {
        echo CJSON::encode();
      }
      Yii::app()->end();
    }
  }

  public function actiontampilRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode        = explode(' ', $_POST['periode']);
      $periode_bulan  = $periode[0];
      $periode_tahun  = $periode[1];
      $format         = new MyFormatter;
      $bulan_angka    = $format->formatMonthForDb($periode_bulan);
      $periode_gaji   = $periode_tahun . '-' . $bulan_angka . '-01';

      $conditions = "periodegaji = '" . $periode_gaji . "' ";
      $criteria       = new CDbCriteria;
      $criteria->select = 'SUM(penerimaanbersih) AS penerimaanbersih';
      $criteria->addCondition($conditions);
      $modPenggajian  = PenggajianpegawaiV::model()->find($criteria);
      $modKas = $modPenggajian->penerimaanbersih;

      $criteria   = new CDbCriteria;
      $criteria->addCondition('rekening5_id IS NOT NULL');
      $criteria->order = 'nourutgaji';
      $modKomponenGaji = KomponengajiM::model()->findAll($criteria);

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
          $this->renderPartial('keuangan.views.penggajian._listRekening', array('modRekening' => $modRekening, 'modKas' => $modKas), true)
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


    $this->render('print', array(
      'modBuktiKeluar' => $modBuktiKeluar,
    ));
  }
}
