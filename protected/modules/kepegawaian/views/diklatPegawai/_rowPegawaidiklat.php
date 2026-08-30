<?php 
    $i = (isset($i) ? $i : '' );
    $no = '';
?>
<tr>
	<td>
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']no',array('readonly'=>true,'style'=>'width:20px;','value'=>$no,'id'=>'KPPegawaidiklat_no')) ?>
	</td>
	<td>
		<?php echo $form->dropDownList($modPegawaidiklat,'['.$i.']jenisdiklat_id',CHtml::listData($modPegawaidiklat->getJenisdiklatItems(),'jenisdiklat_id','jenisdiklat_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:120px;')) ?>
	</td>
	<td style="padding-right: 0;">
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']pegawaidiklat_nama',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
	</td>
	<td>
		<?php 
			$this->widget('MyDateTimePicker',array(
									'model'=>$modPegawaidiklat,
									'attribute'=>'['.$i.']pegawaidiklat_tahun',
									'mode'=>'date',
									'options'=> array(
										'showOn' => false,
										// 'maxDate' => 'd',
										'yearRange'=> "-150:+0",
									),
									'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
									),
		)); ?>
	</td>
	<td>
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']pegawaidiklat_lamanya',array('class'=>'numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:30px;')); ?>
		<?php echo $form->dropDownList($modPegawaidiklat,'['.$i.']pegawaidiklat_lamanyasatuan',array('tahun'=>'tahun','bulan'=>'bulan','hari'=>'hari'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:55px;')) ?>
	</td>
	<td>
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']pegawaidiklat_tempat',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
	</td>
	<td>
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']nomorkeputusandiklat',array('class'=>'span2 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px')); ?>
	</td>
	<td>
		<?php 
		$this->widget('MyDateTimePicker',array(
								'model'=>$modPegawaidiklat,
								'attribute'=>'['.$i.']tglditetapkandiklat',
								'mode'=>'date',
								'options'=> array(
									'showOn' => false,
									// 'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
								),
		)); ?>
	</td>
	<td>
		<?php echo $form->textField($modPegawaidiklat,'['.$i.']pejabatygmemdiklat',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')) ?>
	</td>
	<td>
		<?php echo $form->textArea($modPegawaidiklat,'['.$i.']pegawaidiklat_keterangan',array('onkeypress'=>"(this)",'rows'=>'3','col'=>'2','class'=>'span2')); ?>
	</td>
	<td style="width:50px;">
		<?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahPegawaidiklat(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
		<?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusPegawaidiklat(this);return false','style'=>'cursor:pointer;')); ?>
	</td>
</tr>