<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasi-pengajuankasbon-r-search').submit(function(){
        $.fn.yiiGridView.update('informasi-pengajuankasbon-grid', {
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
                <div class="panel-title">Informasi <strong> Pengajuan Kasbon </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Pengajuan Kasbon </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial($this->path_view.'informasi/_tabel',['model'=>$model],true) ?>                        
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
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

<?php
$urlPrint = $this->createUrl('printInfo');
$js = <<< JSCRIPT
                        
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#informasi-pengajuankasbon-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);