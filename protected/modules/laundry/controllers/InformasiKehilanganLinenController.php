<?php

class InformasiKehilanganLinenController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.informasiKehilanganLinen.';
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Kehilangan Linen";
    $format = new MyFormatter();
    $modPenerimaanlinen = new LAPenerimaanlinenT('searchInformasiKehilangan');
    $modPenerimaanlinen->tgl_awal = date("Y-m-d");
    $modPenerimaanlinen->tgl_akhir = date("Y-m-d");

    if (isset($_GET['LAPenerimaanlinenT'])) {
      $modPenerimaanlinen->attributes = $_GET['LAPenerimaanlinenT'];
      $modPenerimaanlinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPenerimaanlinenT']['tgl_awal']);
      $modPenerimaanlinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPenerimaanlinenT']['tgl_akhir']);
      $modPenerimaanlinen->instalasi_id = $_GET['LAPenerimaanlinenT']['instalasi_id'];
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPenerimaanlinen' => $modPenerimaanlinen,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionBatalPenerimaan($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = PenerimaanlinendetailT::model()->deleteAllByAttributes(array('penerimaanlinen_id' => $id));
      $deletePenerimaan = PenerimaanlinenT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePenerimaan) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
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

  public function actionDetail($penerimaanlinen_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = LAPenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
    $modDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id' => $model->penerimaanlinen_id));
    $judulLaporan = 'Kehilangan Linen';
    $deskripsi = $format->formatDateTimeForUser($model->tglpenerimaanlinen);
    $this->render('_detail', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionPrint($penerimaanlinen_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = LAPenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
    $modDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id' => $penerimaanlinen_id));

    $judul_print = 'Kehilangan Linen';
    $deskripsi = $format->formatDateTimeForUser($model->tglpenerimaanlinen);
    //        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
