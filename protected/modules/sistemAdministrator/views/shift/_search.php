<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sashift-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'shift_nama', array('placeholder' => 'Nama Shift', 'class' => 'span3', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldRow($model, 'shift_kode', array('placeholder' => 'Kode Shift', 'class' => 'span3', 'maxlength' => 1)); ?>

        <?php echo $form->textFieldRow($model, 'shift_namalainnya', array('placeholder' => 'Nama Lain Shift', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Dari Jam', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'shift_jamawal',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'shift_jamakhir',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'shift_urutan', array('placeholder' => '00', 'class' => 'span2 integer')); ?>


        <div class="control-group">
            <?php echo CHtml::label("", 'shift_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'shift_aktif', array('checked' => 'checked')); ?>
                <label for="SAShiftM_shift_aktif">Aktif</label>
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