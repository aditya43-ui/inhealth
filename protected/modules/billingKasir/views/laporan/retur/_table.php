<?php 
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
    $data = $model->searchPrint();  
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'htmlOptions'=>array(
            'style'=>'font-size',
            
        ),
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            array(
                'header'=>'Tanggal Retur',
                'name'=>'tglreturpelayanan',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglreturpelayanan))',
            ),
            array(
                'header'=>'No. Retur Pembayaran',
                'name'=>'noreturbayar',
                'type'=>'raw',
                'value'=>'$data->noreturbayar',
            ),
             array(
                'header'=>'No. RM',
                'name'=>'no_rekam_medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),
            'no_pendaftaran',
            'nama_pasien',                       
            array(
                'header'=>'Ruangan Pelayanan',
                'name'=>'ruanganakhir_nama',
                'type'=>'raw',
                'value'=>'$data->ruanganakhir_nama',
            ),
            array(
                'header'=>'Nominal Retur',
                'name'=>'totalbiayaretur',
                'type'=>'raw',
                'value'=>'number_format($data->totalbiayaretur,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right')
            ),
            array(
                'header'=>'Keterangan Retur',
                'name'=>'keteranganretur',
                'type'=>'raw',
                'value'=>'$data->keteranganretur',
            ),
            array(
                'header'=>'User Pelaksana Retur',
                'name'=>'user_nm_otorisasi',
                'type'=>'raw',
                'value'=>'$data->user_nm_otorisasi',
            ),                                                 

       ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>