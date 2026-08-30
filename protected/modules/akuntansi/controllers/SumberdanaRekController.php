<?php
class SumberdanaRekController extends MyAuthController
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
    $model = SumberdanaM::model()->findByAttributes(array('sumberdana_id' => $id));

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
    $model = new SumberdanaM;
    $ok = true;

    if (isset($_POST['SumberdanaM'])) {
      $trans = Yii::app()->db->beginTransaction();
      //$model->unsetAttributes();
      //$model->attributes=$_POST['SumberdanaM'];
      //$model->sumberdana_namalainnya = $model->sumberdana_nama;
      //$model->sumberdana_aktif = true;
      //$model->create_time = date('Y-m-d H:i:s');
      //$model->create_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');
      //$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      if (isset($_POST['SumberdanaM']['sumberdana_id'])) {
        $model = SumberdanaM::model()->findByPk($_POST['SumberdanaM']['sumberdana_id']);
      }

      if ($ok) {
        if (isset($_POST['SumberdanaM']['rekening_debit']) && !empty($_POST['SumberdanaM']['rekening_debit'])) {
          $deb = new AKSumberdanaRekM();
          $deb->debitkredit = $deb->saldonormal =  'D';
          $deb->sumberdana_id = $model->sumberdana_id;
          $deb->rekening5_id = $_POST['SumberdanaM']['rekening_debit'];
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


          // var_dump($deb->attributes); die;

          $deb->save();
        }

        if (isset($_POST['SumberdanaM']['rekening_kredit']) && !empty($_POST['SumberdanaM']['rekening_kredit'])) {
          $kre = new AKSumberdanaRekM();
          $kre->debitkredit = $kre->saldonormal =  'K';
          $kre->sumberdana_id = $model->sumberdana_id;
          $kre->rekening5_id = $_POST['SumberdanaM']['rekening_kredit'];
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
        }

        $trans->commit();

        Yii::app()->user->setFlash('success', 'Data ' . $model->sumberdana_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : ''));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    /*
                $model=new AKSumberdanaRekM();
                
		$modSumberdana = new SumberdanaM();
		$modDetails = array();
		
		if (isset($_GET['SumberdanaM'])){
				$modSumberdana->unsetAttributes();
				$modSumberdana->attributes=$_GET['SumberdanaM'];
				$modSumberdana->sumberdana_nama = isset($_GET['SumberdanaM']['sumberdana_nama'])?$_GET['SumberdanaM']['sumberdana_nama']:null;
		}
		if(isset($_POST['AKSumberdanaRekM']))
		{                        
			$transaction = Yii::app()->db->beginTransaction();
			try{
				 $success = true;
				 $modDetails = $this->validasiTabular($_POST['AKSumberdanaRekM']);
				 //var_dump(count((array)$modDetails));
				 //exit;
					foreach ($modDetails as $i => $data) {
//                                    echo '<pre>';
//                                    echo print_r($data->jmlsisapiutang);
//                                    echo exit();
						if ($data->sumberdana_id > 0) {
							// if ($data->update()) {
							//     $success = true;

							// } else {
							//     $success = false;
							// }
							// echo '<pre>';
							// echo print_r($data->getErrors());
							// echo '</pre>';
//                                          exit();
							$data->save();
						}else{
							$data->save();
						}
					}

				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin','id'=>1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			}
			catch(Exception $ex){
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}

		}
                 * 
                 */

    $this->render('create', array(
      'model' => $model
    ));
  }

  protected function validasiTabular($data)
  {
    $x = 0;
    foreach ($data['rekening'] as $j => $row) {
      foreach ($data['sumberdana'] as $i => $row2) {
        $modDetails[$x] = new AKSumberdanaRekM;
        $modDetails[$x]->attributes = $row;
        $modDetails[$x]->sumberdana_id = $i;
        $modDetails[$x]->rekening5_id = $row['rekening5_id'];
        $modDetails[$x]->validate();
        $x++;
      }
      //            echo '<pre>';
      //            echo print_r($modDetails[$i]->getErrors());
      //            echo '</pre>';
      //print_r($data['suplier']);
      //exit;
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
    $modSumber = SumberdanaM::model()->findByPk($id);

    //$modeld = AKSumberdanaRekM::model()->findByAttributes(array('sumberdana_id'=>$id, 'debitkredit'=>'D'));
    //$modelk = AKSumberdanaRekM::model()->findByAttributes(array('sumberdana_id'=>$id, 'debitkredit'=>'K'));

    //if (empty($modeld)) $modeld = new AKSumberdanaRekM ();
    //if (empty($modelk)) $modelk = new AKSumberdanaRekM ();
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SumberdanaM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $modSumber->attributes = $_POST['SumberdanaM'];
        //$modSumber->sumberdana_namalainnya = strtoupper($modSumber->sumberdana_nama);
        //$modSumber->update_time = date('Y-m-d H:i:s');
        //$modSumber->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

        //$modSumber->save();

        /*AKSumberdanaRekM::model()->deleteAllByAttributes(array(
				'sumberdana_id'=>$modSumber->sumberdana_id,
			));

			if (isset($_POST['SumberdanaM']['rekening_debit']) && !empty($_POST['SumberdanaM']['rekening_debit'])) {
				$deb = new AKSumberdanaRekM();
				$deb->debitkredit = $deb->saldonormal = 'D';
				$deb->sumberdana_id = $id;
				$deb->rekening5_id = $_POST['SumberdanaM']['rekening_debit'];
				$deb->create_time = date('Y-m-d H:i:s');
				$deb->create_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');
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

			if (isset($_POST['SumberdanaM']['rekening_kredit']) && !empty($_POST['SumberdanaM']['rekening_kredit'])) {
				$kre = new AKSumberdanaRekM();
				$kre->debitkredit = $kre->saldonormal = 'K';
				$kre->sumberdana_id = $id;
				$kre->rekening5_id = $_POST['SumberdanaM']['rekening_kredit'];
				$kre->create_time = date('Y-m-d H:i:s');
				$kre->create_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');
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
			}
                    
                  
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','tab'=>isset($_GET['tab'])?$_GET['tab']:''));*/
        //} */
        if (isset($_POST['delete'])) {
          foreach ($_POST['delete']['sumberdanarek_id'] as $idxx => $itemdel) {
            if (!empty($itemdel)) {
              $det = AKSumberdanaRekM::model()->findByPk($itemdel);

              $ok = $ok && $det->delete();
            }
          }
        }


        if (isset($_POST['detail'])) {
          foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
            if (!empty($item)) {

              if (!empty($_POST['detail']['sumberdanarek_id'][$idx])) {
                $det = AKSumberdanaRekM::model()->findByPk($_POST['detail']['sumberdanarek_id'][$idx]);
                $det->update_time = date("Y-m-d H:i:s");
                $det->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              } else {
                $det = new AKSumberdanaRekM;
                $det->sumberdana_id = $modSumber->sumberdana_id;
                $det->debitkredit = $det->saldonormal = $_POST['detail']['debitkredit'][$idx];
                $det->rekening5_id = $item;
                $det->create_time = date("Y-m-d H:i:s");
                $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $det->create_ruangan = Yii::app()->user->getState('ruangan_id');
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
          Yii::app()->user->setFlash('success', 'Data ' . $modSumber->sumberdana_nama . ' berhasil disimpan.');
          $trans->commit();
          $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : ''));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
          //$this->redirect(array('update', 'id' => $model->jenispengeluaran_id));
        }
      } catch (Exception $e) {
        //var_dump($e->getMessage());
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }


    $this->render('update', array(
      'modSumber' => $modSumber,
      //	'modeld'=>$modeld, 'modelk'=>$modelk,
    ));
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKSumberdanaRekM::model()->findByPk($id);
    $modSumberdana = SumberdanaM::model()->findByPk($model->sumberdana_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKSumberdanaRekM'])) {
      $model->attributes = $_POST['AKSumberdanaRekM'];
      $view = 'UbahRekeningDebit';

      $update = AKSumberdanaRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKSumberdanaRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idSumberdana'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->sumberdanarek_id, 'frame' => $_GET['frame'], 'idSumberdana' => $_GET['idSumberdana']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->sumberdana_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
      'modSumberdana' => $modSumberdana
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKSumberdanaRekM::model()->findByPk($id);
    $modSumberdana = SumberdanaM::model()->findByPk($model->sumberdana_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKSumberdanaRekM'])) {
      $model->attributes = $_POST['AKSumberdanaRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKSumberdanaRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKSumberdanaRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idSumberdana'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->sumberdanarek_id, 'frame' => $_GET['frame'], 'idSumberdana' => $_GET['idSumberdana']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->sumberdana_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modSumberdana' => $modSumberdana
    ));
  }
  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {

      $trans = Yii::app()->db->beginTransaction();
      $data = array('sukses' => 0);

      $ok = true;
      $ok = $ok && AKSumberdanaRekM::model()->deleteAll('sumberdana_id=:sumberdana_id', array(':sumberdana_id' => $_POST['id']));

      if ($ok) {
        $trans->commit();
        $data['sukses'] = 1;
      } else {
        $trans->rollback();
        $data['sukses'] = 0;
      }

      echo CJSON::encode($data);
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDeleteMaster()
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $trans = Yii::app()->db->beginTransaction();
      $data = array('sukses' => 0);

      $ok = true;
      SumberdanarekM::model()->deleteAllByAttributes(array('sumberdana_id' => $_POST['id']));
      $ok = $ok && SumberdanaM::model()->deleteAllByAttributes(array('sumberdana_id' => $_POST['id']));

      if ($ok) {
        $trans->commit();
        $data['sukses'] = 1;
      } else {
        $trans->rollback();
        $data['sukses'] = 0;
      }


      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      //if(!isset($_GET['ajax']))
      //	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


      echo CJSON::encode($data);
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('AKSumberdanaRekM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  { // $this->layout='//layouts/iframe';
    if ($id == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $model = new SumberdanaM('search');
    $model->unsetAttributes();

    if (isset($_GET['SumberdanaM'])) {
      $model->attributes = $_GET['SumberdanaM'];
      $model->sumberdana_nama = $_GET['SumberdanaM']['sumberdana_nama'];
      //$model->rekDebit 		= $_GET['AKSumberdanaRekM']['rekDebit'];
      //$model->rekKredit 		= $_GET['AKSumberdanaRekM']['rekKredit'];
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
    $model = SumberdanaM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function loadDelete($id)
  {
    $model = SumberdanaM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sumberdanarek-m-form') {
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
    $data = array('sukses' => 0);
    if (SumberdanaM::model()->updateByPk($id, array('sumberdana_aktif' => false))) {
      $data['sukses'] = 1;
    }
    echo CJSON::encode($data);
  }

  public function actionPrint()
  {
    $model = new SumberdanaM; //AKSumberdanaRekM;

    if (isset($_GET['SumberdanaM'])) {
      $model->attributes = $_GET['SumberdanaM'];
      $model->sumberdana_nama = $_GET['SumberdanaM']['sumberdana_nama'];
    }
    $judulLaporan = 'Data Sumber Dana Rekening ';
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

  public function actionGetRekeningEditDebitKreditSumberdana()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id     = $_POST['rekening5_id'];
      $sumberdana_id    = $_POST['sumberdana_id'];
      $sumberdanarek_id = $_POST['sumberdanarek_id'];

      $update = AKSumberdanaRekM::model()->updateByPk($sumberdanarek_id, array('rekening5_id' => $rekening5_id));
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

      $item = new AKSumberdanaRekM;


      $res['dat'] = $this->renderPartial('_rowRekeningSumberDana', array('dk' => $dk, 'item' => $item, 'r' => $r), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }
}
