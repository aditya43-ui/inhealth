<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'adverse-event-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
                'enctype' => 'multipart/form-data',
            ),
            //'focus'=>'#',
        )); ?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Peminjaman Barang </b> </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <?php echo $this->renderPartial($this->path_view."_detailPeminjaman", array(
                            'form'=>$form,
                            'model'=>$model,
                        ), true); ?>
        </div>
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"> <b> Barang yang Dipinjam  </b></div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial($this->path_view."_detailBarang", array(
                            'form'=>$form,
                            'model'=>$model,
                        ), true); ?>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>    
</div>
<?php $this->endWidget();?>