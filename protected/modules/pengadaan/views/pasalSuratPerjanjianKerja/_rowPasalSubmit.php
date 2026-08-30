<?php
    $mod = PasalperjanjianM::model()->findBypk($item->pasalperjanjian_id);
?>

<tr>
    <td class="html_no" data-id="<?php echo $item->pasalperjanjian_id; ?>"><?php echo $no; ?></td>
    <td class="html_nama"><?php echo $mod->pasalperjanjian_nama; ?></td>
    <td class="html_uraian"><?php echo $mod->pasalperjanjian_uraian; ?></td>
    <td class="html_isi"><?php echo $item->pasalperjanjian_isi; ?></td>
    <td style="text-align: center;">
        <?php 
        echo CHtml::hiddenField('detail['.$item->pasalperjanjian_id.'][isi]', $item->pasalperjanjian_isi, array(
            'class'=>'pasalperjanjian_isi'
        ));
        echo CHtml::hiddenField('detail['.$item->pasalperjanjian_id.'][uraian]', '', array(
            'class'=>'pasalperjanjian_uraian'
        ));
        
        echo CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
            'onclick'=>'hapusPasal(this); return false;',
        )); ?>
    </td>
</tr>