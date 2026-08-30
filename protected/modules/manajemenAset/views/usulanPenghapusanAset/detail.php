
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> <strong>Usulan Penghapusan</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Usulan Penghapusan'                
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php 
            if (empty($model->tanggal_verifikasi)){
                echo $this->renderPartial('_form',array(
                    'model'=>$model,
                    'modDet'=>$modDet,   
                    'detail' => 1
                )); 
            }else{
                echo $this->renderPartial('verifikasi/_form',array(
                    'model'=>$model,
                    'modDet'=>$modDet,                        
                )); 
            }
        
        ?>
    </div>
</div>


<?php

$js = <<< JS
    setTimeout(function(){        
        $(".form-dis").find("input,textarea,select").attr("disabled",true);
        $(".form-dis").find("a,button,.add-on").hide();
        
        $(".btn-ulang,.btn-simpan,#instruction_button").hide();                     
                
        $("span.required").remove();
        
    },500); 
        
    
JS;

Yii::app()->clientScript->registerScript('penerimaan-medium-alat',$js, CClientScript::POS_END);
?>