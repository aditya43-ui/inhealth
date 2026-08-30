<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    
<div class="panel panel-gradient">        
    <div class="panel-body">
        <?php 
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'rujukan-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event);',
                    'onsubmit' => 'return requiredCheck(this)'
                ),
                'focus' => '#',
            )); 
             
            $this->widget('bootstrap.widgets.BootAlert'); 
            
            echo $this->renderPartial('template',['model'=>$model, 'form'=>$form], true);

            echo $this->renderPartial('_button',['model'=>$model], true);
            
            $this->endWidget(); 
        ?>
    </div>    
</div>

<script stype="text/javascript">
    const printCetak = () => {
        window.open('<?php echo $this->createUrl('printSurat', array('id' => $model->serahterimajaringan_id)); ?>', 'serahterimajaringan', 'left=100,top=100,width=860,height=480');
    }
</script>