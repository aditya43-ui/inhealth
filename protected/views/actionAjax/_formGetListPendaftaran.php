<table class="table table-condensed" id="listPendaftaran">
    <tr>
        <th>Tgl. Pendaftaran</th>
        <th>No. Pendaftaran</th>
        <th>Pilih</th>
    </tr>
    <tr>
        <?php foreach ($modPendaftaran as $i => $pendaftaran) { ?>
            <td><?php echo $pendaftaran->tgl_pendaftaran ?></td>
            <td>
                <?php echo $pendaftaran->no_pendaftaran ?>
                <?php echo CHtml::hiddenField('id_pendaftaran',$pendaftaran->pendaftaran_id) ?>
            </td>
            <td><a href="#" onClick="getListJadwalKunjungan(<?php echo $pendaftaran->pendaftaran_id ?>);"><i class="icon icon-check"></i></a></td>
        <?php } ?>
    </tr>
</table>
