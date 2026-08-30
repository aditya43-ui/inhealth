<?php 
$visibility = isset($_GET['lihat']) ? 'hidden' : '';
?>
<table class="items table table-bordered table-striped table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Dirujuk</th>
            <th>No. Pendaftaran</th>
            <th>Rumah Sakit Tujuan</th>
            <th>Dirujuk ke Bagian</th>
            <th>Dokter Tujuan</th>
            <th>Detail</th>
            <th>Cetak</th>
            <th <?= $visibility ?>>Hapus</th>
        </tr>
    </thead>
    <?php foreach ($modRiwayatRujukanKeluar as $i => $rujukan) { ?>
    <tr>
        <td><?php echo MyFormatter::formatDateTimeForUser($rujukan->tgldirujuk) ?></td>
        <td><?php echo $rujukan->pendaftaran->no_pendaftaran ?></td>
        <td><?php echo $rujukan->rujukankeluar->rumahsakitrujukan ?></td>
        <td><?php echo $rujukan->dirujukkebagian ?></td>
        <td><?php echo $rujukan->kepadayth ?></td>
        <td style="text-align: center;"><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailRujukan('.$rujukan->pasiendirujukkeluar_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail rujukan')); ?></td>
        <td style="text-align: center;">
            <a onclick="printRujukan('PRINT',<?php echo $rujukan->rujukankeluar_id; ?>);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-form-print"></i></a>
        </td>
        <td style="text-align: center;" <?= $visibility ?>><?php echo CHtml::link("<i class='icon-form-sampah'></i>", '#', array('onclick'=>'hapusRujukan(this, '.$rujukan->pasiendirujukkeluar_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail rujukan')); ?></td>
    </tr>
    <?php } ?>
   
</table>
