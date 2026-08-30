<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header'=>'Tanggal Pendaftaran/<br>Tanggal Meninggal',
                'type'=>'raw',
                'value'=>'$data->Tanggal',
            ),
            array(
                'header'=>'No. Pendaftaran/<br>No. Rekam Medis',
                'type'=>'raw',
                'value'=>'$data->RM',
            ),
            array(
                'header'=>'Nama Pasien/<br>Alias ',
                'type'=>'raw',
                'value'=>'$data->Nama',
            ),
            array( 
                'header'=>'Alamat/<br>RT/RW ',
                'type'=>'raw',
                'value'=>'$data->Alamat',
            ),
            array(
                'header'=>'Jenis Kelamin/<br>Umur ',
                'type'=>'raw',
                'value'=>'$data->Umur',
            ),
            array(
                'header'=>'Agama/<br>Golongan Umur ',
                'type'=>'raw',
                'value'=>'$data->Agama',
            ),
            'kondisipulang',
            array(
                'header'=>'Jenis Penjamin /<br>Penjamin ',
                'type'=>'raw',
                'value'=>'$data->Carabayar',
            ),
        'caramasuk_nama',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>