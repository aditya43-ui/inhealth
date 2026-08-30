<?php

class PengirimanInvoiceTagihanKlaimController extends MyAuthController
{
  public $path_view = 'keuangan.views.pengirimanInvoiceTagihanKlaim.';
  public $succesSave = true;
  public $pesan = '';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new PengajuanklaimpiutangT();
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->nokaskeluar = "Otomatis";
    $modBuktiKeluar->carabayarkeluar = Params::CARAPEMBAYARAN_TUNAI;

    
    // $modSrch = new KUPembayaranppnkeluaranV();
    // $modSrch->pajak_id = 6;

    // $modPajak = PajakM::model()->findByPk($modSrch->pajak_id);

    // if (isset($modPajak)) {
    //   $modSrch->pajak_nama = $modPajak->pajak_nama;
    // }

    // $modBuktiKeluar->nokaskeluar = "Otomatis";
    // $modBuktiKeluar->no_setorpajakpembelian = MyGenerator::noSetoranHutangPPNKeluar();
    // $modBuktiKeluar->untukpembayaran = "Setoran Pajak PPN Keluaran - " . $modBuktiKeluar->no_setorpajakpembelian;

    if (isset($_POST['KUTandabuktikeluarT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      
      try {
        $modBuktiKeluar->attributes = $_POST['KUTandabuktikeluarT'];
        $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($_POST['KUTandabuktikeluarT']['tglkaskeluar']);
        $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
        $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
        $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
        $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
        $modBuktiKeluar->tahun = date('Y');

        $tersimpan = false;
        
        if($modBuktiKeluar->save()){
          $tersimpan = true;
          $tersimpanpengajuan = true;
         
          if (!empty($_POST['PengajuanklaimpiutangT'])) {
            foreach($_POST['PengajuanklaimpiutangT'] as $dataDetail){
              if ($dataDetail['checklist'] == 1) {
                $modDetail = PengajuanklaimpiutangT::model()->findByPk($dataDetail['pengajuanklaimpiutang_id']);
                $modDetail->kiriminvoice_ket = $dataDetail['pengajuanklaimpiutang_id'];
                $modDetail->kiriminvoice_nama = $dataDetail['kiriminvoice_nama'];
                $modDetail->kiriminvoice_tgl = (!empty($dataDetail['kiriminvoice_tgl'])? MyFormatter::formatDateTimeForDb($dataDetail['kiriminvoice_tgl']):null);
                $modDetail->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                if(!$modDetail->save()){
                  $tersimpanpengajuan = false;
                }
              }
            }
          }
          
          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
            if (!empty($_POST['RekeningakuntansiV'])) {
              $modJurnalRekening = $this->saveJurnalRekening($modBuktiKeluar);
              $tersimpanjurnal = true;
              foreach($_POST['RekeningakuntansiV'] as $dataRekening){
                if($dataRekening['debitkredit'] == 'D'){
                  $saldo = $dataRekening['saldodebit'];
                }else{
                  $saldo = $dataRekening['saldokredit'];
                }
                $tersimpanjurnal = $this->saveJurnalDetail($modJurnalRekening, $dataRekening['rekening5_id'], $saldo, $dataRekening['debitkredit'], $dataRekening['nourut']);
              }

              if($tersimpanjurnal == false){
                $this->succesSave = false;
              }
            }
          }
          // echo '== '.$tersimpan;
          // exit();

          if($tersimpanpengajuan == false && $this->succesSave == true){
            $tersimpan = false;
          }
        }else{
          $tersimpan = false;
        }
        
        if($tersimpan == true){
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id, 'sukses' => 1));
        }else{
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modBuktiKeluar' => $modBuktiKeluar
    ));
  }


  public function actionPrint($id)
  {
    $totalhutang = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $tglsetoran = "";
    $pajak_nama = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($id);
    $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));

    if (count((array)$model) > 0) {
      foreach ($model as $dataSetor) {
        $totalhutang += $dataSetor->totalhutang;
        $totalsisahutang += $dataSetor->totalsisahutang;
        $jmlpembayaran += $dataSetor->jmlpembayaran;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglsetoranpajak);
        $pajak_nama = (isset($dataSetor->pajak) ? $dataSetor->pajak->pajak_nama : "");
      }
    }

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array(
        'caraPrint' => $caraPrint,
        'modBuktiKeluar' => $modBuktiKeluar,
        'totalhutang' => $totalhutang,
        'totalsisahutang' => $totalsisahutang,
        'tglsetoran' => $tglsetoran,
        'jmlpembayaran' => $jmlpembayaran,
        'model' => $model,
        'pajak_nama' => $pajak_nama,

      ));
    }
  }

  public function actionSetFromPencarian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = '';
      $tgl_awal = (!empty($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDB($_POST['tgl_awal']) : null);
      $tgl_akhir = (!empty($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDB($_POST['tgl_akhir']) : null);
      $noinvoice = (!empty($_POST['noinvoice']) ? $_POST['noinvoice'] : null);
      $carabayar_id = (!empty($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null);
      $penjamin_id = (!empty($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);

      $criteria = new CDbCriteria();
      $criteria->select = "t.pengajuanklaimpiutang_id, crb.carabayar_nama, penjamin.penjamin_nama, t.tglpengajuanklaimanklaim, t.noinvoice, t.totalbayar";
      $criteria->join = "join penjaminpasien_m penjamin on penjamin.penjamin_id = t.penjamin_id 
                        join carabayar_m crb on crb.carabayar_id = penjamin.carabayar_id";
      $criteria->addBetweenCondition('date(tglpengajuanklaimanklaim)', $tgl_awal, $tgl_akhir);
      $criteria->compare('lower(noinvoice)', strtolower($noinvoice), true);

      if (!empty($carabayar_id)) {
          $criteria->addCondition('crb.carabayar_id = ' . $carabayar_id);
      }

      if (!empty($penjamin_id)) {
          $criteria->addCondition('penjamin.penjamin_id = ' . $penjamin_id);
      }
      $criteria->addCondition('t.pembayarklaim_id is null and t.tandabuktikeluar_id is null');
      $criteria->order = "t.tglpengajuanklaimanklaim asc";

      $model = PengajuanklaimpiutangT::model()->findAll($criteria);
      $keterangan = "";
      if(!empty($model)){
        $penjamin_nama = "";
        foreach($model as $dataMod){
          $dataMod->tglpengajuanklaimanklaim = MyFormatter::formatDateTimeForUser($dataMod->tglpengajuanklaimanklaim);

          $form .= $this->renderPartial($this->path_view . '_rowPengajuan', array('modDetail' => $dataMod), true);
          $penjamin_nama = $dataMod->penjamin_nama;
        }
        $keterangan = "Biaya Pengiriman Invoice ".$penjamin_nama." - ".MyGenerator::noKasKeluar();
      }else{
        $pesan = 'Data tidak ditemukan';
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan,'keterangan'=>$keterangan));
      Yii::app()->end();
    }
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


  protected function saveJurnalRekening($modBuktiKeluar)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }
    

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
   
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modBuktiKeluar->tglkaskeluar);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modBuktiKeluar->nokaskeluar;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modBuktiKeluar->tglkaskeluar);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $modBuktiKeluar->untukpembayaran;
   
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
    
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

    $modelJurnalDetail = new JurnaldetailT();
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
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
      $valid = false;
    }

    return $valid;
  }


  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $carabayar = isset($_POST['carabayar']) ? $_POST['carabayar'] : null;
      $bankid = isset($_POST['bankid']) ? $_POST['bankid'] : null;
      $model = null;
      $modRekening = array();
      $criteriaJns = new CDbCriteria;
      $criteriaJns->join  = "JOIN jenispengeluaran_m jns on jns.jenispengeluaran_id = t.jenispengeluaran_id  
      JOIN rekening5_m on rekening5_m.rekening5_id = t.rekening5_id";
      $criteriaJns->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
      $criteriaJns->order = 't.debitkredit ASC';
      $criteriaJns->addCondition("t.debitkredit = 'D' and jns.iskiriminvoiceklaim = true");
      $modRekJns = JnspengeluaranrekM::model()->find($criteriaJns);
       
      if(!empty($modRekJns)){
        $modRekening[] = array(
              'rekening5_id'=>$modRekJns->rekening5_id,
              'kdrekening5'=>$modRekJns->kdrekening5,
              'nmrekening5'=>$modRekJns->nmrekening5,
              'debitkredit'=>'D',
              'nourut'=>1
              );
      }

      $criteria = new CDbCriteria;
      $criteria->join  = "JOIN rekening5_m on rekening5_m.rekening5_id = t.rekening5_id";
      $criteria->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";
      $criteria->order = 't.debitkredit ASC';
      $criteria->addCondition("t.debitkredit = 'K'");

      if (!empty($bankid)) {
        $criteria->addCondition("t.bank_id = " . $bankid);
        $model = BankrekM::model()->find($criteria);
      } else {
        if (!empty($carabayar)) {
          $criteria->addCondition("t.carabayarkeluar = 'TUNAI'");
          $model = CarabayarkeluarrekM::model()->find($criteria);
        }
      }

      if(!empty($model)){
        $modRekening[] = array(
          'rekening5_id'=>$model->rekening5_id,
          'kdrekening5'=>$model->kdrekening5,
          'nmrekening5'=>$model->nmrekening5,
          'debitkredit'=>'K',
          'nourut'=>2
          );
      }


      if (!empty($modRekening)) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $modRekening), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionAmbilDataRekColumn()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jmlBayar = isset($_POST['jmlBayar']) ? $_POST['jmlBayar'] : 0;
      $biayamaterai = isset($_POST['biayamaterai']) ? $_POST['biayamaterai'] : 0;

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";

      $criteria->addCondition("debitkredit = 'D'");
      $dataArr = "";
      if (isset($jmlBayar) && $jmlBayar > 0) {
        $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_SETORANPAJAKT, false);
        $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_SETORANPAJAKBPJSTK, false);
        $model = RekeningcolumnM::model()->findAll($criteria);

        if (count((array)$model) > 0) {
          $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D', 'tr' => 'trDebitPPh', 'nourut' => 1), true);
        }
      }

      $criteria = new CDbCriteria;
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id ";
      $criteria->select = "rekening5_m.rekening5_id, rekening4_m.rekening4_id, rekening3_m.rekening3_id, rekening2_m.rekening2_id, rekening1_m.rekening1_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5";

      $criteria->addCondition("debitkredit = 'D'");

      if (isset($biayamaterai) && $biayamaterai > 0) {
        $criteria->compare('table_name', Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, false);
        $criteria->compare('column_name', Params::REKENINGCOLUMN_COLUMN_BIAYAMATERAI, false);
        $model = RekeningcolumnM::model()->findAll($criteria);

        if (count((array)$model) > 0) {
          $dataArr .= $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'debitkredit' => 'D', 'tr' => 'trDebitMaterai', 'nourut' => 2), true);
        }
      }
      echo CJSON::encode($dataArr);

      Yii::app()->end();
    }
  }
}
