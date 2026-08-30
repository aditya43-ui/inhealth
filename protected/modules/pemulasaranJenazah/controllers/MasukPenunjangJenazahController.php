<?php

class MasukPenunjangJenazahController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain;
  protected $successSave;

  public function actionIndex($pendaftaran_id = '', $instalasi_id = '')
  {
    $this->layout = '//layouts/iframe';
    $modelPulang = new PJPasienpulangT;
    $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
    $modelPulang->tgl_meninggal = date('Y-m-d H:i:s');
    $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
    $modelPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_MENINGGAL_1;
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modelPulang->satuanlamarawat = PARAMS::SATUAN_LAMARAWAT_RD;
    $modelPulang->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');

    if (!empty($pendaftaran_id)) { //RSSP-3074 handel agar tidak dapat diplangkan ketika sudah puang di ruangan terakhir.
      $modPulang = PJPasienpulangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (isset($modPulang->pasienpulang_id) && !empty($modPulang->pasienpulang_id)) {
        $modRuangan = RuanganM::model()->findByPk($modPulang->ruanganakhir_id);
        echo "<h3>Pasien Sudah Dipulangkan Sebelumnya Di Ruangan " . $modRuangan->ruangan_nama . "!</h3>";
        exit;
      }
    }

    if (!empty($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      if (!empty($modPendaftaran->pasienadmisi_id)) {
        $modelPulang->ruanganakhir_id = (isset($modPendaftaran->pasienadmisiTs->ruangan_id) ? $modPendaftaran->pasienadmisiTs->ruangan_id : null);
      }
      $modelPulang->ruanganakhir_id = $modPendaftaran->ruangan_id;
      $modMasukKamar = array();
    }
    if ($instalasi_id == Params::INSTALASI_ID_RI) {
      $modPasienRIV = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modMasukKamar = MasukkamarT::model()->findByPk($modPasienRIV->masukkamar_id);
      if (!empty($modMasukKamar)) {
        $modMasukKamar->tglkeluarkamar = (!empty($modMasukKamar->tglkeluarkamar)) ? $modMasukKamar->tglkeluarkamar : date('d M Y');
        $modMasukKamar->lamadirawat_kamar = $this->hitungLamaDirawat($modMasukKamar->tglmasukkamar, $modMasukKamar->tglkeluarkamar);
      }
      $modelPulang->satuanlamarawat = PARAMS::SATUAN_LAMARAWAT_RI;
    }

    $format = new MyFormatter();
    $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
    $date2 = date('Y-m-d H:i:s');
    $diff = abs(strtotime($date2) - strtotime($date1));
    $hours   = floor(($diff) / 3600);

    $modelPulang->lamarawat = $hours;
    $tersimpan = 'Tidak';
    if (isset($_POST['PJPasienpulangT'])) {
      $modelPulang->attributes = $_POST['PJPasienpulangT'];
      $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modelPulang->pasien_id = $modPendaftaran->pasien_id;
      if ($modelPulang->validate()) {
        $modelPulang->save();
        PasienM::model()->updateByPk($modPasien->pasien_id, array('tgl_meninggal' => $modelPulang->tgl_meninggal));
        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('pasienpulang_id' => $modelPulang->pasienpulang_id));
        if (!empty($modPendaftaran->pasienadmisi_id)) {
          PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array('pasienpulang_id' => $modelPulang->pasienpulang_id));
        }

        $this->savePasienPenunjang($modPendaftaran, $modPasien);
        if ($this->successSave) {
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal disimpan");
        }
      }
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modelPulang' => $modelPulang,
      'instalasi_id' => $instalasi_id,
      'modMasukKamar' => $modMasukKamar,
      'tersimpan' => $tersimpan,
    ));
  }

  public function savePasienPenunjang($attrPendaftaran, $attrPasien)
  {
    $format = new MyFormatter;
    $modPasienPenunjang = new PJPasienMasukPenunjangT;
    $modPasienPenunjang->pasien_id = $attrPasien->pasien_id;
    $modPasienPenunjang->jeniskasuspenyakit_id = $attrPendaftaran->jeniskasuspenyakit_id;
    $modPasienPenunjang->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
    $modPasienPenunjang->pegawai_id = $attrPendaftaran->pegawai_id;
    $modPasienPenunjang->kelaspelayanan_id = $attrPendaftaran->kelaspelayanan_id;
    $modPasienPenunjang->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang(Yii::app()->user->getState('nopendaftaran_jenazah'));
    $modPasienPenunjang->tglmasukpenunjang = $format->formatDateTimeForDb($attrPendaftaran->tgl_pendaftaran);
    $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
    $modPasienPenunjang->kunjungan = $attrPendaftaran->kunjungan;
    $modPasienPenunjang->statusperiksa = $attrPendaftaran->statusperiksa;
    $modPasienPenunjang->ruanganasal_id = $attrPendaftaran->ruangan_id;


    if ($modPasienPenunjang->validate()) {
      $modPasienPenunjang->Save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $modPasienPenunjang->tglmasukpenunjang = Yii::app()->dateFormatter->formatDateTime(
        CDateTimeParser::parse($modPasienPenunjang->tglmasukpenunjang, 'yyyy-MM-dd'),
        'medium',
        null
      );
    }

    return $modPasienPenunjang;
  }

  protected function hitungLamaDirawat($dateMasuk = '', $dateKeluar = '')
  {
    $dateMasuk = (!empty($dateMasuk)) ? date('Y-m-d', strtotime($dateMasuk)) : date('Y-m-d');
    $dateKeluar = (!empty($dateKeluar)) ? date('Y-m-d', strtotime($dateKeluar)) : date('Y-m-d');
    $tgl1 = $dateMasuk;
    $tgl2 = $dateKeluar;

    $pecah1 = explode("-", $tgl1);
    $date1 = $pecah1[2];
    $month1 = $pecah1[1];
    $year1 = $pecah1[0];

    $pecah2 = explode("-", $tgl2);
    $date2 = $pecah2[2];
    $month2 = $pecah2[1];
    $year2 =  $pecah2[0];

    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);

    // hitung selisih hari kedua tanggal
    $selisihHari = ($jd2 - $jd1);

    return $selisihHari;
  }
}
