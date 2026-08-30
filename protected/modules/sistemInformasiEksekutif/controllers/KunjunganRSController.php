<?php

class KunjunganRSController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.kunjunganRS.';

    public function actionIndex() {
            $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() 
    {
        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $dataPie = array();
        $dataPieChart = array();
        $dataBarLineChart = array();

        $format = new MyFormatter();
        $model = new SEKunjunganrsR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if(isset($_REQUEST['jns_periode'])){
            $model->jns_periode = $_REQUEST['jns_periode'];
            $model->tgl_awal    = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
            $model->tgl_akhir   = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
            $model->bln_awal    = $format->formatMonthForDb($_REQUEST['bln_awal']);
            $model->bln_akhir   = $format->formatMonthForDb($_REQUEST['bln_akhir']);
            
            $bln_akhir          = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal    = $_REQUEST['thn_awal'];
            $model->thn_akhir   = $_REQUEST['thn_akhir'];
            $thn_akhir          = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal    = $model->tgl_awal;
            $model->tgl_akhir   = $model->tgl_akhir;
            
            $params = [
                'tgl_awal'      => $model->tgl_awal,
                'tgl_akhir'     => $model->tgl_akhir,
                'instalasi_id'  => $_REQUEST['instalasi_id'],
            ];
            
            $dataBar = $this->dataLine($params, 'bar');
            echo json_encode($dataBar);
            Yii::app()->end();

            die();
        }

        if (isset($_GET['SEKunjunganrsR'])) {
                $model->attributes = $_GET['SEKunjunganrsR'];
                $model->jns_periode = $_GET['SEKunjunganrsR']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEKunjunganrsR']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEKunjunganrsR']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_GET['SEKunjunganrsR']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_GET['SEKunjunganrsR']['bln_akhir']);
                $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
                $model->thn_awal = $_GET['SEKunjunganrsR']['thn_awal'];
                $model->thn_akhir = $_GET['SEKunjunganrsR']['thn_akhir'];
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
                $model->tgl_awal = $model->tgl_awal;
                $model->tgl_akhir = $model->tgl_akhir;
        }
        
        $params = [
            'tgl_awal'  => $model->tgl_awal,
            'tgl_akhir' => $model->tgl_akhir,
        ];

        $dataTile   = $this->dataTile($params);
        $dataLine   = $this->dataLine($params);
        $dataPie    = $this->dataPie($params);
        $dataBar    = $this->dataLine($params, 'bar');
        $dataTable  = $this->dataTable($model);
        
        $this->render('dashboard', array(
            'model'             => $model,
            'dataTile'          => $dataTile,
            'dataLine'          => $dataLine,
            'dataPie'           => $dataPie,
            'dataBar'           => $dataBar,
            'dataTable'         => $dataTable,
            //'format'            => $format
        ));
    }

    /**
     * digunakan untuk sumber data
     * @param type $params
     * @return type
     */
    protected function data($params)
    {
        $periode        = " and date(t.tanggal) between '".$params['tgl_awal']."' and '".$params['tgl_akhir']."' ";
        $instalasi_id   = '';
        
        if(!empty($params['periode'])){
            $periode = $params['periode'];
        }
        
        if(!empty($params['instalasi_id'])){
            $instalasi_id   = ' and instalasi_id = '.$params['instalasi_id'];
        }
        
        $data = Yii::app()->db->createCommand()
                ->select('t.*')
                ->from('kunjunganrs_r t')
                ->where('true '.$periode.$instalasi_id)
                ->queryAll();

        return $data;
    }

    /**
     * Digunakan untuk sumary data tile
     * @param type $params
     * @return int
     */
    protected function dataTile($params)
    {
        $data   = $this->data($params);            
        $jml_ri = 0;
        $jml_rj = 0;
        $jml_rd = 0;

        foreach ($data As $i => $ii){
            if($ii['kunjungan_ri'] > 0){
                $jml_ri++;
            }
            if($ii['kunjungan_rj'] > 0){
                $jml_rj++;
            }
            if($ii['kunjungan_rd'] > 0){
                $jml_rd++;
            }
        }

        $result = [
            'kunjungan_ri' => $jml_ri,
            'kunjungan_rj' => $jml_rj,
            'kunjungan_rd' => $jml_rd,
        ];

        return $result;
    }

    /**
     * Digunakan untuk grafik line
     * @param type $params
     * @param type $jenis
     * @return int
     */
    protected function dataLine($params, $jenis="")
    {
        $periode    = '';
        $labels     = '';
        $data       = '';
        $out        = [];
        $cek        = [];

        $selisih    = CustomFunction::hitungBulan($params['tgl_akhir'], $params['tgl_awal']);
        $bulan      = CustomFunction::getBulanNamaPendek();
        $name_tahun = false;
        $tahun_awal = substr($params['tgl_awal'], 0, 4 );
        $tahun_akhir= substr($params['tgl_akhir'], 0, 4 );

        if ($tahun_awal != $tahun_akhir){
            $name_tahun = true;
        }

        if($selisih > 0){
            /*
             * untuk pencarian periode lintas bulan
             */

            $params_2   = [
                'tgl_awal'      => $params['tgl_awal'],
                'tgl_akhir'     => $params['tgl_akhir'],
                'selisih'       => $selisih,
                'bulan'         => $bulan,
                'tahun_awal'    => $tahun_awal,
                'tahun_akhir'   => $tahun_akhir,
                'name_tahun'    => $name_tahun,
                'periode'       => $periode,
                'instalasi_id'  => isset($params['instalasi_id']) ? $params['instalasi_id'] : null,
            ];

            $out = $this->culikData($params_2, $jenis);
            
        }else{
            /*
             * untuk pencarian periode bulan yang sama
             */

            $bln        = substr($params['tgl_awal'], 5, 2 );
            $thn        = substr($params['tgl_awal'], 0, 4 );
            $bln_akhir  = substr($params['tgl_akhir'], 5, 2 );
            $thn_akhir  = substr($params['tgl_akhir'], 0, 4 );
            $periode    = " AND tanggal between '".$params['tgl_awal']."' AND '".$params['tgl_akhir']."' ";

            $params_1    = [
                'tgl_awal'      => $params['tgl_awal'],
                'tgl_akhir'     => $params['tgl_akhir'],
                'periode'       => $periode,
                'instalasi_id'  => isset($params['instalasi_id']) ? $params['instalasi_id'] : null,
            ];
            
            $labelnya   = [
                'kunjungan_ri' => 'Rawat Inap',
                'kunjungan_rj' => 'Rawat Jalan',
                'kunjungan_rd' => 'Rawat Darurat',
            ];

            $cari       = $this->dataTile($params_1);
            
            if(!empty($cari)){
                if($jenis == ""){
                    $out['bar']['labels'] = [$bulan[$bln].' '.$thn, $bulan[$bln_akhir].' '.$thn_akhir];
                }else{
                    $out['bar']['labels'] = [$bulan[$bln].' '.$thn];
                }
                $warna  = ['#f54b42', '#f59642', '#f5d442'];
                $j = 0;
                foreach ($cari As $a => $aa){                    
                    $out['bar']['datasets'][$j]['data'][] = $aa;
                    $out['bar']['datasets'][$j]['label'] = $labelnya[$a];                    
                    $out['bar']['datasets'][$j]['backgroundColor'] = $warna[$j];
                    $out['bar']['datasets'][$j]['borderColor'] = $warna[$j];
                    $out['bar']['datasets'][$j]['pointStyle'] = 'circle';
                    $out['bar']['datasets'][$j]['pointRadius'] = 5;
                    $out['bar']['datasets'][$j]['fill'] = false;

                    // di gunakan untuk pointer titik akhir
                    if($jenis == ""){
                        $out['bar']['datasets'][$j]['data'][1] = 0;
                    }
                    $j++;
                }
            }
        }

        return $out;
    }
    
    /**
     * Digunakan untuk sumber data lintas periode
     * @param type $params
     * @param type $jenis
     * @return boolean
     */
    protected function culikData($params, $jenis)
    {
        $selisih    = $params['selisih'];
        $bulan      = $params['bulan'];
        $name_tahun = $params['name_tahun'];
        $tahun_awal = $params['tahun_awal'];
        $tahun_akhir= $params['tahun_akhir'];
        $result     = [];        
        $labelnya   = [
            'kunjungan_ri' => 'Rawat Inap',
            'kunjungan_rj' => 'Rawat Jalan',
            'kunjungan_rd' => 'Rawat Darurat',
        ];
        
        // cari sebanyak jangka waktu terpilih
        for($i=0;$i<=$selisih;$i++){
            $load_bln   = date('m', strtotime($params['tgl_awal'].' +'.$i.' month'));
            $load_yr    = date('Y', strtotime($params['tgl_awal'].' +'.$i.' month'));
            $wulan      = date('Y-m-d', strtotime($params['tgl_awal'].' +'.$i.' month'));
            
            if (!$name_tahun){
                $load_yr = '';
            }

            $isi    = [];
            $label  = [];
            $bln        = substr($wulan, 5, 2 );
            $thn        = substr($wulan, 0, 4 );
            $periode    = " AND EXTRACT(MONTH FROM tanggal) = '".$bln."' AND EXTRACT(YEAR FROM tanggal) = '".$thn."' ";
            
            
            $params_3   = [
                'periode'       => $periode,
                'tgl_awal'      => $params['tgl_awal'],
                'tgl_akhir'     => $params['tgl_akhir'],
                'instalasi_id'  => isset($params['instalasi_id']) ? $params['instalasi_id'] : null,
            ];

            $hasil      = $this->dataTile($params_3);            
            $result['bar']['labels'][$i] = $bulan[$load_bln].' '.$load_yr;
            
            // hasil query di re-index => index periode dan index cara keluar
            $j = 0;
            $warna  = ['#f54b42', '#f59642', '#f5d442'];
            foreach ($hasil as $key => $val){                
                $result['bar']['datasets'][$j]['data'][] = $val;
                $result['bar']['datasets'][$j]['label'] = $labelnya[$key];
                $result['bar']['datasets'][$j]['backgroundColor']= $warna[$j];
                $result['bar']['datasets'][$j]['borderColor'] = $warna[$j];
                $result['bar']['datasets'][$j]['pointStyle'] = 'circle';
                $result['bar']['datasets'][$j]['pointRadius'] = 5;
                $result['bar']['datasets'][$j]['fill'] = false;

                $j++;
            }
        }
        
        return $result;
    }
    
    /**
     * digunakan untuk grafik Pie
     * @param type $params
     * @return string
     */
    protected function dataPie($params)
    {
        $result = $this->dataTile($params);
        $out    = [];
        $labelnya   = [
            'kunjungan_ri' => 'Rawat Inap',
            'kunjungan_rj' => 'Rawat Jalan',
            'kunjungan_rd' => 'Rawat Darurat',
        ];
        if(!empty($result)){
            $warna  = ['#f54b42', '#f59642', '#f5d442'];
            $j      = 0;
            foreach ($result As $i => $ii){
                $out['bar']['datasets'][0]['data'][$j] = $ii;
                $out['bar']['datasets'][0]['backgroundColor'][$j] = $warna[$j];
                $out['bar']['datasets'][0]['label'] = 'all instalasi';
                $out['bar']['labels'][] = $labelnya[$i];
                
                $j++;
            }
        }
        
        return $out;
    }
    
    /**
     * Untuk dropDown instalasi
     */
    public function actionSetDropdownInstalasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi  = null;
            $data       = null;
            if($_POST['jenis'] == '1'){ // rawat inap
                $data = Yii::app()->db->createCommand("select instalasi_id, instalasi_nama from ruanganrawatinap_v group by instalasi_id, instalasi_nama order by instalasi_nama")->queryAll();
                $instalasi = CHtml::listData($data, 'instalasi_id', 'instalasi_nama');
            }else if($_POST['jenis'] == '2'){ // rawat jalan
                $data = Yii::app()->db->createCommand("select instalasi_id, instalasi_nama from ruanganrawatjalan_v group by instalasi_id, instalasi_nama order by instalasi_nama")->queryAll();
                $instalasi = CHtml::listData($data, 'instalasi_id', 'instalasi_nama');
            }else if($_POST['jenis'] == '3'){ // rawat darurat
                $data = Yii::app()->db->createCommand("select instalasi_id, instalasi_nama from ruanganrawatdarurat_v group by instalasi_id, instalasi_nama order by instalasi_nama")->queryAll();
                $instalasi = CHtml::listData($data, 'instalasi_id', 'instalasi_nama');                
            }
            
            if($_POST['jenis'] != ''){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
                foreach($instalasi as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }else{
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk data table
     * @param type $model
     * @return \CActiveDataProvider
     */
    protected function dataTable($model)
    {
        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(kunjungan_ri) as jumlah_ri, sum(kunjungan_rd) as jumlah_rd, sum(kunjungan_rj) as jumlah_rj');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(kunjungan_ri) as jumlah_ri, sum(kunjungan_rd) as jumlah_rd, sum(kunjungan_rj) as jumlah_rj');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(kunjungan_ri) as jumlah_ri, sum(kunjungan_rd) as jumlah_rd, sum(kunjungan_rj) as jumlah_rj');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
        }
        
        $dataTable = new CActiveDataProvider($model, array(
            'criteria' => $criteria
        ));
        
        return $dataTable;
    }


    /**
     * digubakan untuk cetak export
     */
    public function actionPrint()
    {
        $model = new SEKunjunganrsR();        
        $format     = new MyFormatter();
        $caraPrint  = $_REQUEST['caraPrint'];
        $target     = 'Print';
        $judulLaporan   = 'Laporan Kunjungan Rumah Sakit';
        $data['title']  = 'Laporan Kunjungan Rumah Sakit';
        
        if(isset($_REQUEST['SEKunjunganrsR'])){
            $model->attributes  = $_REQUEST['SEKunjunganrsR'];
            $model->jns_periode = $_REQUEST['SEKunjunganrsR']['jns_periode'];
            $model->tgl_awal    = $format->formatDateTimeForDb($_REQUEST['SEKunjunganrsR']['tgl_awal']);
            $model->tgl_akhir   = $format->formatDateTimeForDb($_REQUEST['SEKunjunganrsR']['tgl_akhir']);
            $model->bln_awal    = $format->formatMonthForDb($_REQUEST['SEKunjunganrsR']['bln_awal']);
            $model->bln_akhir   = $format->formatMonthForDb($_REQUEST['SEKunjunganrsR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal    = $_REQUEST['SEKunjunganrsR']['thn_awal'];
            $model->thn_akhir   = $_REQUEST['SEKunjunganrsR']['thn_akhir'];
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
            $model->tgl_awal    = $model->tgl_awal;
            $model->tgl_akhir   = $model->tgl_akhir;
            $model->instalasi_id= isset($_REQUEST['SEKunjunganrsR']['instalasi_id']) ? $_REQUEST['SEKunjunganrsR']['instalasi_id'] : null;
        }
        
        $dataTable      = $this->dataTable($model);        
        $this->layout   = '//layouts/printExcel';
        
        $this->render($target, array('model'=>$model, 'dataTable' => $dataTable, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
}

?>