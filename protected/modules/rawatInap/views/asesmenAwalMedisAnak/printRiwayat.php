<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
* @version     2.0.0
* @digunakan   - digunakan untuk menampilkan detail rincian
* RSST-2176
*/

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
if (isset($_GET['caraPrint'])){
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10));  
}
?>
<style>
    i{
        font-size: 15px !important;
        margin-top: 3px;        
        padding-right:5px;
    }
   
</style>

<table class="table noborder paddingtext2">
    <tr>
        <th>Tanggal dan Jam Masuk Ruangan</th>
        <td><?php !empty($model->tglmasuk_rs)?MyFormatter::formatDateTimeForUser($model->tglmasuk_rs):''; ?></td>
        <td>&nbsp;</td>
        <th>Alasan Dirawat</th>
        <td>
            <div class="col-sm-6">
                <?php 
                    $icon = ($model->alasandirawat_observasi)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                    echo '<i class="'.$icon.'"></i>Observasi';                    
                ?>
            </div>
            
            <div class="col-sm-6">
                <?php 
                    $icon = ($model->alasandirawat_prosesdiagnostik)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                    echo '<i class="'.$icon.'"></i>Proses Diagnostik';                    
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <th>Waktu Pemeriksaan</th>
        <td><?php echo MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan); ?></td>
        <td>&nbsp;</td>
        <td></td>
        <td>
            <div class="col-sm-6">
                <?php                     
                    $icon = ($model->alasandirawat_terapi)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                    echo '<i class="'.$icon.'"></i>Terapi';
                ?>
            </div>
            
            <div class="col-sm-6">
                <?php                     
                    $icon = ($model->alasandirawat_rehabilitasi)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                    echo '<i class="'.$icon.'"></i>Rehabilitasi Medis';
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <th>Cara Masuk</th>
        <td>
            <?php  
                if ($model->pasiendari_irj){
                    echo "IRJ";
                }elseif($model->pasiendari_igd){
                    echo "IGD";
                }elseif($model->pasiendari_rujukan){
                    echo "Rujukan";
                }elseif($model->pasiendari_lainnya){
                    echo $model->pasiendari_lainnya_keterangan;
                }

            ?>
        </td>
        <td>&nbsp;</td>
        <td><b>Keluhan Utama</b></td>
        <td rowspan="2">
            <?php echo $model->keluhan_utama; ?>
        </td>
    </tr>
    <tr>
        <th>Diagnosa Masuk RS</th>
        <td><?php echo !empty($model->diagnosa_id)?$model->diagnosa->diagnosa_nama:''; ?></td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
    </tr>
</table>

