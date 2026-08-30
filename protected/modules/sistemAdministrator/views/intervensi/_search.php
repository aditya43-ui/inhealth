<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bataskarakteristik-k-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosakep_nama', array('placeholder' => 'Kode / Nama Diagnosa', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Indikator', 'intervensidet_indikator', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'intervensidet_indikator', array('placeholder' => 'Indikator', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Nama Intervensi', 'intervensi_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'intervensi_nama', LookupM::getItems('levelintervensikeperawatan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onblur' => 'refreshTable();')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'intervensidet_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'intervensidet_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk mengaktifkan / menonaktifkan status', 'checked' => 'intervensidet_aktif')); ?> <label>Aktif</label>
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