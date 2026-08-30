<?php

class RJLaporansurveilansV extends LaporansurveilansV {

    public $tgl_awal, $tgl_akhir, $pilihan_tab, $jumlah_tampil;

    public function searchTable() {
        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('date(surveilans_tgl)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchTableRekap() {
        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('date(surveilans_tgl)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
//        $criteria->limit=1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $this->jumlah_tampil,),
            'totalItemCount' => $this->jumlah_tampil,
        ));
    }

    public function GetTotalPasien() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT count(pasien_id) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalETT() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(CAST(pelepasan_tgl AS date) - CAST(surveilans_tgl AS date)) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalIVL() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(CAST(pelepasan_tgl AS date) - CAST(surveilans_tgl AS date)) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalUC() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(CAST(pelepasan_tgl AS date) - CAST(surveilans_tgl AS date)) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalCVC() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(CAST(pelepasan_tgl AS date) - CAST(surveilans_tgl AS date)) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalVAP() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(vap) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalIAD() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(iad) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalPLEB() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(pleb) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalISK() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(isk) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function GetTotalCDL() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(cdl) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }
    
    public function GetTotalPO() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(surgery) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }
    
    public function GetTotalIDO() {
        $hasil = '';
        $format = new MyFormatter();
        $this->tgl_awal = date('Y-m-d 00:00:00');
        $this->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['RJLaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['RJLaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
        }
        $data = Yii::app()->db->createCommand(
                        "SELECT sum(ido) AS total
                            FROM laporansurveilans_v
                            WHERE
                            surveilans_tgl between '$this->tgl_awal' and '$this->tgl_akhir' "
                )->queryAll();
        $hasil = number_format($data[0]['total'], 0, "", ",");
        return $hasil;
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(surveilans_tgl)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        // Klo limit lebih kecil dari nol itu berarti ga ada limit  
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function searchPrintRekap($is_paginasi = true) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

//        var_dump($this->tgl_awal, $this->tgl_akhir);
        
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('surveilans_tgl::date', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        
        
        
        // Klo limit lebih kecil dari nol itu berarti ga ada limit  
//		$criteria->limit= 1; 

        if ($is_paginasi) {
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array('pageSize' => $this->jumlah_tampil,),
                'totalItemCount' => $this->jumlah_tampil,
            ));
        } else {
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => false,
            ));
        }
    }

    public function getRuanganItems() {
        return RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama'));
    }

    public function getInstalasiItems() {
        return InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    }

    public function Totalett($pasien_id) {
        $hasil = 0;
        $this->tgl_awal = date('Y-m-d');
        $this->tgl_akhir = date('Y-m-d');
        $criteria = new CDbCriteria;
        if (isset($_GET['LaporansurveilansV']['tgl_awal'])) {
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['LaporansurveilansV']['tgl_awal']);
        }
        if (isset($_GET['LaporansurveilansV']['tgl_akhir'])) {
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporansurveilansV']['tgl_akhir']);
        }
        if (isset($_GET['LaporansurveilansV']['instalasi_id'])) {
            $this->jenispenjualan = $_GET['LaporansurveilansV']['instalasi_id'];
        }
        if (isset($_GET['LaporansurveilansV']['ruangan_id'])) {
            $this->jenispenjualan = $_GET['LaporansurveilansV']['ruangan_id'];
        }
        $criteria->addBetweenCondition('date(surveilans_tgl)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->addCondition('pasien_id = ' . $pasien_id);

        $cektotal = LaporansurveilansV::model()->findAll($criteria);
        if (count((array)$cektotal) > 0) {
            foreach ($cektotal as $key => $data) {
                $hasil += $data->ett;
//								echo 'ada';
            }
        }
        return $hasil;
    }
    
    public function getSelisihSurveilansPasang($tglpasang, $tglsurveilans){
        if(empty($tglpasang)){
            $tglpasang = date('Y-m-d');
        }
        if(empty($tglsurveilans)){
            $tglsurveilans = date('Y-m-d');
        }
        $total = CustomFunction::hitungHari($tglpasang, $tglsurveilans);
        return $total;     
    }

}
