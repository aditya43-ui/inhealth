<style>

.tab_detail {
    width: 100%;
    border-collapse: collapse;
}

.tab_detail td, .tab_detail th {
    border: 1px solid black;
    padding: 10px;
}

</style>

<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}


echo $this->renderPartial('_headerPrint');

?>


<?php

$prov->pagination = false;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'tab_detail',
    'columns' => array(
        array(
            'header'=>'Kode',
            'name'=>'kode',
        ),
        array(
            'header'=>'Nama',
            'name'=>'nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
	}',
));

?>

