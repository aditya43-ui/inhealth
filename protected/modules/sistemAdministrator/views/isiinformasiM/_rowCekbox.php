<tr>
    <td>
        <?php // echo CHtml::hiddenField('detail[ii][jenisinformasi_id]', $model->jenisinformasi_id, array('class'=>'infosebelumcheckbox span3')); ?>
        <?php echo CHtml::textArea('detail[ii][infosebelumcheckbox]', $model->infosebelumcheckbox, array('class'=>'infosebelumcheckbox span3')); ?>
    </td>
    <td><?php echo CHtml::textArea('detail[ii][isiinformasi_nama]', $model->isiinformasi_nama, array('class'=>'isiinformasi_nama span3')); ?></td>
    <td><?php echo CHtml::textField('detail[ii][isiinformasi_urutan]', $model->isiinformasi_urutan, array('class'=>'isiinformasi_urutan span1', 'style'=>'text-align: right;')); ?></td>
    <td><?php echo CHtml::textArea('detail[ii][infosetelahcheckbox]', $model->infosetelahcheckbox, array('class'=>'infosetelahcheckbox span3')); ?></td>
    <td>
        <?php echo CHtml::htmlButton('<i class="glyphicon glyphicon-minus"></i>', array('class'=>'btn btn-danger', 'onclick'=>'hapusRowCheckbox(this);')); ?>
    </td>
</tr>