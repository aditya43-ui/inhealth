<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanaumumpengadaan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    .control-label {
        float: left;
        width: 250px;
        padding-top: 5px;
        text-align: left;
    }

    .red{
        color: red;
    }
</style>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pembatalan Rencana Umum Pengadaan  </b> </div>
    </div>
    <div class="panel-body">
        <?php echo $form->hiddenField($model, 'temp_file', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
        <div class="control-group">
            <?php echo CHtml::label("Alasan Pembatalan <span class='required'> * </span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                if (!empty($_GET['sukses'])) {
                    echo $form->textArea($model, 'batal_alasan', array('readonly' => true, 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    echo $form->textArea($model, 'batal_alasan', array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                }
                ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dokumen Pendukung', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                if (empty($_GET['sukses'])) {
                    echo $form->fileField($model, 'batal_dokumen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                }
                if (!empty($model->batal_dokumen)) {
                    echo CHtml::link($model->batal_dokumen, $this->createUrl('unduhDokumen', array('id' => $model->rencanaumumpengadaan_id)), array('title' => 'Unduh Lampiran', 'rel' => 'tooltip'));
                } else {
                    echo "<label> Belum ada dokumen yang diunggah </label>";
                }
                ?> 
            </div>
        </div>
        <div class="control-group">
            <label class="red"> <i></i> </label>
            <div class="controls">
            </div>
        </div>
        <label class="red"> <i> File berformat PDF dan maks 5MB </i> </label>
        <br>
        <br>
        <div class="row-fluid">
            <div class="form-action">
                <?php
                if (empty($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    document.getElementById("RencanaumumpengadaanT_batal_dokumen").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error("Ukuran file tidak boleh lebih dari 5MB", "Perhatian!");
            $("#RencanaumumpengadaanT_batal_dokumen").attr("src", "blank");
            $('#RencanaumumpengadaanT_batal_dokumen').wrap('<form>').closest('form').get(0).reset();
            $('#RencanaumumpengadaanT_batal_dokumen').unwrap();
            return false;
        }
        if (this.files[0].type.indexOf("pdf") == -1) {
            toastr.error("Tipe file harus PDF", "Perhatian!");
            $("#RencanaumumpengadaanT_batal_dokumen").attr("src", "blank");
            $('#RencanaumumpengadaanT_batal_dokumen').wrap('<form>').closest('form').get(0).reset();
            $('#RencanaumumpengadaanT_batal_dokumen').unwrap();
            return false;
        }
    };
</script>