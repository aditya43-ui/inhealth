<?php

/**
 * Digunakan untuk mengakses laporan insiden
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class LaporaninsidenVController extends MyAuthController {

    /**
     * Digunakan untuk mengakses menu laporan insiden
     */
    public function actionIndex() {
        $model = new YKMLaporaninsidenV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->pilihan = 'a';

        if (isset($_GET['YKMLaporaninsidenV'])) {
            $model->attributes = $_GET['YKMLaporaninsidenV'];
            $model->jns_periode = $_GET['YKMLaporaninsidenV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['YKMLaporaninsidenV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['YKMLaporaninsidenV']['bln_akhir']);
            $model->thn_awal = $_GET['YKMLaporaninsidenV']['thn_awal'];
            $model->thn_akhir = $_GET['YKMLaporaninsidenV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
            $model->instalasi_id = isset($_GET['YKMLaporaninsidenV']['instalasi_id']) ? $_GET['YKMLaporaninsidenV']['instalasi_id'] : null;
            $model->lokasikejadian_id = isset($_GET['YKMLaporaninsidenV']['ruangan_id']) ? $_GET['YKMLaporaninsidenV']['ruangan_id'] : null;
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Fungsi cetak laporan insiden
     */
    public function actionPrintLaporanInsiden() {
        $model = new YKMLaporaninsidenV('search');
        $judulLaporan = 'Laporan Insiden';

        //Data Grafik
        if(!empty($_GET['YKMLaporaninsidenV']['pilihan'])){
            if($_GET['YKMLaporaninsidenV']['pilihan'] == 'a'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Grading Risiko';
            }else if($_GET['YKMLaporaninsidenV']['pilihan'] == 'b'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Tingkat Risiko';
            }else if($_GET['YKMLaporaninsidenV']['pilihan'] == 'c'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Waktu Pelaporan Insiden';
            }
        }
        $data['type'] = $_GET['type'];
        if (isset($_GET['YKMLaporaninsidenV'])) {
            $model->attributes = $_REQUEST['YKMLaporaninsidenV'];
            $format = new MyFormatter();
            $model->pilihan = $_GET['YKMLaporaninsidenV']['pilihan'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_akhir']);
            $model->lokasikejadian_id = isset($_GET['YKMLaporaninsidenV']['ruangan_id']) ? $_GET['YKMLaporaninsidenV']['ruangan_id'] : null;
        }

        $caraPrint = $_GET['caraPrint'];
        $target = '_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * Fungsi menampilkan grafik pada laporan insiden
     */
    public function actionFrameGrafikInsiden() {
        $this->layout = '//layouts/iframe';
        $model = new YKMLaporaninsidenV('search');
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d H:i:s');

        //Data Grafik
        if(!empty($_GET['YKMLaporaninsidenV']['pilihan'])){
            if($_GET['YKMLaporaninsidenV']['pilihan'] == 'a'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Grading Risiko';
            }else if($_GET['YKMLaporaninsidenV']['pilihan'] == 'b'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Tingkat Risiko';
            }else if($_GET['YKMLaporaninsidenV']['pilihan'] == 'c'){
                $data['title'] = 'Grafik Laporan Insiden Berdasarkan Waktu Pelaporan Insiden';
            }
        }

        $data['type'] = $_REQUEST['type'];
        if (isset($_GET['YKMLaporaninsidenV'])) {
            $model->attributes = $_GET['YKMLaporaninsidenV'];
            $format = new MyFormatter();
            $model->pilihan = $_GET['YKMLaporaninsidenV']['pilihan'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['YKMLaporaninsidenV']['tgl_akhir']);
            $model->lokasikejadian_id = isset($_GET['YKMLaporaninsidenV']['ruangan_id']) ? $_GET['YKMLaporaninsidenV']['ruangan_id'] : null;
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    /**
     * Fungsi print 
     * @param type $model
     * @param type $data
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array()) {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }
    
    /**
     * Digunakan untuk generate data yang akan digunakan pada chart berdasarkan pencarian
     */
    public function actionSetDataGrafik() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = array();
            $ruangan_idnya = array();
            $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : " ";
            $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : " ";
            $pilihan = isset($_POST['pilihan']) ? $_POST['pilihan'] : "a";            
            $ruangan_idnya = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : " ";
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : " ";
        
            $tr = '';
            $criteria = new CDbCriteria();
            
            if (isset($pilihan)){
                if ($pilihan == 'a') {
                    $criteria->select=" sum((case when regradingrisiko = 'Kuning' then 1 else 0 end)) as grade_kuning,
                                        sum((case when regradingrisiko = 'Hijau' then 1 else 0 end)) as grade_hijau,
                                        sum((case when regradingrisiko = 'Biru' then 1 else 0 end)) as grade_biru,
                                        sum((case when regradingrisiko = 'Merah' then 1 else 0 end)) as grade_merah"; 
                }else if($pilihan == 'b') {
                    $criteria->select=" sum((case when tingkatrisiko_id = 1 then 1 else 0 end)) as grade_low,
                                        sum((case when tingkatrisiko_id = 2 then 1 else 0 end)) as grade_moderate,
                                        sum((case when tingkatrisiko_id = 3 then 1 else 0 end)) as grade_high,
                                        sum((case when tingkatrisiko_id = 5 then 1 else 0 end)) as grade_extrem"; 
                }else if($pilihan == 'c') {
                    $criteria->select=" sum((case when DATE_PART('hour', waktu_pelaporan - waktu_insiden) <= 48 then 1 else 0 end)) as grade_hijau,
                                        sum((case when DATE_PART('hour', waktu_pelaporan - waktu_insiden) > 48 then 1 else 0 end)) as grade_merah";
                }
            }
            if (!isset($pilihan)){
                $criteria->select=" sum((case when regradingrisiko = 'Kuning' then 1 else 0 end)) as grade_kuning,
                                    sum((case when regradingrisiko = 'Hijau' then 1 else 0 end)) as grade_hijau,
                                    sum((case when regradingrisiko = 'Biru' then 1 else 0 end)) as grade_biru,
                                    sum((case when regradingrisiko = 'Merah' then 1 else 0 end)) as grade_merah"; 
            }
            
            $criteria->addBetweenCondition('DATE(tanggal_insiden)', $tgl_awal, $tgl_akhir);
            $criteria->addCondition("regradingrisiko IS NOT NULL");
            $criteria->join = "left join ruangan_m on t.lokasikejadian_id = ruangan_m.ruangan_id ";
            
            if (is_array($ruangan_idnya)) {
                $criteria->addInCondition('ruangan_m.ruangan_id', $ruangan_idnya);
            }

            if (is_array($instalasi_id)) {
                $criteria->addInCondition('ruangan_m.instalasi_id', $instalasi_id);
            }
            
            $modLaporan = YKMLaporaninsidenV::model()->findAll($criteria);
            if (isset($modLaporan)) {
                $i = 0;
                foreach ($modLaporan as $data) {
                    $data->grade_kuning = !empty($data->grade_kuning) ? $data->grade_kuning : 0;
                    $data->grade_hijau = !empty($data->grade_hijau) ? $data->grade_hijau : 0;
                    $data->grade_biru = !empty($data->grade_biru) ? $data->grade_biru : 0;
                    $data->grade_merah = !empty($data->grade_merah) ? $data->grade_merah : 0;
                    
                    $data->grade_low = !empty($data->grade_low) ? $data->grade_low : 0;
                    $data->grade_moderate = !empty($data->grade_moderate) ? $data->grade_moderate : 0;
                    $data->grade_high = !empty($data->grade_high) ? $data->grade_high : 0;
                    $data->grade_extrem = !empty($data->grade_extrem) ? $data->grade_extrem : 0;
                    
                    $data->grade_hijau = !empty($data->grade_hijau) ? $data->grade_hijau : 0;
                    $data->grade_merah = !empty($data->grade_merah) ? $data->grade_merah : 0;
                    if($pilihan == "a"){
                        $data->pilihan = 'Grading Risiko';
                    }else if($pilihan == "b"){
                        $data->pilihan = 'Tingkat Risiko';
                    }else if($pilihan == "c"){
                        $data->pilihan = 'Waktu Pelaporan';
                    }
                    
                    $tr .= $this->renderPartial('_rowTableTAT', array('data' => $data, 'pilihan' => $pilihan, 'i' => $i++), true);
                }
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
}
