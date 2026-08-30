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
        $this->renderPartial($this->path_view.'penyakitRD/penyakitRD',array('model'=>$model,'modPasien'=>$modPasien,
                    'modPendaftaran'=>$modPendaftaran,'modAdmisi'=>$modAdmisi));
    ?>
    <div class="form-actions">
        <?php
            if(!empty($_GET['suratketerangan_id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
                
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }
        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
if(!empty($_GET['suratketerangan_id'])){
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintPenyakitRD&pendaftaran_id='.$_GET['pendaftaran_id'].'&suratketerangan_id='.$_GET['suratketerangan_id'].'');

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
        var keluhan_utama = $('#keluhan_utama').val();
        
        if(tekanan_darah == '' || tempratur == '' || pols == '' || rr == '' || keluhan_utama == ''){
            myAlert('Isi Terlebih dahulu data yang masih kosong');
            return false;
        }else{
            $('#suratketerangan-r-form').submit();
            return true
        }
    }    
</script>