<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfgenerik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#KUGrouplayananM_grouplayanan_nama',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'grouplayanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'grouplayanan_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'grouplayanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php if (!$model->isNewRecord) { ?>
            <div class="control-group">
                <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'grouplayanan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <label for="KUGrouplayananM_grouplayanan_aktif">Aktif</label>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'grouplayanan_definisi', array('placeholder' => 'Definisi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'grouplayanan_order', array('placeholder' => 'Urutan', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'text-align:right;')); ?>

        <div class="control-group">
            <?php echo CHtml::label("Pengelompokkan", '', array('class' => 'control-label')) ?>
            <div class="controls" id="radio-sesuai">
                <?php echo $form->radioButtonList($model, 'is_oa', array(
                    'is_oa' => 'Jenis Obat dan Alkes',
                    'is_tindakan' => 'Tindakan'
                ), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Grup Layanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('GFGenerikM_generik_namalain').value = nama.value.toUpperCase();
    }
</script>