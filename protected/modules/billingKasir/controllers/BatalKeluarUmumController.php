<?php

class BatalKeluarUmumController extends MyAuthController
{
  protected $successSave = true;
  public $path_view = 'billingKasir.views.batalKeluarUmum.';

  public function actionIndex($id = null)
  {
    $format = new MyFormatter;
    $modBatalBayar = new BKBatalKeluarUmumT;
    $modPengeluaran = new BKPengeluaranumumT;
    $modTandabukti = new TandabuktibayarT;
    $modPenUmum = new PenerimaanumumT;
    $modPenUmum->nopenerimaan = '-- Otomatis --';

    $modTandabukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
    $modTandabukti->nobuktibayar = "-- Otomatis --";
    $modTandabukti->sebagaipembayaran_bkm = "Batal Pengeluaran Kas/Umum.";
    
    
    if (!empty($id)) {
            $keluar = PengeluaranumumT::model()->findByPk($id);
            if (!empty($keluar)) {
                $tandabukti = TandabuktikeluarT::model()->findByPk($keluar->tandabuktikeluar_id);
                $jenis = JenispengeluaranM::model()->findByPk($keluar->jenispengeluaran_id);
                $modPengeluaran->jenispengeluaran_id = $jenis->jenispengeluaran_nama;
                $modPengeluaran->tandabuktikeluar_id = $keluar->tandabuktikeluar_id;
                $modPengeluaran->kelompoktransaksi = $keluar->kelompoktransaksi;
                $modPengeluaran->tglpengeluaran = $keluar->tglpengeluaran;
                $modPengeluaran->volume = $keluar->volume;
                $modPengeluaran->satuanvol = $keluar->satuanvol;
                $modPengeluaran->hargasatuan = MyFormatter::formatNumberForPrint($keluar->hargasatuan);
                $modPengeluaran->totalharga = MyFormatter::formatNumberForPrint($keluar->totalharga);
                $modPengeluaran->biayaadministrasi = MyFormatter::formatNumberForPrint($keluar->biayaadministrasi);
                $modPengeluaran->keterangankeluar = $keluar->keterangankeluar;
                $modPengeluaran->nopengeluaran = $keluar->nopengeluaran;
                $modPengeluaran->pengeluaranumum_id = $keluar->pengeluaranumum_id;
                
                $modTandabukti->jmlpembayaran = MyFormatter::formatNumberForPrint($keluar->totalharga);
                $modTandabukti->uangditerima = MyFormatter::formatNumberForPrint($keluar->totalharga);
                $modTandabukti->darinama_bkm = $tandabukti->namapenerima;
                $modTandabukti->alamat_bkm = $tandabukti->alamatpenerima;
                $modTandabukti->sebagaipembayaran_bkm = "Batal Pengeluaran Kas/Umum - ".$keluar->nopengeluaran;
            }
        }
    

    if (isset($_POST['BKBatalKeluarUmumT'])) {

      // var_dump($_POST); die;

      $modPengeluaran->attributes = $_POST['BKPengeluaranumumT'];

      $modPengeluaran->tglpengeluaran = $format->formatDateTimeForDb($_REQUEST['BKPengeluaranumumT']['tglpengeluaran']);

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBatalBayar = $this->saveBatalKeluarUmum($_POST['BKBatalKeluarUmumT']);
        $this->updateBuktiKeluar($modBatalBayar);
        $this->updatePengeluaranUmum($modBatalBayar);
        $modTandabukti = $this->saveTandaBukti($_POST['TandabuktibayarT'], $modBatalBayar);
        $modPenUmum = $this->savePenerimaan($_POST['PenerimaanumumT'], $modTandabukti, $modBatalBayar);

        if (isset($_POST['BKRekeningakuntansiV'])) {

          $modJurnalRekening = $this->saveJurnalRekening($modPenUmum, $modBatalBayar, $modPengeluaran);
          $modJurnalDetail = $this->saveJurnalDetail(
            $modJurnalRekening,
            // $modJurnalPosting,
            $_POST['BKRekeningakuntansiV'],
            null
          );
        } else {
          if (!empty($modBatalBayar->batalkeluarumum_id)) {
            $res = Yii::app()->db
              ->createCommand("select set_afterbatalkeluarumum_fix(" . $modBatalBayar->batalkeluarumum_id . ") as simpan")
              ->queryRow();

            if (!empty($res)) {
              $this->successSave = $this->successSave && $res['simpan'];
            }
            // var_dump($res);
          }
        }

        // var_dump($this->successSave); die;

        $this->notifBatalKeluar($modBatalBayar);

        if ($this->successSave) {
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

    $this->render($this->path_view . 'index', array(
      'modBatalBayar' => $modBatalBayar,
      'modPengeluaran' => $modPengeluaran,
      'modPenUmum' => $modPenUmum,
      'modTandabukti' => $modTandabukti
    ));
  }

  protected function notifBatalKeluar($model)
  {

    $modKeluar = PengeluaranumumT::model()->findByPk($model->pengeluaranumum_id);


    //        print_r($modKeluar->attributes);
    //        print_r($model->attributes); die;

    $judul = "Pembatalan Pengeluaran Umum - " . $modKeluar->nopengeluaran;
    //$jenis = JenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);

    $isi = "Tgl. Pembatalan : " . MyFormatter::formatDateTimeForUser($model->tglbatalkeluar) . "<br/>";
    $isi .= "Alasan : " . $model->alasanbatalkeluar . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);


    //        print_r($isi); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    ));
  }


  /**
   * Dupliasi fungsi dari keuangan.penerimaanUmum
   */
  protected function saveTandaBukti($postTandaBukti, $modBatalBayar)
  {
    $format = new MyFormatter();
    $modTandaBukti = new TandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBukti;
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
    $modTandaBukti->shift_id = Yii::app()->user->getState('shift_id');
    $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
    $modTandaBukti->create_time = date('Y-m-d H:i:s');
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
    $modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->batalkeluarumum_id = $modBatalBayar->batalkeluarumum_id;
    if ($modTandaBukti->validate()) {
      $modTandaBukti->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      var_dump($modTandaBukti->errors);
      die;
      throw new CDbException("Data tanda bukti bayar belum lengkap");
    }

    // var_dump($modTandaBukti->attributes);

    return $modTandaBukti;
  }

  protected function savePenerimaan($postPenerimaan, $modTandaBukti, $modBatalBayar)
  {

    // var_dump($modBatalBayar->attributes); die;

    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->attributes = $postPenerimaan;
    $modPenUmum->tglpenerimaan = $modTandaBukti->tglbuktibayar;
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modPenUmum->volume = 1;
    $modPenUmum->satuanvol = 'KALI';
    $modPenUmum->hargasatuan = $modTandaBukti->jmlpembayaran;
    $modPenUmum->totalharga = $modPenUmum->volume * $modPenUmum->hargasatuan;
    $modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
    $modPenUmum->batalkeluarumum_id = $modBatalBayar->batalkeluarumum_id;
    $modPenUmum->keterangan_penerimaan = $modTandaBukti->sebagaipembayaran_bkm;
    // var_dump($modPenUmum->attributes); die;

    if ($modPenUmum->validate()) {
      $modPenUmum->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      // var_dump($modPenUmum->errors); die;
      throw new CDbException("Data penerimaan belum lengkap");
    }

    // var_dump($modPenUmum->attributes); die;

    return $modPenUmum;
  }

  protected function saveJurnalRekening($modPenUmum, $modBatalBayar, $modPengeluaran)
  {

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    // $modFakturBeli = FakturpembelianT::model()->findByPk($modBayarSupplier->fakturpembelian_id);

    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPenUmum->tglpenerimaan, 'JTK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopenerimaan;
    $modJurnalRekening->tglreferensi = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Batal Pengeluaran Umum - ' . $modPengeluaran->nopengeluaran;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = $period;
    $modJurnalRekening->create_time = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->batalkeluarumum_id = $modBatalBayar->batalkeluarumum_id;


    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      throw new CDbException("Data jurnal rekening belum lengkap");
    }
    return $modJurnalRekening;
  }

