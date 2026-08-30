<?php
/**
 * Digunanakn pada menu pasien pulang
 * 
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage controllers
 */
class PasienPulangController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.pasienPulang.';

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
        $model = new SEPasienpulangR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEPasienpulangR'])) {
            $model->attributes = $_GET['SEPasienpulangR'];
            $model->jns_periode = $_GET['SEPasienpulangR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPasienpulangR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPasienpulangR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPasienpulangR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPasienpulangR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPasienpulangR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPasienpulangR']['thn_akhir'];
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
            $model->instalasi_id = !empty($_GET['SEPasienpulangR']['instalasi_id']) ? $_GET['SEPasienpulangR']['instalasi_id'] : null;
        }
        //=== chart ===
        /* garfik bar tidak digunakan
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = $result;

        for ($i = 0; $i < count($dataChart); $i++) {
            $dataBarLineChart[$i]['id'] = $dataChart[$i]['id'];
            $dataBarLineChart[$i]['periode'] = $dataChart[$i]['periode'];
            $dataBarLineChart[$i]['jenis'] = $dataChart[$i]['jenis'];
            $dataBarLineChart[$i]['jumlah' . $dataChart[$i]['id']] = $dataChart[$i]['jumlah'];
        }

        // sort by id for graph making
        usort($dataBarLineChart, function($a, $b) {
            return $a['id'] - $b['id'];
        });

        $graphs = array();

        for ($i = 0; $i < count($dataBarLineChart); $i++) {
            if ($i == count($dataBarLineChart) - 1) {
                $graph['id'] = "graph" . $i;
                $graph['type'] = "column";
                $graph['title'] = $dataBarLineChart[$i]['jenis'];
                $graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
                $graph['balloonText'] = "[[title]]:[[value]]";
                $graph['lineAlpha'] = 0;
                $graph['fillAlphas'] = 1;
                array_push($graphs, $graph);
            } else {
                if ($dataBarLineChart[$i]['id'] !== $dataBarLineChart[$i + 1]['id']) {
					$graph['id'] = "graph" . $i;
					$graph['type'] = "column";
					$graph['title'] = $dataBarLineChart[$i]['jenis'];
					$graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
					$graph['balloonText'] = "[[title]]:[[value]]";
					$graph['lineAlpha'] = 0;
					$graph['fillAlphas'] = 1;
                    array_push($graphs, $graph);
                }
            }
        }

        // sort by date for graph category

        function date_compare($a, $b) {
            $t1 = strtotime($a['periode']);
            $t2 = strtotime($b['periode']);
            return $t1 - $t2;
        }

        usort($dataBarLineChart, 'date_compare');
        $sql = "
				SELECT 
				carakeluar_nama as jenis, sum(jumlah) as jumlah
				FROM pasienpulang_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				GROUP BY jenis
				";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;
         */
        
        /*
        foreach ($dataPie as $key => $value) {
                if ($key == "jumlah_ri") {
                        $key = "Rawat Inap";
                } elseif ($key == "jumlah_rd") {
                        $key = "Rawat Darurat";
                } else {
                        $key = "Rawat Jalan";
                }
                $temp['jenis'] = $key;
                $temp['jumlah'] = $value;

                array_push($dataPieChart, $temp);
        }
         */
        //=== end chart ===

        //=== start table ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, carakeluar_id as id, carakeluar_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpulang_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $dataTable = array();

        foreach ($result as $data) {
            $id = $data['periode'];
            if (isset($dataTable[$id])) {
                $dataTable[$id][] = $data;
            } else {
                $dataTable[$id] = array($data);
            }
        }
        //=== end table ===
        
        $params = [
            'tgl_awal'  => $model->tgl_awal,
            'tgl_akhir' => $model->tgl_akhir,
            'instalasi' => $model->instalasi_id,
        ];
        $graphs     = [];
        $dataTile   = $this->cari($params);
        $dataBar    = $this->bar($params);
        $dataPie    = $this->dataPie($params);
        $map        = CHtml::listData($dataTile, 'jenis', 'jumlah');
        $dataTable  = $this->bar($params, 'dataTable');
        
