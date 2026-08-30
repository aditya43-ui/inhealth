<?php

class InformasiKartuStokBarangController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.informasiKartuStokBarang.';

  public function actionIndexOld()
  {
    $model = new InformasikartustokbarangV('search');
    $format = new MyFormatter();
    $disabled = false;
    $ruanganAsals = CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama');
    $instalasiAsals = CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = true order by instalasi_nama asc"), 'instalasi_id', 'instalasi_nama');
    //$ruanganAsals = CHtml::listData(RuanganM::getRuanganStokOas(Yii::app()->user->getState('instalasi_id')),'ruangan_id','ruangan_nama');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI) {
      $disabled = true;
    }
    if (isset($_GET['InformasikartustokbarangV'])) {
      $model->attributes = $_GET['InformasikartustokbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_akhir']);
      // $model->transaksi = !empty($_GET['InformasikartustokbarangV']['transaksi'])?$_GET['GFInformasikartustokobatalkesV']['transaksi']:null;
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
      'disabled' => $disabled,
    ));
  }

  public function actionIndex($barang_id = null, $caraPrint = null, $tgl_awal = null, $tgl_akhir = null, $transaksi = null, $instalasi = null, $ruangan = null, $pilihTgl = null)
  {
    $this->pageTitle = Yii::app()->name . " - Kartu Stok Barang";
    //        $instalasi = (empty($instalasi)? Yii::app()->user->getState('instalasi_id'): $instalasi);
    //        $ruangan = (empty($instalasi)? Yii::app()->user->getState('ruangan_id'): $ruangan);

    $cekStok = array();
    if (!empty($barang_id)) {
      $cekStok = InformasikartustokbarangV::model()->findByAttributes(array('barang_id' => $barang_id));
    }
    $mod = array();
    if ($barang_id == null) {
      $mod = Yii::app()->db->createCommand(
        'select barang_id,barang_nama from informasikartustokbarang_v
            where ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' group by barang_id,barang_nama order by barang_nama'
      )
        ->queryAll();
    } else {
      if (empty($cekStok)) {
        $mod = Yii::app()->db->createCommand(
          'select barang_id,barang_nama from barang_m
                    order by barang_nama'
        )
          ->queryAll();
      } else {
        $mod = Yii::app()->db->createCommand(
          'select barang_id,barang_nama from informasikartustokbarang_v
                            where ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' group by barang_id,barang_nama order by barang_nama'
        )
          ->queryAll();
      }
    }

    if (empty($barang_id)) {
      if (count((array)$mod) > 0) {
        $barang_id = $mod[0]['barang_id'];
      } else {
        //                $mod = Yii::app()->db->createCommand(
        //                  'select barang_id,barang_nama from barang_m
        //                  order by barang_nama')
        //                  ->queryAll();	
        //
        //                $barang_id = $mod[0]['barang_id'];
      }
    }

    if (isset($_GET['InformasikartustokbarangV'])) {
      //$model->attributes=$_GET['GFInformasikartustokobatalkesV'];
      $barang_id = $_GET['InformasikartustokbarangV']['barang_id'];
      //if (isset($_GET['bln_awal'])) $tgl_awal = $_GET['bln_awal'];
      $tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_awal']);
      $tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_akhir']);
      $this->createUrl('informasi', array('barang_id' => $barang_id));
      $pilihTgl = ($_GET['InformasikartustokbarangV']['pilihTgl'] == 1) ? true : false;
      $transaksi = !empty($_GET['InformasikartustokbarangV']['transaksi']) ? $_GET['InformasikartustokbarangV']['transaksi'] : null;
      $instalasi = isset($_GET['InformasikartustokbarangV']['instalasi_id']) ? (!empty($_GET['InformasikartustokbarangV']['instalasi_id']) ? $_GET['InformasikartustokbarangV']['instalasi_id'] : 'kosong') : 'kosong';
      $ruangan = isset($_GET['InformasikartustokbarangV']['ruangan_id']) ? (!empty($_GET['InformasikartustokbarangV']['ruangan_id']) ? $_GET['InformasikartustokbarangV']['ruangan_id'] : 'kosong') : 'kosong';
    }


    $next = null;
    $prev = null;
    foreach ($mod as $idx => $item) {
      if ($item['barang_id'] == $barang_id) {
        $next = empty($mod[$idx + 1]) ? null : $mod[$idx + 1]['barang_id'];
        $prev = empty($mod[$idx - 1]) ? null : $mod[$idx - 1]['barang_id'];
        break;
      }
    }
    $model = array();
    if (!empty($barang_id)) {
      $model = InformasikartustokbarangV::model()->findByAttributes(array('barang_id' => $barang_id));
    }

    $count = empty($model) ? 0 : 1;
    if (empty($model)) {
      $model = new InformasikartustokbarangV;
    }
    $model2 = new InformasikartustokbarangV;

    $format = new MyFormatter();
    $disabled = false;
    $ruanganAsals = CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama');
    $instalasiAsals = CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = true order by instalasi_nama asc"), 'instalasi_id', 'instalasi_nama');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->barang_id = $barang_id;

    if (!empty($model->barang_id)) {
      $barang = BarangM::model()->findByPk($model->barang_id);
    } else {
      $barang = BarangM::model()->findByPk($barang_id);
    }

    if ($count == 0) {
      if (isset($barang)) {
        $model->attributes = $barang->attributes;
      }
    }

    //          $model->satuanbesar_nama = !empty($obat->satuanbesar_id)?$obat->satuanbesar->satuanbesar_nama:null;
    //      $model->isikemasan = $obat->kemasanbesar;
    //	  $model->satuankecil_nama = !empty($obat->satuankecil_id)?$obat->satuankecil->satuankecil_nama:null;
    //	  $model->jenisobatalkes_nama =  !empty($obat->jenisobatalkes_id)?$obat->jenisobatalkes->jenisobatalkes_nama:null;
    //	  $model->obatalkes_kategori = $obat->obatalkes_kategori;
    //	  $model->obatalkes_golongan = $obat->obatalkes_golongan;
    $model->transaksi = $transaksi;

    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LOGISTIK || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
      $model2->ruangan_id = (($ruangan == 'kosong') ? null : (empty($ruangan) ? Yii::app()->user->getState('ruangan_id') : $ruangan));
      $model2->instalasi_id = (($instalasi == 'kosong') ? null : (empty($instalasi) ? Yii::app()->user->getState('instalasi_id') : $instalasi));

      $model->ruangan_id = (($ruangan == 'kosong') ? null : (empty($ruangan) ? Yii::app()->user->getState('ruangan_id') : $ruangan));
      $model->instalasi_id = (($instalasi == 'kosong') ? null : (empty($instalasi) ? Yii::app()->user->getState('instalasi_id') : $instalasi));
      $disabled = false;
    } else {
      $disabled = true;
      $model2->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model2->instalasi_id = Yii::app()->user->getState('instalasi_id');
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    }

    $model2->barang_id = $model->barang_id;
    $model2->tgl_awal = $tgl_awal;
    $model2->tgl_akhir = $tgl_akhir;
    $model2->transaksi = $transaksi;

    $judul_print = 'Kartu Stok Barang';
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
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $periode = '';
      if ($pilihTgl == 'true') {
        $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . ' - ' . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
      }
      //if (!empty($model->periodeposting_id)){
      //	$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
      //}

      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => "Stok Kartu", 'periode' => $periode, 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printBaru', array(
        'format' => $format,
        'model' => $model,
        'model2' => $model2,
        'judulLaporan' => $judul_print,
        'caraPrint' => $caraPrint,
        'pilihTgl' => $pilihTgl
        //'next'=>$next,
        //'prev'=>$prev,
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
      'judulLaporan' => $judul_print,
      'next' => $next,
      'prev' => $prev,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
      'disabled' => $disabled,
      'periode' => $periode,
      'pilihTgl' => $pilihTgl
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
      $models = CHtml::listData(GFRuanganM::getRuanganStokOas($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk memanggil prinout data
   */
  public function actionPrint()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new InformasikartustokbarangV;

    $judulLaporan = '<b><h4>Informasi Kartu Stok Barang</h4></b>';

    if (isset($_GET['InformasikartustokbarangV'])) {
      $model->attributes = $_GET['InformasikartustokbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasikartustokbarangV']['tgl_akhir']);
      //$model->transaksi = !empty($_GET['InformasikartustokbarangV']['transaksi'])?$_GET['GFInformasikartustokobatalkesV']['transaksi']:null;
    }

    $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan));
  }

  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(barang_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'barang_nama';
      $criteria->limit = 5;
      $models = BarangM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
