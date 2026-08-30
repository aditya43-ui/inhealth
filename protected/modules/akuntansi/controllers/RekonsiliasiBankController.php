<?php

class RekonsiliasiBankController  extends  MyAuthController
{
  protected $path_view = 'akuntansi.views.rekonsiliasiBank.';
  public $rekonsiliasibanktersimpan = false;
  public $rekonsiliasidetailtersimpan = true;
  public $jurnalrekeningtersimpan = false;
  public $jurnalrekeningdetailtersimpan = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rekonsiliasi Bank";
    $format  = new MyFormatter();
    $model  = new AKRekonsiliasibankT();
    $model->rekonsiliasibank_tgl = date('Y-m-d H:i:s');
    $model->rekonsiliasibank_no = '-- Otomatis --';
    $modRekonDetail  = array();
    $modJurnal  = new AKJurnalrekeningT();
    $modJurnalDetail  = new AKJurnaldetailT();

    if (!empty($_GET['rekonsiliasibank_id'])) {
      $model = AKRekonsiliasibankT::model()->findByPK($_GET['rekonsiliasibank_id']);
      $modRekonDetail = AKRekonsiliasibankdetailT::model()->findAllByAttributes(array('rekonsiliasibank_id' => $model->rekonsiliasibank_id));
    }

