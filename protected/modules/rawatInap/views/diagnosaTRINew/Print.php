<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
        border-collapse: collapse;
        font-family: "Arial" !important;
    }

    .table th, .table td {
        border: 1px solid black;
    }
</style>


<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}


 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
    }
?>
<div class="header" width="100%">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());?>
</div>
<div class="content" width="100%">
    <div class="judulcontent" align="center"> RINCIAN DIAGNOSA </div>
</div>
<table width="100%" style="margin-left:auto; margin-right:auto;">
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
    <tr>
        <td nowrap>  <?= $modPendaftaran->getAttributeLabel('carabayar_id')?>/
                    <?= $modPendaftaran->getAttributeLabel('penjamin_id')?> 
        </td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
</table>
<br/>
<table id="tblDaftarDiagnosa" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelompok Diagnosis</th>
            <th>Kode ICD 10</th>
            <th>Nama ICD 10</th>
            <th>Nama lain ICD 10</th>
        </tr>
    </thead>
    
    <?php 
    $i = 1;
    foreach ($modDiagnosa as $detail) {?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $detail->kelompokdiagnosa->kelompokdiagnosa_nama ?></td>
        <td><?php echo $detail->diagnosa->diagnosa_kode ?></td>
        <td><?php echo $detail->diagnosa->diagnosa_nama ?></td>
        <td><?php echo $detail->diagnosa->diagnosa_namalainnya ?></td>
    </tr>
    <?php 
    $i++;
    } ?>
	<?php $pendaftaran_id = $modPendaftaran->pendaftaran_id;  ?>
</table>
<br/>
<table id="tblDaftarDiagnosaIX" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelompok Diagnosis</th>
            <th>Kode ICD  9 CM</th>
            <th>Nama ICD  9 CM</th>
            <th>Nama lain ICD  9 CM</th>
        </tr>
    </thead>
    
    <?php 
    $i = 1;
    foreach ($modDiagnosaIX as $detail) {?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $detail->pasienmorbiditas->kelompokdiagnosa->kelompokdiagnosa_nama ?></td>
        <td><?php echo $detail->diagnosatindakan->diagnosaicdix_kode ?></td>
        <td><?php echo $detail->diagnosatindakan->diagnosaicdix_nama ?></td>
        <td><?php echo $detail->diagnosatindakan->diagnosaicdix_namalainnya ?></td>
    </tr>
    <?php 
    $i++;
    } ?>
	<?php $pendaftaran_id = $modPendaftaran->pendaftaran_id;  ?>
</table>
<br/>
<table align="RIGHT">
    <tr>
        <td>
            <div align="CENTER"> Dokter Pemeriksa
                <br/><br/><br/><br/>
            ( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )
            </div>
        </td>
    </tr>
</table>
<table align="LEFT">
    <tr>
        <td>
            <div align="CENTER"></div>
        </td>
    </tr>
</table>

<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
