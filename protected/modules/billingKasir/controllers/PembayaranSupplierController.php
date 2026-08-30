<?php

Yii::import('keuangan.models.*');
Yii::import('gudangFarmasi.models.*');
class PembayaranSupplierController extends MyAuthController
{
  protected $successSave;
  public $path_view = "billingKasir.views.pembayaranSupplier.";
  public $init;
  public $simpanTerimaBarang = true;
  public $simpanTerimaBarangDet = true;
  public $simpanFaktur = true;
  public $simpanFakturDet = true;
  public $simpanStok = true;
  public $stokobatalkestersimpan = true;
  public $simpanDeleteFakturDet = true;
  public $simpanDeleteStokOa = true;
  public $succesSave = true;
  public $pesan = "";

  /**
   * pembayaran ke supplier
   * di gunakan :
   * 1. billingKasir -> informasi Faktur Pembelian -> bayar ke supplier 
   */
  public function actionIndex($frame = null, $idFakturPembelian = null, $id = null)
  {

    if (!empty($idFakturPembelian)) {
      if (!empty($frame)) {
        $this->layout = "//layouts/iframe";
      }

      $modelBayar = new BKBayarkeSupplierT;
      $modBuktiKeluar = new BKTandabuktikeluarT;
      $fakturpembelian_id = $_GET['idFakturPembelian'];
      $modFakturBeli = BKFakturPembelianT::model()->findByPk($fakturpembelian_id);
      $uangMuka = 0;
      $modUangMuka = new BKUangMukaBeliT();
      $sudahBayar = 0;
      if (!empty($modFakturBeli)) {
        $modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
        if (isset($modFakturBeli->penerimaanbarang_id)) {
          $modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));
          if (!empty($modUangMuka)) {
            $modelBayar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
            $modBuktiKeluar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
            $uangMuka = ((isset($modUangMuka->jumlahuang)) ? $modUangMuka->jumlahuang : 0);
          } else {
            $modUangMuka = new BKUangMukaBeliT();
          }
        }

        $modBayar = BKBayarkeSupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
        if (count((array)$modBayar) > 0) {
          foreach ($modBayar as $key => $value) {
            $sudahBayar += $value->jmldibayarkan;
          }
        }
      }
      $modelBayar->fakturpembelian_id = $fakturpembelian_id;
      $modelBayar->totaltagihan = $modFakturBeli->totalhargabruto - $sudahBayar;

