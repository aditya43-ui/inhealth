<?php

// pemeriksaan


$konsultasi = array(
    "1.1" => array(
        'name'=>'Konsultasi Dokter Spesialis',
        'value'=>0,
    ),
);
$konsultasi_umum = array(
    "1.8" => array(
        'name'=>'Konsultasi Dokter',
        'value'=>0,
    ),
);


$periksa_dokter = array(
    "1.3" => array(
        'name'=>'Pemeriksaan Dokter',
        'value'=>0,
    )
);

$periksa_bidan = array(
    "1.3.1" => array(
        'name'=>'Pemeriksaan Bidan',
        'value'=>0,
    ),
);

$tindakan_dokter = array(
    "1.2.1" => array(
        'name'=>'Tindakan Paramedis',
        'value'=>0,
    ),
);

$tindakan_medis = array(
    "1.2.1" => array(
        'name'=>'Tindakan Paramedis',
        'value'=>0,
    ),
);

$tindakan_bidan = array(
    "1.2.2" => array(
        'name'=>'Tindakan Paramedis',
        'value'=>0,
    ),
);

$tindakan_fisioterapi = array(
    "1.2.3" => array(
        'name'=>'Tindakan Fisioterapi',
        'value'=>0,
    )
);

$tindakan = array(
    "1.2" => array(
        'name'=>'Tindakan Paramedis',
        'value'=>0,
    ), /*
    "1.4" => array(
        'name'=>'Pendaftaran',
        'value'=>0,
    ), */
);


$visite = array(
    "1.6" => array(
        'name'=>'Pemeriksaan Dokter Spesialis',
        'qty'=>0,
        'satuan'=>'Kali',
        'value'=>0,
    ),
    "1.5" => array(
        'name'=>'Pemeriksaan Dokter Umum',
        'qty'=>0,
        'satuan'=>'Kali',
        'value'=>0,
    ), /*
    "1.7" => array(
        'name'=>'Pemeriksaan Perawat',
        'value'=>0,
    ), */
);


// jenis oa
$jenis_bu = array(22, 4, 1, 20, 14);
$jenis_oa = array();
$jenis_oa_list = CHtml::listData(ObatalkesM::model()->findAll(array(
    'condition'=>'obatalkes_aktif = true and jenisobatalkes_id is not null',
    'select'=>'jenisobatalkes_id',
)), 'jenisobatalkes_id', 'jenisobatalkes_id');

$jenis_oa_mod = JenisobatalkesM::model()->findAllByAttributes(array(
    'jenisobatalkes_id'=>$jenis_oa_list,
), array(
    'order'=>'jenisobatalkes_nama',
    'condition'=>'jenisobatalkes_id not in (22, 4, 1, 20, 14)',
));

$jenis_oa = array(
    "2.22" => array(
        'name'=>'Pemakaian Obat',
        'value'=>0,
    ),
    "2.4" => array(
        'name'=>'Pemakaian BHP',
        'value'=>0,
    ),
    "2.1" => array(
        'name'=>'Pemakaian Alkes',
        'value'=>0,
    ),
    "2.20" => array(
        'name'=>'Pemakaian Infus',
        'value'=>0,
    ),
    "2.14" => array(
        'name'=>'Pemakaian Injeksi',
        'value'=>0,
    ),
);

foreach ($jenis_oa_mod as $item) {
    $jenis_oa["2.".$item->jenisobatalkes_id] = array(
        'name'=>"Pemakaian ".$item->jenisobatalkes_nama,
        'value'=>0,
    );
}

$jenis_oa["2.99"] = array(
    'name'=>'Pemakaian Alat Medis',
    'value'=>0,
);




// operasi
$jasa_operasi = array(
    "3.1" => array(
        'name'=>'Pemakaian Kamar Operasi + RR',
        'value'=>0,
    ),
    "3.2" => array(
        'name'=>'Jasa Medik Dokter + Anastesi',
        'value'=>0,
    ),
    "3.3" => array(
        'name'=>'Jasa Medik Tim Operasi',
        'value'=>0,
    ),
);


