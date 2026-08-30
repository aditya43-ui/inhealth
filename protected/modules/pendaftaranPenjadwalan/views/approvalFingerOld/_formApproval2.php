<div class="span6">


        <div class="control-group">
                <?php echo CHtml::label("Tgl Sep <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_sep',
                                'mode' => 'date',
                                'options' => array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                        'placeholder' => 'DD MM YYYY', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onchange' => "getAsuransiNoKartu($('#" . CHtml::activeId($model, "noka_bpjs") . "').val())",
                                ),
                        )); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("No. Kartu BPJS", 'nopeserta', array('class' => 'control-label')) ?>
                <?php // echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#" . CHtml::activeId($model, "noka_bpjs") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'noka_bpjs', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onblur' => "getAsuransiNoKartu($('#" . CHtml::activeId($model, "noka_bpjs") . "').val())", 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
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
                        <?php echo $form->dropDownList($model, 'jenispelayanan',  array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
        </div>

        
</div>
<div class="span6">
<div class="control-group ">
                <?php echo CHtml::label("Jenis Pengajuan <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenispengajuan',  LookupM::getItemsUrutan('jnspengajuan_approvalsep'), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Keterangan", 'keterangan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textArea($model, 'keterangan', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'user', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>


</div>
<?php // echo $form->hiddenField($model, 'responbridging_pengajuan', array('id'=>'responbridging_pengajuan')); ?>