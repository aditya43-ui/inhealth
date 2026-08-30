<h3 align="left">ASESMEN SPIRITUAL ULANG PASIEN RAWAT INAP</h3>
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

    $listpilihan = $model->pilihanData();
    $penerimaankondisisakit = $listpilihan['penerimaankondisisakit'];
    $ibadahsholat = $listpilihan['ibadahsholat'];
    $selamasakit = $listpilihan['ibadahsholat'];
    unset($selamasakit["TIDAK"]);
    $selamasakit['SAKIT'] = 'Sakit';
    
    $ekspresi = $listpilihan['ekspresi'];
    $hafalan = $listpilihan['hafalan'];
    $mediabersuci = $listpilihan['mediabersuci'];
    $penilaian = $listpilihan['penilaian'];
    
    $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<table class="prinout w100 grid">
    <tr>
        <td width="5%">A.</td>
        <td>IDENTITAS PASIEN</td>
        <td>&nbsp;</td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td>Ruang : <?= $model->kamarruangan_nama; ?></td>
        <td>Tanggal : <?= date('d M Y', strtotime($model->tanggal)) ?></td>
    </tr>  
    <tr>
        <td>&nbsp;</td>
        <td colspan="2">
            Sumber Data : 
            <?= cek_lis($model->sumber_data_pasien) ?> Pasien 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?= cek_lis($model->sumber_data_keluarga) ?> Keluarga 
        </td>
    </tr> 
    <tr>
        <td width="5%">B.</td>
        <td colspan="2">ANAMNESIS KONDISI PASIEN</td>        
    </tr>  
    <tr>
        <td colspan="2">
            Penerimaan Kondisi Sakit<br/>
            Pernyataan Pasien<br/><br/>
            
            <table class="prinout w100 no-grid">                
                <tr>
            <?php
                foreach($penerimaankondisisakit as $key =>$val){
                    echo '<td style="padding:0px;">';
                    echo '<table class="prinout w100 grid">';
                    foreach($val as $k => $v){
                        echo '<tr>';
                        echo '<td width="15%">'.cek_lis_x(in_array($k, $model->penerimaankondisi_pasien)).'</td>';
                        echo '<td>'.$v.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</td>';
                }
            ?>
                </tr>
            </table>
        </td>
        <td>
            Ibadah Sholat<br/>
            Pernyataan Pasien<br/><br/>
            
            <table class="prinout w100 grid">   
                <tr>
                    <td>Sebelum Sakit</td>
                    <td>Selama Sakit</td>
                </tr>
                <tr>
            <?php
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($ibadahsholat as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->ibadahsholatpasien_sebelumsakit)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';   
                echo '</td>';
                             
                
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($selamasakit as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->ibadahsholatpasien_selamasakit)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';
                echo '</td>';
                 
            ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Pernyataan Keluarga<br/><br/>
            
            <table class="prinout w100 no-grid">                
                <tr>
            <?php
                foreach($penerimaankondisisakit as $key =>$val){
                    echo '<td style="padding:0px;">';
                    echo '<table class="prinout w100 grid">';
                    foreach($val as $k => $v){
                        echo '<tr>';
                        echo '<td width="15%">'.cek_lis_x(in_array($k, $model->penerimaankondisi_keluarga)).'</td>';
                        echo '<td>'.$v.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</td>';
                }
            ?>
                </tr>
            </table>
        </td>
        <td>
            Pernyataan Pasien<br/><br/>
            
            <table class="prinout w100 grid">   
                <tr>
                    <td>Sebelum Sakit</td>
                    <td>Selama Sakit</td>
                </tr>
                <tr>
            <?php
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($ibadahsholat as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->ibadahsholatkeluarga_sebelumsakit)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';   
                echo '</td>';
                             
                
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($selamasakit as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->ibadahsholatkeluarga_selamasakit)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';
                echo '</td>';
                 
            ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Ekspresi<br/><br/>
            
            <table class="prinout w100 no-grid">                
                <tr>
            <?php
                foreach($ekspresi as $key =>$val){
                    echo '<td style="padding:0px;">';
                    echo '<table class="prinout w100 grid">';
                    foreach($val as $k => $v){
                        echo '<tr>';
                        echo '<td width="15%">'.cek_lis_x(in_array($k, $model->ekspresi)).'</td>';
                        echo '<td>'.$v.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</td>';
                }
            ?>
                </tr>
            </table>
        </td>
        <td>
            Pernyataan Keluarga<br/><br/>
            
            <table class="prinout w100 grid">   
                <tr>
                    <td>Hafalan</td>
                    <td>Media Bersuci</td>
                </tr>
                <tr>
            <?php
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($hafalan as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->pernyataankeluarga_hafalan)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';   
                echo '</td>';
                             
                
                echo '<td>';
                echo '<table class="prinout w100 grid">';
                foreach($mediabersuci as $key =>$val){                    
                    echo '<tr>';
                    echo '<td width="15%">'.cek_lis_x(in_array($key, $model->pernyataankeluarga_mediabersuci)).'</td>';
                    echo '<td>'.$val.'</td>';
                    echo '</tr>';                    
                }
                echo '</table>';
                echo '</td>';
                 
            ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Penilaian<br/><br/>
            
            <table class="prinout w100 no-grid">                
                <tr>
            <?php
                foreach($penilaian as $key =>$val){
                    echo '<td style="padding:0px;">';
                    echo '<table class="prinout w100 grid">';
                    foreach($val as $k => $v){
                        echo '<tr>';
                        echo '<td width="15%">'.cek_lis_x(in_array($k, $model->penilaian_kondisipasien)).'</td>';
                        echo '<td>'.$v.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</td>';
                }
            ?>
                </tr>
            </table>
        </td>
        <td>
            Penilaian<br/><br/>
            
            <table class="prinout w100 no-grid">                
                <tr>
            <?php
                foreach($penilaian as $key =>$val){
                    echo '<td style="padding:0px;">';
                    echo '<table class="prinout w100 grid">';
                    foreach($val as $k => $v){
                        echo '<tr>';
                        echo '<td width="15%">'.cek_lis_x(in_array($k, $model->penilaian_ibadah)).'</td>';
                        echo '<td>'.$v.'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</td>';
                }
            ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="300px" colspan="3">
            Kesimpulan : <?= $model->kesimpulan ?>
        </td>
    </tr>
</table>

<span><i>SSAP 1 EP 2/SSAP 1 EP 2 EP 3 EP 5/Sertifikasi Syariah 1441 H</i></span>
