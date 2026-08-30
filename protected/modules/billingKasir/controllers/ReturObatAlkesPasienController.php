<?php

class ReturObatAlkesPasienController extends MyAuthController
{
  protected $successSave = true;

  public function actionIndex($returresep_id = null, $returbayarpelayanan_id = null)
  {
    if (!empty($_GET['frame'])) {
      $this->layout = "//layouts/iframe";
    }

    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $modReturResep = new BKReturresepT;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->untukpembayaran = 'Retur Obat Alkes Pasien';
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();

    $modRetur = new BKReturbayarpelayananT;
    $modRetur->noreturbayar = MyGenerator::noReturBayarPelayanan();
    $modRetur->biayaadministrasi = 0;
    $modRetur->totaltindakanretur = 0;
    $modRetur->totalbiayaretur = 0;
    $modRetur->totaloaretur = 0;
    $modRetur->jumlahpembulatan = 0;

    // pengecekan jika request dari iframe

    $url_batal = Yii::app()->createAbsoluteUrl(
      Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
    );

    if (!empty($returresep_id) && !isset($_POST['BKReturresepT'])) {
      $modReturResep = BKReturresepT::model()->findByPk($returresep_id);
      $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);

      $cr = new CDbCriteria();
      $cr->join = 'join obatalkespasien_t oa on oa.penjualanresep_id = t.penjualanresep_id '
        . 'join oasudahbayar_t osb on osb.obatalkespasien_id = oa.obatalkespasien_id '
        . 'join tandabuktibayar_t bkm on bkm.pembayaranpelayanan_id = osb.pembayaranpelayanan_id and bkm.closingkasir_id is null';
      $cr->order = "bkm.tandabuktibayar_id asc";
      $cr->compare('returresep_id', $returresep_id);

      // mengambil data tandabuktibayar_id kemudian di-set ke returesep_id untuk memudahkan pemanggilan
      $cr->select = "bkm.tandabuktibayar_id as returresep_id";
      $retData = ReturresepT::model()->find($cr);
      if (!empty($retData)) {
        $modRetur->tandabuktibayar_id = $retData->returresep_id;
      }

      // var_dump($retData->returresep_id); die;



      //          RETUR OBAT YG SUDAH BAYAR SAJA   $modRetur->totaloaretur = MyFormatter::formatNumberForUser($modReturResep->totalretur);
      $modRetur->totaloaretur = MyFormatter::formatNumberForPrint($modReturResep->TotalOaSudahBayar);
      $modRetur->totalbiayaretur = MyFormatter::formatNumberForPrint($modRetur->totaloaretur);

      $modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
      $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;

      $modBuktiKeluar->carabayarkeluar = 'TUNAI';



      $modPendaftaran->pasien_id = $modPasien->pasien_id;
      $url_batal = Yii::app()->createAbsoluteUrl(
        Yii::app()->controller->module->id . '/' . Yii::app()->controller->id,
        array(
          'returresep_id' => $_GET['returresep_id'],
          'frame' => 1
        )
      );
    }

    if (!empty($returbayarpelayanan_id) && !empty($_GET['sukses'])) {
      $modRetur = BKReturbayarpelayananT::model()->findByPk($returbayarpelayanan_id);
      $modReturResep = BKReturresepT::model()->findByPk($modRetur->returresep_id);
      $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);

      $modRetur->totaloaretur = MyFormatter::formatNumberForUser($modReturResep->TotalOaSudahBayar);
      $modRetur->totalbiayaretur = MyFormatter::formatNumberForUser($modRetur->totaloaretur);

      $modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
      $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;

