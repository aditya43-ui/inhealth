<?php
$url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPemeriksaanRujukan&id=1');
$rim = 'width:600px;overflow-x:none;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTableLaporan();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrintLaporan();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php
Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('tableRujukanLuar', {
                    data: $(this).serialize()
            });
            $.fn.yiiGridView.update('tableRujukanRS', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
?>
<?php $this->renderPartial(
    'bankDarah.views.laporan.pemeriksaanRujukan/_searchPemeriksaanRujukan',
    array('model' => $model, 'modelRS' => $modelRS)
); ?>
<div id="div_rujukanLuar">
    <?php
    if (isset($caraPrint)) {
    } else {
    ?>
        <div class="block-tabel">
            <h6>Tabel Pemeriksaan <b>Rujukan - Dari Luar</b></h6>
        <?php } ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
            'id' => 'tableRujukanLuar',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-condensed',
            'mergeColumns' => array(
                'no',
                'no_pendaftaran',
            ),
            'columns' => array(
                array(
                    'header' => 'No.',
                    'name' => 'no',
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions' => array('style' => 'text-align:center'),
                    /*
                         'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
                         'footer'=>'Total',
                          * 
                          */
                ),
                array(
                    'header' => 'No. Pendaftaran Lab',
                    'name' => 'no_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran'
                ),
                array(
                    'header' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'date("d/m/Y H:i:s", strtotime($data->tglmasukpenunjang))',
                ),
                array(
                    'header' => 'Kode',
                    'type' => 'raw',
                    'value' => '$data->daftartindakan_kode'
                ),
                array(
                    'header' => 'Jenis Pemeriksaan',
                    'type' => 'raw',
                    'value' => '$data->daftartindakan_nama'
                ),
                array(
                    'header' => 'Tarif',
                    'name' => 'tarif_satuan',
                    'type' => 'raw',
                    'value' => 'number_format($data->tarif_satuan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align:right'),
                    /*
                         'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                         'footer'=>'sum(tarif_satuan)',
                          * 
                          */
                ),
            ),
        )); ?>
        </div>
</div>
<div class="block-tabel">
    <?php $this->renderPartial('bankDarah.views.laporan._tab'); ?>

    <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
    </iframe>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPemeriksaanRujukanLuar');
$this->renderPartial('bankDarah.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
$this->renderPartial('_jsFunctions', array('model' => $model));
?>
<?php
$js = <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_rujukanLuar").show();
        $("#div_rujukanRS").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('luar');
            $("#div_rujukanLuar").show();
            $("#div_rujukanRS").hide();  
        } else if (index==1){
            $("#filter_tab").val('rs');
            $("#div_rujukanLuar").hide();
            $("#div_rujukanRS").show();
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('tableRujukanLuar', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableRujukanRS', {
                data: $("#searchLaporan").serialize()
            });       
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pemeriksaanRujukan', $js, CClientScript::POS_HEAD);
?>