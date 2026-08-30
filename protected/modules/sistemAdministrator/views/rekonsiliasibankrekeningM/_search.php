<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisrekonsiliasi-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenisrekonsiliasibank_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenisrekonsiliasibank_nama', array('placeholder' => 'Nama Jenis Rekonsiliasi Bank', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenisrekonsiliasibank_namalain', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenisrekonsiliasibank_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo CHtml::label('Rekening Debit', 'rekeningDebit', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rekening_debit', array('placeholder' => 'Rekening Debit', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Rekening Kredit', 'rekeningDebit', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rekeningKredit', array('placeholder' => 'Rekening Kredit', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit')
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