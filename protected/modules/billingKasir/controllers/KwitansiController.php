<?php
class KwitansiController extends MyAuthController
{
  /**
   * method untuk melihat kwitansi pembayaran
   * digunakan di:
   * 1. billing Kasir -> informasi -> pasien sudah bayar
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
    if (count((array)$tindakanSudahBayar) > 0) {
      $totalTindakan = 0;
      $harga = 0;
      $discount = 0;
      foreach ($tindakanSudahBayar as $key => $value) {
        // print_r($value->daftartindakan->kelompoktindakan_id);exit();
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $harga += $value->jmlbiaya_tindakan;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
        $discount += $value->tindakanpelayanan->discount_tindakan;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
        $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
      }
      $rincianpembayaran['tindakan'] = $tindakan;
      $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
    }
    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      $totalOa = 0;
      foreach ($oaSudahBayar as $key => $value) {
        $oa[0]['kelompoktindakan'] = empty($value->obatalkes->jenisobatalkes_id) ? "-" : $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        //                        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        if (isset($oa[0]['harga'])) {
          $oa[0]['harga'] += ($value->hargasatuan * $value->qty_oa);
        }
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        if (isset($oa[0]['discount'])) {
          $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        }
        if (isset($oa[0]['biayaadministrasi'])) {
          $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        }
        if (isset($oa[0]['biayaservice'])) {
          $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        }
        if (isset($oa[0]['biayakonseling'])) {
          $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        }
        $totalOa += (($value->hargasatuan * $value->qty_oa) - (isset($oa[0]['discount']) ? $oa[0]['discount'] : 0) + (isset($oa[0]['biayaadministrasi']) ? $oa[0]['biayaadministrasi'] : 0) + (isset($oa[0]['biayaservice']) ? $oa[0]['biayaservice'] : 0) + (isset($oa[0]['biayakonseling']) ? $oa[0]['biayakonseling'] : 0));
      }
      $rincianpembayaran['oa'] = $oa;
      $rincianpembayaran['oa']['totalOa'] = $totalOa;
    }

    if ($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2) { //jika jmlpembayaran nol

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
      'format' => $format,
      'judulKwitansi' => $judulKwitansi,
      'modPendaftaran' => $modPendaftaran,
      'rincianpembayaran' => $rincianpembayaran,
      'modTandaBukti' => $modTandaBukti,
      'modBayar' => $modBayar,

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
    //            $this->actionCekHakPrint();
    $judulKwitansi = '----- KWITANSI -----';
    $format = new MyFormatter();
    $modBayar = PembayaranpelayananT::model()->findByPk($idPembayaranPelayanan);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
    $criteria = new CdbCriteria();
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaranPelayanan);
    $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
    //$modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb();
    if (!empty($modBayar->pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
    } else {
      $modPendaftaran = new PendaftaranT;
    }
    $rincianpembayaran = array();
    $tindakan = array();
    $harga = 0;
    $discount = 0;
    if (count((array)$tindakanSudahBayar) > 0) {
      $totalTindakan = 0;
      foreach ($tindakanSudahBayar as $key => $value) {
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
        $harga += $value->jmlbiaya_tindakan;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
        $discount += $value->tindakanpelayanan->discount_tindakan;
        $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
        $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
      }
      $rincianpembayaran['tindakan'] = $tindakan;
      $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
    }
    $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
    $oa = array();
    if (count((array)$oaSudahBayar) > 0) {
      $totalOa = 0;
      foreach ($oaSudahBayar as $key => $value) {
        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
        if (isset($oa[0]['harga'])) {
          $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        }
        $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
        if (isset($oa[0]['discount'])) {
          $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
        }
        if (isset($oa[0]['biayaadministrasi'])) {
          $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
        }
        if (isset($oa[0]['biayaservice'])) {
          $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
        }
        if (isset($oa[0]['biayakonseling'])) {
          $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
        }
        $totalOa += (($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa) - (isset($oa[0]['discount']) ? $oa[0]['discount'] : 0) + (isset($oa[0]['biayaadministrasi']) ? $oa[0]['biayaadministrasi'] : 0) + (isset($oa[0]['biayaservice']) ? $oa[0]['biayaservice'] : 0) + (isset($oa[0]['biayakonseling']) ? $oa[0]['biayakonseling'] : 0));
      }
      $rincianpembayaran['oa'] = $oa;
      $rincianpembayaran['oa']['totalOa'] = $totalOa;
    }

    if ($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2) { //jika jmlpembayaran nol
      $modTandaBukti->jmlpembayaran = $rincianpembayaran['tindakan']['totalTindakan'] + $rincianpembayaran['oa']['totalOa'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('billingKasir.views.kwitansi.viewKwitansi', array(
        'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('billingKasir.views.kwitansi.viewKwitansi', array(
        'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
        'modTandaBukti' => $modTandaBukti,
        'modBayar' => $modBayar
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      //$mpdf = new MyPDF60('',$ukuranKertasPDF); 
      //$mpdf = new MyPDF60('','B5-L');
      $mpdf = new MyPDF60('', '', '15', '', 15, 15, 16, 16, 9, 9, 'B5');
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      /*
                 * cara ambil margin
                 * tinggi_header * 72 / (72/25.4)
                 *  tinggi_header = inchi
                 */

      /**
       *Diupdate oleh     : David Yanuar
       *Tgl. update        : 17 April 2014
       *Fungsi            : Saudara Dhika & Fahmi Minta Di Kurangi Margin Atas Kuitansi-nya : EHS-1032
       */
      /*font-family: tahoma;*/
      // $header = 0.50 * 72 / (72/25.4);
      $header = 0.3 * 72 / (72 / 25.4);
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
  //Penambahan Hak akses print RND-3962
  public function actionCekHakPrint()
  {
    $tandabuktibayar_id = $_POST['tandabuktibayar_id'];
    $tandabukti = TandabuktibayarT::model()->findByPk($tandabuktibayar_id);
    if (!Yii::app()->user->checkAccess('Admin')) {
      $data['cekAkses'] = false;
    } else {
      $data['cekAkses'] = true;
      $data['userid'] = Yii::app()->user->id;
      $data['username'] = Yii::app()->user->name;
      TandabuktibayarT::model()->updateByPk($tandabuktibayar_id, array('isprint' => false));
      $data['isprint'] = $tandabukti->isprint;
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }
  public function actionCekLoginHakPrint()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if (!$user->cekPassword3($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
  public function actionViewRincian($id)
  {
    // $rincianpembayaran = array();
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

  public function actionUpdateDN($tandabuktibayar_id, $darinama_bkm)
  {
    $transaction = Yii::app()->db->beginTransaction();
    try {
      TandabuktibayarT::model()->updateByPk($tandabuktibayar_id, array('darinama_bkm' => $darinama_bkm));
      $transaction->commit();
    } catch (Exception $exc) {
      $transaction->rollback();
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
