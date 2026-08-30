<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakarcis-m-search',
    'type' => 'horizontal',
));
?>

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
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'karcis_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'karcis_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'karcis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'karcis_aktif', array('checked' => 'checked')); ?> <label for="SAKarcisM_karcis_aktif">Aktif</label>
            </div>
        </div>
    </div>

</div>

<?php //echo $form->textFieldRow($model,'karcis_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span5'));  
?>
<?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span5'));  
?>

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