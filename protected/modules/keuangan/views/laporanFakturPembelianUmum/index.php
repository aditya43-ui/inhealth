<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Faktur Pembelian Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Faktur Pembelian Umum',
        );
        $url = Yii::app()->createUrl('keuangan/LaporanFakturPembelianUmum/FrameGrafik&id=1');
        Yii::app()->clientScript->registerScript('search', "
    $('#searchLaporan').submit(function(){
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
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tableBaru', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
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
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>