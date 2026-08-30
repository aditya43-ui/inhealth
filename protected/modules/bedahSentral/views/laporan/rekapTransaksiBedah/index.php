<?php
$this->breadcrumbs = array(
    'Laporan Rekap Transaksi',
);
$url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/frameGrafikLaporanRekapTransaksi&id=1');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchLaporan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
         $('#laporanrekaptransaksi-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('laporanrekaptransaksi-grid', {
                data: $(this).serialize()
        });
    //    $.fn.yiiGridView.update('ugd_laporanrekaptransaksi-grid', {
    //            data: $(this).serialize()
    //    });
    //    $.fn.yiiGridView.update('rj_laporanrekaptransaksi-grid', {
    //            data: $(this).serialize()
    //    });
    //    $.fn.yiiGridView.update('ri_laporanrekaptransaksi-grid', {
    //            data: $(this).serialize()
    //    });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Laporan <b>Rekap Transaksi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('rekapTransaksiBedah/_search', array(
                    'model' => $model, 'filter' => $filter
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekap Transaksi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                //        $this->widget('bootstrap.widgets.BootMenu',array(
                //            'type'=>'tabs',
                //            'stacked'=>false,
                //            'htmlOptions'=>array('id'=>'tabmenu'),
                //            'items'=>array(
                //                array('label'=>'Global','url'=>'javascript:tab(0);','active'=>true),
                //                array('label'=>'Per UGD','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                //                array('label'=>'Per Rawat Jalan','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
                //                array('label'=>'Per Rawat Inap','url'=>'javascript:tab(3);', 'itemOptions'=>array("index"=>3)),
                //            ),
                //        ))
                ?>
                <?php $this->renderPartial('rekapTransaksiBedah/_table', array('model' => $model)); ?>
                <?php //$this->renderPartial('_tab'); 
                ?>
                <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);" hidden>
                </iframe>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanRekapTransaksi');
        $this->renderPartial('_footer2', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>

<!--search-form-->
<?php $this->renderPartial('rekapTransaksiBedah/_jsFunctions', array('model' => $model)); ?>