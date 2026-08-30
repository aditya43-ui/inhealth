<style>
    
    table td {
        vertical-align: top;
        border-collapse: collapse;
    }
    
    body {
        color: black;
    }
    
    #judul {
        display: inline-block;
    }
    #no_erm {
        float: right;
    }
    
    .main_panel {
        border: 1px solid black;
        margin-bottom: 5px;
    }
    
    .main_judul {
        font-weight: bold;
        padding: 5px;
        border-bottom: 1px solid black;
    }
    
    .main_body {
        padding: 5px;
    }
    
    .border td, .border th {
        border: 1px solid black;
        padding: 3px;
    }
    
    .border th {
        font-weight: bold;
    }
    
    .ttd_box {
        width: 200px;
        height: 100px;
        border: 1px solid black;
        display: inline-block;
    }
    
    .main_isi {
        padding: 5px;
    }

    .judul_table{
        padding: 5px;
        text-align: center;
    }

    .center{
        text-align:center;
    }


</style>


<div>
    <b><p>SKALA RESIKO JATUH HUMPTY DUMPTY UNTUK PASIEN ANAK (<13 TAHUN)</p></b>
    <div style="clear:both;"></div>

</div>

<div class="panel_halaman">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pengkajian Skor Resiko Jatuh</div>
        </div>
        <div class="panel-body">
            <table width="100%" >
                <tr>
                    <td width="8%">Tanggal Pendaftaran/ <br>No.Pendaftaran</td>
                    <td width="1%">:</td>
                    <td width="49%"><?= MyFormatter::formatdatetimeforUser($modPendaftaran->tgl_pendaftaran)." / ".$modPendaftaran->no_pendaftaran;?></td>
                    <td width="8%">Petugas Pengisi</td>
                    <td width="1%">:</td>
                    <td width="49%"><?= $model->petugas->NamaLengkap;?></td>
                </tr>
                <tr>
                    <td>Instalasi/ Ruangan</td>
                    <td>:</td>
                    <td><?php 
                            $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
                            $instalasi = InstalasiM::model()->findByPk($ruangan->instalasi_id); 
                            echo $instalasi->instalasi_nama." / ".$model->ruangan->ruangan_nama;?></td>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><?= $model->waktupengkajian_resikojatuh;?></td>
                </tr>
                <tr>
                    <td>Tgl/ Jam <br>Pengkajian Resiko</td>
                    <td>:</td>
                    <td><?= MyFormatter::formatdatetimeforUser($model->tanggal_pengkajian)." / ".$model->jam_pengkajian;?></td>
                    
                </tr>
            
            </table>

            <table width="100%" class="table table-striped table-bordered table-condensed">
                <tr>
                    <td width="3%">No.</td>
                    <td width="46%">Risiko</td>
                    <td width="46%">Penilaian</td>
                    <td width="3%">Skor</td>
                </tr>
                <?php 
                    $penilaian_1 = '';
                    $skor_1 = '';
                    $penilaian_2 = '';
                    $skor_2 = '';
                    $penilaian_3 = '';
                    $skor_3 = '';
                    $penilaian_4 = '';
                    $skor_4 = '';
                    $penilaian_5 = '';
                    $skor_5 = '';
                    $penilaian_6 = '';
                    $skor_6 = '';
                    $penilaian_7 = '';
                    $skor_7 = '';
                    foreach($modHasil as $hasil){
                        if ($hasil->parameter == 'Usia'){
                            $penilaian_1 = $hasil->penilaian;
                            $skor_1 = $hasil->skor;
                        } else if ($hasil->parameter == 'Jenis Kelamin'){
                            $penilaian_2 = $hasil->penilaian;
                            $skor_2 = $hasil->skor;
                        } else if ($hasil->parameter == 'Diagnose'){
                            $penilaian_3 = $hasil->penilaian;
                            $skor_3 = $hasil->skor;
                        } else if ($hasil->parameter == 'Gangguan Kognitif'){
                            $penilaian_4 = $hasil->penilaian;
                            $skor_4 = $hasil->skor;
                        } else if ($hasil->parameter == 'Faktor Lingkungan'){
                            $penilaian_5 = $hasil->penilaian;
                            $skor_5 = $hasil->skor;
                        } else if ($hasil->parameter == 'Respon Terhadap: Pembedahan, sedasi, anastesi'){
                            $penilaian_6 = $hasil->penilaian;
                            $skor_6 = $hasil->skor;
                        } else if ($hasil->parameter == 'Penggunaan Medikamentosa'){
                            $penilaian_7 = $hasil->penilaian;
                            $skor_7 = $hasil->skor;
                        } 
                    }
                ?>
                <tr>
                    <td>1</td>
                    <td>Usia</td>
                    <td><?= $penilaian_1;?></td>
                    <td><?= $skor_1;?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jenis Kelamin</td>
                    <td><?= $penilaian_2;?></td>
                    <td><?= $skor_2;?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Diagnosa</td>
                    <td><?= $penilaian_3;?></td>
                    <td><?= $skor_3;?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Gangguan Kognitif</td>
                    <td><?= $penilaian_4;?></td>
                    <td><?= $skor_4;?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Faktor Lingkungan</td>
                    <td><?= $penilaian_5;?></td>
                    <td><?= $skor_5;?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Respon terhadap : pembedahan, sedasi, anastesi</td>
                    <td><?= $penilaian_6;?></td>
                    <td><?= $skor_6;?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Penggunaan Medikamentosa</td>
                    <td><?= $penilaian_7;?></td>
                    <td><?= $skor_7;?></td>
                </tr>
                <tr>
                    <td colspan="3">Jumlah Skor</td>
                    <td><?= $model->totalskor;?></td>
                </tr>
                <tr>
                    <td colspan="2">Pasien termasuk kategori risiko jatuh :</td>
                    <td colspan="2" style="text-align:right;"><?= $model->keteranganskor_resikojatuh;?></td>
                </tr>
            </table>

        </div>
    </div>
    
