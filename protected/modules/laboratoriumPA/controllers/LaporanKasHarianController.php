<?php

class LaporanKasHarianController extends MyAuthController {
    
    public function actionLaporanKasHarian() {
        $model = new LBClosingkasirT('search');
        $this->pageTitle = Yii::app()->name.' - '.'Laporan Laboratorium';
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['LBClosingkasirT'])) {
            $model->attributes = $_GET['LBClosingkasirT'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBClosingkasirT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBClosingkasirT']['tgl_akhir']);
        }

        $this->render('rekapKas/index', array(
                        'model' => $model,
        ));
    }

    public function actionPrintLaporanKasHarian() {
//        print_r(12);
        $format = new MyFormatter();
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing';
        $criteria->addBetweenCondition('t.tglclosingkasir',$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']),$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']));
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';
        
        $criteria3 = new CDbCriteria;

        $criteria3->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria3->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria3->addBetweenCondition('t.tglclosingkasir',$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']),$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']));
        $criteria3->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';
        
        $model      = LBClosingkasirT::model()->findAll($criteria);
        $modDetail  = LBClosingkasirT::model()->findAll($criteria3);
        
//        echo print_r($modDetail);
        $criteria2=new CDbCriteria;

//        $criteria2->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing, rincianclosing_t.nourutrincian,rincianclosing_t.nilaiuang,rincianclosing_t.banyakuang,rincianclosing_t.jumlahuang';
		if(!empty($model->closingkasir_id)){
			$criteria2->addCondition('closingkasir_id = '.$model->closingkasir_id);
		}
//        $criteria2->addBetweenCondition('t.tglclosingkasir',$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']),$format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']));
//        $criteria2->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
//                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';
        $model      = LBClosingkasirT::model()->findAll($criteria);
        $modDetail  = LBClosingkasirT::model()->findAll($criteria3);
        $modRincian = new RincianclosingT;
        
        $data = array();
        //Data Grafik
        $data['title'] = 'Grafik Laporan Kas Harian';
        $data['type'] = $_REQUEST['type'];
//        if (isset($_REQUEST['LBClosingkasirT'])) {
//            $model->attributes = $_REQUEST['LBClosingkasirT'];
//            $format = new MyFormatter();
//            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']);
//        }
//        echo " test";
        
            if(isset($_REQUEST['LBClosingkasirT'])){
                if($_REQUEST['filter_tab'] == 'rekap')
                {
                    $judulLaporan = 'REKAPITULASI LAPORAN PENDAPATAN HARIAN';
                    $data['filter'] = "rekap";
                    
                }
                else if($_GET['filter_tab'] == 'detail')
                {
                    $judulLaporan = 'LAPORAN DETAIL PEMBAYARAN';
                    $data['filter'] = "detail";
                    
                }
                $model->attributes = $_REQUEST['LBClosingkasirT'];
                $format = new MyFormatter();
                if(!empty($_REQUEST['LBClosingkasirT']['tgl_awal']))
                {
                    $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']);
                }
                if(!empty($_REQUEST['LBClosingkasirT']['tgl_awal']))
                {
                    $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']);
                }
            }
        
//        $data['caraPrint'] = $_REQUEST['caraPrint'];
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'rekapKas/_print';
        
        $this->printFunction($model,$modDetail, $data, $caraPrint, $judulLaporan, $target,$modRincian,$rincianUang);
    }

    public function actionFrameGrafikKasHarian() {
        $this->layout = '//layouts/iframe';
        $model = new LBClosingkasirT('search');
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d H:i:s');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['LBClosingkasirT'])) {
            $model->attributes = $_GET['LBClosingkasirT'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBClosingkasirT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBClosingkasirT']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    protected function printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
//        echo $caraPrint;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint , 'modRincian'=>$modRincian));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian), true));
            $mpdf->Output();
        }
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
        
    }
    
 public function getTabularFormTabs($form, $model)
{
    $tabs = array();
    $count = 0;
    foreach (array('en'=>'English', 'fi'=>'Finnish', 'sv'=>'Swedish') as $locale => $language)
    {
        $tabs[] = array(
            'active'=>$count++ === 0,
            'label'=>$language,
            'content'=>$this->renderPartial('rekapTransaksiBedah/_table', array('form'=>$form, 'model'=>$model, 'locale'=>$locale, 'language'=>$language), true),
        );
    }
    return $tabs;
}
}