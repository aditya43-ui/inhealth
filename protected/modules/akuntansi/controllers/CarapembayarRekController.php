<?php

class CarapembayarRekController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   *  digunakan untuk menentukan apakah menu masuk dalam tab menu atau menu tersendiri
   */

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
    $model = LookupM::model()->findByAttributes(array('lookup_value' => $id, 'lookup_type' => 'carapembayaran'));
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new AKCarapembayarRekM();

    $modlookup = new AKLookupM();

    // $modCarabayar = new CarabayarM();
    // if (isset($_GET['CarabayarM'])){
    //         $modCarabayar->unsetAttributes();
    //         $modCarabayar->attributes=$_GET['CarabayarM'];
    //         $modCarabayar->carabayar_id = $_GET['CarabayarM']['carabayar_id'];
    // }

    $modDetails = array();

    if (isset($_POST['AKLookupM'])) {
      $trans = Yii::app()->db->beginTransaction();

      $ok = true;

      if ($_POST['AKLookupM'])
        $modlookup->unsetAttributes();
      $modlookup->attributes = $_POST['AKLookupM'];
      //$modlookup->lookup_type = 'carapembayaran';
      //$modlookup->lookup_value = $modlookup->lookup_name;
      //$modlookup->lookup_aktif = true;
      //$modlookup->create_time = date('Y-m-d H:i:s');
      //$modlookup->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      //$modlookup->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($ok) {
        if (isset($_POST['AKLookupM']['rekening_debit']) && !empty($_POST['AKLookupM']['rekening_debit'])) {
          $deb = new AKCarapembayarRekM();
          $deb->debitkredit = $deb->saldonormal = 'D';
          // $deb->carapembayaran = $modlookup->lookup_name;
          $det->carapembayaran = $modlookup->lookup_value;
          $deb->rekening5_id = $_POST['AKLookupM']['rekening_debit'];
          $deb->create_time = date('Y-m-d H:i:s');
          $deb->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $deb->create_ruangan = Yii::app()->user->getState('ruangan_id');

          // $r5 = Rekening5M::model()->findByPk($deb->rekening5_id);
          // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
          // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
          // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
          // $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

          // $deb->rekening4_id = $r5->rekening4_id;
          // $deb->rekening3_id = $r4->rekening3_id;
          // $deb->rekening2_id = $r3->rekening2_id;
          // $deb->rekening1_id = $r2->rekening1_id;

          // var_dump($deb->attributes); die;

          $deb->save();
        }

        if (isset($_POST['AKLookupM']['rekening_kredit']) && !empty($_POST['AKLookupM']['rekening_kredit'])) {
          $kre = new AKCarapembayarRekM();
          $kre->debitkredit = $kre->saldonormal = 'K';
          // $kre->carapembayaran = $modlookup->lookup_name;
          $det->carapembayaran = $modlookup->lookup_value;
          $kre->rekening5_id = $_POST['AKLookupM']['rekening_kredit'];
          $kre->create_time = date('Y-m-d H:i:s');
          $kre->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $kre->create_ruangan = Yii::app()->user->getState('ruangan_id');

          // $r5 = Rekening5M::model()->findByPk($kre->rekening5_id);
          // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
          // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
          // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
          // $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

          // $kre->rekening4_id = $r5->rekening4_id;
          // $kre->rekening3_id = $r4->rekening3_id;
          // $kre->rekening2_id = $r3->rekening2_id;
          // $kre->rekening1_id = $r2->rekening1_id;

          $kre->save();
        }

        $trans->commit();

        Yii::app()->user->setFlash('success', 'Data ' . $modlookup->lookup_name . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '', 'modul_id' => Yii::app()->session['modul_id']));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }
      //$modCarabayar->carabayar_id = $_GET['CarabayarM']['carabayar_id'];
    }

    /*
		if (isset($_POST['AKCarapembayarRekM'])) {

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$success = true;
				$modDetails = $this->validasiTabular($_POST['AKCarapembayarRekM']);
				// var_dump(count((array)$modDetails));
				// exit;
				foreach ($modDetails as $i => $data) {
					// echo '<pre>';
					// echo print_r($data->carabayar_id);                                       
					if (isset($data)) {
						// if ($data->update()) {
						//     $success = true;
						// } else {
						//     $success = false;
						// }
						// echo '<pre>';
						// echo print_r($data->getErrors());
						// echo '</pre>';
						// exit();
						$data->save();
						// print_r($data->getErrors());
					} else {
						$data->save();
					}
				}
				// exit();

				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin','id'=>1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}
		}
                 * 
                 */

    $this->render('create', array(
      'modlookup' => $modlookup
    ));
  }

  protected function validasiTabular($data)
  {
    $this->layout = '//layouts/iframe';
    $x = 0;
    foreach ($data['rekening'] as $j => $row) {
      foreach ($data['bayar'] as $i => $row2) {
        $modDetails[$x] = new AKCarapembayarRekM;
        $modDetails[$x]->attributes = $row;
        //$modDetails[$x]->carabayar_id = $i;
        $modDetails[$x]->rekening5_id = $row['rekening5_id'];
        $modDetails[$x]->debitkredit = $row['rekening5_nb'];
        //	                $modDetails[$x]->rekening4_id = $row['rekening4_id'];
        //	                $modDetails[$x]->rekening3_id = $row['rekening3_id'];
        //	                $modDetails[$x]->rekening2_id = $row['rekening2_id'];
        //	                $modDetails[$x]->rekening1_id = $row['rekening1_id'];
        //	                $modDetails[$x]->saldonormal = $row['saldonormal'];
        $modDetails[$x]->carapembayaran = $i;

        $modDetails[$x]->validate();
        $x++;
      }
      // echo '<pre>';
      // echo print_r($modDetails[$i]->getErrors());
      // echo '</pre>';
      //print_r($data['bayar']);
      // exit;
    }
    //print_r(count((array)$modDetails));
    //exit;

    return $modDetails;
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {

    $modlookup = AKLookupM::model()->findByAttributes(array(
      'lookup_type' => 'carapembayaran',
      'lookup_name' => $id,
    ));

    /*$modeld = AKCarapembayarRekM::model()->findByAttributes(array(
			'carapembayaran'=>$id,
			'debitkredit'=>'D',
		));
		$modelk = AKCarapembayarRekM::model()->findByAttributes(array(
			'carapembayaran'=>$id,
			'debitkredit'=>'K',
		));
                
		if (empty($modeld)) $modeld = new AKCarapembayarRekM;
		if (empty($modelk)) $modelk = new AKCarapembayarRekM;*/

    if (isset($_POST['AKLookupM'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        // var_dump($_POST); die;

        /*AKCarapembayarRekM::model()->deleteAllByAttributes(array(
				'carapembayaran'=>$modlookup->lookup_name,
			));

			if (isset($_POST['AKLookupM']['rekening_debit']) && !empty($_POST['AKLookupM']['rekening_debit'])) {
				$deb = new AKCarapembayarRekM();
				$deb->debitkredit = $deb->saldonormal = 'D';
				$deb->carapembayaran = $id;
				$deb->rekening5_id = $_POST['AKLookupM']['rekening_debit'];
				$deb->create_time = date('Y-m-d H:i:s');
				$deb->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
				$deb->create_ruangan = Yii::app()->user->getState('ruangan_id');

				$r5 = Rekening5M::model()->findByPk($deb->rekening5_id);
				$r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
				$r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
				$r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
				$r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

				$deb->rekening4_id = $r5->rekening4_id;
				$deb->rekening3_id = $r4->rekening3_id;
				$deb->rekening2_id = $r3->rekening2_id;
				$deb->rekening1_id = $r2->rekening1_id;

				$deb->save();
			}

			if (isset($_POST['AKLookupM']['rekening_kredit']) && !empty($_POST['AKLookupM']['rekening_kredit'])) {
				$kre = new AKCarapembayarRekM();
				$kre->debitkredit = $kre->saldonormal = 'K';
				$kre->carapembayaran = $id;
				$kre->rekening5_id = $_POST['AKLookupM']['rekening_kredit'];
				$kre->create_time = date('Y-m-d H:i:s');
				$kre->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
				$kre->create_ruangan = Yii::app()->user->getState('ruangan_id');

				$r5 = Rekening5M::model()->findByPk($kre->rekening5_id);
				$r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
				$r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
				$r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
				$r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

				$kre->rekening4_id = $r5->rekening4_id;
				$kre->rekening3_id = $r4->rekening3_id;
				$kre->rekening2_id = $r3->rekening2_id;
				$kre->rekening1_id = $r2->rekening1_id;

				$kre->save();
			}*/

        //Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        //$this->redirect(array('admin','tab'=>isset($_GET['tab'])?$_GET['tab']:'','modul_id'=>Yii::app()->session['modul_id']));



        // Uncomment the following line if AJAX validation is needed

        /*
		if (isset($_POST['AKCarapembayarRekM'])) {
			$model->attributes = $_POST['AKCarapembayarRekM'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin', 'id' => $model->carabayar_id));
			}
		} */
        if (isset($_POST['delete'])) {
          foreach ($_POST['delete']['carapembrek_id'] as $idxx => $itemdel) {
            if (!empty($itemdel)) {
              $det = AKCarapembayarRekM::model()->findByPk($itemdel);

              $ok = $ok && $det->delete();
            }
          }
        }


        if (isset($_POST['detail'])) {
          foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
            if (!empty($item)) {

              if (!empty($_POST['detail']['carapembrek_id'][$idx])) {
                $det = CarapembrekM::model()->findByPk($_POST['detail']['carapembrek_id'][$idx]);
                $det->update_time = date("Y-m-d H:i:s");
                $det->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              } else {
                $det = new CarapembrekM;
                // $det->carapembayaran = $modlookup->lookup_name;
                $det->carapembayaran = $modlookup->lookup_value;
                $det->debitkredit = $det->saldonormal = $_POST['detail']['debitkredit'][$idx];
                $det->rekening5_id = $item;
                $det->create_time = date("Y-m-d H:i:s");
                $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $det->create_ruangan = Yii::app()->user->getState('ruangan_id');
              }

              // $r5 = Rekening5M::model()->findByPk($item);
              // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
              // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
              // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);


              // $det->rekening4_id = $r5->rekening4_id;
              // $det->rekening3_id = $r4->rekening3_id;
              // $det->rekening2_id = $r3->rekening2_id;
              // $det->rekening1_id = $r2->rekening1_id;
              // var_dump($_POST['detail'], $det->attributes, $det->validate(), $det->errors);

              if ($det->validate()) $ok = $ok && $det->save();
              else $ok = false;

              //var_dump($det->getErrors());
            }
          }
        }

        if ($ok) {
          Yii::app()->user->setFlash('success', 'Data ' . $modlookup->lookup_name . ' berhasil disimpan.');
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
      'modlookup' => $modlookup,
      //           'modeld' => $modeld,
      //        'modelk' => $modelk,
    ));
  }

  public function actionUbahRekeningDebit($id)
  {
    $debet = 'D';
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    //$model= AKCarapembayarRekM::model()->findByPk($id);
    $model = AKCarapembayarRekM::model()->findByAttributes(array('carapembayaran' => $id));

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKCarapembayarRekM'])) {
      $model->attributes = $_POST['AKCarapembayarRekM'];
      $view = 'UbahRekeningDebit';

      $update = AKCarapembayarRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKCarapembayarRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idCarabayar'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->carapembrek_id, 'frame' => $_GET['frame'], 'idCarabayar' => $_GET['idCarabayar']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->carabayar_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    $debet = 'K';
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    //$model= AKCarapembayarRekM::model()->findByPk($id);
    $model = AKCarapembayarRekM::model()->findByAttributes(array('carapembayaran' => $id));

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKCarapembayarRekM'])) {
      $model->attributes = $_POST['AKCarapembayarRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKCarapembayarRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKCarapembayarRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idCarabayar'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->carapembrek_id, 'frame' => $_GET['frame'], 'idCarabayar' => $_GET['idCarabayar']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->carabayar_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
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
      $model = AKCarapembayarRekM::model()->deleteAll('carapembayaran=:carapembayaran', array(':carapembayaran' => $id));

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
    $dataProvider = new CActiveDataProvider('AKCarapembayarRekM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {

    if ($id == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;
    $model = new AKLookupM('search');
    $model->unsetAttributes();
    $model->lookup_type = "carapembayaran";

    if (isset($_GET['AKLookupM'])) {
      $model->attributes = $_GET['AKLookupM'];
      $model->rekDebit = $_GET['AKLookupM']['rekDebit'];
      $model->rekKredit = $_GET['AKLookupM']['rekKredit'];
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
    $model = CarabayarM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function loadDelete($id)
  {
    $model = CarabayarM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'carabayarrek-m-form') {
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    AKCarapembayarRekM::model()->updateByPk($id, array('carabayar_aktif ' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new AKLookupM; //AKCarapembayarRekM
    $model->lookup_type = "carapembayaran";
    if (isset($_REQUEST['AKLookupM'])) {
      $model->attributes = $_REQUEST['AKLookupM'];
      $model->lookup_type = "carapembayaran";
    }
    $judulLaporan = 'Data Jenis Penjamin Rekening ';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  public function actionGetRekeningEditDebitKreditCarabayar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //          $rekening1_id     = $_POST['rekening1_id'];
      //          $rekening2_id     = $_POST['rekening2_id'];
      //          $rekening3_id     = $_POST['rekening3_id'];
      //          $rekening4_id     = $_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      //          $carabayar_id     = $_POST['carabayar_id'];
      $carapembrek_id = $_POST['carapembrek_id'];
      //          $saldonormal      = $_POST['saldonormal'];

      $update = AKCarapembayarRekM::model()->updateByPk($carapembrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
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

      $item = new AKCarapembayarRekM;


      $res['dat'] = $this->renderPartial('_rowRekeningCaraBayar', array('dk' => $dk, 'item' => $item, 'r' => $r), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }
}
