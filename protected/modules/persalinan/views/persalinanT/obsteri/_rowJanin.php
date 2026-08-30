<?php
$valueFrekuensi = (!empty($valuefrekuensi) ? $valuefrekuensi: '');
$valueDjj = (!empty($valuedjj)?$valuedjj:'');
$valueLetak = (!empty($valueletak)? $valueletak:'');
?>

<tr>
    <td>
        <?php echo CHtml::textField('frek_auskultasi',$valueFrekuensi,array('class'=>'frek_auskultasi span3')); ?> <label> /menit</label>
        
    </td>
    <td>
        <?php echo CHtml::dropDownList('denyutjantung_janin',$valueDjj, LookupM::getItems('denyutjantung'), array('empty' => '-- Pilih --', 'class' => 'span3 denyutjantung_janin', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>    
    </td>
    <td>
        <?php echo CHtml::dropDownList('posisijanin',$valueLetak, LookupM::getItems('posisijanin'), array('empty' => '-- Pilih --', 'class' => 'span3 posisijanin', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>    
    </td>

    <td style="text-align: center;"><?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array('class'=>'btn btn-danger', 'onclick'=>'hapusJaninObs(this);')); ?></td>
</tr>