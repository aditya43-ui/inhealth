<?php

class MasterPegawaiController extends MyAuthController {

    public function actionIndex() {
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $model = new SEPegawaiberdasarkanpdkR();
        $modelUmur = new SEPegawaiberdasarkanumurR();
        $modelKlp = new SEPegawaiberdasarkanklpR();
        $modelJk = new SEPegawaiberdasarkanjkR();



        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEPegawaiberdasarkanpdkR'])) {
            $model->attributes = $_GET['SEPegawaiberdasarkanpdkR'];
            $model->jns_periode = $_GET['SEPegawaiberdasarkanpdkR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPegawaiberdasarkanpdkR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPegawaiberdasarkanpdkR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPegawaiberdasarkanpdkR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPegawaiberdasarkanpdkR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPegawaiberdasarkanpdkR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPegawaiberdasarkanpdkR']['thn_akhir'];
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

        // TABULASI KELOMPOK PEGAWAI
        //=== chart ===

        $sql = "
		SELECT 
		kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis
		ORDER BY id
				";


        $resultPieChartKlp = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartKlp = $resultPieChartKlp;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
        }
        $resultStackChartKlp = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($resultStackChartKlp as $data) {
            $id = $data['periode'];
            if (isset($StackChartKlp[$id])) {
                unset($data['periode']);
                $StackChartKlp[$id][] = $data;
            } else {
                unset($data['periode']);
                $StackChartKlp[$id] = array($data);
            }
        }

