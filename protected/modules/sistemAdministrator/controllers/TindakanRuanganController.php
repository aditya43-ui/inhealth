<?php
class TindakanRuanganController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/layout1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.tindakanRuangan.';

  public function actionCreate()
  {
    $model = new SATindakanruanganM;
    $modTindakanRuangan = new SATindakanruanganM('search');
    $modTindakanRuangan->unsetAttributes();
    $modTindakanRuangan->ruangan_id = 0; //default tidak muncul data
    if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
      $modTindakanRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    if (isset($_GET['SATindakanruanganM'])) {
      $modTindakanRuangan->attributes = $_GET['SATindakanruanganM'];
      $modTindakanRuangan->ruangan_id = $_GET['SATindakanruanganM']['ruangan_id'];
      $modTindakanRuangan->kelompoktindakan_nama = $_GET['SATindakanruanganM']['kelompoktindakan_nama'];
      $modTindakanRuangan->kategoritindakan_nama = $_GET['SATindakanruanganM']['kategoritindakan_nama'];
      $modTindakanRuangan->daftartindakan_kode = $_GET['SATindakanruanganM']['daftartindakan_kode'];
      $modTindakanRuangan->daftartindakan_nama = $_GET['SATindakanruanganM']['daftartindakan_nama'];
    }

    if (Yii::app()->request->isPostRequest) { //submit by ajax
      $data['sukses'] = 0;
      $data['pesan'] = "";

      if (isset($_POST['SATindakanruanganM'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $loadTindakanRuangan = SATindakanruanganM::model()->findByAttributes(array('daftartindakan_id' => $_POST['SATindakanruanganM']['daftartindakan_id'], 'ruangan_id' => $_POST['SATindakanruanganM']['ruangan_id']));
          if ($loadTindakanRuangan) {
            $data['sukses'] = 0;
            $data['pesan'] = "Tindakan " . $loadTindakanRuangan->daftartindakan->daftartindakan_nama . "sudah ada di " . $loadTindakanRuangan->ruangan->ruangan_nama . "!";
          } else {
            $model = new SATindakanruanganM;
            $model->ruangan_id = $_POST['SATindakanruanganM']['ruangan_id'];
            $model->daftartindakan_id = $_POST['SATindakanruanganM']['daftartindakan_id'];
            if ($model->save()) {
              $transaction->commit();
              $data['sukses'] = 1;
              $data['pesan'] = "Tindakan " . $model->daftartindakan->daftartindakan_nama . " di " . $model->ruangan->ruangan_nama . " berhasil disimpan!";
            } else {
              $transaction->rollback();
              $data['sukses'] = 0;
              $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
            }
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          $data['sukses'] = 0;
          $data['pesan'] = 'Data gagal disimpan!' . MyExceptionMessage::getMessage($exc, true);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modTindakanRuangan' => $modTindakanRuangan,
    ));
  }

  public function actionUpdate($daftartindakan_id, $ruangan_id)
  {
    $model = SATindakanruanganM::model()->find(" daftartindakan_id = '" . $daftartindakan_id . "' AND ruangan_id = '" . $ruangan_id . "'");
    $modRuangan = TindakanruanganM::model()->findAll('daftartindakan_id=' . $daftartindakan_id . '');
    $model->daftartindakan_nama = $model->daftartindakan->daftartindakan_nama;

    //if(Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN){
    //	$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //	$model->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
    //	$modTindakanRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //}


    if (isset($_POST['SATindakanruanganM'])) {
      $model->attributes = $_POST['SATindakanruanganM'];
      $success = true;

      $valid = $model->validate();

      if ($valid) {
        Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
        // $transaction->commit();
        $model->save();
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        //$transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
      }

      /*if (isset($_POST['ruangan_id'])) {
                        $jumlahRuangan=count((array)$_POST['ruangan_id']);
                         
                        $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('daftartindakan_id='.$daftartindakan_id.''); 

                        if($jumlahRuangan>0)
                        {
                            for($i=0; $i<$jumlahRuangan; $i++)
                            {
                                $modTindakanRuangan = new TindakanruanganM;
                                $modTindakanRuangan->ruangan_id=$_POST['ruangan_id'][$i];
                                $modTindakanRuangan->daftartindakan_id=$daftartindakan_id;
                                if (!$modTindakanRuangan->save()){
                                    $success = false;
                                }
                            }                
                        }
                    }*/
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'modRuangan' => $modRuangan,
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
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
      $models = CHtml::listData(SARuanganM::getItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompleteTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($term), true);
      $criteria->compare('LOWER(daftartindakan_kode)', strtolower($term), true, 'OR');
      $criteria->order = 'daftartindakan_nama';
      $criteria->limit = 5;

      $models = SADaftarTindakanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_kode . " " . $model->daftartindakan_nama;
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($idRuangan, $idTindakan)
  {
    $modKasusPenyakitRuangan = array();
    $this->render($this->path_view . 'view', array(
      'model' => RuanganM::model()->findByPk($idRuangan),
      'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
    ));
  }
  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        SATindakanruanganM::model()->deleteAllByAttributes(array('ruangan_id' => $_GET['ruangan_id'], 'daftartindakan_id' => $_GET['daftartindakan_id']));
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Manages all models.
   */
  public function actionAdmin($sukses = '')
  {
    $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
    if ($sukses == 1) {
      Yii::app()->user->setFlash('success', "Data Berhasil Disimpan! ");
    }
    $model = new SATindakanruanganM('search');
    $model->unsetAttributes();  // clear any default values
    if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    if (isset($_GET['SATindakanruanganM'])) {
      $model->attributes = $_GET['SATindakanruanganM'];
      $model->kelompoktindakan_nama = $_GET['SATindakanruanganM']['kelompoktindakan_nama'];
      $model->kategoritindakan_nama = $_GET['SATindakanruanganM']['kategoritindakan_nama'];
      $model->daftartindakan_kode = $_GET['SATindakanruanganM']['daftartindakan_kode'];
      $model->daftartindakan_nama = $_GET['SATindakanruanganM']['daftartindakan_nama'];
      $model->komponenunit_nama = $_GET['SATindakanruanganM']['komponenunit_nama'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionPrint()
  {
    $model = new SATindakanruanganM;
    $judulLaporan = 'Data Tindakan Ruangan';
    $caraPrint = $_REQUEST['caraPrint'];
    if (isset($_GET['SATindakanruanganM'])) {
      // var_dump($_GET['SATindakanruanganM']);die();
      $model->attributes = $_GET['SATindakanruanganM'];
      $model->kelompoktindakan_nama = $_GET['SATindakanruanganM']['kelompoktindakan_nama'];
      $model->kategoritindakan_nama = $_GET['SATindakanruanganM']['kategoritindakan_nama'];
      $model->daftartindakan_kode = $_GET['SATindakanruanganM']['daftartindakan_kode'];
      $model->daftartindakan_nama = $_GET['SATindakanruanganM']['daftartindakan_nama'];
      $model->komponenunit_nama = $_GET['SATindakanruanganM']['komponenunit_nama'];
      if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      };
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
