<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools / Templates
 * and open the template in the editor.
 */
?>

<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'tekanandarah', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $form->textField($modPemeriksaanFisik, 'td_systolic', array('class' => 'span1 numbersOnly systolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this); getText();', 'style' => 'text-align: right;'));
        /*
								$this->widget('CMaskedTextField', array(
								'model' => $modPemeriksaanFisik,
								'attribute' => 'td_systolic',
								'mask' => '999',
								'placeholder'=>'0',
								'htmlOptions' => array('class'=>'span1 systolic', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'returnValue(this); getText();') // change(this); getTekananDarah(this) change(this);getText();
								));
				 */ ?>Mm
        <?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
        ?>
        <?php
        echo $form->textField($modPemeriksaanFisik, 'td_diastolic', array('onblur' => '', 'readonly' => false, 'class' => 'span1 numbersOnly diastolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this); getText();', 'style' => 'text-align: right;'));
        /*
								$this->widget('CMaskedTextField', array(
								'model' => $modPemeriksaanFisik,
								'attribute' => 'td_diastolic',
								'mask' => '999',
								'placeholder'=>'0',
								'htmlOptions' => array('class'=>'span1 diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onkeyup'=>'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
								)); */
        ?>Hg
        <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));
        ?>
        &nbsp;
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $modPemeriksaanFisik->tekanandarah = empty($modPemeriksaanFisik->tekanandarah) ? "000 / 000" : $modPemeriksaanFisik->tekanandarah;
        $this->widget('CMaskedTextField', array(
            'model' => $modPemeriksaanFisik,
            'attribute' => 'tekanandarah',
            'mask' => '999 / 999',
            'placeholder' => '000 / 000',
            'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'style' => 'width:60px;', 'onkeypress' => "return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
        ));
        ?> Mm/Hg
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
        <?php echo CHtml::textField('tekananDarah', '', array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'mean arteri pressure', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'meanarteripressure', array('readonly' => true, 'class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'detaknadi', array('label' => '<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Nadi', 'class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'detaknadi', array('class' => 'span2  integer numbersOnly', 'maxlength' => 3, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        /Menit
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'denyutjantung', array('label' => '<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Denyut Jantung', 'class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $form->dropDownList($modPemeriksaanFisik, 'denyutjantung', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => Params::LOOKUPTYPE_DENYUTJANTUNG), array('order' => 'lookup_name ASC')), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --'));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'pernapasan', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'pernapasan', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>
        /Menit
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'suhutubuh', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'suhutubuh', array('class' => 'span2  float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5, 'style' => 'text-align:right;')); ?>
        &#176 Celcius
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::Label('Tinggi Badan / Berat Badan', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="groupUkurans">
            <?php echo $form->textField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly tinggibadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'size' => 3, 'style' => 'text-align:right;')); ?>
            <?php echo $form->hiddenField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'size' => 3)); ?>
            <?php echo CHtml::dropDownList('meter', '100', array('100' => 'Cm', '0.01' => 'M'), array('style' => 'width:50px;', 'class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
        </div>
        <div class="groupUkurans">
            <?php echo $form->textField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly beratbadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3, 'style' => 'text-align:right;')); ?>
            <?php echo $form->hiddenField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
            <?php echo CHtml::dropDownList('gram', '0.001', array('1000' => 'Gr', '0.001' => 'Kg'), array('class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
        </div>
    </div>
</div>
<div class="control-group">
    <?php echo $form->LabelEx($modPemeriksaanFisik, 'bb_ideal', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'bb_ideal', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?>Kg
    </div>
</div>
<div class="control-group">
    <label class='control-label'>Index Masa Tubuh</label>
    <div class="controls">
        <?php echo CHtml::textField('imtValue', '', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::textField('imt', '', array('readonly' => true, 'class' => 'span2')); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modPemeriksaanFisik, 'kelainanpadabagtubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>

<?php echo $form->textFieldRow($modPemeriksaanFisik, 'tandavital_reflekcahaya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

<div class="control-group">
    <label class='control-label'>SPO2</label>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'tandavital_spo2', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;', 'maxlength' => 3)); ?> <label>%</label>
    </div>
</div>

<script>
    $(".float2").maskMoney({
        "symbol": "",
        "defaultZero": true,
        "allowZero": true,
        "decimal": ",",
        "thousands": "",
        "precision": 2
    });
</script>