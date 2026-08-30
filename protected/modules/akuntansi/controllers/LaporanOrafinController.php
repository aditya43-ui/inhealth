<?php

class LaporanOrafinController extends MyAuthController
{
  protected $path_view = 'akuntansi.views.laporanOrafin.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Integrasi Orafin";
    //            $model	= new AKLaporanrekonsiliasibankV('searchLaporan');
    $model = new AKBukubesarT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //            $model->bln_awal = date('Y-m', strtotime('first day of january'));
    //            $model->bln_akhir = date('Y-m');
    //            $model->thn_awal = date('Y');
    //            $model->thn_akhir = date('Y');

    if (isset($_GET['AKBukubesarT'])) {
      $model->attributes = $_GET['AKBukubesarT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'admin', array(
      'format' => $format,
      'model' => $model
    ));
  }

  public function actionPrintLaporanOrafin()
  {
    $model = new AKBukubesarT('searchLaporanOrafinPrint');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $judulLaporan = 'Laporan Orafin';
    //Data Grafik
    $data['title'] = 'Laporan Orafin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['AKBukubesarT'])) {
      $model->attributes = $_GET['AKBukubesarT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } elseif ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } elseif ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');

      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew',array(),true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionEksportCSV()
  {
    $this->layout = FALSE;
    $jenis = "export";
    $dt = array();
    $modelData = null;
    $tableName = "bukubesar_t";

    $table = Yii::app()->db->getSchema()->getTable($tableName);
    if (isset($_GET['AKBukubesarT'])) {
      $model = new AKBukubesarT();
      $format = new MyFormatter();
      $model->attributes = $_GET['AKBukubesarT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKBukubesarT']['tgl_akhir']);

      $criteria = new CDbCriteria;
      $criteria->select = "t.bukubesar_id, t.tglbukubesar, t.saldodebit, t.saldokredit, t.update_time, t.no_referensi, t.jurnalposting_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5,jurnalrekening_t.urianjurnal, jenisjurnal_m.jenisjurnal_nama, jurnalrekening_t.kodejurnal";
      $criteria->join = " JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id"
        . " LEFT JOIN jurnalposting_t ON jurnalposting_t.jurnalposting_id=t.jurnalposting_id"
        . " LEFT JOIN jurnaldetail_t ON jurnaldetail_t.jurnaldetail_id = jurnalposting_t.jurnaldetail_id"
        . " LEFT JOIN jurnalrekening_t ON jurnalrekening_t.jurnalrekening_id = jurnaldetail_t.jurnalrekening_id"
        . " LEFT JOIN jenisjurnal_m ON jenisjurnal_m.jenisjurnal_id = jurnalrekening_t.jenisjurnal_id";

      $criteria->addBetweenCondition('DATE(t.tglbukubesar)', $model->tgl_awal, $model->tgl_akhir);
      $criteria->order = 'jurnalrekening_t.nobuktijurnal,jurnaldetail_t.nourut';
      $modelData = AKBukubesarT::model()->findAll($criteria);
    }

    $content = "";
    $content .= 'TRANSACTION_ID, STATUS, LEDGER_ID, ACCOUNTING_DATE, CURRENCY_CODE, ACTUAL_FLAG, USER_JE_CATEGORY_NAME, USER_JE_SOURCE_NAME, USER_CURRENCY_CONVERSION_TYPE, CURRENCY_CONVERSION_RATE,SEGMENT1,SEGMENT2,SEGMENT3,SEGMENT4,SEGMENT5,SEGMENT6,SEGMENT7,SEGMENT8,SEGMENT9,SEGMENT10,ENTERED_DR,ENTERED_CR,ATTRIBUTE1,ATTRIBUTE2,ATTRIBUTE3,ATTRIBUTE4,ATTRIBUTE5,ATTRIBUTE6,ATTRIBUTE7,ATTRIBUTE8,ATTRIBUTE9,ATTRIBUTE10,ATTRIBUTE11,ATTRIBUTE12,ATTRIBUTE13,ATTRIBUTE14,ATTRIBUTE15,ATTRIBUTE16,ATTRIBUTE17,ATTRIBUTE18,ATTRIBUTE19,REFERENCE1,REFERENCE2,REFERENCE3,REFERENCE4,REFERENCE5,REFERENCE6,REFERENCE7,REFERENCE8,REFERENCE9,REFERENCE10,TRANSACTION_REFFERENCE_ID,PROCESSED_FLAG,LAST_UPDATE_DATE';
    $content .= "\n";
    //               $content .= 'NUMBER, VARCHAR2(50 BYTE), NUMBER, DATE, VARCHAR2(15 BYTE), VARCHAR2(1 BYTE), VARCHAR2(25 BYTE), VARCHAR2(25 BYTE), VARCHAR2(30 BYTE), NUMBER(18 2),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),VARCHAR2(25 BYTE),NUMBER(18 2),NUMBER(18 2),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(150 BYTE),VARCHAR2(100 BYTE),VARCHAR2(240 BYTE),VARCHAR2(100 BYTE),VARCHAR2(100 BYTE),VARCHAR2(240 BYTE),VARCHAR2(100 BYTE),VARCHAR2(100 BYTE),VARCHAR2(100 BYTE),VARCHAR2(100 BYTE),VARCHAR2(240 BYTE),NUMBER,VARCHAR2(1 BYTE),DATE';
    $content .= "\n";


    foreach ($modelData as $data) {
      $content .= $data->bukubesar_id . ', NEW, 2271, ' . date('d/m/Y', strtotime($data->tglbukubesar)) . ', IDR, A, SHB INV Receiving, SHB, , , 12, 000, 00, ' . $data->kdrekening5 . ',  00,  000,  000, , , , ' . $data->saldodebit . ', ' . $data->saldokredit . ', , , , , , , , , , , , , , , , , , , ,' . $data->jenisjurnal_nama . ', ' . $data->jenisjurnal_nama . ', ,' . $data->jenisjurnal_nama . ',' . $data->urianjurnal . ' ,' . $data->jenisjurnal_nama . ', , , ,' . $data->urianjurnal . ',' . $data->jurnalposting_id . ', U,' . $data->update_time;
      $content .= "\n";
    }

    $judul = "LAPORAN_HIS_ORAFIN";

    Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
    die;
  }
}
