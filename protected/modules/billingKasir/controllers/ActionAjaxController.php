<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends MyAuthController
{
  /**
   * ajax page to load pembayaran
   * digunakan di :
   * 1. Billing Kasir -> pembayaran -> index
   */
  public function actionLoadPembayaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan', 'tipepaket');
      $criteria->join .= "LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id ";
      $criteria->join .= "LEFT JOIN pasienbatalperiksa_r ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pasienbatalperiksa_r.pasienmasukpenunjang_id";
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('t.tindakansudahbayar_id IS NULL');
      $criteria->addCondition('pasienbatalperiksa_r.pasienbatalperiksa_id IS NULL'); //jangan tampilkan tindakan jika ada pembatalan pemeriksaan
      $modTindakan = BKTindakanPelayananT::model()->findAll($criteria);

      $criteriaoa = new CDbCriteria;
      if (!empty($pendaftaran_id)) {
        $criteriaoa->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      //                    $criteriaoa->addCondition('returresepdet_id is null'); //DICOMMENT UNTUK MENAMPILKAN OBAT YG DIRETUR SEBAGIAN QTY
      $criteriaoa->addCondition('oasudahbayar_id IS NULL');
      if (!$tindakanAktif) {
        if (isset($_POST['penjualanResep'])) {
          $idPenjualan = $_POST['penjualanResep'];
          if (!empty($idPenjualan)) {
            $criteriaoa->addCondition("penjualanresep_id = " . $idPenjualan);
          }
        } else
          $criteriaoa->addCondition('penjualanresep_id is not null');
      }
      $criteriaoa->order = 'penjualanresep_id';
      $modObatalkes = BKObatalkesPasienT::model()->with('daftartindakan')->findAll($criteriaoa);

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;

      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      if ($tindakanAktif) {
        foreach ($modTindakan as $j => $tindakan) {
          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      if ($tindakanAktif) {
        foreach ($modTindakan as $i => $tindakan) {
          $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          $tarifBebas = 0;
          foreach ($pembebasanTarif as $i => $pembebasan) {
            $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
          }
          $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
          $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
          $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
          $totDiscount_tindakan += $discountTindakan;

          $subsidi = $this->cekSubsidi($tindakan);
          $tarifSatuan = $tindakan->tarif_satuan;
          $qtyTindakan = $tindakan->qty_tindakan;
          $totQty = $totQty + $qtyTindakan;
          $tarifTindakan = $tindakan->tarif_tindakan;
          $totTarif = $totTarif + $tarifTindakan;
          $tarifCyto = $tindakan->tarifcyto_tindakan;
          $totCyto = $totCyto + $tarifCyto;
          if (!empty($subsidi['max'])) {
            $subsidiAsuransi = round($tarifTindakan / $totalPembagi * $subsidi['max']);
            $subsidiPemerintah = 0;
            $subsidiRumahSakit = 0;

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto));
            $totIur = $totIur + $iurBiaya;
            $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
            $subTotal = ($subTotal > 0) ? $subTotal : 0;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          } else {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
            $totIur = $totIur + $iurBiaya;
            $subTotal = $iurBiaya * $qtyTindakan;
            $subTotal -= $discountTindakan;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          }

          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totCytoOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = round($oaHargasatuan / $totalPembagi * $subsidiOa['max']);
          $oaSubsidipemerintah = 0;
          $oaSubsidirs = 0;

          $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi;
          $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah;
          $totSubRsOa = $totSubRsOa + $oaSubsidirs;
          $oaIurbiaya = round(($oaHargasatuan + $oaCyto));
          $obatAlkes->iurbiaya = $oaIurbiaya;
          $totIurOa = $totIurOa + $oaIurbiaya;
          $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) - $oaSubsidiasuransi - $discount_oa;
          $subTotalOa = ($subTotalOa > 0) ? $subTotalOa : 0;
          $totalbayarOa = $totalbayarOa + $subTotalOa;
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];

          $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi;
          $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah;
          $totSubRsOa = $totSubRsOa + $oaSubsidirs;
          //                              $oaIurbiaya = round(($oaHargasatuan + $oaCyto) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); // tanpa tarif cyto
          $oaIurbiaya = round(($oaHargasatuan) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); // tanpa tarif cyto
          $obatAlkes->iurbiaya = $oaIurbiaya;
          $totIurOa = $totIurOa + $oaIurbiaya;
          //                              $subTotalOa = $oaIurbiaya * $obatAlkes->qty_oa; // tanpa cyto
          $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) + $oaCyto - $discount_oa;
          $totalbayarOa = $totalbayarOa + $subTotalOa;
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');

      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;

      $totDeposit = 0;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      if ($tindakanAktif) {
        $returnVal['formBayarTindakan'] = $this->renderPartial(
          '_loadPembayaranTindakan',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modObatalkes' => $modObatalkes,
            'modTandaBukti' => $modTandaBukti,
            'tottagihan' => $totTagihan,
            //'totalbayartind'=>$totalbayartindakan,
            'totpembebasan' => $totPembebasanTarif,
            'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
            'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
            'totalPembagi' => $totalPembagi
          ),
          true
        );
      }
      $returnVal['formBayarOa'] = $this->renderPartial(
        '_loadPembayaranOa',
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi
        ),
        true
      );

      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : '';
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadPembayaranRetur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPembayaran = $_POST['idPembayaran'];
      $modPembayaran = PembayaranpelayananT::model()->findByPk($idPembayaran);
      $modTandaBukti = TandabuktibayarT::model()->findByPk($modPembayaran->tandabuktibayar_id);

      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : '';
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : '';


      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function proporsiSubsidi($subtotal, $total, $tagihan, $jmlbayar, $maxsubsidi)
  {
  }

  protected function cekSubsidi($modTindakan)
  {
    $subsidi = array();
    $subsidi['asuransi'] = $modTindakan->getSubsidiPenjamin('subsidiasuransitind');
    $subsidi['pemerintah'] = $modTindakan->getSubsidiPenjamin('subsidipemerintahtind');
    $subsidi['rumahsakit'] = $modTindakan->getSubsidiPenjamin('subsidirumahsakittind');
    $subsidi['iurbiaya'] = $modTindakan->tarif_tindakan - ($subsidi['asuransi'] + $subsidi['pemerintah'] + $subsidi['rumahsakit']);

    return $subsidi;
  }

  protected function cekSubsidiOa($modObatAlkesPasien)
  {
    $subsidi = array();

    $subsidi['asuransi'] = $modObatAlkesPasien->getSubsidiPenjamin('subsidiasuransioa', true);
    $subsidi['pemerintah'] = $modObatAlkesPasien->getSubsidiPenjamin('subsidipemerintahoa', true);
    $subsidi['rumahsakit'] = $modObatAlkesPasien->getSubsidiPenjamin('subsidirumahsakitoa', true);
    $subsidi['iurbiaya'] = $modObatAlkesPasien->hargajual_oa - ($subsidi['asuransi'] + $subsidi['pemerintah'] + $subsidi['rumahsakit']);


    return $subsidi;
  }

  public function actionCekHakRetur()
  {
    if (!Yii::app()->user->checkAccess('Retur')) {
      //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
      $data['cekAkses'] = false;
    } else {
      //echo 'punya hak akses';
      $data['cekAkses'] = true;
      $data['userid'] = Yii::app()->user->id;
      $data['username'] = Yii::app()->user->name;
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  /**
   * ajax page to load pembayaran
   * digunakan di :
   * 1. Billing Kasir -> pembayaran -> index
   */
  public function actionLoadPembayaranUangMuka()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $criteria = new CDbCriteria;
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('tindakansudahbayar_id IS NULL');
      $modTindakan = BKTindakanPelayananT::model()->with('daftartindakan', 'tipepaket')->findAll($criteria);

      $criteriaoa = new CDbCriteria;
      if (!empty($pendaftaran_id)) {
        $criteriaoa->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      $criteriaoa->addCondition('returresepdet_id is null');
      $criteriaoa->addCondition('oasudahbayar_id IS NULL');
      $criteriaoa->addCondition('penjualanresep_id is not null');
      $criteriaoa->order = 'penjualanresep_id';
      $modObatalkes = BKObatalkesPasienT::model()->with('daftartindakan')->findAll($criteriaoa);

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;

      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      foreach ($modTindakan as $j => $tindakan) {
        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      //                    if ($tindakanAktif){
      foreach ($modTindakan as $i => $tindakan) {
        $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
        $tarifBebas = 0;
        foreach ($pembebasanTarif as $i => $pembebasan) {
          $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
        }
        $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
        $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
        $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
        $totDiscount_tindakan += $discountTindakan;

        $subsidi = $this->cekSubsidi($tindakan);
        $tarifSatuan = $tindakan->tarif_satuan;
        $qtyTindakan = $tindakan->qty_tindakan;
        $totQty = $totQty + $qtyTindakan;
        $tarifTindakan = $tindakan->tarif_tindakan;
        $totTarif = $totTarif + $tarifTindakan;
        $tarifCyto = $tindakan->tarifcyto_tindakan;
        $totCyto = $totCyto + $tarifCyto;
        if (!empty($subsidi['max'])) {
          $subsidiAsuransi = round($tarifTindakan / $totalPembagi * $subsidi['max']);
          $subsidiPemerintah = 0;
          $subsidiRumahSakit = 0;

          $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
          $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
          $totSubRs = $totSubRs + $subsidiRumahSakit;
          $iurBiaya = round(($tarifSatuan + $tarifCyto));
          $totIur = $totIur + $iurBiaya;
          $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
          $subTotal = ($subTotal > 0) ? $subTotal : 0;
          $totalbayartindakan = $totalbayartindakan + $subTotal;
        } else {
          $subsidiAsuransi = $subsidi['asuransi'];
          $subsidiPemerintah = $subsidi['pemerintah'];
          $subsidiRumahSakit = $subsidi['rumahsakit'];

          $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
          $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
          $totSubRs = $totSubRs + $subsidiRumahSakit;
          $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
          $totIur = $totIur + $iurBiaya;
          $subTotal = $iurBiaya * $qtyTindakan;
          $subTotal -= $discountTindakan;
          $totalbayartindakan = $totalbayartindakan + $subTotal;
        }

        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }
      //                    }

      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totCytoOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      $totDeposit = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = round($oaHargasatuan / $totalPembagi * $subsidiOa['max']);
          $oaSubsidipemerintah = 0;
          $oaSubsidirs = 0;

          $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi;
          $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah;
          $totSubRsOa = $totSubRsOa + $oaSubsidirs;
          $oaIurbiaya = round(($oaHargasatuan + $oaCyto));
          $obatAlkes->iurbiaya = $oaIurbiaya;
          $totIurOa = $totIurOa + $oaIurbiaya;
          $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) - $oaSubsidiasuransi - $discount_oa;
          $subTotalOa = ($subTotalOa > 0) ? $subTotalOa : 0;
          $totalbayarOa = $totalbayarOa + $subTotalOa;
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];

          $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi;
          $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah;
          $totSubRsOa = $totSubRsOa + $oaSubsidirs;
          //                              $oaIurbiaya = round(($oaHargasatuan + $oaCyto) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); // tanpa tarif cyto
          $oaIurbiaya = round(($oaHargasatuan) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); // tanpa tarif cyto
          $obatAlkes->iurbiaya = $oaIurbiaya;
          $totIurOa = $totIurOa + $oaIurbiaya;
          //                              $subTotalOa = $oaIurbiaya * $obatAlkes->qty_oa; // tanpa cyto
          $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) + $oaCyto - $discount_oa;
          $totalbayarOa = $totalbayarOa + $subTotalOa;
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
      //                    echo $totalbayartindakan.' '.$totalbayarOa;
      //                    exit();
      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      //                    if ($tindakanAktif){
      $returnVal['formBayarTindakan'] = $this->renderPartial(
        '_loadPembayaranUangMuka',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayartind'=>$totalbayartindakan,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi
        ),
        true
      );
      //                    }
      $returnVal['formBayarOa'] = $this->renderPartial(
        '_loadPembayaranOa',
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi
        ),
        true
      );

      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : "";
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;


      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk :
   * - Transaksi Pembayaran Jasa
   */
  public function actionAddDetailPembayaranJasa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $komponentarifIds = null;

      $pegawaiId = $_POST['pegawai_id'];
      $rujukandariId = $_POST['rujukandari_id'];
      $komponentarifIds = $_POST['komponentarifId'];
      $data =  array();
      $tr =  "";
      $jasaPerujuk[] = 0;
      $jasaDokter[] = 0;
      $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']) . " 00:00:00";
      $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']) . " 23:59:59";

      if (!empty($rujukandariId)) {
        $criteria = new CdbCriteria();
        $criteria->addBetweenCondition('tglmasukpenunjang', $tgl_awal, $tgl_akhir);
        $criteria->addCondition('rujukandari_id = ' . $rujukandariId);
        $criteria->group = "pasienmasukpenunjang_id, tglmasukpenunjang, rujukandari_id, pendaftaran_id, no_pendaftaran, no_rekam_medik, no_masukpenunjang, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
        $criteria->select = $criteria->group;
        $criteria->order = 'tglmasukpenunjang';
        $dataDetails = BKPasienrujukanluardokterV::model()->findAll($criteria);
        $criteria1 = $criteria;
        $criteria1->group .= ', daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tarif_tindakan';
        $criteria1->select = $criteria1->group;
        $dataTindakans = BKPasienrujukanluardokterV::model()->findAll($criteria1);
        $criteria2 = $criteria;
        $criteria2->select .= ", komponentarif_id, SUM(tarif_tindakankomp) AS tarif_tindakankomp";
        $criteria2->group .= ", komponentarif_id";
        $criteria2->addInCondition('komponentarif_id', $komponentarifIds);
        $dataKomponen = BKPasienrujukanluardokterV::model()->findAll($criteria2);
        foreach ($dataDetails as $i => $dataDetail) {
          //hitung tarif_tindakankomp per pasienmasukpenunjang_id
          foreach ($dataKomponen as $j => $dataKom) {
            if ($dataDetail->pasienmasukpenunjang_id == $dataKom->pasienmasukpenunjang_id)
              $dataDetail->tarif_tindakankomp += $dataKom->tarif_tindakankomp;
          }
          //hitung tarif_tindakan per pasienmasukpenunjang_id
          foreach ($dataTindakans as $k => $tindakan) {
            if ($dataDetail->pasienmasukpenunjang_id == $tindakan->pasienmasukpenunjang_id)
              $dataDetail->tarif_tindakan += $tindakan->tarif_tindakan;
          }
        }
      } else if (!empty($pegawaiId)) {
        $criteria = new CdbCriteria();
        $criteria->addBetweenCondition('tgl_pendaftaran', $tgl_awal, $tgl_akhir);
        $criteria->addCondition('pegawai_id = ' . $pegawaiId);
        $criteria->group = "pendaftaran_id, tgl_pendaftaran, pegawai_id, no_pendaftaran, no_rekam_medik, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
        $criteria->select = $criteria->group;
        $criteria->order = 'tgl_pendaftaran';
        $dataDetails = BKPasienpelayanandokterrsV::model()->findAll($criteria);
        $criteria1 = $criteria;
        $criteria1->group .= ', daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tarif_tindakan';
        $criteria1->select = $criteria1->group;
        $dataTindakans = BKPasienpelayanandokterrsV::model()->findAll($criteria1);
        $criteria2 = $criteria;
        $criteria2->select .= ", komponentarif_id, SUM(tarif_tindakankomp) AS tarif_tindakankomp";
        $criteria2->group .= ", komponentarif_id";
        $criteria2->addInCondition('komponentarif_id', $komponentarifIds);
        $dataKomponen = BKPasienpelayanandokterrsV::model()->findAll($criteria2);
        foreach ($dataDetails as $i => $dataDetail) {
          //hitung tarif_tindakankomp per pendaftaran_id
          foreach ($dataKomponen as $j => $dataKom) {
            if ($dataDetail->pendaftaran_id == $dataKom->pendaftaran_id)
              $dataDetail->tarif_tindakankomp += $dataKom->tarif_tindakankomp;
          }
          //hitung tarif_tindakan per pendaftaran_id
          foreach ($dataTindakans as $k => $tindakan) {
            if ($dataDetail->pendaftaran_id == $tindakan->pendaftaran_id)
              $dataDetail->tarif_tindakan += $tindakan->tarif_tindakan;
          }
        }
      }

      if (count((array)$dataDetails) > 0) {
        foreach ($dataDetails as $i => $detail) {
          $modDetails = new BKPembjasadetailT;
          $modDetails->attributes = $detail->attributes;
          if ($detail->tarif_tindakankomp != 0)
            $modDetails->jumahtarif = $detail->tarif_tindakan;
          else
            $modDetails->jumahtarif = 0;
          $modDetails->jumlahjasa = $detail->tarif_tindakankomp;
          $modDetails->jumlahbayar = $modDetails->jumlahjasa;
          $modDetails->sisajasa = 0;
          $modDetails->pilihDetail = true;
          $tr .= "<tr>";
          $tr .= "<td>" . ($i + 1) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pendaftaran_id', array('value' => $detail->pendaftaran_id)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pembayaranjasa_id', array('value' => null)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pasien_id', array('value' => $detail->pasien_id));
          CHtml::activeHiddenField($modDetails, '[' . $i . ']penjaminId', array('value' => $detail->penjamin_id));
          //tidak ada pasienadmisi_id >> CHtml::activeHiddenField($modDetails,'['.$i.']pasienadmisi_id',array('value'=>$detail->pasienadmisi_id));
          if (!empty($rujukandariId)) {
            $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']pasienmasukpenunjang_id', array('value' => $detail->pasienmasukpenunjang_id));
          }
          $tr .= "</td>";
          $tr .= "<td>" . $detail->no_rekam_medik . "<br>" . $detail->no_pendaftaran . "</td>";
          if (!empty($rujukandariId)) {
            $tr .= "<td>" . $detail->no_masukpenunjang . "</td>";
          } else {
            $tr .= "<td><center>-</center></td>";
          }
          $tr .= "<td>" . $detail->nama_pasien . "</td>";
          $tr .= "<td>" . $detail->alamat_pasien . "</td>";
          $tr .= "<td>" . $detail->penjamin_nama . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumahtarif', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);")) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahjasa', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahbayar', array('readonly' => false, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']sisajasa', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);")) . "</td>";
          $tr .= "<td>" . CHtml::activeCheckBox($modDetails, '[' . $i . ']pilihDetail', array('onclick' => 'checkIni(this);')) . "</td>";
          $tr .= "</tr>";
        }
      }
      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBatalBayar()
  {

    if (Yii::app()->request->isAjaxRequest) {

      $tandabuktibayar_id = (isset($_POST['idTandabuktibayar']) ? $_POST['idTandabuktibayar'] : null);
      $pembayaranpelayanan_id = (isset($_POST['idPembayaranpelayanan']) ? $_POST['idPembayaranpelayanan'] : null);

      $modTandaBuktiBayar = TandabuktibayarT::model()->findByPk($tandabuktibayar_id);
      $modBayarAngsuranPelayananT = BayarangsuranpelayananT::model()->findByAttributes(array('tandabuktibayar_id' => $tandabuktibayar_id));

      $barisBayar = count((array)$modBayarAngsuranPelayananT);
      $closing = (isset($modTandaBuktiBayar->closingkasir_id) ? $modTandaBuktiBayar->closingkasir_id : null);

      $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
      $pasienadmisi_id = isset($modPasienAdmisi->pasienadmisi_id) ? $modPasienAdmisi->pasienadmisi_id : null;

      $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

      $modTindakanSudahBayar = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
      // if (count((array)$modTindakanSudahBayar)>0){
      //   $modTindakanpelayanan = TindakanpelayananT::model()->findByAttributes(array('tindakansudahbayar_id'=>$modTindakanSudahBayar->tindakansudahbayar_id));
      //   $idTindakanpelayanan = $modTindakanpelayanan->tindakanpelayanan_id;
      // }

      $modOA = OasudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
      // if (count((array)$modOA)>0){
      //   $modObatalkespasien = ObatalkespasienT::model()->findByAttributes(array('oasudahbayar_id'=>$modOA->oasudahbayar_id));
      //   $idObatalkespasien = $modObatalkespasien->obatalkespasien_id;
      // }
      // print_r(count((array)$modObatalkespasien));
      // exit();
      $null = null;

      if (empty($closing) && $barisBayar == 0) {

        TandabuktibayarT::model()->updateByPk($tandabuktibayar_id, array('pembayaranpelayanan_id' => null));
        TandabuktibayarT::model()->deleteByPk($tandabuktibayar_id);


        if (count((array)$modOA) > 0) {
          foreach ($modOA as $i => $modOASudahBayar) {
            $modObatalkespasien = ObatalkespasienT::model()->findByAttributes(array('oasudahbayar_id' => $modOASudahBayar->oasudahbayar_id));
            $idObatalkespasien = $modObatalkespasien->obatalkespasien_id;
            ObatalkespasienT::model()->updateByPk($idObatalkespasien, array('oasudahbayar_id' => $null));
          }
        }

        OasudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));


        if (count((array)$modTindakanSudahBayar) > 0) {
          foreach ($modTindakanSudahBayar as $j => $modTindakans) {
            $modTindakanpelayanan = TindakanpelayananT::model()->findByAttributes(array('tindakansudahbayar_id' => $modTindakans->tindakansudahbayar_id));
            $idTindakanpelayanan = (isset($modTindakanpelayanan->tindakanpelayanan_id) ? $modTindakanpelayanan->tindakanpelayanan_id : null);

            TindakanpelayananT::model()->updateByPk($idTindakanpelayanan, array('tindakansudahbayar_id' => $null, 'subsidiasuransi_tindakan' => 0, 'subsidipemerintah_tindakan' => 0, 'subsisidirumahsakit_tindakan' => 0, 'iurbiaya_tindakan' => 0));
          }
        }

        TindakansudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

        PemakaianuangmukaT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));


        PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('pembayaranpelayanan_id' => $null));
        if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ) { //khusus untuk RJ saja Status periksa = sedang periksa
          PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => $null));
        } else {
          PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => $null));
        }
        PembayaranpelayananT::model()->deleteAllByAttributes(array('tandabuktibayar_id' => $tandabuktibayar_id));
        $returnVal['hasil'] = 'BERHASIL';
      } else {
        $returnVal['hasil'] = 'GAGAL';
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /*
  Digunakan pada menu
  - Verifikasi Tagihan
  */
  public function actionLoadPembayaranVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $totDeposit = 0;
      $is_batal = $_POST['is_batal'] ?? 0;
      $instalasi_id = $_POST['instalasi_id'] ?? null;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAdmisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      $returnVal = array();


      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan', 'tipepaket');
      $criteria->join .= "LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id ";
      $criteria->join .= "LEFT JOIN pasienbatalperiksa_r ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pasienbatalperiksa_r.pasienmasukpenunjang_id";
      $criteria->join .= " left join pasienmasukpenunjang_t p on p.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id 
      left join pasienkirimkeunitlain_t u on u.pasienkirimkeunitlain_id = p.pasienkirimkeunitlain_id";
      //$criteria->join .= ""
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('t.tindakansudahbayar_id IS NULL');

      $criteria->addCondition('t.penjualanresep_id IS NULL');

      // $criteria->addCondition('t.verifrenctindakan_id IS NOT NULL');
      if ($is_batal == 1) {
        $criteria->addCondition('t.verifrenctindakan_id IS not NULL');
        $criteria->addCondition('t.verifikasitagihan_id IS not NULL');
      } else {
        $criteria->addCondition('t.verifikasitagihan_id IS NULL');
        $criteria->addCondition('t.verifrenctindakan_id IS NULL');
      }
      $criteria->addCondition('pasienbatalperiksa_r.pasienbatalperiksa_id IS NULL'); //jangan tampilkan tindakan jika ada pembatalan pemeriksaan
      $criteria->order = 't.nopelayanan';

      if ($instalasi_id == Params::INSTALASI_ID_RI) {
        // $criteria->addCondition('t.pasienadmisi_id is not null or (u.pasienkirimkeunitlain_id is not null and u.pasienadmisi_id is not null)');
      
        if ($is_batal != 1) {
          $criteria->addCondition("(t.masukkamar_id is null and t.isapprovaltindaklanjut = true) or (t.masukkamar_id is not null and t.nopelayanan is not null)");
        }
      
      } else {
        $criteria->addCondition('(t.pasienadmisi_id is not null or (u.pasienkirimkeunitlain_id is not null and u.pasienadmisi_id is not null)) = false');
      }
      if ($instalasi_id == Params::INSTALASI_ID_RD && $is_batal != 1)  {
        $criteria->addCondition('(t.masukkamar_id is null and t.isapprovaltindaklanjut = true) or (t.masukkamar_id is not null and t.nopelayanan is not null)');
      }

      // var_dump($criteria); die;

      $modTindakan = BKTindakanPelayananT::model()->findAll($criteria);

      $criteriaoa = new CDbCriteria;
      if (!empty($pendaftaran_id)) {
        $criteriaoa->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }

      // $criteriaoa->addCondition('returresepdet_id is null'); //DICOMMENT UNTUK MENAMPILKAN OBAT YG DIRETUR SEBAGIAN QTY
      
      if ($is_batal == 1) {
        $criteriaoa->addCondition('t.verifikasitagihan_id IS not NULL');
      } else {
        $criteriaoa->addCondition('t.verifikasitagihan_id IS NULL');
      }
      $criteriaoa->addCondition('t.oasudahbayar_id IS NULL');
      if (!$tindakanAktif) {
        if (isset($_POST['penjualanResep'])) {
          $idPenjualan = $_POST['penjualanResep'];
          if (!empty($idPenjualan)) {
            $criteriaoa->addCondition("t.penjualanresep_id = " . $idPenjualan);
          }
        } // else
        // $criteriaoa->addCondition('penjualanresep_id is not null');
      }
      $criteriaoa->join = 'left join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id '
        . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';
      $criteriaoa->addCondition('penjualanresep_id is not null');

      $criteriaoa->order = 'o.obatalkes_nama';

      if ($instalasi_id == Params::INSTALASI_ID_RI) {
        // $criteriaoa->addCondition('t.pasienadmisi_id is not null');
        if ($is_batal != 1) {
          $criteria->addCondition("t.isapprovaltindaklanjut = true");
        }
      } else {
        $criteriaoa->addCondition('t.pasienadmisi_id is null');
      }
      
      if ($instalasi_id == Params::INSTALASI_ID_RD && $is_batal != 1)  {
        $criteriaoa->addCondition('t.isapprovaltindaklanjut = true');
      }

      // var_dump($instalasi_id, $criteriaoa); die;
      
      $modObatalkes = BKObatalkesPasienT::model()->findAll($criteriaoa);

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;


      // $modObatalkes = $this->groupingOAVerifikasi($modObatalkes);


      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      // if ($tindakanAktif){
      foreach ($modTindakan as $j => $tindakan) {
        //  $modTindakan->penjamin_id = 
        if (!empty($modAdmisi)) {
          $modTindakan[$j]->carabayar_id = $modAdmisi->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modAdmisi->penjamin_id;
        } else {
          $modTindakan[$j]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modPendaftaran->penjamin_id;
        }
        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }
      // }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;

      // echo '<pre>'; var_dump(count($modTindakan)); die;

      if ($tindakanAktif) {
        foreach ($modTindakan as $i => $tindakan) {
          $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          $tarifBebas = 0;
          foreach ($pembebasanTarif as $i => $pembebasan) {
            $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
          }
          $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
          $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
          $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
          $totDiscount_tindakan += $discountTindakan;

          $subsidi = $this->cekSubsidi($tindakan);
          $tarifSatuan = $tindakan->tarif_satuan;
          $qtyTindakan = $tindakan->qty_tindakan;
          $totQty = $totQty + $qtyTindakan;
          $tarifTindakan = $tindakan->tarif_tindakan;
          $totTarif = $totTarif + $tarifTindakan;
          $tarifCyto = $tindakan->tarifcyto_tindakan;
          $totCyto = $totCyto + $tarifCyto;
          if (!empty($subsidi['max'])) {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto));
            $totIur = $totIur + $iurBiaya;
            $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
            $subTotal = ($subTotal > 0) ? $subTotal : 0;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          } else {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
            $totIur = $totIur + $iurBiaya;
            $subTotal = $iurBiaya * $qtyTindakan;
            $subTotal -= $discountTindakan;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          }

          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');

      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      if ($tindakanAktif) {

        $load_tin = '_loadPembayaranTindakanVerifikasi';
        $load_oa = '_loadPembayaranOaVerifikasi';

        if(isset($_GET['is_verif'])) {
          $load_oa = '_loadPembayaranOaVerifikasiV';
        }

        if($is_batal == 1) {
          $load_tin = '_loadPembayaranTindakanVerifikasiBatal';
          $load_oa = '_loadPembayaranOaVerifikasiBatal';
        }
        
        $returnVal['formBayarTindakan'] = $this->renderPartial(
          $load_tin,
          array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modObatalkes' => $modObatalkes,
            'modTandaBukti' => $modTandaBukti,
            'tottagihan' => $totTagihan,
            //'totalbayartind'=>$totalbayartindakan,
            'totpembebasan' => $totPembebasanTarif,
            'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
            'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
            'totalPembagi' => $totalPembagi,
            'is_batal' => $is_batal,
            'instalasi_id' => $instalasi_id,
          ),
          true
        );
      }
      $returnVal['formBayarOa'] = $this->renderPartial(
        $load_oa,
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi,
          'is_batal' => $is_batal,
          'instalasi_id' => $instalasi_id,
        ),
        true
      );


      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : 0;
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;
      $returnVal['persen_admin'] = $modPenjamin->biaya_administrasi;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  /*
  Digunakan pada menu
  - Batal Verifikasi Tagihan
  */
  public function actionLoadPembayaranBatalVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $totDeposit = 0;
      $is_batal = $_POST['is_batal'] ?? 0;
      $instalasi_id = $_POST['instalasi_id'] ?? null;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAdmisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      $returnVal = array();


      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan', 'tipepaket');
      $criteria->join .= "LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id ";
      $criteria->join .= "LEFT JOIN pasienbatalperiksa_r ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pasienbatalperiksa_r.pasienmasukpenunjang_id ";
      $criteria->join .= "left join alokasidanadetailtindakan_t alot on alot.tindakanpelayanan_id = t.tindakanpelayanan_id and alot.orderbatalalokasi_id is null ";
      $criteria->join .= " left join pasienmasukpenunjang_t p on p.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id 
      left join pasienkirimkeunitlain_t u on u.pasienkirimkeunitlain_id = p.pasienkirimkeunitlain_id";
      //$criteria->join .= ""
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('t.tindakansudahbayar_id IS NULL');
      $criteria->addCondition('t.alokasidanadetailtindakan_id is null');

      

      // $criteria->addCondition('t.verifrenctindakan_id IS NOT NULL');
      if ($is_batal == 1) {
        $criteria->addCondition('t.verifrenctindakan_id IS not NULL');
        $criteria->addCondition('t.verifikasitagihan_id IS not NULL');
      } else {
        $criteria->addCondition('t.verifikasitagihan_id IS NULL');
        $criteria->addCondition('t.verifrenctindakan_id IS NULL');
      }
      $criteria->addCondition('pasienbatalperiksa_r.pasienbatalperiksa_id IS NULL'); //jangan tampilkan tindakan jika ada pembatalan pemeriksaan
      $criteria->addCondition('alot.tindakanpelayanan_id is null');
      $criteria->order = 't.nopelayanan';

      /*
      if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $criteria->addCondition('t.pasienadmisi_id is not null or (u.pasienkirimkeunitlain_id is not null and u.pasienadmisi_id is not null)');
      } else {
        $criteria->addCondition('(t.pasienadmisi_id is not null or (u.pasienkirimkeunitlain_id is not null and u.pasienadmisi_id is not null)) = false');
      }
      if ($instalasi_id == Params::INSTALASI_ID_RD && $is_batal != 1)  {
        $criteria->addCondition('t.isapprovaltindaklanjut = true');
      }
      */

      // var_dump($criteria); die;

      $criteriaOa = clone $criteria;
      $criteria->addCondition('t.penjualanresep_id IS NULL');


      $modTindakan = BKTindakanPelayananT::model()->findAll($criteria);


      $criteriaOa->addCondition('t.penjualanresep_id IS NOT NULL');

      $modTindakanOA = BKTindakanPelayananT::model()->findAll($criteriaOa);


      $criteriaoa = new CDbCriteria;
      if (!empty($pendaftaran_id)) {
        $criteriaoa->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }

      // $criteriaoa->addCondition('returresepdet_id is null'); //DICOMMENT UNTUK MENAMPILKAN OBAT YG DIRETUR SEBAGIAN QTY
      
      if ($is_batal == 1) {
        $criteriaoa->addCondition('t.verifikasitagihan_id IS not NULL');
      } else {
        $criteriaoa->addCondition('t.verifikasitagihan_id IS NULL');
      }
      $criteriaoa->addCondition('t.oasudahbayar_id IS NULL');
      if (!$tindakanAktif) {
        if (isset($_POST['penjualanResep'])) {
          $idPenjualan = $_POST['penjualanResep'];
          if (!empty($idPenjualan)) {
            $criteriaoa->addCondition("t.penjualanresep_id = " . $idPenjualan);
          }
        } // else
        // $criteriaoa->addCondition('penjualanresep_id is not null');
      }
      $criteriaoa->join = 'left join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id '
        . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';
      $criteriaoa->addCondition('penjualanresep_id is not null');

      $criteriaoa->order = 'o.obatalkes_nama';

      /*
      if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $criteriaoa->addCondition('t.pasienadmisi_id is not null');
      } else {
        $criteriaoa->addCondition('t.pasienadmisi_id is null');
      }
      */
      
      if ($instalasi_id == Params::INSTALASI_ID_RD && $is_batal != 1)  {
        $criteriaoa->addCondition('t.isapprovaltindaklanjut = true');
      }

      // var_dump($instalasi_id, $criteriaoa); die;
      
      $modObatalkes = BKObatalkesPasienT::model()->findAll($criteriaoa);

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;


      // $modObatalkes = $this->groupingOAVerifikasi($modObatalkes);


      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      // if ($tindakanAktif){
      foreach ($modTindakan as $j => $tindakan) {
        //  $modTindakan->penjamin_id = 
        if (!empty($modAdmisi)) {
          $modTindakan[$j]->carabayar_id = $modAdmisi->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modAdmisi->penjamin_id;
        } else {
          $modTindakan[$j]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modPendaftaran->penjamin_id;
        }
        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }
      foreach ($modTindakanOA as $j => $tindakan) {
        //  $modTindakan->penjamin_id = 
        if (!empty($modAdmisi)) {
          $modTindakan[$j]->carabayar_id = $modAdmisi->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modAdmisi->penjamin_id;
        } else {
          $modTindakan[$j]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modPendaftaran->penjamin_id;
        }
        $totHargaSatuanObat = $totHargaSatuanObat + $tindakan->tarif_tindakan;
      }
      // }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;

      // echo '<pre>'; var_dump(count($modTindakan)); die;

      if ($tindakanAktif) {
        foreach ($modTindakan as $i => $tindakan) {
          $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          $tarifBebas = 0;
          foreach ($pembebasanTarif as $i => $pembebasan) {
            $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
          }
          $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
          $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
          $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
          $totDiscount_tindakan += $discountTindakan;

          $subsidi = $this->cekSubsidi($tindakan);
          $tarifSatuan = $tindakan->tarif_satuan;
          $qtyTindakan = $tindakan->qty_tindakan;
          $totQty = $totQty + $qtyTindakan;
          $tarifTindakan = $tindakan->tarif_tindakan;
          $totTarif = $totTarif + $tarifTindakan;
          $tarifCyto = $tindakan->tarifcyto_tindakan;
          $totCyto = $totCyto + $tarifCyto;
          if (!empty($subsidi['max'])) {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto));
            $totIur = $totIur + $iurBiaya;
            $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
            $subTotal = ($subTotal > 0) ? $subTotal : 0;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          } else {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
            $totIur = $totIur + $iurBiaya;
            $subTotal = $iurBiaya * $qtyTindakan;
            $subTotal -= $discountTindakan;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          }

          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      /*
      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      */

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');

      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      

      $load_tin = '_loadPembayaranTindakanVerifikasiBatal';
      $load_oa = '_loadPembayaranTindakanVerifikasiBatal';

      if ($tindakanAktif) {


        $returnVal['formBayarTindakan'] = $this->renderPartial(
          $load_tin,
          array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modObatalkes' => $modObatalkes,
            'modTandaBukti' => $modTandaBukti,
            'tottagihan' => $totTagihan,
            //'totalbayartind'=>$totalbayartindakan,
            'totpembebasan' => $totPembebasanTarif,
            'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
            'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
            'totalPembagi' => $totalPembagi,
            'is_batal' => $is_batal,
            'instalasi_id' => $instalasi_id,
          ),
          true
        );
      }

      $returnVal['formBayarOa'] = $this->renderPartial(
        $load_oa,
        array(
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakanOA,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayartind'=>$totalbayartindakan,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi,
          'is_batal' => $is_batal,
          'instalasi_id' => $instalasi_id,
        ),
        true
      );

      /*
      $returnVal['formBayarOa'] = $this->renderPartial(
        $load_oa,
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi,
          'is_batal' => $is_batal,
          'instalasi_id' => $instalasi_id,
        ),
        true
      );
      */


      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : 0;
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;
      $returnVal['persen_admin'] = $modPenjamin->biaya_administrasi;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadPembayaranVerifikasiTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $totDeposit = 0;
      $is_batal = $_POST['is_batal'] ?? 0;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAdmisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      $returnVal = array();

      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan', 'tipepaket');
      $criteria->join .= "LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id ";
      $criteria->join .= "LEFT JOIN pasienbatalperiksa_r ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pasienbatalperiksa_r.pasienmasukpenunjang_id";
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('t.tindakansudahbayar_id IS NULL');

      if ($is_batal == 1) {
        $criteria->addCondition('t.verifrenctindakan_id IS NULL');
      }
    
      $criteria->addCondition('t.verifbataltindakan_id IS NULL');


      if(isset($_POST['nonota']) && $_POST['nonota'] != '') {
        if(strlen($_POST['nonota']) <= 3) {
          $nopelayanan = $_POST['nonota'];
          if(preg_match('/[a-zA-Z]/', $nopelayanan)) {
            $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id); 
          } else {
            $criteria->compare('LOWER(t.nopelayanan)', strtolower($nopelayanan), true);
          }
        } else {
          $nopelayanan = substr($_POST['nonota'], -3);
          $criteria->compare('LOWER(t.nopelayanan)', strtolower($nopelayanan), true);
        }
      }
      $criteria->addCondition('pasienbatalperiksa_r.pasienbatalperiksa_id IS NULL'); //jangan tampilkan tindakan jika ada pembatalan pemeriksaan
      
      // filter ruangan
      $ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
      $instalasilogin_id = Yii::app()->user->getState('instalasi_id');

      $pelayanan = CHtml::listData(BKInstalasiM::model()->getInstalasiPelayananRawat(), 'instalasi_id', 'instalasi_id');
      if (!empty($pelayanan[$instalasilogin_id])) {
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
      }

      if ($instalasilogin_id == Params::INSTALASI_ID_FARMASI) {
        $criteria->addCondition('t.penjualanresep_id is not null or instalasi_id=' . Params::INSTALASI_ID_FARMASI);
      } else if ($instalasilogin_id != Params::INSTALASI_ID_KASIR2) {
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
      } else {
        if(!empty($ruangan_id)) {
          // $criteria->addCondition('t.ruangan_id = ' . $ruangan_id);
        }
      }

      $criteria->addCondition('t.masukkamar_id is null');
      
      // var_dump($criteria); die;
      
      $modTindakan = BKTindakanPelayananT::model()->findAll($criteria);

      // var_dump(count($modTindakan)); die;


      $modObatalkes = array();

      if ($instalasilogin_id != Params::INSTALASI_ID_RAD) {


        $criteriaoa = new CDbCriteria;
        if (!empty($pendaftaran_id)) {
          $criteriaoa->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
        }

        // $criteriaoa->addCondition('returresepdet_id is null'); //DICOMMENT UNTUK MENAMPILKAN OBAT YG DIRETUR SEBAGIAN QTY
        
        if ($is_batal == 1) {
          $criteriaoa->addCondition('t.verifikasitagihan_id IS not NULL');
        } else {
          $criteriaoa->addCondition('t.verifikasitagihan_id IS NULL');
        }
        $criteriaoa->addCondition('t.penjualanresep_id is null');
        $criteriaoa->addCondition('t.oasudahbayar_id IS NULL');
        if (!$tindakanAktif) {
          if (isset($_POST['penjualanResep']) && !isset($_POST['nonota'])) {
            $idPenjualan = $_POST['penjualanResep'];
            if (!empty($idPenjualan)) {
              $criteriaoa->addCondition("t.penjualanresep_id = " . $idPenjualan);
            }
          } // else
          // $criteriaoa->addCondition('penjualanresep_id is not null');
        }
        $criteriaoa->join = 'left join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id '
          . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';

        $criteriaoa->order = 'o.obatalkes_nama';
        $modObatalkes = BKObatalkesPasienT::model()->findAll($criteriaoa);

      }

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;


      $modObatalkes = $this->groupingOAVerifikasi($modObatalkes);


      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      // if ($tindakanAktif){
      foreach ($modTindakan as $j => $tindakan) {
        //  $modTindakan->penjamin_id = 
        if (!empty($modAdmisi)) {
          $modTindakan[$j]->carabayar_id = $modAdmisi->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modAdmisi->penjamin_id;
        } else {
          $modTindakan[$j]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modPendaftaran->penjamin_id;
        }
        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }
      // }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      if ($tindakanAktif) {
        foreach ($modTindakan as $i => $tindakan) {


          if (!empty($tindakan->penjualanresep_id)) {
            $tindakan->tarif_satuan = $tindakan->tarif_tindakan;
          }

          $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          $tarifBebas = 0;
          foreach ($pembebasanTarif as $i => $pembebasan) {
            $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
          }
          $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
          $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
          $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
          $totDiscount_tindakan += $discountTindakan;

          $subsidi = $this->cekSubsidi($tindakan);
          $tarifSatuan = $tindakan->tarif_satuan;
          $qtyTindakan = $tindakan->qty_tindakan;
          $totQty = $totQty + $qtyTindakan;
          $tarifTindakan = $tindakan->tarif_tindakan;
          $totTarif = $totTarif + $tarifTindakan;
          $tarifCyto = $tindakan->tarifcyto_tindakan;
          $totCyto = $totCyto + $tarifCyto;
          if (!empty($subsidi['max'])) {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto));
            $totIur = $totIur + $iurBiaya;
            $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
            $subTotal = ($subTotal > 0) ? $subTotal : 0;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          } else {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
            $totIur = $totIur + $iurBiaya;
            $subTotal = $iurBiaya * $qtyTindakan;
            $subTotal -= $discountTindakan;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          }

          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');

      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      if ($tindakanAktif) {
        $returnVal['formBayarTindakan'] = $this->renderPartial(
          '_loadPembayaranTindakanVerifikasi2',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modObatalkes' => $modObatalkes,
            'modTandaBukti' => $modTandaBukti,
            'tottagihan' => $totTagihan,
            //'totalbayartind'=>$totalbayartindakan,
            'totpembebasan' => $totPembebasanTarif,
            'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
            'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
            'totalPembagi' => $totalPembagi,
            'is_batal' => $is_batal,
          ),
          true
        );
      }
      $returnVal['formBayarOa'] = $this->renderPartial(
        '_loadPembayaranOaVerifikasi2',
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi,
          'is_batal' => $is_batal,
        ),
        true
      );

      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : 0;
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;
      $returnVal['persen_admin'] = $modPenjamin->biaya_administrasi;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadPembayaranVerifikasiTindakanAkomodasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $totDeposit = 0;
      $is_batal = $_POST['is_batal'] ?? 0;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tindakanAktif = ((isset($_POST['tindakan'])) ? (bool)$_POST['tindakan'] : false);
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAdmisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      $returnVal = array();

      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan', 'tipepaket');
      $criteria->join .= "LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id ";
      $criteria->join .= "LEFT JOIN pasienbatalperiksa_r ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pasienbatalperiksa_r.pasienmasukpenunjang_id";
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->addCondition('t.tindakansudahbayar_id IS NULL');

      if ($is_batal == 1) {
      //   $criteria->addCondition('t.verifikasitagihan_id IS NULL');
      }
    
      $criteria->addCondition('t.verifbataltindakan_id IS NULL');


      if(isset($_POST['nonota']) && $_POST['nonota'] != '') {
        if(strlen($_POST['nonota']) <= 3) {
          $nopelayanan = $_POST['nonota'];
          if(preg_match('/[a-zA-Z]/', $nopelayanan)) {
            $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id); 
          } else {
            $criteria->compare('LOWER(t.nopelayanan)', strtolower($nopelayanan), true);
          }
        } else {
          $nopelayanan = substr($_POST['nonota'], -3);
          $criteria->compare('LOWER(t.nopelayanan)', strtolower($nopelayanan), true);
        }
      }
      $criteria->addCondition('pasienbatalperiksa_r.pasienbatalperiksa_id IS NULL'); //jangan tampilkan tindakan jika ada pembatalan pemeriksaan
      
      // filter ruangan
      $ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
      $instalasilogin_id = Yii::app()->user->getState('instalasi_id');

      $pelayanan = CHtml::listData(BKInstalasiM::model()->getInstalasiPelayananRawat(), 'instalasi_id', 'instalasi_id');
      if (!empty($pelayanan[$instalasilogin_id])) {
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
      }

      if ($instalasilogin_id == Params::INSTALASI_ID_FARMASI) {
        $criteria->addCondition('t.penjualanresep_id is not null');
      } else if ($instalasilogin_id != Params::INSTALASI_ID_KASIR2) {
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
      } else {
        if(!empty($ruangan_id)) {
          // $criteria->addCondition('t.ruangan_id = ' . $ruangan_id);
        }
      }
      $criteria->order = "nopelayanan asc";
      $criteria->addCondition('daftartindakan_akomodasi is true');
      $criteria->addCondition('nopelayanan is not null');
      
      // var_dump($criteria); die;
      
      $modTindakan = BKTindakanPelayananT::model()->findAll($criteria);

      // var_dump(count($modTindakan), $criteria); die;




      $modObatalkes = array();

      if ($instalasilogin_id != Params::INSTALASI_ID_RAD) {


        $criteriaoa = new CDbCriteria;
        if (!empty($pendaftaran_id)) {
          $criteriaoa->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
        }

        // $criteriaoa->addCondition('returresepdet_id is null'); //DICOMMENT UNTUK MENAMPILKAN OBAT YG DIRETUR SEBAGIAN QTY
        
        if ($is_batal == 1) {
          $criteriaoa->addCondition('t.verifikasitagihan_id IS not NULL');
        } else {
          $criteriaoa->addCondition('t.verifikasitagihan_id IS NULL');
        }
        $criteriaoa->addCondition('t.penjualanresep_id is null');
        $criteriaoa->addCondition('t.oasudahbayar_id IS NULL');
        if (!$tindakanAktif) {
          if (isset($_POST['penjualanResep']) && !isset($_POST['nonota'])) {
            $idPenjualan = $_POST['penjualanResep'];
            if (!empty($idPenjualan)) {
              $criteriaoa->addCondition("t.penjualanresep_id = " . $idPenjualan);
            }
          } // else
          // $criteriaoa->addCondition('penjualanresep_id is not null');
        }
        $criteriaoa->join = 'left join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id '
          . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';

        $criteriaoa->order = 'o.obatalkes_nama';
        $modObatalkes = BKObatalkesPasienT::model()->findAll($criteriaoa);

      }

      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;


      $modObatalkes = $this->groupingOAVerifikasi($modObatalkes);


      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      // if ($tindakanAktif){
      foreach ($modTindakan as $j => $tindakan) {
        //  $modTindakan->penjamin_id = 
        if (!empty($modAdmisi)) {
          $modTindakan[$j]->carabayar_id = $modAdmisi->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modAdmisi->penjamin_id;
        } else {
          $modTindakan[$j]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakan[$j]->penjamin_id = $modPendaftaran->penjamin_id;
        }
        $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
      }
      // }

      foreach ($modObatalkes as $i => $obatAlkes) {
        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }
      $totalPembagi = $totTarifTind + $totHargaSatuanObat;

      $totSubAsuransi = 0;
      $totSubPemerintah = 0;
      $totSubRs = 0;
      $totCyto = 0;
      $totTarif = 0;
      $totQty = 0;
      $totDiscount_tindakan = 0;
      $subsidi = 0;
      $subsidiOs = 0;
      $totPembebasanTarif = 0;
      $totIur = 0;
      $iurBiaya = 0;
      $totIurOa = 0;
      $totIurOa = 0;
      $totalbayartindakan = 0;
      $totalbayarOa = 0;
      $totTarifTind = 0;
      $totHargaSatuanObat = 0;
      if ($tindakanAktif) {
        foreach ($modTindakan as $i => $tindakan) {


          if (!empty($tindakan->penjualanresep_id)) {
            $tindakan->tarif_satuan = $tindakan->tarif_tindakan;
          }

          $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          $tarifBebas = 0;
          foreach ($pembebasanTarif as $i => $pembebasan) {
            $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
          }
          $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
          $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan / 100 : 0;
          $discountTindakan = ($disc * $tindakan->tarif_satuan * $tindakan->qty_tindakan);
          $totDiscount_tindakan += $discountTindakan;

          $subsidi = $this->cekSubsidi($tindakan);
          $tarifSatuan = $tindakan->tarif_satuan;
          $qtyTindakan = $tindakan->qty_tindakan;
          $totQty = $totQty + $qtyTindakan;
          $tarifTindakan = $tindakan->tarif_tindakan;
          $totTarif = $totTarif + $tarifTindakan;
          $tarifCyto = $tindakan->tarifcyto_tindakan;
          $totCyto = $totCyto + $tarifCyto;
          if (!empty($subsidi['max'])) {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto));
            $totIur = $totIur + $iurBiaya;
            $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi - $discountTindakan;
            $subTotal = ($subTotal > 0) ? $subTotal : 0;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          } else {
            $subsidiAsuransi = $subsidi['asuransi'];
            $subsidiPemerintah = $subsidi['pemerintah'];
            $subsidiRumahSakit = $subsidi['rumahsakit'];

            $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
            $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah;
            $totSubRs = $totSubRs + $subsidiRumahSakit;
            $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit));
            $totIur = $totIur + $iurBiaya;
            $subTotal = $iurBiaya * $qtyTindakan;
            $subTotal -= $discountTindakan;
            $totalbayartindakan = $totalbayartindakan + $subTotal;
          }

          $totTarifTind = $totTarifTind + $tindakan->tarif_tindakan;
        }
      }

      $totQtyOa = 0;
      $totHargaSatuanObat = 0;
      $totCytoOa = 0;
      $totalbayarOa = 0;
      $totHargaSatuan = 0;
      $totSubAsuransiOa = 0;
      $totSubPemerintahOa = 0;
      $totSubRsOa = 0;
      $totSubAsuransiOa = 0;
      $totDiscount_oa = 0;
      foreach ($modObatalkes as $i => $obatAlkes) {
        $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount / 100 : 0;
        $discount_oa = ($disc * $obatAlkes->qty_oa * $obatAlkes->hargasatuan_oa);
        $totDiscount_oa += $discount_oa;
        $subsidiOa = $this->cekSubsidiOa($obatAlkes);
        $totQtyOa = $totQtyOa + $obatAlkes->qty_oa;
        $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa;
        $oaHargasatuan = $obatAlkes->hargasatuan_oa;
        if ($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" or $obatAlkes->obatalkes->jenisobatalkes_id == 3) {
          $biayaServiceResep = 0;
        } else {
          $biayaServiceResep = $obatAlkes->biayaservice;
        }
        $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling;
        $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling;
        if (!empty($subsidiOa['max'])) {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        } else {
          $oaSubsidiasuransi = $subsidiOa['asuransi'];
          $oaSubsidipemerintah = $subsidiOa['pemerintah'];
          $oaSubsidirs = $subsidiOa['rumahsakit'];
        }

        $totHargaSatuanObat = $totHargaSatuanObat + $obatAlkes->hargasatuan_oa;
      }

      $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');

      $totTagihan = round($totalbayartindakan + $totalbayarOa);
      $uang_muka = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), 'pembatalanuangmuka_id IS NULL');
      if (count((array)$uang_muka) > 0) {
        $totDeposit = 0;
        foreach ($uang_muka as $data) {
          $totDeposit += $data->jumlahuangmuka;
        }
      }
      $modTandaBukti->jmlpembayaran = $totTagihan;
      $modTandaBukti->biayaadministrasi = 0;
      $modTandaBukti->biayamaterai = 0;
      $modTandaBukti->uangkembalian = 0;
      $modTandaBukti->uangditerima = $totTagihan;
      $pembulatan = ($pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
      if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $modTandaBukti->jmlpembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
      } else {
        $modTandaBukti->jmlpembulatan = 0;
      }
      $modTandaBukti->uangditerima = $modTandaBukti->jmlpembayaran;
      if ($tindakanAktif) {
        $returnVal['formBayarTindakan'] = $this->renderPartial(
          '_loadPembayaranTindakanVerifikasi2Akomodasi',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modObatalkes' => $modObatalkes,
            'modTandaBukti' => $modTandaBukti,
            'tottagihan' => $totTagihan,
            //'totalbayartind'=>$totalbayartindakan,
            'totpembebasan' => $totPembebasanTarif,
            'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
            'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
            'totalPembagi' => $totalPembagi,
            'is_batal' => $is_batal,
          ),
          true
        );
      }
      $returnVal['formBayarOa'] = ''; /*$this->renderPartial(
        '_loadPembayaranOaVerifikasi2',
        array(
          'modPendaftaran' => $modPendaftaran,
          'tindakanAktif' => $tindakanAktif,
          'modPasien' => $modPasien,
          'modTindakan' => $modTindakan,
          'modObatalkes' => $modObatalkes,
          'modTandaBukti' => $modTandaBukti,
          'tottagihan' => $totTagihan,
          //'totalbayarOa'=>$totalbayarOa,
          'totpembebasan' => $totPembebasanTarif,
          'jmlpembulatan' => $modTandaBukti->jmlpembulatan,
          'jmlpembayaran' => $modTandaBukti->jmlpembayaran,
          'totalPembagi' => $totalPembagi,
          'is_batal' => $is_batal,
        ),
        true
      );
      */

      $returnVal['tottagihan'] = (!empty($totTagihan)) ? $totTagihan : 0;
      $returnVal['totpembebasan'] = (!empty($totPembebasanTarif)) ? $totPembebasanTarif : 0;
      $returnVal['jmlpembulatan'] = (!empty($modTandaBukti->jmlpembulatan)) ? $modTandaBukti->jmlpembulatan : 0;
      $returnVal['jmlpembayaran'] = (!empty($modTandaBukti->jmlpembayaran)) ? $modTandaBukti->jmlpembayaran : 0;
      $returnVal['uangditerima'] = (!empty($modTandaBukti->uangditerima)) ? $modTandaBukti->uangditerima : 0;
      $returnVal['uangkembalian'] = (!empty($modTandaBukti->uangkembalian)) ? $modTandaBukti->uangkembalian : 0;
      $returnVal['biayamaterai'] = (!empty($modTandaBukti->biayamaterai)) ? $modTandaBukti->biayamaterai : 0;
      $returnVal['biayaadministrasi'] = (!empty($modTandaBukti->biayaadministrasi)) ? $modTandaBukti->biayaadministrasi : 0;
      $returnVal['namapasien'] = (!empty($modPasien->nama_pasien)) ? $modPasien->nama_pasien : 0;
      $returnVal['alamatpasien'] = (!empty($modPasien->alamat_pasien)) ? $modPasien->alamat_pasien : 0;
      $returnVal['photopasien'] = (!empty($modPasien->photopasien)) ? $modPasien->photopasien : 0;
      $returnVal['subsidi'] = $subsidi;
      $returnVal['subsidiOa'] = $subsidiOs;
      $returnVal['deposit'] = $totDeposit;
      $returnVal['persen_admin'] = $modPenjamin->biaya_administrasi;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  private function groupingOAVerifikasi($modObatalkes)
  {
    $res = array();
    $pure_res = array();

    foreach ($modObatalkes as $item) {
      //if (empty($res[$item->obatalkes_id])) {
        $res[$item->obatalkes_id] = $item;
      /*} else {
        $res[$item->obatalkes_id]->qty_oa += $item->qty_oa;
        $res[$item->obatalkes_id]->subsidiasuransi += $item->subsidiasuransi;
        $res[$item->obatalkes_id]->subsidipemerintah += $item->subsidipemerintah;
        $res[$item->obatalkes_id]->subsidirs += $item->subsidirs;
        $res[$item->obatalkes_id]->discount += $item->discount;
      }*/
    }

    foreach ($res as $item) {
      $item->hargajual_oa = $item->qty_oa * $item->hargasatuan_oa;
      $item->iurbiaya = $item->hargajual_oa - $item->discount -
        ($item->subsidiasuransi + $item->subsidipemerintah + $item->subsidirs);

      if ($item->iurbiaya < 0) {
        $item->iurbiaya = 0;
        $item->subsidiasuransi = $item->hargajual_oa - $item->discount - ($item->subsidipemerintah + $item->subsidirs);
      }

      $pure_res[] = $item;
    }

    return $pure_res;
  }
}
