
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Detail Mutasi Aset
        </div>
    </div>
    <div class="panel-body">
        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'mutasiaset-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        )); ?>
        <?php echo $this->renderPartial('_formMutasi', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
        <?php echo $this->renderPartial('_formPeralatan', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
               
        
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#mutasiaset-t-form").find('input,select,textarea').attr("disabled",true);
        $("#mutasiaset-t-form").find('a,button,.add-on,.button-aksi').hide();        
    });
</script>