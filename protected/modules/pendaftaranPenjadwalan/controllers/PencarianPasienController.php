<?php
Yii::import('rawatJalan.models.*');
Yii::import('pendaftaranPenjadwalan.controllers.*');
Yii::import('rekamMedis.models.*');
Yii::import('rawatDarurat.models.*');
Yii::import('rawatDarurat.views.*');
Yii::import('rawatInap.models.*');
class PencarianPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'cariPasien';
  public $path_view = 'pendaftaranPenjadwalan.views.pencarianPasien.';
  public $path_view_pencarian = 'pendaftaranPenjadwalan.views._periksaDataPasien.';

  public $path_viewRd = 'rawatDarurat.views.asesmenTriage.';

  public function actions()
  {
    return array(
      'myBarcode' => array(
        'class' => 'MyBarcodeAction',
        'canvasWidth' => '300',
        'type' => 'code128',
      ),
    );
  }
  /**
   * digunakan untuk menampilkan detail konsul
   * @param integer $id digunakan untuk kriteria
   */
  public function actionDetailKonsul($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PPPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $this->render(
      $this->path_view_pencarian . '_konsulpoli',
      array(
        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      )
    );
  }

  public function actionCariPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Pencarian Pasien";
    $cek = null;
    $format = new MyFormatter();
    $modProp = PropinsiM::model()->findAll("propinsi_aktif = TRUE ORDER BY propinsi_nama ASC");
    $modKab =  KabupatenM::model()->findAll("kabupaten_aktif = TRUE ORDER BY kabupaten_nama ASC");
    $modKec =  KecamatanM::model()->findAll("kecamatan_aktif = TRUE ORDER BY kecamatan_nama ASC");
    $modKel =  KelurahanM::model()->findAll("kelurahan_aktif = TRUE ORDER BY kelurahan_nama ASC");
    $model = new PPPasienM;
    $model->tgl_rm_awal = date('Y-m-d');
    $model->tgl_rm_akhir = date('Y-m-d');
    $model->tgl_awall = date('Y-m-d');
    // $model->tgl_akhirl = date('Y-m-d');
    $model->ceklis = false;
    $modPendaftaran = new PendaftaranT();
    $modPendaftaran->pasien_id = 0;
    /*
                 * Proses Pencarian
                 */
    if (isset($_GET['PendaftaranT']) && $_GET['ajax'] == 'pencarianlistkunjungan-grid') {
      $modPendaftaran->pasien_id = $_GET['PendaftaranT']['pasien_id'];
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $this->render($this->path_view . '_gridListKunjungan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
      Yii::app()->end();
    }

    if (isset($_GET['PPPasienM'])) {
     
      $model->attributes = $_GET['PPPasienM'];
      $model->ceklis = $_REQUEST['PPPasienM']['ceklis'];
      $model->tgl_rekam_medik = $_REQUEST['PPPasienM']['tgl_rekam_medik'];
      
      $model->tgl_rm_awal  = isset($_REQUEST['PPPasienM']['tgl_rm_awal']) ? $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_awal']) : null;
      $model->tgl_rm_akhir = isset($_REQUEST['PPPasienM']['tgl_rm_akhir']) ? $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_akhir']) : null;
      $model->tanggal_lahir = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tanggal_lahir']);
      // $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_akhirl']);
      $model->diagnosa_kode = isset($_REQUEST['PPPasienM']['diagnosa_kode']) ? $_REQUEST['PPPasienM']['diagnosa_kode'] : null;
      $model->diagnosa_nama = isset($_REQUEST['PPPasienM']['diagnosa_nama']) ? $_REQUEST['PPPasienM']['diagnosa_nama'] : null;
      // var_dump($model->tanggal_lahir);die;
      //                    $model->ceklis = isset($_REQUEST['PPPasienM']['ceklis'])?$_REQUEST['PPPasienM']['ceklis']:0;
      // print_r($model->ceklis);
      // var_dump($model);die;
      // exit();
    }
    // if(isset($_REQUEST['PPPasienM'])){
    //     $model->attributes = $_REQUEST['PPPasienM'];
    //     $model->tgl_rm_awal  = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_awal']);
    //     $model->tgl_rm_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_akhir']);
    //     $model->ceklis = $_REQUEST['PPPasienM']['ceklis'];

    // }


    //                                        $model->tgl_rm_awal = Yii::app()->dateFormatter->formatDateTime(
    //                                                                CDateTimeParser::parse($model->tgl_rm_awal, 'yyyy-MM-dd hh:mm:ss'));
    //                                        $model->tgl_rm_akhir = Yii::app()->dateFormatter->formatDateTime(
    //                                                                CDateTimeParser::parse($model->tgl_rm_akhir, 'yyyy-MM-dd hh:mm:ss'));

    $this->render($this->path_view . 'cariPasien', array(
      'cek' => $cek,
      'model' => $model,
      'modProp' => $modProp,
      'modKab' => $modKab,
      'modKec' => $modKec,
      'modPendaftaran' => $modPendaftaran,
      'modKel' => $modKel,
    ));
  }

  public function actionPrintKartu($id, $umur)
  {
    $this->layout = '//layouts/printWindows';
    $model = PasienM::model()->findByPk($id);
    $this->render($this->path_view . 'printKartu', array('model' => $model, 'umur' => $umur));
  }

  public function actionUbahPasienOld($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $temLogo = $model->photopasien;
    if (isset($_POST['PPPasienM'])) {
      $random = rand(0000000, 9999999);
      $format = new MyFormatter();
      $model->attributes = $_POST['PPPasienM'];
      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        if ($model->save()) {
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);

          //$model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('cariPasien'));
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          //$model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('cariPasien'));
        }
      }
    }
    $this->render($this->path_view . 'ubahPasien', array('model' => $model));
  }

  /**
   * module pendaftaranPenjadwalan/pencarianPasien/ubahPasien&id=1
   * date     : 07-May-2014
   * issue    : EHS-1101
   * desc     : pada saat ubah pasien disamakan dengan yang di aplikasi JK
   * action   : actionUbahPasien($id)
   */
  public function actionUbahPasien($id)
  {
    $model = $this->loadModel($id);
    $modPendaftaran = new PendaftaranT;
    $format = new MyFormatter();
    $temLogo = $model->photopasien;
    $modPegawai = new PPPegawaiM;

    if (!empty($model->pegawai_id)) {
      $modPegawai = PPPegawaiM::model()->findByPk($model->pegawai_id);
    }

    if (isset($_POST['PPPasienM']) && isset($_POST['PendaftaranT'])) {
      $random = rand(0000000, 9999999);
      $model->attributes = $_POST['PPPasienM'];
      $modPendaftaran->attributes = $_POST['PendaftaranT'];

      unset($model->fingerprint_data);


      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      $pendaftaran = array();
      $umurBaru = isset($_POST['PendaftaranT']['umur']) ? $_POST['PendaftaranT']['umur'] : null;
      $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);

      if (isset($_POST['PPPegawaiM'])) {
        $model->pegawai_id = $_POST['PPPegawaiM']['pegawai_id'];
      }

      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        $pendaftaran = PendaftaranT::model()->findAllByAttributes(array('pasien_id' => $id), array('order' => 'pendaftaran_id desc'));

        if ($model->save()) {
          if (count((array)$pendaftaran) > 0) {
            PendaftaranT::model()->updateByPk($pendaftaran[0]->pendaftaran_id, array('umur' => $umurBaru));
          }
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);

          //                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('cariPasien'));
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          //                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          if (count((array)$pendaftaran) > 0) {
            PendaftaranT::model()->updateByPk($pendaftaran[0]->pendaftaran_id, array('umur' => $umurBaru));
          }


          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('cariPasien'));
        }
      }
    }
    $model->tanggal_lahir = date('d/m/Y', strtotime($model->tanggal_lahir));
    $this->render($this->path_view . 'ubahPasien', array('format' => $format, 'model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPegawai' => $modPegawai));
  }

  public function actionUbahPenanggungJawab($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    /*
                                 * GET penanggungjawab_id berdasarkan no_rekam_medik dari tabel pendaftaran_t
                                 */
    $model = PenanggungjawabM::model()->findByPk($id);
    if (isset($_POST['PenanggungjawabM'])) {
      $model->attributes = $_POST['PenanggungjawabM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('cariPasien'));
      }
    }
    $this->render($this->path_view . 'ubahPenanggungJawab', array('model' => $model));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model =  PPPasienM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionRiwayatKunjungan($pasien_id = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = new PPPendaftaranT();
    $modPendaftaran->pasien_id = $pasien_id;
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $this->render($this->path_view . '_gridListKunjungan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
  }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
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


  public function actionAutocompleteNobadge()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
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
        $returnVal[$i]['value'] = $model->pegawai->nomorindukpegawai;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionSetNobadge()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nip = null;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $models = PPPegawaiM::model()->findByPk($pegawai_id);
      if (!empty($models)) {
        $nip = $models->nomorindukpegawai;
      }
      echo CJSON::encode($nip);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }


  public function actionNonAktifPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['id'])) {
        PasienM::model()->updateByPk($_POST['id'], array(
          'statusrekammedis' =>  Params::STATUSREKAMMEDIS_NON_AKTIF,
        ));
      }
    }
    Yii::app()->end();
  }


  public function actionDetailHasilRehab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
    $this->render(
      'rawatJalan.views._periksaDataPasien.detailHasilRehab',
      array(
        'masukpenunjang' => $modPasienMasukPenunjang,
        'judulLaporan' => $judulLaporan,
        'detailHasil' => $detailHasil,
      )
    );
  }

  public function actionDetailHasilGizi($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $model = AsesmengiziT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ), array(
      'order' => 'tgl_konsultasi desc',
    ));
    $this->render('rawatJalan.views._periksaDataPasien.detailHasilGizi', array(
      'model' => $model,
    ));
  }

  public function actionDetailOperasi($id)
  {
    $this->layout = '//layouts/iframe';
    $rencana = RencanaoperasiT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'tglrencanaoperasi asc',
    ));

    if (count((array)$rencana) == 0) {
      echo "Data tidak ditemukan";
      Yii::app()->end();
    }

    $penunjang = array();
    foreach ($rencana as $item) {
      $idp = $item->pasienmasukpenunjang_id;
      if (empty($penunjang[$idp])) {
        $penunjang_data = PasienmasukpenunjangV::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $idp
        ));
        $penunjang[$idp] = array(
          'data' => $penunjang_data,
          'rencana' => array(),
        );
      }

      $penunjang[$idp]['rencana'][] = $item;
    }

    $this->render('rawatJalan.views._periksaDataPasien._operasi2', array(
      'penunjang' => $penunjang,
    ));
  }

  public function actionDetailSuratKeteranganKematian($suratketerangan_id)
  {
    $this->layout = '//layouts/iframe';
    $model = SuratketeranganR::model()->findByPk($suratketerangan_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienPulang = PasienpulangT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));

    $this->render(
      'pemulasaranJenazah.views.suratKeterangan.printSuratMeninggal',
      array(
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modPasienPulang' => $modPasienPulang
      )
    );
  }


  public function actionDetailHasilLab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $modKunjungan = RJPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $criteria = new CDbCriteria();
    $criteria->join = "
							JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
							JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
							JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);
    $this->render('rawatInap.views.riwayatPasien.detailHasilLab', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
    ));
  }

  /**
   * actionDetailHasilRad = menampilkan hasil radiologi sesuai dengan rad
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   * @param type $caraPrint
   */
  public function actionDetailHasilRad($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = RJPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $this->render('rawatInap.views.riwayatPasien.detailHasilRad', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'caraPrint' => $caraPrint,
    ));
  }

  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTindakan = RKTindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new RKTindakanpelayananT('search');
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }




  public function actionGetRiwayatPasien($id)
  {
    //$this->layout='//layouts/iframe';
    $criteria = new CDbCriteria;
    if (!empty($id)) {
      $criteria->addCondition("t.pasien_id = " . $id);
    }

    $pages = null; /*new CPagination(RKPendaftaranT::model()->count($criteria));
           $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
            $pages->applyLimit($criteria);
			*/
    $modPasien = PasienM::model()->findByPk($id);

    $modKunjungan = RKPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);


    $this->render('pendaftaranPenjadwalan.views._periksaDataPasien/_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
      'modPasien' => $modPasien,
    ));
  }

  public function actionPrint($id)
  {
    //$this->layout='//layouts/iframe';

    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modDetailHasilLab = DetailhasilpemeriksaanlabT::model()->with('pemeriksaanlab')->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilLab->hasilpemeriksaanlab_id));
    $modDetailHasil = new DetailhasilpemeriksaanlabT();
    $format = new MyFormatter;
    $modHasilLab->tglhasilpemeriksaanlab = $format->formatDateTimeId($modHasilLab->tglhasilpemeriksaanlab);

    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);

    $judulLaporan = 'Laporan Data Hasil Pemeriksaan Lab';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  /**
   * actionDetailPersalinan = menampilkan detail riwayat persalinan pasien
   * RSN-289
   */
  public function actionDetailPersalinan($pendaftaran_id)
  {
    $id = $pendaftaran_id;
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $modPemeriksaan = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'create_ruangan' => Params::RUANGAN_ID_VK), array(
      'order' => 'pemeriksaanfisik_id asc',
    ));

    $systolic = null;
    $diastolic = null;
    foreach ($modPemeriksaan as $cari) {
      $systolic = isset($cari->kala4_systolic) ? $cari->kala4_systolic : null;
      $diastolic = isset($cari->kala4_diastolic) ? $cari->kala4_diastolic : null;
    }

    $criteria2 = new CDbCriteria();
    $criteria2->select = 'max(systolic_min) as sys_max';
    $modSys = SysdiaM::model()->find($criteria2);
    $criteria3 = new CDbCriteria();
    $criteria3->select = 'max(diastolic_min) as dias_max';
    $modDia = SysdiaM::model()->find($criteria3);

    $criteria = new CDbCriteria();

    if (($systolic == null) && ($diastolic == null)) {
      $tekanandarah_text = null;
    } else {
      if ($systolic > $modSys->sys_max) {
        $criteria->condition = 'systolic_min <= ' . $systolic . ' and systolic_max = 0';
      } else {
        $criteria->addCondition($systolic . ' >= systolic_min');
        $criteria->addCondition($systolic . ' <= systolic_max');
      }

      if ($diastolic > $modDia->dias_max) {
        $criteria->condition = 'diastolic_min <= ' . $diastolic . ' and diastolic_max = 0';
      } else {
        $criteria->addCondition($diastolic . ' >= diastolic_min');
        $criteria->addCondition($diastolic . ' <= diastolic_max');
      }

      $modSysDia = SysdiaM::model()->find($criteria);
      $tekanandarah_text = "-"; //$modSysDia->sysdia_nama;
    }





    $format = new MyFormatter;
    $modPersalinanSearch = new PersalinanT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);

    $crFisik = new CDbCriteria();
    $crFisik->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crFisik->compare('pendaftaran_id', $pendaftaran_id);
    $crFisik->compare('r.instalasi_id', Params::INSTALASI_ID_PERSALINAN);
    $crFisik->order = "t.pemeriksaanfisik_id asc";
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAll($crFisik);


    $crReseptur = new CDbCriteria();
    $crReseptur->join = "join ruangan_m r on r.ruangan_id = t.ruanganreseptur_id";
    $crReseptur->compare('pendaftaran_id', $pendaftaran_id);
    $crReseptur->compare('r.instalasi_id', Params::INSTALASI_ID_PERSALINAN);
    $crReseptur->order = "t.reseptur_id desc";
    $maxtime = RJResepturT::model()->findAll($crReseptur);
    $modDetailResep = array();

    $crAnamnesa = new CDbCriteria();
    $crAnamnesa->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crAnamnesa->compare('pendaftaran_id', $pendaftaran_id);
    $crAnamnesa->compare('r.instalasi_id', Params::INSTALASI_ID_PERSALINAN);
    $crAnamnesa->order = "t.anamesa_id asc";
    $modAnamnesa = AnamnesaT::model()->findAll($crAnamnesa);




    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._persalinan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPersalinan' => $modPersalinan,
        'modPemeriksaan' => $modPemeriksaan,
        'tekananDarahText' => $tekanandarah_text,
        'modPersalinanSearch' => $modPersalinanSearch,
        'modPasien' => $modPasien,
        'modAnamnesa' => $modAnamnesa,
        'modDetailResep' => $modDetailResep,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'format' => new MyFormatter,
        'judulLaporan' => '',
        //                    'modPemeriksaanGambar'=>$modPemeriksaanGambar,
        //                    'modGambarTubuh'=>$modGambarTubuh,
        //                    'modBagianTubuh'=>$modBagianTubuh,
        'modReseptur' => $maxtime,
      )
    );
  }



  public function actionDetailPersalinanPelayanan($pendaftaran_id)
  {

    Yii::import("rawatJalan.controllers.DaftarPasienController");


    $id = $pendaftaran_id;

    $con = new DaftarPasienController("pencarianPasien", $this->module);
    $con->actionDetailPersalinan($id);
  }


  public function actionPrintDetailPartograf($id)
  {

    Yii::import("rawatJalan.controllers.DaftarPasienController");

    $con = new DaftarPasienController("pencarianPasien", $this->module);
    $con->actionPrintDetailPartograf($id);
  }

  public function actionPrintDetailPartografBelakang($id)
  {

    Yii::import("rawatJalan.controllers.DaftarPasienController");

    $con = new DaftarPasienController("pencarianPasien", $this->module);
    $con->actionPrintDetailPartografBelakang($id);
  }

  /*awal detail riwayat pemeriksaan ginekologi        
         */
  public function actionDetailGinekologi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modGinekologi = PemeriksaanginekologiT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $ginekologi_id = PemeriksaanginekologiT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (!empty($ginekologi_id)) {
      $modRiwayatKelahiran = RiwayatkehamilanT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $ginekologi_id->pemeriksaanginekologi_id));
    } else {
      $modRiwayatKelahiran = array();
    }

    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._persalinan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modGinekologi' => $modGinekologi,
        'modRiwayatKelahiran' => $modRiwayatKelahiran,
        'modPasien' => $modPasien
      )
    );
  }

  /*akhir detail riwayat pemeriksaan ginekologi*/


  /**
   * actionDetailKelahiran = menampilkan detail riwayat kelahiran bayi pasien
   * RSN-289
   */
  public function actionDetailKelahiran($id)
  {
    Yii::import("rawatJalan.controllers.DaftarPasienController");


    $con = new DaftarPasienController("pencarianPasien", $this->module);
    $con->actionDetailKelahiran($id);
  }

  public function actionDetailAnamnesa($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modAnamnesaSearch = new RJAnamnesaT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._anamnesa',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modAnamnesa' => $modAnamnesa,
        'modAnamnesaSearch' => $modAnamnesaSearch,
        'modPasien' => $modPasien
      )
    );
  }

  /**
   * actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_Periksa Fisik untuk riwayat pasien
   * RND-4100 
   */
  public function actionDetailPeriksaFisik($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._periksafisik',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'modPemeriksaanFisikSearch' => $modPemeriksaanFisikSearch,
        'modPasien' => $modPasien,
        'modPemeriksaanGambar' => $modPemeriksaanGambar
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $penjualan = PenjualanresepT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglpenjualan DESC'));

    $prereseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglreseptur DESC'));

    $reseptur = array();

    foreach ($prereseptur as $item) {
      $item->tglreseptur = MyFormatter::formatDateTimeForDb($item->tglreseptur);
      foreach ($penjualan as $item2) {
        if ($item->reseptur_id == $item2->reseptur_id || $item->penjualanresep_id == $item2->penjualanresep_id) {
          continue;
        }
      }
      array_push($reseptur, $item);
    }



    $checkers = array();

    foreach ($reseptur as $item) {
      $checkers[$item->tglreseptur] = array(
        'tipe' => 1,
        'noresep' => $item->noresep,
        'id' => $item->reseptur_id,
      );
    }



    foreach ($penjualan as $item) {
      $checkers[$item->tglresep] = array(
        'tipe' => 2,
        'noresep' => $item->noresep,
        'id' => $item->penjualanresep_id,
      );
    }

    //echo "<pre>";
    //var_dump($checkers);
    //echo "</pre>";
    //die;

    //ksort($checkers);

    //var_dump(count((array)$checkers));die;
    $modDetailTerapi = new RJObatalkesPasienT;
    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'checkers' => $checkers,
        'modDetailTerapi' => $modDetailTerapi
      )
    );

    /*
            //$modTerapi = RJPenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id'=>$id));
            //$modTerapi = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            //$modDetailTerapi = new RJResepturDetailT('searchDetailTerapi');
            $modDetailTerapi = new RJObatalkesPasienT;
            $format = new MyFormatter;
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_terapi', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTerapi'=>$modTerapi,
                        'modDetailTerapi'=>$modDetailTerapi,
                        'modPasien'=>$modPasien));
             * 
             */
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new RJObatalkesPasienT;
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'pendaftaranPenjadwalan.views._periksaDataPasien._pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
  }

  //untuk riwayat RD
  public function actionDetailRd($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
    $modTriase = Triase::model()->findAllByAttributes(array('triase_aktif' => TRUE), array('order' => 'triase_urutan ASC'));
    $modLookup = LookupM::model()->findAllByAttributes(array('lookup_aktif' => TRUE, 'lookup_type' => 'triase_pemeriksaan'), array('order' => 'lookup_urutan ASC'));
    $dataTriase = array();
    $cekTriase = array();

    $dataFlaCcs = array();
    $cekFlaCcs = array();

    $criFla = new CDbCriteria();
    $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
    $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
    $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
    $modNyeriFlaCcs = RDSkalanyeriflaccsM::model()->findAll($criFla);

    $getFlaCcs = null;

    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $crFisik = new CDbCriteria();
    $crFisik->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crFisik->compare('pendaftaran_id', $pendaftaran_id);
    $crFisik->compare('r.instalasi_id', Params::INSTALASI_ID_RD);
    $crFisik->order = "t.pemeriksaanfisik_id desc";

    $modFisik = null;
    $modFisikDelta = RJPemeriksaanFisikT::model()->findAll($crFisik);

    foreach ($modFisikDelta as $item) {
      $flaccs = RDAsesmennyeriflaccsT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $item->pemeriksaanfisik_id));

      if (count((array)$flaccs) > 0 || !empty($item->skala_wongbaker_nrs)) {
        $modFisik = $item;
      }
    }


    if (empty($modFisik)) {
      $modFisik = new RJPemeriksaanFisikT;
      $modFlaCcs = new RDAsesmennyeriflaccsT;
    } else {

      if ($modFisik->keluhan_nyeri == true || $modFisik->keluhan_nyeri == false) {
        $modFisik->keluhan_nyeri = ($modFisik->keluhan_nyeri == TRUE) ? 1 : 0;
      }
      if ($modFisik->rasanyeri_berpindah == true || $modFisik->rasanyeri_berpindah == false) {
        $modFisik->rasanyeri_berpindah = ($modFisik->rasanyeri_berpindah == TRUE) ? 1 : 0;
      }
      $modFlaCcs = new RDAsesmennyeriflaccsT;
      $getFlaCcs = RDAsesmennyeriflaccsT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modFisik->pemeriksaanfisik_id));

      if (count((array)$getFlaCcs) > 0)
        foreach ($getFlaCcs as $det) {
          $cekFlaCcs["$det->skalanyeriflaccs_id"] = $det->skalanyeriflaccs_id;
        }
    }

    $getTriase = null;

    $modAsesTriase = RDAsesmentriaseT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
    if (!empty($modAsesTriase)) {

      $getTriase = RDAsesmentriasedetT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));

      foreach ($getTriase as $det) {
        $cekTriase["$det->triase_id"] = $det->triase_id;
      }

      $modAsesTriDet = new RDAsesmentriasedetT;


      $modTriPeg = RDAsesmentriasepegT::model()->findAllByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));
      if (count((array)$modTriPeg) <= 0) {
        $modTriPeg = new RDAsesmentriasepegT;
      }

      if ($modAsesTriase->istrauma) {
        $modAsesTriase->trauma = true;
        $modAsesTriase->nontrauma = false;
      } else {
        $modAsesTriase->trauma = false;
        $modAsesTriase->nontrauma = true;
      }
    } else {
      $modAsesTriase = new RDAsesmentriaseT;
      $modAsesTriase->tglasesmentriase = date('d M Y');
      $modAsesTriase->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modAsesTriase->pasien_id = $modPendaftaran->pasien_id;


      $modAsesTriDet = new RDAsesmentriasedetT;

      $modTriPeg = new RDAsesmentriasepegT;
    }

    foreach ($modTriase as $dt) {
      $dt->warna_triase = strtolower($dt->warna_triase);
      $dataTriase["$dt->triase_pemeriksaan"]["$dt->warna_triase"][] = array(
        'triase_id' => $dt->triase_id,
        'keterangan_triase' => $dt->keterangan_triase,
        'value' => isset($cekTriase["$dt->triase_id"]) ? $cekTriase["$dt->triase_id"] : null,
      );
    }

    foreach ($modNyeriFlaCcs as $dtF) {
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
        'id' => $dtF->skalanyeriflaccs_id,
        'keterangan' => $dtF->skalanyeriflaccs_desc,
        'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $cekFlaCcs["$dtF->skalanyeriflaccs_id"] : null,
      );
    }

    $model = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    if (empty($model)) {
      $model = new AsesmenpasienigdT();
      $edukasi = array();
    } else {
      $edukasi = CHtml::listData(AsesmenedukasipasienT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      )), 'edukasipasien', 'edukasipasien');
      $model->edukasipasien = $edukasi;
      $model->masalah = CHtml::listData(AsesmenmasalahkepT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      )), 'masalahkeperawatan_id', 'asesmenmasalahkep_id');
      $model->tindakan = CHtml::listData(AsesmentindakankepT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      )), 'tindakankeperawatan_id', 'asesmentindakankep_id');
    }

    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
    $masalahKeperawatan = $this->getMasalahKeperawatan();


    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->find($crFisik);

    if (empty($modPemeriksaanFisik)) {
      $modPemeriksaanFisik = new RJPemeriksaanFisikT;
      $modPemeriksaanGambar = array();
    } else {
      $modPemeriksaanGambar = PemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
      if (empty($modPemeriksaanGambar)) {
        $modPemeriksaanGambar = array();
      }
    }

    $modGambarTubuh = new RJGambartubuhM();
    $modBagianTubuh = new RJBagiantubuhM();
    if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
      $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
    }

    $crReseptur = new CDbCriteria();
    $crReseptur->join = "join ruangan_m r on r.ruangan_id = t.ruanganreseptur_id";
    $crReseptur->compare('pendaftaran_id', $pendaftaran_id);
    $crReseptur->compare('r.instalasi_id', Params::INSTALASI_ID_RD);
    $crReseptur->order = "t.reseptur_id desc";
    $maxtime = RJResepturT::model()->findAll($crReseptur);
    $modDetailResep = array();

    $crAnamnesa = new CDbCriteria();
    $crAnamnesa->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crAnamnesa->compare('pendaftaran_id', $pendaftaran_id);
    $crAnamnesa->compare('r.instalasi_id', Params::INSTALASI_ID_RD);
    $crAnamnesa->order = "t.anamesa_id asc";
    $modAnamnesa = AnamnesaT::model()->findAll($crAnamnesa);

    if (empty($modAnamnesa)) {
      $modAnamnesa = array();
    }

    $judul_print = 'ASESMEN PASIEN IGD';
    $this->render('pendaftaranPenjadwalan.views._periksaDataPasien._detailRd', array(
      'format' => $format,
      'dataTriase' => $dataTriase,
      'modFisik' => $modFisik,
      'modAsesTriase' => $modAsesTriase,
      'modAsesTriDet' => $modAsesTriDet,
      'getTriase' => $getTriase,
      'modTriPeg' => $modTriPeg,
      'judulLaporan' => $judul_print,
      'modLookup' => $modLookup,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'getFlaCcs' => $getFlaCcs,
      'dataFlaCcs' => $dataFlaCcs,
      'modFlaCcs' => $modFlaCcs,
      'modPendaftaran' => $modPendaftaran,
      'model' => $model,
      'pasien' => $pasien,
      'masalahKeperawatan' => $masalahKeperawatan,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modGambarTubuh' => $modGambarTubuh,
      'modBagianTubuh' => $modBagianTubuh,
      "modDetailResep" => $modDetailResep,
      'modReseptur' => $maxtime,
      'modAnamnesa' => $modAnamnesa,
    ));
  }


  //untuk riwayat RJ
  public function actionDetailRj($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);


    $crAnamnesa = new CDbCriteria();
    $crAnamnesa->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crAnamnesa->compare('pendaftaran_id', $pendaftaran_id);
    $crAnamnesa->compare('r.instalasi_id', array(Params::INSTALASI_ID_RJ));
    $crAnamnesa->order = "t.anamesa_id asc";
    $modAnamnesa = RJAnamnesaT::model()->findAll($crAnamnesa);

    $crFisik = new CDbCriteria();
    $crFisik->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crFisik->compare('pendaftaran_id', $pendaftaran_id);
    $crFisik->compare('r.instalasi_id', Params::INSTALASI_ID_RJ);
    $crFisik->order = "t.pemeriksaanfisik_id desc";
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->find($crFisik);


    if (empty($modPemeriksaanFisik)) {
      $modPemeriksaanFisik = new RJPemeriksaanFisikT;
      $modPemeriksaanGambar = array();
    } else {
      $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
      if (empty($modPemeriksaanGambar)) {
        $modPemeriksaanGambar = array();
      }
    }

    $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modGambarTubuh = new RJGambartubuhM();
    $modBagianTubuh = new RJBagiantubuhM();

    if (empty($modPemeriksaanFisik)) {
      $modPemeriksaanFisik = new RJPemeriksaanFisikT;
    }
    if (empty($modPemeriksaanGambar)) {
      $modPemeriksaanGambar = array();
    }

    if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
      $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
    }

    $maxtime = RJResepturT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (empty($maxtime)) {
      $maxtime = new RJResepturT;
      $modDetailResep = array();
    } else {
      $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
    }


    $judul_print = 'ANAMNESIS';
    $this->render('pendaftaranPenjadwalan.views._periksaDataPasien._detailRj', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modGambarTubuh' => $modGambarTubuh,
      'modBagianTubuh' => $modBagianTubuh,
      "modDetailResep" => $modDetailResep,
      'modReseptur' => $maxtime
    ));
  }

  //untuk riwayat RI
  public function actionDetailRi($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $crAnamnesa = new CDbCriteria();
    $crAnamnesa->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crAnamnesa->compare('pendaftaran_id', $pendaftaran_id);
    $crAnamnesa->compare('r.instalasi_id', array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF));
    $crAnamnesa->order = "t.anamesa_id asc";
    $modAnamnesa = RIAnamnesaT::model()->findAll($crAnamnesa);


    $crFisik = new CDbCriteria();
    $crFisik->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
    $crFisik->compare('pendaftaran_id', $pendaftaran_id);
    $crFisik->compare('r.instalasi_id', array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF));
    $crFisik->order = "t.pemeriksaanfisik_id asc";
    $modPemeriksaanFisik = RIPemeriksaanFisikT::model()->findAll($crFisik);




    $crReseptur = new CDbCriteria();
    $crReseptur->join = "join ruangan_m r on r.ruangan_id = t.ruanganreseptur_id";
    $crReseptur->compare('pendaftaran_id', $pendaftaran_id);
    $crReseptur->compare('r.instalasi_id', array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF));
    $crReseptur->order = "t.reseptur_id desc";
    $maxtime = RJResepturT::model()->findAll($crReseptur);
    $modDetailResep = array();

    $judul_print = 'ANAMNESIS';
    $this->render('pendaftaranPenjadwalan.views._periksaDataPasien._detailRi', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      //                        'hasil'=>$hasil,
      'modPemeriksaanFisiks' => $modPemeriksaanFisik,
      //                        'modPemeriksaanGambar' => $modPemeriksaanGambar,
      //                        'modGambarTubuh' => $modGambarTubuh,
      //                        'modBagianTubuh'=>$modBagianTubuh,
      "modDetailResep" => $modDetailResep,
      'modReseptur' => $maxtime
    ));
  }

  function getMasalahKeperawatan()
  {
    $arr = array();
    $masalah = MasalahkeperawatanM::model()->findAll('masalahkeperawatan_aktif = true order by masalahkeperawatan_grup_order');
    $tindakan = TindakankeperawatanM::model()->findAll('tindakankeperawatan_aktif = true order by tindakankeperawatan_grup_order, tindakankeperawatan_order');

    foreach ($masalah as $item) {
      if (empty($arr[$item->masalahkeperawatan_grup_order])) {
        $arr[$item->masalahkeperawatan_grup_order] = array(
          'masalah' => array(),
          'tindakan' => array(),
        );
      }

      array_push($arr[$item->masalahkeperawatan_grup_order]['masalah'], $item->attributes);
    }

    foreach ($tindakan as $item) {
      array_push($arr[$item->tindakankeperawatan_grup_order]['tindakan'], $item->attributes);
    }

    return $arr;
  }

  public function actionGetRiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_GET['pasien_id'];
      $page = $_GET['page'];
      if (empty($page)) {
        $page = 1;
      }
      //$modPendaftaran=RKPendaftaranT::model()->findByPk($pendaftaran_id);

      $modPasien = PasienM::model()->findByPk($pasien_id);
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('pendaftaranPenjadwalan.views._periksaDataPasien._riwayatPasien', array('modPasien' => $modPasien, 'page' => $page), true)
      ));
      exit;
    }
  }


  public function actionDetailPersetujuanTindakan($id, $suratpersetujuantm_id = null)
  {
    $this->layout = '//layouts/iframe';

    $modSuratPersetujuan = null;
    if (!empty(@$_GET['suratpersetujuantm_id'])) {
      $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($_GET['suratpersetujuantm_id']);
      if (empty($modSuratPersetujuan)) {
        throw new CHttpException(404, "Surat Persetujuan tidak ditemukan");
      }
    }

    $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $format = new MyFormatter;

    $this->render($this->path_view_pencarian . '_persetujuanTindakan', array(
      //			'modKunjungan'=>$modKunjungan,
      'modSuratPersetujuan' => $modSuratPersetujuan,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'format' => $format,
      'data' => $data,
      'pendaftaran_id' => $id,
    ));
  }

  public function actionDetailInformConsent($id, $suratpersetujuantm_id = null)
  {
    $this->layout = '//layouts/iframe';

    $modSuratPersetujuan = null;
    if (!empty(@$_GET['suratpersetujuantm_id'])) {
      $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($_GET['suratpersetujuantm_id']);
      if (empty($modSuratPersetujuan)) {
        throw new CHttpException(404, "Surat Persetujuan tidak ditemukan");
      }
    }

    $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $format = new MyFormatter;

    $this->render($this->path_view_pencarian . '_informConsent', array(
      //			'modKunjungan'=>$modKunjungan,
      'modSuratPersetujuan' => $modSuratPersetujuan,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'format' => $format,
      'data' => $data,
      'pendaftaran_id' => $id,
    ));
  }


  public function actionDetailTindakanAnestesi($id, $persetujuananestesi_id = null)
  {
    $modSuratPersetujuan = null;
    $this->layout = '//layouts/iframe';
    if (!empty(@$_GET['persetujuananestesi_id'])) {
      $modSuratPersetujuan = PersetujuananestesiT::model()->findByPk($_GET['persetujuananestesi_id']);
      if (empty($modSuratPersetujuan)) {
        throw new CHttpException(404, "Surat Persetujuan tidak ditemukan");
      }
    }

    $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $format = new MyFormatter;

    $this->render($this->path_view_pencarian . '_tindakanAnestesi', array(
      //			'modKunjungan'=>$modKunjungan,
      'modSuratPersetujuan' => $modSuratPersetujuan,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'format' => $format,
      'data' => $data,
      'pendaftaran_id' => $id,
    ));
  }

  public function actionDetailGeneralConsent($pendaftaran_id)
  {
    $con = new SuratPersetujuanUmumController("pencarianPasien", $this->module);
    $con->actionView($pendaftaran_id);
  }


  public function actionRiwayatDokfilerm($pasien_id)
  {
    $this->layout = '//layouts/iframe';
    // $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id ='. $pasien_id);
    $modDokfilerms = DokfilermR::model()->findAll($crit);
    // $modDokfilerms =[];
    // foreach ($modDokfilerm as $dok) {
    //     if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
    //         $modDokfilerms[]=$dok; 
    //     }
    // }
    $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms));
  }
  public function actionDetailScanRM($dokfilerm_id) {
    $this->layout = '//layouts/iframe';
    
    $file = DokfilermR::model()->findByPk($dokfilerm_id);
           
    $this->render("detail", array(
      'file'=>$file,
  ));
}
}
