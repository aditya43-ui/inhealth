<style>
    
    .tab_header td {
        vertical-align: top;
        padding: 3px;
    }
    
    .tab_header {
        width: 100%;
    }
    
    .tab_header .border-down td {
        border-bottom: 1px solid black;
    }
    
</style>

<table class="tab_header">
    <tr>
        <td width="200"><?php echo $model->getAttributeLabel('tgl_pendaftaran'); ?></td>
        <td width="10">:</td>
        <td><?php echo $model->tgl_pendaftaran; ?></td>
        <td width="200"><?php echo $model->getAttributeLabel('no_rekam_medik'); ?></td>
        <td width="10">:</td>
        <td><?php echo $model->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->getAttributeLabel('no_pendaftaran'); ?></td>
        <td>:</td>
        <td><?php echo $model->no_pendaftaran; ?></td>
        <td><?php echo $model->getAttributeLabel('nama_pasien'); ?></td>
        <td>:</td>
        <td><?php echo $model->nama_pasien; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->getAttributeLabel('instalasiasal_nama'); ?></td>
        <td>:</td>
        <td><?php echo $model->instalasiasal_nama; ?></td>
        <td><?php echo $model->getAttributeLabel('tanggal_lahir'); ?></td>
        <td>:</td>
        <td><?php echo $model->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->getAttributeLabel('ruanganasal_nama'); ?></td>
        <td>:</td>
        <td><?php echo $model->ruanganasal_nama; ?></td>
        <td><?php echo $model->getAttributeLabel('alamat_pasien'); ?></td>
        <td>:</td>
        <td><?php echo $model->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td><?php echo $model->getAttributeLabel('carabayar_nama'); ?></td>
        <td>:</td>
        <td><?php echo $model->carabayar_nama; ?></td>
        <td><?php echo $model->getAttributeLabel('jeniskelamin'); ?></td>
        <td>:</td>
        <td><?php echo $model->jeniskelamin; ?></td>
    </tr>
    <tr class="border-down">
        <td><?php echo $model->getAttributeLabel('penjamin_nama'); ?></td>
        <td>:</td>
        <td><?php echo $model->penjamin_nama; ?></td>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>