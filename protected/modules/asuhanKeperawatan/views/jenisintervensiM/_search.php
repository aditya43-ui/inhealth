<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisintervensi-m-search',
    'type' => 'horizontal',
        ));
?>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Kode Intervensi</label>
        <div class="controls">
            <?php echo $form->textField($model, 'jenisintervensi_kode', array('class' => 'span3', 'maxlength' => 10)); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nama Intervensi</label>
        <div class="controls">
            <?php echo $form->textField($model, 'jenisintervensi_nama', array('class' => 'span3', 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'jenisintervensi_aktif', array('checked' => 'jenisintervensi_aktif')); ?> <label>Aktif</label>
        </div>				
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?></div>

<?php $this->endWidget(); ?>
