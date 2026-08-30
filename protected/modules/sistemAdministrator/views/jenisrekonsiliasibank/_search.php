<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'akjenisrekonsiliasibank-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisrekonsiliasibank_nama', array('placeholder' => 'Nama Jenis Rekonsiliasi Bank', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisrekonsiliasibank_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxRow($model, 'jenisrekonsiliasibank_aktif', array('checked' => 'jenisrekonsiliasibank_aktif')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>