<div class="white-container">
    <legend class="rim2">Laporan Utang <b>Titipan Apotik</b></legend>
    <?php
    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanJasaServices&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('#search-laporan').submit(function(){
            $('#laporan-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('laporan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <fieldset class="box">
        <?php $this->renderPartial('hutangTitipanApotek/_search',array('model'=>$model)); ?>
    </fieldset>
        <div class="block-tabel">
        <h6>Tabel Utang <b>Titipan Apotik</b></h6>
        <?php $this->renderPartial('hutangTitipanApotek/_table',array('model'=>$model)); ?>
        <?php // $this->renderPartial('_tab'); ?>
    <!--<iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>-->
    </div>
    <?php        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printHutangTitipanApotik');
    $this->renderPartial('hutangTitipanApotek/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>