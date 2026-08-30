<style>

    BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
        font-family: "Arial" !important;
        font-size: 7.5px !important;
        /* font-weight: bold; */
        /* font-size: 8pt !important; */
    }

</style>
<?php $umur = explode(" ", $modPendaftaran->umur); ?>
<?php $jeniskelamin = substr($modPendaftaran->pasien->jeniskelamin, 0, 1); ?>

<table style="width:100%;" >
    <tr>
        <td style="width:30%;text-align:right !important;">
            <table style="text-align:center !important;">
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <!-- <tr>
                <td><br></td>
            </tr> -->
                <tr>
                    <td style="font-size:40px; font-weight:bold; font-family:Sans-Serif; padding-left:20px;padding-bottom:0px!important;line-spacing:0px;line-height:1;">
                        <?php
                            if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
                                echo 'L';
                            } else{
                                echo 'P';
                            }
                        ?> 
                    </td>
                </tr>
            </table>
        </td>
        <td style="width:70%;">
            <table >
                <tr> 
                    <td style="font-size:9pt; font-family:Sans-Serif; padding: 1px;" colspan="3">
                        <b><?php echo 
                        // $modPendaftaran->pasien->namadepan.' '.
                        $modPendaftaran->pasien->nama_pasien; ?></b>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style=" font-size:9pt; font-family:Sans-Serif">
                        DOB : <?php echo MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir); ?>
                        <!-- DOB : <?php //echo date('d/m/Y',strtotime($modPendaftaran->pasien->tanggal_lahir)); ?> -->
                    </td>
                </tr>
                <tr>
                    <td style="font-size:9pt; font-family:Sans-Serif">
                        <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table>

<tr>
        <td style="top:0px;padding-left:50px;">
            <!-- </td> style="background:#787878; "> -->
            <img style="text-align:left;width: 152.28346457px;height:50.897637795px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pasien->no_rekam_medik; ?>&is_text="> 
        </td>
    </tr>
</table>