      $modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
      $modelBayar->sudahbayar = $sudahBayar;
      $modBuktiKeluar->tahun = date('Y');
      $modBuktiKeluar->nokaskeluar = '-- Otomatis --';
      $modBuktiKeluar->namapenerima = $modFakturBeli->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modFakturBeli->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';
      $modBuktiKeluar->biayaadministrasi = $modFakturBeli->biayamaterai;
      $modBuktiKeluar->jmlkaskeluar = $modelBayar->jmldibayarkan + $modBuktiKeluar->biayaadministrasi;
    } else if (!empty($id)) {
      $modelBayar = BKBayarkeSupplierT::model()->findByPk($id);
      //var_dump($modelBayar->fakturpembelian_id);die;
      $modFakturBeli = BKFakturPembelianT::model()->findByPk($modelBayar->fakturpembelian_id);
      $modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
      $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($modelBayar->tandabuktikeluar_id);
      $modUangMuka = new BKUangMukaBeliT;
    } else {
      $modFakturBeli = new BKFakturPembelianT;
      $modDetailBeli = array();
      $modUangMuka = new BKUangMukaBeliT;
      $modelBayar = new BKBayarkeSupplierT;
      $modBuktiKeluar = new BKTandabuktikeluarT;
      $modBuktiKeluar->tahun = date('Y');
      $modBuktiKeluar->nokaskeluar = '-- Otomatis --';
    }

    //		var_dump($modelBayar->bayarkesupplier_id);die;

    if (isset($_POST['BKBayarkeSupplierT']) && (!isset($modFakturBeli->bayarkesupplier_id))) {
      //		
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $uangMuka = $_POST['BKUangMukaBeliT']['jumlahuang'];
        $modelBayar = $this->saveBayarSupplier($_POST['BKBayarkeSupplierT'], $modelBayar);
        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT'], $modelBayar, $modBuktiKeluar);
        $this->updateBayarSupplier($modelBayar, $modBuktiKeluar);
        $sisa = ($modelBayar->totaltagihan - $modelBayar->jmldibayarkan - $uangMuka);
        if ($sisa < 1) {
          $update = FakturpembelianT::model()->updateByPk($modelBayar->fakturpembelian_id, array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id));
        }

        if (isset($_POST['BKFakturPembelianT']['adapembayaran'])) {

          if ($_POST['BKFakturPembelianT']['adapembayaran'] == 'tidak') {
            $fakturAwal = FakturpembelianT::model()->findByPk($modelBayar->fakturpembelian_id);
            $fakturDetAwal = FakturdetailT::model()->findAll(" fakturpembelian_id = '" . $modelBayar->fakturpembelian_id . "' ");

            if (isset($_POST['BKFakturPembelianT'])) {
              if (!empty($_POST['BKFakturPembelianT']['nofaktur_ubah'])) {
                $_POST['BKFakturPembelianT']['nofaktur'] = $_POST['BKFakturPembelianT']['nofaktur_ubah'];
              }
              $ok = $ok && FakturpembelianT::model()->updateByPk($modelBayar->fakturpembelian_id, $_POST['BKFakturPembelianT']);
              $this->simpanFaktur = $this->simpanFaktur && $ok;
            }
            //penerimaan barang
            $terimabarang = PenerimaanbarangT::model()->findByPk($modelBayar->fakturpembelian->penerimaanbarang_id);

            $totTerimaDet = 0;

            $fakturAkhir = FakturpembelianT::model()->findByPk($modelBayar->fakturpembelian_id);

            if (isset($_POST['BKFakturDetailT'])) {

              $fakturDetAkhir = $_POST['BKFakturDetailT'];
              $tempNewDet = array();
              foreach ($_POST['BKFakturDetailT'] as $i => $val) {
                $modFakturDet = BKFakturDetailT::model()->findByPk($val['fakturdetail_id']);

                if (!empty($modFakturDet)) {
                  $modFakturDet->attributes = $val;
                  $ok = $ok && $modFakturDet->save();

                  $this->simpanFakturDet = $this->simpanFakturDet && $ok;

                  $stokOa = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id' => $modFakturDet->penerimaandetail_id));
                  $stokOa->qtystok_in = $modFakturDet->jmlterima;
                  $stokOa->update_time = date('Y-m-d H:i:s');
                  $stokOa->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                  $ok = $ok && $stokOa->update();



                  $this->stokobatalkestersimpan &= $ok;
                } else {
                  $modTrmDet = new PenerimaandetailT();
                  $modTrmDet->attributes = $val;
                  $modTrmDet->penerimaanbarang_id = $terimabarang->penerimaanbarang_id;
                  $modTrmDet->jmlpermintaan = 0;
                  $modTrmDet->harganettoper = $val['harganettofaktur'];
                  $modTrmDet->hargasatuanper = $val['hargasatuan'];
                  $modTrmDet->persenppn = $val['persenppnfaktur'];
                  $modTrmDet->persenpph = $val['persenppnfaktur'];
                  $modTrmDet->biaya_lainlain = 0;
                  $ok = $ok && $modTrmDet->save();
                  $this->simpanTerimaBarangDet = $this->simpanTerimaBarangDet && $ok;

                  if ($this->simpanTerimaBarangDet) {
                    $this->simpanStokObatAlkes($modTrmDet, $val, $terimabarang);
                  }


                  if ($ok) {
                    $modFakturDet = new BKFakturDetailT;
                    $modFakturDet->attributes = $val;
                    $modFakturDet->penerimaandetail_id = $modTrmDet->penerimaandetail_id;
                    $modFakturDet->fakturpembelian_id = $modelBayar->fakturpembelian_id;
                    //	var_dump($modFakturDet->attributes);
                    $ok = $ok && $modFakturDet->save();

                    $this->simpanFakturDet = $this->simpanFakturDet && $ok;

                    if ($fakturAwal->totalhargabruto != $fakturAkhir->totalhargabruto) {
                      $tempNewDet[] = $modFakturDet->attributes;
                    }

                    if ($ok) {

                      $ok = $ok && GFPenerimaanDetailT::model()->updateByPk($modTrmDet->penerimaandetail_id, array('fakturdetail_id' => $modFakturDet->fakturdetail_id));
                      $this->simpanTerimaBarangDet = $this->simpanTerimaBarangDet && $ok;
                    }
                  }

                  //die;

                  $totTerimaDet++;
                }
              }
            }


            if ($totTerimaDet > 0) {
              $penerimaanDet = PenerimaandetailT::model()->findAll(" penerimaanbarang_id = '" . $terimabarang->penerimaanbarang_id . "' ");

              $totterima_harganetto = 0;
              $totterima_jmldiscount = 0;
              $totterima_persendiscount = 0;
              $totterima_totalpajakppn = 0;
              $totterima_totalpajakpph = 0;
              $totterima_totalharga = 0;
              foreach ($penerimaanDet as $dettrm) {
                $totterima_harganetto += ($dettrm->harganettoper * $dettrm->jmlterima);
                $totterima_jmldiscount += ($dettrm->jmlterima * $dettrm->jmldiscount);
              }

              $persendis = round(($totterima_jmldiscount / $totterima_harganetto) * 100, 2);

              $netto_diskon = $totterima_harganetto - $totterima_jmldiscount;

              $totterima_totalpajakppn = round(($netto_diskon * $_POST['BKFakturPembelianT']['persenppn']) / 100);

              $totalseluruh = $netto_diskon + $totterima_totalpajakppn;


              $terimabarang->supplier_id = $_POST['BKFakturPembelianT']['supplier_id'];
              $terimabarang->harganetto = $totterima_harganetto;
              $terimabarang->jmldiscount = $totterima_jmldiscount;
              $terimabarang->persendiscount = $persendis;
              $terimabarang->totalpajakppn = $totterima_totalpajakppn;
              $terimabarang->totalpajakpph = $totterima_totalpajakpph;
              $terimabarang->totalharga = $totalseluruh;

              //var_dump($terimabarang->attributes);
              //							die;

              $ok = $ok && $terimabarang->save();
              $this->simpanTerimaBarang = $this->simpanTerimaBarang && $ok;
            } else {
              $terimabarang->supplier_id = $_POST['BKFakturPembelianT']['supplier_id'];

              $ok = $ok && $terimabarang->save();
              $this->simpanTerimaBarang = $this->simpanTerimaBarang && $ok;
            }

            //insert ke riwayat perubahan faktur

            //var_dump('asd');die;
            if ($fakturAwal->totalhargabruto != $fakturAkhir->totalhargabruto) {
              $ubahFaktur = new UbahfakturbeliR;
              $ubahFaktur->fakturpembelian_id = $fakturAwal->fakturpembelian_id;
              $ubahFaktur->pegawai_id = Yii::app()->user->getState('pegawai_id');
              $ubahFaktur->supplier_awal = $fakturAwal->supplier_id;
              $ubahFaktur->supplier_akhir = $fakturAkhir->supplier_id;
              $ubahFaktur->nofaktur_awal = $fakturAwal->nofaktur;
              $ubahFaktur->nofaktur_akhir = $fakturAkhir->nofaktur;
              $ubahFaktur->totharganetto_awal = $fakturAwal->totharganetto;
              $ubahFaktur->totharganetto_akhir = $fakturAkhir->totharganetto;
              $ubahFaktur->jmldiscount_awal = $fakturAwal->jmldiscount;
              $ubahFaktur->jmldiscount_akhir = $fakturAkhir->jmldiscount;
              $ubahFaktur->totalpajakppn_awal = $fakturAwal->totalpajakppn;
              $ubahFaktur->totalpajakppn_akhir = $fakturAkhir->totalpajakppn;
              $ubahFaktur->totalhargabrutto_awal = $fakturAwal->totalpajakppn;
              $ubahFaktur->totalhargabrutto_akhir = $fakturAkhir->totalhargabruto;
              $ubahFaktur->create_time = date('Y-m-d H:i:s');
              $ubahFaktur->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

              $ok = $ok && $ubahFaktur->save();



              foreach ($fakturDetAwal as $detAwal) {
                foreach ($fakturDetAkhir as $detAkhir) {
                  if ($detAwal->fakturdetail_id == $detAkhir['fakturdetail_id']) {
                    $ubahFakturDet = new UbahfakturbelidetR();
                    $ubahFakturDet->ubahfakturbeli_id = $ubahFaktur->ubahfakturbeli_id;
                    $ubahFakturDet->fakturdetail_id = $detAwal->fakturdetail_id;
                    $ubahFakturDet->obatalkes_id = $detAwal->obatalkes_id;
                    $ubahFakturDet->jmlterima_awal = $detAwal->jmlterima;
                    $ubahFakturDet->jmlterima_akhir = $detAkhir['jmlterima'];
                    $ubahFakturDet->harganettofaktur_awal = $detAwal->harganettofaktur;
                    $ubahFakturDet->harganettofaktur_akhir = $detAkhir['harganettofaktur'];
                    $ubahFakturDet->jmldiscount_awal = $detAwal->jmldiscount;
                    $ubahFakturDet->jmldiscount_akhir = $detAkhir['jmldiscount'];
                    $ubahFakturDet->persenppnfaktur_awal = $detAwal->persenppnfaktur;
                    $ubahFakturDet->persenppnfaktur_akhir = $detAkhir['persenppnfaktur'];
                    $ubahFakturDet->hargasatuan_awal = $detAwal->hargasatuan;
                    $ubahFakturDet->hargasatuan_akhir = $detAkhir['hargasatuan'];
                    $ubahFakturDet->create_time = date("Y-m-d H:i:s");
                    $ubahFakturDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                    $ok = $ok && $ubahFakturDet->save();
                  }
                }

                if (isset($_POST['delete'])) {
                  foreach ($_POST['delete']['fakturdetail_id'] as $idxdel => $deldet) {
                    if (!empty($deldet)) {
                      if ($detAwal->fakturdetail_id == $deldet) {
                        $ubahFakturDet = new UbahfakturbelidetR();
                        $ubahFakturDet->ubahfakturbeli_id = $ubahFaktur->ubahfakturbeli_id;
                        $ubahFakturDet->fakturdetail_id = $detAwal->fakturdetail_id;
                        $ubahFakturDet->obatalkes_id = $detAwal->obatalkes_id;
                        $ubahFakturDet->jmlterima_awal = $detAwal->jmlterima;
                        $ubahFakturDet->jmlterima_akhir = 0;
                        $ubahFakturDet->harganettofaktur_awal = $detAwal->harganettofaktur;
                        $ubahFakturDet->harganettofaktur_akhir = 0;
                        $ubahFakturDet->jmldiscount_awal = $detAwal->jmldiscount;
                        $ubahFakturDet->jmldiscount_akhir = 0;
                        $ubahFakturDet->persenppnfaktur_awal = $detAwal->persenppnfaktur;
                        $ubahFakturDet->persenppnfaktur_akhir = 0;
                        $ubahFakturDet->hargasatuan_awal = $detAwal->hargasatuan;
                        $ubahFakturDet->hargasatuan_akhir = 0;
                        $ubahFakturDet->create_time = date("Y-m-d H:i:s");
                        $ubahFakturDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $ubahFakturDet->ishapus = TRUE;

                        $ok = $ok && $ubahFakturDet->save();
                      }
                    }
                  }
                }
              }

              //cek ada tambah data faktur detail baru
              foreach ($tempNewDet as $idx => $det) {

                $ubahFakturDet = new UbahfakturbelidetR();
                $ubahFakturDet->ubahfakturbeli_id = $ubahFaktur->ubahfakturbeli_id;
                $ubahFakturDet->fakturdetail_id = $det['fakturdetail_id'];
                $ubahFakturDet->obatalkes_id = $det['obatalkes_id'];
                $ubahFakturDet->jmlterima_awal = 0;
                $ubahFakturDet->jmlterima_akhir = $det['jmlterima'];
                $ubahFakturDet->harganettofaktur_awal = 0;
                $ubahFakturDet->harganettofaktur_akhir = $det['harganettofaktur'];
                $ubahFakturDet->jmldiscount_awal = 0;
                $ubahFakturDet->jmldiscount_akhir = $det['jmldiscount'];
                $ubahFakturDet->persenppnfaktur_awal = 0;
                $ubahFakturDet->persenppnfaktur_akhir = $det['persenppnfaktur'];
                $ubahFakturDet->hargasatuan_awal = 0;
                $ubahFakturDet->hargasatuan_akhir = $det['hargasatuan'];
                $ubahFakturDet->create_time = date("Y-m-d H:i:s");
                $ubahFakturDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $ubahFakturDet->istambah = TRUE;


                $ok = $ok && $ubahFakturDet->save();
              }

              $fakturAkhir->fakturberubah = TRUE;
              //$fakturAwal->supplier_id = $fakturAkhir->supplier_id;
              $ok = $ok && $fakturAkhir->update();
            }



            if (isset($_POST['delete'])) {
              foreach ($_POST['delete']['fakturdetail_id'] as $idxx => $itemdel) {
                if (!empty($itemdel)) {
                  $det = BKFakturDetailT::model()->findByPk($itemdel);

                  $ok = $ok && $det->delete();

                  $this->simpanDeleteFakturDet =  $this->simpanDeleteFakturDet && $ok;
                }
              }

              foreach ($_POST['delete']['penerimaandetail_id'] as $idxx => $itemdel) {
                if (!empty($itemdel)) {
                  $stokOaDel = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id' => $itemdel));

                  $ok = $ok && $stokOaDel->delete();

                  $this->simpanDeleteStokOa =  $this->simpanDeleteStokOa && $ok;
                }
              }
            }
          }
        }

        if ($this->successSave && $ok) {
          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            $modelBayar = BayarkesupplierT::model()->findByPk($modelBayar->bayarkesupplier_id);
            $modJurnalRekening = $this->saveJurnalRekening($modelBayar);
            $modFakturJurnal = JurnalrekeningT::model()->findByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
            $modFakturJurnalDetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $modFakturJurnal->jurnalrekening_id), array('order' => 'nourut ASC'));
            $rekening5_id = null;
            $nourutJurnal = 2;

            if (count((array)$modFakturJurnalDetail) > 0) {
              foreach ($modFakturJurnalDetail as $datadetailjurnal) {
                if ($datadetailjurnal->saldokredit > 0) {
                  $rekening5_id = $datadetailjurnal->rekening5_id;
                }
              }
            }

            if (!empty($rekening5_id)) {
              //Debit jurnal rekening mengambil dari transaksi faktur
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
              //Debit Biaya Ongkos Kirim
              $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_BIAYAONGKOSKIRIM . "'");
              if (isset($rekeningcolumn)) {
                $this->saveJurnalDetail($modJurnalRekening, $rekeningcolumn->rekening5_id, $modelBayar->tandabuktikeluar->biayaongkos_kirim, 'D', 2);
              }
            }

            if (!empty($modelBayar->tandabuktikeluar->carabayarkeluar)) {
              //Kredit Carabayarkeluar

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

          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          if (empty($frame)) {
            $this->redirect(array('index', 'id' => $modelBayar->bayarkesupplier_id, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'frame' => 1, 'idFakturPembelian' => $modelBayar->fakturpembelian_id, 'id' => $modelBayar->bayarkesupplier_id, 'sukses' => 1));
          }
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan err(1)");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }

    $this->render($this->path_view . 'indexBaruDesimal', array(
      'modFakturBeli' => $modFakturBeli,
      'modDetailBeli' => $modDetailBeli,
      'modelBayar' => $modelBayar,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modUangMuka' => $modUangMuka,
    ));
  }

  /**
   * method untuk save pembayaran ke supplier 
   * digunakan di
   * 1. PembayaranSupplier/index
   * @param array $postBayarSupplier post request $_POST['BKBayarkeSupplierT']
   * @param obj $modBayar BKBayarkeSupplierT
   * @return object BKBayarkeSupplierT
   */
  protected function saveBayarSupplier($postBayarSupplier, $modBayar)
  {
    $format = new MyFormatter();
    $modBayar->attributes = $postBayarSupplier;
    $modBayar->tglbayarkesupplier = $format->formatDateTimeForDb($postBayarSupplier['tglbayarkesupplier']);
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
   * 1. PembayaranSupplier/index
   * @param array $postBuktiKeluar post request $_POST['BKTandaBuktiKeluarT']
   * @param object $modBayarSupplier BKBayarSupplierT
   * @param object $modBuktiKeluar BKTandaBuktiKeluarT
   * @return object BKTandaBuktiKeluarT
   */
  protected function saveBuktiKeluar($postBuktiKeluar, $modBayarSupplier, $modBuktiKeluar)
  {
    $format = new MyFormatter();

    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->bayarkesupplier_id = $modBayarSupplier->bayarkesupplier_id;
    $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($postBuktiKeluar['tglkaskeluar']);
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tahun = date('Y');
    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function updateBayarSupplier($modBayarSupplier, $modBuktiKeluar)
  {
    BKBayarkeSupplierT::model()->updateByPk($modBayarSupplier->bayarkesupplier_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
  }

  public function actionPrint($id)
  {
    $judulKuitansi = '----- Tanda Bukti Bayar Hutang -----';
    $judul_print = '----- Tanda Bukti Bayar Hutang -----';
    $format = new MyFormatter();
    $modelBayar = BKBayarkeSupplierT::model()->findByPk($id);
    $modFakturBeli = BKFakturPembelianT::model()->findByPk($modelBayar->fakturpembelian_id);
    $modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
    $modelBayar = BKBayarkeSupplierT::model()->findByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
    $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($modelBayar->tandabuktikeluar_id);
    $modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'PrintBaru', array(
      'judulKuitansi' => $judulKuitansi,
      'judul_print' => $judul_print,
      'caraPrint' => $caraPrint,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modFakturBeli' => $modFakturBeli,
      'modDetailBeli' => $modDetailBeli,
      'modelBayar' => $modelBayar,
      'modUangMuka' => $modUangMuka,
    ));
  }


  public function actionAutocompleteFakturFarmasi($no_faktur)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $dat = new BKInformasifakturpembelianV;
      $dat->nofaktur = $no_faktur;
      $prov = $dat->searchInformasiUmum();

      $returnVal = array();
      foreach ($prov->data as $i => $item) {
        $returnVal[$i]['label'] = $item->nofaktur . ' - ' . $item->supplier_nama . ' - ' .  MyFormatter::formatDateTimeForUser($item->tglfaktur);
        $returnVal[$i]['value'] = $item->fakturpembelian_id;
        $returnVal[$i]['label2'] = $item->nofaktur;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadFakturFarmasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $fakturpembelian_id = $_POST['id'];
      $modelBayar = new BKBayarkeSupplierT;
      $modBuktiKeluar = new BKTandabuktikeluarT;
      $modFakturBeli = BKFakturPembelianT::model()->findByPk($fakturpembelian_id);
      $uangMuka = 0;
      $modUangMuka = new BKUangMukaBeliT();
      $sudahBayar = 0;
      if (!empty($modFakturBeli)) {
        $modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
        if (isset($modFakturBeli->penerimaanbarang_id)) {
          $modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));
          if (!empty($modUangMuka)) {
            $modelBayar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
            $modBuktiKeluar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
            $uangMuka = ((isset($modUangMuka->jumlahuang)) ? $modUangMuka->jumlahuang : 0);
          } else {
            $modUangMuka = new BKUangMukaBeliT();
          }
        }

        $modBayar = BKBayarkeSupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
        if (count((array)$modBayar) > 0) {
          foreach ($modBayar as $key => $value) {
            $sudahBayar += $value->jmldibayarkan;
          }
        }
      }
      $modelBayar->fakturpembelian_id = $fakturpembelian_id;
      $modelBayar->totaltagihan = $modFakturBeli->totalhargabruto - $sudahBayar;
      $modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
      $modBuktiKeluar->tahun = date('Y');
      //$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
      $modBuktiKeluar->namapenerima = $modFakturBeli->supplier->supplier_nama;
      $modBuktiKeluar->alamatpenerima = $modFakturBeli->supplier->supplier_alamat;
      $modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';
      $modBuktiKeluar->biayaadministrasi = $modFakturBeli->biayamaterai;
      $modBuktiKeluar->jmlkaskeluar = $modelBayar->jmldibayarkan + $modBuktiKeluar->biayaadministrasi;

      $uangMuka = MyFormatter::formatNumberForPrint($uangMuka);

      $modFakturBeli->umur_hutang = $modFakturBeli->umurHutang;
      $modFakturBeli->tglfaktur = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modFakturBeli->tglfaktur)));
      $modFakturBeli->tgljatuhtempo = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modFakturBeli->tgljatuhtempo)));
      $modFakturBeli->totalhargabruto = number_format($modFakturBeli->totalhargabruto, 0, "", ".");
      $modFakturBeli->totalpajakppn = number_format($modFakturBeli->totalpajakppn, 0, "", ".");
      $modFakturBeli->totalpajakpph = number_format($modFakturBeli->totalpajakpph, 0, "", ".");
      $modFakturBeli->totharganetto = number_format($modFakturBeli->totharganetto, 0, "", ".");
      $modFakturBeli->jmldiscount = number_format($modFakturBeli->jmldiscount, 0, "", ".");


      $modelBayar->totaltagihan = MyFormatter::formatNumberForPrint($modelBayar->totaltagihan);
      $modelBayar->jmldibayarkan = MyFormatter::formatNumberForPrint($modelBayar->jmldibayarkan);

      $modBuktiKeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar);

      $penerimaan = PenerimaanbarangT::model()->findByPk($modFakturBeli->penerimaanbarang_id);

      $cekBayarSupp = BKBayarkeSupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $modFakturBeli->fakturpembelian_id));

      if (count((array)$cekBayarSupp) > 0) {
        $partial = $this->renderPartial($this->path_view . '_rowFaktur', array('modDetailBeli' => $modDetailBeli), true);
        $ada = true;
      } else {
        $partial = $this->renderPartial($this->path_view . '_rowFakturBaru', array('modDetailBeli' => $modDetailBeli), true);
        $ada = false;
      }


      $res = array(
        'modelBayar' => $modelBayar->attributes,
        'buktiKeluar' => $modBuktiKeluar->attributes,
        'uangMukaDat' => $modUangMuka->attributes,
        'umur_hutang' => $modFakturBeli->umur_hutang,
        'supplier_nama' => $modFakturBeli->supplier->supplier_nama,
        'uangMuka' => $uangMuka,
        'penerimaan' => $penerimaan->attributes,
        'fakturBeli' => $modFakturBeli->attributes,
        'tabFaktur' => $partial,
        'ada' => $ada
      );

      if (!empty($modFakturBeli->supplier_id)) {
        $res['supplier'] = $modFakturBeli->supplier->attributes;
      } else {
        $res['supplier'] = '';
      }

      if (isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)) {
        $res['nopermintaan'] = $modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan;
      } else {
        $res['nopermintaan'] = '';
      }
      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionLoadTambahOA()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $status = $_POST['statusobat'];
      $jumlah = $_POST['jumlah'];
      $supplier_id = $_POST['supplier_id'];
      $tipesatuan = $_POST['tipesatuan'];


      $format = new MyFormatter();
      $modPenerimaanBarang = new BKFakturPembelianT();
      $modPenerimaanBarangDetail = new BKFakturDetailT();

      $modObatAlkes = GFObatalkesM::model()->findByPk($obatalkes_id);
      if (!empty($supplier_id)) {
        $modObatSupplier = GFObatSupplierM::model()->findByAttributes(array('supplier_id' => $supplier_id, 'obatalkes_id' => $obatalkes_id));
      }

      $jmlKemasan = $modObatAlkes->kemasanbesar;

      if ($tipesatuan == Params::SATUANOBAT_BESAR) {
        $jumlah = $jumlah * $jmlKemasan;
        $modPenerimaanBarangDetail->jmlterima = $jumlah;
        $modPenerimaanBarangDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
      } else {
        $modPenerimaanBarangDetail->jmlterima = $jumlah;
        $modPenerimaanBarangDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
      }

      $modPenerimaanBarangDetail->satuanobat = $tipesatuan;

      if ($status == 'supplier') {
        $modPenerimaanBarangDetail->harganettofaktur = $modObatSupplier->hargabelikecil;
      } else {
        $modPenerimaanBarangDetail->harganettofaktur = $modObatAlkes->harganetto;
      }


      $ppnharga = $modPenerimaanBarangDetail->harganettofaktur * (10 / 100);
      $modPenerimaanBarangDetail->hargasatuan = $modPenerimaanBarangDetail->harganettofaktur + $ppnharga;
      $modPenerimaanBarangDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
      $modPenerimaanBarangDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
      $modPenerimaanBarangDetail->persenppnfaktur = Params::DEFAULT_PPN;
      $modPenerimaanBarangDetail->persenpphfaktur = 0;
      $modPenerimaanBarangDetail->harganettoubah = $modPenerimaanBarangDetail->harganettofaktur;
      $modPenerimaanBarangDetail->kemasanbesar = $modObatAlkes->kemasanbesar;

      $modPenerimaanBarangDetail->tglkadaluarsa = $modObatAlkes->tglkadaluarsa;

      $modPenerimaanBarangDetail->satuankecil_nama = $modObatAlkes->satuanKecil;

      echo CJSON::encode(
        array(
          'sukses' => 1,
          'status' => 'create_form',
          'form' => $this->renderPartial(
            $this->path_view . '_rowFakturBaruAdd',
            array(
              'detail' => $modPenerimaanBarangDetail,
              'format' => $format
            ),
            true
          )
        )
      );
      exit;
    }
  }

  public function simpanStokObatAlkes($modPenerimaanDetail, $postOa, $modPenerimaanBarang)
  {
    $format = new MyFormatter;
    $modStok = new GFStokObatAlkesT;
    $loadObatAlkes = GFObatAlkesM::model()->findByPk($modPenerimaanDetail->obatalkes_id);
    $modStok->ruangan_id = $modPenerimaanBarang->gudangpenerima_id;
    $modStok->penerimaandetail_id = $modPenerimaanDetail->penerimaandetail_id;
    $modStok->tglkadaluarsa = !empty($modPenerimaanDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa) : null;
    $modStok->obatalkes_id = $modPenerimaanDetail->obatalkes_id;
    $modStok->tglstok_in = $modPenerimaanBarang->tglterima;
    $modStok->tglstok_out = NULL;

    $harganettolama = $loadObatAlkes->harganetto;
    $hargajuallama = $loadObatAlkes->hargajual;

    if (!empty($modPenerimaanDetail->satuanbesar_id)) {
      //if ($modPenerimaanDetail->kemasanbesar < 1) $modPenerimaanDetail->kemasanbesar = 1;
      $modStok->qtystok_in = $modPenerimaanDetail->jmlterima;
      $modStok->harganetto = round($modPenerimaanDetail->harganettoper);
    } else {
      $modStok->qtystok_in = $modPenerimaanDetail->jmlterima;
      $modStok->harganetto = round($modPenerimaanDetail->harganettoper);
    }

    $modStok->qtystok_out = 0;
    $modStok->persendiscount = $modPenerimaanDetail->persendiscount;
    $modStok->jmldiscount = $modPenerimaanDetail->jmldiscount;
    $modStok->persenppn = $modPenerimaanDetail->persenppn;
    $modStok->persenpph = $modPenerimaanDetail->persenpph;
    $modStok->persenmargin = $loadObatAlkes->margin;

    $jmlmargin = round($modPenerimaanDetail->hargasatuanper) * ($modStok->persenmargin / 100);
    $modStok->jmlmargin = round($jmlmargin);

    //$modStok->jmlmargin = 0;
    $modStok->create_time = $modPenerimaanBarang->create_time;
    $modStok->create_loginpemakai_id = Yii::app()->user->id;
    $modStok->create_ruangan = $modPenerimaanBarang->gudangpenerima_id;
    $modStok->tglterima = $modPenerimaanDetail->penerimaanbarang->tglterima;
    $modStok->satuankecil_id = (!empty($modPenerimaanDetail->satuankecil_id) ? $modPenerimaanDetail->satuankecil_id : $loadObatAlkes->satuankecil_id);

    // var_dump($modStok->attributes); die;
    $ok = true && $modStok->save();

    //var_dump($modStok->getErrors());

    $this->stokobatalkestersimpan =  $this->stokobatalkestersimpan && $ok;

    return $ok;
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
    $modJurnalRekening->urianjurnal = 'Pembayaran Faktur Farmasi Ke Supplier ' . (!empty($model->fakturpembelian->supplier_id) ? $model->fakturpembelian->supplier->supplier_nama : "") . " - " . $model->fakturpembelian->nofaktur;

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
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut)
  {
    $valid = true;
    //            $modJurnalPosting = null;
    $rekening5 = Rekening5M::model()->findByPk($rekening5_id);
    $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

    //            if(Yii::app()->user->getState('ispostingotomatis'))
    //            {
    //                $modJurnalPosting = new JurnalpostingT;
    //                $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //                $modJurnalPosting->keterangan = "Posting automatis";
    //                $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //                $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //                $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //                if($modJurnalPosting->validate()){
    //                    $modJurnalPosting->save();
    //                }
    //            }

    $modelJurnalDetail = new JurnaldetailT();
    //            $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5->rekening5_id;
    $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
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
