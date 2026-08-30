<?php

class InformasiRawatJalanController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rawat Jalan";
    $format = new MyFormatter();
    $modRawatJalan = new INRawatJalan('searchRJ');
    $modRawatJalan->unsetAttributes();
    $modRawatJalan->tgl_awal = date('Y-m-d');
    $modRawatJalan->tgl_akhir = date('Y-m-d');
    $modRawatJalan->tgl_awall = date('Y-m-d');
    $modRawatJalan->tgl_akhirl = date('Y-m-d');
    $modRawatJalan->ceklis = false;
    if (isset($_GET['INRawatJalan'])) {
      $modRawatJalan->attributes = $_GET['INRawatJalan'];
      $modRawatJalan->ceklis = $_REQUEST['INRawatJalan']['ceklis'];
      $modRawatJalan->tgl_awal = isset($_GET['INRawatJalan']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['INRawatJalan']['tgl_awal']) : null;
      $modRawatJalan->tgl_akhir = isset($_GET['INRawatJalan']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['INRawatJalan']['tgl_akhir']) : null;
      $modRawatJalan->tgl_awall  = $format->formatDateTimeForDb($_REQUEST['INRawatJalan']['tgl_awall']);
      $modRawatJalan->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['INRawatJalan']['tgl_akhirl']);
    }
    $this->render('index', array(
      'modRawatJalan' => $modRawatJalan,
      'format' => $format
    ));
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


  public function actionDetailsTarif($idKelasPelayanan, $idDaftarTindakan, $idKategoriTindakan)
  {

    $this->layout = '//layouts/iframe';
    if ($idKelasPelayanan != '') {
      $modTarifTindakan = INTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $idKelasPelayanan . ' AND 
                                                               daftartindakan_id=' . $idDaftarTindakan . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '');
    } else {
      $modTarifTindakan = INTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $idDaftarTindakan . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
                                                               AND kelaspelayanan_id isNull');
    }
    $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $idDaftarTindakan . ' and kelaspelayanan_id = ' . $idKelasPelayanan . ' and kategoritindakan_id = ' . $idKategoriTindakan);
    $jumlahTarifTindakan = count((array)$modTarifTindakan);

    $this->render('detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan,
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
}
