<?php
class VerifikasiTindakanController extends MyAuthController
{
  public $succesSave = false;
  protected $successSaveVerifikasiTindakan = true;
  protected $path_view = 'rawatInap.views.verifikasitindakan.';

  public function actionIndex($pendaftaran_id = null)
  {
    $sukses = false;
    $format = new MyFormatter();
    $modInfoPasien = new RIInfopasienmasukkamarV;
    $modPendaftaran = new RIPendaftaranT;
    $modPasien = new RIPasienM;
    $modRencanaTindakan = new RIRencanatindakanT;
    $modVerifikasiTindakan = new RIVerifrenctindakanT;
    $modTindakans = array();
    $modTindakan = new RITindakanPelayananT;
    $modRiwayatTindakans = array();
    $modAdmisi = new RIPasienAdmisiT;
    $modJenisTarif = new JenistarifpenjaminM;

    $modRencanaTindakan->tglperencanaan = date('Y-m-d H:i:s');
    $modVerifikasiTindakan->noverifikasi_renc = '-- Otomatis --';

    if (!empty($_GET['verifrenctindakan_id'])) {
      $modVerifikasiTindakan = RIVerifrenctindakanT::model()->findByPk($_GET['verifrenctindakan_id']);
      $modVerifikasiTindakan->mengetahui_nama = $modVerifikasiTindakan->mengetahui->NamaLengkap;
      $modVerifikasiTindakan->nama_pegawai = $modVerifikasiTindakan->petugas->NamaLengkap;
      //				$modRiwayatTindakans = RIRencanatindakanT::model()->findByAttributes(array('verifrenctindakan_id'=>$_GET['verifrenctindakan_id']));
      $modInfoPasien = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }
    if (!empty($pendaftaran_id)) {
      // simpan url sebelumnya jika menu itu baru ditampilkan
      if (!isset($_GET['verifrenctindakan_id']) && !Yii::app()->request->isPostRequest) {
        $this->setReferrer();
      }

      $modInfoPasien = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modInfoPasien->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modInfoPasien->tgl_pendaftaran);
      //			$modRiwayatTindakans = RIRencanatindakanT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'tglperencanaan DESC'));
      $criteria = new CDbCriteria;
      $criteria->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('tindakanpelayanan_t.rencanatindakan_id is NULL');
      $criteria->order = 't.tglperencanaan DESC';
      $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.rencanatindakan_id = t.rencanatindakan_id';
      $modRiwayatTindakans = RIRencanatindakanT::model()->findAll($criteria);

      $criteria2 = new CDbCriteria();
      $criteria2->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria2->addCondition('tindakansudahbayar_id is NULL');
      $criteria2->order = 'tgl_tindakan DESC';
      $modTindakans = RITindakanPelayananT::model()->findAll($criteria2);
    } else {
      $this->cleanReferrer();
    }

