<?php ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvasetlain-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onclick'=>'cekDisabled(this);','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>
<?php echo $form->errorSummary($model); ?>
<?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'"05"')); ?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Aset Tetap Lainnya</div>
    </div>
    <div class="panel-body">

        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

        <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->hiddenField($model, 'barang_id'); ?>
                    <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>		
                    <?php echo $form->textFieldRow($model, 'kode_wilayah', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_kode', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_judulbuku', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_spesifikasibuku', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_asalkesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_jumlah', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'invasetlain_thncetak', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_harga', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invasetlain_tglguna', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'invasetlain_tglguna',
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
                            <?php echo $form->error($model, 'invasetlain_tglguna'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tahun_cetak', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tahun_cetak',
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
                            <?php echo $form->error($model, 'tahun_cetak'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'pembelian', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'pembelian',
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
                            <?php echo $form->error($model, 'pembelian'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'invasetlain_akumsusut', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_penciptakesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_bahankesenian', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_jenishewan_tum', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_ukuranhewan_tum', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>

    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/invasetlainT/admin'), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php $this->widget('UserTips', array('type' => 'update')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Aset Tetap dan Lainnya', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invasetlainT/Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>

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
    $( document ).ready(function(){
        cekDisabled($('#guinvasetlain-t-form'));
        <?php if(isset($_GET['sukses'])){ ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>
