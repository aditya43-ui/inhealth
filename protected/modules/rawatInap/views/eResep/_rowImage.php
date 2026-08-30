<tr>
    <td>
        eResep : 
    </td>
    <td>
        <?php 
            echo CHtml::activeHiddenField($modEresep, '[0]eresep_text',array('class'=>'text_resep','readonly'=>true));
            echo CHtml::activeTextField($modEresep,'[0]eresep_image',array('class'=>'text_image','readonly'=>true));
        ?>
    </td>
     <td width="10%">
        <?php echo CHtml::link("<i class='".MyIcon::getIcons('lihat')."'></i>",'javascript:void(0);',array(
            'rel'=>'tooltip',
            'onclick'=>'lihatImage(this);',
            )) ?>
    </td>
    <td width="10%">
        <?php echo CHtml::link("<i class='glyphicon glyphicon-trash'></i>",'javascript:void(0);',array('onclick'=>'hapusRow(this);')) ?>
    </td>
</tr>