<tr>
    <td class="html_no" data-id=""></td>
    <td class="html_nama"></td>
    <td class="html_uraian"></td>
    <td class="html_isi"></td>
    <td style="text-align: center;">
        <?php 
        echo CHtml::hiddenField('detail[ii][isi]', '', array(
            'class'=>'pasalperjanjian_isi'
        ));
        echo CHtml::hiddenField('detail[ii][uraian]', '', array(
            'class'=>'pasalperjanjian_uraian'
        ));
        
        echo CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
            'onclick'=>'hapusPasal(this); return false;',
        )); ?>
    </td>
</tr>