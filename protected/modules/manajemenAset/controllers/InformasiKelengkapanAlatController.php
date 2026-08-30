<?php
/**
* - digunakan sebagai Informasi kelengkapan alat
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
class InformasiKelengkapanAlatController extends MyAuthController
{    
    /**
     * action untuk masuk ke menu informasi kelengkapan alat
     */
    public function actionIndex(){
        
        $model = new MAInformasikelengkapanperalatanV('search');
        
        if (isset($_GET['MAInformasikelengkapanperalatanV'])){
            $model->attributes = $_GET['MAInformasikelengkapanperalatanV'];                        
        }
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                $path_view = 'grid/_tabel';
                if ($ajax == 'ruangan-m-grid')
                    $path_view = 'grid/_grid_ruangan';
                else if ($ajax == 'lokasiaset-m-grid')
                    $path_view = 'grid/_grid_lokasi';
                else if ($ajax == 'gedung-m-grid')
                    $path_view = 'grid/_grid_gedung';
                else if ($ajax == 'barang-m-grid')
                    $path_view = 'grid/_grid_barang';
                    
                $this->renderPartial($path_view,[
                    'model'=>$model,            
                ]);
            }
        }else{       
            $this->render('index',[
                'model'=>$model,            
            ]);
        }
    }
    
    public function actionPrintInfo() {
        
        $model = new MAInformasikelengkapanperalatanV;          

        if (isset($_GET['MAInformasikelengkapanperalatanV'])) {
            $model->attributes = $_GET['MAInformasikelengkapanperalatanV'];                        
        }
        
        $judulLaporan = 'Data Kelengkapan Alat';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('_print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('_print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial( '_print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }
    
    /**
     * 
     * @param type $id
     */
    public function actionDetailPerizinan($id){
        $model = MAInvperizinanT::model()->findByPk($id);
        $model->pelaksana = $model->pegawai->namaLengkap;
        
        $this->render('detail/_perizinan',[
            'model'=>$model,            
        ]);
    }
    
    /**
     * 
     * @param type $id
     */
    public function actionUnduh($id,$lampiran) {

        $filename = MAInvperizinanT::model()->findByPk($id);
        $nm_col = 'lampiranfile_'.$lampiran;
        $file = $filename->$nm_col;
        
        $path = Params::pathInvperizinanDirectory().$file ;

        if (!empty($file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
        }
    }
}