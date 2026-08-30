<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Keadaan Umum</strong></div>
        </div>
         <div class="panel-body">
             <div class="row-fluid">
                 <div class="col-sm-6">
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'kesadaranpasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'kesadaranpasien',array('Compos Mentis'=>'Compos Mentis','Delirium'=>'Delirium','Somnolen'=>'Somnolen','Sopor'=>'Sopor','Koma'=>'Koma') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'kesadaranpasien'); ?>
                        </div>
                    </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="panel panel-success panel-shadow">
                        <div class="panel-heading">
                                <div class="panel-title">Tanda Vital</div>
                        </div>
                        <div class="panel-body">
                            <div class="control-group ">
                                <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'tekanandarah',array('class'=>'control-label'));?>
                                <div class="controls">
                                 <?php  echo $form->textField($modAsesmenawalkeperawatanT,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue_dws(this); getText_dws();', 'style'=>'text-align: right;'));?>Mm
                                 <?php echo $form->textField($modAsesmenawalkeperawatanT,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue_dws(this); getText_dws();', 'style'=>'text-align: right;')); ?>Hg
                                </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo CHtml::Label('','',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php
                                                    $modAsesmenawalkeperawatanT->tekanandarah = empty($modAsesmenawalkeperawatanT->tekanandarah) ? "000 / 000" : $modAsesmenawalkeperawatanT->tekanandarah;
                                                  echo $form->textField($modAsesmenawalkeperawatanT,'tekanandarah',array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)"));
                                                    // $this->widget('CMaskedTextField', array(
                                                    // 'model' => $modAsesmenawalkeperawatanT,
                                                    // 'attribute' => 'tekanandarah',
                                                    // 'mask' => '999 / 999',
                                                    // 'placeholder'=>'000 / 000',
                                                    // 'htmlOptions' => array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                                    // ));
                                            ?> Mm/Hg
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <div class="controls">
                                            <?php echo CHtml::label('','',array('class'=>'control-label'));?>
                                            <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'mean arteri pressure',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'detaknadi',array('label'=>'<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Nadi','class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'detaknadi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                                     /Menit
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'denyutjantung',array('label'=>'<i class="icon-facetime-video hoveringIcon" onclick="getfromDevice();"></i> Detak Jantung','class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php
                                                    echo $form->dropDownList($modAsesmenawalkeperawatanT, 'denyutjantung', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUPTYPE_DENYUTJANTUNG),array('order'=>'lookup_name ASC')), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih --'));
                                            ?>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'pernapasan',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'pernapasan',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2));?>
                                            /Menit
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'suhutubuh',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                     &#176; Celcius
                                    </div>
                            </div>

                            <div class="control-group ">
                                    <?php echo CHtml::Label('Tinggi Badan / Panjang Badan','',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <div class="groupUkurans">
                                                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'tinggibadan_cm',array('class'=>'span1 numbersOnly tinggibadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3,'size'=>3, 'style'=>'text-align:right;'));?>
                                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'tinggibadan_cm',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3,'size'=>3));?>
                                                    <?php echo CHtml::dropDownList('meter', '100', array('100'=>'Cm', '0.01'=>'M'), array('style'=>'width:50px;','class'=>'span1', 'onchange'=>'gantiJumlah_dws(this)')); ?>
                                            </div>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo CHtml::Label('Berat Badan','',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <div class="groupUkurans">
                                                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'beratbadan_kg',array('class'=>'span1 numbersOnly beratbadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3, 'style'=>'text-align:right;'));?>
                                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'beratbadan_kg',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                                    <?php echo CHtml::dropDownList('gram', '0.001', array('1000'=>'Gr', '0.001'=>'Kg'), array('class'=>'span1', 'onchange'=>'gantiJumlah_dws(this)')); ?>
                                            </div>
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'bb_ideal',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'bb_ideal',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'readonly'=>true)).' ';?>Kg
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <label class='control-label'>Index Masa Tubuh</label>
                                    <div class="controls">
                                            <?php echo CHtml::textField('imtValue', '', array('readonly'=>true, 'class'=>'span1'));?>
                                            <?php echo CHtml::textField('imt', '', array('readonly'=>true, 'class'=>'span2'));?>
                                    </div>
                            </div>
                            <?php echo $form->textFieldRow($modAsesmenawalkeperawatanT,'kelainanpadabagtubuh',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>

                            <?php echo $form->textFieldRow($modAsesmenawalkeperawatanT,'tandavital_reflekcahaya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                            <div class="control-group ">
                                    <label class='control-label'>SPO2</label>
                                    <div class="controls">
                                        <?php echo $form->textField($modAsesmenawalkeperawatanT,'tandavital_spo2',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;', 'maxlength'=>2)); ?> <label>%</label>
                                    </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
</div>

<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9.]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>
