<?php 

$this->breadcrumbs=array(
    'informasi-spk-form'=>array('informasi'),
    'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
$('#informasi-spk-search').submit(function(){
    $.fn.yiiGridView.update('informasi-spk-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Kontrak</b></div>
    </div>
    <div class="panel-body">                       
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Kontrak</b></div>
            </div>
            <div class="panel-body">
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