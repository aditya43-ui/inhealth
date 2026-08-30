<?php

class InformasiTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Tarif";
    $modTarifTindakanRuanganV = new INTarifTindakanPerdaRuanganV('search');
    // $modTarifTindakanRuanganV->instalasi_id = Params::INSTALASI_ID_RJ;
    // $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    // $modTarifTindakanRuanganV->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    // $modTarifTindakanRuanganV->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['INTarifTindakanPerdaRuanganV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['INTarifTindakanPerdaRuanganV'];
      $modTarifTindakanRuanganV->carabayar_id = $_GET['INTarifTindakanPerdaRuanganV']['carabayar_id'];
      $modTarifTindakanRuanganV->penjamin_id = $_GET['INTarifTindakanPerdaRuanganV']['penjamin_id'];
    }
    $this->render('index', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV));
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
      $models = CHtml::listData(INRuanganM::getRuangans($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  protected function createList($instalasi_id)
  {

    $criteria = new CDbCriteria();
    $criteria->addCondition('instalasi_id = ' . $instalasi_id . '');
    $informasi = INTarifTindakanPerdaRuanganV::model()->findAll($criteria);
    $tr = $this->index($instalasi_id);

    //            $pengeluaran = RETandabuktibayarposV::model()->findAll($criteria);
    //            $tr = $this->rowPengeluaran($pengeluaran, $data['saldo'], $data['tr']);
    return $tr;
  }

  public function actionGantiInstalasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST['instalasi_id'];
      $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);

      $data['instalasi_id'] = $modInstalasi->instalasi_id;
      $data['instalasi_nama'] = $modInstalasi->instalasi_nama;
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }


  public function actionDetailsTarif($kelaspelayanan_id, $daftartindakan_id, $kategoritindakan_id, $jenistarif_id)
  {

    $this->layout = '//layouts/iframe';
    $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
    $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
    $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
    $jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);

    $modTarifTindakanform = new INTarifTindakanPerdaRuanganV();

    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = INTariftindakanM::model()->with('komponentarif')->findAll('t.kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
                                                               t.daftartindakan_id=' . $daftartindakan_id . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . ' AND t.jenistarif_id=' . $jenistarif_id);
    } else {
      $modTarifTindakan = INTariftindakanM::model()->with('komponentarif')->findAll('t.daftartindakan_id=' . $daftartindakan_id . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
                                                               AND kelaspelayanan_id isNull AND t.jenistarif_id=' . $jenistarif_id);
    }
    //            echo '<pre>';
    //            print_r(count((array)$modTarifTindakan));
    //            exit();
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . '');
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and kategoritindakan_id = ' . $kategoritindakan_id);
    }
    $jumlahTarifTindakan = count((array)$modTarifTindakan);

    $this->render('detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan,
      'modTarifTindakanform' => $modTarifTindakanform,
      'jumlahTarifTindakan' => $jumlahTarifTindakan
    ));
  }


  public function actionPrintTarif()
  {
    $model = new INTarifTindakanPerdaRuanganV('searchInformasiPrint');
    //            $model->unsetAttributes();
    if (isset($_GET['INTarifTindakanPerdaRuanganV']))
      $model->attributes = $_GET['INTarifTindakanPerdaRuanganV'];

    $judulLaporan = 'Laporan Penerimaan Kas';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
