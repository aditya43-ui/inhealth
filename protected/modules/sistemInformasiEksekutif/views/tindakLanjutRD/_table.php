<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'penilaian-indikator-m-search',
));
?>
<?php echo $form->textField($model, 'tgl_awal', array('class' => 'span3')); ?>
<?php echo $form->textField($model, 'tgl_akhir', array('class' => 'span3')); ?>
<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchTabelPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTabel();
    $template = "{summary}\n{items}\n{pager}";
}
// format date for value
if ($model->jns_periode == "bulan") {
    $value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
} elseif ($model->jns_periode == "tahun") {
    $value = "date('Y',(strtotime(" . "$" . "data->periode)))";
} else {
    $value = "MyFormatter::formatDateTimeForUser(date('Y-m-d',(strtotime(" . "$" . "data->periode))))";
}
?>
<?php $this->endWidget(); ?>
<?php
$this->widget($table, array(
    'id' => 'table-grid',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Periode',
            'type' => 'raw',
            'value' => $value,
            'footer' => 'Total',
        ),
        array(
            'header' => 'Rawat Inap',
            'name' => 'jumlah_dirawat',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_dirawat)',
            'footer' => 'sum(jumlah_dirawat)',
        ),
        array(
            'header' => 'Rawat Jalan',
            'name' => 'jumlah_dirujuk',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_dirujuk)',
            'footer' => 'sum(jumlah_dirujuk)',
        ),
        array(
            'header' => 'Pasien Pulang',
            'name' => 'jumlah_pulang',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_pulang)',
            'footer' => 'sum(jumlah_pulang)',
        ),
        array(
            'header' => 'Pasien Meninggal',
            'name' => 'jumlah_meninggal',
            'type' => 'raw',
            'value' => 'number_format($data->jumlah_meninggal)',
            'footer' => 'sum(jumlah_meninggal)',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
                        function cekForm(obj)
{
    $("#penilaian-indikator-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-indikator-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>