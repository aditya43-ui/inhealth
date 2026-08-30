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
        <td>Nama Paramedis</td>
        <td>:</td>
        <td><?php echo (isset($detailHasil[0]->paramedis_nama) ? $detailHasil[0]->paramedis_nama : "-"); ?> </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->nama_pasien;?></td>
        <td></td>
        <td>Tgl. Anamnesa</td>
        <td>:</td>
        <td><?php echo (isset($detailHasil[0]->tglanamnesis) ? $detailHasil[0]->tglanamnesis : "-"); ?> </td>
    </tr>
    
</table>
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tgl. Anamnesa</th>
            <th>Keluhan Utama</th>
            <th>Keluhan Tambahan</th>
            <th>Riwayat Penyakit Terdahulu</th>
            <th>Riwayat Penyakit Keluarga</th>
            <th>Lama Sakit</th>
            <th>Pengobatan Yang Sudah Dilakukan</th>
            <th>Riwayat Alergi Obat</th>
            <th>Riwayat Kelahiran</th>
            <th>Riwayat Makanan</th>
            <th>Riwayat Imunisasi</th>
            <th>Keterangan Anamnesa</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($detailHasil as $i=>$hasil){
        ?>
        <tr>
            <?php if(empty($hasil->tglanamnesis)){ ?>
            <td colspan="13">Tidak Ditemukan Hasil </td>
            <?php }else{ ?>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $hasil->tglanamnesis; ?></td>
            <td><?php echo $hasil->keluhanutama; ?></td>
            <td><?php echo $hasil->keluhantambahan; ?></td>
            <td><?php echo $hasil->riwayatpenyakitterdahulu; ?></td>
            <td><?php echo $hasil->riwayatpenyakitkeluarga; ?></td>
            <td><?php echo $hasil->lamasakit; ?></td>
            <td><?php echo $hasil->pengobatanygsudahdilakukan; ?></td>
            <td><?php echo $hasil->riwayatalergiobat; ?></td>
            <td><?php echo $hasil->riwayatkelahiran; ?></td>
            <td><?php echo $hasil->riwayatmakanan; ?></td>
            <td><?php echo $hasil->riwayatimunisasi; ?></td>
            <td><?php echo $hasil->keterangananamesa; ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>