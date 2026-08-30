<?php

class PersediaanObatAlkesController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.persediaanObatAlkes.';

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
        $model = new SEPersediaanobatR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $instalasiAsals = CHtml::listData(SEInstalasiM::getInstalasiStokOas(), 'instalasi_id', 'instalasi_nama');
        $ruanganAsals = CHtml::listData(SERuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');
        $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['SEPersediaanobatR'])) {
            $model->attributes = $_GET['SEPersediaanobatR'];
            $model->jns_periode = $_GET['SEPersediaanobatR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPersediaanobatR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPersediaanobatR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPersediaanobatR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPersediaanobatR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPersediaanobatR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPersediaanobatR']['thn_akhir'];
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
        }
        //=== chart ===
        // check instalasi & ruangan
        if(empty($model->instalasi_id)){
            $params1 = '';
        }else{
            $params1 = 'AND instalasi_id = ' . $model->instalasi_id;
        }
        
        if(empty($model->ruangan_id)){
            $params2 = '';
        }else{
            $params2 = 'AND ruangan_id = '. $model->ruangan_id;
        }
        
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes
		FROM persediaanobat_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                " . $params1 .' '. $params2 . "
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
										SELECT 
										date_trunc('day', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes
										FROM persediaanobat_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                                                                " . $params1 .' '. $params2 . "
										GROUP BY periode
										ORDER BY periode ASC

									";
                break;
            default : $sql = "
										SELECT 
										date_trunc('day', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes
										FROM persediaanobat_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                                                                " . $params1 .' '. $params2 . "
										GROUP BY periode
										ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChart = $result;
        

        $sql = "
				SELECT 
				sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes
				FROM persediaanobat_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                " . $params1 .' '. $params2 . "
				";


        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataPie = $result;

        foreach ($dataPie as $key => $value) {
            if ($key == "jumlah_obat") {
                $key = "Obat";
            } elseif ($key == "jumlah_alkes") {
                $key = "Alkes";
            }
            $temp['jenis'] = $key;
            $temp['jumlah'] = $value;

            array_push($dataPieChart, $temp);
        }
        //=== end chart ===
        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                
                if(!empty($model->instalasi_id)){
                    $criteria->compare('instalasi_id', $model->instalasi_id);   
                }
                
                if(!empty($model->ruangan_id)){
                    $criteria->compare('ruangan_id', $model->ruangan_id);   
                }
                
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                if(!empty($model->instalasi_id)){
                    $criteria->compare('instalasi_id', $model->instalasi_id);   
                }
                
                if(!empty($model->ruangan_id)){
                    $criteria->compare('ruangan_id', $model->ruangan_id);   
                }
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(obat) as jumlah_obat, sum(alkes) as jumlah_alkes');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                if(!empty($model->instalasi_id)){
                    $criteria->compare('instalasi_id', $model->instalasi_id);   
                }
                
                if(!empty($model->ruangan_id)){
                    $criteria->compare('ruangan_id', $model->ruangan_id);   
                }
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
        }

        $dataTable = new CActiveDataProvider($model, array(
            'criteria' => $criteria
        ));

        //=== end table ===

//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'format' => $format,
            'instalasiAsals' => $instalasiAsals,
            'ruanganAsals' => $ruanganAsals,
        ));
    }

}

?>