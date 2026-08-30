<div class="white-container">
    <legend class="rim2">Laporan <b>Indikator Dokter</b></legend>
    <?php
    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporanIndikatorDokter/frameGrafikIndikatorDokter&id=1');
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
    <div class="search-form">
        <?php $this->renderPartial('_searchIndikatorDokter',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </div><!--search-form--> 
    <div class="block-tabel">
        <h6>Tabel <b>Indikator Dokter</b></h6>
        <?php $this->renderPartial('_tableIndikatorDokter', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial($this->path_viewPP.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanIndikatorDokter');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial($this->path_viewPP.'rawatJalan/_jsFunctions', array('model'=>$model));?>
</div>