  protected function saveJurnalDetail($modJurnalRekening, $rekeningakuntansi, $modJurnalPosting = null)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new JurnaldetailT();
      // $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      //                $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";

      if ($model->validate()) {
        $model->save();
      } else {
        $valid = false;
        throw new CDbException("Data jurnal rekening detail belum lengkap");
        break;
      }

      // var_dump($model->attributes);
    }

    // die;

    $this->successSave = $valid;
  }

  /**
   * untuk autocomplete
   */
  public function actionAutocompleteInfoPengeluaranUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('uraian', 'buktikeluar');
      $criteria->compare('LOWER(nopengeluaran)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.batalkeluarumum_id IS NULL');
      $models = PengeluaranumumT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopengeluaran;
        $returnVal[$i]['value'] = $model->nopengeluaran;

        $attrBuktiKeluar = (!empty($model->tandabuktikeluar_id)) ? $model->buktikeluar->attributeNames() : TandabuktikeluarT::model()->attributeNames();
        foreach ($attrBuktiKeluar as $j => $attribute) {
          $returnVal[$i]["buktikeluar"]["$attribute"] = $model->buktikeluar->$attribute;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function saveBatalKeluarUmum($postBatalKeluarUmum)
  {
    $format = new MyFormatter;
    $modBatal = new BKBatalKeluarUmumT;
    $modBatal->attributes = $postBatalKeluarUmum;
    $modBatal->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBatal->tglbatalkeluar = $format->formatDateTimeForDb($_REQUEST['BKBatalKeluarUmumT']['tglbatalkeluar']);
    if ($modBatal->validate()) {
      $modBatal->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBatal;
  }

  protected function updateBuktiKeluar($modBatal)
  {
    TandabuktikeluarT::model()->updateByPk($modBatal->tandabuktikeluar_id, array('batalkeluarumum_id' => $modBatal->batalkeluarumum_id));
  }

  protected function updatePengeluaranUmum($modBatal)
  {
    PengeluaranumumT::model()->updateByPk($modBatal->pengeluaranumum_id, array('batalkeluarumum_id' => $modBatal->batalkeluarumum_id));
  }

  public function actionCekLogin($task = 'Retur')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  // Uncomment the following methods and override them if needed
  /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
