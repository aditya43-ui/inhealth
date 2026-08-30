<?php

/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchRencanaKebutuhanPrint();
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchRencanaKebutuhan();
}
?>
<?php $this->widget($table, array(
    'id' => 'laporan-grid',
    'dataProvider' => $data,
    'itemsCssClass' => 'table table-striped table-condensed',
    'template' => $template,
    //       'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
    //                'start'=>3, //indeks kolom 3
    //                'end'=>5, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            //                        'footer'=>'<b>Total:</b>',
            //                        'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
            //                        'type'=>'raw',
            //                         'htmlOptions'=>array(
            //                            'style'=>'text-align:right;padding-right:10%;'
            //                        ),
        ),
        array(
            'header' => 'Tanggal Perencanaan',
            'value' => 'date("d/m/Y H:i:s", strtotime($data->tglperencanaan))',
        ),
        array(
            'header' => 'No. Perencanaan',
            'value' => '$data->noperencnaan',
        ),
        array(
            'header' => 'Nama Obat Alkes',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Jumlah Permintaan',
            'value' => '$data->jmlpermintaan',
        ),
        array(
            'header' => 'Harga Total (Rp)',
            'value' => 'number_format($data->hargatotalrenc)',
        ),
        //                    array(
        //                        'name'=>'qty_in',
        //                        'type'=>'raw',
        //                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah In</p>',
        //                        'value'=>'$data->qty_in',
        //                        'htmlOptions'=>array('style'=>'text-align:center;'),
        //                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
        //                        'footer'=>'sum(qty_in)',
        //                        
        ////                        'footer'=>number_format($model->totalqtystok_in),
        //                    ),
        //                    array(
        //                        'name'=>'qty_out',
        //                        'type'=>'raw',
        //                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah Out</p>',
        //                        'value'=>'$data->qty_out',
        //                        'htmlOptions'=>array('style'=>'text-align:center;'),
        //                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
        //                        'footer'=>'sum(qty_out)',
        //                        
        ////                        'footer'=>number_format($model->totalqtystok_in),
        //                    ),
        //                    array(
        //                        'name'=>'qty_current',
        //                        'type'=>'raw',
        //                        'header'=>'<p style="margin: 0; text-align: center;">Jumlah Current</p>',
        //                        'value'=>'$data->qty_current',
        //                        'htmlOptions'=>array('style'=>'text-align:center;'),
        //                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
        //                        'footer'=>'sum(qty_current)',
        //                        
        ////                        'footer'=>number_format($model->totalqtystok_in),
        //                    ),
        //                    array(
        //                        'header'=>'Harga Jual',
        //                        'value'=>'number_format($data->hargajual_oa)',
        //                        'footer'=>number_format($model->totalhargajual),
        //                    ),
        //                    array(
        ////                        'header'=>'Total Harga',
        ////                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
        ////                        'footer'=>number_format($model->totalharga),
        //                        'name'=>'totalharga',
        //                        'type'=>'raw',
        //                        'header'=>'Total Harga',
        //                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
        //                        'htmlOptions'=>array('style'=>'text-align:right;'),
        //                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        //                        'footer'=>'sum(totalharga)',
        //                    ),
    ),
)); ?>