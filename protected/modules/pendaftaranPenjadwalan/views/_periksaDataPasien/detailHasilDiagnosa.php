<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>

<table >
    <tr>
        <td> No. RM</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
        <td></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran;?></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $modPasien->alamat_pasien." RT ".$modPasien->rt." RW ".$modPasien->rw; ?> </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->nama_pasien;?></td>
        <td></td>
        <td>Tgl. Diagnosa</td>
        <td>:</td>
        <td><?php echo (isset($detailHasil[0]->tglmorbiditas) ? $detailHasil[0]->tglmorbiditas : "-"); ?> </td>
    </tr>
    
</table>
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tgl. Diagnosa</th>
            <th>Kelompok Diagnosa</th>
            <th>Kode</th>
            <th>Nama Diagnosa</th>
            <th>Nama Lain</th>
            <th>Kata Kunci</th>
            <th>Diagnosa Tindakan</th>
            <th>Sebab Diagnosa</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($detailHasil as $i=>$hasil){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $hasil->tglmorbiditas; ?></td>
            <td><?php echo $hasil->kelompokdiagnosa->kelompokdiagnosa_nama; ?></td>
            <td><?php echo $hasil->diagnosa->diagnosa_kode; ?></td>
            <td><?php echo $hasil->diagnosa->diagnosa_nama; ?></td>
            <td><?php echo $hasil->diagnosa->diagnosa_namalainnya; ?></td>
            <td><?php echo $hasil->diagnosa->diagnosa_katakunci; ?></td>
            <td><?php echo (isset($hasil->diagnosatindakan->diagnosaicdix_nama))?$hasil->diagnosatindakan->diagnosaicdix_nama:'-'; ?></td>
            <td><?php echo isset($hasil->sebabdiagnosa->sebabdiagnosa_nama)?$hasil->sebabdiagnosa->sebabdiagnosa_nama:'-'; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>