<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kunjungan Rawat Jalan dan Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Kunjungan Rawat Jalan dan Rawat Darurat'
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <div class="search-form">
            <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchRJRD', array(
                'modPPInfoKunjunganV' => $model, 'format' => $format
            )); ?>
        </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Kunjungan Rawat Jalan dan Rawat Darurat</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <!--<div class='block-tabel'>-->
                    <!--<h6>Tabel Kunjungan <b>Rawat Jalan</b></h6>-->
                    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tableGlobalRJ', array('model' => $model)); ?>
                    <!--</div>-->
                </div>
            </div>


        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = 'rekamMedis'; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createUrl('/' . $module . '/' . $controller . '/printKunjunganRJ');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footerExcel', array('urlPrint' => $urlPrint, 'tips' => 'bukuregister'));
        ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>

