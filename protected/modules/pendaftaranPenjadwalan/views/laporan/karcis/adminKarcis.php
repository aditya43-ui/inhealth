<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Karcis Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppinfo Kunjungan Rjvs' => array('index'),
            'Manage',
        );

        $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/FrameLaporanKarcis&id=1');
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <div class="box search-form">
            <?php $this->renderPartial('karcis/_searchKarcis', array(
                'modPPInfoKunjunganV' => $model, 'format' => $format
            )); ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Karcis Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('karcis/_tableKarcis', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKarcis');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.karcis/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>