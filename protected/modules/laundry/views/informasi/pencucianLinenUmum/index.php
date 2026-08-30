<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('informasi-grid', {
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
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pencucian Linen Umum</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data <strong>Pencucian Linen Umum</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial($this->path_view.'_tabel',['model'=>$model],true) ?>                       
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                    'model'=>$model,
                            )); ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>  

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pencucian Linen Umum',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();