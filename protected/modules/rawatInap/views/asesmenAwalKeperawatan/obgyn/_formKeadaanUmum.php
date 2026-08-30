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
                                 <?php  echo $form->textField($modAsesmenawalkeperawatanT,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue_obgyn(this); getText_obgyn();', 'style'=>'text-align: right;'));?>Mm
                                 <?php echo $form->textField($modAsesmenawalkeperawatanT,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue_obgyn(this); getText_obgyn();', 'style'=>'text-align: right;')); ?>Hg
                                </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo CHtml::Label('','',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php
                                                    $modAsesmenawalkeperawatanT->tekanandarah = empty($modAsesmenawalkeperawatanT->tekanandarah) ? "000 / 000" : $modAsesmenawalkeperawatanT->tekanandarah;
                                                  echo $form->textField($modAsesmenawalkeperawatanT,'tekanandarah',array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)"));
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
                                     X/Menit
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
                                            X/Menit
                                    </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'suhutubuh',array('class'=>'control-label'));?>
                                    <div class="controls">
                                            <?php echo $form->textField($modAsesmenawalkeperawatanT,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                     &#176; Celcius
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
