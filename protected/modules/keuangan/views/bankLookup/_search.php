<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakonfigfarmasi-k-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lookup_name', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Value", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lookup_value', array('placeholder' => 'Value', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'lookup_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'lookup_aktif', array('checked' => 'lookup_aktif')) ?>
                <label for="KULookupM_lookup_aktif">Aktif</label>
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