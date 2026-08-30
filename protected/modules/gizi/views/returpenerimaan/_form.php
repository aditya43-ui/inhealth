<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gureturpenerimaanbahan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <?php if (isset($modTerima)) {
        $this->renderPartial('_dataTerima', array('modTerima' => $modTerima, 'id' => $id));
    } ?>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'terimabahanmakan_id', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'noreturbahanmakan', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglreturbahanmakan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglreturbahanmakan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tglreturbahanmakan'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alasanreturbahanmakan', array('placeholder' => 'Alasan Retur', 'class' => 'span4 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textFieldRow($model, 'totalretur', array('style' => 'text-align: right; ', 'readonly' => true, 'class' => 'span4 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")) : $form->passwordFieldRow($model, 'totalretur', array('style' => 'text-align: right; ', 'readonly' => true, 'class' => 'span4 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'peg_retur_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'peg_retur_id'); ?>
                <?php echo $form->textField($model, 'peg_retur_nama', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red;'>*</span>", 'peg_mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                <?php echo $form->textField($model, 'peg_mengetahui_nama', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'keterangan_returbahanmakan', array('placeholder' => 'Keterangan Retur', 'rows' => 7, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php if (isset($modDetails)) {
            echo $form->errorSummary($modDetails);
        } ?>
        <div class="block-tabel">
            <?php $this->renderPartial('_tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails)); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton((isset($_GET['sukses'])) ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('ReturpenerimaanT/index&id='.$modTerima->terimapersediaan_id), array('class'=>'btn btn-danger')); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        "javascript:void(0);",
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_returPenerimaan', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<?php
$notif = Yii::t('mds', 'Do You want to cancel?');
$js = <<< JS
    
    function batal(obj){
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!confirm("${notif}")) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                renameInputRowBahanMakanan("tableDetailBarang");
            hitungRetur();
            }
        });
    }
    
    function renameInputRowBahanMakanan(obj_table){
        var row = 0;
        $('#'+obj_table).find("tbody > tr").each(function(){
        $(this).find(".noUrut").html(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
        });
        row++;
        });

    }
JS;
Yii::app()->clientScript->registerScript('onhead', $js,  CClientScript::POS_HEAD);
?>

<?php
Yii::app()->clientScript->registerScript('onready', '
    $("form").submit(function(){
        retur = false;
        idRetur = $("#' . CHtml::activeId($model, 'peg_retur_id') . '").val();
        alasan = $("#' . CHtml::activeId($model, 'alasanreturbahanmakan') . '").val();

        $(".retur").each(function(){
            if ($(this).val() > 0){
                retur = true
            }
        });
        
        if (alasan == ""){
            myAlert("' . CHtml::encode($model->getAttributeLabel('alasanreturbahanmakan')) . ' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(idRetur)){
            myAlert("' . CHtml::encode($model->getAttributeLabel('peg_retur_id')) . ' harus diisi");
            return false;
        }
        
        if ($(".cancel").length < 0){
            myAlert("Detail Bahan Makanan Harus Diisi");
            return false;
        }
        else if (retur == false){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jmlretur')) . ' harus memiliki value yang lebih dari 0");
            return false;
        }
    });
', CClientScript::POS_READY); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<script>
    function hitungRetur() {
        var total = 0;
        $('#tableDetailBarang tbody tr').each(function() {
            var satuan = parseFloat(unformatNumber($(this).find(".harganetto").val()));
            var retur = parseFloat($(this).find(".retur").val());
            var persendiskon = parseFloat($(this).find(".persendiscount").val());
            var persenppn = parseFloat($(this).find(".persenppn").val());
            var persenpph = parseFloat($(this).find(".persenpph").val());

            var jmlSatuan = (satuan * retur);
            var jmldiskon = ((jmlSatuan * persendiskon) / 100);
            var jmlppn = (((jmlSatuan - jmldiskon) * persenppn) / 100);
            var jmlpph = (((jmlSatuan - jmldiskon) * persenpph) / 100);

            var subtotal = (jmlSatuan - jmldiskon + jmlppn + jmlpph);
            total += subtotal;

            $(this).find(".jmldiscount").val(formatNumber(jmldiskon));
            $(this).find(".jmlppn").val(formatNumber(jmlppn));
            $(this).find(".jmlpph").val(formatNumber(jmlpph));
            $(this).find(".hargasatuan").val(formatNumber(subtotal));
            $(this).find(".subtotal").val(formatNumber(subtotal));
        });

        $("#<?php echo CHtml::activeId($model, 'totalretur'); ?>").val(formatNumber(total));
        $("#totalretur").val(formatNumber(total));
    }

    $(document).ready(function() {
        hitungRetur();
    });
</script>