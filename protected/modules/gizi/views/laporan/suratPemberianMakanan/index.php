<?php
$this->breadcrumbs = array(
    'Laporan Surat Pemberian Makanan',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
$url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanMakananHarian&id=1');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Surat Pemberian Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('suratPemberianMakanan/_search', ['model' => $model]) ?>
            </div>
        </div>

        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-layout"></i> Table
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('suratPemberianMakanan/_table', ['model' => $model]) ?>
            </div>
        </div>

        <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printSuratPemberianMakanan');
            $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'grafik' => 'none', 'tips' => ''));
        ?>
    </div>
</div>