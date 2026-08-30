<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemanggilan-antrian',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',         
        ),               
    ));

$detail = isset($detail)?$detail:'';
?>
    <?= CHtml::hiddenField('jenis_dialog',''); ?>
    <?= CHtml::hiddenField('no_row',''); ?>

    <div class="panel  panel-success">
        <div class="panel-heading">
            <div class="panel-title"><strong>Data Pemanggilan Antrian</strong></div>
        </div>
        <div class="panel-body form-donor">                        
            <?php echo $this->renderPartial('form/_1_panggilAntrian',array('form'=>$form)); ?>            
        </div>
    </div>

    <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-pencarian-barcode',
            'content' => array(
                'content-barcode' => array(
                    'header' => '<b>Pencarian Daftar Antrian</b>',
                    'isi' => $this->renderPartial('_search', array(
                        'model' => $model,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
    ?>
   
    <div class="panel  panel-success">
        <div class="panel-heading">
            <div class="panel-title"><strong>Tabel Daftar Antrian</strong></div>
        </div>
        <div class="panel-body">                        
            <?php echo $this->renderPartial('grid/_listAntrian',array('model'=>$model,'form'=>$form)); ?>            
        </div>
    </div>
   
    
<?php $this->endWidget(); 

?>