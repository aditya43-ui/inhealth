<?php

class KelasPelayananMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionCreateRuangan()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new KelasruanganM;
    if (isset($_POST['KelasruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = count((array)$_POST['ruangan_id']);
        $kelasPelayanan_id = $_POST['KelasruanganM']['kelaspelayanan_id'];
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('kelaspelayanan_id=' . $kelasPelayanan_id . '');
        for ($i = 0; $i <= $jumlahRuangan; $i++) {
          $modKasusRuangan = new KelasruanganM;
          $modKasusRuangan->ruangan_id = $_POST['ruangan_id'][$i];
          $modKasusRuangan->kelaspelayanan_id = $kelasPelayanan_id;
          $modKasusRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
      }
    }
    $this->render('createRuangan', array(
      'model' => $model
    ));
  }

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
    $model = new SAKelasPelayananM;

    // Uncomment the following line if AJAX validation is needed



    if (isset($_POST['SAKelasPelayananM'])) {
      
      $valid = true;
      foreach ($_POST['SAKelasPelayananM'] as $i => $item) {
        //                         echo "rizky";
        //                    exit;
        if (is_integer($i)) {
          $model = new SAKelasPelayananM;
          if (isset($_POST['SAKelasPelayananM'][$i]))
            $model->attributes = $_POST['SAKelasPelayananM'][$i];
          $model->jeniskelas_id = $_POST['SAKelasPelayananM']['jeniskelas_id'];
          $model->kelaspelayanan_aktif = true;
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
          }
        }
      }

      $this->redirect(array('admin'));
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
    $criRuang = new CDbCriteria();
    $criRuang->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id  ";
    $criRuang->addCondition(" r.ruangan_aktif = true ");
    $criRuang->addCondition(" kelaspelayanan_id = " . $id . " ");
    //$modRuangan=KelasruanganM::model()->findAll('kelaspelayanan_id='.$id.'    ');
    $modRuangan = KelasruanganM::model()->findAll($criRuang);
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAKelasPelayananM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      $kelasmod = KelaspelayananM::model()->findByAttributes(array('kelaspelayanan_nama'=>$_POST['SAKelasPelayananM']['kelaspelayanan_nama']));

      $hapuskelasRuangan = KelasruanganM::model()->deleteAll('kelaspelayanan_id=' . $id . '');
      if (isset($_POST['ruangan_id'])) {

        //                         $model->attributes = $_POST['SAKelasPelayananM'];
        //                         echo "<pre>";
        //                            echo  $echo = $_POST['SAKelasPelayananM']['kelaspelayanan_aktif'];
        //                            echo "<br>";
        //                         print_r($model->attributes);
        //                         exit();
        //                         $model->kelaspelayanan_aktif = $_POST['SAKelasPelayananM']['kelaspelayanan_aktif'];

        $jumlahRuangan = count((array)$_POST['ruangan_id']);
        $kelasPelayanan_id = $model->kelaspelayanan_id;
        try {
          $cekduplicate = false;
          if(!empty($kelasmod)){
            if($kelasmod->kelaspelayanan_id != $model->kelaspelayanan_id){
              $cekduplicate = true;
            }
          }
          
          if($cekduplicate){
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data kelas pelayanan tidak boleh sama !!");
          }else{
            if ($jumlahRuangan > 0) {

              for ($i = 0; $i < $jumlahRuangan; $i++) {
                $modKasusRuangan = new KelasruanganM;
                $modKasusRuangan->ruangan_id = $_POST['ruangan_id'][$i];
                $modKasusRuangan->kelaspelayanan_id = $kelasPelayanan_id;
                $modKasusRuangan->save();
              }
            }
            $model->attributes = $_POST['SAKelasPelayananM'];
            //$model->kelaspelayanan_aktif = 1;
            $model->save();
            Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
            $transaction->commit();
            $this->redirect(array('admin'));
          }
          
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        }
      } else {
        $transaction->commit();
        $this->redirect(array('admin'));
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRuangan' => $modRuangan
    ));
  }

  public function actionDelete()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $kelasruangan = SAKelasruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $id));
      if (count((array)$kelasruangan) > 0) {
        $status = 'create_form';
        $konfirmasi = 'Data tidak bisa dihapus karena sedang digunakan.';
      } else {
        $delete = SAKelasPelayananM::model()->deleteByPk($id);
        if ($delete) {
          $status = 'proses_form';
          $konfirmasi = 'Data berhasil dihapus.';
        }
      }

      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => $status,
          'konfirmasi' => $konfirmasi,
        ));
        exit;
      }
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAKelasPelayananM::model()->updateByPk($id, array('kelaspelayanan_aktif' => false));
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

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAKelasPelayananM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Kelas Pelayanan";
    $model = new SAKelasPelayananM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAKelasPelayananM']))
      $model->attributes = $_GET['SAKelasPelayananM'];

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
    $model = SAKelasPelayananM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sakelas-pelayanan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new SAKelasPelayananM;
    $model->attributes = $_REQUEST['SAKelasPelayananM'];
    $judulLaporan = 'Data Kelas Pelayanan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
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
