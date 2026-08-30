<?php

class JurnalRekPengeluaranController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * digunakan untuk menentukan template yang digunakan iframe(tanpa menu)  atau menggunakan mainNeonSideBar(menu sidebar dan top bar)
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

    $model = AKJenispengeluaranM::model()->findByAttributes(array('jenispengeluaran_id' => $id));

    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'admin' page.
   */
  public function actionCreate()
  {

    $model = new AKJenispengeluaranM;

    if (isset($_POST['AKJenispengeluaranM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      if ($_POST['AKJenispengeluaranM']['jenispengeluaran_id']) {
        $model = AKJenispengeluaranM::model()->findByPk($_POST['AKJenispengeluaranM']['jenispengeluaran_id']);
      }
      //$model->attributes=$_POST['AKJenispengeluaranM'];
      //$model->create_time = date('Y-m-d');
      //$model->create_ruangan= Yii::app()->user->getState('ruangan_id');
      //$model->create_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');

      //if ($model->validate()) $ok = $ok && $model->save();
      //else $ok = false;

      if (isset($_POST['AKJnsPengeluaranRekM'])) {



        foreach ($_POST['AKJnsPengeluaranRekM']['rekening'] as $item) {
          if (!empty($item['rekening5_id'])) {
            $det = new AKJnsPengeluaranRekM;
            $det->attributes = $item;
            $det->jenispengeluaran_id = $model->jenispengeluaran_id;
            $det->debitkredit = $det->saldonormal = $item['rekening5_nb'];

            $det->rekening5_id = $det->rekening5_id;

            // if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
            // else $model->rekeningkredit_id = $det->rekening5_id;

            // $r5 = Rekening5M::model()->findByPk($item);
            // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
            // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
            // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
            // $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

            // $det->rekening4_id = $r5->rekening4_id;
            // $det->rekening3_id = $r4->rekening3_id;
            // $det->rekening2_id = $r3->rekening2_id;
            // $det->rekening1_id = $r2->rekening1_id;
            $det->create_time = date('Y-m-d H:i:s');
            $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $det->create_ruangan = Yii::app()->user->getState('ruangan_id');


            if ($det->validate()) $ok = $ok && $det->save();
            else $ok = false;
          }
        }
        $model->save();
      }

      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenispengeluaran_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '', 'sukses' => 1));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('create'));
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
    $model = $this->loadModel($id);

    if (isset($_POST['AKJenispengeluaranM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        $model->attributes = $_POST['AKJenispengeluaranM'];
        /*$model->update_time = date('Y-m-d');				
				$model->update_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');
                        
				if ($model->validate()) $ok = $ok && $model->save();
				else $ok = false;

				AKJnsPengeluaranRekM::model()->deleteAllByAttributes(array(
					'jenispengeluaran_id'=>$model->jenispengeluaran_id,
				));

				if (isset($_POST['AKJnsPengeluaranRekM'])) {
					foreach ($_POST['AKJnsPengeluaranRekM']['rekening'] as $item) {
						if (!empty($item['rekening5_id'])){
							$det = new AKJnsPengeluaranRekM;
							$det->attributes = $item;
							$det->jenispengeluaran_id = $model->jenispengeluaran_id;
							$det->debitkredit = $det->saldonormal = $item['rekening5_nb'];

							if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
							else $model->rekeningkredit_id = $det->rekening5_id;

							$r5 = Rekening5M::model()->findByPk($item);
							$r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
							$r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
							$r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
							$r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

							$det->rekening4_id = $r5->rekening4_id;
							$det->rekening3_id = $r4->rekening3_id;
							$det->rekening2_id = $r3->rekening2_id;
							$det->rekening1_id = $r2->rekening1_id;
							$det->create_time = date('Y-m-d H:i:s');
							$det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
							$det->create_ruangan = Yii::app()->user->getState('ruangan_id');

							// var_dump($det->attributes, $det->validate(), $det->errors);

							if ($det->validate()) $ok = $ok && $det->save();
							else $ok = false;
						}
					}
					$model->save();
				}*/

        if (isset($_POST['delete'])) {
          foreach ($_POST['delete']['jnspengeluaranrek_id'] as $idxx => $itemdel) {
            if (!empty($itemdel)) {
              $det = AKJnsPengeluaranRekM::model()->findByPk($itemdel);

              $ok = $ok && $det->delete();
            }
          }
        }


        if (isset($_POST['detail'])) {
          foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
            if (!empty($item)) {

              if (!empty($_POST['detail']['jnspengeluaranrek_id'][$idx])) {
                $det = AKJnsPengeluaranRekM::model()->findByPk($_POST['detail']['jnspengeluaranrek_id'][$idx]);
                $det->update_time = date("Y-m-d H:i:s");
                $det->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              } else {
                $det = new AKJnsPengeluaranRekM;
                $det->jenispengeluaran_id = $model->jenispengeluaran_id;
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
          Yii::app()->user->setFlash('success', 'Data ' . $model->jenispengeluaran_nama . ' berhasil disimpan.');
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
      'model' => $model,
    ));
  }

  public function actionUbahRekeningDebitKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKJenispengeluaranM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJenispengeluaranM'])) {
      $model->attributes = $_POST['AKJenispengeluaranM'];
      $view = 'UbahRekeningDebitKredit';

      $update = AKJenispengeluaranM::model()->updateByPk($id, array('rekeningdebit_id' => $_POST['AKJenispengeluaranM']['rekeningdebit_id'], 'rekeningkredit_id' => $_POST['AKJenispengeluaranM']['rekeningkredit_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->jenispengeluaran_id, 'frame' => $_GET['frame'], 'idPengeluaran' => $_GET['idPengeluaran']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispengeluaran_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebitKredit'), array(
      'model' => $model,
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
      $ok = $ok && AKJnsPengeluaranRekM::model()->deleteAllByAttributes(array('jenispengeluaran_id' => $_POST['id']));

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
      AKJnsPengeluaranRekM::model()->deleteAllByAttributes(array('jenispengeluaran_id' => $_POST['id']));
      $ok = $ok && AKJenispengeluaranM::model()->deleteAllByAttributes(array('jenispengeluaran_id' => $_POST['id']));

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
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('AKJenispengeluaranM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {

    $model = new JenispengeluaranM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['JenispengeluaranM'])) {
      $model->attributes = $_GET['JenispengeluaranM'];
      //			$model->rekDebit=$_GET['JenispengeluaranM']['rekDebit'];
      //			$model->rekKredit=$_GET['JenispengeluaranM']['rekKredit'];
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
    $model = AKJenispengeluaranM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenispengeluaran-m-form') {
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
    $data = array('sukses' => 0);
    if (JenispengeluaranM::model()->updateByPk($id, array('jenispengeluaran_aktif' => false))) {
      $data['sukses'] = 1;
    }
    echo CJSON::encode($data);
  }

  public function actionPrint()
  {
    $model = new JenispengeluaranM; //AKJnsPengeluaranRekM
    if (isset($_REQUEST['JenispengeluaranM'])) {
      $model->attributes = $_REQUEST['JenispengeluaranM'];
    }
    $judulLaporan = 'Data Jurnal Rekening Pengeluaran';
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

      $item = new AKJnsPengeluaranRekM;


      $res['dat'] = $this->renderPartial('_rowRekeningJnsPengeluaran', array('dk' => $dk, 'item' => $item, 'r' => $r), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }
}
