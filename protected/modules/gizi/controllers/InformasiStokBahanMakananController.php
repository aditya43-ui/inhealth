<?php

class InformasiStokBahanMakananController extends MyAuthController
{
    public $path_view = "gizi.views.informasiStokBahanMakanan.";
    public function actionIndex()
    {               
        $model = new GZInformasistokbahanmakananV;

        if(isset($_GET['GZInformasistokbahanmakananV'])){
            $model->attributes=$_GET['GZInformasistokbahanmakananV'];
            $model->ceklisminimal = $_GET['GZInformasistokbahanmakananV']['ceklisminimal'];
        }
        $this->render('index',array('model'=>$model));
    }
             
    public function actionPrint() {
        $model = new GZInformasistokbahanmakananV;
        $model->unsetAttributes();  // clear any default values
        
        if(isset($_GET['GZInformasistokbahanmakananV'])){
            $model->attributes=$_GET['GZInformasistokbahanmakananV'];
            $model->ceklisminimal = $_GET['GZInformasistokbahanmakananV']['ceklisminimal'];
        }
        $judulLaporan = ' Informasi Stok Bahan Makanan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    public function actionRincian($id){
        $this->layout ='//layouts/iframe';
        $model = StokbahanmakananT::model()->findAllByAttributes(array('bahanmakanan_id'=>$id));
        $judulLaporan='RINCIAN STOK BAHAN MAKANAN';
        
        $caraPrint = isset($_REQUEST['caraPrint'])? $_REQUEST['caraPrint']: null;
        
        if(!empty($caraPrint)){
            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
            } 
        }
        
        $this->render($this->path_view.'rincian', array(
            'model'=>$model,
            'judulLaporan'=>$judulLaporan,
            'bahanmakanan_id'=>$id,
             'caraPrint' => $caraPrint
        ));
    }
}