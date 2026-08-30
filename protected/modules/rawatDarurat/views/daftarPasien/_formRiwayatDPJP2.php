<?php 

$this->widget('bootstrap.widgets.BootAlert'); 
?>
<div class="table-responsive">
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Riwayat Alih Leader / Disposisi 
                </div>
    </div>
    <table class="table table-condensed table-bordered">
        <thead>
            <th>Waktu Disposisi</th>
            <th>Petugas Disposisi</th>
            <th>DPJP ASAL</th>
            <th>DPJP Pengganti</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            <?php if (!empty($modDokter)){  ?>
               <?php foreach ($modDokter as $modDokters) : ?>
            <tr>
                <td><?php 
               echo  MyFormatter::formatDateTimeForUser($modDokters->tglubahdokter ?? "");
                ?></td>
                <td><?php echo $modDokters->pegawai->nama_pegawai ?? ""; ?></td>
                <td><?php echo $modDokters->dokterlama->nama_pegawai ?? "";  ?></td>
                <td><?php  echo $modDokters->dokterbaru->nama_pegawai ?? "";  ?></td>
                <td><?php  echo  $modDokters->keterangan ?? "";  ?></td>
            </tr>
            </tbody>
            <?php endforeach ; ?>
            <?php } else { ?>
              <?php echo 'Tidak ada data yang ditemukan'; ?>
                <?php } ?>
            </table>
             