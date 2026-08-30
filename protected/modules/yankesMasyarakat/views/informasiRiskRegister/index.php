<?php 

$this->breadcrumbs=array(
    'riskregister-m-form'=>array('informasi'),
    'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
$('#riskregister-m-search').submit(function(){
    $.fn.yiiGridView.update('riskregister-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Risk Register</b></div>
    </div>
    <div class="panel-body">                       
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Risk Register</b></div>
            </div>
            <div class="panel-body">
                <?php  $this->widget('bootstrap.widgets.BootAlert');  ?>
                <?php echo $this->renderPartial($this->path_view.'_table', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="<?php echo MyIcon::getIcons('cari'); ?>"></i>Pencarian </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_search', array('model'=>$model)) ?>
            </div>
        </div>
    </div>
</div>