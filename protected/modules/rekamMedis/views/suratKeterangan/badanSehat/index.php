<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<?php
$this->breadcrumbs=array(
	'Istirahat',
);
$this->widget('bootstrap.widgets.BootAlert');
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
</style>
    <?php
        $this->renderPartial($this->path_view.'badanSehat/suratBadanSehatV2',array('model'=>$model,'modPasien'=>$modPasien,
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
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintSuratBadanSehat&pendaftaran_id='.$_GET['pendaftaran_id'].'&suratketerangan_id='.$_GET['suratketerangan_id'].'');

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
    function cekValidasi(){
        var tekanan_darah = $('#tekanan_darah').val();
        var tempratur = $('#tempratur').val();
        var pols = $('#pols').val();
        var rr = $('#rr').val();
        var tinggi_badan = $('#tinggi_badan').val();
        var berat_badan = $('#berat_badan').val();
        var buta_warna = $('#buta_warna').val();
        var pemeriksaan_lain = $('#pemeriksaan_lain').val();
        
        if(tekanan_darah == '' || tempratur == '' || pols == '' || rr == '' || tinggi_badan == '' || berat_badan == '' || buta_warna == '' || pemeriksaan_lain == ''){
            myAlert('Isi Terlebih dahulu data yang masih kosong');
            return false;
        }else{
            $('#suratketerangan-r-form').submit();
            return true
        }
    }    

    function setPenandaTangan() {
        var opt = $("#RKSuratketeranganR_mengetahui_surat :selected");

        $("#nama_pegawai").val($(opt).data('nama'));
        $("#sip").val($(opt).data('sip'));
        $("#jabatan").val($(opt).data('jabatan'));
        $("#instansi").val($(opt).data('instansi'));
    }

$(document).ready(function() {
           var mengetahui_surat = jQuery('#<?php echo CHtml::activeId($model, 'mengetahui_surat') ?>');	
           jQuery(mengetahui_surat).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();

           <?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
           <?php endif;?>
       });


    function searchMengetahui() {
            $('#rjpasien-laboratorium-t-form input[name*="mengetahui_surat"]').each(function() {
            });
    }
</script>