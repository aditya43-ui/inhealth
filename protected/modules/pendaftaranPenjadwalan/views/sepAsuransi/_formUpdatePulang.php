<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'assep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
));
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "SEP berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid" id="content-bpjs">
    <div class="span6">

        <?php echo $form->hiddenField($modAsuransiPasien, 'nokartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'nopeserta', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'tglcetakkartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->hiddenField($modAsuransiPasien, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group ">
            <label class="control-label">
                No. SEP
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nosep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nosep'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglsep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglsep', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>

       
        <?php echo $form->dropDownListRow($model, 'jnspelayanan', array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3', 'disabled' => true)); ?>


        <?php echo $form->hiddenField($model, 'klsrawat', array()); ?>


        <div class="control-group">
            <?php echo CHtml::label("Poli Tujuan", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'politujuan', array('readonly' => true, 'placeholder' => 'Poli Tujuan', 'class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->poli_eksekutif = $model->poli_eksekutif ?? "0";
                echo $form->radioButtonList($model, 'poli_eksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'disabled' => true));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Kelas Tanggungan", 'kelastanggungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelastanggungan', array('1' => 'Kelas I', '2' => 'Kelas II', '3' => 'Kelas III'), array(
                    'empty' => '-Pilih-', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'disabled' => true
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Diagnosa <span class='required'>*</span> ", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosaawal', array('readonly' => true, 'placeholder' => 'Diagnosa Awal', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> ", 'nopeserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopeserta', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nopeserta'); ?>
                <?php echo $form->hiddenField($model, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

        <div class="control-group">
            <?php echo CHtml::label("Status Pulang <span class='required'>*</span> ", 'statuspulang', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statuspulang_kode', CHtml::listData(CarakeluarM::model()->findAllByAttributes(array(
                    'carakeluar_aktif' => true,
                ), array(
                    'order' => 'carakeluar_id',
                )), 'carakeluar_id', 'carakeluar_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'setTanggalMeninggalCaraKeluar();')); ?>
            </div>
        </div>
        <div class="input_meninggal">
            <div class="control-group">
                <label class="control-label required">
                    Tanggal Meninggal
                    <span class="required">*</span>
                </label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_meninggal',
                        'mode' => 'date',
                        'options' => array(
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            //                                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nosurat_ketmeninggal', array('class' => 'span3')); ?>
        </div>
        <div class="control-group">
            <label class="control-label required">
                Tanggal Pulang
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpulang',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        //                                            'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'kll_nolaporan_polisi', array('class' => 'span3', 'readonly' => false)); ?>

        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        

    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disabledSave = isset($_GET['id']) ? true : (($sukses == 1) ? true : false);
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekInput(this,15);return false;')); ?>

</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs)); ?>

<script>
    function setTanggalMeninggalCaraKeluar() {
        var carakeluar_id = $("#ARSepT_statuspulang_kode").val();

        if (carakeluar_id == 4) {
            $(".input_meninggal").show();
            $('.input_meninggal').find(".not-required").addClass("required").removeClass("not-required");
        } else {
            $('.input_meninggal').find(".required").addClass("not-required").removeClass("required");
            $(".input_meninggal").hide().find(":input").val("");
        }
    }

    $(document).ready(function() {
        setTanggalMeninggalCaraKeluar();
    });
</script>