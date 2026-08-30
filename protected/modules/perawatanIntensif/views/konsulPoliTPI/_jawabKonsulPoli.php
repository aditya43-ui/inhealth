<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<fieldset class="box">
    <legend class="rim">Permintaan Konsul</legend>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modKonsul, 'tglkonsulpoli', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'disabled' => true)); ?>

            <?php echo $form->dropDownListRow($modKonsul, 'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true));
            ?>

            <?php echo $form->dropDownListRow($modKonsul, 'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasiItems('', true, $modKonsul->ruangan_id), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true));
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modKonsul, 'NamaPegawai', array('value' => $modKonsul->getNamaLengkapDokter($modKonsul->pegawai_id), 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true));
            ?>

            <?php //echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <br/>
            <b>Catatan Dokter</b>
            <br/>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Subjective</label>
                <div class="controls" style="width:80%;">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'subjective', 'toolbar'=>'mini','height'=>'100px')) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Objective</label>
                <div class="controls" style="width:80%;">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'objective', 'toolbar'=>'mini','height'=>'100px')) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Assessment</label>
                <div class="controls" style="width:80%;">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'assessment', 'toolbar'=>'mini','height'=>'100px')) ?>
                </div>
            </div>
            <?php //echo $form->textAreaRow($modKonsul, 'subjective', array('placeholder' => 'Subjective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($modKonsul, 'assessment', array('placeholder' => 'Assessment', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            <div class="control-group">
                <label class="control-label">Planning</label>
                <div class="controls" style="width:80%;">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'planning', 'toolbar'=>'mini','height'=>'100px')) ?>
                </div>
            </div>
            <?php //echo $form->textAreaRow($modKonsul, 'objective', array('placeholder' => 'Objective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($modKonsul, 'planning', array('placeholder' => 'Planning', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</fieldset>
<fieldset class="box">
    <legend class="rim">Jawaban Konsul</legend>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('jawabkonsulpoli_id' => $modJawabKonsul->jawabkonsulpoli_id)), array('readonly' => TRUE)); ?>
            <?php echo $form->labelEx($modJawabKonsul, 'tgljawabkonsul', array('class' => 'control-label')) ?>
            <?php $modJawabKonsul->tgljawabkonsul = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modJawabKonsul->tgljawabkonsul, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modJawabKonsul,
                    'attribute' => 'tgljawabkonsul',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3', 'readonly' => true),
                ));
                ?>
            </div>
            <?php echo $form->dropDownListRow($modJawabKonsul, 'pegawai_id', CHtml::listData($modKonsul->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textAreaRow($modJawabKonsul, 'jawabankonsul', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</fieldset>
<div class="form-actions">
    <?php
    if ($modJawabKonsul->isNewRecord) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
        );
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'title' => 'Simpan',
                'class' => 'btn btn-danger',
                'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'disabled' => true
            )
        );
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    }
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printJawabKonsul');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&jawabkonsulpoli_id="+$modJawabKonsul->jawabkonsulpoli_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>

<?php $this->endWidget(); ?>