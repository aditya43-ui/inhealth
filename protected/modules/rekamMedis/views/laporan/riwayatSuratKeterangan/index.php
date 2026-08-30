<?php
$this->breadcrumbs = array(
    'Laporan Riwayat Surat Keterangan',
);
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);
?>
<style>
    table {
        margin-bottom: 0;
    }

    .form-actions {
        padding: 4px;
        margin-top: 5px;
    }

    .nav-tabs>li>a {
        display: block;
        cursor: pointer;
    }

    .nav-tabs>.active a:hover {
        cursor: pointer;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Riwayat Surat Keterangan</b>
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

                Yii::app()->clientScript->registerScript('search', "
                            $('#searchLaporan').submit(function(){
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
                <?php $this->renderPartial('riwayatSuratKeterangan/_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Surat Keterangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('riwayatSuratKeterangan/_table', array('model' => $model)); ?>
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
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanLembarResepLuar');
                $this->renderPartial('_tab');
                ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url = Yii::app()->createUrl($module . '/' . $controller . '/frameGrafikRiwayatSuratKeterangan') . '/';
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printRiwayatSuratKeterangan');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>

<!--search-form-->
<!--/div-->