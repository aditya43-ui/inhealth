<h3 align="left">ASESMEN SPIRITUAL ULANG PASIEN RAWAT JALAN/IGD</h3>
<br/>
<?php
    function cek_lis($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
        if ($st){
            $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
        }
        return $icon;
    }
    
    function cek_lis_x($st){
        $icon = '<span  style="font-family:FontAwesome;" ></span>';
        if ($st){
            $icon = '<span  style="font-family:FontAwesome;" >&#xf00c;</span>';
        }
        return $icon;
    }

    $listpilihan = $model->listPilihan();
    $tharoh = $listpilihan['thoharoh'];
    $sebelumsakit = $listpilihan['sebelumsakit'];
    $selamasakit = $listpilihan['selamasakit'];
    $psiko = $listpilihan['psiko'];
    $rencanaedukasi = $listpilihan['rencanaedukasi'];
    
    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<table class="prinout w100 grid">
    <tr>
        <td>Ruangan : <?= $model->ruangan_nama ?></td>
        <td>Tanggal : <?= date('d M Y', strtotime($model->tanggal)) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jam : <?= date('H:i:s', strtotime($model->tanggal)) ?></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-left: 20px;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td width="5%">A.</td>
                    <td>THOHAROH</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                         <?php
                            if (!empty($tharoh)){
                                foreach($tharoh as $key => $val){
                                    echo cek_lis($model->$key)." &nbsp ".$val."  ".$space;
                                }
                            }
                        ?>   
                    </td>
                </tr>
            </table>
        </td>
    </tr>  
    <tr>
        <td colspan="2" style="padding-left: 20px;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td width="5%">B.</td>
                    <td>IBADAH</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Sebelum Sakit :</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                         <?php
                            if (!empty($sebelumsakit)){
                                foreach($sebelumsakit as $key => $val){
                                    echo cek_lis($model->$key)." &nbsp ".$val."  ".$space;
                                }
                            }
                        ?>   
                    </td>
                </tr><tr>
                    <td></td>
                    <td>Selama Sakit :</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                         <?php
                            if (!empty($selamasakit)){
                                foreach($selamasakit as $key => $val){
                                    echo cek_lis($model->$key)." &nbsp ".$val."  ".$space;
                                }
                            }
                        ?>   
                    </td>
                </tr>
            </table>
        </td>
    </tr>  
    <tr>
        <td colspan="2" style="text-align: center;">
            ASESMEN SPIRITUAL TAMBAHAN PASIEN RAWAT JALAN / IGD
        </td>        
    </tr>
    <tr>
        <td colspan="2" style="padding-left: 20px;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td width="5%">C.</td>
                    <td>MASALAH PSIKO-SPIRITUAL</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table class="prinout w100 grid">
                            <?php
                                if (!empty($psiko)){
                                    $temp = [];
                                    foreach($psiko as $key => $val){
                                        echo '<tr>';
                                            echo '<td width="5%" align="center">'.cek_lis_x(in_array($val->lookup_name, $model->masalahpsiko)).'</td>';
                                            echo '<td>'.$val->lookup_name.'</td>';
                                        echo '</tr>';
                                    }                                   
                                }
                            ?>                           
                        </table>
                    </td>
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-left: 20px;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td width="5%">D.</td>
                    <td>DIAGNOSA SPIRITUAL</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                         <?php
                            echo $model->diagnosaspiritual;
                        ?>   
                    </td>
                </tr>
            </table>
        </td>
    </tr> 
    <tr>
        <td colspan="2" style="padding-left: 20px;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td width="5%">E.</td>
                    <td>RENCANA EDUKASI ISLAM</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table class="prinout w100 grid">
                            <?php
                                if (!empty($rencanaedukasi)){
                                    $temp = [];
                                    foreach($rencanaedukasi as $key => $val){
                                        echo '<tr>';
                                            echo '<td width="5%" align="center">'.cek_lis_x(in_array($val->lookup_name, $model->rencanaedukasiislami)).'</td>';
                                            echo '<td>'.$val->lookup_name.($val->lookup_name == 'Lain-lain'?'...'.$model->rencanaedukasiislami_lain:'...').'</td>';
                                        echo '</tr>';
                                    }                                   
                                }
                            ?>                           
                        </table>
                    </td>
                </tr>                
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td style="text-align: center;">Pasien / Keluarga</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center;">(<?= '<u>'.(!empty($model->nama_pasien)?$model->nama_pasien:$model->nama_keluarga).'</u>' ?>)</td>
                </tr>
                <tr>
                    <td>Nama dan Tanda Tangan</td>
                </tr>
            </table>
        </td>
        <td style="text-align: center;">
            <table class="prinout w100 no-grid">
                <tr>
                    <td style="text-align: center;">Petugas</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center;">(<?= '<u>'.$model->petugas_nama.'</u>' ?>)</td>
                </tr>
                <tr>
                    <td>Nama dan Tanda Tangan</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<span><i>SSAP 1/SSPBK 2/Sertifikasi Syariah 1441 H</i></span>
