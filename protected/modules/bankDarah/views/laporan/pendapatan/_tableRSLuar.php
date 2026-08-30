<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$this->renderPartial('pendapatan/_search', array(
    'model' => $model,
));
?>
<div id="div_luar">
    <?php if (isset($caraPrint)) {
        $dataLuar = $model->searchPrintPendapatanLuar();
    } else {
        $dataLuar = $model->searchPendapatanLuar();
    ?>
        <div class="block-tabel">
            <h6>Tabel Pendapatan Ruangan <b>Bank Darah - Dari Luar RS</b></h6>
        <?php } ?>
        <?php $this->widget($table, array(
            'id' => 'tablePendapatanLuar',
            'dataProvider' => $dataLuar,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'No. Lab',
                    'type' => 'raw',
                    'value' => '$data->no_masukpenunjang',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                ),
                array(
                    'header' => 'Nama',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                ),
                array(
                    'header' => 'Kedatangan',
                    'type' => 'raw',
                    'value' => '(empty($data->asalrujukan_nama) ? "RUMAH SAKIT" : $data->asalrujukan_nama)',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                    'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'Jumlah Total',
                ),
                array(
                    'header' => 'Pend. Seharusnya',
                    'type' => 'raw',
                    'name' => 'pend_seharusnya',
                    'value' => 'number_format($data->pend_seharusnya)',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(pend_seharusnya)',
                ),
                array(
                    'header' => 'Pend. Sebenarnya',
                    'type' => 'raw',
                    'name' => 'pend_sebenarnya',
                    'value' => 'number_format($data->pend_sebenarnya)',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(pend_sebenarnya)',
                ),
                array(
                    'header' => 'Sisa',
                    'type' => 'raw',
                    'name' => 'sisa',
                    'value' => 'number_format($data->sisa)',
                    'headerHtmlOptions' => array('style' => 'text-align:center'),
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(sisa)',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
        </div>
</div>
<?php
$url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikLaporanPendapatan&id=1');
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPendapatanRSLuar');
//$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

    $content = $this->renderPartial('tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","' . $url . '"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>