<?php
$this->breadcrumbs = array(
    'Laporan Pemesanan Barang',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pemesanan Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('/gudangUmum/laporanPemesananBarang/frameGrafikPemesananBarang');
        Yii::app()->clientScript->registerScript('search', "
					$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
					});
					$('.search-form form').submit(function(){
						$('#Grafik').attr('src','').css('height','0px');
						$.fn.yiiGridView.update('laporan-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body box">
                <?php $this->renderPartial('_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-chart-pie"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>