<?php
Yii::import('sterilisasi.controllers.PengajuanSterilisasiRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PengajuanSterilisasiRuanganTLAController extends PengajuanSterilisasiRuanganTController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.pengajuanSterilisasiRuanganT.';
  public $pengSterilisasi = false;
  public $pengSterilisasiDet = true;

  public function actionIndex($a = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Sterilisasi";
    $format = new MyFormatter;
    $model = new STPengajuansterlilisasiT;
    $model->pengajuansterlilisasi_no = MyGenerator::noPengSterilisasi();

    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->pegpengajuan_id = $modLogin->pegawai_id;
    if (!empty($model->pegpengajuan_id)) {
      $model->pegawaimengajukan_nama = $modLogin->pegawai->nama_pegawai;
    }
    $modDetails = array();
    $modDetail = new STPengajuansterlilisasidetT;
    $ruangan_id = Yii::app()->user->ruangan_id;
    $ruangan_cssd = Params::RUANGAN_ID_STERILISASI;
    if (isset($_POST['STPengajuansterlilisasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STPengajuansterlilisasiT'];
        if ($ruangan_id == $ruangan_cssd) {
          $model->ruangan_id = $_POST['STPengajuansterlilisasiT']['ruangan_id'];
        } else {
          $model->ruangan_id = Yii::app()->user->ruangan_id;
        }
        $model->pengajuansterlilisasi_tgl = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['pengajuansterlilisasi_tgl']);

        if (empty($_POST['STPengajuansterlilisasidetT'][0]['linen_id'])) {
          $model->issterilisasiperalatan = true;
        } else {
          $model->issterilisasiperalatan = false;
        }
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->pengSterilisasi = true;
          if (count((array)$_POST['STPengajuansterlilisasidetT']) > 0) {
            foreach ($_POST['STPengajuansterlilisasidetT'] as $i => $postPengSterilisasi) {
              $modDetail = new STPengajuansterlilisasidetT;
              $modDetail->attributes = $postPengSterilisasi;
              $modDetail->pengajuansterlilisasi_id = $model->pengajuansterlilisasi_id;
              if ($modDetail->save()) {
                $this->pengSterilisasiDet &= true;
              } else {
                $this->pengSterilisasiDet &= false;
              }
            }
          }
        }
        if ($this->pengSterilisasi && $this->pengSterilisasiDet) {
          $transaction->commit();
          $this->redirect(array('index', 'pengajuansterlilisasi_id' => $model->pengajuansterlilisasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pengajuan Sterilisasi gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pengajuan Sterilisasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format, 'ruangan_id' => $ruangan_id, 'ruangan_cssd' => $ruangan_cssd
    ));
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
      $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id" => $instalasi_id), "ruangan_aktif = true"), 'ruangan_id', 'ruangan_nama');
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

  public function actionAutocompletePeralatan()
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

  /*
	 * untuk mencari linen melalui autocomplete
	 */

  public function actionAutocompleteLinen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.namalinen)', strtolower($_GET['term']), true);
      $models = STLinenM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namalinen;
        $returnVal[$i]['value'] = $model->linen_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan peralatan dan linen detail
   * @return row table 
   */
  public function actionLoadFormLineOld()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $barang_id = $_POST['barang_id'];
      $linen_id = $_POST['linen_id'];
      $jumlah = $_POST['jumlah'];
      $format = new MyFormatter();

      if (isset($linen_id)) {
        $modLinen = STLinenM::model()->findByPk($linen_id);
      }
      $modBarang = STBarangV::model()->findByAttributes(array('barang_id' => $barang_id));
      $modDetail = new STPengajuansterlilisasidetT;
      $modDetail->linen_id = (!empty($linen_id) ? $modLinen->linen_id : null);
      $modDetail->namaLinen = (!empty($linen_id) ? $modLinen->namalinen : null);
      $modDetail->barang_id = $barang_id;
      $modDetail->namaPeralatan = $modBarang->barang_nama;
      $modDetail->pengajuansterlilisasidet_jml = $jumlah;
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial($this->path_view . '_rowLinen', array(
            'format' => $format,
            'modDetail' => $modDetail,
          ), true)
        )
      );
      exit;
    }
  }

  public function actionLoadFormLine()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $peralatansterilisasi_id = $_POST['peralatansterilisasi_id'];
      $keadaanperalatan = $_POST['keadaanperalatan'];
      $jenisperalatan = $_POST['jenisperalatan'];
      $map_id = isset($_POST['map_id']) ? $_POST['map_id'] : null;
      $jumlah = $_POST['jumlah'];
      $format = new MyFormatter();


      $modBarang = PeralatansterilisasiM::model()->findByPk($peralatansterilisasi_id);
      $modDetail = new STPengajuansterlilisasidetT;
      $modDetail->peralatansterilisasi_id = $peralatansterilisasi_id;
      //$modDetail->namaLinen = (!empty($linen_id) ? $modLinen->namalinen : null );			
      $modDetail->namaPeralatan = $modBarang->peralatansterilisasi_nama;
      $modDetail->pengajuansterlilisasidet_jml = $jumlah;
      $modDetail->keadaanperalatan = $keadaanperalatan;
      $modDetail->jenisperalatan = $jenisperalatan;


      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial($this->path_view . '_rowPeralatan', array(
            'format' => $format,
            'modDetail' => $modDetail,
          ), true)
        )
      );
      exit;
    }
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

  public function actionAutocompletePegawaiMengajukan()
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
   * untuk print data pengajuan perawatan
   */
  public function actionPrint($pengajuansterlilisasi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPengajuan = STPengajuansterlilisasiT::model()->findByPk($pengajuansterlilisasi_id);
    $modPengajuanDetail = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $pengajuansterlilisasi_id));

    $judul_print = 'Pengajuan Sterilisasi';
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
      'modPengajuan' => $modPengajuan,
      'modPengajuanDetail' => $modPengajuanDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
