
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvtanah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onclick' => 'cekDisabled(this);', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
));
?>

<p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'"01"')); ?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Data Inventarisasi Tanah</div>
    </div>
    <div class="panel-body">

        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->hiddenField($model, 'barang_id'); ?>
                <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php // echo $form->hiddenField($model, 'profilrs_id'); 
                ?>
                <?php echo $form->textFieldRow($model, 'kode_wilayah', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_kode', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_luas', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_thnpengadaan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'invtanah_tglguna', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invtanah_tglguna',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'invtanah_tglguna'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'invtanah_status', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textAreaRow($model, 'invtanah_alamat', array('rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'invtanah_tglsertifikat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invtanah_tglsertifikat',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'invtanah_tglsertifikat'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'invtanah_nosertifikat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_penggunaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_harga', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invtanah_ket', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglpenghapusan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpenghapusan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglpenghapusan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tipepenghapusan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'tipepenghapusan', CHtml::listData(MALookupM::getItemsTipeHapus(), 'lookup_value', 'lookup_name'), array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/invtanahT/admin'), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>            
    <?php
    $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Tanah', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invtanahT/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>
<script>
    $(document).ready(function() {
        cekDisabled($('#guinvtanah-t-form'));
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>