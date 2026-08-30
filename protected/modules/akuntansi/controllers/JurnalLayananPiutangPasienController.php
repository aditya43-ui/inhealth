<?php

class JurnalLayananPiutangPasienController extends MyAuthController
{
  public $path_view = 'akuntansi.views.jurnalLayananPiutangPasien.';
  public $tersimpan = false;
  public $succesSave = false;
  public $layout = '//layouts/iframe';

  public function actionIndex()
  {
    $model = new JurnalpelayananV();

    if (isset($_POST['JurnalpelayananV']) && count((array)$_POST['JurnalpelayananV']) > 0) {
      $transaction = Yii::app()->db->beginTransaction();
      // echo '<pre>';
      // print_r($_POST);
      // exit();
      try {
        $jurnalPel = array();

        foreach ($_POST['JurnalpelayananV'] as $postJurnPel) {
          $jurnalPel[$postJurnPel['tindpelayanan_id']] = $postJurnPel;
        }

        $saveDetail = true;
        if (count((array)$jurnalPel) > 0) {
          foreach ($jurnalPel as $idPel => $postSimpanJurnal) {
            $modJurnalRekening = $this->saveJurnalRekening($postSimpanJurnal);

            foreach ($_POST['JurnalpelayananV'] as $postSimpanDetail) {
              if ($idPel == $postSimpanDetail['daftar_tindakan']) {
                $saveDetail = $this->saveJurnalDetail($modJurnalRekening, $postSimpanDetail['rekening5_id'], $postSimpanDetail['saldodebit'], $postSimpanDetail['saldokredit'], $postSimpanDetail['nourut']);
              }
            }
          }
        }

        if ($this->succesSave == true && $saveDetail == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model
    ));
  }

  public function actionSetFromLoadPiutang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";
      $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : null;
      $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : null;
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $nopendaftaran = isset($_POST['nopendaftaran']) ? $_POST['nopendaftaran'] : null;
      $norekam_medik = isset($_POST['norekam_medik']) ? $_POST['norekam_medik'] : null;

      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('date(tglpelayanan)', $tgl_awal, $tgl_akhir);
      $criteria->compare('lower(no_pendaftaran)', strtolower($nopendaftaran), true);
      $criteria->compare('lower(no_rekam_medik)', strtolower($norekam_medik), true);

      if (is_array($instalasi_id)) {
        $criteria->addInCondition('instalasi_id', $instalasi_id);
      } else {
        if (!empty($instalasi_id)) {
          $criteria->addCondition('instalasi_id = ' . $instalasi_id);
        }
      }

      if (is_array($ruangan_id)) {
        $criteria->addInCondition('ruangan_id', $ruangan_id);
      } else {
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
      }

      $criteria->addCondition('jurnalrekening_id IS NULL');

      $dataDetail = JurnalpelayananV::model()->findAll($criteria);

      if (count((array)$dataDetail) > 0) {
        $no = 1;

        foreach ($dataDetail as $i => $data) {
          $indexTransaksi = 0;
          $data->nobuktijurnal = "Otomatis";
          $data->kodejurnal = "Otomatis";
          $jnsJurnal = JenisjurnalM::model()->findAllByAttributes(array('istabpiutangpasien' => true));
          $data->jenisjurnal_id = (isset($jnsJurnal) ? $jnsJurnal->jenisjurnal_id : null);
          $data->jenisjurnal_nama = (isset($jnsJurnal) ? $jnsJurnal->jenisjurnal_nama : null);
          $data->noreferensi = $data->no_pendaftaran;
          $data->daftar_tindakan = $data->tindpelayanan_id;

          $arrNilaiDebitKredit = array();
          if ($data->jenistransaksi == 'tindakan') {
            $data->uraian = $data->no_pendaftaran . ' - ' . $data->nama_pasien . ' - PIUTANG TINDAKAN ' . $data->tindakan_nama;
            $arrNilaiDebitKredit[0] = array('debit' => $data->totaltagihan, 'kredit' => 0, 'saldonormal' => 'D', 'nourut' => 1);
            $arrNilaiDebitKredit[1] = array('debit' => 0, 'kredit' => $data->totaltagihan, 'saldonormal' => 'K', 'nourut' => 2);
            $indexTransaksi = 2;
          } else if ($data->jenistransaksi == 'obatalkes') {
            $data->uraian = $data->no_pendaftaran . ' - ' . $data->nama_pasien . ' - PIUTANG FARMASI ' . $data->tindakan_nama;

            $modOAP = ObatalkespasienT::model()->findByPk($data->tindpelayanan_id);

            if (isset($modOAP)) {
              $arrNilaiDebitKredit[0] = array('debit' => $modOAP->hargajual_oa, 'kredit' => 0, 'saldonormal' => 'D', 'nourut' => 1);
              $nourutoa = 2;
              if ($data->jumlahppn > 0) {
                $nourutoa = 3;
                $arrNilaiDebitKredit[1] = array('debit' => 0, 'kredit' => $modOAP->jumlahppn, 'saldonormal' => 'K', 'nourut' => 2);
              }
              $arrNilaiDebitKredit[2] = array('debit' => 0, 'kredit' => ($modOAP->hargasatuan_oa * $modOAP->qty_oa), 'saldonormal' => 'K', 'nourut' => $nourutoa);
            }
          }
          $classTr = ($i % 2 == 0) ? "clsOdd" : "clsEven";

          foreach ($arrNilaiDebitKredit as $nilaiDK) {
            $data->saldodebit = $nilaiDK['debit'];
            $data->saldokredit = $nilaiDK['kredit'];
            $debitReadonly = (($nilaiDK['saldonormal'] == 'D') ? false : true);
            $kreditReadonly = (($nilaiDK['saldonormal'] == 'K') ? false : true);
            $data->nourut = $nilaiDK['nourut'];
            $form .= $this->renderPartial($this->path_view . '_rowJurnal', array('modDetail' => $data, 'classTr' => $classTr, 'debitReadonly' => $debitReadonly, 'kreditReadonly' => $kreditReadonly), true);
          }
        }
      } else {
        $pesan = 'Data tidak ditemukan';
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  protected function saveJurnalRekening($postData)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = $postData['jenisjurnal_id'];
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($postData['tglbuktijurnal']);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $postData['noreferensi'];
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($postData['tglbuktijurnal']);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $postData['uraian'];

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($postData['jenistransaksi'] == 'tindakan') {
      $modJurnalRekening->tindakanpelayanan_id = $postData['tindpelayanan_id'];
    } else if ($postData['jenistransaksi'] == 'obatalkes') {
      $modJurnalRekening->obatalkespasien_id = $postData['tindpelayanan_id'];
    }

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldodebit, $nilaisaldokredit, $nourut)
  {
    $valid = true;

    $modelJurnalDetail = new JurnaldetailT();
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modelJurnalDetail->nourut = $nourut;
    $modelJurnalDetail->saldokredit = $nilaisaldokredit;
    $modelJurnalDetail->saldodebit = $nilaisaldodebit;

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      $valid = false;
    }

    return $valid;
  }
}
