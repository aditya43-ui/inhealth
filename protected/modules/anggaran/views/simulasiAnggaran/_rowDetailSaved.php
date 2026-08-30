<tr>
    <td style="width:50px;">
        <?php echo CHtml::textField('no_urut',$i+1,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo (!empty($model->subkegiatanprogram->subkegiatanprogram_kode) ? $model->subkegiatanprogram->subkegiatanprogram_kode.' - ' : "") ?>
        <?php echo (!empty($model->subkegiatanprogram->subkegiatanprogram_nama) ? $model->subkegiatanprogram->subkegiatanprogram_nama : "") ?>
    </td>
    <td style="width:150px;">
        <?php echo (!empty($model->nilai_anggaran) ? MyFormatter::formatUang($model->nilai_anggaran) : "") ?>
    </td>
    <td style="width:100px; text-align: right;">
        <?php echo CHtml::ActiveTextField($model,'['.$i.']kenaikan_persen',array('class'=>'span2 integer','style'=>'width:30px;','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
    </td>
     <td style="width:100px;">
        <?php echo CHtml::ActiveTextField($model,'['.$i.']kenaikan_rupiah',array('class'=>'span2 integer','style'=>'width:100px;','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
    </td>
    <td style="width:100px;">
        <?php echo CHtml::ActiveTextField($model,'['.$i.']total_nilaianggaran',array('class'=>'span2 integer','style'=>'width:100px;','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
    </td>
</tr>
