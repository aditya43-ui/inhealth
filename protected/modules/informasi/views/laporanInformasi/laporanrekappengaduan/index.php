<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Rekap <b>Pengaduan Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#searchLaporan').submit(function(){
                $.fn.yiiGridView.update('laporansayhello-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $url = Yii::app()->createUrl('billingKasir/laporan/FrameGrafikLaporanSetoranHarian&id=1');
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial('laporanrekappengaduan/_search', array(
                    'model' => $model,
                    'format' => $format,
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekap Pengaduan Rumah Sakit</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->renderPartial('laporanrekappengaduan/_table', array(
                    'model' => $model,
                    'format' => $format,
                ));
                ?>
            </div>
        </div>

    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanrekappengaduan');
$this->renderPartial('_footer2', array('urlPrint' => $urlPrint, 'url' => $url));
?>