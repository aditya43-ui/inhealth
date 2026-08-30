<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PrintController extends Controller
{
  public function actions()
  {
    return array(
      'myBarcode' => array(
        'class' => 'MyBarcodeAction',
        'canvasWidth' => '230',
        'type' => 'code128',
      ),
    );
  }

  public function actionLembarJanjiPoli($idBuatJanjiPoli)
  {
    $this->layout = '//layouts/printWindows';
    $modJanjiPoli = BuatjanjipoliT::model()->findByPk($idBuatJanjiPoli);
    $modPasien =  PasienM::model()->findByPk($modJanjiPoli->pasien_id);
    $judulLaporan = 'Lembar Janji Poli';
    $this->render('lembarJanjiPoli', array(
      'modJanjiPoli' => $modJanjiPoli,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien
    ));
  }

  public function actionLembarBookingKamar($idBookingKamar)
  {
    $this->layout = '//layouts/printWindows';
    $modBookingKamar = BookingkamarT::model()->findByPk($idBookingKamar);
    $modPasien =  PasienM::model()->findByPk($modBookingKamar->pasien_id);
    $judulLaporan = 'Lembar Booking Kamar';
    $this->render('lembarBookingKamar', array(
      'modBookingKamar' => $modBookingKamar,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien
    ));
  }

  public function actionlembarPoliRJ($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $idKarcis =  TindakanpelayananT::model()->find('pasien_id=' . $modPasien->pasien_id . ' AND pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '')->karcis_id;
    if (!empty($idKarcis)) {
      $namaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->karcis_nama;
      $hargaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->harga_tariftindakan;
    } else {
      $namaKarcis = '';
      $hargaKarcis = '';
    }

    $judulLaporan = 'Kunjungan Poliklinik';
    $this->render('lembarPoliRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,
      'namaKarcis' => $namaKarcis,
      'hargaKarcis' => $hargaKarcis,
    ));
  }
  /**
   * actionlembarPoliRJ untuk print di blanko rekamedik
   * @param type $pendaftaran_id
   */
  public function actionlembarPoliRJBlanko($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $idKarcis =  TindakanpelayananT::model()->find('pasien_id=' . $modPasien->pasien_id . ' AND pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '')->karcis_id;
    if (!empty($idKarcis)) {
      $namaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->karcis_nama;
      $hargaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->harga_tariftindakan;
    } else {
      $namaKarcis = '';
      $hargaKarcis = '';
    }

    $judulLaporan = 'Kunjungan Poliklinik';
    $this->render('lembarPoliRJBlanko', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,
      'namaKarcis' => $namaKarcis,
      'hargaKarcis' => $hargaKarcis,
    ));
  }

  public function actionlembarPoli($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $idKarcis =  TindakanpelayananT::model()->find('pasien_id=' . $modPasien->pasien_id . ' AND pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '')->karcis_id;
    if (!empty($idKarcis)) {
      $namaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->karcis_nama;
      $hargaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->harga_tariftindakan;
    } else {
      $namaKarcis = '';
      $hargaKarcis = '';
    }

    $judulLaporan = 'Kunjungan Poliklinik';
    $this->render('lembarPoliRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,
      'namaKarcis' => $namaKarcis,
      'hargaKarcis' => $hargaKarcis,
    ));
  }

  public function actionlembarPoliRD($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $idKarcis =  TindakanpelayananT::model()->find('pasien_id=' . $modPasien->pasien_id . ' AND pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '')->karcis_id;
    if (!empty($idKarcis)) {
      $namaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->karcis_nama;
      $hargaKarcis = KarcisV::model()->find('karcis_id=' . $idKarcis . '')->harga_tariftindakan;
    } else {
      $namaKarcis = '';
      $hargaKarcis = '';
    }
    $judulLaporan = 'Kunjungan Rawat Darurat';
    $this->render('lembarPoliRD', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,
      'namaKarcis' => $namaKarcis,
      'hargaKarcis' => $hargaKarcis,
    ));
  }

  public function actionlembarPoliRI($pasienadmisi_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modPasienAdmisi->pendaftaran_id));

    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judulLaporan = 'Kunjungan Masuk Rawat Inap';
    $this->render('lembarPoliRI', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modPasienAdmisi,
      'judulLaporan' => $judulLaporan,
      'modPasien' => $modPasien,

    ));
  }

  public function actionKartuPasien($pasien_id)
  {
    $this->layout = '//layouts/printWindows';
    //        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judulLaporan = 'Kartu Pasien';
    $this->render(
      'kartuPasien',
      array(
        'modPasien' => $modPasien,
        'judulLaporan' => $judulLaporan
      )
    );
  }

  public function actionKartuPegawai($idPegawai)
  {
    $this->layout = '//layouts/printWindows';
    $model = PegawaiM::model()->findByPk($idPegawai);
    $judulLaporan = 'Kartu Pegawai';
    $this->render('kartuPegawai', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan
    ));
  }

  public function actionKartuPasienRI($pasienadmisi_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    $modPasien = PasienM::model()->findByPk($modPasienAdmisi->pasien_id);
    $judulLaporan = 'Kartu Pasien';
    $this->render('kartuPasienRI', array(
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPasien' => $modPasien,
      'judulLaporan' => $judulLaporan
    ));
  }

  public function actionPemeriksaanLab()
  {
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
    $pasien_id = $_GET['pasien_id'];
    //       echo var_dump($_GET);exit;
    $this->layout = '//layouts/printWindows';
    $modHasilpemeriksaanLab = HasilpemeriksaanlabT::model()->findByAttributes(array(
      'pendaftaran_id' => (int)$pendaftaran_id,
      'pasienmasukpenunjang_id' => (int)$pasienmasukpenunjang_id,
      'pasien_id' => (int)$pasien_id
    ));
    $modDetailHasilPemeriksaanLab =  DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilpemeriksaanLab->hasilpemeriksaanlab_id));
    $modNilaiRujukan = NilairujukanM::model()->findByAttributes(array(
      'kelompokumur' => strtoupper($modHasilpemeriksaanLab->hasil_kelompokumur),
      'nilairujukan_jeniskelamin' => strtoupper($modHasilpemeriksaanLab->hasil_jeniskelamin)
    ));
    $this->render('pemeriksaanLab', array(
      'modHasilpemeriksaanLab' => $modHasilpemeriksaanLab,
      'modNilaiRujukan' => $modNilaiRujukan,
      'modDetailHasilPemeriksaanLab' => $modDetailHasilPemeriksaanLab,
      'pasien_id' => $pasien_id
    ));
  }

  /**
   * method untuk print pembayaran kasir
   * digunakan di :
   * 1. Billing Kasir -> transaksi bayar tagihan pasien -> print
   * 2. Billing Kasir -> transaksi bayar resep pasien -> print
   * @param int $idTandaBukti tandabuktibayar_id
   * @param boolean $group to make grouping in obatalkes
   */
  public function actionBayarKasir($idTandaBukti, $caraPrint = 'PRINT', $group = false)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/printWindows';
      $model = TandabuktibayarT::model()->findByPk($idTandaBukti);
      // if (!empty($model->pembayaranpelayanan_id)) {
      //     $modTemp = PembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);
      // } elseif (!empty($model->bayaruangmuka_id)) {
      //     $modTemp = BayaruangmukaT::model()->findByPk($model->bayaruangmuka_id);
      // }
      // if(!empty($modTemp->pasien_id)){
      //     $modPasien = PasienM::model()->findByPk($modTemp->pasien_id);
      // }

      // echo "<pre>"; print_r($modPasien->attributes); exit();
      // $obatalkespasien = ObatalkespasienT::model()->findByAttributes(array('pendaftaran_id'=>$model->pembayaran->pendaftaran_id,));


      //            $detailKwitansi=KwitansiKasirV::model()->findAllByAttributes(array('nobuktibayar_id' =>$nopend));
      //            $rincianTagihan = RinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pembayaran->pendaftaran_id));
      //            $detailKwitansi = array();

      //            $judulKwitansi = '----- KWITANSI -----';
      //            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      //            $pembayarans = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));

      //            $criteria2 = new CDbCriteria();
      //            $criteria2->compare('pendaftaran_id',$model->pembayaran->pendaftaran_id);
      //            $criteria2->compare('pembayaranpelayanan_id', $model->pembayaranpelayanan_id);
      //            $criteria2->select = 'kelompoktindakan_id, kelompoktindakan_nama, ruangan_id, ruangan_nama, 
      //                    sum(jmlbiaya_tindakan) as jmlbiaya_tindakan, 
      //                    sum(jmlsubsidi_asuransi) as jmlsubsidi_asuransi, sum(jmlsubsidi_pemerintah) as jmlsubisi_pemerintah, 
      //                    sum(jmlsubsidi_rs) as jmlsubsidi_rs, sum(jmlsubsidi_asuransi) as jmlsubsidi_asuransijmliurbiaya, 
      //                    sum(jmlpembebasan) as jmlpembebasan, 
      //                    sum(jmlbayar_tindakan) as jmlbayar_tindakan, 
      //                    sum(jmlsisabayar_tindakan) as jmlsisabayar_tindakan, 
      //                    pembayaranpelayanan_id, pasien_id, pendaftaran_id, 
      //                    pasienadmisi_id, nopembayaran, tglpembayaran, carabayar_id, penjamin_id, 
      //                    totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, 
      //                    totalsubsidiasuransi,totalsubsidipemerintah,totalsubsidirs, 
      //                    totaliurbiaya, totalbayartindakan, totaldiscount, 
      //                    totalpembebasan, totalsisatagihan,
      //                    ruanganpelakhir_id';
      //            $criteria2->group = '
      //                        kelompoktindakan_id, kelompoktindakan_nama, ruangan_id, ruangan_nama, 
      //                        pembayaranpelayanan_id, 
      //                        pasien_id, pendaftaran_id, pasienadmisi_id, nopembayaran, 
      //                        tglpembayaran, carabayar_id, penjamin_id, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, 
      //                        totalsubsidiasuransi,totalsubsidipemerintah,totalsubsidirs, 
      //                        totaliurbiaya, totalbayartindakan, totaldiscount, 
      //                        totalpembebasan, totalsisatagihan,
      //                        ruanganpelakhir_id';

      //            $rincianpembayaran = TindakandanoasudahbayarV::model()->findAll($criteria2);
      //            $modBayar = PembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);
      //            $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria2);

      //            $rincianpembayaran = array();
      //            $tindakan = array();
      //            if (count((array)$tindakanSudahBayar) > 0){
      //                foreach ($tindakanSudahBayar as $key => $value) {
      //                    $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
      //                    $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] += $value->tindakanpelayanan->tarif_tindakan;
      //                    $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] += $value->tindakanpelayanan->discount_tindakan;
      //                }
      //                $rincianpembayaran['tindakan'] = $tindakan;
      //            }

      //            $oaSudahBayar = OasudahbayarT::model()->findAll($criteria2);
      //            $oa = array();
      //            if (count((array)$oaSudahBayar) > 0 ){
      //                foreach ($oaSudahBayar as $key => $value) {
      //                    if ((boolean)$group){
      //                        $oa[0]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
      //                        $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
      //                        $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
      //                        $oa[0]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
      //                        $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
      //                        $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
      //                        $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
      //                    }else{
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['kelompoktindakan'] = $value->obatalkes->jenisobatalkes->jenisobatalkes_nama;
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
      //                        $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayaservice'] += $value->obatalkespasien->biayaservice;
      //                        $oa[$value->obatalkes->jenisobatalkes_id]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
      //                    }
      //                }
      //                $rincianpembayaran['oa'] = $oa;
      //            }


      $judulPrint = "Tanda Bukti Pembayaran";
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render(
          '/kwitansiPembayaran',
          array(
            'model' => $model,
            // 'modPembayaran'=>$modPembayaran
          )
        );
      } elseif ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $header = 0.58 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            '/kwitansiPembayaran',
            array(
              'model' => $model,
              'modPembayaran' => $modPembayaran
            ),
            true
          )
        );
        $mpdf->Output();
      }
      // $judulLaporan = 'Tanda Bukti Pembayaran';
      // $this->render('kwitansiPembayaran', array(
      //     'model' => $model,
      //     'modPembayaran'=>$modPembayaran
      //     'modBayar'=>$modBayar, 
      //     'group'=>$group,
      //     'judulLaporan'=> $judulLaporan,
      //     'detailKwitansi'=>$detailKwitansi,
      //     'rincianTagihan'=>$rincianTagihan,
      //     'rincianpembayaran'=>$rincianpembayaran,
      //     'pembayarans'=>$pembayarans,
      //    'judulKwitansi'=>$judulKwitansi,
      //    'modPendaftaran'=>$modPendaftaran,
      //    'obatalkespasien'=>$obatalkespasien
      // ));
    }
  }

  public function actionRincianKasirBaru($idTandaBukti)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/printWindows';
      $data['judulLaporan'] = 'Rincian Tagihan Pasien';
      $criteria = new CDbCriteria;
      if (!empty($idTandaBukti)) {
        $criteria->addCondition("t.tandabuktibayar_id = " . $idTandaBukti);
      }
      $model = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
      $modPendaftaran = PendaftaranT::model()->findByPk($model->pembayaran->pendaftaran_id);
      $modRincian = RinciantagihanpasienV::model()->findAllByAttributes(
        array('pendaftaran_id' => $modPendaftaran->pendaftaran_id),
        array('order' => 'ruangan_id')
      );
      $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
        array('pendaftaran_id' => $model->pembayaran->pendaftaran_id)
      );
      $uang_cicilan = 0;
      foreach ($uangmuka as $val) {
        $uang_cicilan += $val->jumlahuangmuka;
      }

      $data['uang_cicilan'] = $uang_cicilan;
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      $judulPrint = "RINCIAN BIAYA";
      $this->render(
        'kwitansiPembayaranRincianBaru',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'judulPrint' => $judulPrint
        )
      );
    }
  }

  public function actionRincianKasirBaruPrint($idTandaBukti, $idPembayaran = null, $caraPrint = null)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/iframe';
      //            $this->layout='//layouts/printWindows';

      $data['judulLaporan'] = 'Rincian Tagihan Pasien';

      $criteria = new CDbCriteria;
      if (!empty($idTandaBukti)) {
        $criteria->addCondition("t.tandabuktibayar_id = " . $idTandaBukti);
      }
      $model = TandabuktibayarT::model()->with('pembayaran')->find($criteria);

      $pembayaran = PembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);

      $modPendaftaran = PendaftaranT::model()->findByPk(
        $model->pembayaran->pendaftaran_id
      );
      if (empty($idPembayaran)) {
        $modRincian = RinciantagihapasiensudahbayarV::model()->findAllByAttributes(
          array('pendaftaran_id' => $modPendaftaran->pendaftaran_id),
          array('order' => 'ruangan_id')
        );
      } else {
        $modRincian = RinciantagihapasiensudahbayarV::model()->findAllByAttributes(
          array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
            'pembayaranpelayanan_id' => $idPembayaran,
          ),
          array('order' => 'ruangan_id')
        );
      }
      // echo "<pre>";
      // echo $idTandaBukti;echo "<pre>";
      // echo $modPendaftaran->pendaftaran_id;echo "<pre>";
      // echo $pembayaran->pembayaranpelayanan_id;echo "<pre>";
      // echo count((array)$modRincian);exit;
      $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
        array('pendaftaran_id' => $model->pembayaran->pendaftaran_id)
      );

      $uang_cicilan = 0;
      foreach ($uangmuka as $val) {
        $uang_cicilan += $val->jumlahuangmuka;
      }

      $data['uang_cicilan'] = $uang_cicilan;
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      $judulPrint = "RINCIAN BIAYA";
      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60(
          '',
          $ukuranKertasPDF, //format A4 Or
          11, //Font SIZE
          '', //default font family
          3, //15 margin_left
          3, //15 margin right
          25, //16 margin top
          10, // margin bottom
          0, // 9 margin header
          0, // 9 margin footer
          'P' // L - landscape, P - portrait
        );
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        //$mpdf->AddPage($posisi,'','','','',5,5,25,5);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'kwitansiPembayaranRincianBaruPdf',
            array(
              'modPendaftaran' => $modPendaftaran,
              'modRincian' => $modRincian,
              'data' => $data,
              'judulPrint' => $judulPrint
            ),
            true
          )
        );
        $mpdf->Output();
      }
    }
  }

  public function actionRincianKasir($idTandaBukti, $group = false)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/printWindows';
      $criteria = new CDbCriteria;
      if (!empty($idTandaBukti)) {
        $criteria->addCondition("t.tandabuktibayar_id = " . $idTandaBukti);
      }
      $obatalkespasien = ObatalkespasienT::model()->findByAttributes(array('pendaftaran_id' => $rincianpembayaran->pembayaran->pendaftaran_id,));
      $model = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
      //            $detailKwitansi=KwitansiKasirV::model()->findAllByAttributes(array('nobuktibayar_id' =>$nopend));
      $rincianTagihan = RinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $model->pembayaran->pendaftaran_id));
      $detailKwitansi = array();

      $judulKwitansi = '----- KWITANSI -----';
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $pembayarans = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));
      $criteria2 = new CDbCriteria();
      //            $criteria2->compare('pendaftaran_id',$model->pembayaran->pendaftaran_id);
      if (!empty($model->pembayaranpelayanan_id)) {
        $criteria2->addCondition("pembayaranpelayanan_id = " . $model->pembayaranpelayanan_id);
      }
      //            $criteria2->select = 'kelompoktindakan_id, kelompoktindakan_nama, ruangan_id, ruangan_nama, 
      //                    sum(jmlbiaya_tindakan) as jmlbiaya_tindakan, 
      //                    sum(jmlsubsidi_asuransi) as jmlsubsidi_asuransi, sum(jmlsubsidi_pemerintah) as jmlsubisi_pemerintah, 
      //                    sum(jmlsubsidi_rs) as jmlsubsidi_rs, sum(jmlsubsidi_asuransi) as jmlsubsidi_asuransijmliurbiaya, 
      //                    sum(jmlpembebasan) as jmlpembebasan, 
      //                    sum(jmlbayar_tindakan) as jmlbayar_tindakan, 
      //                    sum(jmlsisabayar_tindakan) as jmlsisabayar_tindakan, 
      //                    pembayaranpelayanan_id, pasien_id, pendaftaran_id, 
      //                    pasienadmisi_id, nopembayaran, tglpembayaran, carabayar_id, penjamin_id, 
      //                    totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, 
      //                    totalsubsidiasuransi,totalsubsidipemerintah,totalsubsidirs, 
      //                    totaliurbiaya, totalbayartindakan, totaldiscount, 
      //                    totalpembebasan, totalsisatagihan,
      //                    ruanganpelakhir_id';
      //            $criteria2->group = '
      //                        kelompoktindakan_id, kelompoktindakan_nama, ruangan_id, ruangan_nama, 
      //                        pembayaranpelayanan_id, 
      //                        pasien_id, pendaftaran_id, pasienadmisi_id, nopembayaran, 
      //                        tglpembayaran, carabayar_id, penjamin_id, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, 
      //                        totalsubsidiasuransi,totalsubsidipemerintah,totalsubsidirs, 
      //                        totaliurbiaya, totalbayartindakan, totaldiscount, 
      //                        totalpembebasan, totalsisatagihan,
      //                        ruanganpelakhir_id';

      $rincianpembayaran = TindakandanoasudahbayarV::model()->findAll($criteria2);
      $modBayar = PembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);
      $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria2);
      $oaSudahBayar = OasudahbayarT::model()->findAll($criteria2);
    }

    $judulLaporan = 'Rincian Pembayaran';
    $this->render('kwitansiPembayaranRincian', array(
      'model' => $model,
      'modBayar' => $modBayar,
      'group' => $group,
      'judulLaporan' => $judulLaporan,
      'detailKwitansi' => $detailKwitansi,
      'rincianTagihan' => $rincianTagihan,
      'rincianpembayaran' => $rincianpembayaran,
      'pembayarans' => $pembayarans,
      'judulKwitansi' => $judulKwitansi,
      'modPendaftaran' => $modPendaftaran,
      'obatalkespasien' => $obatalkespasien,
      'oaSudahBayar' => $oaSudahBayar,
    ));
  }

  public function actionBayarKasirApotek($idPenjualanResep, $idTandaBukti)
  {
    if (!empty($idTandaBukti) && !empty($idPenjualanResep)) {
      $this->layout = '//layouts/printWindows';
      $criteria = new CDbCriteria;
      if (!empty($idTandaBukti)) {
        $criteria->addCondition("t.tandabuktibayar_id = " . $idTandaBukti);
      }
      $modPenjualan = PenjualanresepT::model()->findByPk($idPenjualanResep);
      $model = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
      $modObatalkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $idPenjualanResep));
      $rincianTagihan = ObatalkespasienT::model()->findAllByAttributes(array(
        'pasien_id' => $model->pembayaran->pasien_id,
        'penjualanresep_id' => $idPenjualanResep
      ));
      $judulLaporan = 'Tanda Bukti Pembayaran Apotek';
      $this->render('kwitansiPembayaranApotek', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'rincianTagihan' => $rincianTagihan,
        'modObatalkes' => $modObatalkes,
        'modPenjualan' => $modPenjualan,
      ));
    }
  }
  /**
   * actionFakturKasirApotek digunakan untuk print faktur kasir apotek bebas / resep luar / pegawai / dokter / unit
   * @param type $idPenjualanResep
   * @param type $idTandaBukti
   */
  public function actionFakturKasirApotek($id, $idTandaBukti = null, $caraPrint = "PRINT")
  {
    $this->layout = '//layouts/iframe';
    $modPenjualan = PenjualanresepT::model()->findByPk($id);
    $daftar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modPenjualan->pendaftaran_id));
    $obatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $id));
    $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);
    $modPegawaiDokter = new PegawaikaryawanV();
    $modInstalasi = new InstalasiM();
    if (!empty($modPenjualan->pasienpegawai_id))
      $modPegawaiDokter = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id' => $modPenjualan->pasienpegawai_id));
    if (!empty($modPenjualan->pasieninstalasiunit_id))
      $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id' => $modPenjualan->pasieninstalasiunit_id));
    $criteria = new CDbCriteria;
    if (!empty($idTandaBukti)) {
      $criteria->addCondition("t.tandabuktibayar_id = " . $idTandaBukti);
    }
    $tandabukti = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
    $judulLaporan = 'Sale Invoice';
    //        $caraPrint=$_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }
    $this->render('fakturPembayaranApotek', array('modPenjualan' => $modPenjualan, 'daftar' => $daftar, 'pasien' => $pasien, 'modPegawaiDokter' => $modPegawaiDokter, 'modInstalasi' => $modInstalasi, 'obatAlkes' => $obatAlkes, 'tandabukti' => $tandabukti, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  }

  public function actionBayarReturPenjualanObat($idReturBayar, $idTandaBukti)
  {
    if (!empty($idTandaBukti) && !empty($idReturBayar)) {
      $this->layout = '//layouts/printWindows';

      $modReturPenjualan = ReturbayarpelayananT::model()->findByPk($idReturBayar);
      $modTandaBuktiKeluar = TandabuktikeluarT::model()->findByPk($idTandaBukti);
      $returresep = ReturresepT::model()->findByAttributes(array('returresep_id' => $modReturPenjualan->returresep_id));

      $judulLaporan = 'Tanda Bukti Pembayaran Retur Penjualan Obat';
      $this->render('kwitansiReturPenjualanObat', array(
        'modReturPenjualan' => $modReturPenjualan,
        'modTandaBuktiKeluar' => $modTandaBuktiKeluar, 'returresep' => $returresep,
      ));
    }
  }

  public function actionKuponGizi($idKirimMenuDiet)
  {
    $this->layout = '//layouts/printWindows';
    $modKirimMenuDiet = KirimmenudietT::model()->findByPk($idKirimMenuDiet);
    $modKirimMenuPasien = KirimmenupasienT::model()->findByAttributes(array('kirimmenudiet_id' => $idKirimMenuDiet));


    $criteria = new CDbCriteria();
    $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  kirimmenudiet_id';
    $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, kirimmenudiet_id';
    if (!empty($modKirimMenuDiet->kirimmenudiet_id)) {
      $criteria->addCondition("kirimmenudiet_id = " . $modKirimMenuDiet->kirimmenudiet_id);
    }
    $modDetailPesan = KirimmenupasienT::model()->findAll($criteria);

    $modMenuDiet = MenuDietM::model()->findByPk($modDetailPesan->menudiet_id);

    $modPendaftaran = PendaftaranT::model()->findByPk($modDetailPesan[0]->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judulLaporan = '';
    $this->render('kuponGizi', array(
      'modKirimMenuDiet' => $modKirimMenuDiet,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modDetailPesan' => $modDetailPesan,
      'modMenuDiet' => $modMenuDiet,
      'modKirimMenuPasien' => $modKirimMenuPasien,
    ));
  }

  public function actionPembatalanUangMuka($idTandaBukti, $caraPrint = null)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/printWindows';

      if (empty($caraPrint)) $this->layout = '//layouts/iframe';


      $criteria = new CDbCriteria;
      if (!empty($idTandaBukti)) {
        $criteria->addCondition("t.tandabuktikeluar_id = " . $idTandaBukti);
      }
      $model = TandabuktikeluarT::model()->find($criteria);

      $attributes = array(
        'tandabuktikeluar_id' => $model->tandabuktikeluar_id
      );
      $pembatalan = PembatalanuangmukaT::model()->findByAttributes($attributes);
      $uangmuka = BayaruangmukaT::model()->findByPk($pembatalan->bayaruangmuka_id);

      $criteria_dua = new CDbCriteria;
      if (!empty($pembatalan->tandabuktibayar_id)) {
        $criteria->addCondition("t.tandabuktibayar_id = " . $uangmuka->tandabuktibayar_id);
      }
      $model_tandabuktibayar = TandabuktibayarT::model()->find($criteria_dua);

      $judulPrint = "Tanda Bukti Pembatalan";
      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 25, 5);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'kwitansiPembatalan',
            array(
              'model' => $model,
              'tandabuktibayar' => $model_tandabuktibayar,
              'uangmuka' => $uangmuka
            ),
            true
          )
        );
        $mpdf->Output();
      }

      $this->render(
        'kwitansiPembatalan',
        array(
          'model' => $model,
          'tandabuktibayar' => $model_tandabuktibayar,
          'uangmuka' => $uangmuka,
          'pembatalan' => $pembatalan,
        )
      );

      // $judulLaporan = 'Tanda Bukti Pembatalan';
      // $this->render('kwitansiPembatalan',
      //     array(
      //         'model' => $model,
      //         'tandabuktibayar'=>$model_tandabuktibayar
      //     )
      // );

    }
  }

  public function actionReturnTagihan($idTandaBukti)
  {
    if (!empty($idTandaBukti)) {
      $this->layout = '//layouts/printWindows';

      $attributes = array(
        'returbayarpelayanan_id' => $idTandaBukti
      );
      $return = ReturbayarpelayananT::model()->findByAttributes($attributes);
      $model_tandabuktibayar = TandabuktibayarT::model()->with('pembayaran')->findByAttributes(array('tandabuktibayar_id' => $return->tandabuktibayar_id));
      $judulLaporan = 'Tanda Bukti Return Tagihan';
      $this->render(
        'kwitansiReturnTagihan',
        array(
          'model' => $return,
          'tandabuktibayar' => $model_tandabuktibayar
        )
      );
    }
  }
}
