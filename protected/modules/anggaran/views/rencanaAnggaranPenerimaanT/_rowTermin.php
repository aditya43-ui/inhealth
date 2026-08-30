<?php for ($i = 1; $i <= $termin; $i++) {  ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',''.$i.'',array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo $format->formatNumberForUser($i); ?>
		<?php echo CHtml::activeHiddenField($modDetail,'['.$i.']termin',array('value'=>$i,'class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true)); ?>
    </td>
	<td>
	<div class="input-append">
		<?php echo CHtml::activeTextField($modDetail, '['.$i.']tglrenanggaranpen', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;')); ?>
		<span class="add-on"><i class="entypo-calendar"></i></span>
	</div>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modDetail,'['.$i.']hasil',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true)); ?>
	</td>
    <td>
        <a onclick="batalRencana(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php } ?>