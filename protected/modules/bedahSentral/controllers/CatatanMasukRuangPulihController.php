<?php

class CatatanMasukRuangPulihController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'create';
  public $ok = true;

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

    $admisi = PasienadmisiT::model()->findByPk($penunjang->pasienadmisi_id);


    $model = PasienruangpulihT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));



    $masukkamar = new MasukkamarT();
    $pindahkamar = new PindahkamarT();

    if (empty($model)) {
      $model = new PasienruangpulihT;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->masukruanganpulih_tanggal = date('Y-m-d');
      $model->masukruanganpulih_jam = date('H:i:s');

      if (!empty($anestesi)) {
        $model->dokteranastesi_id = $anestesi->dokteranastesi_id;
        $model->perawatanastesi_id = $anestesi->perawatanastesi_id;
      }
      if (!empty($rencana)) {
        $model->petugas_saatmasukruangpulih_id = $rencana->suster_id;
      }

      $skor = new AldrettepasienruangpulihT;
    } else {
      $skor = AldrettepasienruangpulihT::model()->findByAttributes(array(
        'pasienruangpulih_id' => $model->pasienruangpulih_id,
        'jenisaldrette' => 'Masuk Ruang Pulih',
      ));

      if (empty($skor)) {
        $skor = new AldrettepasienruangpulihT;
      }

      $pindahkamar = PindahkamarT::model()->findByAttributes(array('masukkamar_id' => $model->masukkamar_id));
    }

    $model->masukruanganpulih_tanggal = MyFormatter::formatDateTimeForUser($model->masukruanganpulih_tanggal);

    if (isset($_POST['PasienruangpulihT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $this->ok = true;

      try {

        $pasienRI = PasienrawatinapV::model()->findByAttributes(array(
          'pasienadmisi_id' => $model->pasienadmisi_id,
        ));


        $model->attributes = $_POST['PasienruangpulihT'];
        $model->masukruanganpulih_tanggal = MyFormatter::formatDateTimeForDB($model->masukruanganpulih_tanggal);


        if (empty($model->masukkamar_id)) {



          // == PINDAH KAMAR ==/
          $pindahkamar = $this->simpanPindahKamar($_POST['PindahkamarT'], $model);

          // update masuk kamar lama
          if (!empty($pasienRI->masukkamar_id)) {
            $masukkamar_lama = MasukkamarT::model()->findByPk($pasienRI->masukkamar_id);
            $masukkamar_lama->pindahkamar_id = $pindahkamar->pindahkamar_id;
            $masukkamar_lama->tglkeluarkamar = $pindahkamar->tglpindahkamar;
            $masukkamar_lama->jamkeluarkamar = $pindahkamar->jampindahkamar;
            $masukkamar_lama->lamadirawat_kamar = CustomFunction::hitungHari($masukkamar_lama->tglmasukkamar, $masukkamar_lama->tglkeluarkamar);

            $this->ok = $this->ok && $masukkamar_lama->save();

            //                    var_dump($this->ok, $masukkamar_lama->attributes, $pindahkamar->attributes);
            //                    die;
          }

          if (!empty($admisi->kamarruangan_id)) {
            //echo "Kick1"; die;
            KamarruanganM::model()->updateByPk(
              $admisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          }

          $admisi->ruangan_id = $pindahkamar->ruangan_id;
          $admisi->kelaspelayanan_id = $pindahkamar->kelaspelayanan_id;
          $admisi->kamarruangan_id = $pindahkamar->kamarruangan_id;
          $this->ok = $this->ok && $admisi->save();

          $masukkamar = $this->simpanMasukKamar($admisi, $pindahkamar);

          $pindahkamar->masukkamar_id = $masukkamar->masukkamar_id;
          $this->ok = $this->ok && $pindahkamar->save();

          if (!empty($pindahkamar->kamarruangan_id)) {
            /* update_kamar_ruangan */
            KamarruanganM::model()->updateByPk(
              $pindahkamar->kamarruangan_id,
              array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN) //'IN USE'
            );
          }

          $model->masukkamar_id = $masukkamar->masukkamar_id;
        }

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;


        // var_dump($model->attributes); die;

        // insert Pasien Ruang Pulih
        if ($model->validate()) {
          $this->ok = $this->ok && $model->save();

          // die;
        } else {
          $this->ok = false;
          // var_dump($model->errors);
        }


        // simpan data Aldrette Masuk
        if (isset($_POST['AldrettepasienruangpulihT'])) {
          $skor->attributes = $_POST['AldrettepasienruangpulihT'];
          $skor->pasienruangpulih_id = $model->pasienruangpulih_id;

          if ($skor->isNewRecord) {
            $skor->create_time = date('Y-m-d H:i:s');
            $skor->create_loginpemakai_id = Yii::app()->user->id;
            $skor->create_ruangan = Yii::app()->user->getState('ruangan_id');
          }
          $skor->update_time = date('Y-m-d H:i:s');
          $skor->update_loginpemakai_id = Yii::app()->user->id;


          if ($skor->validate()) {
            $this->ok = $this->ok && $skor->save();
          } else {
            $this->ok = false;
          }

          //                    var_dump($skor->attributes); die;
        }

        //                var_dump($this->ok, $pindahkamar->attributes, $model->attributes, $_POST);
        //                die;

        if ($this->ok) {
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
      'masukkamar' => $masukkamar,
      'pindahkamar' => $pindahkamar,
    ));
  }


  public function actionKeluar($pasienmasukpenunjang_id)
  {
    $model = PasienruangpulihT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));



    if (empty($model)) {
      echo "Harus dilakukan masuk ke ruang pulih terlebih dahulu";
      Yii::app()->end();
    }

    $model->setScenario("keluar");
    $model->petugas_saatkeluarruangpulih_id = $model->petugas_saatmasukruangpulih_id;
    if (empty($model->keluarruanganpulih_tanggal)) {
      $model->keluarruanganpulih_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
      $model->keluarruanganpulih_jam = date('H:i:s');
    }

    $pindahkamar = new PindahkamarT;
    $masukkamar = new MasukkamarT;

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $admisi = PasienadmisiT::model()->findByPk($penunjang->pasienadmisi_id);


    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $skor = AldrettepasienruangpulihT::model()->findByAttributes(array(
      'pasienruangpulih_id' => $model->pasienruangpulih_id,
      'jenisaldrette' => 'Keluar Ruang Pulih',
    ));
    if (empty($skor)) {
      $skor = new AldrettepasienruangpulihT;
      $skor->pasienruangpulih_id = $model->pasienruangpulih_id;
      $skor->jenisaldrette = 'Keluar Ruang Pulih';
    }

    $modelNyeri = AsesmentnyeriT::model()->findByPk($model->asesmentnyeri_id);
    if (empty($modelNyeri)) {
      $modelNyeri = new AsesmentnyeriT;
      $modelNyeri->pendaftaran_id = $model->pendaftaran_id;
      $modelNyeri->pasien_id = $model->pasien_id;
      $modelNyeri->keluhannyeri = true;
      $modelNyeri->is_keluhannyeri_dewasa = true;
    }

    if (isset($_POST['PasienruangpulihT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $this->ok = true;

      try {

        $pasienRI = PasienrawatinapV::model()->findByAttributes(array(
          'pasienadmisi_id' => $model->pasienadmisi_id,
        ));

        $model->attributes = $_POST['PasienruangpulihT'];
        $model->keluarruanganpulih_tanggal = MyFormatter::formatDateTimeForDB($model->keluarruanganpulih_tanggal);


        if (empty($model->tindaklanjutpasien_masukkamar_id)) {
          // == PINDAH KAMAR ==/
          $pindahkamar = $this->simpanPindahKamar($_POST['PindahkamarT'], $model, true);

          // update masuk kamar lama
          if (!empty($pasienRI->masukkamar_id)) {
            $masukkamar_lama = MasukkamarT::model()->findByPk($pasienRI->masukkamar_id);
            $masukkamar_lama->pindahkamar_id = $pindahkamar->pindahkamar_id;
            $masukkamar_lama->tglkeluarkamar = $pindahkamar->tglpindahkamar;
            $masukkamar_lama->jamkeluarkamar = $pindahkamar->jampindahkamar;
            $masukkamar_lama->lamadirawat_kamar = CustomFunction::hitungHari($masukkamar_lama->tglmasukkamar, $masukkamar_lama->tglkeluarkamar);

            $this->ok = $this->ok && $masukkamar_lama->save();

            //                    var_dump($this->ok, $masukkamar_lama->attributes, $pindahkamar->attributes);
            //                    die;
          }

          if (!empty($admisi->kamarruangan_id)) {
            //echo "Kick1"; die;
            KamarruanganM::model()->updateByPk(
              $admisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          }

          $admisi->ruangan_id = $pindahkamar->ruangan_id;
          $admisi->kelaspelayanan_id = $pindahkamar->kelaspelayanan_id;
          $admisi->kamarruangan_id = $pindahkamar->kamarruangan_id;
          $this->ok = $this->ok && $admisi->save();

          $masukkamar = $this->simpanMasukKamar($admisi, $pindahkamar);

          $pindahkamar->masukkamar_id = $masukkamar->masukkamar_id;
          $this->ok = $this->ok && $pindahkamar->save();

          if (!empty($pindahkamar->kamarruangan_id)) {
            /* update_kamar_ruangan */
            KamarruanganM::model()->updateByPk(
              $pindahkamar->kamarruangan_id,
              array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN) //'IN USE'
            );
          }

          $model->tindaklanjutpasien_masukkamar_id = $masukkamar->masukkamar_id;
          $model->tindaklanjutpasien_ruanganrawat_id = $masukkamar->ruangan_id;
          $model->tindaklanjutpasien_kamarruangan_id = $masukkamar->kamarruangan_id;
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;


        if ($model->validate()) {
          $this->ok = $this->ok && $model->save();

          // die;
        } else {
          $this->ok = false;
          // var_dump($model->errors);
        }


        // simpan data Aldrette Masuk
        if (isset($_POST['AldrettepasienruangpulihT'])) {
          $skor->attributes = $_POST['AldrettepasienruangpulihT'];
          $skor->pasienruangpulih_id = $model->pasienruangpulih_id;

          if ($skor->isNewRecord) {
            $skor->create_time = date('Y-m-d H:i:s');
            $skor->create_loginpemakai_id = Yii::app()->user->id;
            $skor->create_ruangan = Yii::app()->user->getState('ruangan_id');
          }
          $skor->update_time = date('Y-m-d H:i:s');
          $skor->update_loginpemakai_id = Yii::app()->user->id;


          if ($skor->validate()) {
            $this->ok = $this->ok && $skor->save();
          } else {
            $this->ok = false;
          }

          //                    var_dump($skor->attributes); die;
        }


        if (isset($_POST['VerifikasikeluarRuangpulihT'])) {

          $ver = VerifikasikeluarRuangpulihT::model()->findByAttributes(array(
            'pasienruangpulih_id' => $model->pasienruangpulih_id,
          ));

          if (empty($ver)) {
            $ver = new VerifikasikeluarRuangpulihT;
          }

          $ver->attributes = $_POST['VerifikasikeluarRuangpulihT'];
          $ver->petugasruangpulih_id = $model->petugas_saatmasukruangpulih_id;
          $ver->pasienruangpulih_id = $model->pasienruangpulih_id;
          $ver->dokteranastesi_id = $model->dokteranastesi_id;
          $ver->perawatanastesi_id = $model->perawatanastesi_id;

          if ($ver->isNewRecord) {
            $ver->create_time = date('Y-m-d H:i:s');
            $ver->create_loginpemakai_id = Yii::app()->user->id;
            $ver->create_ruangan = Yii::app()->user->getState('ruangan_id');
          }
          $ver->update_time = date('Y-m-d H:i:s');
          $ver->update_loginpemakai_id = Yii::app()->user->id;

          if ($ver->validate()) {
            $this->ok = $this->ok && $ver->save();
          } else {
            $this->ok = false;
          }
        }

        if (!empty($model->pasienruangpulih_id)) {
          CatatankhususRuangpulihT::model()->deleteAllByAttributes(array(
            'pasienruangpulih_id' => $model->pasienruangpulih_id,
          ));
        }

        if (isset($_POST['CatatankhususRuangpulihT']['detail'])) {
          foreach ($_POST['CatatankhususRuangpulihT']['detail'] as $item) {
            $catatan = new CatatankhususRuangpulihT();
            $catatan->attributes = $item;
            $catatan->pasienruangpulih_id = $model->pasienruangpulih_id;
            $catatan->create_time = date('Y-m-d H:i:s');
            $catatan->create_loginpemakai_id = Yii::app()->user->id;
            $catatan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $catatan->update_time = date('Y-m-d H:i:s');
            $catatan->update_loginpemakai_id = Yii::app()->user->id;


            $this->ok = $this->ok && $catatan->save();
          }
        }


        if (isset($_POST['AsesmentnyeriT'])) {

          $nyeri = AsesmentnyeriT::model()->findByPk($model->asesmentnyeri_id);

          if (empty($nyeri)) {
            $nyeri = new AsesmentnyeriT;
          }
          $nyeri->attributes = $model->attributes;
          $nyeri->attributes = $_POST['AsesmentnyeriT'];
          $nyeri->keluhannyeri = true;
          $nyeri->is_keluhannyeri_dewasa = true;
          $nyeri->tglpemeriksaannyeri = $model->keluarruanganpulih_tanggal . " " . $model->keluarruanganpulih_jam;
          $nyeri->pegawaipemeriksa_id = $model->dokteranastesi_id;
          $nyeri->create_ruangan_id = $model->create_ruangan;

          if ($nyeri->validate()) {
            $this->ok = $this->ok && $nyeri->save();

            $model->asesmentnyeri_id = $nyeri->asesmentnyeri_id;
            $model->score_skalanyeri = $nyeri->score_skalanyeri;
            $model->keteranganskala_nyeri = $nyeri->keteranganskala_nyeri;
            $this->ok = $this->ok && $model->save();
          } else {
            $this->ok = false;
            var_dump($nyeri->errors);
          }
        }

        //                var_dump($this->ok, $model->attributes, $_POST); die;



        if ($this->ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('keluar', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        var_dump($ex->getMessage());
        die;
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }



    $this->render('keluar', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'masukkamar' => $masukkamar,
      'pindahkamar' => $pindahkamar,
      'modelNyeri' => $modelNyeri,
    ));
  }

  public function simpanPindahKamar($post, $model, $is_keluar = false)
  {

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
    ));


    $mod = new PindahkamarT();
    $mod->attributes = $model->attributes;
    $mod->attributes = $post;

    if ($is_keluar) {
      $mod->masukkamar_id = null;
    }


    $mod->pendaftaran_id = $model->pendaftaran_id;
    $mod->pegawai_id = $model->dokteranastesi_id;
    $mod->tglpindahkamar = $model->masukruanganpulih_tanggal;
    $mod->jampindahkamar = $model->masukruanganpulih_jam;
    $mod->shift_id = Yii::app()->user->getState('shift_id');
    $mod->carabayar_id = $penunjang->carabayar_id;
    $mod->penjamin_id = $penunjang->penjamin_id;

    $kamar = KamarruanganM::model()->findByPk($mod->kamarruangan_id);
    $mod->kelaspelayanan_id = $kamar->kelaspelayanan_id;
    $mod->nopindahkamar = MyGenerator::noPindahKamar($mod->ruangan_id);

    //         var_dump($mod->attributes, $model->attributes, $post); die;


    if ($mod->validate()) {
      $this->ok = $this->ok && $mod->save();
    } else {
      $this->ok = false;
    }
    //var_dump($this->ok, $mod->attributes, $post, $model->attributes);
    //die;

    return $mod;
  }

  public function simpanMasukKamar($admisi, $pindahkamar)
  {

    $mod = new MasukkamarT();
    $mod->attributes = $pindahkamar->attributes;
    $mod->pindahkamar_id = null;
    $mod->masukkamar_id = null;
    $mod->nomasukkamar = MyGenerator::noMasukKamar($admisi->ruangan_id);
    $mod->tglmasukkamar = $pindahkamar->tglpindahkamar;
    $mod->jammasukkamar = $pindahkamar->jampindahkamar;
    $mod->kelaspelayanan_id = $pindahkamar->kelaspelayanan_id;
    $mod->create_time = date('Y-m-d H:i:s');
    $mod->create_loginpemakai_id = Yii::app()->user->id;
    $mod->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $mod->kamarruangan_id = !empty($pindahkamar->kamarruangan_id) ? $pindahkamar->kamarruangan_id : null;
    if ($mod->validate()) {
      $this->ok = $this->ok && $mod->save();
    } else {
      $this->ok = false;
    }

    //        var_dump($this->ok, $mod->attributes, $admisi->attributes, $pindahkamar->attributes);
    //        die;

    return $mod;
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PasienruangpulihT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pasienruangpulih-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new PasienruangpulihT;
    $model->attributes = $_REQUEST['PasienruangpulihT'];
    $judulLaporan = 'Data PasienruangpulihT';
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

  public function actionGetKamarKosong($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kamarKosong = array();
      if (!empty($ruangan_id)) {
        $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
        $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (count((array)$kamarKosong) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          }
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