        if (count($resultStackChartKlp) > 0) {

            $dataStackChartKlp = array();
            foreach ($StackChartKlp as $key => $value) {
                $tempStackChartKlp['periode'] = $key;
                foreach ($value as $data) {
                    $tempStackChartKlp['jumlah' . $data['id']] = $data['jumlah'];
                }
                array_push($dataStackChartKlp, $tempStackChartKlp);
            }


            // generate_graph
            $graphStackKlp = array();
            $graphsStackKlp = array();
            foreach ($resultStackChartKlp as $data) {
                $id = $data['id'];
                if (isset($dataChart[$id])) {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackKlp[$id][] = $data;
                } else {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackKlp[$id] = array($data);
                }
            }

            // make graphs
            foreach ($graphStackKlp as $key => $data) {
                $tempGraphStackKlp['id'] = "graph" . $data[0]['id'];
                $tempGraphStackKlp['type'] = "column";
                $tempGraphStackKlp['title'] = $data[0]['jenis'];
                $tempGraphStackKlp['valueField'] = "jumlah" . $data[0]['id'];
                $tempGraphStackKlp['balloonText'] = "[[title]]:[[value]]";
                $tempGraphStackKlp['lineAlpha'] = 0.5;
                $tempGraphStackKlp['fillAlphas'] = 0.5;
                array_push($graphsStackKlp, $tempGraphStackKlp);
            }
        } else {
            $dataStackChartKlp = array();
            $graphsStackKlp = array();
        }


        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
        }
        $resultLineChartKlp = Yii::app()->db->createCommand($sql)->queryAll();
        $ChartLineKlp = $resultLineChartKlp;

        for ($i = 0; $i < count($ChartLineKlp); $i++) {
            $dataLineChartKlp[$i]['id'] = $ChartLineKlp[$i]['id'];
            $dataLineChartKlp[$i]['periode'] = $ChartLineKlp[$i]['periode'];
            $dataLineChartKlp[$i]['jenis'] = $ChartLineKlp[$i]['jenis'];
            $dataLineChartKlp[$i]['jumlah' . $ChartLineKlp[$i]['id']] = $ChartLineKlp[$i]['jumlah'];
        }

        if(count($ChartLineKlp)>0) {

            // sort by id for graph making
            usort($dataLineChartKlp, function($a, $b) {
                return $a['id'] - $b['id'];
            });

            $graphsLineKlp = array();
            for ($i = 0; $i < count($dataLineChartKlp); $i++) {
                if ($i == count($dataLineChartKlp) - 1) {
                    $graphLineKlp['id'] = "graph" . $i;
                    $graphLineKlp['type'] = "column";
                    $graphLineKlp['title'] = $dataLineChartKlp[$i]['jenis'];
                    $graphLineKlp['valueField'] = "jumlah" . $dataLineChartKlp[$i]['id'];
                    $graphLineKlp['balloonText'] = "[[title]]:[[value]]";
                    $graphLineKlp['lineAlpha'] = 0.5;
                    $graphLineKlp['fillAlphas'] = 1;
                    array_push($graphsLineKlp, $graphLineKlp);
                } else {
                    if ($dataLineChartKlp[$i]['id'] !== $dataLineChartKlp[$i + 1]['id']) {
                        $graphLineKlp['id'] = "graph" . $i;
                        $graphLineKlp['type'] = "column";
                        $graphLineKlp['title'] = $dataLineChartKlp[$i]['jenis'];
                        $graphLineKlp['valueField'] = "jumlah" . $dataLineChartKlp[$i]['id'];
                        $graphLineKlp['balloonText'] = "[[title]]:[[value]]";
                        $graphLineKlp['lineAlpha'] = 0.5;
                        $graphLineKlp['fillAlphas'] = 1;
                        array_push($graphsLineKlp, $graphLineKlp);
                    }
                }
            }

            // sort by date for graph category

            function date_compare($a, $b) {
                $t1 = strtotime($a['periode']);
                $t2 = strtotime($b['periode']);
                return $t1 - $t2;
            }

            usort($dataLineChartKlp, 'date_compare');
        } else {
            $dataLineChartKlp = array();
            $graphsLineKlp = array();
        }

        //=== start table ===
        $sql = "
		SELECT 
		kelompokpegawai_id as id, kelompokpegawai_nama as nama
		FROM kelompokpegawai_m
		";


        $resultKlpM = Yii::app()->db->createCommand($sql)->queryAll();
        $dataKelompokM = $resultKlpM;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, kelompokpegawai_id as id, kelompokpegawai_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanklp_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
        }


        $resultTabelKlp = Yii::app()->db->createCommand($sql)->queryAll();
        $dataTableKlp = array();
        foreach ($resultTabelKlp as $data) {
            $id = $data['periode'];
            if (isset($dataTableKlp[$id])) {
                $dataTableKlp[$id][] = $data;
            } else {
                $dataTableKlp[$id] = array($data);
            }
        }

        //=== end table ===
        // TABULASI PENDIDIKAN
        //=== chart ===

        $sql = "
		SELECT 
		pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis
		ORDER BY id
				";


        $resultPieChartPdk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartPdk = $resultPieChartPdk;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
        }
        $resultStackChartPdk = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($resultStackChartPdk as $data) {
            $id = $data['periode'];
            if (isset($dataChartPdk[$id])) {
                unset($data['periode']);
                $dataChartPdk[$id][] = $data;
            } else {
                unset($data['periode']);
                $dataChartPdk[$id] = array($data);
            }
        }


        if (count($resultStackChartPdk) > 0) {
            $dataStackChartPdk = array();
            foreach ($dataChartPdk as $key => $value) {
                $tempStackChartPdk['periode'] = $key;
                foreach ($value as $data) {
                    $tempStackChartPdk['jumlah' . $data['id']] = $data['jumlah'];
                }
                array_push($dataStackChartPdk, $tempStackChartPdk);
            }

            // generate_graph
            $graphStackPdk = array();
            $graphsStackPdk = array();
            foreach ($resultStackChartPdk as $data) {
                $id = $data['id'];
                if (isset($dataChart[$id])) {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackPdk[$id][] = $data;
                } else {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackPdk[$id] = array($data);
                }
            }

            // make graphs
            foreach ($graphStackPdk as $key => $data) {
                $tempGraphStackPdk['id'] = "graph" . $data[0]['id'];
                $tempGraphStackPdk['type'] = "column";
                $tempGraphStackPdk['title'] = $data[0]['jenis'];
                $tempGraphStackPdk['valueField'] = "jumlah" . $data[0]['id'];
                $tempGraphStackPdk['balloonText'] = "[[title]]:[[value]]";
                $tempGraphStackPdk['lineAlpha'] = 0.5;
                $tempGraphStackPdk['fillAlphas'] = 0.5;
                array_push($graphsStackPdk, $tempGraphStackPdk);
            }
        } else {
            $dataStackChartPdk = array();
            $graphsStackPdk = array();
        }



        switch ($model->jns_periode) {
		 case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
        }
        $resultLineChartPdk = Yii::app()->db->createCommand($sql)->queryAll();
        $chartLinePdk = $resultLineChartPdk;

        for ($i = 0; $i < count($chartLinePdk); $i++) {
            $dataLineChartPdk[$i]['id'] = $chartLinePdk[$i]['id'];
            $dataLineChartPdk[$i]['periode'] = $chartLinePdk[$i]['periode'];
            $dataLineChartPdk[$i]['jenis'] = $chartLinePdk[$i]['jenis'];
            $dataLineChartPdk[$i]['jumlah' . $chartLinePdk[$i]['id']] = $chartLinePdk[$i]['jumlah'];
        }

        if (count($chartLinePdk) > 0) {

            // sort by id for graph making
            usort($dataLineChartPdk, function($a, $b) {
                return $a['id'] - $b['id'];
            });

            $graphsLinePdk = array();

            for ($i = 0; $i < count($dataLineChartPdk); $i++) {
                if ($i == count($dataLineChartPdk) - 1) {
                    $graphLinePdk['id'] = "graph" . $i;
                    $graphLinePdk['type'] = "column";
                    $graphLinePdk['title'] = $dataLineChartPdk[$i]['jenis'];
                    $graphLinePdk['valueField'] = "jumlah" . $dataLineChartPdk[$i]['id'];
                    $graphLinePdk['balloonText'] = "[[title]]:[[value]]";
                    $graphLinePdk['lineAlpha'] = 0.5;
                    $graphLinePdk['fillAlphas'] = 1;
                    array_push($graphsLinePdk, $graphLinePdk);
                } else {
                    if ($dataLineChartPdk[$i]['id'] !== $dataLineChartPdk[$i + 1]['id']) {
                        $graphLinePdk['id'] = "graph" . $i;
                        $graphLinePdk['type'] = "column";
                        $graphLinePdk['title'] = $dataLineChartPdk[$i]['jenis'];
                        $graphLinePdk['valueField'] = "jumlah" . $dataLineChartPdk[$i]['id'];
                        $graphLinePdk['balloonText'] = "[[title]]:[[value]]";
                        $graphLinePdk['lineAlpha'] = 0.5;
                        $graphLinePdk['fillAlphas'] = 1;
                        array_push($graphsLinePdk, $graphLinePdk);
                    }
                }
            }

            // sort by date for graph category
			
           // usort($dataLineChartPdk, 'date_compare');
        } else {
            $dataLineChartPdk = array();
            $graphsLinePdk = array();
        }

        //=== start table ===
        $sql = "
		SELECT 
		pendidikan_id as id, pendidikan_nama as nama
		FROM pendidikan_m
		ORDER BY pendidikan_urutan ASC
		";


        $resultPendM = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPendidikanM = $resultPendM;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pegawaiberdasarkanpdk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
        }
        $resultTablePdk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataTablePdk = array();
        foreach ($resultTablePdk as $data) {
            $id = $data['periode'];
            if (isset($dataTablePdk[$id])) {
                $dataTablePdk[$id][] = $data;
            } else {
                $dataTablePdk[$id] = array($data);
            }
        }
        //=== end table ===
        // TABULASI UMUR
        //=== chart ===

      /*  $sql = "
		SELECT 
		umur as jenis, SUM(COALESCE(lakilaki,0)) as jumlah_lk, SUM(COALESCE(perempuan,0)) as jumlah_pr, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as jumlah
		FROM pegawaiberdasarkanumur_r
		GROUP BY jenis
		ORDER BY jenis DESC
				";*/
		
		$sql = " SELECT 
					det.jenis, 
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' THEN det.jumlah_peg ELSE 0 END)as jumlah_lk,
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN det.jumlah_peg ELSE 0 END)as jumlah_p,
					sum(det.jumlah_peg) as total_seluruh
				FROM (
					select date(create_time) as tglbuat,date_part('year',age( '2018-07-26',  pegawai_m.tgl_lahirpegawai)) as jenis, jeniskelamin, count(pegawai_id) as jumlah_peg from pegawai_m
					group by jenis, jeniskelamin, date(create_time)
					) as det
				WHERE date(det.tglbuat) BETWEEN '".$model->tgl_awal."' AND '".$model->tgl_akhir."'
				GROUP BY det.jenis";

		
        $resultPieChartUmur = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartUmur = $resultPieChartUmur;
