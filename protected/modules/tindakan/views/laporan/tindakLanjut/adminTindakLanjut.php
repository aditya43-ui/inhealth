<?php
$this->breadcrumbs = array(
    'Laporan Tindak Lanjut'
);

$url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanTindakLanjut&id=1');
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
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Tindak Lanjut</b>
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
                        <?php $this->renderPartial($this->path_view . 'tindakLanjut/_searchTindakLanjut', array(
                            'model' => $model,
                        )); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Tindak Lanjut</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view . 'tindakLanjut/_tableTindakLanjut', array('model' => $model)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . '_tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                    </div>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanTindakLanjut');
                $this->renderPartial('rawatJalan.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>