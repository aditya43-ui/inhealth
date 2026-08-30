<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Laporan <b>Klasifikasi ASA</b></div>
    </div>
    <div class="panel-body">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php
                    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FramePengkajianAskep&id=1');
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
                <?php $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format)); ?>
            </div>
        </div>
    
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Tabel <b>Klasifikasi ASA</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_table',array('model'=>$model)); ?>
                <?php 
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Print');
                ?>
            </div>
        </div>

<!--    <div class="block-tabel">
        <?php // $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>-->
    <?php $this->renderPartial($this->path_view.'_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model));?>
</div>
</div>
<script>
    function konfirmasi(){
    location.reload();
    }
</script>