//        echo '<pre>';
//        print_r($dataTable);
//        die();
        
        $this->render('dashboard', array(
            'model'             => $model,
            'dataBarLineChart'  => $dataBarLineChart,
            'dataPieChart'      => $dataPie,
            'dataTable'         => $dataTable,
            'graphs'            => $graphs,
            'dataTile'          => $dataTile,
            'map'               => $map,
            'dataBar'           => $dataBar,
        ));
    }
    
    /**
     * digunakan untuk mencari data pasienpulang_r
     * @param type $params
     * @return Array data
     */
    protected function cari($params="")
    {
        $periode    = " and date(tanggal) between '".$params['tgl_awal']."' and '".$params['tgl_akhir']."'";
        if(!empty($params['periode'])){
            $periode = $params['periode'];
        }
        
        $instalasi  = !empty($params['instalasi'])?" and instalasi_id = ".$params['instalasi'] : '';
        $data       = Yii::app()->db->createCommand()
            ->select('count(pasienpulang_id) as jumlah'
                    . ', carakeluar_nama as jenis'
                    . ', carakeluar_id')
            ->from('pasienpulang_r')
            ->where('true '.$periode.$instalasi)
            ->group('carakeluar_nama, carakeluar_id')
            ->order('carakeluar_id')
            ->queryAll();
        
        return $data;
    }
    
    /**
     * digunakan untuk initialisasi data grafik
     * 
     * @depends culikData($params)
     * @param type $params
     * @param type $jenis
     * @return int
     */
    protected function bar($params="", $jenis="")
    {
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
        
        if($params['instalasi'] != ''){
            /*
             * Unit terpilih dengan jangka waktu terpilih
             */
            $instalasi_id = $params['instalasi'];
            if($jenis == 'dataTable'){
                $instalasi_id = $params['instalasi'];
            }
        }else{
            /*
             * semua Unit dengan jangka waktu terpilih
             */
            $instalasi_id = '';
        }
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
            
            $out = $this->culikData($params_2);
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
                'instalasi_id'  => $instalasi_id,
            ];
            
            $cari       = $this->cari($params_1);
            if(!empty($cari)){
                $out['bar']['labels'] = [$bulan[$bln].' '.$thn, $bulan[$bln_akhir].' '.$thn_akhir];
                if($jenis == 'dataTable'){
                    $out['bar']['labels'] = [$bulan[$bln].' '.$thn];
                }
                foreach ($cari As $a => $aa){
                    $out['bar']['datasets'][$a]['data'][] = $aa['jumlah'];
                    $out['bar']['datasets'][$a]['label'] = $aa['jenis'];                    
                    $out['bar']['datasets'][$a]['backgroundColor']= '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$a]['borderColor'] = '#'.substr(md5(rand()), 0, 6);
                    $out['bar']['datasets'][$a]['pointStyle'] = 'circle';
                    $out['bar']['datasets'][$a]['pointRadius'] = 5;
                    $out['bar']['datasets'][$a]['fill'] = false;
                    
                    // di gunakan untuk pointer titik akhir
                    if($jenis != 'dataTable'){
                        $out['bar']['datasets'][$a]['data'][1] = 0;
                    }
                }
                
            }
        }
        
        return $out;
    }
    
    /**
     * Proses mengolah data grafik lintas bulan
     * @depends cari($params)
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
        $result     = [];
        
        $labelnya   = $this->bikinLabel();
        
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
                'instalasi'     => $params['instalasi_id'],
            ];
            
            $hasil  = $this->cari($params_3);
            //$cek[]  = $this->cari($params_3);
            
            $result['bar']['labels'][$i] = $bulan[$load_bln].' '.$load_yr;
            
            // hasil query di re-index => index periode dan index cara keluar
            foreach ($hasil as $key => $val){
                $data[$i][$val['jenis']]['carakeluar_nama'] = $val['carakeluar_id'];
                $data[$i][$val['jenis']]['jumlah'] = $val['jumlah'];
                $data[$i][$val['jenis']]['jenis'] = $val['jenis'];
            }            
            
            foreach ($labelnya As $j => $jj){
                $warna = '#'.substr(md5(rand()), 0, 6);
                $result['bar']['datasets'][$j]['label'] = $jj['carakeluar_nama'];
                
                //cek hasil query dengan index bulan dan cara keluar = ada ?
                if(isset($data[$i][$jj['carakeluar_nama']])){
                    $result['bar']['datasets'][$j]['data'][$i] = $data[$i][$jj['carakeluar_nama']]['jumlah'];
                }else{
                    $result['bar']['datasets'][$j]['data'][$i] = 0;
                }
                
                $result['bar']['datasets'][$j]['backgroundColor'] = $warna;
                $result['bar']['datasets'][$j]['borderColor'] = $warna;
                $result['bar']['datasets'][$j]['pointStyle'] = 'circle';
                $result['bar']['datasets'][$j]['fill'] = false;
                
            }
        }
        
        return $result;
    }
    
    /**
     * digunakan untuk initialisasi labels
     * @return type
     */
    protected function bikinLabel()
    {
        $data       = Yii::app()->db->createCommand()
            ->select('carakeluar_nama, carakeluar_id')
            ->from('pasienpulang_r')
            ->group('carakeluar_nama, carakeluar_id')
            ->order('carakeluar_id')
            ->queryAll();
        
        return $data;
    }
    
    protected function dataPie($params)
    {
        $result = $this->cari($params);
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
    
    /**
     * digubakan untuk cetak export
     */
    public function actionPrint()
    {
        $model      = new SEPasienpulangR;
        $format     = new MyFormatter();
        $caraPrint  = $_REQUEST['SEPasienpulangR'];
        $target     = 'Print';
        $judulLaporan   = 'Data Table Pelayanan';
        $data['title']  = 'Data Table Pelayanan';
        
        if(isset($_REQUEST['SEPasienpulangR'])){
            $model->attributes  = $_REQUEST['SEPasienpulangR'];
            $model->jns_periode = $_REQUEST['SEPasienpulangR']['jns_periode'];
            $model->tgl_awal    = $format->formatDateTimeForDb($_REQUEST['SEPasienpulangR']['tgl_awal']);
            $model->tgl_akhir   = $format->formatDateTimeForDb($_REQUEST['SEPasienpulangR']['tgl_akhir']);
            $model->bln_awal    = $format->formatMonthForDb($_REQUEST['SEPasienpulangR']['bln_awal']);
            $model->bln_akhir   = $format->formatMonthForDb($_REQUEST['SEPasienpulangR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal    = $_REQUEST['SEPasienpulangR']['thn_awal'];
            $model->thn_akhir   = $_REQUEST['SEPasienpulangR']['thn_akhir'];
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
            $model->instalasi_id= isset($_REQUEST['SEPasienpulangR']['instalasi_id']) ? $_REQUEST['SEPasienpulangR']['instalasi_id'] : null;
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
        $dataTable          = $this->bar($params, 'dataTable');
        
        $this->layout = '//layouts/printExcel';
        $this->render($target, array('model'=>$model, 'dataTable' => $dataTable, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
}

?>