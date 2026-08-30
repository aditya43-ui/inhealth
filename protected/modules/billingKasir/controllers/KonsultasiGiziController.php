<?php

Yii::import("billingKasir.controllers.PemeriksaanRadiologiController");

class KonsultasiGiziController extends PemeriksaanRadiologiController
{
  public $layout = "//layouts/iframe";
  public $path_view = "billingKasir.views.konsultasiGizi.";

  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $pasienpenunjangtersimpan = true; //dilooping

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
    $modPemeriksaanKonsultasiGizi = new BKTariftindakanperdaruanganV();
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
              }
              $dataTindakans[$ii]->daftartindakan_id = $tindakan['daftartindakan_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }

        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan konsultasi gizi Pasien " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan !");
          $modPasienMasukPenunjang->isNewRecord = FALSE;
          $this->redirect($this->createUrl('index', array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1)));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan konsultasi gizi gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan konsultasi gizi gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanKonsultasiGizi' => $modPemeriksaanKonsultasiGizi,
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
   * set checklist pemeriksaan rad
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetChecklistPemeriksaanKonsultasiGizi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['BKTariftindakanperdaruanganV'];
      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($postPemeriksaan['kategoritindakan_nama']), true);
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['daftartindakan_nama']), true);
        $criteria->order = "kategoritindakan_nama, daftartindakan_nama";
        $modPemeriksaanKonsultasiGizis = BKTariftindakanperdaruanganV::model()->findAll($criteria);
        $content = $this->renderPartial('_checklistPemeriksaanKonsultasiGizi', array('modPemeriksaanKonsultasiGizis' => $modPemeriksaanKonsultasiGizis), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }
}
