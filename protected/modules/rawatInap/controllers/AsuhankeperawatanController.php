<?php

class AsuhankeperawatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $successPlanning = true;
  public $successImplementasi = true;
  public $successIntervensi = true;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
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
    $model = new RIAsuhankeperawatanT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RIAsuhankeperawatanT'])) {

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->asuhankeperawatan_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
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


    if (isset($_POST['RIAsuhankeperawatanT'])) {
      $model->attributes = $_POST['RIAsuhankeperawatanT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->asuhankeperawatan_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

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
    $model = new RIAsuhankeperawatanT;
    $modPasien = new RIInfokunjunganriV();
    $modAnamnesa = new RIAnamnesaT();
    $modPeriksaFisik = new RIPemeriksaanFisikT();
    $modPasienRIV = new RIPasienRawatInapV();
    $model->tglaskep = date('Y-m-d H:i:s');
    $modPasienRIV->unsetAttributes();
    if (isset($_GET['RIPasienrawatinapV'])) {
      $modPasienRIV->attributes = $_GET['RIPasienrawatinapV'];
    }

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RIAsuhankeperawatanT'])) {
      $model->attributes = $_POST['RIAsuhankeperawatanT'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->shift_id = Yii::app()->user->getState('shift_id');
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = $successIntervensi = $successPlanning = $successImplementasi = true;
        $jumlahAskep = $jumlahIntervensi = $jumlahPlanning = $jumlahImplementasi = 0;
        $jumlah = count((array)$_POST['AsuhankeperawatanT']['diagnosakeperawatan_id']);
        $data = AsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        /**
         * Date     : 4 Agustus 2014
         * Issue    : RND-1187
         * Descript : dicomment karena transaksi bisa lebih dari satu.
                 
                if (count((array)$data) > 0){
                    foreach($data as $data){
                        RIIntervensiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        RIImplementasiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        RIPlaningaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        RIAsuhankeperawatanT::model()->deleteByPk($data->asuhankeperawatan_id);
                    }
                }
         * 
         */

        for ($i = 0; $jumlah > $i; $i++) {
          $modAsuhanKeperawatan[$i] = new RIAsuhankeperawatanT();
          $modAsuhanKeperawatan[$i]->attributes = $model->attributes;
          $modAsuhanKeperawatan[$i]->diagnosakeperawatan_id = $_POST['AsuhankeperawatanT']['diagnosakeperawatan_id'][$i];
          $modAsuhanKeperawatan[$i]->diagnosa_id = $_POST['AsuhankeperawatanT']['diagnosa_id'][$i];
          $modAsuhanKeperawatan[$i]->tglassesment = $model->tglaskep;
          $modAsuhanKeperawatan[$i]->evaluasi_objektif = $_POST['AsuhankeperawatanT']['evaluasi_objektif'][$i];
          $modAsuhanKeperawatan[$i]->evaluasi_subjektif = $_POST['AsuhankeperawatanT']['evaluasi_subjektif'][$i];
          $modAsuhanKeperawatan[$i]->evaluasi_assesment = $_POST['AsuhankeperawatanT']['evaluasi_assesment'][$i];
          $modAsuhanKeperawatan[$i]->askep_tujuan = $_POST['AsuhankeperawatanT']['askep_tujuan'][$i];
          $modAsuhanKeperawatan[$i]->askep_kriteriahasil = $_POST['AsuhankeperawatanT']['askep_kriteriahasil'][$i];
          $modAsuhanKeperawatan[$i]->update_time = date("Y-m-d H:i:s");
          $modAsuhanKeperawatan[$i]->update_loginpemakai_id = Yii::app()->user->id;
          //                    echo "<pre>";
          //                    echo print_r($modAsuhanKeperawatan[$i]->getAttributes());
          if ($modAsuhanKeperawatan[$i]->validate()) {
            if ($modAsuhanKeperawatan[$i]->save()) {
              $success = true;
              $jumlahAskep++;
              if (isset($_POST['rencana_intervensi'])) {
                $jumlahDipilihRencanaIntervensi = count((array)$_POST['rencana_intervensi'][$i]);
                for ($b = 0; $jumlahDipilihRencanaIntervensi > $b; $b++) {
                  $modRencana = RIRencanakeperawatanM::model()->findByPk($_POST['rencana_intervensi'][$i][$b]);
                  $modIntervensiAskep[$i][$b] = new RIIntervensiaskepT;
                  $modIntervensiAskep[$i][$b]->rencanakeperawatan_id = $_POST['rencana_intervensi'][$i][$b];
                  $modIntervensiAskep[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  $modIntervensiAskep[$i][$b]->tglmulaiintervensi = $modAsuhanKeperawatan[$i]->tglaskep;
                  $modIntervensiAskep[$i][$b]->intervensi_kode = $modRencana->rencana_kode;
                  $modIntervensiAskep[$i][$b]->intervensi_nama = $modRencana->rencana_intervensi;
                  $modIntervensiAskep[$i][$b]->intervensi_rasionalisasi = $modRencana->rencana_rasionalisasi;
                  $modIntervensiAskep[$i][$b]->iskolaborasi = $modRencana->iskolaborasiintervensi;
                  $modIntervensiAskep[$i][$b]->lama_waktu_jam = 0;
                  if ($modIntervensiAskep[$i][$b]->validate()) {
                    if ($modIntervensiAskep[$i][$b]->save()) {
                      $successIntervensi = true;
                      $jumlahIntervensi++;
                    }
                  }
                }
              }

              if (isset($_POST['ambil_intervensi'])) {
                $jumlahDipilihAmbilIntervensi = count((array)$_POST['ambil_intervensi'][$i]);
                for ($b = 0; $jumlahDipilihAmbilIntervensi > $b; $b++) {
                  $modRencana = RIRencanakeperawatanM::model()->findByPk($_POST['ambil_intervensi'][$i][$b]);
                  $modPlanning[$i][$b] = new RIPlaningaskepT();
                  $modPlanning[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  if ($modRencana->iskolaborasiintervensi == true) {
                    $modPlanning[$i][$b]->kolaborasilanjutan = $modRencana->rencana_intervensi;
                  } else {
                    $modPlanning[$i][$b]->intervensilanjutan = $modRencana->rencana_intervensi;
                  }

                  if ($modPlanning[$i][$b]->validate()) {
                    if ($modPlanning[$i][$b]->save()) {
                      $successPlanning = true;
                      $jumlahPlanning++;
                    }
                  }
                }
              }
              if (isset($_POST['rencana_implementasi'])) {
                $jumlahDipilihImplementasi = count((array)$_POST['rencana_implementasi'][$i]);
                for ($b = 0; $jumlahDipilihImplementasi > $b; $b++) {
                  $modelImplementasi = ImplementasikeperawatanM::model()->findByPk($_POST['rencana_implementasi'][$i][$b]);
                  $modImplementasi[$i][$b] = new RIImplementasiaskepT();
                  $modImplementasi[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  $modImplementasi[$i][$b]->implementasikeperawatan_id = $_POST['rencana_implementasi'][$i][$b];
                  $modImplementasi[$i][$b]->tglmulaiimplementasi = $modAsuhanKeperawatan[$i]->tglaskep;
                  $modImplementasi[$i][$b]->implementasi_nama = $modelImplementasi->implementasi_nama;
                  $modImplementasi[$i][$b]->iskolaborasi = $modelImplementasi->iskolaborasiimplementasi;
                  if ($modImplementasi[$i][$b]->validate()) {
                    if ($modImplementasi[$i][$b]->save()) {
                      $successImplementasi = true;
                      $jumlahImplementasi++;
                    }
                  }
                }
              }
            }
          }
        }
        $jumlahDipilihImplementasi = 0;
        $jumlahDipilihAmbilIntervensi = 0;
        $jumlahDipilihRencanaIntervensi = 0;
        if ($jumlahImplementasi > 0 && $jumlahDipilihImplementasi > 0 && $jumlahImplementasi != $jumlahDipilihImplementasi)
          $successImplementasi = false;
        if ($jumlahPlanning > 0 && $jumlahDipilihAmbilIntervensi > 0 && $jumlahPlanning != $jumlahDipilihAmbilIntervensi)
          $successPlanning = false;
        if ($jumlahIntervensi > 0 && $jumlahDipilihRencanaIntervensi > 0 && $jumlahIntervensi != $jumlahDipilihRencanaIntervensi)
          $successIntervensi = false;
        if ($jumlahDipilihImplementasi == 0)
          $successImplementasi = true;
        if ($jumlahDipilihAmbilIntervensi == 0)
          $successPlanning = true;
        if ($jumlahDipilihRencanaIntervensi == 0)
          $successIntervensi = true;

        if ($success && $successPlanning && $successImplementasi && $successIntervensi) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Asuhan Keperawatan berhasil disimpan");
          //                    $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modPasien' => $modPasien, 'modPasienRIV' => $modPasienRIV,
      'modAnamnesa' => $modAnamnesa,
      'modPeriksaFisik' => $modPeriksaFisik,
      'model' => $model,
    ));
  }

  public function actionRiwayatAsuhan()
  {
    $this->layout = '//layouts/iframe';
    $this->render(
      '_riwayatAsuhanKeperawatan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailDiagnosaKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->findByPk($id);
    $modDiagnosaKeperawatanSearch = new RIAsuhankeperawatanT('search');
    $this->render(
      '_diagnosa',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailRencanaKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RIAsuhankeperawatanT('search');
    $this->render(
      '_rencana',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailEvaluasiKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RIAsuhankeperawatanT('search');
    $this->render(
      '_evaluasi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailPlanningKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RIAsuhankeperawatanT('search');
    $this->render(
      '_planning',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionGetRiwayatPasien()
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $noRekamMedik = RIPasienM::model()->findByPk($modPendaftaran->pasien_id)->no_rekam_medik;

    $criteria = new CDbCriteria(array(
      'condition' => "no_rekam_medik ='" . $noRekamMedik . "' and ruangan_id =" . Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(InfokunjunganrjV::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);
    $modKunjungan = InfokunjunganriV::model()->findAll($criteria);
    $tr = '';
    foreach ($modKunjungan as $row) {
      $modPendaftaran = PendaftaranT::model()->findByPk($row->pendaftaran_id);
      $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
      $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('pasien_id' => $row->pasien_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA));
      $asuhan = AsuhankeperawatanT::model()->findByAttributes(array('pasien_id' => $row->pasien_id, 'pendaftaran_id' => $row->pendaftaran_id, 'ruangan_id' =>  Yii::app()->user->getState('ruangan_id')), array('order' => 'tglaskep DESC'));
      $tr .= "<tr>
                            <td>" . $row->tgl_pendaftaran . '<br/>' . $row->no_pendaftaran . "</td>
                            <td>" . (isset($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : "") . "</td>
                            <td>" . (isset($modAnamnesa->riwayatpenyakitterdahulu) ? $modAnamnesa->riwayatpenyakitterdahulu : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->tekanandarah) ? $modPendaftaran->pemeriksaanfisikTs->tekanandarah : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->detaknadi) ? $modPendaftaran->pemeriksaanfisikTs->detaknadi : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->suhutubuh) ? $modPendaftaran->pemeriksaanfisikTs->suhutubuh : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->tinggibadan_cm) ? $modPendaftaran->pemeriksaanfisikTs->tinggibadan_cm : "") . "<br/>" . (isset($modPendaftaran->pemeriksaanfisikTs->beratbadan_kg) ? $modPendaftaran->pemeriksaanfisikTs->beratbadan_kg : "") . "</td>
                            <td>" . (isset($diagnosa->diagnosa->diagnosa_nama) ? $diagnosa->diagnosa->diagnosa_nama : "") . "</td>
                            <td>" . (isset($asuhan->tglaskep) ? $asuhan->tglaskep : "") . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailDiagnosaKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Diagnosa Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Diagnosa Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailRencanaKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Rencana Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Rencana Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailEvaluasiKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Evaluasi Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Evaluasi Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailPlanningKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Planning Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Planning Keperawatan")) . "</td>                                    
                         </tr>";
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_riwayatAsuhanKeperawatan', array('tr' => $tr, 'pages' => $pages), true)
      ));
      exit;
    }

    //            $this->render('_riwayatAsuhanKeperawatan', 
    //                    array('tr'=>$tr,        
    //                        'pages'=>$pages
    //                        ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RIAsuhankeperawatanT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RIAsuhankeperawatanT']))
      $model->attributes = $_GET['RIAsuhankeperawatanT'];

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
    $model = RIAsuhankeperawatanT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rjasuhankeperawatan-t-form') {
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
    $model = new RIAsuhankeperawatanT;
    $model->attributes = $_REQUEST['RIAsuhankeperawatanT'];
    $judulLaporan = 'Data RIAsuhankeperawatanT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->session['posisi_kertas'];                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetDiagnosaKeperawatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $diagnosakeperawatan_id = (isset($_POST['idDiagnosaKeperawatan']) ? $_POST['idDiagnosaKeperawatan'] : null);
      $modDiagnosaKeperawatan = DiagnosakeperawatanM::model()->findByPk($diagnosakeperawatan_id);
      $modRencana = RencanakeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $modDiagnosaKeperawatan->diagnosakeperawatan_id));
      $modImplementasi = ImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $modDiagnosaKeperawatan->diagnosakeperawatan_id));
      $data1 = '';
      $data2 = '';
      $tr = $tr2 = $tr3 = '';
      if (count((array)$modRencana) > 0) {
        $data1 .= '<ul id="intervensi">';
        foreach ($modRencana as $row) {
          if (empty($row->iskolaborasiintervensi)) {
            $row->iskolaborasiintervensi = 0;
          }
          $data1 .= '<li>' . CHtml::checkBox('rencana_intervensi[][]', false, array('value' => $row->rencanakeperawatan_id, 'onclick' => 'submitIntervensi(this);', 'class' => 'intervensi_check', 'textData' => $row->rencana_intervensi, 'valuedata' => $row->rencanakeperawatan_id, 'kolaborasi' => $row->iskolaborasiintervensi, 'value' => $row->rencanakeperawatan_id)) . '<span>' . $row->rencana_intervensi . '</span></li>';
        }
        $data1 .= '</ul>';
      }
      if (count((array)$modImplementasi) > 0) {
        $data2 .= '<ul id="implementasi">';
        foreach ($modImplementasi as $row) {
          $data2 .= '<li>' . CHtml::checkBox('rencana_implementasi[][]', false, array('onclick' => 'warnai(this)', 'class' => 'implementasi_check', 'textData' => $row->implementasi_nama, 'valueData' => $row->implementasikeperawatan_id, 'value' => $row->implementasikeperawatan_id)) . '<span>' . $row->implementasi_nama . '</span></li>';
        }
        $data2 .= '</ul>';
      }
      if (count((array)$modDiagnosaKeperawatan) > 0) {
        $model = new AsuhankeperawatanT;
        $tr .= "<tr>
                                <td><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosa_keperawatan, array('class' => 'span2', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                    " . CHtml::activeHiddenField($model, 'diagnosakeperawatan_id[]', array('value' => $diagnosakeperawatan_id, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "
                                    " . CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "
                                </td>
                                <td>" . $data1 . "</td>
                                <td>" . $data2 . "</td>                            
                            </tr>
                            ";
        //<td>".CHtml::activeDropDownList($model, 'evaluasi_assesment[]', CHtml::listData($models, $valueField, $textField), $htmlOptions)($model, 'evaluasi_obbjektif', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
        $tr2 .= "<tr>
                                <td width='160px'><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosa_keperawatan, array('class' => 'span2', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                    " . CHtml::activeHiddenField($model, 'diagnosa_id[]', array('value' => $modDiagnosaKeperawatan->diagnosa_id, 'class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) .
          CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'evaluasi_subjektif[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'evaluasi_objektif[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeDropDownList($model, 'evaluasi_assesment[]', LookupM::getItems('evaluasi_assesment'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'askep_tujuan[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>                               
                                <td>" . CHtml::activeTextArea($model, 'askep_kriteriahasil[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            </tr>";
        $tr3 .= "<tr>

                                <td width='160px'><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosa_keperawatan, array('class' => 'span2', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                                  " . CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>
                                <table class='block'>
                                    <tr>
                                        <td>
                                            <div class='boxtindakan'>
                                                <h6>Intervensi</h6>
                                                <div class='isi_inter'>
                                                    <ul></ul>
                                                </div>
                                            </div>
                                         </td>                                     
                                        <td>
                                            <div class='boxtindakan'>
                                                <h6>Yang Diambil</h6>
                                                <div class='ambil_inter'>
                                                    <ul></ul>
                                                </div>
                                            </div>
                                         </td>                                                          
                                         </tr>
                                         <tr>
                                        <td>
                                            <div class='boxtindakan'>
                                                <h6>Kolaborasi</h6>
                                                <div class='isi_kolab'>
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='boxtindakan'>
                                                <h6>Yang Diambil</h6>
                                                <div class='ambil_kolab'>
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </td>
                                  </tr>
                              </table>
                              </td>
                            </tr>
                                ";
      }
      $data['tr'] = $tr;
      $data['tr2'] = $tr2;
      $data['tr3'] = $tr3;
      //           $data['jam']=$jam;
      $data['id'] = $diagnosakeperawatan_id;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
