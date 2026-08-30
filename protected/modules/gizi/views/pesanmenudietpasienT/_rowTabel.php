<tr>
    <td>
        <label>
        <span class="instalasi_ruangan">
            <?php echo $model->instalasi_nama.'/<br/>'.$model->ruangan_nama; ?>
        </span>
        </label>
    </td>
    <td>
        <label>
        <span class="pendaftaran">
            <?php echo $model->no_pendaftaran.'/<br/>'.$model->no_rekam_medik; ?>
        </span>
        </label>
    </td>
    <td>
        <label>
        <span class="nama_pasien">
            <?php echo $model->nama_pasien; ?>
        </span>
        </label>
    </td>
    <td>
        <label>
        <span class="jeniskelamin">
            <?php echo $model->jeniskelamin.'/<br/>'.$model->umur; ?>
        </span>
        </label>
    </td>
    <td>
        <label>
            <label>
            <span class="jenismakanan">
                <?php echo $model->jenismakanan_nama; ?>
            </span>
            </label>
        </label>
    </td>
    <td>
        <label>
            <span class="jenisdiet">
                <?php echo $model->jenisdiet_nama; ?>
            </span>
        </label>
    </td>
    <td>
        <label>
            <span class="jeniswaktu">
                <?php echo $model->jeniswaktu_nama; ?>
            </span>
        </label>
    </td>
    <td hidden>
        <?php echo CHtml::activeDropDownList($model, '['.$i.']alatmakanan_id', $dropAlatMakanan,array()); ?>
    </td>
</tr>