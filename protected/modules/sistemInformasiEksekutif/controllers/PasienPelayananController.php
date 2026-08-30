<?php
/**
 * Digunanakn pada menu pasien pulang
 * 
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage controllers
 */
class PasienPelayananController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.pasienPelayanan.';

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() {

        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $dataPie = array();
        $dataPieChart = array();
        $dataBarLineChart = array();

        $format = new MyFormatter();
        $model  = new SEPelayananpasienR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal    = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir   = date('Y-m-d');
        $model->bln_awal    = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir   = date('Y-m');
        $model->thn_awal    = date('Y');
        $model->thn_akhir   = date('Y');
        
        if (isset($_GET['SEPelayananpasienR'])) {
            $model->attributes  = $_GET['SEPelayananpasienR'];
            $model->jns_periode = $_GET['SEPelayananpasienR']['jns_periode'];
            $model->tgl_awal    = $format->formatDateTimeForDb($_GET['SEPelayananpasienR']['tgl_awal']);
            $model->tgl_akhir   = $format->formatDateTimeForDb($_GET['SEPelayananpasienR']['tgl_akhir']);
            $model->bln_awal    = $format->formatMonthForDb($_GET['SEPelayananpasienR']['bln_awal']);
            $model->bln_akhir   = $format->formatMonthForDb($_GET['SEPelayananpasienR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal    = $_GET['SEPelayananpasienR']['thn_awal'];
            $model->thn_akhir   = $_GET['SEPelayananpasienR']['thn_akhir'];
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
            $model->instalasi_id= isset($_GET['SEPelayananpasienR']['instalasi_id']) ? $_GET['SEPelayananpasienR']['instalasi_id'] : null;
        }
        
        $instalasi = '';
        if(!empty($model->instalasi_id)){
            $instalasi = ' AND instalasi_id = '.$model->instalasi_id;
        }
        
        //=== chart ===
        /* tidak digunakan
        $sql = "
		SELECT 
		kelompoktindakan_id as id, kelompoktindakan_nama as nama
		FROM kelompoktindakan_m
		ORDER BY id ASC
		";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPelayanan = $result;
         * 
         */
        
        $params = [
            'jns_periode'   => $model->jns_periode,
            'tgl_awal'      => $model->tgl_awal,
            'tgl_akhir'     => $model->tgl_akhir,
            'instalasi'     => $instalasi,
        ];
        
        //$dataBarLineChart   = $this->dataBarLineChart($params);
        $dataPieChart       = $this->dataPieChart($params);
        $dataBarLineChart   = [];
        $dataTile           = $this->dataTile($params);
        $lineChart          = $this->lineData($params);
        $dataTable          = $this->lineData($params, 'dataTable');
        //$dataTable          = $this->dataTable($params);
        
        /*
        $out = [];
        if(!empty($lineChart['bar']['datasets'])){
            foreach ($lineChart['bar']['datasets'] As $j => $jj){
                $cek = [];
                $cek['jenis'] = $jj['label'];
                $cek['jumlah'] = array_sum($jj['data']);

                $out[] = $cek;
            }
        }
         */
        
//        echo '<pre>';
//        print_r($dataTable);echo '<br>';
//        print_r($dataPieChart);
//        die();

        $this->render('dashboard', array(
            'model'             => $model,
            'dataPieChart'      => $dataPieChart,
            'dataTable'         => $dataTable,
            'lineChart'         => $lineChart,
            'dataTile'          => $dataTile,
            'dataBarLineChart'  => $dataBarLineChart,
        ));
    }
    
    protected function dataBarLineChart($items)
    {
        switch ($items['jns_periode']) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";
                
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";
                
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";        
        }
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = $result;

        $dataBarLineChart = array();
        foreach ($dataChart as $data) {
            $id = $data['id'];
            if (isset($dataBarLineChart[$id])) {
                $dataBarLineChart[$id][] = $data;
            } else {
                $dataBarLineChart[$id] = array($data);
            }
        }
        
        return $dataBarLineChart;
    }
    
    protected function dataPieChart($items)
    {
        $sql = "
		SELECT 
		kelompoktindakan_nama as jenis, kelompoktindakan_id, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "' ".$items['instalasi']."
		GROUP BY jenis, kelompoktindakan_id
		ORDER BY jumlah DESC
		LIMIT 10";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $out    = [];
        
        if(!empty($result)){
            $warna = ['#f54b42', '#f59642', '#f5d442', '#aaf542', '#42f5b6', '#42bcf5', '#426cf5', '#7d73f0', '#dd73f0', '#f07390'];
            foreach ($result As $i => $ii){
                $out['bar']['datasets'][0]['data'][$i] = $ii['jumlah'];
                $out['bar']['datasets'][0]['backgroundColor'][] = $warna[$i];
                $out['bar']['datasets'][0]['label'] = 'all instalasi';
                $out['bar']['labels'][] = $ii['jenis'];
            }
        }
        
        return $out;        
    }
    
    protected function dataTile($items)
    {
        $sql = "
		SELECT 
		kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "'
		GROUP BY jenis
		ORDER BY jumlah DESC
		LIMIT 10";

        $result = Yii::app()->db->createCommand($sql)->queryAll();        
        
        return $result;
    }
    
    protected function dataTable($items)
    {
        switch ($items['jns_periode']) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "' ".$items['instalasi']."
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";
                break;
            
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "' ".$items['instalasi']."
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";
                break;
            
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, kelompoktindakan_id as id, kelompoktindakan_nama as jenis, sum(jumlah) as jumlah
		FROM pelayananpasien_r
		WHERE tanggal BETWEEN '" . $items['tgl_awal'] . "' AND '" . $items['tgl_akhir'] . "' ".$items['instalasi']."
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC";
        }
        
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = $result;

        $dataTable = array();
        foreach ($dataChart as $data) {
            $id = $data['periode'];
            if (isset($dataBarLineChart[$id])) {
                $dataTable[$id][]   = $data;
            } else {
                $dataTable[$id]     = array($data);
            }
        }
        
        return $dataTable;
    }

    /**
     * digunakan untuntuk menyususn data grafik garis chartJS
     * @param type $params
     * @return boolean
     * @depends culikData()
     */
    protected function lineData($params="", $jenis="")
    {
        $conn       = Yii::app()->db;
        $periode    = '';
        $unit       = '';
        $labels     = '';
        $data       = '';

        $selisih    = CustomFunction::hitungBulan($params['tgl_akhir'], $params['tgl_awal']);
        $bulan      = CustomFunction::getBulanNamaPendek();
        $name_tahun = false;
        $tahun_awal = substr($params['tgl_awal'], 0, 4 );
        $tahun_akhir= substr($params['tgl_akhir'], 0, 4 );
        
        if ($tahun_awal != $tahun_akhir){
            $name_tahun = true;
        }
        
        if($params['instalasi'] != '' && $jenis == 'dataTable'){
            /*
             * Unit terpilih dengan jangka waktu terpilih
             */
            $instalasi_id = $params['instalasi'];
        }else{
            /*
             * semua Unit dengan jangka waktu terpilih
             */
            $instalasi_id = '';
        }
        //return $instalasi_id; die();
        
        $out = [];
        
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
                'instalasi_id'  => $instalasi_id,
            ];
            
            $out        = $this->culikData($params_2);
        }else{
            /*
             * untuk pencarian periode bulan yang sama
             */            
            $bln        = substr($params['tgl_awal'], 5, 2 );
            $thn        = substr($params['tgl_awal'], 0, 4 );
            $periode    = " AND tanggal between '".$params['tgl_awal']."' AND '".$params['tgl_akhir']."' ";
            
            $params_1    = [
                'tgl_awal'      => $params['tgl_awal'],
                'tgl_akhir'     => $params['tgl_akhir'],
                'periode'       => $periode,
                'instalasi_id'  => $instalasi_id,
            ];
            $cari       = $this->cari($params_1);
            if(!empty($cari)){
                $out['bar']['labels'][] = $bulan[$bln].' '.$thn;
                foreach ($cari As $a => $aa){
                    $out['bar']['datasets'][$a]['data'][] = $aa['total'];
                    $out['bar']['datasets'][$a]['label'] = $aa['kelompoktindakan_nama'];
                    $out['bar']['datasets'][$a]['backgroundColor']= '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$a]['borderColor'] = '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$a]['pointStyle'] = 'circle';
                    $out['bar']['datasets'][$a]['pointRadius'] = 5;
                    $out['bar']['datasets'][$a]['fill'] = false;
                }
            }
        }
        
        return $out;
    }
    /**
     * Sumber data pelayananpasien_r
     * @param type $params
     * @return type
     */
    protected function cari($params)
    {
        $data = Yii::app()->db->createCommand()
                ->select('kelompoktindakan_id'
                        . ', kelompoktindakan_nama'
                        . ', count(pelayananpasien_id) as banyak'
                        . ', coalesce(sum(jumlah), 0) as total')
                ->from('pelayananpasien_r')
                ->where('true '.$params['periode'].$params['instalasi_id'])
                ->group('kelompoktindakan_nama, kelompoktindakan_id')
                ->order('total DESC')
                ->limit(10)
                ->queryAll();
        
        return $data;
    }
    
    /**
     * Proses mengolah data garafik lintas bulan
     * @param type $params
     * @return boolean
     */
    protected function culikData($params)
    {
        $selisih    = $params['selisih'];
        $bulan      = $params['bulan'];
        $name_tahun = $params['name_tahun'];
        $tahun_awal = $params['tahun_awal'];
        $tahun_akhir= $params['tahun_akhir'];
        $out        = [];
        $conn       = Yii::app()->db;
        
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
                'instalasi_id'  => $params['instalasi_id'],
            ];
            $data   =  $this->cari($params_3);
            
            if(!empty($data)){
                $out['bar']['labels'][] = $bulan[$bln].' '.$thn;
                foreach ($data As $b => $bb){
                    $out['bar']['datasets'][$b]['data'][] = $bb['total'];
                    $out['bar']['datasets'][$b]['label'] = $bb['kelompoktindakan_nama'];
                    $out['bar']['datasets'][$b]['backgroundColor']= '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$b]['borderColor'] = '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$b]['pointStyle'] = 'circle';
                    $out['bar']['datasets'][$b]['pointRadius'] = 5;
                    $out['bar']['datasets'][$b]['fill'] = false;
                }
            }
            
        }

        return $out;
    }
    
    /**
     * digubakan untuk cetak export
     */
    public function actionPrint()
    {
        $model      = new SEPelayananpasienR;
        $format     = new MyFormatter();
        $caraPrint  = $_REQUEST['SEPelayananpasienR'];
        $target     = 'Print';
        $judulLaporan   = 'Data Table Pelayanan';
        $data['title']  = 'Data Table Pelayanan';
        
        if(isset($_REQUEST['SEPelayananpasienR'])){
            $model->attributes  = $_REQUEST['SEPelayananpasienR'];
            $model->jns_periode = $_REQUEST['SEPelayananpasienR']['jns_periode'];
            $model->tgl_awal    = $format->formatDateTimeForDb($_REQUEST['SEPelayananpasienR']['tgl_awal']);
            $model->tgl_akhir   = $format->formatDateTimeForDb($_REQUEST['SEPelayananpasienR']['tgl_akhir']);
            $model->bln_awal    = $format->formatMonthForDb($_REQUEST['SEPelayananpasienR']['bln_awal']);
            $model->bln_akhir   = $format->formatMonthForDb($_REQUEST['SEPelayananpasienR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal    = $_REQUEST['SEPelayananpasienR']['thn_awal'];
            $model->thn_akhir   = $_REQUEST['SEPelayananpasienR']['thn_akhir'];
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
            $model->instalasi_id= isset($_REQUEST['SEPelayananpasienR']['instalasi_id']) ? $_REQUEST['SEPelayananpasienR']['instalasi_id'] : null;
        }
        
        $instalasi = '';
        if(!empty($model->instalasi_id)){
            $instalasi = ' AND instalasi_id = '.$model->instalasi_id;
        }
        $params = [
            'jns_periode'   => $model->jns_periode,
            'tgl_awal'      => $model->tgl_awal,
            'tgl_akhir'     => $model->tgl_akhir,
            'instalasi'     => $instalasi,
        ];
        $dataTable          = $this->lineData($params, 'dataTable');
        
        $this->layout = '//layouts/printExcel';
        $this->render($target, array('model'=>$model, 'dataTable' => $dataTable, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
}

?>