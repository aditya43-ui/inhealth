<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenislinen-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'jenislinen_id',array('class'=>'span3')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenislinen_no', array('placeholder' => 'No Jenis Linen', 'class' => 'span3 integer', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jenislinen_nama', array('placeholder' => 'Jenis Linen', 'class' => 'span3', 'maxlength' => 200)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgldiedarkan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgldiedarkan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => "span3",
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'ukuranitem', array('placeholder' => 'Ukuran', 'class' => 'span3', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'beratitem', array('placeholder' => 'Berat', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'qtyitem', array('placeholder' => 'Qty', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'warnalinen', array('placeholder' => 'Warna Linen', 'class' => 'span3', 'maxlength' => 50)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'isberwarna', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isberwarna', array('checked' => 'isberwarna')); ?> <label for="SAJenislinenM_isberwarna">Berwarna</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>