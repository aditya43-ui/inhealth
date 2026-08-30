<?php
$this->breadcrumbs = array(
    'Laporan Jumlah Pendonor'
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
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Laporan <b> Jumlah Pendonor </b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <i class="entypo-search"></i>  <b> Pencarian </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'modShow2' => $modShow2)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Tabel <b> Donor Darah </b> </div>
            </div>
            <div class="panel-body">
                <div class="panel-body overflow-x" >
                    <div class="block-tabel"> 
                        <?php
                        $this->renderPartial($this->path_view . '_table', array('model' => $model, 'b' => $b));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $this->renderPartial($this->path_view . '_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
        ?>
    </div>
</div>