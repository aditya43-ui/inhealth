<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('sajenis-kelas-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php 
    $module  = $this->module->name; 
    $controller = $this->id;
    $format = new MyFormatter();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <strong>Usulan Penghapusan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Usulan Penghapusan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial($this->path_view.'informasi/grid/_tabel',['model'=>$model],true) ?>                        
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'informasi/_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>  
<?= $this->renderPartial($this->path_view.'informasi/_dialog',['model'=>$model],true) ?>