//		$sql1 = "
//			SELECT SUM(COALESCE(lakilaki,0)) as jumlah_lk, SUM(COALESCE(perempuan,0)) as jumlah_pr
//			FROM (
//				SELECT m.umur as jenis, m.lakilaki, m.perempuan, SUM(COALESCE(m.lakilaki,0)) + SUM(COALESCE(m.perempuan,0)) as jumlah
//				FROM pegawaiberdasarkanumur_r m
//				GROUP BY jenis, m.lakilaki, m.perempuan
//			) t
//				";
//
//        $resultPieUmurDet = Yii::app()->db->createCommand($sql1)->queryRow();
//        $dataPieUmurDet = $resultPieUmurDet;
		
        $dataPieChartUmurDet = array();
		//var_dump($dataPieChartUmur);die;
        foreach ($dataPieChartUmur as $key => $value) {				
				//if ($key == "jumlah_lk") {
				//	$key = Params::JENIS_KELAMIN_LAKI_LAKI;
					$tempPieChartumur['jenis'] = $value['jenis'];
					$tempPieChartumur['jumlah'] = $value['total_seluruh'];
				//} else {
				//	$key = Params::JENIS_KELAMIN_PEREMPUAN;
				//	$tempPieChartumur['jenis'] = $value;
				//	$tempPieChartumur['jumlah'] = $value;
				//}
				

				array_push($dataPieChartUmurDet, $tempPieChartumur);
			
//            if ($key == "jumlah_lk") {
//                $key = "Laki - laki";
//            } else {
//                $key = "Perempuan";
//            }
//            $tempPieChartUmurDet['jenis'] = $key;
//            $tempPieChartUmurDet['jumlah'] = $value;
//			$tempPieChartUmurDet['pulled'] = true;
//
//            array_push($dataPieChartUmurDet, $tempPieChartUmurDet);
        }


        //=== start table ===
        //$criteria = new CDbCriteria;

        //$criteria->select = array('umur as jenis, sum(coalesce(lakilaki,0)) as jumlah_l, sum(coalesce(perempuan,0)) as jumlah_p');
        //$criteria->group = 'jenis';
        //$criteria->order = 'jenis DESC';
		$sql = " SELECT 
					det.jenis, 
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' THEN det.jumlah_peg ELSE 0 END)as jumlah_lk,
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN det.jumlah_peg ELSE 0 END)as jumlah_p,
					sum(det.jumlah_peg) as total_seluruh
				FROM (
					select date(create_time) as tglbuat,date_part('year',age( '2018-07-26',  pegawai_m.tgl_lahirpegawai)) as jenis, jeniskelamin, count(pegawai_id) as jumlah_peg from pegawai_m
					group by jenis, jeniskelamin, date(create_time)
					) as det
				WHERE date(det.tglbuat) BETWEEN '".$model->tgl_awal."' AND '".$model->tgl_akhir."'
				GROUP BY det.jenis";

		
        //$modelUmur = Yii::app()->db->createCommand($sql)->queryScalar();
		
        //$dataTableUmur = new CActiveDataProvider($modelUmur, array(
          //  'criteria' => $criteria
        //));
		$count = Yii::app()->db->createCommand(" select count(*) from ($sql) as bb ")->queryScalar();
		$dataTableUmur = new CSqlDataProvider($sql, array(
				  'totalItemCount'=>$count,
				  'keyField' => 'jenis',
				  'pagination'=>array(
						'pageSize'=>10,
					),

				));

       /* $sql = "
		SELECT 
		umur as jenis, SUM(COALESCE(lakilaki,0)) * -1 as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pegawaiberdasarkanumur_r
		GROUP BY jenis
		ORDER BY jenis DESC
				";*/
		$sql = " SELECT 
					det.jenis, 
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' THEN det.jumlah_peg ELSE 0 END)as jumlah_lk,
					sum(CASE WHEN det.jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN det.jumlah_peg ELSE 0 END)as jumlah_p,
					sum(det.jumlah_peg) as total_seluruh
				FROM (
					select date(create_time) as tglbuat,date_part('year',age( '2018-07-26',  pegawai_m.tgl_lahirpegawai)) as jenis, jeniskelamin, count(pegawai_id) as jumlah_peg from pegawai_m
					group by jenis, jeniskelamin, date(create_time)
					) as det
				WHERE date(det.tglbuat) BETWEEN '".$model->tgl_awal."' AND '".$model->tgl_akhir."'
				GROUP BY det.jenis";


        $resultBarChartUmur = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChartUmur = $resultBarChartUmur;

        // TABULASI JENIS KELAMIN
        //=== chart ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
										SELECT 
										date_trunc('month', tanggal) as periode, sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan
										FROM pegawaiberdasarkanjk_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
										SELECT 
										date_trunc('year', tanggal) as periode, sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan
										FROM pegawaiberdasarkanjk_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
                break;
            default : $sql = "
										SELECT 
										date_trunc('day', tanggal) as periode, sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan
										FROM pegawaiberdasarkanjk_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
        }

        $resultBarLineJk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChartJk = $resultBarLineJk;

        $sql = "
				SELECT 
				sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan
										FROM pegawaiberdasarkanjk_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				";


        $resultPieJk = Yii::app()->db->createCommand($sql)->queryRow();
        $dataPieJk = $resultPieJk;
        $dataPieChartJk = array();
        foreach ($dataPieJk as $key => $value) {
			//var_dump($key);
            if ($key == "jumlah_lakilaki") {
                $key = "Laki - laki";
            } else {
                $key = "Perempuan";
            }
            $tempPieChartJk['jenis'] = $key;
            $tempPieChartJk['jumlah'] = $value;

            array_push($dataPieChartJk, $tempPieChartJk);
        }
		//die;
        //=== end chart ===
        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode,  sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode,  sum(lakilaki) as jumlah_lakilaki, sum(perempuan) as jumlah_perempuan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
        }

        $dataTableJk = new CActiveDataProvider($modelJk, array(
            'criteria' => $criteria
        ));

        //=== end table ===
//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'modelUmur' => $modelUmur,
            'modelKlp' => $modelKlp,
            'dataPieChartPdk' => $dataPieChartPdk,
            'dataStackChartPdk' => $dataStackChartPdk,
            'graphsStackPdk' => $graphsStackPdk,
            'dataLineChartPdk' => $dataLineChartPdk,
            'graphsLinePdk' => $graphsLinePdk,
            'dataTablePdk' => $dataTablePdk,
            'dataPieChartUmur' => $dataPieChartUmur,
			'dataPieChartUmurDet'=>$dataPieChartUmurDet,
            'dataTableUmur' => $dataTableUmur,
            'dataBarChartUmur' => $dataBarChartUmur,
            'dataPieChartKlp' => $dataPieChartKlp,
            'dataStackChartKlp' => $dataStackChartKlp,
            'graphsStackKlp' => $graphsStackKlp,
            'dataLineChartKlp' => $dataLineChartKlp,
            'graphsLineKlp' => $graphsLineKlp,
            'dataTableKlp' => $dataTableKlp,
            'dataBarLineChartJk' => $dataBarLineChartJk,
            'dataPieChartJk' => $dataPieChartJk,
            'dataTableJk' => $dataTableJk
        ));
    }

}

?>