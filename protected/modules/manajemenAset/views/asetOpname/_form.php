<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penerimaan-alat-t',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
//    'focus' => '#' . CHtml::activeId($model, 'lemaribankjaringan_nama'),
        ));

$detail = isset($detail)?$detail:'';
?>
    <?= CHtml::hiddenField('jenis_dialog',''); ?>
    <?= CHtml::hiddenField('no_row',''); ?>
    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i> <strong>Data Aset Opname</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'form/_1_data_aset_opname',array('model'=>$model, 'form'=>$form)); ?>
        </div>
    </div>
   
    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i> <strong>Detail Aset</strong></div>
        </div>
        <div class="panel-body form-detail-aset">                        
           
        </div>
    </div>
   
    <div class="form-actions">
        <?= $this->renderPartial($this->path_view.'_button',['model'=>$model]); ?>
    </div>
    
<?php $this->endWidget(); 

?>