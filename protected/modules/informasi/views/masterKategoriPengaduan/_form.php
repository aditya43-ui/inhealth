<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sainstalasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#INKategoriPengaduanM_namakategori',
)); ?>

<?php echo $form->errorSummary(array($model)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namakategori', array('placeholder' => 'Nama Kategori', 'class' => 'span4 required', 'onkeypress' => "return nextFocus(this,event,'INKategoriPengaduanM_warnakategoripengaduan','')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'warnakategoripengaduan', array('placeholder' => 'Warna Ketegori', 'class' => 'span4 required', 'onkeypress' => "return nextFocus(this,event,'INKategoriPengaduanM_estimasipenyelesaian','INKategoriPengaduanM_namakategori')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'estimasipenyelesaian', array('placeholder' => 'Estimasi Penyelesaian', 'class' => 'span4 required numbers-only', 'onkeypress' => "return nextFocus(this,event,'INKategoriPengaduanM_warnakategoripengaduan','INKategoriPengaduanM_estimasipenyelesaian')")); ?>
        <div class="control-group">
        <?php 
            if(isset($model->kategoripengaduan_id)){
        ?>
            <?php echo CHtml::label("", 'kategoripengaduan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kategoripengaduan_aktif'); ?>
                <label for="INKategoriPengaduanM_kategoripengaduan_aktif">Aktif</label>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/instalasiM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>