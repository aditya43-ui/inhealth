<div class="white-container">
    <legend class="rim2"><?php echo $judulLaporan?></legend>
    <?php
    $url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPemeriksaanPenunjang&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchLaporan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#tableLaporanPemeriksaanPenunjang').addClass('animation-loading');
        $.fn.yiiGridView.update('tableLaporanPemeriksaanPenunjang', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanPenunjang/_searchPemeriksaanPenunjang',
                array('model'=>$model)); ?>
    </fieldset>
    <div class="block-tabel"> 
        <h6>Tabel <b>Data Pemeriksaan</b></h6>
        <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanPenunjang/_tablePemeriksaanPenunjang', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('bankDarah.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>       
    </div>
    <?php   
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPemeriksaanPenunjang');
        $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
        $this->renderPartial('_jsFunctions', array('model'=>$model));
    ?>
</div>