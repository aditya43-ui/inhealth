<?php
Yii::import('akuntansi.controllers.JurnalPenerimaanKasController');
Yii::import('akuntansi.views.jurnalPenerimaanKas');

class JurnalPengeluaranKasController extends JurnalPenerimaanKasController
{
  public function actionGetDaftarRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $format = new MyFormatter();
      $model = new AKJurnaldetailT();
      $model->attributes = $data_parsing['AKJurnalrekeningT'];
      $model->is_posting = 1;
      $model->tgl_awal = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_akhir']);
      $model->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
      $model->kodejurnal = $data_parsing['AKJurnalrekeningT']['kodejurnal'];
      $model->nobuktijurnal = $data_parsing['AKJurnalrekeningT']['nobuktijurnal'];
      $record = $model->searchWithJoin();
      $record->pagination = false;
      $record->criteria->limit = -1;

      $result = array();
      $aa = array();

      foreach ($record->getData() as $key => $val) {
        $attributes = $val->attributes;
        $attributes['tglbuktijurnal'] = date("d-m-Y", strtotime($val->jurnalRekening->tglbuktijurnal));
        $attributes['tglbuktijurnalform'] = MyFormatter::formatDateTimeForuser($val->jurnalRekening->tglbuktijurnal);
        $attributes['nobuktijurnal'] = $val->jurnalRekening->nobuktijurnal;
        $attributes['kodejurnal'] = $val->jurnalRekening->kodejurnal;
        //                $attributes['urianjurnal'] = $val->jurnalRekening->urianjurnal;
        $attributes['urianjurnal'] = (!empty($val->uraiantransaksi) ? $val->uraiantransaksi : $val->jurnalRekening->urianjurnal);
        $attributes['tglreferensi'] = MyFormatter::formatDateTimeForUser($val->jurnalRekening->tglreferensi);
        $attributes['noreferensi'] = $val->jurnalRekening->noreferensi;

        $criteria = new CDbCriteria;
        // if (!empty($val->rekening1_id)) {
        //   $criteria->addCondition("rekening1_id = " . $val->rekening1_id);
        // }
        // if (!empty($val->rekening2_id)) {
        //   $criteria->addCondition("rekening2_id = " . $val->rekening2_id);
        // }
        // if (!empty($val->rekening3_id)) {
        //   $criteria->addCondition("rekening3_id = " . $val->rekening3_id);
        // }
        // if (!empty($val->rekening4_id)) {
        //   $criteria->addCondition("rekening4_id = " . $val->rekening4_id);
        // }
        if (!empty($val->rekening5_id)) {
          $criteria->addCondition("rekening5_id = " . $val->rekening5_id);
        }
        $rec_nama = Rekening5M::model()->find($criteria);
        // $rec_nama = AKRekeningakuntansiV::model()->find($criteria);

        if (!empty($rec_nama)) {
          $attributes['rekening5_id'] = $rec_nama->rekening5_id;
          $attributes['rekening4_id'] = null;
          $attributes['rekening3_id'] = null;
          $attributes['rekening2_id'] = null;
          $attributes['rekening1_id'] = null;

          $nama_rekening = $rec_nama->nmrekening5;
          $kode_rekening = $rec_nama->kdrekening5;
          $status_rekening = $rec_nama->rekening5_nb;
        } else {

          $attributes['rekening5_id'] = null;
          $attributes['rekening4_id'] = null;
          $attributes['rekening3_id'] = null;
          $attributes['rekening2_id'] = null;
          $attributes['rekening1_id'] = null;

          $nama_rekening = "-";
          $kode_rekening = "-";
          $status_rekening = "D";
        }
        $attributes['nama_rekening'] = $nama_rekening;
        $attributes['kode_rekening'] = $kode_rekening;
        $attributes['saldo_normal'] = ($status_rekening == "D" ? "Debit" : "Kredit");
        $attributes['saldodebit'] = number_format($attributes['saldodebit'], 2, ",", ".");
        $attributes['saldokredit'] = number_format($attributes['saldokredit'], 2, ",", ".");
        //                $attributes['saldodebit'] = number_format($attributes['saldodebit']);
        //                $attributes['saldokredit'] = number_format($attributes['saldokredit']);

        $attributes['cehkRek'] = 0;
        $result[] = $attributes;
      }

      foreach ($result as $data) {
        $aa[$data['kodejurnal']][] = $data;
      }
      $index = 0;
      $indexData = 0;
      $dp = [];
      foreach ($aa as $i => $itemd) {
        foreach ($itemd as $data) {

          $data['cehkRek'] = $index;
          $dp[] = array('cehkRek' => $index, 'kodejurnal' => $data['kodejurnal']);
        }
        $index++;
      }
      $cek = false;
      foreach ($result as $dataRs) {
        $cek = false;
        foreach ($dp as $dataDp) {
          if ($dataRs['kodejurnal'] == $dataDp['kodejurnal']) {
            $dataRs['cehkRek'] = $dataDp['cehkRek'];
            $cek = true;
            break;
          }
        }
        $result[$indexData] = $dataRs;
        $indexData++;
      }

      echo json_encode($result);
    }
    Yii::app()->end();
  }
}
