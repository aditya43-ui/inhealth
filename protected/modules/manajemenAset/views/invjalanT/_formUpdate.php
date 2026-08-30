
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvjalan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
));
?>

<p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'"04"')); ?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Data Inventarisasi Gedung dan Bangunan</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->hiddenField($model, 'barang_id'); ?>
                    <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model, 'kode_wilayah', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_kode', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_kontruksi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'kondisifisikbangunan', array('class' => 'control-label')); ?>
                        <div class="controls radio-inline">
                            <?php
                            echo $form->radioButtonList($model, 'kondisifisikbangunan', array('Baik' => 'Baik', 'Kurang Baik' => 'Kurang Baik', 'Rusak Berat' => 'Rusak Berat'), array(
                                'template' => '{input}{label}</br>',
                                'seperator' => '',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'invjalan_panjang', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_lebar', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_luas', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_letak', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invjalan_tgldokumen', array('class' => 'control-label')) ?>
                            <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'invjalan_tgldokumen',
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
                                <?php echo $form->error($model, 'invjalan_tgldokumen'); ?>
                            </div>
                        </div>
                        <div class="control-group ">
<?php echo $form->labelEx($model, 'invjalan_tglguna', array('class' => 'control-label')) ?>
                            <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'invjalan_tglguna',
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
                                <?php echo $form->error($model, 'invjalan_tglguna'); ?>
                            </div>
                        </div>
                    <?php echo $form->textFieldRow($model, 'invjalan_nodokumen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                        <?php echo $form->textFieldRow($model, 'invjalan_statustanah', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'invjalan_keadaaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'invjalan_harga', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'invjalan_akumsusut', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'invjalan_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
                <?php echo $form->textFieldRow($model, 'invjalan_nodokumen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_statustanah', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_keadaaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_harga', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_akumsusut', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
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
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/invjalanT/admin'), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>                
    <?php
    $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Jalan Irigasi dan Jaringan ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invjalanT/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
</div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        cekDisabled($('#guinvjalan-t-form'));
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>