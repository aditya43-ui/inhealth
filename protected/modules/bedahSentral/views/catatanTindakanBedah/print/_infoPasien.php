<table class="tab-detail1">
    <tr>
        <td width="150">No. Rekam Medik</td>
        <td width="10">:</td>
        <td width="35%"><?php echo $model->no_rekam_medik; ?></td>
        <td width="150">Tanggal Lahir</td>
        <td width="10">:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $model->nama_pasien; ?></td>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $model->umur; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $model->no_pendaftaran; ?></td>
        <td>Instalasi Asal</td>
        <td>:</td>
        <td><?php echo $model->instalasiasal_nama; ?></td>
    </tr>
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran); ?></td>
        <td>Ruangan Asal</td>
        <td>:</td>
        <td><?php echo $model->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $model->jeniskelamin; ?></td>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $model->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $model->penjamin_nama; ?></td>
    </tr>
</table>