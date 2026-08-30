<?php

class AsuhankeperawatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

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
    $model = new RJAsuhankeperawatanT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RJAsuhankeperawatanT'])) {

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


    if (isset($_POST['RJAsuhankeperawatanT'])) {
      $model->attributes = $_POST['RJAsuhankeperawatanT'];
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

    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new RJAsuhankeperawatanT;
    $modPasien = new RJInfokunjunganrjV();
    $modAnamnesa = new RJAnamnesaT();
    $modPeriksaFisik = new RJPemeriksaanFisikT();
    $modMasukKamar = null;
    $model->tglaskep = date('Y-m-d H:i:s');
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RJAsuhankeperawatanT'])) {

      echo $_POST['AsuhankeperawatanT']['evaluasi_subjektif'][0];
      $model->attributes = $_POST['RJAsuhankeperawatanT'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->shift_id = Yii::app()->user->getState('shift_id');
      $model->pasienadmisi_id = null;
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //echo count((array)$_POST['AsuhankeperawatanT']['evaluasi_assesment']);
      //echo $_POST['AsuhankeperawatanT']['evaluasi_assesment'][0][0];
      //exit();
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = count((array)$_POST['AsuhankeperawatanT']['diagnosakeperawatan_id']);
        $data = AsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        if (count((array)$data) > 0) {
          foreach ($data as $data) {
            RJIntervensiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id' => $data->asuhankeperawatan_id));
            RJImplementasiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id' => $data->asuhankeperawatan_id));
            RJPlaningaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id' => $data->asuhankeperawatan_id));
            RJAsuhankeperawatanT::model()->deleteByPk($data->asuhankeperawatan_id);
          }
        }

        for ($i = 0; $jumlah > $i; $i++) {
          $modAsuhanKeperawatan = new RJAsuhankeperawatanT();
          $modAsuhanKeperawatan->attributes = $model->attributes;
          $modAsuhanKeperawatan->diagnosakeperawatan_id = $_POST['AsuhankeperawatanT']['diagnosakeperawatan_id'][$i];
          $modAsuhanKeperawatan->tglassesment = $model->tglaskep;
          $modAsuhanKeperawatan->evaluasi_objektif = $_POST['AsuhankeperawatanT']['evaluasi_objektif'][$i];
          $modAsuhanKeperawatan->evaluasi_subjektif = $_POST['AsuhankeperawatanT']['evaluasi_subjektif'][$i];
          $modAsuhanKeperawatan->evaluasi_assesment = $_POST['AsuhankeperawatanT']['evaluasi_assesment'][$i];
          $modAsuhanKeperawatan->askep_tujuan = $_POST['AsuhankeperawatanT']['askep_tujuan'][$i];
          $modAsuhanKeperawatan->askep_kriteriahasil = $_POST['AsuhankeperawatanT']['askep_kriteriahasil'][$i];
          // echo "<pre>"; print_r($modAsuhanKeperawatan->attributes);exit;
          if ($modAsuhanKeperawatan->save()) {
            $jumlahDipilihRencanaIntervensi = (isset($_POST['rencana_intervensi'][$i]) ? count((array)$_POST['rencana_intervensi'][$i]) : null);
            for ($b = 0; $jumlahDipilihRencanaIntervensi > $b; $b++) {
              $modRencana = RJRencanakeperawatanM::model()->findByPk($_POST['rencana_intervensi'][$i][$b]);
              $modIntervensiAskep = new RJIntervensiaskepT;
              $modIntervensiAskep->rencanakeperawatan_id = $_POST['rencana_intervensi'][$i][$b];
              $modIntervensiAskep->asuhankeperawatan_id = $modAsuhanKeperawatan->asuhankeperawatan_id;
              $modIntervensiAskep->tglmulaiintervensi = $model->tglaskep;
              $modIntervensiAskep->intervensi_kode = $modRencana->rencana_kode;
              $modIntervensiAskep->intervensi_nama = $modRencana->rencana_intervensi;
              $modIntervensiAskep->intervensi_rasionalisasi = $modRencana->rencana_rasionalisasi;
              $modIntervensiAskep->iskolaborasi = $modRencana->iskolaborasiintervensi;
              $modIntervensiAskep->lama_waktu_jam = 0;

              $modIntervensiAskep->save();
            }

            $jumlahDipilihAmbilIntervensi = (isset($_POST['ambil_intervensi'][$i]) ? count((array)$_POST['ambil_intervensi'][$i]) : null);
            for ($b = 0; $jumlahDipilihAmbilIntervensi > $b; $b++) {
              $modRencana = RJRencanakeperawatanM::model()->findByPk($_POST['ambil_intervensi'][$i][$b]);
              $modPlanning = new RJPlaningaskepT();
              $modPlanning->asuhankeperawatan_id = $modAsuhanKeperawatan->asuhankeperawatan_id;
              if ($modRencana->iskolaborasiintervensi == true) {
                $modPlanning->kolaborasilanjutan = $modRencana->rencana_intervensi;
              } else {
                $modPlanning->intervensilanjutan = $modRencana->rencana_intervensi;
              }

              $modPlanning->save();
            }

            $jumlahImplementasi = (isset($_POST['rencana_implementasi'][$i]) ? count((array)$_POST['rencana_implementasi'][$i]) : null);
            for ($b = 0; $jumlahImplementasi > $b; $b++) {
              $modelImplementasi = RJImplementasikeperawatanM::model()->findByPk($_POST['rencana_implementasi'][$i][$b]);
              $modImplementasi = new RJImplementasiaskepT();
              $modImplementasi->asuhankeperawatan_id = $modAsuhanKeperawatan->asuhankeperawatan_id;
              $modImplementasi->implementasikeperawatan_id = $_POST['rencana_implementasi'][$i][$b];
              $modImplementasi->tglmulaiimplementasi = $model->tglaskep;
              $modImplementasi->implementasi_nama = $modelImplementasi->implementasi_nama;
              $modImplementasi->iskolaborasi = $modelImplementasi->iskolaborasiimplementasi;
              $modImplementasi->save();
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Asuhan Keperawatan berhasil disimpan");
          $this->refresh();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      'modPeriksaFisik' => $modPeriksaFisik,
      'modMasukKamar' => $modMasukKamar,
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
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modDiagnosaKeperawatanSearch = new RJAsuhankeperawatanT('search');
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
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RJAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RJAsuhankeperawatanT('search');
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
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RJAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RJAsuhankeperawatanT('search');
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
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = RJAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new RJAsuhankeperawatanT('search');
    $this->render(
      '_planning',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $noRekamMedik = RJPasienM::model()->findByPk($modPendaftaran->pasien_id)->no_rekam_medik;

    $criteria = new CDbCriteria(array(
      'condition' => "no_rekam_medik ='" . $noRekamMedik . "' and ruangan_id =" . Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(InfokunjunganrjV::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);
    $modKunjungan = InfokunjunganrjV::model()->findAll($criteria);

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
        array("id" => (isset($row->pendaftaran_id) ? $row->pendaftaran_id : null))
      ), array("id" => "'" . (isset($modKunjungan->no_pendaftaran) ? $modKunjungan->no_pendaftaran : null) . "'", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Diagnosa Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Diagnosa Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailRencanaKeperawatan",
        array("id" => (isset($row->pendaftaran_id) ? $row->pendaftaran_id : null))
      ), array("id" => "'" . (isset($modKunjungan->no_pendaftaran) ? $modKunjungan->no_pendaftaran : null) . "'", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Rencana Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Rencana Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailEvaluasiKeperawatan",
        array("id" => (isset($row->pendaftaran_id) ? $row->pendaftaran_id : null))
      ), array("id" => "'" . (isset($modKunjungan->no_pendaftaran) ? $modKunjungan->no_pendaftaran : null) . "'", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Evaluasi Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Evaluasi Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "Asuhankeperawatan/detailPlanningKeperawatan",
        array("id" => (isset($row->pendaftaran_id) ? $row->pendaftaran_id : null))
      ), array("id" => "'" . (isset($modKunjungan->no_pendaftaran) ? $modKunjungan->no_pendaftaran : null) . "'", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Planning Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Planning Keperawatan")) . "</td>                                    
                         </tr>";
    }

    $this->render(
      '_riwayatAsuhanKeperawatan',
      array(
        'tr' => $tr,
        'pages' => $pages
      )
    );
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RJAsuhankeperawatanT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RJAsuhankeperawatanT']))
      $model->attributes = $_GET['RJAsuhankeperawatanT'];

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
    $model = RJAsuhankeperawatanT::model()->findByPk($id);
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
    $model = new RJAsuhankeperawatanT;
    $model->attributes = $_REQUEST['RJAsuhankeperawatanT'];
    $judulLaporan = 'Data RJAsuhankeperawatanT';
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
}
