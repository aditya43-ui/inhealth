<?php

class PembayaranKlaimPiutangController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'Index';
  public $path_view = 'billingKasir.views.pembayaranKlaimPiutang.';
  public $path_view_bk = 'billingKasir.views.';
  protected $succesSave = true;

  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . ' - Transaksi Pembayaran Klaim / Piutang';

    $modPembayaranKlaim = new BKPembayaranklaimT;
    $modPembayaranKlaimDetail = new BKPembayarklaimdetailT;
    $modTandabukti = new TandabuktibayarT;
    $modPembayaranPelayanan = new PembayaranpelayananT;
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $format = new MyFormatter();
    $modPendaftaran->tgl_awal = date('Y-m-d');
    $modPendaftaran->tgl_akhir = date('Y-m-d');
    $modPengajuanKlaim = new BKPengajuanklaimpiutangT();
    $modPembayaranKlaim->tglpembayaranklaim = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $modPembayaranKlaim->nopembayaranklaim = "Otomatis";

    $tr = '';
    $modDetails = '';

    // $modTandabukti = '';
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if (isset($_GET['id'])) {
      $modPembayaranKlaim = BKPembayaranklaimT::model()->findByPk($id);
    }

    if (isset($_POST['BKPembayaranklaimT'])) {
      $modPembayaranKlaim->attributes = $_POST['BKPembayaranklaimT'];
      $modPembayaranKlaim->nopembayaranklaim = MyGenerator::noPembayaranKlaim();
      $modPembayaranKlaim->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
      $modPembayaranKlaim->penjamin_id = Params::PENJAMIN_ID_UMUM;
      if (count((array)$_POST['BKPembayarklaimdetailT']) > 0) {
        $pembayaranpelayanan_id = $this->sortPilih($_POST['BKPembayarklaimdetailT']);
        // $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['BKPembayarklaimdetailT']);
        foreach ($_POST['BKPembayarklaimdetailT'] as $item) {
          if (isset($item['carabayar_id']) && !empty($item['carabayar_id'])) {
            $modPembayaranKlaim->carabayar_id = $item['carabayar_id'];
          }
          if (isset($item['penjamin_id']) && !empty($item['penjamin_id'])) {
            $modPembayaranKlaim->penjamin_id = $item['penjamin_id'];
          }
        }
      }
      $modPembayaranKlaim->tglpembayaranklaim = MyFormatter::formatDateTimeForDb($modPembayaranKlaim->tglpembayaranklaim);
      $pengajuan_id = null;
      
      if ($modPembayaranKlaim->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;
          if ($modPembayaranKlaim->save()) {
            $success = $success && $this->simpanTandaBukti($modPembayaranKlaim, $modTandabukti);

            $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['BKPembayarklaimdetailT']);
            $pengajuan = null;
            
            foreach ($modDetails as $i => $data) {
                
                if (empty($pengajuan)) {
                    $pengajuandetMod = PengajuanklaimdetailT::model()->findByPk($data->pengajuanklaimdetail_id);
                    $pengajuan = PengajuanklaimpiutangT::model()->findByPk($pengajuandetMod->pengajuanklaimpiutang_id);
                    
                    $modPembayaranKlaim->carabayar_id = $pengajuan->carabayar_id;
                    $modPembayaranKlaim->penjamin_id = $pengajuan->penjamin_id;
                    $modPembayaranKlaim->save();
                }
                
                
              if ($data->pembayaranpelayanan_id > 0) {
                if ($data->save()) {
                  if ($modPembayaranKlaim->totalsisapiutang == 0) {
                    $pengajuandet = PengajuanklaimdetailT::model()->findByPk($data->pengajuanklaimdetail_id);
                    $pengajuan_id = $pengajuandet->pengajuanklaimpiutang_id;
                    PengajuanklaimpiutangT::model()->updateByPk($pengajuandet->pengajuanklaimpiutang_id, array(
                      'pembayarklaim_id' => $modPembayaranKlaim->pembayarklaim_id
                    ));
                  }
                  PembayaranpelayananT::model()->updateByPk($data->pembayaranpelayanan_id, array('pembklaimdetal_id' => $data->pembklaimdetal_id));
                } else {
                  $success = false;
                }
              }
            }

            //proses simpan jurnal
            if (isset($_POST['RekeningakuntansiV'])) {
              $postPenUmum = null;
              $modJurnalRekening = $this->saveJurnalRekening($modPembayaranKlaim, $postPenUmum, $pengajuan_id);
              $modJurnalDetail = $this->saveJurnalDetail($_POST['BKPembayaranklaimT'], $modJurnalRekening, $modJurnalPosting = null, $_POST['RekeningakuntansiV']);
            }
          }

          if ($success == true) {

            $this->notifBayarKlaim($modPembayaranKlaim);

            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
            $this->redirect(array('index', 'id' => $modPembayaranKlaim->pembayarklaim_id));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . $ex->getMessage());
        }
      } else {
        Yii::app()->user->setFlash('error', 'Data detail barang harus diisi.');
      }
    }

    if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id'])) && (isset($_GET['pengajuanklaimpiutang_id']))) {
      if (Yii::app()->request->isAjaxRequest) {
        $tgl_awal = $format->formatDateTimeForDb($_GET['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
        $pengajuanklaimpiutang_id = isset($_GET['pengajuanklaimpiutang_id']) ? $_GET['pengajuanklaimpiutang_id'] : null;
        $carabayar_id = isset($_GET['carabayar_id']) ? $_GET['carabayar_id'] : null;
        $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
        $pembklaimdetal_id = isset($_GET['pembklaimdetal_id']) ? $_GET['pembklaimdetal_id'] : null;
        $tr = $this->createList($tgl_awal, $tgl_akhir, $pengajuanklaimpiutang_id, $carabayar_id, $penjamin_id, true);
        echo $tr;
        Yii::app()->end();
      }
    }

    if (isset($_GET['pengajuanklaim_id'])) {
      $pengajuanklaimpiutang_id = $_GET['pengajuanklaim_id'];
      $modPengajuanKlaim = $modPengajuanKlaim->findByPk($pengajuanklaimpiutang_id);
      $modPendaftaran->carabayar_id = $modPengajuanKlaim->carabayar_id;
      $modPendaftaran->penjamin_id = $modPengajuanKlaim->penjamin_id;

      $modPengajuanKlaim->carabayar_nama = $modPengajuanKlaim->carabayar->carabayar_nama ?? null;
      $modPengajuanKlaim->penjamin_nama = $modPengajuanKlaim->penjamin->penjamin_nama ?? null;

      $tr = $this->createList(null, null, $_GET['pengajuanklaim_id'], null, null, true);
    }

    if (isset($pengajuanklaimpiutang_id) && !empty($pengajuanklaimpiutang_id)) {
      $citeriaBayarKe = new CDbCriteria();
      $citeriaBayarKe->select = "t.pembayarklaim_id";
      $citeriaBayarKe->group = "t.pembayarklaim_id";
      $citeriaBayarKe->join = "JOIN pembklaimdetal_t pemdet ON pemdet.pembayarklaim_id = t.pembayarklaim_id "
        . "JOIN pengajuanklaimdetail_t pengdet ON pengdet.pengajuanklaimdetail_id = pemdet.pengajuanklaimdetail_id "
        . "JOIN pengajuanklaimpiutang_t peng ON peng.pengajuanklaimpiutang_id = pengdet.pengajuanklaimpiutang_id";
      $citeriaBayarKe->addCondition('peng.pengajuanklaimpiutang_id = ' . $pengajuanklaimpiutang_id);
      $modBayarKe = PembayarklaimT::model()->findAll($citeriaBayarKe);

      if (isset($modBayarKe) && count((array)$modBayarKe) > 0) {
        $modPembayaranKlaim->bayarke = count((array)$modBayarKe) + 1;
      }
    }


    $this->render($this->path_view . 'index', array(
      'modPembayaranKlaim' => $modPembayaranKlaim,
      'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'modTandabukti' => $modTandabukti,
      'tr' => $tr,
      'modDetails' => $modDetails,
      'format' => $format,
      'modPengajuanKlaim' => $modPengajuanKlaim,
      'linkHalaman' => $linkHalaman
      //'pembayaran'=>$pembayaran,
    ));
  }

  protected function notifBayarKlaim($model)
  {
    $judul = "Pembayaran Klaim Piutang - " . $model->nopembayaranklaim;

    $isi = "Tgl. Pengajuan Klaim : " . MyFormatter::formatDateTimeForUser($model->tglpembayaranklaim) . "<br/>";
    $isi .= "Total Pembayaran : " . MyFormatter::formatNumberForPrint($model->totalbayar) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    //$ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //    array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    ));
  }

  protected function simpanTandaBukti(&$modPembayaranKlaim, &$model)
  {

    $penjamin = PenjaminpasienM::model()->findByPk($modPembayaranKlaim->penjamin_id);
    $ok = true;

    $model = new TandabuktibayarT;
    $model->attributes = $modPembayaranKlaim->attributes;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->nobuktibayar = MyGenerator::noBuktiBayar();
    $model->tglbuktibayar = $modPembayaranKlaim->tglpembayaranklaim;
    $model->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
    $model->darinama_bkm = $penjamin->penjamin_nama;
    $model->alamat_bkm = '-';
    $model->sebagaipembayaran_bkm = 'Pembayaran Klaim Asuransi';
    $model->jmlpembayaran = $modPembayaranKlaim->totalbayar;

    if (isset($_POST['TandabuktibayarT']['bank_id'])) {
      $model->bank_id = $_POST['TandabuktibayarT']['bank_id'];
    }

    if ($modPembayaranKlaim->pembayaranmelalui == "TRANSFER") {
      $model->bank_nominal = $model->jmlpembayaran;
      $model->dengankartu = $modPembayaranKlaim->pembayaranmelalui;
      $model->bank_nama = $modPembayaranKlaim->namabank;
      $model->nokartu = $modPembayaranKlaim->norekbank;
      $model->nostrukkartu = $modPembayaranKlaim->nobuktisetor;
      $model->uangditerima = 0;
    } else {
      $model->uangditerima = $model->jmlpembayaran;
      $model->bank_nominal = 0;
    }

    $model->biayaadministrasi = $model->jmlpembulatan = 0;
    $model->uangkembalian = $model->biayaadministrasi = $model->biayamaterai = 0;
    $model->nourutkasir = MyGenerator::noUrutKasir($model->ruangan_id);

    if ($model->validate()) {
      $ok = $ok && $model->save();
      $modPembayaranKlaim->tandabuktibayar_id = $model->tandabuktibayar_id;
      $modPembayaranKlaim->save();
    } else {
      $ok = false;
    }
    return $ok;
  }

  protected function rowPengeluaran($pengeluaran, $totaltransaksi, $tr, $text = null)
  {
    if (count((array)$pengeluaran) > 0) {
      foreach ($pengeluaran as $i => $row) {

        $bkm = PembayaranpelayananT::model()->findByPk($row->pembayaranpelayanan_id);
        $bkm2 = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => $row->pembayaranpelayanan_id));
        $bayar_klaim = PembklaimdetalT::model()->findAllByAttributes(array(
          'pembayaranpelayanan_id' => $row->pembayaranpelayanan_id,
          'pengajuanklaimdetail_id' => $row->pengajuanklaimdetail_id,
        ));

        $jumlahPiutang = $row->jumlahbayar;

        $cek = PengajuanklaimdetailT::model()->findByAttributes(array('pembayaranpelayanan_id' => $row->pembayaranpelayanan_id));
        $jmlbayar = 0;
        $jmltelahbayar = 0;
        $jmlsisapiutang = 0;

        foreach ($bayar_klaim as $item) {
          $jmltelahbayar += $item->jumlahbayar;
        }

        // var_dump($jmltelahbayar, $jumlahPiutang);

        $jmlsisapiutang = $jumlahPiutang - $jmltelahbayar;

        if ($jmlsisapiutang <= 0)
          continue;

        if (!empty($cek)) {
          $klaim = $cek->pengajuanklaimdetail_id;

          $bayar = BKPembayarklaimdetailT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $row->pembayaranpelayanan_id, 'pengajuanklaimdetail_id' => $cek->pengajuanklaimdetail_id));

          foreach ($bayar as $byr) {
            $jmltelahbayar = $jmltelahbayar + $byr->jmltelahbayar;
          }
        } else {
          $klaim = null;
        }
        $i++;
        $totaltransaksi = count((array)$pengeluaran);
        $biayapelayanan = 0;
        //$biayapelayanan += $row->totalbiayapelayanan;                    
        //$jmlsisapiutang = $row->totalbiayapelayanan - $jmltelahbayar;
        $jmlbayar = $jmlsisapiutang;

        $sisa = $jmlsisapiutang - $jmlbayar;

        if ($jmlsisapiutang <= 0)
          continue;

        $detail_link = Yii::app()->createUrl('/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar', array(
          'pembayaranpelayanan_id' => $bkm->pembayaranpelayanan_id,
          'frame' => 1,
        ));

        $tr .= '<tr >';
        $tr .= '<td>' . $i . '</td>';
        $tr .= '<td>' . MyFormatter::formatDateTimeForUser($bkm->pendaftaran->tgl_pendaftaran) . "<br/>" . $bkm->pendaftaran->no_pendaftaran . '</td>';
        $tr .= '<td>' . CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($bkm->tglpembayaran) . "<br/>" . $bkm->nopembayaran . '</u>', $detail_link, array(
          'target' => 'framePembayaranPasien',
          'onclick' => '$("#dialogPembayaranPasien").dialog("open");',
          'data-toggle' => 'tooltip',
          'title' => 'Rincian Tagihan Sudah Bayar',
        )) . '</td>';
        $tr .= '<td>' . $bkm->pasien->nama_pasien .
          CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pasien_id]', $bkm->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
          '</td>';
        // $tr .= '<td>' . $bkm->pasien->alamat_pasien . '</td>';
        // $tr .= '<td>' . (isset($bkm->pendaftaran->penanggungJawab->nama_pj) ? $bkm->pendaftaran->penanggungJawab->nama_pj : "")."-".(isset($bkm->pendaftaran->penanggungJawab->pengantar) ? $bkm->pendaftaran->penanggungJawab->pengantar : "") . '</td>';
        // $tr .= '<td>' . $bkm->nopembayaran . '</td>';
        // $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][diskonpersen]', 0, array('style'=>'width:70px;','class' => 'inputFormTabel span3 float2','onkeyup'=>'hitungDiskon()','maxlength'=>5)) . '</td>';
        if ($text == true) {
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($bkm->totalbiayapelayanan) . '</td>';
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($bkm->totalsisatagihan) . '</td>';
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($bkm->uangditerima) . '</td>';
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($bkm->totalbayartindakan) . '</td>';
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($bkm->totalsisatagihan) . '</td>';
        } else {
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmltagihan]', MyFormatter::formatNumberForPrint($bkm2->jmlpembayaran), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltagihan integer2 ', 'readonly' => false, 'onkeyup' => 'hitungSemuaTransaksi()', 'readonly' => true)) . '</td>';
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmldiskon]', MyFormatter::formatNumberForPrint($row->jmldiskon), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 diskon integer2 ', 'readonly' => false, 'onkeyup' => 'hitungSemuaTransaksi()', 'readonly' => true)) . '</td>';
          //  $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlpiutang]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlpiutang integer2 ', 'onkeyup' => 'hitungJumlahPiutang(this);', 'readonly'=>true)) . 
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang + $bkm->totalsisatagihan) : MyFormatter::formatNumberForPrint($jumlahPiutang + $bkm->totalsisatagihan)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang integer2 ', 'onkeyup' => 'hitungJumlahPiutang(this);', 'readonly' => true)) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang2]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($bkm->totalsisatagihan) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang2 integer2')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang3]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang3 integer2 ', 'onkeyup' => 'hitungJumlahPiutang(this);', 'readonly' => true)) .
            '</td>';
          //$tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmltelahbayar]', (empty($bkm->pembklaimdetal_id) ? (empty($bkm->detailklaim->telahbayar) ? "0" : MyFormatter::formatNumberForPrint($bkm->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmltelahbayar)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltelahbayar integer2 ', 'onkeyup' => 'hitungJumlahTelahBayar();', 'readonly'=>true)) . '</td>';
          //$tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlbayar]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($bkm->tandabukti->jmlpembayaran) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang - $bkm->detailklaim->jmltelahbayar) ), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlbayar integer2 ', 'onblur' => 'hitungSisaTagihan();')) . '</td>';
          //$tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlsisatagihan]',(empty($bkm->pembklaimdetal_id) ? (empty($bkm->detailklaim->jmlsisapiutang) ? "0" : MyFormatter::formatNumberForPrint($bkm->totalbiayapelayanan - $bkm->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang - ($bkm->detailklaim->jmltelahbayar + ($bkm->detailklaim->jmlpiutang - $bkm->detailklaim->jmltelahbayar)))) , array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlsisatagihan integer2 ', 'onkeyup' => 'hitungSemuaTransaksi();')). '</td>';
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmltelahbayar]', MyFormatter::formatNumberForPrint($jmltelahbayar), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2 ', 'onkeyup' => 'hitungJumlahTelahBayar();', 'readonly' => true)) . '</td>';
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmlbayar]', MyFormatter::formatNumberForPrint($jmlbayar), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2 ', 'onblur' => 'hitungSisaTagihan();')) . '</td>';
          $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', MyFormatter::formatNumberForPrint($sisa), array('readonly' => true, 'style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2 ', 'onkeyup' => 'hitungSemuaTransaksi();')) . '</td>';

          $tr .= '<td>' . CHtml::checkBox('BKPembayarklaimdetailT[' . $i . '][cekList]', true, array('value' => $bkm->pembayaranpelayanan_id, 'class' => 'cek', 'onClick' => 'setCeklisBayarPiutang(this); setAll();')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pendaftaran_id]', $bkm->pendaftaran_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel integer2 span3 jmlsisatagihan',)) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pembayaranpelayanan_id]', $bkm->pembayaranpelayanan_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3 ')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][tandabuktibayar_id]', $bkm->tandabuktibayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][carabayar_id]', $bkm->carabayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][penjamin_id]', $bkm->penjamin_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmldiskon]', $bkm->penjamin_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3 integer2')) .
            CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pengajuanklaimdetail_id]', $klaim, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
            '</td>';
        }
        $tr .= '</tr>';
      }
    }
    return $tr;
  }

  protected function createList($tgl_awal, $tgl_akhir, $pengajuanklaimpiutang_id, $carabayar_id, $penjamin_id, $status = null)
  {
    $criteria = new CDbCriteria();

    if (!empty($pengajuanklaimpiutang_id)) {
      $criteria->addCondition("pengajuanklaimpiutang_id = " . $pengajuanklaimpiutang_id);
    }

    $pengeluaran = PengajuanklaimdetailT::model()->findAll($criteria);

    $tr = $this->rowPengeluaran($pengeluaran, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null);

    return $tr;
  }

  protected function sortPilih($data)
  {
    $result = array();
    foreach ($data as $i => $row) {
      if (isset($row['cekList']) && !empty($row['cekList']) && $row['cekList'] == 1) {
        $result[] = $row['pembayaranpelayanan_id'];
      }
    }

    return $result;
  }

    protected function validasiTabular($modPembayaranKlaim, $data) {
      $modDetails = array();

        foreach ($data as $i => $row) {
            if (isset($row['cekList']) && !empty($row['cekList']) && $row['cekList'] == 1) {
                // var_dump($row); die;
                $modDetails[$i] = new BKPembayarklaimdetailT();
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
//                $modDetails[$i]->pasien_id = $row['pasien_id'];
                $modDetails[$i]->pembayarklaim_id = $modPembayaranKlaim->pembayarklaim_id;
                $modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
                $modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
                //$modDetails[$i]->jmlpiutang = $row['jmlpiutang']-$row['jmlbayar'];
                $modDetails[$i]->jmlpiutang = $row['jmlpiutang'];
                $modDetails[$i]->jumlahbayar = $row['jumlahbayar'];
                $modDetails[$i]->jmltelahbayar = $row['jmltelahbayar'];
                $modDetails[$i]->jmlsisapiutang = $row['jmlsisapiutang'];
                $modDetails[$i]->diskonpersen = 0; //$row['diskonpersen'];
                $modDetails[$i]->jmldiskon = $row['jmldiskon']; //$row['jmldiskon'];
                $modDetails[$i]->validate();
            }
        }
        return $modDetails;
    }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
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

  /**
   * method untuk print tanda bukti pembayaran Klaim Piutang
   * @param int $pembayaranklaim_id pembayaranklaim_id
   */
  public function actionPrint($pembayarklaim_id = null)
  {
    $judulKuitansi = '----- PEMBAYARAN KLAIM / PIUTANG -----';
    $format = new MyFormatter();
    $modPembayaranKlaim = BKPembayaranklaimT::model()->findByPk($pembayarklaim_id);
    $modPembayaranKlaimDetail = BKPembayarklaimdetailT::model()->findAllByAttributes(array('pembayarklaim_id' => $pembayarklaim_id));

    if (!empty($modPembayaranKlaimDetail->pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaranKlaimDetail->pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPembayaranKlaimDetail->pendaftaran->tgl_pendaftaran);
    } else {
      $modPendaftaran = new PendaftaranT;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array(
        'modPendaftaran' => $modPendaftaran,
        'judulKuitansi' => $judulKuitansi,
        'caraPrint' => $caraPrint,
        'modPembayaranKlaim' => $modPembayaranKlaim,
        'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'print', array(
        'modPendaftaran' => $modPendaftaran,
        'judulKuitansi' => $judulKuitansi,
        'caraPrint' => $caraPrint,
        'modPembayaranKlaim' => $modPembayaranKlaim,
        'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      //			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      //            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
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

      /* font-family: tahoma; */
      // $header = 0.50 * 72 / (72/25.4);
      $header = 0.3 * 72 / (72 / 25.4);
      $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
      $mpdf->WriteHTML(
        $this->renderPartial(
          $this->path_view . 'print',
          array(
            'modPendaftaran' => $modPendaftaran,
            'judulKuitansi' => $judulKuitansi,
            'caraPrint' => $caraPrint,
            'modPembayaranKlaim' => $modPembayaranKlaim,
            'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail
          ),
          true
        )
      );
      $mpdf->Output();
    }
  }

  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $criteria = new CDbCriteria;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekening5_id = " . $rekening5_id);
      }
      if (!empty($rekening4_id)) {
        $criteria->addCondition("rekening4_id = " . $rekening4_id);
      }
      if (!empty($rekening3_id)) {
        $criteria->addCondition("rekening3_id = " . $rekening3_id);
      }
      if (!empty($rekening2_id)) {
        $criteria->addCondition("rekening2_id = " . $rekening2_id);
      }
      if (!empty($rekening1_id)) {
        $criteria->addCondition("rekening1_id = " . $rekening1_id);
      }

      $model = RekeningakuntansiV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'status' => $status), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningByJnsPenerimaan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {


      $carapembayaran = $_POST['carapembayaran'];
      $bank_id = $_POST['bank_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $model = array();

      // debit
      if (strtolower($carapembayaran) == "transfer" && !empty($bank_id)) {
        $bank = BankrekM::model()->findByAttributes(array(
          'bank_id' => $bank_id,
          'debitkredit' => 'D',
        ));

        if (!empty($bank)) {
          $rek = Rekening5M::model()->findByAttributes(array(
            'rekening5_id' => $bank->rekening5_id,
          ));
          $rek->rekening5_nb = "D";

          $model[] = $rek;
        }
      } else {

        $kas = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'pembayaranklaim_t',
          'column_name' => 'totalbayar',
          'debitkredit' => 'D',
        ));

        if (!empty($kas)) {
          $rek = Rekening5M::model()->findByAttributes(array(
            'rekening5_id' => $kas->rekening5_id,
          ));
          $rek->rekening5_nb = "D";

          $model[] = $rek;
        }
      }

      // kredit
      $penjamin = PenjaminrekM::model()->findByAttributes(array(
        'penjamin_id' => $penjamin_id,
        'debitkredit' => 'K',
        'ispembayaran' => true,
      ));

      if (!empty($penjamin)) {
        $rek = Rekening5M::model()->findByAttributes(array(
          'rekening5_id' => $penjamin->rekening5_id,
        ));
        $rek->rekening5_nb = "K";

        $model[] = $rek;
      }

      if (count((array)$model) > 0) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'dariDialog' => true), true)
        );
      }
      Yii::app()->end();
    }
  }

  protected function saveJurnalRekening($modPembayaranKlaim, $postPenUmum, $pengajuan_id)
  {

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $penjamin = PenjaminpasienM::model()->findByPk($modPembayaranKlaim->penjamin_id);
    $carabayar = CarabayarM::model()->findByPk($penjamin->carabayar_id);

    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPembayaranKlaim->tglpembayaranklaim;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPembayaranKlaim->tglpembayaranklaim, 'JKK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPembayaranKlaim->nopembayaranklaim;
    $modJurnalRekening->tglreferensi = $modPembayaranKlaim->tglpembayaranklaim;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'PEMBAYARAN KLAIM PIUTANG ' . $carabayar->carabayar_nama
      . " " . $penjamin->penjamin_nama . " - " . $modPembayaranKlaim->nopembayaranklaim;

    $pengajuan = PengajuanklaimpiutangT::model()->findByPk($pengajuan_id);
    if (!empty($pengajuan)) {
      $modJurnalRekening->urianjurnal .= " - " . $pengajuan->nopengajuanklaimanklaim;
    }

    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $modPembayaranKlaim->tglpembayaranklaim;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;

      if (empty($modJurnalRekening->rekperiod_id)) {
        $this->pesan = "Periode Akuntansi Belum di-set";
      } else {
        $this->pesan = $modJurnalRekening->getErrors();
      }
    }
    return $modJurnalRekening;
  }

  protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi = null)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new JurnaldetailT();
      //            $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model->uraiantransaksi = $modJurnalRekening->urianjurnal;
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";
      if ($model->validate()) {
        $model->save();
      } else {
        $this->pesan = $model->getErrors();
        $valid = false;
        break;
      }
    }

    $this->succesSave = $valid;
  }
  
  public function actionSetFromPengajuanKlaim()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $form = "";
            $pesan = "";
            $pengajuanklaimpiutang_id = isset($_POST['pengajuanklaimpiutang_id']) ? $_POST['pengajuanklaimpiutang_id'] : null;

            $pengajuan = PengajuanklaimpiutangT::model()->findByPk($pengajuanklaimpiutang_id);
            $dataDetail = PengajuanklaimdetailT::model()->findAllByAttributes(array('pengajuanklaimpiutang_id'=>$pengajuanklaimpiutang_id));

            $bayarklaimArr = array();
            
            
            if(count($dataDetail) > 0){
                $no = 1;
                foreach($dataDetail as $i=>$data){
                    $pajakNilai = 0;
                    $jmlbayarKlaim = 0;

                    $modByr = PembklaimdetalT::model()->findAllByAttributes(array('pengajuanklaimdetail_id'=>$data->pengajuanklaimdetail_id));

                    if(count($modByr) > 0){
                        
                        
                      foreach ($modByr as $byr) {
                        $bayarklaimArr[$byr->pembayarklaim_id] = $byr->pembayarklaim_id;
                        $pajakNilai += $byr->jumlahbayar;
                      }
                    }

                    $jmlbayarKlaim = $pajakNilai;
                    $data->jumlahbayar = ($data->jumlahbayar - $pajakNilai);
                    $data->jmlpiutang = $data->jumlahbayar;
                    if($data->jumlahbayar > 0){
                        $form .= $this->renderPartial($this->path_view.'_rowPengajuan', array('modDetail'=>$data, 'index'=>$no,'i'=>$i,'jmlbayarKlaim'=>$jmlbayarKlaim), true);
                        $no++;
                    }
                }
            }else{
                    $pesan = 'Data tidak ditemukan';
            }
            
            $bayar = PembayarklaimT::model()->findByAttributes(array(
                'pembayarklaim_id'=>$bayarklaimArr,
            ), array(
                'order'=>'bayarke desc',
            ));            
            $bayarke = empty($bayar) ? 1 : $bayar->bayarke + 1;

            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan, 'bayarke'=>$bayarke));
            Yii::app()->end();
        }
    }
    
    public function actionAutocompletePengajuanKlaimPiutang($term = null) {
        
        $cr = new CDbCriteria;
        $cr->addCondition('pembayarklaim_id is null');
        $cr->compare('lower(nopengajuanklaimanklaim)', strtolower($term), true);
        $cr->order = 'tglpengajuanklaimanklaim desc';
        
        $data = PengajuanklaimpiutangT::model()->findAll($cr);
        $res = array();
        
        foreach ($data as $item) {
            
            $item->tglpengajuanklaimanklaim = MyFormatter::formatDateTimeForUser($item->tglpengajuanklaimanklaim);
            $item->tgljatuhtempo = MyFormatter::formatDateTimeForUser($item->tgljatuhtempo);
            
            $sub = $item->attributes;
            $sub['carabayar_nama'] = $item->carabayar->carabayar_nama;
            $sub['penjamin_nama'] = $item->penjamin->penjamin_nama;
            $sub['label'] = $item->nopengajuanklaimanklaim." - ".$item->tglpengajuanklaimanklaim;
            $sub['value'] = $item->pengajuanklaimpiutang_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
}
