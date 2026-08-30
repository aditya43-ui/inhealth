<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'salinen-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'linen_id',array('class'=>'span3')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(array('order' => 'ruangan_nama'), array('condition' => 'ruangan_aktif = TRUE')), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>

        <?php echo $form->dropDownListRow($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAll(array('order' => 'rakpenyimpanan_nama'), array('condition' => 'rakpenyimpanan_aktif = TRUE')), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>

        <?php //echo $form->textFieldRow($model,'kodelinen',array('class'=>'span3','maxlength'=>50)); 
        ?>

        <?php //echo $form->textFieldRow($model,'tglregisterlinen',array('class'=>'span3')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(array('order' => 'jenislinen_nama',)), 'jenislinen_id', 'jenislinen_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAll(array('order' => 'bahanlinen_nama'), array('condition' => 'bahanlinen_aktif = TRUE')), 'bahanlinen_id', 'bahanlinen_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Linen', 'barang_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_nama', array('placeholder' => 'Nama Linen', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'linen_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'linen_aktif', array('checked' => 'linen_aktif')); ?> <label for="SALinenM_linen_aktif">Linen Aktif</label>
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