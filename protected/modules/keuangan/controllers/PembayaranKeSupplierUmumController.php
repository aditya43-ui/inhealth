<?php

Yii::import('gizi.models.GZTerimabahanmakan');

class PembayaranKeSupplierUmumController extends MyAuthController
{
  protected $successSave;
  public $path_view = 'keuangan.views.pembayaranKeSupplierUmum.';
  public $pesan = "";
  /**
   * pembayaran ke supplier
   * di gunakan :
   * 1. keuangan -> informasi Faktur UMum -> bayar ke supplier
   */
  public function actionIndex($terimapersediaan_id = null, $terimabahanmakan_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Supplier Umum";
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $modelBayar = new KUBayarkesupplierT;
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modTerimaPersediaan = new KUTerimapersediaanT;
    $modDetailPersediaan = new KUTerimapersdetailT;
    $modBuktiKeluar->tahun = date('Y');

    $modTerimaMakanan = new TerimabahanmakanT;
    $modDetailMakanan = new TerimabahandetailT;

    $modBuktiKeluar->nokaskeluar = "Otomatis";

    if (!empty($terimapersediaan_id)) {
      // $terimapersediaan_id = $terimapersediaan_id;
      $modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForDb($modTerimaPersediaan->tglterima);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForDb($modTerimaPersediaan->tglsuratjalan);
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForDb($modTerimaPersediaan->tglfaktur);

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglterima);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglsuratjalan);
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglfaktur);
      $modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
      $modTerimaPersediaan->umurhutang = CustomFunction::hitungTahunBulanHari($modTerimaPersediaan->tglfaktur, $modTerimaPersediaan->tgljatuhtempo);
      $modTerimaPersediaan->syaratbayar_nama = (isset($modTerimaPersediaan->syaratbayar) ? $modTerimaPersediaan->syaratbayar->syaratbayar_nama : "");


      $sudahBayar = 0;

      //			if (!empty($modTerimaPersediaan)) {
      $modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));

      $modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
      if (count((array)$modBayar) > 0) {
        foreach ($modBayar as $key => $value) {
          $sudahBayar += $value->jmldibayarkan;
        }
      }
      //			}
      //
      $modelBayar->terimapersediaan_id = $terimapersediaan_id;
      $modelBayar->totaltagihan = (floatval($modTerimaPersediaan->totalkeseluruhan) - floatval($sudahBayar));
      //$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
      $modBuktiKeluar->namapenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';

      //			$totalkeseluruhan = 0;
      //			if ($modTerimaPersediaan->totalkeseluruhan == 0 || empty($modTerimaPersediaan->totalkeseluruhan)){
      //				$totalkeseluruhan = $modTerimaPersediaan->totalharga - $modTerimaPersediaan->discount + $modTerimaPersediaan->pajakpph + $modTerimaPersediaan->pajakppn + $modTerimaPersediaan->biayaadministrasi;
      //				$modTerimaPersediaan->totalkeseluruhan = $totalkeseluruhan;
      //			}else{
      //				$totalkeseluruhan = $modTerimaPersediaan->totalkeseluruhan;
      //			}

      //			$modelBayar->totaltagihan = $totalkeseluruhan;
      $modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;
      //$modBuktiKeluar->biayaadministrasi =  $modTerimaPersediaan->biayaadministrasi;

    }
    if (!empty($terimabahanmakan_id)) {
      // $terimabahanmakan_id = $terimabahanmakan_id;
      $modTerimaMakanan = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);

      // var_dump($modTerimaMakanan->attributes); die;
      //            $modelBayar->tgljatuhtempo = date('d m y');
      $modTerimaPersediaan->nopenerimaan = $modTerimaMakanan->nopenerimaanbahan;
      $modTerimaPersediaan->nofaktur = $modTerimaMakanan->nofaktur;
      $modTerimaPersediaan->nosuratjalan = $modTerimaMakanan->nosuratjalan;

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser($modTerimaMakanan->tglterimabahan);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser($modTerimaMakanan->tglsurjalan);
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser($modTerimaMakanan->tglfaktur);
      $modTerimaPersediaan->tgljatuhtempo = (!empty($modTerimaMakanan->tgljatuhtempo) ? MyFormatter::formatDateTimeForUser($modTerimaMakanan->tgljatuhtempo) : "");

      $modTerimaPersediaan->totalharga = $modTerimaMakanan->totalharganetto;
      $modTerimaPersediaan->discount = $modTerimaMakanan->totaldiscount;
      $modTerimaPersediaan->pajakppn = $modTerimaMakanan->pajakppn;
      $modTerimaPersediaan->pajakpph = $modTerimaMakanan->pajakpph;
      $modTerimaPersediaan->biayaadministrasi = $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi;
      $modTerimaPersediaan->totalkeseluruhan = $modTerimaMakanan->totalkeseluruhan;
      $modTerimaPersediaan->supplier_nama = $modTerimaMakanan->supplier->supplier_nama;
      $modTerimaPersediaan->umurhutang = CustomFunction::hitungTahunBulanHari($modTerimaMakanan->tglfaktur, $modTerimaMakanan->tgljatuhtempo);
      $modTerimaPersediaan->syaratbayar_nama = (isset($modTerimaMakanan->syaratbayar) ? $modTerimaMakanan->syaratbayar->syaratbayar_nama : "");


      //            $modTerimaPersediaan->totalkeseluruhan = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglterima);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglsuratjalan);
      //			$modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglfaktur);
      $modTerimaPersediaan->supplier_nama = $modTerimaMakanan->supplier->supplier_nama;
      $modTerimaPersediaan->keteranganfaktur = $modTerimaMakanan->keteranganfaktur;
      $sudahBayar = 0;

      //			if (!empty($modTerimaMakanan)) {
      $modDetailMakanan = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));

      $modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
      if (count((array)$modBayar) > 0) {
        foreach ($modBayar as $key => $value) {
          $sudahBayar += $value->jmldibayarkan;
        }
      }
      //			}

      $jumlah = $modTerimaPersediaan->totalkeseluruhan;
      //            $jumlah = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

      $modelBayar->terimabahanmakan_id = $terimabahanmakan_id;
      $modelBayar->totaltagihan = $jumlah - $sudahBayar;
      //$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
      $modBuktiKeluar->namapenerima = $modTerimaMakanan->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modTerimaMakanan->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier Bahan Makanan';

      //			$totalkeseluruhan = 0;
      //			if ($jumlah == 0 || empty($jumlah)){
      //				$totalkeseluruhan = $jumlah;
      //			}else{
      //				$totalkeseluruhan = $jumlah;
      //			}

      //			$modelBayar->totaltagihan = $totalkeseluruhan;
      $modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;
      //$modBuktiKeluar->biayaadministrasi =  $modTerimaPersediaan->biayaadministrasi;

    }

    if (!empty($_GET['bayarkesupplier_id'])) {

      $modelBayar = KUBayarkesupplierT::model()->findByPk($_GET['bayarkesupplier_id']);
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $_GET['bayarkesupplier_id']));
    }
    //		if (isset($_POST['KUBayarkesupplierT']) && (!isset($modTerimaPersediaan->bayarkesupplier_id))) {
    if (isset($_POST['KUBayarkesupplierT']) && isset($_POST['KUTandabuktikeluarT'])) {
      //
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modelBayar = $this->saveBayarSupplier($_POST['KUBayarkesupplierT'], $modelBayar);

        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $modelBayar, $modBuktiKeluar);

        if ($this->successSave) {

          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            $modelBayar = BayarkesupplierT::model()->findByPk($modelBayar->bayarkesupplier_id);
            $modJurnalRekening = $this->saveJurnalRekening($modelBayar);
            $modFakturJurnalDetail = null;
            $modFakturJurnal = null;
            if (!empty($modelBayar->terimabahanmakan_id)) {
              $modFakturJurnal = JurnalrekeningT::model()->findByAttributes(array('terimabahanmakan_id' => $modelBayar->terimabahanmakan_id));
            } else if (!empty($modelBayar->terimapersediaan_id)) {
              $modFakturJurnal = JurnalrekeningT::model()->findByAttributes(array('terimapersediaan_id' => $modelBayar->terimapersediaan_id));
            }

            if (isset($modFakturJurnal)) {
              $modFakturJurnalDetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $modFakturJurnal->jurnalrekening_id), array('order' => 'nourut ASC'));
            }

            $rekening5_id = null;
            $nourutJurnal = 2;

            if (count((array)$modFakturJurnalDetail) > 0) {
              foreach ($modFakturJurnalDetail as $datadetailjurnal) {
                if ($datadetailjurnal->saldokredit > 0) {
                  $rekening5_id = $datadetailjurnal->rekening5_id;
                }
              }
            }
            //Debit jurnal rekening mengambil dari transaksi faktur
            if (!empty($rekening5_id)) {
              $this->saveJurnalDetail($modJurnalRekening, $rekening5_id, $modelBayar->jmldibayarkan, 'D', 1);
            }

            if ($modelBayar->tandabuktikeluar->biayaadministrasi > 0) {
              $nourutJurnal = 3;
              //Debit administrasi
              $rekeningcolumn = RekeningcolumnM::model()->findByPk(Params::REKENINGCOLUMN_ID_BAYARKESUPPLIER);
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modelBayar->tandabuktikeluar->biayaadministrasi, 'D', 2);
              }
            }
            if ($modelBayar->tandabuktikeluar->biayaongkos_kirim > 0) {
              if ($modelBayar->tandabuktikeluar->biayaadministrasi > 0) {
                $nourutJurnal = 4;
              } else {
                $nourutJurnal = 3;
              }

              //Debit biayaongkos_kirim
              $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_BIAYAONGKOSKIRIM . "'");
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modelBayar->tandabuktikeluar->biayaongkos_kirim, 'D', 3);
              }
            }
            //Kredit Carabayarkeluar
            if (!empty($modelBayar->tandabuktikeluar->carabayarkeluar)) {
              if ($modelBayar->tandabuktikeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER) {
                $modBankRek = BankrekM::model()->findByAttributes(array('bank_id' => $modelBayar->tandabuktikeluar->bank_id, 'debitkredit' => 'K'));
                if (isset($modBankRek)) {
                  $this->saveJurnalDetail($modJurnalRekening, $modBankRek->rekening5_id, $modelBayar->tandabuktikeluar->jmlkaskeluar, 'K', $nourutJurnal);
                }
              } else {
                $modCarabayarKeluarrek = CarabayarkeluarrekM::model()->findByAttributes(array('carabayarkeluar' => $modelBayar->tandabuktikeluar->carabayarkeluar));
                if (isset($modCarabayarKeluarrek)) {
                  $this->saveJurnalDetail($modJurnalRekening, $modCarabayarKeluarrek->rekening5_id, $modelBayar->tandabuktikeluar->jmlkaskeluar, 'K', $nourutJurnal);
                }
              }
            }
          }

          $transaction->commit();
          Yii::app()->user->setFlash("success", "Pembayaran berhasil disimpan.");
          if (isset($_GET['frame'])) {
            $this->redirect(array('index', 'terimapersediaan_id' => $modelBayar->terimapersediaan_id, 'bayarkesupplier_id' => $modelBayar->bayarkesupplier_id, 'frame' => 1, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'terimapersediaan_id' => $modelBayar->terimapersediaan_id, 'bayarkesupplier_id' => $modelBayar->bayarkesupplier_id, 'sukses' => 1));
          }
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }

    $this->render('index', array(
      'modTerimaPersediaan' => $modTerimaPersediaan,
      'modDetailPersediaan' => $modDetailPersediaan,
      'modTerimaMakanan' => $modTerimaMakanan,
      'modDetailMakanan' => $modDetailMakanan,
      'modelBayar' => $modelBayar,
      'modBuktiKeluar' => $modBuktiKeluar,
    ));
  }

  /**
   * method untuk save pembayaran ke supplier
   * digunakan di
   * 1. keuangan/PembayaranKeSupplierUmum/index
   * @param array $postBayarSupplier post request $_POST['KUBayarkesupplierT']
   * @param obj $modBayar KUBayarkesupplierT
   * @return object KUBayarkesupplierT
   */
  protected function saveBayarSupplier($postBayarSupplier, $modBayar)
  {
    $format = new MyFormatter();

    $modBayar->attributes = $postBayarSupplier;
    $modBayar->terimapersediaan_id = $postBayarSupplier['terimapersediaan_id'];
    $modBayar->terimabahanmakan_id = $postBayarSupplier['terimabahanmakan_id'];

    $modBayar->tgljatuhtempo = (isset($postBayarSupplier['tgljatuhtempo']) || !empty($postBayarSupplier['tgljatuhtempo'])) ? $format->formatDateTimeForDB($postBayarSupplier['tgljatuhtempo']) : null;
    $modBayar->tglbayarkesupplier = $format->formatDateTimeForDB($postBayarSupplier['tglbayarkesupplier']);

    if ($modBayar->validate()) {
      $modBayar->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
    }

    return $modBayar;
  }

  /**
   * method untuk save tanda bukti keluar ke supplier
   * digunakan di
   * 1. keuangan/PembayaranKeSupplierUmum/index
   * @param array $postBuktiKeluar post request $_POST['KUTandaBuktiKeluarT']
   * @param object $modBayarSupplier KUBayarSupplierT
   * @param object $modBuktiKeluar KUTandaBuktiKeluarT
   * @return object KUTandaBuktiKeluarT
   */
  protected function saveBuktiKeluar($postBuktiKeluar, $modBayarSupplier, $modBuktiKeluar)
  {
    $format = new MyFormatter();

    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->bayarkesupplier_id = $modBayarSupplier->bayarkesupplier_id;
    $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($postBuktiKeluar['tglkaskeluar']);
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->tahun = date('Y');
    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
      $this->updateBayarSupplier($modBayarSupplier, $modBuktiKeluar);
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function updateBayarSupplier($modBayarSupplier, $modBuktiKeluar)
  {
    KUBayarkesupplierT::model()->updateByPk($modBayarSupplier->bayarkesupplier_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
  }

  public function actionPrint($terimapersediaan_id = null, $terimabahanmakan_id = null, $bayarkesupplier_id = null)
  {
    $judulKuitansi = '----- Tanda Bukti Bayar Supplier -----';
    $format = new MyFormatter();

    $modTerimaPersediaan = new KUTerimapersediaanT;
    $modDetailPersediaan = array();

    $modTerimaBahanMakan = new TerimabahanmakanT;
    $modDetailBahanMakan = array();
    $modelBayar = KUBayarkesupplierT::model()->findByAttributes(array('bayarkesupplier_id' => $bayarkesupplier_id));
    $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id), array('order' => 'create_time DESC'));

    if (!empty($terimapersediaan_id)) {
      $modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
      $modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
      $modTerimaPersediaan->umurhutang = CustomFunction::hitungTahunBulanHari($modTerimaPersediaan->tglfaktur, $modTerimaPersediaan->tgljatuhtempo);
      $modTerimaPersediaan->syaratbayar_nama = (isset($modTerimaPersediaan->syaratbayar) ? $modTerimaPersediaan->syaratbayar->syaratbayar_nama : "");

      $modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
      //            $modelBayar = KUBayarkesupplierT::model()->findByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
      //            $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id),array('order'=>'create_time DESC'));
    } else if (!empty($terimabahanmakan_id)) {
      $modTerimaBahanMakan = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);
      $modTerimaPersediaan->nopenerimaan = $modTerimaBahanMakan->nopenerimaanbahan;
      $modTerimaPersediaan->umurhutang = CustomFunction::hitungTahunBulanHari($modTerimaPersediaan->tglfaktur, $modTerimaPersediaan->tgljatuhtempo);

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForDb($modTerimaBahanMakan->tglterimabahan);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForDb($modTerimaBahanMakan->tglsurjalan);
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForDb($modTerimaBahanMakan->tglfaktur);

      $modTerimaPersediaan->nofaktur = $modTerimaBahanMakan->nofaktur;
      $modTerimaPersediaan->keterangan_persediaan = $modTerimaBahanMakan->keterangan_terima_bahan;

      $modTerimaPersediaan->totalharga = $modTerimaBahanMakan->totalharganetto;
      $modTerimaPersediaan->discount = $modTerimaBahanMakan->totaldiscount;
      $modTerimaPersediaan->pajakppn = $modTerimaBahanMakan->biayapajak;
      $modTerimaPersediaan->biayaadministrasi = $modTerimaBahanMakan->biayapengiriman + $modTerimaBahanMakan->biayatransportasi;
      $modTerimaPersediaan->totalkeseluruhan = $modTerimaBahanMakan->totalharganetto + $modTerimaBahanMakan->biayapengiriman + $modTerimaBahanMakan->biayatransportasi + $modTerimaBahanMakan->biayapajak - $modTerimaBahanMakan->totaldiscount;

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglterima)));
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglsuratjalan)));
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglfaktur)));
      $modTerimaPersediaan->supplier_nama = $modTerimaBahanMakan->supplier->supplier_nama;
      $modTerimaPersediaan->syaratbayar_nama = (isset($modTerimaBahanMakan->syaratbayar) ? $modTerimaBahanMakan->syaratbayar->syaratbayar_nama : "");


      $modDetailBahanMakan = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
      //            $modelBayar = KUBayarkesupplierT::model()->findByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
      //            $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id),array('order'=>'create_time DESC'));


    }

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }
    $this->render('Print', array(
      'judulKuitansi' => $judulKuitansi,
      'caraPrint' => $caraPrint,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modTerimaPersediaan' => $modTerimaPersediaan,
      'modDetailPersediaan' => $modDetailPersediaan,
      'modTerimaBahanMakan' => $modTerimaBahanMakan,
      'modDetailBahanMakan' => $modDetailBahanMakan,
      'modelBayar' => $modelBayar,
    ));
  }

  public function actionLoadDetailTerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $terimapersediaan_id = $_POST['id'];
      //if (!empty($terimapersediaan_id)) {
      $modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglterima)));
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglfaktur)));
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modTerimaPersediaan->tglsuratjalan)));
      //$modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
      $sudahBayar = 0;
      $modelBayar = new KUBayarkesupplierT();
      $modBuktiKeluar = new KUTandabuktikeluarT;

      if (!empty($modTerimaPersediaan)) {
        $modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));

        $modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
        if (count((array)$modBayar) > 0) {
          foreach ($modBayar as $key => $value) {
            $sudahBayar += $value->jmldibayarkan;
          }
        }
      }
      $modelBayar->terimapersediaan_id = $terimapersediaan_id;
      $modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;

      $modBuktiKeluar->namapenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';


      $totalkeseluruhan = 0;
      if ($modTerimaPersediaan->totalkeseluruhan == 0 || empty($modTerimaPersediaan->totalkeseluruhan)) {
        $totalkeseluruhan = $modTerimaPersediaan->totalharga - $modTerimaPersediaan->discount + $modTerimaPersediaan->pajakpph + $modTerimaPersediaan->pajakppn + $modTerimaPersediaan->biayaadministrasi;
        $modTerimaPersediaan->totalkeseluruhan = $totalkeseluruhan;
      } else {
        $totalkeseluruhan = $modTerimaPersediaan->totalkeseluruhan;
      }

      $modelBayar->totaltagihan = $totalkeseluruhan;
      //$modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;
      $modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;

      $ii = 1;
      $partial = '';
      foreach ($modDetailPersediaan as $det) {
        $partial .= $this->renderPartial($this->path_view . '_rowTerimaDetail', array('detail' => $det, 'ii' => $ii), true);
        $ii++;
      }
      //}




      $res = array(
        'tr' => $partial,
        'modBayarSupplier' => $modelBayar,
        'modTerima' => $modTerimaPersediaan,
        'modBuktiKeluar' => $modBuktiKeluar
      );


      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }
  public function actionLoadDetailTerimaBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $terimabahanmakan_id = $_POST['id'];

      //if (!empty($terimapersediaan_id)) {
      $modTerimaPersediaan = new KUTerimapersediaanT;
      $modTerimaMakanan = TerimabahanmakanT::model()->findByPk($terimabahanmakan_id);


      // var_dump($modTerimaMakanan->attributes); die;

      $modTerimaPersediaan->nopenerimaan = $modTerimaMakanan->nopenerimaanbahan;

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglterimabahan);
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglsurjalan);
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForDb($modTerimaMakanan->tglfaktur);
      $modTerimaPersediaan->nofaktur = $modTerimaMakanan->nofaktur;

      $modTerimaPersediaan->totalharga = $modTerimaMakanan->totalharganetto;
      $modTerimaPersediaan->discount = $modTerimaMakanan->totaldiscount;
      $modTerimaPersediaan->pajakppn = $modTerimaMakanan->biayapajak;
      $modTerimaPersediaan->biayaadministrasi = $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi;
      $modTerimaPersediaan->totalkeseluruhan = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

      $modTerimaPersediaan->tglterima = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglterima)));
      $modTerimaPersediaan->tglsuratjalan = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglsuratjalan)));
      $modTerimaPersediaan->tglfaktur = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTerimaPersediaan->tglfaktur)));
      $modTerimaPersediaan->supplier_nama = $modTerimaMakanan->supplier->supplier_nama;
      $modTerimaPersediaan->keterangan_persediaan = $modTerimaMakanan->keterangan_terima_bahan;

      //$modTerimaPersediaan->supplier_nama = $modTerimaPersediaan->supplier->supplier_nama;
      $sudahBayar = 0;
      $modelBayar = new KUBayarkesupplierT();
      $modBuktiKeluar = new KUTandabuktikeluarT;

      if (!empty($modTerimaMakanan)) {
        $modDetailMakanan = TerimabahandetailT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));

        $modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimabahanmakan_id' => $terimabahanmakan_id));
        if (count((array)$modBayar) > 0) {
          foreach ($modBayar as $key => $value) {
            $sudahBayar += $value->jmldibayarkan;
          }
        }
      }

      $jumlah = $modTerimaMakanan->totalharganetto + $modTerimaMakanan->biayapengiriman + $modTerimaMakanan->biayatransportasi + $modTerimaMakanan->biayapajak - $modTerimaMakanan->totaldiscount;

      $modelBayar->terimabahanmakan_id = $terimabahanmakan_id;
      $modelBayar->totaltagihan = $jumlah - $sudahBayar;
      //$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
      $modBuktiKeluar->namapenerima = $modTerimaMakanan->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modTerimaMakanan->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier Bahan Makanan';

      $totalkeseluruhan = 0;
      if ($jumlah == 0 || empty($jumlah)) {
        $totalkeseluruhan = $jumlah;
      } else {
        $totalkeseluruhan = $jumlah;
      }

      $modelBayar->totaltagihan = $totalkeseluruhan;
      $modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;
      //$modBuktiKeluar->biayaadministrasi =  $modTerimaPersediaan->biayaadministrasi;

      $ii = 1;
      $partial = '';
      foreach ($modDetailMakanan as $det) {
        $partial .= $this->renderPartial($this->path_view . '_rowTerimaDetailBahan', array('detail' => $det, 'ii' => $ii), true);
        $ii++;
      }
      //}




      $res = array(
        'tr' => $partial,
        'modBayarSupplier' => $modelBayar,
        'modTerima' => $modTerimaPersediaan,
        'modBuktiKeluar' => $modBuktiKeluar
      );


      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }

  protected function saveJurnalRekening($model)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglbayarkesupplier);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->tandabuktikeluar->nokaskeluar;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglbayarkesupplier);
    $modJurnalRekening->nobku = "";
    $uraianJurnal = "";

    if (!empty($model->terimabahanmakan_id)) {
      $modTerimabahan = TerimabahanmakanT::model()->findByPk($model->terimabahanmakan_id);
      $uraianJurnal = "Bahan Makanan Ke Supplier " . (!empty($modTerimabahan->supplier_id) ? $modTerimabahan->supplier->supplier_nama : "") . " - " . $modTerimabahan->nofaktur;
    } else if (!empty($model->terimapersediaan_id)) {
      $modTerimaBarang = TerimapersediaanT::model()->findByPk($model->terimapersediaan_id);
      $uraianJurnal = "Barang Ke Supplier " . (!empty($modTerimaBarang->supplier_id) ? $modTerimaBarang->supplier->supplier_nama : "") . " - " . $modTerimaBarang->nofaktur;
    }


    $modJurnalRekening->urianjurnal = 'Pembayaran Faktur ' . $uraianJurnal;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->bayarkesupplier_id = $model->bayarkesupplier_id;
    $modJurnalRekening->tandabuktikeluar_id = $model->tandabuktikeluar->tandabuktikeluar_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut)
  {
    $valid = true;
    //        $modJurnalPosting = null;
    // $rekening5 = Rekening5M::model()->findByPk($rekening5_id);
    // if (!empty($rekening5)) {
    //   $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    //   $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    //   $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);
    // }

    //        if(Yii::app()->user->getState('ispostingotomatis'))
    //        {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if($modJurnalPosting->validate()){
    //                $modJurnalPosting->save();
    //            }
    //        }

    $modelJurnalDetail = new JurnaldetailT();
    //        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    // if (!empty($rekening5)) {
      $modelJurnalDetail->rekening5_id = $rekening5_id;
      // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
      // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
      // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
      // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    // }
    $modelJurnalDetail->nourut = $nourut;
    if ($typeSaldo == 'K') {
      $modelJurnalDetail->saldokredit = $nilaisaldo;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($typeSaldo == 'D') {
      $modelJurnalDetail->saldodebit = $nilaisaldo;
      $modelJurnalDetail->saldokredit = 0;
    }
    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }

  public function actionGetMasterBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bank_id = isset($_GET['bank_id']) ? $_GET['bank_id'] : null;

      $model = BankM::model()->findByPk($bank_id);
      $data = array();

      if (isset($model)) {
        $data['norekening'] = $model->norekening;
        $data['namabank'] = $model->namabank;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
}
