<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Barang Fast Moving</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Fast Moving Barang',
        );
        $url = Yii::app()->createUrl('gudangUmum/laporanFastSlowMoving/frameFast&id=1');
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
        <?php echo $this->renderPartial('_search', array(
            'model' => $model,
        ), true); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Barang Fast Moving</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_table', array(
                    'model' => $model, 'fast' => true,
                ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-chart-pie"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printFast');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>