<div class="overflow-x">
<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <!--<th>Waktu Observasi</th>-->
        <th>Kantong Darah</th>
<!--        <th>Reaksi Transfusi</th>
        <th>Petugas Observasi</th>-->
        <th>Lihat</th>
        <th>Ubah</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(count($loadRiwayat) > 0) : ?>
    <?php foreach($loadRiwayat as $row) : ?>
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($row['tgl_pendaftaran']).'/'.$row['no_pendaftaran'] ?>
        </td>
        <td>
            <?php 
                if (!empty($row['kantong'])){
                    echo implode(', ', $row['kantong']);
                }
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantong_transfusi_darah_id'=>$row['kantong_transfusi_darah_id'], 'mode'=>'view')); 
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantong_transfusi_darah_id'=>$row['kantong_transfusi_darah_id'])); 
            ?>
        </td>
        <td>
            <center><a onclick="hapusRiwayat('<?php echo $row['kantong_transfusi_darah_id']; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Transfusi Darah"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <center><a href="javascript:void(0)" onclick="print(<?= $_GET['pendaftaran_id'] ?>,<?= $row['kantong_transfusi_darah_id']; ?>)" ><i class="icon-print"></i></a></center>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantong_transfusi_darah_id'=>$row['kantong_transfusi_darah_id'], 'salin_id'=>1)); 
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>
</div>