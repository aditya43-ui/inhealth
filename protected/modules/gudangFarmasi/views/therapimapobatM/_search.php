<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gftherapimapobatm-search',
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#GFTherapimapobatM_obatalkes_nama',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'Nama Obat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'obatalkes_nama', array('placeholder' => 'Nama Obat', 'class' => 'span3', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'Nama Kelas Terapi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'therapiobat_nama', array('placeholder' => 'Nama Kelas Terapi', 'class' => 'span3', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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