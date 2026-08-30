<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);

$this->breadcrumbs=array(
    'Laporan Rekapitulasi Peralatan Berdasarkan Sumber Dana'    
);


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
        cariData();
	return false;
});
");


?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Laporan <strong>Rekapitulasi Peralatan Berdasarkan Sumber Dana</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
						<!--fieldset class="box search-form"-->
							<?php $this->renderPartial($this->path_view.'rekapitulasiKondisiAset._search',array(
								'model'=>$model,
							)); ?>
						<!--/fieldset--><!-- search-form --> 

                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Rekapitulasi Peralatan Berdasarkan Sumber Dana</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel"> 
							<?php $this->renderPartial($this->path_view.'rekapitulasiPeralatanBySumberDana._table', array('model'=>$model)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="fas fa-chart-bar"></i> Grafik</div>
                    </div>
                    <div class="panel-body">
                        <?= $this->renderPartial($this->path_view.'rekapitulasiPeralatanBySumberDana._tab',[],true); ?>
                        <?= $this->renderPartial($this->path_view.'rekapitulasiPeralatanBySumberDana._grafik',['model'=>$model],true); ?>
                    </div>
                </div>								
                <?php 

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printRekapitulasiPeralatanBySumberDana');
                $this->renderPartial($this->path_view.'_footerGrafik', array('urlPrint'=>$urlPrint, 'url'=>''));?>
            </div>
        </div>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'grid/_gedung',[],true) ?>
<?= $this->renderPartial($this->path_view.'grid/_lokasi',[],true) ?>
<?= $this->renderPartial($this->path_view.'grid/_ruangan',[],true) ?>
<?= $this->renderPartial($this->path_view.'rekapitulasiPeralatanBySumberDana/_jsFunction',['model'=>$model],true) ?>

<script>
    setTimeout(function(){
            
        cariData();
        
    },500);            
</script>