<?php

class BuatJanjiPoliTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'pendaftaranPenjadwalan.views.buatJanjiPoliT.';
  public $title = 'Poliklinik';
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($id = null)
  {
    $format = new MyFormatter;

    $modPPBuatJanjiPoli = new PPBuatJanjiPoliT;
    $modPasien = new PPPasienM;
    $modPasien->isPasienLama = false;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;

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

    if (!empty($id)) {
      $modPPBuatJanjiPoli = PPBuatJanjiPoliT::model()->findByPk($id);
      if (!empty($modPPBuatJanjiPoli)) {
        $modPasien = PPPasienM::model()->findByPk($modPPBuatJanjiPoli->pasien_id);
      } else {
        $modPasien = new PPPasienM;
      }
    }


    if (isset($_POST['PPBuatJanjiPoliT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPPBuatJanjiPoli->attributes = $_POST['PPBuatJanjiPoliT'];
        $modPPBuatJanjiPoli->tglbuatjanji = date('Y-m-d H:i:s');
        $modPPBuatJanjiPoli->tgljadwal = $format->formatDateTimeForDb($_POST['PPBuatJanjiPoliT']['tgljadwal']);
        $modPPBuatJanjiPoli->create_time = date('Y-m-d H:i:s');
        $modPPBuatJanjiPoli->update_time = date('Y-m-d H:i:s');
        $modPPBuatJanjiPoli->update_loginpemakai_id = Yii::app()->user->id;
        $modPPBuatJanjiPoli->create_loginpemakai_id = Yii::app()->user->id;
        $modPPBuatJanjiPoli->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if (!isset($_POST['isPasienLama'])) {   //Jika Pasiennya Lama
          $modPasien = $this->savePasien($_POST['PPPasienM']);
          $modPPBuatJanjiPoli->pasien_id = $modPasien->pasien_id;
        } else {
          $modPPBuatJanjiPoli->no_rekam_medik = $_POST['no_rekam_medik'];
          $modPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
          $modPPBuatJanjiPoli->pasien_id = $modPasien->pasien_id;
        }

        if ($modPPBuatJanjiPoli->validate()) {
          $modPPBuatJanjiPoli->save();

          // SMS GATEWAY
          $modPegawai = $modPPBuatJanjiPoli->pegawai;
          $modRuangan = $modPPBuatJanjiPoli->ruangan;
          $modPasien = $modPPBuatJanjiPoli->pasien;
          $sms = new Sms();
          $smspasien = 1;
          $smsdokter = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPPBuatJanjiPoli->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            }
          }
          // END SMS GATEWAY

          //Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Pasien Dan Janji Kunjungan berhasil disimpan.');						
          $transaction->commit();
          $this->redirect(array('Create', 'id' => $modPPBuatJanjiPoli->buatjanjipoli_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter));
          $modPPBuatJanjiPoli->isNewRecord = FALSE;
        } else {
          die();
          $transaction->rollback();

          Yii::app()->user->setFlash('error', 'Data Gagal disimpan ');
        }
      } catch (Exception $exc) {
        var_dump($exc->getMessage());
        die();
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($exc, true) . '');
      }
    }

    $this->render($this->path_view . 'create', array(
      'modPasien' => $modPasien,
      'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli

    ));
  }

  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionGetListDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idPropinsi = (isset($_POST['idProp']) ? $_POST['idProp'] : null);
      $idKabupaten = (isset($_POST['idKab']) ? $_POST['idKab'] : null);
      $idKecamatan = (isset($_POST['idKec']) ? $_POST['idKec'] : null);
      $idKelurahan = (isset($_POST['idKel']) ? $_POST['idKel'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $pasien = PasienM::model()->findByPk($pasien_id);

      $propinsiOption = '';
      foreach ($propinsis as $value => $name) {
        if ($value == $idPropinsi)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatenOption = '';
      $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $idPropinsi, 'kabupaten_aktif' => true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      foreach ($kabupatens as $value => $name) {
        if ($value == $idKabupaten)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $kecamatanOption = '';
      $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id' => $idKabupaten, 'kecamatan_aktif' => true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      foreach ($kecamatans as $value => $name) {
        if ($value == $idKecamatan)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $kelurahanOption = '';
      if (!empty($pasien->kelurahan_id)) {
        //                echo $pasien->kelurahan_id;exit;
        $kelurahans = KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $idKecamatan, 'kelurahan_aktif' => true));
        $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
        $kelurahanOption .= CHtml::tag('option', array('value' => null), "-- Pilih --", true);
        foreach ($kelurahans as $value => $name) {
          if ($value == $pasien->kelurahan_id)
            $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
          else
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      } else {
        $kelurahanOption .= CHtml::tag('option', array('value' => null), "-- Pilih --", true);
      }


      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetKabupaten($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $propinsi_id = $_POST["$namaModel"]['propinsi_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $propinsi_id = $_POST["$namaModel"]["$attr"];
      }
      $kabupaten = KabupatenM::model()->findAll('propinsi_id=' . $propinsi_id . ' and kabupaten_aktif = true ORDER BY kabupaten_nama asc');
      $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');

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

  public function actionGetKecamatan($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $kabupaten_id = $_POST["$namaModel"]['kabupaten_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$namaModel"]["$attr"];
      }
      $kecamatan = KecamatanM::model()->findAll('kabupaten_id = ' . $kabupaten_id . ' ORDER BY kecamatan_nama asc');
      $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');

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

  public function actionGetKelurahan($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $kecamatan_id = $_POST["$namaModel"]['kecamatan_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$namaModel"]["$attr"];
      }
      $kelurahan = KelurahanM::model()->findAll('kecamatan_id=' . $kecamatan_id . ' order by kelurahan_nama asc');
      $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');

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

  public function actionGetHari()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $tanggalWaktu = $_POST['tanggal'];

      $tanggal = trim(substr($tanggalWaktu, 0, -8)); //Menampilkan Tanggal Tanpa Jam
      $tanggalDB = $format->formatDateTimeForDb($tanggal); //Mengubah Tanggal inputan ke tanggal database
      $hari = date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

      if (strtolower($hari) == 'sunday') {
        $hari = 'Minggu';
      } else if (strtolower($hari) == 'monday') {
        $hari = 'Senin';
      } else if (strtolower($hari) == 'tuesday') {
        $hari = 'Selasa';
      } else if (strtolower($hari) == 'wednesday') {
        $hari = 'Rabu';
      } else if (strtolower($hari) == 'thursday') {
        $hari = 'Kamis';
      } else if (strtolower($hari) == 'friday') {
        $hari = 'Jumat';
      } else if (strtolower($hari) == 'saturday') {
        $hari = 'Sabtu';
      }
      $data['hari'] = $hari;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetTglLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {

      $format = new MyFormatter();
      $umur = explode(' ', $_POST['umur']);
      $today = date('Y-m-d');
      if (isset($umur[0]) && isset($umur[2]) && isset($umur[4])) {
        $thn = $umur[0];
        $bln = $umur[2];
        $hr = $umur[4];

        if ($thn == '') $thn = 0;
        if ($bln == '') $bln = 0;
        $date_calc = strtotime(date("Y-m-d", strtotime($today)) . "-$thn year");
        $date = date('Y-m-d', $date_calc);
        $date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$bln month");
        $date = date('Y-m-d', $date_calc);
        $date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$hr day");
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d', $date_calc), 'yyyy-MM-dd'), 'medium', null);
        $data['tglLahir'] = $tgl; // 28/02/2002
      } else {
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($today, 'yyyy-MM-dd'), 'medium', null);
        $data['tglLahir'] = $tgl;
      }
      //				print_r($data);exit;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->order = 'no_rekam_medik';
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

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $modPPBuatJanjiPoli = $this->loadModel($id);

    //$modPPBuatJanjiPoli->tgljadwal = $modPPBuatJanjiPoli->tgljadwal[0]." ".$modPPBuatJanjiPoli->tgljadwal[1].":00";

     $format = new MyFormatter;
    $modPPBuatJanjiPoli->tgljadwal = $format->formatDateTimeForDb($modPPBuatJanjiPoli->tgljadwal);
    $modPPBuatJanjiPoli->tgljadwal;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPBuatJanjiPoliT'])) {
      // echo CJSON::encode($_POST['PPBuatJanjiPoliT']);
      // die;
      $tanggal = explode(" ", $modPPBuatJanjiPoli->tgljadwal);
      $modPPBuatJanjiPoli->attributes = $_POST['PPBuatJanjiPoliT'];

      if ($modPPBuatJanjiPoli->slotantrian == 1) {
        
        $modPPBuatJanjiPoli->tgljadwal = $tanggal[0]." ".$tanggal[1]."";
     
      }else{
        $modPPBuatJanjiPoli->tgljadwal = $tanggal[0]." ".$modPPBuatJanjiPoli->tgljadwal[1].":00";

      }
      //  echo CJSON::encode($modPPBuatJanjiPoli->tgljadwal);
      //  die;
      if ($modPPBuatJanjiPoli->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $modPPBuatJanjiPoli->buatjanjipoli_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'modPPBuatJanjiPoli' => $modPPBuatJanjiPoli,
    ));
  }


  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id = null)
  {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    if (isset($_POST['id'])) {
      $modBuatJanji = PPBuatJanjiPoliT::model()->findByPk($id);
      if (empty($modBuatJanji->pendaftaran_id)) {
        $modBuatJanji->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'pesan' => 'Data Janji Poli berhasi di batalkan.',
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'pesan' => 'Data janji poli tidak bisa dibatalkan karena pasien sudah didaftarkan!',
          ));
          exit;
        }
      }
    }
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PPBuatJanjiPoliT');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Janji Poliklinik";
    $format = new MyFormatter();
    $model = new PPBuatJanjiPoliT;
    //$model->tgl_awal = date('Y-m-d');
    //$model->tgl_akhir = date('Y-m-d');
    $model->tgl_awal_janji = date('Y-m-d');
    $model->tgl_akhir_janji = date('Y-m-d');
    $model->nama_pasien='';
    if (isset($_REQUEST['PPBuatJanjiPoliT'])) {
      $model->attributes = $_REQUEST['PPBuatJanjiPoliT'];
     // $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['PPBuatJanjiPoliT']['tgl_awal']);
     // $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBuatJanjiPoliT']['tgl_akhir']);
      $model->tgl_awal_janji = $format->formatDateTimeForDb($_REQUEST['PPBuatJanjiPoliT']['tgl_awal_janji']);
      $model->tgl_akhir_janji = $format->formatDateTimeForDb($_REQUEST['PPBuatJanjiPoliT']['tgl_akhir_janji']);
      $model->tgljadwal = $model->tgl_awal_janji && $model->tgl_akhir_janji;
      $model->nama_pasien = $_REQUEST['PPBuatJanjiPoliT']['nama_pasien'];
      $model->carabayar_id = $_REQUEST['PPBuatJanjiPoliT']['carabayar_id'];
      $model->penjamin_id = $_REQUEST['PPBuatJanjiPoliT']['penjamin_id'];
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(61);

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
      'format' => $format,
      'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PPBuatJanjiPoliT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppbuat-janji-poli-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new PPBuatJanjiPoliT;
    $model->attributes = $_REQUEST['PPBuatJanjiPoliT'];
    $judulLaporan = 'Data Buat Janji Poli';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

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
  public function savePasien($attrPasien)
  {
    $modPasien = new PPPasienM;
    $modPasien->attributes = $attrPasien;
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modPasien->no_rekam_medik = MyGenerator::noRekamMedikJanjiPoli();
    $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->profilrs_id = Params::getDefaultProfilRS();
    $modPasien->statusrekammedis = 'AKTIF';
    $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasien->loginpemakai_id = Yii::app()->user->id;
    $modPasien->create_time = date('Y-m-d H:i:s');
    $modPasien->update_time = date('Y-m-d H:i:s');
    $modPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modPasien->update_loginpemakai_id = Yii::app()->user->id;
    $modPasien->ispasienluar = TRUE;

    if ($modPasien->validate()) {
      // form inputs are valid, do something here
      $modPasien->save();
    } else {
      //                echo var_dump($_POST['PPPasienM']);exit;
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
   * print lembar janji poli
   * @param type $buatjanjipoli_id
   */
  public function actionLembarJanjiPoli($buatjanjipoli_id)
  {
    $this->layout = '//layouts/printWindows';
    $modJanjiPoli = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
    $modPasien =  PasienM::model()->findByPk($modJanjiPoli->pasien_id);
    $modPendaftaran = PendaftaranT::model()->find('pasien_id =' . $modPasien->pasien_id);
    $judulLaporan = 'Lembar Janji Poli';
    $this->render('lembarJanjiPoli', array(
      'modJanjiPoli' => $modJanjiPoli,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
