<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Obat Minimal</b>
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
                        $url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FrameMinimalStockFarmasi&id=1');
                        Yii::app()->clientScript->registerScript('searchTable', "
                                $('.search-button').click(function(){
                                    $('.search-form').toggle();
                                    return false;
                                });
                                $('.search-form form').submit(function(){
                                    $('#Grafik').attr('src','').css('height','0px');
                                    $.fn.yiiGridView.update('laporan-grid', {
                                        data: $(this).serialize()
                                    });
                                    return false;
                                });
                                ");
                        ?>
                        <div class="search-form">
                            <?php $this->renderPartial('minimalStock/_search', array(
                                'model' => $model,
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Obat Minimal</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('minimalStock/_tableStock', array('model' => $model)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('_tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                    </div>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintMinimalStock');
                $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//    $this->endWidget();
?>