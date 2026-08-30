<?php echo $form->hiddenField($modAsuransiPasienPekerja,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
<div class="control-group">
        <?php echo CHtml::label("NIP / No. Prokespen <span class='required'>*</span>", 'nopeserta', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasienPekerja,
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
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'nopeserta').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            $("#'.CHtml::activeId($modAsuransiPasienPekerja,'hubkeluarga').'").val(ui.item.hubkeluarga);
                                            $("#'.CHtml::activeId($modPegawai,'alamat_pegawai').'").val(ui.item.alamat_pegawai);
                                            $("#'.CHtml::activeId($modPegawai,'notelp_pegawai').'").val(ui.item.notelp_pegawai);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'Ketik NIP',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>''),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasienPekerja,'nopeserta'); ?>                        
             
        </div>
</div>
<div class="control-group">
	<?php echo CHtml::label("Nama Pegawai <span class='required'>*</span>", 'namapemilikasuransi', array('class'=>'control-label required'))?>
	<div class="controls">
		<?php echo $form->textField($modAsuransiPasienPekerja,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label("Alamat Pegawai", 'alamat_pegawai', array('class'=>'control-label'))?>
	<div class="controls">
		<?php echo $form->textArea($modPegawai,'alamat_pegawai',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label("No. Telepon Pegawai", 'notelp_pegawai', array('class'=>'control-label'))?>
	<div class="controls">
		<?php echo $form->textField($modPegawai,'notelp_pegawai',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label("Kelas Tanggungan <span class='required'>*</span>", 'kelastanggunganasuransi_id', array('class'=>'control-label required refreshable'))?>
	<div class="controls">
		<?php echo $form->dropDownList($modAsuransiPasienPekerja,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
