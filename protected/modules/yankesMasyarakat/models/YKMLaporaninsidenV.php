<?php

/**
 * Digunakan untuk memanggil view Laporaninsiden_v, hanya untuk modul yankesMasyarakat
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models  
 * @category model
 */
class YKMLaporaninsidenV extends LaporaninsidenV {

    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir,
           $data, $jumlah, $tick, $jns_periode, $instalasi_id, $ruangan_id,
           $ruangan_nama, $instalasi_nama, $grading;
    
    public $grade_kuning, $grade_hijau, $grade_biru, $grade_merah, $grade_low, $grade_moderate, $grade_high, $grade_extrem, $pilihan;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporaninsidenV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Criteria pencarian untuk filter data tabel dan print laporan buku register
     * @return \CDbCriteria
     */
    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $format = new MyFormatter();

        $tanggal_awal = date('d-m-Y', strtotime($this->tgl_awal)); 
        $tanggal_akhir = date('d-m-Y', strtotime($this->tgl_akhir)); 
        $this->tgl_awal = $format->formatDateTimeForDb($tanggal_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($tanggal_akhir);
        $criteria->addBetweenCondition('DATE(tanggal_insiden)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("regradingrisiko IS NOT NULL");
        $criteria->join = "left join ruangan_m on t.lokasikejadian_id = ruangan_m.ruangan_id ";
        if (!empty($this->lokasikejadian_id)) {
            $criteria->addInCondition('lokasikejadian_id', $this->lokasikejadian_id);
        }
        
        if (!empty($this->instalasi_id)) {
            $criteria->addInCondition('ruangan_m.instalasi_id', $this->instalasi_id);
        }

        $criteria->order = "tanggal_insiden ASC";
        return $criteria;
    }
    /**
     * Filter tabel laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchTable() {
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Fungsi untuk generate filter / criteria pada frame grafik
     * $model adalah model yang akan digunakan untuk grafik
     * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
     * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
     * 
     * @param type $model
     * @param type $type
     * @param type $addCols
     * @return \CDbCriteria
     */
    public static function criteriaGrafik($model, $type = 'data', $addCols = array()) {
        $criteria = new CDbCriteria;
//        $criteria->select = 'count(pendaftaran_id) as jumlah';
        
//        if (isset($_GET['filter'])){
//            if (!empty($model->penjamin_id)) {
//                $criteria->select   ="(SELECT COUNT(pendaftaran_id) FROM laporaninsiden_v WHERE regradingrisiko = 'Kuning') AS grade_kuning,"
//                                    . "(SELECT COUNT(pendaftaran_id) FROM laporaninsiden_v WHERE regradingrisiko = 'Hijau') AS grade_hijau,"
//                                    . "(SELECT COUNT(pendaftaran_id) FROM laporaninsiden_v WHERE regradingrisiko = 'Biru') AS grade_biru,"
//                                    . "(SELECT COUNT(pendaftaran_id) FROM laporaninsiden_v WHERE regradingrisiko = 'Merah') AS grade_merah,"
//                                    . "regradingrisiko as " . $type; 
////                $criteria->group = 'regradingrisiko';
//            } else if (!empty($model->carabayar_id)) {
//                $criteria->select = 'regradingrisiko as ' . $type;
//                $criteria->group = 'regradingrisiko';
//            } else {
//                $criteria->select = 'regradingrisiko as ' . $type;
//                $criteria->group = 'regradingrisiko';
//            }
//        }
        
        if (!isset($_GET['filter'])){
            $criteria->select   ="  tanggal_insiden,
                                    regradingrisiko,
                                    pendaftaran_id,
                                    sum((case when regradingrisiko = 'Kuning' then 1 else 0 end)) as grade_kuning,
                                    (case when regradingrisiko = 'Hijau' then 1 else 0 end) as grade_hijau,
                                    (case when regradingrisiko = 'Biru' then 1 else 0 end) as grade_biru,
                                    (case when regradingrisiko = 'Merah' then 1 else 0 end) as grade_merah,"; 
            $criteria->group = 'tanggal_insiden, regradingrisiko';
        }

//        if (count($addCols) > 0) {
//            if (is_array($addCols)) {
//                foreach ($addCols as $i => $v) {
//                    $criteria->group .= ',' . $v;
//                    $criteria->select .= ',' . $v . ' as ' . $i;
//                }
//            }
//        }
        
        return $criteria;
    }

    /**
     * Filtering frame grafik laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {

        $criteria = $this->criteriaSearch();
        $format = new MyFormatter();
        
        if (isset($this->pilihan)){
            if ($this->pilihan == 'a') {
                $criteria->select=" sum((case when regradingrisiko = 'Kuning' then 1 else 0 end)) as grade_kuning,
                                    sum((case when regradingrisiko = 'Hijau' then 1 else 0 end)) as grade_hijau,
                                    sum((case when regradingrisiko = 'Biru' then 1 else 0 end)) as grade_biru,
                                    sum((case when regradingrisiko = 'Merah' then 1 else 0 end)) as grade_merah"; 
            }else if($this->pilihan == 'b') {
                $criteria->select=" sum((case when tingkatrisiko_id = 1 then 1 else 0 end)) as grade_low,
                                    sum((case when tingkatrisiko_id = 2 then 1 else 0 end)) as grade_moderate,
                                    sum((case when tingkatrisiko_id = 3 then 1 else 0 end)) as grade_high,
                                    sum((case when tingkatrisiko_id = 5 then 1 else 0 end)) as grade_extrem"; 
            }else if($this->pilihan == 'c') {
                $criteria->select=" sum((case when DATE_PART('hour', waktu_pelaporan - waktu_insiden) <= 48 then 1 else 0 end)) as grade_hijau,
                                    sum((case when DATE_PART('hour', waktu_pelaporan - waktu_insiden) > 48 then 1 else 0 end)) as grade_merah";
            }
        }
        if (!isset($this->pilihan)){
            $criteria->select=" sum((case when regradingrisiko = 'Kuning' then 1 else 0 end)) as grade_kuning,
                                    sum((case when regradingrisiko = 'Hijau' then 1 else 0 end)) as grade_hijau,
                                    sum((case when regradingrisiko = 'Biru' then 1 else 0 end)) as grade_biru,
                                    sum((case when regradingrisiko = 'Merah' then 1 else 0 end)) as grade_merah"; 
        }
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tanggal_insiden)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("regradingrisiko IS NOT NULL");
        if (!empty($this->lokasikejadian_id)) {
            $criteria->addInCondition('lokasikejadian_id', $this->lokasikejadian_id);
        }
        
        $res = YKMLaporaninsidenV::model()->findAll($criteria); 
        
        if (isset($this->pilihan)){
            if ($this->pilihan == 'a') {
                foreach($res as $key => $val){            
                    $dt[1]['id'] = 1;    
                    $dt[1]['data'] = "Biru";                 
                    $dt[1]['jumlah'] = $val->grade_biru;                

                    $dt[2]['id'] = 2;    
                    $dt[2]['data'] = "Hijau";               
                    $dt[2]['jumlah'] = $val->grade_hijau;   

                    $dt[3]['id'] = 3;    
                    $dt[3]['data'] = "Kuning";                 
                    $dt[3]['jumlah'] = $val->grade_kuning;      

                    $dt[4]['id'] = 4;    
                    $dt[4]['data'] = "Merah";                
                    $dt[4]['jumlah'] = $val->grade_merah;                               
                }
            }else if($this->pilihan == 'b') {
                foreach($res as $key => $val){            
                    $dt[1]['id'] = 1;    
                    $dt[1]['data'] = "Low";               
                    $dt[1]['jumlah'] = $val->grade_low;                

                    $dt[2]['id'] = 2;    
                    $dt[2]['data'] = "Moderate";               
                    $dt[2]['jumlah'] = $val->grade_moderate;   

                    $dt[3]['id'] = 3;    
                    $dt[3]['data'] = "High";               
                    $dt[3]['jumlah'] = $val->grade_high;      

                    $dt[4]['id'] = 4;    
                    $dt[4]['data'] = "Extrem";               
                    $dt[4]['jumlah'] = $val->grade_extrem;                               
                }
            }else if($this->pilihan == 'c') {
                foreach($res as $key => $val){            
                    $dt[1]['id'] = 1;    
                    $dt[1]['data'] = "<= 2x24 jam";               
                    $dt[1]['jumlah'] = $val->grade_hijau;   

                    $dt[2]['id'] = 2;    
                    $dt[2]['data'] = "> 2x24 jam";               
                    $dt[2]['jumlah'] = $val->grade_merah;                               
                }
            }
        }
        
        if (!isset($this->pilihan)){
            foreach($res as $key => $val){            
                $dt[1]['id'] = 1;    
                $dt[1]['data'] = "Biru";               
                $dt[1]['jumlah'] = $val->grade_biru;                

                $dt[2]['id'] = 2;    
                $dt[2]['data'] = "Hijau";               
                $dt[2]['jumlah'] = $val->grade_hijau;   

                $dt[3]['id'] = 3;    
                $dt[3]['data'] = "Kuning";               
                $dt[3]['jumlah'] = $val->grade_kuning;      

                $dt[4]['id'] = 4;    
                $dt[4]['data'] = "Merah";               
                $dt[4]['jumlah'] = $val->grade_merah;                               
            }
        }

        return new CArrayDataProvider($dt, array(
                    'keyField'=> 'id',			
                    'id'=>'data_laporan',
                        'totalItemCount'=>count($dt),
                        'pagination' => array(
                            'pageSize' => 10,
                            'pageVar' => 'page'
                        ),			
        )); 
    }

    /**
     * Filtering cetak data laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

?>
