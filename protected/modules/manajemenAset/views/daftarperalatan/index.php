<?php
$this->breadcrumbs = array(
    'Daftar Peralatan' => array('informasi'),
    'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
$('#guinvperalatan-t-search').submit(function(){
    $.fn.yiiGridView.update('guinvperalatan-t-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Daftar Peralatan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_searchInfo', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Peralatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_tableInfo', array('model' => $model)) ?>
            </div>
        </div>
    </div>
</div>
