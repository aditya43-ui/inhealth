<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'komponengaji-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#KomponengajiM_nourutgaji',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model, 'nourutgaji', array('placeholder' => 'No. Urut Gaji', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'komponengaji_kode', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'komponengaji_kode', array('placeholder' => 'Kode Gaji', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam" data-toggle="tooltip" data-placement="top" title="" data-original-title="Perubahan <b>Kode Gaji Berpengaruh pada proses pengajuan gaji</b>, Jika ingin melakukan perubahan harap hubungi administrator / SIMRS" data-html="true"></i>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'komponengaji_nama', array('placeholder' => 'Nama Gaji', 'class' => 'span3 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->dropDownListRow($model, 'tipekomponengaji',  LookupM::getItems('tipekomponengaji'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'komponengaji_singkt', array('placeholder' => 'Singkatan Gaji', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penerimaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo '&nbsp;&nbsp;' . $form->radioButton($model, 'penerimaan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'name' => "komponen")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ispotongan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo '&nbsp;&nbsp;' . $form->radioButton($model, 'ispotongan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'name' => "komponen")); ?>
            </div>
        </div>

        <!--<div class="control-group">  
            <?php // echo $form->labelEx($model,'kelompokpegawai_id', array('class'=>'control-label')); 
            ?>
            <div class="controls">
                <?php // echo $form->dropDownList($model, 'kelompokpegawai_id', $model->getDropKelPegAktif(),array('empty' => '-- Choose --', 'class'=>'span3')); 
                ?>
                <i class="<?php // echo MyIcon::getIcons('info2') 
                            ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Jika data <b>field kelompok pegawai diisi</b>, maka <b>komponen gaji</b> ini, hanya tampil pada kelompok pegawai tersebut saja" data-html="true"></i>
            </div>
        </div>-->
        <?php echo $form->textFieldRow($model, 'nominal_satuan', array('placeholder' => '00', 'class' => 'span3 integer2 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        <?php //echo $form->checkBoxRow($model,'komponengaji_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'name'=>"aktif")); 
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Komponen Gaji', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>