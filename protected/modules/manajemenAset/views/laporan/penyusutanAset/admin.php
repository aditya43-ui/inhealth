<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan <b>Penyusutan Aset</b></div>
    </div>
    <div class="panel-body">

    <?php
    $url = Yii::app()->createUrl('manajemenAset/laporan/penyusutanAset&id=47');
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
        <?php $this->renderPartial($this->path_view.'penyusutanAset/_search',array(
            'model'=>$model,
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Penyusutan Aset</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'penyusutanAset/_table', array('model'=>$model,)); ?>
            </div>
        </div>
        
    </div>

    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanPenyusutanAset');
    $this->renderPartial($this->path_view.'penyusutanAset/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
	?>
    <?php //$this->renderPartial($this->path_viewPP.'rawatJalan/_jsFunctions', array('model'=>$model));?>
</div>
</div>
</div>