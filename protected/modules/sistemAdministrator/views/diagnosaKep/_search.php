<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'diagnosakep-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kode Diagnosa', 'diagnosakep_kode', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosakep_kode', array('placeholder' => 'Kode Diagnosa', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Diagnosa Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosakep_nama', array('placeholder' => 'Diagnosa Keperawatan', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Deskripsi', 'diagnosakep_deskripsi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosakep_deskripsi', array('placeholder' => 'Deskripsi', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'diagnosakep_aktif', array('checked' => 'diagnosakep_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit')
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