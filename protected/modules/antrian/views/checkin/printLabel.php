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
        font-size: 7.7px !important;
        font-weight: bold;
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

</style>
<?php $umur = explode(" ", $modPendaftaran->umur); ?>
<?php $jeniskelamin = substr($modPendaftaran->pasien->jeniskelamin, 0, 1); ?>

<div style="padding-top:15px; padding-left:190px; text-align:left" width="100%">
    <table>
        <tr>
            <td rowspan="10" width="100%" style="vertical-align: middle; text-align: left;">
                <?php 
                $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                                  'data' =>$modPendaftaran->pasien->no_rekam_medik,
                                  'subfolderVar' => false,
                                  'displayImage'=>true, // default to true, if set to false display a URL path
                                  'errorCorrectionLevel'=>'M', // available parameter is L,M,Q,H
                                  'matrixPointSize'=>2, // 1 to 10 only
                              )); 
                ?>
            </td>
        </tr>
    </table>
</div>
<div style="padding-top:0; line-height:1.5; padding-right:10px;" width="100%">
    <table>
       
    </table>
    <table>
        <tr>
            <td>
                <?php
                    echo '<td width="40">No Urut</td><td>:</td><td>'.$modPendaftaran->ruangan->ruangan_singkatan.'-'.$modPendaftaran->no_urutantri.'</td>';
                ?> 
            </td>
        </tr>
        <tr>
            <td>
                <?php
                echo '<td>Reg</td><td> : </td><td>'.$modPendaftaran->no_pendaftaran.' '.date('d/m/Y', strtotime($modPendaftaran->tgl_pendaftaran)).'</td>';
                ?>
            <td>
        </tr>
        <tr>
            <td>
                <?php
                echo '<td>NIK</td><td> : </td><td>'.$modPendaftaran->pasien->no_identitas_pasien.'</td>';
                ?>
            <td>
        </tr>
        <tr>
            <td style='font-weight:bold;'>
                <?php if($modPendaftaran->pasien->jeniskelamin == "LAKI-LAKI"){
                    $jns = "(L)";
                }else{
                    $jns = "(P)";
                } ?>
                <?php echo '<td>Nama</td><td> : </td><td>' .$modPendaftaran->pasien->nama_pasien." ".$jns.'</td>'; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                echo '<td>MR</td><td> : </td><td>'.$modPendaftaran->pasien->no_rekam_medik.' TL : '.date('d/m/Y', strtotime($modPendaftaran->pasien->tanggal_lahir)).' '.$modPendaftaran->umur.'</td>';
                ?>
            <td>
        </tr>
        <tr>
            <td>
                <?php echo '<td>Poli</td><td> : </td><td>'.$modPendaftaran->ruangan->ruangan_nama.'</td>'; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo '<td>Dr</td><td> : </td><td>'.$modPendaftaran->pegawai->namaLengkap.'</td>'; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo '<td>Pnj</td><td> : </td><td>'.$modPendaftaran->penjamin->penjamin_nama.'</td>'; ?>
            </td>
        </tr>
    </table>
</div>