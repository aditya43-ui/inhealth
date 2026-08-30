<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $this->renderPartial('/_ringkasDataPasiendanPemeriksaanKehamilan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,'modPeriksaKehamilan'=>$modPeriksaKehamilan)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pskeg-bayi-tabung-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($modKegiatanBayiTabung); ?>
<?php $this->renderPartial('_formRiwayatBayiTabung',array('modRiwayatBayiTabung'=>$modRiwayatBayiTabung)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php $this->renderPartial('_formKegiatanBayiTabung',array('modKegiatanBayiTabung'=>$modKegiatanBayiTabung,'form'=>$form)); ?>
<div class="form-actions">
                <?php echo CHtml::htmlButton($modPeriksaKehamilan->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'validasi()')); ?>
                  <div style="display: none">     
                         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
                  </div> 
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/DaftarPasien/index'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
// ===========================Dialog Foto=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogFoto',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Foto USG',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>true,
                         ),
                    ));
echo "<div align=\"center\">
        <img src=\"".Params::urlUSGDirectory().$modPeriksaKehamilan->filefotousg."\">
      </div>";
  
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Foto================================

$jscript = <<< JS

function slideDataKehamilan()
{
    $('#divDataKehamilan').slideToggle(500);
}

function lihatFoto()
{
    $('#divFoto').slideToggle(500);
    $('#divTombolLihat').slideToggle(500);
    $('#divTombolTutup').slideToggle(500);
}
   
function numberOnly(obj,nilaiKosong)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;

    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
    $(obj).val(orignalValue);
    }else{
    $(obj).val(nilaiKosong);
    }
    
}

function validasi()
{
    kosong = 'Tidak';
    $('.isRequired').each(function() {
           if($(this).val()==''){
             kosong='Ya';
             $(this).focus();
           }
        });
    
    if(kosong=='Tidak'){
        $('#btn_simpan').click();
    }else{
        myAlert('Harap isi semua field yang bertanda *');
    }    
}

    function readURL(input) 
    {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
    $('#img_prev')
    .attr('src', e.target.result)
    };

    reader.readAsDataURL(input.files[0]);
    }
}

JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>