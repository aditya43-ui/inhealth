<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Pengantar</label>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPenanggungJawab, 'pengantar', LookupM::getItems('pengantar'), array('class' => 'span4 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekPengantar();')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama</label>
            <div class="controls">
            <?php echo CHtml::activeTextField($modPenanggungJawab, 'nama_pj', array('placeholder' => 'Nama Lengkap Penanggung Jawab', 'class' => 'span4 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Kelamin</label>
            <div class="controls">
                <?php echo CHtml::activeRadioButtonList($modPenanggungJawab, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('class' => '', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No Identitas <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <?php //echo CHtml::labelEx($modPenanggungJawab,'no_identitas', array('class'=>'control-label refreshable')) 
            ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPenanggungJawab, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'jenisidentitas_pj required span2 form-control delapan',
                    'style' => 'width:80px;',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onchange' => 'cekLengthPJ(this);',

                )); ?>
                <?php echo CHtml::activeTextField($modPenanggungJawab, 'no_identitas', array('placeholder' => 'No. Identitas', 'class' => 'nik_pj required span2 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::error($modPenanggungJawab, 'jenisidentitas'); ?>
                <?php echo CHtml::error($modPenanggungJawab, 'no_identitas'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    <div class="control-group">
            <?php echo CHtml::activeLabelEx($modPenanggungJawab, 'hubungankeluarga', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPenanggungJawab, 'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('class' => 'span4 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>

        <?php echo CHtml::activeTextField($modPenanggungJawab, 'tempatlahir_pj', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'span4 all-caps form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($modPenanggungJawab, 'tgllahir_pj', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPenanggungJawab,
                    'attribute' => 'tgllahir_pj',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'onkeyup' => "js:function(){setUmurPjp(this.value);}",
                        'onSelect' => 'js:function(){setUmurPjp(this.value);}',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask form-control delapan span4', 'onblur' => 'setUmurPjp(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo CHtml::error($modPenanggungJawab, 'tgllahir_pj'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($modPenanggungJawab, 'umur', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('CMaskedTextField', array(
                    'model' => $modPenanggungJawab,
                    'attribute' => 'umur_pj',
                    'mask' => '99 Thn 99 Bln 99 Hr',
                    'htmlOptions' => array('placeholder' => '00 Thn 00 Bln 00 Hr', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setTglLahirPjp(this)', 'onchange' => 'setNamaGelar()', 'class' => 'span4 form-control')
                ));
                ?>
                <?php echo CHtml::error($modPenanggungJawab, 'umur_pj'); ?>
            </div>
        </div>
        <?php echo CHtml::activeTextArea($modPenanggungJawab, 'alamat_pj', array('placeholder' => 'Alamat Lengkap Penanggung Jawab', 'class' => 'span4 form-control autogrow', 'onchange' => 'convertToUpper(this)', 'onkeyup' => 'convertToUpper(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label('No. Telepon', 'no_teleponpj', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPenanggungJawab, 'no_teleponpj', array('placeholder' => 'No. Telepon Penanggung Jawab', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span4 form-control')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Handphone <span class="required">*</span>', 'no_teleponpj', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPenanggungJawab, 'no_mobilepj', array('placeholder' => 'No. Handphone Penanggung Jawab', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span4 form-control required', 'maxlength' => 15)); ?>
            </div>
        </div>
    </div>
</div>