<div class="overflow-x">
    <table class="table table-striped ">
        <tr>
            <th>Tgl.Pendaftaran/No.Pendaftaran</th>
            <th>Tgl.Darah Diterima</th>
            <th>Nama DPJP</th>
            <th>Suhu Coolbox (&#8451;)</th>
            <th>Obat-obatan sebelum transfusi</th>
            <th>Lihat</th>
            <th>Ubah</th>
            <th>Hapus</th>
            <th>Salin</th>
        </tr>
        <?php if(count($loadRiwayat) > 0) : ?>
        <?php foreach($loadRiwayat as $row) : ?>
        <tr>
            <td>
                <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran) .'/'. $modPendaftaran->no_pendaftaran ?>
            </td>
            <td>
                <?= MyFormatter::formatDateTimeId($row->waktu_darah_diterima); ?>
            </td>
            <td>
                <?= $row->pegawai->nama_pegawai; ?>
            </td>
            <td>
                <?= $row->suhu_coolbox ?>
            </td>
            <td>
                <?php
                $detail = ObatSebelumTransfusiT::model()->findAll("observasi_transfusi_darah_id = ".$row->kantong_transfusi_darah_id);
                $data = "";
                if(count($detail) > 0){
                    foreach($detail as $det){
                        $data .= $det->nama_obat.' - ';
                    }
                }
                echo $data;
                ?>
            </td>
            <td>
                <?php
                echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantongdarahid'=>$row->kantong_transfusi_darah_id, 'mode'=>'view')); 
                ?>
            </td>
            <td>
                <?php
                echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantongdarahid'=>$row->kantong_transfusi_darah_id)); 
                ?>
            </td>
            <td>
                <center><a onclick="hapusRiwayat('<?= $row->kantong_transfusi_darah_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Kantong Darah"><i class="entypo-trash"></i></a></center>
            </td>
            <?php /*
            <td>
                <center><a onclick="print('<?= $_GET['pendaftaran_id']; ?>','<?= $row->kantong_transfusi_darah_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk cetak Riwayat Kantong Darah"><i class="entypo-print"></i></a></center>
            </td>
             * 
             */?>
            <td>
                <?php
                echo CHtml::link("<i class='icon-copy'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'kantongdarahid'=>$row->kantong_transfusi_darah_id, 'salin_id'=>1)); 
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>