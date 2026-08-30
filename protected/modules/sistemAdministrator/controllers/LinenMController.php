<?php

/**
 * digunakan untuk perbaikan tampilan interface dan laporan
 * BMB-199
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.sistemAdministrator
 * @subpackage      controllers
 * 
 */
class LinenMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.linenM.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $format = new MyFormatter;
    $model = new SALinenM;
    $model->tglregisterlinen = $format->formatDateTimeForUser(date("Y-m-d"), strtotime($model->tglregisterlinen));
    $model->noregisterlinen = MyGenerator::noRegisterLinen();
    if (isset($_POST['SALinenM'])) {
      $model->attributes = $_POST['SALinenM'];
      //$model->barang_id = $_POST['barang_id'];
      $model->ruangan_id = Yii::app()->user->ruangan_id;
      $model->tglregisterlinen = $format->formatDateTimeForDb($_POST['SALinenM']['tglregisterlinen']);
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');


      $random = rand(0000000, 9999999);
      // if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
      // {                               
      $model->gambarlinen = CUploadedFile::getInstance($model, 'gambarlinen');
      $gambar = $model->gambarlinen;

      if (!empty($model->gambarlinen)) //Klo User Memasukan Logo
      {

        $model->gambarlinen = $random . $model->gambarlinen;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->gambarlinen;
        $fullImgSource = Params::pathLinenDirectory() . $fullImgName;
        $fullThumbSource = Params::pathLinenThumbsDirectory() . 'kecil_' . $fullImgName;

        $gambar->saveAs($fullImgSource);
        $thumb->create($fullImgSource)
          ->resize(200, 200)
          ->save($fullThumbSource);
      }
      // }   

      //$model->gambarlinen = CUploadedFile::getInstance($model, 'gambarlinen');
      //    $random = rand(0000000, 9999999);
      //  $gambar = $random.$model->gambarlinen;

      //	if (isset($model->gambarlinen)){
      // $model->gambarlinen->saveAs(Params::pathLinenDirectory().$gambar);
      //  $model->gambarlinen = $gambar;
      //  }
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $model->barang_nama = isset($model->barang->barang_nama) ? $model->barang->barang_nama : '';
    // Uncomment the following line if AJAX validation is needed		
    $temLogo = $model->gambarlinen;
    if (isset($_POST['SALinenM'])) {
      $model->attributes = $_POST['SALinenM'];
      //$model->barang_id = $_POST['barang_id'];

      $model->gambarlinen = CUploadedFile::getInstance($model, 'gambarlinen');
      $gambar = $model->gambarlinen;
      $random = rand(0000000, 9999999);
      if (isset($model->gambarlinen)) {
        // if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
        // { 
        if (!empty($model->gambarlinen)) //Klo User Memasukan Logo
        {
          $model->gambarlinen = $random . $model->gambarlinen;
          Yii::import("ext.EPhpThumb.EPhpThumb");
          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed
          $fullImgName = $model->gambarlinen;
          $fullImgSource = Params::pathLinenDirectory() . $fullImgName;
          $fullThumbSource = Params::pathLinenThumbsDirectory() . 'kecil_' . $fullImgName;
          //                                    if($model->save())
          if ($model->update()) {
            if (!empty($temLogo)) {
              if (file_exists(Params::pathLinenDirectory() . $temLogo)) {
                unlink(Params::pathLinenDirectory() . $temLogo);
              }
              if (file_exists(Params::pathLinenThumbsDirectory() . 'kecil_' . $temLogo)) {
                unlink(Params::pathLinenThumbsDirectory() . 'kecil_' . $temLogo);
              }
            }
            $gambar->saveAs($fullImgSource);
            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          } else {
            Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
          }
        } else {
          $model->gambarlinen = $temLogo;
        }

        //}   

      } else {
        $model->gambarlinen = $temLogo;
      }

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      $hapus = $this->loadModel($id);
      $temLogo = $hapus->gambarlinen;

      if (!empty($temLogo)) {
        if (file_exists(Params::pathLinenDirectory() . $temLogo)) {
          unlink(Params::pathLinenDirectory() . $temLogo);
        }
        if (file_exists(Params::pathLinenThumbsDirectory() . 'kecil_' . $temLogo)) {
          unlink(Params::pathLinenThumbsDirectory() . 'kecil_' . $temLogo);
        }
      }

      $hapus->delete();
      // we only allow deletion via POST request
      //$this->loadModel($id)->delete();

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
      $model->linen_aktif = 0;
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
    $dataProvider = new CActiveDataProvider('SALinenM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin($sukses = '')
  {
    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;
    $model = new SALinenM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SALinenM'])) {
      $model->attributes = $_GET['SALinenM'];
      $model->barang_nama = $_GET['SALinenM']['barang_nama'];
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
    $model = SALinenM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'salinen-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SALinenM;
    $model->attributes = $_REQUEST['SALinenM'];
    $judulLaporan = 'Laporan Data Linen';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);;

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /*
	 * untuk mencari barang melalui autocomplete
	 */
  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
      $criteria->order = 't.barang_id';
      $models = SABarangM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
