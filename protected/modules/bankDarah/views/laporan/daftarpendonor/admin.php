<?php
$this->breadcrumbs = array(
    'Laporan Daftar Pendonor'
);

$url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikdaftarpendonor&id=1');
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
    ul.yiiPager .selected a{
        background: #81CC74;
        color: #ffffff !important;
    }
    ul.yiiPager a:link, ul.yiiPager a:visited{
        border: solid 1px #81CC74;
        color: #373e4a;
        font-weight: inherit;
        padding: 0 8px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Daftar Pendonor</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
                        <?php
                        $this->renderPartial('daftarpendonor/_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Daftar Pendonor</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <div class="block-tabel"> 
                            <?php
                            $this->renderPartial('daftarpendonor/_table', array('model' => $model, 'modShow' => $modShow));
                            $this->widget('CLinkPager', array(
                                'pages' => $pages,
                            ))
                            ?>
                        </div>
                    </div>
                </div>															
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printdaftarpendonor');
                $this->renderPartial('daftarpendonor/_footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>
