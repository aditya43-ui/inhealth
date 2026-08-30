<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laporan Kartu Utang',
);
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikHutang&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
/*
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
*/
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kartu Utang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $this->renderPartial('akuntansi.views.laporanKartu.hutang/_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Utang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('akuntansi.views.laporanKartu.hutang/_table', array('model' => $model)); ?>
                <?php // $this->renderPartial('_tab'); 
                ?>

            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printHutang');
        $this->renderPartial('akuntansi.views.laporanKartu._footerNoGraph', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {

        var supplier = jQuery('#<?php echo CHtml::activeId($model, 'supplier_id') ?>');

        jQuery(supplier).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>