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
        <?php echo $form->hiddenField($modAsuransiPasien, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group " style="display:none">
            <?php echo CHtml::label("Jenis/Asal Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls form-inline">
                <?php
                echo $form->radioButtonList($model, 'jenispeserta_id', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group" style="display:none">
            <?php echo CHtml::label("No.Rujukan Faskes 1<span class='required'>*</span> <i class=\"icon-search\" onclick=\"getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modRujukanBpjs, 'no_rujukan', array('placeholder' => 'No. Rujukan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
            </div>
        </div>
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

        <div class="control-group " style="display:none">
            <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group " style="display:none">
            <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'jnspelayanan', array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3', 'disabled' => true)); ?>


        <?php echo $form->hiddenField($model, 'klsrawat', array()); ?>

        <div class="control-group " style="display:none">
            <?php echo CHtml::label("No. Rujukan <span class='required'>*</span>", 'norujukan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'norujukan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>

        <div class="control-group" style="display:none">
            <?php echo CHtml::label("Kode PPK Rujukan <span class='required'>*</span><i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkrujukan', array('placeholder' => 'Kode PPK Rujukan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group" style="display:none">
            <?php echo CHtml::label("Nama PPK Rujukan <i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkrujukan_nama', array('placeholder' => 'Nama PPK Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Poli Tujuan <span class='required'>*</span> ", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'politujuan', array('readonly' => true, 'placeholder' => 'Poli Tujuan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
                    'carakeluar_aktif'=>true,
                ), array(
                    'order'=>'carakeluar_id',
                )), 'carakeluar_id', 'carakeluar_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange'=>'setTanggalMeninggalCaraKeluar();')); ?>
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
            <?php echo $form->textFieldRow($model, 'nosurat_ketmeninggal', array('class'=>'span3')); ?>
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
        <?php echo $form->textFieldRow($model, 'kll_nolaporan_polisi', array('class'=>'span3', 'readonly'=>true)); ?>
        <div class="control-group" style="display:none">
            <label class="control-label required">
                Tanggal Rujukan
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modRujukanBpjs,
                    'attribute' => 'tanggal_rujukan',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span2 datetime', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>


        <div class="control-group form-inline" style="display:none">
            <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'is_cob', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline" style="display:none">
            <?php echo CHtml::label("Laka Lantas", 'Lantas', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'is_lakalantas', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setLakaLantas(this)'));
                ?>
            </div>
        </div>
        <div class="control-group " style="display:none">
            <?php echo CHtml::label("Penjamin", 'Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_lakalantas', array('1' => 'Jasa Raharja PT', '2' => 'BPJS Ketenagakerjaan', '3' => 'TASPEN', '4' => 'ASABRI PT'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                ));
                ?>
            </div>
        </div>
        <div class="control-group" style="display:none">
            <?php echo CHtml::label("Lokasi Laka Lantas", 'lokasi_lakalantas', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lokasi_lakalantas', array('placeholder' => 'Lokasi laka lantas', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group" style="display:none">
            <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textArea($model, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => "display:none")); ?>

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
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs)); ?>

<script>
    function setTanggalMeninggalCaraKeluar() {
        var carakeluar_id = $("#ARSepT_statuspulang_kode").val();

        if (carakeluar_id == 4) {
            $(".input_meninggal").show();
        } else {
            $(".input_meninggal").hide().find(":input").val("");
        }
    }

    $(document).ready(function() {
        setTanggalMeninggalCaraKeluar();
    });
</script>