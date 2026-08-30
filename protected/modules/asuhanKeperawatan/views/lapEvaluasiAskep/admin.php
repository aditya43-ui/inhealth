<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Evaluasi Keperawatan</b>
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
                $url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FramePengkajianAskep&id=1');
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
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Evaluasi Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');
                ?>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
    </div>
</div>

<script>
    function konfirmasi() {
        location.reload();
    }
</script>