<div class="span6">
    <div class="control-group ">
        <?php echo CHtml::label("No. Rujukan <span class='required'>*</span>", 'norujukan', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nosuratrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tgldirujuk', array('class' => 'control-label', 'label'=>'Tgl. Rujukan')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgldirujuk',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                    //'onClose' => 'js:function(){checkPlanDate();checkPlanDate();}'
                ),
                'htmlOptions' => array(
                    'readonly'=>true,
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 span3 tgldirujuk', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglrencanakunjungan_bpjs', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglrencanakunjungan_bpjs',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'readonly'=>true,
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 span3 tglrencanakunjungan_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    
    <div class="control-group" hidden>
        <label class="control-label">
            Tanggal Buat Rujukan <span class="required">*</span>
        </label>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglbuat_rujukan',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange' => "-150:+0",                    
                ),
                'htmlOptions' => array(
                    'readonly'=>true,
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 span3 date required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
        
    <div class="control-group ">
        <?php echo CHtml::label("Jenis Faskes", 'Jenis Faskes', array('class' => 'control-label')) ?>
        <div class="controls form-inline">
            <?php
            echo $form->radioButtonList($model, 'jenisfaskes', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('class'=>'jenisfaskes', 'onkeyup' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kode PPK Dirujuk ke <span class='required'>*</span><i class=\"icon-search\" onclick=\"setDialogPPK();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'ppkrujukan',
                'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('getDataFaskes') . '",
                                dataType: "json",
                                data: {
                                    tipe: 1,
                                    term: request.term,
                                    jenis: $(".jenisfaskes:checked").val()
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                         }',
                    'select' => 'js:function( event, ui ) {
                            setInputRujukan(ui.item);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode PPK Rujukan', 'rel' => 'tooltip', 'title' => 'Ketik Kode PPK Rujukan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 ppkrujukan',
                ),
            ));
            ?>
        
            <?php // echo $form->textField($model, 'ppkrujukan', array('placeholder' => 'Kode PPK Rujukan', 'class' => 'span3 required ppkrujukan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama PPK Dirujuk ke <span class='required'>*</span><i class=\"icon-search\" onclick=\"setDialogPPK();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'ppkrujukan_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('getDataFaskes') . '",
                                dataType: "json",
                                data: {
                                    tipe: 1,
                                    term: request.term,
                                    jenis: $(".jenisfaskes:checked").val()
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                         }',
                    'select' => 'js:function( event, ui ) {
                            setInputRujukan(ui.item);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode PPK Rujukan', 'rel' => 'tooltip', 'title' => 'Ketik Kode PPK Rujukan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 required ppkrujukan_nama',
                ),
            ));
            ?>

            <?php // echo $form->textField($model, 'ppkrujukan_nama', array('placeholder' => 'Nama PPK Rujukan', 'class' => 'span3 ppkrujukan_nama', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogDiagnosaBpjs').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php 
                echo $form->hiddenField($model, 'diagnosasementara_ruj',['class'=>'diagnosasementara_ruj required']);
                echo $form->hiddenField($model, 'kodediagnosasementara_ruj',['class'=>'kodediagnosasementara_ruj required']);
                echo $form->textField($model, 'diagnosa_awal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3 required diagnosa_awal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
            ?>
        </div>
    </div>

</div>
<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'Pelayanan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jenispelayanan_bpjs',  array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tipe Rujukan <span class='required'>*</span>", 'Tipe Rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'tiperujukan_bpjs',  CHtml::listData(LookupM::model()->findAll("lookup_type = 'tiperujukan_bpjs'"), 'lookup_kode', 'lookup_name'), array('empty' => '--Pilih--', 'class' => 'span3 required', 'onchange'=>'cekInputPoli();')); ?>
        </div>
    </div>
    
    <div class="control-group" hidden>
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?= $form->checkBox($model, 'isrujukan_khusus') ?>
        </div>
        <label class="controls">
            Rujukan Khusus
        </label>
    </div>
    
    <div class="control-group " id='poliR'>
        <?php echo CHtml::label("Poli Rujukan <span class='hide required' id='polirujukan'>*</span> <i class=\"icon-search\" onclick=\"cekPoli();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'dirujukkebagian_nama', array('readonly' => true, 'placeholder' => 'Poli Tujuan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textField($model, 'dirujukkebagian', array('placeholder' => 'Poli Tujuan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("User BPJS", 'userinput_bpjs', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'userinput_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Catatan <span class='required'>*</span>", 'catatandokterperujuk', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'catatandokterperujuk', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>