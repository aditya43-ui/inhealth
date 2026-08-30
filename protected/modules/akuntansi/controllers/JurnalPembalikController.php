<?php

class JurnalPembalikController extends MyAuthController
{
  public $success = false;
  public $postingjurnalsimpan = false;

  public function loadModel($id)
  {
    $model = AKJurnalrekeningT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionAdmin()
  {
    $format = new MyFormatter();
    $model = new AKInformasijurnaltransaksiV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');


    if (isset($_GET['AKInformasijurnaltransaksiV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['AKInformasijurnaltransaksiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKInformasijurnaltransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKInformasijurnaltransaksiV']['tgl_akhir']);
      $model->is_posting = $_GET['AKInformasijurnaltransaksiV']['is_posting'];
      $model->jenisjurnal_id = $_GET['AKInformasijurnaltransaksiV']['jenisjurnal_id'];
      $model->nobuktijurnal = $_GET['AKInformasijurnaltransaksiV']['nobuktijurnal'];
      $model->noreferensi = $_GET['AKInformasijurnaltransaksiV']['noreferensi'];
      $model->kodejurnal = $_GET['AKInformasijurnaltransaksiV']['kodejurnal'];
      $model->pegawai_id = isset($_GET['AKInformasijurnaltransaksiV']['pegawai_id']) ? $_GET['AKInformasijurnaltransaksiV']['pegawai_id'] : null;
    }
    $this->render(
      'gridJurnalUmum',
      array(
        'model' => $model
      )
    );
  }

  public function actionIndex($jurnalrekening_id)
  {
    $format = new MyFormatter();
    $model = AKJurnalrekeningT::model()->findByPk($jurnalrekening_id);
    $model->jenisjurnal_id = Params::JENISJURNAL_ID_UMUM_BALIK;
    $model->jenisjurnal_nama = (!empty($model->jenisjurnal_id) ? $model->jenisJurnal->jenisjurnal_nama : "");
    $beforUraianJurnal = $model->urianjurnal;
    $model->urianjurnal = "Jurnal Pembalik - " . $beforUraianJurnal;

    $modelJurDetail = array();

    $modelDetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $model->jurnalrekening_id), array('order' => 'saldodebit ASC'));

    if (count((array)$modelDetail) > 0) {
      $nourut = 1;
      foreach ($modelDetail as $detail) {

        $saldoDebit =  $detail->saldodebit;
        $saldoKredit =  $detail->saldokredit;
        $detail->saldodebit = $saldoKredit;
        $detail->saldokredit = $saldoDebit;
        $detail->nourut = $nourut;
        $nourut++;
        $modelJurDetail[] = $detail;
      }
    }

    if (isset($_POST['AKJurnalrekeningT'])) {
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $modelIns = new JurnalrekeningT();
        $modelIns->attributes = $model->attributes;
        $modelIns->jenisjurnal_id = $_POST['AKJurnalrekeningT']['jenisjurnal_id'];
        $modelIns->tglbuktijurnal = $format->formatDateTimeForDb($_POST['AKJurnalrekeningT']['tglbuktijurnal']);
        $modelIns->tglreferensi = $format->formatDateTimeForDb($_POST['AKJurnalrekeningT']['tglreferensi']);
        //                $modelIns->nobuktijurnal = $_POST['AKJurnalrekeningT']['nobuktijurnal'];
        //                $modelIns->kodejurnal = $_POST['AKJurnalrekeningT']['kodejurnal'];
        $modelIns->rekperiod_id = $_POST['AKJurnalrekeningT']['rekperiod_id'];
        $modelIns->noreferensi = $_POST['AKJurnalrekeningT']['noreferensi'];
        $modelIns->urianjurnal = $_POST['AKJurnalrekeningT']['urianjurnal'];
        $jeniskode = (!empty($modelIns->jenisjurnal_id) ? $modelIns->jenisJurnal->jeniskode : "");

        $modelIns->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modelIns->tglbuktijurnal, $jeniskode);
        $modelIns->kodejurnal = MyGenerator::kodeJurnalRek();
        $modelIns->jurnalbalik_id = $model->jurnalrekening_id;

        if ($modelIns->save()) {
          $this->success = true;

          if (isset($_POST['JurnaldetailT'])) {
            if (count((array)$_POST['JurnaldetailT']) > 0) {
              foreach ($_POST['JurnaldetailT'] as $detailIns) {
                $modeJurnalDetail = JurnaldetailT::model()->findByPk($detailIns['jurnaldetail_id']);
                $modDetailIns = new JurnaldetailT();
                $modDetailIns->attributes = $modeJurnalDetail->attributes;
                $modDetailIns->jurnalrekening_id = $modelIns->jurnalrekening_id;
                $modDetailIns->nourut = $detailIns['nourut'];
                $modDetailIns->rekening5_id = $detailIns['rekening5_id'];
                $modDetailIns->saldodebit = $detailIns['saldodebit'];
                $modDetailIns->saldokredit = $detailIns['saldokredit'];
                $modDetailIns->uraiantransaksi = $modelIns->urianjurnal;

                if (!$modDetailIns->save()) {
                  $this->success = false;
                }
              }
            }
          }
          JurnalrekeningT::model()->updateByPk($model->jurnalrekening_id, array('jurnalbalik_id' => $modelIns->jurnalrekening_id));
        } else {
          $this->success = false;
        }

        if ($this->success) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'jurnalrekening_id' => $modelIns->jurnalrekening_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }


    $this->render(
      'index',
      array(
        'model' => $model,
        'modelDetail' => $modelJurDetail
      )
    );
  }

