<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

$persalinan->lokasi_persalinan = CJSON::decode($persalinan->lokasi_persalinan);
$persalinan->rujuk_pendamping = CJSON::decode($persalinan->rujuk_pendamping);
$persalinan->masalah_kehamilan = CJSON::decode($persalinan->masalah_kehamilan);

$lokasi_list = array(
    'Rumah Ibu'=>'Rumah Ibu',
    'Polindes'=>'Polindes',
    'Klinik Swasta'=>'Klinik Swasta',
    'Puskesmas'=>'Puskesmas',
    'Rumah Sakit'=>'Rumah Sakit',
);

$pendamping_list = array(
    'Bidan'=>'Bidan',
    'Suami'=>'Suami',
    'Keluarga'=>'Keluarga',
    'Teman'=>'Teman',
    'Dukun'=>'Dukun',
    'Tidak Ada'=>'Tidak Ada',
);

$masalah_list = array(
    'Gawat Darurat'=>'Gawat Darurat',
    'Pendarahan'=>'Pendarahan',
    'HDK'=>'HDK',
    'Infeksi'=>'Infeksi',
    'PMTCT'=>'PMTCT',
);

?>

<style>
    .tab_list td {
        vertical-align: top;
    }
    
    .tab_detail {
        width:100%;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<h3 style="text-align: center">CATATAN PERSALINAN</h3>

<table width="100%" class="tab_list">
    <tr>
        <td width="50%">
            <ol>
                <li>Tanggal : <?php echo MyFormatter::formatDateTimeForUser($persalinan->create_time); ?></li>
                <li>Nama Bidan : <?php echo empty($persalinan->bidan) ? "-" : $persalinan->bidan->nama_pegawai; ?></li>
                <li>Tempat Persalinan : <br>
                    <ul style="list-style-type: none">
                        <?php 
                        
                        
                        foreach ($lokasi_list as $val => $label): ?>
                        <li>
                            <?php 
                            echo ((!empty($persalinan->lokasi_persalinan) && in_array($val, $persalinan->lokasi_persalinan)) ? $ceklis : $unceklis)." ".$label; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>Alamat Tempat Persalinan : <?php echo empty($persalinan->alamat_persalinan) ? "-" :  $persalinan->alamat_persalinan; ?></li>
                <li>Catatan : <?php
                
                echo $persalinan->is_rujuk ? $ceklis : $unceklis;
                echo " Rujuk, Kala : ";
                if ($persalinan->is_rujuk && !empty($persalinan->rujuk_kala)) {
                    echo $persalinan->rujuk_kala;
                } else {
                    echo "-";
                }
                
                ?></li>
                <li>Alasan Merujuk : <?php echo empty($persalinan->rujuk_alasan) ? "-" :  $persalinan->rujuk_alasan; ?></li>
                <li>Tempat Rujukan : <?php echo empty($persalinan->rujuk_tempat) ? "-" :  $persalinan->rujuk_tempat; ?></li>
                <li>Berdamping pada saat merujuk : <br>
                
                    <ul style="list-style-type: none">
                        <?php 
                        
                        
                        foreach ($pendamping_list as $val => $label): ?>
                        <li>
                            <?php 
                            echo ((!empty($persalinan->rujuk_pendamping) && in_array($val, $persalinan->rujuk_pendamping)) ? $ceklis : $unceklis)." ".$label; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                </li>
                <?php /*
                <li>Masalah dalam kehamilan/persalinan ini : <br>
                
                    <ul style="list-style-type: none">
                        <?php 
                        
                        
                        foreach ($masalah_list as $val => $label): ?>
                        <li>
                            <?php 
                            echo (in_array($val, $persalinan->masalah_kehamilan) ? $ceklis : $unceklis)." ".$label; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                </li>
                 * 
                 */ ?>
            </ol>
            <h5>KALA I</h5>
            <ol start="9">
                <?php /* <li>Temuan selama fase laten : <?php echo empty($kala->kala_i_temuanlaten) ? "-" : $kala->kala_i_temuanlaten ?></li> */ ?>
                <li>Partogram melewati garis waspada : 
                    <?php echo ($kala->kala_i_partogram_gariswaspada ? $ceklis : $unceklis)." Ya"; ?>
                    <?php echo ($kala->kala_i_partogram_gariswaspada ? $unceklis : $ceklis)." Tidak"; ?>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_i_masalahlain) ? "-" : $kala->kala_i_masalahlain ?></li>
                <li>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_i_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_i_penatalaksaan_masalah_tsb ?></li>
                <li>Hasil-nya : <?php echo empty($kala->kala_i_hasilnya) ? "-" : $kala->kala_i_hasilnya ?></li>
            </ol>
            <h5>KALA II</h5>
            <ol start="13">
                <li>Episotomi : 
                    <?php echo ($kala->kala_ii_is_episotomi ? $unceklis : $ceklis)." Tidak"; ?>
                    <?php echo ($kala->kala_ii_is_episotomi ? $ceklis : $unceklis)." Ya"; ?>
                    
                    <?php if ($kala->kala_ii_is_episotomi && !empty($kala->kala_ii_episotomo_indikasi)) {
                        echo ", Indikasi : ".$kala->kala_ii_episotomo_indikasi;
                    }
                    ?>
                </li>
                <li>Pendamping pada saat persalinan : <br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_ii_suami ? $ceklis : $unceklis; ?> Suami</li>
                        <li><?php echo $kala->kala_ii_teman ? $ceklis : $unceklis; ?> Teman</li>
                        <li><?php echo $kala->kala_ii_keluarga ? $ceklis : $unceklis; ?> Keluarga</li>
                        <li><?php echo $kala->kala_ii_dukun ? $ceklis : $unceklis; ?> Dukun</li>
                        <li><?php echo $kala->kala_ii_tidak_ada ? $ceklis : $unceklis; ?> Tidak Ada</li>
                    </ul>
                </li>
                <li>Gawat Janin :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_ii_is_gawatjanin ? $ceklis : $unceklis; ?> Ya, tindakan yang dilakukan : 
                            <?php echo ($kala->kala_ii_is_gawatjanin && !empty($kala->kala_ii_gawatjanin_tindakan)) ? $kala->kala_ii_gawatjanin_tindakan : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_ii_is_gawatjanin ? $ceklis : $unceklis; ?> Tidak</li>
                    </ul>
                </li>
                <li>Distosia Bahu :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_ii_is_distosiabahu ? $ceklis : $unceklis; ?> Ya, tindakan kala_ii_is_distosiabahu dilakukan : 
                            <?php echo ($kala->kala_ii_is_distosiabahu && !empty($kala->kala_ii_distosiabahu_tindakan)) ? $kala->kala_ii_distosiabahu_tindakan : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_ii_is_distosiabahu ? $ceklis : $unceklis; ?> Tidak</li>
                    </ul>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_ii_masalahlain) ? "-" : $kala->kala_ii_masalahlain ?></li>
                <li>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_ii_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_ii_penatalaksaan_masalah_tsb ?></li>
                <li>Hasil-nya : <?php echo empty($kala->kala_ii_hasilnya) ? "-" : $kala->kala_ii_hasilnya ?></li>
            </ol>
            <h5>KALA III</h5>
            <ol start="20">
                <li>Lama Kala III : <?php echo empty($kala->kala_iii_lama) ? "-" : $kala->kala_iii_lama ?> menit</li>
                <li>Pemberian Olsitosin 10 U im ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_beri_olsitosin ? $ceklis : $unceklis; ?> Ya, Waktu : 
                            <?php echo ($kala->kala_iii_is_beri_olsitosin && !empty($kala->kala_iii_beri_olsitosin_waktu)) ? $kala->kala_iii_beri_olsitosin_waktu : "-"; ?> menit
                        </li>
                        <li><?php echo !$kala->kala_iii_is_beri_olsitosin ? $ceklis : $unceklis; ?> Tidak, alasan : 
                            <?php echo (!$kala->kala_iii_is_beri_olsitosin && !empty($kala->kala_iii_alasan_tidak_beri_olsitosin)) ? $kala->kala_iii_alasan_tidak_beri_olsitosin : "-"; ?>
                            
                        </li>
                    </ul>
                </li>
                <li>Pemberian ulang Olsitosin (2x) ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_beri_ulang_oksitosin ? $ceklis : $unceklis; ?> Ya, Alasan : 
                            <?php echo ($kala->kala_iii_is_beri_ulang_oksitosin && !empty($kala->kala_iii_beri_ulang_oksitosin_alasan)) ? $kala->kala_iii_beri_ulang_oksitosin_alasan : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_iii_is_beri_ulang_oksitosin ? $ceklis : $unceklis; ?> Tidak</li>
                    </ul>
                </li>
                <li>Penegangan tali pusat terkendali ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_penegangan_tali_pusat ? $ceklis : $unceklis; ?> Ya 
                        </li>
                        <li><?php echo !$kala->kala_iii_is_penegangan_tali_pusat ? $ceklis : $unceklis; ?> Tidak, Alasan : 
                            <?php echo (!$kala->kala_iii_is_penegangan_tali_pusat && !empty($kala->kala_iii_tidak_penegangan_talipusat_alasan)) ? $kala->kala_iii_tidak_penegangan_talipusat_alasan : "-"; ?>
                        </li>
                    </ul>
                </li>
            </ol>
        </td>
        <td width="50%">
            <ol start="24">
                <li>Masase Fundus Uteri ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_masase_fundusuteri ? $ceklis : $unceklis; ?> Ya 
                        </li>
                        <li><?php echo !$kala->kala_iii_is_masase_fundusuteri ? $ceklis : $unceklis; ?> Tidak, Alasan : 
                            <?php echo (!$kala->kala_iii_is_masase_fundusuteri && !empty($kala->kala_iii_masase_fundusuteri_alasantidak)) ? $kala->kala_iii_masase_fundusuteri_alasantidak : "-"; ?>
                        </li>
                    </ul>
                </li>
                <li>Plasenta Lahir Lengkap ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_plasenta_lahirlengkap ? $ceklis : $unceklis; ?> Ya 
                        </li>
                        <li><?php echo !$kala->kala_iii_is_plasenta_lahirlengkap ? $ceklis : $unceklis; ?> Tidak, Tindakan yang dilakukan : 
                            <?php echo (!$kala->kala_iii_is_plasenta_lahirlengkap && !empty($kala->kala_iii_plasenta_lahirlengkap_tidak_ket)) ? $kala->kala_iii_plasenta_lahirlengkap_tidak_ket : "-"; ?>
                        </li>
                    </ul>
                </li>
                <li>Plasenta Tidak Lahir > 30 menit :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_plasenta_tidak_lahirlebih30mnt ? $ceklis : $unceklis; ?> Ya, Tindakan  : 
                            <?php echo ($kala->kala_iii_is_plasenta_tidak_lahirlebih30mnt && !empty($kala->kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket)) ? $kala->kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_iii_is_plasenta_tidak_lahirlebih30mnt ? $ceklis : $unceklis; ?> Tidak 
                        </li>
                    </ul>
                </li>
                <li>Laserasi :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_laserasi ? $ceklis : $unceklis; ?> Ya, Dimana  : 
                            <?php echo ($kala->kala_iii_is_laserasi && !empty($kala->kala_iii_laserasi_ya_dimana)) ? $kala->kala_iii_laserasi_ya_dimana : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_iii_is_laserasi ? $ceklis : $unceklis; ?> Tidak 
                        </li>
                    </ul>
                </li>
                <li>
                    Jika laserasi perineum, derajat : <?php echo !empty($kala->kala_iii_laserasi_perineum_derajat) ? $kala->kala_iii_laserasi_perineum_derajat : "-"; ?><br>
                    Tindakan : <br>
                    <ul style="list-style-type: none;">
                        <li><?php echo (($kala->kala_iii_is_laserasi_perineum_penjahitan && $kala->kala_iii_laserasi_perineum_penjahitan_keterangan == 'tanpa anestesi') ? $ceklis : $unceklis); ?> Penjahitan, tanpa anestesi
                        </li>
                         <li><?php echo (($kala->kala_iii_is_laserasi_perineum_penjahitan && $kala->kala_iii_laserasi_perineum_penjahitan_keterangan == 'dengan anestesi') ? $ceklis : $unceklis); ?> Penjahitan, dengan anestesi
                        </li>
                        <li><?php echo !$kala->kala_iii_is_laserasi_perineum_penjahitan ? $ceklis : $unceklis; ?> Tidak dijahit, alasan : 
                            <?php echo (!$kala->kala_iii_is_laserasi_perineum_penjahitan && !empty($kala->kala_iii_tidak_laserasi_perineum_penjahitan_alasan)) ? $kala->kala_iii_tidak_laserasi_perineum_penjahitan_alasan : "-"; ?>
                        </li>
                    </ul>
                </li>
                <li>Atoni uteri :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_atoni_uteri ? $ceklis : $unceklis; ?> Ya, Tindakan  : 
                            <?php echo ($kala->kala_iii_is_atoni_uteri && !empty($kala->kala_iii_ya_atoni_uteri_tindakan)) ? $kala->kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_iii_is_atoni_uteri ? $ceklis : $unceklis; ?> Tidak 
                        </li>
                    </ul>
                </li>
                <li>Jumlah Pendarahan : <?php echo empty($kala->kala_iii_jumlah_pendarahan) ? "-" : $kala->kala_iii_jumlah_pendarahan ?> ml</li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_iii_masalahlain) ? "-" : $kala->kala_iii_masalahlain ?></li>
                <li>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_iii_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_iii_penatalaksaan_masalah_tsb ?></li>
                <li>Hasil-nya : <?php echo empty($kala->kala_iii_hasilnya) ? "-" : $kala->kala_iii_hasilnya ?></li>
            </ol>
            <h5>BAYI BARU LAHIR</h5>
            <ol start="34">
                <li>Berat Badan : <?php echo empty($kelahiran->bb_gram) ? "-" : $kelahiran->bb_gram ?> gram</li>
                <li>Panjang : <?php echo empty($kelahiran->tb_cm) ? "-" : $kelahiran->tb_cm ?> cm</li>
                <li>Jenis Kelamin : <?php echo empty($kelahiran->jeniskelamin) ? "-" : substr($kelahiran->jeniskelamin, 0, 1) ?></li>
                <li>Penilaian Bayi Baru Lahir : </li>
                <li>Bayi Lahir : <br>
                    <ul style="list-style-type: none;">
                        <li>
                            <?php echo $kelahiran->bayilahir_is_normal ? $ceklis : $unceklis; ?> Normal, tindakan :<br>
                            <?php 
                            $arr_normal = explode("///", $kelahiran->bayilahir_normal_tindakan);
                            $list_normal = LookupM::getItemsUrutan('bayilahirnormal');
                            
                            if (count((array)$list_normal) > 0): ?>
                            <ul style="list-style-type: none">
                                <?php foreach ($list_normal as $val => $label): ?>
                                <li>
                                    <?php echo ((!empty($arr_normal) && in_array($val, $arr_normal)) ? $ceklis : $unceklis)." ".$label; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php echo $kelahiran->bayilahir_is_aspiksia ? $ceklis : $unceklis; ?> Aspiksia ringan/pucat/biru/lemas, tindakan :<br>
                            <?php 
                            $arr_asp = explode("///", $kelahiran->bayilahir_aspiksia_tindakan);
                            $list_asp = LookupM::getItemsUrutan('bayilahiraspiksia');
                            
                            ?>
                            <ul style="list-style-type: none">
                                <?php foreach ($list_asp as $val => $label): ?>
                                <li>
                                    <?php 
                                    echo ((!empty($arr_asp)) && in_array($val, $arr_asp) ? $ceklis : $unceklis)." ".$label;
                                    if ((!empty($arr_asp)) && in_array($val, $arr_asp) && $val == "LAIN - LAIN") {
                                        echo ", ".$kelahiran->bayilahir_aspiksia_ketlainlain;
                                    }
                                    ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <?php echo $kelahiran->bayilahir_is_cacatbawaan ? $ceklis : $unceklis; ?> Cacat Bawaan, sebutkan :
                            <?php
                            echo ($kelahiran->bayilahir_is_cacatbawaan && !empty($kelahiran->bayilahir_cacatbawaan_keterangan)) ? $kelahiran->bayilahir_cacatbawaan_keterangan : "-";
                            ?>
                        </li>
                        <li>
                            <?php echo $kelahiran->bayilahir_is_hiportemi ? $ceklis : $unceklis; ?> Hipotermi, tindakan :
                            <?php
                            echo ($kelahiran->bayilahir_is_hiportemi && !empty($kelahiran->bayilahir_hiportemi_tindakan)) ? $kelahiran->bayilahir_hiportemi_tindakan : "-";
                            ?>
                        </li>
                    </ul>
                
                </li>
                <li>Pemberian ASI<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kelahiran->is_pemberianasi ? $ceklis : $unceklis; ?> Ya, Waktu : 
                            <?php echo ($kelahiran->is_pemberianasi && !empty($kelahiran->waktu_pemberianasi)) ? $kelahiran->waktu_pemberianasi : "-"; ?> Jam
                        </li>
                        <li><?php echo !$kelahiran->is_pemberianasi ? $ceklis : $unceklis; ?> Tidak, alasan : 
                            <?php echo (!$kelahiran->is_pemberianasi && !empty($kelahiran->alasantidak_pemberianasi)) ? $kelahiran->alasantidak_pemberianasi : "-"; ?>
                            
                        </li>
                    </ul>
                </li>
                <?php /*
                <li>Masalah lain, sebutkan : </li>
                <li>Hasil-nya : </li>
                 * 
                 */ ?>
            </ol>
            <?php // var_dump($kelahiran->attributes, $kala->attributes); die; ?>
        </td>
    </tr>
