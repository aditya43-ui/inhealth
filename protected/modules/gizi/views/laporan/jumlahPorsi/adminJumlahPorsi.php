<?php
$this->breadcrumbs = array(
    'Laporan Jumlah Porsi',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Jumlah Porsi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanJasaInstalasi&id=1');
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
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial('jumlahPorsi/_searchJumlahPorsi', array(
                    'model' => $model,
                ));
                ?>
            </div>
            <!--search-form-->
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jumlah Porsi Berdasarkan <span id="ruangan"></span></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('jumlahPorsi/_tableJumlahPorsi', array('model' => $model)); ?>

            </div>
        </div>
        <?php //$this->renderPartial('_tab');  
        ?>
        <!--<iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);"></iframe>-->

        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
        //')); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanJumlahPorsiGizi');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'grafik' => 'none'));
        ?>
        <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>
<script>
    function changeRuangan() {

        var ru = "Ruangan " + $("#GZLaporanJumlahPorsiV_ruangan_id option:selected").html();

        setTimeout(function() {
            if (ru == "Ruangan -- Pilih --") {
                ru = "Semua Ruangan";
            }
            $("#ruangan").html(ru);
        }, 500);
    }
</script>