<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Penerimaan Kas</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('keuangan/laporanPembayaranGaji/FrameGrafikLaporanPembayaranGaji&id=1');
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
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Kas</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
            </div>

        </div>

        <!--<iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>-->
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>