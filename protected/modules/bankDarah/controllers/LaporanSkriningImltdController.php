<?php
/**
* digunakan sebagai Laporan Skrining IMLTD
* @author Elham Budianto <elhambudianto1@gmail.com>
* @package application.modules.bankDarah
* @subpackage controllers
**/
class LaporanSkriningImltdController extends MyAuthController {
    
    /**
     * Fungsi untuk load halaman awal
     */
    public function actionIndex() {
        $model = new LapskriningdarahV('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        $this->render('admin', array(
            'model' => $model
        ));
    }
    
    /**
     * Fungsi untuk mendapatkan data laporan skrining
     */
    public function actionGetLaporan(){
        if (Yii::app()->request->isAjaxRequest){
            //mendapatkan tanggal awal dan tanggal akhir dari form search
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
            $data = $this->getData($tgl_awal,$tgl_akhir);
            $tr = $this->renderPartial('_detailLaporan', array('data'=>$data), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi untuk mendapatkan data skrining
     * @param type $tgl_awal
     * @param type $tgl_akhir
     * @return type
     */
    public function getData($tgl_awal , $tgl_akhir){
        //mendapatkan tanggal awal dan tanggal akhir dari form search
            //$tgl_awal = $_POST['tgl_awal'];
            //$tgl_akhir = $_POST['tgl_akhir'];
            
            $tanggal_awal = date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
            $tanggal_akhir = date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));
            
            //mencari data dari model sesuai dengan range data tanggal yang diinputkan
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('DATE(tglskrining)', $tanggal_awal, $tanggal_akhir);
            $modelResult= LapskriningdarahV::model()->findAll($criteria);
            
            //mendapatkan list bluan diantara tanggal awal dan tanggal akhir yang diinputkan
            $tanggal_filter = [];
            $bulan_awal   = strtotime($tanggal_awal);
            $bulan_akhir   = date('Y-m', strtotime($tanggal_akhir));
            $totalbulan = 0;
            do {
                $hasil_bulan = date('Y-m', $bulan_awal);

                $tanggal_filter[] = $hasil_bulan;
                $totalbulan = $totalbulan+1;

                $bulan_awal = strtotime('+1 month', $bulan_awal);
            } while ($hasil_bulan != $bulan_akhir);

            //mencari data sesuai dengan data list bulan 
            if(!empty($modelResult)){
                $count = null;
                $i=0;
                $data = null;
                for($i ; $i<$totalbulan ;$i++) {
                    $hbsag= 0;$antihiv=0;$antihvc=0;$sifilis = 0 ;
                    $hbsagstatus[]= 0;$antihivstatus[]=0;$antihvcstatus[]=0;$sifilisstatus[] = 0 ;
                    $jumlah_sampel =0;
                    $jumlahSampel = 0;
                    $jumlahSkrining = 0;
                    $jumlahKantong = 0;
                    foreach($modelResult as $result){
                        if(date("Y-m",strtotime($result->tglskrining))== $tanggal_filter[$i]){
                            $jumlahSkrining++;
                            $jumlahSampel = $jumlahSampel + $jumlah_sampel;
                            if($result->hbsag == TRUE){
                                $hbsag++;  
                                $hbsagstatus[$jumlahSkrining] = 1;
                            }else{
                                $hbsagstatus[$jumlahSkrining] = 0;
                            }
                            if($result->antihiv == TRUE){
                                $antihiv++;  
                                $antihivstatus[$jumlahSkrining] = 1;
                            }else{
                                $antihivstatus[$jumlahSkrining] = 0;
                            }
                            if($result->antihvc == TRUE){
                                $antihvc++;  
                                $antihvcstatus[$jumlahSkrining] = 1;
                            }else{
                                $antihvcstatus[$jumlahSkrining] = 0;
                            }
                            if($result->sifilis == TRUE){
                                $sifilis++;  
                                $sifilisstatus[$jumlahSkrining] = 1;
                            }else{
                                $sifilisstatus[$jumlahSkrining] = 0;
                            }
                            if(($hbsagstatus[$jumlahSkrining]+$antihivstatus[$jumlahSkrining]+$antihvcstatus[$jumlahSkrining]+$sifilisstatus[$jumlahSkrining])>0){
                                $jumlahKantong++;
                            }
                            $data[$tanggal_filter[$i]]['filter'] = $tanggal_filter[$i];
                            $data[$tanggal_filter[$i]]['jumlah_sampel'] = $jumlahSkrining;
                            $data[$tanggal_filter[$i]]['hbsag'] = $hbsag;
                            $data[$tanggal_filter[$i]]['hiv']= $antihiv;
                            $data[$tanggal_filter[$i]]['hvc'] = $antihvc;
                            $data[$tanggal_filter[$i]]['sifilis'] = $sifilis;
                            $data[$tanggal_filter[$i]]['reaktif'] = $hbsag + $antihiv + $antihvc + $sifilis;
                            $data[$tanggal_filter[$i]]['kantong'] = $jumlahKantong;
                        }
                        $jumlah_sampel++;
                    }
                }
            }else{
                //jika tidak ada record sesuai dengan tgl yg di search maaka akan direturn null
                $data = null;
            }
            
            return $data;
    }
    
    /**
     * Fungsi untuk mencetak laporan
     * @param type $caraPrint
     */
    public function actionPrint($caraPrint){
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN SKRINING IMLTD';
        $tgl_awal = $_GET['LapskriningdarahV']['tgl_awal'];
        $tgl_akhir = $_GET['LapskriningdarahV']['tgl_akhir'];
        $modelData = $this->getData($tgl_awal,$tgl_akhir);
        
        $model = new LapskriningdarahV('searchGrafik');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Skrining IMLTD';
        $type = substr($_GET['r'],42);
        
        //$data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        $data['type'] = $type;
        
        if (isset($_GET['LapskriningdarahV'])) {
            $model->attributes = $_GET['LapskriningdarahV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LapskriningdarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LapskriningdarahV']['tgl_akhir']);
            $model->is_jenis = $_GET['LapskriningdarahV']['is_jenis'];
        }
        
        if ($caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render('_print', array('judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint,'model'=>$model,'data'=>$modelData,'data'=>$data));
        }else if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('_print', array('judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint,'model'=>$modelData));
        }  
        else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('_print', array('judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint,'model'=>$modelData));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            //$mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('_print', array('model'=>$modelData,'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    /**
     * Fungsi untuk load grafik
     */
    public function actionFrameGrafikSkrining() {
        $this->layout = '//layouts/iframe';

        $model = new LapskriningdarahV('searchGrafik');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        //Data Grafik
        $type = substr($_GET['id'],6);
        $data['title'] = 'Grafik Laporan Skrining IMLTD';
        //$data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        $data['type'] = $type;
        //$data['type'] = 'garis';
        if (isset($_GET['LapskriningdarahV'])) {
            $model->attributes = $_GET['LapskriningdarahV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LapskriningdarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LapskriningdarahV']['tgl_akhir']);
            $model->is_jenis = $_GET['LapskriningdarahV']['is_jenis'];
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
}