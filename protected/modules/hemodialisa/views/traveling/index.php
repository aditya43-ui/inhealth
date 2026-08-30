<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 

$this->pageTitle = 'Traveling Hemodialisis';

$this->breadcrumbs = array(
    'Traveling Hemodialisis',
    
);
?>
<style type="text/css">
    .form-pasien .controls, .form-catatan .controls{
        margin-top: 5px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="icon-form-detailtagihan"></i> <?= $this->pageTitle ?>
            <?php if (!empty($_GET['pendaftaran_id'])) {?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), array('/hemodialisa/pemeriksaanAsesmenPerawat', 'pendaftaran_id' => $_GET['pendaftaran_id']), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
            
        </div>
    </div>
    <div class="panel-body">
        <?php 
            $this->widget('bootstrap.widgets.BootAlert');
            
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'traveling-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'focus' => '#',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)', 
                    'onsubmit' => 'return requiredCheck(this);'
                ),
            )); 
                     
            echo CHtml::hiddenField('jenis_dialog','');
            echo $this->renderPartial($this->path_view . 'form/_1_petugas', array('model' => $model, 'form'=>$form), true); 
            
            echo '<div class="form-pasien">';
                echo $this->renderPartial($this->path_view . 'form/_2_pasien', array('model' => $model, 'form'=>$form), true); 
            echo '</div>';
            
            echo '<div class="form-catatan">';
                echo $this->renderPartial($this->path_view . 'form/_3_catatan', array('model' => $model, 'form'=>$form), true);             
            echo '</div>';    
            
            $this->renderPartial($this->path_view . '_button', array('model'=>$model));         
            
            $this->endWidget();
            
            $this->renderPartial($this->path_view . '_jsFunctions', array('model'=>$model));         
            $this->renderPartial($this->path_view . '_dialog', array());  
        ?>        
    </div>
</div>