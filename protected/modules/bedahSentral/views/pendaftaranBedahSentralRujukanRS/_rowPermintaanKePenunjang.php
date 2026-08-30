<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo (!empty($modPermintaan->daftartindakan_id) ? $modPermintaan->operasi->operasi_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']operasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php 
        // if(!empty($modPermintaan->tarif_pelayananan )){
            echo MyFormatter::formatNumberForUser($modPermintaan->tarif_pelayananan);
        // }else{
        //     echo $
        // }
        ?>
    </td>
</tr>

