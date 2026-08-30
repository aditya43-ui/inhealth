<tr>
    <td>
		<?php echo CHtml::activeHiddenField($modKondisiPasienAnestesi, '[0]kondisipasienanestesi_id', array('readonly'=>false,'class'=>'span1')) ?>
		<?php echo CHtml::hiddenField('no_urut', '1', array('readonly'=>false,'class'=>'span1')) ?>
			<?php 
			$modKondisiPasienAnestesi->tglpemantauan = isset($modKondisiPasienAnestesi->tglpemantauan) ? MyFormatter::formatDateTimeForUser($modKondisiPasienAnestesi->tglpemantauan) : "";
			$this->widget('MyDateTimePicker', array(
				'model'=>$modKondisiPasienAnestesi,
				'attribute'=>'[0]tglpemantauan',
				'value' => 'tglpemantauan', 
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;', 'onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'tglpemantauan'),
			));?>
	</td>
	<td><?php 
			$modKondisiPasienAnestesi->jammulai = isset($modKondisiPasienAnestesi->jammulai) ? $modKondisiPasienAnestesi->jammulai : "";
			$this->widget('MyDateTimePicker', array(
				'model'=>$modKondisiPasienAnestesi,
				'attribute'=>'[0]jammulai',
				'value' => 'jammulai', 
				'mode' => 'time',
				'options' => array(
//					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;', 'onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'tglpemantauan'),
			));?>
	</td>
	<td>
		<?php 
			$modKondisiPasienAnestesi->jamselesai = isset($modKondisiPasienAnestesi->jamselesai) ? $modKondisiPasienAnestesi->jamselesai : "";
			$this->widget('MyDateTimePicker', array(
				'model'=>$modKondisiPasienAnestesi,
				'attribute'=>'[0]jamselesai',
				'value' => 'jamselesai', 
				'mode' => 'time',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;', 'onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'tglpemantauan'),
		));?>
	</td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]menitke', array('readonly'=>false,'class'=>'span2')) ?></td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]oksigen_liter', array('readonly'=>false,'class'=>'span2')) ?></td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]ventilasi_mmhg', array('readonly'=>false,'class'=>'span2')) ?></td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]sirkulasi', array('readonly'=>false,'class'=>'span2')) ?></td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]suhu', array('readonly'=>false,'class'=>'span1')) ?></td>
	<td><?php echo CHtml::activeTextField($modKondisiPasienAnestesi, '[0]perfusijaringan', array('readonly'=>false,'class'=>'span2')) ?></td>    
	<td>
        <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowPemantauan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah pemantauan kondisi pasien')); 
                echo "<br/><br/>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalPemantauan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan pemantauan kondisi pasien'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowPemantauan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah pemantauan kondisi pasien'));
            }
        ?>
    </td>
</tr>
