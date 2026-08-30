<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Faktur Pembelian Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Faktur Pembelian Farmasi',
        );
        $url = Yii::app()->createUrl('keuangan/LaporanFakturPembelianFarmasi/FrameGrafik&id=1');
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian Farmasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tableBaru', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <?php $this->renderPartial($this->path_view . '_tab'); ?>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>