<style>
    /*    body{
            width:100%;
            height:2.5cm;
            font-size:22pt;
            padding:10px;
            *border:1px solid #333;*
            margin-top:0.2cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }*/

    /*/*    .label{
            height:7cm;
            width:6cm;   
            margin-bottom: 4px;
            vertical-align: middle;
            padding-top: 70px;
            border: 1px solid #333;
            font-size:16pt;
        }*/

    BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
        font-family: "Courier New" !important;
        font-size: 8.5px !important;
        font-weight: bold;
      
        /* margin-top:10px;
        margin-bottom: 10px; */
        /* font-size: 8pt !important; */
    }
    /*.tabel {
            width:100%;
            height:2.5cm;
            border: 1px solid #000;
        margin-top:0.2cm;
            margin-left: 2cm;
            margin-bottom: 15px;
            background-color: #CCC;
    }*/

    /* table tr, table td {
        border: 1px solid black;
    } */

    .tbl-pisah tr, .tbl-pisah td {
        border: 1px solid white;
    }

    .tbl-pisah {
        border-collapse: collapse;
    }

</style>
<?php
$x = 0;
foreach ($modPendaftaran as $result => $i){ 
    
    $x++;
    ?>
    <table colspan="2" style="width: 100%; margin-left: -10px; margin-top: 5px;" class="tbl-pisah">
 
        <tr>
            <td align ="center"  style="padding-top:20px;padding-bottom:28px;padding-left:0px;">                
                <?php
             
             $umurs = explode(' ',$modPendaftaran->umur);
             echo '<td align ="center">'.$modPendaftaran->pasien->no_rekam_medik.'<br>'.$modPendaftaran->pasien->nama_pasien.'<br>'.substr($modPendaftaran->pasien->alamat_pasien, 0, 30).'<br>'.$modPendaftaran->pasien->tanggal_lahir.'&nbsp;&nbsp;('.$umurs[0].' '.$umurs[1].')</td>';         ?>
            <td>
            <?php if($x <= 3):?>
            <td align ="center"  style="padding-top:30px;padding-bottom:30px;padding-left:0px;">
            <?php elseif($x == 8):?>
            <td align ="center"  style="padding-top:40px;padding-bottom:10px;padding-left:0px;">
            <?php else:?>
             <td align ="center"  style="padding-top:30px;padding-bottom:30px;padding-left:0px;">
            <?php endif;?>
                <?php
                 $umurs = explode(' ',$modPendaftaran->umur);
                echo '<td align ="center">'.$modPendaftaran->pasien->no_rekam_medik.'<br>'.$modPendaftaran->pasien->nama_pasien.'<br>'.substr($modPendaftaran->pasien->alamat_pasien, 0, 30).'<br>'.$modPendaftaran->pasien->tanggal_lahir.'&nbsp;&nbsp;('.$umurs[0].' '.$umurs[1].')</td>';
                ?>
            <td>
        </tr>
    
    </table>
    <?php

if($x==8) break;
} ?>

