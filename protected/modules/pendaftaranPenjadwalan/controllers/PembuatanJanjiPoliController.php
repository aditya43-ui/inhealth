<?php

class PembuatanJanjiPoliController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'pendaftaranPenjadwalan.views.pembuatanJanjiPoli.';
 // public $default = true;
  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($janjipoli = null)
  {

    $this->pageTitle = Yii::app()->name . " - Pembuatan Janji Poliklinik";
    $model = new PPBuatJanjiPoliT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPenjamin = new AsuransipasienM;
    $model->jamjadwal = date('H:i:00');
    $default = true;
    
    if (isset($janjipoli)) {
      $model = $this->loadModel($janjipoli);
      $model->pegawai_id = $model->pegawai_id;
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      $modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
      // $modPenjamin = AsuransipasienM::model()->findAllByAttributes($model->pasien_id);
      $arr_jadwal = array(date('Y-m-d', strtotime($model->tgljadwal)), date('H:i:s', strtotime($model->tgljadwal)));
      $model->tgljadwal = $arr_jadwal;
      // var_dump($model->attributes); die;
    } else {
      $jadwalKosong = array('', '');
      $model->tgljadwal = $jadwalKosong;

    }

    
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
    
    $format = new MyFormatter;
    
    if (isset($_POST['PPBuatJanjiPoliT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      // var_dump($_POST);die;
      try {
        // $model = new PPBuatJanjiPoliT;
        $model->attributes = $_POST['PPBuatJanjiPoliT'];
        $model->tglbuatjanji = date('Y-m-d H:i:s');

        $model->tgljadwal = $model->tgljadwal[0]." ".$model->tgljadwal[1];

        $model->tgljadwal = $format->formatDateTimeForDb($model->tgljadwal);
        $model->ruangan_id = $_POST['PPBuatJanjiPoliT']['ruangan_id'];
        $model->no_antrianjanji = !isset($_POST['PPBuatJanjiPoliT']['no_antrianjanji']) ? MyGenerator::noAntrianJanjiPoli($model->ruangan_id) : str_pad($_POST['PPBuatJanjiPoliT']['no_antrianjanji'], 3, '0', STR_PAD_LEFT);
        $model->no_buatjanji = MyGenerator::noJanjiPoli("JP");
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->penjamin_id = $_POST['PPPasienM']['penjamin_id'];
        $model->no_kartu_bpjs = $_POST['AsuransipasienM']['nopeserta'];
    
       // if (!isset($_POST['isPasienLama'])) {   //Jika Pasiennya Lama
        if($modPasien->isPasienLama == $default) {
          $modPasien = $this->savePasien($_POST['PPPasienM']);
          $model->pasien_id = $modPasien->pasien_id;
          $model->no_rekam_medik = $modPasien->no_rekam_medik;
        } else {
          $modPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
          $modPasien->no_mobile_pasien = $_POST['PPPasienM']['no_mobile_pasien'];
          $modPasien->save(false);
          $model->pasien_id = $modPasien->pasien_id;
          $model->no_rekam_medik = $modPasien->no_rekam_medik;
        }

        if ($model->validate()) {
          $model->save();
          // SMS GATEWAY
          // $modPegawai = $model->pegawai;
          // $modRuangan = $model->ruangan;
          // $sms = new Sms();
          // $smspasien = 1;
          // $smsdokter = 1;
          // foreach ($modSmsgateway as $i => $smsgateway) {
          //   $isiPesan = $smsgateway->templatesms;

          //   $attributes = $modPasien->getAttributes();
          //   foreach ($attributes as $attributes => $value) {
          //     $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          //   }
          //   $attributes = $model->getAttributes();
          //   foreach ($attributes as $attributes => $value) {
          //     $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          //   }
          //   $attributes = $modPegawai->getAttributes();
          //   foreach ($attributes as $attributes => $value) {
          //     $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          //   }
          //   $attributes = $modRuangan->getAttributes();
          //   foreach ($attributes as $attributes => $value) {
          //     $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
          //   }
          //   $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

          //   if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
          //     if (!empty($modPasien->no_mobile_pasien)) {
          //       $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
          //     } else {
          //       $smspasien = 0;
          //     }
          //   } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
          //     if (!empty($modPegawai->nomobile_pegawai)) {
          //       $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
          //     } else {
          //       $smsdokter = 0;
          //     }
          //   }
          // }
          //                        echo '<pre>';
          //                        print_r();
          //                        exit();
          // END SMS GATEWAY
          //Insert Notifikasi_r untuk modul Pendaftaran 
          $judul = 'Pemberitahuan Janji Poli';
          $isi = 'bahwa besok akan ada jadwal pemeriksaan pasien ' . $modPasien->nama_pasien . "<br/>"
            . "Tanggal Janji Poli : " . MyFormatter::formatDateTimeForUser($model->tgljadwal);
          $modNotifikasiR = array();
          $tglNotif = date('Y-m-d', strtotime("-1 day", strtotime($model->tgljadwal)));

          $timeNotif = date('H:i:s');
          $modNotifikasiR['tglnotifikasi'] = $tglNotif . ' ' . $timeNotif;
          $modNotifikasiR['create_time'] = date('Y-m-d H:i:s');
          $modNotifikasiR['create_loginpemakai_id'] = Yii::app()->user->id;
          $modNotifikasiR['judulnotifikasi'] = $judul;
          $modNotifikasiR['isinotifikasi'] = $isi;
          $modNotifikasiR['instalasi_id'] = Params::INSTALASI_ID_RM;
          $modNotifikasiR['modul_id'] = Params::MODUL_ID_PENDAFTARAN;
          $modNotifikasiR['create_ruangan'] = Params::RUANGAN_ID_LOKET_PENDAFTARAN;

          // CustomFunction::insertNotifikasiCron($modNotifikasiR);
          //Insert Notifikasi_r untuk modul Informasi
          $modNotifikasiRInformasi = array();
          $modNotifikasiRInformasi['tglnotifikasi'] = $tglNotif . ' ' . $timeNotif;
          $modNotifikasiRInformasi['create_time'] = date('Y-m-d H:i:s');
          $modNotifikasiRInformasi['create_loginpemakai_id'] = Yii::app()->user->id;
          $modNotifikasiRInformasi['judulnotifikasi'] = $judul;
          $modNotifikasiRInformasi['isinotifikasi'] = $isi;
          $modNotifikasiRInformasi['instalasi_id'] = Params::INSTALASI_ID_RM;
          $modNotifikasiRInformasi['modul_id'] = Params::MODUL_ID_INFORMASI;
          $modNotifikasiRInformasi['create_ruangan'] = Params::RUANGAN_ID_INFORMASI;

          // CustomFunction::insertNotifikasiCron($modNotifikasiRInformasi);
          

          //                         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          //                            array('instalasi_id'=> Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_LOKET_PENDAFTARAN, 'modul_id'=> Params::MODUL_ID_PENDAFTARAN),
          //                        )); 
          // var_dump($model->attributes, $_POST); die;
          $transaction->commit();


          // if ($model->whatsapp) {
            $profil = ProfilrumahsakitM::model()->find();

            $msg = "
Assalamualaikum.Wr.Wb
Terimakasih telah melakukan Perjanjian di ((nama_rs))
            
((nama_pasien)) memiliki perjanjian dengan No Perjanjian ((no_buatjanji)) untuk tanggal kunjungan ((jgljadwal)) Ke ((ruangan_nama)) - ((nama_pegawai)) dengan Nomor Antrian ((no_antrian))
            
            
*Membawa Surat Rujukan Online dari PPK 1 yang masih berlaku/ RS Tipe C (BPJS)
*Sebelum memasuki rumah sakit Semua pengunjung harus mengisi screening online di link berikut: http://sariasihciputat.com/screening\n 
*Untuk melihat Live Antrian dapat mengunjungi : https://sariasihgroup.com/salive/antrian
            
            
Terimakasih
Syafakumullah
            
Wassalamualaikum.Wr.Wb
";
            $msg = str_replace("((nama_rs))", $profil->nama_rumahsakit, $msg);
            $msg = str_replace("((nama_pasien))", $modPasien->namadepan.$modPasien->nama_pasien, $msg);
            $msg = str_replace("((no_rekam_medik))", $modPasien->no_rekam_medik, $msg);
            $msg = str_replace("((no_buatjanji))", $model->no_buatjanji, $msg);
            $msg = str_replace("((tgljadwal))", MyFormatter::formatDateTimeForUser($model->tgljadwal), $msg);
            $msg = str_replace("((ruangan_nama))", $model->ruangan->ruangan_nama, $msg);
            $msg = str_replace("((nama_pegawai))", $model->pegawai->namaLengkap, $msg);
            $msg = str_replace("((no_antrian))", $model->ruangan->ruangan_singkatan."-".$model->no_antrianjanji, $msg);

            // var_dump($msg."\n", $model->attributes); die;
            // die;

            // if (!empty($modPasien->no_mobile_pasien)) {
            //     // echo "Kirim: ".$model->no_buatjanji." - ".$modPasien->no_mobile_pasien."\n";
            //     $wa = new WhatsApp();
                
            //     $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $msg);

            //     // var_dump($res);
            // }
          // }
          Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->nama_pasien . " berhasil disimpan");
          
          // Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          // $this->redirect(array('create', 'buatjanjipoli_id' => $model->buatjanjipoli_id, 'sukses' => 1));
          $this->redirect(array('create', 'janjipoli'=>$model->buatjanjipoli_id, 'ok' => 1));

        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } catch (Exception $exc) {
        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }
   
    $tgl = explode('-', date('Y-m-d'));
    $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
    $grid = $this->createGrid($day, $tgl[1], $tgl[0]);

    $this->render('create', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'grid' => $grid,
      'modPenjamin' => $modPenjamin
    ));
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
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->pekerjaan_id = 14;

    if ($modPasien->validate()) {
      $modPasien->save();
    } else {
      $modPasien->tanggal_lahir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasien->tanggal_lahir, 'yyyy-MM-dd'), 'medium', null);
    }
    return $modPasien;
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $modPasien = PPPasienM::model()->findByAttributes(array('pasien_id' => $id));
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPBuatJanjiPoliT'])) {
      $model->attributes = $_POST['PPBuatJanjiPoliT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->buatjanjipoli_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**GetKabupaten
   * 
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PPBuatJanjiPoliT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new PPBuatJanjiPoliT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PPBuatJanjiPoliT'])) {
      $model->attributes = $_GET['PPBuatJanjiPoliT'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
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
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new PPBuatJanjiPoliT;
    $model->attributes = $_REQUEST['PPBuatJanjiPoliT'];
    $judulLaporan = 'Data PPBuatJanjiPoliT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  /**
   * Fungsi untuk autocomplete no rekam medik 
   */
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
   * set Nip dari Pegawaai Id (int)
   */
  public function actionSetNip()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['nomorindukpegawai'] = null;
      $pegawai = $_POST['pegawai_id'];
      $res = PegawaiM::model()->findByPk($pegawai);
      $data['nomorindukpegawai'] = $res->nomorindukpegawai;
      echo json_encode($data);
      Yii::app()->end();
    }
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


  public function actionGetHari()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $tanggalWaktu = $_POST['tanggal'];
      //	$jam=$_POST['jam'];
      //	$ruangan_id = $_POST['ruangan_id'];
      //	$pegawai_id = $_POST['pegawai_id'];
      //	$tipe = $_POST['tipe'];

      /*$p = PegawaiM::model()->findByPk($pegawai_id);
				
				$data['dokter'] = $p->namaLengkap;
				
				$r = RuanganM::model()->findByPk($ruangan_id);
				
				$data['ruangan'] = $r->ruangan_nama;
				
				$data['jadwal'] = 'tidak';*/

      //  $tanggal=trim(substr($tanggalWaktu,0,-8)); //Menampilkan Tanggal Tanpa Jam
      $tanggalDB = $format->formatDateTimeForDb($tanggalWaktu); //Mengubah Tanggal inputan ke tanggal database
      $hari = date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

      //				$tgl = date('Y-m-d', strtotime($tanggalDB));
      //				$jam = $jam;
      //				
      //				$data['tanggal'] = MyFormatter::formatDateTimeForUser($tanggal);
      //				
      //				$cri = new CDbCriteria();
      //				$cri->addCondition(" ruangan_id = ".$ruangan_id." ");
      //				$cri->addCondition(" pegawai_id = ".$pegawai_id." ");
      //				$cri->addCondition(" ('".$jam."' >= jadwaldokter_mulai AND '".$jam."' <=jadwaldokter_tutup)  ");
      //				$cri->addCondition(" jadwaldokter_tgl = '".$tanggalDB."' ");
      //								
      //				$jadwal = JadwaldokterM::model()->find($cri);
      //				
      //				if (!empty($jadwal)){
      //					$data['jadwal'] = 'ada';
      //					
      //					if ($jam == $jadwal->jadwaldokter_tutup){
      //						$data['jadwal'] = 'sama';
      //					}
      //				}else{
      //					$cri = new CDbCriteria();
      //					$cri->addCondition(" ruangan_id = ".$ruangan_id." ");
      //					$cri->addCondition(" pegawai_id = ".$pegawai_id." ");					
      //					$cri->addCondition(" jadwaldokter_tgl = '".$tanggalDB."' ");
      //
      //					$jadwal = JadwaldokterM::model()->find($cri);
      //					
      //					if (!empty($jadwal))
      //					{
      //						$data['jadwal'] = 'diluar';
      //						$data['jamtanggal'] = $jadwal->jadwaldokter_mulai;
      //					}					
      //				}

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

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintKarcis($buatjanjipoli_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $model = PPBuatJanjiPoliT::model()->findByPk($buatjanjipoli_id);
    $modPasien = PasienM::model()->findByPk($model->pasien_id);
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);


    $judul_print = 'Karcis Janji Poliklinik';
    $this->render('printKarcis', array(
      'format' => $format,
      'model' => $model,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
    ));
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
   * method untuk membuat calendar 
   * @param sting $jumlahhari
   * @param string $bulan
   * @param string $tahun
   * @param array $variable
   * @return string berupa grid calender
   */
  protected function createGrid($jumlahhari, $bulan, $tahun, $variable = null)
  {
    $tglMulai = strtotime($tahun . '-' . $bulan . '-' . '01');

    if (!empty($variable['st']) && $variable['st'] == 'ruangan') {
      return $this->renderPartial($this->path_view . "_createGridKlinikV2", array('tglMulai' => $tglMulai, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $jumlahhari, 'variable' => $variable), true);
    } else {
      return $this->renderPartial($this->path_view . "_createGridDokterV2", array('tglMulai' => $tglMulai, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $jumlahhari, 'variable' => $variable), true);
    }
  }

  /**
   * 
   */
  public function actionGetJadwalJanjiPolik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $st = isset($_POST['st']) ? $_POST['st'] : null;

      $data = array(
        'id' => $id,
        'st' => $st
      );

      $mulai = date('Y-m-01');
      $tgl = explode('-', $mulai);
      $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);

      if ($id != null) {
        $grid['tr'] = $this->createGrid($day, $tgl[1], $tgl[0], $data);
      } else {
        $grid['tr'] = array();
      }

      echo json_encode($grid);

      Yii::app()->end();
    }
  }

  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
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

  public function actionSetNoKartu($encode = false, $namaModel = ''){
    if (Yii::app()->request->isAjaxRequest) {
      $nokartu = '';
        $pasien_id = $_POST['PPBuatJanjiPoliT']['pasien_id'];
        // $penjamin_id = $_POST['PPPasienM']['penjamin_id'];
        $modPenjamin = AsuransipasienM::model()->findByAttributes(array('pasien_id' => $pasien_id));
        if(!empty($modPenjamin)){
          if($modPenjamin->carabayar_id == Params::CARABAYAR_ID_BPJS){
            $nokartu = $modPenjamin->nopeserta;
          }
        } else {
          $nokartu = '';
        }
        // var_dump($nokartu);die;
        echo json_encode($nokartu);
        Yii::app()->end();
    }

  }


  public function actionGetKuotaJanjiPoli()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }
    
    $pegawai_id = $_POST['pegawai_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $tanggal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($_POST['tgl'])));

    $kuota = 0;
    $dipakai = 0;
    $sisa = 0;
    $msg = "";
    $is_penuh = 0;
    $no_luarjadwal = 1;

    $peg = PegawaiM::model()->findByPk($pegawai_id);
    $ruangan = RuanganM::model()->findByPk($ruangan_id);

    $jadwals = JadwaldokterM::model()->findAllByAttributes(array(
      'pegawai_id' => $pegawai_id,
      'ruangan_id' => $ruangan_id,
      'jadwaldokter_tgl' => $tanggal
    ));

    $str = '<option value="">-- Pilih --</option>';
    
    $list_jadwal = array();

    foreach ($jadwals as $jadwal) {
      // var_dump($jadwal->attributes); die;
      $no_luarjadwal = 1;

      $kuota += $jadwal->maksbuatjanji;

      $waktu_mulai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl)." ".$jadwal->jadwaldokter_mulai);
      $waktu_selesai = new DateTime(MyFormatteR::formatDateTimeForDb($jadwal->jadwaldokter_tgl)." ".$jadwal->jadwaldokter_tutup);

      $dataJanji = array();
      $dataJadwal = array();
      $arr_waktu = array();

      $period = new DatePeriod(
        $waktu_mulai,
        new DateInterval('PT'.$jadwal->estimasipelayanan.'M'),
        $waktu_selesai
      );

      foreach ($period as $item) {
        $value_awal = $item->format('H:i:s');

        $arr_waktu[] = $tanggal." ".$value_awal;
      }

      $janji_dipakai = BuatjanjipoliT::model()->findAllByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'ruangan_id' => $ruangan_id,
        'tgljadwal' => $arr_waktu,
      ), array(
        'condition'=>'pendaftaran_id is null',
      ));

      $jadwal_dipakai = PendaftaranT::model()->findAllByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'ruangan_id' => $ruangan_id,
        'tgl_pendaftaran' => $arr_waktu,
      ));
    
      foreach ($janji_dipakai as $item) {
        $waktu = date('H:i', strtotime($item->tgljadwal));
        $dataJanji[$waktu] = $item;
      }

      foreach ($jadwal_dipakai as $item) {
        $waktu = date('H:i', strtotime($item->tgl_pendaftaran));
        $dataJadwal[$waktu] = $item;
      }


      

      
      $idx_slot = 1;
      foreach ($period as $idx => $item) {
        $terisi = 0;
        $terisi_jadwal = 0;
        $pasien_id = "";
        $value_awal = $item->format('H:i');
        
        $value_akhir = date('H:i', strtotime($value_awal.":00") + ($jadwal->estimasipelayanan * 60));

        $label = ($idx + 1)." - ".$value_awal." - ".$value_akhir;

        if (!empty($dataJadwal[$value_awal])) {
          $terisi_jadwal = 1;
          $terisi = 1;
          $label .= " -- ".$ruangan->ruangan_singkatan."-".$dataJadwal[$value_awal]->no_urutantri;
          $label .= " -- ".$dataJadwal[$value_awal]->pasien->nama_pasien;
          $pasien_id = $dataJadwal[$value_awal]->pasien->pasien_id;
          $dipakai++;
        } else if (!empty($dataJanji[$value_awal])) {
          $terisi = 1;
          $label .= " -- ".$ruangan->ruangan_singkatan."-".(str_pad($idx + 1, 3, "0", STR_PAD_LEFT));
          $label .= " -- ".$dataJanji[$value_awal]->pasien->nama_pasien;
          $pasien_id = $dataJanji[$value_awal]->pasien->pasien_id;
          $dipakai++;
        }

        $str .= '<option value="'.$value_awal.'" data-terisi="'.$terisi.'" data-terisi-jadwal="'.$terisi_jadwal.'" data-slot="'.($idx_slot).'" data-jadwal="'.$jadwal->jadwaldokter_mulai.'" data-pasien="'.$pasien_id.'" data-item="1">'.$label.'</option>';
  
        $idx_slot++;
        $no_luarjadwal++;
      }

      /*
      $dipakai = BuatjanjipoliT::model()->countByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'ruangan_id' => $ruangan_id,
        'tgljadwal' => $tanggal,
      ));
      */

      $list_jadwal[$jadwal->jadwaldokter_mulai] = date('H:i', strtotime($jadwal->jadwaldokter_mulai))." - ".date('H:i', strtotime(($jadwal->jadwaldokter_tutup)));
      
      
    }
   
    $checkbox_jadwal = CHtml::radioButtonList('ceklis_jadwal', null, $list_jadwal, array(
      'class'=>'ceklis_jadwal', 'uncheckValue'=>'null', 'onclick'=>'setCeklisJadwalDokter()',
    ));
    
    $sisa = $kuota - $dipakai;
    
    /*
    if ($kuota != 0 && $sisa == 0) {
      $is_penuh = 1;
      $msg = "Maaf untuk dokter " . $peg->namaLengkap . " dan ruangan " . $ruangan->ruangan_nama . ", sisa kuota untuk buat janji sudah habis.";
    }
    */
    
    echo CJSON::encode(array(
      'kuota' => $kuota,
      'sisa' => $sisa,
      'slot' => $str,
      'is_penuh' => $is_penuh,
      'msg' => $msg,
      'checkbox_jadwal'=>$checkbox_jadwal,
      'no_luarjadwal'=>$no_luarjadwal,
    ));
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

            if (!empty($pasien_id)) {
                $p = PasienM::model()->findByPk($pasien_id);
                $modAsuransi = AsuransipasienM::model()->findByAttributes(array(
                  'pasien_id' => $pasien_id,
                ));
            } else if (!empty($no_rekam_medik)) {
                //var_dump($no_rekam_medik); die;
                $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
                //var_dump($p->pasien_id); die;
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $p->pasien_id,
                ), array(
                    'condition' => 'pasienbatalperiksa_id is null',
                    'order' => 'pendaftaran_id desc',
                ));
            } 

            $returnVal['lebih'] = false;
            $returnVal['adaDaftar'] = false;
            $returnVal['is_kabur'] = false;
            $pp = null;
            if (!empty($pendaftaran)) {
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;
              
                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

                if (!empty($admisi)) {
                    $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                } else {
                    //var_dump($pendaftaran->attributes);die;
                    switch ($pendaftaran->instalasi_id) {
                        case Params::INSTALASI_ID_RJ:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_MCU:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_HD:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RD:
                            $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RI:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_ICU:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        default:
                            $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                    }
                }
                //die;
            }

            $returnVal['listDaftar']['pasien']['fingerprint_data'] = null;


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
            
            $returnVal["fingerprint_data"] = null;
            $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
            $returnVal['asuransi'] = !empty($modAsuransi)?$modAsuransi->nopeserta :null;
            $returnVal['isPasienLama'] = 1;
            
            // $returnVal['penjamin_id'] = !empty($modAsuransi)?$modAsuransi->penjamin_id :null;
            // $returnVal['carabayar_id'] = !empty($modAsuransi)?$modAsuransi->carabayar_id :null;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionKirimWhatsApp()
    {
      if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        
      
        $model = PPBuatJanjiPoliT::model()->findByPk($_POST['janjipoli']);
        $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
        $profil = ProfilrumahsakitM::model()->find();
        $data = array();
      
            $msg = "
Assalamualaikum.Wr.Wb
Terimakasih telah melakukan Perjanjian di ((nama_rs))
            
((nama_pasien)) memiliki perjanjian dengan No Perjanjian ((no_buatjanji)) untuk tanggal kunjungan ((jgljadwal)) Ke ((ruangan_nama)) - ((nama_pegawai)) dengan Nomor Antrian ((no_antrian))
            
            
*Membawa Surat Rujukan Online dari PPK 1 yang masih berlaku/ RS Tipe C (BPJS)
*Sebelum memasuki rumah sakit Semua pengunjung harus mengisi screening online di link berikut: http://sariasihciputat.com/screening\n 
*Untuk melihat Live Antrian dapat mengunjungi : https://sariasihgroup.com/salive/antrian
            
            
Terimakasih
Syafakumullah
            
Wassalamualaikum.Wr.Wb
";
            $msg = str_replace("((nama_rs))", $profil->nama_rumahsakit, $msg);
            $msg = str_replace("((nama_pasien))", $modPasien->namadepan.$modPasien->nama_pasien, $msg);
            $msg = str_replace("((no_rekam_medik))", $modPasien->no_rekam_medik, $msg);
            $msg = str_replace("((no_buatjanji))", $model->no_buatjanji, $msg);
            $msg = str_replace("((tgljadwal))", MyFormatter::formatDateTimeForUser($model->tgljadwal), $msg);
            $msg = str_replace("((ruangan_nama))", $model->ruangan->ruangan_nama, $msg);
            $msg = str_replace("((nama_pegawai))", $model->pegawai->namaLengkap, $msg);
            $msg = str_replace("((no_antrian))", $model->ruangan->ruangan_singkatan."-".$model->no_antrianjanji, $msg);

            // var_dump($msg."\n", $model->attributes); die;
            // die;
            // var_dump($modPasien->no_mobile_pasien);die;
            if (!empty($modPasien->no_mobile_pasien)) {
                // echo "Kirim: ".$model->no_buatjanji." - ".$modPasien->no_mobile_pasien."\n";
                $wa = new WhatsApp();
                
                $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $msg);
                if ($res){
                  $data['status'] = 'ok';
                } else {
                  $data['status'] = 'gagal';
                }
            }
        echo json_encode($data);
        Yii::app()->end();
      }
    }

}
