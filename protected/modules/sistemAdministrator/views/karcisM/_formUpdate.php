<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakarcis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'daftartindakan_id', CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'), array(
            'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --'
        ));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'), array(
            'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --'
        ));
        ?>

<?php
        echo $form->dropDownListRow($model, 'asalrujukan_id', CHtml::listData($model->AsalRujukan, 'asalrujukan_id', 'asalrujukan_nama'), array(
            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --'
        ));
        ?>


        <div class="control-group">
            <?php echo CHtml::label("", 'karcis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'karcis_aktif'); ?> <label for="SAKarcisM_karcis_aktif">Aktif</label>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'karcis_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'karcis_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->radioButtonListInlineRow($model, 'statuspasien', LookupM::getItems('statuspasien')); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/karcisM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Karcis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('karcisM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>