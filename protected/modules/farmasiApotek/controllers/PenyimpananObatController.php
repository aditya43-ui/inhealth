<?php

class PenyimpananObatController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public
    $defaultAction = 'admin';
  public $path_view = 'farmasiApotek.views.penyimpananObat.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }


  public function actionGetObatAlkesSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $rakobat_id = $_POST['rakobat_id'];

      $modRuangan = RuanganM::model()->findByPk($ruangan_id);
      $modRakObat = RakobatM::model()->findByPk($rakobat_id);

      // $modObatSupplier = new ObatsupplierM;
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);

      $modPenyimpanan = new FAPenyimpananobatM();

      $modPenyimpanan->rakobat_id = $rakobat_id;
      $modPenyimpanan->ruangan_id = $ruangan_id;
      $modPenyimpanan->obatalkes_id = $obatalkes_id;
      $modPenyimpanan->ruangan_nama = $modRuangan->ruangan_nama;
      $modPenyimpanan->rakobat_nama = $modRakObat->rakobat_nama;
      $modPenyimpanan->obatalkes_nama = $modObatAlkes->obatalkes_nama;
      $modPenyimpanan->obatalkes_kode = $modObatAlkes->obatalkes_kode;


      $nourut = 1;
     
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial(
            $this->path_view . '_rowPenyimpananObat',
            array(
              'modPenyimpanan' => $modPenyimpanan,
            ),
            true
          )
        )
      );

      Yii::app()->end();
    }
  }

  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = RuanganM::model()->findByAttributes(array('ruangan_id' => $_POST['idRuangan']));
      $post = array(
        'ruangan_id' => $data->ruangan_id,
        'ruangan_nama' => $data->ruangan_nama,
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionRuanganList()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(ruangan_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'ruangan_nama';
      $criteria->limit = 5;
      $models = RuanganM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->ruangan_namalainnya . ' - ' . $model->ruangan_nama . ' - ' . $model->ruangan_singkatan;
        $returnVal[$i]['ruangan_nama'] = $model->ruangan_nama;
        $returnVal[$i]['value'] = $model->ruangan_id;
        // $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionRakList()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(rakobat_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'rakobat_nama';
      $criteria->limit = 5;
      $models = RakobatM::model()->findAll($criteria);

      $ruangan_id = $_POST['ruangan_id'];
    

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->rakobat_label . ' - ' . $model->rakobat_nama . ' - ' . $model->rakobat_namalain;
        $returnVal[$i]['rakobat_nama'] = $model->rakobat_nama;
        $returnVal[$i]['value'] = $model->rakobat_id;
        // $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionObatList()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes_nama';
      $criteria->addCondition('obatalkes_aktif = true');
      $criteria->limit = 5;
      $models = FAObatalkesM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_barcode . ' - ' . $model->obatalkes_nama . ' - ' . $model->obatalkes_kode;
        $returnVal[$i]['obatalkes_nama'] = $model->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_id;
        // $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $model = new PenyimpananobatM;
    // $model = new FAPenyimpananobatM;


    if (isset($_POST['PenyimpananobatM'])) {
      $ok = true;
      $pesan = '';
      $trans = Yii::app()->db->beginTransaction();
      try {

        foreach ($_POST['PenyimpananobatM'] as $i => $key) {

          $modPenyimpanan = new PenyimpananobatM;
          $modPenyimpanan->attributes = $key;
          $modPenyimpanan->create_time = date('Y-m-d h:i:s');
          $modPenyimpanan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modPenyimpanan->create_ruangan = Yii::app()->user->getState('ruangan_id');

          // echo "<pre>";
          // var_dump($modPenyimpanan->attributes);
          $ok &= $modPenyimpanan->save();
          // var_dump($ok);
        
          if (!$ok) {
            $pesan .= '<br/> Penyimpanan Obat : ' . MyExceptionMessage::getErrorMessage($modPenyimpanan);
          }
        }
  // die;
        if ($ok) {
        //   var_dump($ok);
        // die;
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $trans->commit();
          // $this->redirect(array('index', 'id' => $model->pengajuankasbon_id, 'sukses' => 1));
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
        var_dump($pesan
        );
        die;
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
        }
      } catch (Exception $ex) {
        var_dump($ex);
        die;
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
      }

      $model->attributes = $_POST['PenyimpananobatM'];



      // if ($ok) {
      //   Yii::app()->user->setFlash('success', 'Data ' . $model->rakobat_nama . ' berhasil disimpan.');
      //   $this->redirect(array('admin'));
      // } else {
      //   Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
      // }
    }

    $this->render('create', array(
      'model' =>
      $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    // $model = $this->loadModel($id);

    $model = PenyimpananobatM::model()->findByPk($id);

    $model->ruangan_nama =$model->ruangan->ruangan_nama;
    $model->rakobat_nama =$model->rakobat->rakobat_nama;
    $model->obatalkes_nama =$model->obatalkes->obatalkes_nama;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PenyimpananobatM'])) {
      $model->attributes = $_POST['PenyimpananobatM'];
        $model->update_time = date('Y-m-d h:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');


      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->rakobat_nama . ' berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */


   public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $id = $_REQUEST['id'];
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] :
          array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  // public function actionnonActive($id) {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $data['sukses'] = 0;
  //     $model = $this->loadModel($id);
  //     // set non-active this
  //     // example: 
  //     $model->rakobat_aktif = false;
  //     if ($model->save()) {
  //       $data['sukses'] = 1;
  //     }
  //     echo CJSON::encode($data);
  //   }
  // }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('FARakobatM');
    $this->render('index', array(
      'dataProvider' =>
      $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new PenyimpananobatM('search');
    $model->unsetAttributes();   // clear any default values
    // $model->rakobat_aktif = 1;
    if (isset($_GET['PenyimpananobatM'])) {
      $model->attributes = $_GET['PenyimpananobatM'];
      $model->obatalkes_nama = !empty($_GET['PenyimpananobatM']['obatalkes_nama']) ? $_GET['PenyimpananobatM']['obatalkes_nama'] : null;
      $model->ruangan_nama = !empty($_GET['PenyimpananobatM']['ruangan_nama']) ? $_GET['PenyimpananobatM']['ruangan_nama'] : null;
      $model->rakobat_nama = !empty($_GET['PenyimpananobatM']['rakobat_nama']) ? $_GET['PenyimpananobatM']['rakobat_nama'] : null;

    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PenyimpananobatM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'farakobat-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new PenyimpananobatM;
    $model->attributes = $_REQUEST['PenyimpananobatM'];
    $model->obatalkes_nama = !empty($_GET['PenyimpananobatM']['obatalkes_nama']) ? $_GET['PenyimpananobatM']['obatalkes_nama'] : null;
    $model->ruangan_nama = !empty($_GET['PenyimpananobatM']['ruangan_nama']) ? $_GET['PenyimpananobatM']['ruangan_nama'] : null;
    $model->rakobat_nama = !empty($_GET['PenyimpananobatM']['rakobat_nama']) ? $_GET['PenyimpananobatM']['rakobat_nama'] : null;
    $judulLaporan = 'Data Rak Obat';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }
}
