<tr>
	<td>
		<div class="control-group">
			<?php //echo CHtml::label("Pegawai",'pegawai_id',array('class'=>'control-label')) ?>
			<div class="controls">
					<?php
						echo CHtml::activeHiddenField($model,'[ii]pegawai_id',array());
						$model->nama_pegawai = (isset($model->pegawai->nama_pegawai) ? $model->pegawai->nama_pegawai : "");
						$this->widget('MyJuiAutoComplete',array(
								'model'=>$model,
								'attribute'=>'[ii]nama_pegawai',
								'sourceUrl'=> $this->createUrl('/ActionAutoComplete/getPegawai'),
								'options'=>array(
								   'showAnim'=>'fold',
								   'minLength' => 2,
								   'focus'=> 'js:function( event, ui ) {
										//$("#'.CHtml::activeId($model, 'pegawai_id').'").val("");
										//$("#'.CHtml::activeId($model, 'nama_pegawai').'").val("");
										//$("#'.CHtml::activeId($model, 'jabatan_id').'").val("");
										//$("#'.CHtml::activeId($model, 'organigram_kode').'").val("");	
										//$("#jabatan_nama").val("");
										
										return false;
									}',
								   'select'=>'js:function( event, ui ) {
										//$("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.value);
										//$("#'.CHtml::activeId($model, 'nama_pegawai').'").val(ui.item.label);
										//$("#'.CHtml::activeId($model, 'jabatan_id').'").val(ui.item.jabatan_id);
										//$("#'.CHtml::activeId($model, 'organigram_kode').'").val(ui.item.organigram_kode);	
										//$("#jabatan_nama").val(ui.item.jabatan_nama);
										setPegawaiAutoCom(ui.item.value);
										return false;
									}',

								),
								'htmlOptions'=>array('placeholder'=>'Nama Pegawai / NIP',
									'onblur'=>'if($(this).val()=="") $("#'.CHtml::activeId($model, 'pegawai_id').'").val("")',
									'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 required'),
								'tombolDialog'=>array('idDialog'=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
					)); ?>
			</div>
		</div>
	</td>
	<td>
		<div class="control-group">
			<?php //echo CHtml::label("Jabatan",'jabatan_id',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeHiddenField($model,'[ii]jabatan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				<?php echo CHtml::activeTextField($model,'[ii]jabatan_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			</div>	
		</div>	
	</td>
	<td>
		<?php echo CHtml::activeTextField($model,'[ii]organigram_kode',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($model,'[ii]organigram_pelaksanakerja',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</td>
	<td>
		
		<?php echo CHtml::activeTextField($model,'[ii]organigram_urutan',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;')); ?>
	</td>
</tr>