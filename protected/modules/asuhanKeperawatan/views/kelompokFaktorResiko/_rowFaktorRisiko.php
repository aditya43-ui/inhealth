<tr>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]faktorrisiko_daftar_nama', array('class' => 'faktorrisiko_daftar_nama span10', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]jenisfaktorrisiko_id', array());?>
        <?php echo CHtml::activeHiddenField($model, '[ii]kelompokfaktorrisikodaftar_id', array('class' => 'kelompokfaktorrisikodaftar_id'));?> 
        <?php echo CHtml::activeHiddenField($model, '[ii]faktorrisiko_daftar_id', array('class' => 'faktorrisiko_daftar_id'));?> 
    </td>
    <td style="text-align: center"><?php echo CHtml::activeCheckBox($model,'[ii]kelompokfaktorrisikodaftar_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk menonaktifkan status Kelompok Faktor Risiko', 'onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>$model->kelompokfaktorrisikodaftar_aktif)); ?></td>  
    <td style="text-align: center">
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Hapus Kelompok Faktor Risiko', 'class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
    </td>
</tr> 
