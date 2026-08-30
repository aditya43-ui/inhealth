<?php
class PenerimaanLinenLangsungController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $penerimaanLinen = false;
  public $penerimaanLinenDet = true;

  public $path_view = 'laundry.views.penerimaanLinenLangsung.';
  public $path_view_tips = 'laundry.views.penerimaanLinenT.';

  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Perawatan Linen Langsung";
    $format = new MyFormatter;
    $model = new LAPenerimaanlinenT;
    $model->nopenerimaanlinen = MyGenerator::noPenerimaanLinen();
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');

    $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($model->instalasi_id), 'ruangan_id', 'ruangan_nama');

    $modDetail = new LAPenerimaanlinendetailT;
    $modDetail->jenisperawatanlinen = Params::JENISPERAWATAN_PERAWATAN;
    $modDetail->jumlah = 1;

    if (isset($_POST['LAPenerimaanlinenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPenerimaan = new LAPenerimaanlinenT;
        $modPenerimaan->attributes = $_POST['LAPenerimaanlinenT'];
        $modPenerimaan->tglpenerimaanlinen = $format->formatDateTimeForDb($_POST['LAPenerimaanlinenT']['tglpenerimaanlinen']);
        $modPenerimaan->create_time = date("Y-m-d H:i:s");
        $modPenerimaan->create_loginpemakai_id = Yii::app()->user->id;
        $modPenerimaan->create_ruangan = Yii::app()->user->ruangan_id;
        $modPenerimaan->pengperawatanlinen_id = null; //null karena perawatan linen langsung

        if ($modPenerimaan->save()) {
          $this->penerimaanLinen = true;
          if (count((array)$_POST['LAPenerimaanlinendetailT']) > 0) {
            foreach ($_POST['LAPenerimaanlinendetailT'] as $i => $postPengajuanDet) {
              $modDetail = new LAPenerimaanlinendetailT;
              $modDetail->attributes = $postPengajuanDet;
              $modDetail->linen_id = $postPengajuanDet['linen_id'];
              $modDetail->jenisperawatanlinen = $postPengajuanDet['jenisperawatanlinen'];
              $modDetail->keterangan_penerimaanlinen = $postPengajuanDet['keterangan_penerimaanlinen'];
              $modDetail->penerimaanlinen_id = $modPenerimaan->penerimaanlinen_id;
              $modDetail->jumlah = $postPengajuanDet['jumlah'];
              $modDetail->save();
              if ($modDetail->save()) {
                $this->penerimaanLinenDet &= true;
              } else {
                $this->penerimaanLinenDet &= false;
              }
            }
          }
        }
        if ($this->penerimaanLinen && $this->penerimaanLinenDet) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $id, 'penerimaanlinen_id' => $modPenerimaan->penerimaanlinen_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penerimaan Perawatan Linen Langsung gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penerimaan Perawatan Linen Langsung gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
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
      $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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

  /*
	 * untuk mencari register linen melalui autocomplete
	 */
  public function actionAutocompleteRegisterLinen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $noregisterlinen = isset($_GET['noregisterlinen']) ? $_GET['noregisterlinen'] : null;
      $namalinen = isset($_GET['namalinen']) ? $_GET['namalinen'] : null;
      $criteria->compare('LOWER(t.noregisterlinen)', strtolower($noregisterlinen), true);
      $criteria->compare('LOWER(t.namalinen)', strtolower($namalinen), true);
      $criteria->limit = 5;
      $models = LALinenM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->noregisterlinen . ' - ' . $model->namalinen;
        $returnVal[$i]['value'] = $model->linen_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($penerimaanlinen_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaanLinen = LAPenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
    $modPenerimaanLinenDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id' => $penerimaanlinen_id));

    $judul_print = 'Penerimaan Linen';
    $deskripsi = $format->formatDateTimeForUser($modPenerimaanLinen->tglpenerimaanlinen);
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
