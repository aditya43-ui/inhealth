<?php

class PemesananKamarController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $pemesanankamartersimpan = false;
  public $pasientersimpan = false;
  public $path_view = 'pendaftaranPenjadwalan.views.pemesananKamar.';

  public function actionIndex($bookingkamar_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Kamar";
    $this->setStatusKamarOpen();
    $model = new PPBookingKamarT;
    $model->bookingkamar_no = "- Otomatis -";
    $model->tglbookingkamar = date('d M Y H:i:s');
    $model->statusbooking = Params::STATUSBOOKING_ANTRI;
    $lamabooking = Yii::app()->user->getState('lamakonfbooking');
    $tanggal_sekarang = strtotime(date('Y-m-d H:i:s') . ' + ' . $lamabooking . ' days');
    $model->tglakhirkonfirmasi = date('d M Y H:i:s', $tanggal_sekarang);
    $modPasien = new PPPasienM;
    $modPasien->tanggal_lahir = date('d/m/Y');
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    // $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->isPasienLama = false;
    $modPegawai = new PPPegawaiM;

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

    if (!empty($bookingkamar_id)) {
      $model = PPBookingKamarT::model()->findByPk($bookingkamar_id);
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
    }

    if (isset($_POST['PPBookingKamarT'])) {
      $model->attributes = $_POST['PPBookingKamarT'];
      $model->bookingkamar_no = MyGenerator::noBookingKamar();
      $model->tgltransaksibooking = date('Y-m-d H:i:s');
      $model->statuskonfirmasi = Params::STATUSKONFIRMASI_BOOKING_BELUM;
      $model->create_time = date('Y-m-d H:i:s');
      $model->bookingkamar_no = MyGenerator::noBookingKamar();
      //if(!isset($_POST['isPasienLama']))

      if (!isset($_POST['PPPasienM']['isPasienLama'])) { // Jika Bukan Pasien Lama
        $modPasien = $this->savePasien($_POST['PPPasienM']);
        $model->pasien_id = $modPasien->pasien_id;
        $model->pendaftaran_id = (isset($modPasien->pendaftaranTs->pendaftaran_id) ? $modPasien->pendaftaranTs->pendaftaran_id : null);
      } else {
        $modPasien = PPPasienM::model()->findByPk($_POST['PPPasienM']['pasien_id']);
        $model->pasien_id = $modPasien->pasien_id;
        if (isset($modPasien)) {
          $modPasien->attributes = $_POST['PPPasienM'];
          $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
          $modPasien->update_time = date("Y-m-d H:i:s");
          $modPasien->update_loginpemakai_id = Yii::app()->user->id;
          $modPasien->update();
        }
      }

      if ($model->save()) {
        KamarruanganM::model()->updateByPk($model->kamarruangan_id, array('keterangan_kamar' => "BOOKING"));
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $model->isNewRecord = false;

        // SMS GATEWAY
        $modRuangan = $model->ruangan;
        $modKamarRuangan = $model->kamarruangan;
        $modPasien = $model->pasien;
        $modKelasPelayanan = $model->kelaspelayanan;
        $sms = new Sms();
        $smspasien = 1;
        foreach ($modSmsgateway as $i => $smsgateway) {
          $isiPesan = $smsgateway->templatesms;

          $attributes = $model->getAttributes();
          foreach ($attributes as $attributes => $value) {
            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          }
          $attributes = $modPasien->getAttributes();
          foreach ($attributes as $attributes => $value) {
            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          }
          $attributes = $modKamarRuangan->getAttributes();
          foreach ($attributes as $attributes => $value) {
            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          }
          $attributes = $modRuangan->getAttributes();
          foreach ($attributes as $attributes => $value) {
            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          }
          $attributes = $modKelasPelayanan->getAttributes();
          foreach ($attributes as $attributes => $value) {
            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          }
          $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
          $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbookingkamar), $isiPesan);

          if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
            if (!empty($modPasien->no_mobile_pasien)) {
              $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
            } else {
              $smspasien = 0;
            }
          }
        }
        // END SMS GATEWAY
        $this->redirect(array('index', 'bookingkamar_id' => $model->bookingkamar_id, 'status' => 1, 'smspasien' => $smspasien));
      } else {
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan ');
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai
    ));
  }

  public function savePasien($attrPasien)
  {
    $modPasien = new PPPasienM;
    $modPasien->attributes = $attrPasien;
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modPasien->no_rekam_medik = MyGenerator::noRekamMedikBookingKamar();
    $modPasien->ispasienluar = true;
    $modPasien->tgl_rekam_medik = date('Y-m-d', time());
    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($attrPasien['tanggal_lahir']);
    $modPasien->profilrs_id = Params::getDefaultProfilRS();
    $modPasien->statusrekammedis = 'AKTIF';
    $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasien->loginpemakai_id = Yii::app()->user->id;
    $modPasien->create_time = date('Y-m-d H:i:s');
    $modPasien->update_time = date('Y-m-d H:i:s');
    $modPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modPasien->update_loginpemakai_id = Yii::app()->user->id;

    if ($modPasien->validate()) {
      // form inputs are valid, do something here
      $modPasien->save();
      $this->pasientersimpan = true;
    } else {
      // mengembalikan format tanggal 2012-04-10 ke 10 Apr 2012 untuk ditampilkan di form
      $modPasien->tanggal_lahir = Yii::app()->dateFormatter->formatDateTime(
        CDateTimeParser::parse($modPasien->tanggal_lahir, 'yyyy-MM-dd'),
        'medium',
        null
      );
    }
    return $modPasien;
  }

  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->order = 'no_rekam_medik, nama_pasien';
        $criteria->limit = 50;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
        $criteria->limit = 50;
        $models = PPPasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition("pasien_id = " . $pasien_id);
      }
      if (!empty($no_rekam_medik)) {
        $criteria->addCondition("no_rekam_medik = '" . $no_rekam_medik . "'");
      }
      $criteria->addCondition('ispasienluar = FALSE');
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }

      $cekBpjs = AsuransipasienM::model()->find(" pasien_id = '" . $pasien_id . "' ORDER BY create_time DESC");
      if (!empty($cekBpjs)) {
        if ($cekBpjs->carabayar_id == Params::CARABAYAR_ID_ASURANSI) {
          $returnVal["isbpjs"] = true;
        } else {
          $returnVal["isbpjs"] = false;
        }
      } else {
        $returnVal["isbpjs"] = false;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
  public function actionSetDropdownDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new PPPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
      $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /*
     * Mencari Kamar Ruangan berdasarkan ruangan_id di tabel kelasruanganM
     * and open the template in the editor.
     */
  public function actionGetKamarRuangan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      $ruangan = KamarruanganM::model()->findAll('ruangan_id=' . $ruangan_id . ' AND kamarruangan_aktif = TRUE ORDER BY kamarruangan_nokamar');

      $ruangan = CHtml::listData($ruangan, 'kamarruangan_id', 'kamarDanTempatTidurDanKelaspelayanan');

      if (empty($ruangan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($ruangan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetStatusKamar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKamarruangan = $_POST['idKamarruangan'];
      $model = KamarruanganM::model()->findByPk($idKamarruangan);
      $data['status'] = "<font>" . ((!empty($model->keterangan_kamar)) ? "Status Kamar : " . $model->keterangan_kamar : "Status Kamar : KOSONG") . "</font>";
      $data['kamar'] = !empty($model->keterangan_kamar) ? $model->keterangan_kamar : "KOSONG";

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function setStatusKamarOpen()
  {
    $status = '';
    $tglsekarang = date('Y-m-d');
    $criteria = new CDbCriteria();
    //		$criteria->addCondition('statuskonfirmasi IS NOT "'.Params::STATUSKONFIRMASI_BOOKING_SUDAH.'"');
    $criteria->addCondition('pendaftaran_id IS NULL');
    $criteria->addCondition("'$tglsekarang' > DATE(tglakhirkonfirmasi)");
    $model = PPBookingKamarT::model()->findAll($criteria);
    if (count((array)$model) > 0) {
      foreach ($model as $data) {
        if (isset($model->kamarruangan_id)) {
          if ($model->statuskonfirmasi != Params::STATUSKONFIRMASI_BOOKING_SUDAH) {
            PPKamarruanganM::model()->updateByPk($model->kamarruangan_id, array('keterangan_kamar' => 'OPEN'));
            $status = 'berhasil';
          }
        }
      }
    } else {
      $status = 'gagal';
    }
    $status = $status;
  }

  /*
     * Mencari kelas pelayanan berdasarkan kamarruangan_id di tabel kamarruanganM
     * and open the template in the editor.
     */
  public function actionGetKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kamarRuangan_id = $_POST["$namaModel"]['kamarruangan_id'];
      $kelasPelayanan = KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id=' . $kamarRuangan_id . ' AND kelaspelayanan.kelaspelayanan_aktif = TRUE');

      $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');

      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * lembar booking kamar
   * @param type $bookingkamar_id
   */
  public function actionLembarBookingKamar($bookingkamar_id)
  {
    $this->layout = '//layouts/printWindows';
    $modBookingKamar = PPBookingKamarT::model()->findByPk($bookingkamar_id);
    $modPasien =  PPPasienM::model()->findByPk($modBookingKamar->pasien_id);
    $judulLaporan = 'Lembar Booking Kamar';
    $this->render('lembarBookingKamar', array(
      'modBookingKamar' => $modBookingKamar,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien
    ));
  }
}
