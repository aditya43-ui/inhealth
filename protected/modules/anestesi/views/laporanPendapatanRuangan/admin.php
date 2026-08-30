<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Laporan <b>Pendapatan Ruangan</b></div>
    </div>
    <div class="panel-body">

    <?php
    $url = Yii::app()->createUrl('anestesi/laporanPendapatanRuangan/frameGrafikLaporanPendapatanRuangan&id=1');
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,'format'=>$format,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Tabel <b>Pendapatan Ruangan</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_table', array('model'=>$model)); ?>
            </div>
        </div>

    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));?>
</div>
</div>