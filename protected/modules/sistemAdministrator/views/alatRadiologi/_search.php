<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapemeriksaanalatrad-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'alatmedis_id',  CHtml::listData($model->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_nama', array('placeholder' => 'Nama Pemeriksaan', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_aetitle', array('placeholder' => 'Title', 'class' => 'span3', 'maxlength' => 100)); ?>

        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanalatrad_aktif'); ?>
                <label for="SAPemeriksaanalatradM_pemeriksaanalatrad_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>