<?php

class PengambilanGambarPasienController extends MyAuthController
{
  protected $path_view = 'rawatJalan.views.pengambilanGambarPasien.';

  public function actionIndex($pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new RJInfokunjunganrjV();
    $model = new RJPhotopemeriksaanT();
    $judulphoto = '';
    if (!empty($pendaftaran_id)) {
      $loadKunjungan = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($loadKunjungan)) {
        $modKunjungan = $loadKunjungan;
      }
      $model = RJPhotopemeriksaanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($model)) {
        $judulphoto = $model->judulphotopemeriksaan;
      } else {
        $model = new RJPhotopemeriksaanT();
        $judulphoto = '';
      }
    }
    $this->render('index', array(
      'model' => $model,
      'modKunjungan' => $modKunjungan,
      'judulphoto' => $judulphoto,
    ));
  }

  public function actionGallery()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJPhotopemeriksaanT();

    $this->render('gallery', array('model' => $model));
  }
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = RJInfokunjunganrjV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopasien)) {
          $photopasien = Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopasien;
        } else {
          $photopasien =  Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg';
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['photopasien'] = $photopasien;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = $this->loadModKunjungan($_POST['pendaftaran_id']);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopasien)) {
        $photopasien = Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopasien;
      } else {
        $photopasien =  Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg';
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["photopasien"] = $photopasien;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * @param type $pendaftaran_id
   * @return RJInfokunjunganrjV
   */
  public function loadModKunjungan($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
    $model = RJInfokunjunganrjV::model()->find($criteria);
    return $model;
  }

  /**
   * Method to handle file upload thought XHR2
   * On success returns JSON object with image info.
   * @param $gallery_id string Gallery Id to upload images
   * @throws CHttpException
   */
  public function actionAjaxUpload($pendaftaran_id = null)
  {
    //        if(Yii::app()->request->isAjaxRequest) { 
    //        header("Content-Type: application/json");
    $photopemeriksaan_id = "";
    $nourut = "";
    $judulphotopemeriksaan = "";
    $keteranganphoto = "";
    $preview = "";
    $date = date('Y-m-d');

    $pendaftaran_id =  isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
    $webcam = isset($_GET['image']) ? $_GET['image'] : "";

    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $criteria->compare('DATE(tglphotopemeriksaan)', $date);
    $criteria->addCondition('tampildigalery is false');
    //            $modPhotoPemeriksaan = RJPhotopemeriksaanT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
    $modPhotoPemeriksaan = RJPhotopemeriksaanT::model()->findAll($criteria);

    $nourut =  count((array)$modPhotoPemeriksaan);
    if (count((array)$modPhotoPemeriksaan) == 0) {
      $nourut = 1;
    } else {
      $nourut = $nourut + 1;
    }

    $model = new RJPhotopemeriksaanT();
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $model->pasien_id = $modPendaftaran->pasien_id;
    $model->pasienadmisi_id = null;
    $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $model->tglphotopemeriksaan = date('Y-m-d H:i:s');
    $model->nourut = $nourut;
    $model->judulphotopemeriksaan = $modPendaftaran->pasien->nama_pasien . "-" . $modPendaftaran->no_pendaftaran;
    $model->keteranganphoto = $modPendaftaran->pasien->nama_pasien . "-" . $modPendaftaran->no_pendaftaran;
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    //            $imageFile = $image;
    if (empty($webcam)) {
      $imageFile = CUploadedFile::getInstanceByName('image');

      $gambar = $imageFile;
      $random = rand(000000, 999999);
      if (!empty($imageFile)) //Klo User Memasukan Logo
      {
        $model->pathphoto = $random . $imageFile;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->pathphoto;
        $fullImgSource = Params::pathPemeriksaanPasienPhotosDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPemeriksaanPasienThumbsDirectory() . 'kecil_' . $fullImgName;
      }
    } else {
      $model->pathphoto = $webcam;
    }
    $model->validate();
    // var_dump($model->errors); die;
    if ($model->validate()) {
      if ($model->save()) {
        if (empty($webcam)) {
          if (!empty($model->pathphoto)) {
            $gambar->saveAs($fullImgSource);

            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          }
        }

        $photopemeriksaan_id = $model->photopemeriksaan_id;
        $nourut = $model->nourut;
        $judulphotopemeriksaan = (string)$model->judulphotopemeriksaan;
        $keteranganphoto = (string)$model->keteranganphoto;
        $preview = $model->getPreview($model->pathphoto);
      }
    }
    $data['photopemeriksaan_id'] = $photopemeriksaan_id;
    $data['nourut'] = $nourut;
    $data['judulphotopemeriksaan'] = $judulphotopemeriksaan;
    $data['keteranganphoto'] = $keteranganphoto;
    $data['preview'] = $preview;
    echo CJSON::encode($data);
    Yii::app()->end();
  }

  /**
   * Removes image with ids specified in post request.
   * On success returns 'OK'
   */
  public function actionDelete()
  {
    $id = array();
    $id = $_POST['id'];
    /** @var $photos GalleryPhoto[] */
    if (count((array)$id) > 1) {
      $criteria = new CDbCriteria();
      $criteria->addInCondition('photopemeriksaan_id', $id);

      $photos = RJPhotopemeriksaanT::model()->findAll($criteria);
      foreach ($photos as $i => $photo) {
        $delete = RJPhotopemeriksaanT::model()->deleteByPk($photo->photopemeriksaan_id);
      }
    } else {
      $photos = RJPhotopemeriksaanT::model()->findByPk($id);
      $delete = RJPhotopemeriksaanT::model()->deleteByPk($id);
    }

    if ($delete) {
      echo 'OK';
    } else {
      throw new CHttpException(400, 'Photo, not found');
    }
  }

  /**
   * Saves images order according to request.
   * Variable $_POST['order'] - new arrange of image ids, to be saved
   * @throws CHttpException
   */
  public function actionOrder()
  {
    if (!isset($_POST['order'])) throw new CHttpException(400, 'No. data, to save');
    $gp = $_POST['order'];
    $orders = array();
    $i = 0;
    foreach ($gp as $k => $v) {
      if (!$v) $gp[$k] = $k;
      $orders[] = $gp[$k];
      $i++;
    }
    sort($orders);
    $i = 0;
    $res = array();
    foreach ($gp as $k => $v) {
      /** @var $p GalleryPhoto */
      $p = RJPhotopemeriksaanT::model()->findByPk($k);
      $p->nourut = $orders[$i];
      $res[$k] = $orders[$i];
      $p->save(false);
      $i++;
    }

    echo CJSON::encode($res);
  }

  public function actionUpdatePhoto()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $pendaftaran_id = $_POST['pendaftaran_id'];
      $photopemeriksaan_id = $_POST['photopemeriksaan_id'];
      $judulphoto = $_POST['judulphoto'];
      $keteranganphoto = $_POST['keteranganphoto'];

      $model = RJPhotopemeriksaanT::model()->findByPk($photopemeriksaan_id);
      $update = RJPhotopemeriksaanT::model()->updateByPk($photopemeriksaan_id, array(
        'judulphotopemeriksaan' => $judulphoto,
        'keteranganphoto' => $keteranganphoto
      ));
      if ($update) {
        $data['pesan'] = 'Data photo pemeriksaan berhasil diubah';
        $data['judulphoto'] = $judulphoto;
      } else {
        $data['pesan'] = 'Data photo pemeriksaan berhasil diubah';
        $data['judulphoto'] = $judulphoto;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionTampilkanSemua($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modKunjungan = new RJInfokunjunganrjV();
    $model = new RJPhotopemeriksaanT();
    if (!empty($pendaftaran_id)) {
      $loadKunjungan = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($loadKunjungan)) {
        $modKunjungan = $loadKunjungan;
      }
      $model = RJPhotopemeriksaanT::model()->findAllByAttributes(array('pasien_id' => $loadKunjungan->pasien_id, 'tampildigalery' => true));
    }
    $this->render('_photo', array(
      'model' => $model,
      'modKunjungan' => $modKunjungan,
    ));
  }

  // public function actionGroup($pendaftaran_id = null, $pendaftaran_id = null)
  public function actionGroup($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $modKunjungan = new RJInfokunjunganrjV();
    $model = new RJPhotopemeriksaanT();
    if (!empty($pendaftaran_id)) {
      $loadKunjungan = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($loadKunjungan)) {
        $modKunjungan = $loadKunjungan;
      }
      $model = RJPhotopemeriksaanT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'tampildigalery' => true));
    }
    $this->render('_photo', array(
      'model' => $model,
      'modKunjungan' => $modKunjungan,
    ));
  }

  /**
   * Removes image with ids specified in post request.
   * On success returns 'OK'
   */
  public function actionUpdateGallery()
  {
    $id = array();
    $id = $_POST['id'];
    /** @var $photos GalleryPhoto[] */
    if (count((array)$id) > 1) {
      $criteria = new CDbCriteria();
      $criteria->addInCondition('photopemeriksaan_id', $id);

      $photos = RJPhotopemeriksaanT::model()->findAll($criteria);
      foreach ($photos as $i => $photo) {
        $update = RJPhotopemeriksaanT::model()->updateByPk($photo->photopemeriksaan_id, array('tampildigalery' => true));
      }
    } else {
      $photos = RJPhotopemeriksaanT::model()->findByPk($id);
      $update = RJPhotopemeriksaanT::model()->updateByPk($id, array('tampildigalery' => true));
    }

    if ($update) {
      echo 'OK';
    } else {
      throw new CHttpException(400, 'Photo, not found');
    }
  }

  public function actionUpdateGalleryView()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $data['pesan'] = '';
      $statusGallery = isset($_POST['status']) ? $_POST['status'] : null;
      /** @var $photos GalleryPhoto[] */
      $photos = RJPhotopemeriksaanT::model()->findByPk($id);
      $update = RJPhotopemeriksaanT::model()->updateByPk($id, array('tampildigalery' => false));
      if ($update) {
        $data['pesan'] = 'OK';
      } else {
        throw new CHttpException(400, 'Photo, not found');
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
