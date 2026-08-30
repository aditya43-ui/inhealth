<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pppekerjaan-m-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'pekerjaan_nama'),
)); ?>

<div>
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'pekerjaan_id',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'pekerjaan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pekerjaan_nama', array('placeholder' => 'Pekerjaan', 'class' => 'span3 form-control hurufs-only', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pekerjaan_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3 form-control hurufs-only', 'maxlength' => 50)); ?>
        <?php //echo $form->checkBoxRow($model,'pekerjaan_aktif',array('checked'=>'checked')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'pekerjaan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pekerjaan_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
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