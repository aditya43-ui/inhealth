<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sanilairujukan-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelkumurhasillab_id', CHtml::listData(KelkumurhasillabM::model()->findAll(array('order' => 'kelkumurhasillab_urutan'), 'kelkumurhasillab_aktif = true'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>

        <?php echo $form->dropDownListRow($model, 'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldRow($model, 'kelompokdet', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Kelompok Detail')); ?>

        <?php echo $form->textFieldRow($model, 'namapemeriksaandet', array('class' => 'span3', 'maxlength' => 200, 'placeholder' => 'Nama Detail Pemeriksaan')); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'nilairujukan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'nilairujukan_aktif', array('id' => 'aktif', 'checked' => 'checked')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nilairujukan_nama', array('class' => 'span3', 'maxlength' => 100, 'placeholder' => 'Nilai Rujukan')); ?>

        <?php echo $form->textFieldRow($model, 'nilairujukan_min', array('class' => 'span3', 'placeholder' => 'Nilai Minimal')); ?>

        <?php echo $form->textFieldRow($model, 'nilairujukan_max', array('class' => 'span3', 'placeholder' => 'Nilai Maksimal')); ?>
        <?php
        //echo $form->textFieldRow($model,'nilairujukan_satuan',array('class'=>'span3','maxlength'=>50)); 
        echo $form->dropDownListRow($model, 'nilairujukan_satuan', LookupM::getItems('satuanhasillab'), array('class' => 'span3', 'empty' => '-- Pilih --'))
        ?>
        <?php echo $form->textFieldRow($model, 'nilairujukan_metode', array('class' => 'span3', 'maxlength' => 30, 'placeholder' => 'Metode')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
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