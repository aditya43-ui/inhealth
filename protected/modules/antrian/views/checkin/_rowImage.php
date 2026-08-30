<tr>
    <td>
        <?php echo CHtml::label("Tanda tangan :", 'ttd_text', array('class' => 'control-label')) ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeHiddenField($modSep, '[0]ttd_text',array('class'=>'text_resep','readonly'=>true));
            echo CHtml::activeTextField($modSep,'[0]ttd_link',array('class'=>'text_image','readonly'=>true));
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