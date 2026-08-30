<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenis-kelas-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelaspelayanan_nama', array('placeholder' => 'Kelas Pelayanan', 'class' => 'span3', 'maxlength' => 50)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'kelaspelayanan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelaspelayanan_aktif', array('checked' => 'checked')); ?>
                <label for="SAKelasPelayananM_kelaspelayanan_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'kelaspelayanan_id',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'jeniskelas_nama',array('class'=>'span3','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'kelaspelayanan_namalainnya',array('class'=>'span5','maxlength'=>50)); 
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