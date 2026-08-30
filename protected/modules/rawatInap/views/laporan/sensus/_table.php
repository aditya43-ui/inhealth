<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $itemCssClass="table table-bordered table-striped table-condensed";
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';}
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
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            'no_rekam_medik',    
            array(
                'header'=>' Nama Pasien / Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
            'umur',
            'jeniskelamin',
            array(
               'header'=>'Alamat',
               'value'=>'$data->AlamatLengkap',
            ),
            'kelaspelayanan_nama',
            'nomasukkamar',
            array(
               'name'=>'CaraBayar / Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
            'kunjungan',
            'statuspasien',
            array(
                'header'=>'Diagnosa / Kelompok',
                'value'=>'$data->diagnosa',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>