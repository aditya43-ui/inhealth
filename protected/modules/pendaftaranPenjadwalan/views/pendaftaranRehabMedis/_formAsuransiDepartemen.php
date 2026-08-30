<?php echo $form->hiddenField($modAsuransiPasienDepartemen,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
<div class="control-group">
	<?php echo CHtml::label("Nama Departemen <span class='required'>*</span>", 'namaperusahaan', array('class'=>'control-label required'))?>
	<div class="controls">
		<?php echo $form->textField($modAsuransiPasienDepartemen,'namaperusahaan',array('placeholder'=>'Nama Departemen PT. Badak','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'readonly'=>true)); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label("No. Surat", 'nomorpokokperusahaan', array('class'=>'control-label'))?>
	<div class="controls">
		<?php echo $form->textField($modAsuransiPasienDepartemen,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'readonly'=>false)); ?>
	</div>
</div>
<div class="control-group">
        <?php echo CHtml::label("NIP <span class='required'>*</span>", 'nopeserta', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasienDepartemen,
                                'attribute'=>'nopeserta',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransiBadak').'",
                                                   dataType: "json",
                                                   data: {
                                                       nopeserta: request.term,
//                                                       penjamin_id: penjamin_id,
//                                                       pasien_id: pasien_id,
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
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'Ketik NIP',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>''),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasienDepartemen,'nopeserta'); ?>                        
             
        </div>
</div>
<div class="control-group">
	<?php echo CHtml::label("Nama Pegawai <span class='required'>*</span>", 'namapemilikasuransi', array('class'=>'control-label required'))?>
	<div class="controls">
		<?php echo $form->textField($modAsuransiPasienDepartemen,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
</div>

<div class="control-group">
	<?php echo CHtml::label("Kelas Tanggungan <span class='required'>*</span>", 'kelastanggunganasuransi_id', array('class'=>'control-label required refreshable'))?>
	<div class="controls">
		<?php echo $form->dropDownList($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
