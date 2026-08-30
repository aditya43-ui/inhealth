<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ptkp-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span5')); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglberlaku', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglberlaku',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3 span2',
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'jmltanggunan', array('placeholder' => 'Jumlah Tanggungan', 'class' => 'span4 numbers-only', 'maxlength' => 100, 'style' => 'text-align:right;')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'wajibpajak_thn', array('placeholder' => 'Nilai Wajib Pajak (Tahun)', 'class' => 'span4 numbers-only', 'maxlength' => 20, 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'wajibpajak_bln', array('placeholder' => 'Nilai Wajib Pajak (Bulan)', 'class' => 'span4 numbers-only', 'maxlength' => 20, 'style' => 'text-align:right;')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'berlaku', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'berlaku', array('checked' => 'checked')); ?> <label for="SAPtkpM_berlaku">Aktif</label>
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