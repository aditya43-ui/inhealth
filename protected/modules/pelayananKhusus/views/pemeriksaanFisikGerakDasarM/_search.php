<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pemeriksaanfisikgerakdasar-m-search',
    'type' => 'horizontal',
        ));
?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Nama Pemeriksaan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'periksafungsigerakdasar_nama', array('class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Lainnya", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'periksafungsigerakdasar_namalainnya', array('class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'periksafungsigerakdasar_aktif', array('checked' => 'periksafungsigerakdasar_aktif')) ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="' . MyIcon::getIcons('cari') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>
<?php $this->endWidget(); ?>
