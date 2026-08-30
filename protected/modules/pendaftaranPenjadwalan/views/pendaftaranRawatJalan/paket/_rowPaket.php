<tr data-id="<?php echo $paket->paketbmhp_id; ?>">
    <td><?php 
        echo CHtml::hiddenField('paket_medis['.$paket->paketbmhp_id.']', $paket->paketbmhp_id);
        echo $paket->tipepaket->tipepaket_nama; 
    ?></td>
    <td><?php echo $paket->paketbmhp_nama; ?></td>
    <td><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
        'onclick'=>'hapusRowPaket(this); return false;'
    ));?> </td>
</tr>