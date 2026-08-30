<tr>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]faktorrisiko_daftar_nama', array('class' => 'faktorrisiko_daftar_nama span10', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]faktorrisiko_id', array());?>
        <?php echo CHtml::activeHiddenField($model, '[ii]diagnosakep_id', array());?>
        <?php echo CHtml::activeHiddenField($model, '[ii]kelompokfaktorrisikodaftar_id', array('class' => 'kelompokfaktorrisikodaftar_id'));?> 
    </td>
    <td style="text-align: center"><?php echo CHtml::activeCheckBox($model,'[ii]faktorrisiko_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk menonaktifkan status Tanda Gejala', 'onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>$model->faktorrisiko_aktif)); ?></td>  
    <td style="text-align: center">
        <?php if(empty($model->faktorrisiko_id)) : ?>
            <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Hapus Indikator', 'class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
        <?php endif; ?>
    </td>
</tr>        