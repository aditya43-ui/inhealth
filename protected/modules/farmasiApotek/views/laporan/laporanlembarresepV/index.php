<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Laporan Lembar Resep',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Lembar Resep</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $url = Yii::app()->createUrl('farmasiApotek/laporan/frameGrafikLaporanLembarResep&id=1');
                Yii::app()->clientScript->registerScript('search', "
                            $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                            });
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
                <?php // $this->renderPartial('_search',array('model'=>$model)); 
                ?>
                <?php $this->renderPartial('laporanlembarresepV/_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Lembar Resep</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('laporanlembarresepV/_table', array('tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir, 'model' => $model)); ?>
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
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanLembarResep');
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