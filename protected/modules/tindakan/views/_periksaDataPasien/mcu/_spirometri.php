
        <?php 
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'tes-spirometri-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )); 
        
        $this->widget('bootstrap.widgets.BootAlert');
        
        
        echo $this->renderPartial('rawatJalan.views._periksaDataPasien.mcu._formSpirometri', array(
            'form'=>$form,
            'model'=>$model,
        ), true);
        
        echo $this->renderPartial('rawatJalan.views._periksaDataPasien.mcu._formKesimpulanSpirometri', array(
            'form'=>$form,
            'model'=>$model,
        ), true);
        ?>
        
        <?php $this->endWidget();
        ?>
<script>

$(document).ready(function() {
    $("input, select").prop("disabled", true);
});

</script>