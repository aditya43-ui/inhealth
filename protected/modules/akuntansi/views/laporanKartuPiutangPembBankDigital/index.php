<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laporan kartu Piutang Bank & Pembayaran Digital',
);
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikHutang&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
/*
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
*/
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kartu Piutang Bank & Pembayaran Digital</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $this->renderPartial($this->path_view . '/_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Piutang Bank & Pembayaran Digital</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $this->renderPartial($this->path_view . '_footerNoGraph', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>