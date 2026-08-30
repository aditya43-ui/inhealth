<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'notadinasppk-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        //'enctype'=>'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'nomor_notadinas') . '',
        ));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Detail Nota Dinas PPK </b> </div>        
    </div>
    <div class="panel-body">                        
        <div class="col-sm-6">
            <?php
            echo $form->hiddenField($model, 'suratperjanjiankerja_id', array('readonly' => true));
            echo $form->textFieldRow($model, 'notadinasppk_nomor', array('readonly' => true));
            ?>
            <div class="control-group">
                    <?php echo CHtml::label('Termin <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'termin_angka', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <label> dari</label>
                    <?php echo $form->textField($model, 'termin_jumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($model, 'termin_persen', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($model, 'total_pembayaran', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <?php
            echo $form->textFieldRow($model, 'nomor_notadinas', array('readonly' => true));
            echo $form->textAreaRow($model, 'kepada', array('readonly' => true));
            ?>
        </div>

        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'notadinasppk_tanggal', array('readonly' => true)); ?>
            <?php
            echo $form->textFieldRow($model, 'pegppk_nama', array('readonly' => true));
            echo $form->textAreaRow($model, 'pekerjaan', array('readonly' => true));
            ?>
        </div>                
    </div>
</div>

<?php $this->endWidget(); ?>
