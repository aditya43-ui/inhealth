<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'penerimaansisa-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',        
	'htmlOptions' => array(            
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return requiredCheck(this);'
        ),
	'focus' => '#nokantongutama',
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
        <div class="panel-title">Transaksi <b>Penerimaan Sisa Kantong Darah</b></div>        
    </div>
    <div class="panel-body">                        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Penerimaan Kantong Darah</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'form/_formPenerimaan',array('form'=>$form)) ?>                
                
                <?php echo $this->renderPartial($this->path_view.'tabel/_tabelPenerimaan',array('form'=>$form)) ?>                
            </div>
        </div>        
        
      
        <div class="clear"></div>
        
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array(),true); ?>                      

        <?php echo $this->renderPartial($this->path_view.'_button',array(),true); ?>
                                      
    </div>
</div>
    
<?php $this->endWidget(); ?>
