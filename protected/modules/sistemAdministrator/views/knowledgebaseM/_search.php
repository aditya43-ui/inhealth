<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'knowledgebase-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
<div class="col-sm-6">
    <?php echo $form->dropDownListRow($model,'knowledgebase_jenis',LookupM::getItems('jenisknowledgebase'),array('empty' => '-- Pilih --')) ?>
    <?php echo $form->textFieldRow($model,'knowledgebase_nama'); ?>
</div>
<div class="col-sm-6">
<?php echo $form->textAreaRow($model,'knowledgebase_deskripsi'); ?>
        <div class="control-group">
            <?php echo CHtml::label('Aktif', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'knowledgebase_aktif', array('checked' => 'knowledgebase_aktif')); ?>
                <label for="SAFM_knowledgebase_aktif">Aktif</label>
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