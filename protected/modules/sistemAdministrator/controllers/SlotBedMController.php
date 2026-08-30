<?php

class SlotBedMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $path_view = 'sistemAdministrator.views.slotBedM.';
  public $defaultAction = 'admin';

  public function actionDynamicRuangan()
  {
    if (!empty($_POST['PasienM']['propinsi_id'])) {
      $propinsi = $_POST['PasienM']['propinsi_id'];
    } else {
      $propinsi = $_POST['PendaftaranadmisiV']['propinsi_id'];
    }
    if (isset($_POST['propinsi_nama'])) {
      $data = KabupatenM::model()->findAll('propinsi_id=:prop_id ORDER BY kabupaten_nama', array(':prop_id' => (int) $_POST['KecamatanM']['propinsi_id'],));
    } else {
      $data = KabupatenM::model()->findAll('propinsi_id=:prop_id ORDER BY kabupaten_nama', array(':prop_id' => (int) $propinsi,));
    }

    $data = CHtml::listData($data, 'kabupaten_id', 'kabupaten_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view.'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SASlotBedM;

    
    $ins_id = !empty($this->module->id == 'hemodialisa')?Yii::app()->user->getState('instalasi_id'):null;
    $model->instalasi_id = empty($ins_id)?Params::INSTALASI_ID_RI:$ins_id;
    $instalasiTujuans = CHtml::listData(SAInstalasiM::getInstalasiItems($ins_id), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(SARuanganM::getRuanganByInstalasi($model->instalasi_id), 'ruangan_id', 'ruangan_nama');

    $modRiwayatRuanganR = new SARiwayatRuanganR;
    $modRiwayatRuanganR->tglpenetapanruangan = date('Y-m-d');
    // Uncomment the following line if AJAX validation is needed

    
    if (isset($_POST['SASlotBedM'])) {
      // var_dump($_POST); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $photo = CUploadedFile::getInstance($model, 'slotbed_image');
        $random = rand(000000, 999999);
        $gambar = $photo;
        if (!empty($photo)) { //Klo User Memasukan Logo
          Yii::import("ext.EPhpThumb.EPhpThumb");
          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed
          $fullImgName = $random . $photo;
          //echo $photo;exit;
          $fullImgSource = Params::pathSlotBedDirectory() . $fullImgName;
          $fullThumbSource = Params::pathSlotBedTumbsDirectory() . 'kecil_' . $fullImgName;


          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);
        }
        // vaR_dump($_POST);
        for ($i = 0; $i < count((array)$_POST['SASlotBedM']['slotbed_nobed']); $i++) {

          $model = new SASlotBedM;
          $modRiwayatRuanganR = new SARiwayatRuanganR;

          $modRiwayatRuanganR->attributes = $_POST['SARiwayatRuanganR'];
          $modRiwayatRuanganR->save();
          $model->attributes = $_POST['SASlotBedM'];
          if (!empty($photo)) {
            $model->slotbed_image = $fullImgName;
          }
          $model->slotbed_nobed = $_POST['SASlotBedM']['slotbed_nobed'][$i];
          // $model->is_bedbayangan = $_POST['SASlotBedM']['is_bedbayangan'][$i] ?? false;
          $model->jadwal_buka = $model->jadwal_mulai." s/d ".$model->jadwal_tutup;
          $model->slotbed_noslot = $_POST['SASlotBedM']['slotbed_noslot'];
          $model->riwayatruangan_id = $modRiwayatRuanganR->riwayatruangan_id;
          $model->slotbed_aktif = TRUE;
          //                               $model->slotbed_status=FALSE;
          //modifi 20 Feb 2013 //
          $model->slotbed_status = TRUE;
          // end modifi //
          $model->save();  
          
          // var_dump($model->attributes, $model->errors);
        }

        // die;
        $transaction->commit();

        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
      } catch (Exception $exc) {          
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view.'create', array(
      'model' => $model,
      'modRiwayatRuanganR' => $modRiwayatRuanganR,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
            
      $models = null;
      $models = CHtml::listData(SARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (!empty($instalasi_id)){
            if (count((array)$models) > 0) {
              foreach ($models as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
              }
            }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  //public function actionUpdate($id)
  public function actionUpdate($id, $kelaspelayanan_id, $ruangan_id, $slotbed_noslot)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    $model->slotbed_jmlbed = $model->getTotalBed($kelaspelayanan_id, $ruangan_id, $slotbed_noslot);
    //$model=

    $loadSlot = $model->LoadSlot($kelaspelayanan_id, $ruangan_id, $slotbed_noslot);
    // Uncomment the following line if AJAX validation is needed

    $model->slotTerpakai = ($model->slotbed_status == true) ? false : true;

    if (isset($_POST['SASlotBedM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
//      var_dump($_POST); die;
      try {
        $model->attributes = $_POST['SASlotBedM'];

        if (isset($_POST['SlotbedM']['banyakbed'])) {

          foreach ($_POST['SlotbedM']['banyakbed'] as $key => $val) {
            if (empty($val['slotbed_id'])) {
              $modSlot = new SlotbedM;
              $modSlot->attributes = $model->attributes;
              $model->jadwal_buka = $model->jadwal_mulai . ' s/d ' . $model->jadwal_tutup;
              $modSlot->attributes = $_POST['SlotbedM']['banyakbed'][$key];
              $modSlot->slotbed_status = ($val['slotTerpakai'] == true) ? false : true;
            } else {
              $modSlot = SlotbedM::model()->findByPk($val['slotbed_id']);
              $modSlot->attributes = $model->attributes;
              $model->jadwal_buka = $model->jadwal_mulai . ' s/d ' . $model->jadwal_tutup;
              $modSlot->attributes = $_POST['SlotbedM']['banyakbed'][$key];
              $modSlot->slotbed_status = ($val['slotTerpakai'] == true) ? false : true;
            }
//            var_dump($modSlot->attributes);
            $ok = $ok && $modSlot->save();
          }
        }
        //var_dump($_POST['SASlotBedM']);die;
//        	die;
        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => $model->slotbed_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } catch (Exception $e) {
        echo $e->getMessage();
        die;
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Berhasil!</strong> Data gagal disimpan.');
      }
    }

    $this->render($this->path_view.'update', array(
      'model' => $model,
      'loadSlot' => $loadSlot
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SASlotBedM');
    $this->render($this->path_view.'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Slot Bed";
    $model = new SASlotBedM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SASlotBedM']))
      $model->attributes = $_GET['SASlotBedM'];
    $model->instalasi_id = isset($_GET['SASlotBedM']['instalasi_id']) ? $_GET['SASlotBedM']['instalasi_id'] : null;

    $this->render($this->path_view.'admin', array(
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
    $model = SASlotBedM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saslot-bed-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
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
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SASlotBedM::model()->updateByPk($id, array('slotbed_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  public function actionPrint()
  {

    $model = new SASlotBedM;
    $model->attributes = $_GET['SASlotBedM'];
    $judulLaporan = 'Data Slot Bed';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }


  public function actionPenjadwalan() {
    $model = new SlotBedM();
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $jadwal = $_POST['slotBed'];
        $error = array();
        $error2 = array();
        $data = array();
        $allError = true;
        $error2[0] = '';
        $jumlahDokter = 0;
        foreach ($jadwal as $key => $value) {
            if (empty($jadwal[$key])) {
                $error2[] = 'slotBed[' . $key . ']';
                $allError = false;
            }
        }
        $dokter = null;
        if (count($jadwal['jadwal']) > 0) {
            unset($error2[0]);
            foreach ($jadwal['jadwal'] as $key => $value) {
                foreach ($value['dokter'] as $i => $row) {
                    if (isset($row['cek']) && $row['cek'] == 1) {
                        if (isset($row['dokter']) && count($row['dokter']) > 0) {
                            foreach ($row['dokter'] as $j => $row2) {
                                $slotBed = new SlotBedM();
                                $slotBed->attributes = $row2;
                                $slotBed->instalasi_id = (isset($_POST['slotBed']['instalasi_id']) ? $_POST['slotBed']['instalasi_id'] : null);
                                $slotBed->jadwal_hari = $value['jadwal_hari'];
                                $slotBed->jadwal_tgl = $value['jadwal_tgl'];
                                $slotBed->jadwal_buka = $row2['jadwal_mulai'] . ' s/d ' . $row2['jadwal_tutup'];
                                $slotBed->ruangan_id = $row['ruangan_id'];
                                $slotBed->instalasi_id = $jadwal['instalasi'];
                                if (!$slotBed->validate()) {
                                    $allError = false;
                                    foreach ($slotBed->getErrors() as $x => $y) {
                                        $error['slotBed[jadwal][' . $key . '][dokter][' . $slotBed->ruangan_id . '][dokter][' . $j . '][' . $x . ']'] = $y;
                                    }
                                } else {
                                    $jumlahDokter += count($row['dokter']);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (count($jadwal['jadwal']) == 0 || $jumlahDokter == 0) {
            $error2[0] = 'Jadwal Dokter Detail Tidak Boleh Kosong.';
            $allError = false;
        }
        $data['error'] = ($allError) ? 'no' : $error;
        $data['error2'] = $error2;
        echo json_encode($data);
        Yii::app()->end();
    }
    // exit(json_encode($_POST));

    if (isset($_POST['slotBed'])) {
        $jadwal = $_POST['slotBed'];

        $detail = isset($_POST['detail']) ? $_POST['detail'] : [];

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $ok = true;


            foreach ($detail as $det) {

                if (!isset($det['ceklis'])) {
                    continue;
                }

                /*
                $jadwal_id = $det['jadwal_id'];
                if (!empty($jadwal_id)) {
                    $model = SlotBedM::model()->findByPk($jadwal_id);

                    if (empty($model)) {
                        $model = new SlotBedM;
                    }
                } else {
                    */
                    $model = new SlotBedM;
                    /*
                }
                */

                // var_dump($model->isNewRecord);

                $model->attributes = $jadwal;
                $model->slotbed_id = null;
                $model->attributes = $det;
                // $model->estimasipelayanan = $det['estimasipelayanan'];
                $model->jadwal_buka = $model->jadwal_mulai." s/d ".$model->jadwal_tutup;
                $model->jadwal_hari = MyFormatter::getDayUser($det['hari']);

                // var_dump($model->attributes, $det);
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }

                // var_dump($det);
            }

            // die;
            
            if ($ok) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'sukses' => 1));
                //$this->refresh();
            } else {
                var_dump($model->getErrors());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
            }
        } catch (Exception $exc) {
                var_dump($exc);die;
//
            $transaction->rollback();
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.', MyExceptionMessage::getMessage($exc));
        }
    }
    $this->render($this->path_view . 'penjadwalan', array('model' => $model));
}
}
