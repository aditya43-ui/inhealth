<?php
$this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'readOnlyNoRm' => true));
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'suratketerangan-r-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php //echo $form->errorSummary($model); 
?>

<div class="col-sm-6">
    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($model, 'profilrs_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'judulsurat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
    <?php echo $form->dropDownListRow($model, 'jenissurat_id',  CHtml::listData($model->getJenisSurat(), 'jenissurat_id', 'jenissurat_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'tglsurat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($model, 'penyebabkematian', array('placeholder' => 'Penyebab Kematian', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'nourutsurat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'nomorsurat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->dropDownListRow($model, 'mengetahui_surat',  CHtml::listData($model->getMengetahuiItems(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), 'nama_pegawai', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 pilihanSearch', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
</div>

<div class="clear"></div>
<div class="form-actions">
    <?php // echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Simpan & Print',array('{icon}'=>'<i class="entypo-print"></i>')) : 
    //                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
    //                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
    ?>
    <?php
    if (!empty($model->suratketerangan_id)) {
        echo CHtml::htmlButton(Yii::t(
            'mds',
            '{icon} Create',
            array('{icon}' => '<i class="entypo-check"></i>')
        ), array(
            'title' => 'Simpan',
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => true
        ));

        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-danger', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    } else {
        echo CHtml::htmlButton(Yii::t(
            'mds',
            '{icon} Create',
            array('{icon}' => '<i class="entypo-check"></i>')
        ), array(
            'title' => 'Simpan',
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'
        ));
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
        );
    }
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function printSuratKematian() {
        window.open('<?php echo $this->createUrl('suratKeterangan/PrintSuratKematian') ?>', 'printsuratkematian', 'left=100,top=100,width=700,height=450,scrollbars=1');
    }

    $(function(){
        jQuery('.pilihanSearch').multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>
<?php
if (!empty($model->suratketerangan_id)) {
    $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintSuratMeninggal&pendaftaran_id=' . $model->pendaftaran_id . '&suratketerangan_id=' . $model->suratketerangan_id . '');

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}

JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>