<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
         echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass='table border';
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
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
           array(
                    'header'=>'Tanggal Pendaftaran  <br> / No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." <br> /  ".$data->no_pendaftaran',
                ),
            array(
                    'header'=>'Tanggal Meninggal',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_meninggal)',
                ),
            array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                ),
            array( 
                    'header'=>'Alamat/<br>RT/RW ',
                    'type'=>'raw',
                    'value'=>'$data->Alamat',
                ),
            array(
                    'header'=>'Umur ',
                    'type'=>'raw',
                    'value'=>'$data->umur',
                ),
            array(
                    'header'=>'Golongan Umur ',
                    'type'=>'raw',
                    'value'=>'$data->golonganumur_nama',
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