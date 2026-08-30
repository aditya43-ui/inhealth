<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sarakpenyimpanan-m-search',
    'type' => 'horizontal',
));
?>

<?php //echo $form->textFieldRow($model,'rakpenyimpanan_id',array('class'=>'span3')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'lokasipenyimpanan_id', CHtml::listData($model->LokasipenyimpananItems, 'lokasipenyimpanan_id', 'lokasipenyimpanan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_label', array('placeholder' => 'Label', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 5)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'rakpenyimpanan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'rakpenyimpanan_aktif', array('checked' => 'checked')); ?> <label for="SARakpenyimpananM_rakpenyimpanan_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>