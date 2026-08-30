<?php ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvperalatan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            Data Barang																	
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::label("Nomor Perolehan <span class='required'>*</span>",'nopenerimaan');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modelDetail, 'nopenerimaan', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::label("Nama Aset <span class='required'>*</span>",'barang_nama');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modBarang, 'barang_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php // $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'"02"')); ?>  

<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Inventarisasi Peralatan dan Mesin</div>
    </div>
    <div class="panel-body">

        <div class="row-fluid">
            <div class="span6">
                <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->hiddenField($model, 'barang_id'); ?>
                <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_kode', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_namabrg', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_merk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_ukuran', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invperalatan_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'invperalatan_thnpembelian', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invperalatan_tglguna', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invperalatan_tglguna',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                <?php echo $form->error($model, 'invperalatan_tglguna'); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'invperalatan_nopabrik', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_norangka', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_nomesin', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                
            </div>
            <div class="span6">
                <?php echo $form->textFieldRow($model, 'invperalatan_nopolisi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_nobpkb', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_harga', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_akumsusut', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'invperalatan_ket', array('rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invperalatan_kapasitasrata', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                <div class="control-group">
                    <?php echo CHtml::label("",'invperalatan_ijinoperasional', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'invperalatan_ijinoperasional',array('checked'=>'invperalatan_ijinoperasional')); ?>
                        <?php echo $form->labelEx($model,'invperalatan_ijinoperasional');?>
                    </div>				
                </div>
                    <?php echo $form->textFieldRow($model, 'invperalatan_serftkkalibrasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->textFieldRow($model, 'invperalatan_umurekonomis', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Keadaan <span class="required">*</span>', 'invperalatan_keadaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model, 'invperalatan_keadaan', LookupM::getItems('inventariskeadaan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
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
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                        echo $form->dropDownList($model, 'tipepenghapusan', CHtml::listData(MALookupM::getItemsTipeHapus(), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
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
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/invperalatanT/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
<?php $content = $this->renderPartial('tips/transaksi', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Peralatan dan Mesin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invperalatanT/Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
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
    function setKodeRegister(barang_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetkodeRegister'); ?>',
            data: {barang_id: barang_id},
            dataType: "json",
            success: function (data) {
                $('#MAInvperalatanT_invperalatan_noregister').val(data.value);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
    $( document ).ready(function(){
        cekDisabled($('#guinvperalatan-t-form'));
        <?php if(isset($_GET['sukses'])){ ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>