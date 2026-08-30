<?php
class JurnalRekPenjaminController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function init()
  {
    if (isset($_GET['tab'])) {
      if ($_GET['tab'] == 'frame') {
        $this->layout = '//layouts/iframe';
      }
    }
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    //$model=AKPenjaminRekM::model()->findByAttributes(array('penjamin_id'=>$id));
    $model = AKPenjaminRekM::model()->findByAttributes(array('penjamin_id' => $id));

    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new AKPenjaminRekM();
    $modPenjamin = new AKPenjaminpasienM();
    $modDetails = array();
    $model->rekening5_id = isset($_POST['AKPenjaminRekM']['rekening'][1]['rekening5_id']) ? $_POST['AKPenjaminRekM']['rekening'][1]['rekening5_id'] : null;

    if (isset($_GET['AKPenjaminRekM'])) {
      $model->attributes = $_GET['AKPenjaminRekM'];
      //var_dump($model->attributes);die;
    }
    if (isset($_POST['AKPenjaminRekM'])) {
      $transaction = Yii::app()->db->beginTransaction();

      if (isset($_POST['AKPenjaminpasienM'])) {
        //$modPenjamin->unsetAttributes();
        if (!empty($_POST['AKPenjaminpasienM']['penjamin_id'])) {
          $modPenjamin = PenjaminpasienM::model()->findByPk($_POST['AKPenjaminpasienM']['penjamin_id']);
        }
        //$modPenjamin->attributes=$_POST['AKPenjaminpasienM'];								
        //$modPenjamin->penjamin_aktif = true;
        //$modPenjamin->create_time = date('Y-m-d H:i:s');
        //$modPenjamin->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        //$modPenjamin->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //$modPenjamin->save();


        //var_dump($modPenjamin->attributes);die;
      }
      try {
        $success = true;
        $modDetails = $this->validasiTabular($_POST['AKPenjaminRekM'], $modPenjamin);
        if (!empty($modDetails)) {
          foreach ($modDetails as $i => $data) {
            if ($data->save()) {
              $success = true;
            } else {
              $success = false;
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $modPenjamin->penjamin_nama . ' berhasil disimpan.');
          $this->redirect(array('admin', 'id' => 1, 'tab' => isset($_GET['tab']) ? $_GET['tab'] : ''));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modDetails' => $modDetails,
      'modPenjamin' => $modPenjamin,
      ''
    ));
  }

  protected function validasiTabular($data, $modPenjamin)
  {
    $modDetails = null;
    foreach ($data['rekening'] as $i => $row) {
      if (!empty($row['rekening5_id'])) {
        $modDetails[$i] = new AKPenjaminRekM;
        $modDetails[$i]->attributes = $row;
        $modDetails[$i]->debitkredit = $modDetails[$i]->saldonormal = $row['rekening5_nb'];
        $modDetails[$i]->penjamin_id = $modPenjamin->penjamin_id;
        $modDetails[$i]->rekening5_id = $row['rekening5_id'];

        $r5 = Rekening5M::model()->findByPk($modDetails[$i]->rekening5_id);
        $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
        $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
        $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
        $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

        $modDetails[$i]->rekening4_id = $r5->rekening4_id;
        $modDetails[$i]->rekening3_id = $r4->rekening3_id;
        $modDetails[$i]->rekening2_id = $r3->rekening2_id;
        $modDetails[$i]->rekening1_id = $r2->rekening1_id;
        $modDetails[$i]->create_time = date('Y-m-d H:i:s');
        $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modDetails[$i]->ispembayaran = $data['ispembayaran'];

        //var_dump($modDetails[$i]->ispembayaran);die;
      }
    }
    return $modDetails;
  }
  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $modPenjamin = AKPenjaminpasienM::model()->findByPk($id);
    //$amodel=AKPenjaminRekM::model()->findAllByAttributes(array('penjaminrek_id'=>$id), array('order'=>'debitkredit'));
    //$penjaminid=AKPenjaminRekM::model()->findByAttributes(array('penjaminrek_id'=>$id), array('order'=>'debitkredit'));
    //$modPenjamin = AKPenjaminpasienM::model()->findByPk($penjaminid->penjamin_id);
    $model = array('D' => null, 'K' => null);

    //$cnt = 0;
    //$dk = ['D', 'K'];
    //foreach ($amodel as $item) {
    //	if (!empty($item->debitkredit)) {
    //		$model[$item->debitkredit] = $item;
    //	} else {
    //		$model[$dk[$cnt]] = $item;
    //		$cnt++;
    //	}
    //	$modPenjamin->ispembayaran = $item->ispembayaran;
    //}

    //foreach ($model as $k=>$item) {
    //	if (empty($item)) {
    //		$model[$k] = new AKPenjaminRekM;
    //	}
    //}


    if (isset($_POST['AKPenjaminpasienM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        //AKPenjaminRekM::model()->deleteAllByAttributes(array(
        //  'penjamin_id'=>$modPenjamin->penjamin_id,
        //));


        //var_dump($_POST['AKPenjaminpasienM']);die;
        /* $deb = new PenjaminrekM();
						$deb->debitkredit = $deb->saldonormal = 'D';
						$deb->penjamin_id = $id;
						$deb->rekening5_id = $_POST['AKPenjaminpasienM']['rekening_debit'];

						$r5 = Rekening5M::model()->findByPk($deb->rekening5_id);
						$r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
						$r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
						$r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
						$r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

						$deb->rekening4_id = $r5->rekening4_id;
						$deb->rekening3_id = $r4->rekening3_id;
						$deb->rekening2_id = $r3->rekening2_id;
						$deb->rekening1_id = $r2->rekening1_id;
						$deb->ispembayaran = $_POST['AKPenjaminpasienM']['ispembayaran'];

						$deb->save();

						$kre = new PenjaminrekM();
						$kre->debitkredit = $kre->saldonormal = 'K';
						$kre->penjamin_id = $id;
						$kre->rekening5_id = $_POST['AKPenjaminpasienM']['rekeningKredit'];
						$kre->rekening5_id = $_POST['AKPenjaminpasienM']['rekeningKredit'];

						$r5 = Rekening5M::model()->findByPk($kre->rekening5_id);
						$r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
						$r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
						$r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
						$r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

						$kre->rekening4_id = $r5->rekening4_id;
						$kre->rekening3_id = $r4->rekening3_id;
						$kre->rekening2_id = $r3->rekening2_id;
						$kre->rekening1_id = $r2->rekening1_id;
						$kre->ispembayaran = $_POST['AKPenjaminpasienM']['ispembayaran'];

						$kre->save();

						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						$this->redirect(array('admin','tab'=>isset($_GET['tab'])?$_GET['tab']:''));
							//} */

        if (isset($_POST['delete'])) {
          foreach ($_POST['delete']['penjaminrek_id'] as $idxx => $itemdel) {
            if (!empty($itemdel)) {
              $det = AKPenjaminRekM::model()->findByPk($itemdel);

              $ok = $ok && $det->delete();
            }
          }
        }


        if (isset($_POST['detail'])) {
          foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
            if (!empty($item)) {

              if (!empty($_POST['detail']['penjaminrek_id'][$idx])) {
                $det = AKPenjaminRekM::model()->findByPk($_POST['detail']['penjaminrek_id'][$idx]);
                $det->update_time = date("Y-m-d H:i:s");
                $det->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              } else {
                $det = new AKPenjaminRekM;
                $det->penjamin_id = $modPenjamin->penjamin_id;
                $det->debitkredit = $det->saldonormal = $_POST['detail']['debitkredit'][$idx];
                $det->rekening5_id = $item;
                $det->create_time = date("Y-m-d H:i:s");
                $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $det->create_ruangan = Yii::app()->user->getState('ruangan_id');
              }

              if (isset($_POST['detail']['is_pilihan'][$item . $det->debitkredit])) {
                $det->ispembayaran = $_POST['detail']['is_pilihan'][$item . $det->debitkredit];
              } else {
                $det->ispembayaran = false;
              }

              $r5 = Rekening5M::model()->findByPk($item);
              $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
              $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
              $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);


              $det->rekening4_id = $r5->rekening4_id;
              $det->rekening3_id = $r4->rekening3_id;
              $det->rekening2_id = $r3->rekening2_id;
              $det->rekening1_id = $r2->rekening1_id;
              // var_dump($_POST['detail'], $det->attributes, $det->validate(), $det->errors);

              if ($det->validate()) $ok = $ok && $det->save();
              else $ok = false;

              //var_dump($det->getErrors());
            }
          }
        }

        if ($ok) {
          Yii::app()->user->setFlash('success', 'Data ' . $modPenjamin->penjamin_nama . ' berhasil disimpan.');
          $trans->commit();
          $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : ''));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
          //$this->redirect(array('update', 'id' => $model->jenispengeluaran_id));
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }
    }

    $this->render('update', array(
      'modPenjamin' => $modPenjamin,
      'model' => $model,
    ));
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKPenjaminRekM::model()->findByPk($id);
    $modPenjamin = AKPenjaminpasienM::model()->findByPk($model->penjamin_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKPenjaminrekM'])) {
      $model->attributes = $_POST['AKPenjaminrekM'];
      $view = 'UbahRekeningDebit';

      $update = AKPenjaminrekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKPenjaminrekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenjamin'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->penjaminrek_id, 'frame' => $_GET['frame'], 'idPenjamin' => $_GET['idPenjamin']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->penjamin_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
      'modPenjamin' => $modPenjamin
    ));
  }
  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKPenjaminRekM::model()->findByPk($id);
    $modPenjamin = AKPenjaminpasienM::model()->findByPk($model->penjamin_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKPenjaminrekM'])) {
      $model->attributes = $_POST['AKPenjaminrekM'];
      $view = 'UbahRekeningKredit';

      $update = AKPenjaminrekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKPenjaminrekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenjamin'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->penjaminrek_id, 'frame' => $_GET['frame'], 'idPenjamin' => $_GET['idPenjamin']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->penjamin_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modPenjamin' => $modPenjamin
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

      $model = AKPenjaminRekM::model()->deleteAllByAttributes(array('penjamin_id' => $id));
      //$model = AKPenjaminRekM::model()->findByPk($id);

      //	$model->delete();
      //  $this->loadDelete($id)->delete();

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
    $dataProvider = new CActiveDataProvider('AKPenjaminpasienM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {

    $model = new AKPenjaminpasienM('search');
    $model->unsetAttributes();

    if (isset($_GET['AKPenjaminpasienM'])) {
      $model->attributes = $_GET['AKPenjaminpasienM'];
      //$model->rekening_debit = $_GET['AKPenjaminpasienM']['rekening_debit'];
      //$model->rekeningKredit = $_GET['AKPenjaminpasienM']['rekeningKredit'];
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
    $model = AKPenjaminpasienM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function loadDelete($id)
  {
    $model = AKPenjaminpasienM::model()->findByPk($id);


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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'penjaminpasien-m-form') {
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
    AKPenjaminpasienM::model()->updateByPk($id, array('penjamin_aktif ' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new AKPenjaminpasienM;
    if (isset($_REQUEST['AKPenjaminpasienM'])) {
      $model->attributes = $_REQUEST['AKPenjaminpasienM'];
      $model->carabayar_nama = !empty($_REQUEST['AKPenjaminRekM']['carabayar_nama']) ? $_REQUEST['AKPenjaminRekM']['carabayar_nama'] : null;
    }
    $judulLaporan = 'Data Jurnal Rekening Penjamin ';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  /* jurnal rek penjamin */
  public function actionGetRekeningEditDebitPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id = $_POST['rekening5_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $penjaminrek_id = $_POST['penjaminrek_id'];

      $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionGetRekeningEditKreditPenjamin()

  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id = $_POST['rekening5_id'];

      $penjamin_id = $_POST['penjamin_id'];
      $penjaminrek_id = $_POST['penjaminrek_id'];

      $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionCekRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekdebit_id = isset($_POST['rekdebit_id']) ? $_POST['rekdebit_id'] : null;
      $rekkredit_id = isset($_POST['rekkredit_id']) ? $_POST['rekkredit_id'] : null;
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

      //$cekKredit = AKPenjaminRekM::model()->findAllByAttributes(array('debitkredit'=> Params::));
    }
  }

  /**
   * @author	M Iqbal Laksana	<iqbal.laksana@piindonesia.co.id>
   * - digunakan untuk menambahkan data rekening
   */
  public function actionFormRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $r = Rekening5M::model()->findByPk($_POST['id']);
      $dk = $_POST['debitkredit'];

      $res = array();

      $item = new AKPenjaminRekM;


      $res['dat'] = $this->renderPartial('_rowRekeningPenjamin', array('dk' => $dk, 'item' => $item, 'r' => $r), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }


  /*end jurnal rek penjamin */
}
