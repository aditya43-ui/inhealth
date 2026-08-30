<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan <b>Re-Evaluasi Aset</b></div>
    </div>
    <div class="panel-body">

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
        <?php $this->renderPartial($this->path_view.'reevaluasiAset/_searchReevaluasi',array(
            'model'=>$model,
			'format'=>$format
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Re-Evaluasi Aset</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'reevaluasiAset/_tableReevaluasi', array('model'=>$model)); ?>
            </div>
        </div>
    </div>

    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintReevaluasi');
    $this->renderPartial($this->path_view.'reevaluasiAset/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
	?>
    <?php //$this->renderPartial($this->path_viewPP.'rawatJalan/_jsFunctions', array('model'=>$model));?>
</div>
</div>
</div>