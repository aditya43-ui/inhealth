<?php
$this->breadcrumbs = array(
    'Monitoring Rawat Darurat',
);

//$this->menu=array(
//	array('label'=>'List MonitoringRawatdaruratV', 'url'=>array('index')),
//	array('label'=>'Create MonitoringRawatdaruratV', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
});
$('#monitoring-search-form').submit(function(){
        $.fn.yiiGridView.update('monitoring-v-grid', {
                data: $(this).serialize()
        });
        return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-monitor"></i> Monitoring <b>Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Monitoring Rawat Darurat</b> <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i>', 'javascript:;', array('class' => 'btn btn-default', 'style' => 'color:white;', 'onclick' => 'refreshTable();', "data-toggle" => "tooltip", "data-placement" => "top", "title" => "", "data-original-title" => "Klik tombol ini, untuk melakukan refresh data", "data-html" => true)); ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial('_tableRawatdarurat', array('model' => $model)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_searchRawatdarurat', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function() {
            $.fn.yiiGridView.update('monitoring-v-grid', { // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
                data: $(this).serialize()
            });
            return false;
        },
        <?php echo (Yii::app()->user->getState('monitoringrefresh')) . '000'; ?> // fungsi di eksekusi setiap waktu yang ditentukan di database
    );

    function refreshTable() {
        $.fn.yiiGridView.update('monitoring-v-grid', {
            data: $("#monitoring-search-form").serialize()
        });
    }
</script>