<?php
Yii::import('sterilisasi.controllers.PemesananPeralatanSterilRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PemesananPeralatanSterilRuanganTPIController extends PemesananPeralatanSterilRuanganTController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.pemesananPeralatanSterilRuanganT.';
  public $pemesananSteril = false;
  public $pemesananSterilDet = true;

  public function actionIndex($a = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Peralatan Sterilisasi";
    $format = new MyFormatter;
    $model = new STPesanperlinensterilT;
    $model->pesanperlinensteril_no = '-- Otomatis --';
    //		$model->pesanperlinensteril_no = MyGenerator::noPesanSterilisasi();
    $modDetails = array();
    $modDetail = new STPesanperlinensterildetT;
    $ruangan_id = Yii::app()->user->ruangan_id;
    $ruangan_cssd = Params::RUANGAN_ID_STERILISASI;
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));

    $model->pegpemesan_id = $modLogin->pegawai_id;
    if (!empty($model->pegpemesan_id)) {
      $model->pegawaimemesan_nama = $modLogin->pegawai->NamaLengkap;
    }

    if (isset($_POST['STPesanperlinensterilT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STPesanperlinensterilT'];
        $model->pesanperlinensteril_no = MyGenerator::noPesanSterilisasi();
        //				if ($ruangan_id == $ruangan_cssd) {
        //					$model->ruangan_id = $_POST['STPesanperlinensterilT']['ruangan_id'];
        //				} else {
        //					$model->ruangan_id = Yii::app()->user->ruangan_id;
        //				}
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $model->pesanperlinensteril_tgl = $format->formatDateTimeForDb($_POST['STPesanperlinensterilT']['pesanperlinensteril_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($model->save()) {
          $this->pemesananSteril = true;
          if (isset($_POST['STPesanperlinensterildetT'])) {
            foreach ($_POST['STPesanperlinensterildetT'] as $i => $postPesanSteril) {
              $modDetail = new STPesanperlinensterildetT;
              $modDetail->attributes = $postPesanSteril;
              $modDetail->pesanperlinensteril_id = $model->pesanperlinensteril_id;
              if ($modDetail->save()) {
                $this->pemesananSterilDet &= true;
              } else {
                $this->pemesananSterilDet &= false;
              }
            }
          }

          $this->simpanNotifPemesananPeralatanSteril($model);
        }

        if ($this->pemesananSteril && $this->pemesananSterilDet) {
          $transaction->commit();
          $this->redirect(array('index', 'pesanperlinensteril_id' => $model->pesanperlinensteril_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemesanan Peralatan Steril gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pemesanan Peralatan Steril gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
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
  public function actionLoadFormLine()
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
      $modDetail = new STPesanperlinensterildetT;
      $modDetail->linen_id = (!empty($linen_id) ? $modLinen->linen_id : null);
      $modDetail->namaLinen = (!empty($linen_id) ? $modLinen->namalinen : null);
      $modDetail->barang_id = $barang_id;
      $modDetail->namaPeralatan = $modBarang->barang_nama;
      $modDetail->pesanperlinensterildet_jml = $jumlah;
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

  public function actionAutocompletePegawaiMemesan()
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
  public function actionPrint($pesanperlinensteril_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPemesanan = STPesanperlinensterilT::model()->findByPk($pesanperlinensteril_id);
    $modPemesananDetail = STPesanperlinensterildetT::model()->findAllByAttributes(array('pesanperlinensteril_id' => $pesanperlinensteril_id));

    $judul_print = 'Pemesanan Peralatan Steril';
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
      'modPemesanan' => $modPemesanan,
      'modPemesananDetail' => $modPemesananDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
