<?php 
$i = (isset($i) ? $i : '' );
?>
<tr>
	<td>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']nourut_pend',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:30px;')) ?>
	</td>
	<td>
		<?php echo $form->dropDownList($modPendidikanpegawai,'['.$i.']pendidikan_id',CHtml::listData($modPendidikanpegawai->getPendidikanItems(),'pendidikan_id','pendidikan_nama'),array('empty'=>'-- Pilih --','style'=>'width:60px;','class'=>'required')) ?>
	</td>
	<td>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']namasek_univ',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
	</td>
	<td>
		<?php echo $form->textArea($modPendidikanpegawai,'['.$i.']almtsek_univ',array('rows'=>3,'cols'=>3,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	</td>
	<td>
		<?php 
		$this->widget('MyDateTimePicker',array(
								'model'=>$modPendidikanpegawai,
								'attribute'=>'['.$i.']tglmasuk',
								'mode'=>'date',
								'options'=> array(
									'showOn' => false,
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
								),
		)); ?>
	</td>
	<td>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']lamapendidikan_bln',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 num')); ?>
                <?php echo $form->dropDownList($modPendidikanpegawai,'['.$i.']satuan',array('tahun'=>'tahun','bulan'=>'bulan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:55px;')) ?>
	</td>
	<td>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']no_ijazah_sert',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
	</td>
	<td>
		<?php   
		$this->widget('MyDateTimePicker',array(
								'model'=>$modPendidikanpegawai,
								'attribute'=>'['.$i.']tgl_ijazah_sert',
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
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']ttd_ijazah_sert',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
	</td>
	<td>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']nilailulus',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px;')); ?>
		<?php echo ' / '; ?>
		<?php echo $form->textField($modPendidikanpegawai,'['.$i.']gradelulus',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px;')); ?>
	</td>
	<td>
		<?php echo $form->textArea($modPendidikanpegawai,'['.$i.']keteranganpend',array('rows'=>2,'class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:50px;','class'=>'keterangan')); ?>
	</td>
	<td>
		<?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahPendidikanpegawai(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
		<?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusPendidikanpegawai(this);return false;','style'=>'cursor:pointer;')); ?>
	</td>
</tr>