<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Pengguna</th>
            <th>Catatan</th>
            <th>Status</th>
            <th>Lampiran</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($modRiwayat)){
                $i=1;
                foreach($modRiwayat as $riwayat){
                    if(!empty($riwayat->jabatan_pengadaan)){
                        $jabatan_pengadaan = '('.$riwayat->jabatan_pengadaan.')';
                    }else{
                        $jabatan_pengadaan = '';
                    }
        ?>
        <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tanggal_update);?></td>
            <td><?php echo $riwayat->nama_pegawai.' '.$jabatan_pengadaan;?></td>
            <td><?php echo $riwayat->riwayatpengadaan_catatan;?></td>
            <td><?php echo $riwayat->status_berkas;?></td>
            <td><?php echo CHtml::link($riwayat->riwayatpengadaan_lampiran, $this->createUrl('UnduhRiwayat', array('id' => $riwayat->riwayatpengadaan_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip'));?></td>
        </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>