<?php

Yii::import("billingKasir.controllers.PemeriksaanLaboratoriumController");

class PemeriksaanRadiologiController extends PemeriksaanLaboratoriumController
{
  public $layout = "//layouts/iframe";
  public $path_view = "billingKasir.views.pemeriksaanRadiologi.";

  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping

  /*
     * di copy dari radiologi/pendaftaranRadiologiRujukanRS
     */
  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new BKPasienadmisiT;
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    if (!empty($pasienadmisi_id)) {
      $modPasienAdmisi = BKPasienadmisiT::model()->findByPk($pasienadmisi_id);
    }

    $modKunjungan = new BKPasienkirimkeunitlainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanRad = new BKTarifpemeriksaanradruanganV;
    $modPasienMasukPenunjang = new BKPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
    $modTindakan = new BKTindakanPelayananT;
    $modObatAlkesPasien = new BKObatalkesPasienT;
    $dataTindakans = array();
    $modRiwayatTindakans = new BKTindakanPelayananT;

    if (!empty($pasienmasukpenunjang_id)) {
      $modPasienMasukPenunjang = BKPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $loadModKunjungan = BKPasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
      }
    }

    if (isset($_POST['BKPasienmasukpenunjangT'])) {
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['BKPasienmasukpenunjangT']);

        if (isset($_POST['BKTindakanPelayananT'])) {
          if (count((array)$_POST['BKTindakanPelayananT']) > 0) {
            foreach ($_POST['BKTindakanPelayananT'] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                $dataTindakans[$ii] = BKTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              }
              $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }

        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan radiologi Pasein " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan !");
          $modPasienMasukPenunjang->isNewRecord = FALSE;
          $this->redirect($this->createUrl('index', array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1)));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataTindakans' => $dataTindakans,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPendaftaran' => $modPendaftaran,
      'modRiwayatTindakans' => $modRiwayatTindakans
    ));
  }

  /**
   * Fungsi untuk menyimpan data ke model BKPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return BKPasienmasukpenunjangT 
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $format = new MyFormatter;
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = (isset($post['tglmasukpenunjang']) ? $format->formatDateTimeForDb($post['tglmasukpenunjang']) : date("Y-m-d H:i:s"));
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }

  /**
   * proses simpan BKTindakanpelayananT dan BKTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  {
    $modTindakan = new BKTindakanPelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * simpan BKHasilpemeriksaanradT
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaan = new BKHasilpemeriksaanradT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
    $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
      //RND-8272
      $dataBroker = $modHasilPemeriksaan->getDataBroker();
      if (!empty($dataBroker)) {
        CustomFunction::postHL7Broker("ADD", $dataBroker);
      }

      $modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
      $modTindakan->update();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }
  }

  /**
   * set checklist pemeriksaan rad
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetChecklistPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['BKTarifpemeriksaanradruanganV'];
      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(jenispemeriksaanrad_nama)', strtolower($postPemeriksaan['jenispemeriksaanrad_nama']), true);
        $criteria->compare('LOWER(pemeriksaanrad_nama)', strtolower($postPemeriksaan['pemeriksaanrad_nama']), true);
        $criteria->order = "jenispemeriksaanrad_urutan, pemeriksaanrad_urutan";
        $modPemeriksaanRads = BKTarifpemeriksaanradruanganV::model()->findAll($criteria);
        $content = $this->renderPartial('_checklistPemeriksaanRad', array('modPemeriksaanRads' => $modPemeriksaanRads), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  /**
   * set dropdown dokter
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BKPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BKPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
}
