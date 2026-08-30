<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?> 

<div class="panel panel-success panel-shadow equal">
	<div class="panel-heading">
		<div class="panel-title">Data Paket Obat</div>
	</div>
	<div class="panel-body">
		<div class="control-group ">
			<?php echo CHtml::label('Dokter', '', array('class' => 'control-label')) ?>
			<div class="controls">

				<?php echo CHtml::hiddenField('paketobatdetail_id'); ?>
				<?php
				echo Chtml::activeHiddenField($model, 'dokter_id', array());
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'nama_pegawai',
					'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('/actionAutoComplete/ListDokter') . '",
								dataType: "json",
								data: {
										term: request.term,
								},
								success: function (data) {
										response(data);
								}
							})
						}',
					'options' => array(
						'minLength' => 2,
						'focus' => 'js:function( event, ui ) {
								$(this).val( "");
								return false;
							}',
						'select' => 'js:function( event, ui ) {
													$(this).val( ui.item.label);
													$("#GFPaketobatM_dokter_id").val(ui.item.value);
													return false;
											}',
					),
					'tombolDialog' => array('idDialog' => 'dialogDokter'),
					'htmlOptions' => array(
						'placeholder' => 'Ketik Nama Dokter', 'class' => 'span3 all-caps pegawaishift_nama', 'rel' => 'tooltip', 'title' => 'Ketik NIP/Nama/klik icon untuk mencari data Dokter',
						'onkeyup' => "return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#GFPaketobatM_dokter_id").val(""); '
					),
				));
				?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model, 'nama_paket', array('class' => 'span3 required', 'maxlength' => 100)); ?>
		<div class="control-group">
			<?php echo CHtml::label('Jenis Resep','Jenis Resep', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				echo CHtml::dropDownList('jenisresep','',
					array(0=>'Non Racikan',1=>'Racikan'),
					array('key'=>'jenisresep', 'class'=>'span3','onchange'=>'formjenisresep(this.value); setDropDownRke();')
				);
				?><br>
			</div>
		</div>
	</div>
</div>