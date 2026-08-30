<?php

class JenisPembayarController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "akuntansi.views.jenisPembayar.";

		public function init(){
			if (isset($_GET['tab'])){
				if ($_GET['tab'] == 'frame'){
					$this->layout='//layouts/iframe';
				}
			}
		}

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render($this->path_view.'view',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	// public function actionCreate()
	// {
	// 	$model = new JnspembayarM;

  //       $rekD = new JnspembrekM;
  //       $rekK = new JnspembrekM;

  //       $rekD->debitkredit = 'D';
  //       $rekK->debitkredit = 'K';

	// 	if(isset($_POST['JnspembayarM']))
	// 	{
  //           $trans = Yii::app()->db->beginTransaction();
  //           $ok = true;


  //           try {

  //               $model->attributes = $_POST['JnspembayarM'];

  //               $bank_list = array();

  //               if ($model->validate()) {
  //                   $ok = $ok && $model->save();

  //                   // var_dump($ok, $model->attributes, $_POST); die;

  //                   if (isset($_POST['JnspembrekM']['detail'])) {
  //                       foreach ($_POST['JnspembrekM']['detail'] as $item) {

  //                           if (!empty($item['bank_id'])) {
  //                               $bank_list[$item['bank_id']] = 1;
  //                           }

  //                           // rekening D
  //                           $det = new JnspembrekM;
  //                           $det->attributes = $item['D'];
  //                           $det->debitkredit = $det->saldonormal = 'D';
  //                           $det->jnspembayar_id = $model->jnspembayar_id;
  //                           $det->bank_id = $item['bank_id'];

  //                           if (!empty($det->rekening5_id) && $det->validate()) {
  //                               $ok = $ok && $det->save();
  //                           }

  //                           // var_dump($det->attributes);

  //                           // rekening K
  //                           $det = new JnspembrekM;
  //                           $det->attributes = $item['K'];
  //                           $det->debitkredit = $det->saldonormal = 'K';
  //                           $det->jnspembayar_id = $model->jnspembayar_id;
  //                           $det->bank_id = $item['bank_id'];

  //                           if (!empty($det->rekening5_id) && $det->validate()) {
  //                               $ok = $ok && $det->save();
  //                           }

  //                           // var_dump($det->attributes);
  //                       }
  //                   }

  //               } else {
  //                   $ok = false;
  //               }

  //               if (count((array)$bank_list) > 0) {
  //                   foreach (array_keys($bank_list) as $item) {
  //                       $bankdet = new JnspembayarbankM;
  //                       $bankdet->bank_id = $item;
  //                       $bankdet->jnspembayar_id = $model->jnspembayar_id;

  //                       $ok = $ok && $bankdet->save();
  //                       // var_dump($bankdet->attributes);
  //                   }
  //               }

  //               // var_dump($ok);
  //               // die;

  //               if ($ok) {
  //                   $trans->commit();
  //                   $this->redirect(array('admin'));
  //               } else {
  //                   $trans->rollback();
  //                   Yii::app()->user->setFlash('error', "Data gagal disimpan !");
  //               }

  //           } catch (Exception $e) {
  //               $trans->rollback();
  //               Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
  //           }

  //         }
  //       }
  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  // public function actionView($id)
  // {
  //   $model = $this->loadModel($id);
  //   $this->render($this->path_view . 'view', array(
  //     'model' => $model,
  //   ));
  // }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $model = new JnspembayarM;

    $rekD = new JnspembrekM;
    $rekK = new JnspembrekM;

    $rekD->debitkredit = 'D';
    $rekK->debitkredit = 'K';

    if (isset($_POST['JnspembayarM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;


      try {

        $model->attributes = $_POST['JnspembayarM'];

        $bank_list = array();

        if ($model->validate()) {
          $ok = $ok && $model->save();

          // var_dump($ok, $model->attributes, $_POST); die;

          if (isset($_POST['JnspembrekM']['detail'])) {
            foreach ($_POST['JnspembrekM']['detail'] as $item) {

              if (!empty($item['bank_id'])) {
                $bank_list[$item['bank_id']] = 1;
              }

              // rekening D
              $det = new JnspembrekM;
              $det->attributes = $item['D'];
              $det->debitkredit = $det->saldonormal = 'D';
              $det->jnspembayar_id = $model->jnspembayar_id;
              $det->bank_id = $item['bank_id'];

              if (!empty($det->rekening5_id) && $det->validate()) {
                $ok = $ok && $det->save();
              }

              // var_dump($det->attributes);

              // rekening K
              $det = new JnspembrekM;
              $det->attributes = $item['K'];
              $det->debitkredit = $det->saldonormal = 'K';
              $det->jnspembayar_id = $model->jnspembayar_id;
              $det->bank_id = $item['bank_id'];

              if (!empty($det->rekening5_id) && $det->validate()) {
                $ok = $ok && $det->save();
              }

              // var_dump($det->attributes);
            }
          }
        } else {
          $ok = false;
        }

        if (count((array)$bank_list) > 0) {
          foreach (array_keys($bank_list) as $item) {
            $bankdet = new JnspembayarbankM;
            $bankdet->bank_id = $item;
            $bankdet->jnspembayar_id = $model->jnspembayar_id;

            $ok = $ok && $bankdet->save();
            // var_dump($bankdet->attributes);
          }
        }

        // var_dump($ok);
        // die;

        if ($ok) {
          $trans->commit();
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'rekD' => $rekD,
      'rekK' => $rekK,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    $rekD = null;
    if (empty($rekD)) {
      $rekD = new JnspembrekM;
      $rekD->debitkredit = "D";
    }

    $rekK = null;
    if (empty($rekK)) {
      $rekK = new JnspembrekM;
      $rekD->debitkredit = "K";
    }

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['JnspembayarM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;


      try {

        $model->attributes = $_POST['JnspembayarM'];

        $bank_list = array();

        if ($model->validate()) {
          $ok = $ok && $model->save();

          JnspembrekM::model()->deleteAllByAttributes(array(
            'jnspembayar_id' => $model->jnspembayar_id,
          ));
          JnspembayarbankM::model()->deleteAllByAttributes(array(
            'jnspembayar_id' => $model->jnspembayar_id,
          ));

          // var_dump($ok, $model->attributes, $_POST); die;

          if (isset($_POST['JnspembrekM']['detail'])) {
            foreach ($_POST['JnspembrekM']['detail'] as $item) {

              if (!empty($item['bank_id'])) {
                $bank_list[$item['bank_id']] = 1;
              }

              // rekening D
              $det = new JnspembrekM;
              $det->attributes = $item['D'];
              $det->debitkredit = $det->saldonormal = 'D';
              $det->jnspembayar_id = $model->jnspembayar_id;
              $det->bank_id = $item['bank_id'];

              if (!empty($det->rekening5_id) && $det->validate()) {
                $ok = $ok && $det->save();
              }

              // var_dump($det->attributes);

              // rekening K
              $det = new JnspembrekM;
              $det->attributes = $item['K'];
              $det->debitkredit = $det->saldonormal = 'K';
              $det->jnspembayar_id = $model->jnspembayar_id;
              $det->bank_id = $item['bank_id'];

              if (!empty($det->rekening5_id) && $det->validate()) {
                $ok = $ok && $det->save();
              }

              // var_dump($det->attributes);
            }
          }
        } else {
          $ok = false;
        }

        if (count((array)$bank_list) > 0) {
          foreach (array_keys($bank_list) as $item) {
            $bankdet = new JnspembayarbankM;
            $bankdet->bank_id = $item;
            $bankdet->jnspembayar_id = $model->jnspembayar_id;

            $ok = $ok && $bankdet->save();
            // var_dump($bankdet->attributes);
          }
        }

        // var_dump($ok);
        // die;

        if ($ok) {
          $trans->commit();
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model, 'rekD' => $rekD, 'rekK' => $rekK,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      JnspembayarbankM::model()->deleteAllByAttributes(array(
        'jnspembayar_id' => $id,
      ));
      JnspembrekM::model()->deleteAllByAttributes(array(
        'jnspembayar_id' => $id,
      ));
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Memanggil dan menonaktifkan status
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example:
      $model->jnspembayar_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('JnspembayarM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new JnspembayarM('search');
    $model->unsetAttributes();  // clear any default values
    $model->jnspembayar_aktif = true;

    if (isset($_GET['JnspembayarM'])) {
      $model->attributes = $_GET['JnspembayarM'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = JnspembayarM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jnspembayar-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new JnspembayarM;
    $model->unsetAttributes();  // clear any default values
    $model->jnspembayar_aktif = true;

		if(isset($_REQUEST['JnspembayarM'])){
				$model->attributes = $_REQUEST['JnspembayarM'];
		}

		$judulLaporan='Data Jenis Pembayaran';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = 'A4'; //Ukuran Kertas Pdf
			$posisi = 'L'; //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF);
			// ////$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}

  //   public function actionListBank() {
  //       if (!Yii::app()->request->isAjaxRequest) {
  //           Yii::app()->end();
  //       }

  //   if (isset($_REQUEST['JnspembayarM'])) {
  //     $model->attributes = $_REQUEST['JnspembayarM'];
  //   }

  //   $judulLaporan = 'Data Jenis Pembayaran';
  //   $caraPrint = $_REQUEST['caraPrint'];
  //   if ($caraPrint == 'PRINT') {
  //     $this->layout = '//layouts/printWindows';
  //     $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($caraPrint == 'EXCEL') {
  //     $this->layout = '//layouts/printExcel';
  //     $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($_REQUEST['caraPrint'] == 'PDF') {
  //     $ukuranKertasPDF = 'A4'; //Ukuran Kertas Pdf
  //     $posisi = 'L'; //Posisi L->Landscape,P->Portait
  //     $mpdf = new MyPDF60('', $ukuranKertasPDF);
  //     // //$mpdf->useOddEven = 2;
  //     $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //     $mpdf->WriteHTML($stylesheet, 1);
  //     $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
  //     $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
  //     $mpdf->Output();
  //   }
  // }

  public function actionListBank()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria();
    $cr->addCondition('bank_aktif = true');
    $cr->order = 'namabank';
    $list = BankM::model()->findAll($cr);


    $str = '<option value="">-- Pilih --</option>';

    foreach ($list as $item) {
      $str .= '<option value="' . $item->bank_id . '">' . $item->bankDanAtasNama . '</option>';
    }

    echo CJSON::encode(array(
      'option' => $str,
    ));
  }
}