// lab
$jenis_lab = array();
$periksa_lab = CHtml::listData(PemeriksaanlabM::model()->findAll(array(
    'condition'=>'pemeriksaanlab_aktif = true',
    'select'=>'jenispemeriksaanlab_id'
)), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_id');
$jenis_lab_mod = JenispemeriksaanlabM::model()->findAllByAttributes(array(
    'jenispemeriksaanlab_id'=>$periksa_lab,
), array(
    'order'=>'jenispemeriksaanlab_nama',
));

foreach ($jenis_lab_mod as $item) {
    
    if (trim(strtolower($item->jenispemeriksaanlab_kelompok)) == 'patologi klinik') {
        $item->jenispemeriksaanlab_kelompok = 'LABORATORIUM KLINIK';
    }
    
    $jenis_lab["4.".$item->jenispemeriksaanlab_kelompok] = array(
        'name'=>$item->jenispemeriksaanlab_kelompok,
        'value'=>0,
    );
}

// rad
$jenis_rad = array();
$periksa_rad = CHtml::listData(PemeriksaanradM::model()->findAll(array(
    'condition'=>'pemeriksaanrad_aktif = true',
    'select'=>'jenispemeriksaanrad_id'
)), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_id');
$jenis_rad_mod = JenispemeriksaanradM::model()->findAllByAttributes(array(
    'jenispemeriksaanrad_id'=>$periksa_rad,
), array(
    'order'=>'jenispemeriksaanrad_nama',
));

foreach ($jenis_rad_mod as $item) {
    $jenis_rad["5.".$item->jenispemeriksaanrad_id] = array(
        'name'=>$item->jenispemeriksaanrad_nama,
        'value'=>0,
    );
}


// kamar

$kamar = array(
    "6.1"=>array(
        'name'=>'VVIP',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
    "6.2"=>array(
        'name'=>'VIP',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
    "6.25"=>array(
        'name'=>'Eksekutif',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
    "6.3"=>array(
        'name'=>'Kelas I',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
    "6.5"=>array(
        'name'=>'Kelas II',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
    "6.4"=>array(
        'name'=>'Kelas III',
        'value'=>0,
        'qty'=>0,
        'satuan'=>'Hari',
    ),
);


$grp = array(
    1 => array(
        'name'=>'PENDAFTARAN',
        'value'=>0,
    ),
    2 => array(
        'name'=>'POLIKLINIK',
        'detail'=> array (
            2 => array(
                'name'=>'Poli Spesialis',
                'detail'=>array_merge($periksa_dokter, $tindakan_medis, $konsultasi_umum),
            ),
            4 => array(
                'name'=>'Poli Umum/KIA',
                'detail'=>array_merge($periksa_dokter, $tindakan_medis, $konsultasi),
            ),
            3 => array (
                'name'=>'UGD',
                'detail'=>array_merge($periksa_dokter, $tindakan_medis, $konsultasi),
            ),
        ),
    ),
    3 => array(
        'name'=>'KAMAR OPERASI',
        'detail'=>array_merge($jasa_operasi),
    ),
    13 => array(
        'name'=>'PERSALINAN',
        'detail'=>array_merge(array(
            "9.1"=>array(
                'name'=>'Pemakaian Kamar Bersalin',
                'value'=>0,
            ),
        ),$periksa_dokter, $periksa_bidan, $konsultasi_umum, $tindakan_dokter, $tindakan_bidan, array(
            "9.2"=>array(
                'name'=>'Perawatan Intensif',
                'value'=>0,
            ),
        )),
    ),
    4 => array(
        'name'=>'LABORATORIUM',
        'detail'=>array_merge($jenis_lab, array(
            "4.99"=>array(
                'name'=>'Darah',
                'value'=>0,
            )
        )),
    ),
    "4.1" => array(
        'name'=>'RADIOLOGI',
        'detail'=>array_merge($jenis_rad),
    ),
    5 => array(
        'name'=>'RUANGAN',
        'detail'=>$kamar,
    ),
    6 => array(
        'name'=>'PEMERIKSAAN',
        'detail'=>array_merge($visite, $konsultasi, array(
            '1.8'=>array(
                'name'=>'Konsul Gizi',
                'value'=>0,
            )
        )),
    ),
    12 => array(
        'name'=>'TINDAKAN',
        'detail'=>array_merge($tindakan_dokter, $tindakan, $tindakan_fisioterapi, array(
            '10.1' => array(
                'name'=>'Perawatan Lanjutan',
                'value'=>0,
            ),
        )),
    ),
    7 => array(
        'name'=>'RUANG NEONATUS',
        'detail'=>array_merge(array(
            "11.1"=>array(
                'name'=>'Pemakaian Ruangan',
                'value'=>0,
            ),
        ),$tindakan_dokter, $tindakan),
    ),
    14 => array(
        'name'=>'APOTEK',
        'detail'=>$jenis_oa,
    ),
    8 => array(
        'name'=>'KENDARAAN',
        'detail'=>array(
            '7.1'=>array(
                'name'=>'Ambulance Dalam Kota',
                'value'=>0,
            ),
            '7.2'=>array(
                'name'=>'Ambulance Luar Kota',
                'value'=>0,
            ),
            '7.3'=>array(
                'name'=>'Ambulance Jenazah',
                'value'=>0,
            )
        ),
    ),
    9 => array(
        'name'=>'JASA PELAYANAN RS',
        'value'=>0,
    ),
    10 => array(
        'name'=>'ADMINISTRASI',
        'value'=>0,
    ),
    11 => array(
        'name'=>'LAIN-LAIN',
        'value'=>0,
    ),
);

echo CJSON::encode($grp);

?>
