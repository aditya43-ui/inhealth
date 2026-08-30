<?php

class RKrl32KunjunganrdV extends Rl32KunjunganrdV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

      public function getTotPasien($statusrujukan, $jeniskasuspenyakit_id){
            // if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            // }
            
            $format = new MyFormatter();
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
            $modHitung = Rl32KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

          public function getSumCarakeluar($carakeluar_id, $jeniskasuspenyakit_id){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'jeniskasuspenyakit_nama, jeniskasuspenyakit_id';

            
            $criteria->addCondition("carakeluar_id = '".$carakeluar_id."'");
            $criteria->addCondition('jeniskasuspenyakit_id = '.$jeniskasuspenyakit_id);
            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl32KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

          public function getTotalStatus($statusrujukan){
            

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            
            $criteria->addCondition("statusrujukan = '".$statusrujukan."'");
            

            $criteria->select = 'sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl32KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }

         public function getTotalCaraKeluar($carakeluar_id){
            

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            
            $criteria->addCondition("carakeluar_id = '".$carakeluar_id."'");
            

            $criteria->select = 'sum(jmlpasien) AS jmlpasien';
            $modHitung = Rl32KunjunganrdV::model()->findAll($criteria);
            $totHitung = 0;
            foreach($modHitung as $key=>$total){
                $totHitung = $total->jmlpasien;
            }
             return $totHitung;
        }
     
}