  public function actionGetDataRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = '';
      $pesan = '';
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status = isset($_POST['jenis_rekening']) ? $_POST['jenis_rekening'] : null;
      $criteria = new CDbCriteria;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekeninglast_id = " . $rekening5_id);
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
      $model = AKRekeningakuntansiV::model()->findAll($criteria);
      $modJurnaldetail = new AKJurnaldetailT;
      if ($model > 0) {
        foreach ($model as $data) {
          $modJurnaldetail->rekening1_id = $data->rekening1_id;
          $modJurnaldetail->rekening2_id = $data->rekening2_id;
          $modJurnaldetail->rekening3_id = $data->rekening3_id;
          $modJurnaldetail->rekening4_id = $data->rekening4_id;
          $modJurnaldetail->rekening5_id = $data->rekeninglast_id;

          $modJurnaldetail->kdrekening1 = isset($data->kdrekening1) ? $data->kdrekening1 : "";
          $modJurnaldetail->kdrekening2 = isset($data->kdrekening2) ? $data->kdrekening2 : "";
          $modJurnaldetail->kdrekening3 = isset($data->kdrekening3) ? $data->kdrekening3 : "";
          $modJurnaldetail->kdrekening4 = isset($data->kdrekening4) ? $data->kdrekening4 : "";
          $modJurnaldetail->kdrekening5 = isset($data->kdrekeninglast) ? $data->kdrekeninglast : "";

          $modJurnaldetail->nmrekening5 = isset($data->nmrekeninglast) ? $data->nmrekeninglast : "";
          $form .= $this->renderPartial('_rowInputRekening', array('modJurnaldetail' => $modJurnaldetail, 'status' => $status), true);
        }
      } else {
        $pesan = "Rekening tidak tersedia!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }


  public function actionSimpanJurnalUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $is_action = 'insert';
      $pesan = 'succes';
      $alert = '';
      parse_str($_REQUEST['data'], $data_parsing);


      $jenis = JenisjurnalM::model()->findByPk($data_parsing['AKJurnalrekeningT']['jenisjurnal_id']);
      $data_parsing['AKJurnalrekeningT']['tglbuktijurnal'] = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tglbuktijurnal']);
      $data_parsing['AKJurnalrekeningT']['tglreferensi'] = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tglreferensi']);
      $data_parsing['AKJurnalrekeningT']['nobuktijurnal'] = MyGenerator::noBuktiJurnalRekTanggal($data_parsing['AKJurnalrekeningT']['tglbuktijurnal'], $jenis->jeniskode);
      $data_parsing['AKJurnalrekeningT']['kodejurnal'] = MyGenerator::kodeJurnalRek();
      $transaction = Yii::app()->db->beginTransaction();

      try {

        $jurnal_rek = $this->simpanJurnal($data_parsing['AKJurnalrekeningT']);
        // var_dump($jurnal_rek->attribtues); die;
        $jurPosting = null;
        $params = array();

        $isposting = $_REQUEST['jenis_simpan'] == 'posting';

        $this->simpanDetailJurnal($data_parsing, $jurnal_rek, $isposting);

        $res = null;
        if ($_REQUEST['jenis_simpan'] == 'posting') {
          $res = Yii::app()->db
            ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(" . $jurnal_rek->jurnalrekening_id . ") as simpan")
            ->queryRow();

          if (!empty($res)) {
            $this->success = $this->success && $res['simpan'];
          }
        }

        // var_dump($res, $this->success);
        // die;
        if ($this->success) {
          $transaction->commit();
          $alert = Yii::app()->user->setFlash('success', "<strong>Berhasil!</strong> Data berhasil disimpan.");
          $periodeID = Yii::app()->user->getState('periode_ids');
          $pesan = array(
            'nobuktijurnal' => '-- Otomatis --',
            'kodejurnal' => '-- Otomatis --',
            //                        'rekperiod_id' => $periodeID[0]
            'rekperiod_id' => $periodeID
          );
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $alert = Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        $pesan = $exc;
        $this->success = false;
      }

      $result = array(
        'action' => $is_action,
        'pesan' => $pesan,
        'status' => ($this->success == true) ? 'ok' : 'not',
        'alert' => $alert,
      );
      echo json_encode($result);
    }
    Yii::app()->end();
  }

