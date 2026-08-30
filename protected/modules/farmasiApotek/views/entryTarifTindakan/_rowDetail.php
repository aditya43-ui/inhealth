<tr>
    <td>
        <span class="nourut">
        </span>
    </td>
    <td>
        <?= $modTindakanPelayanan->daftartindakan_kode ?? '' ?>
        
        <?= CHtml::activehiddenField($modTindakanPelayanan, '[ii]daftartindakan_id') ?>
    </td>
    <td>
        <?= $modTindakanPelayanan->daftartindakan_nama ?? '' ?>
    </td>
    <td>
        <?= CHtml::activeTextField($modTindakanPelayanan, '[ii]jumlahtarif', ['readonly' => true]) ?>
    </td>
    <td>
        <center>
            <a onclick="batalTindakan(this);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-remove"></i></a>
        </center>
    </td>
</tr>