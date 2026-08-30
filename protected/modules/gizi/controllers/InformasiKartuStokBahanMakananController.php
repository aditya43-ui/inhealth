<?php

class InformasiKartuStokBahanMakananController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.informasiKartuStokBahanMakanan.';

  public function actionIndex($bahanmakanan_id = null, $caraPrint = null, $tgl_awal = null, $tgl_akhir = null, $transaksi = null, $instalasi = null, $ruangan = null, $pilihTgl = null)
  {
    $this->pageTitle = Yii::app()->name . " - Kartu Stok Bahan Makanan";
    $cekStok = array();
    if (!empty($bahanmakanan_id)) {
      $cekStok = InformasikartustokbahanmakananV::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id));
    }

    $mod = array();

    if ($bahanmakanan_id == null) {
      $mod = Yii::app()->db->createCommand(
        'select bahanmakanan_id, namabahanmakanan from informasikartustokbahanmakanan_v
            group by bahanmakanan_id,namabahanmakanan order by namabahanmakanan'
      )
        ->queryAll();
    } else {
      if (empty($cekStok)) {
        $mod = Yii::app()->db->createCommand(
          'select bahanmakanan_id,namabahanmakanan from bahanmakanan_m
                    order by namabahanmakanan'
        )
          ->queryAll();
      } else {
        $mod = Yii::app()->db->createCommand(
          'select bahanmakanan_id,namabahanmakanan from informasikartustokbahanmakanan_v
                            group by bahanmakanan_id,namabahanmakanan order by namabahanmakanan'
        )
          ->queryAll();
      }
    }

    if (empty($bahanmakanan_id)) {
      if (count((array)$mod) > 0) {
        $bahanmakanan_id = $mod[0]['bahanmakanan_id'];
      }
    }

    if (isset($_GET['InformasikartustokbahanmakananV'])) {
      $bahanmakanan_id = $_GET['InformasikartustokbahanmakananV']['bahanmakanan_id'];
      $tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InformasikartustokbahanmakananV']['tgl_awal']);
      $tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InformasikartustokbahanmakananV']['tgl_akhir']);
      $this->createUrl('informasi', array('bahanmakanan_id' => $bahanmakanan_id));
      $pilihTgl = ($_GET['InformasikartustokbahanmakananV']['pilihTgl'] == 1) ? true : false;
      $transaksi = !empty($_GET['InformasikartustokbahanmakananV']['transaksi']) ? $_GET['InformasikartustokbahanmakananV']['transaksi'] : null;
    }


    $next = null;
    $prev = null;
    foreach ($mod as $idx => $item) {
      if ($item['bahanmakanan_id'] == $bahanmakanan_id) {
        $next = empty($mod[$idx + 1]) ? null : $mod[$idx + 1]['bahanmakanan_id'];
        $prev = empty($mod[$idx - 1]) ? null : $mod[$idx - 1]['bahanmakanan_id'];
        break;
      }
    }
    $model = null;
    if (!empty($bahanmakanan_id)) {
      $model = InformasikartustokbahanmakananV::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id));
    }

    $count = !empty($model) ? 1 : 0;
    if (empty($model)) {
      $model = new InformasikartustokbahanmakananV;
    }
    $model2 = new InformasikartustokbahanmakananV;

    $format = new MyFormatter();
    $disabled = false;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->bahanmakanan_id = $bahanmakanan_id;

    if (!empty($model->bahanmakanan_id)) {
      $bahanmakanan = BahanmakananM::model()->findByPk($model->bahanmakanan_id);
    } else {
      $bahanmakanan = BahanmakananM::model()->findByPk($bahanmakanan_id);
    }

    if ($count ==  0) {
      if (isset($bahanmakanan)) {
        $model->attributes = $bahanmakanan->attributes;
      }
    }
    $model->transaksi = $transaksi;

    $model2->bahanmakanan_id = $model->bahanmakanan_id;
    $model2->tgl_awal = $tgl_awal;
    $model2->tgl_akhir = $tgl_akhir;
    $model2->transaksi = $transaksi;

    $judul_print = 'Kartu Stok';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframeNeon';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF, 9);
      $mpdf->SetHTMLFooter('{PAGENO}');
      //            //$mpdf->useOddEven = 1;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $periode = '';
      if ($pilihTgl == 'true') {
        $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . ' - ' . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
      }

      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => "Stok Kartu",  'periode' => $periode, 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printBaru', array(
        'format' => $format,
        'model' => $model,
        'model2' => $model2,
        'judul_print' => $judul_print,
        'caraPrint' => $caraPrint,
      ), true));
      $mpdf->Output($judul_print . '_' . date('Y-m-d') . '.pdf', 'I');
    }

    $target = $this->path_view . 'rincianStok';
    $periode = '';
    if (isset($_GET['caraPrint'])) {
      $target = $this->path_view . 'printBaru';
      if ($pilihTgl == 'true') {
        $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . ' - ' . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
      }
    }

    $this->render($target, array(
      'format' => $format,
      'model' => $model,
      'model2' => $model2,
      'caraPrint' => $caraPrint,
      'judul_print' => $judul_print,
      'next' => $next,
      'prev' => $prev,
      'disabled' => $disabled,
      'periode' => $periode,
      'pilihTgl' => $pilihTgl
    ));
  }

  public function actionAutocompleteBahanMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(bahanmakanan_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'bahanmakanan_nama';
      $criteria->limit = 5;
      $models = BahanmakananM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->bahanmakanan_nama;
        $returnVal[$i]['value'] = $model->bahanmakanan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
