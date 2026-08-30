<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Waktu Pemeriksaan</th>
        <th>Dokter Pemeriksa</th>
        <th>Konsultan Nefrologi</th>
        <th>Diagnosis Masuk RS</th>
        <th>Lihat</th>
        <th>Ubah</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(!empty($modRiwayatAwalMedis)) : ?>
    <?php foreach($modRiwayatAwalMedis as $row) : ?>
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran) ."/".$modPendaftaran->no_pendaftaran ?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->tgl_pemeriksaan) ?>
        </td>
        <td>
            <?= !empty($row->dokterpemeriksa_id) ? $row->dokterpemeriksa->nama_pegawai : '' ?>
        </td>
        <td>
            <?= !empty($row->konsultan_nefrologi_id) ? $row->konsultannefrologi->nama_pegawai : '' ?>
        </td>
        <td>
            <?= !empty($row->diagnosa_id) ? $row->diagnosa->diagnosa_nama : '' ?>
        </td>
        <td>
            <?php
                echo CHtml::link("<i class='icon icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'id'=>$row->asesmen_awal_medis_id, 'mode'=>'view')); 
            ?>
        </td>
        <td>
            <?php
                echo CHtml::link("<i class='icon icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'id'=>$row->asesmen_awal_medis_id)); 
            ?>
        </td>
        <td>
            <center><a onclick="hapusRiwayat('<?php echo $row->asesmen_awal_medis_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Asesmen Awal Dialisis"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon}', 
                array('{icon}'=>'<i class="icon-print"></i>')), 
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print($row->asesmen_awal_medis_id);return false"))."&nbsp;";
            ?>
        </td>
        <td>
            <?php
                echo CHtml::link("<i class='icon icon-list'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'id'=>$row->asesmen_awal_medis_id, 'salin_id'=>1)); 
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>