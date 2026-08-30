<tr>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[0]dokumenpengadaan_id',array('readonly'=>true));?>
        <?php echo CHtml::activeHiddenField($model, '[0]jenispengadaan_id',array('readonly'=>true));?>
        <?php echo CHtml::activeHiddenField($model, '[0]dokumenpengadaan_jenistransaksi',array('readonly'=>true));?>
        <?php echo CHtml::activeTextField($model, '[0]dokumenpengadaan_nama',array('class'=>'span3'));?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[0]dokumenpengadaan_namalain',array('class'=>'span3'));?>	
    </td>
    <td>
        <?php echo CHtml::activeTextArea($model, '[0]dokumenpengadaan_deskripsi',array('class'=>'span3'));?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[0]dokumenpengadaan_urutan',array('class'=>'span3'));?>	
    </td>
    <td style="text-align: center">
        <?php if (isset($_POST['is_update'])): ?><?php echo CHtml::activeCheckBox($model, '[0]dokumenpengadaan_aktif',array('class'=>'span1')); ?><?php endif; ?>
    </td>
    <td>
        <?php echo CHtml::activeCheckBox($model, '[0]dokumenpengadaan_wajib',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_zip',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_rar',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_word',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_pdf',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_excel',array('class'=>'span1'));?>	
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[0]file_image',array('class'=>'span1'));?>	
    </td>  
    <td style="text-align: center;" class="rowbutton span3">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
    </td>
</tr>