    if (isset($_POST['RITindakanPelayananT']) || isset($_POST['RIRencanatindakanT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $valid = true;

      try {

        $modVerifikasiTindakan->attributes = $_POST['RIVerifrenctindakanT'];
        $modVerifikasiTindakan->tglverifikasirenc = $format->formatDateTimeForDb($_POST['RIVerifrenctindakanT']['tglverifikasirenc']);
        $modVerifikasiTindakan->noverifikasi_renc = MyGenerator::noVerifikasiTindakan();
        $modVerifikasiTindakan->create_time = date('Y-m-d H:i:s');
        $modVerifikasiTindakan->create_loginpemakai_id = Yii::app()->user->id;
        $modVerifikasiTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modVerifikasiTindakan->validate()) {
          $valid = $valid && $modVerifikasiTindakan->save();
          $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran, $_POST['RIInfopasienmasukkamarV'], $modAdmisi, $valid);

          if ($modTindakans > 0) {
            foreach ($modTindakans as $i => $tindakan) {
              $modRencanaTindakan = RIRencanatindakanT::model()->findByPk($tindakan->rencanatindakan_id);
              if (!empty($modRencanaTindakan)) {
                $modRencanaTindakan->verifrenctindakan_id = $modVerifikasiTindakan->verifrenctindakan_id;
                $valid = $valid && $modRencanaTindakan->save();
              }
            }
          }
        } else $valid = false;

        // var_dump($valid, $modVerifikasiTindakan->attributes); die;

        if ($valid) {


          $judul = 'Verifikasi Tagihan Pasien';

          $isi = $modInfoPasien->no_pendaftaran . ' ' . $modInfoPasien->nama_pasien . ' tindakan pasien sudah di verifikasi';

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
          ));

          $transaction->commit();
          $this->setIsSubmit();
          $this->succesSave = true;
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $_GET['pasienadmisi_id'], 'verifrenctindakan_id' => $modVerifikasiTindakan->verifrenctindakan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();

          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modInfoPasien' => $modInfoPasien,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modVerifikasiTindakan' => $modVerifikasiTindakan,
      'modRencanaTindakan' => $modRencanaTindakan,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'modRiwayatTindakans' => $modRiwayatTindakans,
      'modAdmisi' => $modAdmisi,
      'modJenisTarif' => $modJenisTarif,
      'format' => $format,
      'sukses' => $sukses
    ));
  }
  /**
   * Mengurai data pasien berdasarkan:
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $model = RIInfopasienmasukkamarV::model()->find($criteria);
      $modJenisTarif = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $model->penjamin_id));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["jenistarif_id"] = $modJenisTarif->jenistarif_id;
      $returnVal["jenistarif_nama"] = $model->penjamin_nama;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAjaxLoadTindakan()
  {
  }

  /**
   * action ajax select tindakan ke form
   */
  public function actionDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
      $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
      $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null);

      $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id);
      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
          $criteria->addCondition('tipepaket_id = ' . Params::TIPEPAKET_ID_LUARPAKET);
        }
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        if (!empty($penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $penjamin_id);
        }
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        } else {
          $models = TariftindakanperdaV::model()->findAll($criteria);
        }
        $returnVal = array();
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

        if (!empty($tipepaket_id)) {
          $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->find($criteria);
        if (isset($models)) {
          foreach ($models as $i => $model) {
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
              $returnVal[$i]["$attribute"] = $model->$attribute;
            }
            $returnVal[$i]['label'] = $model->daftartindakan_nama;
            $returnVal[$i]['value'] = $model->daftartindakan_id;
          }
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  /**
   * action ajax select dokter ke form
   */
  public function actionDaftarDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();

      $pegawai_id = (isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null);

      $criteria = new CDbCriteria();
      if (isset($pegawai_id)) {
        if (!empty($pegawai_id)) {
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
        }
      }
      $models = PegawaiM::model()->find($criteria);
      if (isset($models)) {
        $attributes = $models->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal["$attribute"] = $models->$attribute;
        }
        $returnVal['label'] = $models->nama_pegawai;
        $returnVal['value'] = $models->pegawai_id;
        $returnVal['nama_pegawai'] = $models->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan tindakan
   * @return row table 
   */
  public function actionSetFormTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rencanatindakan_id = $_POST['rencanatindakan_id'];
      $daftartindakan_id = $_POST['daftartindakan_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pasien_id = $_POST['pasien_id'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modTindakan = new RITindakanPelayananT;
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('pasien_id = ' . $pasien_id);
      $criteria->addCondition('daftartindakan_id = ' . $daftartindakan_id);
      $criteria->addCondition('rencanatindakan_id = ' . $rencanatindakan_id);
      $modTindakans = RIRencanatindakanT::model()->findAll($criteria);
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $tindakan) {
          $modTindakan->rencanatindakan_id = $rencanatindakan_id;
          $modTindakan->daftartindakanNama = $tindakan->daftartindakan->daftartindakan_nama;
          $modTindakan->kategoriTindakanNama = $tindakan->daftartindakan->kategoritindakan->kategoritindakan_nama;
          $modTindakan->tgl_tindakan = $format->formatDateTimeForUser($tindakan->tglrencanatindakan);
          $modTindakan->tarif_satuan = $tindakan->tarifsatuan;
          $modTindakan->qty_tindakan = $tindakan->qty_rentindakan;
          $modTindakan->jumlahTarif = ($tindakan->qty_rentindakan * $tindakan->tarifsatuan);
          $modTindakan->satuantindakan = $tindakan->satuanrenctinda;
          $modTindakan->cyto_tindakan = $tindakan->iscyto;
          $modTindakan->nama_pegawai = isset($tindakan->pegawai->NamaLengkap) ? $tindakan->pegawai->NamaLengkap : "";
          $modTindakan->pegawai_id = $tindakan->pegawai_id;
          $modTindakan->daftartindakan_id = $tindakan->daftartindakan_id;
          $modTindakan->keterangantindakan = $tindakan->keteranganrentinda;
          $modTindakan->subsidiasuransi_tindakan = 0;
          $modTindakan->subsidipemerintah_tindakan = 0;
          $modTindakan->subsisidirumahsakit_tindakan = 0;
          $modTindakan->iurbiaya_tindakan = $modTindakan->jumlahTarif;

          $form .= $this->renderPartial('_rowTindakan', array('modTindakan' => $modTindakan), true);
        }
      } else {
        $pesan = "tindakan tidak ditemukan!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function saveTindakan($modPasien, $modPendaftaran, $modInfoPasien, $modAdmisi, &$valid)
  {
    $post = isset($_POST['TindakanpelayananT']) ? $_POST['TindakanpelayananT'] : $_POST['RITindakanPelayananT'];
    $valid = true;
    $modTindakans = null;
    foreach ($post as $i => $item) {
      if (!empty($item) && (!empty($item['daftartindakan_id']))) {
        if ($item['status'] != 'Pelayanan') {
          $modTindakans[$i] = new RITindakanPelayananT;
          $modTindakans[$i]->attributes = $item;
          $modTindakans[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
          $modTindakans[$i]->pasien_id = $modInfoPasien['pasien_id'];
          $modTindakans[$i]->pasienadmisi_id = $modInfoPasien['pasienadmisi_id'];
          $modTindakans[$i]->kelaspelayanan_id = $modInfoPasien['kelaspelayanan_id'];
          $modTindakans[$i]->carabayar_id = $modInfoPasien['carabayar_id'];
          $modTindakans[$i]->penjamin_id = $modInfoPasien['penjamin_id'];
          $modTindakans[$i]->jeniskasuspenyakit_id = $modInfoPasien['jeniskasuspenyakit_id'];
          $modTindakans[$i]->pendaftaran_id = $modInfoPasien['pendaftaran_id'];
          $modTindakans[$i]->keterangantindakan = $item['keterangantindakan'];
          $modTindakans[$i]->tgl_tindakan = $modTindakans[$i]->tgl_tindakan;
          $modTindakans[$i]->dokterpemeriksa1_id = $item['pegawai_id'];
          $modTindakans[$i]->rencanatindakan_id = $modTindakans[$i]->rencanatindakan_id;
          $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
          $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
          $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;

          if ($item['cyto_tindakan'])
            $modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
          else
            $modTindakans[$i]->tarifcyto_tindakan = 0;

          $modTindakans[$i]->discount_tindakan = 0;
          $modTindakans[$i]->subsidiasuransi_tindakan = 0;
          $modTindakans[$i]->subsidipemerintah_tindakan = 0;
          $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
          $modTindakans[$i]->iurbiaya_tindakan = 0;
          $modTindakans[$i]->instalasi_id = Yii::app()->user->getState('instalasi_id');
          $modTindakans[$i]->ruangan_id =  Yii::app()->user->getState('ruangan_id');


          if ($modTindakans[$i]->validate()) {
            $valid = $valid && $modTindakans[$i]->save();
            $valid = $valid && $modTindakans[$i]->saveTindakanKomponen();
          } else $valid = false;
        }
      }
    }

    return $modTindakans;
  }

  /**
   * untuk menampilkan data pegawai verifikasi
   * - nama_pegawai
   */
  public function actionAutocompletePegawaiVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;

      $models = RIPegawaiM::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data pegawai mengetahui
   * - nama_pegawai
   */
  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $mengetahui_nama = isset($_GET['mengetahui_nama']) ? $_GET['mengetahui_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($mengetahui_nama), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;

      $models = RIPegawaiM::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /*
	 * fungsi untuk delete tindakan
	 */
  public function actionAjaxDeleteTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idTindakanpelayanan = (isset($_POST['idTindakanpelayanan']) ? $_POST['idTindakanpelayanan'] : null);
      $transaction = Yii::app()->db->beginTransaction();

      try {

        $data['success'] = true;
        $data['pesan'] = "berhasil";
        $modTindakanPelayanan = RITindakanPelayananT::model()->findByPk($idTindakanpelayanan);
        $obatAlkesT = RIObatalkespasienT::model()->findAllByAttributes(
          array('tindakanpelayanan_id' => $idTindakanpelayanan)
        );
        if (count((array)$obatAlkesT) > 0) {
          $this->kembalikanStok($obatAlkesT);
          $deleteObatPasien = RIObatalkespasienT::model()->deleteAllByAttributes(
            array('tindakanpelayanan_id' => $idTindakanpelayanan)
          );
          $deleteKomponen = RITindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = RITindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
          if (!$deleteObatPasien) {
            $data['success'] = false;
          }
        } else {
          $deleteKomponen = RITindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = RITindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
        }

        if (!empty($modTindakanPelayanan->tindakansudahbayar_id) && !empty($obatAlkesT->oasudahbayar_id)) {
          $data['success'] = false;
          $data['pesan'] = "gagal";
        } else {
          if ($deleteKomponen && $deleteTindakan && $data['success']) {
            $data['success'] = true;
            $transaction->commit();
          } else {
            $data['success'] = false;
            $transaction->rollback();
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        print_r(MyExceptionMessage::getMessage($exc, true));
        $data['success'] = false;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data rencana tindakan
   */
  public function actionPrint($pendaftaran_id = null, $pasienadmisi_id = null, $caraPrint = null)
  {
    $format = new MyFormatter;
    $criteria = new CDbCriteria;
    $criteria->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
    $criteria->addCondition('t.pasienadmisi_id = ' . $pasienadmisi_id);
    $criteria->order = 't.tgl_tindakan DESC';

    $modTindakans = RITindakanPelayananT::model()->findAll($criteria);
    $modInfoPasien = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $judul_print = 'Verifikasi Tindakan Pasien';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modTindakans' => $modTindakans,
      'modInfoPasien' => $modInfoPasien,
      'caraPrint' => $caraPrint
    ));
  }
}
