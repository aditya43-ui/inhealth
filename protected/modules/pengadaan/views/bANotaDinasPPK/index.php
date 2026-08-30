<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'notadinasppk-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',        
	'htmlOptions' => array(
            //'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return requiredCheck(this);'
        ),
	'focus' => '#'.CHtml::activeId($model, 'nomor_notadinas').'',
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
<div class="panel-group joined" id="accordion-uji">
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-uji" href="#riwayat" aria-expanded="true" class="">
                    <b> Riwayat Nota Dinas PPK </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff; overflow: auto; max-height: 300px;">
                <?php echo $this->renderPartial('_riwayatBA', array('model' => $model, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Nota Dinas PPK </b> </div>        
    </div>
    <div class="panel-body">                        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        <?php echo $this->renderPartial($this->path_view.'form/_formNotaDinasPPK',array('model'=>$model, 'form'=>$form)) ?>
        <div class="clear"></div>
        
        <?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model),true); ?>       

        <?php echo $this->renderPartial($this->path_view.'_button',array('model'=>$model),true); ?>
                                      
    </div>
</div>
    
<?php $this->endWidget(); ?>


<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog1',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cetak Nota Dinas PPK',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog2',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Nota Dinas PPK',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 400,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
