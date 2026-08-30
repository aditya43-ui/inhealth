<?php

class MasterPasienController extends MyAuthController {

    public function actionIndex() {
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $model = new SEPasienujkR();
        $modelKerja = new SEPasienpekerjaanR();
//        $modelKlp = new SEPegawaiberdasarkanklpR();


        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEPasienujkR'])) {
            $model->attributes = $_GET['SEPasienujkR'];
            $model->jns_periode = $_GET['SEPasienujkR']['jns_periode'];

            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPasienujkR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPasienujkR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPasienujkR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPasienujkR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPasienujkR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPasienujkR']['thn_akhir'];
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
        // TABULASI UMUR
        //=== chart ===

        $sql = "
		SELECT 
		golonganumur as jenis, SUM(COALESCE(lakilaki,0)) * -1 as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pasienujk_r
                WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
		ORDER BY CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END
				";


        $resultBarChartUmur = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChartUmur = $resultBarChartUmur;

        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('golonganumur as jenis, SUM(COALESCE(lakilaki,0)) as jumlah_l,  SUM(COALESCE(perempuan,0)) as jumlah_p, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as total');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis';
                $criteria->order = "CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END";
                break;
            case 'tahun' : $criteria->select = array('golonganumur as jenis, SUM(COALESCE(lakilaki,0)) as jumlah_l,  SUM(COALESCE(perempuan,0)) as jumlah_p, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as total');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis';
                $criteria->order = "CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END";
                break;
            default : $criteria->select = array('golonganumur as jenis, SUM(COALESCE(lakilaki,0)) as jumlah_l,  SUM(COALESCE(perempuan,0)) as jumlah_p, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as total');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis';
                $criteria->order = "CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END";
        }

