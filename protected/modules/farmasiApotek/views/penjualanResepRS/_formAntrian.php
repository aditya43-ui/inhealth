<?php $form_antrian=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'anantrianfarmasi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
    <div class="row-fluid">
        <div class = "span12">
        <?php echo $form_antrian->hiddenField($modAntrian,'antrianfarmasi_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form_antrian->dropDownList($modAntrian, 'racikan_id', $modAntrian->getListRacikans(),array('class'=>'span3','empty'=>'-- Pilih --') )?>
        <?php echo $form_antrian->hiddenField($modAntrian,'tglambilantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
            <div id="noantrian_text" style="width: 100%; text-align: center; font-size: 30px; font-weight: bold;">
                <?php echo (empty($modAntrian->noantrian) ? "Otomatis" : $modAntrian->racikan->racikan_singkatan."-".$modAntrian->noantrian); ?>
            </div>
            <?php echo $form_antrian->hiddenField($modAntrian,'noantrian',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
    </div>
<?php $this->endWidget(); ?>