</div>
<div class="panel_halaman">
<div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Intervensi Pencegahan Jatuh</div>
        </div>
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td width="8%">Tanggal Intervensi <br>Pencegahan Jatuh</td>
                    <td width="1%">:</td>
                    <td width="49%"><?= isset($modIntervensi->tgl_intervensi) ? MyFormatter::formatdatetimeforUser($modIntervensi->tgl_intervensi) : ' - ';?></td>
                    <td width="8%">Petugas Pengisi</td>
                    <td width="1%">:</td>
                    <td width="49%"><?= isset($modIntervensi->petugas->NamaLengkap) ? $modIntervensi->petugas->NamaLengkap : ' - ';?></td>
                </tr>
                <tr>
                    <td>Jam Intervensi <br>Pencegahan Jatuh</td>
                    <td>:</td>
                    <td><?= isset($modIntervensi->jam_intervensi) ? $modIntervensi->jam_intervensi : ' - ';?></td>
                    <td>Resiko Jatuh</td>
                    <td>:</td>
                    <td><?= isset($modIntervensi->resikojatuh_tingkat) ? $modIntervensi->resikojatuh_tingkat : ' - ';?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>Evaluasi</td>
                    <td>:</td>
                    <td><?php if($modIntervensi->evaluasi_pencegahanjatuh ==  true){
                            echo "Terjadi insiden jatuh";
                        } else {
                            echo "Tidak terjadi insiden jatuh";
                        }?>
                    </td>
                    
                </tr>
            
            </table>

            <table width="100%" class="table table-striped table-bordered table-condensed">
                <tr>
                    <td width="10%">PROTOKOL</td>
                    <td width="85%" colspan="2">TINDAKAN PENCEGAHAN</td>
                    <td width="5%">DILAKUKAN</td>
                </tr>
                
                <?php 
                    $modMasterIntervensiRendah = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'rendah' and kelompok_pasien = 'anak' ORDER BY intervensipencegahanjatuh_urutan ASC");
                            $status = "Tidak";
                            foreach ($modMasterIntervensiRendah as $key => $value) {
                            if ($key == 0){?>
                                <tr>
                                    <td rowspan="<?= count($modMasterIntervensiRendah);?>" style="text-align:center; vertical-align:middle;">
                                        <b><p>STANDAR 1 <br>RESIKO RENDAH</p></b>
                                    </td>
                                    <td style="text-align:center;" width="3%"><?= $key+1;?>.</td>
                                    <td><?= $value->intervensipencegahanjatuh_nama; ?></td>
                                    <td style="text-align:center;">
                                        <?php foreach ($modDetail as $key => $v_det) {
                                            if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                                if ($v_det->isdilakukan == true){
                                                    $status = "Ya";
                                                }
                                            }
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                </tr>

                            <?php } else{ ?>
                                <tr>
                                    <td style="text-align:center;" width="3%"><?= $key+1;?>.</td>
                                    <td><?= $value->intervensipencegahanjatuh_nama; ?></td>
                                    <td style="text-align:center;">
                                        <?php foreach ($modDetail as $key => $v_det) {
                                            if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                                if ($v_det->isdilakukan == true){
                                                    $status = "Ya";
                                                }
                                            }
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                <?php }?>

                <?php 
                    $modMasterIntervensiRendah = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'tinggi' and kelompok_pasien = 'anak' ORDER BY intervensipencegahanjatuh_urutan ASC");
                            $status = "Tidak";
                            foreach ($modMasterIntervensiRendah as $key => $value) {
                            if ($key == 0){?>
                                <tr>
                                    <td rowspan="<?= count($modMasterIntervensiRendah);?>" style="text-align:center; vertical-align:middle;">
                                        <b><p>RESIKO JATUH TINGGI (PROTOKOL 1,2)</p></b>
                                    </td>
                                    <td style="text-align:center;" width="3%"><?= $key+1;?>.</td>
                                    <td><?= $value->intervensipencegahanjatuh_nama; ?></td>
                                    <td style="text-align:center;">
                                        <?php foreach ($modDetail as $key => $v_det) {
                                            if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                                if ($v_det->isdilakukan == true){
                                                    $status = "Ya";
                                                }
                                            }
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                </tr>

                            <?php } else{ ?>
                                <tr>
                                    <td style="text-align:center;" width="3%"><?= $key+1;?>.</td>
                                    <td><?= $value->intervensipencegahanjatuh_nama; ?></td>
                                    <td style="text-align:center;">
                                        <?php foreach ($modDetail as $key => $v_det) {
                                            if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                                if ($v_det->isdilakukan == true){
                                                    $status = "Ya";
                                                }
                                            }
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                <?php }?>

                <?php 
                    // $modMasterIntervensiRendah = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'sangat_tinggi' and kelompok_pasien = 'anak' ORDER BY intervensipencegahanjatuh_urutan ASC");
                    //         $status = "Tidak";
                    //         foreach ($modMasterIntervensiRendah as $key => $value) {
                    //         if ($key == 0){?>
                                <!-- <tr>
                                    <td rowspan="<? //echo count($modMasterIntervensiRendah);?>" style="text-align:center; vertical-align:middle;">
                                        <b><p>RESIKO JATUH SANGAT TINGGI (PROTOKOL 1,2,3)</p></b>
                                    </td>
                                    <td style="text-align:center;" width="3%"><?//= $key+1;?>.</td>
                                    <td><?//= $value->intervensipencegahanjatuh_nama; ?></td>
                                    <td style="text-align:center;"> -->
                                        <?php //foreach ($modDetail as $key => $v_det) {
                                        //     if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                        //         if ($v_det->isdilakukan == true){
                                        //             $status = "Ya";
                                        //         }
                                        //     }
                                        // }
                                        // echo $status;
                                        ?>
                                    <!-- </td>
                                </tr> -->

                            <?php //} else{ ?>
                                <!-- <tr>
                                    <td style="text-align:center;" width="3%"><?//= $key+1;?>.</td>
                                    <td><?//=$value->intervensipencegahanjatuh_nama; ?></td> -->
                                    <!-- <td style="text-align:center;"> -->
                                        <?php //foreach ($modDetail as $key => $v_det) {
                                        //     if ($value->intervensipencegahanjatuh_nama == $v_det->intervensicegahjatuh_nama){
                                        //         if ($v_det->isdilakukan == true){
                                        //             $status = "Ya";
                                        //         }
                                        //     }
                                        // }
                                        // echo $status;
                                        ?>
                                    </td>
                                </tr>
                            <?php //} ?>
                            
                <?php //}?>
                    
                
            </table>

        </div>
    </div>
    
</div>

<div>
    <?php echo CHtml::htmlButton('< Sebelumnya', array('class'=>'btn btn-success btn_back', 'onclick'=>'goto_kembali();')); ?>
    <?php echo CHtml::htmlButton('Berikutnya >', array('class'=>'btn btn-success btn_next', 'onclick'=>'goto_lanjut();', 'style'=>'float: right;')); ?>
    <div style="clear: both;"></div>
</div>
<br/>

<br/>

<script>

var idx = 0;

function goto_kembali() {
    if (idx > 0) {
        idx--;
    }
    
    cekTombol();
}

function goto_lanjut() {
    if (idx < 1) {
        idx++;
    }
    cekTombol();
}

function cekTombol() {
    $(".panel_halaman").hide();
    $(".panel_halaman").eq(idx).show();
    
    if (idx == 0) {
        $(".btn_back").hide();
    } else {
        $(".btn_back").show();
    }
    
    if (idx == 1) {
        $(".btn_next").hide();
    } else {
        $(".btn_next").show();
    }
}


$(document).ready(function() {
    cekTombol();
});

</script>
