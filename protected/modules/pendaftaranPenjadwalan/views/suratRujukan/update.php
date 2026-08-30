<!--<div class="white-container">-->
<!--<legend class="rim2">Update Surat Rujukan Keluar</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rujukan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Rujukan berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<!--<div class="row-fluid">-->
<fieldset class="box">
    <legend class="rim">Pembuat Rujukan Keluar</legend>
    <div class="row-fluid">
        <div class="span6">
            <?php $readonly = true; ?>
            <?php echo CHtml::hiddenField('sep_id', $modInfoKunjungan->sep_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo CHtml::label("No. SEP <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('nosep', $modInfoKunjungan->nosep, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('no_pendaftaran', $modInfoKunjungan->no_pendaftaran, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('no_rekam_medik', $modInfoKunjungan->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('tgl_pendaftaran', $modInfoKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo CHtml::hiddenField('tglselesaiperiksa',$modInfoKunjungan->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::textField('nama_pasien', $modInfoKunjungan->nama_pasien, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('tanggal_lahir', $modInfoKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('jeniskelamin', $modInfoKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textArea('alamat_pasien', $modInfoKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<?php echo CHtml::textField('ppk_terdaftar', '', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'disabled' => true, 'style' => 'display:none')); ?>
<fieldset class="box" id="content-bpjs">
    <legend class="rim">Data Rujukan</legend>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group ">
                <?php echo CHtml::label("No. Rujukan <span class='required'>*</span>", 'norujukan', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nosuratrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tgldirujuk', array('class' => 'control-label', 'label' => 'Tgl. Rujukan')); ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker', [
                        'model' => $model,
                        'attribute' => 'tgldirujuk',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 tgldirujuk', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ]); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglrencanakunjungan_bpjs', array('class' => 'control-label', 'label' => 'Tgl. Rencana Kunjungan')); ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker', [
                        'model' => $model,
                        'attribute' => 'tglrencanakunjungan_bpjs',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 tglrencanakunjungan_bpjs', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ]); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Jenis Faskes", 'Jenis Faskes', array('class' => 'control-label')) ?>
                <div class="controls form-inline">
                    <?php
                    echo $form->radioButtonList($model, 'jenisfaskes', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Kode PPK Dirujuk ke <span class='required'>*</span><i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'ppkrujukan', array('placeholder' => 'Kode PPK Rujukan', 'class' => 'span3 required ppkrujukan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Nama PPK Dirujuk ke <span class='required'>*</span><i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'ppkrujukan_nama', array('placeholder' => 'Nama PPK Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogDiagnosaBpjs').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'diagnosasementara_ruj', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                    //echo $form->hiddenField($model, 'diagnosasementara_ruj',['class'=>'diagnosasementara_ruj required']);
                    echo $form->hiddenField($model, 'kodediagnosasementara_ruj', ['class' => 'kodediagnosasementara_ruj required']); ?>
                </div>
            </div>

        </div>
        <div class="span6">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'Pelayanan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenispelayanan_bpjs',  array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Tipe Rujukan <span class='required'>*</span>", 'Tipe Rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'tiperujukan_bpjs',  CHtml::listData(LookupM::model()->findAll("lookup_type = 'tiperujukan_bpjs'"), 'lookup_kode', 'lookup_name'), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Poli Rujukan <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogPoli').dialog('open'); cariDataPoli();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'dirujukkebagian_nama', array('readonly' => true, 'placeholder' => 'Poli Tujuan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textField($model, 'dirujukkebagian', array('placeholder' => 'Poli Tujuan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("User BPJS", 'userinput_bpjs', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'userinput_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Catatan <span class='required'>*</span>", 'catatandokterperujuk', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'catatandokterperujuk', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<!--</div>-->
<div class="row-fluid">
    <div class="form-actions">
        <?php
        $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
        $disabledSave = ($sukses == 1) ? true : false;
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekInput(2);return false;')); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('update'),
            array(
                'class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        if (Yii::app()->user->getState('isbridging')) {
            if (isset($model->sep_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRujukan();return false", 'disabled' => FALSE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. Rujukan!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            }
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<!--</div>-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPoli',
    'options' => array(
        'title' => 'Referensi Poli BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.suratRujukan._pencarianPoliRujukan');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaBpjs',
    'options' => array(
        'title' => 'Referensi Diagnosa BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.sepAsuransi._pencarianDiagnosa');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPpk',
    'options' => array(
        'title' => 'Referensi PPK Rujukan/Faskes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.suratRujukan._pencarianPpk');
$this->endWidget();
?>
<?php
echo $this->renderPartial('_jsFunctions', array('model' => $model));
?>