  private function simpanJurnal($params)
  {
    $model = new AKJurnalrekeningT();
    $model->attributes = $params;
    $model->create_time = date('Y-m-d');
    $model->update_time = date('Y-m-d');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->update_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    $model->rekperiod_id = $model->currentPeriod;

    // print_r($model->attributes); die;

    // if(empty($model->ruangan_id))
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      if ($model->save()) {
        $this->success = true;
      } else {
        $this->success = false;
        print_r($model->getErrors());
      }
    } else {
      print_r('AKJurnalrekeningT');
      print_r($model->getErrors());
      $this->success = false;
    }
    return $model;
  }

  private function simpanJurnalPosting($params)
  {
    $model = new AKJurnalpostingT();
    $model->attributes = $params;
    if ($model->validate()) {
      if ($model->save()) {
        $this->success = true;
      } else {
        $this->success = false;
        print_r($model->getErrors());
      }
    } else {
      $this->success = false;
      print_r($model->getErrors());
    }
    return $model;
  }

  private function simpanDetailJurnal($params, $jurnal_rek, $jurPosting = null)
  {
    $modDetail = $this->validasiTabular($params['AKJurnaldetailT']);
    foreach ($modDetail as $i => $data) {
      $data->rekperiod_id = $jurnal_rek->rekperiod_id;
      $data->jurnalrekening_id = $jurnal_rek->jurnalrekening_id;
      $data->uraiantransaksi = $jurnal_rek->urianjurnal;
      $data->saldodebit = MyFormatter::formatNumberForDb($data->saldodebit);
      $data->saldokredit = MyFormatter::formatNumberForDb($data->saldokredit);

      if ($data->jurnaldetail_id > 0) {
        if ($data->update()) {
          $this->success = true;
        } else {
          $this->success = false;
        }
      } else {
        if ($data->save()) {
          $this->success = true;
        } else {
          $this->success = false;
          print_r($data->getErrors());
        }
      }
    }
  }

  private function validasiTabular($params)
  {
    $modDetails = array();
    sort($params);
    foreach ($params as $i => $row) {
      $modDetails[$i] = new AKJurnaldetailT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionRincianJurnal()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKJurnaldetailT();
    $model->jurnalrekening_id = $_GET['id'];
    $this->render(
      '__gridRincianJurnal',
      array(
        'model' => $model
      )
    );
  }

  public function actionEditJurnal()
  {
    $model = $this->loadModel($_GET['id']);
    $this->render(
      'editJurnal',
      array(
        'model' => $model
      )
    );
  }

  public function actionPostingJurnal($nobuktijurnal = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $model = AKJurnalrekeningT::model()->findByAttributes(array('nobuktijurnal' => $nobuktijurnal));
    $model->jenisjurnal_nama = $model->jenisJurnal->jenisjurnal_nama;
    $model->rekperiode_nama = $model->rekPeriode->deskripsi;
    $modDetail = AKJurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $model->jurnalrekening_id));

    $modPostingJurnal = new AKJurnalpostingT;
    $modPostingJurnal->tgljurnalpost = date('Y-m-d H:i:s');
    $modDetailJurnal = array();
    $periodeID = Yii::app()->user->getState('periode_ids');
    $urlRedirect = Yii::app()->createUrl(Yii::app()->controller->module->id . '/RekperiodM');

    if (isset($_POST['AKJurnalpostingT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (count((array)$_POST['AKJurnaldetailT']) > 0) {
          foreach ($_POST['AKJurnaldetailT'] as $i => $postingJurnal) {
            $modDetailJurnal[$i] = $this->simpanPostingJurnal($_POST['AKJurnaldetailT'], $modPostingJurnal, $postingJurnal);
          }
        }
        if ($this->postingjurnalsimpan) {
          $transaction->commit();
          $this->redirect(array('postingJurnal', 'nobuktijurnal' => $model->nobuktijurnal, 'sukses' => 1, 'frame' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Alokasi Anggaran gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Posting Jurnal gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('postingJurnal', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'modPostingJurnal' => $modPostingJurnal,
      'redirect' => array($periodeID, $urlRedirect)
    ));
  }

  /**
   * simpan AKJurnalpostingT
   * @param type $postJurnalPosting
   * @param type $modPostingJurnal
   * @param type $postingJurnal
   * @return \AKJurnalpostingT
   */
  protected function simpanPostingJurnal($postJurnalPosting, $modPostingJurnal, $postingJurnal)
  {
    $format = new MyFormatter;
    $criteria = new CDbCriteria();
    $criteria->addCondition("DATE(tglperiodeposting_awal) <= '" . date("Y-m-d") . "' AND DATE(tglperiodeposting_akhir) >= '" . date("Y-m-d") . "'");

    $modPostingJurnal = new AKJurnalpostingT;
    $modPostingJurnal->attributes = $_POST['AKJurnalpostingT'];
    $modPostingJurnal->tgljurnalpost = $format->formatDateTimeForDb($_POST['AKJurnalpostingT']['tgljurnalpost']);
    $modPostingJurnal->keterangan = $_POST['AKJurnalpostingT']['keterangan'];
    $modPostingJurnal->create_time = date("Y-m-d H:i:s");
    $modPostingJurnal->create_loginpemekai_id = Yii::app()->user->id;
    $modPostingJurnal->create_ruangan = Yii::app()->user->ruangan_id;
    $modPostingJurnal->jurnaldetail_id = $postingJurnal['jurnaldetail_id'];
    $modPostingJurnal->periodeposting_id = (isset(PeriodepostingM::model()->find($criteria)->periodeposting_id) ? PeriodepostingM::model()->find($criteria)->periodeposting_id : NULL);

    if ($modPostingJurnal->validate()) {
      $modPostingJurnal->save();
      $this->postingjurnalsimpan = true;
      $this->updateJurnalDetail($modPostingJurnal);
    } else {
      $this->postingjurnalsimpan = false;
    }
    return $modPostingJurnal;
  }

  /**
   * update AKJurnaldetailT
   * @param type $modPostingJurnal
   * @return \AKJurnaldetailT
   */
  protected function updateJurnalDetail($modPostingJurnal)
  {
    $format = new MyFormatter;
    $modJurnalDetail = AKJurnaldetailT::model()->findByPk($modPostingJurnal->jurnaldetail_id);
    $modJurnalDetail->jurnalposting_id = $modPostingJurnal->jurnalposting_id;

    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
    }

    return $modJurnalDetail;
  }

  /**
   * untuk print jurnal posting
   */
  public function actionPrint($jurnalrekening_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = AKJurnalrekeningT::model()->findByPk($jurnalrekening_id);
    $criteria = new CDbCriteria();
    if (!empty($model->jurnalrekening_id)) {
      $criteria->addCondition('jurnalrekening_id = ' . $model->jurnalrekening_id);
    }
    $criteria->addCondition('jurnalposting_id is not null');
    $modDetail = AKJurnaldetailT::model()->findAll($criteria);

    $judulLaporan = 'Posting Jurnal';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render('Print', array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      'model' => $model,
      'modDetail' => $modDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
