<div class="span6">

        <?php echo $form->hiddenField($model, 'diagnosa_awal_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'politujuan_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'jenispeserta_bpjs_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'jenispeserta_bpjs_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'nama_ppk_pelayanan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


        <div class="control-group">
                <?php echo CHtml::label("Tgl Sep <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_sep',
                                'mode' => 'date',
                                'options' => array(
                                        'dateFormat' => "yy-mm-dd",
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                        )); 
                        echo $form->hiddenField($model, 'tgl_rujukan', array('readonly' => true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",));
                        ?>
                        
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#" . CHtml::activeId($model, "no_kartu_bpjs") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'no_kartu_bpjs', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Nama Peserta BPJS <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'namapeserta_bpjs', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenis_pelayanan',  array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
        </div>

        
</div>
<div class="span6">
<div class="control-group ">
                <?php echo CHtml::label("Jenis Pengajuan <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'jnspengajuan_approvalsep',  LookupM::getItemsUrutan('jnspengajuan_approvalsep'), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Keterangan", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textArea($model, 'catatan', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'user_approval_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                        <?php echo $form->hiddenField($model, 'userpembuat_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>


</div>
<?php echo $form->hiddenField($model, 'responbridging_pengajuan', array('id'=>'responbridging_pengajuan')); ?>