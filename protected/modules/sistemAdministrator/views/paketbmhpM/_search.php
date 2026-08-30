<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tipe Paket', 'tipepaket_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'tipepaket_id', CHtml::listData(SATipePaketM::getItems(), 'tipepaket_id', 'tipepaket_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldROw($model, 'paketbmhp_nama', array('class' => 'span3')); ?>
        <?php echo $form->textFieldROw($model, 'paketbmhp_namalain', array('class' => 'span3')); ?>
        <?php echo $form->textFieldROw($model, 'paketbmhp_nomorpaket', array('class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
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