<?php

class ReturTagihanPasienController extends MyAuthController
{
  protected $successSave = true;

  public function actionIndex($pembebasantarif_id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = "//layouts/iframe";
    }
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->untukpembayaran = 'Retur Tagihan Pasien';
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->notemp = '-- Otomatis --';
    // $modBuktiKeluar->carabayarkeluar = Params::CARAPEMBAYARAN_TUNAI;

    $modRetur = new BKReturbayarpelayananT;
    $modRetur->noreturbayar = MyGenerator::noReturBayarPelayanan();
    $modRetur->notemp = '-- Otomatis --';
    $modRetur->biayaadministrasi = 0;
    $modRetur->totaltindakanretur = 0;
    $modRetur->totalbiayaretur = 0;
    $modRetur->totaloaretur = 0;


    


    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    // pengecekan jika request dari iframe

    $url_batal = Yii::app()->createAbsoluteUrl(
      Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
    );

    if (isset($_GET['pendaftaran_id'])) {
      $modPendaftaran = BKPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modBuktiKeluar->namapenerima = $modPasien->no_rekam_medik . " - " . $modPasien->namadepan . $modPasien->nama_pasien;
      $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
    }

    if (isset($_GET['returbayarpelayanan_id'])) {
      $modRetur = BKReturbayarpelayananT::model()->findByPk($_GET['returbayarpelayanan_id']);
      $modRetur->notemp = $modRetur->noreturbayar;
      $nokaskeluar = BKTandabuktikeluarT::model()->findByPk($modRetur->tandabuktikeluar_id)->nokaskeluar;
      $modBuktiKeluar->notemp = $nokaskeluar;
    }

    $bebas = null;
    if (!empty($pembebasantarif_id)) {
      $bebas = PembebasantarifT::model()->findByPk($pembebasantarif_id);

      if (!empty($bebas) && empty($bebas->returbayarpelayanan_id)) {
        $modPendaftaran = BKPendaftaranT::model()->findByPk($bebas->pendaftaran_id);
        $modPasien = $modPendaftaran->pasien;

        // var_dump($bebas->attributes); die;

        $modTindakan = TindakansudahbayarT::model()->findByPk($bebas->tindakansudahbayar_id);
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($modTindakan->pembayaranpelayanan_id);

        $modRetur->tandabuktibayar_id = $modPembayaran->tandabuktibayar_id;
        $modRetur->totaltindakanretur = $bebas->jmlpembebasan;
        $modRetur->totalbiayaretur = $bebas->jmlpembebasan;

        $modBuktiKeluar->namapenerima = $modPasien->no_rekam_medik . " - " . $modPasien->namadepan . $modPasien->nama_pasien;
        $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;

      }
    }

