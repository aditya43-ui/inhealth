<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/detailTransaksiFarmasi');
$id_pendaftaran = $data['pendaftaran_id'];

?>
<script>
    function printDetail(params) {
        var url = <?php echo "'" . $urlPrint . "'"; ?>;
        var id_pendaftaran = <?php echo $id_pendaftaran; ?>;
        window.open(url + "&caraPrint=" + params + "&id=" + id_pendaftaran, "", 'location=_new, width=900px');
    }
</script>
<?php
if (isset($caraPrint)) {
    echo $this->renderPartial(
        'application.views.headerReport.headerLaporan',
        array(
            'judulLaporan' => $data['judulLaporan'],
            'periode' => $data['periode']
        )
    );
}
$table = '<table width="100%" class ="table table-striped table-bordered table-condensed">';
$table .= '<thead>';
$table .= '<tr>';
$table .= '<th>Kelompok</th>';
$table .= '<th>No. Transaksi</th>';
$table .= '<th>Nama Items</th>';
$table .= '<th>Jumlah</th>';
$table .= '<th>Harga</th>';
$table .= '</tr>';
$table .= '</thead>';

$cols = '';
foreach ($row as $val) {
    $rowspan = '';
    $cols .= '<tr>';
    if (count((array)$val['data_transaksi']) > 1) {
        $rowspan = "rowspan='" . count((array)$val['data_transaksi']) . "'";
    }
    $td_pertama = '<td ' . $rowspan . '>' . $val['kelompok'] . '</td>';
    $col = '';
    foreach ($val['data_transaksi'] as $value) {
        $col .= '<td>' . $value['no_transaksi'] . '</td>';
        $col .= '<td>' . $value['nama_item'] . '</td>';
        $col .= '<td style = "text-align:right;">' . $value['qty'] . '</td>';
        $col .= '<td style = "text-align:right;">' . $value['harga'] . '</td>';
        $col .= '</tr>';
    }
    $cols .= $td_pertama;
    $cols .= $col;
}
$table .= $cols;
$table .= '</table>';
echo ($table);
?>
<?php
$this->widget('bootstrap.widgets.BootButtonGroup', array(
    'type' => 'primary',
    'buttons' => array(
        array(
            'label' => 'Print',
            'icon' => 'entypo-print',
            'url' => "#",
            'htmlOptions' => array(
                'onclick' => 'printDetail(\'PRINT\');return false;'
            )
        ),
        array(
            'label' => '',
            'items' => array(
                array('label' => 'PDF', 'icon' => 'icon-book', 'url' => "#", 'itemOptions' => array('onclick' => 'printDetail(\'PDF\');return false;')),
                array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => "#", 'itemOptions' => array('onclick' => 'printDetail(\'EXCEL\');return false;')),
            )
        ),
    ),
));
?>
<?php
/*
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $dataProvider = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        
        echo $this->renderPartial('application.views.headerReport.headerLaporan',
            array(
                'judulLaporan'=>$data['judulLaporan'],
                'periode'=>$data['periode']
            )
        );        
    } else{
        $dataProvider = $model->searchTableDetail();
        $template = "{summary}\n{items}\n{pager}";
    }
 * 
 */
?>
<?php
/*
    $this->widget($table,
        array(
            'id'=>'tableLaporanFarmasi',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('jenisobatalkes_nama'),
            'columns'=>array(
                array(
                    'header'=>'Kelompok',
                    'type'=>'raw',
                    'name'=>'jenisobatalkes_nama',
                    'value'=>'$data->jenisobatalkes_nama',
                ),
                array(
                    'header'=>'Tgl. Transaksi',
                    'type'=>'raw',
                    'value'=>'$data->tglpenjualan',
                ),
                array(
                    'header'=>'Nama Item',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_nama',
                ),
                array(
                    'header'=>'Jumlah',
                    'type'=>'raw',
                    'value'=>'$data->qty_oa',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Harga (Rp)',
                    'type'=>'raw',
                    'value'=>'CustomFunction::formatnumber($data->hargasatuan_oa)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
 * 
 */

?>