<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'masterkronis-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
));

?>


<div class="control-group">
    <?php echo CHtml::label('Jumlah Obat','jumlahobat', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlahobat',array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($model,'formulaobatkronis_id',array('class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Jumlah Obat Max (INA-CBGs)','jumlahobat_maksimal', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlahobat_maksimal',array('class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Jumlah Obat Min (free for service)','jumlahobat_minimal', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlahobat_minimal',array('class' => 'span3')); ?>
    </div>
</div>
<br/>
<div class="form-action">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Simpan', 'id' => 'btn_simpan', 'onclick'=>'cekForm();')
    );

    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('kronis'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
</div>


<?php $this->endWidget(); ?>

<script>
function cekForm() {
    $(".integer2, .float2, .integer-decimal").each(function() {
        $(this).val(unformatNumber($(this).val()));
    });

    disableOnSubmit($("#btn_simpan"));
    $("#masterkronis-t-form").submit();
    return false;
}

function closeDialog(){
	window.parent.$('#dialogMasterObatKronis').dialog('close');
}

function listKronis(){   
    var formulaobatkronis_id = $('#FormulaobatkronisM_formulaobatkronis_id').val();
    var jumlah = $('#FormulaobatkronisM_jumlahobat').val();

    $.post("<?php echo $this->createUrl('setListKronis')?>", {
        jumlah: jumlah,
        formulaobatkronis_id: formulaobatkronis_id
    },
    function(data){
        window.parent.$('#formulaobatkronis_id').html(data.listKronis);
        window.parent.$('#formulaobatkronis_id').attr('disabled', false);
        window.parent.$('#formulaobatkronis_id').attr('readonly', false);
        window.parent.$('#qtyNonRacik').val(jumlah);
        window.parent.$('#is_obatkronis').prop('checked', true);
    }, "json");
}

$(document).ready(function(){
    <?php if (isset($_GET['sukses'])) { ?>
        listKronis();
        closeDialog();
    <?php } ?>
});
</script>