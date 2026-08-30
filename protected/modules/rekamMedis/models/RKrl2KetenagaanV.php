<?php

class RKrl2KetenagaanV extends Rl2KetenagaanV {
    
    public $tgl_awal, $tgl_akhir;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $jns_periode;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function cekPendidikanKualifikasi($pendkualifikasi_id, $jeniskelamin)
    {
       $criteria=new CDbCriteria();
       $criteria->addCondition("pendkualifikasi_id = ".$pendkualifikasi_id);       
       $cek = Rl2KetenagaanV::model()->findAll($criteria);
              
       $criteria2=new CDbCriteria();
       $criteria2->addCondition("pendkualifikasi_id = ".$pendkualifikasi_id  );     //
       $criteria2->addCondition("jeniskelamin = '$jeniskelamin' ");
       
       $cek2 = Rl2KetenagaanV::model()->findAll($criteria2);
       
       if (count((array)$cek) > 1)
       {    $status = true;    
            if (count((array)$cek2) > 0)
            {           
                foreach($cek2 as $cek3):
                    $data = $cek3->jeniskelamin;
                endforeach;
                //var_dump($data);die;
                if ($data == 'PEREMPUAN'):                   
                    $status = true;
                else:
                    $status = false;
                endif;
                            
            }
            else
            {
                $status = false;               
            }
       }
       else
       {
           $status = true;
       }
                      
       return $status;
    }

     public function getSumKeadaan($pendkualifikasi_id, $jeniskelamin){
           
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';

           // $criteria->addCondition('pendkualifikasi_id = '.$pendkualifikasi_id);
           $criteria->addCondition("pendkualifikasi_id = ".$pendkualifikasi_id);
           $criteria->addCondition("jeniskelamin = '".$jeniskelamin."'");
           

           

            $criteria->select = $criteria->group;
            $modTarif = Rl2KetenagaanV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif = $tarif->jmlkeadaanskrg;
            }
             return $totTarif;
        }

     public function getSumTotal($jeniskelamin){
            // if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            // }
            

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';
            $criteria->addCondition("jeniskelamin = '".$jeniskelamin."'");

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlkeadaanskrg) AS jmlkeadaanskrg';
            $modTarif = Rl2KetenagaanV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jmlkeadaanskrg;
            }
             return $totTarif;
        }

        public function getSumkebutuhanL(){
            // if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            // }
            

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlkeblaki) AS jmlkeblaki';
            $modTotal = Rl2KetenagaanV::model()->findAll($criteria);
            $total = 0;
            foreach($modTotal as $key=>$tot){
                $total += $tot->jmlkeblaki;
            }
             return $total;
        }

        public function getSumkebutuhanP(){
            // if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            // }
            

            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tglAwal = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAwal']);
            //     $tglAkhir = $format->formatDateTimeMediumForDB($_GET['GZLaporanJumlahPorsiV']['tglAkhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tglAwal,$tglAkhir);
            // }

            $criteria->select = $criteria->group.', sum(jmlkebperempuan) AS jmlkebperempuan';
            $modTotal = Rl2KetenagaanV::model()->findAll($criteria);
            $total = 0;
            foreach($modTotal as $key=>$tot){
                $total += $tot->jmlkebperempuan;
            }
             return $total;
        }



     
}