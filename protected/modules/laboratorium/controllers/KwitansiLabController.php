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
  public function actionView($pendaftaran_id, $idPembayaranPelayanan)
  {

    if (!empty($_GET['frame']))
      $this->layout = '//layouts/iframe';
    //                $pembayaranpelayanan = $pembayarans[0]->pembayaranpelayanan_id;
    //                $model = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $judulKwitansi = '----- KWITANSI -----';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    //            $pembayarans = TindakandanoasudahbayarV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
    $criteria2 = new CDbCriteria();
    //				if(!empty($pendaftaran_id)){
    //					$criteria2->addCondition('pendaftaran_id = '.$pendaftaran_id);
    //				}
    ////            $criteria2->select = 'jmlbiaya_tindakan, qty_tindakanqty_tindakan, kelompoktindakan_nama, kelompoktindakan_id, qty_tindakan';
    //            $criteria2->select= 'count(daftartindakan_id) as daftartindakan_id, kelompoktindakan_id, daftartindakan_nama, kelompoktindakan_nama, daftartindakan_id, ruangan_id, ruangan_nama, tindakansudahbayar_id, qty_tindakan, sum(jmlbiaya_tindakan) as jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, pembayaranpelayanan_id, pasien_id, pendaftaran_id, pasienadmisi_id, nopembayaran, tglpembayaran, carabayar_id, penjamin_id, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, ruanganpelakhir_id';
    //            $criteria2->group = 'kelompoktindakan_id, kelompoktindakan_nama, daftartindakan_nama, daftartindakan_id, ruangan_id, ruangan_nama, tindakansudahbayar_id, qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, pembayaranpelayanan_id, pasien_id, pendaftaran_id, pasienadmisi_id, nopembayaran, tglpembayaran, carabayar_id, penjamin_id, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, ruanganpelakhir_id';
    //            //				if(!empty($pendaftaran_id)){
    //					$criteria2->addCondition('pendaftaran_id = '.$pendaftaran_id);
    //				}
    if (!empty($idPembayaranPelayanan)) {
      $criteria2->addCondition('pembayaranpelayanan_id = ' . $idPembayaranPelayanan);
    }
    //                $criteria2->select ='kelompoktindakan_id, nopembayaran,kelompoktindakan_nama,totalbayartindakan,totalsisatagihan,
    //                                     SUM(qty_tindakan) AS qty_tindakan,
    //                                     SUM(jmlbiaya_tindakan) AS jmlbiaya_tindakan';
    //                $criteria2->group = 'kelompoktindakan_id, kelompoktindakan_nama,nopembayaran,totalbayartindakan,totalsisatagihan';
    //                if(!empty($this->daftartindakan_id)){
    //					$criteria2->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
    //				}
    //                $pembayarans = TindakandanoasudahbayarV::model()->findAll($criteria2);

    $modBayar = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);

    $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria2);

    $rincianpembayaran = array();
    $tindakan = array();
    $pembayarans = array();
    $model = array();
    $harga = 0;
    $discount = 0;
    if (count((array)$tindakanSudahBayar) > 0) {
      foreach ($tindakanSudahBayar as $key => $value) {
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = (isset($value->jmlbiaya_tindakan) ? ($harga + $value->jmlbiaya_tindakan) : 0);
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = (isset($value->tindakanpelayanan->discount_tindakan) ? ($discount + $value->tindakanpelayanan->discount_tindakan) : 0);
      }
      $rincianpembayaran['tindakan'] = $tindakan;
    }

    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria2);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      foreach ($oaSudahBayar as $key => $value) {
        //                    if (isset($rincianpembayaran['tindakan'])){
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        //                        $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaservice'] += $value->obatalkespasien->biayaservice;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        //                    }else{
        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        //                    }
      }
      $rincianpembayaran['oa'] = $oa;
    }


    $this->render('viewKwitansi', array(
      'pembayarans' => $pembayarans,
      'judulKwitansi' => $judulKwitansi,
      'modPendaftaran' => $modPendaftaran,
      'rincianpembayaran' => $rincianpembayaran,
      'modTandaBukti' => $modTandaBukti,
      'modBayar' => $modBayar,
      'model' => $model,
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
  public function actionPrintKwitansi($pendaftaran_id, $idPasienadmisi, $idPembayaranPelayanan)
  {
    $judulKwitansi = '----- KWITANSI -----';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modBayar = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
    $criteria2 = new CDbCriteria();
    if (!empty($idPembayaranPelayanan)) {
      $criteria2->addCondition('pembayaranpelayanan_id = ' . $idPembayaranPelayanan);
    }
    $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria2);

    $rincianpembayaran = array();
    $tindakan = array();
    $model = array();
    $pembayarans = array();
    $harga = 0;
    $discount = 0;
    if (count((array)$tindakanSudahBayar) > 0) {
      foreach ($tindakanSudahBayar as $key => $value) {
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = (isset($value->jmlbiaya_tindakan) ? ($harga + $value->jmlbiaya_tindakan) : 0);
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = (isset($value->tindakanpelayanan->discount_tindakan) ? ($discount + $value->tindakanpelayanan->discount_tindakan) : 0);
      }
      $rincianpembayaran['tindakan'] = $tindakan;
    }

    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria2);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      foreach ($oaSudahBayar as $key => $value) {
        //                    if (isset($rincianpembayaran['tindakan'])){
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        //                        $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaservice'] += $value->obatalkespasien->biayaservice;
        //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        //                    }else{
        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        //                    }
      }
      $rincianpembayaran['oa'] = $oa;
    }
    //            $data['judulLaporan']='Data Rincian Tagihan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('laboratorium.views.kwitansiLab.viewKwitansi', array(
        'model' => $model, 'pembayarans' => $pembayarans, 'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('laboratorium.views.kwitansiLab.viewKwitansi', array(
        'model' => $model, 'pembayarans' => $pembayarans, 'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('laboratorium.views.kwitansiLab.viewKwitansiPdf', array(
        'model' => $model, 'pembayarans' => $pembayarans, 'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ), true));
      $mpdf->Output();
    }
  }

  public function terbilang($x, $style = 4, $strcomma = ",")
  {
    if ($x < 0) {
      $result = "minus " . trim($this->ctword($x));
    } else {
      $arrnum = explode("$strcomma", $x);
      $arrcount = count((array)$arrnum);
      if ($arrcount == 1) {
        $result = trim($this->ctword($x));
      } else if ($arrcount > 1) {
        $result = trim($this->ctword($arrnum[0])) . " koma " . trim($this->ctword($arrnum[1]));
      }
    }
    switch ($style) {
      case 1: //1=uppercase  dan
        $result = strtoupper($result);
        break;
      case 2: //2= lowercase
        $result = strtolower($result);
        break;
      case 3: //3= uppercase on first letter for each word
        $result = ucwords($result);
        break;
      default: //4= uppercase on first letter
        $result = ucfirst($result);
        break;
    }
    return $result;
  }

  public function ctword($x)
  {
    $x = abs((int)$x);
    $number = array(
      "", "satu", "dua", "tiga", "empat", "lima",
      "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
    );
    $temp = "";

    if ($x < 12) {
      $temp = " " . $number[$x];
    } else if ($x < 20) {
      $temp = $this->ctword($x - 10) . " belas";
    } else if ($x < 100) {
      $temp = $this->ctword($x / 10) . " puluh" . $this->ctword($x % 10);
    } else if ($x < 200) {
      $temp = " seratus" . $this->ctword($x - 100);
    } else if ($x < 1000) {
      $temp = $this->ctword($x / 100) . " ratus" . $this->ctword($x % 100);
    } else if ($x < 2000) {
      $temp = " seribu" . $this->ctword($x - 1000);
    } else if ($x < 1000000) {
      $temp = $this->ctword($x / 1000) . " ribu" . $this->ctword($x % 1000);
    } else if ($x < 1000000000) {
      $temp = $this->ctword($x / 1000000) . " juta" . $this->ctword($x % 1000000);
    } else if ($x < 1000000000000) {
      $temp = $this->ctword($x / 1000000000) . " milyar" . $this->ctword(fmod($x, 1000000000));
    } else if ($x < 1000000000000000) {
      $temp = $this->ctword($x / 1000000000000) . " trilyun" . $this->ctword(fmod($x, 1000000000000));
    }
    return $temp;
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
