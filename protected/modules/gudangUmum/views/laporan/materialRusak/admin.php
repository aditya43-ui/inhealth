<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Material Rusak</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Material Rusak',
        );
        $url = Yii::app()->createUrl('gudangUmum/laporan/FrameMaterialRusak&id=1');
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body box">
                <!--fieldset class="box"-->
                <?php $this->renderPartial('materialRusak/_search', array(
                    'model' => $model, 'format' => $format, 'searchdata' => $searchdata,
                )); ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Material Rusak</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('materialRusak/_table', array('model' => $model, 'searchdata' => $searchdata,)); ?>
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

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintMaterialRusak');
        $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
        <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model, 'searchdata' => $searchdata,)); ?>
    </div>
</div>