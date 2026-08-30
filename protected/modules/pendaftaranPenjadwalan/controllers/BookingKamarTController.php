<?php

class BookingKamarTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $successSave = false;
  public $path_view = 'pendaftaranPenjadwalan.views.bookingKamarT.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($bookingkamar_id = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new PPBookingKamarT;
    $model->tglbookingkamar = date('d M Y H:i:s');
    $modPasien = new PPPasienM;
    $modPasien->tanggal_lahir = date('d/m/Y');
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;

    $modPasien->isPasienLama = false;
    $model->bookingkamar_no = "- Otomatis -";

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
      $model->bookingkamar_no = MyGenerator::noBookingKamar();
      $model->attributes = $_POST['PPBookingKamarT'];
      $model->tgltransaksibooking = date('Y-m-d H:i:s');
      $model->statuskonfirmasi = Params::STATUSKONFIRMASI_BOOKING_BELUM;
      $model->create_time = date('Y-m-d H:i:s');
      $model->bookingkamar_no = MyGenerator::noBookingKamar();
      if (!isset($_POST['isPasienLama'])) { // Jika Bukan Pasien Lama
        $modPasien = $this->savePasien($_POST['PPPasienM']);
        $model->pasien_id = $modPasien->pasien_id;
        $model->pendaftaran_id = (isset($modPasien->pendaftaranTs->pendaftaran_id) ? $modPasien->pendaftaranTs->pendaftaran_id : null);
      } else {
        $modPasien = PPPasienM::model()->findByPk($_POST['PPBookingKamarT']['pasien_id']);
        $model->pasien_id = $modPasien->pasien_id;
        if (isset($modPasien)) {
          $modPasien->attributes = $_POST['PPPasienM'];
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
        $this->redirect(array('create', 'bookingkamar_id' => $model->bookingkamar_id, 'status' => 1, 'smspasien' => $smspasien));
      } else {
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan ');
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modPasien' => $modPasien,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPBookingKamarT'])) {
      $model->attributes = $_POST['PPBookingKamarT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->bookingkamar_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $status = false;
      $id = $_POST['id'];
      $modBooking = $this->loadModel($id);
      $updateKamar = KamarruanganM::model()->updateByPk($modBooking->kamarruangan_id, array('keterangan_kamar' => 'OPEN'));
      $hapusBooking = $this->loadModel($id)->delete();
      if ($updateKamar && $hapusBooking) {
        $status = true;
        $div = "<div class='flash-success'>Data berhasil dihapus.</div>";
      } else {
        $status = false;
        $div = "<div class='flash-success'>Data gagal dihapus.</div>";
      }

      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => $div,
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PPBookingKamarT');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionUbahStatusKonfirmasiBooking()
  {
    //            $idBooking = Yii::app()->session['bookingkamar_id'];
    $idbooking = $_POST['idbooking'];
    $status = $_POST['status'];
    $idkamarruangan = $_POST['idkamarruangan'];
    $model = BookingkamarT::model()->findByPk($idbooking);

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
    $nama_pasien = '';

    if (!empty($_POST['idbooking'])) {
      if ($status == "BELUM KONFIRMASI") {
        $statusbook = "SUDAH KONFIRMASI";
      } else if ($status == "SUDAH KONFIRMASI") {
        $statusbook = "BATAL BOOKING";
      }
      $update = BookingkamarT::model()->updateByPk($idbooking, array('statuskonfirmasi' => $statusbook));
      // $kamar = KamarruanganM::model()->updateByPk($idkamarruangan,array('keterangan_kamar'=>"KOSONG"));
      if ($update) {
        // SMS GATEWAY
        $modPasien = $model->pasien;
        $nama_pasien = $modPasien->nama_pasien;
        $sms = new Sms();

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

          $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
          // $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglbookingkamar),$isiPesan);

          if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
            if (!empty($modPasien->no_mobile_pasien)) {
              $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
            } else {
              $smspasien = 0;
            }
          }
        }
        // END SMS GATEWAY

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'berhasil',
            'div' => "<div class='flash-success'>Data Booking Kamar <b></b> berhasil disimpan </div>",
            'smspasien' => $smspasien,
            'nama_pasien' => $nama_pasien,
          ));
          exit;
        }
      } else {

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'gagal',
            'div' => "<div class='flash-error'>Data Booking Kamar <b></b> gagal disimpan </div>",
            'smspasien' => $smspasien,
            'nama_pasien' => $nama_pasien,
          ));
          exit;
        }
      }
    }

    //            if (Yii::app()->request->isAjaxRequest)
    //            {   
    //                echo CJSON::encode(array(
    //                    'status'=>'create_form', 
    //                    'div'=>$this->renderPartial('_ubahStatusKonfirmasiBooking',array('model'=>$model),true)));
    //                exit;               
    //            }
  }

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

  public function actionRuanganberdasarkanRM()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      // ================================cari Pendaftaran terakhir========================================
      $no_rekam_medik = $_POST['no_rekam_medik'];
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->addCondition('tgl_pendaftaran BETWEEN \'' . date('Y-m-d') . ' 00:00:00\' AND \'' . date('Y-m-d H:i:s') . '\'');
      $criteria->addCondition('t.instalasi_id=' . Params::INSTALASI_ID_RJ . ' OR t.instalasi_id=' . Params::INSTALASI_ID_RD . '');
      $criteria->with = array('pasien', 'ruangan', 'instalasi');
      $criteria->order = 'tgl_pendaftaran DESC';
      $criteria->limit = 1;

      $pendaftaran = PendaftaranT::model()->find($criteria);
      if (empty($pendaftaran)) {

        $data['data_pesan'] = 'Pasien Belum Mendaftar di Rawat 
									  Jalan ataupun Rawat Darurat Pada hari Ini';
      } else {
        $data['pendaftaran_id'] = $pendaftaran->pendaftaran_id;
        $data['data_pesan'] = 'Pasien Terdaftar di ' . $pendaftaran->instalasi->instalasi_nama . '<br>
										 Ruangan :<b>' . $pendaftaran->ruangan->ruangan_nama . ' </b>
										 <br>Tanggal Pendaftaran :<b>' . $pendaftaran->tgl_pendaftaran . '</b>';
      }
      //==================================Akhir Cari DiPendaftaran==========================================

      //==================================Cari Di Pasien Admisi=============================================
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($no_rekam_medik), true);
      $criteria->with = array('pasien', 'ruangan');
      $criteria->addCondition('statuskeluar=FALSE');
      $pasienAdmisi = PasienadmisiT::model()->find($criteria);
      if (empty($pasienAdmisi)) {
        $data['cek'] = null;
        $data['data_pesan'] .= '<br>Pasien Belum terdaftar Dirawat Inap';
      } else {
        $data['pasien_id'] = $pasienAdmisi->pasien_id;
        $data['kelaspelayanan_id'] = $pasienAdmisi->kelaspelayanan_id;
        $data['ruangan_id'] = $pasienAdmisi->ruangan_id;
        $data['kamarruangan_id'] = $pasienAdmisi->kamarruangan_id;
        $data['pasienadmisi_id'] = $pasienAdmisi->pasienadmisi_id;
        $data['data_pesan'] .= '<br>Pasien sudah Terdaftar di Rawat Inap<br>
										   Ruangan : <b>' . $pasienAdmisi->ruangan->ruangan_nama . '</b>';
      }
      //======================================Akhir Cari Di Pasien Admisi                
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

  /*
     * Mencari Kamar Ruangan berdasarkan ruangan_id di tabel kelasruanganM
     * and open the template in the editor.
     */
  public function actionGetKamarRuangan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      $ruangan = KamarruanganM::model()->findAll('ruangan_id=' . $ruangan_id . 'ORDER BY kamarruangan_nokamar');

      $ruangan = CHtml::listData($ruangan, 'kamarruangan_id', 'KamarDanTempatTidur');

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

  public function actionAddKabupaten()
  {
    $modelKab = new KabupatenM;
    $modProp = PropinsiM::model()->findAll();

    if (isset($_POST['KabupatenM'])) {
      $modelKab->attributes = $_POST['KabupatenM'];
      $modelKab->kabupaten_aktif = true;
      if ($modelKab->save()) {
        $data = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $_POST['KabupatenM']['propinsi_id'],), array('order' => 'kabupaten_nama'));
        $data = CHtml::listData($data, 'kabupaten_id', 'kabupaten_nama');

        if (empty($data)) {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kabupaten <b>" . $_POST['KabupatenM']['kabupaten_nama'] . "</b> berhasil ditambahkan </div>",
            'kabupaten' => $kabupatenOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKabupaten', array('model' => $modelKab, 'modProp' => $modProp), true)
      ));
      exit;
    }
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

  public function actionAddKecamatan()
  {
    $modelKec = new KecamatanM;
    //$modProp = PropinsiM::model()->findAll(array('order'=>'propinsi_nama'));

    if (isset($_POST['KecamatanM'])) {
      $modelKec->attributes = $_POST['KecamatanM'];
      $modelKec->kecamatan_aktif = true;
      if ($modelKec->save()) {
        $data = KecamatanM::model()->findAllByAttributes(array('kabupaten_id' => $_POST['KecamatanM']['kabupaten_id'],), array('order' => 'kecamatan_nama'));
        $data = CHtml::listData($data, 'kecamatan_id', 'kecamatan_nama');

        if (empty($data)) {
          $kecamatanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $kecamatanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kecamatan <b>" . $_POST['KecamatanM']['kecamatan_nama'] . "</b> berhasil ditambahkan </div>",
            'kecamatan' => $kecamatanOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKecamatan', array('model' => $modelKec), true)
      ));
      exit;
    }
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->setStatusKamarOpen();
    $this->pageTitle = Yii::app()->name . " - Pemesanan Kamar";

    $format = new MyFormatter();
    $model = new PPBookingKamarT;
    $model->unsetAttributes(); // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['PPBookingKamarT'])) {
      $model->attributes = $_GET['PPBookingKamarT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['PPBookingKamarT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBookingKamarT']['tgl_akhir']);
      $model->noRekamMedik = $_REQUEST['PPBookingKamarT']['noRekamMedik'];
      $model->prefix_pendaftaran = $_GET['PPBookingKamarT']['prefix_pendaftaran'];
      $model->no_pendaftaran = $_GET['PPBookingKamarT']['no_pendaftaran'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionUpdateStatusKonfirmasi()
  {
    $satu = '';
    $model = BookingkamarT::model()->findByPk($idBooking);
    $idBooking = $_POST['idBooking'];
    $tglbookingkamar = $_POST['tglbookingkamar'];

    $model->tglbookingkamar = $_POST['tglbookingkamar'];
    $model->bookingkamar_id = $_POST['idBooking'];
    $waktuini = date('h:i:s');

    $jamtransaksi = $model->tgltransaksibooking;

    $test = date('H:i:s', strtotime($jamtransaksi));
    $test2 = date('H:i:s');
    $jamtrans = $test;
    $jamsaatini = $test2;
    $jml_jam = $this->selisih($jamtrans, $jamsaatini);

    //              echo "test: ".$test; echo "<br>";
    //              echo "test2:".$test2; echo "<br>";
    //              echo "trans:".$jamtrans; echo "<br>";
    //              echo "now:".$jamsaatini; echo "<br>";
    //              echo "WAktu Kerja : ".selisih($jamtrans,$jamsaatini);

    if ($jml_jam >= 2 && $model->statuskonfirmasi != "SUDAH KONFIRMASI") {
      $update = BookingkamarT::model()->updateByPk($idBooking, array('statuskonfirmasi' => 'BATAL BOOKING'));
    }

    if ($update) {
      $satu = $this->createUrl('admin');
    }

    echo CJSON::encode(array(
      'satu' => $satu,
      'tglbooking' => $tglbookingkamar,
      'idBooking' => $idBooking,
    ));
    Yii::app()->end();
  }

  function selisih($jamtrans, $jamsaatini)
  {
    list($h, $m, $s) = explode(":", $jamtrans);
    $dtAwal = mktime($h, $m, $s, '1', '1', '1');
    list($h, $m, $s) = explode(':', $jamsaatini);
    $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];

    //          return $jml_jam." jam ".$sisamenit2." menit"; 
    return $jml_jam;
  }
  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PPBookingKamarT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppbooking-kamar-t-form') {
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
    $model = new PPBookingKamarT;
    $model->attributes = $_REQUEST['PPBookingKamarT'];
    $judulLaporan = 'Data Booking Kamar';
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
      $this->successSave = true;
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
   * lembar booking kamar
   * @param type $bookingkamar_id
   */
  public function actionLembarBookingKamar($bookingkamar_id)
  {
    $this->layout = '//layouts/printWindows';
    $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
    $modPasien =  PasienM::model()->findByPk($modBookingKamar->pasien_id);
    $judulLaporan = 'Lembar Booking Kamar';
    $this->render('lembarBookingKamar', array(
      'modBookingKamar' => $modBookingKamar,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien
    ));
  }
  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['PPBookingKamarT'])) {
        $format = new MyFormatter();
        $model = new PPBookingKamarT;
        $modPasien = new PPPasienM;

        $model->attributes = $_POST['PPBookingKamarT'];
        $modPasien->attributes = $_POST['PPPasienM'];
      }
      $data['status'] = true;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
  public function actionSetDropdownKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      $kelasPelayanan = null;
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
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

  /*
     * Mencari kelas pelayanan berdasarkan kamarruangan_id di tabel kamarruanganM
     * and open the template in the editor.
     */
  public function actionGetKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kamarRuangan_id = $_POST["$namaModel"]['kamarruangan_id'];
      $kelasPelayanan = KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id=' . $kamarRuangan_id . '', array());

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

  public function actionGetKabupaten($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel == '' && $attr !== '') {
        $propinsi_nama = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $propinsi_nama = $_POST["$namaModel"]["$attr"];
      }
      $propinsi = PropinsiM::model()->findByAttributes(array('propinsi_nama' => $propinsi_nama));
      $propinsi_id = $propinsi->propinsi_id;
      if (empty($propinsi)) {
        $propinsi_id = $propinsi_nama;
      }
      $kabupaten = KabupatenM::model()->findAll("propinsi_id='$propinsi_id' ORDER BY kabupaten_nama asc");
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
}
