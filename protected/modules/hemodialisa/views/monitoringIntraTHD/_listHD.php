<table class="table table-striped">
    <tr>
        <th>Tgl.pendaftaran/No.pendaftaran</th>
        <th>Tgl dan Jam</th>
        <th>Perawat 1</th>
        <th>Perawat 2</th>
        <th>DPJP</th>
        <th>Ubah</th>
        <th>Lihat</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(count($loadRiwayat) > 0) : ?>
    <?php foreach($loadRiwayat as $row) : ?>
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran).'/'.$modPendaftaran->no_pendaftaran ?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->tanggal); ?>
        </td>
        <td>
            <?= $row->perawat1->nama_pegawai; ?>
        </td>
        <td>
            <?= (!empty($row->perawat2_id)) ? $row->perawat2->nama_pegawai : "" ?>
        </td>
        <td>
            <?= $row->dpjp->nama_pegawai; ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringintraid'=>$row->monitoring_intra_hd_id, 'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)); 
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringintraid'=>$row->monitoring_intra_hd_id, 'mode'=>'view', 'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null,'detail'=>1)); 
            ?>
        </td>
        <td>
            <center><a onclick="hapusRiwayat('<?php echo $row->monitoring_intra_hd_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Monitoring Intra HD"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}'=>'<i class="icon-print"></i>')),
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print(".$modPendaftaran->pendaftaran_id.",".$row->monitoring_intra_hd_id.");return false"))."&nbsp;"; ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'monitoringintraid'=>$row->monitoring_intra_hd_id, 'salin_id'=>1, 'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)); 
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else : ?>
    <tr>
        <td colspan="9"><center>Tidak ada data</center></td>
    </tr>
    <?php endif; ?>
</table>
