<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'approve-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Approval berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<!--<div class="row-fluid">-->
<fieldset class="box" id="content-bpjs">
    <div id="animation"></div>
    <legend class="rim">Data Pengajuan Approval SEP</legend>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_kartu_bpjs', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('no_pendaftaran', $modInfoKunjungan->no_pendaftaran ?? '', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('no_rekam_medik', $modPasien->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Tgl Sep <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tgl_sep', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group ">
                <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenis_pelayanan',  array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('empty' => '--Pilih--', 'class' => 'span3 required', 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'user_approval_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Catatan/Keterangan <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'catatan', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Jenis Pengajuan <span class='required'>*</span>", '', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jnspengajuan_approvalsep',  LookupM::getItems('jnspengajuan_approvalsep'), array('empty' => '--Pilih--', 'class' => 'span3', 'readonly' => true)); ?>    
                </div>
            </div>
        </div>
    </div>
</fieldset>
<!--</div>-->
<div id="animation"></div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
        $disabledSave = ($sukses == 1) ? true : false;
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Approve', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave));  //'onclick' => 'approve(this,14);return false;' ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>