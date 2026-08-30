<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Tgl.Pengisisan</th>
        <th>Profesi</th>
        <th>Nama Pegawai</th>
        <th>Ubah</th>
        <th>Lihat</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(count($modRiwayatPerawatan) > 0) : ?>
    <?php foreach($modRiwayatPerawatan as $row) : ?>
    <tr>
        <td><?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran)."/".$modPendaftaran->no_pendaftaran ?></td>
        <td><?= MyFormatter::formatDateTimeId($row->waktu_dialisis_pertama); ?></td>
        <td><?= $row->profesi; ?></td>
        <td><?= !empty($row->pegawai_id) ? $row->pegawai->nama_pegawai : ""; ?></td>
        <td>
            <center><?= CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'rencana_perawatan_dialisis_id'=>$row->rencana_perawatan_dialisis_id)) ?></center>
        </td>
        <td>
            <center><?= CHtml::link("<i class='glyphicon glyphicon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'rencana_perawatan_dialisis_id'=>$row->rencana_perawatan_dialisis_id, 'mode'=>'view')) ?></center>
        </td>
        <td>
            <center><a href="javascript:void(0)" onclick="hapusRiwayatPerawatan(<?= $row->rencana_perawatan_dialisis_id ?>)"><i class="icon-remove"></i></a></center>
        </td>
        <td>
            <center><a href="javascript:void(0)" onclick="print(<?= $row->rencana_perawatan_dialisis_id ?>)"><i class="icon-print"></i></a></center>
        </td>
        <td>
            <center><?= CHtml::link("<i class='fa fa-files-o'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'rencana_perawatan_dialisis_id'=>$row->rencana_perawatan_dialisis_id, 'salin'=>1)) ?></center>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>
