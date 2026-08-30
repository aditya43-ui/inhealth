<?php
$this->breadcrumbs = array(
    'Laporan Penyadapan Darah'
);

$url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPenyadapanDarah&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	$('#tableLaporan').addClass('animation-loading');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);
?>
<style>
    ul.yiiPager .selected a {
        background: #81CC74;
        color: #ffffff !important;
    }

    ul.yiiPager a:link,
    ul.yiiPager a:visited {
        border: solid 1px #81CC74;
        color: #373e4a;
        font-weight: inherit;
        padding: 0 8px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Penyadapan Darah</b>
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
                        <?php $this->renderPartial('penyadapandarah/_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Penyadapan Darah</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('penyadapandarah/_table', array('model' => $model, 'modShow' => $modShow, 'b' => $b));
                        $this->widget('CLinkPager', array(
                            'pages' => $pages,
                        )) ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('_tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                    </div>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPenyadapanDarah');
                $this->renderPartial('penyadapandarah/_footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>