<?php
$this->breadcrumbs = array(
    'Laporan Penerimaan Bahan Makanan',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Penerimaan Bahan Makanan</b>
        </div>
    </div>

    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('gizi/laporan/frameGrafikLaporanBahanPenerimaanMakanan&id=1');
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

        <?php
        $this->renderPartial('terimaBahanMak/_search', array(
            'model' => $model, 'format' => $format
        ));
        ?>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('terimaBahanMak/_table', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>

            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        //mengambil Controller yang sedang dipakai
        $controller = Yii::app()->controller->id;
        //mengambil Module yang sedang dipakai
        $module = Yii::app()->controller->module->id;

        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanBahanPenerimaanMakanan');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>

<?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model)); ?>

<script>
    function konfirmasi() {
        location.reload();
    }
</script>