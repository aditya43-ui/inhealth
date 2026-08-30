<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = false;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

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
        window.open('<?php echo $this->createUrl('printSurat', array('id' => $model->suratketerangankematian_id)); ?>', 'suratketerangankematian', 'left=100,top=100,width=860,height=480');
    }

    <?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
                $('.redactor_frame').each(function() {
                    $(this).contents().find('html > body > #page').attr("contenteditable", false);
                });

                $('.form-actions').find('button').not('.btn-cetak').addClass('hide');

        <?php endif;?>
</script>