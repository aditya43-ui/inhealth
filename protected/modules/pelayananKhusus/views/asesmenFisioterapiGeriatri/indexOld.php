<?php

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'asesmen-pediatri-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',        
	'htmlOptions' => array(            
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return requiredCheck(this);'
        ),
	'focus' => '#'.CHtml::activeId($model, 'nodok_pergeseran').'',
    ));
?>
<style>
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
    
    .close{
        color:#333 !important;
        font-size: 30px !important;
    }  
</style>
<p>&nbsp;</p>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <b>Asesmen Fisioerapi - Geriatri</b></div>        
    </div>
    <div class="panel-body">                        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>        
        
        <?php echo $this->renderPartial($this->path_view.'tabel/_tabelPenilaian',array('model'=>$model, 'form'=>$form, 'loadMaster' => $loadMaster)) ?>                
        <div class="clear"></div>
        <?php echo $this->renderPartial($this->path_view.'form/_formGeriatri',array('model'=>$model, 'form'=>$form)) ?>                
        
        
        <div class="clear"></div>
        
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model),true); ?>                       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
                                      
    </div>
</div>
    
<?php $this->endWidget(); ?>
