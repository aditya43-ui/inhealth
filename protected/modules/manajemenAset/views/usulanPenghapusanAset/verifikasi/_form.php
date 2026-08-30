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
    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i>  <strong>Usulan Penghapusan</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'verifikasi/form/_1_data_usulan',array('model'=>$model, 'form'=>$form)); ?>
        </div>
    </div>
   
    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i>  <strong>Data Aset</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'verifikasi/form/_2_daftar_aset',array(
                'model'=>$model, 
                'form'=>$form,
                'modDet'=>$modDet,                   
            )); ?>
        </div>
    </div>

    <div class="panel  panel-success form-dis">
        <div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i>  <strong>Data Verifikasi</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial($this->path_view.'verifikasi/form/_3_data_verifikasi',array(
                'model'=>$model, 
                'form'=>$form,                
            )); ?>
        </div>
    </div>
   
    <div class="form-actions">
        <?= $this->renderPartial($this->path_view.'_button',['model'=>$model]); ?>
    </div>
    
<?php $this->endWidget(); 

?>