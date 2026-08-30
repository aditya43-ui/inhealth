<div class="control-group ">
    <?php echo $form->labelEx($modRujukan,'asalrujukan_id', array('class'=>'control-label refreshable')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modRujukan,'asalrujukan_id', CHtml::listData($modRujukan->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'), 
                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'ajax'=>array('type'=>'POST',
                                                          'url'=>Yii::app()->createUrl('laboratorium/pendaftaranLaboratorium/GetRujukanDari',array('encode'=>false,'namaModel'=>'RMRujukanT')),
                                                          'update'=>'#'.CHtml::activeId($modRujukan, 'rujukandari_id'),),
                                            'onchange'=>"clearRujukan();",)); ?>
        <?php echo $form->error($modRujukan, 'asalrujukan_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan,'no_rujukan', array('placeholder'=>'Nomor Rujukan','class'=>'span3 numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>20)); ?>
<div class="control-group ">
    <?php echo $form->labelEx($modRujukan,'rujukandari_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRujukan,'rujukandari_id',CHtml::listData($modRujukan->getRujukanDariItems($modRujukan->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                                          array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); ?>
        <?php echo $form->error($modRujukan, 'rujukandari_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan,'nama_perujuk', array('placeholder'=>'Nama Lengkap Perujuk','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>


<div class="control-group ">
    <?php echo $form->labelEx($modRujukan,'tanggal_rujukan', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modRujukan,
                                'attribute'=>'tanggal_rujukan',
                                'mode'=>'date',
                                'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modRujukan, 'tanggal_rujukan'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan,'diagnosa_rujukan', array('placeholder'=>'Diagnosa Rujukan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Diagnosa Rujukan')); ?> 

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddAsalRujukan',
    'options'=>array(
        'title'=>'Menambah data Asal Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>300,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormAsalRujukan"></div>';
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddRujukanDari',
    'options'=>array(
        'title'=>'Menambah data Nama Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormRujukanDari"></div>';
$this->endWidget();

?>
