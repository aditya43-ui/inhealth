<?php echo $form->dropDownListRow($modPenanggungJawab, 'pengantar', LookupM::getItems('pengantar'), array('class' => 'span3 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekPengantar();')); ?>
<div class="control-group pj_2" hidden>
    <?php echo CHtml::label("Nama / NIP Pegawai <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modPenanggungJawab, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPenanggungJawab,
            'attribute' => 'nama_pegawai',
            'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutocompletePegawai') . '",
                                                        dataType: "json",
                                                        data: {
                                                                nama_pegawai: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                })
                                            }',
            'options' => array(
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                                                        $("this").val(ui.item.nama_pegawai);
                                                        return false;
                                                    }',
                'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nama_pegawai);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'nama_pj') . '").val(ui.item.nomorindukpegawai);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'unit_perusahaan') . '").val(ui.item.unit_perusahaan);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'jabatan_nama') . '").val(ui.item.jabatan_nama);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'jenisidentitas') . '").val("LAINNYA");
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'no_identitas') . '").val(ui.item.nomorindukpegawai);
                                                        $("#' . CHtml::activeId($modPenanggungJawab, 'no_mobilepj') . '").val(ui.item.nomobile_pegawai);
                                                        if(ui.item.jeniskelamin == "LAKI-LAKI"){
                                                            jQuery("#PPPenanggungJawabM_jeniskelamin_0").attr("checked", true);
                                                        }
                                                        if(ui.item.jeniskelamin == "PEREMPUAN"){
                                                            jQuery("#PPPenanggungJawabM_jeniskelamin_1").attr("checked", true);
                                                        }
                                                        return false;
                                                    }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nama Pegawai',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "if($(this).val()=='') setResetPengantar()",
                'class' => 'form-control required delapan pj_2 span3'
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group pj_2" hidden>
    <?php echo CHtml::label("Jabatan", 'jabatan_nama', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->textField($modPenanggungJawab, 'jabatan_nama', array('class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
        ?>
    </div>
</div>
<div class="control-group pj_2" hidden>
    <?php echo CHtml::label("Unit Perusahaan", 'Unit Perusahaan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->textField($modPenanggungJawab, 'unit_perusahaan', array('class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
        ?>
    </div>
</div>
<div class="pj_1">
    <?php echo $form->textFieldRow($modPenanggungJawab, 'nama_pj', array('placeholder' => 'Nama Lengkap Penanggung Jawab', 'class' => 'span3 form-control pj_1', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
</div>

<?php echo $form->radioButtonListInlineRow($modPenanggungJawab, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('class' => '', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo CHtml::label("No Identitas <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
    <?php //echo $form->labelEx($modPenanggungJawab,'no_identitas', array('class'=>'control-label refreshable')) 
    ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPenanggungJawab, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array(
            'empty' => '-- Pilih --',
            'class' => 'jenisidentitas_pj required span2 form-control delapan',
            'style' => 'width:80px;',
            'onkeyup' => "return $(this).focusNextInputField(event)",
            'onchange' => 'cekLengthPJ(this);',

        )); ?>
        <?php echo $form->textField($modPenanggungJawab, 'no_identitas', array('placeholder' => 'No. Identitas', 'class' => 'nik_pj required span2 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->error($modPenanggungJawab, 'jenisidentitas'); ?>
        <?php echo $form->error($modPenanggungJawab, 'no_identitas'); ?>
    </div>
</div>
<div class="control-group hubungankeluarga">
    <?php echo $form->labelEx($modPenanggungJawab, 'hubungankeluarga', array('class' => 'control-label ')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPenanggungJawab, 'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('class' => 'span3 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

<?php echo $form->textFieldRow($modPenanggungJawab, 'tempatlahir_pj', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'span3 all-caps form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php // echo $form->labelEx($modPenanggungJawab,'tgllahir_pj', array('class'=>'control-label')) 
    ?>
    <?php echo CHtml::label("Tgl. Lahir <span class='required'>*</span>", 'tgllahir_pj', array('class' => 'control-label')) ?>
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
                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask form-control delapan span3 required', 'onblur' => 'setUmurPjp(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
            ),
        )); ?>
        <?php echo $form->error($modPenanggungJawab, 'tgllahir_pj'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modPenanggungJawab, 'umur', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('CMaskedTextField', array(
            'model' => $modPenanggungJawab,
            'attribute' => 'umur',
            'mask' => '99 Thn 99 Bln 99 Hr',
            'htmlOptions' => array('placeholder' => '00 Thn 00 Bln 00 Hr', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setTglLahirPjp(this)', 'onchange' => 'setNamaGelar()', 'class' => 'span3 form-control')
        ));
        ?>
        <?php echo $form->error($modPenanggungJawab, 'umur'); ?>
    </div>
</div>
<?php echo $form->textAreaRow($modPenanggungJawab, 'alamat_pj', array('placeholder' => 'Alamat Lengkap Penanggung Jawab', 'class' => 'span3 form-control autogrow', 'onchange' => 'convertToUpper(this)', 'onkeyup' => 'convertToUpper(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo CHtml::label('No. Telepon', 'no_teleponpj', array('class' => 'control-label ')) ?>
    <div class="controls">
        <?php echo $form->textField($modPenanggungJawab, 'no_teleponpj', array('placeholder' => 'No. Telepon Penanggung Jawab', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span3 form-control')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('No. Handphone <span class="required">*</span>', 'no_teleponpj', array('class' => 'control-label ')) ?>
    <div class="controls">
        <?php echo $form->textField($modPenanggungJawab, 'no_mobilepj', array('placeholder' => 'No. Handphone Penanggung Jawab', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span3 form-control required', 'maxlength' => 15)); ?>
    </div>
</div>