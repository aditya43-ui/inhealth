<?php
$this->breadcrumbs = array(
    'Laporan Lembar Resep Luar',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Lembar Resep Luar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('farmasiApotek/laporan/frameGrafikLaporanLembarResepLuar&id=1');
        Yii::app()->clientScript->registerScript('search', "
                            $('#laporan-search').submit(function(){
                                $('#Grafik').attr('src','').css('height','0px');
                                $.fn.yiiGridView.update('laporan-grid', {
                                        data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
        ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php // $this->renderPartial('_search',array('model'=>$model)); 
                ?>
                <?php $this->renderPartial('laporanlembarresepluarV/_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Lembar Resep Luar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('laporanlembarresepluarV/_table', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanLembarResepLuar');
                $this->renderPartial('_tab');
                ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $this->renderPartial('_footerLaporanlembar', array('urlPrint' => $urlPrint, 'url' => $url, 'model' => $model));
        ?>
    </div>
</div>