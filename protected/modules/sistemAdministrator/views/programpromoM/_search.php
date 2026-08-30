<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saprogram-promo-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namaprogrampromo', array('placeholder' => 'Nama Program Promo', 'class' => 'span3', 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelompoktindakan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'programpromo_aktif', array('checked' => 'kelompoktindakan_aktif')); ?>
                <label for="SAProgrampromoM_programpromo_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'kelompoktindakan_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'kelompoktindakan_urutan',array('class'=>'span5')); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="fa fa-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>
<?php $this->endWidget(); ?>