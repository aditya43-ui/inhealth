<?php
/**
 * Controller Laporan Forbes
 *
 * @author Refi Fadholi <refifadholi.@gmail.com>
 */
class LaporanForbesController extends MyAuthController
{

    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Laporan Fobes Bedah Elektif";
        $model = new LaporanforbesbedahsentralV;

        if (isset($_REQUEST['LaporanforbesbedahsentralV'])) {
            $model->attributes = $_REQUEST['LaporanforbesbedahsentralV'];
            $model->kamarruangan_nobed = $_REQUEST['LaporanforbesbedahsentralV']['kamarruangan_nobed'];
        }

        $this->render('index', array(
            'model' => $model
        ));
    }

      /**
   * digunakan sebagai fungsi cetak laporan konusl gizi
   */
  public function actionPrint()
  {
    $model = new LaporanforbesbedahsentralV('search');
    $judulLaporan = 'LAPORAN FORBES <BR/> BEDAH ELEKTIF';
    $format = new MyFormatter();


    //Data Grafik
    $data['title'] = 'Grafik Laporan Forbes Bedah Elektif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    // if (isset($_REQUEST['LaporanforbesbedahsentralV'])) {
      $model->attributes = $_REQUEST;
    // }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

    /**
   * digunakan sebagai fungsi print global untuk gizi
   * @param object $model menampung data yang dikirim  
   * @param array $data menampung data informasi grafik
   * @param string $caraPrint digunakan untuk seleksi jenis print
   * @param string $judulLaporan menampung jul halaman cetak
   * @param string $target menampung halaman tujuan
   */
  protected function printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = "-";

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = 'L';                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /*
    Mengambil nama hari
    src: https://steemit.com/utopian-io/@rajamalikulfajar/how-to-display-the-day-name-in-indonesian-with-php-programming-language
  */
  public function hari_ini(){
    $hari = date ("D");
    
    switch($hari){
        case 'Sun':
            $hari_ini = "Minggu";
        break;
    
        case 'Mon':         
            $hari_ini = "Senin";
        break;
    
        case 'Tue':
            $hari_ini = "Selasa";
        break;
    
        case 'Wed':
            $hari_ini = "Rabu";
        break;
    
        case 'Thu':
            $hari_ini = "Kamis";
        break;
    
        case 'Fri':
            $hari_ini = "Jumat";
        break;
    
        case 'Sat':
            $hari_ini = "Sabtu";
        break;
        
        default:
            $hari_ini = "Tidak di ketahui";     
        break;
    }
    return $hari_ini;
    
    }
    
}