<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'antibiotikmikro-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="controls">
            <?php echo $form->textFieldRow($model, 'antibiotikmikro_urutan', array('placeholder' => 'Urutan', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model, 'antibiotikmikro_kode', array('placeholder' => 'Kode', 'class' => 'span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
               
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'antibiotikmikro_aktif', array()) ?>
                <label for="SAAntibiotikMikroM_antibiotikmikro_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    <div class="control-group">
            <div class="controls">
            <?php echo $form->textFieldRow($model, 'antibiotikmikro_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model, 'antibiotikmikro_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
               
            </div>
        </div>
  
    

    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Antibiotik', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'simpan',
        '2' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
