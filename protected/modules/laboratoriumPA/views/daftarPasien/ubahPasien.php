<style>
    fieldset legend.accord1{
        width:100%;
    }
    table{
        width: 100%;
    }
 </style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class="white-container">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'update-pasien-form',
            'type'=>'horizontal',
            'focus'=>'#LKPasienM_jenisidentitas',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cekForm();',),
    ));
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->renderPartial($this->path_view.'_formPasienUpdate', array('form'=>$form,'modPasien'=>$model)); ?>

    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'button', 
                                                        'onKeypress'=>'return formSubmit(this,event)',
                                                        'id'=>'btn_simpan', 'onclick'=>'$(\'#update-pasien-form\').submit();  ',
                                                       )); 
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id,array('modul_id'=>Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
    <?php $this->endWidget(); ?>
</div>
<script>     
function cekForm(){
    var kosong = "";
    var reqPasien       = $("#fieldsetPasien").find(".reqPasien[value="+kosong+"]");
    var reqPasienKosong = reqPasien.length; 
    if(reqPasienKosong > 0){
        myAlert('Silahkan isi data yang bertanda * !');
        return false;
    }else{
        return true;
    }
}
</script>