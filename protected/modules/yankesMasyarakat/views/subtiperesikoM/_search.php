<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'subtiperesiko-m-search',
    'type' => 'horizontal',
        ));
?>
<div class="col-md-6">
    <div class="control-group">
        <?php echo Chtml::label('Tipe Risiko', 'tiperesiko_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'tiperesiko_id', Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif' => true)), 'tiperesiko_id', 'tiperesiko_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
    </div> 
    <div class="control-group">
            <?php echo Chtml::label('Sub Tipe Risiko', 'subtiperesiko_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'subtiperesiko_nama', array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
    </div> 
</div>
<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'subtiperesiko_urutan', array('class' => 'span3 numbers-only')); ?>
    
    <?php echo $form->textAreaRow($model, 'subtiperesiko_keterangan', array('class' => 'span3')); ?>


    <?php echo $form->checkBoxRow($model, 'subtiperesiko_aktif', array('checked' => 'checked')); ?>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>
