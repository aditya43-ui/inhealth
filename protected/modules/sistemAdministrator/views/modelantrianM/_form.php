<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'modelantrian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'modelantrian_kode', array('placeholder' => 'Antrian Kode', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_nama', array('placeholder' => 'Antrian Nama', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_layanan', array('placeholder' => 'Layanan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Warna", 'modelantrian_warna', array('class' => 'control-label')) ?>
            <div class="controls">
                <input id="ModelantrianM_modelantrian_warna" value="<?= $model->modelantrian_warna?>" type="color" class="span3" name="ModelantrianM[modelantrian_warna]"> </input>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'modelantrian_deskripsi', array('placeholder' => 'Deskripsi', 'rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_formatnomor', array('placeholder' => 'Format Nomor', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'modelantrian_maksantrian', array('placeholder' => 'Maks. Antrian', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


        <div class="control-group">
            <?php echo CHtml::label("Gambar", 'modelantrian_gambar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'modelantrian_gambar', array('accept' => 'image/*', 'Hint' => 'Isi Jika Akan Menambahkan Gambar Model Antrian')); ?>
            </div>
        </div>
        <?php if (!empty($model->modelantrian_id)) :  ?>
            <div class="control-group">
                <label class="control-label"> </label>
                <div class="controls">
                    <?php
                    $url_ttd = (!empty($model->modelantrian_gambar) ? Params::urlProfilRSDirectory() . $model->modelantrian_gambar : Params::urlProfilRSDirectory() . "no_photo.jpeg");
                    ?>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img src="<?php echo $url_ttd; ?>" /></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'modelantrian_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'modelantrian_aktif'); ?> <label for="ModelantrianM_modelantrian_aktif">Aktif</label>
            </div>
        </div>

    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Model Antrian', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>