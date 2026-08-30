<table class="table table-striped">
    <tr>
        <th>Tgl.pendaftaran/No.pendaftaran</th>
        <th>Tgl dan Jam</th>
        <th>Perawat 1</th>
        <th>Perawat 2</th>
        <th>DPJP</th>
        <th>Keluhan</th>
        <th>Ubah</th>
        <th>Lihat</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(count($loadRiwayat) > 0) : ?>
    <?php foreach($loadRiwayat as $row) : ?>
    <tr>
        <td><?= $modPendaftaran->tgl_pendaftaran .'/'.$modPendaftaran->no_pendaftaran; ?></td>
        <td><?= MyFormatter::formatDateTimeId($row->waktu); ?></td>
        <td><?= !empty($row->perawat1_id) ? $row->perawat1->nama_pegawai : ""; ?></td>
        <td><?= !empty($row->perawat2_id2) ? $row->perawat2Id2->nama_pegawai : ""; ?></td>
        <td><?= !empty($row->dpjp_id) ? $row->dpjp->nama_pegawai : ""; ?></td>
        <td><?= $row->keluhan; ?></td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringpostid'=>$row->monitoring_post_hd_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)); 
			?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='glyphicon glyphicon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringpostid'=>$row->monitoring_post_hd_id, 'mode'=>'view','konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)); 
			?>
        </td>
        <td>
            <a href="javascript:void(0)" onclick="hapusPost(<?= $row->monitoring_post_hd_id; ?>)" ><i class="icon-remove"></i></a>
        </td>
        <td>
            <a href="javascript:void(0)" onclick="print(<?= $_GET['pendaftaran_id'] ?>,<?= $row->monitoring_post_hd_id; ?>)" ><i class="icon-print"></i></a>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringpostid'=>$row->monitoring_post_hd_id, 'salin_id'=>1,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)); 
			?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else : ?>
    <?php endif; ?>
</table>