    if (isset($_POST['AKRekonsiliasibankT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $this->simpanRekonsiliasiBank($model, $_POST['AKRekonsiliasibankT']);
        if ($model) {
          $modJurnal = $this->simpanJurnalRekening($model, $_POST['AKRekonsiliasibankT']);
          if (count((array)$_POST['AKRekonsiliasibankdetailT']) > 0) {
            $nourut = 1;
            foreach ($_POST['AKRekonsiliasibankdetailT'] as $i => $details) {
              $modDetails[$i] = $this->simpanRekonsiliasiBankDetail($_POST['AKRekonsiliasibankdetailT'], $details, $model, $modJurnal, $nourut);
              $this->simpanJurnalRekeningDetail($model, $modDetails[$i], $modJurnal, $nourut);
              $nourut++;
            }
          }
        }

        $this->notifRekonsiliasiBank($model);
        if ($this->rekonsiliasibanktersimpan && $this->rekonsiliasidetailtersimpan && $this->jurnalrekeningtersimpan && $this->jurnalrekeningdetailtersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'rekonsiliasibank_id' => $model->rekonsiliasibank_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Rekonsiliasi Bank gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Rekonsiliasi Bank gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modRekonDetail' => $modRekonDetail,
      'modJurnal' => $modJurnal,
      'modJurnalDetail' => $modJurnalDetail
    ));
  }


  protected function notifRekonsiliasiBank($model)
  {

    $ruangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $judul = "Rekonsiliasi Bank - " . $model->rekonsiliasibank_no;
    $bank = BankM::model()->findByPk($model->bank_id);

    $isi = "Tgl. Transaksi : " . MyFormatter::formatDateTimeForUser($model->rekonsiliasibank_tgl) . "<br/>";
    $isi .= "No. Transaksi : " . $model->rekonsiliasibank_no . "<br/>";
    $isi .= "Bank : " . (empty($bank) ? "-" : $bank->namabank) . "<br/>";
    $isi .= "Saldo Bank : " . MyFormatter::formatNumberForPrint($model->rekonsiliasibank_saldobank) . "<br/>";
    $isi .= "Saldo Kas : " . MyFormatter::formatNumberForPrint($model->rekonsiliasibank_saldokas) . "<br/>";

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
    ));
  }

  /**
   * proses simpan data rekonsiliasi bank
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanRekonsiliasiBank($model, $post)
  {
    $format = new MyFormatter();
    $model = new AKRekonsiliasibankT;
    $model->attributes = $post;
    $model->rekonsiliasibank_no = MyGenerator::noRekonsiliasiBank();
    $model->rekonsiliasibank_tgl = $format->formatDateTimeForDb($post['rekonsiliasibank_tgl']);
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      $model->save();
      $this->rekonsiliasibanktersimpan = true;
    } else {
      $this->rekonsiliasibanktersimpan = false;
    }

    return $model;
  }

  /**
   * proses simpan data jurnal rekening
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanJurnalRekening($model, $post)
  {
    $format = new MyFormatter();
    $modJurnalRekening = new AKJurnalrekeningT();
    $modJurnalRekening->tglbuktijurnal = $model->rekonsiliasibank_tgl;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modJurnalRekening->tglbuktijurnal, 'JRB');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $model->rekonsiliasibank_tgl;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = isset($model->bank->namabank) ? $model->bank->namabank : "";
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
    $modJurnalRekening->create_time = $model->rekonsiliasibank_tgl;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->jurnalrekeningtersimpan = true;
    } else {
      $this->jurnalrekeningtersimpan = false;
    }

    return $modJurnalRekening;
  }

  /**
   * simpan AKRekonsiliasibankdetailT
   * @param type $model
   * @param type $postRekonsiliasi
   * @return \AKRekonsiliasibankdetailT
   */
  protected function simpanRekonsiliasiBankDetail($postRekonsiliasiDetail, $details, $postRekonsiliasi, $modJurnal, $nourut)
  {
    $format = new MyFormatter;
    $modRekonDetail = new AKRekonsiliasibankdetailT;
    $modRekonDetail->attributes = $details;
    $modRekonDetail->rekonsiliasibank_id = $postRekonsiliasi->rekonsiliasibank_id;
    $modRekonDetail->jenisrekonsiliasibank_id = isset($details['jenisrekonsiliasibank_id']) ? $details['jenisrekonsiliasibank_id'] : null;
    $modRekonDetail->saldodebit = isset($details['saldodebit']) ? $details['saldodebit'] : 0;
    $modRekonDetail->saldokredit = isset($details['saldokredit']) ? $details['saldokredit'] : 0;

    if ($modRekonDetail->validate()) {
      $modRekonDetail->save();
      $this->rekonsiliasidetailtersimpan = true;
    } else {
      $this->rekonsiliasidetailtersimpan = false;
    }
    return $modRekonDetail;
  }

  /**
   * simpan AKJurnaldetailT
   * @param type $model
   * @param type $modRekonDetail
   * @return \AKJurnaldetailT
   */
  protected function simpanJurnalRekeningDetail($model, $modRekonDetail, $modJurnalRekening, $nourut)
  {
    $format = new MyFormatter;
    $modJurnalDetail = new AKJurnaldetailT();
    $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modJurnalDetail->uraiantransaksi = $modRekonDetail->getNamaRekening();
    $modJurnalDetail->saldodebit = isset($modRekonDetail->saldodebit) ? $modRekonDetail->saldodebit : 0;
    $modJurnalDetail->saldokredit = isset($modRekonDetail->saldokredit) ? $modRekonDetail->saldokredit : 0;
    $modJurnalDetail->nourut = $nourut;
    // $modJurnalDetail->rekening1_id = isset($modRekonDetail->rekening1_id) ? $modRekonDetail->rekening1_id : null;
    // $modJurnalDetail->rekening2_id = isset($modRekonDetail->rekening2_id) ? $modRekonDetail->rekening2_id : null;
    // $modJurnalDetail->rekening3_id = isset($modRekonDetail->rekening3_id) ? $modRekonDetail->rekening3_id : null;
    // $modJurnalDetail->rekening4_id = isset($modRekonDetail->rekening4_id) ? $modRekonDetail->rekening4_id : null;
    $modJurnalDetail->rekening5_id = isset($modRekonDetail->rekening5_id) ? $modRekonDetail->rekening5_id : null;
    $modJurnalDetail->catatan = "";

    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
      $this->jurnalrekeningdetailtersimpan = true;
    } else {
      $this->jurnalrekeningdetailtersimpan = false;
    }
    return $modJurnalDetail;
  }

  public function actionSetSaldoBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $saldobank  = 0;
      $saldodebit  = 0;
      $saldokredit = 0;
      $pesan = '';

      $bank_id = isset($_POST['bank_id']) ? $_POST['bank_id'] : null;
      $modBankRek = AKBankRekM::model()->findAllByAttributes(array('bank_id' => $bank_id));
      if (count((array)$modBankRek) > 0) {
        foreach ($modBankRek as $i => $saldo) {
          $criteria = new CDbCriteria();
          // $rek = Rekening5M::model()->findByAttributes(array(
          //   'rekeninglast_id' => $saldo->rekening5_id,
          // ));

          // $rek = RekeningakuntansiV::model()->findByAttributes(array(
          //   'rekeninglast_id' => $saldo->rekening5_id,
          // ));
          // $rekening1_id = $rek->rekening1_id;
          // $rekening2_id = $rek->rekening2_id;
          // $rekening3_id = $rek->rekening3_id;
          // $rekening4_id = $rek->rekening4_id;
          $rekening5_id = $saldo->rekening5_id;
          /*
					if(!empty($rekening1_id)){
						$criteria->addCondition('rekening1_id ='.$rekening1_id);
					}
					if(!empty($rekening2_id)){
						$criteria->addCondition('rekening2_id ='.$rekening2_id);
					}
					if(!empty($rekening3_id)){
						$criteria->addCondition('rekening3_id ='.$rekening3_id);
					}
					if(!empty($rekening4_id)){
						$criteria->addCondition('rekening4_id ='.$rekening4_id);
					}
					 *
					 */
          if (!empty($rekening5_id)) {
            $criteria->addCondition('rekening5_id =' . $rekening5_id);
          }

          $modBukuBesar = AKBukubesarT::model()->find($criteria);
          if (!empty($modBukuBesar)) {
            $saldodebit += isset($modBukuBesar->saldodebit) ? $modBukuBesar->saldodebit : 0;
            $saldokredit += isset($modBukuBesar->saldokredit) ? $modBukuBesar->saldokredit : 0;
          }
        }
      }

      $saldobank = $saldodebit - $saldokredit;
      $data = array(
        'saldobank' => $saldobank,
        'pesan' => $pesan
      );
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  public function actionSetRekonsiliasiBank()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modRekonDetail = new AKRekonsiliasibankdetailT();
      $pesan = '';
      $form = '';
      $jenisrekonsiliasibank_id = isset($_POST['jenisrekonsiliasibank_id']) ? $_POST['jenisrekonsiliasibank_id'] : null;

      if (!empty($jenisrekonsiliasibank_id)) {

        $modRekonRekening = AKRekonsiliasibankrekeningM::model()->findAllByAttributes(array('jenisrekonsiliasibank_id' => $jenisrekonsiliasibank_id));
        $modJenisRekonsiliasi = AKJenisrekonsiliasibankM::model()->findByPk($jenisrekonsiliasibank_id);
        if (count((array)$modRekonRekening) > 0) {
          foreach ($modRekonRekening as $i => $rekening) {
            $rekening1_id = isset($rekening->rekening1_id) ? $rekening->rekening1_id : null;
            $rekening2_id = isset($rekening->rekening2_id) ? $rekening->rekening2_id : null;
            $rekening3_id = isset($rekening->rekening3_id) ? $rekening->rekening3_id : null;
            $rekening4_id = isset($rekening->rekening4_id) ? $rekening->rekening4_id : null;
            $rekening5_id = isset($rekening->rekening5_id) ? $rekening->rekening5_id : null;
            $status      = isset($rekening->rekeningdebit->rekening5_nb) ? $rekening->rekeningdebit->rekening5_nb : null;

            if ($status == 'D') {
              $status = 'debit';
            } else if ($status == 'K') {
              $status = 'kredit';
            }

            // pencarian rekening
            $criteria = new CDbCriteria;
            if (!empty($rekening5_id)) {
              $criteria->addCondition("rekening5_id = " . $rekening5_id);
            } /*
						if(!empty($rekening4_id)){
							$criteria->addCondition("rekening4_id = ".$rekening4_id);
						}
						if(!empty($rekening3_id)){
							$criteria->addCondition("rekening3_id = ".$rekening3_id);
						}
						if(!empty($rekening2_id)){
							$criteria->addCondition("rekening2_id = ".$rekening2_id);
						}
						if(!empty($rekening1_id)){
							$criteria->addCondition("rekening1_id = ".$rekening1_id);
						}
						 *
						 */

            // $model = AKRekeningakuntansiV::model()->find($criteria);
            $model = Rekening5M::model()->find($criteria);
            if (!empty($model)) {
              //							$modRekonDetail->kelrekening_id = isset($model->kelrekening_id) ? $model->kelrekening_id : "";
              //							$modRekonDetail->rekening1_id = $model->rekening1_id;
              //							$modRekonDetail->rekening2_id = $model->rekening2_id;
              //							$modRekonDetail->rekening3_id = $model->rekening3_id;
              //							$modRekonDetail->rekening4_id = $model->rekening4_id;
              $modRekonDetail->rekening5_id = $model->rekening5_id;
              $modRekonDetail->jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id;
              $modRekonDetail->saldodebit = isset($model->saldodebit) ? $model->saldodebit : 0;
              $modRekonDetail->saldokredit = isset($model->saldokredit) ? $model->saldokredit : 0;
              $modRekonDetail->kode_rekening = $model->kdrekening5;
              $modRekonDetail->nama_rekening = $model->nmrekening5;
              $modRekonDetail->keterangan = '';
              $modRekonDetail->uraiantransaksi = isset($modJenisRekonsiliasi->jenisrekonsiliasibank_nama) ? $modJenisRekonsiliasi->jenisrekonsiliasibank_nama  : "";
            } else {
              //							$modRekonDetail->kelrekening_id = isset($rekening->kelrekening_id) ? $rekening->kelrekening_id : "";
              //							$modRekonDetail->rekening1_id = $rekening->rekening1_id;
              //							$modRekonDetail->rekening2_id = $rekening->rekening2_id;
              //							$modRekonDetail->rekening3_id = $rekening->rekening3_id;
              //							$modRekonDetail->rekening4_id = $rekening->rekening4_id;
              $modRekonDetail->rekening5_id = $rekening->rekeninglast_id;
              $modRekonDetail->jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id;
              $modRekonDetail->saldodebit = 0;
              $modRekonDetail->saldokredit = 0;
              $modRekonDetail->kode_rekening = null;
              $modRekonDetail->nama_rekening = null;
              $modRekonDetail->keterangan = '';
              $modRekonDetail->uraiantransaksi = isset($modJenisRekonsiliasi->jenisrekonsiliasibank_nama) ? $modJenisRekonsiliasi->jenisrekonsiliasibank_nama  : "";
            }
            $form .= $this->renderPartial('_rowDetailRekening', array('model' => $model, 'status' => $status, 'modRekonDetail' => $modRekonDetail), true);
          }
        } else {
          $pesan = 'Rekening belum disetting';
        }
      }

      $data = array(
        'form' => $form,
        'pesan' => $pesan
      );

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetRekonsiliasiBankRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modRekonDetail = new AKRekonsiliasibankdetailT();
      $pesan = '';
      $form = '';
      $jenisrekonsiliasibank_id = isset($_POST['jenisrekonsiliasibank_id']) ? $_POST['jenisrekonsiliasibank_id'] : null;
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status      = isset($_POST['rekening5_nb']) ? $_POST['rekening5_nb'] : null;

      $modJenisRekonsiliasi = AKJenisrekonsiliasibankM::model()->findByPk($jenisrekonsiliasibank_id);

      $criteria = new CDbCriteria;
      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekening5_id = " . $rekening5_id);
      }
      // if (!empty($rekening4_id)) {
      //   $criteria->addCondition("rekening4_id = " . $rekening4_id);
      // }
      // if (!empty($rekening3_id)) {
      //   $criteria->addCondition("rekening3_id = " . $rekening3_id);
      // }
      // if (!empty($rekening2_id)) {
      //   $criteria->addCondition("rekening2_id = " . $rekening2_id);
      // }
      // if (!empty($rekening1_id)) {
      //   $criteria->addCondition("rekening1_id = " . $rekening1_id);
      // }

      $model = Rekening5M::model()->find($criteria);
      // $model = AKRekeningakuntansiV::model()->find($criteria);
      if (!empty($model)) {
        $modRekonDetail = new AKRekonsiliasibankdetailT();
        //				$modRekonDetail->kelrekening_id = $model->kelrekening_id;
        //				$modRekonDetail->rekening1_id = $model->rekening1_id;
        //				$modRekonDetail->rekening2_id = $model->rekening2_id;
        //				$modRekonDetail->rekening3_id = $model->rekening3_id;
        //				$modRekonDetail->rekening4_id = $model->rekening4_id;
        $modRekonDetail->rekening5_id = $model->rekening5_id;
        $modRekonDetail->jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id;
        $modRekonDetail->uraiantransaksi = isset($modJenisRekonsiliasi->jenisrekonsiliasibank_nama) ? $modJenisRekonsiliasi->jenisrekonsiliasibank_nama : "";
        $modRekonDetail->kode_rekening = $model->kdrekening5;
        $modRekonDetail->nama_rekening = $model->nmrekening5;
        $modRekonDetail->keterangan = '';
        $modRekonDetail->saldodebit = isset($model->saldodebit) ? $model->saldodebit : 0;
        $modRekonDetail->saldokredit = isset($model->saldokredit) ? $model->saldokredit : 0;
        $form .= $this->renderPartial('_rowDetailRekening', array('model' => $model, 'status' => $status, 'modRekonDetail' => $modRekonDetail), true);
      } else {
        $pesan = 'Rekening belum disetting';
      }

      $data = array(
        'form' => $form,
        'pesan' => $pesan
      );

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data rekonsiliasibank
   */
  public function actionPrint($rekonsiliasibank_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = AKRekonsiliasibankT::model()->findByPk($rekonsiliasibank_id);
    $modelDetail = AKRekonsiliasibankdetailT::model()->findAllByAttributes(array('rekonsiliasibank_id' => $rekonsiliasibank_id));

    $judul_print = 'Rekonsiliasi Bank';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modelDetail' => $modelDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
