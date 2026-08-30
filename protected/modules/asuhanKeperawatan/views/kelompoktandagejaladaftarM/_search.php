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
            <?php echo CHtml::label('Jenis Tanda dan Gejala', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenistandagejala_id', JenistandagejalaM::getDropDownJenis(), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanda dan Gejala', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tandagejala_daftar_nama', array('class' => 'span3', 'placeholder' => 'Tanda Gejala')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Status", 'jenistandagejaladaftar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <!--<?php // echo $form->checkBox($model, 'jenistandagejaladaftar_aktif', array('checked' => 'jenistandagejaladaftar_aktif')); 
                    ?> <label>Aktif</label>-->
                <?php echo $form->dropdownList($model, 'jenistandagejaladaftar_aktif', array(0 => 'Tidak Aktif', 1 => 'Aktif'), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
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