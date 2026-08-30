<?php

Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.views.pemakaianbarangT');

class PemakaianbarangTMCController extends PemakaianbarangTController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.pemakaianbarangT.';
  public $success = true;

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
  public function actionIndex($a = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Barang";
    $format = new MyFormatter();
    $model = new GUPemakaianbarangT;
    $ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->ruangan_id = $ruangan_id;
    $model->nopemakaianbrg = "-- Otomatis --";
    $model->create_ruangan = $ruangan_id;
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->create_time = date('Y-m-d H:i:s');
    $model->tglpemakaianbrg = date('Y-m-d H:i:s');
    $modDetails = array();

    if (isset($_GET['id'])) {
      $model = GUPemakaianbarangT::model()->findByPk($_GET['id']);
      $modDetails = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $model->pemakaianbarang_id));
    }

    if (isset($_POST['GUPemakaianbarangT'])) {
      $model->attributes = $_POST['GUPemakaianbarangT'];
      $model->tglpemakaianbrg = $format->formatDateTimeForDb($model->tglpemakaianbrg);
      $model->nopemakaianbrg = MyGenerator::noPemakaianBarang();
      // $model->pegawai_id = Yii::app()->user->id;
      if (count((array)$_POST['GUPemakaianbrgdetailT']) > 0) {
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            if ($model->save()) {
              $modDetails = $this->validasiTabular($model, $_POST['GUPemakaianbrgdetailT']);
              foreach ($modDetails as $i => $data) {
                if ($data->jmlpakai > 0) {
                  if ($data->save()) {
                    // InventarisasiruanganT::model()->updateByPk($data->inventarisasiruangan_id, array('pemakaianbrgdetail_id' => $data->pemakaianbrgdetail_id, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));
                    InventarisasiruanganT::simpanStokPemakaian($model, $data);
                    //										$this->saveInventarisasiRuangan($model,$data);
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            $this->setNotifPemakaianBarang($model);

            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('index', 'id' => $model->pemakaianbarang_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          } catch (Exception $ex) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }

    $linkHalaman = CustomFunction::getUrlByMenuID(2974);

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modDetails' => $modDetails,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function setNotifPemakaianBarang($model)
  {

    $judul = "Pemakaian Barang - " . $model->nopemakaianbrg;

    $asal = RuanganM::model()->findByPk($model->ruangan_id);

    $isi = "Tgl. Pemakaian : " . MyFormatter::formatDateTimeForUser($model->tglpemakaianbrg) . "<br/>";
    $isi .= "No. Pemakaian : " . $model->nopemakaianbrg . "<br/>";
    $isi .= "Untuk Keperluan : " . $model->untukkeperluan . "<br/>";

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
    ));
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
    // Uncomment the following line if AJAX validation is needed
    if (isset($_POST['GUPemakaianbarangT'])) {
      $model->attributes = $_POST['GUPemakaianbarangT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pemakaianbarang_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new GUPemakaianbarangT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GUPemakaianbarangT']))
      $model->attributes = $_GET['GUPemakaianbarangT'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi($a = null)
  {
    $model = new GUPemakaianbarangT();
    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y H:i:s');
    if (isset($_GET['GUPemakaianbarangT'])) {
      $model->attributes = $_GET['GUPemakaianbarangT'];
      $format = new CustomFormat();
      $model->tglAwal = $format->formatDateTimeMediumForDB($_GET['GUPemakaianbarangT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeMediumForDB($_GET['GUPemakaianbarangT']['tglAkhir']);
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/frameDialog';
    $modPemakaianbarang = GUPemakaianbarangT::model()->findByPk($id);
    if (!empty($modPemakaianbarang)) {
      $modDetailPemakaian = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $id));
      $this->render($this->path_view . 'detailInformasi', array(
        'modPemakaianbarang' => $modPemakaianbarang,
        'modDetailPemakaian' => $modDetailPemakaian,
      ));
    }
  }

  public function actionGetStokBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
      $jumlah = isset($_POST['qty']) ? $_POST['qty'] : null;
      //            if (KonfigsystemK::getKonfigKurangiStokUmum() == true){ // fungsi dikomment karena tida ada fungsi tersebut dlm model yg bersangkutan
      if (InventarisasiruanganT::validasiStok($jumlah, $barang_id) == false) {
        $pesan = 'kosong';
      } else {
        $pesan = 'tersedia';
      }
      //            }

      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /*
	 * untuk menampilkan baris pemakaian barang
	 */

  public function actionGetPemakaianBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 0;
      $satuan = isset($_POST['satuan']) ? $_POST['satuan'] : "";
      $inventarisasi_kode = isset($_POST['inventarisasi_kode']) ? $_POST['inventarisasi_kode'] : "";
      $inventarisasi_id = isset($_POST['inventarisasi_id']) ? $_POST['inventarisasi_id'] : "";
      $modBarang = BarangM::model()->findByPk($barang_id);
      $modDetail = new GUPemakaianbrgdetailT();
      $modDetail->barang_id = $barang_id;
      $modDetail->satuanpakai = $satuan;
      $modDetail->jmlpakai = $jumlah;
      $modDetail->harganetto = $modBarang->barang_harganetto;
      $modDetail->hargajual = $modBarang->barang_hargajual;
      $modDetail->ppn = $modBarang->barang_ppn;
      $modDetail->disc = $modBarang->barang_persendiskon;
      $modDetail->hpp = $modBarang->barang_hpp;
      //$modDetail->inventarisasi_kode = $inventarisasi_kode;
      //$modDetail->inventarisasiruangan_id = $inventarisasi_id;
      // $modDetail->jmldlmkemasan = $modBarang->barang_jmldlmkemasan;

      $tr = $this->renderPartial($this->path_view . '_detailPemakaianBarang', array('modBarang' => $modBarang, 'modDetail' => $modDetail), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /*
	 * untuk mencari barang melalui autocomplete
	 */

  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = GUBarangM::model()->findAll($criteria);
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

  /**
   * untuk print data pemakaian barang
   */
  public function actionPrint($pemakaianbarang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPemakaianBarang = GUPemakaianbarangT::model()->findByPk($pemakaianbarang_id);
    $modPemakaianBarangDetail = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id' => $pemakaianbarang_id));

    $judul_print = 'PEMAKAIAN BARANG';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemakaianBarang' => $modPemakaianBarang,
      'modPemakaianBarangDetail' => $modPemakaianBarangDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