<div class="panel panel-darkk">
    <span class="group-title">
        <b>Riwayat Pasien</b>
    </span>
    <div class="panel-body">
        <table class="table noborder paddingtext2">
            <tr>
                <th>Riwayat Penyakit Sekarang</th>
                <td><?php echo $model->riwayat_penyakit_sekarang; ?></td>
                <td>&nbsp;</td>
                <th>Status Psikososial</th>
                <td>
                    <div class="col-sm-12">
                        <?php                     
                            $icon = ($model->status_psikososial_pakai_napza)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Pernah Menggunakan NAPZA';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->status_psikososial_cobabunuhdiri)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Percobaan Bunuh Diri';
                        ?>
                    </div>
                </td>
            </tr>            
            <tr>
                <th>Riwayat Penyakit Dahulu</th>
                <td>
                    <div class="col-sm-4">
                        <?php                     
                            $icon = ($model->riwayat_sakit_dulu_diabetes)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Diabetes';
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            $icon = ($model->riwayat_sakit_dulu_hipertensi)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Hipertensi';
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            $icon = ($model->riwayat_sakit_dulu_jantung)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Penyakit Jantung';
                        ?>
                    </div>
                </td>
                <td>&nbsp;</td>
                <th></th>
                <td>
                    <div class="col-sm-12">
                        <?php                     
                            $icon = ($model->status_psikososial_kdrt)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>KDRT';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->status_psikososial_agresif)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Agresif';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->status_psikososial_tidakkooperatif)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Kooperatif';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <div class="col-sm-4">
                        <?php                     
                            $icon = ($model->riwayat_sakit_dulu_tidakada)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Ada';
                        ?>
                    </div>
                    <div class="col-sm-8">
                        <?php
                            $icon = ($model->riwayat_sakit_dulu_lainnya)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Lainnya : '.$model->riwayat_sakit_dulu_lainnya_ket;
                        ?>
                    </div>                    
                </td>
                <td>&nbsp;</td>
                <th>Status Fungsional</th>
                <td>
                    <div class="col-sm-12">
                        <?php                     
                            $icon = ($model->statusfungsional_mandiri)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Mandiri';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->statusfungsional_tirahbaringparsial)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tirah Baring Parsial';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->statusfungsional_tirahbaringtotal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tirah Baring Total';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Riwayat Penyakit Keluarga</th>
                <td>
                    <div class="col-sm-4">
                        <?php                     
                            $icon = ($model->riwayat_sakit_keluarga_diabetes)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Diabetes';
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            $icon = ($model->riwayat_sakit_keluarga_hipertensi)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Hipertensi';
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?php
                            $icon = ($model->riwayat_sakit_keluarga_jantung)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Penyakit Jantung';
                        ?>
                    </div>
                </td>
                <td>&nbsp;</td>
                <th></th>
                <td>
                   
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <div class="col-sm-4">
                        <?php                     
                            $icon = ($model->riwayat_sakit_keluarga_tidakada)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Ada'; 
                        ?>
                    </div>
                    <div class="col-sm-8">
                        <?php
                            $icon = ($model->riwayat_sakit_keluarga_lainnya)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Lainnya : '.$model->riwayat_sakit_keluarga_lainnya_ket;
                        ?>
                    </div>                    
                </td>
                <td>&nbsp;</td>
                <th></th>
                <td>
                   
                </td>
            </tr>
            <tr>
                <th>Alergi</th>
                <td>
                    <div class="col-sm-12">
                        <?php                     
                            $icon = ($model->riwayatalergi_obat)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Alergi Obat : '.$model->riwayatalergi_obatket;
                        ?>
                    </div>                    
                </td>
                <td>&nbsp;</td>
                <th></th>
                <td>
                   
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <div class="col-sm-12">
                        <?php                     
                            $icon = ($model->riwayatalergi_makanan)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Alergi Makanan : '.$model->riwayatalergi_makananket;
                        ?>
                    </div>                    
                </td>
                <td>&nbsp;</td>
                <th></th>
                <td>
                   
                </td>
            </tr>
        </table>
    </div>
</div>
<p>&nbsp;</p>
<div class="panel panel-darkk">
    <span class="group-title">
        <b>Riwayat Pengobatan Sebelumnya</b>
    </span>
    <div class="panel-body">
        <table class="table border paddingtext2">
            <tr>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Cara Pemakaian</th>
                <th>Waktu/Tanggal Pemberian</th>
            </tr>
            <?php
                if (!empty($modObat)){
                    foreach($modObat as $o){
            ?>
                <tr>
                    <td><?php echo $o->nama_obat; ?></td>
                    <td><?php echo $o->dosis_obat; ?></td>
                    <td><?php echo $o->carapemberian; ?></td>
                    <td><?php echo !empty($o->tglpemberian)? MyFormatter::formatDateTimeForUser($o->tglpemberian):''; ?></td>
                </tr>
            <?php
                    }
                }
            ?>
        </table>
    </div>
