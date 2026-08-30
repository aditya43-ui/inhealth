<?php
class KwitansiLabController extends MyAuthController
{
  /**
   * method untuk melihat kwitansi pembayaran
   * digunakan di:
   * 1. billing Kasir -> informasi -> pasien sudah bayar
   * @param int $pendaftaran_id pendaftaran_id
   * @param int $idPasienadmisi pasinadmisi_id
   * @param int $idPembayaranPelayanan pembayaranpelayanan_id
   */
  public function actionView($idPembayaranPelayanan)
  {
    if (!empty($_GET['frame']))
      $this->layout = '//layouts/iframe';
    $judulKwitansi = '----- KWITANSI -----';
    $format = new MyFormatter();
    $modBayar = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
    $criteria = new CdbCriteria();
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaranPelayanan);
    $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
    if (!empty($modBayar->pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
    } else {
      $modPendaftaran = new PendaftaranT;
    }
    $rincianpembayaran = array();
    $tindakan = array();
    $pembayarans = array();
    $model = array();
    if (count((array)$tindakanSudahBayar) > 0) {
      $totalTindakan = 0;
      $harga = 0;
      $discount = 0;
      foreach ($tindakanSudahBayar as $key => $value) {
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $harga += $value->jmlbiaya_tindakan;
        $discount += $value->tindakanpelayanan->discount_tindakan;

        $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
      }
      $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
      $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
      $rincianpembayaran['tindakan'] = $tindakan;
      $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
    }
    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      $totalOa = 0;
      foreach ($oaSudahBayar as $key => $value) {
        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        $totalOa += ($oa[0]['harga'] - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
      }
      $rincianpembayaran['oa'] = $oa;
      $rincianpembayaran['oa']['totalOa'] = $totalOa;
    }
    if (isset($modTandaBukti->jmlpembayaran) && $modTandaBukti->jmlpembayaran == 0) { //jika jmlpembayaran nol
      $modTandaBukti->jmlpembayaran = $rincianpembayaran['tindakan']['totalTindakan'] + $rincianpembayaran['oa']['totalOa'];
    }

    //Jika ada perubahan nama pembayar (darinama_bkm)
    if (isset($_POST['TandabuktibayarT'])) {
      if (!empty($_POST['TandabuktibayarT']['darinama_bkm'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $updateSukses = TandabuktibayarT::model()->updateByPk($modBayar->tandabuktibayar_id, array('darinama_bkm' => $_POST['TandabuktibayarT']['darinama_bkm']));
          if ($updateSukses) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
            $this->refresh();
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', 'Data gagal disimpan !');
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('viewKwitansi', array(
      'pembayarans' => $pembayarans,
      'judulKwitansi' => $judulKwitansi,
      'modPendaftaran' => $modPendaftaran,
      'rincianpembayaran' => $rincianpembayaran,
      'modTandaBukti' => $modTandaBukti,
      'modBayar' => $modBayar,
      'model' => $model,
      'format' => $format
      //                                       'pembayaranpelayanan'=>$pembayaranpelayanan
    ));
  }

  /**
   * method untuk print kwitansi
   * digunakan di :
   * 1. Billing Kasir -> Informasi Pasien Sudah Bayar -> Kwitansi Pasien
   * @param int $pendaftaran_id pendaftaran_id
   * @param int $idPasienadmisi pasienadmisi_id
   * @param int $idPembayaranPelayanan pembayaranpelayanan_id
   */
  public function actionPrintKwitansi($idPembayaranPelayanan)
  {
    $judulKwitansi = '----- KWITANSI -----';
    $format = new MyFormatter();
    $modBayar = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
    $criteria = new CdbCriteria();
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaranPelayanan);
    $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
    if (!empty($modBayar->pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
    } else {
      $modPendaftaran = new PendaftaranT;
    }
    $rincianpembayaran = array();
    $tindakan = array();

    if (count((array)$tindakanSudahBayar) > 0) {
      $totalTindakan = 0;
      $harga = 0;
      $discount = 0;
      foreach ($tindakanSudahBayar as $key => $value) {
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $harga += $value->jmlbiaya_tindakan;
        $discount += $value->tindakanpelayanan->discount_tindakan;
        $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
      }
      $rincianpembayaran['tindakan'] = $tindakan;
      $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
    }
    $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
    $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      $totalOa = 0;
      foreach ($oaSudahBayar as $key => $value) {
        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        $totalOa += ($oa[0]['harga'] - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
      }
      $rincianpembayaran['oa'] = $oa;
      $rincianpembayaran['oa']['totalOa'] = $totalOa;
    }
    if (isset($modTandaBukti->jmlpembayaran) && $modTandaBukti->jmlpembayaran == 0) { //jika jmlpembayaran nol
      $modTandaBukti->jmlpembayaran = $rincianpembayaran['tindakan']['totalTindakan'] + $rincianpembayaran['oa']['totalOa'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('billingKasir.views.kwitansi.viewKwitansi', array(
        'model' => $model, 'pembayarans' => $pembayarans, 'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('billingKasir.views.kwitansi.viewKwitansi', array(
        'model' => $model, 'pembayarans' => $pembayarans, 'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      /*
                 * cara ambil margin
                 * tinggi_header * 72 / (72/25.4)
                 *  tinggi_header = inchi
                 */
      $header = 0.78 * 72 / (72 / 25.4);
      $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'billingKasir.views.kwitansi.viewKwitansiPdf',
          array(
            'model' => $model,
            'pembayarans' => $pembayarans,
            'modPendaftaran' => $modPendaftaran,
            'judulKwitansi' => $judulKwitansi,
            'caraPrint' => $caraPrint,
            'rincianpembayaran' => $rincianpembayaran,
            'modTandaBukti' => $modTandaBukti,
            'modBayar' => $modBayar
          ),
          true
        )
      );
      $mpdf->Output();
    }
  }

  public function actionViewRincian($id)
  {
    $this->layout = '//layouts/printWindows';

    $modReturPenjualan = ReturbayarpelayananT::model()->findByPk($id);
    $modTandaBuktiKeluar = TandabuktikeluarT::model()->findByPk($modReturPenjualan->tandabuktikeluar_id);
    $returresep = ReturresepT::model()->findByAttributes(array('returresep_id' => $modReturPenjualan->returresep_id));

    $judulKwitansi = 'Tanda Bukti Pembayaran Retur Penjualan Obat';

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('kwitansiReturPenjualanObat', array('returresep' => $returresep, 'modReturPenjualan' => $modReturPenjualan, 'modTandaBuktiKeluar' => $modTandaBuktiKeluar, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    }
  }
  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
