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
        font-family: "Arial" !important;
        font-size: 6.5px !important;
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


     table tr, table td {
        border: 1px solid black;
    } 

</style>
<?php
$x = 0;
foreach ($modPendaftaran as $result => $i){ 
    
    $x++;
    ?>
    <table colspan="2">
 
        <tr>
            <td align ="center"  style="padding-top:25px;padding-bottom:30px;padding-left:15px;">
                
                <?php
             
             $umurs = explode(' ',$modPendaftaran->umur);
             echo '<td align ="center">'.$modPendaftaran->pasien->no_rekam_medik.'<br>'.$modPendaftaran->pasien->nama_pasien.'<br>'.$modPendaftaran->pasien->alamat_pasien.'&nbsp;&nbsp;('.$umurs[0].' '.$umurs[1].')</td>';         ?>
            <td>

            <td align ="center"  style="padding-top:25px;padding-bottom:30px;padding-left:15px;">
         
                <?php
                 $umurs = explode(' ',$modPendaftaran->umur);
                echo '<td align ="center">'.$modPendaftaran->pasien->no_rekam_medik.'<br>'.$modPendaftaran->pasien->nama_pasien.'<br>'.$modPendaftaran->pasien->alamat_pasien.'&nbsp;&nbsp;('.$umurs[0].' '.$umurs[1].')</td>';
                ?>
            <td>
        </tr>
    
    </table>
    <?php

if($x==8) break;
} ?>

