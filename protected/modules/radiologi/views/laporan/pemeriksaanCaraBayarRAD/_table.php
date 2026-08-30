<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLapPemeriksaanCaraByrRADPrint();
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass='table border';      
    } else{
        $data = $model->searchLapPemeriksaanCaraByrRAD();
         $template = "{summary}\n{items}\n{pager}";
        
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '$row+1',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tanggal <br> / No. Pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->TanggalNoPendaftaran',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'value' => '$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value' => '$data->NamaPasien',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),      
                 array(
                    'header'=>'Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->getOwner()->renderPartial(\'pembayaranPemeriksaanRAD/_listTindakan\', array(\'id\'=>$data->pendaftaran_id, \'ruangan_id\'=>$data->ruangan_id))',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jenis Penjamin <br> /  Penjamin',
                    'type' => 'raw',
                    'value' => '$data->CaraBayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),                                              
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

