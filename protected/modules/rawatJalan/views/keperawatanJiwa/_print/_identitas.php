<table class="form_predispo">
    <tr>
        <td width="200">Inisial</td>
        <td width="10">:</td>
        <td><?php 
        $pasien = explode(" ", $modPasien->nama_pasien);
        
        foreach ($pasien as $item) {
            echo empty($item[0]) ? "" : $item[0];
        }
        
        echo " (".$modPasien->jeniskelamin[0].")";
        
        ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td>Informan</td>
        <td>:</td>
        <td><?php echo $model->informan; ?></td>
    </tr>
    <tr>
        <td>Tanggal Pengkajian</td>
        <td>:</td>
        <td><?php echo $model->tgl_pengkajian; ?></td>
    </tr>
    <tr>
        <td>No. RM</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
</table>
