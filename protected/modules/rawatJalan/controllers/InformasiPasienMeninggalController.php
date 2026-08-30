<?php

class InformasiPasienMeninggalController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.informasiPasienMeninggal.';
    public $path_tips = 'sistemAdministrator.views.tips.';           
    
        
    /**
     * halaman informasi
     */
    public function actionIndex(){
                
        $model = new RJDaftarpasienmeninggalV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        $format = new MyFormatter();

        if (isset($_GET['RJDaftarpasienmeninggalV'])) {
            $model->attributes = $_GET['RJDaftarpasienmeninggalV'];
            $model->tgl_awal = isset($_GET['RJDaftarpasienmeninggalV']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['RJDaftarpasienmeninggalV']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['RJDaftarpasienmeninggalV']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['RJDaftarpasienmeninggalV']['tgl_akhir']):null;            
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'informasi-grid')
                    $path = $this->path_view.'_tabel';                                
                
                $this->renderPartial($path,['model'=>$model]);
            }
            exit;
        }
        
        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'format' => $format,
        ));
    
    }
    
    /**
     * cetak 
     */
    public function actionPrintInfo() {
        
        $model = new RJDaftarpasienmeninggalV;          

        if (isset($_GET['RJDaftarpasienmeninggalV'])) {
            $model->attributes = $_GET['RJDaftarpasienmeninggalV'];
            $model->id_lab = isset($_GET['RJDaftarpasienmeninggalV']['id_lab'])?$_GET['RJDaftarpasienmeninggalV']['id_lab']:null;
            $model->nama_peneliti = isset($_GET['RJDaftarpasienmeninggalV']['nama_peneliti'])?$_GET['RJDaftarpasienmeninggalV']['nama_peneliti']:null;
            $model->pasien_nama = isset($_GET['RJDaftarpasienmeninggalV']['pasien_nama'])?$_GET['RJDaftarpasienmeninggalV']['pasien_nama']:null;
            $model->pasien_norm = isset($_GET['RJDaftarpasienmeninggalV']['pasien_norm'])?$_GET['RJDaftarpasienmeninggalV']['pasien_norm']:null;
        }
      
        $judulLaporan = 'Data Sel Rusak pada Proses';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }        
       
}
