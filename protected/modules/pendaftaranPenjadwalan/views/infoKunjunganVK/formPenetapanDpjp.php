<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
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
            
            echo $this->renderPartial('templateDpjp',['model'=>$model, 'form'=>$form], true);
            echo $this->renderPartial('templateKebutuhanPrivasi',['model'=>$model, 'form'=>$form], true);
            echo $this->renderPartial('templatePermintaanKerohanian',['model'=>$model, 'form'=>$form], true);

            echo $this->renderPartial('_button',['model'=>$model], true);
            
            $this->endWidget(); 
        ?>
    </div>    
</div>

<script stype="text/javascript">
    const printCetak = () => {
        window.open('<?php echo $this->createUrl('printSurat', array('id' => $model->suratperintahdpjp_id)); ?>', 'formulirpenetapandpjp', 'left=100,top=100,width=860,height=480');
    }
    
    $(document).ready(function(){
        CKEDITOR.replace('kebutuhanprivasi', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [
                {
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ]
        });
        
        CKEDITOR.replace('kebutuhanrohani', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [
                {
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ]
        });
    })
</script>