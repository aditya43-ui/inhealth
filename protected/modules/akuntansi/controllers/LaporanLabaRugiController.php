<?php
class LaporanLabaRugiController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanLabaRugi.';

  public function actionIndex($caraPrint = null)
  {
    $this->pageTitle = Yii::app()->name . " - Laba Rugi";
    $model = new AKLaporanlabarugiV('searchLaporan2');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-t', strtotime('first day of this month'));

    //$criteria = new CDbCriteria();
    //$criteria->addCondition("'".date("Y-m-d")."'::date between tglperiodeposting_awal and tglperiodeposting_akhir");
    //$periode = PeriodepostingM::model()->find($criteria);

    //	if (!empty($periode))
    //		$model->periodeposting_id = $periode->periodeposting_id;

    if (isset($_GET['AKLaporanlabarugiV'])) {

      $model->attributes = $_GET['AKLaporanlabarugiV'];
      $format = new MyFormatter();

      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKLaporanlabarugiV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKLaporanlabarugiV']['tgl_akhir']);

      //$model->bulan = $_GET['AKLaporanlabarugiV']['bulan'];
      //$model->thn_awal = $_GET['AKLaporanlabarugiV']['thn_awal'];
    }

    //var_dump($model->bulan); die;


    //$models = $model->findAll($model->searchLaporan2());
    $models = array();
    echo $this->render(
      $this->path_view . 'admin',
      array(
        'model' => $model,
        'models' => $models,
        'caraPrint' => $caraPrint,
      ),
      true
    );
  }

  public function actionPrintLaporanLabaRugi()
  {
    $model = new AKLaporanlabarugiV('searchLaporan2');
    $model->unsetAttributes();
    //$model->tgl_awal = date('m-d', strtotime('first day of this month'));
    //$model->thn_awal = date('Y');
    $judulLaporan = 'LAPORAN LABA RUGI';

    //Data Grafik       
    $data['title'] = 'GRAFIK LAPORAN LABA RUGI';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
    if (isset($_REQUEST['AKLaporanlabarugiV'])) {
      $model->attributes = $_REQUEST['AKLaporanlabarugiV'];
      $format = new MyFormatter();

      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKLaporanlabarugiV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKLaporanlabarugiV']['tgl_akhir']);
    }

    $periode = $_GET['AKLaporanlabarugiV']['tgl_awal'] . " s/d " . $_GET['AKLaporanlabarugiV']['tgl_akhir'];
    $print_periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . " s/d " . MyFormatter::formatDateTimeForUser($model->tgl_akhir);


    $models = $model->findAll($model->searchLaporan2());
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $segmen = null; //$_REQUEST['Segmen'];
    // $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

    // $print_periode = $periodeposting_id->periodeposting_nama;

    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array(
        'model' => $model, 'models' => $models, 'print_periode' => $print_periode,
        /* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen' => $segmen
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array(
        'model' => $model, 'models' => $models, 'print_periode' => $print_periode,
        /* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen' => $segmen
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $target = $this->path_view . '_print';
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array(
        'model' => $model, 'models' => $models, 'print_periode' => $print_periode,
        'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen' => $segmen
      ), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function PeriodeHeader($periode = null, $models = null)
  {
    $dataArray = array();
    foreach ($models as $row => $data) {
      $dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
    }
    foreach ($dataArray as $row => $data) {
      if (!empty($data)) {
        if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
          $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
          $periode_array .= "<th ALIGN=CENTER>" . MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal']))) . "</th>";
        } else {
          $periode_array .= "<td></td>";
        }
        $jmlKolom++;
      } else {
        if (!empty($models) || !empty($data)) {
          $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;
          $periode_array .= "<th ALIGN=CENTER>" . MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data))) . "</th>";
        } else {
          $periode_array .= "<td></td>";
        }
        $jmlKolom++;
      }
    }
    return $periode_array;
  }
}
