<?php 

$this->breadcrumbs=array(
    'Informasi Monitoring Suhu Coolbox'=>array('informasi'),
    'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
$('#monitoringsuhu-v-search').submit(function(){
    $.fn.yiiGridView.update('monitoringsuhu-v-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Monitoring Suhu Coolbox</b></div>
    </div>
    <div class="panel-body">                       
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Daftar Monitoring Suhu Coolbox</b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('table', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="<?php echo MyIcon::getIcons('cari'); ?>"></i>Pencarian </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('search', array('model'=>$model)) ?>
            </div>
        </div>
    </div>
</div>

