<?php

class PelamarTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  private $successSaveBahasa = false;
  private $successSaveLingkunganKerja = false;
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->layout = '//layouts/iframe';
    $modKemampuanPelamars  = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $id));
    $modBahasas        = KPKemampuanBahasaR::model()->findAllByAttributes(array('pelamar_id' => $id));
    $modLingkunganKerjas  = KPLingkunganKerjaR::model()->findAllByAttributes(array('pelamar_id' => $id));
    $modPengalamankerjas = KPPengalamankerjaR::model()->findAllByAttributes(array('pelamar_id' => $id));
    $modReferensiKerjas = ReferensikerjaR::model()->findAllByAttributes(array('pelamar_id' => $id));

    $this->render('view', array(
      'model' => $this->loadModel($id),
      'modKemampuanPelamars' => $modKemampuanPelamars,
      'modBahasas' => $modBahasas,
      'modLingkunganKerjas' => $modLingkunganKerjas,
      'modPengalamankerjas'=>$modPengalamankerjas,
      'modReferensiKerjas'=> $modReferensiKerjas

    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Calon Pegawai";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $modKonfig = KonfigsystemK::model()->find();
    $masaberlaku_pelamar = isset($modKonfig) ? $modKonfig->masaberlaku_pelamar_hr : 0;

    $model = new KPPelamarT;
    $modBahasa = new KPKemampuanBahasaR;
    $modLingkunganKerja = new KPLingkunganKerjaR;
    $modBahasas = null;
    $modLingkunganKerjas = null;
    $modKemampuanPelamar = new KPKemampuanpelamarR();
    $modKemampuanPelamars = null;
    $modPengalamankerja = new KPPengalamankerjaR;
    $modPengalamankerjas = null;

    $modReferensiKerja = new ReferensikerjaR;
    $modReferensiKerjas = null;

    $modBahasa->no_urut = 1;
    $modLingkunganKerja->nourut = 1;

    if (!empty($id)) {
      $model          = KPPelamarT::model()->findByPk($id);
      $modBahasas     = KPKemampuanBahasaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
      $modLingkunganKerjas = KPLingkunganKerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
      $modKemampuanPelamars = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
      $modPengalamankerjas = KPPengalamankerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
      $modReferensiKerjas = ReferensikerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    }

    if (!empty($masaberlaku_pelamar)) {
      $tgl_pencatatan = date('Y-m-d H:i:s');
      $tglmasaberlaku = strtotime($tgl_pencatatan . ' + ' . $masaberlaku_pelamar . ' days');
      $tglmasaberlaku = date('Y-m-d H:i:s', $tglmasaberlaku);
      $model->berlaku_s_d = $tglmasaberlaku;
    }

    if (isset($_POST['KPPelamarT'])) {
      // echo '<pre>';
      //               print_r($_POST);
      //               exit();
      $tersimpansukses = false;
      
      $format = new MyFormatter();
      $model->attributes = $_POST['KPPelamarT'];
      $model->tgllowongan = $format->formatDateTimeForDb($_POST['KPPelamarT']['tgllowongan']);
      $model->berlaku_s_d = $format->formatDateTimeForDb($_POST['KPPelamarT']['berlaku_s_d']);

      $model->masa_sip = isset($_POST['KPPelamarT']['masa_sip']) ? $format->formatDateTimeForDb($_POST['KPPelamarT']['masa_sip']) : null;
      $model->masa_str = isset($_POST['KPPelamarT']['masa_str']) ? $format->formatDateTimeForDb($_POST['KPPelamarT']['masa_str']) : null;
      $model->masa_sip_2 = isset($_POST['KPPelamarT']['masa_sip_2']) ? $format->formatDateTimeForDb($_POST['KPPelamarT']['masa_sip_2']) : null;
      $model->tglmelamar = isset($_POST['KPPelamarT']['tglmelamar']) ? $format->formatDateTimeForDb($_POST['KPPelamarT']['tglmelamar']) : null;
      
      $model->tglditerima = null;
      $model->create_time = date('Y-m-d H:i:s');
      $model->update_time = null;
      //			  $model->kemampuan_tingkat = !empty($_POST['KPPelamarT']['tgllowongan'])?$_POST['KPPelamarT']['tgllowongan']:null;
      $model->create_loginpemakai_id = Yii::app()->user->id;
      // $model->create_loginpemakai_id = null;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $file = $model->filelamaran;
      $model->photopelamar = CUploadedFile::getInstance($model, 'photopelamar');
      $model->filelamaran = CUploadedFile::getInstance($model, 'filelamaran');
      $gambar = $model->photopelamar;
      $fileLamaran = $model->filelamaran;
      $random = rand(000000, 999999);

      if (empty($_POST['KPPelamarT']['tgl_lahirpelamar']))
        $model->tgl_lahirpelamar = null;
      else
        $model->tgl_lahirpelamar = $format->formatDateTimeForDb($model->tgl_lahirpelamar);
      if (empty($_POST['KPPelamarT']['tglmulaibekerja']))
        $model->tglmulaibekerja = null;
      else
        $model->tglmulaibekerja = $format->formatDateTimeForDb($model->tglmulaibekerja);
      //                    ==========pengecekan file photo pelamar
      if (!empty($model->photopelamar)) //Klo User Memasukan Logo
      {

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed
        $model->photopelamar = $random . $model->photopelamar;
        $fullImgName = $model->photopelamar;
        $fullImgSource = Params::pathPelamarPhotosDirectory() . $fullImgName;

        $fullThumbSource = Params::pathPelamarThumbsDirectory() . 'kecil_' . $fullImgName;
      }
      //                    ===========pengecekan file lamaran
      if (!empty($model->filelamaran)) {
        $model->filelamaran = $random . $model->filelamaran;
        $namaFile = $model->filelamaran;
        $dataLamaran = Params::pathPelamarFilesDirectory() . $namaFile;
      }

      //                    ======================= VALIDASI TABULAR
      // echo "<pre>";

      if (isset($_POST['KPKemampuanBahasaR'])) {
        $hasilBahasa = $this->validasiTabularBahasa($_POST['KPKemampuanBahasaR']);
        $modBahasas = $hasilBahasa['modBahasa'];
        $bahasa = $hasilBahasa['bahasa'];
      }
      if (isset($_POST['KPLingkunganKerjaR'])) {
        $hasilLingkunganKerja = $this->validasiTabularLingkunganKerja($_POST['KPLingkunganKerjaR']);
        $modLingkunganKerjas = $hasilLingkunganKerja['modLingkunganKerja'];
        $lingkunganKerja = $hasilLingkunganKerja['lingkunganKerja'];
      }

      $transaction = Yii::app()->db->beginTransaction();
      
      if ($model->validate()) {
        
        try {

          if ($model->save()) {
            $tersimpansukses = true;
            //                              ==========ini digunakan untuk menyimpan photo pelamar
            if (!empty($model->photopelamar)) {
              $gambar->saveAs($fullImgSource);

              $thumb->create($fullImgSource)
                ->resize(200, 200)
                ->save($fullThumbSource);
            }

            //                           =========ini digunakan untuk menyimpan file lamaran pelamar
            if (!empty($model->filelamaran)) {
              $fileLamaran->saveAs($dataLamaran);
            }
            $tersimpankemampuan = true;
            $tersimpanpengalaman = true;
            $tersimpanreferensi = true;
            $tersimpanbahasa = true;
            $tersimpanlingkungan = true;


            if ($bahasa) {
              foreach ($modBahasas as $key => $modBahasa) {
                $modBahasa->pelamar_id = $model->pelamar_id;
                if (!$modBahasa->save()) {
                  $tersimpanbahasa = false;
                }
              }
            }

            if ($lingkunganKerja) {
              foreach ($modLingkunganKerjas as $key => $modLingkunganKerja) {
                $modLingkunganKerja->pelamar_id = $model->pelamar_id;
                if (!$modLingkunganKerja->save()) {
                  $tersimpanlingkungan = false;
                }
              }
            }
            
            
            if (isset($_POST['KPKemampuanpelamarR'])) {
              foreach ($_POST['KPKemampuanpelamarR'] as $key => $detailskill) {
                $modKemampuanPelamar = new KPKemampuanpelamarR();
                $modKemampuanPelamar->attributes = $detailskill;
                $modKemampuanPelamar->masaberlaku_sertifikasi = (isset($modKemampuanPelamar->masaberlaku_sertifikasi) ? $format->formatDateTimeForDb($modKemampuanPelamar->masaberlaku_sertifikasi) : null);

                $modKemampuanPelamar->pelamar_id = $model->pelamar_id;
                if ($modKemampuanPelamar->validate()) {
                  if(!$modKemampuanPelamar->save()){
                    $tersimpankemampuan = false;
                  }
                }
              }
            }
            
            if (isset($_POST['KPPengalamankerjaR'])) {
              foreach ($_POST['KPPengalamankerjaR'] as $key => $detail) {
                $modPengalaman = new KPPengalamankerjaR();
                $modPengalaman->attributes = $detail;
                $modPengalaman->tglmasuk = (isset($modPengalaman->tglmasuk) ? $format->formatDateTimeForDb($modPengalaman->tglmasuk) : null);
                $modPengalaman->tglkeluar = (isset($modPengalaman->tglkeluar) ? $format->formatDateTimeForDb($modPengalaman->tglkeluar) : null);

                $modPengalaman->pelamar_id = $model->pelamar_id;
                $modPengalaman->create_time = date('Y-m-d H:i:s');
                $modPengalaman->create_loginpemakai_id = Yii::app()->user->id;
                $modPengalaman->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($modPengalaman->validate()) {
                  if(!$modPengalaman->save()){
                    $tersimpanpengalaman = false;
                  }
                }

              }
            }
            
            if (isset($_POST['ReferensikerjaR'])) {
              // echo '<pre>';
              //       print_r($_POST['ReferensikerjaR']);
              //       exit();
              foreach ($_POST['ReferensikerjaR'] as $detailRef) {
               
                $modReferensikerjaR = new ReferensikerjaR();
                $modReferensikerjaR->attributes = $detailRef;
                $modReferensikerjaR->pelamar_id = $model->pelamar_id;
                

                if ($modReferensikerjaR->validate()) {
                  if(!$modReferensikerjaR->save()){
                    $tersimpanreferensi = false;
                  }
                }
              }
            }

            if($tersimpankemampuan == false && $tersimpanpengalaman == false && $tersimpanreferensi == false && $tersimpanbahasa == false && $tersimpanlingkungan == false){
              $tersimpansukses = false;
            }
            
          }
          
          if ($tersimpansukses == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data Pelamar ' . $model->nama_pelamar . ' Berhasil Disimpan.');
            //                                  $this->redirect(array('create','id'=>$model->pelamar_id));
            $this->redirect(array('create', 'id' => $model->pelamar_id,'sukses'=>1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan" . $e->getMessage());
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan. Silakan Periksa Kembali Data Pelamar !");
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modBahasa' => $modBahasa,
      'modLingkunganKerja' => $modLingkunganKerja,
      'modBahasas' => $modBahasas,
      'modLingkunganKerjas' => $modLingkunganKerjas,
      'modKemampuanPelamar' => $modKemampuanPelamar,
      'modKemampuanPelamars' => $modKemampuanPelamars,
      'modPengalamankerja'=> $modPengalamankerja,
      'modPengalamankerjas'=> $modPengalamankerjas,
      'modReferensiKerja'=>$modReferensiKerja,
      'modReferensiKerjas'=>$modReferensiKerjas
    ));
  }


  private function cekSemua($model, $except = array())
  {
    $ada = false;
    foreach ($model as $counter => $value) {
      if (!in_array($counter, $except)) {
        if (!empty($value)) {
          $ada = true;
          break;
        }
      }
    }
    return $ada;
  }

  private function validasiTabularBahasa($modBahasa)
  {
    $modBahasas = null;
    $result = array();
    $bahasa = false;
    if (count((array)$modBahasa) > 0) {
      foreach ($modBahasa as $key => $modelBahasa) {
        $ada = $this->cekSemua($modelBahasa, array('no_urut'));
        if ($ada) {
          $modBahasas[$key] = new KPKemampuanBahasaR;
          $modBahasas[$key]->attributes  = $modelBahasa;
          $bahasa = true;
          $modBahasas[$key]->validate();
        }
      }
      sort($modBahasas);
    }
    $result['modBahasa'] = $modBahasas;
    $result['bahasa'] = $bahasa;
    return $result;
  }

  private function validasiTabularLingkunganKerja($modLingkunganKerja)
  {
    $modLingkunganKerjas = null;
    $result = array();
    $lingkunganKerja = false;
    if (count((array)$modLingkunganKerja) > 0) {
      foreach ($modLingkunganKerja as $key => $modelLingkunganKerja) {
        $ada = $this->cekSemua($modelLingkunganKerja, array('nourut'));
        if ($ada) {
          $modLingkunganKerjas[$key] = new KPLingkunganKerjaR;
          $modLingkunganKerjas[$key]->attributes  = $modelLingkunganKerja;
          $lingkunganKerja = true;
          $modLingkunganKerjas[$key]->validate();
        }
      }
      sort($modLingkunganKerjas);
    }
    $result['modLingkunganKerja'] = $modLingkunganKerjas;
    $result['lingkunganKerja'] = $lingkunganKerja;
    return $result;
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPPelamarT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Calon Pegawai";
    $model = new KPPelamarT('searchInfoPelamar');
    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['KPPelamarT'])) {
      $model->attributes = $_GET['KPPelamarT'];
      $model->semuapelamar = $_GET['KPPelamarT']['semuapelamar'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPelamarT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPelamarT']['tgl_akhir']);
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPPelamarT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pelamar-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionKontrakPelamar($idPelamar = null, $idKaryawan = null, $sukses = '')
  {
    if ($sukses == 1) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    $format = new MyFormatter;
    $modPegawai = new KPPegawaiM;

    //          =================model kontrak pegawai
    $modKontrak = new KPKontrakKaryawanR;
    $criteria = new CDbCriteria();
    $criteria->select = 'max(nourutkontrak) as nourut';
    $nourut = KPKontrakKaryawanR::model()->find($criteria);
    $modKontrak->nourutkontrak = $nourut->nourut + 1;
    $modKontrak->create_time = date('Y-m-d');
    $modKontrak->create_loginpemakai_id = Yii::app()->user->id;
    //          ===================end kontrak pegawai

    if (!empty($idPelamar)) {
      $pelamar = KPPelamarT::model()->findByPk($idPelamar);
      $modPegawai->jenisidentitas    = $pelamar->jenisidentitas;
      $modPegawai->noidentitas    = $pelamar->noidentitas;
      $modPegawai->nama_pegawai    = $pelamar->nama_pelamar;
      $modPegawai->nama_keluarga    = $pelamar->nama_keluarga;
      $modPegawai->jeniskelamin    = $pelamar->jeniskelamin;
      $modPegawai->tempatlahir_pegawai = $pelamar->tempatlahir_pelamar;
      if (!empty($pelamar->tgl_lahirpelamar)) {
        $modPegawai->tgl_lahirpegawai = $pelamar->tgl_lahirpelamar;
      }
      $modPegawai->statusperkawinan  = $pelamar->statusperkawinan;
      $modPegawai->alamat_pegawai    = $pelamar->alamat_pelamar;
      $modPegawai->agama        = $pelamar->agama;
      $modPegawai->nomobile_pegawai  = $pelamar->nomobile_pelamar;
      $modPegawai->notelp_pegawai    = $pelamar->notelp_pelamar;
      $modPegawai->alamatemail    = $pelamar->alamatemail;
      $modPegawai->pendidikan_id    = $pelamar->pendidikan_id;
      $modPegawai->pendkualifikasi_id = $pelamar->pendkualifikasi_id;
      $modPegawai->warganegara_pegawai = $pelamar->warganegara_pelamar;
      $modPegawai->suku_id      = $pelamar->suku_id;
      $modPegawai->photopegawai    = $pelamar->photopelamar;
    }
    if (!empty($idKaryawan)) {
      $modPegawai = KPPegawaiM::model()->findByPk($idKaryawan);
      $modKontrak = KPKontrakKaryawanR::model()->findByAttributes(array('pegawai_id' => $modPegawai->pegawai_id));
    }

    $thisdate = date('Y-m-d');
    $random = rand(00000, 99999);

    if (isset($_POST['KPPegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPegawai->attributes = $_POST['KPPegawaiM'];
        $modPegawai->create_time = $thisdate;
        $modPegawai->create_loginpemakai_id = Yii::app()->user->id;
        $modPegawai->pegawai_aktif = TRUE;
        $modPegawai->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (!empty($modPegawai->tgl_lahirpegawai)) {
          $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tgl_lahirpegawai']);
        } else {
          $modPegawai->tgl_lahirpegawai = null;
        }
        if (!empty($modPegawai->tglberhenti)) {
          $modPegawai->tglberhenti = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglberhenti']);
        } else {
          $modPegawai->tglberhenti = null;
        }
        if (!empty($modPegawai->tglditerima)) {
          $modPegawai->tglditerima = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglditerima']);
        } else {
          $modPegawai->tglditerima = null;
        }
        //              =================upload photo pelamar
        $modPegawai->photopegawai = CUploadedFile::getInstance($modPegawai, 'photopegawai');
        $photoKaryawan = $modPegawai->photopegawai;
        if (isset($_POST['KPKontrakKaryawanR'])) {
          $modKontrak->attributes = $_POST['KPKontrakKaryawanR'];
          $modKontrak->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }
        if ($modPegawai->validate()) {
          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $adaphoto = true;
          if (!empty($pelamar->photopelamar)) {
            $modPegawai->photopegawai = $pelamar->photopelamar;
            $file = Params::pathPelamarPhotosDirectory() . $modPegawai->photopegawai;
            $newFile_photo = Params::pathPegawaiDirectory() . $modPegawai->photopegawai;
            $newFileTumbs_photo = Params::pathPegawaiTumbsDirectory() . $modPegawai->photopegawai;
            copy($file, $newFile_photo);
            copy($newFile_photo, $newFileTumbs_photo);
            $adaphoto = false;
          }

          if (!empty($modPegawai->photopegawai) && $adaphoto) {

            $modPegawai->photopegawai = $random . $photoKaryawan;
            $fullimage_photo = Params::pathPegawaiDirectory() . $modPegawai->photopegawai;

            $tumbsimage_photo = Params::pathPegawaiTumbsDirectory() . $modPegawai->photopegawai;

            $photoKaryawan->saveAs($fullimage_photo);

            $thumb->create($fullimage_photo)
              ->resize(200, 200)
              ->save($tumbsimage_photo);
          }
          if ($modPegawai->save()) {
            $modPelamar = KPPelamarT::model()->findByPk($idPelamar);
            $modPelamar->tglditerima = $format->formatDateTimeForDb($modPegawai->tglditerima);
            $modPelamar->save();
            $modKemampuanPelamars = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $idPelamar));
            if (count((array)$modKemampuanPelamars) > 0) {
              foreach ($modKemampuanPelamars as $key => $modKemampuanPelamar) {
                $modKemampuanPegawai = new KPKemampuanpegawaiR();
                $modKemampuanPegawai->pegawai_id = $modPegawai->pegawai_id;
                $modKemampuanPegawai->kemampuanpegawai_nama = $modKemampuanPelamar->kemampuan_nama;
                $modKemampuanPegawai->kemampuanpegawai_tingkat = $modKemampuanPelamar->kemampuan_tingkat;
                if ($modKemampuanPegawai->validate()) {
                  $modKemampuanPegawai->save();
                }
              }
            }
            $modKontrak->attributes = $_POST['KPKontrakKaryawanR'];
            $modKontrak->pegawai_id = $modPegawai->pegawai_id;
            if ($modKontrak->validate()) {
              $modKontrak->tglkontrak = $format->formatDateTimeForDb($modKontrak->tglkontrak);
              $modKontrak->tglmulaikontrak = $format->formatDateTimeForDb($modKontrak->tglmulaikontrak);
              $modKontrak->tglakhirkontrak = $format->formatDateTimeForDb($modKontrak->tglakhirkontrak);
              if ($modKontrak->save()) {  //                                               
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('kontrakPelamar', 'idKaryawan' => $modPegawai->pegawai_id, 'sukses' => 1));
              } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
              }
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan" . $e->getMessage());
      }
    }

    $this->render('kontrakPelamar', array(
      'modPegawai' => $modPegawai, 'modKontrak' => $modKontrak,
    ));
  }

  public function actionPrint($pelamar_id, $caraPrint)
  {
    //            $model= new HRDPengcalpegawaiT;
    //            $model->attributes=$_REQUEST['HRDPengcalpegawaiT'];
    //            $this->layout = '//layouts/iframe';  
    $judulLaporan = 'Data Pelamar';

    $model          = KPPelamarT::model()->findByPk($pelamar_id);
    $modBahasas     = KPKemampuanBahasaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modLingkunganKerjas = KPLingkunganKerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modKemampuanPelamars = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'modBahasas' => $modBahasas, 'modLingkunganKerjas' => $modLingkunganKerjas, 'modKemampuanPelamars' => $modKemampuanPelamars));
    }
    //            else if($caraPrint=='EXCEL') {
    //                $this->layout='//layouts/printExcel';
    //                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    //            }
    //            else if($_REQUEST['caraPrint']=='PDF') {
    //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    //                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    //                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
    //                //$mpdf->useOddEven = 2;  
    //                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //                $mpdf->WriteHTML($stylesheet,1);  
    //                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
    //                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
    //                $mpdf->Output();
    //            }                       
  }

  public function actionGetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $tglLahir = $format->formatDateTimeForDb($_POST['tglLahir']);
      $dob = $tglLahir;
      $today = date("Y-m-d");
      list($y, $m, $d) = explode('-', $dob);
      list($ty, $tm, $td) = explode('-', $today);
      if ($td - $d < 0) {
        $day = ($td + 30) - $d;
        $tm--;
      } else {
        $day = $td - $d;
      }
      if ($tm - $m < 0) {
        $month = ($tm + 12) - $m;
        $ty--;
      } else {
        $month = $tm - $m;
      }
      $year = $ty - $y;

      // $data['umur'] = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
      $data['thn'] = str_pad($year, 2, '0', STR_PAD_LEFT);
      $data['bln'] = str_pad($month, 2, '0', STR_PAD_LEFT);
      $data['hr'] = str_pad($day, 2, '0', STR_PAD_LEFT);
      //$data['umur'] = $dob;
      echo json_encode($data);
      Yii::app()->end();
    }
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


  public function actionCekNIP()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $nip = $_POST['nip'];
      $noidentitas = isset($_POST['noidentitas']) ? $_POST['noidentitas'] : '';
      $data['nip'] = null;
      $data['noidentitas'] = null;
      if (!empty($nip)) {
        $data['nip'] = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $nip));
      }
      if (!empty($noidentitas)) {
        $data['noidentitas'] = KPPegawaiM::model()->findByAttributes(array('noidentitas' => $noidentitas));
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
      $modPasien = new KPPegawaiM;
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
      $modPasien = new KPPegawaiM;
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
      $modPasien = new KPPegawaiM;
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


  public function actionGetLamaKontrak()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']);
      list($y, $m, $d) = explode('-', $tgl_awal);
      list($ty, $tm, $td) = explode('-', $tgl_akhir);

      if ($td - $d < 0) {
        $day = ($td + 30) - $d;
        $tm--;
      } else {
        $day = $td - $d;
      }
      if ($tm - $m < 0) {
        $month = ($tm + 12) - $m;
        $ty--;
      } else {
        $month = $tm - $m;
      }
      $year = $ty - $y;

      $data['kontrak'] = str_pad($year, 2, '0', STR_PAD_LEFT) . ' Thn ' . str_pad($month, 2, '0', STR_PAD_LEFT) . ' Bln ' . str_pad($day, 2, '0', STR_PAD_LEFT) . ' Hr';

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetStatusNilai()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $id = $_POST['id'];
      $statuspenilaian = isset($_POST['statuspenilaian']) ? $_POST['statuspenilaian'] : '';
      $tanggalpenilaian = date('Y-m-d');

      $attributes = array(
        'statuspenilaian' => $statuspenilaian,
        'tanggalpenilaian' => $tanggalpenilaian
      );
      $update = PelamarT::model()->updateAll($attributes, " pelamar_id = " . $id);
      if ($update) {
        $data['status'] = 'ok';
      } else {
        $data['status'] = 'not';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . '' . $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->gelardepan . '' . $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionApproveMenyetujui($pelamar_id = null, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'Data Pelamar';
    $model = KPPelamarT::model()->findByPk($pelamar_id);
    $modBahasas = KPKemampuanBahasaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modLingkunganKerjas = KPLingkunganKerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modKemampuanPelamars = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));

    if ($approve) {
      $update = KPPelamarT::model()->updateByPk($pelamar_id, array('menyetujui_tgl' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'pelamar_id' => $pelamar_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }

    $this->render('_menyetujui', array(
      'model' => $model,
      'modBahasas' => $modBahasas,
      'modLingkunganKerjas' => $modLingkunganKerjas,
      'modKemampuanPelamars' => $modKemampuanPelamars
    ));
  }

  public function actionApproveMengetahui($pelamar_id = null, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'Data Pelamar';
    $model = KPPelamarT::model()->findByPk($pelamar_id);
    $modBahasas = KPKemampuanBahasaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modLingkunganKerjas = KPLingkunganKerjaR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));
    $modKemampuanPelamars = KPKemampuanpelamarR::model()->findAllByAttributes(array('pelamar_id' => $model->pelamar_id));

    if ($approve) {
      $update = KPPelamarT::model()->updateByPk($pelamar_id, array('mengetahui_tgl' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'pelamar_id' => $pelamar_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }

    $this->render('_mengetahui', array(
      'model' => $model,
      'modBahasas' => $modBahasas,
      'modLingkunganKerjas' => $modLingkunganKerjas,
      'modKemampuanPelamars' => $modKemampuanPelamars
    ));
  }
}
