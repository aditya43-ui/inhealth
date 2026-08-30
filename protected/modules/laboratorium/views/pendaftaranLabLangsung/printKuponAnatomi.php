<style>
    body{
        width:7.5cm;
        height:5cm;
        border:1px solid;
        margin: 0;
            /* background: #787878; */
            background-size:7.5cm 5cm;
            background-repeat:no-repeat;
        position:absolute;
        padding:3px;
    }
    .content-depan{
    /* -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg); */
    /* transform: rotate(0deg); */
        color:#000000;
        /*width:7.5cm;*/
        width:7.5cm;
        height:5cm;
        border:0px solid;
        margin: 0;
            /* background: #787878; */
            background-size:7.5cm 5cm;
            background-repeat:no-repeat;
        position:absolute;
        padding:3px;
    }
    tr > td{
        padding:2px;
    }
</style>
<?php

if(count((array)$modPasienMasukPenunjangs) > 0){
    foreach($modPasienMasukPenunjangs AS $i => $penunjang){
?>
<table style="width: 100%; border: none;">
    <!-- <thead>
        <tr>
             <td>
                <div class="header"> -->
                    <?php 
                        // echo $this->renderPartial('application.views.headerReport.headerDefaultKuponLab',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
                    ?>
                <!-- </div>  
            </td>
        </tr>
    </thead> -->
    <tbody>
                    <?php 
                        echo $this->renderPartial('application.views.headerReport.headerDefaultKuponLab',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
                    ?>
<!-- <div class="content-depan"> -->
    <br>
    <br>
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $modPasien->namadepan." ".$modPasien->nama_pasien ?></td>
        </tr>
        <tr>
            <td>No. PA</td>
            <td>:</td>
            <td><?php echo !empty($penunjang->noorderlis)?$penunjang->noorderlis:""; ?></td>
            <!-- <td><?php
                // foreach ($daftartindakan[$i] as $i=>$daftartindakans){
            // echo $penunjang->no_masukpenunjang;
                // }
            ?></td> -->
        </tr>
        <tr>
            <td>Tgl Terima</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId(date('Y/m/d'),strtotime($penunjang->tglmasukpenunjang)) ?></td>
        </tr>
        <tr>
            <td>Tgl Hasil</td>
            <td>:</td>
            <td><?php
                foreach ($daftartindakan[$i] as $i=>$daftartindakans){
                    echo MyFormatter::formatDateTimeId(date('Y/m/d'),strtotime($daftartindakans->tgl_tindakan));
                }
            ?></td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik ?></td>
        </tr>
    </table>
<!-- </div> -->
    </tbody>
    </table>
<?php }}?>