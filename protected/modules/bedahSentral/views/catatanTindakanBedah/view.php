<style>
    
    .tab-panel {
        border: 1px solid black;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .tab-panel > thead > tr > th {
        border-bottom: 1px solid black;
        font-weight: bold;
    }
    
    .tab-panel > thead > tr > th, .tab-panel > tbody > tr > td {
        padding: 5px;
    }
    
    
    
    
    
    .tab-detail1 {
        width: 100%;
    }
    
    .tab-detail1 td {
        padding: 2px;
        vertical-align: top;
    }
    
    .tab-detail2 {
        width: 100%;
    }
    
    .tab-detail2 th, .tab-detail2 td {
        padding: 5px;
        vertical-align: top;
        border: 1px solid black;
    }
    
</style>

<?php echo $this->renderPartial('application.views.headerReport.headerRincianLogo', array(), true); ?>
<h3 style="text-align: center;">Laporan Tindakan Bedah & Prosedur Invasif dengan Anestesi Lokal</h3>

<table class="tab-panel">
    <thead>
        <tr>
            <th>Data Pasien</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_infoPasien', array(
                    'model'=>$model
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Tim Bedah</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_timBedah', array(
                    'model'=>$model,
                    'rencana'=>$rencana,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Keterangan Waktu Bedah</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_waktuBedah', array(
                    'model'=>$model,
                    'rencana'=>$rencana,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Informasi Bedah</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_informasiBedah', array(
                    'model'=>$model,
                    'rencana'=>$rencana,
                    'anamnesa'=>$anamnesa,
                    'diagnosa'=>$diagnosa,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Obat yang diberikan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_obat', array(
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Spesimen yang Diambil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_spesimen', array(
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Hasil Observasi Tanda Vital selama Operasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_observasi', array(
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab-panel">
    <thead>
        <tr>
            <th>Pemeriksaan Fisik Post Operasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'print/_postOperasi', array(
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td width="200" style="text-align: center; vertical-align: top;">Dokter Bedah
            <br>
            <br>
            <br>
            <br>
            <?php echo (empty($rencana) || empty($rencana->dokter1)) ? "-" : ($rencana->dokter1->namaLengkap); ?>
        </td>
        <td></td>
        <td width="200" style="text-align: center; vertical-align: top;">Perawat
            <br>
            <br>
            <br>
            <br>
            <?php echo (empty($rencana) || empty($rencana->perawatsirkuler)) ? "-" : ($rencana->perawatsirkuler->namaLengkap); ?>
        </td>
    </tr>
</table>
<br>
<?php

if (empty($caraPrint)) { ?>

<?php echo CHtml::htmlButton('<i class="entypo-print"></i> Print', array(
    'class'=>'btn btn-info', 'onclick'=>"printLaporan('PRINT');",
))." "; ?>
<?php 
//echo CHtml::htmlButton('<i class="entypo-print"></i> PDF', array(
//    'class'=>'btn btn-info', 'onclick'=>"printLaporan('PDF');",
//)); ?>

<script>

function printLaporan(caraPrint) {
    var pasienmasukpenunjang_id = '<?php echo isset($model->pasienmasukpenunjang_id) ? $model->pasienmasukpenunjang_id : null ?>';
    window.open('<?php echo $this->createUrl('laporan'); ?>&pasienmasukpenunjang_id=' + pasienmasukpenunjang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}

</script>

<?php
}
?>