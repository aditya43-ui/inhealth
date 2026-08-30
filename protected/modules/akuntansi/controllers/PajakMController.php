<?php

class PajakMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'akuntansi.views.pajakM.';

  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('AKPajakM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

    public function init(){
  		if (isset($_GET['tab'])){
  			if ($_GET['tab'] == 'frame'){
  				$this->layout='//layouts/iframe';
  			}
  		}
  	}

    // public function actionIndex() {
    //     $dataProvider = new CActiveDataProvider('AKPajakM');
    //     $this->render($this->path_view . 'index', array(
    //             'dataProvider' => $dataProvider,
    //     ));
    // }

    public function actionAdmin() {
        $model = new AKPajakM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AKPajakM'])) {
            $model->attributes = $_GET['AKPajakM'];
            $model->rekening5_nama = isset($_GET['AKPajakM']['rekening5_nama']) ? $_GET['AKPajakM']['rekening5_nama'] : null;
        }

        $this->render($this->path_view . 'admin', array(
                'model' => $model,
        ));
    }

    public function actionCreate() {
        $model = new AKPajakM;

        if (isset($_POST['AKPajakM'])) {
                $model->attributes = $_POST['AKPajakM'];
                if ($model->save()) {
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin', 'id' => $model->pajak_id));
                }
        }

        $this->render($this->path_view . 'create', array(
                'model' => $model,
        ));
    }

    public function loadModel($id) {
		$model = AKPajakM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

    public function actionView($id) {
		$model = $this->loadModel($id);
		$this->render($this->path_view . 'view', array(
			'model' => $model,
		));
	}

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->rekening5_nama = (isset($model->rekening5)?$model->rekening5->nmrekening5:"");

        if (isset($_POST['AKPajakM'])) {
                $model->attributes = $_POST['AKPajakM'];
                if ($model->save()) {
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin', 'id' => $model->pajak_id));
                }
        }
    }

  // public function actionCreate()
  // {
  //   $model = new AKPajakM;

  //   if (isset($_POST['AKPajakM'])) {
  //     $model->attributes = $_POST['AKPajakM'];
  //     if ($model->save()) {
  //       Yii::app()->user->setFlash('success', 'Data ' . $model->pajak_nama . ' berhasil disimpan.');
  //       $this->redirect(array('admin', 'id' => $model->pajak_id));
  //     } else {
  //       Yii::app()->user->setFlash('error', "Data gagal disimpan");
  //     }
  //   }

    public function actionNonActive() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
                $data['sukses'] = 0;
                $model = PajakM::model()->findByPk($id);

                 $model->pajak_aktif = 0;
                 if($model->save()){
                	$data['sukses'] = 1;
                 }

                echo CJSON::encode($data);
        }
    }

    public function actionDelete() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        if (Yii::app()->request->isPostRequest) {
                $id = $_POST['id'];
                PajakM::model()->deleteByPk($id);
                if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array(
                                'status' => 'proses_form',
                                'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                        exit;
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
}

    public function actionRekeningAkuntansi() {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $data['sukses'] = 0;
      $model = PajakM::model()->findByPk($id);

      $model->pajak_aktif = 0;
      if ($model->save()) {
        $data['sukses'] = 1;
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
}


    // protected function performAjaxValidation($model) {
    //     if (isset($_POST['ajax']) && $_POST['ajax'] === 'sabank-m-form') {
    //         echo CActiveForm::validate($model);
    //         Yii::app()->end();
    //     }
    // }

  //   public function actionPrint() {
  //       $model = new AKPajakM();
  //       if (isset($_REQUEST['AKPajakM'])) {
  //               $model->attributes = $_REQUEST['AKPajakM'];
  //       }
  //       if (isset($model->rincianobyek_id)) {
  //         $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
  //         $nama_rekening = $model->nmrekening5;
  //       } else {
  //         if (isset($model->obyek_id)) {
  //           $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
  //           $nama_rekening = $model->nmrekening4;
  //         } else {
  //           $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
  //           $nama_rekening = $model->nmrekening3;
  //         }
  //       }
  //       $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
  //       $returnVal[$i]['value'] = $nama_rekening;
  //     }
  //     echo CJSON::encode($returnVal);
  //   }
  //   Yii::app()->end();
  // }


  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sabank-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $model = new AKPajakM();
    if (isset($_REQUEST['AKPajakM'])) {
      $model->attributes = $_REQUEST['AKPajakM'];
    }
    $judulLaporan = 'Data Pajak';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
