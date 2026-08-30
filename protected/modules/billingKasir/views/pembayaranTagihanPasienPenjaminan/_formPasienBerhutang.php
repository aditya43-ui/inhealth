<div class="control-group">
    <?php echo $form->labelEx($model, 'totalsisatagihan', array('class'=>'control-label required', 'label'=>'Sisa Tagihan'))?>
    <div class="controls">
        <?php echo $form->textField($model,'totalsisatagihan',array(
            'readonly'=>true,
            'class'=>'span2 integer2', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            //'style'=>'font-weight: bold;', 
            'onblur'=>'hitungUangKembalian();'
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'tgljatuhtempo', array('class'=>'control-label required', 'label'=>'Jatuh Tempo'))?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model'=>$model,
            'attribute'=>'tgljatuhtempo',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                //'minDate' => 'd',
            ),
            'htmlOptions' => array(
                'class' => 'span3',
                'readonly' => true,
                'onkeyup' => "return $(this).focusNextInputField(event)"),
        ));
        ?>
        
        <?php // echo $form->textField($model,'tgljatuhtempo',array('readonly'=>true,'class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'font-weight: bold;', 'onblur'=>'hitungUangKembalian();')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'penanggungjawabhutang', array('class'=>'control-label required', 'label'=>'Penanggung Jawab <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'penanggungjawabhutang',array(
            'readonly'=>false,'class'=>'span3', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'noktp_hutang', array('class'=>'control-label required', 'label'=>'No. KTP <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'noktp_hutang',array(
            'readonly'=>false,
            'class'=>'span3 numbers-only', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'alamat', array('class'=>'control-label required', 'label'=>'Alamat <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textArea($model,'alamat',array(            
            'class'=>'autogrow', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'notelp_hutang', array('class'=>'control-label required', 'label'=>'No. Telp/Mobile <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'notelp_hutang',array(
            'readonly'=>false,
            'class'=>'span3 numbers-only', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'pekerjaan_id', array('class'=>'control-label required', 'label'=>'Pekerjaan <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->dropDownList($model,'pekerjaan_id', CHtml::listData(PekerjaanM::model()->findAll(" pekerjaan_aktif = TRUE ORDER BY pekerjaan_nama ASC "), 'pekerjaan_id', 'pekerjaan_nama'),array(
            'empty'=>'-- Pilih --',
            'readonly'=>false,
            'class'=>'span3', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'hubungankeluarga', array('class'=>'control-label required', 'label'=>'Hubungan Keluarga <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'hubungankeluarga',array(
            'readonly'=>false,
            'class'=>'span3', 
            'maxlegth'=>50,
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'jaminanygditinggal', array('class'=>'control-label required', 'label'=>'Jaminan yang ditinggal <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'jaminanygditinggal',array(
            'readonly'=>false,
            'class'=>'span3', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'keteranganberhutang', array('class'=>'control-label', 'label'=>'Keterangan'))?>
    <div class="controls">
        <?php echo $form->textArea($model,'keteranganberhutang',array(
            'rows'=>4, 
            'readonly'=>false,
            'class'=>'span3', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>
<?php /*
<div class="control-group">
    <?php echo $form->labelEx($model, 'nominal_cicilan', array('class'=>'control-label required', 'label'=>'Nominal Cicilan <span class="required">*</span>'))?>
    <div class="controls">
        <?php echo $form->textField($model,'nominal_cicilan',array(
            'readonly'=>false,
            'class'=>'integer2',             
            'onkeyup'=>"return $(this).focusNextInputField(event);",
        )); ?>
    </div>
</div>
 * 
 */ ?>

