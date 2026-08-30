<?php
$format = new MyFormatter();
$penunjang = PasienmasukpenunjangT::model()->find("pendaftaran_id = '".$pendaftaran_id."' ");
$pasienmasukpenunjang_id = !empty($penunjang)?$penunjang->pasienmasukpenunjang_id:null;
// "DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '". $format->formatDateTimeForDb($tgl_awal) ."' AND '". $format->formatDateTimeForDb($tgl_akhir) ."'",
    if(!empty($pendaftaran_id) && !empty($pasienmasukpenunjang_id)){
        $cond = array(
           
            "pasienmasukpenunjang_t.ruangan_id = '".Params::RUANGAN_ID_LAB_KLINIK."' ",
            "pasienmasukpenunjang_t.pasienmasukpenunjang_id = $pasienmasukpenunjang_id",
            "pendaftaran_t.pendaftaran_id = $pendaftaran_id",
            "daftartindakan_m.daftartindakan_id = '".Params::DAFTARTINDAKAN_ID_IGM."' "
        );
    }
    //else{
      //  $cond = array(
        //            "pasienmasukpenunjang_t.ruangan_id = '".Params::RUANGAN_ID_LAB_KLINIK."' "
          //      );
   // }
    
    $query = "select 
                    pasien_m.no_rekam_medik,
                    pasien_m.nama_pasien,
                    pasien_m.jeniskelamin,
                    pasien_m.alamat_pasien,
                    pasien_m.rt,
                    pasien_m.rw,
                    kabupaten_m.kabupaten_nama,
                    propinsi_m.propinsi_nama,
                    pendaftaran_t.tgl_pendaftaran,
                    pendaftaran_t.no_pendaftaran,
                    pendaftaran_t.pendaftaran_id,
                    pendaftaran_t.umur,
                    pasienmasukpenunjang_t.no_masukpenunjang,
                    daftartindakan_m.daftartindakan_id
            from tindakanpelayanan_t b
            LEFT JOIN pasienmasukpenunjang_t 
                    ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
            LEFT JOIN pendaftaran_t 
                    ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
            LEFT JOIN pasien_m 
                    ON pendaftaran_t.pasien_id = pasien_m.pasien_id
            LEFT JOIN detailhasilpemeriksaanlab_t 
                    ON b.tindakanpelayanan_id = detailhasilpemeriksaanlab_t.tindakanpelayanan_id	
            LEFT JOIN hasilpemeriksaanlab_t 
                    ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = hasilpemeriksaanlab_t.hasilpemeriksaanlab_id
            LEFT JOIN pemeriksaanlabdet_m 
                    ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id
            LEFT JOIN pemeriksaanlab_m
                    ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
            LEFT JOIN daftartindakan_m 
                    ON daftartindakan_m.daftartindakan_id = b.daftartindakan_id 
            LEFT JOIN jenispemeriksaanlab_m 
                    ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
            LEFT JOIN kabupaten_m 
                    ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
            LEFT JOIN propinsi_m 
                    ON pasien_m.propinsi_id = propinsi_m.propinsi_id
            ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
            GROUP BY 
                    pasien_m.no_rekam_medik,
                    pasien_m.nama_pasien,
                    pasien_m.jeniskelamin,
                    pasien_m.alamat_pasien,
                    pasien_m.rt,
                    pasien_m.rw,
                    kabupaten_m.kabupaten_nama,
                    propinsi_m.propinsi_nama,
                    pendaftaran_t.tgl_pendaftaran,
                    pendaftaran_t.no_pendaftaran,
                    pendaftaran_t.pendaftaran_id,
                    pendaftaran_t.umur,
                    pasienmasukpenunjang_t.no_masukpenunjang,
                    daftartindakan_m.daftartindakan_id
                LIMIT 1   ";
    $data = Yii::app()->db->createCommand($query)->queryAll();
    
    if(COUNT($data)>0)
    {   
        foreach($data as $i=>$datas)
        {
            echo ($datas['daftartindakan_id'] == Params::DAFTARTINDAKAN_ID_IGM) ?  "<center><i class=icon-ok icon-black></i></center>":  "<center><i class=icon-minus icon-black></i></center>";
        }
    }
    else
    {
            echo "<center><i class=icon-minus icon-black></i></center>";
    }  
?>