<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Analisa Darah Kembali
        </div>
    </div>
    <div class="panel-body">
        <?php 
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'analisa-darah-kembali-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
                // 'enctype' => 'multipart/form-data',
            ),
            //'focus'=>'#',
        )); 
        
        ?>
            <?php echo $this->renderPartial($this->path_view."_formKantongDetail", array(
                'model'=>$model,
                'form'=>$form,
            ), true); ?>
            <?php echo $this->renderPartial($this->path_view."_formAnalisa", array(
                'model'=>$model,
                'form'=>$form,
            ), true); ?>
        
        <?php $this->endWidget(); ?>
    </div>
</div>