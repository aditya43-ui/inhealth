<?php

class PresentasiHargaJualController extends MyAuthController
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
    $model = new GFKonfigfarmasiK;
    $modKonfig = GFKonfigfarmasiK::model()->find('konfigfarmasi_aktif is true');

    if (!empty($modKonfig) && $modKondig->konfigfarmasi_aktif == True) {
      echo "<script>
                            myAlert('Maaf masih ada konfigurasi untuk farmasi yang berlaku');
                            window.top.location.href='" . Yii::app()->createUrl('gudangFarmasi/PresentasiHargaJual/admin') . "';
                      </script>";
    }
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GFKonfigfarmasiK'])) {
      $model->attributes = $_POST['GFKonfigfarmasiK'];
      $model->totalpersenhargajual = $_POST['persenhj'] + $_POST['totalphj'];
      $model->persjualbebas = $_POST['persenjb'] + $_POST['totalpjb'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data Konfigurasi berhasil disimpan');
        $this->redirect(array('admin', 'id' => $model->konfigfarmasi_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modKonfig' => $modKonfig,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Konfigurasi Farmasi";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if ($id == null) {
      $id = 1;
    }
    $model = $this->loadModel($id);
    $model->tglberlaku = (!empty($model->tglberlaku)? MyFormatter::formatDateTimeForUser($model->tglberlaku): null);
    $criteriaJasaFarmasi = new CDbCriteria();
    $criteriaJasaFarmasi->join = 'LEFT join penjaminpasien_m p on p.penjamin_id = t.penjamin_id';
    $criteriaJasaFarmasi->order = 't.instalasi_id, p.carabayar_id, p.penjamin_nama';
    $jasaFarmasi = JasafarmasiM::model()->findAll($criteriaJasaFarmasi);

    if (count((array)$jasaFarmasi) == 0) {
      $jasaFarmasi = array();
    } else {
      foreach ($jasaFarmasi as $idx => $item) {
        if(!empty($item->penjamin_id)){
          $penjamin = PenjaminpasienM::model()->findByPk($item->penjamin_id);
          $jasaFarmasi[$idx]->carabayar_id = (!empty($penjamin->carabayar_id)?$penjamin->carabayar_id:null);
        }
      }
    }
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GFKonfigfarmasiK'])) {
      // var_dump($_POST);
      $trans = Yii::app()->db->beginTransaction();
      $model->attributes = $_POST['GFKonfigfarmasiK'];
      $model->tglberlaku = (!empty($model->tglberlaku)? MyFormatter::formatDateTimeForDb($model->tglberlaku): null);

      $model->persensubsidirspegawai = str_replace(",", ".", $model->persensubsidirspegawai);
      if ($model->save() && $this->simpanTanggunanPenjualanOA($_POST['tanggungan'])) {
        $tersimpanjasa = true;

        if (isset($_POST['jasaFarmasi'])) {
         
          foreach ($_POST['jasaFarmasi'] as $item) {
            if (isset($item['jasafarmasi_id']) && !empty($item['jasafarmasi_id'])) {

              if (isset($item['is_delete']) && $item['is_delete'] == 1) {
                JasafarmasiM::model()->deleteByPk($item['jasafarmasi_id']);
                continue;
              }

              $jasamedis = JasafarmasiM::model()->findByPk($item['jasafarmasi_id']);
            } else {
              $jasamedis = new JasafarmasiM();
            }

            $jasamedis->attributes = $item;
            if(!$jasamedis->save()){
              $tersimpanjasa = false;
            }
          }
        }
        if($tersimpanjasa == true){
          $trans->commit();
          Yii::app()->user->setFlash('success', 'Data Konfigurasi berhasil disimpan');
          $this->redirect(array('Update', 'id' => $model->konfigfarmasi_id));
        }else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
        
        
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }
    }

    $model->persensubsidirspegawai = str_replace(".", ",", $model->persensubsidirspegawai);

    $this->render('update', array(
      'model' => $model, 'jasaFarmasi' => $jasaFarmasi,
    ));
  }

  function simpanTanggunanPenjualanOA($tanggungan)
  {
    $ok = true;
    // var_dump($tanggungan); 
    TanggunganpenjualanM::model()->deleteAll();
    foreach ($tanggungan['jenis'] as $idx => $item) {
      if (!empty($item)) {
        $tp = new TanggunganpenjualanM();
        $tp->lookup_name = $item;
        $tp->subsidiasuransi = str_replace(",", ".", $tanggungan['asuransi'][$idx]);
        $tp->subsidipemerintah = str_replace(",", ".", $tanggungan['pemerintah'][$idx]);
        $tp->subsidirs = str_replace(",", ".", $tanggungan['rs'][$idx]);

        if ($tp->validate()) {
          $ok = $ok && $tp->save();
        } else $ok = false;
      }
    }

    return $ok;
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
    $dataProvider = new CActiveDataProvider('GFKonfigfarmasiK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  //	public function actionAdmin()
  //	{
  //                
  //		$model=new GFKonfigfarmasiK('search');
  //                                $format = new MyFormatter;
  //		$model->unsetAttributes();  // clear any default values
  //		if(isset($_GET['GFKonfigfarmasiK']))
  //                                {
  //			$model->attributes=$_GET['GFKonfigfarmasiK'];
  //                                                $model->tglberlaku = $format->formatDateTimeForDb($_GET['GFKonfigfarmasiK']['tglberlaku']);
  //                                }
  //		$this->render('admin',array(
  //			'model'=>$model,
  //		));
  //	}

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GFKonfigfarmasiK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfkonfigfarmasi-k-form') {
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
    GFKonfigfarmasiK::model()->updateByPk($id, array('konfigfarmasi_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {

    $model = new GFKonfigfarmasiK;
    $model->attributes = $_REQUEST['GFKonfigfarmasiK'];
    $judulLaporan = 'Data Konfigurasi Farmasi';
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

  public function actionAutocompletePenanggungjawabApoteker()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->select = "pegawai_id, nama_pegawai";
      $criteria->group = $criteria->select;

      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addInCondition("ruangan_id", array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1));
      $criteria->addCondition('pegawai_aktif = true');
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawairuanganV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
