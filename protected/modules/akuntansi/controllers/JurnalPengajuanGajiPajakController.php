<?php

/**
 * Description of JurnalPengajuanGajiPajakController
 *
 * @author inova
 */
class JurnalPengajuanGajiPajakController extends MyAuthController
{
  public $path_view = "akuntansi.views.jurnalPengajuanGajiPajak.";

  public function actionIndex()
  {
    if (isset($_POST['form_cari']) && isset($_POST['form_cari']['penggajianpeg_id']) && isset($_POST['form_cari']['rekening'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $rekening = $this->simpanJurnal($_POST['form_cari'], $ok);
        $ok = $ok && $this->simpanJurnalDetail($rekening, $_POST['form_cari']);

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Pengajuan Pengajuan Gaji berhasil disimpan !");
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data Pengajuan Pengajuan Gaji gagal disimpan !");
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Pengajuan Pengajuan Gaji gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . "index", array());
  }


  protected function simpanJurnal($post, &$ok)
  {

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $model = new JurnalrekeningT();



    $model->urianjurnal = "Pengajuan Gaji Pegawai " . $post['kategori'] . " Periode " . $post['periodegaji'];
    $model->jenisjurnal_id = 13;
    $model->tglbuktijurnal = $model->tglreferensi = $model->create_time = date('Y-m-d H:i:s');
    $model->noreferensi = "-";

    $modJenisjurnal = JenisjurnalM::model()->findByPk($model->jenisjurnal_id);
    $model->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $model->kodejurnal = MyGenerator::kodeJurnalRek();

    $periodeID = $period;
    $model->rekperiod_id = $periodeID;
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      $ok = $ok && $model->save();
      if (isset($post['penggajianpeg_id'])) {
        $penggajianpeg_id = CJSON::decode($post['penggajianpeg_id']);
        foreach ($penggajianpeg_id as $id) {
          PenggajianpegT::model()->updateByPk($id, array(
            'jurnalrekening_id' => $model->jurnalrekening_id
          ));
        }
      }
    } else {
      $ok = false;
    }

    return $model;
  }

  protected function simpanJurnalDetail($rekening, $post)
  {
    $ok = true;

    $idx = 1;
    foreach ($post['rekening'] as $rekening_id => $item) {

      $rek = RekeningakuntansiV::model()->findByAttributes(array(
        'rekeninglast_id' => $rekening_id
      ));

      $detail = new JurnaldetailT();
      $detail->jurnalrekening_id = $rekening->jurnalrekening_id;
      $detail->rekperiod_id = $rekening->rekperiod_id;
      $detail->rekening5_id = $rekening_id;
      // $detail->rekening4_id = $rek->rekening4_id;
      // $detail->rekening3_id = $rek->rekening3_id;
      // $detail->rekening2_id = $rek->rekening2_id;
      // $detail->rekening1_id = $rek->rekening1_id;
      $detail->nourut = $idx++;
      $detail->uraiantransaksi = $rekening->urianjurnal;
      $detail->saldodebit = $item['debit'];
      $detail->saldokredit = $item['kredit'];

      if ($detail->validate()) {
        $ok = $ok && $detail->save();
      } else {
        $ok = false;
      }

      //            var_dump($detail->attributes);
    }

    //        var_dump($ok, $post, $rekening->attributes);
    //        die;

    return $ok;
  }

  public function actionLoadNilaiPengajuan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $jumlah_pegawai = 0;
    $total_pengajuan = 0;
    $total_pajak = 0;
    $penggajian_id = array();

    $html = "";

    if (isset($_POST['form_cari'])) {
      $cr = new CDbCriteria();
      $cr->join = "join pegawai_m p on p.pegawai_id = t.pegawai_id "
        . " LEFT JOIN jurnalrekening_t j ON j.jurnalrekening_id = t.jurnalrekening_id";
      $cr->compare('t.periodegaji', MyFormatter::formatMonthForDb($_POST['form_cari']['periodegaji']) . "-01");
      $cr->compare("p.kategoripegawaiasal", $_POST['form_cari']['kategori']);
      $cr->addCondition("t.tgl_menyetujui is not null");
      $cr->addCondition('j.jurnalrekening_id is null');


      $kategori = $_POST['form_cari']['kategori'];

      $model = PenggajianpegT::model()->findAll($cr);
      $bpjs_naker = 0;
      $bpjs_kes = 0;
      $totalbpjskaryawan = 0;

      foreach ($model as $item) {
        $penggajian_id[] = $item->penggajianpeg_id;
        $jumlah_pegawai++;
        $total_pengajuan += $item->penerimaanbersih;
        $total_pajak += $item->totalpajak;

        $modKomp = PenggajiankompT::model()->findAllByAttributes(array('penggajianpeg_id' => $item->penggajianpeg_id));

        if (count((array)$modKomp) > 0) {
          foreach ($modKomp as $pegkomp) {
            if (
              $pegkomp->komponengaji_id == 116 ||
              $pegkomp->komponengaji_id == 115 ||
              $pegkomp->komponengaji_id == 119 ||
              $pegkomp->komponengaji_id == 120
            ) {
              $bpjs_naker += $pegkomp->jumlah;
            }

            if ($pegkomp->komponengaji_id == 117) {
              $bpjs_kes += $pegkomp->jumlah;
            }

            if ($pegkomp->komponengaji_id == 100 || $pegkomp->komponengaji_id == 99 || $pegkomp->komponengaji_id == 95) {
              $totalbpjskaryawan += $pegkomp->jumlah;
            }
          }
        }
      }

      $jamsostek = ($bpjs_naker + $bpjs_kes);

      // rek
      if ($kategori == "RS") {
        $rek_gaji_d = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'penggajianpeg_t',
          'column_name' => 'penerimaanbersih',
          'debitkredit' => 'D',
        ));
      } else {
        $rek_gaji_d = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'penggajianpeg_t',
          'column_name' => 'penerimaanbersih_pt',
          'debitkredit' => 'D',
        ));
      }
      $total_pengajuan = ($total_pengajuan + $totalbpjskaryawan);

      $totalpengajuan_total = ($total_pengajuan + $total_pajak);

      if ($totalpengajuan_total > 0) {
        if (!empty($rek_gaji_d)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_gaji_d, 'debitkredit' => 'D', 'nilai' => $total_pengajuan + $total_pajak), true);
        }
      }

      // JAMSOSTEK
      if ($jamsostek > 0) {
        $rekgajijamsostek_d = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PENGGAJIANPEGT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_JAMSOSTEK,
          'debitkredit' => 'D'
        ));

        if (isset($rekgajijamsostek_d)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rekgajijamsostek_d, 'debitkredit' => 'D', 'nilai' => $jamsostek), true);
        }
      }

      // BPJS KETENAGAKERJAAN
      if ($bpjs_naker > 0) {
        $rekgajibpjsnaker_k = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PENGGAJIANPEGT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_BPJSKETENAGAKERJA,
          'debitkredit' => 'K'
        ));

        if (isset($rekgajibpjsnaker_k)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rekgajibpjsnaker_k, 'debitkredit' => 'K', 'nilai' => $bpjs_naker), true);
        }
      }

      // BPJS KESEHATAN
      if ($bpjs_kes > 0) {
        $rekgajibpjskes_k = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PENGGAJIANPEGT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_BPJSKESEHATAN,
          'debitkredit' => 'K'
        ));

        if (isset($rekgajibpjskes_k)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rekgajibpjskes_k, 'debitkredit' => 'K', 'nilai' => $bpjs_kes), true);
        }
      }

      if ($total_pajak > 0) {

        $rek_pajak_d = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => 'penggajianpeg_t',
          'column_name' => 'totalpajak',
          'debitkredit' => 'K',
        ));
        if (!empty($rek_pajak_d)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_pajak_d, 'debitkredit' => 'K', 'nilai' => $total_pajak), true);
        }
      }


      $rek_gaji_k = RekeningcolumnM::model()->findByAttributes(array(
        'table_name' => 'penggajianpeg_t',
        'column_name' => 'penerimaanbersih',
        'debitkredit' => 'K',
      ));

      if ($total_pengajuan > 0) {
        if (!empty($rek_gaji_k)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_gaji_k, 'debitkredit' => 'K', 'nilai' => $total_pengajuan), true);
        }
      }
    }


    echo CJSON::encode(array(
      'rekening' => $html,
      'jumlah_pegawai' => $jumlah_pegawai,
      'total_pengajuan' => MyFormatter::formatNumberForPrint($total_pengajuan),
      'total_pajak' => MyFormatter::formatNumberForPrint($total_pajak),
      'total_bpjsketenagakerjaan' => MyFormatter::formatNumberForPrint($bpjs_naker),
      'total_bpjskesehatan' => MyFormatter::formatNumberForPrint($bpjs_kes),
      'penggajianpeg_id' => $penggajian_id,
    ));
  }
}
