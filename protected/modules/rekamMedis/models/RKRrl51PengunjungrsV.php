<?php

class RKRrl51PengunjungrsV extends Rl51PengunjungrsV {

    public $tgl_awal, $tgl_akhir;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $jns_periode;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

      public function getTotPasien($statusrujukan, $jeniskasuspenyakit_id){
            // if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            // }
            
            $format = new CustomFormat();
            $criteria=new CDbCriteria();
            $criteria->group = 'jeniskasuspenyakit_nama, jeniskasuspenyakit_id';

           $criteria->addCondition("statusrujukan = '".$statusrujukan."'");
           $criteria->addCondition('jeniskasuspenyakit_id = '.$jeniskasuspenyakit_id);

           

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlpasien) as jmlpasien';
            $modHitung = Rl23KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

          public function getSumCarakeluar($carakeluar, $jeniskasuspenyakit_id){
            $format = new CustomFormat();
            $criteria=new CDbCriteria();
            $criteria->group = 'jeniskasuspenyakit_nama, jeniskasuspenyakit_id';

            
            $criteria->addCondition("carakeluar = '".$carakeluar."'");
            $criteria->addCondition('jeniskasuspenyakit_id = '.$jeniskasuspenyakit_id);
            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl23KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

          public function getTotalStatus($statusrujukan){
            

            $format = new CustomFormat();
            $criteria=new CDbCriteria();
            
            $criteria->addCondition("statusrujukan = '".$statusrujukan."'");
            

            $criteria->select = 'sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl23KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

         public function getTotalCaraKeluar($carakeluar){
            

            $format = new CustomFormat();
            $criteria=new CDbCriteria();
            
            $criteria->addCondition("carakeluar = '".$carakeluar."'");
            

            $criteria->select = 'sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl23KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }
     
}