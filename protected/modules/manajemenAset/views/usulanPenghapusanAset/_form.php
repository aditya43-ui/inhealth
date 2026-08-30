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
            <div class="panel-title"><strong><i class="glyphicon glyphicon-file"></i> Data Usulan Penghapusan Aset</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'form/_1_data_usulan',array('model'=>$model, 'form'=>$form)); ?>
        </div>
    </div>
   
    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="glyphicon glyphicon-file"></i> Data Aset</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'form/_2_daftar_aset',array(
                'model'=>$model, 
                'form'=>$form,
                'modDet'=>$modDet,                   
                'detail'=>!empty($detail)?$detail:null
            )); ?>
        </div>
    </div>
   
    <div class="form-actions">
        <?= $this->renderPartial($this->path_view.'_button',['model'=>$model]); ?>
    </div>
    
<?php $this->endWidget(); 

?>