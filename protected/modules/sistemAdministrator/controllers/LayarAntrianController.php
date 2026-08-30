<?php

class LayarAntrianController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.layarAntrian.';

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
    $model = new SALayarantrianM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SALayarantrianM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SALayarantrianM'];
        $model->layarantrian_latarbelakang = "-";
        /*
                    $random = rand(0000000, 9999999);
                    $model->layarantrian_latarbelakang = CUploadedFile::getInstance($model, 'layarantrian_latarbelakang');
                    $gambar = $model->layarantrian_latarbelakang;
                    if (!empty($model->layarantrian_latarbelakang)) {//Klo User Memasukan Background
                        $model->layarantrian_latarbelakang = $random.$model->layarantrian_latarbelakang;

                        Yii::import("ext.EPhpThumb.EPhpThumb");
                        
                        $thumb = new EPhpThumb();
                        $thumb->init(); //this is needed

                        $fullImgName = $model->layarantrian_latarbelakang;
                        $fullImgSource = Params::pathBackgroundAntrian() . $fullImgName;
                        $fullThumbSource = Params::pathBackgroundAntrianThumbs() . 'kecil_' . $fullImgName;

                        $model->layarantrian_latarbelakang = $fullImgName;
                    }
                     * 
                     */

        if ($model->save()) {
          /*
                        $gambar->saveAs($fullImgSource);
                        $thumb->create($fullImgSource)
                                ->resize(200, 200)
                                ->save($fullThumbSource);
                        */
                 if ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_POLIKLINIK) {
            if (isset($_POST['ruangan_id_poliklinik'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_poliklinik'], $model);
            }
          
          } elseif ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_PENUNJANG) {
            if (isset($_POST['ruangan_id_penunjang'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_penunjang'], $model);
            }
          } elseif ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_KASIR) {
            if (isset($_POST['ruangan_id_kasir'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_kasir'], $model);
            }
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('view', 'id' => $model->layarantrian_id));
        }
      } catch (Exception $exc) {
        //exit();
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  protected function simpanRuanganPoliklinik($ruangans, $layarantrians)
  {
    $jumlah_ruangan =  count((array)$ruangans);
    $cek_ruangan = 0;
    for ($i = 0; $i <= $jumlah_ruangan; $i++) {
      $modLayarRuangan = new SALayarruanganM;
      if (isset($ruangans[$i])) {
        $modLayarRuangan->ruangan_id = $ruangans[$i];
      }
      $modLayarRuangan->layarantrian_id = $layarantrians->layarantrian_id;
      if ($modLayarRuangan->validate()) {
        $modLayarRuangan->save();
        $cek_ruangan++;
      }
    }
    if ($cek_ruangan == $jumlah_ruangan) {
      return $layarantrians;
    }
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $bg_temp = $model->layarantrian_latarbelakang;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SALayarantrianM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->layarantrian_jenis = $_POST['SALayarantrianM']['layarantrian_jenis'];
        $model->layarantrian_nama = $_POST['SALayarantrianM']['layarantrian_nama'];
        $model->layarantrian_judul = $_POST['SALayarantrianM']['layarantrian_judul'];
        $model->layarantrian_jenis = $_POST['SALayarantrianM']['layarantrian_jenis'];
        $model->layarantrian_runningtext = $_POST['SALayarantrianM']['layarantrian_runningtext'];
        $model->layarantrian_maksitem = $_POST['SALayarantrianM']['layarantrian_maksitem'];
        $model->layarantrian_itemhigh = $_POST['SALayarantrianM']['layarantrian_itemhigh'];
        $model->layarantrian_itemwidth = $_POST['SALayarantrianM']['layarantrian_itemwidth'];
        $model->layarantrian_intrefresh = $_POST['SALayarantrianM']['layarantrian_intrefresh'];
        $model->layarantrian_aktif = $_POST['SALayarantrianM']['layarantrian_aktif'];
        $latarbelakang = CUploadedFile::getInstance($model, 'layarantrian_latarbelakang');

        $gambar = "";
        if (!empty($latarbelakang)) {
          $model->layarantrian_latarbelakang = $latarbelakang;
          $gambar = $model->layarantrian_latarbelakang;
        }

        if (!empty($gambar)) { //Klo User Memasukan Background
          $random = rand(0000000, 9999999);
          $model->layarantrian_latarbelakang = $random . $model->layarantrian_latarbelakang;

          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = $model->layarantrian_latarbelakang;
          $fullImgSource = Params::pathBackgroundAntrian() . $fullImgName;
          $fullThumbSource = Params::pathBackgroundAntrianThumbs() . 'kecil_' . $fullImgName;

          $model->layarantrian_latarbelakang = $fullImgName;
          if (file_exists(Params::pathBackgroundAntrian() . $bg_temp)) {
            unlink(Params::pathBackgroundAntrian() . $bg_temp);
          }
          if (file_exists(Params::pathBackgroundAntrianThumbs() . 'kecil_' . $bg_temp)) {
            unlink(Params::pathBackgroundAntrianThumbs() . 'kecil_' . $bg_temp);
          }

          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);
        }

        if ($model->update()) {
          SALayarruanganM::model()->deleteAll('layarantrian_id =' . $id . '');
          if ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_POLIKLINIK) {
            if (isset($_POST['ruangan_id_poliklinik'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_poliklinik'], $model);
            }
          } elseif ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_PENUNJANG) {
            if (isset($_POST['ruangan_id_penunjang'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_penunjang'], $model);
            }
          } elseif ($model->layarantrian_jenis == Params::LAYARANTRIAN_JENIS_KASIR) {
            if (isset($_POST['ruangan_id_kasir'])) {
              $simpan_ruangan = $this->simpanRuanganPoliklinik($_POST['ruangan_id_kasir'], $model);
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('view', 'id' => $model->layarantrian_id));
        }
      } catch (Exception $exc) {
        //exit();
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
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
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        SALayarruanganM::model()->deleteAll('layarantrian_id =' . $id . '');
        $model = $this->loadModel($id);
        // $bg_temp = $model->layarantrian_latarbelakang;
        /*
                if (!empty($bg_temp)){
                    unlink(Params::pathBackgroundAntrian().$bg_temp);
                    unlink(Params::pathBackgroundAntrianThumbs().'kecil_'.$bg_temp);
                }
                 * 
                 */
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        $transaction->commit();
        if (!isset($_GET['ajax']))
          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        echo 'error' . $e->getMessage();
      }
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
      $model->layarantrian_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
    // we only allow deletion via POST request
    //        $model = $this->loadModel($id);
    //        // set non-active this
    //        // example: 
    //         $model->layarantrian_aktif = false;
    //         $model->save();
    //        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil di non-aktif kan.');
    //        $this->render('view',array(
    //                'model'=>$model,
    //        ));
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SALayarantrianM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SALayarantrianM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SALayarantrianM'])) {
      $model->attributes = $_GET['SALayarantrianM'];
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
    $model = SALayarantrianM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'salayarantrian-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SALayarantrianM;
    $model->attributes = $_REQUEST['SALayarantrianM'];
    $judulLaporan = 'Data Layar Antrian';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
