<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'laporankeuangan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Menu', 'menu_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'menu_nama', array('placeholder' => 'Nama Menu', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('URL Menu', 'menu_url', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'menu_url', array('placeholder' => 'URL Menu', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3', 'maxlength' => 100)); ?>
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