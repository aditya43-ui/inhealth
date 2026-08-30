<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenisalatmedis-m-search',
    'type' => 'horizontal',
        ));
?>


<div class="control-group">
    <?php echo CHtml::label("Nama Jenis Alat Medis", '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'jenisalatmedis_nama', array('class' => 'span3', 'maxlength' => 100)); ?>
    </div>				
</div>
<div class="control-group">
    <?php echo CHtml::label("Nama Lainnya", '', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'jenisalatmedis_namalain', array('class' => 'span3', 'maxlength' => 100)); ?>
    </div>				
</div>

<div class="control-group">
        <?php echo CHtml::label("", 'jenisalatmedis_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'jenisalatmedis_aktif', array('checked' => 'jenisalatmedis_aktif')) ?> <label>Aktif</label>
        </div>				
    </div>
<?php //echo $form->textFieldRow($model,'jenisalatmedis_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
