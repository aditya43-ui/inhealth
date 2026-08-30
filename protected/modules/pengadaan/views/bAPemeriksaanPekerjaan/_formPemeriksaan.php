<div class="row-fluid">
    <div class="col-sm-6">
        
        <?php echo $form->textFieldRow($model, 'bapemeriksaanpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model,'kode_dokumen', Chtml::listData(LookupM::model()->findAll("lookup_type = 'kodepemeriksaanpekerjaan' AND lookup_aktif IS TRUE"),'lookup_name','lookup_name'),array('empty' => '-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4')) ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA', 'readonly'=>true)); ?>
        
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_ke', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <label class="control-label" style="width: 35px">Dari</label>
            <div class="controls">
                <?php echo $form->textField($model, 'total_termin', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'terminke', array('class'=>'span1','readonly'=>true)); ?>
                <?php echo $form->hiddenField($model, 'termin_persen', array('class'=>'span1','readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bapemeriksaanpekerjaan_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bapemeriksaanpekerjaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bapemeriksaanpekerjaan_tanggal'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'lokasi_pemeriksaan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => 'Lokasi Pemeriksaan')); ?>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bapemeriksaanpekerjaan_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">
        
        <?php // echo $form->textFieldRow($model, 'pa_keputusan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => 'Keputusan PA')); ?>
        <?php echo $form->textFieldRow($model, 'pa_nomorsk', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor SK', 'readonly'=>true)); ?>
        
    </div>
    <div class="col-sm-6">
        
        <?php echo $form->textFieldRow($model, 'pa_tanggalsk', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Tanggal SK', 'readonly'=>true)); ?>
        <?php // echo $form->textFieldRow($model, 'pa_keptentang', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => 'Keputusan Tentang')); ?>
        
    </div>
</div>