      $modPendaftaran->pasien_id = $modPasien->pasien_id;
    }

    if (isset($_POST['BKReturbayarpelayananT']) && !empty($_POST['BKReturresepT']['pasien_id'])) {
      $modPasien = BKPasienM::model()->findByPk($_POST['BKReturresepT']['pasien_id']);

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->successSave = true;

        $modRetur = $this->saveReturBayarPelayanan($_POST['BKReturbayarpelayananT'], $_POST['BKReturresepT']);
        $modBuktiKeluar = $this->saveTandaBuktiKeluar($modRetur, $_POST['BKTandabuktikeluarT'], $modReturResep);

        $this->insertJurnalReturBayarOA($modRetur, $modBuktiKeluar);

        // var_dump($this->successSave); die;

        // die;

        if ($this->successSave) {

          $this->notifReturFarmasi($modRetur);
          // die;
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $transaction->commit();
          $modRetur->isNewRecord = FALSE;
          $this->redirect(array('index', 'returbayarpelayanan_id' => $modRetur->returbayarpelayanan_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }


    $this->render(
      'index',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modBuktiKeluar' => $modBuktiKeluar,
        'modRetur' => $modRetur,
        'modReturResep' => $modReturResep,
        'url_batal' => $url_batal
      )
    );
  }

  protected function insertJurnalReturBayarOA($modRetur, $modBuktiKeluar)
  {

    if (Yii::app()->user->getState('isjurnalotomatis') != true) {
      return;
    }

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $returResep = ReturresepT::model()->findByPk($modRetur->returresep_id);
    $pendaftaran = PendaftaranT::model()->findByPk($returResep->pendaftaran_id);

    $format = new MyFormatter();

    // jurnal rekening
    $modJurnalRekening = new JurnalrekeningT();
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modRetur->tglreturpelayanan);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modRetur->noreturbayar;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modRetur->tglreturpelayanan);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Pengembalian Uang Retur Resep - ' . $pendaftaran->no_pendaftaran . " - " . $pendaftaran->pasien->nama_pasien;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($modRetur->tglreturpelayanan);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $modRetur->ruangan_id;
    $modJurnalRekening->returbayarpelayanan_id = $modRetur->returbayarpelayanan_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
    }

    // jurnal detail total retur (D)
    $administrasi = RekeningcolumnM::model()->findByAttributes(array(
      'table_name' => 'returbayarpelayanan_t',
      'column_name' => 'totalbiayaretur',
      'debitkredit' => 'D',
    ));
    if (!empty($administrasi)) {
      $this->successSave = $this->successSave && JurnaldetailT::model()->simpanJurnalDetail(
        $modJurnalRekening,
        $administrasi->rekening5_id,
        1,
        $modJurnalRekening->urianjurnal,
        $modRetur->totalbiayaretur,
        true
      );
    }

    // jurnal detail administrasi (D)
    $administrasi = RekeningcolumnM::model()->findByAttributes(array(
      'table_name' => 'returbayarpelayanan_t',
      'column_name' => 'biayaadministrasi',
      'debitkredit' => 'D',
    ));
    if (!empty($administrasi) && isset($modRetur->biayaadministrasi) && $modRetur->biayaadministrasi > 0) {
      $this->successSave = $this->successSave && JurnaldetailT::model()->simpanJurnalDetail(
        $modJurnalRekening,
        $administrasi->rekening5_id,
        2,
        $modJurnalRekening->urianjurnal,
        $modRetur->biayaadministrasi,
        true
      );
    }

    // jurnal detail pembulatan (D)
    $rekpembulatan = RekeningcolumnM::model()->findByAttributes(array(
      'table_name' => 'returbayarpelayanan_t',
      'column_name' => 'jumlahpembulatan',
      'debitkredit' => 'D',
    ));
    if (!empty($rekpembulatan) && isset($modRetur->jumlahpembulatan) && $modRetur->jumlahpembulatan > 0) {
      $this->successSave = $this->successSave && JurnaldetailT::model()->simpanJurnalDetail(
        $modJurnalRekening,
        $rekpembulatan->rekening5_id,
        3,
        $modJurnalRekening->urianjurnal,
        $modRetur->jumlahpembulatan,
        true
      );
    }

    if (!empty($rekpembulatan) && isset($modRetur->jumlahpembulatan) && $modRetur->jumlahpembulatan < 0) {
      $this->successSave = $this->successSave && JurnaldetailT::model()->simpanJurnalDetail(
        $modJurnalRekening,
        $rekpembulatan->rekening5_id,
        3,
        $modJurnalRekening->urianjurnal,
        abs($modRetur->jumlahpembulatan),
        false
      );
    }

    // jurnal detail kas (K)
    $carakeluar = RekeningcolumnM::model()->findByAttributes(array(
      'table_name' => 'returbayarpelayanan_t',
      'column_name' => 'totalbiayaretur_biayaadministrasi',
      'debitkredit' => 'K',
    ));

    if (!empty($carakeluar)) {
      $this->successSave = $this->successSave && JurnaldetailT::model()->simpanJurnalDetail(
        $modJurnalRekening,
        $carakeluar->rekening5_id,
        4,
        $modJurnalRekening->urianjurnal,
        $modBuktiKeluar->jmlkaskeluar,
        false
      );
    }
  }

  protected function notifReturFarmasi($modRetur)
  {
    $retur = ReturresepT::model()->findByPk($modRetur->returresep_id);
    $pasien = PasienM::model()->findByPk($retur->pasien_id);


    $judul = "Pembayaran Retur Resep - " . $modRetur->noreturbayar;
    $isi = "";

    if (!empty($pasien)) {
      $isi .= $pasien->no_rekam_medik . " - " . $pasien->nama_pasien . "<br/>";
      $isi .= $retur->noreturresep; //." -> ".MyFormatter::formatNumberForPrint($modRetur->totalbiayaretur);
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK), //, 'link_proses'=>$link_rj
    ));

    // var_dump($ok, $judul, $isi, $retur->attributes, $modRetur->attributes); die;
  }

  protected function saveReturBayarPelayanan($postRetur, $modReturResep)
  {
    $format = new MyFormatter();
    $modRetur = new BKReturbayarpelayananT;
    $modRetur->attributes = $postRetur;
    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modRetur->tglreturpelayanan = $format->formatDateTimeForDb($postRetur['tglreturpelayanan']);
    $modRetur->create_time = date('Y-m-d H:i:s');
    $modRetur->create_loginpemakai_id =  Yii::app()->user->id;
    $modRetur->create_ruangan =   Yii::app()->user->getState('ruangan_id');
    $modRetur->returresep_id = $modReturResep['returresep_id'];
    $modRetur->noreturbayar = MyGenerator::noReturBayarPelayanan();

    $modRetur->totaloaretur = $modRetur->totalbiayaretur = MyFormatter::formatRupiahForDb($modRetur->totaloaretur);

    // var_dump($modRetur->attributes); die;

    if ($modRetur->validate()) {
      if ($modRetur->save()) {
        $this->successSave = $this->successSave && true;
        TandabuktibayarT::model()->updateByPk($modRetur->tandabuktibayar_id, array('returbayarpelayanan_id' => $modRetur->returbayarpelayanan_id));
      }
    } else {
      $this->successSave = false;
    }

    return $modRetur;
  }

  protected function saveTandaBuktiKeluar($modRetur, $postBuktiKeluar, $modReturResep)
  {
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturpelayanan;
    $modBuktiKeluar->jmlkaskeluar = $modRetur->totalbiayaretur;
    $modBuktiKeluar->biayaadministrasi = $modRetur->biayaadministrasi;
    $modBuktiKeluar->keterangan_pengeluaran = $modRetur->keteranganretur;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->jmlkaskeluar = MyFormatter::formatRupiahForDB($modBuktiKeluar->jmlkaskeluar);
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->returbayarpelayanan_id = $modRetur->returbayarpelayanan_id;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id =  Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan =   Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
      BKReturbayarpelayananT::model()->updateByPk(
        $modRetur->returbayarpelayanan_id,
        array(
          'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id
        )
      );
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  public function actionPrintRetur($returbayarpelayanan_id, $frame = null)
  {
    if (!empty($returbayarpelayanan_id)) {
      if (empty($frame)) {
        $this->layout = '//layouts/printWindows';
      } else {
        $this->layout = '//layouts/iframe';
      }

      $attributes = array(
        'returpembayaranpelayanan_id' => $returbayarpelayanan_id
      );
      $judulLaporan = '';
      $return = BKReturbayarpelayananT::model()->findByPk($returbayarpelayanan_id);
      $model_tandabuktibayar = BKTandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $return->tandabuktikeluar_id));
      $judulLaporan = 'Tanda Bukti Retur Obat Alkes Pasien';
      $this->render(
        'kwitansiReturTagihan',
        array(
          'model' => $return,
          'tandabuktibayar' => $model_tandabuktibayar,
          'judulLaporan' => $judulLaporan,
        )
      );
    }
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
}
