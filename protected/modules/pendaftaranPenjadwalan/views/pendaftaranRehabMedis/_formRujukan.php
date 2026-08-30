<div class="control-group">
    <?php echo CHtml::label($modRujukan->getAttributeLabel('asalrujukan_id') . " <span class='required'>*</span>", 'asalrujukan_id', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukan,
            'asalrujukan_id',
            CHtml::listData($modRujukan->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
            array(
                'class' => 'span3 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanT')),
                    'update' => '#' . CHtml::activeId($modRujukan, 'rujukandari_id'),
                ),
                'onchange' => "clearRujukan();setKarcis(1);",
            )
        ); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class'=>'btn btn-primary','onclick'=>"{addAsalRujukan(); $('#dialogAddAsalRujukan').dialog('open');}",
                                              'id'=>'btnAddAsalRujukan','onkeyup'=>"return $(this).focusNextInputField(event)",
                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukan->getAttributeLabel('asalrujukan_id'))) */ ?>
        <?php echo $form->error($modRujukan, 'asalrujukan_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan, 'no_rujukan', array('placeholder' => 'Nomor Rujukan', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'rujukandari_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukan,
            'rujukandari_id',
            CHtml::listData($modRujukan->getRujukanDariItems($modRujukan->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
            array('class' => 'span3 form-control enam', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujuk();')
        ); ?>
        <?php echo CHtml::htmlButton(
            '<i class="entypo-plus-circled"></i>',
            array(
                'class' => 'btn btn-primary', 'onclick' => "{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
                'id' => 'btnAddRujukanDari', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modRujukan->getAttributeLabel('nama_perujuk')
            )
        ) ?>
        <?php echo $form->error($modRujukan, 'rujukandari_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'tanggal_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modRujukan,
            'attribute' => 'tanggal_rujukan',
            'mode' => 'date',
            'options' => array(
                //                                    'dateFormat'=>Params::DATE_FORMAT,
                'showOn' => false,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modRujukan, 'tanggal_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'kddiagnosa_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukan,
            'attribute' => 'kddiagnosa_rujukan',
            'data' => explode(',', $modRujukan->kddiagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukanKode', 'class' => ''),
        ));
        ?>
        <?php echo $form->error($modRujukan, 'kddiagnosa_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'diagnosa_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukan,
            'attribute' => 'diagnosa_rujukan',
            'data' => explode(',', $modRujukan->diagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukan', 'class' => ''),
        ));
        ?>
        <?php echo $form->error($modRujukan, 'diagnosa_rujukan'); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary pull-right', 'style' => 'margin: -37px 2px 0 0;', 'rel' => 'tooltip', 'title' => 'klik untuk mencari diagnosa rujukan', 'onclick' => '$(\'#dialogDiagnosa\').dialog(\'open\')')); ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddAsalRujukan',
    'options' => array(
        'title' => 'Menambah data Asal Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="divForFormAsalRujukan"></div>';
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddRujukanDari',
    'options' => array(
        'title' => 'Menambah data Nama Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormRujukanDari"></div>';
$this->endWidget();

?>