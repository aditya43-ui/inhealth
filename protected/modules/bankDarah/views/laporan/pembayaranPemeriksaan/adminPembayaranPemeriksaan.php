<div class="white-container">
    <legend class="rim2">Laporan <b>Pembayaran Pemeriksaan</b></legend>
    <?php
        $url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPembayaranPemeriksaan&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $('#tableLaporanPembayaranPemeriksaan').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporanPembayaranPemeriksaan', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <div class="search-form">
        <?php $this->renderPartial('bankDarah.views.laporan.pembayaranPemeriksaan/_searchPembayaranPemeriksaan',
                array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <h6>tABEL <b>Pembayaran Pemeriksaan</b></h6>
        <?php $this->renderPartial('bankDarah.views.laporan.pembayaranPemeriksaan/_tablePembayaranPemeriksaan', array('model'=>$model)); ?>
    </div>
    
        <?php // $this->renderPartial('bankDarah.views.laporan._tab'); ?>
<!--<iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>       
    </div>-->
    <?php   
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPembayaranPemeriksaan');
        $this->renderPartial('bankDarah.views.laporan._footerNoGrafik', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
        $this->renderPartial('_jsFunctions', array('model'=>$model));
    ?>
</div>