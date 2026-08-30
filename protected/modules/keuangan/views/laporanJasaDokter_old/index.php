<div class="white-container">
    <?php
    $url = Yii::app()->createUrl('keuangan/laporanJasaDokter/FrameGrafikLaporanJasaDokter&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('#searchLaporan').submit(function(){
            $.fn.yiiGridView.update('laporan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Laporan Pembayaran <b>Jasa Dokter</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Pembayaran <b>Jasa Dokter</b></h6>
        <?php $this->renderPartial('_table',array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
    </div>
    <?php        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>