</table>
<h5>PEMANTAUAN PERSALINAN KALA IV</h5>
<table class="tab_detail">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Tekanan Darah</th>
            <th>Nadi</th>
            <th>Suhu</th>
            <th>Tinggi Fundus Uteri</th>
            <th>Kontraksi Uterus</th>
            <th>Kandung Kemih</th>
            <th>Pendarahan</th>
        </tr>
    </thead>
    <tbody id="tab_pemantauan_kalaiv">
        <?php
        $det = PemantauankalaivT::model()->findAllByAttributes(array(
            'pemeriksaankala_id'=>$kala->pemeriksaankala_id,
        ), array(
            'order'=>'waktu',
        ));

        foreach ($det as $idx=>$item) {
            $item->waktu = MyFormatter::formatDateTimeForUser($item->waktu);
            $item->suhu = number_format($item->suhu, 2, ",", "");
            ?>
        <tr>
            <td><?php echo $item->waktu; ?></td>
            <td><?php echo (empty($item->systolic) ? "-" : $item->systolic)."/".(empty($item->diastolic) ? "-" : $item->diastolic); ?></td>
            <td><?php echo (empty($item->nadi) ? "-" : $item->nadi); ?></td>
            <td><?php echo (empty($item->suhu) ? "-" : $item->suhu); ?></td>
            <td><?php echo (empty($item->tinggi_fundus_uteri) ? "-" : $item->tinggi_fundus_uteri); ?></td>
            <td><?php echo (empty($item->kontraksi_uterus) ? "-" : $item->kontraksi_uterus); ?></td>
            <td><?php echo (empty($item->kantung_kemih) ? "-" : $item->kantung_kemih); ?></td>
            <td><?php echo (empty($item->darah_yang_keluar) ? "-" : $item->darah_yang_keluar); ?></td>
        </tr>
        
        <?php
        }

        ?>
    </tbody>
</table>
<ul style="list-style-type: none;">
    <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_iv_masalah_lain) ? "-" : $kala->kala_iv_masalah_lain ?></li>
    <li>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_iv_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_iv_penatalaksaan_masalah_tsb ?></li>
    <li>Hasil-nya : <?php echo empty($kala->kala_iv_hasilnya) ? "-" : $kala->kala_iv_hasilnya ?></li>
</ul>
