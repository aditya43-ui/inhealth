<?php
//Yii::import('laundry.models.*');
//Yii::import('laundry.controllers.KehilanganLinenController');
class KehilanganLinenSTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.kehilanganLinenST.';
  public $path_tips = 'sterilisasi.views.penerimaanPeralatanSteril.';
  public $penerimaanSteril = false;
  public $pengajuanSterilUpdate = false;
  public $penerimaanSterilDet = true;

  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pencatatan Kehilangan Alat Cssd";
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $format = new MyFormatter;
    $model = new STPenerimaansterilisasiT;

    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->penerimaansterilisasi_no = MyGenerator::noPenerimaanSteril();

    $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($model->instalasi_id), 'ruangan_id', 'ruangan_nama');

    $model->pegmenerima_id = Yii::app()->user->getState('pegawai_id');
    if (!empty($model->pegmenerima_id)) $model->pegawaipenerima_nama = (isset($model->pegawaiMenerima->namaLengkap)) ? $model->pegawaiMenerima->namaLengkap : '';

    $modDetail = new STPenerimaansterilisasidetT;
    if (!empty($id)) {
      $model = STPenerimaansterilisasiT::model()->findByPk($id);
      $modDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $model->penerimaansterilisasi_id));
    }

    if (isset($_POST['STPenerimaansterilisasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STPenerimaansterilisasiT'];
        $model->ruangan_id = $_POST['STPenerimaansterilisasiT']['ruangan_id'];
        $model->penerimaansterilisasi_tgl = $format->formatDateTimeForDb($_POST['STPenerimaansterilisasiT']['penerimaansterilisasi_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        //                                $model->penerimaansterilisasi_no = MyGenerator::noPenerimaanSteril();
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        //                                $model->validate(); 
        //                                echo CHtml::errorSummary($model); 
        if ($model->save()) {
          $this->penerimaanSteril = true;
          if (count((array)$_POST['STPenerimaansterilisasidetT']) > 0) {
            foreach ($_POST['STPenerimaansterilisasidetT'] as $i => $postPengajuanSteril) {
              $modDetail = new STPenerimaansterilisasidetT;
              $modDetail->attributes = $postPengajuanSteril;
              $modDetail->penerimaansterilisasi_id = $model->penerimaansterilisasi_id;
              //$modDetail->linen_id = $postPengajuanSteril['linen_id'];
              //$modDetail->barang_id = $postPengajuanSteril['barang_id'];
              $modDetail->penerimaansterilisasidet_jml = $postPengajuanSteril['penerimaansterilisasidet_jml'];
              $modDetail->penerimaansterilisasidet_ket = $postPengajuanSteril['penerimaansterilisasidet_ket'];
              //												$modDetail->validate(); 
              //                                                                                                echo CHtml::errorSummary($modDetail);  exit();
              if ($modDetail->save()) {
                $this->penerimaanSterilDet &= true;
              } else {
                $this->penerimaanSterilDet &= false;
              }
            }
          }
        }
        if ($this->penerimaanSteril && $this->penerimaanSterilDet) {
          $transaction->commit();
          $this->redirect(array('index', 'penerimaansterilisasi_id' => $model->penerimaansterilisasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penerimaan Peralatan Steril Langsung gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penerimaan Peralatan Steril Langsung gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format,
      'modDetail' => $modDetail,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  public function actionAutocompletePegawaiPenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /*
	 * untuk mencari peralatan melalui autocomplete
	 */
  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STBarangV::model()->findAll($criteria);
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

  public function actionPrint($penerimaansterilisasi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaan = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);
    $modPenerimaanDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $penerimaansterilisasi_id));

    $judul_print = 'Kehilangan Peralatan Steril';
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
      'modPenerimaan' => $modPenerimaan,
      'modPenerimaanDetail' => $modPenerimaanDetail,
      'caraPrint' => $caraPrint
    ));
  }


  /**
   * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @version         2.0.0
   * @documentation   http://kbase..com
   * @issue           RSST-1338
   * - digunakan untuk menambahkan data peralatan sterilisasi
   */
  public function actionLoadFormLine()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $peralatansterilisasi_id = $_POST['peralatansterilisasi_id'];
      $keadaanperalatan = $_POST['keadaanperalatan'];
      $jenisperalatan = $_POST['jenisperalatan'];
      $barang_id = $_POST['barang_id'];
      $map_id = isset($_POST['map_id']) ? $_POST['map_id'] : null;
      $jumlah = $_POST['jumlah'];
      $format = new MyFormatter();


      $modBarang = PeralatansterilisasiM::model()->findByPk($peralatansterilisasi_id);
      $modDetail = new STPenerimaansterilisasidetT;
      $modDetail->peralatansterilisasi_id = $peralatansterilisasi_id;
      //$modDetail->namaLinen = (!empty($linen_id) ? $modLinen->namalinen : null );			
      $modDetail->namaPeralatan = $modBarang->peralatansterilisasi_nama;
      $modDetail->penerimaansterilisasidet_jml = $jumlah;
      $modDetail->keadaanperalatan = $keadaanperalatan;
      $modDetail->jenisperalatan = $jenisperalatan;
      $modDetail->barang_id = $barang_id;


      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial(
            $this->path_view . '_rowPeralatan',
            array(
              'format' => $format,
              'modDetail' => $modDetail,
            ),
            true
          )
        )
      );
      exit;
    }
  }
}
