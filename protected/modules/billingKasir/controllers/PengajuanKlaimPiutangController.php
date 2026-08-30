<?php

class PengajuanKlaimPiutangController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'Index';
  public $path_view = 'billingKasir.views.pengajuanKlaimPiutang.';
  public $path_view_bk = 'billingKasir.views.';

  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . ' - Transaksi Pengajuan Klaim Piutang Penjamin';

    $modPengajuanKlaim = new BKPengajuanklaimpiutangT;
    $modPengajuanKlaimDetail = new BKPengajuanklaimdetailT;
    $modTandabukti = new TandabuktibayarT;
    $modPembayaranPelayanan = new PembayaranpelayananT;
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $format = new MyFormatter();

    $modPendaftaran->tgl_awal = date('Y-m-d');
    $modPendaftaran->tgl_akhir = date('Y-m-d');

    $modPengajuanKlaim->tglpengajuanklaimanklaim = date('Y-m-d H:i:s');
    $modPengajuanKlaim->tgljatuhtempo = date('Y-m-d H:i:s');
    $modPengajuanKlaim->nopengajuanklaimanklaim = '-- Otomatis --';

    $tr = '';
    $modDetails = '';

    if (isset($_GET['id'])) {
      $modPengajuanKlaim = BKPengajuanklaimpiutangT::model()->findByPk($_GET['id']);
      $modPengajuanKlaimDetail = BKPengajuanklaimdetailT::model()->findByAttributes(array('pengajuanklaimpiutang_id' => $_GET['id']));
    }

    if (isset($_POST['BKPengajuanklaimpiutangT'])) {
      $modPengajuanKlaim->attributes = $_POST['BKPengajuanklaimpiutangT'];
      //$modPengajuanKlaim->carabayar_id = isset($_POST['BKPengajuanklaimdetailT'][1]['carabayar_id'])?$_POST['BKPengajuanklaimdetailT'][1]['carabayar_id']:null;
      //$modPengajuanKlaim->penjamin_id= isset($_POST['BKPengajuanklaimdetailT'][1]['penjamin_id'])?$_POST['BKPengajuanklaimdetailT'][1]['penjamin_id']:null;
      $modPengajuanKlaim->carabayar_id = isset($_POST['BKPengajuanklaimdetailT'][0]['carabayar_id']) ? $_POST['BKPengajuanklaimdetailT'][0]['carabayar_id'] : null;
      $modPengajuanKlaim->penjamin_id = isset($_POST['BKPengajuanklaimdetailT'][0]['penjamin_id']) ? $_POST['BKPengajuanklaimdetailT'][0]['penjamin_id'] : null;


      $modPengajuanKlaim->nopengajuanklaimanklaim = MyGenerator::noPengajuanKlaim();
      if (isset($_POST['BKPengajuanklaimdetailT']) && count((array)$_POST['BKPengajuanklaimdetailT']) > 0) {
        $pembayaranpelayanan_id = $this->sortPilih($_POST['BKPengajuanklaimdetailT']);
        $modDetails = $this->validasiTabular($modPengajuanKlaim, $_POST['BKPengajuanklaimdetailT']);
      }
      //var_dump($_POST['BKPengajuanklaimdetailT']);die;
      $modPengajuanKlaim->tglpengajuanklaimanklaim = isset($_POST['BKPengajuanklaimpiutangT']['tglpengajuanklaimanklaim']) ? MyFormatter::formatDateTimeForDb($_POST['BKPengajuanklaimpiutangT']['tglpengajuanklaimanklaim']) : null;
      // $modPengajuanKlaim->totalpiutang = $_POST['BKPengajuanklaimpiutangT']['totalpiutang'];
      $modPengajuanKlaim->totaltagihan = $_POST['BKPengajuanklaimpiutangT']['totaltagihan'];
      $modPengajuanKlaim->tgljatuhtempo = MyFormatter::formatDateTimeForDB($_POST['BKPengajuanklaimpiutangT']['tgljatuhtempo']);

      // var_dump($modPengajuanKlaim->attributes, $_POST); die;

      if ($modPengajuanKlaim->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;
          if ($modPengajuanKlaim->save()) {
            $modDetails = $this->validasiTabular($modPengajuanKlaim, $_POST['BKPengajuanklaimdetailT']);
            foreach ($modDetails as $i => $data) {
              // var_dump($data->attributes);

              if ($data->pembayaranpelayanan_id > 0) {
                if ($data->save()) {
                  $success = true;
                } else {
                  $success = false;
                }
              }
            }
          }

          // var_dump($success); die;

          if ($success == true) {
            // $cekAsuransi = PengajuanklaimdetailT::model()->getAllAsutansi();


            /*
                  if (count((array)$cekAsuransi)>0){
                  $judul = "Penagihan Klaim Piutang";
                  $isi =      "Berikut list penjamin asuransi penagihan klaim piutang, pada tanggal ".MyFormatter::formatDateTimeForUser(date('Y-m-d')).' :';
                  $isi .="<ol>";
                  $count = 0;
                  foreach ($cekAsuransi as $ck){

                  $kurang = $ck->piutang - $ck->telahbayar;
                  if ($kurang > 5000000){
                  $isi .= '<li>'.$ck->penjamin_nama.'</li>';
                  $count = $count + 1;
                  }else{
                  $count = $count + 0;
                  }
                  }
                  $isi .="</ol>";

                  if ($count > 0){
                  $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                  array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=> Params::MODUL_ID_KEUANGAN),
                  ));
                  }
                  }
                  *
                  */

            // var_dump($isi);
            //die;
            // var_dump($success); die;

            $this->notifPengajuanKlaim($modPengajuanKlaim);

            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $this->redirect(array('index', 'id' => $modPengajuanKlaim->pengajuanklaimpiutang_id));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . $ex->getMessage());
        }
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail pengajuan harus diisi.');
      }
    }

    //var_dump((isset($_GET['tgl_awal'])), (isset($_GET['tgl_akhir'])), (isset($_GET['carabayar_id'])), (isset($_GET['penjamin_id']))); die;

    if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id']))) {
      //if (Yii::app()->request->isAjaxRequest) {
      $tgl_awal = $format->formatDateTimeForDb($_GET['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
      $carabayar_id = $_GET['carabayar_id'];
      $penjamin_id = $_GET['penjamin_id'];
      $pengajuanklaimpiutang_id = isset($_GET['pengajuanklaimpiutang_id']) ? $_GET['pengajuanklaimpiutang_id'] : null;
      $tr = $this->createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, true);
      $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

      if (!empty($penjamin->lama_tempo)) {
        $tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s', strtotime("+" . $penjamin->lama_tempo . ' days')));
      } else {
        $tgl = MyFormatter::formatDateTimeForuser(date('Y-m-d H:i:s'));
      }

      echo CJSON::encode(array('tr' => $tr, 'tgl' => $tgl));
      Yii::app()->end();
      //}
    }

    $this->render($this->path_view . 'index', array(
      'modPengajuanKlaim' => $modPengajuanKlaim,
      'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'modTandabukti' => $modTandabukti,
      'tr' => $tr,
      'modDetails' => $modDetails,
      'format' => $format,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function notifPengajuanKlaim($model)
  {


    $judul = "Pengajuan Klaim Piutang - " . $model->nopengajuanklaimanklaim;

    $isi = "Tgl. Pengajuan Klaim : " . MyFormatter::formatDateTimeForUser($model->tglpengajuanklaimanklaim) . "<br/>";
    $isi .= "Total Tagihan : " . MyFormatter::formatNumberForPrint($model->totaltagihan) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    //$ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //    array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    ));
  }

  protected function rowPengeluaran($pengeluaran, $totaltransaksi, $tr, $text = null, $penjamin = null)
  {
    $diskon = 0;

    if (!empty($penjamin) && !empty($penjamin->diskon_klaim)) {
      $diskon = number_format(100 - $penjamin->diskon_klaim, 2, ",", "");
    }

    if (count((array)$pengeluaran) > 0) {
      $cnt = 0;

      foreach ($pengeluaran as $i => $row) {

        $bkm = TandabuktibayarT::model()->findByAttributes(array(
          'pembayaranpelayanan_id' => $row->pembayaranpelayanan_id
        ));

        if (($row->totalsubsidiasuransi + $row->total_inacbg) == 0)
          continue;

        $totaltransaksi = count((array)$pengeluaran);
        $jumlahPiutang = $row->totalsubsidiasuransi + $row->total_inacbg;
        $biayapelayanan = 0;

        /*
          if($row->carabayar->issubsidiasuransi == true || $row->carabayar->issubsidipemerintah == true || $row->carabayar->issubsidirs == true){
          $jumlahPiutang += $row->totalsubsidiasuransi + $row->totalsubsidipemerintah + $row->totalsubsidirs;
          }else if($row->carabayar->issubsidiasuransi == true){
          $jumlahPiutang += $row->totalsubsidiasuransi;
          }else if($row->carabayar->issubsidipemerintah == true){
          $jumlahPiutang += $row->totalsubsidipemerintah ;
          }else if($row->carabayar->issubsidirs == true){
          $jumlahPiutang += $row->totalsubsidirs;
          }
          *
          */



        $cek = PengajuanklaimdetailT::model()->findByAttributes(array('pembayaranpelayanan_id' => $row->pembayaranpelayanan_id), array(
          'order' => 'pengajuanklaimdetail_id desc',
        ));
        $jmlbayar = 0;
        $jmltelahbayar = 0;
        $jmlsisapiutang = 0;

        if (!empty($cek)) {

          $diskon = number_format($cek->persendiskon, 2, ",", "");

          $klaim = $cek->pengajuanklaimdetail_id;

          $bayar = BKPembayarklaimdetailT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $row->pembayaranpelayanan_id, 'pengajuanklaimdetail_id' => $cek->pengajuanklaimdetail_id));

          foreach ($bayar as $byr) {
            $jmltelahbayar = $jmltelahbayar + $byr->jumlahbayar;
          }
          // var_dump($jmltelahbayar); die;
        } else {
          $klaim = null;
        }


        $biayapelayanan += $row->totalbiayapelayanan;
        $jmlpengajuan = $jumlahPiutang - $jmltelahbayar;

        if ($jmlpengajuan == 0)
          continue;

        //$jmlpengajuan = $jmlsisapiutang;
        //  $sisa = $row->totaliurbiaya;

        if (empty($cek) || $jmltelahbayar != $jumlahPiutang) {
          $tr .= $this->renderPartial($this->path_view . '_rowKlaim', array(
            'text' => $text,
            'row' => $row,
            'i' => $cnt++,
            'jumlahPiutang' => $jumlahPiutang,
            'diskon' => $diskon,
            'jmlpengajuan' => $jmlpengajuan,
            'jmltelahbayar' => $jmltelahbayar,
            'bkm' => $bkm,
          ), true);
        }
      }
    }
    return $tr;
  }

  protected function createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $status = null)
  {
    $criteria = new CDbCriteria();
    if (!empty($carabayar_id)) {
      $criteria->addCondition("t.carabayar_id = " . $carabayar_id);
    }
    if (!empty($penjamin_id)) {
      $criteria->addCondition("t.penjamin_id = " . $penjamin_id);
    }
    $criteria->addBetweenCondition('DATE(t.tglpembayaran)', $tgl_awal, $tgl_akhir);

    if (!empty($this->pembklaimdetal_id)) {
      $criteria->addCondition('detailklaim.jmlsisapiutang > 0');
    }

    $criteria->with = array('detailklaim');
    $criteria->join = 'LEFT JOIN pembklaimdetal_t ON pembklaimdetal_t.pembklaimdetal_id = t.pembklaimdetal_id';
    $criteria->order = 'nopembayaran';
    $pengeluaran = PembayaranpelayananT::model()->findAll($criteria);
    $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

    $tr = $this->rowPengeluaran($pengeluaran, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null, null, $penjamin);

    return $tr;
  }

  protected function sortPilih($data)
  {
    $result = array();

    foreach ($data as $i => $row) {
      if (isset($row['cekList'])) {
        if ($row['cekList'] == 1) {

          $result[] = $row['pembayaranpelayanan_id'];
        }
      }
    }

    return $result;
  }

  protected function validasiTabular($modPengajuanKlaim, $data)
  {
    foreach ($data as $i => $row) {
      if (isset($row['cekList'])) {
        if ($row['cekList'] == 1) {
          $modDetails[$i] = new BKPengajuanklaimdetailT();
          $modDetails[$i]->attributes = $row;
          $modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
          $modDetails[$i]->pasien_id = $row['pasien_id'];
          $modDetails[$i]->pengajuanklaimpiutang_id = $modPengajuanKlaim->pengajuanklaimpiutang_id;
          $modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
          $modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
          $modDetails[$i]->jmlpiutang = $row['jmlpiutang']; //-$row['jmlbayar'];
          $modDetails[$i]->jumlahbayar = $row['jmlpengajuan'];
          $modDetails[$i]->jmltagihan = $row['jmltagihan'];
          $modDetails[$i]->persendiskon = $row['discount'];
          $modDetails[$i]->jmldiskon = $row['nilai_diskon'];
          $modDetails[$i]->jmltelahbayar = $row['jmlbayar'];
          $modDetails[$i]->jmlsisapiutang = $modDetails[$i]->jmlpiutang - $modDetails[$i]->jumlahbayar; //$row['jmlsisatagihan'];
          // var_dump($row, $modDetails[$i]->attributes); die;

          $modDetails[$i]->validate();
        }

        //var_dump($modDetails[$i]->attributes);die;
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
   * method untuk print tanda bukti pengajuan Klaim Piutang
   * @param int $pengajuanklaimpiutang_id pengajuanklaimpiutang_id
   */
  public function actionPrint($pengajuanklaimpiutang_id = null)
  {
    $judulKuitansi = 'PENGAJUAN KLAIM PIUTANG';
    $format = new MyFormatter();
    $modPengajuanKlaim = BKPengajuanklaimpiutangT::model()->findByPk($pengajuanklaimpiutang_id);
    $modPengajuanKlaimDetail = BKPengajuanklaimdetailT::model()->findAllByAttributes(array('pengajuanklaimpiutang_id' => $pengajuanklaimpiutang_id));

    if (!empty($modPengajuanKlaimDetail->pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($modPengajuanKlaimDetail->pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPengajuanKlaimDetail->pendaftaran->tgl_pendaftaran);
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
        'modPengajuanKlaim' => $modPengajuanKlaim,
        'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'print', array(
        'modPendaftaran' => $modPendaftaran,
        'judulKuitansi' => $judulKuitansi,
        'caraPrint' => $caraPrint,
        'modPengajuanKlaim' => $modPengajuanKlaim,
        'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail
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
            'modPengajuanKlaim' => $modPengajuanKlaim,
            'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail
          ),
          true
        )
      );
      $mpdf->Output();
    }
  }
}
