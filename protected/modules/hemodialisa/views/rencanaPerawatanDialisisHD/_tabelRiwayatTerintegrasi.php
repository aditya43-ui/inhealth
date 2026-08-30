<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Tgl Pengisian</th>
        <th>Profesi</th>
        <th>Nama Pegawai</th>
        <th>Salin</th>
    </tr>
    <?php if(count($modRiwayatTerintegrasi) > 0) : ?>
    <?php foreach($modRiwayatTerintegrasi as $row) : ?>
    
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran)."/".$modPendaftaran->no_pendaftaran ?>
        </td>
        <td><?= MyFormatter::formatDateTimeId($row->tgltransaksi); ?></td>
        <td><?= $row->profesi; ?></td>
        <td><?php
            if(!empty($row->pegawai_id)){
                $pegawai = PegawaiM::model()->findByPk($row->pegawai_id);
                echo $pegawai->nama_pegawai;
            }else{
                echo "";
            }
        ?></td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'perkembangan_terintegrasi_pasien_id'=>$row->perkembangan_terintegrasi_pasien_id)); 
			?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>