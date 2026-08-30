<?php

class PasienapachescoreController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

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
    $model = new PIPasienapachescoreT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PIPasienapachescoreT'])) {
      $model->attributes = $_POST['PIPasienapachescoreT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pasienapachescore_id));
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


    if (isset($_POST['PIPasienapachescoreT'])) {
      $model->attributes = $_POST['PIPasienapachescoreT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pasienapachescore_id));
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
    $this->pageTitle = Yii::app()->name . " - Apache Ii Score";
    $modPasien = new PIPasienM();
    $model = new PIPasienapachescoreT();
    $modApacheScore = PIApachescoreM::model()->findAllByAttributes(array('apachescore_aktif' => true), array('order' => 'varfisiologik_nourut'));
    $modPIMetodeGSCM = PIMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_singkatan,metodegcs_nilai DESC');
    $model->tglscoring = date('Y-m-d H:i:s');

    //$modPasienPIV = new PIPasienRawatInapV();
    $modPasienPIV = new PIInfopasienmasukkamarV();
    $modPasienPIV->unsetAttributes();
    $modPasienPIV->tgl_pendaftaran = date('d/m/Y') . ' - ' . date('d/m/Y');
    if (isset($_GET['PIInfopasienmasukkamarV'])) {
      $modPasienPIV->attributes = $_GET['PIInfopasienmasukkamarV'];
    }

    if (isset($_POST['PIPasienapachescoreT'])) {
      $model->attributes = $_POST['PIPasienapachescoreT'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $jumlah = count((array)$modApacheScore);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        PIPasienapachescoreT::model()->deleteAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        for ($i = 1; $i < $jumlah; $i++) {
          if (!empty($_POST['apachescore_id_' . $i])) {
            echo $i;
            $models = new PIPasienapachescoreT();
            $modeScorePoint = PIScorepointM::model()->findByPk($i);
            $point_nama = (isset($modeScorePoint) ? $modeScorePoint->point_nama : "");
            $models->attributes = $model->attributes;
            $models->apachescore_id = $i;
            $models->point_nama = $point_nama;
            $models->point_score = $_POST['point_' . $i];
            $models->point_nilai = $_POST['apachescore_id_' . $i];
            $models->create_time = date('Y-m-d H:i:s');
            $models->update_time = date('Y-m-d H:i:s');
            $models->create_loginpemakai_id = Yii::app()->user->id;
            $models->update_loginpemakai_id = Yii::app()->user->id;
            $models->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if ($models->save()) {
              $success = true;
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Apache Score berhasil disimpan");
          //                        $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('index', array(
      'modPasien' => $modPasien, 'modPasienPIV' => $modPasienPIV,
      'model' => $model,
      'modApacheScore' => $modApacheScore,
      'modPIMetodeGSCM' => $modPIMetodeGSCM,
    ));
  }

  public function actionGetRiwayatPasien($id = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PIPendaftaranT::model()->findByPk($id);
    $noRekamMedik = PIPasienM::model()->findByPk($modPendaftaran->pasien_id)->no_rekam_medik;

    $criteria = new CDbCriteria(array(
      'condition' => "no_rekam_medik ='" . $noRekamMedik . "' and ruangan_id =" . Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
      'limit' => 5
    ));
    $criteria->addBetweenCondition("DATE(tglmasukkamar)", date("Y-m-d", strtotime("-31 days")), date("Y-m-d"));

    $criteriaApache = new CDbCriteria(array(
      'condition' => "pendaftaran_id ='" . $id . "' and ruangan_id =" . Yii::app()->user->getState('ruangan_id'),
      'order' => 'tglscoring DESC'
    ));

    $pages = new CPagination(PIPasienrawatinapV::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);
    $modKunjungan = PIPasienrawatinapV::model()->findAll($criteria);
    $modApacheScore = PIPasienapachescoreT::model()->findAll($criteriaApache);
    $tr = '';
    foreach ($modApacheScore as $row) {
      $modPendaftaran = PendaftaranT::model()->findByPk($row->pendaftaran_id);
      $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
      $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('pasien_id' => $row->pasien_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA));
      $pendaftaran_id = (isset($row->pendaftaran_id) ? $row->pendaftaran_id : null);
      $no_pendaftaran = (isset($modKunjungan->no_pendaftaran) ? $modKunjungan->no_pendaftaran : "");
      $tr .= "<tr>
                            <td>" . $row->tglscoring . "</td>
                            <td>" . (isset($row->point_nama) ? $row->point_nama : "") . "</td>
                            <td><center>" . (isset($row->point_nilai) ? $row->point_nilai : "") . "</center></td>
                            <td><center>" . (isset($row->point_score) ? $row->point_score : "") . "</center></td>
                            <td>" . (isset($row->catatanapachescore) ? $row->catatanapachescore : "") . "</td>
                            ";
      //                <td>".(isset($modPendaftaran->pemeriksaanfisik->suhutubuh) ? $modPendaftaran->pemeriksaanfisik->suhutubuh : "")."</td>
      //                            <td>".(isset($modPendaftaran->pemeriksaanfisik->tinggibadan_cm) ? $modPendaftaran->pemeriksaanfisik->tinggibadan_cm : "")."<br/>".(isset($modPendaftaran->pemeriksaanfisik->beratbadan_kg) ? $modPendaftaran->pemeriksaanfisik->beratbadan_kg : "")."</td>
      //                            <td>".(isset($diagnosa->diagnosa->diagnosa_nama) ? $diagnosa->diagnosa->diagnosa_nama : "")."</td>
      //                            
      //                            <td>".$row->umur."</td>
      //                            <td>".CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pasienapachescore/detailHasil",
      //                                array("id"=>$pendaftaran_id)),array("id"=>"$no_pendaftaran","target"=>"detailData2","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Apache Score", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text"=>"Detail Hasil Apache Score"))."</td>
      //                            
      $tr .= "</tr>";
    }

    $this->render(
      '_riwayatApacheScore',
      array(
        'modKunjungan' => new PIPasienRawatInapV,
        'model' => new PIPasienapachescoreT(),
        'tr' => $tr,
        'pages' => $pages
      )
    );
  }

  public function actionDetailHasil($id)
  {
    //$modApacheScore = PIPasienapachescoreT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $this->layout = '//layouts/iframe';
    $modApacheScore = new PIPasienapachescoreT('search');
    $this->render(
      '_detailHasil',
      array(
        'pendaftaran_id' => $id,
        'modApacheScore' => $modApacheScore,
      )
    );
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new PIPasienapachescoreT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PIPasienapachescoreT']))
      $model->attributes = $_GET['PIPasienapachescoreT'];

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
    $model = PIPasienapachescoreT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ripasienapachescore-t-form') {
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
    $model = new PIPasienapachescoreT;
    $model->attributes = $_REQUEST['PIPasienapachescoreT'];
    $judulLaporan = 'Data PIPasienapachescoreT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PPINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->session['posisi_kertas'];                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetScoreApachePI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $score = (isset($_POST['score']) ? $_POST['score'] : null);
      $id = (isset($_POST['id']) ? $_POST['id'] : null);
      $id = explode('_', $id);
      if (!empty($id[3])) {
        $aktif = true;
      } else {
        $aktif = false;
      }
      $scoreId = $id[2];

      $criteria2 = new CDbCriteria();
      $criteria2->select = 'max(point_minimal) as max_point';
      if (!empty($scoreId)) {
        $criteria2->addCondition("apachescore_id = " . $scoreId);
      }
      if (($aktif == true) && ($scoreId == 10)) {
        $criteria2->addCondition('point_arf = is true');
      }
      $modApache = ScorepointM::model()->find($criteria2);

      $criteria = new CDbCriteria();
      if (!empty($scoreId)) {
        $criteria->addCondition("apachescore_id = " . $scoreId);
      }
      if ($score > $modApache->max_point) {
        if (($aktif == true) && ($scoreId == 10)) {
          $criteria->addCondition('point_arf is true');
        }
        $criteria->addCondition('point_minimal <= ' . $score . ' and point_maksimal = 0');
      } else {
        $criteria->addCondition($score . ' >= point_minimal');
        $criteria->addCondition($score . ' <= point_maksimal');
      }
      $score = ScorepointM::model()->find($criteria);
      $data['pointscore'] = (isset($score->point_score) ? $score->point_score : "");
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_rekam_medik
   */
  public function actionAutocompletePasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->limit = 5;

      $models = PIInfopasienmasukkamarV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data dokter dari autocomplete
   * - nama_pegawai
   */
  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;

      $models = PIDokterV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePerawat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;

      $models = PIParamedisV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
