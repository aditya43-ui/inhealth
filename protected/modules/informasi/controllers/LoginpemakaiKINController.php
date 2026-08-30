<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.LoginpemakaiKController');

class LoginpemakaiKINController extends LoginpemakaiKController
{
  public $ruangantersimpan = true; //looping
  public $modultersimpan = true; //looping

  public $layout = '//layouts/column1';
  public $path_view = 'informasi.views.loginpemakaiK.';

  public function actionCreate($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Aktivasi Mobile Pasien";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new LoginpemakaiK;
    $model->jenispemakai = 'pasien';
    $model->nama_pemakai = '';
    // Uncomment the following line if AJAX validation is needed
    if (!empty($id)) {
      $model = LoginpemakaiK::model()->findByPk($id);
      $modPasien = PasienM::model()->findByPk($model->pasien_id);
      if (isset($modPasien)) {
        $model->nama_pasien = $modPasien->nama_pasien;
      }
    }

    if (isset($_POST['LoginpemakaiK'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LoginpemakaiK'];
        $model->katakunci_pemakai = $model->new_password;
        $model->ruangan = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
        $model->modul = (isset($_POST['modul_id']) ? $_POST['modul_id'] : null);
        $model->jenispemakai = (isset($_POST['LoginpemakaiK']['jenispemakai']) ? $_POST['LoginpemakaiK']['jenispemakai'] : null);
        $model->loginpemakai_aktif = TRUE;
        $model->statuslogin = TRUE;
        $model->lastlogin = $format->formatDateTimeForDb($model->lastlogin);
        $model->tglpembuatanlogin = $format->formatDateTimeForDb($model->tglpembuatanlogin);
        $model->tglupdatelogin = $format->formatDateTimeForDb($model->tglupdatelogin);
        $model->waktuterakhiraktifitas = $format->formatDateTimeForDb($model->waktuterakhiraktifitas);
        //                        if($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai'){
        //                                $model->pasien_id = null;
        //                        }else{ 
        $model->pegawai_id = null;
        //                        }
        $model->waktuterakhiraktifitas = date("Y-m-d H:i:s");
        $model->setScenario('insert');

        if ($model->save()) {
          if (!empty($model->pasien_id)) {
            $logNull = PasienM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
            if (!empty($logNull)) {
              $logNull->loginpemakai_id = null;
              $logNull->save();
            }

            $peg = PasienM::model()->updateByPk($model->pasien_id, array('loginpemakai_id' => $model->loginpemakai_id));

            $cek = PasienM::model()->findByPk($model->pasien_id);
            if (!empty($cek)) {
              if (!empty($cek->alamatemail)) {
                LoginpemakaiK::model()->updateByPk($model->loginpemakai_id, array('is_email' => true));
              }
              if (!empty($cek->no_mobile_pasien)) {
                LoginpemakaiK::model()->updateByPk($model->loginpemakai_id, array('is_phonenumber' => true));
              }
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'id' => $model->loginpemakai_id, 'sukses' => 1));
        }
      } catch (Exception $e) {
        //echo $e->getMessage();die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $linkHalaman = CustomFunction::getUrlByMenuID(3281);

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionInfomasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien";
    $model = new INLoginpemakaiK("searchInformasi");
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['INLoginpemakaiK'])) {
      $model->attributes = $_GET['INLoginpemakaiK'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['INLoginpemakaiK']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['INLoginpemakaiK']['tgl_akhir']);
      $model->no_rekam_medik = $_GET['INLoginpemakaiK']['no_rekam_medik'];
      $model->nama_pasien = $_GET['INLoginpemakaiK']['nama_pasien'];
    }

    $linkHalaman = CustomFunction::getUrlByMenuID(3279);

    $this->render($this->path_view . 'informasi', array(
      'format' => $format,
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }
}