    if (!empty($_GET['idPembayaran']) && !isset($_POST['BKReturbayarpelayananT'])) {
      $modPembayaran = BKPembayaranpelayananT::model()->findByPk($_GET['idPembayaran']);
      $modTindakan = BKTindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id));
      $modPembebasan = array();
      
      foreach ($modTindakan as $m){
        $modPembebasan_proto = PembebasantarifT::model()->findAllByAttributes(array('tindakansudahbayar_id'=>$m->tindakansudahbayar_id));
        
        foreach ($modPembebasan_proto as $item) {
          $modPembebasan[$item->pembebasantarif_id] = $item;
        }
      }
      $modPendaftaran = BKPendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
      $modPasien = BKPasienM::model()->findByPk($modPembayaran->pasien_id);
      // var_dump($modPembebasan);die;

      $modRetur->tandabuktibayar_id = $modPembayaran->tandabuktibayar_id;
      $modRetur->totaloaretur = $modPembayaran->totalbiayaoa;
      $modRetur->totaltindakanretur = $modPembayaran->totalbiayatindakan;
      $modRetur->totalbiayaretur = $modPembayaran->totalbiayapelayanan;

      $modBuktiKeluar->namapenerima = $modPasien->no_rekam_medik . " - " . $modPasien->namadepan . $modPasien->nama_pasien;
      $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
      
      $modBebas1 = null;
      foreach($modPembebasan as $m){

        // var_dump($m->attributes);

        if (empty($modBebas1)) {
          $modBebas1 = $m;
        } else {
          $modBebas1->jmlpembebasan += $m->jmlpembebasan;
        }

      }

      // var_dump($modBebas1->attributes); die;

      if (isset($_GET['ajax_retur']) && !empty($modBebas1)) {
        $data = array(
          'pembayaran' => $modPembayaran->attributes,
          'pendaftaran' => $modPendaftaran->attributes,
          'pasien' => $modPasien->attributes,
          'retur' => $modRetur->attributes,
          'buktikeluar' => $modBuktiKeluar->attributes,
          'pembebasan' => $modBebas1->attributes,
        );
        echo CJSON::encode($data);
        Yii::app()->end();
      }

      $url_batal = Yii::app()->createAbsoluteUrl(
        Yii::app()->controller->module->id . '/' . Yii::app()->controller->id,
        array(
          'idPembayaran' => $_GET['idPembayaran'],
          'frame' => 1
        )
      );
    }
    $successSave = false;
    //                    echo nl2br(print_r($_POST,1));exit();
    if (isset($_POST['BKReturbayarpelayananT']) && !empty($_POST['BKPendaftaranT']['pendaftaran_id'])) {
      $modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['BKPendaftaranT']['pendaftaran_id']);
      $modPasien = BKPasienM::model()->findByPk($_POST['BKPendaftaranT']['pasien_id']);

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRetur = $this->saveReturBayarPelayanan($_POST['BKReturbayarpelayananT']);
        $modBuktiKeluar = $this->saveTandaBuktiKeluar($modRetur, $_POST['BKTandabuktikeluarT']);

        $successSave = $this->successSave;
        if ($successSave) {

          
          if (!empty($bebas)) {
            $bebas->returbayarpelayanan_id = $modRetur->returbayarpelayanan_id;
            $bebas->save(false);


            $modRetur->pembebasantarif_id = $bebas->pembebasantarif_id;
            $modRetur->save(false);

            $bebas = PembebasantarifT::model()->findByPk($bebas->pembebasantarif_id);

            // var_dump($modRetur->attributes, $bebas->attributes); die;
          }
          // die;
          

          Yii::app()->user->setFlash('success', "Data berhasil disimpan");

          // SMS GATEWAY
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modBuktiKeluar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRetur->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modRetur->tglreturpelayanan), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          $this->redirect(array('index', 'status' => 1, 'returbayarpelayanan_id' => $modRetur->returbayarpelayanan_id, 'pendaftaran_id' => $_POST['BKPendaftaranT']['pendaftaran_id'], 'smspasien' => $smspasien));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    //$modPendaftaran = new BKPendaftaranT;

    $this->render(
      'index',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modBuktiKeluar' => $modBuktiKeluar,
        'modRetur' => $modRetur,
        'successSave' => $successSave,
        'url_batal' => $url_batal
      )
    );
  }

  protected function saveReturBayarPelayanan($postRetur)
  {
    $modRetur = new BKReturbayarpelayananT;
    $modRetur->attributes = $postRetur;
    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if ($modRetur->validate()) {
      $modRetur->save();
      TandabuktibayarT::model()->updateByPk(
        $modRetur->tandabuktibayar_id,
        array(
          'returbayarpelayanan_id' => $modRetur->returbayarpelayanan_id
        )
      );
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modRetur;
  }

  protected function saveTandaBuktiKeluar($modRetur, $postBuktiKeluar)
  {
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturpelayanan;
    $modBuktiKeluar->jmlkaskeluar = $modRetur->totalbiayaretur;
    $modBuktiKeluar->biayaadministrasi = $modRetur->biayaadministrasi;
    $modBuktiKeluar->keterangan_pengeluaran = $modRetur->keteranganretur;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->returbayarpelayanan_id = $modRetur->returbayarpelayanan_id;
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');

    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->validate();

    //  var_dump($modBuktiKeluar->attributes, $modBuktiKeluar->validate(), $modBuktiKeluar->errors); die;

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
      $modRetur->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
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

  public function actionReturTagihan($tandabuktibayar_id, $frame = 0)
  {
    if (!empty($tandabuktibayar_id)) {
      $this->layout = '//layouts/printWindows';

      if ($frame == 1) {
        $this->layout = "//layouts/iframe";
      }

      $attributes = array(
        'returbayarpelayanan_id' => $tandabuktibayar_id
      );
      $judulLaporan = '';
      $return = ReturbayarpelayananT::model()->findByAttributes($attributes);
      $model_tandabuktibayar = TandabuktibayarT::model()->with('pembayaranpelayanan')->findByAttributes(array('tandabuktibayar_id' => $return->tandabuktibayar_id));
      $judulLaporan = 'Tanda Bukti Return Tagihan';
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


  function actionInformasi()
  {
    $model = new BKReturbayarpelayananT();
    //  $model->tgl_awal = date('Y-m-d H:i:s', time() - (7 * 24 * 3600));
    //$model->tgl_akhir = date('Y-m-d H:i:s');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');

    if (isset($_GET['BKReturbayarpelayananT'])) {
      $model->attributes = $_GET['BKReturbayarpelayananT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BKReturbayarpelayananT']['tgl_awal']) . ' 00:00:00';
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BKReturbayarpelayananT']['tgl_akhir']) . ' 23:59:59';
      $model->nobuktibayar = $_GET['BKReturbayarpelayananT']['nobuktibayar'];
      $model->no_pendaftaran = $_GET['BKReturbayarpelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKReturbayarpelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKReturbayarpelayananT']['nama_pasien'];
      $model->carabayar_id = $_GET['BKReturbayarpelayananT']['carabayar_id'];
      $model->penjamin_id = $_GET['BKReturbayarpelayananT']['penjamin_id'];
    }

    $this->render('informasi', array(
      'model' => $model,
    ));
  }
}
