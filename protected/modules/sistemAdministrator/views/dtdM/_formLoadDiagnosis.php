<tr id="tr_<?php echo $modDiagnosa->diagnosa_id; ?>">
    <td><?php echo '1'; ?></td>
    <td><?php echo $modDiagnosa->diagnosa_nama; ?></td>
    <td>
        <?php echo $modDiagnosa->diagnosa_namalainnya; ?>
        <?php echo CHtml::hiddenField('Morbiditas[0][diagnosa_id]', $modDiagnosa->diagnosa_id, array('readonly'=>true,'class'=>'span1 idDiagnosa')); ?>
    </td>
    <td><a href="#" rel="tooltip" class="batal" data-original-title="Hapus"><i class="icon-form-silang"></i></a></td>
  
</tr>
