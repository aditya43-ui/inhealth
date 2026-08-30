<div id="form-resep">
	<div class="col-sm-6"  >
		<div class="control-group" >
			<?php 
				
				echo $form->labelEx($modReseptur,'tglresep_ok', array('class'=>'control-label', 'label' => 'Tgl. Resep')) 
			?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modReseptur,
						'attribute' => 'tglresep_ok',
						'name'=> 'tglresep_ok',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							//										'maxDate' => 'd',
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 realtime', 'onclick' => "return $(this).focusNextInputField(event)"),
					)); 
				?>	
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur,'noresep_ok', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'noresep_ok',array('readonly'=>true, 'style'=>'width:170px;', 'class' => 'noresep')); ?><br>
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur,'nama_pasien', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'nama_pasien',array('readonly'=>true, 'style'=>'width:170px;', 'class' => 'nama_pasien')); ?><br>
			</div>
		</div>
		
		<?php echo $form->dropDownListRow($modReseptur,'petugasfarmasi_id',CHtml::listData($modReseptur->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('class' => 'span4 petugasfarmasi_id','onkeypress'=>"return $(this).focusNextInputField(event)"));?>
		
		
		<input type="hidden" id="obatalkes_id">
		<input type="hidden" id="hargasatuanreseptur">
		<input type="hidden" id="sumberdana_id">
		<input type="hidden" id="stfornas">
		<div class="control-group">
			<label for="" class="control-label">Nama Obat</label>
			<div class="controls">
				<?php 
					$this->widget('MyJuiAutoComplete', array(
						'name'=>'obatalkes_nama',
						'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.$this->createUrl('/rawatJalan/reseptur/AutocompleteObatApiRuangan').'",
								dataType: "json",
								data: {
									term: request.term,
								},
								success: function (data) {
										response(data);
								}
							})
						}',
						'options'=>array(
							'showAnim'=>'fold',
							'minLength' => 2,
							'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.label);
								setObatDariApi(ui.item.kode, ui.item.jenis, ui.item.stFornas, ui.item.HJual, ui.item.satuan, ui.item.HPP, ui.item.nama);
								return false;
							}',
						),
						'tombolDialog'=>array('idDialog'=>'dialogObatDariApi'),
						'htmlOptions'=>array('id'=>'obatalkes_id_nama','class'=>'span3'),
					)); 
				?>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="jumlah">Jumlah Obat</label>
			<div class="controls">
				<?php echo CHtml::textField('jumlah', 1, array('readonly'=>false,'onkeyup'=>'$("#jumlah").val($(this).val());','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'jumlah number-char',"rel"=>"tooltip",'style'=>'width:50px;', 'onblur'=>'hitungJumlahObatQty();')) ?>
				<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
									array('onclick'=>'tambahRowObat(this);return false;',
									'class'=>'btn btn-primary',
									'id'=>'tomboltambahracikan',
									'onkeypress'=>"tambahRowObat(this);return false;",
									'rel'=>"tooltip",
									'title'=>"Klik untuk menambahkan ke tabel resep",)); ?>
			</div>
		</div>
	
	</div> <!-- ./col -->
	
	<div class="col-sm-6">
		<div class="control-group">
			<label for="" class="control-label">Paket Obat Operasi<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'paket_obat',array('class' => 'span3 paket_obat', 'placeholder' => 'Nama Paket Obat Operasi')); ?>
			</div>
		</div>	
		<div class="control-group">
			<label for="" class="control-label">Keterangan</label>
			<div class="controls">
				<?php echo CHtml::textArea('keterangan','',array('id'=>'keterangan','readonly'=>false, 'rows' => 10, 'cols' => 50 )); ?>
			</div>
		</div>	
	</div>
</div>


	