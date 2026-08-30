<?php


$this->breadcrumbs=array(
    'Laporan Perbekalan Medik'    
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
	return false;
});
");


?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Laporan <strong>Perbekalan Medik</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
						<!--fieldset class="box search-form"-->
							<?php $this->renderPartial($this->path_view.'perbekalanMedik._search',array(
								'model'=>$model,
							)); ?>
						<!--/fieldset--><!-- search-form --> 

                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Perbekalan Medik</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel"> 
							<?php $this->renderPartial($this->path_view.'perbekalanMedik.grid._table', array('model'=>$model)); ?>
						</div>
                    </div>
                </div>								                							
                <?php 

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printPerbekalanMedik');
                $this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>''));?>
            </div>
        </div>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'perbekalanMedik/grid/_gedung',[],true) ?>
<?= $this->renderPartial($this->path_view.'perbekalanMedik/grid/_lokasi',[],true) ?>
<?= $this->renderPartial($this->path_view.'perbekalanMedik/grid/_ruangan',[],true) ?>
<?= $this->renderPartial($this->path_view.'perbekalanMedik/grid/_barang',[],true) ?>
