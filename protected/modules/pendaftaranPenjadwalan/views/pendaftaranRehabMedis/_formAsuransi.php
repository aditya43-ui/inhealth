<?php
	$read_only = '';
	if (isset($readdata)){
		$read_only = " readonly = true  ";
	}
?>
<div class="control-group">
        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('nopeserta')." <span class='required jks_spec'>*</span>", 'nopeserta', array('class'=>'control-label required jks_spec'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'nopeserta',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransi').'",
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
                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nominal_tanggungan').'").val(formatNumber(ui.item.nominal_tanggungan));
											setAsuransiLama();
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'No. Peserta',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>'span3 angkahuruf-only all-caps'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nopeserta'); ?>                        
             
        </div>
</div>
<?php echo $form->hiddenField($modAsuransiPasien,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
<div class="control-group">
        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('nokartuasuransi')." <span class='required jks_spec'>*</span>", 'nokartuasuransi', array('class'=>'control-label required jks_spec'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'nokartuasuransi',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransiKartu').'",
                                                   dataType: "json",
                                                   data: {
                                                       nokartuasuransi: request.term,
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
                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'").val(ui.item.nokartuasuransi);
											$("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nominal_tanggungan').'").val(formatNumber(ui.item.nominal_tanggungan));
											setAsuransiLama();
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogAsuransi','jsFunction'=>'cekAsuransi()'),
                                'htmlOptions'=>array('placeholder'=>'No. Kartu Asuransi','rel'=>'tooltip','title'=>'No. Peserta',
                                    'onkeyup'=>"; return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>'span3 angkahuruf-only all-caps'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nokartuasuransi'); ?>                        
      </div>
</div>
<?php //echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <label class="control-label">
        Kelas Tanggungan Asuransi
        <span class="required">*</span>
        <?php if (strtolower($this->id) != "pendaftaranrawatdarurat"): ?>
        <span class="required">*</span>
        <?php endif; ?>
    </label>
    <div class="controls">

    <?php 
        if (isset($statusMenu)){
            echo $form->dropDownList($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekPerbedaanKelas(this);')); 
        }else{
            echo $form->dropDownList($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)")); 
        }
        
            
    ?>
    </div>
</div>
<?php echo $form->textFieldRow($modAsuransiPasien,'nominal_tanggungan',array('placeholder'=>'Nominal Tanggungan Asuransi','class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <label class="control-label">Status Konfirmasi</label>
    <div class="controls">

            <?php 
            echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                'value'=>1,
                'uncheckValue'=>null,
                'id'=>'konfirmasi_sudah',
                'onchange'=>'$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", false);',
               // 'onchange'=>'switchOtomatis(this)',
                'class'=>'rb_kon',
                'checked'=>'checked',
            ))."Sudah ";
            echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                'value'=>0,
                'uncheckValue'=>null,
                'onchange'=>'$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", true);',
                'class'=>'rb_kon',
                'id'=>'konfirmasi_sudah',
                'checked'=>false,
            ))."Belum ";
            ?>
         <?php //echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?>
        <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modAsuransiPasien,'tgl_konfirmasi', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $modAsuransiPasien->tgl_konfirmasi = (!empty($modAsuransiPasien->tgl_konfirmasi) ? date("d/m/Y H:i:s",strtotime($modAsuransiPasien->tgl_konfirmasi)) : null);
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modAsuransiPasien,
                            'attribute'=>'tgl_konfirmasi',
                            'mode'=>'datetime',
                            'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('class'=>'span3 dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
    </div>
</div>
