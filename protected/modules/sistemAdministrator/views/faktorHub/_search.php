<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bataskarakteristik-k-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosakep_nama', array('placeholder' => 'Diagnosa Keperawatan', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Indikator', 'faktorhubdet_indikator', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'faktorhubdet_indikator', array('placeholder' => 'Indikator', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Nama Kondisi Klinis Terkait', 'faktorhub_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'faktorhub_nama', LookupM::getItems('faktorhub_as'), array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'inputRequire'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'faktorhubdet_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'faktorhubdet_aktif', array('checked' => 'faktorhubdet_aktif')); ?>
                <label for="SAFaktorhubdetM_faktorhubdet_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>