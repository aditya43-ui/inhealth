<tr>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]tandagejala_daftar_nama', array('class' => 'tandagejala_daftar_nama span10', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]tandagejala_id', array());?>
        <?php echo CHtml::activeHiddenField($model, '[ii]diagnosakep_id', array());?>
        <?php echo CHtml::activeHiddenField($model, '[ii]kelompoktandagejaladaftar_id', array('class' => 'kelompoktandagejaladaftar_id'));?> 
    </td>
    <td style="text-align: center"><?php echo CHtml::activeCheckBox($model,'[ii]tandagejala_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk menonaktifkan status Tanda Gejala', 'onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>$model->tandagejala_aktif)); ?></td>  
    <td style="text-align: center">
        <?php if(empty($model->tandagejala_id)) : ?>
            <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Hapus Indikator', 'class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
        <?php endif; ?>
    </td>
</tr>        