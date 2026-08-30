<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gradinginsidenrs-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label('Tanggal ', 'tgl_gradingunit', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->textField($model, 'tgl_persetujuan', array('class' => 'span3', 'disabled' => true));
            ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo Chtml::label("Status Laporan", 'statuslaporan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php
            echo $form->dropDownList($model, 'statuslaporan', array(
                'Disetujui' => 'Disetujui',
                'Ditolak' => 'Ditolak'
                    ), array('empty' => '-- Pilih --', 'class' => 'span3', 'disabled' => true))
            ?>
        </div>
    </div>
    <?php if(($model->statuslaporan) == 'Ditolak') : ?>
    <div class="control-group" id="penolakan">
        <?php echo Chtml::label("Kategori Penolakan", 'statuslaporan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->dropDownList($model, 'kategoripenolakan', LookupM::getItems("kategoripenolakan"), array('class' => 'span3', 'empty' => '-- Pilih --', 'disabled' => true)); ?>
        </div>
    </div>
    <?php endif;?>
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'tindakan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'alasan_persetujuan', array('class' => 'span3', 'rows' => 5, 'disabled' => true)); ?>
            <?php echo $form->hiddenField($model, 'insidenrs_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?> 

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>