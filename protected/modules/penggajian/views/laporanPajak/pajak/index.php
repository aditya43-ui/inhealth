<?php
$this->breadcrumbs = array(
    'Laporan Pajak',
);
$url = Yii::app()->createUrl('kepegawaian/LaporanPajak/frameGrafikPajak&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pajak</b>
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
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . 'pajak/_searchPajak', array(
                        'model' => $model, 'format' => $format
                    )); ?>
                </div>
                <!--search-form-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pajak</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . 'pajak/_tablePajak', array('model' => $model)); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPajak');
        $this->renderPartial($this->path_view . 'pajak/_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view . 'pajak/_jsFunctions', array('model' => $model)); ?>