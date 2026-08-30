<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'agunitkerja-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kodeunitkerja', array('placeholder' => 'Kode', 'class' => 'span3 angkahurufs-only', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'namaunitkerja', array('placeholder' => 'Nama Unit', 'class' => 'span3 hurufs-only', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3 hurufs-only', 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Divisi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'divisi', LookupM::getItems('divisiunitkerja'), array('empty' => 'Pilih', 'class'=>'span3')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'unitkerja_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'unitkerja_aktif', array('checked' => 'checked')); ?>
                <label for="SAUnitkerjaM_unitkerja_aktif">Aktif</label>
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