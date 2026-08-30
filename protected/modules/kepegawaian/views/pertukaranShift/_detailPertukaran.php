<div class="overflow-x">
	<table class="items table table-striped table-condensed table-bordered" id="tabel-pertukaran">
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No. Induk Pegawai</th>
				<th>Nama Pegawai</th>
				<th>Asal Shift</th>
				<th>Perubahan Shift</th>
				<th>Alasan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1.
					<?php echo CHtml::hiddenField('row',0,array('class'=>'span1','style'=>'width:30px','readonly'=>true)); ?>
				</td>
				<td>
					<!--<div class="input-append"><?php //echo CHtml::activeTextField($modDetail, '[ii]tglpertukaranjadwal', array('class'=>'date pertukarantgl', 'style'=>'float:left;width:100px;','value'=>date('d/m/Y'),'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?><span class="add-on"><i class="entypo-calendar"></i></span></div>-->
					<?php
						
					
						$this->widget('MyDateTimePicker',array(
							'model'=>$modDetail,
							'attribute'=>'[0]tglpertukaranjadwal',
							'mode'=>'date',
							'options'=> array(
								'showOn' => false,
								'maxDate' => 'd',
								'yearRange'=> "-150:+0",
							),
							'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:130px;'
							),
));
					?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel datapegawai')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalandetail_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nomorindukpegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Data Pegawai');"),
                                'htmlOptions'=>array('placeholder'=>'Nomor Induk Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nama_pegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Data Pegawai');"),
                                'htmlOptions'=>array('placeholder'=>'Nama Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 autocomplete-pegawai required','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shiftasal_id', array(),array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''));//untuk_tgltukar ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shift_id', array(),array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''));//CHtml::listData(KPShiftM::model()->findAll(" shift_aktif = TRUE ORDER BY shift_nama ASC "),'shift_id','ShiftJam') ?></td>
				<td><?php echo CHtml::activeTextArea($modDetail, '[ii]alasanpertukaran',array('class'=>'span2 autogrow required','rows'=>1,'cols'=>5)); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail,'[ii]ketranganpertukaran', LookupM::getItems('tukarshift'), array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''))?></td>
			</tr>			
			<tr>
				<td>2.
					<?php echo CHtml::hiddenField('row',0,array('class'=>'span1','style'=>'width:30px','readonly'=>true)); ?>
				</td>
				<td>
					<!--<div class="input-append"><?php //echo CHtml::activeTextField($modDetail, '[ii]tglpertukaranjadwal', array('class'=>'date pertukarantgl', 'style'=>'float:left;width:100px;','value'=>date('d/m/Y'),'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?><span class="add-on"><i class="entypo-calendar"></i></span></div>-->
					<?php
						$this->widget('MyDateTimePicker',array(
							'model'=>$modDetail,
							'attribute'=>'[1]tglpertukaranjadwal',
							'mode'=>'date',
							'options'=> array(
								'showOn' => false,
								'maxDate' => 'd',
								'yearRange'=> "-150:+0",
							),
							'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:130px;'
							),
));
					?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel datapegawai')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalandetail_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nomorindukpegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Data Pegawai');"),
                                'htmlOptions'=>array('placeholder'=>'Nomor Induk Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nama_pegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Data Pegawai');"),
                                'htmlOptions'=>array('placeholder'=>'Nama Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 autocomplete-pegawai required','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shiftasal_id', array(),array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''));//CHtml::listData(KPShiftM::model()->findAll(" shift_aktif = TRUE ORDER BY shift_nama ASC "),'shift_id','ShiftJam') ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shift_id', array(),array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''));//CHtml::listData(KPShiftM::model()->findAll(" shift_aktif = TRUE ORDER BY shift_nama ASC "),'shift_id','ShiftJam') ?></td>
				<td><?php echo CHtml::activeTextArea($modDetail, '[ii]alasanpertukaran',array('class'=>'span2 autogrow required','rows'=>1,'cols'=>5)); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail,'[ii]ketranganpertukaran', LookupM::getItems('tukarshift'), array('empty'=>'-- Pilih --','class'=>'span2 required','style'=>''))?></td>
			</tr>			
		</tbody>
	</table>
</div>