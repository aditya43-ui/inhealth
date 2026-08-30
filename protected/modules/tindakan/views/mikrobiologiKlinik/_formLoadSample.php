<tr id="pemeriksaanSpesimen_<?php echo $modSample->samplelab_id; ?>">
    <td>
        <?php echo $modSample->samplelab_namalainnya; ?>
        <?php echo CHtml::hiddenField("samplelab[samplelab_id][]", $modSample->samplelab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $modSample->samplelab_nama; ?>
    </td>
    <td>
        <?php echo $modSample->lokasi; ?>
    </td>
    <td>
        <?php echo CHtml::textField("samplelab[inputqty][]", '1',array('class'=>'inputFormTabel lebar1 integer gty span2 jumlahspesimen', 'onkeyup'=>'hitungTotal();',)); ?>
    </td>
</tr>   