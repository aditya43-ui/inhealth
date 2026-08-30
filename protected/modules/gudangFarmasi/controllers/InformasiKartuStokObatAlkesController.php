<?php

class InformasiKartuStokObatAlkesController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiKartuStokObatAlkes.';

  public function actionIndexOld()
  {
    $model = new GFInformasikartustokobatalkesV('search');
    $format = new MyFormatter();
    $disabled = false;
    //$ruanganAsals = CHtml::listData(GFRuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama');
    $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->ruangan_id == Params::RUANGAN_ID_GUDANG_FARMASI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
      $disabled = false;
    } else {
      $disabled = true;
    }
    if (isset($_GET['GFInformasikartustokobatalkesV'])) {
      $model->attributes = $_GET['GFInformasikartustokobatalkesV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_akhir']);
      $model->transaksi = !empty($_GET['GFInformasikartustokobatalkesV']['transaksi']) ? $_GET['GFInformasikartustokobatalkesV']['transaksi'] : null;
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
      'disabled' => $disabled,
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
    $model = new GFInformasikartustokobatalkesV;

    $judulLaporan = '<b><h4>Informasi Kartu Stok Obat Alkes</h4></b>';

    if (isset($_GET['GFInformasikartustokobatalkesV'])) {
      $model->attributes = $_GET['GFInformasikartustokobatalkesV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_akhir']);
      $model->transaksi = !empty($_GET['GFInformasikartustokobatalkesV']['transaksi']) ? $_GET['GFInformasikartustokobatalkesV']['transaksi'] : null;
    }

    $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan));
  }

  /**
   * NEW GUI Informasi Kartu Stok
   */
  public function actionIndex($obatalkes_id = null, $caraPrint = null, $tgl_awal = null, $tgl_akhir = null, $transaksi = null, $instalasi = null, $ruangan = null, $pilihTgl = null)
  {

    $this->pageTitle = Yii::app()->name . " - Kartu Stok Obat Alkes";
    $cekStok = GFInformasikartustokobatalkesV::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));

    if ($obatalkes_id == null) {
      $mod = Yii::app()->db->createCommand(
        'select obatalkes_id,obatalkes_nama from informasikartustokobatalkes_v
		where ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' group by obatalkes_id,obatalkes_nama order by obatalkes_nama'
      )
        ->queryAll();
    } else {
      //var_du
      if (empty($cekStok)) {
        $mod = Yii::app()->db->createCommand(
          'select obatalkes_id,obatalkes_nama from obatalkes_m
			order by obatalkes_nama'
        )
          ->queryAll();
      } else {
        $mod = Yii::app()->db->createCommand(
          'select obatalkes_id,obatalkes_nama from informasikartustokobatalkes_v
				where ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' group by obatalkes_id,obatalkes_nama order by obatalkes_nama'
        )
          ->queryAll();
      }
    }

    //var_dump($mod[0]['obatalkes_id']); die;
    if (empty($obatalkes_id)) {
      if (count((array)$mod) > 0) {
        $obatalkes_id = $mod[0]['obatalkes_id'];
      } else {
        $mod = Yii::app()->db->createCommand(
          'select obatalkes_id,obatalkes_nama from obatalkes_m
			order by obatalkes_nama'
        )
          ->queryAll();

        $obatalkes_id = $mod[0]['obatalkes_id'];
      }
    }
    if (isset($_GET['GFInformasikartustokobatalkesV'])) {
      //$model->attributes=$_GET['GFInformasikartustokobatalkesV'];
      $obatalkes_id = $_GET['GFInformasikartustokobatalkesV']['obatalkes_id'];
      //if (isset($_GET['bln_awal'])) $tgl_awal = $_GET['bln_awal'];
      $tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_awal']);
      $tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_akhir']);
      $this->createUrl('informasi', array('obatalkes_id' => $obatalkes_id));
      $pilihTgl = ($_GET['GFInformasikartustokobatalkesV']['pilihTgl'] == 1) ? true : false;
      $transaksi = !empty($_GET['GFInformasikartustokobatalkesV']['transaksi']) ? $_GET['GFInformasikartustokobatalkesV']['transaksi'] : null;
      $instalasi = isset($_GET['GFInformasikartustokobatalkesV']['instalasi_id']) ? (!empty($_GET['GFInformasikartustokobatalkesV']['instalasi_id']) ? $_GET['GFInformasikartustokobatalkesV']['instalasi_id'] : 'kosong') : 'kosong';
      $ruangan = isset($_GET['GFInformasikartustokobatalkesV']['ruangan_id']) ? (!empty($_GET['GFInformasikartustokobatalkesV']['ruangan_id']) ? $_GET['GFInformasikartustokobatalkesV']['ruangan_id'] : 'kosong') : 'kosong';
    }
    //var_dump($mod); die;



    $next = null;
    $prev = null;
    foreach ($mod as $idx => $item) {
      if ($item['obatalkes_id'] == $obatalkes_id) {
        $next = empty($mod[$idx + 1]) ? null : $mod[$idx + 1]['obatalkes_id'];
        $prev = empty($mod[$idx - 1]) ? null : $mod[$idx - 1]['obatalkes_id'];
        break;
      }
    }
    // die;
    $model = GFInformasikartustokobatalkesV::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));


    if (empty($model)) {
      $model = new GFInformasikartustokobatalkesV;
    }
    $model2 = new GFInformasikartustokobatalkesV;
    //var_dump(count((array)$model)); die;
    $format = new MyFormatter();
    $disabled = false;
    //$ruanganAsals = CHtml::listData(GFRuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama');
    $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->obatalkes_id = $obatalkes_id;
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');		



    // var_dump(count((array)$model)); die;

    if (!empty($model->obatalkes_id)) {
      $obat = ObatalkesM::model()->findByPk($model->obatalkes_id);
    } else {
      $obat = ObatalkesM::model()->findByPk($obatalkes_id);
    }

    if (!empty($model)) {
      $model->attributes = $obat->attributes;
    }

    //var_dump($obatalkes_id);die;
    $model->satuanbesar_nama = !empty($obat->satuanbesar_id) ? $obat->satuanbesar->satuanbesar_nama : null;
    $model->isikemasan = $obat->kemasanbesar;
    $model->satuankecil_nama = !empty($obat->satuankecil_id) ? $obat->satuankecil->satuankecil_nama : null;
    $model->jenisobatalkes_nama =  !empty($obat->jenisobatalkes_id) ? $obat->jenisobatalkes->jenisobatalkes_nama : null;
    $model->obatalkes_kategori = $obat->obatalkes_kategori;
    $model->obatalkes_golongan = $obat->obatalkes_golongan;
    $model->transaksi = $transaksi;


    if (Yii::app()->user->ruangan_id == Params::RUANGAN_ID_GUDANG_FARMASI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
      $model2->ruangan_id = (($ruangan == 'kosong') ? null : (empty($ruangan) ? Yii::app()->user->getState('ruangan_id') : $ruangan));
      $model2->instalasi_id = (($instalasi == 'kosong') ? null : (empty($instalasi) ? Yii::app()->user->getState('instalasi_id') : $instalasi));

      $model->ruangan_id = (($ruangan == 'kosong') ? null : (empty($ruangan) ? Yii::app()->user->getState('ruangan_id') : $ruangan));
      $model->instalasi_id = (($instalasi == 'kosong') ? null : (empty($instalasi) ? Yii::app()->user->getState('instalasi_id') : $instalasi));
      $disabled = false;
      //$model2->ruangan_id = 59;
      //$model2->instalasi_id = 9;			
    } else {
      $disabled = true;
      //die;
      $model2->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model2->instalasi_id = Yii::app()->user->getState('instalasi_id');
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    }

    //$instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(),'instalasi_id','instalasi_nama');
    //$ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI),'ruangan_id','ruangan_nama');
    //$model->tgl_awal = date("Y-m-d",strtotime('-1 month'));
    //$model->tgl_akhir = date("Y-m-d");

    $model2->obatalkes_id = $model->obatalkes_id;
    $model2->tgl_awal = $tgl_awal;
    $model2->tgl_akhir = $tgl_akhir;
    $model2->transaksi = $transaksi;

    //var_dump($model2->instalasi_id);die;

    $judul_print = 'Kartu Stok';
    if (!empty($model->ruangan_id)) {
      $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
      if (!empty($ruangan)) {
        $judul_print .= ' - ' . $ruangan->ruangan_nama;
      }
    }

    if (!empty($obat)) {
      $judul_print .= '<br>' . $obat->obatalkes_nama;
    }


    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframeNeon';
    }
    if ($caraPrint == 'PRINT') {
      $judul_print = '<b><h4>Informasi Kartu Stok Obat Alkes</h4></b>';
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $judul_print = '<b><h4>Informasi Kartu Stok Obat Alkes</h4></b>';
      $this->layout = '//layouts/printExcel';
    } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
      $judul_print = '<b><h4>Informasi Kartu Stok Obat Alkes</h4></b>';
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $periode = '';
      if ($pilihTgl == 'true') {
        $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . ' - ' . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
      }
      //if (!empty($model->periodeposting_id)){
      //	$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
      //}

      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judul_print,  'periode'=> $periode, 'colspan'=>10),true));
      //            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printBaru', array(
        'format' => $format,
        'obat' => $obat,
        'model' => $model,
        'model2' => $model2,
        'judul_print' => $judul_print,
        'caraPrint' => $caraPrint,
        //'next'=>$next,
        //'prev'=>$prev,
      ), true));
      $mpdf->Output($judul_print . '_' . date('Y-m-d') . '.pdf', 'I');
      Yii::app()->end();
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
      'obat' => $obat,
      'model' => $model,
      'model2' => $model2,
      'caraPrint' => $caraPrint,
      'judul_print' => $judul_print,
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
   * Action auto complete pencarian berdasarkan nama obat alkes
   * @param type $obatalkes_nama
   * @param type $attr
   */
  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
