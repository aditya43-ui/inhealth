<?php

class TransaksiController extends MyAuthController
{
  protected $successSavePemakaianBahan = true;
  protected $successSaveTindakanPelayanan = true;
  public $path_view = 'ambulans.views.transaksi.';

  public function actionIndex()
  {
    $this->render('index');
  }

  protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
  {
    $format = new MyFormatter();
    $modPemakaian = new AMPemakaianambulansT;
    $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
    $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);
    $modPemakaian->pasien_id = $modPendaftaran->pasien_id;
    $modPemakaian->namapasien = $modPendaftaran->pasien->nama_pasien;
    $modPemakaian->nomobile = $modPendaftaran->pasien->no_mobile_pasien;
    $modPemakaian->notelepon = $modPendaftaran->pasien->no_telepon_pasien;
    $modPemakaian->norekammedis = $modPendaftaran->pasien->no_rekam_medik;
    $modPemakaian->noidentitas = $modPendaftaran->pasien->no_identitas_pasien;
    $modPemakaian->tempattujuan = '';
    $modPemakaian->alamattujuan = $modPendaftaran->pasien->alamat_pasien;
    $modPemakaian->kelurahan_nama = (isset($modPendaftaran->pasien->kelurahan->kelurahan_nama) ? $modPendaftaran->pasien->kelurahan->kelurahan_nama : "");
    $modPemakaian->rt_rw = $modPendaftaran->pasien->rt . '/' . $modPendaftaran->pasien->rw;
    $modPemakaian->rt = $modPendaftaran->pasien->rt;
    $modPemakaian->rw = $modPendaftaran->pasien->rw;
    $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($modPemakaian->tglpemakaianambulans);
    $modPemakaian->pesanambulans_t = null;
    $modPemakaian->pendaftaran_id = $pendaftaran_id;
    $modPemakaian->ruangan_id = $modPendaftaran->ruangan_id;

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemesanan($idPemesanan)
  {
    $format = new MyFormatter();
    $modPemakaian = new AMPemakaianambulansT;
    $modPemesanan = AMPesanambulansT::model()->findByPk($idPemesanan);
    $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
    $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
    if (isset($modPasien)) {
      $noidentitas = $modPasien->no_identitas_pasien;
    } else {
      $noidentitas = null;
    }
    $modPemakaian->pasien_id = $modPemesanan->pasien_id;
    $modPemakaian->namapasien = $modPemesanan->namapasien;
    $modPemakaian->nomobile = $modPemesanan->nomobile;
    $modPemakaian->notelepon = $modPemesanan->notelepon;
    $modPemakaian->norekammedis = $modPemesanan->norekammedis;
    $modPemakaian->noidentitas = $noidentitas;
    $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
    $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemesanan->rt_rw;
    $modPemakaian->rt = substr($modPemesanan->rt_rw, 0, 2);
    $modPemakaian->rw = substr($modPemesanan->rt_rw, 2, 2);
    $modPemakaian->tglpemakaianambulans = (isset($modPemesanan->tglpemakaianambulans) ? $modPemesanan->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
    $modPemakaian->pesanambulans_t = $idPemesanan;
    $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;

    return $modPemakaian;
  }

  public function actionPemesanan($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Ambulans Pasien Luar";
    $modPemesanan = new AMPesanambulansT;
    $modPemesanan->tglpemesananambulans = date('Y-m-d H:i:s');
    $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $instalasiTujuans = CHtml::listData(AMInstalasiM::getInstalasi(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(AMRuanganM::getRuangan(Params::INSTALASI_ID_UMUM_PENUNJANG), 'ruangan_id', 'ruangan_nama');
    $modPasien = new AMPasienM;
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    $modPemesanan->create_loginpemakai_id = Yii::app()->session['loginpemakai_id'];
    $sukses = 1;

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
    $smspasien = 1;

    if (!empty($id)) {
      $modPemesanan = AMPesanambulansT::model()->findByPk($id);
      $rt_rw = explode("/", $modPemesanan->rt_rw);

      $modPemesanan->rt = empty($rt_rw[0]) ? null : $rt_rw[0];
      $modPemesanan->rw = empty($rt_rw[1]) ? null : $rt_rw[1];
    }
    if (isset($_POST['AMPesanambulansT'])) {


      $modPemesanan->attributes = $_POST['AMPesanambulansT'];
      $format = new MyFormatter();
      $modPemesanan->tglpemesananambulans = $format->formatDateTimeForDb($_POST['AMPesanambulansT']['tglpemesananambulans']);
      if ($_POST['AMPesanambulansT']['tglpemakaianambulans'] < 1) {
        $modPemesanan->tglpemakaianambulans = null;
      } else {
        $modPemesanan->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPesanambulansT']['tglpemakaianambulans']);
      }
      $modPemesanan->create_time = date('Ymd H:i:s');
      $modPemesanan->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPemesanan->create_loginpemakai_id = 8;
      $modPemesanan->pesanambulans_no = MyGenerator::noPesanAmbulans(PARAMS::INSTALASI_ID_AMBULAN);

      $modPemesanan->rt_rw = $_POST['AMPesanambulansT']['rt'] . "/" . $_POST["AMPesanambulansT"]["rw"];


      if ($modPemesanan->validate()) {
        if ($modPemesanan->save()) {
          // SMS GATEWAY
          $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            if (isset($modPasien)) {
              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
            }
            $attributes = $modPemesanan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPemesanan->tglpemesananambulans), $isiPesan);
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY
          $sukses = 1;
          $modPemesanan->isNewRecord = FALSE;

          Yii::app()->user->setFlash('success', "Transaksi Pesan Ambulans nomor " . $modPemesanan->pesanambulans_no . " Berhasil disimpan");
          $this->redirect(array('pemesanan', 'id' => $modPemesanan->pesanambulans_t, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal disimpan");
        }
      }
    }

    $this->render($this->path_view . 'pemesanan', array(
      'modPemesanan' => $modPemesanan,
      'modPasien' => $modPasien,
      'modInstalasi' => $modInstalasi,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
      'smspasien' => $smspasien
    ));
  }

  protected function savePemakaianBahan($modPendaftaran, $pemakaianBahan)
  {
    $valid = true;
    foreach ($pemakaianBahan as $i => $bmhp) {
      $modPakaiBahan[$i] = new AMObatalkesPasienT;
      $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
      $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
      $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
      $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
      $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
      $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
      $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPakaiBahan[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
      $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
      $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
      $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
      $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
      $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
      $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
      $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
      $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
      $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
      $modPakaiBahan[$i]->oa = Params::OBATALKESPASIEN_BMHP;

      $valid = $modPakaiBahan[$i]->validate() && $valid;
      if ($valid) {
        $modPakaiBahan[$i]->save();
        $this->kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
        $this->successSavePemakaianBahan = true;
      } else {
        $this->successSavePemakaianBahan = false;
      }
    }

    return $modPakaiBahan;
  }

  protected function kurangiStok($qty, $idobatAlkes)
  {
    $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    foreach ($stoks as $i => $stok) {
      if ($qty <= $stok['qtystok_current']) {
        $stok_current = $stok['qtystok_current'] - $qty;
        $stok_out = $stok['qtystok_out'] + $qty;
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_current' => $stok_current, 'qtystok_out' => $stok_out));
        $selesai = true;
        break;
      } else {
        $qty = $qty - $stok['qtystok_current'];
        $stok_current = 0;
        $stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current' => $stok_current, 'qtystok_out' => $stok_out));
      }
    }
  }

  protected function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new StokObatalkesT;
      $stok->unsetIdTransaksi();
      $stok->obatalkes_id = $obatAlkes->obatalkes_id;
      $stok->sumberdana_id = $obatAlkes->sumberdana_id;
      $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $stok->tglstok_in = date('Y-m-d H:i:s');
      $stok->tglstok_out = null;
      $stok->qtystok_in = $obatAlkes->qty_oa;
      $stok->qtystok_out = 0;
      $stok->harganetto_oa = $obatAlkes->harganetto_oa;
      $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
      $stok->discount = $obatAlkes->discount;
      $stok->satuankecil_id = $obatAlkes->satuankecil_id;
      $stok->save();
    }
  }

  protected function saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian)
  {
    $modTindakan = new TindakanpelayananT;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modTindakan->pasien_id = $modPasien->pasien_id;
    $modTindakan->daftartindakan_id = $modPemakaian->daftartindakanId;
    $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modTindakan->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');

    $modTindakan->tarif_tindakan = $modPemakaian->totaltarifambulans;
    $modTindakan->satuantindakan = 'Km';
    $modTindakan->qty_tindakan = $modPemakaian->jumlahkm;
    $modTindakan->tarif_satuan = $modPemakaian->tarifperkm;

    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;

    if ($modTindakan->save()) {
      $this->successSaveTindakanPelayanan = true;
    } else {
      $this->successSaveTindakanPelayanan = false;
      Yii::app()->user->setFlash('info', '<pre>' . print_r($modTindakan->getErrors(), 1) . '</pre>');
    }

    return $this->successSaveTindakanPelayanan;
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll('instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama', array(':instalasi_id' => $instalasi_id));

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = PasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAddFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
      $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
      $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

      echo CJSON::encode(array(
        'pendaftaran_id' => $pendaftaran_id,
        'namaObat' => $modObatAlkes->obatalkes_nama,
        'form' => $this->renderPartial('_formAddPemakaianBahan', array(
          'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
          'modPendaftaran' => $modPendaftaran,
        ), true),
      ));
      exit;
    }
  }

  /*
     * untuk print pemesanan ambulans pasien luar
     */

  public function actionPrint($pesanambulans_t)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemesanan = AMPesanambulansT::model()->findByPk($pesanambulans_t);

    $judul_print = 'Pemesanan Ambulans Pasien Luar';
    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemesanan' => $modPemesanan
    ));
  }
}
