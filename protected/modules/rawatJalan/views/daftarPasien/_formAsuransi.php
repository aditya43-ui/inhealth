
<div class="control-group">
        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nopeserta')." <span class='required'>*</span>", 'nopeserta', array('class'=>'control-label'))?>
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
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'No. Peserta',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
                                    'onblur'=>"",
                                    'class'=>'numbers-only span3'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nopeserta'); ?>                        
             <?php echo $form->hiddenField($modAsuransiPasien,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
</div>
<?php echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(RJPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <div class="controls">
         <?php echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeyup'=>"return $(this).focusNextInputField(event)",'checked'=>false,'id'=>'telahkonfirmasi')); ?><label for="telahkonfirmasi"> Telah Dikonfirmasi</label>
        <?php echo $form->error($modAsuransiPasien, 'status_konfirmasi'); ?>
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
                            'htmlOptions'=>array('placeholder'=>'Pilih tanggal konfirmasi', 'class'=>'dtPicker3 datetimemask span3','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
    </div>
</div>
