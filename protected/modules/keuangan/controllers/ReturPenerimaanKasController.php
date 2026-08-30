<?php

class ReturPenerimaanKasController extends MyAuthController
{
  protected $successSave = true;

  public function actionIndex()
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if (isset($_GET['idPenerimaan'])) {
      $idPenerimaan = $_GET['idPenerimaan'];
      $modPenerimaan = KUPenerimaanUmumT::model()->findByPk($idPenerimaan);
      $modBuktiBayar = KUTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);

      $modBuktiKeluar = new KUTandabuktikeluarT;
      $modBuktiKeluar->tahun = date('Y');
      $modBuktiKeluar->namapenerima = isset($modBuktiBayar->darinama_bkm) ? $modBuktiBayar->darinama_bkm : "";
      $modBuktiKeluar->alamatpenerima = isset($modBuktiBayar->alamat_bkm) ? $modBuktiBayar->alamat_bkm : "";
      $modBuktiKeluar->untukpembayaran = 'Retur Tagihan Pasien';
      $modBuktiKeluar->nokaskeluar = '-- Otomatis --'; // MyGenerator::noKasKeluar();
      $modBuktiKeluar->jmlkaskeluar = $modPenerimaan->totalharga;
      $modRetur = new KUReturPenerimaanUmumT;
      $modRetur->penerimaanumum_id = $modPenerimaan->penerimaanumum_id;
      $modRetur->tandabuktibayar_id = $modPenerimaan->tandabuktibayar_id;
      $modPengUmum = new KUPengeluaranumumT;
      $modPengUmum->volume = 1;
      $modPengUmum->satuanvol = "KALI";
    } else if (isset($_GET['id'])) {
      $modRetur = KUReturPenerimaanUmumT::model()->findByPk($_GET['id']);
      // $modRetur->penerimaanumum_id = $modPenerimaan->penerimaanumum_id;
      // $modRetur->tandabuktibayar_id = $modPenerimaan->tandabuktibayar_id;
      $modPenerimaan = KUPenerimaanUmumT::model()->findByPk($modRetur->penerimaanumum_id);
      $modBuktiBayar = KUTandabuktibayarT::model()->findByPk($modRetur->tandabuktibayar_id);
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array(
        'returpenerimaanumum_id' => $modRetur->returpenerimaanumum_id,
      ));
      $modPengUmum = PengeluaranumumT::model()->findByPk($modBuktiKeluar->pengeluaranumum_id);

      $jeniskode = JenispengeluaranM::model()->findByPk($modPengUmum->jenispengeluaran_id);
    } else {
      $modPenerimaan = new KUPenerimaanUmumT;
      $modBuktiBayar = new KUTandabuktibayarT;
      $modPengUmum = new KUPengeluaranumumT;
      $modPengUmum->volume = 1;
      $modPengUmum->satuanvol = "KALI";
    }

    if (isset($_POST['KUReturPenerimaanUmumT'])) {


      $idPenerimaan = $_POST['KUReturPenerimaanUmumT']['penerimaanumum_id'];
      $modPenerimaan = KUPenerimaanUmumT::model()->findByPk($idPenerimaan);
      $modBuktiBayar = KUTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRetur = $this->saveReturPenerimaan($_POST['KUReturPenerimaanUmumT']);
        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $modRetur);
        $this->updateTandaBuktiBayar($modPenerimaan->tandabuktibayar_id, $modRetur);


        $modPengUmum->attributes = $_POST['KUPengeluaranumumT'];
        $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
        $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
        $modPengUmum->tglpengeluaran = $modBuktiKeluar->tglkaskeluar;
        $modPengUmum->hargasatuan = $modPengUmum->totalharga = $modBuktiKeluar->jmlkaskeluar;
        $modPengUmum->keterangankeluar = $modBuktiKeluar->keterangan_pengeluaran;
        $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
        $modPengUmum->satuanvol = 'KALI';

        if ($modPengUmum->validate()) {
          $this->successSave = $this->successSave && $modPengUmum->save();
          $modBuktiKeluar->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
          $this->successSave = $this->successSave && $modBuktiKeluar->save();
        } else $this->successSave = false;

        $modJurnalRekening = new JurnalrekeningT;
        if (isset($_POST['RekeningakuntansiV'])) {
          // var_dump("Insert Jurnal...");
          $modJurnalRekening = $this->saveJurnalRekening($modPenerimaan, $modBuktiKeluar);
          $this->successSave = $this->successSave && $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
        } else {
          if (!empty($modRetur->returpenerimaanumum_id)) {
            $res = Yii::app()->db
              ->createCommand("select set_afterreturpenerimaanumum_fix(" . $modRetur->returpenerimaanumum_id . ") as simpan")
              ->queryRow();

            if (!empty($res)) {
              $this->successSave = $this->successSave && $res['simpan'];
            }

            // var_dump($res);
          }
        }

        // var_dump($modJurnalRekening->attributes);
        // var_dump($modPengUmum->attributes);
        // var_dump($modBuktiKeluar->attributes);

        // var_dump($_POST);
        // var_dump($this->successSave); die;



        $successSave = $this->successSave;
        if ($successSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");

          $param = array(
            'index',
            'id' => $modRetur->returpenerimaanumum_id,
          );

          if (isset($_GET['frame'])) {
            $param['frame'] = $_GET['frame'];
          }

          $this->redirect($param);
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
      'modPenerimaan' => $modPenerimaan,
      'modBuktiBayar' => $modBuktiBayar,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modPengUmum' => $modPengUmum,
      'modRetur' => $modRetur
    ));
  }


  protected function saveJurnalRekening($modPenerimaan, $modBukti)
  {



    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modBukti->tglkaskeluar;
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modBukti->tglkaskeluar, 'JKK');
    $modJurnalRekening->noreferensi = $modBukti->nokaskeluar;
    $modJurnalRekening->tglreferensi = $modBukti->tglkaskeluar;
    $modJurnalRekening->urianjurnal = "Batal Penerimaan Umum - " . $modPenerimaan->nopenerimaan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->tandabuktikeluar_id = $modBukti->tandabuktikeluar_id;


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
    $modJurnalRekening->create_time = $modBukti->tglkaskeluar;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      // $this->succesSave = true;
    } else {
      // $this->succesSave = false;

      if (empty($modJurnalRekening->rekperiod_id)) {
        throw new CDbException("Periode Akuntansi Belum di-set");
      } else {
        throw new CDbException($modJurnalRekening->getErrors());
      }
    }
    // var_dump($modJurnalRekening->attributes, $modBukti->attributes, $modPetty->attributes); die;
    return $modJurnalRekening;
  }


  protected function saveJurnalDetail($modJurnalRekening, $rekeningakuntansi)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new KUJurnaldetailT();
      // $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";




      if ($model->validate()) {
        $model->save();

        // var_dump($model->attributes);
      } else {
        throw new CDbException($model->getErrors());
        $valid = false;
        break;
      }
    }

    return $valid;

    // $this->succesSave = $valid;
  }


  protected function saveReturPenerimaan($postRetur)
  {
    $format = new MyFormatter();
    $modRetur = new KUReturPenerimaanUmumT;
    $modRetur->attributes = $postRetur;


    $modRetur->tglreturumum = $format->formatDateTimeForDb($postRetur['tglreturumum']);

    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if ($modRetur->validate()) {
      $modRetur->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modRetur;
  }

  protected function saveBuktiKeluar($postBuktiKeluar, $modRetur)
  {
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->returpenerimaanumum_id = $modRetur->returpenerimaanumum_id;
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturumum;
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->biayaadministrasi = 0;

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function updateTandaBuktiBayar($idBuktiBayar, $modRetur)
  {
    KUTandabuktibayarT::model()->updateByPk($idBuktiBayar, array('returpenerimaanumum_id' => $modRetur->returpenerimaanumum_id));
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
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari myAuthController
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
