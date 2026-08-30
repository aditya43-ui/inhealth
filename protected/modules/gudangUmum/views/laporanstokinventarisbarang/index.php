<?php
$this->breadcrumbs = array(
    'Laporan Stok Barang',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Stok Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        // $url = Yii::app()->createUrl('FrameMutasiBarang&id=1');
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
                    'model' => $model, 'format' => $format,
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = $this->createUrl('print');
                ?>
            </div>
        </div>

        <?php $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint)); ?>
    </div>
</div>