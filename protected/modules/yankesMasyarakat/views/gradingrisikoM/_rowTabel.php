<tr>
	<td style="text-align: center;">
		<?php echo CHtml::textField("noUrut", $i,array('readonly'=>true,'class'=>'nourut span1'));?>		
	</td>
        <td style="text-align: center;">
            <?php echo CHtml::activeHiddenField($model, '[ii]peluang_id',array('class'=>'span3 peluang_id','readonly'=>true));?>		
            <?php echo CHtml::activeTextField($model, '[ii]peluang_descriptor',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;">
            <?php echo CHtml::activeHiddenField($model, '[ii]konsekuensi_id',array('class'=>'span3 konsekuensi_id','readonly'=>true));?>		
            <?php echo CHtml::activeTextField($model, '[ii]konsekuensi_namabobot',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
            <?php echo CHtml::activeHiddenField($model, '[ii]tingkatrisiko_id',array('class'=>'span3 tingkatrisiko_id','readonly'=>true));?>		
            <?php echo CHtml::activeTextField($model, '[ii]tingkatrisiko_nama',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
            <?php echo CHtml::activeTextField($model, '[ii]warnarisiko',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]gradingrisiko_aktif',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusTemporary(this)')); ?>
	</td>
</tr>