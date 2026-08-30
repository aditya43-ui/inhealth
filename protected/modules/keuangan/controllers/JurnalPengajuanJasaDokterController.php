<?php

/**
 * Description of JurnalPengajuanGajiPajakController
 *
 * @author inova
 */
class JurnalPengajuanJasaDokterController extends MyAuthController
{
  public $path_view = "keuangan.views.jurnalPengajuanJasaDokter.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Jurnal Pengajuan Jasa Dan Pajak Dokter";
    if (isset($_POST['form_cari']) && isset($_POST['form_cari']['pembayaranjasa_id']) && isset($_POST['form_cari']['rekening'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $rekening = $this->simpanJurnal($_POST['form_cari'], $ok);
        $ok = $ok && $this->simpanJurnalDetail($rekening, $_POST['form_cari']);

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Jurnal Pengajuan Jasa Dokter berhasil disimpan !");
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data Jurnal Pengajuan Jasa Dokter gagal disimpan !");
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Jurnal Pengajuan Jasa Dokter gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
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

    $model->urianjurnal = "Pengajuan Jasa Dokter Periode " . $post['periodegaji'];
    $model->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
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
      if (isset($post['pembayaranjasa_id'])) {
        $pembayaranjasa_id = CJSON::decode($post['pembayaranjasa_id']);
        foreach ($pembayaranjasa_id as $id) {
          PembayaranjasaT::model()->updateByPk($id, array(
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
      //            $modJurnalPosting = null;

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
        if ($detail->save()) {
          $ok = true;
          //                   if(Yii::app()->user->getState('ispostingotomatis'))
          //                    {
          //                        $criteria = new CDbCriteria();
          //                        $criteria->addCondition("DATE(tglperiodeposting_awal) <= '" . date("Y-m-d") . "' AND DATE(tglperiodeposting_akhir) >= '" . date("Y-m-d") . "'");
          //                        $modJurnalPosting = new JurnalpostingT;
          //                        $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
          //                        $modJurnalPosting->keterangan = "Posting automatis";
          //                        $modJurnalPosting->create_time = date('Y-m-d H:i:s');
          //                        $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
          //                        $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
          //                        $modJurnalPosting->jurnaldetail_id = $detail->jurnaldetail_id;
          //                        $modJurnalPosting->periodeposting_id = (isset(PeriodepostingM::model()->find($criteria)->periodeposting_id) ? PeriodepostingM::model()->find($criteria)->periodeposting_id : NULL);
          //
          //                        if($modJurnalPosting->validate()){
          //                            if($modJurnalPosting->save()){
          //                                $ok = true;
          //                                JurnaldetailT::model()->updateByPk($detail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
          //                            }
          //                        }
          //                    }
        } else {
          $ok = false;
        }
      } else {
        $ok = false;
      }
    }

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
    $pembayaranjasa_id = array();

    $html = "";

    if (isset($_POST['form_cari'])) {
      $cr = new CDbCriteria();
      $cr->join = "join pegawai_m p on p.pegawai_id = t.pegawai_id "
        . " LEFT JOIN jurnalrekening_t j ON j.jurnalrekening_id = t.jurnalrekening_id";
      $cr->compare('t.periodejasa', MyFormatter::formatMonthForDb($_POST['form_cari']['periodegaji']) . "-01");
      $cr->addCondition("t.tgl_menyetujui is not null");
      $cr->addCondition('j.jurnalrekening_id is null');

      $model = PembayaranjasaT::model()->findAll($cr);

      foreach ($model as $item) {
        $pembayaranjasa_id[] = $item->pembayaranjasa_id;
        $jumlah_pegawai++;
        $total_pengajuan += $item->totalbayarjasa;
        $total_pajak += $item->total_pajak;
      }

      $totalpengajuan_total = (round($total_pengajuan) + round($total_pajak));

      // Debit Pengajuan Jasa Dokter
      if ($totalpengajuan_total > 0) {
        $rek_pemb_d = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PEMBAYARANJASAT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_TOTALBAYARJASA,
          'debitkredit' => 'D'
        ));

        if (!empty($rek_pemb_d)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_pemb_d, 'debitkredit' => 'D', 'nilai' => $totalpengajuan_total), true);
        }
      }

      // Kredit Pajak Dokter
      if ($total_pajak > 0) {
        $rek_pajak = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PEMBAYARANJASAT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_TOTALPAJAK,
          'debitkredit' => 'K'
        ));
        if (!empty($rek_pajak)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_pajak, 'debitkredit' => 'K', 'nilai' => $total_pajak), true);
        }
      }

      // Kredit Pengajuan Jasa Dokter
      if ($total_pengajuan > 0) {
        $rek_pemb_k = RekeningcolumnM::model()->findByAttributes(array(
          'table_name' => Params::REKENINGCOLUMN_TABLE_PEMBAYARANJASAT,
          'column_name' => Params::REKENINGCOLUMN_COLUMN_TOTALBAYARJASA,
          'debitkredit' => 'K'
        ));
        if (!empty($rek_pemb_k)) {
          $html .= $this->renderPartial($this->path_view . '_rowRekening', array('rekening' => $rek_pemb_k, 'debitkredit' => 'K', 'nilai' => $total_pengajuan), true);
        }
      }
    }


    echo CJSON::encode(array(
      'rekening' => $html,
      'jumlah_pegawai' => $jumlah_pegawai,
      'total_pengajuan' => MyFormatter::formatNumberForPrint($total_pengajuan),
      'total_pajak' => MyFormatter::formatNumberForPrint($total_pajak),
      'pembayaranjasa_id' => $pembayaranjasa_id,
    ));
  }
}