</div>
<p>&nbsp;</p>
<div class="panel panel-darkk">
    <span class="group-title">
        <b>Pemeriksaan Umum</b>
    </span>
    <div class="panel-body">
        <table class="table noborder paddingtext2">
            <tr>
                <th>Kesadaran Kualitatif</th>
                <td><?php                 
                    if (!empty($model->kesadarankualitatif_composmentis)){
                        echo 'Composmentis';
                    }elseif (!empty($model->kesadarankualitatif_composmentis)){
                        echo 'Apatis';
                    }elseif (!empty($model->kesadarankualitatif_delirum)){
                        echo 'Delirum';
                    }elseif (!empty($model->kesadarankualitatif_koma)){
                        echo 'Koma';
                    }                              
                ?></td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Kesadaran Kualitatif Skala Koma Glasgow</th>
                <td><?php                 
                    echo 'E : '.$model->kesadarankuantitatif_gcs_eye;
                    echo '&nbsp;&nbsp;&nbsp;';
                    echo 'V : '.$model->kesadarankuantitatif_gcs_verbal;
                    echo '&nbsp;&nbsp;&nbsp;';
                    echo 'M : '.$model->kesadarankuantitatif_gcs_motorik;
                ?></td>
                <td>&nbsp;</td>
                <th>Kepala</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->kepala_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->kepala_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->kepala_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Berat Badan</th>
                <td class="numbers-only"><?php                 
                    echo (!empty($model->beratbadan)?$model->beratbadan.' Kg':'');
                ?></td>
                <td>&nbsp;</td>
                <th>THT</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->tht_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->tht_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->tht_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Tinggi Badan</th>
                <td class="numbers-only"><?php                 
                    echo (!empty($model->tinggibadan)?$model->tinggibadan.' cm':'');
                ?></td>
                <td>&nbsp;</td>
                <th>Leher</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->leher_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->leher_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->leher_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Luas Badan</th>
                <td class="numbers-only"><?php                 
                    echo (!empty($model->luasbadan)?$model->luasbadan.' kg/m<sup>2</sup>':'');
                ?></td>
                <td>&nbsp;</td>
                <th>Mulut</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->mulut_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->mulut_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->mulut_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>BMI</th>
                <td class="numbers-only"><?php                 
                    echo $model->nilai_bmi;
                    echo '&nbsp;&nbsp;&nbsp;';
                    echo !empty($model->bodymassindex_id)?$model->bodymassaindex->bmi_defenisi:'';
                ?></td>
                <td>&nbsp;</td>
                <th>Jantung & Pembuluh Darah</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->jantung_pb_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->jantung_pb_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->jantung_pb_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Kondisi Khusus</th>
                <td class="numbers-only"><?php                 
                    if ($model->kondisikhusus_normal){
                        echo 'Normal';
                    }elseif($model->kondisikhusus_anemis){
                        echo 'Anemis';
                    }elseif($model->kondisikhusus_icterus){
                        echo 'Icterus';
                    }elseif($model->kondisikhusus_sianosis){
                        echo 'Sianosis';
                    }elseif($model->kondisikhusus_lainnya){
                        echo 'Lainnya : '.$model->kondisikhusus_lainnya_ket;
                    }                    
                ?></td>
                <td>&nbsp;</td>
                <th>Thorax, Paru - Paru, Payudara</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->thorax_paru_payudara_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->thorax_paru_payudara_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->thorax_paru_payudara_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Tekanan Darah</th>
                <td class="numbers-only"><?php                 
                    if (!empty($model->tekanandarah_sistolok) && !empty($model->tekanandarah_diastolik)){
                        echo $model->tekanandarah_sistolok.'/'.$model->tekanandarah_diastolik.' mmHg';
                    }
                ?></td>
                <td>&nbsp;</td>
                <th>Abdomen</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->abdomen_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->abdomen_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->abdomen_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Nadi</th>
                <td class="numbers-only"><?php                 
                    if (!empty($model->nadi)){
                        echo $model->nadi.' x/mnt';
                    }
                ?></td>
                <td>&nbsp;</td>
                <th>Kulit dan Sistem Limfatik</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->kulit_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->kulit_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->kulit_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Pernapasan</th>
                <td class="numbers-only"><?php                 
                    if (!empty($model->pernafasan)){
                        echo $model->pernafasan.' x/mnt';
                    }
                ?></td>
                <td>&nbsp;</td>
                <th>Tulang Belakang dan Anggota Tubuh</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->tulang_anggotatubuh_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->tulang_anggotatubuh_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->tulang_anggotatubuh_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Suhu</th>
                <td class="numbers-only"><?php                 
                    if (!empty($model->suhu)){
                        echo $model->suhu.' <sup>o</sup>C (Aksiler/Rectal)';
                    }
                ?></td>
                <td>&nbsp;</td>
                <th>Sistem Saraf</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->sistemsaraf_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->sistemsaraf_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->sistemsaraf_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Nyeri</th>
                <td>
                    <div class="col-sm-6">
                    <?php
                        $icon = ($model->nyeri_ada)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Ya';
                    ?>
                    </div>
                     <div class="col-sm-6">
                    <?php
                        $icon = ($model->nyeri_tidakada)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak';
                    ?>
                    </div>
                </td>
                <td>&nbsp;</td>
                <th>genitalia, Anus dan Rektum</th>
                <td>
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->genitalia_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Normal';
                    ?>
                    </div>
                    
                    <div class="col-sm-12">
                    <?php
                        $icon = ($model->genitalia_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                        echo '<i class="'.$icon.'"></i>Tidak Normal : <br/>'.$model->genitalia_tidaknormal_ket;
                    ?>
                    </div>
                </td>
            </tr>
            
        </table>
    </div>
</div>
<p>&nbsp;</p>
<div class="panel panel-darkk">
    <span class="group-title">
        <b>Pemeriksaan Penunjang Pre Rawat Inap</b>
    </span>
    <div class="panel-body">
        <table class="table noborder paddingtext2">
            <tr>
                <th>Laboratorium</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->laboratorium_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->laboratorium_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->laboratorium_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Radiologi</th>
                <td>
                   
                </td>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. Thorax Foto</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->radiologi_thorax_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->radiologi_thorax_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->radiologi_thorax_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. Thorax Foto</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->radiologi_thorax_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->radiologi_thorax_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->radiologi_thorax_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. CT Scan</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->radiologi_ctscan_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->radiologi_ctscan_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->radiologi_ctscan_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. MRI</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->radiologi_mri_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->radiologi_mri_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->radiologi_mri_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>            
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4. USG</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            $icon = ($model->radiologi_usg_normal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Normal';
                            echo '&nbsp;&nbsp;&nbsp;';
                            $icon = ($model->radiologi_usg_tidaknormal)?MyIcon::getIcons('checkbox-cek'):MyIcon::getIcons('checkbox');
                            echo '<i class="'.$icon.'"></i>Tidak Normal : '.$model->radiologi_usg_tidaknormal_ket;                            
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5. Lain - Lain</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            echo $model->radiologi;
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Diagnosis Awal</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            echo $model->diagnosisawal;
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Diagnosis Banding</th>
                <td>
                    <div class="col-sm-12">
                        <?php
                            echo $model->diagnosisbanding;
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<table class="table noborder paddingtext2">
    <tr>
        <th>Mengetahui</th>
    </tr>
     <tr>
        <th>Dokter Pemeriksa</th>
        <td>
            <?php 
                $ppds = PpdsM::model()->findByPk($model->ppds_id);
                echo !empty($ppds->ppds_nama) ? $ppds->ppds_nama : ""; 
            ?>
        </td>
        <td>&nbsp;</td>
        <th>DPJP</th>
        <td>
            <?php
                if (!empty($model->dokterdpjp_id)){
                    echo $model->dokterdpjp->namaLengkap;
                }
            ?>
        </td>
    </tr>
</table>

<?php
    if (!isset($_GET['caraPrint'])){
        if (isset($dari)){
            echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('data-placement'=>'right','rel'=>'tooltip','title'=>'Klik untuk mencetak data via browser','class'=>'btn btn-info','onclick'=>"print(".$model->asesmen_awal_medis_id.",'PRINT')"));
        }
    }
?>

<script>
    function print(id,caraPrint){
        window.open('<?php echo $this->createUrl('/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/lihatRiwayat',array('id'=>$model->asesmen_awal_medis_id)); ?>&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
</script>
