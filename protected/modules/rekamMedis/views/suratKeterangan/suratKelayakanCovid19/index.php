<?php
$this->breadcrumbs=array(
	'Istirahat',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratketerangan-r-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'cekValidasi();return false;'),
        'focus'=>'#',
)); ?>
<style>
    .groupUkurans{
        display:inline;
    }
    table > tbody > tr > td > input{
        margin-top:5px;
    }
    .strike{
        text-decoration: line-through;
    }
</style>
    <?php
        $this->renderPartial($this->path_view.'suratKelayakanCovid19/template',array(
            'model'=>$model,'modPasien'=>$modPasien,
            'modPendaftaran'=>$modPendaftaran));
    ?>
    <div class="form-actions" <?=$hidden?>>
        <?php
            if(!empty($_GET['suratketerangan_id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
                
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }
        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
if(!empty($_GET['suratketerangan_id'])){
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printSuratKelayakanCovid19&pendaftaran_id='.$_GET['pendaftaran_id'].'&suratketerangan_id='.$_GET['suratketerangan_id'].'');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
}
?>
<script>
    const cekLayak = (jenis, obj) => {
        const active = $(obj).hasClass("active");
        $(".st-layak").removeClass("active");
        $(".st-layak").removeClass("strike");
        $("#cb-layak").prop("checked", false);
        
        if (jenis == 'layak' && !active){
            $(obj).addClass('active');
            $(obj).addClass('strike');
            $("#cb-layak").prop("checked", true);
        }else if (jenis == 'tidak-layak' && !active){
            $(obj).addClass('strike');
            $(obj).addClass('active');
        }
    }
    
    $(document).ready(function(){        
        <?php if ($model->islayak === true){ ?>
                cekLayak('tidak-layak', $("#tidaklayak"));                
        <?php }else{ ?>
                cekLayak('layak', $("#layak"));
        <?php } ?>

        <?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
        <?php endif;?>
    })
</script>