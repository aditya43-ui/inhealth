<?php

class MasterOrganigramController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterOrganigram.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->layout = "//layouts/iframe";
    $model = $this->loadModel($id);
    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    $model = new SAOrganigramM;
    if (!empty($id)) {
      $model = SAOrganigramM::model()->findByPk($id);
    }

    if (isset($_POST['SAOrganigramM'])) {

      $model->attributes = $_POST['SAOrganigramM'];
      $model->organigram_periode = empty($model->organigram_periode) ? null : $format->formatDateTimeForDb($model->organigram_periode);
      $model->organigram_sampaidengan = empty($model->organigram_sampaidengan) ? null : $format->formatDateTimeForDb($model->organigram_sampaidengan);

      $model->create_time = date("Y-m-d H:i:s");
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_loginpemakai_id = Yii::app()->user->id;




      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->organigram_kode . ' berhasil disimpan.');
        $this->redirect(array('index', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'indexBaru', array(
      'model' => $model,
    ));
  }


  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($id = null)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $model = new SAOrganigramM;
    if (!empty($id)) {
      $model = SAOrganigramM::model()->findByPk($id);
    }

    if (isset($_POST['SAOrganigramM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();

      try {
        $model->attributes = $_POST['SAOrganigramM'];
        $model->organigram_periode = empty($model->organigram_periode) ? null : $format->formatDateTimeForDb($model->organigram_periode);
        $model->organigram_sampaidengan = empty($model->organigram_sampaidengan) ? null : $format->formatDateTimeForDb($model->organigram_sampaidengan);

        $model->create_time = date("Y-m-d H:i:s");
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;


        if (isset($_POST['SAOrganigramM']['pegawai'])) {
          foreach ($_POST['SAOrganigramM']['pegawai'] as $peg) {
            $new = new OrganigramM();
            $new->attributes = $model->attributes;
            $new->pegawai_id = $peg['pegawai_id'];
            $new->organigram_pelaksanakerja = $peg['organigram_pelaksanakerja'];
            $new->organigram_kode = $peg['organigram_kode'];
            $new->pegawai_id = $peg['pegawai_id'];
            $new->jabatan_id = $peg['jabatan_id'];

            $ok = $ok && $new->save();
          }
        }


        if ($ok) {
          Yii::app()->user->setFlash('success', 'Data  berhasil disimpan.');
          $trans->commit();
          $this->redirect(array('admin', 'sukses' => 1, 'iframe' => 'ya'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }

  /*
		 * get data pegawai jabatan berdasarkan 
		 */
  public function actionGetDataPegawaiJabatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = SAPegawaijabatanR::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'nomorkeputusanjabatan' => $data->nomorkeputusanjabatan,
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  /**
   * menampilkan data pegawai
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($term), true, "OR");
      $criteria->compare('LOWER(gelardepan)', strtolower($term), true, "OR");
      if (isset($_GET['jabatan_id'])) {
        if (!empty($_GET['jabatan_id'])) {
          $criteria->addCondition("jabatan_id = " . $_GET['jabatan_id']);
        }
      }
      $criteria->addCondition('pegawai_aktif = TRUE');
      $criteria->limit = 5;
      $models = SAPegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $returnVal[$i] = $model->attributes;
        if (isset($model->jabatan)) {
          $returnVal[$i] = $model->jabatan->attributes;
        }
        $returnVal[$i]['label'] = $model->gelardepan . ' ' . $model->nama_pegawai . ' ' . (isset($model->gelarbelakang->gelarbelakang_nama) ? $model->gelarbelakang->gelarbelakang_nama : "") . "-" . $model->nomorindukpegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan data organigram untuk dipilih atasannya
   */
  public function actionAutocompleteAtasan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;

      $criteria = new CDbCriteria();
      $criteria->with = array('pegawai');
      $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($term), true);
      $criteria->compare('LOWER(pegawai.nomorindukpegawai)', strtolower($term), true, "OR");
      $criteria->compare('LOWER(pegawai.gelardepan)', strtolower($term), true, "OR");
      $criteria->compare('LOWER(t.organigram_unitkerja)', strtolower($term), true, "OR");
      if (isset($_GET['organigram_id'])) {
        if (!empty($_GET['organigram_id'])) {
          $criteria->addCondition("t.organigram_id <> " . $_GET['organigram_id']);
        }
      }
      $criteria->limit = 5;
      $models = SAOrganigramM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $returnVal[$i] = $model->attributes;
        if (isset($model->pegawai)) {
          $returnVal[$i] = $model->pegawai->attributes;
        }

        if (isset($model->pegawai)) {
          $returnVal[$i]['label'] = $model->pegawai->gelardepan . ' ' . $model->pegawai->nama_pegawai . ' ' . (isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "") . "-" . $model->pegawai->nomorindukpegawai;
        } else {
          $returnVal[$i]['label'] = $returnVal[$i]['organigram_unitkerja'];
        }
        $returnVal[$i]['value'] = $model->organigram_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id, $from = null)
  {

    if ($from == null) {
      $this->layout = "//layouts/iframe";
    }
    $format = new MyFormatter;
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAOrganigramM'])) {
      $model->attributes = $_POST['SAOrganigramM'];

      $model->organigram_periode = empty($model->organigram_periode) ? null : $format->formatDateTimeForDb($model->organigram_periode);
      $model->organigram_sampaidengan = empty($model->organigram_sampaidengan) ? null : $format->formatDateTimeForDb($model->organigram_sampaidengan);

      $model->update_time = date("Y-m-d H:i:s");
      $model->update_loginpemakai_id = Yii::app()->user->id;

      if ($model->save()) {
        if ($from == null) {
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $this->redirect(array('index', 'sukses' => 1));
        }
        Yii::app()->user->setFlash('success', ' Data berhasil disimpan.');
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan !");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'from' => $from
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];

      $cek = OrganigramM::model()->findByAttributes(array('organigramasal_id' => $id));
      $data['pesan'] = '';
      if (empty($cek)) {
        $data['sukses'] = 1;
        $this->loadModel($id)->delete();
      } else {
        $data['sukses'] = 1;
        $data['pesan'] = 'Data ini memiliki beberapa pegawai di level bawahnya, silakan hilangkan relasi pegawai dibawahnya, jika ingin menghapus data ini';
      }


      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode($data);
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //if(Yii::app()->request->isAjaxRequest)
    //{
    // we only allow deletion via POST request
    //$this->loadModel($id)->delete();			
    //$id = isset($_GET['id'])?$_GET['id']:null;
    //$cek = OrganigramM::model()->findByAttributes(array('organigramasal_id'=>$id));

    //if (empty($cek)){
    //	$this->loadModel($id)->delete();
    //	$data['pesan'] = 'Data ini memiliki beberapa pegawai di level bawahnya, silakan hilangkan relasi pegawai dibawahnya, jika ingin menghapus data ini';
    //	$data['sukses'] = 1;
    //}


    //echo CJSON::encode($data); 

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //if(!isset($_GET['ajax']))
    //	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    //}
    //else
    //	throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive() //$id
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = OrganigramM::model()->updateByPk($id, array('organigram_aktif' => false));
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
    /*if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			if($model->organigram_aktif)
				$model->organigram_aktif = false;
			else
				$model->organigram_aktif = true;
			
			if($model->save()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}*/
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->layout = "//layouts/iframe";
    $model = new SAOrganigramM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAOrganigramM'])) {
      $model->attributes = $_GET['SAOrganigramM'];
      $model->atasan = $_GET['SAOrganigramM']['atasan'];
      $model->nama_pegawai = $_GET['SAOrganigramM']['nama_pegawai'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * menampilkan organigram
   */
  public function actionOrganigram()
  {
    if (isset($_GET['caraPrint'])) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframePolos';
    }
    $criteria = new CDbCriteria();
    $criteria->addCondition("organigram_aktif = TRUE");
    $criteria->order = "organigram_id ASC";
    $organigram = SAOrganigramM::model()->findAll($criteria);

    $modOrgAsal = array();
    foreach ($organigram as $asal) {
      if (!empty($asal->organigramasal_id)) {
        $modOrgAsal["$asal->organigramasal_id"]['organigram_unitkerja'] = $asal->organigramasal->organigram_unitkerja;
        $modOrgAsal["$asal->organigramasal_id"]['pegawai_id'] = $asal->organigramasal->pegawai_id;
        $modOrgAsal["$asal->organigramasal_id"]['nama_pegawai'] = $asal->organigramasal->pegawai->namaLengkap;
        $modOrgAsal["$asal->organigramasal_id"]['organigramasal_id'] = $asal->organigramasal->organigramasal_id;
        $modOrgAsal["$asal->organigramasal_id"]['organigram_id'] = $asal->organigramasal->organigram_id;
      }
    }

    $modOrg = array();
    foreach ($organigram as $org) {
      if (!isset($modOrgAsal["$org->organigram_id"])) {
        $unit_org = $org->organigram_unitkerja . '-' . $org->organigramasal_id;
        $modOrg["$unit_org"]['organigram_unitkerja'] = $org->organigram_unitkerja;
        $modOrg["$unit_org"]['organigramasal_id'] = $org->organigramasal_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['organigram_id'] = $org->organigram_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['pegawai_id'] = $org->pegawai_id;
        $modOrg["$unit_org"]['det']["$org->organigram_id"]['nama_pegawai'] = $org->pegawai->namaLengkap;
      }
    }



    $this->render($this->path_view . 'organigramBaru', array(
      'modOrg' => $modOrg,
      'modOrgAsal' => $modOrgAsal,
    ));
  }
  /**
   * menampilkan list
   */
  public function actionList()
  {
    $this->layout = "//layouts/iframe";
    $model = new SAOrganigramM('search');

    $this->render($this->path_view . 'list', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SAOrganigramM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kporganigram-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAOrganigramM;
    $model->attributes = $_REQUEST['SAOrganigramM'];
    $judulLaporan = 'Data Struktur Organigram';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
