<?php

class DaftarTindakanMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframeB';
  public $defaultAction = 'admin';

  public function actionCreateRuangan()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new TindakanruanganM;
    if (isset($_POST['TindakanruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = count((array)$_POST['ruangan_id']);
        $daftarTindakan_id = $_POST['TindakanruanganM']['daftartindakan_id'];
        $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $daftarTindakan_id . '');
        for ($i = 0; $i <= $jumlahRuangan; $i++) {
          $modTindakanRuangan = new TindakanruanganM;
          $modTindakanRuangan->ruangan_id = $_POST['ruangan_id'][$i];
          $modTindakanRuangan->daftartindakan_id = $daftarTindakan_id;
          $modTindakanRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
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
    $model = new SADaftarTindakanM;
    $modTarifTindakan = new SATarifTindakanM();
    $modDetailKomponen = array();
    $modDetail = array();
    // Uncomment the following line if AJAX validation is needed


    $td = DaftartindakanM::model()->find(array(
      'order' => 'daftartindakan_id desc',
    ));
    $model->daftartindakan_kode = "TM-" . str_pad($td->daftartindakan_id + 1, 4, 0, STR_PAD_LEFT);


    if (isset($_POST['SADaftarTindakanM'])) {

      //var_dump($_POST['SADaftarTindakanM']);die;
      $model->attributes = $_POST['SADaftarTindakanM'];
      $model->daftartindakan_aktif = TRUE;
      $model->pilihTindakan = isset($_POST['SADaftarTindakanM']['pilihTindakan']) ? $_POST['SADaftarTindakanM']['pilihTindakan'] : null;

      if ($model->pilihTindakan == 'is_karcis') {
        $model->daftartindakan_karcis = true;
      } elseif ($model->pilihTindakan == 'is_visite') {
        $model->daftartindakan_visite = true;
      } elseif ($model->pilihTindakan == 'is_konsul') {
        $model->daftartindakan_konsul = true;
      } elseif ($model->pilihTindakan == 'is_akomodasi') {
        $model->daftartindakan_akomodasi = true;
      } elseif ($model->pilihTindakan == 'is_tindakan') {
        $model->daftartindakan_tindakan = true;
      } elseif ($model->pilihTindakan == 'is_periksa') {
        $model->daftartindakan_periksa = true;
      } elseif ($model->pilihTindakan == 'is_observasi') {
        $model->daftartindakan_observasi = true;
      } elseif ($model->pilihTindakan == 'is_alatmedis') {
        $model->daftartindakan_alatmedis = true;
      }


      $transaction = Yii::app()->db->beginTransaction();
      try {
        $ok = true;
        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        // simpan tindakan ruangan
        if (isset($_POST['ruangan_id'])) {
          foreach ($_POST['ruangan_id'] as $item) {
            $tr = new TindakanruanganM;
            $tr->daftartindakan_id = $model->daftartindakan_id;
            $tr->ruangan_id = $item;
            $ok = $ok && $tr->save();
          }
        }

        // simpan tarif
        if (isset($_POST['SATarifTindakanM'])) {
          $ok = $ok && $this->simpanTarifTindakan($model, $_POST['SATarifTindakanM']);
        }

        if ($ok) {
          //var_dump();die;
          if (!empty($_POST['SADaftarTindakanM']['grouplayanan_id'])) {
            $gro = new GrouplayanankasirM;
            $gro->daftartindakan_id = $model->daftartindakan_id;
            $gro->grouplayanan_id = $_POST['SADaftarTindakanM']['grouplayanan_id'];
            $ok = $ok && $gro->save();
          }
        }
        //var_dump($ok);
        // die;
        if ($ok) {
          $this->notifDaftarTinBaru($model);

          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin', 'id' => $model->daftartindakan_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    /* untuk pencarian dialog */

    if (isset($_GET['FilterForm'])) {
      $_GET['test'] = true;
      $_GET['term'] = $_GET['FilterForm'];
    }
    if (isset($_GET['test'])) {
      $_GET['term'] = (isset($_GET['term'])) ? $_GET['term'] : null;
      if (Yii::app()->request->isAjaxRequest) {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(komponentarif_nama)', strtolower($_GET['term']), true);
        //                    $criteria->compare('komponentarif_id', Params::KOMPONENTARIF_ID_TOTAL);
        //                    $criteria->order = 'komponentarif_nama';
        $models = 'KomponentarifM';


        $dataProvider = new CActiveDataProvider($models, array(
          'criteria' => $criteria,
        ));
        $route = Yii::app()->createUrl($this->route);
        $this->renderPartial('_daftarDialog', array('dataProvider' => $dataProvider, 'models' => $models, 'route' => $route));
        Yii::app()->end();
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modTarifTindakan' => $modTarifTindakan,
      'modDetailKomponen' => $modDetailKomponen,
      'modDetail' => $modDetail,
    ));
  }

  protected function simpanTarifTindakan($model, $post)
  {
    $ok = true;
    // var_dump($model->attributes, $post);

    $det = array();

    foreach ($post as $idx => $item) {
      if (is_numeric($idx)) {
        $kel = $item['kelaspelayanan_id'];
        if (empty($det[$kel]))
          $det[$kel] = array('total' => 0, 'data' => array());
        array_push($det[$kel]['data'], array(
          'komponentarif_id' => $item['komponentarif_id'],
          'harga_tariftindakan' => $item['harga_tariftindakan'],
        ));
        $det[$kel]['total'] += $item['harga_tariftindakan'];
      }
    }

    // var_dump($det);

    foreach ($det as $kelas => $item) {
      foreach ($item['data'] as $detail) {
        $d = new TariftindakanM;
        $d->attributes = $post;

        if ($d->persendiskon_tind == 0) {
          if ($item['total'] != 0) {
            $d->persendiskon_tind = round(($d->hargadiskon_tind / $item['total']) * 100, 2);
            $d->hargadiskon_tind = round(($d->hargadiskon_tind / $item['total']) * $detail['harga_tariftindakan']);
          } else {
            $d->persendiskon_tind = 0;
            $d->hargadiskon_tind = 0;
          }
        } else {
          $d->hargadiskon_tind = ($d->persendiskon_tind * $detail['harga_tariftindakan']) / 100;
        }

        $d->daftartindakan_id = $model->daftartindakan_id;
        $d->kelaspelayanan_id = $kelas;
        $d->komponentarif_id = $detail['komponentarif_id'];
        $d->harga_tariftindakan = $detail['harga_tariftindakan'];

        $d->create_time = date('Y-m-d H:i:s');
        $d->create_loginpemakai_id = Yii::app()->user->id;
        $d->create_ruangan = Yii::app()->user->getState('ruangan_id');

        // var_dump($d->validate(), $d->errors); die;

        if ($d->validate()) {
          $ok = $ok && $d->save();
        } else
          $ok = false;

        // var_dump($d->attributes);
      }

      // total
      $d = new TariftindakanM;
      $d->attributes = $post;

      if ($d->persendiskon_tind == 0) {
        if ($item['total'] != 0) {
          $d->persendiskon_tind = round(($d->hargadiskon_tind / $item['total']) * 100, 2);
        } else {
          $d->persendiskon_tind = 0;
        }
      } else {
        $d->hargadiskon_tind = ($d->persendiskon_tind * $item['total']) / 100;
      }

      $d->daftartindakan_id = $model->daftartindakan_id;
      $d->kelaspelayanan_id = $kelas;
      $d->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
      $d->harga_tariftindakan = $item['total'];

      $d->create_time = date('Y-m-d H:i:s');
      $d->create_loginpemakai_id = Yii::app()->user->id;
      $d->create_ruangan = Yii::app()->user->getState('ruangan_id');


      if ($d->validate()) {
        $ok = $ok && $d->save();
      } else
        $ok = false;

      //var_dump($d->attributes);
      //die;
    }

    return $ok;


    //die;
  }

  protected function validasiTabular($datas, $modDaftar)
  {
    $modDetails = array();
    if (count((array)$datas) > 0) {
      foreach ($datas as $key => $data) {
        $modDetails[$key] = new SATarifTindakanM();
        if (empty($data['komponentarif_id'])) {
          $komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
        } else {
          $komponentarif_id = $data['komponentarif_id'];
        }
        $modDetails[$key]->attributes = $data;
        $modDetails[$key]->komponentarif_id = $komponentarif_id;
        $modDetails[$key]->jenistarif_id = $_POST['SATarifTindakanM']['jenistarif_id'];
        $modDetails[$key]->persendiskon_tind = $_POST['SATarifTindakanM']['persendiskon_tind'];
        $modDetails[$key]->hargadiskon_tind = $_POST['SATarifTindakanM']['hargadiskon_tind'];
        $modDetails[$key]->persencyto_tind = $_POST['SATarifTindakanM']['persencyto_tind'];
        $modDetails[$key]->perdatarif_id = Params::DEFAULT_PERDA_TARIF;
        $modDetails[$key]->daftartindakan_id = $modDaftar->daftartindakan_id;
        $modDetails[$key]->validate();
        //                echo '<pre>';
        ////                        echo print_r($datas[$key]);
        //                        echo print_r($modDetails[$key]->attributes);
      }
      //                
      //                echo '<pre>';
      ////                        echo print_r($datas[0]['kelaspelayanan_id']);
      //                        echo print_r($modDetails[0]->attributes);
      //                        echo print_r($modDetails[1]->attributes);
      //                        echo print_r($modDetails[2]->attributes);
      //                         exit();
    }

    //            echo print_r($modDetails[$key]->attributes);exit;
    return $modDetails;
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
    $modRuangan = TindakanruanganM::model()->findAll('daftartindakan_id=' . $id . '');
    if (!empty($model->jeniskegiatan_id)) {
      $model->jeniskegiatan_nama = $model->jeniskegiatan->jeniskegiatan_nama;
    }

    if ($model->daftartindakan_karcis == true) {
      $model->pilihTindakan = 'is_karcis';
    } elseif ($model->daftartindakan_visite == true) {
      $model->pilihTindakan = 'is_visite';
    } elseif ($model->daftartindakan_konsul == true) {
      $model->pilihTindakan = 'is_konsul';
    } elseif ($model->daftartindakan_akomodasi == true) {
      $model->pilihTindakan = 'is_akomodasi';
    } elseif ($model->daftartindakan_tindakan == true) {
      $model->pilihTindakan = 'is_tindakan';
    } elseif ($model->daftartindakan_observasi == true) {
      $model->pilihTindakan = 'is_observasi';
    } elseif ($model->daftartindakan_periksa == true) {
      $model->pilihTindakan = 'is_periksa';
    } elseif ($model->daftartindakan_alatmedis == true) {
      $model->pilihTindakan = 'is_alatmedis';
    }

    $cekGrup = GrouplayanankasirM::model()->findByAttributes(array('daftartindakan_id' => $model->daftartindakan_id));

    //var_dump($cekGrup->attributes);die;

    if (!empty($cekGrup)) {
      $model->grouplayanan_id = $cekGrup->grouplayanan_id;
      $model->grouplayanan_nama = $cekGrup->grouplayanan->grouplayanan_nama;
    }

    // Uncomment the following line if AJAX validation is needed
    //
    //		if(isset($_POST['SADaftarTindakanM']))
    //		{
    //			$model->attributes=$_POST['SADaftarTindakanM'];
    //			if($model->save()){
    //                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    //				$this->redirect(array('view','id'=>$model->daftartindakan_id));
    //                        }
    //		}
    //                

    if (isset($_POST['SADaftarTindakanM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->attributes = $_POST['SADaftarTindakanM'];
      $model->pilihTindakan = isset($_POST['SADaftarTindakanM']['pilihTindakan']) ? $_POST['SADaftarTindakanM']['pilihTindakan'] : null;

      $model->daftartindakan_karcis = false;
      $model->daftartindakan_visite = false;
      $model->daftartindakan_konsul = false;
      $model->daftartindakan_akomodasi = false;
      $model->daftartindakan_tindakan = false;
      $model->daftartindakan_periksa = false;
      $model->daftartindakan_observasi = false;
      $model->daftartindakan_alatmedis = false;

      if ($model->pilihTindakan == 'is_karcis') {
        $model->daftartindakan_karcis = true;
      } elseif ($model->pilihTindakan == 'is_visite') {
        $model->daftartindakan_visite = true;
      } elseif ($model->pilihTindakan == 'is_konsul') {
        $model->daftartindakan_konsul = true;
      } elseif ($model->pilihTindakan == 'is_akomodasi') {
        $model->daftartindakan_akomodasi = true;
      } elseif ($model->pilihTindakan == 'is_tindakan') {
        $model->daftartindakan_tindakan = true;
      } elseif ($model->pilihTindakan == 'is_periksa') {
        $model->daftartindakan_periksa = true;
      } elseif ($model->pilihTindakan == 'is_observasi') {
        $model->daftartindakan_observasi = true;
      } elseif ($model->pilihTindakan == 'is_alatmedis') {
        $model->daftartindakan_alatmedis = true;
      }

      //var_dump($model->attributes);die;
      //var_dump($_POST['SADaftarTindakanM']);die;

      try {

        if ($model->save()) {

          $success = true;
          $daftarTindakan_id = $model->daftartindakan_id;
          $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $daftarTindakan_id . '');

          if (isset($_POST['ruangan_id'])) {
            $jumlahRuangan = count((array)$_POST['ruangan_id']);


            if ($jumlahRuangan > 0) {
              for ($i = 0; $i < $jumlahRuangan; $i++) {
                $modTindakanRuangan = new TindakanruanganM;
                $modTindakanRuangan->ruangan_id = $_POST['ruangan_id'][$i];
                $modTindakanRuangan->daftartindakan_id = $daftarTindakan_id;
                if (!$modTindakanRuangan->save()) {
                  $success = false;
                }
              }
            }
          }
          if ($success && $model->save()) {
            //if ($ok){
            //var_dump();die;
            $ok = true;
            if (!empty($_POST['SADaftarTindakanM']['grouplayanan_id'])) {

              if (empty($cekGrup)) {
                $gro = new GrouplayanankasirM;
                $gro->daftartindakan_id = $model->daftartindakan_id;
                $gro->grouplayanan_id = $_POST['SADaftarTindakanM']['grouplayanan_id'];
                $ok = $ok && $gro->save();
              } else {
                $cekGrup->daftartindakan_id = $model->daftartindakan_id;
                $cekGrup->grouplayanan_id = $_POST['SADaftarTindakanM']['grouplayanan_id'];
                $ok = $ok && $cekGrup->save();
              }
            } else {
              if (!empty($cekGrup)) {
                $ok = $ok && $cekGrup->delete();
              }
            }
            //	}     

            if ($ok) {
              Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
              $transaction->commit();
              $this->redirect(array('admin'));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRuangan' => $modRuangan
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
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                         
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $id . '');
        $this->loadModel($id)->delete();
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Dihapus");
      }
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
    $dataProvider = new CActiveDataProvider('SADaftarTindakanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SADaftarTindakanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SADaftarTindakanM'])) {
      $model->attributes = $_GET['SADaftarTindakanM'];
      // $model->komponenunit_nama = $_GET['SADaftarTindakanM']['komponenunit_nama'];
      // $model->kategoritindakan_nama = $_GET['SADaftarTindakanM']['kategoritindakan_nama'];
      // $model->kelompoktindakan_nama = $_GET['SADaftarTindakanM']['kelompoktindakan_nama'];
      $model->komponenunit_id = $_GET['SADaftarTindakanM']['komponenunit_id'];
      $model->kategoritindakan_id = $_GET['SADaftarTindakanM']['kategoritindakan_id'];
      $model->kelompoktindakan_id = $_GET['SADaftarTindakanM']['kelompoktindakan_id'];
    }
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
    $model = SADaftarTindakanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sadaftar-tindakan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      $model->daftartindakan_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                SADaftarTindakanM::model()->updateByPk($id, array('daftartindakan_aktif'=>false));
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {

    $model = new SADaftarTindakanM();
    $model->attributes = $_REQUEST['SADaftarTindakanM'];
    $judulLaporan = 'Daftar Tindakan';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
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
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * 
   * - digunakan untuk membuat notifikasi, jika ada daftar tindakan 
   * @param type $modDaftarTindakan
   * @return type
   */
  public function notifDaftarTinBaru($modDaftarTindakan)
  {

    $judul = 'Daftar Tindakan Baru';

    $isi = $modDaftarTindakan->daftartindakan_kode . ' ' . $modDaftarTindakan->daftartindakan_nama;

    $cri = new CDbCriteria();
    $cri->select = " t.ruangan_id, t.daftartindakan_id, r.instalasi_id, r.modul_id ";
    $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
    $cri->addCondition(" daftartindakan_id = " . $modDaftarTindakan->daftartindakan_id . " ");

    $r = TindakanruanganM::model()->findAll($cri);

    if (count((array)$r) > 0) {
      foreach ($r as $i) {
        //echo "asd";
        //var_dump($i->modul_id);
        if (!empty($i->modul_id)) {
          //  echo "dsa";
          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $i->instalasi_id, 'ruangan_id' => $i->ruangan_id, 'modul_id' => $i->modul_id),
          ));
        }
      }
    }

    // die;
  }
}