        $dataTableUmur = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
                'pagination' =>false,
        ));

        $sql = "
		SELECT 
		golonganumur as jenis, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as jumlah
		FROM pasienujk_r
                WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
		ORDER BY CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END;				";


        $resultPieChartUmur = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartUmur = $resultPieChartUmur;

        $sql = "
		SELECT 
		SUM(COALESCE(lakilaki,0)) as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pasienujk_r
                WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				";


        $resultPieChartJK = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartJk = array();
        foreach ($resultPieChartJK as $data) {
            foreach ($data as $key => $value) {
                if ($key == "jumlah_l") {
                    $key = "Laki - laki";
                } else {
                    $key = "Perempuan";
                }
                $tempPieChartJk['jenis'] = $key;
                $tempPieChartJk['jumlah'] = $value;

                array_push($dataPieChartJk, $tempPieChartJk);
            }
        }

        // Umur Stack Chart
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, golonganumur as jenis, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as jumlah
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis,periode
		ORDER BY CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END;
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, golonganumur as jenis, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as jumlah
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis,periode
		ORDER BY CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END;

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, golonganumur as jenis, SUM(COALESCE(lakilaki,0)) + SUM(COALESCE(perempuan,0)) as jumlah
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis,periode
		ORDER BY CASE   
                                WHEN golonganumur = '>80' THEN 1
                                WHEN golonganumur = '76-80' THEN 2
                                WHEN golonganumur = '71-75' THEN 3
                                WHEN golonganumur = '66-70' THEN 4
                                WHEN golonganumur = '61-65' THEN 5
                                WHEN golonganumur = '56-60' THEN 6
                                WHEN golonganumur = '51-55' THEN 7
                                WHEN golonganumur = '46-50' THEN 8
                                WHEN golonganumur = '41-45' THEN 9
                                WHEN golonganumur = '36-40' THEN 10
                                WHEN golonganumur = '31-35' THEN 11
                                WHEN golonganumur = '26-30' THEN 12
                                WHEN golonganumur = '21-25' THEN 13
                                WHEN golonganumur = '16-20' THEN 14
                                WHEN golonganumur = '11-15' THEN 15
                                WHEN golonganumur = '6-10' THEN 16
                                WHEN golonganumur = '0-5' THEN 17                              
                       END;

									";
        }
        $resultStackChartUmur = Yii::app()->db->createCommand($sql)->queryAll();
        $StackChartUmur = array();
        foreach ($resultStackChartUmur as $data) {
            $id = $data['periode'];
            if (isset($StackChartUmur[$id])) {
                unset($data['periode']);
                $StackChartUmur[$id][] = $data;
            } else {
                unset($data['periode']);
                $StackChartUmur[$id] = array($data);
            }
        }

        if (count($resultStackChartUmur) > 0) {
            $dataStackChartUmur = array();
            foreach ($StackChartUmur as $key => $value) {
                $tempStackChartUmur['periode'] = $key;
                foreach ($value as $data) {
                    $tempStackChartUmur['jumlah' . $data['jenis']] = $data['jumlah'];
                }
                array_push($dataStackChartUmur, $tempStackChartUmur);
            }


            // generate_graph
            $graphStackUmur = array();
            $graphsStackUmur = array();
            foreach ($resultStackChartUmur as $data) {
                $id = $data['jenis'];
                if (isset($graphStackUmur[$id])) {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackUmur[$id][] = $data;
                } else {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackUmur[$id] = array($data);
                }
            }

            // make graphs
            foreach ($graphStackUmur as $key => $data) {
                $tempGraphStackUmur['id'] = "graph" . $data[0]['jenis'];
                $tempGraphStackUmur['title'] = $data[0]['jenis'];
                $tempGraphStackUmur['valueField'] = "jumlah" . $data[0]['jenis'];
                $tempGraphStackUmur['balloonText'] = "[[title]]:[[value]]";
                $tempGraphStackUmur['lineAlpha'] = 0.5;
                $tempGraphStackUmur['fillAlphas'] = 0.5;
                array_push($graphsStackUmur, $tempGraphStackUmur);
            }
        } else {
            $dataStackChartUmur = array();
            $graphsStackUmur = array();
        }


        // Jenis Kelamin Stack Chart
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, SUM(COALESCE(lakilaki,0)) as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, SUM(COALESCE(lakilaki,0)) as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, SUM(COALESCE(lakilaki,0)) as jumlah_l, SUM(COALESCE(perempuan,0)) as jumlah_p
		FROM pasienujk_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode

									";
        }
        $resultStackChartJk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataStackChartJk = $resultStackChartJk;


        // TABULASI PEKERJAAN
        //=== chart ===

        $sql = "
		SELECT 
		pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis
		ORDER BY id
                LIMIT 10
				";


        $resultPieChartKerja = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartKerja = $resultPieChartKerja;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
        }
        $resultStackChartKerja = Yii::app()->db->createCommand($sql)->queryAll();
        $StackChartKerja = array();

        foreach ($resultStackChartKerja as $data) {
            $id = $data['periode'];
            if (isset($StackChartKerja[$id])) {
                unset($data['periode']);
                $StackChartKerja[$id][] = $data;
            } else {
                unset($data['periode']);
                $StackChartKerja[$id] = array($data);
            }
        }

        if (count($resultStackChartKerja) > 0) {

            $dataStackChartKerja = array();
            foreach ($StackChartKerja as $key => $value) {
                $tempStackChartKerja['periode'] = $key;
                foreach ($value as $data) {
                    $tempStackChartKerja['jumlah' . $data['id']] = $data['jumlah'];
                }
                array_push($dataStackChartKerja, $tempStackChartKerja);
            }


            // generate_graph
            $graphStackKerja = array();
            $graphsStackKerja = array();
            foreach ($resultStackChartKerja as $data) {
                $id = $data['id'];
                if (isset($graphStackKerja[$id])) {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackKerja[$id][] = $data;
                } else {
                    unset($data['periode']);
                    unset($data['jumlah']);

                    $graphStackKerja[$id] = array($data);
                }
            }

            // make graphs
            foreach ($graphStackKerja as $key => $data) {
                $tempGraphStackKerja['id'] = "graph" . $data[0]['id'];
                $tempGraphStackKerja['title'] = $data[0]['jenis'];
                $tempGraphStackKerja['valueField'] = "jumlah" . $data[0]['id'];
                $tempGraphStackKerja['balloonText'] = "[[title]]:[[value]]";
                $tempGraphStackKerja['lineAlpha'] = 0.5;
                $tempGraphStackKerja['fillAlphas'] = 0.5;
                array_push($graphsStackKerja, $tempGraphStackKerja);
            }
        } else {
            $dataStackChartKerja = array();
            $graphsStackKerja = array();
        }

        //=== start table ===

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pekerjaan_id as id, pekerjaan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpekerjaan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
        }


        $resultTabelKerja = Yii::app()->db->createCommand($sql)->queryAll();
        $dataTableKerja = array();
        foreach ($resultTabelKerja as $data) {
            $id = $data['periode'];
            if (isset($dataTableKerja[$id])) {
                $dataTableKerja[$id][] = $data;
            } else {
                $dataTableKerja[$id] = array($data);
            }
        }
        //=== end table ===
        // TABULASI PENDIDIKAN
        //=== chart ===

        $sql = "
		SELECT 
		pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis
		ORDER BY id
                LIMIT 10
				";


        $resultPieChartPdk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChartPdk = $resultPieChartPdk;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode

									";
        }
        $resultStackChartPdk = Yii::app()->db->createCommand($sql)->queryAll();
        $StackChartPdk = array();
        foreach ($resultStackChartPdk as $data) {
            $id = $data['periode'];
            if (isset($StackChartPdk[$id])) {
                unset($data['periode']);
                $StackChartPdk[$id][] = $data;
            } else {
                unset($data['periode']);
                $StackChartPdk[$id] = array($data);
            }
        }

        if (count($resultStackChartPdk) > 0) {

            $dataStackChartPdk = array();
            foreach ($StackChartPdk as $key => $value) {
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
                if (isset($graphStackPdk[$id])) {
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

        //=== start table ===

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, pendidikan_id as id, pendidikan_nama as jenis, sum(jumlah) as jumlah
		FROM pasienpendidikan_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC

									";
        }


        $resultTabelPdk = Yii::app()->db->createCommand($sql)->queryAll();
        $dataTablePdk = array();
        foreach ($resultTabelPdk as $data) {
            $id = $data['periode'];
            if (isset($dataTablePdk[$id])) {
                $dataTablePdk[$id][] = $data;
            } else {
                $dataTablePdk[$id] = array($data);
            }
        }

        //=== end table ===

//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataBarChartUmur' => $dataBarChartUmur,
            'dataTableUmur' => $dataTableUmur,
            'dataPieChartUmur' => $dataPieChartUmur,
            'dataPieChartJk' => $dataPieChartJk,
            'graphsStackUmur' => $graphsStackUmur,
            'dataStackChartUmur' => $dataStackChartUmur,
            'dataStackChartJk' => $dataStackChartJk,
            'dataPieChartKerja' => $dataPieChartKerja,
            'dataStackChartKerja' => $dataStackChartKerja,
            'dataTableKerja' => $dataTableKerja,
            'graphsStackKerja' => $graphsStackKerja,
            'dataPieChartPdk' => $dataPieChartPdk,
            'dataStackChartPdk' => $dataStackChartPdk,
            'dataTablePdk' => $dataTablePdk,
            'graphsStackPdk' => $graphsStackPdk
        ));
    }

}

?>