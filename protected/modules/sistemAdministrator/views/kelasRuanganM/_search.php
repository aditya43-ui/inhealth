<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppruangan-m-search',
    'type' => 'horizontal',
)); ?>
<?php
$display = "display:none;";
if (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) {
    $display = "";
} ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group" style="<?php echo $display; ?>">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'instalasi_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group" style="<?php echo $display; ?>">
            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ruangan_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(SAKelasPelayananM::model()->getItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')); ?>
            </div>
        </div>
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