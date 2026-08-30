<div class="white-container">
    <legend class="rim2">Laporan <b>Realisasi Anggaran Penerimaan</b></legend>

    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <?php
    $url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FrameAnggaranPenerimaan&id=1');
    Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#laporan-search').submit(function(){
                    $.fn.yiiGridView.update('laporan-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
    ?>
    <?php $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>

    <div class="block-tabel">
        <h6>Tabel <b>Realisasi Anggaran Penerimaan</b></h6>
        <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');
        ?>
    </div>
    <!--<div class="block-tabel">
        <?php // $this->renderPartial($this->path_view.'_tab'); 
        ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>-->
    <?php $this->renderPartial($this->path_view . '_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    <?php // $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model));
    ?>
</div>
<script>
    function konfirmasi() {
        location.reload();
    }
</script>