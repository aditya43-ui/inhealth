<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saimplementasikeperawatan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->dropDownListRow($model, 'diagnosakeperawatan_id', CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'implementasikeperawatan_kode', array('class' => 'span3', 'maxlength' => 20)); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->dropDownListRow($model, 'rencanakeperawatan_id', CHtml::listData($model->RencanaKeperawatanItems, 'rencanakeperawatan_id', 'rencana_kode'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textAreaRow($model, 'implementasi_nama', array('rows' => 6, 'cols' => 20, 'class' => 'span3')); ?>
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