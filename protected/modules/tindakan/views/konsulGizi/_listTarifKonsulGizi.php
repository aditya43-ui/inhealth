<?php 
        if(!empty($modTarif)){
//        foreach ($modTarif as $i => $konsul) { 
    ?>
        <tr>
            <td><?php echo $modTarif->daftartindakan->daftartindakan_nama ?></td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan); ?>
                <?php echo CHtml::hiddenField('daftartindakan_id['.$modTarif->daftartindakan_id.']',$modTarif->daftartindakan_id,array('class'=>'daftartindakan_id')); ?>
            </td>
        </tr>
    <?php //} ?>
    <?php }else{ ?>
        <tr>
            <td colspan="3">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>