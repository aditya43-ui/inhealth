<div class="panel panel-gradient">
    <?php
    $this->breadcrumbs = array(
        'Laporan Pengajuan Klaim Piutang',
    );
    $url = Yii::app()->createUrl('keuangan/laporanPembayaranGaji/FrameGrafikLaporanPembayaranGaji&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('#searchLaporan').submit(function(){
            $.fn.yiiGridView.update('laporan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pengajuan Klaim Piutang</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Klaim Piutang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>

    </div>
</div>


<script>
    $(document).ready(function() {
        var penjamin = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

        jQuery(penjamin).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();


    });
</script>