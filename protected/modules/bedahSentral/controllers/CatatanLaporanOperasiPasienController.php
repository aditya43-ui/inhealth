<?php

class CatatanLaporanOperasiPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'create';

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
  public function actionCreate($pasienmasukpenunjang_id)
  {
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = LaporanoperasipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $modelLapor = LaporanoperasipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      $model = new LaporanoperasipasienT;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->tanggalpengisian_laporanop = date('Y-m-d');

      if (!empty($rencana)) {
        $model->tanggal_operasi = $rencana->mulaioperasi;
        $model->jam_mulaioperasi = date('H:i:s', strtotime($rencana->mulaioperasi));
        $model->jam_selesaioperasi = date('H:i:s', strtotime($rencana->selesaioperasi));
        $model->dokterbedah_pengisilaporan_id = $rencana->dokterpelaksana1_id;
      }

      if (!empty($model->jam_mulaioperasi) && !empty($model->jam_selesaioperasi)) {

        $time_awal = strtotime($model->jam_mulaioperasi);
        $time_selesai = strtotime($model->jam_selesaioperasi);

        if ($time_awal > $time_selesai) {
          $time_selesai += 24 * 3600;
        }

        $selisih = ($time_selesai - $time_awal);
        $jam = floor($selisih / 3600);
        $menit = floor($selisih / 60) % 60;
        $detik = $selisih % 60;

        $model->lamaoperasi = "${jam} jam ${menit} menit ${detik} detik";
      }

      //            var_dump($model->attributes); die;
      //            $model->tanggal_operasi =
    }
    $model->tanggalpengisian_laporanop = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tanggalpengisian_laporanop)));


    if (isset($_POST['LaporanoperasipasienT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;


      try {
        $model->attributes = $_POST['LaporanoperasipasienT'];
        $model->tanggalpengisian_laporanop = MyFormatter::formatDateTimeForDB($model->tanggalpengisian_laporanop);
        $model->tanggal_operasi = MyFormatter::formatDateTimeForDB($model->tanggal_operasi);

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }

        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        if (!empty($model->laporanoperasipasien_id)) {
          SpesimenhasiloperasiT::model()->deleteAllByAttributes(array(
            'laporanoperasipasien_id' => $model->laporanoperasipasien_id,
          ));
        }

        if (isset($_POST['SpesimenhasiloperasiT']['detail'])) {
          foreach ($_POST['SpesimenhasiloperasiT']['detail'] as $item) {
            $det = new SpesimenhasiloperasiT;
            $det->attributes = $penunjang->attributes;
            $det->attributes = $item;
            $det->laporanoperasipasien_id = $model->laporanoperasipasien_id;


            if ($det->isNewRecord) {
              $det->create_time = date('Y-m-d H:i:s');
              $det->create_loginpemakai = Yii::app()->user->id;
              $det->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            }

            $det->update_time = date('Y-m-d H:i:s');
            $det->update_loginpemakai = Yii::app()->user->id;

            if ($det->validate()) {
              $ok = $ok && $det->save();
            } else {
              $ok = false;
            }

            if (isset($item['permintaanPeriksa'])) {
              $permintaan = explode(",", $item['permintaanPeriksa']);

              foreach ($permintaan as $item2) {
                if (empty($item2)) {
                  continue;
                }

                $periksa = PemeriksaanlabM::model()->findByPk($item2);
                if (empty($periksa)) {
                  continue;
                }

                $det2 = new SpesimenhasiloperasidetT;
                $det2->attributes = $periksa->attributes;
                $det2->spesimenhasiloperasi_id = $det->spesimenhasiloperasi_id;

                if ($det2->validate()) {
                  $ok = $ok && $det2->save();
                } else {
                  $ok = false;
                }

                // var_dump($det2->attributes);

              }

              // var_dump($permintaan);
            }


            // var_dump($det->attributes);
          }
        }


        // var_dump($ok, $model->attributes, $_POST); die;


        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {

    $model = LaporanoperasipasienT::model()->findByPK($id);
    $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
    // var_dump($model,$pasienmasukpenunjang_id, $id);die;
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      // 'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = LaporanoperasipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->tanggalpengisian_laporanop = date('Y-m-d');

      if (!empty($rencana)) {
        $model->tanggal_operasi = $rencana->mulaioperasi;
        $model->jam_mulaioperasi = date('H:i:s', strtotime($rencana->mulaioperasi));
        $model->jam_selesaioperasi = date('H:i:s', strtotime($rencana->selesaioperasi));
        $model->dokterbedah_pengisilaporan_id = $rencana->dokterpelaksana1_id;
      }

      if (!empty($model->jam_mulaioperasi) && !empty($model->jam_selesaioperasi)) {

        $time_awal = strtotime($model->jam_mulaioperasi);
        $time_selesai = strtotime($model->jam_selesaioperasi);

        if ($time_awal > $time_selesai) {
          $time_selesai += 24 * 3600;
        }

        $selisih = ($time_selesai - $time_awal);
        $jam = floor($selisih / 3600);
        $menit = floor($selisih / 60) % 60;
        $detik = $selisih % 60;

        $model->lamaoperasi = "${jam} jam ${menit} menit ${detik} detik";
      }

      //            var_dump($model->attributes); die;
      //            $model->tanggal_operasi =
    }

    $model->tanggalpengisian_laporanop = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tanggalpengisian_laporanop)));


    if (isset($_POST['LaporanoperasipasienT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;


      try {
        // echo "<pre>";
        // var_dump($_POST);die;

        $model->attributes = $_POST['LaporanoperasipasienT'];


        $model->tanggalpengisian_laporanop = MyFormatter::formatDateTimeForDB($model->tanggalpengisian_laporanop);
        $model->tanggal_operasi = MyFormatter::formatDateTimeForDB($model->tanggal_operasi);
        $time_awal = strtotime($_POST['LaporanoperasipasienT']['jam_mulaioperasi']);
        $time_selesai = strtotime($_POST['LaporanoperasipasienT']['jam_selesaioperasi']);

        if ($time_awal > $time_selesai) {
          $time_selesai += 24 * 3600;
        }

        $selisih = ($time_selesai - $time_awal);
        $jam = floor($selisih / 3600);
        $menit = floor($selisih / 60) % 60;
        $detik = $selisih % 60;

        $model->lamaoperasi = "${jam} jam ${menit} menit ${detik} detik";
        // var_dump($model->lamaoperasi);die;

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }

        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        if (!empty($model->laporanoperasipasien_id)) {
          SpesimenhasiloperasiT::model()->deleteAllByAttributes(array(
            'laporanoperasipasien_id' => $model->laporanoperasipasien_id,
          ));
        }

        if (isset($_POST['SpesimenhasiloperasiT']['detail'])) {
          foreach ($_POST['SpesimenhasiloperasiT']['detail'] as $item) {
            $det = new SpesimenhasiloperasiT;
            $det->attributes = $penunjang->attributes;
            $det->attributes = $item;
            $det->laporanoperasipasien_id = $model->laporanoperasipasien_id;

            if ($det->isNewRecord) {
              $det->create_time = date('Y-m-d H:i:s');
              $det->create_loginpemakai = Yii::app()->user->id;
              $det->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            }

            $det->update_time = date('Y-m-d H:i:s');
            $det->update_loginpemakai = Yii::app()->user->id;

            if ($det->validate()) {
              $ok = $ok && $det->save();
            } else {
              $ok = false;
            }

            if (isset($item['permintaanPeriksa'])) {
              $permintaan = explode(",", $item['permintaanPeriksa']);

              foreach ($permintaan as $item2) {
                if (empty($item2)) {
                  continue;
                }

                $periksa = PemeriksaanlabM::model()->findByPk($item2);
                if (empty($periksa)) {
                  continue;
                }

                $det2 = new SpesimenhasiloperasidetT;
                $det2->attributes = $periksa->attributes;
                $det2->spesimenhasiloperasi_id = $det->spesimenhasiloperasi_id;

                if ($det2->validate()) {
                  $ok = $ok && $det2->save();
                } else {
                  $ok = false;
                }

                // var_dump($det2->attributes);

              }

              // var_dump($permintaan);
            }


            // var_dump($det->attributes);
          }
        }


        // var_dump($ok, $model->attributes, $_POST); die;


        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi,
    ));
  }


  // public function actionUbah($id)
  // {
  //   $model = $this->loadModel($id);

  //   // Uncomment the following line if AJAX validation is needed

  //   if (isset($_POST['LaporanoperasipasienT'])) {
  //     $model->attributes = $_POST['LaporanoperasipasienT'];
  //     if ($model->save()) {
  //       Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //       $this->redirect(array('view', 'id' => $model->laporanoperasipasien_id));
  //     }
  //   }

  //   $this->render('ubah', array(
  //     'model' => $model,
  //   ));
  // }




  // /**
  //  * Memanggil dan Menghapus data.
  //  * @param integer $id the ID of the model to be deleted
  //  */
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

  // /**
  //  * Memanggil dan menonaktifkan status
  //  */
  // public function actionNonActive($id)
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $data['sukses'] = 0;
  //     $model = $this->loadModel($id);
  //     // set non-active this
  //     // example:
  //     // $model->modelaktif = false;
  //     // if($model->save()){
  //     //	$data['sukses'] = 1;
  //     // }
  //     echo CJSON::encode($data);
  //   }
  // }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('LaporanoperasipasienT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new LaporanoperasipasienT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['LaporanoperasipasienT'])) {
      $model->attributes = $_GET['LaporanoperasipasienT'];
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
    $model = LaporanoperasipasienT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'laporanoperasipasien-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }


  public function actionLoadTambahRow()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $mod = new SpesimenhasiloperasiT();
    $mod->attributes = $_POST['SpesimenhasiloperasiT'];
    $mod->permintaanPeriksa = $_POST['SpesimenhasiloperasiT']['permintaanPeriksa'];

    echo $this->renderPartial('_rowJaringan', array('mod' => $mod, 'idx' => microtime(true)), true);
  }

  /**
   * Mencetak data
   */


  public function actionPrint2($laporanoperasi_id)
  {

    $model = LaporanoperasipasienT::model()->findByAttributes(array(
      'laporaoperasi_id' => $laporanoperasi_id,
    ));


    $caraPrint = $_REQUEST['caraPrint'];
    $this->layout = '//layouts/printWindows';
    $this->render('print/PrintNew', array(
      'model' => $model,
    ));
  }


  public function actionPrint($pasienmasukpenunjang_id = null, $id = null)
  {

    if (!empty($id)) {
      $model = LaporanoperasipasienT::model()->findByPK($id);
      $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
    } else if (!empty($pasienmasukpenunjang_id)) {
      $model = LaporanoperasipasienT::model()->findByAttributes(array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      ));
    }
    // var_dump($model,$id,$pasienmasukpenunjang_id);die;


    //$pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      // 'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = LaporanoperasipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    // $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
    //     'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    // ));


    // $rencana = RencanaoperasiT::model()->findByAttributes(array(
    //     'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    // ));


    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($anastesi)) {
      $anestesi = new PasienanastesiT;
    }


    // $model = LaporanoperasipasienT::model()->findByAttributes(array(
    //     'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    // ));

    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $penunjang->pendaftaran_id));
    $modPasien = PasienM::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));

    $modSpesimen = SpesimenhasiloperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $caraPrint = !empty($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : 'print';
    $this->layout = '//layouts/printWindows';
    $this->render('print/PrintNew', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modSpesimen' => $modSpesimen
    ));
  }
}
