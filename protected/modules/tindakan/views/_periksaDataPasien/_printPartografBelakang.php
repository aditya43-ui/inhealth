<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$modKonfig = KonfigsystemK::model()->find();

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

    .tab_header > tbody > tr > td {
        padding: 5px;
    }
    
    .tab_header_border {
        border: 1px solid black;
    }
    .textcoret {
        text-decoration: line-through;
    }
</style>

<table width="100%" class='tab_header'>
    <tbody>
        <tr>
            <td width="35%" class="tab_header_border">
                <table> 
                    <tr>
                        <td align="center">
                            <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 140px"/></div>
                        </td>
                        <td width="150">
                            <?php echo $modKonfig->headerprintout_erm; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="30%" class="tab_header_border">
                <center>
                    <h3>CATATAN PERSALINAN</h3>
                </center>
            </td>
            <td width="35%" class="tab_header_border" valign="top">
                <table class="tab_header">
                    <tr>
                        <td width="100px">No. RM</td>
                        <td>
                            : <?php echo $pasien->no_rekam_medik; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>
                            : <?php echo $pasien->namadepan." ".$pasien->nama_pasien; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>
                            : <?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>
                            : <?php echo $pasien->no_identitas_pasien; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<table width="100%" class="tab_list">
    <tr>
        <td width="50%">
            <ol>
                <li>Tanggal : <?php echo MyFormatter::formatDateTimeForUser($persalinan->create_time); ?></li>
                <li>Nama Penolong : <?php echo (empty($persalinan->pegawai) ? "-" : $persalinan->pegawai->nama_pegawai." (Dokter)").(empty($persalinan->bidan) ? "" : ", ".$persalinan->bidan->nama_pegawai." (Bidan)"); ?></li>
                <li>Tempat Persalinan : <br>
                    <table style="margin-left: 20px;">
                    <?php
                        if(!empty($lokasi_list)){
                            $htmlTempat = "";
                            $indexTempat = 0;
                            foreach($lokasi_list as $val => $label){
                                $isTempat = false;
                                if(!empty($persalinan->lokasi_persalinan) > 0){
                                    foreach ($persalinan->lokasi_persalinan as $oriLokasi) {
                                        if($oriLokasi == $val){
                                            $isTempat = true;
                                        }
                                    }
                                }

                                $indexTempat++;
                                if($indexTempat == 1){
                                    $htmlTempat .= "<tr>";
                                }
                                $htmlTempat .= "<td width='150px'>";
                                $htmlTempat .= "<span class='".(($isTempat==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$label;
                                $htmlTempat .= "</td>";
                                
                                if($indexTempat == 2){
                                    $htmlTempat .= "</tr>";
                                    $indexTempat = 0;
                                }
                            }
                            echo $htmlTempat;
                        }
                    ?>
                    </table>
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
                    <table style="margin-left: 20px;">
                    <?php
                        if(!empty($pendamping_list)){
                            $htmlPendamping = "";
                            $indexPendamping = 0;
                            foreach($pendamping_list as $val => $label){
                                $isPendamping = false;
                                if(!empty($persalinan->rujuk_pendamping) > 0){
                                    foreach ($persalinan->rujuk_pendamping as $oriPendamping) {
                                        if($oriPendamping == $val){
                                            $isPendamping = true;
                                        }
                                    }
                                }

                                $indexPendamping++;
                                if($indexPendamping == 1){
                                    $htmlPendamping .= "<tr>";
                                }
                                $htmlPendamping .= "<td width='150px'>";
                                $htmlPendamping .= "<span class='".(($isPendamping==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$label;
                                $htmlPendamping .= "</td>";
                                
                                if($indexPendamping == 2){
                                    $htmlPendamping .= "</tr>";
                                    $indexPendamping = 0;
                                }
                            }
                            echo $htmlPendamping;
                        }
                    ?>
                    </table>
                </li>
                <li>Masalah dalam kehamilan/ persalinan ini : <br>
                    <table  style="margin-left: 20px;">
                        <?php
                            $lookup_penyunting = LookupM::model()->findAllByAttributes(array('lookup_type'=>'penyulit_kehamilan_persalinan'),array('condition'=>"lookup_value <> 'Lainnya' ",'order'=>'lookup_urutan ASC'));
                            $html_penyunting = "";

                            if(!empty($lookup_penyunting)){
                            $ind_penyuting = 1;
                            foreach($lookup_penyunting as $i => $look){
                                $ischeck = false;
                                $ind_penyuting++;    
                                if(!empty($persalinan->penyulit_kehamilan_persalinan)){
                                    $oriPenyunting = json_decode($persalinan->penyulit_kehamilan_persalinan);
                                    
                                    foreach ($oriPenyunting as $ori_data) {
                                        if($ori_data->penyulit == $look->lookup_value){
                                            $ischeck = true;
                                        }
                                    }
                                }
                                if($ind_penyuting == 1){
                                    $html_penyunting .= '<tr>';
                                }
                                $html_penyunting .= "<td width='150px'>";
                                $html_penyunting .= "<span class='".(($ischeck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                                $html_penyunting .= "</td>";

                                if($ind_penyuting == 2){
                                    $html_penyunting .= '<tr>';
                                    $ind_penyuting = 0;
                                }
                               
                            }
                        }
                            $lookup_penyuntinglain = LookupM::model()->findAllByAttributes(array('lookup_type'=>'penyulit_kehamilan_persalinan'),array('condition'=>"lookup_value = 'Lainnya' ",'order'=>'lookup_urutan ASC'));

                            if(!empty($lookup_penyuntinglain)){
                                $index_urut = 0;
                                foreach($lookup_penyuntinglain as $i => $look){
                                    $ischeck = false;
                                    $ket = "";
    
                                    if(!empty($persalinan->penyulit_kehamilan_persalinan)){
                                        $oriPenyunting = json_decode($persalinan->penyulit_kehamilan_persalinan);
                                        foreach ($oriPenyunting as $ori_data) {
                                            if($ori_data->penyulit == $look->lookup_value){
                                                $ischeck = true;
                                                $ket = $ori_data->keterangan;
                                            }
                                        }
                                    }
                                    $html_penyunting .= '<tr>';
                                    $html_penyunting .= '<td colspan="2">';
                                    $html_penyunting .= "<span class='".(($ischeck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                                    $html_penyunting .= "<span style='padding-left: 20px'></span>".$ket;
    
                                    $html_penyunting .= '</td>';
                                    $html_penyunting .= '</tr>';
                                    $index_urut++;
                                }
                            }

                                echo $html_penyunting;
                        ?>
                    </table>
                </li>
                <li>Prevention Mother To Child Transmission : <?php echo $persalinan->pmtct; ?>
                </li>
            </ol>
            <h5>KALA I</h5>
            <ol start="11">
                <li>Temuan selama fase laten : <?php echo empty($kala->kala_i_temuanlaten) ? "-" : $kala->kala_i_temuanlaten ?></li>
                <li>Partogram melewati garis waspada : 
                    <?php echo ($kala->kala_i_partogram_gariswaspada ? $ceklis : $unceklis)." Ya"; ?>
                    <?php echo ($kala->kala_i_partogram_gariswaspada ? $unceklis : $ceklis)." Tidak"; ?>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_i_masalahlain) ? "-" : $kala->kala_i_masalahlain ?></li>
                <li>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_i_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_i_penatalaksaan_masalah_tsb ?></li>
                <li>Hasil-nya : <?php echo empty($kala->kala_i_hasilnya) ? "-" : $kala->kala_i_hasilnya ?></li>
            </ol>
            <h5>KALA II</h5>
            <ol start="16">
                <li>Episiotomy :
                    <span class="<?php echo (($kala->kala_ii_is_episotomi == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                    <br/>
                    <span style="padding-left: 96px;" class="<?php echo (($kala->kala_ii_is_episotomi == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya

                    <?php if ($kala->kala_ii_is_episotomi && !empty($kala->kala_ii_episotomo_indikasi)) {
                        echo ", Indikasi : ".$kala->kala_ii_episotomo_indikasi;
                    }
                    ?>
                </li>
                <li>Pendamping pada saat persalinan : <br>
                <table style="margin-left: 20px;">
                    <tr>
                        <td width='150px'>
                            <span class="<?php echo (($kala->kala_ii_suami == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Suami
                        </td>
                        <td width='150px'>
                            <span class="<?php echo (($kala->kala_ii_dukun == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Dukun    
                        </td>
                    </tr>
                    <tr>
                        <td width='150px'>
                            <span class="<?php echo (($kala->kala_ii_teman == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Teman
                        </td>
                        <td width='150px'>
                            <span class="<?php echo (($kala->kala_ii_tidak_ada == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                        </td>
                    </tr>
                    <tr>
                        <td width='150px'>
                            <span class="<?php echo (($kala->kala_ii_keluarga == true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Keluarga
                        </td>
                    </tr>
                </table>
                </li>
                <li>Gawat Janin :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_ii_is_gawatjanin ? $ceklis : $unceklis; ?> Ya, tindakan yang dilakukan : 
                            <?php echo ($kala->kala_ii_is_gawatjanin && !empty($kala->kala_ii_gawatjanin_tindakan)) ? $kala->kala_ii_gawatjanin_tindakan : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_ii_is_gawatjanin ? $ceklis : $unceklis; ?> Tidak</li>
                        <li><?php echo $kala->kala_ii_isperiksadjj ? $ceklis : $unceklis; ?> Pemantauan DJJ setiap 5-10 menit selama Kala II <br/> Hasilnya : <?php $kala->kala_ii_hasilpemantauandjj; ?></li>
                    </ul>
                </li>
                <li>Distorsia Bahu :<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_ii_is_distosiabahu ? $ceklis : $unceklis; ?> Ya, tindakan yang dilakukan : 
                            <?php echo ($kala->kala_ii_is_distosiabahu && !empty($kala->kala_ii_distosiabahu_tindakan)) ? $kala->kala_ii_distosiabahu_tindakan : "-"; ?>
                        </li>
                        <li><?php echo !$kala->kala_ii_is_distosiabahu ? $ceklis : $unceklis; ?> Tidak</li>
                    </ul>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_ii_masalahlain) ? "-" : $kala->kala_ii_masalahlain ?>
                    <br/><span style="padding-left: 22px;"></span>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_ii_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_ii_penatalaksaan_masalah_tsb ?>
                    <br/><span style="padding-left: 22px;"></span>Hasil-nya : <?php echo empty($kala->kala_ii_hasilnya) ? "-" : $kala->kala_ii_hasilnya ?>
                </li>
            </ol>
            <h5>KALA III</h5>
            <ol start="21">
                <li>Inisiasi Menyusui Dini : <br> 
                    <ul style="list-style-type: none;">
                        <li><?php echo ($kala->kala_iii_isimd == 'Ya') ? $ceklis : $unceklis; ?> Ya 
                        </li>
                        <li><?php echo ($kala->kala_iii_isimd == 'Tidak') ? $ceklis : $unceklis; ?> Tidak, alasan : <?php echo (!empty($kala->kala_iii_alasantidak_imd)? $kala->kala_iii_alasantidak_imd:"-") ?> </li>
                    </ul>
                </li>
                <li>Lama Kala III : <?php echo empty($kala->kala_iii_lama) ? "-" : $kala->kala_iii_lama ?> menit</li>
                <li>Pemberian Oksitosin 10 U im ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_beri_olsitosin ? $ceklis : $unceklis; ?> Ya, Waktu : 
                            <?php echo ($kala->kala_iii_is_beri_olsitosin && !empty($kala->kala_iii_beri_olsitosin_waktu)) ? $kala->kala_iii_beri_olsitosin_waktu : "-"; ?> menit sesudah persalinan
                        </li>
                        <li><?php echo !$kala->kala_iii_is_beri_olsitosin ? $ceklis : $unceklis; ?> Tidak, alasan : 
                            <?php echo (!$kala->kala_iii_is_beri_olsitosin && !empty($kala->kala_iii_alasan_tidak_beri_olsitosin)) ? $kala->kala_iii_alasan_tidak_beri_olsitosin : "-"; ?>
                            
                        </li>
                        <li>
                        Penjepitan tali pusar <?php echo (!empty($kala->kala_iii_penjepitaltalipusar)? $kala->kala_iii_penjepitaltalipusar:"-") ?> menit setelah bayi lahir
                        </li>
                    </ul>
                </li>
                <li>Pemberian ulang Oksitosin (2x) ?<br>
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
            <ol start="26">
                <li>Masase Fundus Uteri ?<br>
                    <ul style="list-style-type: none;">
                        <li><?php echo $kala->kala_iii_is_masase_fundusuteri ? $ceklis : $unceklis; ?> Ya 
                        </li>
                        <li><?php echo !$kala->kala_iii_is_masase_fundusuteri ? $ceklis : $unceklis; ?> Tidak, Alasan : 
                            <?php echo (!$kala->kala_iii_is_masase_fundusuteri && !empty($kala->kala_iii_masase_fundusuteri_alasantidak)) ? $kala->kala_iii_masase_fundusuteri_alasantidak : "-"; ?>
                        </li>
                    </ul>
                </li>
                <li>Plasenta Lahir Lengkap  (Intact) ?
                     <?php echo $kala->kala_iii_is_plasenta_lahirlengkap ? $ceklis : $unceklis; ?> Ya 
                    <?php echo !$kala->kala_iii_is_plasenta_lahirlengkap ? $ceklis : $unceklis; ?> Tidak
                    <ul style="list-style-type: none;">
                        <li>
                            
                        </li>
                        <li>Jika tidak lengkap, tindakan yang dilakukan : 
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
                <li>
                    PMTCT (Prevention Mother to Child Transmissin): <br>
                    <ul style="list-style-type: none;">
                        <li><?php echo (($kala->kala_iii_pmtct == 'Ya') ? $ceklis : $unceklis); ?> Ya
                            
                        </li>
                        <li><?php echo (($kala->kala_iii_pmtct == 'Tidak') ? $ceklis : $unceklis); ?> Tidak 
                            , Alasan : <?php echo (!empty($kala->kala_iii_isalasantindakpmtct)) ? $kala->kala_iii_isalasantindakpmtct : "-"; ?>
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
            <h5>KALA IV</h5>
            <ol start="37">
                <li>Kondisi Ibu :<br>
                    <table style="margin-left: 20px;">
                        <tr>
                            <td width='150px'>
                                KU : <?php echo $kala->kala_iv_keadaanumum; ?>
                            </td>
                            <td width='150px'>
                                Nadi : <?php echo $periksaFisik->kala4_detaknadi; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width='150px'>
                                TD : <?php echo $periksaFisik->kala4_systolic.'/'.$periksaFisik->kala4_diastolic; ?> mmHg
                            </td>
                            <td width='150px'>
                                Pernapasan : <?php echo $periksaFisik->kala4_pernapasan; ?>
                            </td>
                        </tr>
                    </table>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kala->kala_iv_masalah_lain) ? "-" : $kala->kala_iv_masalah_lain ?>
                    <br/><span style="padding-left: 22px;"></span>Penatalaksanaan masalah Tsb. : <?php echo empty($kala->kala_iv_penatalaksaan_masalah_tsb) ? "-" : $kala->kala_iv_penatalaksaan_masalah_tsb ?>
                    <br/><span style="padding-left: 22px;"></span>Hasil-nya : <?php echo empty($kala->kala_iv_hasilnya) ? "-" : $kala->kala_iv_hasilnya ?>
                </li>
            </ol>
            <h5>BAYI BARU LAHIR</h5>
            <ol start="39">
                <li>Berat Badan : <?php echo empty($kelahiran->bb_gram) ? "-" : $kelahiran->bb_gram ?> gram</li>
                <li>Panjang Badan : <?php echo empty($kelahiran->tb_cm) ? "-" : $kelahiran->tb_cm ?> cm</li>
                <li>Jenis Kelamin : <?php echo empty($kelahiran->jeniskelamin) ? "-" : substr($kelahiran->jeniskelamin, 0, 1) ?></li>
                <li>Penilaian Bayi Baru Lahir : <?php echo $kelahiran->penilaianbayi_barulahir; ?></li>
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
                            <?php echo $kelahiran->bayilahir_is_aspiksia ? $ceklis : $unceklis; ?> Aspiksia <span class="<?php echo (($kelahiran->tingkat_aspiksia == 'ringan')? "textcoret":""); ?>">ringan</span>/<span class="<?php echo (($kelahiran->tingkat_aspiksia == 'pucat')? "textcoret":""); ?>">pucat</span>/<span class="<?php echo (($kelahiran->tingkat_aspiksia=='biru')? "textcoret":""); ?>">biru</span>/<span class="<?php echo (($kelahiran->tingkat_aspiksia == 'lemas')? "textcoret":""); ?>">lemas</span>, tindakan :<br>
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
                            <?php echo ($kelahiran->is_pemberianasi && !empty($kelahiran->waktu_pemberianasi)) ? $kelahiran->waktu_pemberianasi : "-"; ?> Jam setelah lahir
                        </li>
                        <li><?php echo !$kelahiran->is_pemberianasi ? $ceklis : $unceklis; ?> Tidak, alasan : 
                            <?php echo (!$kelahiran->is_pemberianasi && !empty($kelahiran->alasantidak_pemberianasi)) ? $kelahiran->alasantidak_pemberianasi : "-"; ?>
                            
                        </li>
                    </ul>
                </li>
                <li>Masalah lain, sebutkan : <?php echo empty($kelahiran->masalah_lain) ? "-" : $kelahiran->masalah_lain ?>
                    <br/><span style="padding-left: 22px;"></span>Penatalaksanaan masalah Tsb. : <?php echo empty($kelahiran->penatalaksanaan_masalahlain) ? "-" : $kelahiran->penatalaksanaan_masalahlain ?>
                    <br/><span style="padding-left: 22px;"></span>Hasil-nya : <?php echo empty($kelahiran->hasilpenatalaksanaan_masalahlain) ? "-" : $kelahiran->hasilpenatalaksanaan_masalahlain ?>
                </li>
            </ol>
        </td>
    </tr>
</table>
<h5><u>PEMANTAUAN KALA IV</u></h5>
<table class="tab_detail">
    <thead>
        <tr>
            <th>Jam ke-</th>
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
            <td><?php echo $item->jam_ke; ?></td>
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
