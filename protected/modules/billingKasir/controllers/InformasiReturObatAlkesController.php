<?php

class InformasiReturObatAlkesController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Retur Obat Alkes";
    $format = new MyFormatter();
    $model = new BKInformasireturresepV('searchInformasiRetur');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->belumbayar = "false";
    if (isset($_GET['BKInformasireturresepV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['BKInformasireturresepV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasireturresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasireturresepV']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionDetailRetur($id)
  {
    $this->layout = '//layouts/iframe';
    $judulKwitansi = 'Detail';
    $caraPrint = '';
    $model = BKReturresepT::model()->findByPk($id);
    $modDetail = BKReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $id));

    $this->render('view', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'judulKwitansi' => $judulKwitansi,
      'caraPrint' => $caraPrint,
    ));
  }

  public function actionViewRincian($id, $caraPrint = null)
  {
    $this->layout = '//layouts/printWindows';

    $model = BKReturresepT::model()->findByPk($id);
    $modDetail = BKReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $id));

    $judulKwitansi = 'Tanda Bukti Pembayaran Retur Penjualan Obat';

    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintReturPenjualanObat', array(
        'model' => $model,
        'modDetail' => $modDetail,
        'judulKwitansi' => $judulKwitansi,
        'caraPrint' => $caraPrint,
      ));
    }
  }


  public function actionPembayaran($idReturBayar)
  {
    $this->layout = '//layouts/iframe';

    $model = ReturbayarpelayananT::model()->findByPk($idReturBayar);
    $format = new MyFormatter();
    $modTandaBukti = new TandabuktikeluarT;
    $modTandaBukti->biayaadministrasi = $model->biayaadministrasi;
    $modTandaBukti->jmlkaskeluar = $model->totaloaretur - $model->biayaadministrasi;
    $modTandaBukti->untukpembayaran = "Retur Pembayaran Penjualan Obat Alkes";

    if (isset($_POST['TandabuktikeluarT'])) {
      $modTandaBukti->attributes = $_POST['TandabuktikeluarT'];
      $modTandaBukti->returbayarpelayanan_id = $model->returbayarpelayanan_id;
      $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modTandaBukti->tglkaskeluar = $format->formatDateTimeForDb($_POST['TandabuktikeluarT']['tglkaskeluar']);
      $modTandaBukti->tahun = date('Y');
      $modTandaBukti->nokaskeluar = MyGenerator::noBuktiKeluar();
      if ($modTandaBukti->validate()) {
        //                    echo "<pre>";
        //                    echo print_r($modTandaBukti->getAttributes());
        //                    echo "</pre>";
        //                    exit();
        if ($modTandaBukti->save()) {
          ReturbayarpelayananT::model()->updateByPk($idReturBayar, array('tandabuktikeluar_id' => $modTandaBukti->tandabuktikeluar_id));
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      }
    }
    $this->render('returPembayaran', array(
      'model' => $model, 'modTandaBukti' => $modTandaBukti,
      'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint,
    ));
  }

  public function actionBayarReturPenjualanObat($idReturBayar, $idTandaBukti)
  {
    if (!empty($idTandaBukti) && !empty($idReturBayar)) {
      $this->layout = '//layouts/printWindows';

      $modReturPenjualan = ReturbayarpelayananT::model()->findByPk($idReturBayar);
      $modTandaBuktiKeluar = TandabuktikeluarT::model()->findByPk($idTandaBukti);
      $returresep = ReturresepT::model()->findByAttributes(array('returresep_id' => $modReturPenjualan->returresep_id));

      $judulLaporan = 'Tanda Bukti Pembayaran Retur Penjualan Obat';
      $this->renderPartial('billingKasir.views.kwitansiReturPenjualanObat', array(
        'modReturPenjualan' => $modReturPenjualan,
        'modTandaBuktiKeluar' => $modTandaBuktiKeluar, 'returresep' => $returresep,
      ));
    }
  }
}
