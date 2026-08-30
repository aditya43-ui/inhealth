<?php echo $form->hiddenField($modAsuransiPasienBadak,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
<?php echo $form->textFieldRow($modAsuransiPasienBadak,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'value'=>'PT. Badak LNG', 'readonly'=>true)); ?>
<div class="control-group">
        <?php echo CHtml::label("NIP / No. Prokespen <span class='required'>*</span>", 'nopeserta', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasienBadak,
                                'attribute'=>'nopeserta',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransiBadak').'",
                                                   dataType: "json",
                                                   data: {
                                                       nopeserta: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'nopeserta').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga').'").val(ui.item.hubkeluarga);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'Ketik NIP',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>''),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasienBadak,'nopeserta'); ?>                        
             
        </div>
</div>
<div class="control-group">
	<?php echo CHtml::label("Nama Pegawai <span class='required'>*</span>", 'namapemilikasuransi', array('class'=>'control-label required'))?>
	<div class="controls">
		<?php echo $form->textField($modAsuransiPasienBadak,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
</div>

<div class="control-group">
	<?php echo CHtml::label("Status Hubungan Keluarga <span class='required'>*</span>", 'hubkeluarga', array('class'=>'control-label required refreshable'))?>
	<div class="controls">
		<?php echo $form->dropDownList($modAsuransiPasienBadak,'hubkeluarga', LookupM::getItems('statuskeluargaasuransi'),  
                        array('empty'=>'-- Pilih --', 
								'onkeyup'=>"return $(this).focusNextInputField(event)", 
								'class'=>'span3',
								'style'=>'float:left; width:80px')
						); ?>   
	</div>
</div>

<div class="control-group">
	<?php echo CHtml::label("Kelas Tanggungan <span class='required'>*</span>", 'kelastanggunganasuransi_id', array('class'=>'control-label required refreshable'))?>
	<div class="controls">
		<?php echo $form->dropDownList($modAsuransiPasienBadak,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
