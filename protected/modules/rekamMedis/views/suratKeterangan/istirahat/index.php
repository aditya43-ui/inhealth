<?php
$this->breadcrumbs=array(
	'Istirahat',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratketerangan-r-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<style>
.groupUkurans{
    display:inline;
     table > tbody > tr > td > input{
        margin-top:5px;
    }
}
</style>
    <?php
        $this->renderPartial($this->path_view.'istirahat/suratIstirahatV2',array('model'=>$model,'modPasien'=>$modPasien,
                    'modPendaftaran'=>$modPendaftaran));
    ?>
    <div class="form-actions">
        <?php
            if(!empty($_GET['suratketerangan_id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
                
                echo "&nbsp;".CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
                echo "&nbsp;".CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }
        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
if(!empty($_GET['suratketerangan_id'])){
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintIstirahat&pendaftaran_id='.$_GET['pendaftaran_id'].'&suratketerangan_id='.$_GET['suratketerangan_id'].'&lama_hari='.$_GET['lama_hari']);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
}
?>