<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jadwalhari-m-search',
    'type' => 'horizontal',
)); ?>

<?php echo $form->textFieldRow($model, 'jadwalhari_nama', array('placeholder' => 'Nama Jadwal Hari', 'class' => 'span3', 'maxlength' => 100)); ?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_senin'); 
?>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_senin', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_senin', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_selasa', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_selasa', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_rabu', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_rabu', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_kamis', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_kamis', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_jumat', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_jumat', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_sabtu', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_sabtu', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_hari_minggu', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_hari_minggu', array('class' => '')); ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php echo $form->checkBox($model, 'jadwalhari_aktif', array('checked' => 'alatmedis_aktif')); ?>
            <?php echo CHtml::activeLabel($model, 'jadwalhari_aktif', array('class' => '')); ?>
        </div>
    </div>
</div>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_selasa'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_rabu'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_kamis'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_jumat'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_sabtu'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_hari_minggu'); 
?>

<?php // echo $form->checkBoxRow($model,'jadwalhari_aktif'); 
?>
<?php // echo $form->checkBoxRow($model,'jadwalhari_aktif',array('checked'=>true)); 
?>

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