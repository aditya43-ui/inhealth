<?php

class MutasiPegawaiController extends MyAuthController {

	public $path_view = 'sistemInformasiEksekutif.views.mutasiPegawai.';

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
	public function actionSetIFrameDashboard() {

		$this->layout = '//layouts/iframe';
		//=== start 4 kolom ===
		$dataPie = array();
		$dataPieChart = array();
		$dataBarLineChart = array();

		$format = new MyFormatter();
		$model = new SEPegawaimutasiR();
		$model->unsetAttributes();
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
                $unit = CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'namaunitkerja', 'namaunitkerja');
                
                $params = [
                    'tgl_awal' => $model->tgl_awal,
                    'tgl_akhir' => $model->tgl_akhir,
                    'unit_id' => 'null',
                ];
                $count = $this->count($params);
                
                if (isset($_GET['SEPegawaimutasiR'])){
                    $model->attributes = $_GET['SEPegawaimutasiR'];
                    $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPegawaimutasiR']['tgl_awal']);
                    $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPegawaimutasiR']['tgl_akhir']);
                    
                }

                
		$this->render('dashboard', array(
			'model' => $model,
			'format' => $format,
                    
                        'unit'      => $unit,
                        'count'     => $count,
		));
	}
        
        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @issue Improvement RSST-8576
         */
        public function actionGetData()
        {
            if(Yii::app()->request->isAjaxRequest){
                $format = new MyFormatter();
                
                $params = $_POST;
                $params['tgl_awal'] = $format->formatDateTimeForDb($_POST['tgl_awal']);
                $params['tgl_akhir'] = $format->formatDateTimeForDb($_POST['tgl_akhir']);
                $count  = $this->count($params);                
                $bar    = $this->bar($params);
                
                
                $result = [
                    'count' => $count,
                    'bar'   => $bar['bar'],
                ];
                echo json_encode($result);
            }
        }

        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @category Improvement RSST-8576
         * @depends culikData()
         * @param type $params
         * @return type object
         */
        protected function count($params)
        {
            $conn = Yii::app()->db;
            $periode = '';
            if(!empty($params['tgl_awal']) && !empty($params['tgl_akhir']) ){
                $periode = " AND tglsk BETWEEN '".$params['tgl_awal']."' AND '".$params['tgl_akhir']."' ";
            }
            //$isi    = !isset($params['unit_id']) ? implode(', ', $params['unit_id']) : '';
            $isi    = !isset($params['unit_id']) ? "'" . implode("', '", $isi) . "'" : '';
            $unit   = !empty($isi) ? ' AND unitkerja_id IN('.$isi.')' : '';
                    
            $tile_perempuan = $conn->createCommand()
                ->select('COUNT(pegmutasi_id) AS total')
                ->from('pegmutasi_r r')
                ->leftJoin('pegawai_m p', 'p.pegawai_id = r.pegawai_id')
                ->where("jeniskelamin = 'PEREMPUAN' ".$periode.$unit)
                ->limit(1)
                ->queryRow();
            
            $tile_laki = $conn->createCommand()
                ->select('COUNT(pegmutasi_id) AS total')
                ->from('pegmutasi_r r')
                ->leftJoin('pegawai_m p', 'p.pegawai_id = r.pegawai_id')
                ->where("jeniskelamin = 'LAKI-LAKI' ".$periode.$unit)
                ->limit(1)
                ->queryRow();
            
            $tile_pns = $conn->createCommand()
                ->select('COUNT(pegmutasi_id) AS total')
                ->from('pegmutasi_r r')
                ->leftJoin('pegawai_m p', 'p.pegawai_id = r.pegawai_id')
                ->where("jeniskelamin = 'PNS' ".$periode.$unit)
                ->limit(1)
                ->queryRow();
            
            $tile_blud = $conn->createCommand()
                ->select('COUNT(pegmutasi_id) AS total')
                ->from('pegmutasi_r r')
                ->leftJoin('pegawai_m p', 'p.pegawai_id = r.pegawai_id')
                ->where("jeniskelamin = 'BLUD' ".$periode.$unit)
                ->limit(1)
                ->queryRow();
            
            $result = [
                'tile_perempuan'=> $tile_perempuan['total'],
                'tile_laki'     => $tile_laki['total'],
                'tile_pns'      => $tile_pns['total'],
                'tile_blud'     => $tile_blud['total'],
            ];
            
            return $result;
        }
        
        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @issue Improvement RSST-8576
         * @depends culikData()
         * @param type $params
         * @return type object
         */
        protected function bar($params)
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
            $out = [];
            $warna      = ['#F4543C', '#00A65A', '#0073B7', '#6C541E', '#FFC929'];
            $paramex    = [
                'tgl_awal'      => $params['tgl_awal'],
                'tgl_akhir'     => $params['tgl_akhir'],
                'unit_id'       => $params['unit_id'],
                'selisih'       => $selisih,
                'bulan'         => $bulan,
                'tahun_awal'    => $tahun_awal,
                'tahun_akhir'   => $tahun_akhir,
                'name_tahun'    => $name_tahun,
                'panel'         => $params['panel'],
                'unit_kerja'    => $params['unit_kerja'],
            ];
            if($selisih > 0){
                /*
                 * untuk unit terpilih perbulannya
                 */
                $out = $this->culikData($paramex);
            }else{
                /*
                 * semua Unit di bulan yg sama
                 */
                
                $bln        = substr($params['tgl_awal'], 5, 2 );
                $thn        = substr($params['tgl_awal'], 0, 4 );
                $periode    = " AND EXTRACT(MONTH FROM tglsk) = '".$bln."' AND EXTRACT(YEAR FROM tglsk) = '".$thn."' ";
                
                if($params['unit_id'] != 'null'){
                    /*
                     * Unit terpilih di bulan yg sama
                     */
                    $out = $this->culikData($paramex);
                }else{
                    /*
                     * semua unit di bulan yg sama
                     */
                    $data = $conn->createCommand()
                    ->select("COALESCE(count(pegmutasi_id), 0) AS total")
                    ->from('pegmutasi_r r')
                    ->where("TRUE ".$periode)
                    ->limit(1)
                    ->queryRow();
                    if($params['panel'] == 'cari_batang'){
                        $out = [
                            'bar' => [
                                'labels'    => [$bulan[$bln]],
                                'datasets'  => [
                                    [
                                        'data' => [$data['total']],
                                        'label' => ['All Unit'],
                                        'backgroundColor' => $warna[0],
                                    ]
                                ],
                            ]
                        ];
                    }else if($params['panel'] == 'cari_garis'){
                        $out = [
                            'bar' => [
                                'labels'    => [$bulan[$bln]],
                                'datasets'  => [
                                    [
                                        'data' => [$data['total']],
                                        'label' => ['All Unit'],
                                        'fill' => false,
                                        'backgroundColor' => $warna[0],
                                        'borderColor' => $warna[0],
                                    ]
                                ],
                            ]
                        ];
                    }else{
                        $out = [
                            'bar' => [
                                'labels'    => [$bulan[$bln]],
                                'datasets'  => [
                                    [
                                        'data' => [$data['total']],
                                        'label' => ['All Unit'],
                                        'backgroundColor' => $warna[0],
                                    ]
                                ],
                            ]
                        ];
                    } 
                }
            }
            
            return $out;
        }
        
        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @issue Improvement RSST-8576
         * @param type $params
         * @return type object
         */
        protected function cariData($params)
        {
            $bln        = substr($params['tgl_awal'], 5, 2 );
            $thn        = substr($params['tgl_awal'], 0, 4 );
            $unit       = !empty($params['unit_id']) ? " AND unitkerja = '".$params['unit_id']."'":'';
            
            $conn       = Yii::app()->db;
            $data = $conn->createCommand()
                ->select("count(pegmutasi_id) AS total, unitkerja")
                ->from('pegmutasi_r')
                ->where("EXTRACT(MONTH FROM tglsk) = '".$bln."' AND EXTRACT(YEAR FROM tglsk) = '".$thn."' ".$unit)
                ->group('unitkerja')
                ->queryRow();
            
            return $data;
        }
        
        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @issue Improvement RSST-8576
         * @param type $params
         * @return string object
         */
        protected function culikData($params)
        {
            $selisih    = $params['selisih'];
            $bulan      = $params['bulan'];
            $name_tahun = $params['name_tahun'];
            $tahun_awal = $params['tahun_awal'];
            $tahun_akhir= $params['tahun_akhir'];
            $out        = [];
            $warna      = ['#F4543C', '#00A65A', '#0073B7', '#6C541E', '#FFC929'];
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

                if($params['unit_id'] != 'null'){
                    /*
                     * Unit terpilih dengan jangka waktu terpilih
                     */
                    $out['bar']['labels'][] = $bulan[$load_bln].' '.$load_yr;
                    foreach ($params['unit_id'] as $key => $val){
                        $paramo = [
                            'tgl_awal'  => $wulan,
                            'unit_id'   => $val,
                        ];
                        
                        if($params['panel'] != 'cari_pie'){
                            $data =  $this->cariData($paramo);
                            $out['bar']['datasets'][$key]['data'][] = !empty($data['total']) ? $data['total'] : 0;
                            $out['bar']['datasets'][$key]['label'] = $val;
                            
                            if($params['panel'] == 'cari_batang'){                            
                                $out['bar']['datasets'][$key]['backgroundColor'] = $warna[$key];
                            }else if($params['panel'] == 'cari_garis'){
                                $out['bar']['datasets'][$key]['backgroundColor']= $warna[$key];
                                $out['bar']['datasets'][$key]['borderColor'] = $warna[$key];
                                $out['bar']['datasets'][$key]['pointStyle'] = 'circle';
                                $out['bar']['datasets'][$key]['pointRadius'] = 5;
                                $out['bar']['datasets'][$key]['fill'] = false;
                            }
                        }
                    }
                    
                    if($params['panel'] == 'cari_pie'){
                        $paramnya = [
                            'tgl_awal'  => $wulan,
                            'unit_id'   => !empty($params['unit_kerja']) ? $params['unit_kerja'] : '',
                        ];
                        
                        $datanya =  $this->cariData($paramnya);
                        $out['bar']['datasets'][0]['data'][$i]    = empty($datanya['total']) ? 0 : $datanya['total'];
                        $out['bar']['datasets'][0]['backgroundColor'][$i] = '#'.substr(md5(rand()), 0, 6);
                    }
                }else{
                    /*
                     * semua Unit dengan jangka waktu terpilih
                     */
                    $bln        = substr($wulan, 5, 2 );
                    $thn        = substr($wulan, 0, 4 );
                    $periode    = " AND EXTRACT(MONTH FROM tglsk) = '".$bln."'";

                    

                    $out['bar']['labels'][] = $bulan[$load_bln].' '.$load_yr;
                    
                    if($params['panel'] == 'cari_pie'){
                        $paramnya = [
                            'tgl_awal'  => $wulan,
                            'unit_id'   => !empty($params['unit_kerja']) ? $params['unit_kerja'] : '',
                        ];
                        
                        $datanya =  $this->cariData($paramnya);
                        $out['bar']['datasets'][0]['data'][$i]    = empty($datanya['total']) ? 0 : $datanya['total'];
                        $out['bar']['datasets'][0]['backgroundColor'][$i] = '#'.substr(md5(rand()), 0, 6);
                    }else{
                        $data = $conn->createCommand()
                        ->select("COALESCE(count(pegmutasi_id), 0) AS total")
                        ->from('pegmutasi_r r')
                        ->where("EXTRACT(MONTH FROM tglsk) = '".$bln."'")
                        ->limit(1)
                        ->queryRow();
                        
                        $out['bar']['datasets'][0]['data'][]    = $data['total'];                    
                        $out['bar']['datasets'][0]['label']  = 'All Unit';
                        if($params['panel'] == 'cari_batang'){
                            $out['bar']['datasets'][0]['backgroundColor'] = $warna[0];
                        }else{
                            $out['bar']['datasets'][0]['backgroundColor'] = $warna[0];
                            $out['bar']['datasets'][0]['borderColor'] = $warna[0];
                            $out['bar']['datasets'][0]['pointStyle'] = 'circle';
                            $out['bar']['datasets'][0]['pointRadius'] = 5;
                            $out['bar']['datasets'][0]['fill'] = false;
                        }
                    }
                }

            }            
            return $out;
        }
        
        /**
         * @author Wahyu Wicaksono <wahyuwicaksono@.com>
         * @test test run
         * @param type $params
         * @return type object
         */
        public function actionCari()
        {
            $params = [
                'tgl_awal'  => "2019-03-01",
                'tgl_akhir'  => "2019-03-04",
                'unit_id'   => 'null'//['Graha Amerta (Gedung Rawat Inap Utama)', "PPJT (PUSAT PELAYANAN JANTUNG TERPADU)", "GEDUNG BEDAH PUSAT TERPADU (GBPT)", "BAGIAN KEPEGAWAIAN"],
            ];
            
            //$data =  $this->cariData($params);
            $data =  $this->bar($params);
            $bln        = substr($params['tgl_awal'], 5, 2 );
            $thn        = substr($params['tgl_awal'], 0, 4 );
            echo '<pre>';
            print_r($data);
            die();
        }
        
        public function actionData()
        {
            $model  = new SEPegawaimutasiR();
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']);
            $model->unitkerja_id = $_POST['unit_id'];
            
            $data = $model->getData();
        }
}

?>